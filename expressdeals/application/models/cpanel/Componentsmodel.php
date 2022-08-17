<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Componentsmodel extends CI_Model{
	
	private $authortbl = 'aff_authors';
	private $tagstbl = 'aff_tags';
	private $conuntrytbl = 'aff_country';
	private $usertbl = 'aff_users';
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function getAuthorCount($search){
		return $this->db->query("SELECT author.aid FROM ".$this->authortbl." as author INNER JOIN ".$this->usertbl." as users ON author.created_by = users.uid   WHERE ".$search."")->num_rows();
	}
	
	public function getTagsCount($search){
		return $this->db->query("SELECT tags.tag_id FROM ".$this->tagstbl." as tags INNER JOIN ".$this->usertbl." as users ON tags.modified_by = users.uid   WHERE ".$search."")->num_rows();
	}
	public function getCountriesCount($search){
		return $this->db->query("SELECT cid FROM ".$this->conuntrytbl." WHERE ".$search."")->num_rows();
	}
	
	public function getAuthor($search , $perPage , $row , $orderBy){	
		return $this->db->query("SELECT  users.username , author.aid , author.author_name , author.author_description  , author.author_image , author.caption , author.alt , author.status ,  DATE_FORMAT(author.modified_on, '%D %M %Y %h:%i:%s %p') as modified_on FROM ".$this->authortbl." as author INNER JOIN ".$this->usertbl." as users ON author.created_by = users.uid WHERE ".$search." ".$orderBy." LIMIT ".$row." , ".$perPage."")->result();
	}
	
	public function getTag($search , $perPage , $row , $orderBy){	
		return $this->db->query("SELECT  users.username , tags.tag_id , tags.tag_name , tags.meta_name  , tags.meta_description , tags.status , DATE_FORMAT(tags.modified_on, '%D %M %Y %h:%i:%s %p') as modified_on FROM ".$this->tagstbl." as tags INNER JOIN ".$this->usertbl." as users ON tags.modified_by = users.uid WHERE ".$search." ".$orderBy." LIMIT ".$row." , ".$perPage."")->result();
	}
	
	public function getCountries($search , $perPage , $row , $orderBy){	
		return $this->db->query("SELECT  cid , name FROM ".$this->conuntrytbl." WHERE ".$search." ".$orderBy." LIMIT ".$row." , ".$perPage."")->result();
	}
	
	public function insertData($data , $table){
		return $this->db->insert($table , $data);
	}
	public function updateData($data , $id , $table){
		$this->db->where('aid' ,  $id );
		return $this->db->update($table , $data);
	}
	
	public function updateTag($data , $id){
		$this->db->where('tag_id' ,  $id );
		return $this->db->update($this->tagstbl , $data);
	}
	
	public function getAuthorRecords($aid){
		return $this->db->select('*')->where('aid' , $aid)->get($this->authortbl)->row_array();
	}
	
	public function getTagRecords($tid){
		return $this->db->select('*')->where('tag_id' , $tid)->get($this->tagstbl)->row_array();
	}
	
	public function checkAuthor($id){
		$this->db->db_debug = false;
		$this->db->where('aid' , $id);
		if(!@$this->db->delete($this->authortbl)){
			return 2;
		}else{
			$this->db->db_debug = true;
			return 1;
		}
	}
}

?>