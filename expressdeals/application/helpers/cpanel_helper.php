<?php
if(!function_exists('get_menu')){
	
	function get_menu(){
		$CI = &get_instance();
		return $CI->db->query('SELECT mid , menu_name , parent_id , menu_description , menu_link FROM aff_menus WHERE status=1 ORDER BY order_by ASC')->result();
	}
}

if(!function_exists('get_submenu')){
	
	function get_submenu($menuid , $menus){
		$template ='';
		$CI = &get_instance();
		foreach($menus as $menu){
			if($menu->parent_id == $menuid){
				$template .='<li><a class="'.(($menu->menu_link==$CI->uri->segment(2).'/'.$CI->uri->segment(3)) ? 'active' : '').'" href="'.base_url(ADMINFOLDER.$menu->menu_link).'">'.$menu->menu_name.'</a></li>';
			}
		}
		if($template!=''){
			$template ='<ul>'.$template.'</ul>';
		}
		return $template;
	}
}

if(!function_exists('menucheck')){
	
	function menucheck($menuid , $roles){
		$response['view'] = $response['add'] = $response['edit'] = $response['delete'] = 0;
		for($i=0;$i<count($roles);$i++){
			if($roles[$i]['id'] == $menuid){
				$response['view'] = $roles[$i]['view'];
				$response['add'] = $roles[$i]['add'];
				$response['edit'] = $roles[$i]['edit'];
				$response['delete'] = $roles[$i]['delete'];
			}
		}
		return $response;
	}
}


if(!function_exists('validate_menu')){
	
	function validate_menu($menuname , $type='VIEW' , $return =0){
		$CI = &get_instance();
		$menu =  $CI->db->query('SELECT mid FROM aff_menus WHERE status=1 AND menu_name="'.$menuname.'"')->row_array();
		if($return==1){
			return $menu;
		}
		if(count($menu) > 0){
			if(constant('MENU'.$type.'_'.$menu['mid'])!=1){
				redirect(ADMINFOLDER.'denied/'.$menuname);
				exit;
			}
		}else{
			redirect(ADMINFOLDER.'denied/'.$menuname);
			exit;
		}
	}
}

