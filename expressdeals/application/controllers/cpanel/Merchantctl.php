<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Merchantctl extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'productmodel');
		$this->load->model(ADMINFOLDER.'merchantmodel');
	}
	
	public function index(){
		validate_menu('Merchants');
		$this->load->library('pagination');
		$orderBy =" ORDER BY merchant.mid DESC";
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
		if($this->input->get('query1')!=''){
			if(is_numeric($this->input->get('query1'))){
				$search .=" AND merchant.mid='".trim($this->input->get('query1'))."' "; 
			}else{
				$search .=" AND merchant.merchant_name LIKE '%".trim($this->input->get('query1'))."%'"; 
			}
			$suffix .='&query1='.trim($this->input->get('query1'));
		}
		if($this->input->get('status')!=''){
			$search .=" AND merchant.merchant_status='".trim($this->input->get('status'))."' "; 
			$suffix .='&status='.trim($this->input->get('status'));
		}
		$perPage = 15;
		$data['title'] = 'Merchants - ENPL';
		$data['template'] = 'merchant_view';
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$totalRows = $this->merchantmodel->getMerchantCount($search);
		$totalRows = $data['total_rows'] = $totalRows;
		$config = custom_pagination([base_url(ADMINFOLDER.'merchants') ,$data['total_rows'] , $perPage ,$suffix]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->merchantmodel->getMerchants($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
}
?>