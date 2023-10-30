<?php

$data = $this->data['post'];
$userdata = $this->data['userdata'];

$vmh_id = $data['h_id3']; 
unset($data['h_id3']);

if (is_uploaded_file($_FILES['vmh_rekening_koran']['tmp_name'])) {
    $this->upload->do_upload('vmh_rekening_koran','rekening_koran', "keuangan");
    $files = $this->upload->data();
    $data['vmh_rekening_koran'] = $files['file_name'] ? $files['file_name'] : '';
}else{
    unset($data['vmh_rekening_koran']);
}
$data['updated_by'] = $userdata['user_name'];
$data['updated_date'] = date('Y-m-d H:i:s');

$this->db->update('vnd_mandor_header',$data,['vmh_id'=>$vmh_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);
