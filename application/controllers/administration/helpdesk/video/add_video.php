<?php
$post = $this->input->post();
$userdata = $this->data['userdata'];

$files = "";
if (is_uploaded_file($_FILES['lampiran']['tmp_name'])) {
    $files = $this->do_upload('lampiran', 'user_guide', $this->input->post('kategori'));
}

$input['judul'] = $post['judul'];
$input['kategori'] = $post['kategori'];
$input['jenis_dokumen'] = 2;
$input['lampiran'] = $files ? $files : '';
$input['date_created'] = date('Y-m-d h:i:s');
$input['created_by'] = $userdata['user_name'];

$result = $this->db->insert('adm_dokumen_flow', $input);

$this->session->set_flashdata('tab', 'video');
if ($result) {
    $this->session->set_flashdata('status', '1');
    return redirect('administration/helpdesk/video');
} else {
    $this->session->set_flashdata('status', '2');
    return redirect('administration/helpdesk/video');
}
