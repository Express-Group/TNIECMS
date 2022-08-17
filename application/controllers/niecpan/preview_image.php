<?php

class preview_image extends CI_Controller{
	
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function image($id=''){
		$imagepath  = $this->input->get('q');
		if(!empty($imagepath))
			header('Content-Disposition: inline');
			header('Content-type: image/jpeg');
			readfile('http://images.newindianexpress.com/uploads/article/temp/3a28c7a5b55e6d437a0020990e192244_150_150.jpg');
	}
}
?>  