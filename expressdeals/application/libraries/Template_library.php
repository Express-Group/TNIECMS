<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Template_library
{
    private $CI;
    public function __construct(){
        $this->CI = &get_instance();
    }
	
	public function form_template($json , $data){
		$html ='';
		$type = $json['type'];
		$template = $json['template'];
		switch($type){
			case '3':
				if(isset($template[0]) && count($template[0]) > 0){
					$blocks = $template[0];
					$html .='<section class="section">';
					$html .='<div class="container">';
					for($i=0;$i<count($blocks);$i++){
						$rawData = json_decode(base64_decode($blocks[$i]['rawdata']) ,true);
						$html .= $this->CI->load->view(BLOCKPATH.$blocks[$i]['path'] , [ 'rawData' => $rawData ,  'json' => $json ,'data' => $data] ,true);
					}
					$html .='</div>';
					$html .='</section>';
				}
			break;
			case '3,2-1,3':
				if(isset($template[0]) && count($template[0]) > 0){
					$blocks = $template[0];
					$html .='<section class="section">';
					$html .='<div class="container">';
					for($i=0;$i<count($blocks);$i++){
						$rawData = json_decode(base64_decode($blocks[$i]['rawdata']) ,true);
						$html .= $this->CI->load->view(BLOCKPATH.$blocks[$i]['path'] , [ 'rawData' => $rawData ,  'json' => $json ,'data' => $data] ,true);
					}
					$html .='</div>';
					$html .='</section>';
				}
				if(isset($template[1]) && count($template[1]) > 0){
					$blocks = $template[1];
					$html .='<section class="section">';
					$html .='<div class="container">';
					$html .='<div class="row">';
					$html .='<div class="col-md-9 col-lg-9 col-xl-9 col-sm-12 col-12">';
					for($i=0;$i<count($blocks);$i++){
						$rawData = json_decode(base64_decode($blocks[$i]['rawdata']) ,true);
						$html .= $this->CI->load->view(BLOCKPATH.$blocks[$i]['path'] , [ 'rawData' => $rawData ,  'json' => $json ,'data' => $data] ,true);
					}
					$html .='</div>';
					if(isset($template[2]) && count($template[2]) > 0){
						$blocks = $template[2];	
						$html .='<div class="col-md-3 col-lg-3 col-xl-3 col-sm-12 col-12">';
						for($i=0;$i<count($blocks);$i++){
							$rawData = json_decode(base64_decode($blocks[$i]['rawdata']) ,true);
							$html .= $this->CI->load->view(BLOCKPATH.$blocks[$i]['path'] , [ 'rawData' => $rawData ,  'json' => $json ,'data' => $data] ,true);
						}
						$html .='</div>';
					}
					$html .='</div>';
					
					$html .='</div>';
					$html .='</section>';
				}
				if(isset($template[3]) && count($template[3]) > 0){
					$blocks = $template[3];
					$html .='<section class="section">';
					$html .='<div class="container">';
					for($i=0;$i<count($blocks);$i++){
						$rawData = json_decode(base64_decode($blocks[$i]['rawdata']) ,true);
						$html .= $this->CI->load->view(BLOCKPATH.$blocks[$i]['path'] , [ 'rawData' => $rawData ,  'json' => $json ,'data' => $data] ,true);
					}
					$html .='</div>';
					$html .='</section>';
				}
			break;
		}
		return $html;
	}
   
}
?> 