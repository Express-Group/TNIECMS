<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginmodel extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function validate_user($data){
		return $this->db->query("SELECT user.uid , user.firstname , user.lastname , groups.gid , groups.group_name , groups.roles , groups.status , user.status as user_status FROM aff_users as user INNER JOIN aff_groups as groups ON groups.gid = user.gid WHERE user.username='".$data['username']."' AND user.password = '".$data['password']."' LIMIT 1")->row_array();
	}
	
	
}

?>