<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sectionmodel extends CI_Model{
	private $tbl = 'aff_sections';
	public function __construct(){
		parent::__construct();
	}
	
	public function get_allsections(){
		
		return $this->db->select('sid , section_name , parent_id , section_type')->where('status' ,1)->order_by('order_by' , 'ASC')->get($this->tbl)->result();
	}
	
	public function get_parentsection($sid){
		return $this->db->select('sid , section_name , section_path , section_full_path')->where(['status' => 1 , 'sid' => $sid])->get($this->tbl)->row_array();
	}
	
	public function check_fullpath($path){
		return $this->db->select('sid')->where(['section_full_path' => $path])->get($this->tbl)->num_rows();
	}
	
	public function insertData($data){
		return $this->db->insert($this->tbl , $data);
	}
	
	public function maxvalue(){
		$result = $this->db->select_max('order_by', 'max')->get($this->tbl);
		return ($result->row()->max + 1);
	}
	
	public function get_count($search){
		return $this->db->query("SELECT section.sid FROM ".$this->tbl." as section INNER JOIN aff_users as user ON section.created_by = user.uid WHERE ".$search."")->num_rows();
	}
	
	public function get_data($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT section.sid , section.section_name , section.section_full_path , section.parent_id , section.status , DATE_FORMAT(section.modified_on, '%D %M %Y %h:%i:%s %p') as modified_on , user.username FROM ".$this->tbl." as section INNER JOIN aff_users as user ON section.created_by = user.uid WHERE ".$search." ORDER BY ".$orderBy." LIMIT ".$row." , ".$perPage."")->result();
	}
	
	public function update_section($data,$id){
		$this->db->where('sid' , $id);
		return $this->db->update($this->tbl , $data);
	}
	
	public function sectionDetails($sid){
		return $this->db->select('*')->from($this->tbl)->where('sid' , $sid)->get()->row_array();
	}
	
}

?>