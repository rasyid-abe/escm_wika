<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helpdesk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->db->order_by("faq_id", "desc");
        $this->db->where('category', 1);
        $get_url1 = $this->db->get("vnd_faq_helpdesk")->result_array();

        $this->db->where('category', 2);
        $get_url2 = $this->db->get("vnd_faq_helpdesk")->result_array();

        $this->db->where('category', 3);
        $get_url3 = $this->db->get("vnd_faq_helpdesk")->result_array();

        $this->db->where('category', 4);
        $get_url4 = $this->db->get("vnd_faq_helpdesk")->result_array();

        $data['title'] = 'FAQ';
        $data['get_list1'] = $get_url1;
        $data['get_list2'] = $get_url2;
        $data['get_list3'] = $get_url3;
        $data['get_list4'] = $get_url4;

        $this->load->view('helpdesk/helpdesk_v', $data);
    }
    public function addTicket()
    {
        $post = $this->input->post();

        $input = array();

        $input['nama_perusahaan'] = $post['nama_perusahaan'];
        $input['npwp_no'] = $post['npwp_no'];
        $input['email_perusahaan'] = $post['email_perusahaan'];
        $input['no_telp'] = $post['no_telp'];
        $input['alamat'] = $post['alamat'];
        $input['kategori'] = $post['kategori'];
        $input['deskripsi_pertanyaan'] = $post['deskripsi_pertanyaan'];
        // $input['created_by'] = $userdata['id'];
        $input['status'] = 1;
        $input['created_at'] = date("Y-m-d H:i:s");

        $act = $this->db->insert("vnd_ticket", $input);

        $this->session->set_flashdata('tab', 'ticket');
        if ($act) {
            $this->session->set_flashdata('status', '1');
            return redirect('helpdesk/check_ticket');
        } else {
            $this->session->set_flashdata('status', '2');
            return redirect('helpdesk/check_ticket');
        }
    }
    public function check_ticket()
    {
        $this->db->order_by("ticket_id", "desc");
        $list = $this->db->get("vnd_ticket")->result_array();

        $data['title'] = 'Daftar Tiket';
        $data['ticket'] = $list;

        $this->load->view('helpdesk/ticket/ticket_v', $data);
    }
    public function detail()
    {
        $ticket_id = $this->uri->segment(3, 0);
        $this->db->where('ticket_id', $ticket_id);
        $query = $this->db->get('vnd_ticket');

        $this->db->where('ticket_id', $ticket_id);
        $res = $this->db->get('vnd_ticket_chat');

        $data = array();
        $data['title'] = 'Detail Ticket';
        $data['data_detail'] =  $query->row_array();
        $data['res'] =  $res->result_array();

        $this->load->view('helpdesk/ticket/detail_ticket_v', $data);
    }
    public function add_chat()
    {
        $ticket_id = $this->input->post('ticket_id');
        $files = "";

        if (is_uploaded_file($_FILES['lampiran_left']['tmp_name'])) {
            $files = $this->do_upload('lampiran_left', 'ticket', $ticket_id);
        }

        $data = array(
            'ticket_id' => $this->input->post('ticket_id'),
            'message_left' => $this->input->post('message_left'),
            'lampiran_left' => $files ? $files : '',
            'date_create' => date('Y-m-d H:i:s')
        );

        //var_dump($files);die();

        $result = $this->db->insert('vnd_ticket_chat', $data);

        $this->session->set_flashdata('tab', 'chat');
        if ($result && ($this->input->post('message_left') != NULL || $files != NULL)) {
            $this->session->set_flashdata('res', '1');
            return redirect('helpdesk/detail/' . $ticket_id);
        } else {
            $this->session->set_flashdata('res', '2');
            return redirect('helpdesk/detail/' . $ticket_id);
        }
    }

    public function do_upload($filename, $tenderid, $job)
    {
        $config['upload_path']          = 'attachment/' . $tenderid . '/' . $job;
        //start code hlmifi
        if ($job != "penawaran" || $job != "prakualifikasi") {
            $config['max_size']             = 10250;
        } else {
            $config['max_size']             = 10250;
        }
        //endcode
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = true;

        if (!is_dir('attachment')) {
            mkdir('attachment', 0777, true);
        }
        if (!is_dir('attachment/' . $tenderid)) {
            mkdir('attachment/' . $tenderid, 0777, true);
        }
        if (!is_dir('attachment/' . $tenderid . '/' . $job)) {
            mkdir('attachment/' . $tenderid . '/' . $job, 0777, true);
        }

        $this->load->library('upload', $config);

        $this->upload->initialize($config);

        $upload = $this->upload->do_upload($filename);

        if ($upload) {
            return $this->upload->data('file_name');
        } else {
            return array("0" => "1", "1" => $this->upload->display_errors());
        }
    }
}
