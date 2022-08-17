<?php
class cache_master extends CI_Controller{
	
	private $accessKey = 'AKIAJFTARKRJNNTZAWBQ';
	private $secretKey = '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';
	private $appDistributionKey = 'E2QK91CR1TCMC9'; 
	private $imageDistributionKey = 'E1MN0TB908IRCL';
	private $folderPath = '';
	
	public function __construct(){
		parent::__construct();
		$this->folderPath = FCPATH.APPPATH.'views/aws_cache_logs';
		if(!is_dir($this->folderPath)){
			mkdir($this->folderPath);
			chmod($this->folderPath , 0777);
		}
	}
	
	public function index(){
		
		$data['title'] = 'AWS Cache Manager';
		$menuName = "AWS Cache Master";
		$menuId = get_menu_details_by_menu_name($menuName);
		if(defined("USERACCESS_VIEW".$menuId) && constant("USERACCESS_VIEW".$menuId) == 1){
			$data['template'] 	= 'cache_view';
			$this->load->view('admin_template',$data);
		}else{
			redirect(folder_name.'/common/access_permission/cache_master');
		}
	}
	
	public function purge(){
		$response['type'] =  $response['type1'] = 0;
		$response['msg'] = $response['msg1'] = '';
		$data = $this->input->post('data');
		$jsonfile = $this->folderPath.'/aws-'.date('y-m-d').'.json';
		$temp = [];
		$appdomain = $imagedomain = '';
		for($i=0;$i<count($data);$i++){
			$url = str_replace(['https://www.newindianexpress.com' ,'https://images.newindianexpress.com' ,'images.newindianexpress.com' ,'www.newindianexpress.com'],['','','',''],$data[$i][1]);
			if($data[$i][0]=='1'){
				$appdomain .='<Path>'.$url.'</Path>';
			}else{
				$imagedomain .='<Path>'.$url.'</Path>';
			}
			$temp[] = ['type'=>$data[$i][0] , 'url'=> $data[$i][1] , 'time'=>date('Y-m-d H:i:s')];
		}
		if(file_exists($jsonfile)){
			$data = json_decode(file_get_contents($jsonfile),true);
			$json = array_merge($data , $temp);
			file_put_contents($jsonfile , json_encode($json));
		}else{
			file_put_contents($jsonfile , json_encode($temp));
		}
		if($appdomain!=''){
		$epoch = date('U');
		$xml = <<<EOD
<InvalidationBatch>
{$appdomain}
<CallerReference>{$this->appDistributionKey}{$epoch}</CallerReference>
</InvalidationBatch>
EOD;

			$len = strlen($xml);
			$date = gmdate('D, d M Y G:i:s T');
			$sig = base64_encode(hash_hmac('sha1', $date, $this->secretKey, true));
			$msg = "POST /2010-11-01/distribution/{$this->appDistributionKey}/invalidation HTTP/1.0\r\n";
			$msg .= "Host: cloudfront.amazonaws.com\r\n";
			$msg .= "Date: {$date}\r\n";
			$msg .= "Content-Type: text/xml; charset=UTF-8\r\n";
			$msg .= "Authorization: AWS {$this->accessKey}:{$sig}\r\n";
			$msg .= "Content-Length: {$len}\r\n\r\n";
			$msg .= $xml;
			$fp = fsockopen('ssl://cloudfront.amazonaws.com', 443, $errno, $errstr, 30);
			if (!$fp){
				$response['type'] = 0;
				$response['msg'] = $errno.'!-!'.$errstr;
			}else{
				fwrite($fp, $msg);
				$resp = '';
				while(! feof($fp)) {
					$resp .= fgets($fp, 1024);
				}
				fclose($fp);
				$response['type'] = 1;
				$response['msg'] = $resp;
			}
		}
		if($imagedomain!=''){
		$epoch = date('U');
		$xml = <<<EOD
<InvalidationBatch>
{$imagedomain}
<CallerReference>{$this->imageDistributionKey}{$epoch}</CallerReference>
</InvalidationBatch>
EOD;

			$len = strlen($xml);
			$date = gmdate('D, d M Y G:i:s T');
			$sig = base64_encode(hash_hmac('sha1', $date, $this->secretKey, true));
			$msg = "POST /2010-11-01/distribution/{$this->imageDistributionKey}/invalidation HTTP/1.0\r\n";
			$msg .= "Host: cloudfront.amazonaws.com\r\n";
			$msg .= "Date: {$date}\r\n";
			$msg .= "Content-Type: text/xml; charset=UTF-8\r\n";
			$msg .= "Authorization: AWS {$this->accessKey}:{$sig}\r\n";
			$msg .= "Content-Length: {$len}\r\n\r\n";
			$msg .= $xml;
			$fp = fsockopen('ssl://cloudfront.amazonaws.com', 443, $errno, $errstr, 30);
			if (!$fp){
				$response['type1'] = 0;
				$response['msg1'] = $errno.'!-!'.$errstr;
			}else{
				fwrite($fp, $msg);
				$resp = '';
				while(! feof($fp)) {
					$resp .= fgets($fp, 1024);
				}
				fclose($fp);
				$response['type1'] = 1;
				$response['msg1'] = $resp;
			}
		}
		echo json_encode($response);
		
	}
	
	public function test(){
		$getAuthorDetails = $this->db->select("image_path , image_alt , image_caption , AuthorName")->where("Author_id" , 135)->get("authormaster")->row();
		print_r($getAuthorDetails);
	}
}
?> 