<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardctl extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data['title'] = 'Dashboard - Enpl';
		$data['template'] = 'home_view';
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function denied($menuname){
		$data['title'] = 'Access Denied - Enpl';
		$data['menuname'] = $menuname;
		$this->load->view(ADMINFOLDER.'access_denied_view' , $data);
	}
	
	public function logout(){
		$this->session->userdata = array();
		$this->session->sess_destroy();
		redirect(ADMINFOLDER);
	}
}
?>