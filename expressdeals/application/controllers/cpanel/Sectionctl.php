<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sectionctl extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'sectionmodel');
	}
	
	public function index(){
		validate_menu('Section');
		$this->load->library('pagination'); 
		$data['title'] = 'Section - ENPL';
		$data['template'] = 'section_view';
		$search = " section.sid!=''";
		$orderBy = " section.sid DESC";
		$perPage = 20;
		$suffix = '';
		if($this->input->get('section_id')!=''){
			if(is_numeric($this->input->get('section_id'))){
				$search .= " AND section.gid='".trim($this->input->get('section_id'))."'";
			}else{
				$search .= " AND section.section_name LIKE '%".trim($this->input->get('section_id'))."%'";
			}
			$suffix .= '&section_id='.trim($this->input->get('section_id'));
		}
		if($this->input->get('status')!=''){
			$search .= " AND section.status=".trim($this->input->get('status'))."";
			$suffix .= '&status='.trim($this->input->get('status'));
		}
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$data['total_rows'] = $this->sectionmodel->get_count($search);
		$config = custom_pagination([base_url(ADMINFOLDER.'section') ,$data['total_rows'] , $perPage ,'' ]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->sectionmodel->get_data($search , $perPage , $row , $orderBy);
		$data['sections'] = $this->sectionmodel->get_allsections();
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function add(){
		validate_menu('Section' ,'ADD');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('section_name', 'Section Name', 'required|trim');
		$this->form_validation->set_rules('section_url', 'Section Url', 'required|trim|alpha_dash|callback_validate_url');
		$this->form_validation->set_rules('section_type', 'Section Type', 'required|trim');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'required|trim');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required|trim');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if(isset($_FILES['section_image']['name']) && $_FILES['section_image']['name']!=''){
			$this->form_validation->set_rules('section_image', 'Section Image', 'callback_validate_image');
		}
		$this->form_validation->set_message('validate_url','url exists! please try another one');
		$this->form_validation->set_message('validate_image','Supports only jpg|jpeg|png');
		if($this->form_validation->run() == FALSE){
            $data['title'] = 'Section - ENPL';
			$data['template'] = 'addsection_view';
			$data['sections'] = $this->sectionmodel->get_allsections();
			$this->load->view(ADMINFOLDER.'common_view' , $data);
        }else{
			$data['section_name'] = $this->input->post('section_name');
			$data['section_path'] = strtolower($this->input->post('section_url'));
			$parentId = $this->input->post('parent_section');
			$parentUrl = '';
			if($parentId!=''){
				$parentSection = $this->sectionmodel->get_parentsection($parentId);
				$parentUrl = $parentSection['section_full_path'];
			}
			$fullurl = ($parentUrl!='') ? $parentUrl.'/'.strtolower($data['section_path']) : strtolower($data['section_path']);
			$data['section_full_path'] = $fullurl;
			$data['parent_id'] = ($parentId!='') ? $parentId : null;
			if(isset($_FILES['section_image']['name']) && $_FILES['section_image']['name']!=''){
				$this->load->library('upload');
				$config['upload_path'] = ASSETS_BASE_PATH.SECTION_IMAGE_PATH;
				$config['allowed_types'] = '*';
				$this->upload->initialize($config);
				if($this->upload->do_upload('section_image')){
					$imageresult = $this->upload->data();
					$data['image'] = $imageresult['file_name'];
				}
			}
			$data['section_type'] = $this->input->post('section_type');
			$data['article_hosting'] = ($this->input->post('article_host')=='on') ? 1 : 0;
			$data['rss_status'] = ($this->input->post('rss')=='on') ? 1 : 0;
			$data['status'] = $this->input->post('status');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['meta_keywords'] = $this->input->post('meta_keywords');
			$data['no_index'] = ($this->input->post('no_index')=='on') ? 1 : 0;
			$data['no_follow'] = ($this->input->post('no_follow')=='on') ? 1 : 0;
			$data['canonical_url'] = $this->input->post('canonical_url');
			$data['order_by'] = $this->sectionmodel->maxvalue();
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->sectionmodel->insertData($data);
			$this->session->set_flashdata('message',($result==1) ? 1 : 0);
			redirect(ADMINFOLDER.'section');
        }
		
	}
	
	public function edit($id){
		validate_menu('Section' ,'EDIT');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('section_name', 'Section Name', 'required|trim');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'required|trim');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required|trim');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if(isset($_FILES['section_image']['name']) && $_FILES['section_image']['name']!=''){
			$this->form_validation->set_rules('section_image', 'Section Image', 'callback_validate_image');
		}
		$this->form_validation->set_message('validate_image','Supports only jpg|jpeg|png');
		if($this->form_validation->run() == FALSE){
            $data['title'] = 'Section - ENPL';
			$data['template'] = 'addsection_view';
			$data['sections'] = $this->sectionmodel->get_allsections();
			$data['sectionDetails'] = $this->sectionmodel->sectionDetails($id);
			$this->load->view(ADMINFOLDER.'common_view' , $data);
        }else{
			$data['section_name'] = $this->input->post('section_name');
			if(isset($_FILES['section_image']['name']) && $_FILES['section_image']['name']!=''){
				$this->load->library('upload');
				$config['upload_path'] = ASSETS_BASE_PATH.SECTION_IMAGE_PATH;
				$config['allowed_types'] = '*';
				$this->upload->initialize($config);
				if($this->upload->do_upload('section_image')){
					$imageresult = $this->upload->data();
					$data['image'] = $imageresult['file_name'];
				}
			}
			$data['article_hosting'] = ($this->input->post('article_host')=='on') ? 1 : 0;
			$data['rss_status'] = ($this->input->post('rss')=='on') ? 1 : 0;
			$data['status'] = $this->input->post('status');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['meta_keywords'] = $this->input->post('meta_keywords');
			$data['no_index'] = ($this->input->post('no_index')=='on') ? 1 : 0;
			$data['no_follow'] = ($this->input->post('no_follow')=='on') ? 1 : 0;
			$data['canonical_url'] = $this->input->post('canonical_url');
			$data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->sectionmodel->update_section($data ,$id);
			$this->session->set_flashdata('message',($result==1) ? 2 : 0);
			redirect(ADMINFOLDER.'section');
		}
		
	} 
	
	public function validate_url($value){
		$parentId = $this->input->post('parent_section');
		$parentUrl = '';
		if($parentId!=''){
			$parentSection = $this->sectionmodel->get_parentsection($parentId);
			$parentUrl = $parentSection['section_full_path'];
		}
		$url = ($parentUrl!='') ? $parentUrl.'/'.strtolower($value) : strtolower($value);
		$checkUrl = $this->sectionmodel->check_fullpath($url);
		if($checkUrl==0){
			return true;
		}else{
			return false;
		}
	}
	
	public function validate_image($value){
		$allowed = array("image/jpeg", "image/jpg", "image/png");
		if(!in_array($_FILES['section_image']['type'], $allowed)){
			return false;
		}else{
			return true;
		}
	}
	
	public function arrange(){
		validate_menu('Section' ,'EDIT');
		$data['title'] = 'Arrange Section - ENPL';
		$data['template'] = 'arrange_section_view';
		$data['sections'] = $this->sectionmodel->get_allsections();
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function save_arranged(){
		$list = $this->input->post('list');
		$response = 0;
		$modified_on = date('Y-m-d H:i:s');
		for($i=0;$i<count($list);$i++){
			$data =[];
			$detials = explode('-' , $list[$i]);
			$data['order_by'] = $detials[0];
			$data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = $modified_on;
			$response += $this->sectionmodel->update_section($data , $detials[1]);
			$data = '';
		}
		//echo (count($list)==$response) ? 1 : 0;
		print_r($list);
	} 

}

?>