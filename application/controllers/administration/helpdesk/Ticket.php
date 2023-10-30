<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MY_Controller {

	public function __construct(){
        parent::__construct();
    }

	public function index()
	{
		$url = $this->config->item('api_url').'api/v1/vendor/ticket?page=0&size=10&sortBy=&sortValue=DESC';			
		$get_url = file_get_contents($url);		
		
		$data = array();		
		$data['title'] = 'Daftar Ticket';
		$data['get_list'] = json_decode($get_url, true);

		$this->load->view('administration/helpdesk/ticket_v',$data);
	}

	public function detail( $get_par = null) 
	{
		$par = dec( $get_par );
		$ticket_id = $par['ticket_id'];

		$this->db->where('ticket_id', $ticket_id);
		$query = $this->db->get('vnd_ticket');	

		$this->db->where('ticket_id', $ticket_id);
		$res = $this->db->get('vnd_ticket_chat');

		$data = array();
		$data['title'] = 'Detail Ticket';		
		$data['data_detail'] =  $query->row_array();
		$data['res'] =  $res->result_array();

		$this->load->view('administration/helpdesk/ticket_detail_v',$data);
	} 

	public function edit()
    {
        $ticket_id = $this->input->post('ticket_id');
  
        $arr_data = [
			'status' => $this->input->post('status'),
            'kategori' => $this->input->post('kategori'),
            'nama_perusahaan' => $this->input->post('nama_perusahaan'),
            'npwp_no' => $this->input->post('npwp_no'),
            'email_perusahaan' => $this->input->post('email_perusahaan'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'deskripsi_pertanyaan' => $this->input->post('deskripsi_pertanyaan'),
            'deskripsi_jawaban' => $this->input->post('deskripsi_jawaban')
		];

		$this->db->where('ticket_id', $ticket_id);
		$result = $this->db->update('vnd_ticket', $arr_data);	

        $this->session->set_flashdata('tab', 'ticket');
		if ($result) {
			$this->session->set_flashdata('res', '1');
			return redirect('administration/helpdesk/ticket/detail/'. enc( ['ticket_id' => $ticket_id]));
		} else {
			$this->session->set_flashdata('res', '2');
			return redirect('administration/helpdesk/ticket/detail/'. enc( ['ticket_id' => $ticket_id]));
		}        
    }

	public function add_chat()
    {                  
		$ticket_id = $this->input->post('ticket_id');
		$files = "";

        if (is_uploaded_file($_FILES['lampiran_right']['tmp_name'])) {
            $files = $this->do_upload('lampiran_right','ticket', $ticket_id);
        }
		
        $data = array (
            'ticket_id' => $this->input->post('ticket_id'),
            'message_right' => $this->input->post('message_right'),
			'lampiran_right' => $files ? $files : '',
            'date_create' => date('Y-m-d H:i:s')
        );	  		

        $result = $this->db->insert('vnd_ticket_chat', $data);

        $this->session->set_flashdata('tab', 'chat');
		if ($result && ($this->input->post('message_right') != NULL || $files != NULL)) {
			$this->session->set_flashdata('res', '1');
			return redirect('administration/helpdesk/ticket/detail/'. enc( ['ticket_id' => $ticket_id]));
		} else {
			$this->session->set_flashdata('res', '2');
			return redirect('administration/helpdesk/ticket/detail/'. enc( ['ticket_id' => $ticket_id]));
		}  
    }

	public function delete_chat( $id = null )
    {        
		$this->db->where('id', $id);
		$data = $this->db->get('vnd_ticket_chat');
		$res = $data->row_array();

        $result = $this->db->delete('vnd_ticket_chat', array('id' => $id));

        $this->session->set_flashdata('tab', 'chat_del');
		if ($result) {
			$this->session->set_flashdata('res', '1');
			return redirect('administration/helpdesk/ticket/detail/'. enc( ['ticket_id' => $res['ticket_id']]));
		} else {
			$this->session->set_flashdata('res', '2');
			return redirect('administration/helpdesk/ticket/detail/'. enc( ['ticket_id' => $res['ticket_id']]));
		}  
    }
}
