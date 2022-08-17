<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groupsctl extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'groupsmodel');
	}
	
	public function index(){
		validate_menu('Groups');
		$this->load->library('pagination'); 
		$data['title'] = 'Groups - ENPL';
		$data['template'] = 'groups_view';
		$search = " groups.gid!=''";
		$orderBy = " groups.gid DESC";
		$perPage = 20;
		$suffix = '';
		if($this->input->get('group_id')!=''){
			if(is_numeric($this->input->get('group_id'))){
				$search .= " AND groups.gid='".trim($this->input->get('group_id'))."'";
			}else{
				$search .= " AND groups.group_name LIKE '%".trim($this->input->get('group_id'))."'";
			}
			$suffix .='&group_id='.trim($this->input->get('group_id'));
		}
		if($this->input->get('status')!=''){
			$search .= " AND groups.status=".trim($this->input->get('status'))."";
			$suffix .='&status='.trim($this->input->get('status'));
		}
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$data['total_rows'] = $this->groupsmodel->get_count($search);
		$config = custom_pagination([base_url(ADMINFOLDER.'groups') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->groupsmodel->get_data($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function add(){
		validate_menu('Groups' ,'ADD');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('group_description', 'Group Description', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if($this->form_validation->run() == FALSE){
            $data['title'] = 'Groups - ENPL';
			$data['template'] = 'addgroups_view';
			$this->load->view(ADMINFOLDER.'common_view' , $data);
        }else{
			$data['group_name'] = trim($this->input->post('group_name'));
			$data['group_description'] = trim($this->input->post('group_description'));
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['status'] = trim($this->input->post('status'));
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['roles'] = [];
			$menucount = $this->input->post('menu_count');
			for($i=1;$i<=$menucount;$i++):
				$temp['id'] = $this->input->post('menu_'.$i);
				$temp['view'] = ($this->input->post('view_'.$i)=='on')? 1 : 0;
				$temp['add'] = ($this->input->post('add_'.$i)=='on')? 1 : 0;
				$temp['edit'] = ($this->input->post('edit_'.$i)=='on')? 1 : 0;
				$temp['delete'] = ($this->input->post('delete_'.$i)=='on')? 1 : 0;
				$data['roles'][] = $temp;
			endfor;
			$data['roles'] = json_encode($data['roles']);
            $result = $this->groupsmodel->insertData($data);
			$this->session->set_flashdata('message',($result==1) ? 1 : 0);
			redirect(ADMINFOLDER.'groups');
        }
		
	}
	
	public function edit($gid){
		validate_menu('Groups' ,'EDIT');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('group_description', 'Group Description', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if($this->form_validation->run() == FALSE){
            $data['title'] = 'Groups - ENPL';
			$data['template'] = 'addgroups_view';
			$data['detial'] = $this->groupsmodel->get_group($gid);
			$this->load->view(ADMINFOLDER.'common_view' , $data);
        }else{
			$data['group_name'] = trim($this->input->post('group_name'));
			$data['group_description'] = trim($this->input->post('group_description'));
			$data['modified_by'] = $this->session->userdata('uid');
			$data['status'] = trim($this->input->post('status'));
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['roles'] = [];
			$menucount = $this->input->post('menu_count');
			for($i=1;$i<=$menucount;$i++):
				$temp['id'] = $this->input->post('menu_'.$i);
				$temp['view'] = ($this->input->post('view_'.$i)=='on')? 1 : 0;
				$temp['add'] = ($this->input->post('add_'.$i)=='on')? 1 : 0;
				$temp['edit'] = ($this->input->post('edit_'.$i)=='on')? 1 : 0;
				$temp['delete'] = ($this->input->post('delete_'.$i)=='on')? 1 : 0;
				$data['roles'][] = $temp;
			endfor;
			$data['roles'] = json_encode($data['roles']);
            $result = $this->groupsmodel->updateData($data , $gid); 
			$this->session->set_flashdata('message',($result==1) ? 2 : 0);
			redirect(ADMINFOLDER.'groups');
        }
		
	}
	
	public function delete(){
		$gid = $this->input->post('gid');
		$response = '-1';
		$menuDetial = validate_menu('Groups' ,'DELETE' ,1);
		if(count($menuDetial) > 0){
			if(defined('MENUDELETE_'.$menuDetial['mid']) && constant('MENUDELETE_'.$menuDetial['mid'])==1){
				$groupUser = $this->groupsmodel->getUser($gid);
				if($groupUser==0){
					$response = $this->groupsmodel->deleteGroup($gid);
				}else{
					$response = '0';
				}
				
			}else{
				$response = '-2';
			}
		}
		echo trim($response);
	}
}

?>