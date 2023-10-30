<?php

$header = $this->data['post'];
$userdata = $this->data['userdata'];

$vmh_id = $header['vmh_id']; 
unset($header['vmh_id']);

$header['updated_by'] = $userdata['user_name'];
$header['updated_date'] = date('Y-m-d H:i:s');

$this->db->update('vnd_mandor_header',$header,['vmh_id'=>$vmh_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);