if(!function_exists('custom_pagination')){
	
	function custom_pagination($parameter){
		$config = [];
		$config['base_url'] = $parameter[0];
		$config['total_rows'] = $parameter[1];
		$config['per_page'] = $parameter[2];
		$config['num_links'] = 5;
		$config['use_page_numbers'] = FALSE;
		$config['page_query_string'] = TRUE;
		$config['suffix'] = $parameter[3];
		$config['num_tag_open'] = $config['next_tag_open'] = $config['last_tag_open'] = $config['first_tag_open'] = $config['prev_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = $config['next_tag_close'] = $config['last_tag_close'] = $config['first_tag_close'] = $config['prev_tag_close'] ='</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a>';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
		$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-center">';
		$config['full_tag_close'] = '</ul>';
		return $config;
	}
}

if(!function_exists('section_dropdown')){
	$dropdown = '';
	function section_dropdown($section ,  $r = 0, $p = null){
		foreach ($section as $i => $t) {
			$dash = ($t->parent_id == null) ? '' : str_repeat('-', $r) .' ';
			if(isset($t->article_hosting) && $t->article_hosting==0){
				printf("\t<option disabled value='%d'>%s%s</option>\n", $t->sid, $dash, $t->section_name);
			}else{
				printf("\t<option value='%d'>%s%s</option>\n", $t->sid, $dash, $t->section_name);
			}
			if ($t->parent_id == $p){
				$r = 0;
			}
			if (isset($t->_children)){
				section_dropdown($t->_children, ++$r, $t->parent_id);
			}
		}
	}
}

if(!function_exists('section_dropdown_template')){
	$dropdown = '';
	function section_dropdown_template($section , $current='' ,  $r = 0, $p = null){
		foreach ($section as $i => $t) {
			$dash = ($t->parent_id == null) ? '' : str_repeat('-', $r) .' ';
			if(isset($t->article_hosting) && $t->article_hosting==0){
				printf("\t<option ".(($current==$t->sid)? ' selected ' :'' )." disabled value='%d'>%s%s</option>\n", $t->sid, $dash, $t->section_name);
			}else{
				printf("\t<option ".(($current==$t->sid)? ' selected ' :'' )." value='%d'>%s%s</option>\n", $t->sid, $dash, $t->section_name);
			}
			if ($t->parent_id == $p){
				$r = 0;
			}
			if (isset($t->_children)){
				section_dropdown_template($t->_children, $current , ++$r, $t->parent_id);
			}
		}
	}
}

if(!function_exists('article_section_dropdown')){
	$dropdown = '';
	function article_section_dropdown($type=1 ,$section , $current=0, $r = 0, $p = null){
		foreach ($section as $i => $t) {
			$dash = ($t->parent_id == null) ? '' : str_repeat('-', $r) .' ';
			if($t->section_type==$type):
				if(isset($t->article_hosting) && $t->article_hosting==0){
					printf("\t<option ".(($current==$t->sid) ? ' selected ' : '')." disabled value='%d'>%s%s</option>\n", $t->sid, $dash, $t->section_name);
				}else{
					printf("\t<option ".(($current==$t->sid) ? ' selected ' : '')." value='%d'>%s%s</option>\n", $t->sid, $dash, $t->section_name);
				}
			endif;
			if ($t->parent_id == $p){
				$r = 0;
			}
			if (isset($t->_children)){
				article_section_dropdown($type , $t->_children, $current , ++$r, $t->parent_id);
			}
		}
	}
}

if(!function_exists('template_section')){
	$dropdown = '';
	function template_section($section ,$r = 0, $p = null){
		foreach ($section as $i => $t) {
			$dash = ($t->parent_id == null) ? '' : str_repeat('-', $r) .' ';
			printf('<a href="#" data-sid="%d" class="list-group-item template-list">%s%s</a>', $t->sid, $dash, $t->section_name);
			if ($t->parent_id == $p){
				$r = 0;
			}
			if (isset($t->_children)){
				template_section($t->_children, ++$r, $t->parent_id);
			}
		}
	}
}


if(!function_exists('section_dropdown_option')){
	$dropdown = '';
	function section_dropdown_option($section , $current ,$sectionarray , $r = 0, $p = null,$type=1){
		foreach ($section as $i => $t) {
			$dash = ($t->parent_id == null) ? '' : str_repeat('-', $r) .' ';
			if(isset($t->article_hosting) && $t->article_hosting==1 && $t->section_type==$type){
				printf("\t<tr><td><div class='custom-control custom-checkbox'>   <input ".(($current==$t->sid)? ' disabled ' :'')." type='checkbox' value='%d' class='custom-control-input multi-map' id='map_section".$t->sid."' name='map_list[]' ".((in_array($t->sid, $sectionarray))? ' checked ' :'')."><label class='custom-control-label' for='map_section".$t->sid."'></label></div></td><td>%s%s</td></tr>\n" ,$t->sid, $dash, $t->section_name);
			}
			if ($t->parent_id == $p){
				$r = 0;
			}
			if (isset($t->_children)){
				section_dropdown_option($t->_children, $current , $sectionarray ,++$r, $t->parent_id ,$type);
			}
		}
	}
}

if(!function_exists('buildTree')){
	function buildTree(Array $data, $parent = 0) {
		$tree = array();
		foreach ($data as $d) {
			if ($d->parent_id == $parent) {
				$children = buildTree($data, $d->sid);
				if (!empty($children)) {
					$d->_children = $children;
				}
				$tree[] = $d;
			}
		}
		return $tree;
	}
}

if(!function_exists('get_parentsection')){
	function get_parentsection($id ,$data) {
		$name = '';
		foreach ($data as $d) {
			if($id==$d->sid){
				$name = $d->section_name;	
			}
		}
		return $name;
	}
}


if(!function_exists('arrange_menu_check')){
	function arrange_menu_check($data , $id){
		foreach($data as $section):
			if($section->parent_id == $id){
				 return true;
			}
		endforeach;
		return false;
	}
}
if(!function_exists('arrange_menu')){
	function arrange_menu($data , $id=null) {
		echo '<ol class="dd-list">';
		foreach($data as $section):
			if ($section->parent_id == $id){
				echo '<li class="dd-item" parent-id="'.$id.'" data-id="'.$section->sid.'">';
				echo '<div class="dd-handle bg-primary" style="text-align:left;">'.$section->section_name.'</div>';
				if(arrange_menu_check($data , $section->sid)){
					arrange_menu($data , $section->sid);
				}
				echo '</li>';
			}
		endforeach;
		echo '</ol>';
	}
}

if(!function_exists('imagefolderpath')){
	function imagefolderpath(){
		$year = date('Y');
		$month = date('m');
		$date = date('d');
		$folderlist = ['small/' ,'medium/' ,'large/' ,'exlarge/' ,'original/'];
		if(!is_dir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH)){
			mkdir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH);
			chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH ,0777);
		}
		if(!is_dir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/')){
			mkdir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/');
			chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/' ,0777);
		}
		if(!is_dir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/')){
			mkdir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/');
			chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/' ,0777);
		}
		if(!is_dir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/')){
			mkdir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/');
			chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/' ,0777);
		}
		if(!is_dir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/')){
			mkdir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/');
			chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/' ,0777);
		}
		if(!is_dir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/')){
			mkdir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/');
			chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/' ,0777);
		}
		for($i=0;$i<count($folderlist);$i++){
			if(!is_dir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/'.$folderlist[$i])){
				mkdir(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/'.$folderlist[$i]);
				chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$year.'/'.$month.'/'.$date.'/'.$folderlist[$i] ,0777);
			}
			$path[str_replace('/','',$folderlist[$i])] = $year.'/'.$month.'/'.$date.'/'.$folderlist[$i];
		}
		return $path;
	}
}

