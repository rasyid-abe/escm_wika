<?php

$id = $this->uri->segment(5, 0);
$result = $this->db->delete('adm_dokumen_flow', array('id' => $id));

$this->session->set_flashdata('tab', 'flow_del');
if ($result) {
    $this->session->set_flashdata('status', '1');
    return redirect('administration/helpdesk/flow');
} else {
    $this->session->set_flashdata('status', '2');
    return redirect('administration/helpdesk/flow');
}
