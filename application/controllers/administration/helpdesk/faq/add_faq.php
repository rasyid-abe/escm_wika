<?php
$userdata = $this->data['userdata'];
$post = $this->input->post();

$input['category'] = $post['category'];
$input['question'] = $post['question'];
$input['answer'] = $post['answer'];
$input['created_by'] = $userdata['id'];
$input['created_at'] = date("Y-m-d H:i:s");

$act = $this->db->insert("vnd_faq_helpdesk", $input);

$this->session->set_flashdata('tab', 'faq');
if ($act) {
    var_dump($act);
    $this->session->set_flashdata('status', '1');
    return redirect('administration/helpdesk/faq');
} else {
    $this->session->set_flashdata('status', '2');
    return redirect('administration/helpdesk/faq');
}