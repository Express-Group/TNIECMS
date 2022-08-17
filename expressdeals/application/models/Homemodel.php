<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Homemodel extends CI_Model{
	
	private $sectiontbl = 'aff_sections';
	private $contenttbl = 'aff_content';
	private $relatedtbl = 'aff_content_related';
	private $mappingtbl = 'aff_content_maping';
	private $templatetbl = 'aff_template';
	private $producttbl = 'aff_products';
	private $productrelatedtbl = 'aff_products_related';
	private $merchanttbl = 'aff_merchants';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('memcached_library');
	}
	
	public function sectionDetails($sid){
		if(IS_MEMCACHE){
			$CacheID = 'SECTIONID-'.$sid;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$type = (is_numeric($sid)) ? 'sid' : 'section_full_path';
				$result = $this->db->select('sid , section_name , section_path , section_full_path , parent_id , section_type , order_by ,article_hosting , visible_status , rss_status , meta_title , meta_description , meta_keywords , no_index , no_follow , canonical_url , template ,image ')->where(['status' => 1 , $type => $sid])->get($this->sectiontbl)->row_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			$type = (is_numeric($sid)) ? 'sid' : 'section_full_path';
			return $this->db->select('sid , section_name , section_path , section_full_path , parent_id , section_type , order_by ,article_hosting , visible_status , rss_status , meta_title , meta_description , meta_keywords , no_index , no_follow , canonical_url , template , image')->where(['status' => 1 , $type => $sid])->get($this->sectiontbl)->row_array();
		}
		
	}
	
	public function menuDetails(){
		if(IS_MEMCACHE){
			$CacheID = 'MENULIST';
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->select('sid , section_name , section_path , section_full_path , parent_id , rss_status')->where(['status' => 1])->order_by('order_by', 'ASC')->get($this->sectiontbl)->result_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $this->db->select('sid , section_name , section_path , section_full_path , parent_id , rss_status')->where(['status' => 1])->order_by('order_by', 'ASC')->get($this->sectiontbl)->result_array();
		}
	}
	
	public function getManualArticles($list , $limit){
		if(IS_MEMCACHE){
			$CacheID = 'MANUALARTICLES-'.$list;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query("SELECT content_id , url , title , summary , section_id , content_type , published_date , image_path , image_caption , image_alt , author_name FROM ".$this->contenttbl." WHERE status =1 AND (approve_status=1 OR approve_status=2)  AND content_id IN (".$list.") ORDER BY FIELD(content_id,".$list.") LIMIT ".$limit."")->result_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $this->db->query("SELECT content_id , url , title , summary , section_id , content_type , published_date , image_path , image_caption , image_alt , author_name FROM ".$this->contenttbl." WHERE status =1 AND (approve_status=1 OR approve_status=2) AND content_id IN (".$list.") ORDER BY FIELD(content_id,".$list.") LIMIT ".$limit."")->result_array();
		}
	}
	
	public function getAutoArticles($section , $limit){
		if(IS_MEMCACHE){
			$CacheID = 'AUTOARTICLES-'.$section;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$sectionQuery ="";
				if($section!=''){
					$sectionQuery = "";
					$sectionQuery .=" AND (mapping.section_id IN (select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$section."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)) OR mapping.section_id='".$section."' OR article.section_id='".$section."' )";
				}
				$result = $this->db->query("SELECT article.content_id , article.title , article.url , article.summary ,  article.section_id , article.content_type  , article.last_updated_on AS published_date , article.image_path , article.image_alt  , article.image_caption , article.author_name FROM ".$this->contenttbl." AS article INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$sectionQuery." GROUP BY article.content_id ORDER BY article.last_updated_on DESC LIMIT ".$limit ."")->result_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			$sectionQuery ="";
			if($section!=''){
				$sectionQuery = "";
				$sectionQuery .=" AND (mapping.section_id IN (select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$section."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)) OR mapping.section_id='".$section."' OR article.section_id='".$section."' )";
			}
			return $this->db->query("SELECT article.content_id , article.title , article.url , article.summary ,  article.section_id , article.content_type  , article.last_updated_on AS published_date , article.image_path , article.image_alt  , article.image_caption  , article.author_name FROM ".$this->contenttbl." AS article INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$sectionQuery." GROUP BY article.content_id ORDER BY article.published_date DESC LIMIT ".$limit ."")->result_array();
		}
	}
	
	public function commonTemplate($id){
		if(IS_MEMCACHE){
			$CacheID = 'COMMONTEMPLATELIST-'.$id;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query("SELECT published_template , tid , section_id FROM ".$this->templatetbl." WHERE status =1 AND active_status=1 AND section_id='".$id."' LIMIT 1")->row_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $this->db->query("SELECT published_template , tid , section_id FROM ".$this->templatetbl." WHERE status =1 AND active_status=1 AND section_id='".$id."' LIMIT 1")->row_array();
		}
	}
	
	public function getAutoPaginationCount($section ,  $takenIDs , $max_article){
		if(IS_MEMCACHE){
			$CacheID = 'AUTOPAGINATION-'.$section;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query("SELECT template , tid , section_id FROM ".$this->templatetbl." WHERE status =1 AND active_status=1 AND section_id='".$id."' LIMIT 1")->row_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			$sectionQuery = "";
			if($section!=''){
				$sectionQuery .=" AND (mapping.section_id IN (select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$section."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)) OR mapping.section_id='".$section."' OR article.section_id='".$section."' )";
			}
			if($takenIDs!=''){
				$sectionQuery .=" AND article.content_id NOT IN(".$takenIDs.") ";
			}
			return $this->db->query("SELECT article.content_id  FROM ".$this->contenttbl." AS article INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$sectionQuery."  GROUP BY article.content_id")->num_rows();
		}
	}
	
	public function getAutoPaginationArticles($section , $perpage , $row , $takenIDs){
		if(IS_MEMCACHE){
			$CacheID = 'AUTOPAGINATIONARTICLES-'.$section;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$sectionQuery ="";
				if($section!=''){
					$sectionQuery = "";
					$sectionQuery .=" AND (mapping.section_id IN (select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$section."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)) OR mapping.section_id='".$section."' OR article.section_id='".$section."' )";
				}
				if($takenIDs!=''){
					$sectionQuery .=" AND article.content_id NOT IN(".$takenIDs.") ";
				}
				$result = $this->db->query("SELECT article.content_id , article.title , article.url , article.summary ,  article.section_id , article.content_type  , article.last_updated_on AS published_date , article.image_path , article.image_alt  , article.image_caption , article.author_name FROM ".$this->contenttbl." AS article INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$sectionQuery." GROUP BY article.content_id ORDER BY article.last_updated_on DESC LIMIT ".$row ." ,".$perpage ."")->result_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			$sectionQuery ="";
			if($section!=''){
				$sectionQuery = "";
				$sectionQuery .=" AND (mapping.section_id IN (select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$section."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)) OR mapping.section_id='".$section."' OR article.section_id='".$section."' )";
			}
			if($takenIDs!=''){
				$sectionQuery .=" AND article.content_id NOT IN(".$takenIDs.") ";
			}
			return $this->db->query("SELECT article.content_id , article.title , article.url , article.summary ,  article.section_id , article.content_type  , article.last_updated_on AS published_date , article.image_path , article.image_alt  , article.image_caption , article.author_name FROM ".$this->contenttbl." AS article INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$sectionQuery." GROUP BY article.content_id ORDER BY article.published_date DESC LIMIT ".$row ." ,".$perpage ."")->result_array();
		}
	}
	
	public function articleDetails($contentID){
		if(IS_MEMCACHE){
			$CacheID = 'ACONTNETID-'.$contentID;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query(" SELECT content_id , url , title , summary , content , section_id , content_type ,published_date , last_updated_on , image_path , image_caption , image_alt , author_name , author_image , author_image_caption , author_image_alt , tags , allow_comments , allow_pagination , no_index , no_follow , canonical_url , meta_title , meta_description FROM ".$this->contenttbl." WHERE status=1 AND (approve_status=1 OR approve_status=2) AND content_id='".$contentID."'")->row_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $this->db->query(" SELECT content_id , url , title , summary , content , section_id , content_type ,published_date , last_updated_on , image_path , image_caption , image_alt , author_name , author_image , author_image_caption , author_image_alt , tags , allow_comments , allow_pagination , no_index , no_follow , canonical_url , meta_title , meta_description FROM ".$this->contenttbl." WHERE status=1 AND (approve_status=1 OR approve_status=2) AND content_id='".$contentID."'")->row_array();
		}
	}
	
	public function productDetails($contentID){
		if(IS_MEMCACHE){
			$CacheID = 'PRODUCTDETAILS-'.$contentID;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query("SELECT related.pid , related.title , product.product_name , product.product_short_note , product.product_summary , product.image_path , product.image_alt , product.image_caption FROM ".$this->productrelatedtbl." AS related INNER JOIN ".$this->producttbl." AS product ON related.pid = product.pid WHERE related.content_id='".$contentID."' AND product.status=1")->result_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $this->db->query("SELECT related.pid , related.title , product.product_name , product.product_short_note , product.product_summary , product.image_path , product.image_alt , product.image_caption FROM ".$this->productrelatedtbl." AS related INNER JOIN ".$this->producttbl." AS product ON related.pid = product.pid WHERE related.content_id='".$contentID."' AND product.status=1")->result_array();
		}
	}
	
	public function getSearchCount($term , $search_by , $type){
		$serach ='';
		switch($search_by){
			case 2:
				$serach .=" AND summary LIKE '%".$term."%'";
			break;
			case 3:
				$serach .=" AND author_name LIKE '".$term."'";
			break;
			default:
				$serach .=" AND title LIKE '%".$term."%'";
			break;
		} 
		$serach .=" AND content_type ='".$type."'";
		if(IS_MEMCACHE){
			$CacheID = 'SEARCH-'.$term;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query("SELECT article.content_id FROM ".$this->contenttbl." AS article WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$serach."")->num_rows();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $this->db->query("SELECT article.content_id FROM ".$this->contenttbl." AS article WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$serach."")->num_rows();
		}
	}
	
	public function getSearchContent($term , $search_by , $type , $row , $limit){
		$serach ='';
		switch($search_by){
			case 2:
				$serach .=" AND summary LIKE '%".$term."%'";
			break;
			case 3:
				$serach .=" AND author_name LIKE '".$term."'";
			break;
			default:
				$serach .=" AND title LIKE '%".$term."%'";
			break;
		} 
		$serach .=" AND content_type ='".$type."'";
		if(IS_MEMCACHE){
			$CacheID = 'SEARCH1-'.$term;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query("SELECT article.content_id , article.title , article.url , article.summary ,  article.section_id , article.content_type  , article.published_date , article.image_path , article.image_alt  , article.image_caption , article.author_name FROM ".$this->contenttbl." AS article WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$serach." ORDER BY article.last_updated_on DESC LIMIT ".$row ." ,".$limit ."" )->result_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $this->db->query("SELECT article.content_id , article.title , article.url , article.summary ,  article.section_id , article.content_type  , article.published_date , article.image_path , article.image_alt  , article.image_caption , article.author_name FROM ".$this->contenttbl." AS article WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) ".$serach." ".$serach." ORDER BY article.last_updated_on DESC LIMIT ".$row ." ,".$limit ."")->result_array();
		}
	}
}
?>