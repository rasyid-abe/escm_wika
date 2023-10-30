<?php

$data = $this->data['post'];
$userdata = $this->data['userdata'];
echo json_encode($data);
$vmtq_id = (int)$data['vmtq_id']; 
unset($data['vmtq_id']);

$vmh_id = $data['h_id5']; 
unset($data['h_id5']);

$data['updated_by'] = $userdata['user_name'];
$data['updated_date'] = date('Y-m-d H:i:s');

$this->db->update('vnd_mandor_teknik_qty_ahli_bidang',$data,['vmtq_id'=>$vmtq_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);
