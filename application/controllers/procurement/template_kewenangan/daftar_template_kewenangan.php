<?php 
  $view = 'procurement/template_kewenangan/daftar_template_kewenangan_v';
  $data = array();

  $tipeUskep[0]['code'] = 'BAKP';
  $tipeUskep[0]['name'] = 'BAKP';
  $tipeUskep[1]['code'] = 'PENILAIAN';
  $tipeUskep[1]['name'] = 'PENILAIAN';
  // $tipeUskep[2]['code'] = 'DEPKN';
  // $tipeUskep[2]['name'] = 'DEPKN';

  $tipePengadaan[0]['name'] = 'PROYEK';
  $tipePengadaan[1]['name'] = 'NON PROYEK';

  $tipeProyek[0]['name'] = 'KECIL';
  $tipeProyek[1]['name'] = 'MENENGAH';
  $tipeProyek[2]['name'] = 'BESAR';

  $tipePlan[0]['code'] = 'rkp';
  $tipePlan[0]['name'] = 'PROYEK';

  $tipePlan[1]['code'] = 'rkp_matgis';
  $tipePlan[1]['name'] = 'MATGIS';

  $tipePlan[2]['code'] = 'rkap';
  $tipePlan[2]['name'] = 'NON PROYEK';

  $tipeKontrakMatgis[0]['code'] = 'p';
  $tipeKontrakMatgis[0]['name'] = 'PAYUNG';

  $tipeKontrakMatgis[1]['code'] = 's';
  $tipeKontrakMatgis[1]['name'] = 'SPOT';



  $data['tipe_uskep'] = json_encode($tipeUskep);
  $divisi = $this->db->get('vw_dept')->result_array();
  $data['divisi'] = json_encode($divisi);
  $data['tipe_pengadaan'] = json_encode($tipePengadaan);
  $data['tipe_proyek'] = json_encode($tipeProyek);
  $data['tipe_plan'] = json_encode($tipePlan);
  $data['tipe_kontrak_matgis'] = json_encode($tipeKontrakMatgis);


  $this->template($view,"Daftar Template Kewenangan",$data);
?>