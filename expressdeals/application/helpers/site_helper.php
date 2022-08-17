<?php
if(!function_exists('has_childmenu')){
	function has_childmenu($menus,$sid){
		foreach ($menus as $menu) {
			if($menu['parent_id'] == $sid)
				return true;
		}
		return false;
	}
}

if(!function_exists('site_menu')){
	function site_menu($menus,$parent=0 ,$r = 0 ,$rss=0){
		$result = "<ul>";
		foreach ($menus as $menu){
			if($menu['rss_status']==1):
			if($menu['parent_id'] == $parent){
				if(strtolower($menu['section_name'])=='home'){
					$menu['section_name'] = '<i class="fa fa-home" aria-hidden="true"></i>';
					$menu['section_full_path'] = '';
				}
				if($rss==1){
					if(strtolower($menu['section_name'])!='<i class="fa fa-home" aria-hidden="true"></i>'){
						$result.= "<li><i class=\"fa fa-rss-square\"></i> <a href='".base_url('rssfeed?section='.$menu['sid'])."'>{$menu['section_name']}</a>";	
					}
				}else{
				$result.= "<li><a href='".base_url($menu['section_full_path'])."'>{$menu['section_name']}</a>";	
				}
				if(has_childmenu($menus,$menu['sid'])){
					$result.= site_menu($menus,$menu['sid']);
				}
				$result.= "</li>";
				if($menu['parent_id']==null){ ++$r;}
				if($r==10){ break; }
			}
			endif;
		}
		$result.= "</ul>";
		return $result;
	}
	
}

if(!function_exists('hasImage')){
	function hasImage($imagepath ,$type="CONTENT"){
		$response = ['width' => 0 , 'height' => 0 ,'status' => 0];
		switch($type){
			case 'CONTENT' :
			if($imagepath!=''){
				if(getimagesize(ASSETURLNS.IMAGE_PATH.$imagepath)){
					list($width, $height) = getimagesize(ASSETURLNS.IMAGE_PATH.$imagepath);
					$response = ['width' => $width , 'height' => $height ,'status' => 1];
				}
			}
			break;
		}
		return $response;
	}
}

if(!function_exists('merchantDetails')){
	function merchantDetails($pid){
		$template = '';
		$CI = &get_instance();
		$merchantDetails = $CI->db->query("SELECT merchant_name , merchant_url , merchant_price FROM aff_merchants WHERE merchant_status=1 AND pid='".$pid."'")->result_array();
		foreach($merchantDetails as $merchant){
			$template .='<a target="_BLANK" href="'.$merchant['merchant_url'].'" class="btn btn-primary">'.$merchant['merchant_price'].' from '.$merchant['merchant_name'].'</a>';
		}
		return $template;
	}
}
?> 