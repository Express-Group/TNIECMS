<?php

class specialwidget extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function corona(){
		
		$data = [];
		$data['active_case_india' ] = $this->input->post('active_case_india');
		$data['deaths_case_india' ] = $this->input->post('deaths_case_india');
		$data['re_case_india' ] = $this->input->post('re_case_india');
		$data['active_case_world' ] = $this->input->post('active_case_world');
		$data['deaths_case_world' ] = $this->input->post('deaths_case_world');
		$data['re_case_world' ] = $this->input->post('re_case_world');
		$data['url' ] = $this->input->post('re_url');
		$data = json_encode($data);
		$filepath =  FCPATH.'application/views/specialwidget/corona.widget';
		file_put_contents($filepath , $data);
		$post_data = array('file_name' => 'corona.widget','file_contents'=> $data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, BASEURLTEMP.'user/commonwidget/special_widget_put');
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$result=curl_exec ($ch);
		curl_close ($ch);
		echo 1;
	}
	
	public function get_corona(){
		$filepath =  FCPATH.'application/views/specialwidget/corona.widget';
		echo file_get_contents($filepath);
	}
} 
?>