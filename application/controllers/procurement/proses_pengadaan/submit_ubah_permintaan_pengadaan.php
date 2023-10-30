<?php

$post = $this->input->post();

$id = $post['id'];

$last_comment = $this->Comment_m->getProcurementPR("", $id)->row_array();

$pr_number = $last_comment['tender_id'];

$tender = $this->Procpr_m->getPR()->row_array();

$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if (!$position) {
  $this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

//haqim
$permintaan = $this->Procpr_m->getPR($pr_number)->row_array();
$perencanaan_id = (isset($post['perencanaan_pengadaan_inp'])) ? $post['perencanaan_pengadaan_inp'] : (!empty($permintaan) ? $permintaan['ppm_id'] : $tender['ppm_id']);
//end

$perencanaan = $this->Procplan_m->getPerencanaanPengadaan($perencanaan_id)->row_array();

$prhist = $this->Procplan_m->getHist($pr_number, $perencanaan_id)->row_array();

$lasthist = $this->Procplan_m->getHist("", $perencanaan_id)->row_array();

$error = false;

if ($last_comment['activity'] == 1000) {

  if ($post['status_inp'][0] == '287') {
  }

  $input['pr_subject_of_work'] = (isset($post['nama_pekerjaan'])) ? $post['nama_pekerjaan'] : $perencanaan['ppm_subject_of_work'];
  $input['pr_scope_of_work'] = (isset($post['deskripsi_pekerjaan'])) ? $post['deskripsi_pekerjaan'] : $perencanaan['ppm_scope_of_work'];
  $input['pr_pagu_anggaran'] = (isset($post['total_pagu_inp'])) ? $post['total_pagu_inp'] : $perencanaan['ppm_pagu_anggaran'];
  $input['pr_sisa_anggaran'] = $perencanaan['ppm_sisa_anggaran'];

  //haqim
  $input['pr_project_name'] = $perencanaan['ppm_project_name']; //y
  $input['pr_type_of_plan'] = $perencanaan['ppm_type_of_plan']; //y
  $input['pr_spk_code'] = $perencanaan['ppm_project_id'];
  $input['isjoin'] = (isset($post['joinpr'])) ? $post['joinpr'] : NULL; //y
  //end

  if (isset($post['perencanaan_pengadaan_inp'])) {
    $this->form_validation->set_rules("perencanaan_pengadaan_inp", "Nomor Perencanaan Pengadaan", 'required|max_length[' . DEFAULT_MAXLENGTH . ']');
  }

  if (isset($post['lokasi_kebutuhan_inp'])) {
    $this->form_validation->set_rules("lokasi_kebutuhan_inp", "Lokasi Kebutuhan", 'required|max_length[' . DEFAULT_MAXLENGTH_TEXT . ']');
    $input['pr_district_id'] = $post['lokasi_kebutuhan_inp'];
  }
  if (isset($post['lokasi_pengiriman_inp'])) {
    $input['pr_delivery_point_id'] = $post['lokasi_pengiriman_inp'];
  }
  if (isset($post['jenis_kontrak_inp'])) {
    $input['pr_contract_type'] = $post['jenis_kontrak_inp'];
  }

  if ($input['pr_sisa_anggaran'] < 0) {
    $this->setMessage("Sisa anggaran tidak boleh kurang dari 0");
    $error = true;
  }

  if ($post['status_inp'][0] == '287') {
  }

  //Menambahkan eksepsi validasi untuk pembuatan draft permintaan pengadaan
  if ($post['status_inp'][0] != '289') {
    if (!isset($post['item_kode'])) {
      $this->setMessage("Tidak ada item yang dipilih");
      if (!$error) {
        $error = true;
      }
    }
  }
}

if ($last_comment['activity'] == 1010 &&  $perencanaan['ppm_type_of_plan'] == "rkp") {

  $this->db->where("A.dept_id", $userdata['dept_id']);
  $logins = $this->Administration_m->getUserByJob("PELAKSANA PENGADAAN")->row_array();

  $input['pr_buyer'] = $logins['fullname'];
  $input['pr_buyer_id'] = $logins['employee_id'];
  $input['pr_buyer_pos_code'] = $logins['pos_id'];
  $input['pr_buyer_pos_name'] = $logins['pos_name'];
} elseif ($last_comment['activity'] == 1011) {

  $buyer = $this->Administration_m->getPosition("PELAKSANA PENGADAAN", $post['pelaksana']);
  $buyername = $this->Administration_m->get_employee($post['pelaksana'])->row_array();

  $input['pr_buyer'] = $buyername['fullname'];
  $input['pr_buyer_id'] = $buyer['employee_id'];
  $input['pr_buyer_pos_code'] = $buyer['pos_id'];
  $input['pr_buyer_pos_name'] = $buyer['pos_name'];
}

$pr_number = $last_comment['tender_id'];

$input_doc = array();

$input_item = array();

$tipe_pengadaan_header = isset($post['tipe_pengadaan']) ? $post['tipe_pengadaan'] : '';

$input_penilaian_risiko = array();

$input_item_detail = array();

$input_opportunity = array();

$n = 0;

$this->form_validation->set_rules("id", 'ID', 'required');

foreach ($post as $key => $value) {
  if (is_array($value)) {

    foreach ($value as $key2 => $value2) {

      $this->form_validation->set_rules($key . "[" . $key2 . "]", '', '');

      if (isset($post['doc_id_inp'][$key2])) {
        $input_doc[$key2]['ppd_id'] = $post['doc_id_inp'][$key2];
      }

      if (isset($post['doc_category_inp'][$key2])) {
        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length[' . DEFAULT_MAXLENGTH . ']');
        $input_doc[$key2]['ppd_category'] = $post['doc_category_inp'][$key2];
      }
      if (isset($post['doc_desc_inp'][$key2])) {
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length[' . DEFAULT_MAXLENGTH_TEXT . ']');
        $input_doc[$key2]['ppd_description'] = $post['doc_desc_inp'][$key2];
      }
      if (isset($post['doc_attachment_inp'][$key2])) {
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length[' . DEFAULT_MAXLENGTH . ']');
        $input_doc[$key2]['ppd_file_name'] = $post['doc_attachment_inp'][$key2];
      }

      if ($tipe_pengadaan_header == 'jasa') {
        if (isset($post['kategori_resiko_jasa'][$key2])) {
          $input_penilaian_risiko[$key2]['id'] = (isset($post['id'][$key2])) ? $post['id'][$key2] : '';
          $input_penilaian_risiko[$key2]['id_risiko'] = (isset($post['id_risiko'][$key2])) ? $post['id_risiko'][$key2] : '';
          $input_penilaian_risiko[$key2]['category_risiko'] = (isset($post['kategori_resiko_jasa'][$key2])) ? $post['kategori_resiko_jasa'][$key2] : '';
          $input_penilaian_risiko[$key2]['nilai_risiko'] = (isset($post['nilai_skala_resiko'][$key2])) ? $post['nilai_skala_resiko'][$key2] : 0;
          $input_penilaian_risiko[$key2]['bobot_risiko'] = (isset($post['bobot_jasa'][$key2])) ? $post['bobot_jasa'][$key2] : 0;
          $input_penilaian_risiko[$key2]['total_nilai_bobot'] = (isset($post['nilai_x_bobot'][$key2])) ? $post['nilai_x_bobot'][$key2] : 0;
          $input_penilaian_risiko[$key2]['lampiran_risiko'] = (isset($post['doc_attachment_inp_drup_jasa_' . $key2])) ? $post['doc_attachment_inp_drup_jasa_' . $key2] : '';
        }
      } else {
        if (isset($post['kategori_resiko_jasa_barang'][$key2])) {
          $input_penilaian_risiko[$key2]['id'] = (isset($post['id'][$key2])) ? $post['id'][$key2] : '';
          $input_penilaian_risiko[$key2]['id_risiko'] = (isset($post['id_risiko_barang'][$key2])) ? $post['id_risiko_barang'][$key2] : '';
          $input_penilaian_risiko[$key2]['category_risiko'] = (isset($post['kategori_resiko_jasa_barang'][$key2])) ? $post['kategori_resiko_jasa_barang'][$key2] : '';
          $input_penilaian_risiko[$key2]['nilai_risiko'] = (isset($post['nilai_skala_resiko_barang'][$key2])) ? $post['nilai_skala_resiko_barang'][$key2] : 0;
          $input_penilaian_risiko[$key2]['bobot_risiko'] = (isset($post['bobot_jasa_barang'][$key2])) ? $post['bobot_jasa_barang'][$key2] : 0;
          $input_penilaian_risiko[$key2]['total_nilai_bobot'] = (isset($post['nilai_x_bobot_barang'][$key2])) ? $post['nilai_x_bobot_barang'][$key2] : 0;
          $input_penilaian_risiko[$key2]['lampiran_risiko'] = (isset($post['doc_attachment_inp_drup_barang_' . $key2])) ? $post['doc_attachment_inp_drup_barang_' . $key2] : '';
        }
      }
    }

    $n++;
  }
}

if (isset($post['pengusul'])) {
  foreach ($post['pengusul'] as $key2 => $v) {
    if ($post['id_opportunity'][$key2]) {
      $input_opportunity[$key2]['id'] = (isset($post['id_opportunity'][$key2])) ? $post['id_opportunity'][$key2] : '';
    }
    $input_opportunity[$key2]['pengusul'] = (isset($post['pengusul'][$key2])) ? $post['pengusul'][$key2] : '';
    $input_opportunity[$key2]['area'] = (isset($post['area'][$key2])) ? $post['area'][$key2] : '';
    $input_opportunity[$key2]['opportunity'] = (isset($post['opportunity'][$key2])) ? $post['opportunity'][$key2] : '';
    $input_opportunity[$key2]['benefit'] = (isset($post['benefit'][$key2])) ? $post['benefit'][$key2] : '';
    $input_opportunity[$key2]['nilai_benefit'] = (isset($post['nilai_benefit'][$key2])) ? $post['nilai_benefit'][$key2] : 0;
    $input_opportunity[$key2]['probabilitas'] = (isset($post['probabilitas'][$key2])) ? $post['probabilitas'][$key2] : '';
    $input_opportunity[$key2]['rtl'] = (isset($post['rtl'][$key2])) ? $post['rtl'][$key2] : '';
    $input_opportunity[$key2]['biaya'] = (isset($post['biaya'][$key2])) ?  $post['biaya'][$key2] : 0;
    $input_opportunity[$key2]['hambatan'] = (isset($post['hambatan'][$key2]));
    $input_opportunity[$key2]['date_created'] = date('Y-m-d h:i:s');
    $input_opportunity[$key2]['created_by'] = $userdata['user_name'];
  }
}

if ($this->form_validation->run() == FALSE || $error) {

  $this->renderMessage("error");
} else {

  $this->db->trans_begin();

  $act = $this->Procpr_m->updateDataPR($pr_number,$input);

  $act = true;

  $complete_comment = 1;

  if ($act) {
    if (!empty($input_doc)) {

      $deleted_doc = array();

      foreach ($input_doc as $key => $value) {
        $value['pr_number'] = $pr_number;
        $id = (isset($value['ppd_id'])) ? $value['ppd_id'] : "";
        $act = $this->Procpr_m->replaceDokumenPR($id, $value);
        if ($act) {
          $deleted_doc[] = $act;
        }
      }
      $this->Procpr_m->deleteIfNotExistDokumenPR($pr_number, $deleted_doc);
    }

    if (!empty($input_opportunity)) {
      $deleted_opportunity = array();
      foreach ($input_opportunity as $key => $value) {
        $value['pr_number'] = $pr_number;
        $id = isset($value['id']) ? $value['id'] : '';
        $act = $this->Procpr_m->replaceOpportunity($id, $value);
        if ($act) {
          $deleted_opportunity[] = $act;
        }
      }
      $this->Procpr_m->deleteIfNotExistOpportunity($pr_number, $deleted_opportunity);
    }

    $response = $post['status_inp'][0];

    $com = $post['comment_inp'][0];

    $attachment = '';

    $buyerman = (isset($post['pelaksana'])) ? $post['pelaksana'] : NULL;
    $this->db->select('*');
    $this->db->from('prc_pr_main');
    $this->db->where('pr_number', $pr_number);
    $isSwakelola = $this->db->get()->row_array();

    $return = $this->Procedure_m->prc_pr_comment_complete($pr_number, $userdata['complete_name'], $last_comment['activity'], $response, $com, $attachment, $last_comment['comment_id'], $perencanaan_id, $userdata['employee_id'], $isSwakelola['isSwakelola'], $perencanaan['ppm_type_of_plan'], $isSwakelola['isjoin'], $buyerman, "");

    if ($last_comment['activity'] == 1000) {

      if ($return['nextactivity'] == 1010) { //next aprv
        $hist = array(
          'ppm_id' => $perencanaan_id,
          'pph_main' => $perencanaan['ppm_sisa_anggaran'],
          // 'pph_min' => $post['total_alokasi_ppn_inp'],
          // 'pph_remain' => $perencanaan['ppm_sisa_anggaran'] - $post['total_alokasi_ppn_inp'],
          'pph_date' => date("Y-m-d H:i:s"),
          'pph_desc' => $return['nextactivity'],
          'pph_first' => $pr_number,
          'pph_mod' => $pr_number
        );
        //potong anggaran
        // $angg = $perencanaan['ppm_sisa_anggaran'] - $post['total_alokasi_ppn_inp'];
        // $potong = $this->Procplan_m->updateDataPerencanaanPengadaan($perencanaan_id, array('ppm_sisa_anggaran' => $angg));
        //insert history anggaran
        $plan_hist = $this->Procplan_m->insertHist($hist);
      }
    } else {
      // $total_alokasi_ppn_inp = isset($post['total_alokasi_ppn_inp']) ? $post['total_alokasi_ppn_inp'] : 0;
      if ($return['nextactivity'] == 1000 || $return['nextactivity'] == 1904) { //revisi or batal PR
        $histbatal = array(
          'ppm_id' => $perencanaan_id,
          'pph_main' => $perencanaan['ppm_sisa_anggaran'],
          // 'pph_plus' => $total_alokasi_ppn_inp,
          // 'pph_remain' => $perencanaan['ppm_sisa_anggaran'] + $total_alokasi_ppn_inp,
          'pph_date' => date("Y-m-d H:i:s"),
          'pph_desc' => $return['nextactivity'],
          'pph_first' => $pr_number,
          'pph_mod' => $pr_number
        );
        // $revang = $total_alokasi_ppn_inp + $perencanaan['ppm_sisa_anggaran'];
        // $back = $this->Procplan_m->updateDataPerencanaanPengadaan($perencanaan_id, array('ppm_sisa_anggaran' => $revang));
        $planhist = $this->Procplan_m->insertHist($histbatal);

        //histori volume batal atau revisi
        $check_vol = $this->Procplan_m->getVolumeHist("", $perencanaan_id, $pr_number)->result_array();
        if (count($check_vol) > 0) {
          $getVolItem = $this->Procpr_m->getItemPR("", $pr_number)->result_array();
          foreach ($getVolItem as $key => $vol_value) {
            $getVolumeHist = $this->Procplan_m->getVolumeHist($vol_value['ppi_code'], $perencanaan_id, $pr_number)->row_array();
            $getLastVolume = $this->Procplan_m->getVolumeHist($vol_value['ppi_code'], $perencanaan_id)->row_array();

            $dataVolume = array(
              'ppm_id' => $getVolumeHist['ppm_id'],
              'ppv_main' => $getLastVolume['ppv_remain'],
              'ppv_minus' => 0,
              'ppv_plus' => $getVolumeHist['ppv_minus'],
              'ppv_remain' => ($getLastVolume['ppv_remain'] + $getVolumeHist['ppv_minus']),
              'ppv_activity' =>  $return['nextactivity'],
              'ppv_no' => $pr_number,
              'ppv_smbd_code' => $getVolumeHist['ppv_smbd_code'],
              'ppv_unit' => $getVolumeHist['ppv_unit'],
              'ppv_prc' => $getVolumeHist['ppv_prc'],
              'created_datetime' => date("Y-m-d H:i:s"),
            );

            $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
          }
        }
        //end

      } else { //to rfq or join pr

        $rfqorpr = ($return['newnumber'] != "0") ? $return['newnumber'] : $pr_number;
        $hist = array(
          'pph_desc' => $return['nextactivity'],
          'pph_mod' => $rfqorpr
        );
        //update history anggaran
        $plan_hist = $this->Procplan_m->updateHist($pr_number, $hist);

        //histori volume lanjut rfq
        $check_vol = $this->Procplan_m->getVolumeHist("", $perencanaan_id, $pr_number)->result_array();
        if (count($check_vol) > 0) {
          $getVolItem = $this->Procpr_m->getItemPR("", $pr_number)->result_array();
          foreach ($getVolItem as $key => $vol_value) {
            $getVolumeHist = $this->Procplan_m->getVolumeHist($vol_value['ppi_code'], $perencanaan_id, $pr_number)->row_array();
            $getLastVolume = $this->Procplan_m->getVolumeHist($vol_value['ppi_code'], $perencanaan_id)->row_array();

            $dataVolume = array(
              'ppm_id' => $getVolumeHist['ppm_id'],
              'ppv_main' => $getLastVolume['ppv_main'],
              'ppv_minus' => 0,
              'ppv_plus' => 0,
              'ppv_remain' => ($getLastVolume['ppv_remain']),
              'ppv_activity' =>  $return['nextactivity'],
              'ppv_no' => $return['newnumber'],
              'ppv_smbd_code' => $getVolumeHist['ppv_smbd_code'],
              'ppv_unit' => $getVolumeHist['ppv_unit'],
              'ppv_prc' => "RFQ",
              'created_datetime' => date("Y-m-d H:i:s"),
            );

            $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
          }
        }
        //end
      }
    }

    if (!empty($return['nextactivity'])) {

      if (!empty($return['newnumber'])) {
        $comment = $this->Comment_m->insertProcurementRFQ($return['newnumber'], $return['nextactivity'], "", "", "", $return['nextposcode'], $return['nextposname']);
      } else {
        $comment = $this->Comment_m->insertProcurementPR($pr_number, $return['nextactivity'], "", "", "", $return['nextposcode'], $return['nextposname']);
      }
    } else {
    }
  }

  if ($this->db->trans_status() === FALSE) {
    $this->setMessage("Gagal mengubah data");
    $this->db->trans_rollback();
  } else {
    $this->setMessage("Sukses mengubah data");
    $this->db->trans_commit();
  }

  $this->renderMessage("success", site_url("procurement/daftar_pekerjaan"));
}
