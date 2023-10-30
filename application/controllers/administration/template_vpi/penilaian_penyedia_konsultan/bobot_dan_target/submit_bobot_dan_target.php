<?php

$get = $this->input->get();
$newData = str_replace(',', '.', str_replace('.', '', $get['data']));
$total = str_replace(',', '.', str_replace('.', '', $get['total']));
$type = $get['type'];

switch ($get['key']) {
	case 'target_ketepatan_waktu':
    $where = array('abt_indicator'=>'target_ketepatan_progress');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
      'abt_indicator'=>'target_ketepatan_progress',
      'abt_seq' => 1);
	break;

  case 'bobot_ketepatan_waktu':
    $where = array('abt_indicator'=>'bobot_ketepatan_progress');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
    'abt_indicator'=>'bobot_ketepatan_progress',
    'abt_seq' => 2);
    break;

  case 'target_mutu_pekerjaan':
    $where = array('abt_indicator'=>'target_mutu_pekerjaan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
     $data = array(
      'abt_indicator'=>'target_mutu_pekerjaan',
      'abt_seq' => 3);
    break;

  case 'bobot_mutu_pekerjaan':
    $where = array('abt_indicator'=>'bobot_mutu_pekerjaan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
       $data = array(
      'abt_indicator'=>'bobot_mutu_pekerjaan',
      'abt_seq' => 4);
    break;

  case 'target_mutu_personal':
    $where = array('abt_indicator'=>'target_mutu_personal');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);

     $data = array( 
    'abt_indicator'=>'target_mutu_personal',
    'abt_seq' => 5);
    break;

  case 'bobot_mutu_personal':
    $where = array('abt_indicator'=>'bobot_mutu_personal');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
    'abt_indicator'=>'bobot_mutu_personal',
    'abt_seq' => 6);
    break;

  case 'target_pelayanan':
    $where = array('abt_indicator'=>'target_pelayanan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);

     $data = array(
    'abt_indicator'=>'target_pelayanan',
    'abt_seq' => 7);
    break;

  case 'bobot_pelayanan':
    $where = array('abt_indicator'=>'bobot_pelayanan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array( 
    'abt_indicator'=>'bobot_pelayanan',
    'abt_seq' => 8);
    break;

}

$data['abt_value'] = $newData;
$data['abt_type'] = $type;
$data['created_datetime'] = date('Y-m-d h:i:s');
$data['abt_status'] = 'A';

$this->db->trans_begin();

if ($check > 0) {
  $where['abt_type'] = $type;
}else{
  $where = "";
}

$update = $this->Administration_m->InsertTargetdanBobotKompilasiVPI($data,$where);

if ($this->db->trans_status() === FALSE)
  {
    $this->db->trans_rollback();
    echo "Gagal Mengubah data";
  }
  else
  {
    $this->db->trans_commit();
    echo "Sukses Mengubah data";

  }

$this->unset_session('app_id');  
