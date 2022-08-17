<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->library('phpmailer_lib');
		$mail = $this->phpmailer_lib->load();
		//$mail->isSMTP();
		$mail->setFrom('pandiaraj.m@newindianexpress.com', 'Pandiaraj');
		$mail->Username = 'AKIAZKMLWP5PHL7OOS63';
		$mail->Password = 'BJiJLqooF0Q1qByXlQlIt/bgjVPaN4yEh2XB95i0J0wd';
		$mail->Host = 'email-smtp.us-west-2.amazonaws.com';
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->addAddress('chriswar@newindianexpress.com');
		$mail->addAddress('pandiaraj.m@newindianexpress.com');
		$mail->isHTML(true);
		$mail->Subject = 'subject';
		$mail->Body = '<p>test</p>';
		$mail->AltBody = 'test';
		if(!$mail->Send()){
		   echo 'Message was not sent.';
		   echo 'Mailer error: ' . $mail->ErrorInfo;
		}
	}
}
?>