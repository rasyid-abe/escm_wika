<?php 

  $view = 'procurement/template_kewenangan/detail_template_kewenangan_v';

  $data = array();

  $id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

  $data['id'] = $id;

  $this->db->where('id', $id);
  $header = $this->db->get('adm_matriks_kegiatan')->row_array();


  $this->db->where('kegiatan_id', $id);
  $this->db->order_by('order_no', 'asc');
  
  $detail = $this->db->get('adm_matriks_kewenangan_kegiatan')->result_array();

  //$this->db->where('dept_id', $header['divisi']);
  $adm_pos = $this->db->get('adm_jobtitle')->result_array();
  $fungsi_bidang = $this->db->get('adm_emp_fungsi_bidang')->result_array();
  $posisi = $this->db->get('vw_hcis_posisi')->result_array();

  $data['data'] = $header;

  $data['detail'] = $detail;
  $data['adm_pos'] = json_encode($adm_pos);
  $data['fungsi_bidang'] = json_encode($fungsi_bidang);
  $data['posisi'] = json_encode($posisi);


  $plan= "";
  if($header['tipe_plan'] == "rkp")
  {
    $plan = "PROYEK";

  } else if ($header['tipe_plan'] == "rkp_matgis")
  {
    $plan = "MATGIS";

  } else {
    $plan = "NON PROYEK";
  }
  

  $this->template($view,"Detail Template Kewenangan Komisi ".$header['komisi'].' '.$header['tipe_proyek'].' Plan '.$plan,$data);