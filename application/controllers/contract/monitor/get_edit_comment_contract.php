<?php 

$post = $this->input->post();

$id = $post['id'];
$this->db->where('id', $id);
$edits = $this->db->get('ctr_comment_all_div');
$data['edits'] = $edits->result_array();

echo json_encode($data);