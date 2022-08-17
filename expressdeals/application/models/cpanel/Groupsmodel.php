<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groupsmodel extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function insertData($data){
		return $this->db->insert('aff_groups' , $data);
	}
	
	public function get_count($search){
		return $this->db->query("SELECT groups.gid FROM aff_groups as groups INNER JOIN aff_users as user ON groups.created_by = user.uid WHERE ".$search."")->num_rows();
	}
	
	public function get_data($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT groups.gid , groups.group_name , groups.group_description , groups.status , DATE_FORMAT(groups.modified_on, '%D %M %Y %h:%i:%s %p') as modified_on , user.username FROM aff_groups as groups INNER JOIN aff_users as user ON groups.created_by = user.uid WHERE ".$search." ORDER BY ".$orderBy." LIMIT ".$row." , ".$perPage."")->result();
	}
	
	public function get_group($gid){
		return $this->db->select('*')->where('gid' , $gid)->get('aff_groups')->row_array();
	}
	
	public function updateData($data , $gid){
		$this->db->where('gid' , $gid);
		return $this->db->update('aff_groups' , $data);
	}
	
	public function getUser($gid){
		return $this->db->select('uid')->where('gid' , $gid)->get('aff_users')->num_rows();
	}
	
	public function deleteGroup($gid){
		$this->db->where('gid' , $gid);
		return $this->db->delete('aff_groups');
	}
	
	
}

?>