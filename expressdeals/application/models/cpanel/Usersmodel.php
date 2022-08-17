<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usersmodel extends CI_Model{
	
	private $tbl = 'aff_users';
	
	public function __construct(){
		parent::__construct();
	}
	
	public function get_groups(){
		return $this->db->select('gid , group_name')->where('status' , 1)->get('aff_groups')->result();
	}
	
	public function insertData($data){
		return $this->db->insert($this->tbl , $data);
	}
	
	public function updateData($data , $id){
		$this->db->where('uid' , $id);
		return $this->db->update($this->tbl , $data);
	}
	
	public function get_count($search){
		return $this->db->query("SELECT users.uid FROM aff_users as users INNER JOIN aff_users as userlist ON userlist.uid = users.uid INNER JOIN aff_groups as groups ON users.gid = groups.gid  WHERE ".$search."")->num_rows();
	}
	
	public function get_data($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT users.uid , users.username , users.firstname , users.lastname , users.status , DATE_FORMAT(users.modified_on, '%D %M %Y %h:%i:%s %p') as modified_on ,  groups.group_name  , userlist.username as mod_user FROM aff_users as users INNER JOIN aff_users as userlist ON userlist.uid = users.modified_by INNER JOIN aff_groups as groups ON users.gid = groups.gid WHERE ".$search." ORDER BY ".$orderBy." LIMIT ".$row." , ".$perPage."")->result();
	}
	
	public function getUser($id){
		return $this->db->select('*')->where('uid' , $id)->get($this->tbl)->row_array(); 
	}
	
	public function checkUser($id){
		$this->db->db_debug = false;
		$this->db->where('uid' , $id);
		if(!@$this->db->delete($this->tbl)){
			return 2;
		}else{
			$this->db->db_debug = true;
			return 1;
		}
	}
	
	
	
}

?>