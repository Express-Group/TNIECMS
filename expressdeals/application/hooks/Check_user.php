<?php class Check_user{
	public function IsLogged(){
		$CI = &get_instance();
		$userID = $CI->session->userdata('uid');
		$userData = $CI->session->userdata('userdata');
		$urlPath = $CI->uri->segment(1).'/';
		if(($urlPath==ADMINFOLDER) && ($CI->uri->total_segments() > 1) && $CI->uri->segment(2)!='login'):
			if($userID=='' && !is_array($userData) && count($userData)==0){
				redirect(ADMINFOLDER);
				exit;
			}
			$roles = json_decode($userData['roles'] , true);
			for($i=0;$i<count($roles);$i++){
				defined('MENUVIEW_'.$roles[$i]['id']) OR define('MENUVIEW_'.$roles[$i]['id'] ,$roles[$i]['view']);
				defined('MENUADD_'.$roles[$i]['id']) OR define('MENUADD_'.$roles[$i]['id'] ,$roles[$i]['add']);
				defined('MENUEDIT_'.$roles[$i]['id']) OR define('MENUEDIT_'.$roles[$i]['id'] ,$roles[$i]['edit']);
				defined('MENUDELETE_'.$roles[$i]['id']) OR define('MENUDELETE_'.$roles[$i]['id'] ,$roles[$i]['delete']);
			}
		endif;
	}
}?>