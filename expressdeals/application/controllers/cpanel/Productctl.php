
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Productctl extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'productmodel');
	}
	
	public function index(){
		validate_menu('Products');
		$this->load->library('pagination');
		$orderBy =" ORDER BY product.pid DESC";
		$search = " product.pid!=''";
		$suffix ='';
		if($this->input->get('query')!=''){
			if(is_numeric($this->input->get('query'))){
				$search .=" AND product.pid='".trim($this->input->get('query'))."' "; 
			}else{
				$search .=" AND product.product_name LIKE '%".trim($this->input->get('query'))."%'"; 
			}
			$suffix .='&query='.trim($this->input->get('query'));
		}
		if($this->input->get('section_name')!=''){
			$search .=" AND product.section_id='".trim($this->input->get('section_name'))."' "; 
			$suffix .='&section_name='.trim($this->input->get('section_name'));
		}
		if($this->input->get('status')!=''){
			$search .=" AND product.status='".trim($this->input->get('status'))."' "; 
			$suffix .='&status='.trim($this->input->get('status'));
		}
		$perPage = 15;
		$data['title'] = 'Product - ENPL';
		$data['template'] = 'product_view';
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$data['sections'] = $this->productmodel->get_sections();
		$totalRows = $this->productmodel->getProductCount($search);
		$totalRows = $data['total_rows'] = $totalRows;
		$config = custom_pagination([base_url(ADMINFOLDER.'products') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->productmodel->getProducts($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}	
	
	

	public function add(){
		validate_menu('Products' , 'ADD');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_title', 'Product Title', 'required|trim');
		$this->form_validation->set_rules('product_short_title', 'Product Short Note', 'required|trim');
		$this->form_validation->set_rules('product_summary', 'Product Summary', 'required|trim');
		$this->form_validation->set_rules('category', 'Category', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Add product - ENPL';
			$data['template'] = 'addproduct_view';
			$data['sections'] = $this->productmodel->get_sections();
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$data['product_name'] = trim($this->input->post('product_title'));
			$data['product_short_note'] = trim($this->input->post('product_short_title'));
			$data['product_summary'] = trim($this->input->post('product_summary'));
			$data['status'] = trim($this->input->post('product_status'));
			$data['section_id'] = $this->input->post('category');
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			if($this->input->post('image_id')!=''){
				$imageDetails = modify_image($_POST);
				$data['image_path'] = $imageDetails['path'];
				$data['image_caption'] = $imageDetails['caption'];
				$data['image_alt'] = $imageDetails['alt'];
				$data['image_id'] = $imageDetails['id'];
			}
			$proudctID = $this->productmodel->insertProduct($data);
			if($proudctID!=0 && $proudctID!='' && $proudctID!=null){
				$merchantCount = $this->input->post('merchant_count');
				if($merchantCount!=0){
					$merchant= [];
					for($i=1;$i<=$merchantCount;$i++){
						$merchantName = trim($this->input->post('merchant_name_'.$i));
						$merchantUrl = trim($this->input->post('merchant_url_'.$i));
						$merchantPrice = trim($this->input->post('merchant_price_'.$i));
						$merchantStatus = $this->input->post('merchant_status'.$i);
						$merchant[] = ['pid' => $proudctID , 'merchant_name' => $merchantName , 'merchant_url' => $merchantUrl , 'merchant_price' => $merchantPrice , 'merchant_status' => $merchantStatus , 'modified_by' => $data['created_by'] , 'modified_on' => $data['modified_on']];
					}
					if(count($merchant) > 0){
						$this->productmodel->insertMerchant($merchant);
					}
					$this->session->set_flashdata('message',1);
					redirect(ADMINFOLDER.'products');
				}else{
					$this->session->set_flashdata('message',1);
					redirect(ADMINFOLDER.'products');
				}
			}else{
				$this->session->set_flashdata('message',0);
				redirect(ADMINFOLDER.'products');
			}
			
		}
		
	}
	
	public function edit($pid){
		validate_menu('Products' , 'EDIT');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_title', 'Product Title', 'required|trim');
		$this->form_validation->set_rules('product_short_title', 'Product Short Note', 'required|trim');
		$this->form_validation->set_rules('product_summary', 'Product Summary', 'required|trim');
		$this->form_validation->set_rules('category', 'Category', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Edit product - ENPL';
			$data['template'] = 'addproduct_view';
			$data['sections'] = $this->productmodel->get_sections();
			$data['productDetails'] = $this->productmodel->productDetails($pid);
			$data['merchantDetails'] = $this->productmodel->merchantDetails($pid);
			if(isset($data['productDetails']['image_id']) && $data['productDetails']['image_id']!='' && $data['productDetails']['image_id']!=0){
				$this->productmodel->remove_temp($data['productDetails']['image_id']);
				$data['imageDetails'] =  $this->productmodel->set_temp($data['productDetails']['image_id']);
			}
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$data['product_name'] = trim($this->input->post('product_title'));
			$data['product_short_note'] = trim($this->input->post('product_short_title'));
			$data['product_summary'] = trim($this->input->post('product_summary'));
			$data['status'] = trim($this->input->post('product_status'));
			$data['section_id'] = $this->input->post('category');
			$data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			if($this->input->post('image_id')!=''){
				$imageDetails = modify_image($_POST);
				$data['image_path'] = $imageDetails['path'];
				$data['image_caption'] = $imageDetails['caption'];
				$data['image_alt'] = $imageDetails['alt'];
				$data['image_id'] = $imageDetails['id'];
			}
			$result = $this->productmodel->updateProduct($data , $pid);
			if($result==1){
				$this->productmodel->removeMerchant($pid);
				$merchantCount = $this->input->post('merchant_count');
				if($merchantCount!=0){
					$merchant= [];
					for($i=1;$i<=$merchantCount;$i++){
						$merchantName = trim($this->input->post('merchant_name_'.$i));
						$merchantUrl = trim($this->input->post('merchant_url_'.$i));
						$merchantPrice = trim($this->input->post('merchant_price_'.$i));
						$merchantStatus = $this->input->post('merchant_status'.$i);
						$merchant[] = ['pid' => $pid , 'merchant_name' => $merchantName , 'merchant_url' => $merchantUrl , 'merchant_price' => $merchantPrice , 'merchant_status' => $merchantStatus , 'modified_by' => $data['modified_by'] , 'modified_on' => $data['modified_on']];
					}
					if(count($merchant) > 0){
						$this->productmodel->insertMerchant($merchant);
					}
					$this->session->set_flashdata('message',2);
					redirect(ADMINFOLDER.'products');
				}else{
					$this->session->set_flashdata('message',2);
					redirect(ADMINFOLDER.'products');
				}
			}else{
				$this->session->set_flashdata('message',0);
				redirect(ADMINFOLDER.'products');
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
}
?>