<?php

$data = $this->data['post'];
$userdata = $this->data['userdata'];

$vmpe_id = $data['vmpe_id']; 
unset($data['vmpe_id']);

$vmh_id = $data['h_id4']; 
unset($data['h_id4']);

if (is_uploaded_file($_FILES['vmpe_evidence_project']['tmp_name'])) {
    $this->upload->do_upload('vmpe_evidence_project','rekening_koran', "keuangan");
    $files = $this->upload->data();
    $data['vmpe_evidence_project'] = $files['file_name'] ? $files['file_name'] : '';
}else{
    unset($data['vmpe_evidence_project']);
}




$bidang_name = [];
$bidang_code = [];
$sub_bidang_name = [];
$sub_bidang_code = [];
for ($i=0; $i < count($data['vmb_bidang_code_proyek']) ; $i++) {
    array_push($bidang_code,$data['vmb_bidang_code_proyek'][$i]);
    array_push($sub_bidang_code,$data['vmb_sub_bidang_code_proyek'][$i]);
    array_push($bidang_name, $this->db->get_where('adm_master',['am_kode'=> $data['vmb_bidang_code_proyek'][$i]])->row_array()['am_name']);
    array_push($sub_bidang_name, $this->db->get_where('adm_master',['am_kode'=> $data['vmb_sub_bidang_code_proyek'][$i]])->row_array()['am_name']);
}

unset($data['vmb_bidang_code_proyek']);
unset($data['vmb_sub_bidang_code_proyek']);

$data['vmb_bidang_code'] 		= json_encode($bidang_code);
$data['vmb_bidang_name'] 		= json_encode($bidang_name);
$data['vmb_sub_bidang_code'] 	= json_encode($bidang_code);
$data['vmb_sub_bidang_name'] 	= json_encode($sub_bidang_name);

$data['updated_by'] = $userdata['user_name'];
$data['updated_date'] = date('Y-m-d H:i:s');

$this->db->update('vnd_mandor_project_experience',$data,['vmpe_id'=>$vmpe_id]);

redirect('/vendor/lihat_detail_mandor/'.$vmh_id);
