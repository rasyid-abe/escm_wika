<?php

$get_data_bobot = $this->Administration_m->getTargetdanBobotKompilasiVPI("",'konsultan')->result_array();
  $data['data_bobot'] = [];
  $arrayNew = array();

  if (empty($get_data_bobot)) {
    $arrayNew['target_ketepatan_progress'] = 0;
    $arrayNew['target_mutu_pekerjaan'] = 0;
    $arrayNew['target_mutu_personal'] = 0;
    $arrayNew['target_pelayanan'] = 0;
    $arrayNew['bobot_ketepatan_progress'] = 0;
    $arrayNew['bobot_mutu_pekerjaan'] = 0;
    $arrayNew['bobot_mutu_personal'] = 0;
    $arrayNew['bobot_pelayanan'] = 0;
    $data['total_target'] = 0;
    $data['total_bobot'] = 0;
  }else{

  foreach ($get_data_bobot as $key => $value) {
    $arrayNew[$value['abt_indicator']] = str_replace('.', ',', $value['abt_value']); 
  }
  array_push($data['data_bobot'] , $arrayNew);
  $arrayNew['target_ketepatan_progress'] = isset($arrayNew['target_ketepatan_progress']) ? $arrayNew['target_ketepatan_progress'] : 0;
    $arrayNew['target_mutu_pekerjaan'] = isset($arrayNew['target_mutu_pekerjaan']) ? $arrayNew['target_mutu_pekerjaan'] : 0;
    $arrayNew['target_mutu_personal'] = isset($arrayNew['target_mutu_personal']) ? $arrayNew['target_mutu_personal'] : 0;
    $arrayNew['target_pelayanan'] = isset($arrayNew['target_pelayanan']) ? $arrayNew['target_pelayanan'] : 0;

    $arrayNew['bobot_ketepatan_progress'] = isset($arrayNew['bobot_ketepatan_progress']) ? $arrayNew['bobot_ketepatan_progress'] : 0;
    $arrayNew['bobot_mutu_pekerjaan'] = isset($arrayNew['bobot_mutu_pekerjaan']) ? $arrayNew['bobot_mutu_pekerjaan'] : 0;
    $arrayNew['bobot_mutu_personal'] = isset($arrayNew['bobot_mutu_personal']) ? $arrayNew['bobot_mutu_personal'] : 0;
    $arrayNew['bobot_pelayanan'] = isset($arrayNew['bobot_pelayanan']) ? $arrayNew['bobot_pelayanan'] : 0;

    $total_target = array(
      str_replace(',', '.', $arrayNew['target_ketepatan_progress']),
      str_replace(',', '.', $arrayNew['target_mutu_pekerjaan']),
      str_replace(',', '.', $arrayNew['target_mutu_personal']),
      str_replace(',', '.', $arrayNew['target_pelayanan']),
    );

    $total_bobot = array(
      str_replace(',', '.', $arrayNew['bobot_ketepatan_progress']),
      str_replace(',', '.', $arrayNew['bobot_mutu_pekerjaan']),
      str_replace(',', '.', $arrayNew['bobot_mutu_personal']),
      str_replace(',', '.', $arrayNew['bobot_pelayanan'])
    );

    $data['total_target'] = array_sum($total_target);
    $data['total_bobot'] = array_sum($total_bobot);

  }

  array_push($data['data_bobot'] , $arrayNew);
  $data['data_bobot'] = $data['data_bobot'][0];

  $this->db->where('ahm_status', 'A');
  $data['mutu_pekerjaan'] =  $this->Administration_m->getHasilMutuPekerjaan("",$vvh_tipe)->result_array();
  
  $this->db->where('app_status', 'A');
  $data['pelayanan'] =  $this->Administration_m->getAspekPenilaianPelayanan()->result_array();

  $prev_data = $this->Vendor_m->getVPIKompilasi($vvh_id)->row_array();
  $data['prev_data'] = $prev_data;

  //get nilai ketepatan progress
  $this->db->where('vvh_id', $vvh_id);
  $ketepatan_progress =  $this->Vendor_m->getDataPenilaianKetepatanProgress()->row_array();
  $data['nilai_ketepatan_progress'] = str_replace('.', ',', $ketepatan_progress['vpkp_value']);

  //get nilai mutu pekerjaan dan personal
  $this->db->where('vvh_id', $vvh_id);
  $hasil_mutu_pekerjaan =  $this->Vendor_m->getDataPenilaianMutu()->row_array();
  $data['nilai_mutu'] = str_replace('.', ',', $hasil_mutu_pekerjaan['vpm_answer']);

   //get nilai Pelayanan
  $this->db->where('vvh_id', $vvh_id);
  $pelayanan =  $this->Vendor_m->getVPIPelayanan()->row_array();
  $data['nilai_pelayanan'] = str_replace('.', ',', $pelayanan['vpp_value']);


