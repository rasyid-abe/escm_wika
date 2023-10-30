<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->lang->load('bahasa', $this->session->userdata('language'));
		$this->load->helper('download');

		$kode_vendor = $this->session->userdata('userid');
		if(!$kode_vendor){
			if(!empty(uri_string())){
				$uri_string = explode("/", uri_string());
				if($uri_string[0] != "welcome"){
				redirect(site_url());
				}
			}
		}
		else{
			$this->db->query("UPDATE vnd_session SET last_access = NOW() WHERE login_id = '".$this->session->userdata('login_id')."'");
		}
	}

	public function setMessage($message){

		$current_message = $this->session->userdata("message");


		if(!empty($message)){
			if(is_array($message)){
			$message = implode("<br/>", $message);
			}
			$this->session->set_userdata("message",$message."<br/>".$current_message);
		}

	}

	public function renderMessage($status,$redirect = ""){

		$this->form_validation->set_error_delimiters('<p>', '</p>');

		$message = validation_errors();
		$message .= $this->session->userdata("message");

		if($this->input->is_ajax_request()){

			$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('message' => $message, "status"=>$status, "redirect"=>$redirect)));

			$this->session->unset_userdata("message");

		} else {
			//$this->template("","Sorry",array());
			header('Location: '.$_SERVER['REQUEST_URI']);
		}

	}

	public function do_upload($filename, $tenderid, $job){
		$config['upload_path']          = 'attachment/'.$tenderid.'/'.$job;
		//start code hlmifi
		if($job != "penawaran" || $job != "prakualifikasi"){
			$config['max_size'] = 10250;
		}
		else{
			$config['max_size'] = 10250;
		}
		//endcode
		$config['allowed_types'] = '*';
		$config['encrypt_name'] = true;

		if (!is_dir('attachment'))
		{
			mkdir('attachment', 0777, true);
		}
		if (!is_dir('attachment/'.$tenderid))
		{
			mkdir('attachment/'.$tenderid, 0777, true);
		}
		if (!is_dir('attachment/'.$tenderid.'/'.$job))
		{
			mkdir('attachment/'.$tenderid.'/'.$job, 0777, true);
		}

		$this->load->library('upload', $config);

		$this->upload->initialize($config);

		$upload = $this->upload->do_upload($filename);

		if($upload){
			return $this->upload->data('file_name');
		}
		else{
			return array("0" => "1", "1" => $this->upload->display_errors());
		}
	}

	public function download($job, $filename,$folder=""){
		$job = str_replace("%20", " ", $job);
		$filename_not_encrypted = $filename; // untuk file upload yang tidak diencrypt (just in case)
		$filename = $this->encryption->decrypt($this->umum->forbidden($filename, 'dekrip'));
		if (empty($filename)) {
			$filename = $filename_not_encrypted;
		}
		if(file_exists("./attachment/".$this->session->userdata("userid")."/".$job."/".$filename)){

			force_download('./attachment/'.$this->session->userdata("userid").'/'.$job.'/'.$filename, NULL);
			echo $this->session->userdata("userid")."/".$job."/".$filename;
			
		}else{
			if (empty($folder)) {
				$folder ="procurement";
			}

			$subfolder = array("permintaan","tender","panitia","perencanaan","sanggahan");

			if ($job == 'vendor') {
				$folder ="vendor";
				$subfolder = array("documentpq");
			}

			foreach ($subfolder as $key => $value) {

				stream_context_set_default( [
					'ssl' => [
						'verify_peer' => false,
						'verify_peer_name' => false,
					],
				]);

				$file = INTRANET_PATH."uploads/".$folder."/".$value."/".$filename;
				$header = get_headers($file);


						if ($header[0] === "HTTP/1.1 200 OK") {
						//download file
						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename='.basename($file));
						header('Content-Transfer-Encoding: binary');
						header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: private');
						header('Content-Length: '.filesize($file));
						ob_clean();
						flush();
						readfile($file);
						exit;
					};

				$file = INTRANET_PATH."uploads/comment/".$folder."/".$value."/".$filename;
				$header = get_headers($file);

					if ($header[0] === "HTTP/1.1 200 OK") {
					//download file
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($file));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: private');
					header('Content-Length: '.filesize($file));
					ob_clean();
					flush();
					readfile($file);
					exit;
				};
			}

			echo "<script>alert(\"File not Found\");</script>";

		}
	}

	public function picker(){

		$selector = "picker";

		$get = $this->input->get();

		if(!empty($get)){

			$this->session->unset_userdata($selector);

			$filter_add = array();
			$filter_del = array();

			foreach ($get as $key => $value) {
			$selection = $key;
			}

			$this->session->set_userdata($selector,$selection);

		} else {
			$data = $this->session->userdata($selector);
			echo json_encode($data);
		}

	}
}
