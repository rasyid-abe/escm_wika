<?php 

  $userdata = $this->session->all_userdata();
  $tenderid = $this->input->post("tenderid");

  $lowest_bid = $this->db
  ->where(array("ppm_id"=>$tenderid))
  ->order_by("tgl_bid","desc")
  ->limit(1)->get("prc_eauction_history")->row_array();

  $batas_atas = $this->db
        ->where("ppm_id",$tenderid)
        ->get("prc_eauction_header")
        ->row()->batas_atas;
        
  $data['lowest_bid'] = (isset($lowest_bid['jumlah_bid'])) ? inttomoney($lowest_bid['jumlah_bid']) : '-';

  echo json_encode($data);