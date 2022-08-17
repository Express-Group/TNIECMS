<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Imagemodel extends CI_Model{
	private $tbl = 'aff_images';
	private $temptbl = 'aff_temp_images';
	public function __construct(){
		parent::__construct();
	}
	
	public function insert_data($data){
		$this->db->insert($this->tbl , $data);
		return $this->db->insert_id();
	}
	
	public function get_data($id , $type=1){
		if($type==1){
			return $this->db->select('*')->from($this->tbl)->where('id' , $id)->get()->row_array();
		}else{
			return $this->db->select('*')->from($this->tbl)->where('image_name' , $id)->get()->result();
		}
		
	}
	
	public function remove_data($id){
		$this->db->where('id' , $id);
		return $this->db->delete($this->tbl);
	}
	
	public function get_count($search){
		return $this->db->query("SELECT image.id FROM ".$this->tbl." as image INNER JOIN aff_users as user ON image.created_by = user.uid WHERE ".$search."")->num_rows();
	}
	
	public function get_records($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT image.id , image.file_path , image.caption , image.alt , image.status , DATE_FORMAT(image.modified_on, '%D %M %Y %h:%i:%s %p') as modified_on , user.username FROM ".$this->tbl." as image INNER JOIN aff_users as user ON image.created_by = user.uid WHERE ".$search." ORDER BY ".$orderBy." LIMIT ".$row." , ".$perPage."")->result();
	}
	
	public function insert_temp($data){
		$this->db->insert($this->temptbl , $data);
		return $this->db->insert_id();
	}
	
	public function get_tempdata($id){
		return $this->db->select('*')->from($this->temptbl)->where('id' , $id)->get()->row_array();
	}
	
	public function remove_tempdata($id){
		$this->db->where('id' , $id);
		return $this->db->delete($this->temptbl);
	}
	
}

?>