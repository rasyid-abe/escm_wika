<?php

$get = $this->input->get();
$data = str_replace(',', '.', str_replace('.', '', $get['data']));
$total = str_replace(',', '.', str_replace('.', '', $get['total']));

switch ($get['key']) {
	case 'target_ketepatan_waktu':
		$this->db->where('abt_indicator', 'target_ketepatan_progress');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'target_ketepatan_progress');
    $data = array(
      'abt_value' => $data, 
      'abt_indicator'=>'target_ketepatan_progress',
      'abt_seq' => 1,
      "created_datetime"=>date('Y-m-d h:i:s'),
      "abt_status"=>"A");
	break;

  case 'bobot_ketepatan_waktu':
    $this->db->where('abt_indicator', 'bobot_ketepatan_progress');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'bobot_ketepatan_progress');
    $data = array(
    'abt_value' => $data, 
    'abt_indicator'=>'bobot_ketepatan_progress',
    'abt_seq' => 2,
    "created_datetime"=>date('Y-m-d h:i:s'),
    "abt_status"=>"A");
    break;

  case 'target_mutu_pekerjaan':
    $this->db->where('abt_indicator', 'target_mutu_pekerjaan');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'target_mutu_pekerjaan');
     $data = array(
      'abt_value' => $data, 
      'abt_indicator'=>'target_mutu_pekerjaan',
      'abt_seq' => 3,
      "created_datetime"=>date('Y-m-d h:i:s'),
      "abt_status"=>"A");
    break;

  case 'bobot_mutu_pekerjaan':
    $this->db->where('abt_indicator', 'bobot_mutu_pekerjaan');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'bobot_mutu_pekerjaan');
       $data = array(
      'abt_value' => $data, 
      'abt_indicator'=>'bobot_mutu_pekerjaan',
      'abt_seq' => 4,
      "created_datetime"=>date('Y-m-d h:i:s'),
      "abt_status"=>"A");
    break;

  case 'target_mutu_personal':
    $this->db->where('abt_indicator', 'target_mutu_personal');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'target_mutu_personal');

     $data = array(
    'abt_value' => $data, 
    'abt_indicator'=>'target_mutu_personal',
    'abt_seq' => 5,
    "created_datetime"=>date('Y-m-d h:i:s'),
    "abt_status"=>"A");
    break;

  case 'bobot_mutu_personal':
    $this->db->where('abt_indicator', 'bobot_mutu_personal');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'bobot_mutu_personal');
    $data = array(
    'abt_value' => $data, 
    'abt_indicator'=>'bobot_mutu_personal',
    'abt_seq' => 6,
    "created_datetime"=>date('Y-m-d h:i:s'),
    "abt_status"=>"A");
    break;

  case 'target_pelayanan':
    $this->db->where('abt_indicator', 'target_pelayanan');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'target_pelayanan');

     $data = array(
    'abt_value' => $data, 
    'abt_indicator'=>'target_pelayanan',
    'abt_seq' => 7,
    "created_datetime"=>date('Y-m-d h:i:s'),
    "abt_status"=>"A");
    break;

  case 'bobot_pelayanan':
    $this->db->where('abt_indicator', 'bobot_pelayanan');
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->row_array();
    $check = count($get_data);
    $where = array('abt_indicator'=>'bobot_pelayanan');
    $data = array(
    'abt_value' => $data, 
    'abt_indicator'=>'bobot_pelayanan',
    'abt_seq' => 8,
    "created_datetime"=>date('Y-m-d h:i:s'),
    "abt_status"=>"A");
    break;

}

$this->db->trans_begin();

if ($check > 0) {
  $where = $where;
}else{
  $where = "";
}

$update = $this->Administration_m->InsertTargetdanBobotKompilasiVPI($data,$where);

if ($this->db->trans_status() === FALSE)
  {
    // $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
    echo "Gagal Mengubah data";
  }
  else
  {

    // $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
    echo "Sukses Mengubah data";

  }

$this->unset_session('app_id');  
