<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Merchantmodel extends CI_Model{
	private $tbl = 'aff_merchants';
	private $producttbl = 'aff_products';
	private $userstbl = 'aff_users';

	public function __construct(){
		parent::__construct();
	}
	public function getMerchantCount($search){
		return $this->db->query("SELECT product.pid FROM ".$this->tbl." AS merchant INNER JOIN ".$this->userstbl." AS user ON  merchant.modified_by = user.uid INNER JOIN ".$this->producttbl." AS product ON product.pid = merchant.pid  WHERE ".$search."")->num_rows();
	}
	
	public function getMerchants($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT merchant.mid , merchant.merchant_name , merchant.merchant_url , merchant.merchant_price , merchant.merchant_status , DATE_FORMAT(merchant.modified_on, '%D %b %Y %h:%i:%s %p') as modified_on , product.product_name , user.username FROM ".$this->tbl." AS merchant INNER JOIN ".$this->userstbl." AS user ON  merchant.modified_by = user.uid INNER JOIN ".$this->producttbl." AS product ON product.pid = merchant.pid  WHERE ".$search." ".$orderBy." LIMIT ".$row ." , ".$perPage."")->result();
	}
}
?>