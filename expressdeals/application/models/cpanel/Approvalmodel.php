<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Approvalmodel extends CI_Model{
	
	private $tbl = 'aff_content_approval';
	private $sectiontbl = 'aff_sections';
	private $relatedtbl = 'aff_content_related';
	private $mappingtbl = 'aff_content_maping';
	private $producttbl = 'aff_products';
	private $productrealtedtbl = 'aff_products_related';
	private $contenttbl = 'aff_content';
	public function __construct(){
		parent::__construct();
	}
	
	public function get_sections(){
		
		return $this->db->select('sid , section_name , parent_id , article_hosting , section_type')->where('status' ,1)->order_by('order_by' , 'ASC')->get($this->sectiontbl)->result();
	}
	public function getSectionDetails($sid){
		return $this->db->select('sid , section_name , parent_id , article_hosting , section_type , section_path , section_full_path')->where('sid' , $sid)->get($this->sectiontbl)->row_array();
	}
	public function getArticleCount($search=''){
		return $this->db->query("SELECT approval.content_id FROM ".$this->contenttbl." AS approval INNER JOIN ".$this->sectiontbl." AS section ON approval.section_id = section.sid INNER JOIN aff_users AS user ON  approval.modified_by = user.uid LEFT JOIN ".$this->mappingtbl." AS mapping ON approval.content_id = mapping.content_id WHERE ".$search."")->num_rows();
	}
	public function getArticle($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT approval.content_id , approval.title , approval.url , approval.image_path , approval.image_alt ,approval.author_name , approval.status , DATE_FORMAT(approval.last_updated_on, '%D %b %Y %h:%i:%s %p') as modified_on , approval.approve_status ,  user.username  , section.section_full_path , section.section_name FROM ".$this->contenttbl." AS approval INNER JOIN aff_users AS user ON  approval.modified_by = user.uid INNER JOIN ".$this->sectiontbl." AS section ON approval.section_id = section.sid LEFT JOIN ".$this->mappingtbl." AS mapping ON approval.content_id = mapping.content_id WHERE ".$search." GROUP BY approval.content_id ".$orderBy." LIMIT ".$row ." , ".$perPage."")->result();
	}
	
	public function approvalArticle($id){
		return $this->db->query("SELECT * FROM ".$this->tbl." WHERE content_id='".$id."' ORDER BY aid DESC LIMIT 1")->row_array();
	}
	
	public function updateArticle($content , $relatedContent , $id){
		$this->db->where('content_id' , $id);
		$this->db->update($this->contenttbl , $content);
		$this->db->where('content_id' , $id);
		return $this->db->update($this->relatedtbl , $relatedContent);
	}
	
	public function approveUpdate($aid , $data){
		$this->db->where('aid' , $aid);
		return $this->db->update($this->tbl , $data);
	}
	
	public function getApprovalArticleCount($search){
		return $this->db->query("SELECT aid FROM ".$this->tbl." WHERE ".$search."")->num_rows();
	}
	
	public function getApprovalArticle($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT aid , content_id , title , image_path , image_alt , DATE_FORMAT(last_updated_on, '%D %b %Y %h:%i:%s %p') as last_updated_on FROM ".$this->tbl." WHERE ".$search." ".$orderBy." LIMIT ".$row ." , ".$perPage."")->result();
	}
	
	public function getApprovalArticleList($id){
		return $this->db->query("SELECT a.aid , a.title , a.image_path , a.image_alt , DATE_FORMAT(a.last_updated_on, '%D %b %Y %h:%i:%s %p') as last_updated_on , a.status , a.notes , DATE_FORMAT(a.approved_on, '%D %b %Y %h:%i:%s %p') as approved_on , a.approved_by , u.username , s.section_name FROM ".$this->tbl." AS a INNER JOIN aff_users AS u ON a.modified_by = u.uid INNER JOIN ".$this->sectiontbl." AS s ON  a.section_id = s.sid WHERE a.content_id = '".$id."'")->result();
	}
	
}?>