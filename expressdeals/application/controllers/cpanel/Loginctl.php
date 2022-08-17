<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginctl extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'loginmodel');
	}
	
	public function index(){
		$this->load->view(ADMINFOLDER.'login_view');
	}
	
	public function login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|alpha');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$this->load->view(ADMINFOLDER.'login_view');
		}else{
			$data['username'] = $this->input->post('username' , true);
			$data['password'] = md5($this->input->post('password' , true));
			$result = $this->loginmodel->validate_user($data);
			if(is_array($result) && count($result) > 0){
				if($result['user_status']==0){
					$this->session->set_flashdata('message' ,2);
					redirect(ADMINFOLDER);
					exit;
				}
				$this->session->set_userdata('uid' , $result['uid']);
				$this->session->set_userdata('username' , $data['username']);
				$this->session->set_userdata('userdata' , $result);
				redirect(ADMINFOLDER.'home');
			}else{
				$this->session->set_flashdata('message' ,1);
				redirect(ADMINFOLDER);
			}
		}
	}
	
	public function logout(){
		$this->session->userdata = array();
		$this->session->sess_destroy();
		redirect(ADMINFOLDER);
	}
}
?>