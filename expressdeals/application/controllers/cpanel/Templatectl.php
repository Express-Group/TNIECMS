<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Templatectl extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(ADMINFOLDER.'templatemodel');
	}
	
	public function index(){
		validate_menu('Page Template');
		$data['title'] = 'Template - ENPL';
		$data['template'] = 'template_view';
		$data['sections'] = $this->templatemodel->get_sections();
		$this->load->view(ADMINFOLDER.'common_view' , $data);
	}
	
	public function get_templates(){
		$response = [];
		$response['versions'] = '';
		$response['currenttemplate'] = [];
		$response['lockdetails'] = [];
		$sectionID = trim($this->input->post('sid'));
		$versions = $this->templatemodel->get_versions($sectionID);
		$tid =0;
		foreach($versions as $pages){
			if($pages->active_status==1){ 
				$tid = $pages->tid; 
				$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
				$response['lockdetails'] = $this->templatemodel->userDetails($response['currenttemplate']['locked_by']);
			}
			$response['versions'] .= '<option '.(($pages->active_status==1) ? ' selected ' : '').' value="'.$pages->tid.'">'.$pages->template_name.' '.(($pages->active_status==1) ? ' (active) ' : '').'</option>';
		}
		
		if($tid==0){
			$i =1;
			$response['versions']='';
			foreach($versions as $pages){
				if($i==count($versions)){
					$tid = $pages->tid; 
					$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
					$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
					$response['lockdetails'] = $this->templatemodel->userDetails($response['currenttemplate']['locked_by']);
				}
				$response['versions'] .= '<option '.(($i==count($versions)) ? ' selected ' : '').' value="'.$pages->tid.'">'.$pages->template_name.' '.(($pages->active_status==1) ? ' (active) ' : '').'</option>';
				$i++;
			}
		}
		echo json_encode($response);
		exit();
	}
	
	public function get_version_templates(){
		$response = [];
		$response['versions'] = '';
		$response['currenttemplate'] = [];
		$response['lockdetails'] = [];
		$sectionID = trim($this->input->post('sid'));
		$tid = trim($this->input->post('tid'));
		$versions = $this->templatemodel->get_versions($sectionID);	
		$response['versions']='';
		foreach($versions as $pages){
			if($tid == $pages->tid){
				$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
				$response['lockdetails'] = $this->templatemodel->userDetails($response['currenttemplate']['locked_by']);
			}
			$response['versions'] .= '<option '.(($tid==$pages->tid) ? ' selected ' : '').' value="'.$pages->tid.'">'.$pages->template_name.' '.(($pages->active_status==1) ? ' (active) ' : '').'</option>';
		}
		echo json_encode($response);
		exit();
	}
	
	public function add_templates(){
		$sectionID = trim($this->input->post('sid'));
		$type = trim($this->input->post('type'));
		$templateName  = 'template '.$this->templatemodel->maxvalue($sectionID);
		$data = [];
		$template = [];
		$template['type'] = $type;
		$template['template'] =[];
		$data['section_id'] = $sectionID;
		$data['template_name'] = $templateName;
		$data['status'] = 1;
		$data['active_status'] = 0;
		$data['locked_by'] = $this->session->userdata('uid');
		$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['template'] = json_encode($template);
		$result = $this->templatemodel->insertTemplate($data);
		$response = [];
		$response['versions'] = '';
		$response['currenttemplate'] = [];
		$versions = $this->templatemodel->get_versions($sectionID);
		foreach($versions as $pages){
			$response['versions'] .= '<option '.(($result==$pages->tid) ? ' selected ' : '').' value="'.$pages->tid.'">'.$pages->template_name.' '.(($pages->active_status==1) ? ' (active) ' : '').'</option>';
		}
		$response['currenttemplate'] = $this->templatemodel->get_pageparam($result);
		$response['lockdetails'] = $this->templatemodel->userDetails($this->session->userdata('uid'));
		echo json_encode($response);
		exit();
	}
	
	public function get_block(){
		$bid = $this->input->post('bid');
		echo json_encode(blocks($bid));
		exit();
	}
	
	public function update_template(){
		$response['status'] = 0;
		$tid = $this->input->post('tid');
		$type = $this->input->post('type');
		$json = $this->input->post('json');
		$template = [];
		$template['type'] = $type;
		$template['template'] =$json;
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->session->userdata('uid');
		$data['template'] = json_encode($template);
		$data['update_status'] = 0;
		$response['status'] = $this->templatemodel->updateTemplate($data , $tid);
		//$response['active_status'] = $data['active_status'];
		$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
		$response['lockdetails'] = $this->templatemodel->userDetails($response['currenttemplate']['locked_by']);
		echo json_encode($response);
		exit();
	}
	
	public function block_config(){
		$data['controller'] = $this;
		$data['title'] = $this->input->post('title');
		$data['slots'] = $this->input->post('slots');
		$data['id'] = $this->input->post('id');
		$data['json'] = stripslashes($this->input->post('json'));
		$data['blockDetails']= [];
		if($data['json']!='' && $data['json']!='undefined'){
			$json = iconv('UTF-8', 'utf-8//TRANSLIT', base64_decode($data['json']));
			$json = json_decode($json , true);
			if(count($json) > 0){
				$data['blockDetails'] = $json;
				if(isset($json['section']) && $json['section']!=''){
					$currentSection = $this->templatemodel->get_sections($json['section']);
					if(count($currentSection) > 0){
						$data['SectionDetails'] =  '<option value="'.$json['section'].'">'.$currentSection['section_name'].'</option>';
					}
						
				}
			}
		}
		$data['src'] = $this->input->post('src');
		$data['type'] = $this->input->post('type');
		$data['timestamp'] = $this->input->post('timestamp');
		$data['sections'] = $this->templatemodel->get_sections();
		$response['content'] = $this->load->view(ADMINFOLDER.'blockconfig_view' , $data , TRUE);
		echo json_encode($response);
		exit();
	}
	
	public function get_particular_section(){
		$res ='';
		$id = $this->input->post('id');
		$sections = $this->templatemodel->get_sections();
		if($id!=0){
			$currentSection = $this->templatemodel->get_sections($id);
			if(count($currentSection) > 0){
				echo '<option>Please select any one</option><option value="'.$id.'">'.$currentSection['section_name'].'</option>';
			}
			echo section_dropdown(buildTree($sections , $id));
		}else{
			echo '<option>Please select any one</option>';
			echo section_dropdown(buildTree($sections ));
		}
		
		exit();
	}
	
	public function selected_content($list){
		return $this->templatemodel->selectedContent($list);
	}
	
	public function get_content($sid=0 , $listed=[] ,$type = 0){
		$search =" article.status=1";
		if($type==1){
			$id = $sid; 
			$list = $listed;
		}else{
			$id = $this->input->post('id');
			$list = $this->input->post('list');
		}
		if($id!=0){
			$currentSection = $this->templatemodel->get_sections($id);
			$search .=" AND article.content_type= '".$currentSection['section_type']."'";
			$sectionQuery = "select sid from(select * from aff_sections order by parent_id, sid) aff_sections, (select @pv := '".$id."') initialisation where find_in_set(parent_id, @pv) > 0 AND status=1 and @pv := concat(@pv, ',', sid)";
			$search .=" AND (mapping.section_id IN (".$sectionQuery.") OR mapping.section_id='".$id."' OR article.section_id='".$id."' )";
		}
		$result = $this->templatemodel->getContent($search);
		$template = "<table class='table'>";
		$template .='<thead>';
		$template .='<tr>';
		$template .='<th>ID</th><th>TITLE</th><th>CONTENT TYPE</th><th>IMAGE</th><th>ACTION</th>';
		$template .='</tr>';
		$template .='</thead>';
		$template .='<tbody>';
		foreach($result as $article){
			$template .='<tr '.((in_array($article->content_id , $list))? ' style="display:none;"' : '').' class="content-list-'.$article->content_id.'" data-type="'.$article->content_type.'" data-id="'.$article->content_id.'">';
			$template .='<td>'.$article->content_id.'</td>';
			$template .='<td>'.shortDescription(strip_tags($article->title)).'</td>';
			$template .='<td>';
			if($article->content_type=='1'){
			 $template .='ARTICLE';
			}
			if($article->content_type=='2'){
			 $template .='GALLERY';
			}
			if($article->content_type=='2'){
			 $template .='VIDEO';
			}
			$template .='</td><td class="text-center">';
			if($article->image_path!=''){
				$template .='<img style="width: 65px;border-radius:5px;"  src="'.ASSETURL.IMAGE_PATH.str_replace('original/' ,'medium/' ,$article->image_path).'">';
			}else{
				$template .='-';
			}
			$template .='</td>';
			$template .='<td><button onclick="add_template_articles('.$article->content_id.')" style="padding: 6px 8px;" class="btn btn-primary">ADD</button></td>';
			$template .='</tr>';
		}
		$template .='</tbody>';
		$template .= "</table>";
		echo $template;
	}
	
	public function lock_template(){
		$response = [];
		$response['versions'] = '';
		$response['currenttemplate'] = [];
		$response['lockdetails']=[];
		$sectionID = trim($this->input->post('sid'));
		$tid = trim($this->input->post('tid'));
		$response['lock_status'] = $this->templatemodel->lockStatus($tid);	
		if($response['lock_status'][0]==1){
			$versions = $this->templatemodel->get_versions($sectionID);	
			$response['versions']='';
			foreach($versions as $pages){
				if($tid == $pages->tid){ 
					$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
					$response['lockdetails'] = $this->templatemodel->userDetails($response['currenttemplate']['locked_by']);
				}
				$response['versions'] .= '<option '.(($tid==$pages->tid) ? ' selected ' : '').' value="'.$pages->tid.'">'.$pages->template_name.' '.(($pages->active_status==1) ? ' (active) ' : '').'</option>';
			}
		}
		echo json_encode($response);
		exit();
	}
	
	public function unlock_template(){
		$response = [];
		$response['currenttemplate']= [];
		$response['lockdetails']= [];
		$sectionID = trim($this->input->post('sid'));
		$tid = trim($this->input->post('tid'));
		$response['status'] =  $this->templatemodel->unlockTemplate($tid);
		$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
		$response['lockdetails'] = $this->templatemodel->userDetails($response['currenttemplate']['locked_by']);
		echo json_encode($response);
		exit();
	}
	
	public function publish_template(){
		$response = [];
		$response['currenttemplate']= [];
		$response['lockdetails']= [];
		$response['versions']= '';
		$response['status']= $response['template_status'] = 1;
		$sectionID = trim($this->input->post('sid'));
		$tid = trim($this->input->post('tid'));
		$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
		if($sectionID ==20000 || $sectionID==20001){
			$response['status'] = 1;
		}else{
			$response['status'] = $this->templatemodel->updateSection($sectionID , $response['currenttemplate']['template']);	
		}
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->session->userdata('uid');
		$data['published_template'] = $response['currenttemplate']['template'];
		$data['locked_by'] = null;
		$data['active_status'] = $data['update_status'] = 1;
		$this->templatemodel->updatesectionTemplate($sectionID);
		$response['template_status'] = $this->templatemodel->updateTemplate($data , $tid);
		$versions = $this->templatemodel->get_versions($sectionID);
		foreach($versions as $pages){
			if($pages->active_status==1){ 
				$tid = $pages->tid;
				$response['currenttemplate'] = $this->templatemodel->get_pageparam($tid);
				$response['lockdetails'] = $this->templatemodel->userDetails($response['currenttemplate']['locked_by']);
			}
			$response['versions'] .= '<option '.(($pages->active_status==1) ? ' selected ' : '').' value="'.$pages->tid.'">'.$pages->template_name.' '.(($pages->active_status==1) ? ' (active) ' : '').'</option>';
		}
		echo json_encode($response);
		exit();
	} 
	
	
}
?>