if(!function_exists('resize_image')){
	function resize_image($path , $filename){
		$sizes['small'] = [150 , 150];
		$sizes['medium'] = [600 , 300];
		$sizes['large'] = [900 , 450];
		$sizes['exlarge'] = [1200 , 800];
		$CI = &get_instance();
		$CI->load->library('image_lib');
		foreach($path as $key => $value){ 
			if($key!='original'){
				$config['image_library'] = 'gd2';
				$config['source_image'] = ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$path['original'].$filename;
				$config['new_image'] = ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$value.$filename;
				$config['create_thumb'] = false;
				$config['maintain_ratio'] = false;
				$config['width'] = $sizes[$key][0];
				$config['height']= $sizes[$key][1];
				$CI->image_lib->clear();
				$CI->image_lib->initialize($config);
				$CI->image_lib->resize();
				chmod(ASSETS_BASE_PATH.CONTENT_IMAGE_PATH.$value.$filename , 0777);
			}
		}
	}
}

if(!function_exists('modify_image')){
	function modify_image($data){
		$details =[];
		$details['id'] = null;
		$details['path'] = $details['caption'] = $details['alt'] = '';
		$imageID = $data['image_id'];
		if($imageID!=''){
			$CI = &get_instance();
			$imageDetails =  $CI->db->query('SELECT id , image_id , image_path , image_name , caption , alt , change_status FROM aff_temp_images WHERE id="'.$imageID.'"')->row_array();	
			if(count($imageDetails) > 0){
				if($imageDetails['change_status']==0){
					$image =  $CI->db->query('SELECT id , file_path FROM aff_images WHERE id="'.$imageDetails['image_id'].'"')->row_array();
					$details['id'] = $imageDetails['image_id'];
					$details['path'] = $image['file_path'];
					$details['caption'] = $data['image_caption'];
					$details['alt'] = $data['image_alt'];
					$originalPath = $imageDetails['image_path'];
					$smallPath = str_replace('image_' , 'image_small_' , $imageDetails['image_path']);
					$mediumPath = str_replace('image_' , 'image_medium_' , $imageDetails['image_path']);
					$largePath = str_replace('image_' , 'image_large_' , $imageDetails['image_path']);
					$exlargePath = str_replace('image_' , 'image_exlarge_' , $imageDetails['image_path']);
					unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$originalPath);
					unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath);
					unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath);
					unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath);
					unlink(ASSETS_BASE_PATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath);
					$CI->db->where('id' , $imageID);
					$CI->db->delete('aff_temp_images');
				}else{
					
				}
			}
		}
		return $details;
	}
}

