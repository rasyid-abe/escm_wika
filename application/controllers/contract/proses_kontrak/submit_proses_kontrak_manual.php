<?php

    $error = false;

    $post = $this->input->post();

    $ptm_number = $this->Procrfq_m->getUrutRFQ();

    $userdata = $this->data['userdata'];

    $vendor_id = 0;
    $vendor_name = '';
    $siup_type = '';

    $vendor_inp = preg_replace('[\D]', '', $post['vendor_inp']);

    $this->db->where('vendor_id', (int)$vendor_inp);
    $getVendor = $this->db->get("vnd_header")->row_array();

    $this->db->trans_begin();

    if ($vendor_inp == NULL && $post['vendor_name_inp'] == NULL) {
        $this->setMessage("Vendor belum dipilih");

        if(!$error){
          $error = true;
        }
    }

    if ($vendor_inp != NULL && $post['vendor_name_inp'] != NULL) {
        $this->setMessage("Pilih salah satu vendor");

        if(!$error){
          $error = true;
        }
    }

    if ($vendor_inp != NULL && $post['vendor_name_inp'] == NULL) {
        $vendor_name = $getVendor['vendor_name'];
        $vendor_id = $vendor_inp;
    }

    // vendor
    if ($vendor_inp == NULL && $post['vendor_name_inp'] != NULL) {
        $this->db->select_max("vendor_id");
        $get = $this->db->get("vnd_header")->row_array();
        $vendor_id = $get['vendor_id']+1;
        $vendor_name = $post['vendor_name_inp'];

        if ($post['npwp_inp'] == NULL || $post['email_vendor_inp'] == NULL || $post['tipe_perusahaan_inp'] == NULL) {
          $this->setMessage("Isi data vendor dengan lengkap");

          if(!$error){
            $error = true;
          }
        }

        if ($post['tipe_perusahaan_inp'] != NULL) {
          if ($post['tipe_perusahaan_inp'] == 'B') {
              $siup_type = 'Besar';
          } else if ($post['tipe_perusahaan_inp'] == 'M') {
              $siup_type = 'Menengah';
          } else if ($post['tipe_perusahaan_inp'] == 'K') {
              $siup_type = 'Kecil';
          } else if ($post['tipe_perusahaan_inp'] == 'I') {
              $siup_type = 'Mikro';
          }
        }

        $inputVendor = array(
          'vendor_id' => $vendor_id,
          'vendor_name' => $post['vendor_name_inp'],
          'login_id' => $post['email_vendor_inp'],
          'email_address' => $post['email_vendor_inp'],
          'address_country' => "INDONESIA",
          'addres_prop' => $post['prop_inp'],
          'address_city' => $post['city_inp'],
          'address_district' => $post['district_inp'],
          'address_village' => $post['village_inp'],
          'project_category' => $post['kategori_proyek_inp'],
          'address_street' => $post['alamat_vendor_inp'],
          'npwp_no' => $post['npwp_inp'],
          'fin_class' => $post['tipe_perusahaan_inp'],
          'siup_type' => $siup_type,
          'vnd_jenis' => 'E-SCM',
          'status' => 11,
          'reg_status_id' => 13,
          'creation_date' => date("Y-m-d H:i:s"),
          'modified_by' => $userdata['complete_name']
        );

        $this->db->insert("vnd_header", $inputVendor);
    }

    //contract header
    $inputHeader = array(
        'ptm_number' => $ptm_number,
        'subject_work' => $post['subject_work_inp'],
        'scope_work' => $post['scope_work_inp'],
        'vendor_id' => $vendor_id,
        'vendor_name' => $vendor_name,
        'sign_date' => date("Y-m-d H:i:s"),
        'start_date' => $post['tgl_mulai_inp']. ' 00:00:00',
        'end_date' => $post['tgl_akhir_inp']. ' 00:00:00',
        'contract_type' => $post['tipe_kontrak_inp'],
        'currency' => $post['mata_uang_inp'],
        'contract_amount' => moneytoint($post['nilai_kontrak_inp']),
        'status' => 2010,
        'ctr_currency' => $post['mata_uang_inp'],
        'ctr_item_type' => $post['item_kontrak_inp'],
        'dept_id' => $post['dept_id_inp'],
        'ctr_jenis' => 'MANUAL',
        'kategori_pekerjaan' => $post['kategori_pekerjaan_inp'],
        'type_winner' => $post['type_winner_inp'],
        'created_date' => date("Y-m-d H:i:s"),
        'ctr_spe_employee' => $userdata['employee_id'],
        'ctr_spe_pos' => $userdata['pos_id']
    );

    $this->db->insert("ctr_contract_header", $inputHeader);

    $contract_id = $this->db->insert_id();

    // tender main
    $inputTender = array(
        'ptm_number' => $ptm_number,
        'ptm_requester_name' => $post['request_name_inp'],
        'pr_number' => $ptm_number,
        'ptm_requester_pos_code' => $post['pos_id_inp'],
        'ptm_requester_pos_name' => $post['pos_name_inp'],
        'ptm_created_date' => date("Y-m-d H:i:s"),
        'ptm_subject_of_work' => $post['subject_work_inp'],
        'ptm_scope_of_work' => $post['scope_work_inp'],
        'ptm_district_id' => $post['district_id_inp'],
        'ptm_district_name' => $post['district_name_inp'],
        'ptm_buyer' => $post['request_name_inp'],
        'ptm_buyer_pos_code' => $post['pos_id_inp'],
        'ptm_buyer_pos_name' => $post['pos_name_inp'],
        'ptm_currency' => $post['mata_uang_inp'],
        'ptm_contract_type' => $post['item_kontrak_inp'],
        'ptm_dept_id' => $post['dept_id_inp'],
        'ptm_dept_name' => $post['dept_name_inp'],
        'ptm_buyer_id' => $post['user_id_inp'],
        'ptm_project_name' => $post['nama_pekerjaan_inp'],
        'ptm_packet' => $post['subject_work_inp'],
        'spk_code' => $post['spk_code_inp'],
    );

    $this->db->insert("prc_tender_main", $inputTender);

    $input_item = array();
    $input_item_rfq = array();
    $input_doc = array();
    $input_jaminan = array();
    $input_milestone = array();
    $input_person = array();
    $input_detail_item = array();
    $input_risiko = array();

    $n = 0;

    foreach ($post as $key => $value) {

      if(is_array($value)){

        foreach ($value as $key2 => $value2) {

          if(isset($post['item_kode'][$key2])){
            $input_item[$key2]['item_code'] = $post['item_kode'][$key2];
            $input_item[$key2]['short_description'] = $post['item_deskripsi'][$key2];
            $input_item[$key2]['long_description'] = $post['item_deskripsi'][$key2];
            $input_item[$key2]['qty'] = $post['item_jumlah'][$key2];
            $input_item[$key2]['max_qty'] = $post['item_jumlah'][$key2];
            $input_item[$key2]['uom'] = $post['item_satuan'][$key2];
            $input_item[$key2]['sub_total'] = $post['item_subtotal'][$key2];
            $input_item[$key2]['price'] = $post['item_harga_satuan'][$key2];
            $input_item[$key2]['vendor_code'] = $vendor_id;

            $input_item[$key2]['incoterm'] = $post['incoterm'][$key2];
            $input_item[$key2]['lokasi_incoterm'] = $post['lokasi_incoterm'][$key2];
            $input_item[$key2]['hps'] = $post['hps'][$key2];
            $input_item[$key2]['lampiran'] = $post['doc_attachment_inp_'][$key2];

            $input_item_rfq[$key2]['tit_code'] = $post['item_kode'][$key2];
            $input_item_rfq[$key2]['ptm_number'] = $ptm_number;
            $input_item_rfq[$key2]['tit_description'] = $post['item_deskripsi'][$key2];
            $input_item_rfq[$key2]['tit_quantity'] = $post['item_jumlah'][$key2];
            $input_item_rfq[$key2]['tit_unit'] = $post['item_satuan'][$key2];
            $input_item_rfq[$key2]['tit_price'] = $post['item_harga_satuan'][$key2];
            $input_item_rfq[$key2]['tit_currency'] = 'IDR';
            $input_item_rfq[$key2]['ptv_vendor_code'] = $vendor_id;
            $input_item_rfq[$key2]['tit_spk_code'] = $post['item_kode'][$key2];

          }

          if(isset($post['doc_id_inp'][$key2])){
            $input_doc[$key2]['doc_id'] = $post['doc_id_inp'][$key2];
          }
          if(isset($post['doc_desc'][$key2])){
            $this->form_validation->set_rules("doc_desc[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
            $input_doc[$key2]['description']= $post['doc_desc'][$key2];
          }
          if(isset($post['doc_attachment'][$key2])){
            $this->form_validation->set_rules("doc_attachment[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
            $input_doc[$key2]['filename']= $post['doc_attachment'][$key2];
          }
          if(isset($post['doc_vendor'][$key2])){
            $this->form_validation->set_rules("doc_vendor[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
            $input_doc[$key2]['publish']= $post['doc_vendor'][$key2];
          }
          if(isset($post['doc_name'][$key2])){
            $this->form_validation->set_rules("doc_name[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
            $input_doc[$key2]['name_input']= $post['doc_name'][$key2];
          }
          if(isset($post['doc_req_e_sign'][$key2])){
            $this->form_validation->set_rules("doc_req_e_sign[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
            $input_doc[$key2]['req_e_sign']= $post['doc_req_e_sign'][$key2];
          }
          if(isset($post['doc_name'][$key2])){
            $input_doc[$key2]['upload_date']= date('Y-m-d h:i:s');
          }
          if(isset($post['doc_id_inp'][$key2])){
            $input_doc[$key2]['doc_id'] = $post['doc_id_inp'][$key2];
          }
          if(isset($post['doc_desc'][$key2])){
            $this->form_validation->set_rules("doc_desc[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
            $input_doc[$key2]['description']= $post['doc_desc'][$key2];
          }
          if(isset($post['doc_attachment'][$key2])){
            $this->form_validation->set_rules("doc_attachment[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
            $input_doc[$key2]['filename']= $post['doc_attachment'][$key2];
          }
          if(isset($post['doc_vendor'][$key2])){
            $this->form_validation->set_rules("doc_vendor[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
            $input_doc[$key2]['publish']= $post['doc_vendor'][$key2] == 'YA' ? '1' : '0';
          }
          if(isset($post['doc_name'][$key2])){
            $this->form_validation->set_rules("doc_name[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
            $input_doc[$key2]['name_input']= $post['doc_name'][$key2];
          }
          if(isset($post['doc_name'][$key2])){
            $input_doc[$key2]['upload_date']= date('Y-m-d h:i:s');
          }
          if(isset($post['deskripsi_milestone'][$key2])){

            $this->form_validation->set_rules("deskripsi_milestone[$key2]", "Deskripsi Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

            if(!empty($post['milestone_id'][$key2])){
              $input_milestone[$key2]['milestone_id']=$post['milestone_id'][$key2];
            }

            $input_milestone[$key2]['percentage']=moneytoint($post['bobot_milestone'][$key2]);
            $input_milestone[$key2]['description']=$post['deskripsi_milestone'][$key2];
            $input_milestone[$key2]['target_date']=$post['tanggal_milestone'][$key2];
            $input_milestone[$key2]['milestone_file']=$post['milestone_file'][$key2];
            $input_milestone[$key2]['nilai']=moneytoint($post['nilai_milestone'][$key2]);
          }
          if(isset($post['jenis_jaminan'][$key2])){

            $this->form_validation->set_rules("jenis_jaminan[$key2]", "Jenis Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

            if(!empty($post['jaminan_id'][$key2])){
              $input_jaminan[$key2]['id']=$post['jaminan_id'][$key2];
            }

            $input_jaminan[$key2]['cj_jenis_jaminan']=$post['jenis_jaminan'][$key2];
            $input_jaminan[$key2]['cj_tipe_jaminan']=$post['tipe_jaminan'][$key2];
            $input_jaminan[$key2]['cj_nama_perusahaan']=$post['nama_perusahaan'][$key2];
            $input_jaminan[$key2]['cj_nomor_jaminan']=$post['nomor_jaminan'][$key2];
            $input_jaminan[$key2]['cj_alamat']=$post['alamat'][$key2];
            $input_jaminan[$key2]['cj_date_start']=$post['mulai_berlaku'][$key2];
            $input_jaminan[$key2]['cj_date_end']=$post['berlaku_hingga'][$key2];
            $input_jaminan[$key2]['cj_lampiran']=$post['jaminan_file'][$key2];
            $input_jaminan[$key2]['cj_nilai']=moneytoint($post['nilai'][$key2]);
            $input_jaminan[$key2]['cj_created_by']=$userdata['employee_id'][$key2];
            $input_jaminan[$key2]['cj_created_date']=date('Y-m-d h:i:s');
          }
          if(isset($post['jabatan'][$key2])){

            $this->form_validation->set_rules("user[$key2]", "Nama Lengkap #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

            if(!empty($post['person_id'][$key2])){
              $input_person[$key2]['id']=$post['person_id'][$key2];
            }

            if(!empty($post['user'][$key2])){
              $input_person[$key2]['cp_nama_lengkap']=$post['user'][$key2];
            }

            if(!empty($post['user_manual'][$key2])){
              $input_person[$key2]['cp_nama_lengkap']=$post['user_manual'][$key2];
            }
            $input_person[$key2]['cp_jabatan']=$post['jabatan'][$key2];
            $input_person[$key2]['cp_divisi']=$post['divisi'][$key2];
            $input_person[$key2]['cp_nama_perusahaan']=$post['perusahaan'][$key2];
            $input_person[$key2]['cp_no_telp']=$post['telp'][$key2];
            $input_person[$key2]['cp_email']=$post['email'][$key2];
            $input_person[$key2]['cp_note']=$post['person_keterangan'][$key2];
            $input_person[$key2]['cp_created_by']=$userdata['employee_id'][$key2];
            $input_person[$key2]['cp_created_date']=date('Y-m-d h:i:s');
          }

          if (!empty($post['rsd_item_tbl'][$key2])) {
            $input_detail_item[$key2]['rsd_item'] = (isset($post['rsd_item_tbl'][$key2])) ? $post['rsd_item_tbl'][$key2] : '';
            $input_detail_item[$key2]['rsd_keterangan'] = (isset($post['rsd_keterangan_tbl'][$key2])) ? $post['rsd_keterangan_tbl'][$key2] : '';
            $input_detail_item[$key2]['rsd_volume'] = (isset($post['rsd_volume_tbl'][$key2])) ? $post['rsd_volume_tbl'][$key2] : '';
            $input_detail_item[$key2]['rsd_satuan'] = (isset($post['rsd_satuan_tbl'][$key2])) ? $post['rsd_satuan_tbl'][$key2] : '';
            $input_detail_item[$key2]['rsd_harga_satuan'] = (isset($post['rsd_harga_satuan_tbl'][$key2])) ? $post['rsd_harga_satuan_tbl'][$key2] : '';
            $input_detail_item[$key2]['rsd_subtotal'] = (isset($post['rsd_subtotal_tbl'][$key2])) ? $post['rsd_subtotal_tbl'][$key2] : '';
          }

          if (isset($post['kategori'][$key2])) {
            $input_risiko[$key2]['kategori'] = (isset($post['kategori'][$key2])) ? $post['kategori'][$key2] : '';
            $input_risiko[$key2]['risiko'] = (isset($post['risiko'][$key2])) ? $post['risiko'][$key2] : '';
            $input_risiko[$key2]['penyebab'] = (isset($post['penyebab'][$key2])) ? $post['penyebab'][$key2] : '';
            $input_risiko[$key2]['dampak'] = (isset($post['dampak'][$key2])) ? $post['dampak'][$key2] : '';
            $input_risiko[$key2]['rating_probabilitas'] = (isset($post['rating_probabilitas'][$key2])) ? $post['rating_probabilitas'][$key2] : '';
            $input_risiko[$key2]['rating_dampak'] = (isset($post['rating_dampak'][$key2])) ? $post['rating_dampak'][$key2] : '';
            $input_risiko[$key2]['level_risiko'] = (isset($post['level_risiko'][$key2])) ? $post['level_risiko'][$key2] : '';
            $input_risiko[$key2]['pic'] = (isset($post['pic'][$key2])) ? $post['pic'][$key2] : '';
            $input_risiko[$key2]['mitigasi'] = (isset($post['mitigasi'][$key2])) ? $post['mitigasi'][$key2] : '';
            $input_risiko[$key2]['date_created'] = date('Y-m-d h:i:s');
            $input_risiko[$key2]['created_by'] = $userdata['user_name'];
          }
        }

        $n++;

      }

    }

    // comment
    $spew = array(
        "job_title" => "PENGELOLA KONTRAK",
        "dept_id" => $post['dept_id_inp']
    );

    $getdata = $this->db->select("pos_id, pos_name, employee_id")
                ->where($spew)
                ->get("user_login_rule")
                ->row_array();

    $inputComment = array(
        'ptm_number' => $ptm_number,
        'contract_id' => $contract_id,
        'ccc_response' => 'Simpan dan Lanjutkan',
        'ccc_name' => $userdata['complete_name'],
        'ccc_end_date' => date("Y-m-d H:i:s"),
        'ccc_activity' => 2010,
        'ccc_user' => $userdata['employee_id'],
        'ccc_comment' => 'Pembuatan Kontrak Manual',
        'ccc_position' => $getdata['pos_name'],
        'ccc_pos_code' => $getdata['pos_id'],
        'ccc_start_date' => date("Y-m-d H:i:s"),
    );

    $insert_first_comment = $this->db->insert("ctr_contract_comment", $inputComment);

    $getdataNext = $this->Procedure2_m->getNextState(
      "hap_pos_code",
      "hap_pos_name",
      "vw_prc_hierarchy_approval_10",
      "hap_pos_code = (select distinct hap_pos_parent
          from vw_prc_hierarchy_approval_10 where hap_pos_code = ".$getdata['pos_id']." AND hap_pos_parent IS NOT NULL)");

    if($insert_first_comment){
      $comment = $this->Comment_m->insertContract($ptm_number,"2027","","","",$getdataNext['nextPosCode'],$getdataNext['nextPosName'],$contract_id,NULL);

      $check_vol = $this->Procplan_m->getVolumeHist("", $post['ppm_id'])->result_array();
      if (count($check_vol) > 0) {

          foreach ($post['item_kode'] as $key2 => $value2) {

              $getVolumeHist = $this->Procplan_m->getVolumeHist($post['item_kode'][$key2], $post['ppm_id'])->row_array();

              $dataVolume = array(
                  'ppm_id' => $post['ppm_id'],
                  'ppv_main' => $getVolumeHist['ppv_main'],
                  'ppv_minus' => $post['item_jumlah'][$key2],
                  'ppv_remain' => ($getVolumeHist['ppv_main'] - $post['item_jumlah'][$key2]),
                  'ppv_activity' => 2027,
                  'ppv_no' => $ptm_number,
                  'ppv_smbd_code' => $post['item_kode'][$key2],
                  'ppv_unit' => $getVolumeHist['ppv_unit'],
                  'ppv_prc' => "CTR",
                  'created_datetime' => date("Y-m-d H:i:s"),
              );

              $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
          }
      }
    }

    // end comment

    if(!empty($input_item)){
      foreach ($input_item as $key => $value) {
          $value['contract_id'] = $contract_id;
          $this->Contract_m->insertItem($value);
      }
    }

    if(!empty($input_item_rfq)){

      $deleted = array();

      foreach ($input_item_rfq as $key => $value) {
        $value['ptm_number'] = $ptm_number;
        $act = $this->Procrfq_m->replaceItemRFQ($key,$value);
        if($act){
          $deleted[] = $act;
        }
      }

      $this->Procrfq_m->deleteIfNotExistItemRFQ($ptm_number,$deleted);

    }

    if(!empty($input_doc)){
      foreach ($input_doc as $key => $value) {
          $value['contract_id'] = $contract_id;
          $this->db->insert("ctr_contract_doc",$value);
      }
    }

    if(!empty($input_milestone)){
      foreach ($input_milestone as $key => $value) {
          $value['contract_id'] = $contract_id;
          $this->db->insert("ctr_contract_milestone", $value);
      }
    }

    if(!empty($input_jaminan)){
      foreach ($input_jaminan as $key => $value) {
          $value['cj_contract_id'] = $contract_id;
          $this->db->insert("ctr_jaminan", $value);
      }
    }

    if(!empty($input_person)){
      foreach ($input_person as $key => $value) {
          $value['cp_contract_id'] = $contract_id;
          $this->db->insert("ctr_person_in_charge", $value);
      }
    }

    if(!empty($input_detail_item)){
      foreach ($input_detail_item as $key => $value) {
          $value['pr_number'] = $ptm_number;
          $this->db->insert("prc_risiko_detail", $value);
      }
    }

    if(!empty($input_detail_item)){
      foreach ($input_detail_item as $key => $value) {
          $value['pr_number'] = $ptm_number;
          $this->db->insert("prc_risiko_detail", $value);
      }
    }

    foreach ($input_risiko as $key => $value) {
      $value['pr_number'] = $ptm_number;
      // insert section risiko
      $this->db->insert("prc_risiko", $value);
    }

    if(!$error){
      if ($this->db->trans_status() === FALSE)  {
        $this->setMessage("Gagal mengubah data");
        $this->db->trans_rollback();
      }
      else  {
        $this->setMessage("Sukses mengubah data");
        $this->db->trans_commit();
      }

      $this->renderMessage("success",site_url("contract/monitor/monitor_kontrak"));
    }

    else {
      $this->renderMessage("error");
    }

?>
