<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Homecontroller extends CI_Controller{
	
	private $homeID;
	public function __construct(){
		parent::__construct();
		$this->load->model('homemodel');
		$this->load->library('template_library');
		$this->homeID = 19;
	}
	
	public function index(){
		$data['sectionDetails'] = $this->homemodel->sectionDetails($this->homeID);
		$data['menuDetails'] = $this->homemodel->menuDetails();
		$data['url'] = base_url();
		$data['commonTemplate'] = 0;
		$data['isHome'] = 1;
		$data['isArticle'] = 0;
		if(count($data['sectionDetails']) > 0){
			$data['template'] =  $data['sectionDetails']['template'];
			if($data['template']!=''){
				$jsonData = json_decode($data['template'] , true);
				if(count($jsonData) > 0){
					$data['html'] = $this->template_library->form_template($jsonData , $data);
					$this->load->view('home' , $data);
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}
	public function section(){
		$sectionUrl =  strtolower(trim($this->uri->uri_string()));
		$data['sectionDetails'] = $this->homemodel->sectionDetails($sectionUrl);
		$data['menuDetails'] = $this->homemodel->menuDetails();
		$data['url'] = base_url();
		$data['isHome'] = 0;
		$data['isArticle'] = 0;
		if(count($data['sectionDetails']) > 0){
			$data['commonTemplate'] = 0;
			$data['template'] =  $data['sectionDetails']['template'];
			if($data['template']!=''){
				$jsonData = json_decode($data['template'] , true);
				if(count($jsonData) > 0){
					$data['html'] = $this->template_library->form_template($jsonData , $data);
					$this->load->view('home' , $data);
				}else{
					show_404();
				}
			}else{
				$data['commonTemplate'] = 1;
				$common = $this->homemodel->commonTemplate(20000);
				if(count($common) > 0){
					$data['template'] =  $common['published_template'];
					if($data['template']!=''){
						$jsonData = json_decode($data['template'] , true);
						if(count($jsonData) > 0){
							$data['html'] = $this->template_library->form_template($jsonData , $data);
							$this->load->view('home' , $data);
						}else{
							show_404();
						}
					}else{
						show_404();
					}
				}else{
					show_404();
				}
			}
		}else{
			show_404();
		}
	}
	public function article($contentID){
		$data['articleDetails'] = $this->homemodel->articleDetails($contentID);
		$data['productDetails'] = $this->homemodel->productDetails($contentID);
		if(count($data['articleDetails']) > 0){
			$data['sectionDetails'] = $this->homemodel->sectionDetails($data['articleDetails']['section_id']);
			$data['menuDetails'] = $this->homemodel->menuDetails();
			$data['url'] = base_url();
			$data['isHome'] = 0;
			$data['isArticle'] = 1;
			if(count($data['sectionDetails']) > 0){
				$data['commonTemplate'] = 1;
				$common = $this->homemodel->commonTemplate(20001);
				if(count($common) > 0){
					$data['template'] =  $common['published_template'];
					if($data['template']!=''){
						$jsonData = json_decode($data['template'] , true);
						if(count($jsonData) > 0){
							$data['html'] = $this->template_library->form_template($jsonData , $data);
							$this->load->view('home' , $data);
						}else{
							show_404();
						}
					}else{
						show_404();
					}
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}
}
?>