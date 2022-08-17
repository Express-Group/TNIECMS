<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Templatemodel extends CI_Model{
	private $tbl = 'aff_template';
	private $contenttbl = 'aff_content';
	private $sectiontbl = 'aff_sections';
	private $relatedtbl = 'aff_content_related';
	private $mappingtbl = 'aff_content_maping';
	public function __construct(){
		parent::__construct();
	}
	
	public function get_sections($id =0){
		if($id==0){
			return $this->db->select('sid , section_name , parent_id , article_hosting , section_type')->where('status' ,1)->order_by('order_by' , 'ASC')->get($this->sectiontbl)->result();
		}else{
			return $this->db->select('sid , section_name , parent_id , article_hosting , section_type')->where(['status' =>1 ,'sid' => $id])->get($this->sectiontbl)->row_array();
		}
		
	}
	
	public function get_versions($sid){
		return $this->db->select('tid , template_name , active_status')->where(['status' => 1 , 'section_id' => $sid])->get($this->tbl)->result();
	}
	
	public function get_pageparam($tid){
		//return $this->db->select('*')->where(['status' => 1 , 'tid' => $tid])->get($this->tbl)->row_array();
		return $this->db->query("SELECT t.tid , t.section_id , t.template_name , t.template , t.status , t.active_status  , t.update_status , t.locked_by , user.username , user.firstname , user.lastname FROM ".$this->tbl." AS t INNER JOIN aff_users AS user ON t.created_by = user.uid WHERE t.status=1 AND t.tid='".$tid."'")->row_array();
	}
	
	public function maxvalue($sid){
		$result = $this->db->select_max('tid', 'max')->where('section_id' , $sid)->get($this->tbl);
		return ($result->row()->max + 1);
	}
	
	public function insertTemplate($data){
		$this->db->insert($this->tbl , $data);
		return $this->db->insert_id();
	}
	
	public function updateTemplate($data , $tid){
		$this->db->where('tid', $tid);
		return $this->db->update($this->tbl , $data);
	}
	
	public function getContent($search){
		return $this->db->query("SELECT article.content_id , article.title , article.url , article.image_path , article.image_alt , article.status , article.content_type , DATE_FORMAT(article.last_updated_on, '%D %b %Y %h:%i:%s %p') as modified_on ,  user.username  , section.section_full_path , section.section_name FROM ".$this->contenttbl." AS article INNER JOIN aff_users AS user ON  article.created_by = user.uid INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id INNER JOIN ".$this->sectiontbl." AS section ON article.section_id = section.sid WHERE ".$search." GROUP BY article.content_id ORDER BY article.published_date DESC LIMIT 50")->result();
	}
	
	public function selectedContent($list){
		if($list!=''){
			return $this->db->query("SELECT article.content_id , article.title , article.url , article.image_path , article.image_alt , article.status , article.content_type , DATE_FORMAT(article.last_updated_on, '%D %b %Y %h:%i:%s %p') as modified_on  FROM ".$this->contenttbl." AS article WHERE status=1 AND content_id IN(".$list.")")->result();
		}else{
			return [];
		}
		
	}
	
	public function lockStatus($tid){
		$query = $this->db->query("SELECT tid ,locked_by FROM ".$this->tbl." WHERE tid='".$tid."'")->row_array();
		if($query['locked_by']==null){
			$this->db->where('tid' , $tid);
			$this->db->update($this->tbl , ['locked_by' => $this->session->userdata('uid') ,'modified_by' =>$this->session->userdata('uid') , 'modified_on' => date('Y-m-d H:i:s')]);
			return [1 ,""];
		}else{
			$userDetails = $this->db->select('username')->where('uid' ,$query['locked_by'])->get('aff_users')->row_array();
			return [0 ,$userDetails['username']];
		}
	}
	
	public function unlockTemplate($tid){
		$this->db->where('tid' , $tid);
		return $this->db->update($this->tbl , ['locked_by' => null ,'modified_by' =>$this->session->userdata('uid') , 'modified_on' => date('Y-m-d H:i:s')]);
	}
	
	public function userDetails($id){
		if($id!=null){
			return $this->db->select('username , uid ,firstname , lastname')->where('uid' ,$id)->get('aff_users')->row_array();
		}else{
			return [];
		}
		
	}
	
	public function updateSection($sid , $data){
		$this->db->where('sid'  ,$sid);
		return $this->db->update($this->sectiontbl , ['template' => $data]);
	}
	
	public function updatesectionTemplate($sid){
		$this->db->where('section_id'  ,$sid);
		return $this->db->update($this->tbl , ['active_status' => 0]);
	}
	
}?>