<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Componentsctl extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'componentsmodel');
	}
	
	public function author(){
		validate_menu('Author');
		$this->load->library('pagination');
		$orderBy =" ORDER BY author.aid DESC";
		$search =" author.author_name!='' ";
		$perPage = 15;
		$suffix ="";
		if($this->input->get('aid')!=''){
			if(is_numeric($this->input->get('aid'))){
				$search .= " AND author.aid='".trim($this->input->get('aid'))."'";
			}else{
				$search .= " AND author.author_name LIKE '%".trim($this->input->get('aid'))."%'";
			}
			$suffix .= '&author.aid='.trim($this->input->get('aid'));
		}
		$totalRows = $this->componentsmodel->getAuthorCount($search);
		$totalRows = $data['total_rows'] =  $totalRows;
		$data['title'] = 'Author - ENPL';
		$data['template'] = 'author_view';
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$config = custom_pagination([base_url(ADMINFOLDER.'components/author') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->componentsmodel->getAuthor($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function add_author(){
		validate_menu('Author' ,'ADD');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('author_name', 'Author Name', 'required|trim');
		$this->form_validation->set_rules('author_description', 'Author Description', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if(isset($_FILES['author_image']['name']) && $_FILES['author_image']['name']!=''){
			$this->form_validation->set_rules('author_image', 'Author Image', 'callback_validate_image');
			$this->form_validation->set_rules('author_image_caption', 'Author Image Caption', 'required|trim');
			$this->form_validation->set_rules('author_image_alt', 'Author Imnage Alt', 'required|trim');
		}
		$this->form_validation->set_message('validate_image','Supports only jpg|jpeg|png');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Add Author - ENPL';
			$data['template'] = 'addauthor_view';
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$data['author_image'] = "";
			$data['author_name'] = $this->input->post('author_name');
			$data['author_description'] = $this->input->post('author_description');
			$data['caption'] = $this->input->post('author_image_caption');
			$data['alt'] = $this->input->post('author_image_alt');
			$data['status'] = $this->input->post('status');
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			if(isset($_FILES['author_image']['name']) && $_FILES['author_image']['name']!=''){
				$this->load->library('upload');
				$config['upload_path'] = FCPATH.AUTHOR_IMAGE_PATH;
				$config['allowed_types'] = '*';
				$this->upload->initialize($config);
				if($this->upload->do_upload('author_image')){
					$imageresult = $this->upload->data();
					$data['author_image'] = $imageresult['file_name'];
					chmod(FCPATH.AUTHOR_IMAGE_PATH.$data['author_image'] , 0777);
				}
			}
			$result = $this->componentsmodel->insertData($data , 'aff_authors');
			$this->session->set_flashdata('message',($result==1) ? 1 : 0);
			redirect(ADMINFOLDER.'components/author');
		}
		
	}
	
	public function edit_author($aid){
		validate_menu('Author' ,'EDIT');
		$details = $this->componentsmodel->getAuthorRecords($aid);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('author_name', 'Author Name', 'required|trim');
		$this->form_validation->set_rules('author_description', 'Author Description', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if(isset($_FILES['author_image']['name']) && $_FILES['author_image']['name']!=''){
			$this->form_validation->set_rules('author_image', 'Author Image', 'callback_validate_image');
			$this->form_validation->set_rules('author_image_caption', 'Author Image Caption', 'required|trim');
			$this->form_validation->set_rules('author_image_alt', 'Author Imnage Alt', 'required|trim');
		}
		$this->form_validation->set_message('validate_image','Supports only jpg|jpeg|png');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Edit Author - ENPL';
			$data['template'] = 'addauthor_view';
			$data['details'] = $details;
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$data['author_name'] = $this->input->post('author_name');
			$data['author_description'] = $this->input->post('author_description');
			$data['caption'] = $this->input->post('author_image_caption');
			$data['alt'] = $this->input->post('author_image_alt');
			$data['status'] = $this->input->post('status');
			$data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			if(isset($_FILES['author_image']['name']) && $_FILES['author_image']['name']!=''){
				$this->load->library('upload');
				$config['upload_path'] = FCPATH.AUTHOR_IMAGE_PATH;
				$config['allowed_types'] = '*';
				$this->upload->initialize($config);
				if($this->upload->do_upload('author_image')){
					$imageresult = $this->upload->data();
					$data['author_image'] = $imageresult['file_name'];
					chmod(FCPATH.AUTHOR_IMAGE_PATH.$data['author_image'] , 0777);
					if($details['author_image']!=''){
						unlink(FCPATH.AUTHOR_IMAGE_PATH.$details['author_image']);
					}
				}
			}
			$result = $this->componentsmodel->updateData($data , $aid , 'aff_authors');
			$this->session->set_flashdata('message',($result==1) ? 2 : 0);
			redirect(ADMINFOLDER.'components/author');
		}
	}
	public function validate_image($value){
		$allowed = array("image/jpeg", "image/jpg", "image/png");
		if(!in_array($_FILES['author_image']['type'], $allowed)){
			return false;
		}else{
			return true;
		}
	}
	
	public function delete_author(){ 
		$aid = trim($this->input->post('aid'));
		if($aid!='' && is_numeric($aid)){
			echo $this->componentsmodel->checkAuthor($aid);
		}else{
			echo 0;
			exit();
		}
	}
	
	public function tags(){
		validate_menu('Tags');
		$this->load->library('pagination');
		$orderBy =" ORDER BY tags.tag_id DESC";
		$search =" tags.tag_name!='' ";
		$perPage = 15;
		$suffix ="";
		if($this->input->get('tid')!=''){
			if(is_numeric($this->input->get('tid'))){
				$search .= " AND tags.tag_id='".trim($this->input->get('tid'))."'";
			}else{
				$search .= " AND tags.tag_name LIKE '%".trim($this->input->get('tid'))."%'";
			}
			$suffix .= '&tid='.trim($this->input->get('tid'));
		}
		$totalRows = $this->componentsmodel->getTagsCount($search);
		$totalRows = $data['total_rows'] =  $totalRows;
		$data['title'] = 'Tags - ENPL';
		$data['template'] = 'tags_view';
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$config = custom_pagination([base_url(ADMINFOLDER.'components/tags') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->componentsmodel->getTag($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function add_tags(){
		validate_menu('Tags' , 'ADD');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tag_name', 'Tag Name', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Add Tags - ENPL';
			$data['template'] = 'addtags_view';
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$data['tag_name'] = trim($this->input->post('tag_name'));
			$data['meta_name'] = trim($this->input->post('meta_title'));
			$data['meta_description'] = trim($this->input->post('meta_description'));
			$data['status'] = trim($this->input->post('status'));
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->componentsmodel->insertData($data , 'aff_tags');
			$this->session->set_flashdata('message',($result==1) ? 1 : 0);
			redirect(ADMINFOLDER.'components/tags');
		}
	}
	
	public function edit_tags($tid){
		validate_menu('Tags' , 'EDIT');
		$details = $this->componentsmodel->getTagRecords($tid); 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tag_name', 'Tag Name', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Edit Tags - ENPL';
			$data['template'] = 'addtags_view';
			$data['details'] = $details;
			$this->load->view(ADMINFOLDER.'common_view' , $data);
		}else{
			$data['tag_name'] = trim($this->input->post('tag_name'));
			$data['meta_name'] = trim($this->input->post('meta_title'));
			$data['meta_description'] = trim($this->input->post('meta_description'));
			$data['status'] = trim($this->input->post('status'));
			$data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->componentsmodel->updateTag($data , $tid );
			$this->session->set_flashdata('message',($result==1) ? 2 : 0);
			redirect(ADMINFOLDER.'components/tags');
		}
	}
	
	public function countries(){
		validate_menu('Countries');
		$this->load->library('pagination');
		$orderBy =" ORDER BY name ASC";
		$search =" name!='' ";
		$perPage = 15;
		$suffix ="";
		if($this->input->get('id')!=''){
			if(is_numeric($this->input->get('id'))){
				$search .= " AND cid='".trim($this->input->get('id'))."'";
			}else{
				$search .= " AND name LIKE '%".trim($this->input->get('id'))."%'";
			}
			$suffix .= '&id='.trim($this->input->get('id'));
		}
		$totalRows = $this->componentsmodel->getCountriesCount($search);
		$totalRows = $data['total_rows'] =  $totalRows;
		$data['title'] = 'Tags - ENPL';
		$data['template'] = 'countries_view';
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$config = custom_pagination([base_url(ADMINFOLDER.'components/countries') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->componentsmodel->getCountries($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
}
?> 