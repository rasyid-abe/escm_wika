<?php

    $error = false;

    $post = $this->input->post();

    $id = $post['id'];

    $last_comment = $this->Comment_m->getContract("",$id,"")->row_array();

    $last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 2000;

    $ptm_number = $last_comment['tender_id'];

    $this->db->select('pr_number');
    $this->db->where('ptm_number', $ptm_number);
    $getNoPR = $this->db->get('vw_prc_monitor')->row_array();

    $contract_id = $last_comment['contract_id'];

    $permintaan = $this->Procpr_m->getPR($getNoPR['pr_number'], $post['is_sap'])->row_array();

    $contract = $this->Contract_m->getContractNew($ptm_number)->row_array();

    $contract_header = $this->Contract_m->getData($contract_id)->row_array();

    $perencanaan_id = $permintaan['ppm_id'];

    $ccc_user = NULL;

    $tender = $this->Procrfq_m->getRFQ($last_comment['tender_id'])->row_array();

    $input = array();

    if (isset($post['padi_umkm_inp'])) {
      $input['padi_umkm'] = $post['padi_umkm_inp'];
    }

    if (isset($post['e_signature_inp'])) {
      $input['e_signature'] = $post['e_signature_inp'];
    }

    $userdata = $this->data['userdata'];

    $pelaksana_id = $userdata['employee_id'];

    $position = $this->Administration_m->getPosition("PIC USER");

    if(!$position){
      //$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
    }

    if($last_activity == 2000){

      $input['ptm_number'] = $ptm_number;
      $input['vendor_id'] = $contract['vendor_id'];
      $input['vendor_name'] = $contract['vendor_name'];
      $input['subject_work'] = $contract['ptm_subject_of_work'];
      $input['scope_work'] = $contract['ptm_scope_of_work'];
      $input['contract_type'] = $contract['ptm_contract_type'];
      $input['completed_tender_date'] = $contract['ptm_completed_date'];
      $input['contract_amount'] = $contract['total_contract'];

      if(isset($post['manager_kontrak_inp'])){
        $this->form_validation->set_rules("manager_kontrak_inp", "Manager Kontrak", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      }

      $pelaksana_id = (isset($post['manager_kontrak_inp'])) ? $post['manager_kontrak_inp'] : null;

      $this->db->where("job_title","MANAJER PENGADAAN");

      $pelaksana = $this->Administration_m->getUserRule($pelaksana_id)->row_array();

      if(!empty($pelaksana)){
        $input['ctr_man_employee'] = $pelaksana['employee_id'];
        $input['ctr_man_pos'] = $pelaksana['pos_id'];
        $input['ctr_man_pos_name'] = $pelaksana['pos_name'];
      }

    }

    if($last_activity == 2001){

      if(isset($post['pelaksana_kontrak_inp'])){
        $this->form_validation->set_rules("pelaksana_kontrak_inp", "Pelaksana Kontrak", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      }

      $pelaksana_id = (isset($post['pelaksana_kontrak_inp'])) ? $post['pelaksana_kontrak_inp'] : null;

      $this->db->where("job_title","PENGELOLA KONTRAK");

      $pelaksana = $this->Administration_m->getUserRule($pelaksana_id)->row_array();

      if(!empty($pelaksana)){
        $input['ctr_spe_employee'] = $pelaksana['employee_id'];
        $input['ctr_spe_pos'] = $pelaksana['pos_id'];
        $input['ctr_spe_pos_name'] = $pelaksana['pos_name'];
      }

    }

    $status_id = $post['status_inp'][0];

    if(in_array($last_activity, array(2010,2030))){

      // $this->form_validation->set_rules("jenis_kontrak_inp", "Jenis Kontrak", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("tgl_mulai_inp", "Tanggal Mulai Kontrak", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("tgl_akhir_inp", "Tanggal Akhir Kontrak", 'required|max_length['.DEFAULT_MAXLENGTH.']');

      $input['created_date'] = date("Y-m-d H:i:s");
      $input['pf_bank'] = $post['deskripsi_milestone_inp'];
      $input['pf_amount'] = moneytoint($post['nilai_inp']);
      $input['pf_number'] = $post['nomor_jaminan_inp'];
      $input['pf_start_date'] = (!empty($post['mulai_berlaku_inp'])) ? date("Y-m-d",strtotime($post['mulai_berlaku_inp'])) : null;
      $input['pf_end_date'] = (!empty($post['berlaku_hingga_inp'])) ? date("Y-m-d",strtotime($post['berlaku_hingga_inp'])) : null;
      $input['pf_attachment'] = $post['jaminan_file_inp'];
      // $input['ctr_currency'] = $post['currency_inp'];

    }

    if(in_array($last_activity, array(2010))){

      $getctr = $this->db->select("*")->like("ptm_number", $ptm_number)->get("ctr_contract_header")->result_array();
      $tenary = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

      if($tenary["isjoin"] == NULL){ //normal

        $plans = $this->db->select("*")
                          ->join("prc_pr_main y", "y.ppm_id = z.ppm_id")
                          ->join("prc_tender_main x", "x.pr_number = y.pr_number")
                          ->where(array("x.ptm_number" => $ptm_number))
                          ->get("prc_plan_main z")
                          ->row_array();

        $totalhps = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();
        $amount = "";

        foreach ($getctr as $keys => $vals) {
          if($vals['created_date'] == NULL){
            $amount += $vals['contract_amount'];
            $diff = floatval($totalhps['hps_total']) - floatval($amount);
            $remain = $plans['ppm_sisa_anggaran']+$diff;
            $hist = array(
                      'ppm_id' => $plans['ppm_id'],
                      'pph_main' => $plans['ppm_sisa_anggaran'],
                      'pph_plus' => $diff,
                      'pph_remain' => $remain,
                      'pph_date' => date("Y-m-d H:i:s"),
                      'pph_desc' => 2010,
                      'pph_first' => $vals['contract_id'],
                      'pph_mod' => $ptm_number
                    );
            //insert history anggaran
            // $this->Procplan_m->insertHist($hist);
            // $this->Procplan_m->updateDataPerencanaanPengadaan($plans['ppm_id'], $hist['pph_remain']);
          }
        }


      }else{ //jika join paket

      }

      if(isset($post['min_qty'])){

        foreach ($post['min_qty'] as $key => $min) {

          $max = $post['max_qty'][$key];

          if($max < $min || $min < 0){

            $this->setMessage("/ dan Jumlah maksimum tidak boleh dibawah jumlah minimum");

            if(!$error){
              $error = true;
            }

          }

        }

      }

    }

    if(in_array($last_activity, array(2030))){

      $contract = $this->Contract_m->getData($contract_id)->row_array();

      $tipe_pengadaan = $this->Administration_m->isHeadQuatersProcurement($ptm_number);

      $getdept = $this->db->select("dep_code")
      ->join("adm_dept","ptm_dept_id=dept_id")
      ->where("ptm_number",$ptm_number)
      ->get("prc_tender_main")
      ->row()->dep_code;

      if($contract_header['ctr_jenis'] != 'MANUAL' && $contract_header['amandemen_number'] == NULL) {
        $input['contract_number'] = $this->Contract_m->getUrutCtr(date('Y'), $tender['spk_code']);
        // $input['ctr_is_matgis_ecatalogue'] = $input['contract_number'];
      }

    }

    if(in_array($last_activity, array(2010,2030))){

      $contract = $this->Contract_m->getData($contract_id)->row_array();

      $input['subject_work'] = $post['subject_work_inp'];
      $input['spk_code'] = substr($post['subject_work_inp'], 0, 6);
      $input['scope_work'] = $post['scope_work_inp'];
      $input['contract_amount'] = moneytoint($post['total_alokasi_inp']);
      $input['ctr_item_type'] = $post['item_kontrak_inp'];
      $input['kategori_pekerjaan'] = $post['kategori_pekerjaan_inp'];

      if ($post['is_sap'] == 1) {

          $input['ctr_doc_type'] = $post['ctr_doc_type'];
          $input['ctr_down_payment'] = $post['ctr_down_payment'];
          $input['ctr_down_payment_date'] = $post['ctr_down_payment_date'];
          $input['ctr_term_condition'] = $post['ctr_term_condition'];
          $input['ctr_scope'] = $post['ctr_scope'];
      }

      $mulai = $post['tgl_mulai_inp'];
      $akhir = $post['tgl_akhir_inp'];

      if ($last_activity == 2030) {
        $sign = $post['tgl_sign_inp'];//tambah
      }

      $input['start_date'] = (!empty($mulai)) ? date("Y-m-d",strtotime($mulai)) : null;
      $input['end_date'] = (!empty($mulai)) ? date("Y-m-d",strtotime($akhir)) : null;
      if ($last_activity == 2030) {
        $input['sign_date'] = (!empty($mulai)) ? date("Y-m-d",strtotime($sign)) : null;//tambah
      }
      if(strtotime($akhir) < strtotime($mulai)){
        $this->setMessage("Tanggal berakhir kontrak tidak boleh kurang dari tanggal mulai kontrak");
        if(!$error){
          $error = true;
        }
      }

      if($contract['contract_type'] != "HARGA SATUAN" && !empty($status_id) && $status_id == 444){

        $milestone = 0.0;

        if(isset($post['bobot_milestone'])){

          foreach ($post['bobot_milestone'] as $key => $value) {
            $milestone += moneytoint($value);
          }

        }

        if($milestone != 100.0) {
          $this->setMessage("Milestone harus 100%");
          if(!$error){
            $error = true;
          }
        }

      }

    }

    $input_item = array();
    $input_doc = array();
    $input_jaminan = array();
    $input_milestone = array();
    $input_person = array();

    $n = 0;

    $this->form_validation->set_rules("id", 'ID', 'required');

    foreach ($post as $key => $value) {

      if(is_array($value)){

        foreach ($value as $key2 => $value2) {

          $this->form_validation->set_rules($key."[".$key2."]", '', '');

          if (isset($post['item_kode'][$key2])) {
            $input_item[$key2]['item_code'] = $post['item_kode'][$key2];
            //$input_item[$key2]['tit_id'] = $post['tit_id'][$key2];
            $input_item[$key2]['short_description'] = $post['item_deskripsi'][$key2];
            $input_item[$key2]['long_description'] = $post['item_deskripsi'][$key2];
            $input_item[$key2]['qty'] = $post['item_jumlah'][$key2];
            $input_item[$key2]['max_qty'] = $post['item_jumlah'][$key2];
            $input_item[$key2]['uom'] = $post['item_satuan'][$key2];
            $input_item[$key2]['sub_total'] = $post['item_subtotal'][$key2];
            $input_item[$key2]['price'] = $post['item_harga_satuan'][$key2];
            $input_item[$key2]['vendor_code'] = $contract['vendor_id'];

            if ($post['is_sap'] == 1) {
                $input_item[$key2]['item_po'] = $post['item_po'];
            }

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
          // if(isset($post['deskripsi_milestone'][$key2])){
          //   $this->form_validation->set_rules("deskripsi_milestone[$key2]", "Deskripsi Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
          //   if(!empty($post['milestone_id'][$key2])){
          //     $input_milestone[$key2]['milestone_id']=$post['milestone_id'][$key2];
          //   }
          //   $input_milestone[$key2]['percentage']=moneytoint($post['bobot_milestone'][$key2]);
          //   $input_milestone[$key2]['description']=$post['deskripsi_milestone'][$key2];
          //   $input_milestone[$key2]['target_date']=$post['tanggal_milestone'][$key2];
          //   $input_milestone[$key2]['milestone_file']=$post['milestone_file'][$key2];
          //   $input_milestone[$key2]['nilai']=moneytoint($post['nilai_milestone'][$key2]);
          // }
          // if(isset($post['jenis_jaminan'][$key2])){
          //   $this->form_validation->set_rules("jenis_jaminan[$key2]", "Jenis Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
          //   if(!empty($post['jaminan_id'][$key2])){
          //     $input_jaminan[$key2]['id']=$post['jaminan_id'][$key2];
          //   }
          //   $input_jaminan[$key2]['cj_jenis_jaminan']=$post['jenis_jaminan'][$key2];
          //   $input_jaminan[$key2]['cj_tipe_jaminan']=$post['tipe_jaminan'][$key2];
          //   $input_jaminan[$key2]['cj_nama_perusahaan']=$post['nama_perusahaan'][$key2];
          //   $input_jaminan[$key2]['cj_nomor_jaminan']=$post['nomor_jaminan'][$key2];
          //   $input_jaminan[$key2]['cj_alamat']=$post['alamat'][$key2];
          //   $input_jaminan[$key2]['cj_date_start']=$post['mulai_berlaku'][$key2];
          //   $input_jaminan[$key2]['cj_date_end']=$post['berlaku_hingga'][$key2];
          //   $input_jaminan[$key2]['cj_lampiran']=$post['jaminan_file'][$key2];
          //   $input_jaminan[$key2]['cj_nilai']=moneytoint($post['nilai'][$key2]);
          //   $input_jaminan[$key2]['cj_created_by']=$userdata['employee_id'];
          //   $input_jaminan[$key2]['cj_created_date']=date('Y-m-d h:i:s');
          // }
          // if(isset($post['jabatan'][$key2])){
          //   $this->form_validation->set_rules("user[$key2]", "Nama Lengkap #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
          //   if(!empty($post['person_id'][$key2])){
          //     $input_person[$key2]['id']=$post['person_id'][$key2];
          //   }
          //   if(!empty($post['user'][$key2])){
          //     $input_person[$key2]['cp_nama_lengkap']=$post['user'][$key2];
          //   }
          //   if(!empty($post['user_manual'][$key2])){
          //     $input_person[$key2]['cp_nama_lengkap']=$post['user_manual'][$key2];
          //   }
          //   $input_person[$key2]['cp_jabatan']=$post['jabatan'][$key2];
          //   $input_person[$key2]['cp_divisi']=$post['divisi'][$key2];
          //   $input_person[$key2]['cp_nama_perusahaan']=$post['perusahaan'][$key2];
          //   $input_person[$key2]['cp_no_telp']=$post['telp'][$key2];
          //   $input_person[$key2]['cp_email']=$post['email'][$key2];
          //   $input_person[$key2]['cp_note']=$post['person_keterangan'][$key2];
          //   $input_person[$key2]['cp_created_by']=$userdata['employee_id'];
          //   $input_person[$key2]['cp_created_date']=date('Y-m-d h:i:s');
          // }

        }

        $n++;

      }

    }

    if ($this->form_validation->run() == FALSE || $error){

      $this->renderMessage("error");

    } else {

      $this->db->trans_begin();

      if(!empty($input)){

          // $this->db->where('contract_id', $contract_id);
          // $this->db->update('ctr_contract_item', ['item_po' => $post['item_po']]);

        $act = $this->Contract_m->updateData($contract_id,$input);

      } else {

        $act = true;

      }

      $complete_comment = 1;

      if(!empty($input_item)){
        $deleted = array();

        foreach ($input_item as $key => $value) {
          $value['contract_id'] = $contract_id;
          $id = (isset($value['contract_item_id'])) ? $value['contract_item_id'] : "";
          $act = $this->Contract_m->replaceItem($id,$value);
          if($act){
            $deleted[] = $act;
          }
        }

        $this->Contract_m->deleteIfNotExistItem($contract_id,$deleted);

      }

      if(!empty($input_doc)){

        $deleted = array();

        foreach ($input_doc as $key => $value) {
          $value['contract_id'] = $contract_id;
          $id = (isset($value['doc_id'])) ? $value['doc_id'] : "";
          $act = $this->Contract_m->replaceDoc($id,$value);
          if($act){
            $deleted[] = $act;
          }
        }

        $this->Contract_m->deleteIfNotExistDoc($contract_id,$deleted);

      }

      // if(!empty($input_milestone)){

      //   $deleted = array();

      //   foreach ($input_milestone as $key => $value) {
      //     $value['contract_id'] = $contract_id;
      //     $act = $this->Contract_m->replaceMilestone($key,$value);
      //     if($act){
      //       $deleted[] = $act;
      //     }
      //   }

      //   $this->Contract_m->deleteIfNotExistMilestone($contract_id,$deleted);

      // }

      // if(!empty($input_jaminan)){

      //   $deleted = array();

      //   foreach ($input_jaminan as $key => $value) {
      //     $value['cj_contract_id'] = $contract_id;
      //     $act = $this->Contract_m->replaceJaminan($key,$value);
      //     if($act){
      //       $deleted[] = $act;
      //     }
      //   }

      //   $this->Contract_m->deleteIfNotExistJaminan($contract_id,$deleted);

      // }

      // if(!empty($input_person)){

      //   $deleted = array();

      //   foreach ($input_person as $key => $value) {
      //     $value['cp_contract_id'] = $contract_id;
      //     $act = $this->Contract_m->replacePerson($key,$value);
      //     if($act){
      //       $deleted[] = $act;
      //     }
      //   }

      //   $this->Contract_m->deleteIfNotExistPerson($contract_id,$deleted);

      // }

      // if(isset($post['tax_ppn'])){

      //   foreach ($post['tax_ppn'] as $key => $value) {
      //     $getitem = $this->db->where("contract_item_id",$key)->get("ctr_contract_item")->row_array();
      //     $ppn = $value;
      //     $pph = (!empty($post['tax_pph'][$key])) ? $post['tax_pph'][$key] : NULL;
      //     $input['sub_total'] = (1+(($ppn+$pph)/100))*($getitem['price']*$getitem['qty']);
      //     $input = array("ppn"=>$ppn,"pph"=>$pph);
      //     if(isset($post['min_qty'])){
      //       $input['min_qty'] = $post['min_qty'][$key];
      //     }
      //     if(isset($post['max_qty'])){
      //       $input['max_qty'] = $post['max_qty'][$key];
      //     }
      //     if(isset($post['note'])){
      //       $input['note'] = $post['note'][$key];
      //     }
      //     $this->db->where("contract_item_id",$key)->update("ctr_contract_item",$input);
      //   }

      // }

      $response = $post['status_inp'][0];

      $com = $post['comment_inp'][0];

      $attachment = '';

      //hlmifzi
      if ($last_activity == 2901) {

      }

      // echo "<pre>";
      // print_r($ptm_number);
      // echo "<br>";
      // print_r($userdata['complete_name']);
      // echo "<br>";
      // print_r($last_activity);
      // echo "<br>";
      // print_r($response);
      // echo "<br>";
      // print_r($com);
      // echo "<br>";
      // print_r($attachment);
      // echo "<br>";
      // print_r($last_comment['comment_id']);
      // echo "<br>";
      // print_r($contract_id);
      // echo "<br>";
      // print_r($userdata['employee_id']);
      // die;

      $return = $this->Procedure2_m->ctr_contract_comment_complete($ptm_number,$userdata['complete_name'],$last_activity,$response,$com,$attachment,$last_comment['comment_id'],$contract_id,$userdata['employee_id']);

      if ($return['nextactivity'] == 2902) {
        $check_vol = $this->Procplan_m->getVolumeHist("","",$ptm_number)->result_array();
        if (count($check_vol) > 0) {
        $getVolItem = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();
          foreach ($getVolItem as $key => $vol_value) {
            $getVolumeHist = $this->Procplan_m->getVolumeHist($vol_value['ppi_code'],"",$ptm_number)->row_array();
            $getLastHist = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],$perencanaan_id)->row_array();

            $this->db->select('ppv_minus');
            $this->db->where('ppv_minus !=', 0);
            $getMinusVol = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],$perencanaan_id,$ptm_number)->row_array();

            $dataVolume = array(
                'ppm_id' => $getVolumeHist['ppm_id'],
                'ppv_main' => $getLastHist['ppv_remain'],
                'ppv_minus' => 0,
                'ppv_plus' => $getMinusVol['ppv_minus'],
                'ppv_remain' => ($getLastHist['ppv_remain'] + $getMinusVol['ppv_minus']),
                'ppv_activity' =>  $return['nextactivity'],
                'ppv_no' => $ptm_number,
                'ppv_smbd_code' => $getVolumeHist['ppv_smbd_code'],
                'ppv_unit' => $getVolumeHist['ppv_unit'],
                'ppv_prc' => 'CTR',
                'created_datetime' => date("Y-m-d H:i:s"),
              );

              $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
          }
        }
      }elseif (!empty($return['nextactivity'])) {
        $check_vol = $this->Procplan_m->getVolumeHist("","",$ptm_number)->result_array();
      }

      if(!empty($return['nextactivity'])){
        $comment = $this->Comment_m->insertContract($ptm_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$contract_id,$ccc_user);
      }

      if ($return['nextactivity'] == "2901") {
        $data = $this->Contract_m->getData($contract_id)->row_array();

        $po['po_number'] = $this->Contract_m->getUrutWOMatgis();
        $po['creator_employee'] = $data["ctr_spe_employee"];
        $po['creator_pos'] = $data["ctr_spe_pos"];
        $po['contract_id'] = $data["contract_id"];
        $po['vendor_id'] = $data["vendor_id"];
        $po['vendor_name'] = $data["vendor_name"];
        $po['start_date'] = $data["start_date"];
        $po['end_date'] = $data["end_date"];
        $po['created_date'] = $data["created_date"];
        $po['currency'] = $data["currency"];
        $po['status'] = '2017';
        $po['po_notes'] = $data["scope_work"];
        $po['approved_date'] = date('Y-m-d H:i:s');
        $po['current_approver_pos'] = $data["current_approver_pos"];
        $po['current_approver_level'] = $data["current_approver_level"];
        $po['dept_code'] = $data["dept_code"];
        $po['spk_code'] = $data["spk_code"];
        $po['ctr_amount'] = $data["contract_amount"];
        $po['type_of_plan'] = $data["type_of_plan"];
        $res3 = $this->Contract_m->insertWOData($po);

        /////ctr_po_item
        $product = $this->Contract_m->getItem("",$contract_id)->result_array();
        $idpo = $this->Contract_m->getDataWO("",$contract_id)->row_array();
        if (!empty($product)) {
          foreach ($product as $key => $pro) {

            $pd['po_id'] = $idpo["po_id"];
            $pd['contract_item_id'] = $pro["contract_item_id"];
            $pd['item_code'] = $pro["item_code"];
            $pd['short_description'] = $pro["short_description"];
            $pd['long_description'] = $pro["long_description"];
            $pd['price'] = $pro["price"];
            $pd['qty'] = $pro["qty"];
            $pd['uom'] = $pro["uom"];
            $pd['sub_total'] = $pro["sub_total"];
            $pd['ppn'] = 0;
            $pd['pph'] = 0;
            $this->Contract_m->insertWOItem($pd);
          }
        }

        /////ctr_wo_header
        $dl['wo_id'] = $idpo["po_id"];
        $dl['wo_number'] = $this->Contract_m->getUrutWOMatgis();
        $dl['creator_employee'] = $data["ctr_spe_employee"];
        $dl['creator_pos'] = $data["ctr_spe_pos"];
        $dl['contract_id'] = $data["contract_id"];
        $dl['vendor_id'] = $data["vendor_id"];
        $dl['vendor_name'] = $data["vendor_name"];
        $dl['created_date'] = $data["created_date"];
        $dl['currency'] = 'IDR';
        $dl['status'] = '2033';
        $dl['start_date'] = $data["start_date"];
        $dl['end_date'] = $data["end_date"];
        $dl['ctr_amount'] = $data["contract_amount"];
        $dl['approved_date'] = date('Y-m-d H:i:s');
        $dl['current_approver_pos'] = $data["current_approver_pos"];
        $dl['current_approver_level'] = $data["current_approver_level"];
        $dl['dept_code'] = $data["dept_code"];
        $dl['dept_id'] = $data["dept_id"];
        $dl['spk_number'] = $data["spk_code"];
        $dl['spk_name'] = $data["subject_work"];
        $res = $this->Contract_m->insertWODataMatgis($dl);

        /////ctr_wo_item
        $idwo = $this->Contract_m->getDataWO("",$contract_id)->row_array();
        $product = $this->Contract_m->getItem("",$contract_id)->result_array();
        if (!empty($product)) {
          foreach ($product as $key => $pro) {
            $p['wo_id'] = $idwo['po_id'];
            $p['contract_item_id'] = $pro["contract_item_id"];
            $p['item_code'] = $pro["item_code"];
            $p['short_description'] = $pro["short_description"];
            $p['long_description'] = $pro["long_description"];
            $p['price'] = $pro["price"];
            $p['qty'] = $pro["qty"];
            $p['uom'] = $pro["uom"];
            $p['sub_total'] = $pro["sub_total"];
            $p['ppn'] = 0;
            $p['pph'] = 0;
            $this->Contract_m->insertWOItemMatgis($p);
          }
        }

        ///////ctr_sppm_header
        $idwo = $this->Contract_m->getDataWO("",$contract_id)->row_array();
        $sp['sppm_number'] = $data["contract_number"];
        $sp['creator_employee'] = $data["ctr_spe_employee"];
        $sp['creator_pos'] = $data["ctr_spe_pos"];
        $sp['contract_id'] = $data["contract_id"];
        $sp['vendor_id'] = $data["vendor_id"];
        $sp['wo_id'] = $idwo['po_id'];
        $sp['sppm_date'] = date("Y-m-d h:i:sa");
        $sp['created_date'] = date("Y-m-d h:i:sa");
        $sp['tgl_expected_delivery'] = date("Y-m-d h:i:sa",strtotime('+3 days'));
        $sp['sppm_total'] = $data["contract_amount"];
        $sp['sppm_notes'] = $data["notes"];
        $sp['current_approver_pos'] = $data["current_approver_pos"];
        $sp['current_approver_level'] = $data["current_approver_level"];
        $sp['approved_date'] = date("Y-m-d h:i:sa");

        $res2 = $this->Contract_m->insertSPPMMatgis($sp);

        /////ctr_sppm_item
        $idpo = $this->Contract_m->getDataWO("",$contract_id)->row_array();
        $idsppm = $this->Contract_m->getDataSppm("",$idpo['po_id'])->row_array();
        $product = $this->Contract_m->getItem("",$contract_id)->result_array();
        if (!empty($product)) {
          foreach ($product as $key => $pro) {
            $spi['sppm_id'] = $idsppm['sppm_id'];
            $spi['contract_item_id'] = $pro["contract_item_id"];
            $spi['item_code'] = $pro["item_code"];
            $spi['short_description'] = $pro["short_description"];
            $spi['long_description'] = $pro["long_description"];
            $spi['price'] = $pro["price"];
            $spi['qty'] = $pro["qty"];
            $spi['uom'] = $pro["uom"];
            $spi['sub_total'] = $pro["sub_total"];
            $spi['ppn'] = 0;
            $spi['pph'] = 0;
            $this->Contract_m->insertSPPMItemMatgis($spi);
          }
        }

        $ress = $this->Contract_m->push_kode_nasabah($contract['vendor_id']);

        $nasabahStat = (json_decode($ress, true));

        if ($nasabahStat['status'] == "success") {
          $cust = str_replace("kode_nasabah = ", "", $nasabahStat['message']);
          $this->db->where("vendor_id", $contract['vendor_id'])->update("vnd_header", array("nasabah_code" => $cust));
          $this->setMessage("Kode nasabah ".$cust);
        }

        else if($nasabahStat != NULL){

          foreach ($nasabahStat['message'] as $k => $v) {
            $msg = str_replace("harus diisi", "vendor belum ada", $v['keterangan']);
            $this->setMessage($msg);
          }
          $this->setMessage("Gagal generate kode nasabah vendor, silahkan hubungi admin<p>");
          $error = true;
        }

        // post api umkm padi
        $vendor = $this->Vendor_m->getVendorActive($contract['vendor_id'])->row_array();

        $vnd_manual = $this->Vendor_m->getVendorList($contract['vendor_id'])->row_array();

        $fin_class = array("M", "K", "I");

        if (in_array($vendor['fin_class'], $fin_class) &&  $vnd_manual['vnd_jenis'] == 'E-SCM') {

          $ch = curl_init( UMKM_PADI );

          $payload = json_encode( array( "umkm" => array(
              "uid" => 'WIKA-' . $vendor['vendor_id'],
              "nama_umkm" => $vendor['vendor_name'],
              "alamat" => $vendor['address_street'],
              "blok_no_kav" => "-",
              "kode_pos" => $vendor['address_postcode'],
              "kota" => $vendor['address_city'],
              "provinsi" => $vendor['addres_prop'],
              "no_telp" => $vendor['address_phone_no'],
              "hp" => $vendor['address_phone_no'],
              "email" => $vendor['login_id'],
              "kategori_usaha" => "",
              "jenis_kegiatan_usaha" => "",
              "npwp" => $vendor['npwp_no'],
              "nama_bank" => "",
              "country_bank" => "",
              "no_rekening" => "",
              "nama_pemilik_rekening" => "",
              "longitute" => "",
              "latitute" => "",
              "total_project" => "1",
              "total_revenue" => "",
              "ontime_rate" => "",
              "average_rating" => ""
          ) ) );

          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
          curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'x-api-key:' . API_KEY_PADI,
            'User-Agent:WIKA_E-SCM_V2'
          ));

          $result = curl_exec($ch);

          $res_padi = json_decode($result, true);

          curl_close($ch);
        }
      }

      // save sap txt to inbound
      
      if($return['nextactivity'] == 2027)
      {
        $idko = "";
              
              $this->db->order_by('contract_id');
              
              $ooh = $this->db->get_where('ctr_contract_header', ['ptm_number' => $ptm_number])->row_array();

              $oop = $this->db->get_where('ctr_contract_item', ['contract_id' => $ooh['contract_id']])->row_array();
              $aa = "
                  cci2.item_code as item_code,
                  TRUNC(cci2.qty) qty,
                  cci2.uom,
                  TRUNC(cci2.hps) as sub_total,
                  ";
              $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";

              if ($oop['pr_acc_assig'] == "Q" && $oop['pr_cat_tech'] == 0) {
                  $idko = "B";              
                  $aa = "
                  cci2.item_code as item_code,
                  TRUNC(cci2.qty) qty,
                  cci2.uom,
                  TRUNC(cci2.hps) as sub_total,
                      ";
                  $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
              }
              
              if ($oop['pr_acc_assig'] == "X" && $oop['pr_cat_tech'] == 5) {
                  $idko = "B";              
                  $aa = "
                  cci2.item_code as item_code,
                  TRUNC(cci2.qty) qty,
                  cci2.uom,
                  TRUNC(cci2.hps) as sub_total,
                      ";
                  $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
              } 

              if ($oop['pr_acc_assig'] == "P" && $oop['pr_cat_tech'] == 0) {
                  $idko = "B";              
                  $aa = "
                  cci2.item_code as item_code,
                  TRUNC(cci2.qty) qty,
                  cci2.uom,
                  TRUNC(cci2.hps) as sub_total,
                      ";
                  $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
              }

              if ($oop['pr_acc_assig'] == "N" && $oop['pr_cat_tech'] == 9) {
                  $idko = "J";
                  $aa = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                  $bb = "
                  cci2.item_code as item_code,
                  TRUNC(cci2.qty) qty,
                  cci2.uom,
                  TRUNC(cci2.hps) as sub_total,
                      ";
              } 

              if ($oop['pr_acc_assig'] == "U" && $oop['pr_cat_tech'] == 0) {
                  $idko = "A";
                  $aa = "
                  cci2.item_code as item_code,
                  TRUNC(cci2.qty) qty,
                  cci2.uom,
                  TRUNC(cci2.hps) as sub_total,
                      ";
                  $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
              }

              $sql = "
                select
                  cch2.ctr_doc_type,
                  vnd.code_bp,
                  concat(to_char(now(), 'YYYY'), '.', to_char(now(), 'MM'), '.', to_char(now(), 'DD')) start_date,
                  admi.code,
                  cci2.lokasi_incoterm,
                  cci2.pr_retention,
                  case 
                  when cch2.ctr_down_payment = 0 then null
                  else cch2.ctr_down_payment
                  end as ctr_down_payment,
                  case
                  when cch2.ctr_down_payment_date is not null 
                  then concat(to_char(cch2.ctr_down_payment_date, 'YYYY'), '.', to_char(cch2.ctr_down_payment_date, 'MM'), '.', to_char(cch2.ctr_down_payment_date, 'DD'))
                  else null
                  end as ctr_down_payment_date,
                  (ROW_NUMBER () OVER (ORDER BY cci2.item_code desc) * 10 ) tit_item_po,
                  $aa
                  cci2.pr_number_sap,
                  cci2.pr_item_sap,
                  cch2.contract_number contract_number,
                  case
                  when cch2.ctr_delivery_date is not null 
                  then concat(to_char(cch2.ctr_delivery_date, 'YYYY'), '.', to_char(cch2.ctr_delivery_date, 'MM'), '.', to_char(cch2.ctr_delivery_date, 'DD'))
                  else null
                  end as ptm_created_date,
                  cci2.no_asset,
                  cci2.sub_number,
                  cci2.tax_code,
                  $bb
                  cch2.ctr_scope,
                  concat(concat(to_char(cch2.start_date, 'YYYY'),'.',to_char(cch2.start_date, 'MM'),'.',to_char(cch2.start_date, 'DD')),' - ',concat(to_char(cch2.end_date, 'YYYY'),'.',to_char(cch2.end_date, 'MM'),'.',to_char(cch2.end_date, 'DD'))) as rangedate
                from
                ctr_contract_header cch2
                LEFT JOIN ctr_contract_item cci2 ON cch2.contract_id = cci2.contract_id
                LEFT JOIN adm_incoterm admi ON cci2.incoterm = admi.description
                LEFT JOIN vnd_header vnd ON cci2.vendor_code = vnd.vendor_id

        where
          cch2.ptm_number = '$ptm_number'
        order by cci2.item_code DESC";
        
              $data = $this->db->query($sql)->result_array();

              $newl = "\n";
              $body = "";
              foreach ($data as $k => $v) {
                  $body .= 1 .'|'. implode("|",$v) . $newl;

                  //insert to table po
                  $po['DOC_NO'] = $k+1;
                  $po['DOC_TYPE'] = $v['ctr_doc_type'];
                  $po['VENDOR'] = $v['code_bp'];
                  $po['DOC_DATE'] = $v['start_date'];
                  $po['INCOTERMS1'] = $v['lokasi_incoterm'];
                  $po['INCOTERMS2'] = $v['lokasi_incoterm'];
                  $po['RETENTION_PERCENTAGE'] = $v['pr_retention'];
                  $po['DOWNPAY_PERCENT'] = $v['ctr_down_payment'];
                  $po['DOWNPAY_DUEDATE'] = $v['ctr_down_payment_date'];
                  $po['PO_ITEM'] = $v['tit_item_po'];
                  $po['MATERIAL'] = $oop['pr_acc_assig']; //$v['ptm_doc_type_sap'];
                  $po['QUANTITY'] = $v['qty'];
                  $po['PO_UNIT'] = $v['uom'];
                  $po['NET_PRICE'] = $v['sub_total'];
                  // $po['PREQ_NO'] = $v['ptm_doc_type_sap'];
                  // $po['PREQ_ITEM'] = $v['ptm_doc_type_sap'];
                  // $po['VEND_MAT'] = $v['ptm_doc_type_sap'];
                  $po['DELIVERY_DATE'] = $v['ptm_created_date'];
                  $po['ASSET_NO'] = $v['no_asset'];
                  $po['SUB_NUMBER'] = $v['sub_number'];
                  $po['TAX_CODE'] = $v['tax_code'];
                  $po['SERVICE'] = $v['service'];
                  $po['SERVICE_QTY'] = $v['qty'];
                  $po['BASE_UOM'] = $v['uom'];
                  $po['GR_PRICE'] = 0;
                  $po['RUANG_LINGKUP'] = $v['ctr_scope'];
                  $po['JANGKA_WAKTU'] = $v['rangedate'];
                  $po['SOURCE'] = "M";
                  $po['RFQ_NO'] = $ptm_number;

                  $this->db->insert('prc_tender_po', $po);
              }

              $todaydate = date('Ymd');
              $time_utc=mktime(date('G'),date('i'),date('s'));
              $NowisTime=date('Gis',$time_utc);

              $hex = bin2hex(openssl_random_pseudo_bytes(16));

              $hea2 = "YMMI005".$idko."|".strtoupper($hex)."|A000||".$todaydate.$NowisTime;
              $head = 'DOC_NO|DOC_TYPE|VENDOR|DOC_DATE|INCOTERMS1|INCOTERMS2|RETENTION_PERCENTAGE|DOWNPAY_PERCENT|DOWNPAY_DUEDATE|PO_ITEM|MATERIAL|QUANTITY|PO_UNIT|NET_PRICE|PREQ_NO|PREQ_ITEM|VEND_MAT|DELIVERY_DATE|ASSET_NO|SUB_NUMBER|TAX_CODE|SERVICE|SERVICE_QTY|BASE_UOM|GR_PRICE|RUANG_LINGKUP|JANGKA_WAKTU';

              $directory = dirname(__DIR__,6) . '/FTP/SAPInterface/S4HANADEV/Inbound';
              
              $path = 'uploads/PO';
              if (!is_dir($path))
                  mkdir($path, 0777, true);

              $filename = 'YMMI005'.$idko.'_'.$todaydate.$NowisTime.'.txt';
              $output = $hea2.$newl.$head.$newl.$body;
              file_put_contents($path.'/'.$filename, $output);
              //print_r(file_put_contents($path.'/'.$filename, $output));
              // exit;
              copy($path.'/'.$filename, $directory.'/'.$filename);

              //update field generate po contract
              $update['ctr_generate_text_number'] = $filename;

              $this->db->where('ptm_number', $ptm_number);
              $this->db->update('prc_tender_main', $update);

              $this->db->where('ptm_number', $ptm_number);
              $this->db->update('ctr_contract_header', $update);
      }
    }

    if(!empty($return['message'])){
      $this->setMessage($return['message']);
      if(!$error){
        $error = true;
      }
    }

    $get_nomor_po = $this->db->get_where('prc_tender_main', array('ptm_number' => $ptm_number))->row_array();

    if(empty($get_nomor_po['ctr_po_number'])){
      $this->setMessage("Nomor PO belum tersedia.");
      if(!$error){
        $error = true;
      }
    }

    if(!$error){
      if ($this->db->trans_status() === FALSE)  {
        $this->setMessage("Gagal mengubah data");
        $this->db->trans_rollback();
      }
      else  {
        $this->load->model("Sinkron_Release_m");

        $login_status = $this->Sinkron_Release_m->do_sinkron($get_nomor_po['ctr_po_number']);

        if($login_status['type_res'] == 'E') {
          
          $this->setMessage($login_status['message_res']);
          $this->setMessage("Gagal mengubah data");
          $this->db->trans_rollback();

        } else {

          $this->setMessage("Sukses mengubah data");
          $this->db->trans_commit();
          $this->renderMessage("success",site_url("contract/daftar_pekerjaan"));
        }

      }

    }

    else {
      $this->renderMessage("error");
    }