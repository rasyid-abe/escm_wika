<?php
$id = $this->uri->segment(5, 0);
$result = $this->db->delete('vnd_faq_helpdesk', array('faq_id' => $id));

$this->session->set_flashdata('tab', 'del');
if ($result) {
    $this->session->set_flashdata('res', '1');
    return redirect('administration/helpdesk/faq');
} else {
    $this->session->set_flashdata('res', '2');
    return redirect('administration/helpdesk/faq');
}
