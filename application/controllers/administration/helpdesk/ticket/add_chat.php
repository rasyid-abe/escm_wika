<?php
$post = $this->input->post();
$ticket_id = $post['ticket_id'];

$input['ticket_id'] = $post['ticket_id'];
$input['message_right'] = $post['message_right'];
$input['lampiran_right'] = $post['lampiran_right'];
$input['date_create'] = date('Y-m-d H:i:s');

$result = $this->db->insert('vnd_ticket_chat', $input);

$this->session->set_flashdata('tab', 'chat');
if ($result && ($post['message_right'] != NULL || $input['lampiran_right'] != NULL)) {
    $this->session->set_flashdata('res', '1');
    return redirect('administration/helpdesk/ticket/detail_ticket/' . $ticket_id);
} else {
    $this->session->set_flashdata('res', '2');
    return redirect('administration/helpdesk/ticket/detail_ticket/' . $ticket_id);
}