if(!function_exists('authorDetails')){
	function authorDetails($data){
		$details =[];
		$details['id'] = null;
		$details['name'] = $details['path'] = $details['caption'] = $details['alt'] = '';
		$authorname = trim($data['author']);
		if($authorname!=''){
			$CI = &get_instance();
			$authorDetails =  $CI->db->query('SELECT aid , author_name , author_image , caption , alt  FROM aff_authors WHERE author_name="'.$authorname.'" ORDER BY aid ASC LIMIT 1')->row_array();
			if(count($authorDetails) > 0){
				$details['id'] = $authorDetails['aid'];
				$details['name'] = $authorDetails['author_name'];
				$details['path'] = $authorDetails['author_image'];
				$details['caption'] = $authorDetails['caption'];
				$details['alt'] = $authorDetails['alt'];
			}else{
				$details['name'] = $authorname;
				$created_by = $CI->session->userdata('uid');
				$CI->db->insert('aff_authors' , ['author_name' => $authorname , 'status' => 1 , 'created_by' => $created_by , 'modified_by' => $created_by , 'modified_on' => date('Y-m-d H:i:s')]);
				$details['id'] = $CI->db->insert_id();
			}
			
		}
		return $details;
	}
}

if(!function_exists('countryDetails')){
	function countryDetails($data){
		$details =[];
		$details['id'] = null;
		$details['name'] ='';
		if($data['country']!=''){
			$CI = &get_instance();
			$countryDetails = $CI->db->query('SELECT cid , name FROM aff_country WHERE cid="'.$data['country'].'"')->row_array();
			if(count($countryDetails) > 0){
				$details['id'] = $countryDetails['cid'];
				$details['name'] = $countryDetails['name'];
			}
		}
		return $details;
	}
}

if(!function_exists('stateDetails')){
	function stateDetails($data){
		$details =[];
		$details['id'] = null;
		$details['name'] ='';
		if($data['country']!=''){
			$CI = &get_instance();
			$stateDetails = $CI->db->query('SELECT sid , name FROM aff_states WHERE sid="'.$data['state'].'"')->row_array();
			if(count($stateDetails) > 0){
				$details['id'] = $stateDetails['sid'];
				$details['name'] = $stateDetails['name'];
			}
		}
		return $details;
	}
}

if(!function_exists('tags')){
	function tags($data){
		$details =[];
		$details['id'] = null;
		$details['tags'] ='';
		if($data['tags']!=''){
			$tags = explode(',' , $data['tags']);
			$CI = &get_instance();
			$idtemp = $nametemp = [];
			for($i=0;$i<count($tags);$i++){
				$tagDetails = $CI->db->query('SELECT tag_id , tag_name FROM aff_tags WHERE tag_name="'.trim($tags[$i]).'" ORDER BY tag_id ASC LIMIT 1')->row_array();
				if(count($tagDetails) > 0){
					array_push($idtemp , $tagDetails['tag_id']);
					array_push($nametemp , $tagDetails['tag_name']);
				}else{
					$created_by = $CI->session->userdata('uid');
					$CI->db->insert('aff_tags' , ['tag_name' => trim($tags[$i]) , 'status' => 1 , 'created_by' => $created_by , 'modified_by' => $created_by , 'modified_on' => date('Y-m-d H:i:s')]);
					array_push($idtemp , $CI->db->insert_id());
					array_push($nametemp , trim($tags[$i]));
				}				
			}
			
			if(count($idtemp) > 0){
				$details['id'] = implode(',' , $idtemp);
				$details['tags'] = implode(',' , $nametemp);
			}
		}
		return $details;
	}
}

