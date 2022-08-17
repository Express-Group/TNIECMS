<?php
class Testcontroller extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){


	/*	$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
    'smtp_port' => 465,
    'smtp_user' => 'AKIAXJIMHE7CI7ZLSL7C',
    'smtp_pass' => 'BCcNRDtcogcimSxGmlQVZQY5zBNgC2KLbxTPohra8bwU',
    'mailtype'  => 'html', 
    'charset'   => 'iso-8859-1'
);



$config['useragent'] = 'PHPMailer'; // Mail engine switcher: 'CodeIgniter' or 'PHPMailer'
$config['protocol'] = 'mail'; // 'mail', 'sendmail', or 'smtp'
$config['mailpath'] = '/usr/sbin/sendmail';
$config['smtp_host'] = 'mail.newindianexpress.com';
$config['smtp_auth'] = true; 
$config['smtp_user'] = 'btcadmin'; //youremail
$config['smtp_pass'] = 'express'; //yourpassword
$config['smtp_port'] = 25;
$config['smtp_timeout'] = 30; // (in seconds)
$config['smtp_crypto'] = ''; // '' or 'tls' or 'ssl'



$this->load->library('email', $config);
$this->email->set_newline("\r\n");

// Set to, from, message, etc.

$this->email->from('admin@clapout.com', 'clapout');
$this->email->to('pandiaraj.m@gmail.com');
        
$result = $this->email->send();

echo "<pre>Check";
print_r($result);
echo "</pre>";



	$config = Array(
    'protocol' => 'mail',
    'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
    'smtp_port' => 465,
    'smtp_user' => 'btcadmin',
	'useragent' => 'AKIAXJIMHE7CI7ZLSL7C',
	'mailpath' => '/usr/sbin/sendmail',
	'smtp_auth' => true,	
    'smtp_pass' => 'express',
    'smtp_timeout'   => 30
);




$this->load->library('email', $config);
$this->email->set_newline("\r\n");

// Set to, from, message, etc.

$this->email->from('admin@clapout.com', 'clapout');
$this->email->to('pandiaraj.m@gmail.com');
        
echo $result = $this->email->send();




*/






	 

$config['useragent'] = 'PHPMailer'; // Mail engine switcher: 'CodeIgniter' or 'PHPMailer'
$config['protocol'] = 'mail'; // 'mail', 'sendmail', or 'smtp'
$config['mailpath'] = '/usr/sbin/sendmail';
$config['smtp_host'] = 'mail.newindianexpress.com';
$config['smtp_auth'] = true; 
$config['smtp_user'] = 'btcadmin'; //youremail
$config['smtp_pass'] = 'express'; //yourpassword
$config['smtp_port'] = 25;
$config['smtp_timeout'] = 30; // (in seconds)
$config['smtp_crypto'] = ''; // '' or 'tls' or 'ssl'

/*
		$config['useragent']	='PHPMailer';
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		//$config['protocol'] = 'mail';
		$config['smtp_host'] = 'email-smtp.us-east-1.amazonaws.com';
		$config['smtp_user'] = 'AKIAXJIMHE7CI7ZLSL7C';
		$config['smtp_pass'] = 'BCcNRDtcogcimSxGmlQVZQY5zBNgC2KLbxTPohra8bwU'; 
		$config['smtp_port'] = 465;
		$config['smtp_crypto'] = 'tls';
		$config['smtp_auth'] = true; 
		$config['newline'] = '\r\n';
		*/
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('admin@clapout.com', 'clapoutf');
		$this->email->to('krishraja5858@gmail.com');
		$this->email->cc('asaguru@gmail.com');
		//$this->email->bcc('them@their-example.com');
		$this->email->subject('test message');
		$this->email->message('test message');
		$result = $this->email->send();

		 if ( ! $result) {

			 print_r($this->email->print_debugger());
       
    }
	else
		{
		echo "<pre>";
		print_r($result);
		echo "</pre>";

		}


	}
	
	
}
?> 