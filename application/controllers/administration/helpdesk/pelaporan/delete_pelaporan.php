<?php
$id = $this->uri->segment(5, 0);
$result = $this->db->delete('vnd_pelaporan', array('id' => $id));

$this->session->set_flashdata('tab', 'pelaporan_del');
if ($result) {
    $this->session->set_flashdata('status', '1');
    return redirect('administration/helpdesk/pelaporan');
} else {
    $this->session->set_flashdata('status', '2');
    return redirect('administration/helpdesk/pelaporan');
}