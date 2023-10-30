<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procedure_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function setMessage($message)
	{
		$current_message = $this->session->userdata("message");

		if(!empty($message))
			{
			if(is_array($message)){
				$message = implode("<br/>", $message);
			} 
			$this->session->set_userdata("message",$message."<br/>".$current_message);
		}
	}

	public function renderMessage($message,$status,$redirect = "")
	{
		$this->form_validation->set_error_delimiters('<p>', '</p>');

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode(array('message' => $message, "status"=>$status, "redirect"=>$redirect)));
	}

	public function vnd_vendor_complete(
	$vnd_id = "",
	$name = "",
	$activity = 0,
	$response = "",
	$comment = "",
	$attachment = "",
	$user_id = null,
	)

}

?>
