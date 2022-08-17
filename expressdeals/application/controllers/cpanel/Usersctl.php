<?php
class Usersctl extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'usersmodel');
	}
	
	public function index(){
		validate_menu('User');
		$this->load->library('pagination'); 
		$data['title'] = 'Users - ENPL';
		$data['template'] = 'user_view';
		$search = " users.uid!=''";
		$suffix = '';
		$orderBy = " users.uid DESC";
		$perPage = 20; 
		if($this->input->get('uid')!=''){
			$uid = trim($this->input->get('uid'));
			if(is_numeric($uid)){
				$search .= " AND users.uid='".$uid."'";
			}else{
				$search .= " AND (users.username LIKE '%".$uid."%' OR users.firstname LIKE '%".$uid."%' OR users.lastname LIKE '%".$uid."%')";
			}
			$suffix .='&uid='.$uid;
		}
		if($this->input->get('status')!=''){
			$search .= " AND users.status='".trim($this->input->get('status'))."'";
			$suffix .='&status='.trim($this->input->get('status'));
		}
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$data['total_rows'] = $this->usersmodel->get_count($search);
		$config = custom_pagination([base_url(ADMINFOLDER.'users') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->usersmodel->get_data($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
		
	}
	
	public function add(){
		validate_menu('User' ,'ADD'); 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|alpha');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|alpha');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[12]|min_length[6]');
		$this->form_validation->set_rules('group', 'Group', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|trim');
		if($this->form_validation->run() == FALSE){
            $data['title'] = 'Add Users - ENPL';
			$data['template'] = 'addusers_view';
			$data['groups']= $this->usersmodel->get_groups();
			$this->load->view(ADMINFOLDER.'common_view' , $data);
        }else{
			$data['username'] = $this->input->post('username');
			$data['firstname'] = $this->input->post('first_name');
			$data['lastname'] = $this->input->post('last_name');
			$data['password'] = md5($this->input->post('password'));
			$data['gid'] = $this->input->post('group');
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['status'] = $this->input->post('status');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->usersmodel->insertData($data);
			$this->session->set_flashdata('message',($result==1) ? 1 : 0);
			redirect(ADMINFOLDER.'users');
        }
		
	}
	
	public function edit($id){
		validate_menu('User' ,'EDIT');
		if(!is_numeric($id)){
			redirect(ADMINFOLDER.'users');
			exit();
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|alpha');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|alpha');
		if(isset($_POST['password']) && $_POST['password']!=''){
			$this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[12]|min_length[6]');
		}
		//$this->form_validation->set_rules('group', 'Group', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|trim');		
		if($this->form_validation->run() == FALSE){
            $data['title'] = 'Edit Users - ENPL';
			$data['template'] = 'addusers_view';
			$data['groups']= $this->usersmodel->get_groups();
			$data['userDetails']= $this->usersmodel->getUser($id);
			if(count($data['userDetails']) >0){
				$this->load->view(ADMINFOLDER.'common_view' , $data);
			}else{
				redirect(ADMINFOLDER.'users');
				exit();
			}
        }else{
			$data['username'] = $this->input->post('username');
			$data['firstname'] = $this->input->post('first_name');
			$data['lastname'] = $this->input->post('last_name');
			if($this->input->post('password')!=''){
				$data['password'] = md5($this->input->post('password'));
			}
			$data['modified_by'] = $this->session->userdata('uid');
			$data['status'] = $this->input->post('status');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->usersmodel->updateData($data , $id);
			$this->session->set_flashdata('message',($result==1) ? 2 : 0);
			redirect(ADMINFOLDER.'users'); 
        }
	}
	
	public function delete(){
		$uid = trim($this->input->post('uid'));
		if($uid!='' && is_numeric($uid)){
			echo $this->usersmodel->checkUser($uid);
		}else{
			echo 0;
			exit();
		}
	}
}

?>