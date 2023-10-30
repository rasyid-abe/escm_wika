<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/jqSuitePHP/jqUtils.php');

class Registrasi extends CI_Controller
{

	public function rekanan()
	{
		$this->load->view('pendaftaran_rekanan');
	}

	public function account()
	{
		$data = array();
		$data['title'] = 'Ketentuan Penggunaan Sistem';
		$data['sub'] = 'Online Registrasi Vendor, eProcurement dan eReverse Auction (Online Procurement)';
		$this->load->view('/registrasi/register_v', $data);
	}

	public function add_vendor()
	{
		$post = $this->input->post();
		$input = array();
		$status = 0;
		//email
		$this->db->where('login_id', $post['email_address']);
		$email = $this->db->get('vnd_header')->row();

		//npwp
		$this->db->where('npwp_no', $post['npwp_no']);
		$npwp_no = $this->db->get('vnd_header')->row();

		// get MAX vendor_id                
		$this->db->order_by('vendor_id', 'DESC');
		$this->db->limit(1);
		$vendor_id = $this->db->get('vnd_header')->row();
		$vendor_id = (int)$vendor_id->vendor_id + 1;


		if ($this->input->post('password') == $this->input->post('password_rep')) {
			if (isset($email->email_address)) {
				if ($email->email_address == $post['email_address']) {
					$status = 5;
				}
			} elseif (isset($npwp_no->npwp_no)) {

				if ($npwp_no->npwp_no == $post['npwp_no']) {
					$status = 3;
				}
			} else {
				$status = 1;
				$password = strtoupper(hash('sha1' ,$post['password']));
				$input['vendor_id'] = $vendor_id;
				$input['vendor_type'] = $post['type_vendor'];
				$input['login_id'] = $post['email_address'];
				$input['password'] = $password;
				$input['email_address'] = $post['email_address'];
				$input['npwp_no'] = $post['npwp_no'];
				$input['reg_isactivate'] = 1;
				$input['creation_date'] = date('Y-m-d H:i:s');

				$result = $this->db->insert('vnd_header', $input);

				if (true) {
					$to =  $input['email_address'];
					$title = "Email Verification";
					$msg = "<p>Yang Terhormat,<br>Bapak/Ibu calon Vendor</p>
					<p>Terima kasih telah berminat untuk menjadi salah satu mitra kerja PT WIJAYA KARYA TBK
					Silakan klik link/URL dibawah ini untuk melanjutkan proses registrasi :</p>
					<p>URL DAN TOKEN DISINI</p>
					<p>Salam,<br>Vendor Officer</p>
					<p>Mohon untuk tidak membalas ke alamat email ini. Kami tidak akan membaca ataupun membalas semua pertanyaan yang diajukan ke alamat email ini</p>";
					// $this->sendEmail($to, $title, $msg);

					$data_in['vrc_npwp'] = $post['npwp_no'];
					$data_in['vrc_start_date'] = date('Y-m-d h:i:s');
					$data_in['vrc_position'] = 'Vendor';
					$data_in['vrc_activity'] = 'Registrasi';
					$data_in['vrc_user'] = $post['email_address'];

					$result_in = $this->db->insert('vnd_reg_comment', $data_in);
				}
			}
		} else $status = 4;

		echo json_encode($status);
	}

	public function success()
	{
		$data = array();
		$data['title'] = 'Registrasi Berhasil';
		$this->load->view('registrasi/success_v', $data);
	}

	public function validation()
	{
		$data = array();
		$data['title'] = 'Validasi Email';
		$this->load->view('registrasi/valid_v', $data);
	}

	public function failed()
	{
		$data = array();
		$data['title'] = 'Registrasi Gagal';
		$this->load->view('registrasi/failed_v', $data);
	}

	public function sendEmail($to = "", $title = "", $message = "")
	{
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = '10.4.0.44';
		//$config['smtp_user'] = 'admin@wikamail.id';
		//$config['smtp_crypto'] = "tls";
		$config['smtp_port'] = 25;
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$config['useragent'] = COMPANY_NAME;
		$config['charset'] = 'utf8';
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";

		$this->load->library(array('email', 'parser'));

		$this->email->initialize($config);

		$email_cont = $this->load->view("email/alert", "", true);

		$content = trim($email_cont);

		$data['message'] = $message;

		$data['title'] = $title;

		$html = parse_str($content, $data);

		$this->email->from('no-reply@indoportalinternasional.com', 'ADMIN PT. WIKA');
		$this->email->to($to);

		$this->email->subject($title);
		$this->email->message($html);


		$email = $this->email->send();

		//$this->email->clear();

		if ($email) {
			$status = '{"msg": "Success to send email to ' . $to . '!"}';
			echo json_encode($status);
		}

		return $html;
	}
}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */