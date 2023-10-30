<?php

$get = $this->input->get();
$newData = str_replace(',', '.', str_replace('.', '', $get['data']));
$type = $get['type'];
$total = str_replace(',', '.', str_replace('.', '', $get['total']));

switch ($get['key']) {
	case 'target_ketepatan_progress':
    $where = array('abt_indicator'=>'target_ketepatan_progress');
		$this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
      'abt_indicator'=>'target_ketepatan_progress',
      'abt_seq' => 1,

    );
	break;

  case 'bobot_ketepatan_progress':
    $where = array('abt_indicator'=>'bobot_ketepatan_progress');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array( 
    'abt_indicator'=>'bobot_ketepatan_progress',
    'abt_seq' => 2,
    );
    break;

    case 'target_hasil_mutu_pekerjaan':
    $where = array('abt_indicator'=>'target_hasil_mutu_pekerjaan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
      'abt_indicator'=>'target_hasil_mutu_pekerjaan',
      'abt_seq' => 3,

    );
  break;

  case 'bobot_hasil_mutu_pekerjaan':
    $where = array('abt_indicator'=>'bobot_hasil_mutu_pekerjaan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array( 
    'abt_indicator'=>'bobot_hasil_mutu_pekerjaan',
    'abt_seq' => 4,
    );
    break;

    case 'target_k3l':
    $where = array('abt_indicator'=>'target_k3l');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
      'abt_indicator'=>'target_k3l',
      'abt_seq' => 5,

    );
  break;

  case 'bobot_k3l':
    $where = array('abt_indicator'=>'bobot_k3l');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array( 
    'abt_indicator'=>'bobot_k3l',
    'abt_seq' => 6,
    );
    break;

    case 'target_5r':
    $where = array('abt_indicator'=>'target_5r');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
      'abt_indicator'=>'target_5r',
      'abt_seq' => 7,

    );
  break;

  case 'bobot_5r':
    $where = array('abt_indicator'=>'bobot_5r');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array( 
    'abt_indicator'=>'bobot_5r',
    'abt_seq' => 8,
    );
    break;

    case 'target_pengamanan':
    $where = array('abt_indicator'=>'target_pengamanan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array(
      'abt_indicator'=>'target_pengamanan',
      'abt_seq' => 9,

    );
  break;

  case 'bobot_pengamanan':
    $where = array('abt_indicator'=>'bobot_pengamanan');
    $this->db->where($where);
    $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI("",$type)->row_array();
    $check = count($get_data);
    $data = array( 
    'abt_indicator'=>'bobot_pengamanan',
    'abt_seq' => 10,
    );
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
// var_dump($data);exit();
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

