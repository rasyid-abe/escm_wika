<?php

$id = $this->uri->segment(5, 0);

$this->db->where('id', $id);
$data = $this->db->get('vnd_ticket_chat');
$res = $data->row_array();
// var_dump($res);
// die();
$result = $this->db->delete('vnd_ticket_chat', array('id' => $id));

$this->session->set_flashdata('tab', 'chat_del');
if ($result) {
    $this->session->set_flashdata('res', '1');
    return redirect('administration/helpdesk/ticket/detail_ticket/' . $res['ticket_id']);
} else {
    $this->session->set_flashdata('res', '2');
    return redirect('administration/helpdesk/ticket/detail_ticket/' . $res['ticket_id']);
}
