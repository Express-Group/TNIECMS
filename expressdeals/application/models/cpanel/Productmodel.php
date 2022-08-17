<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Productmodel extends CI_Model{
	private $tbl = 'aff_products';
	private $merchanttbl = 'aff_merchants';
	private $sectiontbl = 'aff_sections';

	public function __construct(){
		parent::__construct();
	}
	
	public function insertProduct($data){
		$this->db->insert($this->tbl , $data);
		return $this->db->insert_id();
	}
	public function updateProduct($data , $pid){
		$this->db->where('pid' , $pid);
		return $this->db->update($this->tbl , $data);
	}
	
	public function insertMerchant($data){
		return $this->db->insert_batch($this->merchanttbl, $data); 
	}
	
	public function removeMerchant($pid){
		$this->db->where('pid' , $pid);
		return $this->db->delete($this->merchanttbl);
	}
	
	public function productDetails($pid){
		return $this->db->select('*')->where('pid' , $pid)->get($this->tbl)->row_array(); 
	}
	
	public function merchantDetails($pid){
		return $this->db->select('*')->where('pid' , $pid)->get($this->merchanttbl)->result_array(); 
	}
	
	public function getProductCount($search){
		return $this->db->query("SELECT product.pid FROM ".$this->tbl." AS product INNER JOIN aff_users AS user ON  product.modified_by = user.uid INNER JOIN ".$this->sectiontbl." AS section ON product.section_id = section.sid  WHERE ".$search."")->num_rows();
	}
	
	public function getProducts($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT product.pid , product.product_name , product.product_short_note  ,product.product_summary , product.image_path ,  product.image_caption , product.image_alt ,product.image_id ,product.status , DATE_FORMAT(product.modified_on, '%D %b %Y %h:%i:%s %p') as modified_on , user.username , section.section_name FROM ".$this->tbl." AS product INNER JOIN aff_users AS user ON  product.modified_by = user.uid INNER JOIN ".$this->sectiontbl." AS section ON product.section_id = section.sid  WHERE ".$search." ".$orderBy." LIMIT ".$row ." , ".$perPage."")->result();
	}
	
	public function get_sections(){
		return $this->db->select('sid , section_name , parent_id , article_hosting , section_type')->where('status' ,1)->order_by('order_by' , 'ASC')->get($this->sectiontbl)->result();
	}
	public function getImagesCount($search , $perpage ,$rows){
		return $this->db->query("SELECT img.id FROM aff_images AS img INNER JOIN aff_users AS user ON img.created_by = user.uid WHERE img.status=1 ".$search."")->num_rows();
	}
	
	public function getImages($search , $perpage ,$rows){
		return $this->db->query("SELECT img.id , img.file_path , img.caption , img.alt , img.image_name ,user.username FROM aff_images AS img INNER JOIN aff_users AS user ON img.created_by = user.uid WHERE img.status=1 ".$search." ORDER BY img.id DESC LIMIT ".$rows." , ".$perpage."")->result();
	}
	public function set_temp($image_id){
		$this->load->model(ADMINFOLDER.'imagemodel');
		$response = [];
		$response['status'] = 0;
		$details = $this->imagemodel->get_data($image_id);
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
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH. str_replace('original/' ,'small/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath);
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'medium/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath);
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'large/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath);
			copy(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'exlarge/',$details['file_path']) , ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath);
			$data['image_id'] = $details['id'];
			$data['image_path'] = $originalPath;
			$data['image_name'] = $details['image_name'];
			$data['caption'] = $details['caption'];
			$data['alt'] = $details['alt'];
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->imagemodel->insert_temp($data);
			$response['temp_id'] = $result;
			$response['image_name'] = $data['image_name'];
			$response['path'] = ASSETURL.IMAGE_TEMP_PATH.$originalPath; 
		}
		return $response;
	}
	
	public function remove_temp($image_id){
		$this->load->model(ADMINFOLDER.'imagemodel');
		$result = $this->db->select('*')->where('image_id', $image_id)->get('aff_temp_images')->result_array();
		foreach($result as $details){
			$originalPath = $details['image_path'];
			$smallPath = str_replace('image_' , 'image_small_' , $details['image_path']);
			$mediumPath = str_replace('image_' , 'image_medium_' , $details['image_path']);
			$largePath = str_replace('image_' , 'image_large_' , $details['image_path']);
			$exlargePath = str_replace('image_' , 'image_exlarge_' , $details['image_path']);
			@unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$originalPath);
			@unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath);
			@unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath);
			@unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath);
			@unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath);
			$this->imagemodel->remove_tempdata($details['id']);
		}
	}
	
	
	
	
}?>