<?php

$data = $this->data['post'];
$userdata = $this->data['userdata'];

$vmp_id = $data['vmp_id']; 
unset($data['vmp_id']);

$vmh_id = $data['h_id1']; 
unset($data['h_id1']);

$data['updated_by'] = $userdata['user_name'];
$data['updated_date'] = date('Y-m-d H:i:s');

$this->db->update('vnd_mandor_pic',$data,['vmp_id'=>$vmp_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);
