<?php

  $get_data_bobot = $this->Administration_m->getTargetdanBobotKompilasiVPI('',$vvh_tipe)->result_array();
  $data['data_bobot'] = [];
  $arrayNew = array();
  if (empty($get_data_bobot)) {
    $arrayNew['target_ketepatan_progress'] = 0;
    $arrayNew['target_hasil_mutu_pekerjaan'] = 0;
    $arrayNew['target_k3l'] = 0;
    $arrayNew['target_5r'] = 0;
    $arrayNew['target_pengamanan'] = 0;
    $arrayNew['bobot_ketepatan_progress'] = 0;
    $arrayNew['bobot_hasil_mutu_pekerjaan'] = 0;
    $arrayNew['bobot_k3l'] = 0;
    $arrayNew['bobot_5r'] = 0;
    $arrayNew['bobot_pengamanan'] = 0;
    $data['total_target'] = 0;
    $data['total_bobot'] = 0;
  }else{

      foreach ($get_data_bobot as $key => $value) {
      if (empty($value['abt_value'])) {
        $value['abt_value'] = 0;
      }
      $arrayNew[$value['abt_indicator']] = str_replace('.', ',', $value['abt_value']); 
    }

    $arrayNew['target_ketepatan_progress'] = isset($arrayNew['target_ketepatan_progress']) ? $arrayNew['target_ketepatan_progress'] : 0;
    $arrayNew['target_hasil_mutu_pekerjaan'] = isset($arrayNew['target_hasil_mutu_pekerjaan']) ? $arrayNew['target_hasil_mutu_pekerjaan'] : 0;
    $arrayNew['target_k3l'] = isset($arrayNew['target_k3l']) ? $arrayNew['target_k3l'] : 0;
    $arrayNew['target_5r'] = isset($arrayNew['target_5r']) ? $arrayNew['target_5r'] : 0;
    $arrayNew['target_pengamanan'] = isset($arrayNew['target_pengamanan']) ? $arrayNew['target_pengamanan'] : 0;

    $arrayNew['bobot_ketepatan_progress'] = isset($arrayNew['bobot_ketepatan_progress']) ? $arrayNew['bobot_ketepatan_progress'] : 0;
    $arrayNew['bobot_hasil_mutu_pekerjaan'] = isset($arrayNew['bobot_hasil_mutu_pekerjaan']) ? $arrayNew['bobot_hasil_mutu_pekerjaan'] : 0;
    $arrayNew['bobot_k3l'] = isset($arrayNew['bobot_k3l']) ? $arrayNew['bobot_k3l'] : 0;
    $arrayNew['bobot_5r'] = isset($arrayNew['bobot_5r']) ? $arrayNew['bobot_5r'] : 0;
    $arrayNew['bobot_pengamanan'] = isset($arrayNew['bobot_pengamanan']) ? $arrayNew['bobot_pengamanan'] : 0;

    $total_target = array(
      str_replace(',', '.', $arrayNew['target_ketepatan_progress']),
      str_replace(',', '.', $arrayNew['target_hasil_mutu_pekerjaan']),
      str_replace(',', '.', $arrayNew['target_k3l']),
      str_replace(',', '.', $arrayNew['target_5r']),
      str_replace(',', '.', $arrayNew['target_pengamanan'])
    );

    $total_bobot = array(
      str_replace(',', '.', $arrayNew['bobot_ketepatan_progress']),
      str_replace(',', '.', $arrayNew['bobot_hasil_mutu_pekerjaan']),
      str_replace(',', '.', $arrayNew['bobot_k3l']),
      str_replace(',', '.', $arrayNew['bobot_5r']),
      str_replace(',', '.', $arrayNew['bobot_pengamanan'])
    );

    $data['total_target'] = array_sum($total_target);
    $data['total_bobot'] = array_sum($total_bobot);

  }

  array_push($data['data_bobot'] , $arrayNew);
  $data['data_bobot'] = $data['data_bobot'][0];

  $this->db->where('ahm_status', 'A');
  $data['mutu_pekerjaan'] =  $this->Administration_m->getHasilMutuPekerjaan("",$vvh_tipe)->result_array();

  $this->db->where('ak_status', 'A');
  $data['k3l'] =  $this->Administration_m->getK3l("",$vvh_tipe)->result_array();

  $this->db->where('ar_status', 'A');
  $data['5r'] =  $this->Administration_m->get5r("",$vvh_tipe)->result_array();

  $this->db->where('ap_status', 'A');
  $data['pengamanan'] =  $this->Administration_m->getPengamanan("",$vvh_tipe)->result_array();

  $prev_data = $this->Vendor_m->getVPIKompilasi($vvh_id)->row_array();
  $data['prev_data'] = $prev_data;

  //get nilai ketepatan progress
  $this->db->where('vvh_id', $vvh_id);
  $ketepatan_progress =  $this->Vendor_m->getDataPenilaianKetepatanProgress()->row_array();
  $data['nilai_ketepatan_progress'] = str_replace(',', '.', $ketepatan_progress['vpkp_value']);

  //get nilai hasil mutu pekerjaan
  $this->db->where('vvh_id', $vvh_id);
  $hasil_mutu_pekerjaan =  $this->Vendor_m->getDataPenilaianMutu()->row_array();
  $data['nilai_mutu_pekerjaan'] = str_replace(',', '.', $hasil_mutu_pekerjaan['vpm_answer']);

   //get nilai K3L dan 5R
  $this->db->where('vvh_id', $vvh_id);
  $k3l_5r =  $this->Vendor_m->getVPIK3l5r()->row_array();
  $data['nilai_k3l'] = str_replace(',', '.', $k3l_5r['vvk_k3l_value']);
  $data['nilai_5r'] = str_replace(',', '.', $k3l_5r['vvk_5r_value']);

  //get nilai pengamanan
  $this->db->where('vvh_id', $vvh_id);
  $pengamanan =  $this->Vendor_m->getVPIPengamanan()->row_array();
  $data['nilai_pengamanan'] = str_replace(',', '.', $pengamanan['vvp_value']);