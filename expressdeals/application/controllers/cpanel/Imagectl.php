<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Imagectl extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'imagemodel');
	}
	
	public function index(){
		validate_menu('Image Library');
		$this->load->library('pagination'); 
		$data['title'] = 'Image Library - ENPL';
		$data['template'] = 'imglibrary_view';
		$search = " image.id!=''";
		$orderBy = " image.id DESC";
		$perPage = 20;
		$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
		$data['total_rows'] = $this->imagemodel->get_count($search);
		$config = custom_pagination([base_url(ADMINFOLDER.'image_library') ,$data['total_rows'] , $perPage ,'' ]);
		$this->pagination->initialize($config);
		$data['pager'] = str_replace('<a' ,'<a class="page-link" ',$this->pagination->create_links());
		$data['data'] = $this->imagemodel->get_records($search , $perPage , $row , $orderBy);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function upload(){
		$filename ='';
		$this->load->library('upload');
		$path = imagefolderpath();
		$config['upload_path'] = ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$path['original'];
		$config['allowed_types'] = '*';
		$this->upload->initialize($config);
		if($this->upload->do_upload('file')){
			$result = $this->upload->data();
			$filename =$result['file_name'];
		}
		if($filename!=''){
			resize_image($path , $filename);
			$caption = explode('.' , $filename);
			$data['file_path'] = $path['original'].$filename;
			$data['caption'] = $data['image_name']= trim($caption[0]);
			$data['status'] = 1;
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$finalresult = $this->imagemodel->insert_data($data);
			if($finalresult!=null && $finalresult!=0){
				echo $finalresult;
			}else{
				echo 'error';
			}
		}
	}
	
	public function upload_single(){
		$data =[];
		$filename ='';
		$this->load->library('upload');
		$path = imagefolderpath();
		$config['upload_path'] = ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$path['original'];
		$config['allowed_types'] = '*';
		$this->upload->initialize($config);
		if($this->upload->do_upload('article_single_img')){
			$result = $this->upload->data();
			$filename =$result['file_name'];
		}
		if($filename!=''){
			resize_image($path , $filename);
			$caption = explode('.' , $filename);
			$data['file_path'] = $path['original'].$filename;
			$data['caption'] = $data['image_name']= trim($caption[0]);
			$data['alt'] = '';
			$data['status'] = 1;
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$finalresult = $this->imagemodel->insert_data($data);
			if($finalresult!=null && $finalresult!=0){
				$data['id'] = $finalresult;
				$data['fullimage'] = ASSETURL.IMAGE_PATH.$data['file_path'] ;
			}else{
				$data['id'] = null;
				$data['fullimage'] = '';
			}
		}
		echo json_encode($data);
		exit();
	}
	
	public function remove(){
		$id = $this->input->post('id');
		$details = $this->imagemodel->get_data($id);		
		if(count($details) > 0){
			$folderlist = ['small/' ,'medium/' ,'large/' ,'exlarge/' ,'original/'];
			for($i=0;$i<count($folderlist);$i++){
				$filename = str_replace('original/' ,$folderlist[$i] ,$details['file_path']);
				unlink(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$filename);
			}
			echo $this->imagemodel->remove_data($id);
		}else{
			echo 0;
		}
	}
	
	public function crop(){
		validate_menu('Image Library' , 'EDIT');
		$data['title'] = 'Image Library - ENPL';
		$data['template'] = 'imgcrop_view';
		$id = $this->input->get('id');
		$data['details'] = $this->imagemodel->get_data($id);
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function set_temp(){
		$response = [];
		$response['status'] = 0;
		$details = $this->imagemodel->get_data($this->input->post('image_id'));
		if(count($details) > 0){
			$response['status'] = 1;
			$timestamp = time();
			$file = explode('.' , $details['file_path']);
			$originalPath = 'image_'.$timestamp.'.'.$file[1];
			$smallPath = 'image_small_'.$timestamp.'.'.$file[1];
			$mediumPath = 'image_medium_'.$timestamp.'.'.$file[1];
			$largePath = 'image_large_'.$timestamp.'.'.$file[1];
			$exlargePath = 'image_exlarge_'.$timestamp.'.'.$file[1];
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$details['file_path'] , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$originalPath);
			chmod(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$originalPath ,0777);
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH. str_replace('original/' ,'small/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath);
			chmod(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath ,0777);
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'medium/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath);
			chmod(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath ,0777);
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'large/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath);
			chmod(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath ,0777);
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'exlarge/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath);
			chmod(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath ,0777);
			$data['image_id'] = $details['id'];
			$data['image_path'] = $originalPath;
			$data['image_name'] = $details['image_name'];
			$data['caption'] = $details['caption'];
			$data['alt'] = $details['alt'];
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->imagemodel->insert_temp($data);
			$response['temp_id'] = $result;
			$response['path'] = ASSETURL.IMAGE_TEMP_PATH.$originalPath; 
		}
		echo json_encode($response);
		exit();
	}
	
	public function remove_temp(){
		$details = $this->imagemodel->get_tempdata($this->input->post('temp_id'));
		if(count($details) > 0){
			$originalPath = $details['image_path'];
			$smallPath = str_replace('image_' , 'image_small_' , $details['image_path']);
			$mediumPath = str_replace('image_' , 'image_medium_' , $details['image_path']);
			$largePath = str_replace('image_' , 'image_large_' , $details['image_path']);
			$exlargePath = str_replace('image_' , 'image_exlarge_' , $details['image_path']);
			unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$originalPath);
			unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath);
			unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath);
			unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath);
			unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath);
			echo $this->imagemodel->remove_tempdata($details['id']);
		}else{
			echo 0;
		}
	}
	
	public function check_imagename(){
		$imageName = trim($this->input->post('image_name'));
		$details = $this->imagemodel->get_data($imageName ,2);
		if(count($details) > 0){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	

}

?>