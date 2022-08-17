<?php
class newsletter extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$CI = &get_instance();
		$this->live_db = $CI->load->database('live_db',TRUE);
	}
	
	public function index(){
		
		if($this->input->get('type')=='1' || $this->input->get('type')==''){
			$tablename = 'article';
		}else if($this->input->get('type')=='2'){
			$tablename = 'gallery';
		}else if($this->input->get('type')=='3'){
			$tablename = 'video';
		}
		$search="";
		$query = $this->input->get('query');
		if($query!=''){
			if(is_numeric($query)){
				$search =" AND content_id='".trim($query)."'";
			}else{
				$search =" AND title LIKE '%".trim($query)."%'";
			}
		}
		$data['articles'] = $this->live_db->query("SELECT content_id , title FROM ".$tablename." where status='p' AND publish_start_date < NOW() ".$search." ORDER BY publish_start_date DESC LIMIT 100")->result();
		$data['template'] = 'newsletter_view';
		$this->load->view('admin_template',$data);
	}
	
	public function add_article(){
		$id = $this->input->post('id');
		$content_type = $this->input->post('content_type');
		$title = $this->input->post('title');
		$summary = $this->input->post('summary');
		$ctitle = $csummary ='';
		$checkcount = $this->db->query("SELECT nid FROM newsletter_template")->num_rows();
		if($checkcount <5){
			$response = $this->db->query("SELECT nid FROM newsletter_template WHERE content_id='".$id."' AND content_type='".$content_type."'");
			if($response->num_rows() > 0){
				echo 2;
			}else{
				if($content_type=='1'){
				$type='article';
				}else if($content_type=='2'){
					$type='gallery';
				}else if($content_type=='3'){
					$type='video';
				}
				$details = $this->live_db->query("SELECT title,summary_html FROM ".$type." WHERE  content_id='".$id."' AND status='P'");
				if($details->num_rows > 0){
					$res = $details->result();
					$dbtitle = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$res[0]->title));
					$dbtitle = htmlspecialchars_decode($dbtitle, ENT_QUOTES);
					$dbsummary = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$res[0]->summary_html));
					$dbsummary = htmlspecialchars_decode($dbsummary, ENT_QUOTES);
					if($title!=$dbtitle){
						$ctitle = $title;
					}
					if($summary!=$dbsummary){
						$csummary = $summary;
					}
				}
				$data = array('content_id' =>$id , 'content_type'=>	$content_type ,'created_by'=>USERID ,'custom_title'=>$ctitle ,'custom_summary'=>$csummary);
				$currentdate = date('Y-m-d');
				$folderpath = FCPATH.APPPATH.'views/newsletter_logs/'.$currentdate.'.json';
				if(file_exists($folderpath)){
					$json = json_decode(file_get_contents($folderpath),TRUE);
					$json[count($json )] = array('content_id' => $id ,'created_on'=>date('Y-m-d H:i:s') , 'created_by'=>USERID);
				}else{
					$json[0]=array('content_id' => $id ,'created_on'=>date('Y-m-d H:i:s') , 'created_by'=>USERID);
					
				}
				file_put_contents($folderpath ,json_encode($json));
				echo $this->db->insert('newsletter_template' , $data);
			}
		}else{
			echo 3;
		}
		
	}
	public function load_table(){
		$list= $this->db->query("SELECT nid , content_id , content_type ,custom_title FROM newsletter_template")->result();
		$template='';
		foreach($list as $temp){
			$template .='<tr>';
			if($temp->content_type=='1'){
				$type='article';
			}else if($temp->content_type=='2'){
				$type='gallery';
			}else if($temp->content_type=='3'){
				$type='video';
			}
			$article = $this->live_db->query("SELECT  title  FROM ".$type." WHERE content_id='".$temp->content_id."'")->result();
			$template .='<td>'.$type.'</td>';
			$template .='<td>'.$temp->content_id.'</td>';
			if($temp->custom_title!=''){
				$template .='<td>'.strip_tags($temp->custom_title).'</td>';
			}else{
				$template .='<td>'.strip_tags($article[0]->title).'</td>';
			}
			$template .='<td class="text-center"><button onclick="edit_article('.$temp->nid.')" class="btn btn-primary btn-custom"><i class="fa fa-pencil" aria-hidden="true"></i></button><button onclick="remove_article('.$temp->nid.')" class="btn btn-primary btn-custom"><i class="fa fa-trash" aria-hidden="true"></i></button></td>';
			$template .='</tr>';
		}
		if(count($list)==0){
			$template .='<tr><td class="text-center" colspan="4">No records found</td></tr>';
		}
		echo $template;
	}
	
	public function remove_article(){
		$nid = $this->input->post('nid');
		$this->db->where('nid',$nid);
		echo $this->db->delete('newsletter_template');
	}
	
	public function preview($options=''){
		if($options==1){ $filename='newsletter-'.date('d-m-Y-h:i:s').'.html'; }
		$data['list']= $this->db->query("SELECT nid , content_id , content_type ,custom_title ,custom_summary FROM newsletter_template LIMIT 5")->result();
		$data['record'] =array();
		foreach($data['list'] as $temp){
			if($temp->content_type=='1'){
				$type='article';
				$img = 'article_page_image_path';
			}else if($temp->content_type=='2'){
				$type='gallery';
				$img = 'first_image_path';
			}else if($temp->content_type=='3'){
				$type='video';
				$img = 'video_image_path';
			}
			$response = $this->live_db->query("SELECT title,section_name,url,summary_html,".$img." as image FROM ".$type." WHERE  content_id='".$temp->content_id."' AND status='P' AND publish_start_date < NOW()");
			if($response->num_rows() > 0){
				$result= $response->result();
				if($temp->custom_title!=''){
					$title = $temp->custom_title;
				}else{
					$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->title);
				}
				if($temp->custom_summary!=''){
					$summary = $temp->custom_summary;
				}else{
					$summary = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->summary_html);
				}
				$data['record'][] = array('title'=>$title, 'section'=>$result[0]->section_name , 'summary'=>$summary,'image'=>$result[0]->image ,'url'=>$result[0]->url);
			}
		}
		$this->load->view('admin/newsletter_preview' ,$data);
		
		if($options==1){
			header("Content-type: application/octet-stream");
        	header("Content-Disposition: filename=\"".$filename."\"");
		}

	}
	
	public function article_details(){
		$response =[];
		$response['response'] =0;
		$contentID = $this->input->post('id');
		$type = $this->input->post('content_type');
		if($type=='1'){
				$tbl='article';
		}else if($type=='2'){
				$tbl='gallery';
		}else if($type=='3'){
				$tbl='video';
		}
		$details = $this->live_db->query("SELECT title ,summary_html FROM ".$tbl." WHERE content_id='".$contentID."'");
		if($details->num_rows() > 0){
			$result = $details->result();
			$response['response'] =1;
			$title = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->title));
			$title = htmlspecialchars_decode($title, ENT_QUOTES);
			$summary = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->summary_html));
			$summary = htmlspecialchars_decode($summary, ENT_QUOTES);
			$response['title'] =$title;
			$response['summary'] =$summary;
		}
		
	echo json_encode($response);		
		
	}
	
	public function edit_article(){
		$response =[];
		$response['response'] =0;
		$nid = $this->input->post('nid');
		$templateDetails = $this->db->query("SELECT content_id ,
		CASE
			WHEN content_type = 1 THEN 'article'
			WHEN content_type = 2 THEN 'gallery'
			WHEN content_type = 3 THEN 'video'
			ELSE 'article'
		END  as type , custom_title , custom_summary FROM newsletter_template WHERE nid='".$nid."'")->result();
		$details = $this->live_db->query("SELECT title ,summary_html FROM ".$templateDetails[0]->type." WHERE content_id='".$templateDetails[0]->content_id."'");
		if($details->num_rows() > 0){
			$response['response'] =1;
			$result = $details->result();
			$title = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->title));
			$title = htmlspecialchars_decode($title, ENT_QUOTES);
			$summary = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->summary_html));
			$summary = htmlspecialchars_decode($summary, ENT_QUOTES);
			if($templateDetails[0]->custom_title!=''){
				$title = $templateDetails[0]->custom_title;
			}
			if($templateDetails[0]->custom_summary!=''){
				$summary = $templateDetails[0]->custom_summary;
			}
			$response['title'] =$title;
			$response['summary'] =$summary;
			$response['type'] =$templateDetails[0]->type;
			$response['content_id'] =$templateDetails[0]->content_id;
		}
		echo json_encode($response);
	}
	
	public function edit_publish_article(){
		$nid = $this->input->post('nid');
		$title = $this->input->post('title');
		$summary = $this->input->post('summary');
		$type = $this->input->post('type');
		$cid = $this->input->post('cid');
		$stitle = $ssummary ='';
		$result = $this->live_db->query("SELECT title ,summary_html FROM ".$type." WHERE content_id='".$cid."'")->result();
		$dbtitle = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->title));
		$dbtitle = htmlspecialchars_decode($dbtitle, ENT_QUOTES);
		$dbsummary = html_entity_decode(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$result[0]->summary_html));
		$dbsummary = htmlspecialchars_decode($dbsummary, ENT_QUOTES);
		if($title!=$dbtitle){
			$stitle  = $title;
		}
		if($summary!=$dbsummary){
			$ssummary  = $summary;
		}
		$data = array('custom_title'=>$stitle , 'custom_summary'=>$ssummary);
		$this->db->where('nid' , $nid);
		echo $this->db->update('newsletter_template' ,$data);
	}
} 
?> 