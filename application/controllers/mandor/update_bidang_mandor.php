<?php

$data = $this->data['post'];
$userdata = $this->data['userdata'];

$vmb_id = (int)$data['vmb_id']; 
unset($data['vmb_id']);

$vmh_id = $data['h_id2']; 
unset($data['h_id2']);

$bidang_name = $this->db->get_where('adm_master',['am_kode'=>$data['vmb_bidang_code']])->row_array()['am_name'];
$sub_bidang_name = $this->db->get_where('adm_master',['am_kode'=>$data['vmb_sub_bidang_code']])->row_array()['am_name'];

$data['vmb_bidang_name'] = $bidang_name;
$data['vmb_sub_bidang_name'] = $sub_bidang_name;
$data['updated_by'] = $userdata['user_name'];
$data['updated_date'] = date('Y-m-d H:i:s');

$this->db->update('vnd_mandor_bidang',$data,['vmb_id'=>$vmb_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);
