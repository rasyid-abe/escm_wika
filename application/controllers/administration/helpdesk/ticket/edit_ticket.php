<?php
$post = $this->input->post();
$ticket_id = $post['ticket_id'];

$input['status'] = $post['status'];
$input['kategori'] = $post['kategori'];
$input['nama_perusahaan'] = $post['nama_perusahaan'];
$input['npwp_no'] = $post['npwp_no'];
$input['email_perusahaan'] = $post['email_perusahaan'];
$input['no_telp'] = $post['no_telp'];
$input['alamat'] = $post['alamat'];
$input['deskripsi_pertanyaan'] = $post['deskripsi_pertanyaan'];
$input['deskripsi_jawaban'] = $post['deskripsi_jawaban'];

$this->db->where('ticket_id', $ticket_id);
$result = $this->db->update('vnd_ticket', $input);

$this->session->set_flashdata('tab', 'ticket');
if ($result) {
    $this->session->set_flashdata('res', '1');
    return redirect('administration/helpdesk/ticket/detail_ticket/' . $ticket_id);
} else {
    $this->session->set_flashdata('res', '2');
    return redirect('administration/helpdesk/ticket/detail_ticket/' . $ticket_id);
}
