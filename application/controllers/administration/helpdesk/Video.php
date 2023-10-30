<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends MY_Controller {

	public function __construct(){
        parent::__construct();
    }

	public function index()
	{
		$this->db->where('jenis_dokumen', 2);
		$query = $this->db->get('adm_dokumen_flow');

		$data = array();		
		$data['get_list'] = $query->result_array();
		$data['title'] = 'Video Flow Sistem';

		$this->load->view('administration/helpdesk/video_v',$data);
	}
}
