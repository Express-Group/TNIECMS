<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Contentctl extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'contentmodel');
	}
	
	public function article(){
		validate_menu('Article');
		$this->load->library('pagination');
		$search =" article.content_type=1 ";
		if($this->input->get('order_type')!='' && $this->input->get('order_by')!=''){
			$orderBy =" ORDER BY article.".$this->input->get('order_type')." ".$this->input->get('order_by')."";
		}else{
			$orderBy =" ORDER BY article.content_id DESC";
		}
		$perPage = 50;
		$suffix ="";
		if($this->input->get('search_by')!='' && $this->input->get('query')!=''){
			$searchBy = $this->input->get('search_by');
			$query = $this->input->get('query');
			if($searchBy==1){ $search .=" AND article.content_id = '".$query."' "; }
			if($searchBy==2){ $search .=" AND article.title LIKE '%".$query."%' "; }
			if($searchBy==3){ $search .=" AND user.username LIKE '".$query."' "; }
			if($searchBy==4){ $search .=" AND article.author_name LIKE '".$query."' "; }
		}
		if($this->input->get('start')!=''){
			$startDate = date('Y-m-d' , strtotime($this->input->get('start')));
			$endDate = ($this->input->get('end')!='') ? date('Y-m-d' , strtotime($this->input->get('end'))) : $startDate;
			$startDate = $startDate.' 00:00:00';
			$endDate = $endDate.' 23:59:59';
			$search .=" AND article.last_updated_on BETWEEN '".$startDate."' AND '".$endDate."' "; 
			
		}
		if($this->input->get('status')!=''){
			$search .=" AND article.status='".$this->input->get('status')."' "; 
		}
		if($this->input->get('section')!=''){
			$sectionQuery = "select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$this->input->get('section')."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)";
			$search .=" AND (mapping.section_id IN (".$sectionQuery.") OR mapping.section_id='".$this->input->get('section')."' OR article.section_id='".$this->input->get('section')."' )"; 
		}
		if(count($_GET) > 0){
			$suffix = "&query=".$this->input->get('query')."&search_by=".$this->input->get('search_by')."&section=".$this->input->get('section')."&start=".$this->input->get('start')."&end=".$this->input->get('end')."&status=".$this->input->get('status')."&order_type=".$this->input->get('order_type')."&order_by=".$this->input->get('order_by');
		}
		$totalRows = $this->contentmodel->getArticleCount($search);
		$totalRows = $data['total_rows'] = ($totalRows > 800) ? 800 : $totalRows;
		$data['title'] = 'Article - ENPL';
		$data['template'] = 'article_view';
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$config = custom_pagination([base_url(ADMINFOLDER.'content/article') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->contentmodel->getArticle($search , $perPage , $row , $orderBy);
		$data['sections'] = $this->contentmodel->get_sections();
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}	
	
	public function add_article(){
		validate_menu('Article' , 'ADD');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('article_title', 'Article Title', 'required|trim');
		$this->form_validation->set_rules('article_summary', 'Article Summary', 'required|trim');
		$this->form_validation->set_rules('article_content', 'Article Content', 'required|trim');
		$this->form_validation->set_rules('parent_section', 'Section', 'required|trim');
		$this->form_validation->set_rules('url', 'Url', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Add Article - ENPL';
			$data['template'] = 'add_article_view';
			$data['sections'] = $this->contentmodel->get_sections();
			$data['country'] = $this->contentmodel->get_countries();
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$sectionDetails = $this->contentmodel->getSectionDetails($this->input->post('parent_section'));
			if(count($sectionDetails) > 0){
				$date = date('Y-m-d H:i:s');
				$Year = date('Y');
				$Month = date('M');
				$Date = date('d');
				$data = $relatedData = $mappingData = [];
				$mapping = $this->input->post('map_list[]');
				$data['title'] = trim($this->input->post('article_title'));
				$data['summary'] = trim($this->input->post('article_summary'));
				$data['content'] = trim($this->input->post('article_content'));
				$url = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', trim($this->input->post('url')))); 
				//$data['url'] = $sectionDetails['section_full_path'].'/'.$Year.'/'.$Month.'/'.$Date.'/'.$url.'/';
				$data['url'] = $sectionDetails['section_full_path'].'/'.$url.'/';
				$data['url'] = strtolower($data['url']);
				$data['section_id'] = $sectionDetails['sid'];
				$data['content_type'] = $sectionDetails['section_type'];
				$data['published_date'] = $data['last_updated_on'] = $date;
				$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
				$productID = $this->input->post('product_id[]');
				$productTitle = $this->input->post('product_title[]');
				if($this->input->post('image_id')!=''){
					$imageDetails = modify_image($_POST);
					$data['image_path'] = $imageDetails['path'];
					$data['image_caption'] = $imageDetails['caption'];
					$data['image_alt'] = $imageDetails['alt'];
					$relatedData['image_id'] = $imageDetails['id'];
				}
				if($this->input->post('author')!=''){
					$authorDetails = authorDetails($_POST);
					$data['author_name'] = $authorDetails['name'];
					$data['author_image'] = $authorDetails['path'];
					$data['author_image_caption'] = $authorDetails['caption'];
					$data['author_image_alt'] = $authorDetails['alt'];
					$relatedData['author_id'] = $authorDetails['id'];
				}
				if($this->input->post('country')!=''){
					$countryDetails = countryDetails($_POST);
					$data['country_name'] = $countryDetails['name'];
					$relatedData['country_id'] = $countryDetails['id'];
				}
				if($this->input->post('state')!=''){
					$stateDetails = stateDetails($_POST);
					$data['state_name'] = $stateDetails['name'];
					$relatedData['state_id'] = $stateDetails['id'];
				}
				$data['city_name'] = trim($this->input->post('city'));
				if($this->input->post('tags')!=''){
					$tagDetails = tags($_POST);
					$data['tags'] = $tagDetails['tags'];
					$relatedData['tag_ids'] = $tagDetails['id'];
				}
				$data['allow_comments'] = ($this->input->post('comments')=='on') ? 1 : 0;
				$data['allow_pagination'] = ($this->input->post('pager')=='on') ? 1 : 0;
				$data['no_index'] = ($this->input->post('no_index')=='on') ? 1 : 0;
				$data['no_follow'] = ($this->input->post('no_follow')=='on') ? 1 : 0;
				$data['canonical_url'] = trim($this->input->post('canonical_url'));
				$data['meta_title'] = trim($this->input->post('meta_title'));
				$data['meta_description'] = trim($this->input->post('meta_description'));
				$data['status'] = trim($this->input->post('article_status'));
				$result = $this->contentmodel->insertArticle($data , $relatedData , $mapping , $productID , $productTitle);
				if($result=='SUCCESS'){
					$this->session->set_flashdata('message',1);
					redirect(ADMINFOLDER.'content/article');
				}else{
					$this->session->set_flashdata('message',0);
					redirect(ADMINFOLDER.'content/article');
				}	
			}else{
				$this->session->set_flashdata('message',0);
				redirect(ADMINFOLDER.'content/article');
			}
			
		}
		
	}
	
	public function edit_article($content_id){
		validate_menu('Article' , 'EDIT');
		$data['details'] =  $this->contentmodel->articleDetails($content_id);
		$data['imageDetails'] =  [];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('article_title', 'Article Title', 'required|trim');
		$this->form_validation->set_rules('article_summary', 'Article Summary', 'required|trim');
		$this->form_validation->set_rules('article_content', 'Article Content', 'required|trim');
		$this->form_validation->set_rules('parent_section', 'Section', 'required|trim');
		$this->form_validation->set_rules('url', 'Url', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Edit Article - ENPL';
			$data['template'] = 'add_article_view';
			$data['sections'] = $this->contentmodel->get_sections();
			$data['country'] = $this->contentmodel->get_countries();
			if($data['details']['approveStatus']==1){
				if(isset($data['details']['relatedDetails']['image_id']) && $data['details']['relatedDetails']['image_id']!=''){
					$this->contentmodel->remove_temp($data['details']['relatedDetails']['image_id']);
					$data['imageDetails'] =  $this->contentmodel->set_temp($data['details']['relatedDetails']['image_id']);
				}
			}else{
				if(isset($data['details']['articleDetails']['image_id']) && $data['details']['articleDetails']['image_id']!=''){
					$this->contentmodel->remove_temp($data['details']['articleDetails']['image_id']);
					$data['imageDetails'] =  $this->contentmodel->set_temp($data['details']['articleDetails']['image_id']);
				}
			}
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$sectionDetails = $this->contentmodel->getSectionDetails($this->input->post('parent_section'));
			if(count($sectionDetails) > 0){
				$date = date('Y-m-d H:i:s');
				$Year = date('Y' , strtotime($data['details']['articleDetails']['published_date']));
				$Month = date('M' , strtotime($data['details']['articleDetails']['published_date']));
				$Date = date('d' , strtotime($data['details']['articleDetails']['published_date']));
				$data = $relatedData = $mappingData = [];
				$mapping = $this->input->post('map_list[]');
				$productID = $this->input->post('product_id[]');
				$productTitle = $this->input->post('product_title[]');
				$data['title'] = trim($this->input->post('article_title'));
				$data['summary'] = trim($this->input->post('article_summary'));
				$data['content'] = trim($this->input->post('article_content'));
				$url = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', trim($this->input->post('url')))); 
				if($content_id >=151){
					$data['url'] = $sectionDetails['section_full_path'].'/'.$url.'/'.$content_id.'.html';
				}else{
					$data['url'] = $sectionDetails['section_full_path'].'/'.$Year.'/'.$Month.'/'.$Date.'/'.$url.'/'.$content_id.'.html';
				}
				$data['url'] = strtolower($data['url']);
				$data['section_id'] = $sectionDetails['sid'];
				$data['content_type'] = $sectionDetails['section_type'];
				$data['last_updated_on'] = $date;
				$data['modified_by'] = $this->session->userdata('uid');
				if($this->input->post('image_id')!=''){
					$imageDetails = modify_image($_POST);
					$data['image_path'] = $imageDetails['path'];
					$data['image_caption'] = $imageDetails['caption'];
					$data['image_alt'] = $imageDetails['alt'];
					$relatedData['image_id'] = $imageDetails['id'];
				}
				if($this->input->post('author')!=''){
					$authorDetails = authorDetails($_POST);
					$data['author_name'] = $authorDetails['name'];
					$data['author_image'] = $authorDetails['path'];
					$data['author_image_caption'] = $authorDetails['caption'];
					$data['author_image_alt'] = $authorDetails['alt'];
					$relatedData['author_id'] = $authorDetails['id'];
				}
				if($this->input->post('country')!=''){
					$countryDetails = countryDetails($_POST);
					$data['country_name'] = $countryDetails['name'];
					$relatedData['country_id'] = $countryDetails['id'];
				}
				if($this->input->post('state')!=''){
					$stateDetails = stateDetails($_POST);
					$data['state_name'] = $stateDetails['name'];
					$relatedData['state_id'] = $stateDetails['id'];
				}
				$data['city_name'] = trim($this->input->post('city'));
				if($this->input->post('tags')!=''){
					$tagDetails = tags($_POST);
					$data['tags'] = $tagDetails['tags'];
					$relatedData['tag_ids'] = $tagDetails['id'];
				}
				$data['allow_comments'] = ($this->input->post('comments')=='on') ? 1 : 0;
				$data['allow_pagination'] = ($this->input->post('pager')=='on') ? 1 : 0;
				$data['no_index'] = ($this->input->post('no_index')=='on') ? 1 : 0;
				$data['no_follow'] = ($this->input->post('no_follow')=='on') ? 1 : 0;
				$data['canonical_url'] = trim($this->input->post('canonical_url'));
				$data['meta_title'] = trim($this->input->post('meta_title'));
				$data['meta_description'] = trim($this->input->post('meta_description'));
				$data['status'] = trim($this->input->post('article_status'));
				$result = $this->contentmodel->updateArticle($data , $relatedData , $mapping , $productID , $productTitle , $content_id);
				if($result=='SUCCESS'){
					$this->session->set_flashdata('message',2);
					$this->session->set_flashdata('message_edit',strip_tags($data['title']));
					redirect(ADMINFOLDER.'content/article');
				}else{
					$this->session->set_flashdata('message',0);
					redirect(ADMINFOLDER.'content/article');
				}	
			}else{
				$this->session->set_flashdata('message',0);
				redirect(ADMINFOLDER.'content/article');
			}
			
		}
	}
	
	public function get_image(){
		$this->load->library('pagination');
		$response =[];
		$response[1] = 0;
		$response['content'] = '';
		$caption =trim($this->input->post('caption'));
		$search ="";
		if($caption!=''){
			$search = " AND (img.caption LIKE '%".$caption."%' OR img.alt LIKE '%".$caption."%' OR img.image_name LIKE '%".$caption."%')";
		}
		$row = $_GET['per_page'] =  ($this->input->post('page')!=0) ? $this->input->post('page') : 0 ;
		$perpage = 15;
		$getImagesCount = $this->contentmodel->getImagesCount($search , $perpage , $row);
		$config = custom_pagination([base_url(ADMINFOLDER.'content/article/get_image') ,$getImagesCount , $perpage ,'' ]);
		$this->pagination->initialize($config);
		$response['pager'] = str_replace('<a' ,'<a class="page-link image-pager" ',$this->pagination->create_links());
		$result = $this->contentmodel->getImages($search , $perpage , $row);
		foreach($result as $image):
			$imageurl = ASSETURL.IMAGE_PATH. str_replace('original/' , 'medium/' , $image->file_path);
			$response['content'] .= '<img class="img-select" src="'.$imageurl.'" image-id="'.$image->id.'" image-alt="'.$image->alt.'" image-caption="'.$image->caption.'" image-name="'.$image->image_name.'">';
		endforeach;
		echo $response['content'].$response['pager'];
	}
	
	public function get_product(){
		$query = trim($this->input->post('query'));
		$section = trim($this->input->post('section'));
		$id = trim($this->input->post('id'));
		$search = '';
		if($query!=''){
			if(is_numeric($query)){
				$search .=' AND product.pid="'.$query.'"';
			}else{
				$search .=' AND product.product_name LIKE "%'.$query.'%"';
			}
		}
		if($section!=''){
			$search .=' AND product.section_id="'.$section.'"';
		}
		if($id!=''){
			$search .=' AND product.pid NOT IN('.$id.')';
		}
		$data = $this->contentmodel->getProductDetails($search);
		$template ='<div class="table-responsive">';
		$template .='<table class="table">';
		$template .='<thead>';
		$template .='<tr><th>PRODUCT NAME</th><th class="text-center">PRODUCT IMAGE</th><th>SECTION NAME</th><th>ACTION</th></tr>';
		$template .='</thead>';
		$template .='<tbody>';
		if(count($data) > 0){
			foreach($data as $product){
				$template .='<tr class="product-'.$product['pid'].'" data-title="'.strip_tags($product['product_name']).'" data-imagepath="'.(($product['image_path']!='') ? ASSETURL.IMAGE_PATH.$product['image_path']: '').'">';
				$template .='<td>'.strip_tags($product['product_name']).'</td>';
				$template .='<td class="text-center">';
				if($product['image_path']!=''){
				$template .='<img src="'.ASSETURL.IMAGE_PATH.$product['image_path'].'" style="width:75px;border-radius:5px;">';	
				}else{
				$template .='-';	
				}
				$template .='</td>';
				$template .='<td>'.$product['section_name'].'</td>';
				$template .='<td><button type="button" onclick="addproduct('.$product['pid'].')" class="btn btn-primary">ADD</button></td>';
				$template .='</tr>';
			}
		}else{
		$template .='<tr><td colspan="4" class="text-center"><h6>NO RECORDS FOUND</h6></td></tr>';	
		}
		$template .='</tbody>';
		$template .='</table>';
		$template .='</div>';
		echo $template;
		exit();
	}
}
?>