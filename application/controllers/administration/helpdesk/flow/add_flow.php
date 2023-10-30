<?php

$post = $this->input->post();
$userdata = $this->data['userdata'];


$input['judul'] = $post['judul'];
$input['kategori'] = $post['kategori'];
$input['jenis_dokumen'] = 1;
$input['lampiran'] = $post['lampiran_flow'];
$input['date_created'] = date('Y-m-d h:i:s');
$input['created_by'] = $userdata['user_name'];

$result = $this->db->insert('adm_dokumen_flow', $input);

$this->session->set_flashdata('tab', 'flow');
if ($result) {
    $this->session->set_flashdata('status', '1');
    return redirect('administration/helpdesk/flow');
} else {
    $this->session->set_flashdata('status', '2');
    return redirect('administration/helpdesk/flow');
}
