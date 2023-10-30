<?php 

$view = 'mandor/lihat_detail_mandor_v';
$userdata = $this->data['userdata'];

$dataUpdate['status'] = $status;
$dataUpdate['updated_by'] = $userdata['employee_name'];
$dataUpdate['updated_date'] = date('Y-m-d H:i:s');
$this->db->update('vnd_mandor_header',$dataUpdate,['vmh_id'=>$vmh_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);