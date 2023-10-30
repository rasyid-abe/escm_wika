<?php

    $error = false;

    $post = $this->input->post();

    $id = $post['id'];

    $last_comment = $this->Comment_m->getProcurementRFQ("",$id)->row_array();

    $last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 0;

    $ptm_number = $last_comment['tender_id'];

    $tender = $this->Procrfq_m->getRFQ($last_comment['tender_id'])->row_array();

    
    $this->db->select('pr_number');
    $this->db->where('ptm_number', $ptm_number);
    $getNoPR = $this->db->get('vw_prc_monitor')->row_array();

    $permintaan = $this->Procpr_m->getPR($getNoPR['pr_number'])->row_array();

    $perencanaan_id = $permintaan['ppm_id'];

    $input = array();

    $input_doc = array();

    $input_item = array();

    $input_prep = array();

    $input_person = array();

    $rks_tender = array();

    $ranked_index = [];

    $contract = null;
    
    $number = null;

    $user_id = null;

    $userdata = $this->data['userdata'];

    $position = $this->Administration_m->getPosition("PIC USER");

    $tender = $this->db->where("ptm_number",$ptm_number)->get("prc_tender_main")->row_array();

    $tender_name = (isset($tender['ptm_subject_of_work'])) ? $tender['ptm_subject_of_work'] : null;

    $activity_terminasi = 1800;

    if(!$position){
    //$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
    }

    $response = $post['status_inp'][0];

    if(!empty($response)){

        $resp = $this->db
        ->where("awr_id",$response)
        ->get("adm_wkf_response")
        ->row_array();

        $response_name = url_title($resp['awr_name'],"_",true);

    }

    if($response_name == "reject_uskep")
    {
        redirect(site_url("procurement/submit_reject_pengadaan/".$ptm_number));
    }
   

    $evaltech = "";

    $evalprice = "";

    $method = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

    $validateeval = $this->Procrfq_m->getEvalViewRFQ("", $ptm_number)->result_array();

    foreach ($validateeval as $key => $evals) {

        $evaltech .= $evals['pte_technical_value'];

        $evalprice .= $evals['pte_price_value'];

    }

    $except = [
        url_title('Ulangi Proses Pengadaan',"_",true),
        url_title('Proses E-Auction',"_",true)
    ];

    if (!in_array($response_name, $except)) {

        if ($method["ptp_submission_method"] == 0) { //satu sampul

            if($last_activity == 1100){ 
                if($evaltech <= 0){
                    $this->setMessage("Evaluasi Teknis harus dinilai");
                    if(!$error){
                    $error = true;
                    }
                }
                if($evalprice <= 0){
                    $this->setMessage("Evaluasi Harga harus dinilai");
                    if(!$error){
                    $error = true;
                    }
                }
            }

        } else { //dua sampul

            if($last_activity == 1100){ 
                if($evaltech <= 0){
                    $this->setMessage("Evaluasi Teknis harus dinilai");
                    if(!$error){
                    $error = true;
                    }
                }
            }
            if($last_activity == 1120){
                if($evalprice <= 0){
                    $this->setMessage("Evaluasi Harga harus dinilai");
                    if(!$error){
                    $error = true;
                    }
                }
            }
        }
    }    

    if($last_activity == 1029){
        $manajer_id = (isset($post['manager_inp'])) ? $post['manager_inp'] : "";
        $input['ptm_man_emp_id'] = $manajer_id;
        $user_id = $manajer_id;
    }    

    if($last_activity == 1030){

        $pelaksana_id = (isset($post['pelaksana_pengadaan_inp'])) ? $post['pelaksana_pengadaan_inp'] : $tender['ptm_buyer'];
        
        $user_id = $pelaksana_id;
        
        $this->db->where("job_title","PELAKSANA PENGADAAN");

        $pelaksana = $this->Administration_m->getUserRule($pelaksana_id)->row_array();

        if(isset($post['pelaksana_pengadaan_inp'])){
            $this->form_validation->set_rules("pelaksana_pengadaan_inp", "Pelaksana Pengadaan", 'required|max_length['.DEFAULT_MAXLENGTH.']');
        }

        if(!empty($pelaksana)){
            $input['ptm_buyer_id'] = $pelaksana_id;
            $input['ptm_buyer'] = $pelaksana['complete_name'];
            $input['ptm_buyer_pos_code'] = $pelaksana['pos_id'];
            $input['ptm_buyer_pos_name'] = $pelaksana['pos_name'];
        }
    }

    if ($last_activity == 1141) {
        $input['ptm_winner'] = isset($post['winner_type_inp']) ? $post['winner_type_inp'] : $tender['ptm_winner'];
    }

    $input['ptm_is_uskep_online'] = 0;
      if(isset($post['ptm_is_uskep_online'])){
            $input['ptm_is_uskep_online'] = 1;          
      }

    $invited_vendor = (isset($this->data['selection_vendor_tender'])) ? $this->data['selection_vendor_tender'] : array();    

    if($last_activity == 1040){
      //update document single RFQ
      $dataDocSingle['doc_attachment_inp_header'] = $post['doc_attachment_inp_header'];
      $dataDocSingle['doc_attachment_inp_mtd_pengadaan'] = $post['doc_attachment_inp_mtd_pengadaan'];
      $this->db->where('ptm_number', $ptm_number);
      $this->db->update('prc_tender_main', $dataDocSingle);
      
      $metode_pengadaan = null;

      $sampul = null;

      $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

      $filtering_vendor = array();

      if(isset($post['klasifikasi_kecil_inp'])){
          $filtering_vendor[] = "K";
      }
      if(isset($post['klasifikasi_menengah_inp'])){
          $filtering_vendor[] = "M";
      }
      if(isset($post['klasifikasi_besar_inp'])){
          $filtering_vendor[] = "B";
      }
      if(isset($post['tambah_bidder_inp'])){
        $input['ptm_add_bidder'] = $post['tambah_bidder_inp'];
      }

      if(isset($post['ctr_down_payment'])){
        $input['ctr_down_payment'] = (int)$post['ctr_down_payment'];
      }

      if(isset($post['ctr_down_payment_date'])){
        $input['ctr_down_payment_date'] = $post['ctr_down_payment_date'];
      }

      if(isset($post['ctr_doc_type'])){
        $input['ctr_doc_type'] = $post['ctr_doc_type'];
      }

      if(isset($post['ctr_delivery_date'])){
        $input['ctr_delivery_date'] = $post['ctr_delivery_date'];
      }

      $input_prep['ptp_padi_umkm'] = 0;
      if(isset($post['padi_umkm_inp'])){
          if($post['padi_umkm_inp'] = "on"){
              $input_prep['ptp_padi_umkm'] = 1;
          }
      }

      $input_prep['ptp_pengadaan_com'] = 0;
      if(isset($post['pengadaan_com_inp'])){
          if($post['pengadaan_com_inp'] = "on"){
              $input_prep['ptp_pengadaan_com'] = 1;
          }
      }
      $input_prep['ptp_partai_wika'] = 0;
      if(isset($post['portal_wika_inp'])){
          if($post['portal_wika_inp'] = "on"){
              $input_prep['ptp_partai_wika'] = 1;
          }
      }
      $input_prep['ptp_tim_panitia'] = 0;
      $input_prep['ptp_preferensi_umkm'] = 0;
      if(isset($post['penilaian_umkm_inp'])){
          if($post['penilaian_umkm_inp'] = "on"){
              $input_prep['ptp_preferensi_umkm'] = 1;
          }
      }

      $input_prep['ptm_is_uskep_online'] = 0;
      if(isset($post['ptm_is_uskep_online'])){
            $input_prep['ptm_is_uskep_online'] = 1;          
      }

      if($prep['ptp_prequalify'] != 2){ 

          $input['ptm_contract_type'] = null;
          if(isset($post['ptm_contract_type_inp'])){
              $input['ptm_contract_type'] = $post['ptm_contract_type_inp'];
          }

          $input_prep['ptp_tender_priod'] = 0;
          if(isset($post['tender_priod_inp'])){
              $input_prep['ptp_tender_priod'] = $post['tender_priod_inp'];
          }

          $input_prep['ptp_eauction'] = 0;
          if(isset($post['eauction_inp'])){
              if($post['eauction_inp'] > 0){
                  $input_prep['ptp_eauction'] = $post['eauction_inp'];
              }
          }

          $input_prep['ptp_prequalify'] = 0;
          if(isset($post['pq_inp'])){
              $input_prep['ptp_prequalify'] = $post['pq_inp'];
          }
          
          $input_prep['ptp_aanwijzing_online'] = 0;

          if(!empty($post['aanwijzing_online_inp'])){
              $input_prep['ptp_aanwijzing_online'] = 1;
          }

          if(isset($post['metode_pengadaan_inp'])){
              $metode_pengadaan = (!empty($post['metode_pengadaan_inp'])) ? $post['metode_pengadaan_inp'] : 0;
              $input_prep['ptp_tender_method'] = $metode_pengadaan;
          }

          if (isset($post["ptp_syarat_penunjuk"])) {
              $syarat_penunjuk = !empty($post["ptp_syarat_penunjuk"]) ? $post["ptp_syarat_penunjuk"] : "";
              $arr_data = array();

              $syarat_penunjuk = json_encode($post["ptp_syarat_penunjuk"]);
              $input_prep["ptp_syarat_penunjuk"] = $syarat_penunjuk;
          }

          if(isset($post['sistem_sampul_inp'])){
              $sampul = (!empty($post['sistem_sampul_inp'])) ? $post['sistem_sampul_inp'] : 0;
              $input_prep['ptp_submission_method'] = $sampul;
          }

          if(isset($post['evt_id'])){
              $input_prep['evt_id'] = (!empty($post['evt_id'])) ? $post['evt_id'] : 0;
          }

          if(isset($post['keterangan_metode_inp'])){
              $input_prep['ptp_inquiry_notes'] = $post['keterangan_metode_inp'];
          }

          $ptp_klasifikasi_peserta = (isset($post['klasifikasi_kecil_inp'])) ? 1 : 0;
          $ptp_klasifikasi_peserta .= (isset($post['klasifikasi_menengah_inp'])) ? 1 : 0;
          $ptp_klasifikasi_peserta .= (isset($post['klasifikasi_besar_inp'])) ? 1 : 0;

          $ptp_quo_type = 1;
          $ptp_quo_type .= (isset($post['quo_type_b_inp'])) ? 1 : 0;
          $ptp_quo_type .= (isset($post['quo_type_c_inp'])) ? 1 : 0;

          $input_prep['ptp_klasifikasi_peserta'] = $ptp_klasifikasi_peserta;
          $input_prep['ptp_quo_type'] = $ptp_quo_type;

          $eval_id = $post['evt_id'];

          if(!empty($eval_id)){
              $evaluasi = $this->Procevaltemp_m->getTemplateEvaluasi($eval_id)->row_array();
              $input_prep['evt_id'] = $eval_id;
              $input_prep['evt_description'] = $evaluasi['evt_name'];
              $input_prep['ptp_evaluation_method'] = $evaluasi['evt_type'];
          }

          $hps = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

          if(count($invited_vendor) == 0 && $post['metode_pengadaan_inp'] != 2){
              $this->setMessage("Tidak ada vendor yang diundang");
              if(!$error){
                  $error = true;
              }
          } 

          if(empty($eval_id)){
              $this->setMessage("Template evaluasi wajib diisi");
              if(!$error){
                  $error = true;
              }
          }

          switch ($metode_pengadaan) {
              //Penunjukkan Langsung
              case 0:

              if(count($invited_vendor) > 1){
                  $this->setMessage("Hanya 1 vendor yang dapat diundang Penunjukkan Langsung");
                  if(!$error){
                      $error = true;
                  }
              }

              break;

              case 1:

              if(count($invited_vendor) < 2){
                  $this->setMessage("Minimal 2 vendor yang diundang Pemilihan Langsung");
                  if(!$error){
                      $error = true;
                  }
              }

              break;

              case 2:

              break;

              default:

              $this->setMessage("Pilih metode pengadaan");
              if(!$error){
                  $error = true;
              }

              break;
          }

      }

      //validasi tanggal
      if($post['tgl_pembukaan_pendaftaran_inp'] == "" || $post['tgl_mulai_penawaran_inp'] == "" || $post['tgl_penutupan_pendaftaran_inp'] == "" || $post['tgl_akhir_penawaran_inp'] == "" || $post['tgl_aanwijzing_inp'] == "" || $post['tgl_pembukaan_dok_penawaran_inp'] == ""){  
          $this->setMessage("Kolom yang wajib diisi tidak boleh kosong");
          $error = true;
      }
      //end

      if(!empty($post['tgl_pembukaan_pendaftaran_inp'])){
          $input_prep['ptp_reg_opening_date'] = $post['tgl_pembukaan_pendaftaran_inp'];

      } else {
          $input_prep['ptp_reg_opening_date'] = "";
          if(in_array($sampul, array(1,2)) && $metode_pengadaan == 2){
              $this->setMessage("Tanggal pembukaan pendaftaran lelang harus terisi");
              if(!$error){
                  $error = true;
              }
          }
      }

      if(!empty($post['tgl_penutupan_pendaftaran_inp'])){
          $input_prep['ptp_reg_closing_date'] = $post['tgl_penutupan_pendaftaran_inp'];

      } else {
          $input_prep['ptp_reg_closing_date'] = "";
          if(in_array($sampul, array(1,2)) && $metode_pengadaan == 2){
              $this->setMessage("Tanggal penutupan pendaftaran lelang harus terisi");
              if(!$error){
                  $error = true;
              }
          }
      }

      if(!empty($post['tgl_mulai_penawaran_inp'])){
          $input_prep['ptp_quot_opening_date'] = $post['tgl_mulai_penawaran_inp'];
      } else {
      $input_prep['ptp_quot_opening_date'] = "";
      }
      if(!empty($post['tgl_akhir_penawaran_inp'])){
          $input_prep['ptp_quot_closing_date'] = $post['tgl_akhir_penawaran_inp'];
      } else {
          $input_prep['ptp_quot_closing_date'] = "";
      }
      if(!empty($post['tgl_aanwijzing_inp'])){
          $input_prep['ptp_prebid_date'] = $post['tgl_aanwijzing_inp'];
      } else {
          $input_prep['ptp_prebid_date'] = "";
      }
      if(!empty($post['lokasi_aanwijzing_inp'])){
          $input_prep['ptp_prebid_location'] = $post['lokasi_aanwijzing_inp'];
      } else {
          $input_prep['ptp_prebid_location'] = "";
      }
      if(!empty($post['tgl_pembukaan_dok_penawaran_inp'])){
          $input_prep['ptp_doc_open_date'] = $post['tgl_pembukaan_dok_penawaran_inp'];
      } else {
          $input_prep['ptp_doc_open_date'] = "";
      }

      if (!empty($post["negosiasi"])) {
          $input_prep["ptp_negosiation_date"] = todatetime($post["negosiasi"]);
      } else {
          $input_prep["ptp_negosiation_date"] = "";
      }

      if (!empty($post["uskep"])) {
          $input_prep["ptp_uskep_date"] = todatetime($post["uskep"]);
      } else {
          $input_prep["ptp_uskep_date"] = "";
      }

      if (!empty($post["pengumuman"])) {
          $input_prep["ptp_announcement_date"] = todatetime($post["pengumuman"]);
      } else {
          $input_prep["ptp_announcement_date"] = "";
      }
      if (!empty($post["sanggahan"])) {
          $input_prep["ptp_disclaimer_date"] = todatetime($post["sanggahan"]);
      } else {
          $input_prep["ptp_disclaimer_date"] = "";
      }
      if (!empty($post["penunjukan"])) {
          $input_prep["ptp_appointment_date"] = todatetime($post["penunjukan"]);
      } else {
          $input_prep["ptp_appointment_date"] = "";
      }

      $opening = strtotime($input_prep['ptp_reg_opening_date']);
      $closing = strtotime($input_prep['ptp_reg_closing_date']);
      $aanwijzing = strtotime($input_prep['ptp_prebid_date']);
      $bid = strtotime($input_prep['ptp_quot_opening_date']);
      $bid_close = strtotime($input_prep['ptp_quot_closing_date']);
      $open_doc = strtotime($input_prep['ptp_doc_open_date']);

      if(!empty($opening) && !empty($closing) && $opening > $closing){
          $this->setMessage("Tanggal pembukaan pendaftaran tidak boleh lebih dari penutupan pendaftaran");
          if(!$error){
              $error = true;
          }
      }

      if(!empty($closing) && !empty($aanwijzing) && $closing > $aanwijzing){
          $this->setMessage("Tanggal penutupan pendaftaran tidak boleh lebih dari aanwijzing");
          if(!$error){
              $error = true;
          }
      }

      if(!empty($aanwijzing) && !empty($bid) && $aanwijzing > $bid){
          $this->setMessage("Tanggal aanwijzing tidak boleh lebih dari mulai kirim penawaran");
          if(!$error){
              $error = true;
          }
      }

      if(!empty($bid) && !empty($bid_close) && $bid > $bid_close){
          $this->setMessage("Tanggal mulai kirim penawaran tidak boleh lebih dari akhir kirim penawaran");
          if(!$error){
              $error = true;
          }
      }

      if(!empty($bid_close) && !empty($open_doc) && $bid_close > $open_doc){
          $this->setMessage("Tanggal akhir kirim penawaran tidak boleh lebih dari pembukaan dokumen penawaran");
          if(!$error){
              $error = true;
          }
      }
    }

    if($last_activity == 1071){

        $vnd_upd = array();

        $vnd_id = array();

        $this->db->where("ptm_number",$ptm_number)->update("prc_tender_vendor_status",array("pvs_pq_passed"=>0,"pvs_pq_reason"=>""));

        if(isset($post['alasan_pq_inp'])){
            foreach ($post['alasan_pq_inp'] as $key => $value) {
            $vnd_upd[$key]['pvs_pq_reason'] = $value;
            }
        }

        if(isset($post['lulus_pq_inp'])){
            foreach ($post['lulus_pq_inp'] as $key => $value) {
            $vnd_upd[$key]['pvs_pq_passed'] = 1;
            }
        }

        if(isset($post['attachment_pq_inp'])){
            foreach ($post['attachment_pq_inp'] as $key => $value) {
            $vnd_upd[$key]['pvs_pq_attachment'] = $value;
            }
        }

        foreach ($vnd_upd as $key => $value) {
            $cek = $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$key))
            ->get("prc_tender_vendor_status")->num_rows();
            if(!empty($cek)){
                $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$key))
                ->update("prc_tender_vendor_status",$value);
            } else {
                $value['ptm_number'] = $ptm_number;
                $value["pvs_vendor_code"] = $key;
                $this->db->insert("prc_tender_vendor_status",$value);
            }
        }
    }

    if($last_activity == 1112){

        if($post['tgl_mulai_penawaran_2_inp'] == "" || $post['tgl_akhir_penawaran_2_inp'] == "" || $post['tgl_aanwijzing_2_inp'] == "" ){  
            $this->setMessage("Tanggal jadwal tahap 2 yang wajib diisi tidak boleh kosong");
            $error = true;
        }
        if(!empty($post['tgl_mulai_penawaran_2_inp'])){
            $input_prep['ptp_bid_opening2'] = $post['tgl_mulai_penawaran_2_inp'];
        }
        if(!empty($post['tgl_akhir_penawaran_2_inp'])){
            $input_prep['ptp_bid_closing2'] = $post['tgl_akhir_penawaran_2_inp'];
        }
        if(!empty($post['lokasi_aanwijzing_2_inp'])){
            $input_prep['ptp_lokasi_aanwijzing2'] = $post['lokasi_aanwijzing_2_inp'];
        }
        if(!empty($post['tgl_aanwijzing_2_inp'])){
            $input_prep['ptp_tgl_aanwijzing2'] = $post['tgl_aanwijzing_2_inp'];
        }
        
        $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

        $bid = strtotime($prep['ptp_quot_opening_date']);
        $bid2 = strtotime($input_prep['ptp_bid_opening2']);
        $aanwijzing2 = strtotime($input_prep['ptp_tgl_aanwijzing2']);

        if($bid2 < $bid){
            $this->setMessage("Tanggal penutupan penawaran tahap 2 tidak boleh kurang dari penutupan penawaran");
            if(!$error){
                $error = true;
            }
        }

        if($bid2 < $aanwijzing2){
            $this->setMessage("Tanggal penutupan penawaran tahap 2 tidak boleh kurang dari aanwijzing tahap 2");
            if(!$error){
                $error = true;
            }
        }

    }

    if($last_activity == 1080){

        $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

        if($prep['ptp_tender_method'] == 2){

            $mendaftar = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->num_rows();

            if($mendaftar < 3){
                $this->setMessage("Minimal 3 vendor yang mendaftar");
                if(!$error){
                    $error = true;
                }
            }
            
        }

    }

    if(in_array($last_activity, array(1100,1120))){

        if ($response_name == url_title('Proses E-Auction',"_",true)){

            if(isset($post['reset_inp']) && !empty($post['reset_inp'])){

                $this->db
                ->where("ppm_id",$ptm_number)
                ->delete("prc_eauction_history");

                $this->db
                ->where("ppm_id",$ptm_number)
                ->delete("prc_eauction_history_item");

                $reset = $this->db->where("ppm_id",$ptm_number)
                ->update("prc_eauction_header",['status'=>0]);

            } else {

                $running = (isset($post['eauction_running']) && !empty($post['eauction_running']));

                if(!$running){

                    $mulai_eauction     = strtotime($post['tgl_mulai_eauction_inp']);

                    $selesai_eauction   = strtotime($post['tgl_selesai_eauction_inp']);

                    if($selesai_eauction < time()){

                        $this->setMessage("Tanggal selesai e-auction tidak boleh lewat dari sekarang");

                        if(!$error){

                        $error = true;

                        }

                    }

                    if($mulai_eauction < time()){

                        $this->setMessage("Tanggal mulai e-auction tidak boleh lewat dari sekarang");

                        if(!$error){

                        $error = true;

                        }

                    }

                    if($mulai_eauction > $selesai_eauction){

                        $this->setMessage("Tanggal selesai e-auction tidak boleh mundur dari tanggal mulai");

                        if(!$error){

                        $error = true;

                        }

                    }

                }

                if(!$running && !$error){

                    $bid_minutes = 10;

                    $inp = array(
                    "hps"=>$post['total_alokasi_inp'],
                    "batas_atas"=>moneytoint($post['b_atas_eauction_money_inp'])+0,
                    "batas_bawah"=>moneytoint($post['b_bawah_eauction_money_inp'])+0,
                    "created_by"=>$userdata['employee_id'],
                    "created_date"=>date("Y-m-d H:i:s"),
                    "deskripsi"=>$post['deskripsi_eauction_inp'],
                    "judul"=>$post['judul_eauction_inp'],
                    "minimal_penurunan"=>moneytoint($post['penurunan_eauction_inp']),
                    "status"=>1,
                    "tanggal_berakhir"=>$post['tgl_selesai_eauction_inp'],
                    "tanggal_mulai"=>$post['tgl_mulai_eauction_inp'],
                    "tipe"=>$post['tipe_eauction_inp'],
                    "waktu_detik"=>$post['tipe_eauction_inp'],
                    "curr_id"=>$tender['ptm_currency'],
                    "batas_atas_percent"=>moneytoint($post['b_atas_eauction_percent_inp'])+0,
                    "batas_bawah_percent"=>moneytoint($post['b_bawah_eauction_percent_inp'])+0,
                    "max_bid_per_minute"=>$bid_minutes,
                    );

                    $eact = $this->db->where("ppm_id",$ptm_number)
                    ->update("prc_eauction_header",['status'=>0]);

                    $inp['ppm_id'] = $ptm_number;

                    $eact = $this->db->insert("prc_eauction_header",$inp);

                    if($eact){

                        $this->db
                        ->where("ppm_id",$ptm_number)
                        ->delete("prc_eauction_vendor");

                        $this->db->where("ppm_id",$ptm_number)
                        ->delete("prc_eauction_item");

                        $vendor = $this->db->where("ptm_number",$ptm_number)
                        ->get("prc_tender_vendor_status")
                        ->result_array();

                        foreach ($vendor as $key => $value) {

                            $inp = array(
                                "bid_in_minutes"=>$bid_minutes,
                                "vendor_id"=>$value['pvs_vendor_code'],
                                "ppm_id"=>$ptm_number
                            );

                            $this->db->insert("prc_eauction_vendor",$inp);

                        }

                        foreach ($post['harga_penurunan'] as $key => $value) {

                            $inp = array(
                                "tit_id"=>$key,
                                "value_min"=>moneytoint($value),
                                "ppm_id"=>$ptm_number
                            );

                            $this->db->insert("prc_eauction_item",$inp);

                        }

                    }

                }

            }

        }

    }

    if(in_array($last_activity, array(1073,1160))){

        $periode_sanggahan = !empty($post['periode_sanggahan_inp']) ? moneytoint($post['periode_sanggahan_inp']) : 0;
        $sanggahan_start = date("Y-m-d H:i:s");
        $sanggahan_end = date("Y-m-d H:i:s",strtotime("+$periode_sanggahan day"));

        $begin = new DateTime( $sanggahan_start );
        $end = new DateTime($sanggahan_end);
        $end = $end->modify( '+0 day' ); 

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        $a = 0;
        foreach($daterange as $date){
            $x = $date->format("N");
            if($x < 6){
                $a++;
            }
        }

        //start hlmifzi
        if($periode_sanggahan != $a){
            $periode_sanggahan += ($periode_sanggahan-$a);
            $sanggahan_end = date("Y-m-d H:i:s",strtotime("+$periode_sanggahan day"));
        } elseif ($periode_sanggahan == 0) {
            $periode_sanggahan += 0;
            $sanggahan_end = date("Y-m-d H:i:s");
        }
        //end

        $input_prep['ptp_denial_period'] = $periode_sanggahan;
        $input_prep['ptp_denial_period_start'] = $sanggahan_start;
        $input_prep['ptp_denial_period_end'] = $sanggahan_end;

    }

    if($last_activity == 1090){

        $vendor_status = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();
        $mendaftar = 0;
        $tidak_diverifikasi = 0;
        foreach ($vendor_status as $key => $value) {
            if($value['pvs_status'] != 1){
            $mendaftar++;
            }
            if($value['pvs_status'] == 3){
            $tidak_diverifikasi++;
            }
        }

        if(empty($mendaftar)){
            $this->setMessage("Tidak ada vendor yang mendaftar. Proses tidak dapat berlanjut");
            if(!$error){
            $error = true;
            }
        }

        if(!empty($tidak_diverifikasi)){
            $this->setMessage("Beberapa vendor belum di verifikasi. Proses tidak dapat berlanjut");
            if(!$error){
            $error = true;
            }
        }

    }

    if($last_activity == 1120 && !in_array($response_name, $except)){

        $getevalcalculated = $this->db->where("pte_price_value >",0)
        ->where("ptm_number",$ptm_number)->get("prc_tender_eval")->num_rows(); 

        if(empty($getevalcalculated)){
            $this->setMessage("Proses perhitungan evaluasi harga belum dilaksanakan. Proses tidak dapat berlanjut");
            if(!$error){
                $error = true;
            }
        }

    }

    if($last_activity == 1180 || $last_activity == 1181){

        $wins = [];

        $quota_vend = [];

        $winner_quota = [];
        
        if ($last_activity == 1180) {

            foreach ($post['tit_code_inp'] as $k => $v) {

                foreach ($post['winner_inp'] as $ky => $val) {

                    $winval[$v][$val] = "100";

                }

            }  

            $winner_input = $winval;

        } else {

            if($tender['ptm_type_of_plan'] == "rkp_matgis"){

            $winner_input = $post['winner_inp'];

            } else {

              $winval = [];

              foreach ($post['winner_inp'] as $ky => $val) {

                  $winval[$ky][$val] = "100";

              } 

              $winner_input = $winval;

            }

        }

        $ke = 1;

        foreach ($winner_input as $key => $value) {

            $total = 0;

            $i = $this->db
            ->where("tit_id",$key)
            ->where("ptm_number",$ptm_number)
            ->get("prc_tender_item")
            ->row_array();

            foreach ($value as $k => $v) {

                $winner_quota[] = [
                    "tit_id"=>$key,
                    "vendor_id"=>$k,
                    "percentage"=>moneytoint($v),
                    "weight"=>moneytoint($v)/100*$i['tit_quantity'],
                    "ptm_number"=>$ptm_number
                ];

                $x = moneytoint($v);

                $total += $x;

                if($x > 0){

                    $wins[] = ['vendwin'=>$k,'itemwin'=>$key];

                }

                if(!isset($quota_vend[$k])){
                    $quota_vend[$k] = $x;
                } else {
                    $quota_vend[$k] += $x;
                }

            }

            if ($response_name != url_title('Simpan Sebagai Draft',"_",true)) {
            
                if((int) $total != 100 && !$error){
                    $this->setMessage("Setiap item harus berjumlah 100% <br/> <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>  Pada item ke-$ke dengan total ".str_replace('.', ',', $total));
                    $error = true;
                }

            }

            $ke++;

        }

        $ordered_values = $quota_vend;

        rsort($ordered_values);

        $rank = [];

        $vndloser = [];

        foreach ($quota_vend as $key => $value) {

            if(!empty($value)){
                foreach ($ordered_values as $ordered_key => $ordered_value) {
                    if ($value === $ordered_value) {
                        $key = $ordered_key;
                        break;
                    }
                }

                $rank[$value] = ((int) $key + 1);
                
            } else {

                $vndloser[] = $key;
            }
        }

        $ranked = [];

        foreach ($quota_vend as $key => $value) {
            foreach ($rank as $k => $v) {
                if($value == $k){
                    $ranked[$key] = $v;
                }
            }
        }

        $ranked_index = array_flip($ranked);

    }

    if ($last_activity == 1180) {

        $this->db->where("pvs_vendor_code !=", $post['winner_inp'][0]);
        $vdlose = $this->Procrfq_m->getVendorStatusRFQ("", $ptm_number)->result_array();
        
        $vnloser = null;

        foreach ($vdlose as $vk => $vv) {
            $vnloser[] = $vv['pvs_vendor_code'];
        }

        $loser = $vnloser;

    } else if ($last_activity == 1181){

        $loser = $vndloser;

    }

    $n = 0;

    $this->form_validation->set_rules("id", 'ID', 'required');
    foreach ($post as $key => $value) {

        if(is_array($value)){

            foreach ($value as $key2 => $value2) { 

                $this->form_validation->set_rules($key."[".$key2."]", '', '');

                if(isset($post['doc_id_inp'][$key2])){
                    $input_doc[$key2]['ptd_id'] = $post['doc_id_inp'][$key2];
                }

                if(isset($post['doc_category_inp'][$key2])){
                    $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
                    $input_doc[$key2]['ptd_category']= $post['doc_category_inp'][$key2];
                }
                if(isset($post['doc_desc_inp'][$key2])){
                    $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
                    $input_doc[$key2]['ptd_description']= $post['doc_desc_inp'][$key2];
                }
                if(isset($post['doc_attachment_inp'][$key2])){
                    $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
                    $input_doc[$key2]['ptd_file_name']= $post['doc_attachment_inp'][$key2];
                }
                if(isset($post['doc_type_inp'][$key2])){
                    $input_doc[$key2]['ptd_type']= $post['doc_type_inp'][$key2];
                }

                if(isset($post['jabatan'][$key2])){

                    $this->form_validation->set_rules("user[$key2]", "Nama Lengkap #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
                    
                    if(!empty($post['person_id'][$key2])){
                      $input_person[$key2]['id']=$post['person_id'][$key2];
                    }
        
                    if(!empty($post['user'][$key2])){
                      $input_person[$key2]['pp_nama_lengkap']=$post['user'][$key2];
                    }
        
                    if(!empty($post['user_manual'][$key2])){
                      $input_person[$key2]['pp_nama_lengkap']=$post['user_manual'][$key2];
                    }
                    $input_person[$key2]['pp_jabatan']=$post['jabatan'][$key2];
                    $input_person[$key2]['pp_divisi']=$post['divisi'][$key2];
                    $input_person[$key2]['pp_nama_perusahaan']=$post['perusahaan'][$key2];
                    $input_person[$key2]['pp_no_telp']=$post['telp'][$key2];
                    $input_person[$key2]['pp_email']=$post['email'][$key2];
                    $input_person[$key2]['pp_note']=$post['person_keterangan'][$key2];
                    $input_person[$key2]['pp_created_by']=$userdata['employee_id'][$key2];
                    $input_person[$key2]['pp_created_date']=date('Y-m-d h:i:s');
                }

                if(isset($post['rks_desc_inp'][$key2])){                    
                    $rks_tender[$key2]['id']=$post['rks_desc_inp'][$key2];
                    $rks_tender[$key2]['created_by']=$userdata['employee_id'];
                    $rks_tender[$key2]['created_date']=date('Y-m-d h:i:s');
                }
            }

            $n++;

        }

    }

    if ($this->form_validation->run() == FALSE || $error){

        $this->renderMessage("error");

    } else {

        $this->db->trans_begin();

        if(!empty($input)){

            $act = $this->Procrfq_m->updateDataRFQ($ptm_number,$input);

        } else {

            $act = true;

        }

        $complete_comment = 1;

        if(!empty($input_person)){

            $deleted = array();
        
            foreach ($input_person as $key => $value) {
              $value['ptm_number'] = $ptm_number;
              $act = $this->Procrfq_m->replacePerson($key,$value);
              if($act){
                $deleted[] = $act;
              }
            }
        
            $this->Procrfq_m->deleteIfNotExistPerson($ptm_number,$deleted);
        
        }

        if(!empty($rks_tender)){

            $deleted = array();
        
            foreach ($rks_tender as $key => $value) {
                
                $data = $this->db->query("select * from adm_rks where id = '". $value['id'] ."'")->row_array();

                $value['ptm_number'] = $ptm_number;
                $value['rks_cat'] = $data['header_main'];
                $value['rks_sub_cat'] = $data['header_sub'];
                $value['rks_desc'] = $data['description'];

                $act = $this->Procrfq_m->replaceRks($key,$value);
                if($act){
                    $deleted[] = $act;
                }
            }
        
            $this->Procrfq_m->deleteIfNotExistRks($ptm_number,$deleted);
        
        }

        if(!empty($input_prep)){

            $p = $this->Procrfq_m->getPrepRFQ($ptm_number)->num_rows();
            if(!empty($p)){
            $this->Procrfq_m->updatePrepRFQ($ptm_number,$input_prep);
            } else {
            $input_prep['ptm_number'] = $ptm_number;
            $this->Procrfq_m->updatePrepRFQ($input_prep);
            }
        }

        if(!empty($input_doc)){

            $deleted = array();

            foreach ($input_doc as $key => $value) {
                $value['ptm_number'] = $ptm_number;
                $id = (isset($value['ptd_id'])) ? $value['ptd_id'] : "";
                $act = $this->Procrfq_m->replaceDokumenRFQ($id,$value);
                if($act){
                    $deleted[] = $act;
                }
            }

            $this->Procrfq_m->deleteIfNotExistDokumenRFQ($ptm_number,$deleted);            

        }
        
        if($last_activity == 1040){
            
            $this->load->model("Vendor_m");
            
            if(!empty($invited_vendor)){
                
                $prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

                if($prep['ptp_tender_method'] == 5 && $prep['ptp_prequalify'] != 2){

                    $this->db->where("ptm_number",$ptm_number)->delete("prc_tender_vendor");
                    $this->db->where("ptm_number",$ptm_number)->delete("prc_tender_vendor_status");

                } else {

                    $deleted = array();

                    if(substr($prep['ptp_klasifikasi_peserta'], 0,1) == 1){
                        $filtering_vendor[] = "K";
                    }

                    if(substr($prep['ptp_klasifikasi_peserta'], 1,1) == 1){
                        $filtering_vendor[] = "M";
                    }

                    if(substr($prep['ptp_klasifikasi_peserta'], 2,1) == 1){
                        $filtering_vendor[] = "B";
                    }

                    $this->db->where_in("fin_class",$filtering_vendor)->where_in("vendor_id",$invited_vendor);

                    $list_vnd = $this->Vendor_m->getVendorActive()->result_array();

                    if(isset($prep['ptp_prequalify']) && $prep['ptp_prequalify'] != 2){ 

                        foreach ($list_vnd as $key => $value) {

                            $inp = array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$value['vendor_id']);
                            $act = $this->Procrfq_m->replaceVendorStatusRFQ($inp);

                            if($act){
                                $deleted[] = $act;
                            }

                        }

                        $this->Procrfq_m->deleteIfNotExistVendorStatusRFQ($ptm_number,$deleted);

                    }

                }

            }

        }

        if($last_activity == 1180 || $last_activity == 1181){

            $isi = in_array("", $post['winner_inp']);

            if ($isi) {

            } else {

                if ($response != 605 OR $response != 606) {

                    foreach ($winner_quota as $key => $value) {

                        $this->Procrfq_m->insert_tender_winner($value);

                    }

                }

                if(isset($post['rank_inp']) && !empty($post['rank_inp'])){
                
                    //insert vendor winner to each item
                    foreach ($wins as $keyss => $valuess) {

                    $isi = $this->db
                    ->where(["ptm_number"=>$ptm_number,"tit_id"=>$valuess['itemwin']])
                    ->update("prc_tender_item",["ptv_vendor_code" =>$valuess['vendwin']]);

                    $quo_main = $this->Procrfq_m
                    ->getVendorQuoMainRFQ($valuess['vendwin'],$ptm_number)
                    ->row_array();

                    $quo_item = $this->Procrfq_m
                    ->getViewVendorQuoComRFQ($valuess['itemwin'], $quo_main['pqm_id'], $ptm_number)
                    ->result_array();

                    $rfq = $this->Procrfq_m
                    ->getRFQ($ptm_number)
                    ->row_array();

                    foreach ($quo_item as $k => $v) {

                        if($v['catalog_type'] == "M"){

                            $isi = array(
                                "mat_catalog_code" => $v['tit_code'],
                                "short_description" => $v['short_description'],
                                "long_description" => $v['long_description'],
                                "del_point_id" => $rfq['ptm_delivery_point_id'],
                                "del_point_name" => $rfq['ptm_delivery_point'],
                                "sourcing_date" => date("Y-m-d H:i:s"),
                                "unit_price" => $v['pqi_price'],
                                "handling_cost" => 0,
                                "insurance_cost" => 0,
                                "freight_cost" => 0,
                                "tax_duty" => 0,
                                "total_cost" => $v['pqi_price'],
                                "discount" => 0,
                                "sourcing_id" => 7,
                                "currency" => $quo_main['pqm_currency'],
                                "vendor" => $v['vendor_name'],
                                "status"=>"A",
                                "notes" => "No. Tender : ".$ptm_number.", Vendor : ".$v['vendor_name'].", No. Penawaran : ".$quo_main['pqm_number'],
                                "update_by" => $v['vendor_id'],
                                "update_by_user" =>$v['vendor_name'],
                                "updated_datetime" => date("Y-m-d H:i:s"),
                                "thn_pengadaan" => date("Y"),
                                "dept" => $userdata['dept_name'],
                                "location" => NULL,
                                "duration" => floor((time() - strtotime($tender['ptm_created_date'])) / (60 * 60 * 24))." Hari"
                            );

                            if (strlen($v['tit_code']) < 10) {
                                $cekmatprice = $this
                                ->Commodity_m
                                ->getMatSmbdPrice("", $v['tit_code'])
                                ->result_array();

                                $this
                                ->Commodity_m
                                ->newPrice($cekmatprice, $v['tit_code'], $isi,true); //tambah true jika sumberdaya
                                
                            } else {
                                    
                                    $cekmatprice = $this
                                    ->Commodity_m
                                    ->getMatPrice("", $v['tit_code'])
                                    ->result_array();

                                    $this
                                    ->Commodity_m
                                    ->newPrice($cekmatprice, $v['tit_code'], $isi); 
                                }           

                        } else {

                            $isi = array(
                                "srv_catalog_code" => $v['tit_code'],
                                "short_description" => $v['tit_description'],
                                "long_description" => $v['tit_description'],
                                "del_point_id" => $rfq['ptm_delivery_point_id'],
                                "del_point_name" => $rfq['ptm_delivery_point'],
                                "sourcing_id" => 7,
                                "sourcing_date" => date("Y-m-d H:i:s"),
                                "currency" => $quo_main['pqm_currency'],
                                "total_price" => $v['pqi_price'],
                                "vendor" => $v['vendor_name'],
                                "status"=>"A",
                                "notes" => "No. Tender : ".$ptm_number.", Vendor : ".$v['vendor_name'].", No. Penawaran : ".$quo_main['pqm_number'],
                                "updated_by" => $v['vendor_id'],
                                "updated_by_user" =>$v['vendor_name'],
                                "updated_datetime" => date("Y-m-d H:i:s"),
                                "thn_pengadaan" => date("Y"),
                                "dept" => $userdata['dept_name'],
                                "location" => NULL,
                                "duration" => floor((time() - strtotime($tender['ptm_created_date'])) / (60 * 60 * 24))." Hari"
                            );

                            $isi_smbd = array(
                                "srv_catalog_code" => $v['tit_code'],
                                "short_description" => $v['tit_description'],
                                "long_description" => $v['tit_description'],
                                "del_point_id" => $rfq['ptm_delivery_point_id'],
                                "del_point_name" => $rfq['ptm_delivery_point'],
                                "sourcing_id" => 7,
                                "sourcing_date" => date("Y-m-d H:i:s"),
                                "currency" => $quo_main['pqm_currency'],
                                "total_cost" => $v['pqi_price'],
                                "vendor" => $v['vendor_name'],
                                "status"=>"A",
                                "notes" => "No. Tender : ".$ptm_number.", Vendor : ".$v['vendor_name'].", No. Penawaran : ".$quo_main['pqm_number'],
                                "update_by" => $v['vendor_id'],
                                "update_by_user" =>$v['vendor_name'],
                                "updated_datetime" => date("Y-m-d H:i:s"),
                                "thn_pengadaan" => date("Y"),
                                "dept" => $userdata['dept_name'],
                                "location" => NULL,
                                "duration" => floor((time() - strtotime($tender['ptm_created_date'])) / (60 * 60 * 24))." Hari"
                            );

                            if (strlen($v['tit_code']) < 10) {
                                $ceksrvprice = $this
                                ->Commodity_m
                                ->getSrvSmbdPrice("", $v['tit_code'])
                                ->result_array();
                                
                                $this
                                ->Commodity_m
                                ->newSrvPrice($ceksrvprice, $v['tit_code'], $isi_smbd,true); //tambah true jika sumberdaya

                            } else {
                                $ceksrvprice = $this
                                ->Commodity_m
                                ->getSrvPrice("", $v['tit_code'])
                                ->result_array();

                                $this
                                ->Commodity_m
                                ->newSrvPrice($ceksrvprice, $v['tit_code'], $isi);
                            }
                        }
                    }
                }

                //change status winner for each vendor

                foreach ($ranked_index as $k => $v) {

                    $inpv = array("pte_is_winner"=> 1, "pte_rank"=>0);
                    $this->db
                    ->where(array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$v))
                    ->update("prc_tender_eval",$inpv);

                    $inps = array("pvs_is_winner"=> 1, "pvs_status"=> 11);

                    $this->db
                    ->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$v))
                    ->update("prc_tender_vendor_status",$inps);
                    $rank++;

                }

                //change status loser for each vendor

                if (!empty($loser)) {
                    foreach ($loser as $ky => $val) {

                        $inpv = array("pte_is_winner"=> 0, "pte_rank"=>0);
                        $this->db
                        ->where(array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$val))
                        ->update("prc_tender_eval",$inpv);

                        $inps = array("pvs_is_winner"=> 0, "pvs_status"=> 24);
                        $this->db
                        ->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$val))
                        ->update("prc_tender_vendor_status",$inps);

                    }  
                }

            }

            $stat = ($last_activity == 1180) ? 1901 : 1905;

            $this->db
            ->where(array("ptm_number"=>$ptm_number))
            ->update("prc_tender_main",array("ptm_status"=>$stat)); 

            }

        }

        if($last_activity == 1060){

            //KIRIM EMAIL KE VENDOR

            $msg = "Dengan hormat,
            <br/>
            <br/>
            Bersama ini kami sampaikan bahwa ".COMPANY_NAME." membuka pendaftaran 
            untuk dapat berpartisipasi dalam pengadaan nomor <strong>$ptm_number</strong> 
            dengan nama pengadaan : '$tender_name'.
            <br/>
            Pendaftaran pengadaan dapat dilakukan melalui <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a> dengan memastikan bahwa data perusahaan anda sudah lengkap dan masih berlaku.";

            $invited_vendor = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

            foreach ($invited_vendor as $key => $value) {

                $deleted2 = array();

                $mail = $value['email_address'];

                //$email = $this->sendEmail($mail,"Pemberitahuan Pengadaan Nomor $ptm_number",$msg);

                $inp = array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$value['pvs_vendor_code'],"pvs_status"=>1);
                $act2 = $this->Procrfq_m->replaceVendorStatusRFQ($inp);

                if($act2){
                    $deleted2[] = $act2;
                }

            }

        }

        if($last_activity == 1080){

            $invited_vendor = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

            if(!empty($invited_vendor)){

                foreach ($invited_vendor as $key => $value) {

                    $inp = array("ptv_is_attend"=>0);

                    $where = array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$value['pvs_vendor_code']);

                    $check = $this->db->where($where)->get('prc_tender_vendor')->row_array();

                    if(empty($check)){
                        $this->db->insert('prc_tender_vendor',array_merge($inp,$where));
                    }

                }

            }

            $vendor_attend = (isset($post['vendor_hadir'])) ? $post['vendor_hadir'] : array();

            if(!empty($vendor_attend)){

                $is_attend = array();

                foreach ($vendor_attend as $key => $value) {

                    $is_attend[] = $key;

                    $inp = array("ptv_is_attend"=>$value);

                    $where = array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$key);

                    $check = $this->db->where($where)->get("prc_tender_vendor")->row_array();

                    if(!empty($check)){
                    $this->db->where($where)->update('prc_tender_vendor',$inp);
                    } else {
                    $this->db->where($where)->insert('prc_tender_vendor',$inp);
                    }

                }

            }

            $eval_id = $this->Procrfq_m->getPrepRFQ($ptm_number)->row()->evt_id;

            $evaluasi = $this->Procevaltemp_m->getTemplateEvaluasi($eval_id)->row_array();

            $invited_vendor = $this->Procrfq_m->getVendorRFQ("",$ptm_number)->result_array();

            $deleted3 = array();

            foreach ($invited_vendor as $key => $value) {

                $inp = array(
                "ptm_number"=>$ptm_number,
                "ptv_vendor_code"=>$value['ptv_vendor_code'],
                "pte_passing_grade"=>$evaluasi['evt_passing_grade'],
                "pte_technical_weight"=>$evaluasi['evt_tech_weight'],
                "pte_price_weight"=>$evaluasi['evt_price_weight']
                );
                $act3 = $this->Procrfq_m->replaceEvalRFQ($inp);

                if($act3){
                    $deleted3[] = $act3;
                }

            }

            if(!empty($deleted3)){
                $this->Procrfq_m->deleteIfNotExistEvalRFQ($ptm_number,$deleted3);
            }

        }

        if($last_activity == 1114){

            $vendor_attend = (isset($post['vendor_hadir_2'])) ? $post['vendor_hadir_2'] : array();

            if(!empty($vendor_attend)){

                foreach ($vendor_attend as $key => $value) {

                    $inp = array("ptv_is_attend_2"=>$value);

                    $where = array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$key);

                    $this->db->where($where)->update('prc_tender_vendor',$inp);

                }

            }

        }

        if($last_activity == 1113){

            $this->db->where(array("pvs_status"=>5,"ptm_number"=>$ptm_number))
            ->update("prc_tender_vendor_status",array("pvs_status"=>2));

        }

        if($last_activity == 1170 || $last_activity == 1160){

            $sta = array(1160=>9,1170=>8);

            $eval = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

            foreach ($eval as $key => $value) {
                if(strtolower($value['pass']) == "lulus"){
                $this->db->where(array("pvs_vendor_code"=>$value['ptv_vendor_code'],"ptm_number"=>$ptm_number))
                ->update("prc_tender_vendor_status",array("pvs_status"=>$sta[$last_activity]));
                }
            }

        }

        if($last_activity == 1090){

            $eval_id = $this->Procrfq_m->getPrepRFQ($ptm_number)->row()->evt_id;

            $evaluasi = $this->Procevaltemp_m->getTemplateEvaluasi($eval_id)->row_array();

            $this->db->where("pvs_status",4);

            $qualified_vendor = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

            foreach ($qualified_vendor as $key => $value) {

                $deleted3 = array();

                $inp = array(
                    "ptm_number"=>$ptm_number,
                    "ptv_vendor_code"=>$value['pvs_vendor_code'],
                    "pte_passing_grade"=>$evaluasi['evt_passing_grade'],
                    "pte_technical_weight"=>$evaluasi['evt_tech_weight'],
                    "pte_price_weight"=>$evaluasi['evt_price_weight']
                );

                $act3 = $this->Procrfq_m->replaceEvalRFQ($inp);

                if($act3){
                    $deleted3[] = $act3;
                }

            }

        }

        if($last_activity == 1140){

            if ($response_name == url_title('Buka Negosiasi',"_",true)) {

                if(isset($post['msg_nego_inp']) && !empty($post['msg_nego_inp'])){

                    $vnd_id = $post['vendor_nego_inp'];

                    $inp = array(
                        "ptm_number"=>$ptm_number,
                        "awa_id"=>$last_activity,
                        "pbm_vendor_code"=> $vnd_id,
                        "pbm_message"=>$post['msg_nego_inp'],
                        "pbm_date"=>date("Y-m-d H:i:s"),
                        "pbm_mode"=>null,
                        "pbm_user"=>$userdata['complete_name'],
                    );

                    $msg = $this->Procrfq_m->insertMessageRFQ($inp);

                    if($msg){

                        $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code !="=>$vnd_id))
                        ->update("prc_tender_vendor_status",array("pvs_is_negotiate"=>0));
                        $this->db->where(array("ptm_number"=>$ptm_number,"pvs_vendor_code"=>$vnd_id))
                        ->update("prc_tender_vendor_status",array("pvs_is_negotiate"=>1,"pvs_status"=>10));
                    }

                } else {
                    $this->setMessage("Silahkan pilih vendor dan isi pesan negosiasi terlebih dahulu");
                    if(!$error){
                        $error = true;
                    }
                }
            }
        }

        if($last_activity == 1073){

            $this->db
            ->where("ptm_number",$ptm_number)
            ->where("pvs_pq_passed !=",1)
            ->update("prc_tender_vendor_status",
                array("pvs_status"=>"-12"));
            $this->db
            ->where("ptm_number",$ptm_number)
            ->where("pvs_pq_passed",1)
            ->update("prc_tender_vendor_status",
                array("pvs_status"=>"12"));

        }

        if(!empty($return['message'])){
            $this->setMessage($return['message']);
            if(!$error){
                $error = true;
            }
        }

        if ($last_activity == 1160) {
            //validation n send email doc pemenang;
            $this->db->where('rfq_no', $ptm_number);
            $this->db->where('tipe', 1);
            $docsPemenang = $this->db->get('prc_doc_pengumuman')->row_array();

            if($docsPemenang == null)
            {
                $error = true;
                $this->setMessage("Dokumen Surat Pemenang harus upload terlebih dulu");
            } else {
                //send email;

            }

            

            

            // $this->db->where(array("adm"=>"Lulus"));
            // $eval_data = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

            // $i = 1;
            // foreach ($eval_data as $key => $value) {

            //     $vnd_email = $this->db
            //     ->select('email_address')
            //     ->where("vendor_id",$value['ptv_vendor_code'])
            //     ->get("vnd_header")
            //     ->row()
            //     ->email_address; 

            //     $tipe_pemenang = $tender['ptm_winner'] == 2 ? 'Multi-Winner atau dapat memiliki lebih dari satu pemenang' : 'Single-Winner alias hanya satu pemenang';

            //     $msg2 = $post['periode_sanggahan_inp'] > 0 ? "Kami memberikan kesempatan kepada saudara untuk mengikuti masa sanggah selama ".$post['periode_sanggahan_inp']." hari sejak penetapan pemenang ini. Proses penyampaian sanggahan dapat dilakukan di sistem <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a> dengan memberikan jaminan sanggahan sebesar 10% dari nilai penawaran sesuai dengan prosedur ".COMPANY_NAME.".
            //     <br><br>" : "";

            //     $value['pass_price'] != '' ? $value['pass_price'] : 'Tidak Lulus';

            //     $msg = "Dengan hormat,
            //     <br/>
            //     <br/>
            //     Sehubungan dengan proses pengadaan <strong>$tender_name</strong> nomor <strong>$ptm_number</strong>, 
            //     kami sampaikan terima kasih atas proposal penawaran yang dikirimkan dan telah kami terima dengan baik.
            //     <br>
            //     <br/> 
            //     Setelah kami lakukan evaluasi atas proposal penawaran yang masuk, dengan ini kami sampaikan bahwa penawaran dari perusahaan Bapak/Ibu menduduki peringkat <strong>ke - ".$i."</strong> dengan hasil sebagai berikut : 
            //     <br>
            //     <ul>
            //     <li>
            //     Administrasi : <strong>".$value['adm']."</strong>
            //     </li>
            //     <li>
            //     Teknis : <strong>".$value['pass']."</strong>
            //     </li>
            //     <li>
            //     Validitas Penawaran : <strong>".$value['pass_price']."</strong>
            //     </li>
            //     </ul>
            //     Perlu diketahui, pengadaan ini bersifat ".$tipe_pemenang.".
            //     <br>
            //     <br/>
            //     ".$msg2."
            //     Demikian disampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih";

            //     //$email = $this->sendEmail($vnd_email,"Pengumuman Pemenang Nomor $ptm_number - $tender_name",$msg);
            //     $i++;
            // }
        }

        $com = $post['comment_inp'][0];

        $attachment = '';

        if ($last_activity == 1180) {
            $this->db->where('rfq_no', $ptm_number);
            $this->db->where('tipe', 2);
            $docsPemenang = $this->db->get('prc_doc_pengumuman')->row_array();

            if($docsPemenang == null)
            {
                $error = true;
                $this->setMessage("Dokumen Surat Penunjuk Penyedia harus upload terlebih dulu");
            } else {
                //send email;
                
            }

            foreach ($ranked_index as $key => $value) {

                $vnd_email = $this->db
                ->select('email_address')
                ->where("vendor_id",$value)
                ->get("vnd_header")
                ->row()
                ->email_address; 

                

                // $msg = "Dengan hormat,
                // <br/>
                // <br/>
                // Kami mengucapkan SELAMAT atas ditetapkannya Perusahaan Bapak/Ibu menjadi pemenang atas pengadaan <strong>$ptm_number</strong> dengan nama pengadaan '$tender_name'.
                // <br>
                // Untuk lebih jelasnya Bapak/Ibu dapat mengakses ke <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a>.
                // <br>
                // Gunakan username dan password yang telah Anda buat pada saat melakukan registrasi.";

                // //$email = $this->sendEmail($vnd_email,"Pengumuman Penetapan Pemenang Nomor $ptm_number",$msg);

            }

            $vendors_not_win = $this->db
            ->select('ptv_vendor_code')
            ->where_in('ptv_vendor_code',$loser)
            ->where(array('ptm_number'=>$ptm_number,'adm'=>'Lulus','pass'=>'Lulus','pass_price'=>'Lulus'))
            ->get('vw_prc_evaluation')->result_array();

            foreach ($vendors_not_win as $key => $vnw) {

                $vnd_not_win_email = $this->db
                ->select('email_address')
                ->where("vendor_id",$vnw['ptv_vendor_code'])
                ->get("vnd_header")
                ->row()
                ->email_address;

                $msg = "Dengan hormat,
                <br/>
                <br/>
                Sehubungan dengan proses pengadaan '$tender_name' nomor <strong>$ptm_number</strong>, kami sampaikan terima kasih atas proposal penawaran yang dikirimkan dan telah kami terima dengan baik.
                <br>
                Setelah kami lakukan evaluasi atas proposal penawaran yang masuk, dengan ini kami memberitahukan bahwa proposal penawaran, proses klarifikasi teknis dan negosiasi harga dari perusahaan Bapak/Ibu belum memenuhi kriteria kebutuhan kami saat ini.
                <br>
                Besar harapan kami agar Perusahaan Bapak/Ibu dapat berpartisipasi dalam pengadaan ".COMPANY_NAME." di kesempatan berikutnya.
                <br/>
                <br/>
                Demikian disampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.";

                //$email = $this->sendEmail($vnd_not_win_email,"Pengumuman Pengadaan Nomor $ptm_number",$msg);

            }
        

        } else if ($last_activity == 1181 AND $response_name != url_title('Simpan Sebagai Draft',"_",true)) {

            foreach ($ranked_index as $key => $value) {

                $vnd_email = $this->db->select('email_address')
                ->where("vendor_id",$value)
                ->get("vnd_header")
                ->row()
                ->email_address; 

                $items = $this->db
                ->select('tit_description,tit_quantity,tit_unit')
                ->where(array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$value))
                ->get('prc_tender_item')
                ->result_array();

                $item_satuan = '';

                foreach ($items as $key => $value_item) {

                    $item_satuan .= "<li>".$value_item['tit_description']." dengan jumlah ".$quota_vend[$value]." ". $value_item['tit_unit']."</li>";

                }

                if ($item_satuan != '') {

                    $msg = "Dengan hormat,
                    <br/>
                    <br/>
                    Kami mengucapkan SELAMAT atas ditetapkannya Perusahaan Bapak/Ibu menjadi pemenang atas pengadaan <strong>$ptm_number</strong> dengan nama pengadaan '$tender_name' untuk beberapa item berikut :
                    <br>
                    <ol>".$item_satuan."</ol>
                    <br>
                    Untuk lebih jelasnya Bapak/Ibu dapat mengakses ke <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a>.
                    <br>
                    Gunakan username dan password yang telah Anda buat pada saat melakukan registrasi.";

                } else {

                    $msg = "Dengan hormat,
                    <br/>
                    <br/>
                    Sehubungan dengan proses pengadaan '$tender_name' nomor <strong>$ptm_number</strong>, kami sampaikan terima kasih atas proposal penawaran yang dikirimkan dan telah kami terima dengan baik.
                    <br>
                    Setelah kami lakukan evaluasi atas proposal penawaran yang masuk, dengan ini kami memberitahukan bahwa proposal penawaran, proses klarifikasi teknis dan negosiasi harga dari perusahaan Bapak/Ibu belum memenuhi kriteria kebutuhan kami saat ini.
                    <br>
                    Besar harapan kami agar Perusahaan Bapak/Ibu dapat berpartisipasi dalam pengadaan ".COMPANY_NAME." di kesempatan berikutnya.
                    <br/>
                    <br/>
                    Demikian disampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.";

                }

                //$email = $this->sendEmail($vnd_email,"Pengumuman Penetapan Pemenang Nomor $ptm_number",$msg);

            }

            if(!empty($loser)){

                $vendors_not_win = $this->db->select('ptv_vendor_code')
                ->where_in('ptv_vendor_code',$loser)
                ->where(array('ptm_number'=>$ptm_number,'adm'=>'Lulus','pass'=>'Lulus','pass_price'=>'Lulus'))
                ->get('vw_prc_evaluation')->result_array();

                foreach ($vendors_not_win as $key => $vnw) {

                    $vnd_not_win_email = $this->db
                    ->select('email_address')
                    ->where("vendor_id",$vnw['ptv_vendor_code'])
                    ->get("vnd_header")
                    ->row()
                    ->email_address;

                    $msg = "Dengan hormat,
                    <br/>
                    <br/>
                    Sehubungan dengan proses pengadaan '$tender_name' nomor <strong>$ptm_number</strong>, kami sampaikan terima kasih atas proposal penawaran yang dikirimkan dan telah kami terima dengan baik.
                    <br>
                    Setelah kami lakukan evaluasi atas proposal penawaran yang masuk, dengan ini kami memberitahukan bahwa proposal penawaran, proses klarifikasi teknis dan negosiasi harga dari perusahaan Bapak/Ibu belum memenuhi kriteria kebutuhan kami saat ini.
                    <br>
                    Besar harapan kami agar Perusahaan Bapak/Ibu dapat berpartisipasi dalam pengadaan ".COMPANY_NAME." di kesempatan berikutnya.
                    <br/>
                    <br/>
                    Demikian disampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.";

                    //$email = $this->sendEmail($vnd_not_win_email,"Pengumuman Pengadaan Nomor $ptm_number",$msg);

                }

            }

        }

        $p = [
            'set' => NULL,
            'panitia_id' => NULL
        ];

        $winner_quota = (isset($winner_quota) ? $winner_quota : NULL);
        $return = $this->Procedure_m->prc_tender_comment_complete($ptm_number,$userdata['complete_name'],$last_activity,$response,$com,$attachment,$last_comment['comment_id'],$userdata['employee_id'],$tender['ptm_type_of_plan'],$ranked_index, $winner_quota, $p);        

        if($last_activity == 1900){

            $contract = $this->Procrfq_m->getCtrbyRFQ($tender['ptm_number']);

            // foreach ($contract as $key => $value) {
                
            //     $number = ($value['contract_number'] == NULL) ? "pengadaan ".$tender['ptm_number'] : $value['contract_number'];

            //     if ($tender['ptm_number'] != NULL && $value['ptm_number'] != NULL && $value['status'] != "2902") {
            //         $this->setMessage("Kontrak dengan no ".$number." harus dibatalkan terlebih dulu");
            //         $error = TRUE;
            //     }	
            // }

            // if ($tender != NULL && $tender['ptm_status'] != "1902") {
            //     $this->setMessage("Pengadaan dengan no ".$tender['ptm_number']." harus dibatalkan terlebih dulu");
            //     $error = TRUE;
            // }

            $input_pr = array('pr_status'=>$activity_terminasi);
            $input_rfq = array('ptm_status'=>$activity_terminasi);
            $anggaran = $post['remain']+$post['hps'];

            $updateanggaran = $this->Procplan_m->updateDataPerencanaanPengadaan($post['plan'], array('ppm_sisa_anggaran'=>$anggaran));

            if ($updateanggaran) {

                $planhist = [
                    'ppm_id' => $post['plan'],
                    'pph_main' => $post['remain'],
                    'pph_plus' => $post['hps'],
                    'pph_remain' => $anggaran,
                    'pph_date' => date("Y-m-d H:i:s"),
                    'pph_desc' => $activity_terminasi,
                    'pph_first' => $getNoPR['pr_number'],
                    'pph_mod' => $getNoPR['pr_number']
                ];

                $inserthist = $this->Procplan_m->insertHist($planhist);
            }

            $update_rfq = $this->Procrfq_m->updateDataRFQ($ptm_number,$input_rfq);   

            $update_com = $this->db
            ->where(array("ptc_id"=>$last_comment['comment_id']))
            ->update("prc_tender_comment",array(
                "ptc_response" => ucwords($return['response']),
                "ptc_name" => $userdata['complete_name'],
                "ptc_end_date" => date("Y-m-d H:i:s"),
                "ptc_comment" => $post['comment_inp'][0],
                "ptc_attachment" => $attachment,
                "ptc_user" => $userdata['employee_id']
            ));

            $update_pr = $this->Procpr_m->updateDataPR($getNoPR['pr_number'],$input_pr);

            if($update_pr){

                $this->db->order_by("ppc_id", "desc");
                $com = $this->db->where("pr_number", $getNoPR['pr_number'])->get("prc_pr_comment")->row_array();

                $input2['pr_number'] = $getNoPR['pr_number'];
                $input2['ppc_pos_code'] = $userdata['pos_id'];
                $input2['ppc_position'] =  $userdata['pos_name'];
                $input2['ppc_name'] =  $userdata['complete_name'];
                $input2['ppc_activity'] = $activity_terminasi;
                $input2['ppc_comment'] = $post['comment_inp'][0];
                $input2['ppc_start_date'] = date("Y-m-d H:i:s");
                if ($com['ppc_user'] == NULL) {
                    $this->db->where("ppc_id", $com['ppc_id'])->update("prc_pr_comment", array("ppc_name"=>" ", "ppc_user"=>$userdata['employee_id']));
                }

                $this->db->insert("prc_pr_comment",$input2);

            }

            $check_vol = $this->Procplan_m->getVolumeHist("",$post['plan'])->result_array();

            $item = $this->Procpr_m->getItemPR("", $getNoPR['pr_number'])->result_array();

            if (count($check_vol) > 0) {

                foreach ($item as $key2 => $value2) { 

                    $getVolumeHist = $this->Procplan_m->getVolumeHist($value2['ppi_code'],1)->row_array();

                    $dataVolume = array(
                        'ppm_id' => $post['plan'],
                        'ppv_main' => $getVolumeHist['ppv_remain'],
                        'ppv_plus' => $value2['ppi_quantity'],
                        'ppv_minus' => 0,
                        'ppv_remain' => ($getVolumeHist['ppv_main'] + $value2['ppi_quantity']),
                        'ppv_activity' => $activity_terminasi,
                        'ppv_no' => $getNoPR['pr_number'],
                        'ppv_smbd_code' => $value2['ppi_code'],
                        'ppv_unit' => $getVolumeHist['ppv_unit'],
                        'ppv_prc' => "PR",
                        'created_datetime' => date("Y-m-d H:i:s"),
                    );

                    $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
                }
            }        
        }

        if ($last_activity == 1141) {
            //GenerateSAP
            //generate PO TEMPORARY
            if($tender['is_sap'] == '1') {
                $idko = "";
                $oop = $this->db->get_where('prc_tender_item', ['ptm_number' => $ptm_number])->row_array();
                $aa = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
                    ";
                $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";

                if ($oop['tit_acc_assig'] == "Q" && $oop['tit_cat_tech'] == 0) {
                    $idko = "B";              
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
                        ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                }
                
                if ($oop['tit_acc_assig'] == "X" && $oop['tit_cat_tech'] == 5) {
                    $idko = "B";              
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
                        ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                } 

                if ($oop['tit_acc_assig'] == "P" && $oop['tit_cat_tech'] == 0) {
                    $idko = "B";              
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
                        ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                }

                if ($oop['tit_acc_assig'] == "N" && $oop['tit_cat_tech'] == 9) {
                    $idko = "J";
                    $aa = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                    $bb = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
                        ";
                } 

                if ($oop['tit_acc_assig'] == "U" && $oop['tit_cat_tech'] == 0) {
                    $idko = "A";
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
                        ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                }

                $sql = "
					select
						cch.ptm_doc_type_sap,
						vnd.code_bp,
						concat(to_char(now(), 'YYYY'), '.', to_char(now(), 'MM'), '.', to_char(now(), 'DD')) start_date,
						admi.code,
						cci.tit_lokasi_incoterm,
						cci.tit_retention,
						case 
						when cch.ctr_down_payment = 0 then null
						else cch.ctr_down_payment
						end as ctr_down_payment,
						case
						when cch.ctr_down_payment_date is not null 
						then concat(to_char(cch.ctr_down_payment_date, 'YYYY'), '.', to_char(cch.ctr_down_payment_date, 'MM'), '.', to_char(cch.ctr_down_payment_date, 'DD'))
						else null
						end as ctr_down_payment_date,
						(ROW_NUMBER () OVER (ORDER BY cci.tit_id) * 10 ) tit_item_po,
						$aa
						cci.tit_pr_number,
						cci.tit_pr_item,
						'' contract_number,
						case
						when cch.ctr_delivery_date is not null 
						then concat(to_char(cch.ctr_delivery_date, 'YYYY'), '.', to_char(cch.ctr_delivery_date, 'MM'), '.', to_char(cch.ctr_delivery_date, 'DD'))
						else null
						end as ptm_created_date,
						cci.tit_no_asset,
						cci.tit_sub_number,
						cci.tit_tax_code,
						$bb
						cch.ctr_scope,
						concat(concat(to_char(cch.ctr_start_date, 'YYYY'),'.',to_char(cch.ctr_start_date, 'MM'),'.',to_char(cch.ctr_start_date, 'DD')),' - ',concat(to_char(cch.ctr_end_date, 'YYYY'),'.',to_char(cch.ctr_end_date, 'MM'),'.',to_char(cch.ctr_end_date, 'DD'))) as rangedate
					from
						prc_tender_main cch
						left join prc_tender_item cci on cch.ptm_number = cci.ptm_number
						left join adm_incoterm admi on cci.tit_incoterm = admi.description
						left join (select ptm_number,ptv_vendor_code vendor_id from vw_prc_evaluation where ptm_number = '".$ptm_number."' order by total desc limit 1) ptw on cch.ptm_number = ptw.ptm_number
						left join vnd_header vnd on ptw.vendor_id = vnd.vendor_id
					where
						cch.ptm_number = '$ptm_number'
					";

                $data = $this->db->query($sql)->result_array();

                $newl = "\n";
                $body = "";
                foreach ($data as $k => $v) {
                    $body .= $k+1 .'|'. implode("|",$v) . $newl;

                    //insert to table po
						$po['DOC_NO'] = $k+1;
						$po['DOC_TYPE'] = $v['ptm_doc_type_sap'];
						$po['VENDOR'] = $v['code_bp'];
						$po['DOC_DATE'] = $v['ptm_doc_type_sap'];
						$po['INCOTERMS1'] = $v['ptm_doc_type_sap'];
						$po['INCOTERMS2'] = $v['ptm_doc_type_sap'];
						$po['RETENTION_PERCENTAGE'] = $v['ptm_doc_type_sap'];
						$po['DOWNPAY_PERCENT'] = $v['ptm_doc_type_sap'];
						$po['DOWNPAY_DUEDATE'] = $v['ptm_doc_type_sap'];
						$po['PO_ITEM'] = $v['ptm_doc_type_sap'];
						$po['MATERIAL'] = $v['ptm_doc_type_sap'];
						$po['QUANTITY'] = $v['ptm_doc_type_sap'];
						$po['PO_UNIT'] = $v['ptm_doc_type_sap'];
						$po['NET_PRICE'] = $v['ptm_doc_type_sap'];
						$po['PREQ_NO'] = $v['ptm_doc_type_sap'];
						$po['PREQ_ITEM'] = $v['ptm_doc_type_sap'];
						$po['VEND_MAT'] = $v['ptm_doc_type_sap'];
						$po['DELIVERY_DATE'] = $v['ptm_doc_type_sap'];
						$po['ASSET_NO'] = $v['ptm_doc_type_sap'];
						$po['SUB_NUMBER'] = $v['ptm_doc_type_sap'];
						$po['TAX_CODE'] = $v['ptm_doc_type_sap'];
						$po['SERVICE'] = $v['ptm_doc_type_sap'];
						$po['SERVICE_QTY'] = $v['ptm_doc_type_sap'];
						$po['BASE_UOM'] = $v['ptm_doc_type_sap'];
						$po['GR_PRICE'] = $v['ptm_doc_type_sap'];
						$po['RUANG_LINGKUP'] = $v['ptm_doc_type_sap'];
						$po['JANGKA_WAKTU'] = $v['ptm_doc_type_sap'];
						$po['SOURCE'] = "E";
						$po['RFQ_NO'] = $rfqId;

						$this->db->insert('prc_tender_po', $po);
                }

                $todaydate = date('Ymd');
                $time_utc=mktime(date('G'),date('i'),date('s'));
                $NowisTime=date('Gis',$time_utc);

                $hex = bin2hex(openssl_random_pseudo_bytes(16));

                $hea2 = "YMMI005".$idko."|".strtoupper($hex)."|A000||".$todaydate.$NowisTime;
                $head = 'DOC_NO|DOC_TYPE|VENDOR|DOC_DATE|INCOTERMS1|INCOTERMS2|RETENTION_PERCENTAGE|DOWNPAY_PERCENT|DOWNPAY_DUEDATE|PO_ITEM|MATERIAL|QUANTITY|PO_UNIT|NET_PRICE|PREQ_NO|PREQ_ITEM|VEND_MAT|DELIVERY_DATE|ASSET_NO|SUB_NUMBER|TAX_CODE|SERVICE|SERVICE_QTY|BASE_UOM|GR_PRICE|RUANG_LINGKUP|JANGKA_WAKTU';

                $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound';
                
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
            }

        }

        if ($return['nextactivity'] == 1902) {

            $check_vol = $this->Procplan_m->getVolumeHist("","",$ptm_number)->result_array();
            if (count($check_vol) > 0) {
                $getVolItem = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();
                foreach ($getVolItem as $key => $vol_value) {
                $getVolumeHist = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],"",$ptm_number)->row_array();

                $getLastHist = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],$perencanaan_id)->row_array();
                $this->db->select('ppv_minus');
                $this->db->where('ppv_minus !=', 0);
                $getMinusVol = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],$perencanaan_id,$ptm_number)->row_array();

                $dataVolume = array(
                    'ppm_id' => $getVolumeHist['ppm_id'],
                    'ppv_main' => $getLastHist['ppv_remain'],
                    'ppv_minus' => 0,
                    'ppv_plus' => ($getMinusVol['ppv_minus']),
                    'ppv_remain' => ($getLastHist['ppv_remain'] + $getMinusVol['ppv_minus']),
                    'ppv_activity' =>  $return['nextactivity'],
                    'ppv_no' => $ptm_number,
                    'ppv_smbd_code' => $getVolumeHist['ppv_smbd_code'],
                    'ppv_unit' => $getVolumeHist['ppv_unit'],
                    'ppv_prc' => "RFQ",
                    'created_datetime' => date("Y-m-d H:i:s"),
                );

                $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
                }
            }

        } elseif ($return['nextactivity'] == 1901) {

            $check_vol = $this->Procplan_m->getVolumeHist("","",$ptm_number)->result_array();
            if (count($check_vol) > 0) {
                $getVolItem = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

                //insert history pembuatan draft kontrak
                foreach ($getVolItem as $key => $vol_value) {
                    $getVolumeHist = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],"",$ptm_number)->row_array();
                    $getLastHist = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],$perencanaan_id)->row_array();

                    $this->db->select('ppv_minus');
                    $this->db->where('ppv_minus !=', 0);
                    $getMinusVol = $this->Procplan_m->getVolumeHist($vol_value['tit_code'],$perencanaan_id,$ptm_number)->row_array();

                    $dataVolume = array(
                    'ppm_id' => $getVolumeHist['ppm_id'],
                    'ppv_main' => $getLastHist['ppv_remain'],
                    'ppv_minus' => 0,
                    'ppv_plus' => 0,
                    'ppv_remain' => ($getLastHist['ppv_remain']),
                    'ppv_activity' =>  2010,
                    'ppv_no' => $ptm_number,
                    'ppv_smbd_code' => $getVolumeHist['ppv_smbd_code'],
                    'ppv_unit' => $getVolumeHist['ppv_unit'],
                    'ppv_prc' => 'CTR',
                    'created_datetime' => date("Y-m-d H:i:s"),
                    );

                    $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);

                }

            }

        }

        if(!empty($return['nextactivity'])){

            $update = $this->db
            ->where(array("ptm_number"=>$ptm_number))
            ->update("prc_tender_main",array(
                "ptm_status" => $return['nextactivity'],
            ));

            if($return['nextjobtitle'] == "MANAJER PENGADAAN" && empty($user_id)){
                $user_id = $tender['ptm_man_emp_id'];
            }

            $comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$user_id);

        }    

        if(!$error){

            if ($this->db->trans_status() === FALSE)
            {
                $this->setMessage("Gagal mengubah data");
                $this->db->trans_rollback();
            }
            
            else
            {
                $this->setMessage("Sukses mengubah data");
                $this->db->trans_commit();
            }
            
            $this->renderMessage("success",site_url("procurement/daftar_pekerjaan"));  

        } else {

            $this->renderMessage("error");
        }

    }