if(!function_exists('shortDescription')){
	function shortDescription($fullDescription){
		$shortDescription = "";
		$fullDescription = htmlspecialchars_decode(trim(strip_tags($fullDescription)));
		$fullDescription = str_replace('&nbsp;', ' ', $fullDescription);
		if ($fullDescription){
			$initialCount = 35;
			if (mb_strlen($fullDescription) > $initialCount){
				 $shortDescription = mb_substr($fullDescription,0, $initialCount,'UTF-8')."...";
			}else{
				return $fullDescription;
			}
		}
		return $shortDescription;
	}
}

if(!function_exists('articleinfo')){
	function articleinfo($data){
		$info = '';
		$CI = &get_instance();
		$createdBy = $CI->db->select('username')->where('uid' , $data['created_by'])->get('aff_users')->row_array();
		$modifiedBy = $CI->db->select('username')->where('uid' , $data['modified_by'])->get('aff_users')->row_array();
		$createdOn = date('d-m-Y H:i:s' , strtotime($data['published_date']));
		$modifiedOn = date('d-m-Y H:i:s' , strtotime($data['last_updated_on']));
		$info .='Created By : '.$createdBy['username'].' | Created On :'.$createdOn.' | Modified By : '.$modifiedBy['username'].' | Modified On : '.$modifiedOn;
		return $info;
	}
}

if(!function_exists('blocks')){
	function blocks($id=''){
		$CI = &get_instance();
		if($id!=''){
			return $CI->db->select('bid , block_name , block_image ,content ,block_path')->where(['status' => 1 , 'bid' => $id])->get('aff_blocks')->row_array();
		}else{
			return $CI->db->select('bid , block_name , block_image  ,block_path')->where('status' ,1)->get('aff_blocks')->result_array();
		}
		
	}
}

if(!function_exists('approval_article')){
	function approval_article($id=''){
		$CI = &get_instance();
		return $CI->db->query("SELECT approval.title , DATE_FORMAT(approval.last_updated_on, '%D %b %Y %h:%i:%s %p') as modified_on , approval.image_path , approval.image_alt , approval.status , section.section_name , user.username FROM aff_content_approval AS approval INNER JOIN aff_users AS user ON  approval.modified_by = user.uid INNER JOIN aff_sections AS section ON approval.section_id = section.sid WHERE approval.content_id = '".$id."' ORDER BY approval.aid DESC LIMIT 1")->row_array();		
	}
}

if(!function_exists('SendMail')){
	function SendMail($emailAddress=[] , $data = []){
		$CI = &get_instance();
		$CI->load->library('phpmailer_lib');
		$mail = $CI->phpmailer_lib->load();
		//$mail->isSMTP();
		$mail->setFrom('pandiaraj.m@newindianexpress.com', 'Pandiaraj');
		$mail->Username = 'AKIAZKMLWP5PHL7OOS63';
		$mail->Password = 'BJiJLqooF0Q1qByXlQlIt/bgjVPaN4yEh2XB95i0J0wd';
		$mail->Host = 'email-smtp.us-west-2.amazonaws.com';
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		for($i=0;$i<count($emailAddress) ;$i++){
			$mail->addAddress($emailAddress[$i]);
		}
		$mail->isHTML(true);
		$mail->Subject = $data['subject'];
		$mail->Body = $data['body'];
		$mail->AltBody = $data['bodyalt'];
		$mail->send();
	}
}

if(!function_exists('getUsername')){
	
	function getUsername($id){
		$CI = &get_instance();
		$result = $CI->db->query("SELECT username FROM aff_users WHERE uid='".$id."'")->row_array();
		return $result['username'];
	}
}
?>