<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Approvalctl extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'approvalmodel');
	}
	
	public function index(){
		validate_menu('Content Approval');
		$this->load->library('pagination');
		$search =" approval.content_type=1 AND (approval.approve_status=0 OR approval.approve_status=2)";
		$orderBy =" ORDER BY approval.last_updated_on DESC";
		$perPage = 50;
		$suffix ="";
		if($this->input->get('search_by')!='' && $this->input->get('query')!=''){
			$searchBy = $this->input->get('search_by');
			$query = $this->input->get('query');
			if($searchBy==1){ $search .=" AND approval.content_id = '".$query."' "; }
			if($searchBy==2){ $search .=" AND approval.title LIKE '%".$query."%' "; }
			if($searchBy==3){ $search .=" AND user.username LIKE '".$query."' "; }
			if($searchBy==4){ $search .=" AND approval.author_name LIKE '".$query."' "; }
		}
		if($this->input->get('start')!=''){
			$startDate = date('Y-m-d' , strtotime($this->input->get('start')));
			$endDate = ($this->input->get('end')!='') ? date('Y-m-d' , strtotime($this->input->get('end'))) : $startDate;
			$startDate = $startDate.' 00:00:00';
			$endDate = $endDate.' 23:59:59';
			$search .=" AND approval.last_updated_on BETWEEN '".$startDate."' AND '".$endDate."' "; 
			
		}
		if($this->input->get('status')!=''){
			$search .=" AND approval.status='".$this->input->get('status')."' "; 
		}
		if($this->input->get('section')!=''){
			$sectionQuery = "select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$this->input->get('section')."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)";
			$search .=" AND (mapping.section_id IN (".$sectionQuery.") OR mapping.section_id='".$this->input->get('section')."' OR approval.section_id='".$this->input->get('section')."' )"; 
		}
		if(count($_GET) > 0){
			$suffix = "&query=".$this->input->get('query')."&search_by=".$this->input->get('search_by')."&section=".$this->input->get('section')."&start=".$this->input->get('start')."&end=".$this->input->get('end')."&status=".$this->input->get('status')."&order_type=".$this->input->get('order_type')."&order_by=".$this->input->get('order_by');
		}
		$totalRows = $this->approvalmodel->getArticleCount($search);
		$totalRows = $data['total_rows'] = ($totalRows > 800) ? 800 : $totalRows;
		$data['title'] = 'Content Approval - ENPL';
		$data['template'] = 'approval_view';
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$config = custom_pagination([base_url(ADMINFOLDER.'approval') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->approvalmodel->getArticle($search , $perPage , $row , $orderBy);
		$data['sections'] = $this->approvalmodel->get_sections();
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function preview(){
		$id = trim($this->input->post('id'));
		$details = $this->approvalmodel->approvalArticle($id);
		$time = date('F d, Y' , strtotime($details['last_updated_on']));
		$content = str_replace('<table' , '<div class="table-responsive"><table class="table"' ,$details['content']);
		$content = str_replace('</table>' , '</table></div>' ,$content);
		$template = '';
		$template .='<h1>'.strip_tags($details['title']).'</h1>';
		$template .='<p class="mt-2" style="color: #a6a4a4;">'.strip_tags($details['summary']).'</p>';
		$template .='<p class="mt-2" style="color: #d00a0a;">'.$time.'</p>';
		if($details['image_path']!=''){
			$template .='<img style="width: 100%;border-radius: 8px;" src="'.ASSETURL.IMAGE_PATH.$details['image_path'].'" class="img-fluid">';
		}
		$template .='<div class="mt-4">'.$content.'</div>';
		$template .='<div class="form-group">
					<label for="notes">Notes <sup>*</sup></label>
					<textarea class="form-control" id="notes"></textarea>
					<input type="hidden" id="article_id">
				</div>';
		echo $template;
	}
	
	public function approve(){
		$id = trim($this->input->post('id'));
		$notes = trim($this->input->post('notes'));
		$details = $this->approvalmodel->approvalArticle($id);
		$content = [];
		$relatedContent = [];
		$content['url'] = $details['url'];
		$content['title'] = $details['title'];
		$content['summary'] = $details['summary'];
		$content['content'] = $details['content'];
		$content['section_id'] = $details['section_id'];
		$content['content_type'] = $details['content_type'];
		$content['last_updated_on'] = $details['last_updated_on'];
		$content['image_path'] = $details['image_path'];
		$content['image_caption'] = $details['image_caption'];
		$content['image_alt'] = $details['image_alt'];
		$content['author_name'] = $details['author_name'];
		$content['author_image'] = $details['author_image'];
		$content['author_image_caption'] = $details['author_image_caption'];
		$content['author_image_alt'] = $details['author_image_alt'];
		$content['country_name'] = $details['country_name'];
		$content['state_name'] = $details['state_name'];
		$content['city_name'] = $details['city_name'];
		$content['tags'] = $details['tags'];
		$content['allow_comments'] = $details['allow_comments'];
		$content['allow_pagination'] = $details['allow_pagination'];
		$content['no_index'] = $details['no_index'];
		$content['no_follow'] = $details['no_follow'];
		$content['canonical_url'] = $details['canonical_url'];
		$content['meta_title'] = $details['meta_title'];
		$content['meta_description'] = $details['meta_description'];
		$content['status'] = $details['status'];
		$content['approve_status'] = 1;
		$content['modified_by'] = $details['modified_by'];
		$relatedContent['image_id'] = $details['image_id'];
		$relatedContent['author_id'] = $details['author_id'];
		$relatedContent['country_id'] = $details['country_id'];
		$relatedContent['state_id'] = $details['state_id'];
		$relatedContent['tag_ids'] = $details['tag_ids'];
		$relatedContent['group_id'] = $details['group_id'];
		$result = $this->approvalmodel->updateArticle($content , $relatedContent , $details['content_id']);
		if($result==1){
			$approvedDate = date('Y-m-d H:i:s');
			$mailTime = date('jS F Y h:i:s A' , strtotime($approvedDate));
			$userName = getUsername($this->session->userdata('uid'));
			$bodyAlt =  strip_tags($content['title']).' article has been approved on '.$mailTime.' by '.$userName.'.';
			$bodyText = '';
			$bodyText .= '<h3>Hi,</h3>';
			$bodyText .= '<h3>'.strip_tags($content['title']).' article has been approved on '.$mailTime.' by '.$userName.'.</h3>';
			$bodyText .= '<h3>Approver Comments : '.$notes.'</h3>';
			
			$bodyText .= '<h3 style="margin:0px;">Thanks</h3>';
			$bodyText .= '<h3 style="margin:0px;">Tech Team,</h3>';
			$bodyText .= '<h3 style="margin:0px;">ENPL.</h3>';
			SendMail(explode(',' ,EMAILLIST) , ['subject' => 'Article approved' , 'body'=> $bodyText , 'bodyalt' => $bodyAlt]);
			echo $this->approvalmodel->approveUpdate($details['aid'] , ['approved_by' => $this->session->userdata('uid') , 'approved_on' =>  $approvedDate, 'notes' => $notes , 'approve_status' => 1]);
		}else{
			echo 0;
		}
		exit();
	}
	
	public function notes(){
		validate_menu('Approval Notes');
		$this->load->library('pagination');
		$search =" aid IN (SELECT MAX(aid) FROM aff_content_approval GROUP BY content_id HAVING COUNT(content_id) > 0)";
		$orderBy =" ORDER BY last_updated_on DESC";
		$perPage = 10;
		$suffix ="";
		if($this->input->get('search_by')!='' && $this->input->get('query')!=''){
			$searchBy = $this->input->get('search_by');
			$query = $this->input->get('query');
			if($searchBy==1){ $search .=" AND content_id = '".$query."' "; }
			if($searchBy==2){ $search .=" AND title LIKE '%".$query."%' "; }
		}
		if(count($_GET) > 0){
			$suffix = "&query=".$this->input->get('query')."&search_by=".$this->input->get('search_by');
		}
		$totalRows = $this->approvalmodel->getApprovalArticleCount($search);
		$totalRows = $data['total_rows'] = ($totalRows > 800) ? 800 : $totalRows;
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$config = custom_pagination([base_url(ADMINFOLDER.'approval/notes') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->approvalmodel->getApprovalArticle($search , $perPage , $row , $orderBy);
		$data['title'] = 'Content Approval Notes - ENPL';
		$data['template'] = 'approvalnotes_view';
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function view_notes(){
		$id = trim($this->input->post('id'));
		$result = $this->approvalmodel->getApprovalArticleList($id);
		$template ='<div class="table-responsive"><table class="table table-lg" style="font-size: 13px;background: #eee9;">';
		$template .='<thead>';
		$template .='<tr class="text-center">';
		//$template .='<th>S.No</th>';
		//$template .='<th>Content ID</th>';
		$template .='<th>Title</th>';
		$template .='<th>Section</th>';
		//$template .='<th>Image</th>';
		$template .='<th>Modified On</th>';
		$template .='<th>Modified By</th>';
		$template .='<th>Approved By</th>';
		$template .='<th>Approved On</th>';
		$template .='<th>Notes</th>';
		$template .='</tr>';
		$template .='</thead>';
		$template .='<tbody>';
		$i=1;
		foreach($result as $article){
			$title =  strip_tags($article->title);
			$template .='<tr>';
			//$template .='<td>'.$i.'</td>';
			//$template .='<td>'.$id.'</td>';
			$template .='<td><p style="margin:0;" data-toggle="tooltip" title="'.$title.'">'.shortDescription($title).'</p></td>';
			$template .='<td style="color: #5066e1;">'.$article->section_name.'</td>';
			/* if($article->image_path!=''){
				$imagepath = str_replace('original/' , 'medium/' , $article->image_path);
				$imagepath = ASSETURL.IMAGE_PATH.$imagepath;
				$template .='<td class="text-center"><img style="width: 65px;border-radius:5px;" src="'.$imagepath.'" alt="'.trim($article->image_alt).'"></td>';
			}else{
				$template .='<td class="text-center">-</td>';
			} */
			$template .='<td>'.$article->last_updated_on.'</td>';
			$template .='<td>'.$article->username.'</td>';
			if($article->approved_by!=0){
				$template .='<td>'.getUsername($article->approved_by).'</td>';
				$template .='<td>'.$article->approved_on.'</td>';
				$template .='<td>'.$article->notes.'</td>';
			}else{
				$template .='<td><span class="badge bg-danger">Not Approved</span></td>';
				$template .='<td>-</td>';
				$template .='<td>-</td>';
			}
			$template .='</tr>';
			$i++;
		}
		$template .='</tbody>';
		$template .='</table></div>';
		echo $template;
		
	}
}
?>