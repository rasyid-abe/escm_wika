<?php

$userdata = $this->data['userdata'];
$post = $this->input->post();

$input = array();

$input['nama_perusahaan'] = $post['nama_perusahaan'];
$input['npwp_no'] = $post['npwp_no'];
$input['email_perusahaan'] = $post['email_perusahaan'];
$input['no_telp'] = $post['no_telp'];
$input['alamat'] = $post['alamat'];
$input['kategori'] = $post['kategori'];
$input['deskripsi_pertanyaan'] = $post['deskripsi_pertanyaan'];
$input['created_by'] = $userdata['id'];
$input['status'] = 1;
$input['created_at'] = date("Y-m-d H:i:s");

$act = $this->db->insert("vnd_ticket", $input);

$this->session->set_flashdata('tab', 'ticket');
if ($act) {
    var_dump($act);
    $this->session->set_flashdata('status', '1');
    return redirect('administration/helpdesk/ticket');
} else {
    $this->session->set_flashdata('status', '2');
    return redirect('administration/helpdesk/ticket');
}