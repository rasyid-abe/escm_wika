<?php

$data = $this->data['post'];
$userdata = $this->data['userdata'];
echo json_encode($data);
$vmt_id = (int)$data['vmt_id']; 
unset($data['vmt_id']);

$vmh_id = $data['h_id6']; 
unset($data['h_id6']);

$data['updated_by'] = $userdata['user_name'];
$data['updated_date'] = date('Y-m-d H:i:s');

$this->db->update('vnd_mandor_tools',$data,['vmt_id'=>$vmt_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);
