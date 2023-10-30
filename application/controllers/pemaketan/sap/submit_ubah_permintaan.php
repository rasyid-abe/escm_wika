<?php

$error = false;

$post = $this->input->post();


if (isset($post['pr_number'])) {

    // 287 lanjutkan approve
    // 289 simpan draft
    $status_inp = $post['status_inp'][0];

    $pr_number = $post["pr_number"];

    $last_comment = $this->db->where('pr_number', $pr_number)->order_by('ppc_id', 'desc')->limit(1)->get('prc_pr_comment')->row_array();

    $input = array();

    $input_comment = array();

    $userdata = $this->data['userdata'];

    $position = $this->Administration_m->getPosition("PIC USER");

    if (!$position) {
        $this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
    }

    //haqim
    $permintaan = $this->Procpr_m->getPR($pr_number)->row_array();
    $perencanaan_id = (isset($post['perencanaan_pengadaan_inp'])) ? $post['perencanaan_pengadaan_inp'] : (!empty($permintaan) ? $permintaan['ppm_id'] : $post['ppm_id']);
    //end

    $perencanaan = $this->Procplan_m->getPerencanaanPengadaan($perencanaan_id)->row_array();

    $prhist = $this->Procplan_m->getHist($pr_number, $perencanaan_id)->row_array();

    $lasthist = $this->Procplan_m->getHist("", $perencanaan_id)->row_array();

    $invited_vendor = (isset($this->data['selection_vendor_tender'])) ? $this->data['selection_vendor_tender'] : array();

    if ($permintaan['pr_status'] == 1000) {

        $input['pr_subject_of_work'] = (isset($post['nama_pekerjaan'])) ? $post['nama_pekerjaan'] : $perencanaan['ppm_subject_of_work'];
        $input['pr_scope_of_work'] = (isset($post['deskripsi_pekerjaan'])) ? $post['deskripsi_pekerjaan'] : $perencanaan['ppm_scope_of_work'];
        $input['pr_pagu_anggaran'] = (isset($post['total_pagu_inp'])) ? $post['total_pagu_inp'] : $perencanaan['ppm_pagu_anggaran'];
        $input['pr_sisa_anggaran'] = $perencanaan['ppm_sisa_anggaran'];

        $input['pr_type_pengadaan'] = $post['tipe_pengadaan'];
        $input['pr_mata_anggaran'] = $perencanaan['ppm_mata_anggaran'];
        $input['pr_nama_mata_anggaran'] = $perencanaan['ppm_nama_mata_anggaran'];
        $input['pr_sub_mata_anggaran'] = $perencanaan['ppm_sub_mata_anggaran'];
        $input['pr_nama_sub_mata_anggaran'] = $perencanaan['ppm_nama_sub_mata_anggaran'];
        $input['pr_currency'] = $perencanaan['ppm_currency'];
        //$input['pr_dept_id'] = $position['dept_id'];
        $input['pr_dept_name'] = $position['dept_name'];
        $input['pr_created_date'] = date("Y-m-d H:i:s");
        $input['pr_requester_name'] = $userdata['complete_name'];
        $input['pr_requester_pos_code'] = $position['pos_id'];
        $input['pr_requester_pos_name'] = $position['pos_name'];
        $input['pr_requester_id'] = $userdata['employee_id'];
        $input['pr_doc_type'] = $post['pr_doc_type'];

        $input['pr_tipe_pengadaan'] = $post['tipe_pengadaan_kew'];
        $input['pr_cat_management'] = $post['cat_management_kew'];
        $input['pr_jns_pengadaan'] = $post['jns_pengadaan_kew'];
        $input['pr_nilai_pengadaan'] = $post['nilai_pengadaan_kew'];

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

        //Menambahkan eksepsi validasi untuk pembuatan draft permintaan pengadaan
        if ($status_inp != '289') {
            if (!isset($post['item_kode'])) {
                $this->setMessage("Tidak ada item yang dipilih");
                $error = true;
            }
        }
    }

    $input_doc = array();

    $input_item = array();

    $tipe_pengadaan_header = isset($post['tipe_pengadaan']) ? $post['tipe_pengadaan'] : '';

    $input_penilaian_risiko = array();

    $n = 0;

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

                if (isset($post['kategori_resiko_jasa'][$key2])) {
                    $input_penilaian_risiko[$key2]['id_risiko'] = (isset($post['id_risiko'][$key2])) ? $post['id_risiko'][$key2] : '';
                    $input_penilaian_risiko[$key2]['category_risiko'] = (isset($post['kategori_resiko_jasa'][$key2])) ? $post['kategori_resiko_jasa'][$key2] : '';
                    $input_penilaian_risiko[$key2]['nilai_risiko'] = (isset($post['nilai_skala_resiko'][$key2])) ? $post['nilai_skala_resiko'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['bobot_risiko'] = (isset($post['bobot_jasa'][$key2])) ? $post['bobot_jasa'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['total_nilai_bobot'] = (isset($post['nilai_x_bobot'][$key2])) ? $post['nilai_x_bobot'][$key2] : 0;
                }
                if (isset($post['kategori_resiko_jasa_barang'][$key2])) {
                    $input_penilaian_risiko[$key2]['id_risiko'] = (isset($post['id_risiko_barang'][$key2])) ? $post['id_risiko_barang'][$key2] : '';
                    $input_penilaian_risiko[$key2]['category_risiko'] = (isset($post['kategori_resiko_jasa_barang'][$key2])) ? $post['kategori_resiko_jasa_barang'][$key2] : '';
                    $input_penilaian_risiko[$key2]['nilai_risiko'] = (isset($post['nilai_skala_resiko_barang'][$key2])) ? $post['nilai_skala_resiko_barang'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['bobot_risiko'] = (isset($post['bobot_jasa_barang'][$key2])) ? $post['bobot_jasa_barang'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['total_nilai_bobot'] = (isset($post['nilai_x_bobot_barang'][$key2])) ? $post['nilai_x_bobot_barang'][$key2] : 0;
                }

                if (isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])) {

                    $this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length[' . DEFAULT_MAXLENGTH . ']');
                    $this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length[' . DEFAULT_MAXLENGTH_TEXT . ']|numeric');
                    $this->form_validation->set_rules("item_satuan[$key2]", "lang:attachment #$key2", 'max_length[' . DEFAULT_MAXLENGTH . ']');
                    $this->form_validation->set_rules("item_harga_satuan[$key2]", "Harga #$key2", 'max_length[' . DEFAULT_MAXLENGTH . ']|numeric');
                    $this->form_validation->set_rules("item_subtotal[$key2]", "Subtotal #$key2", 'max_length[' . DEFAULT_MAXLENGTH . ']|numeric');

                    $input_item[$key2]['ppi_code'] = $post['item_kode'][$key2];
                    $input_item[$key2]['ppi_description'] = $post['item_deskripsi'][$key2];
                    $input_item[$key2]['ppi_quantity'] = $post['item_jumlah'][$key2];
                    $input_item[$key2]['ppi_unit'] = $post['item_satuan'][$key2];
                    $input_item[$key2]['ppi_price'] = $post['item_harga_satuan'][$key2];

                    $input_item[$key2]['ppi_ppn'] = 0;
                    $input_item[$key2]['ppi_pph'] = 0;

                    // new coloumn
                    $input_item[$key2]['ppis_pr_number'] = $post['ppis_pr_number'][$key2];
                    $input_item[$key2]['ppis_pr_item'] = $post['ppis_pr_item'][$key2];
                    $input_item[$key2]['ppis_delivery_date'] = $post['ppis_delivery_date'][$key2];
                    $input_item[$key2]['ppis_pr_type'] = $post['ppis_pr_type'][$key2];
                    $input_item[$key2]['ppis_cat_tech'] = $post['ppis_cat_tech'][$key2];
                    $input_item[$key2]['ppis_acc_assig'] = $post['ppis_acc_assig'][$key2];

                    //add the new field from client
                    $input_item[$key2]['ppi_incoterm'] = $post['incoterm'][$key2];
                    $input_item[$key2]['ppi_lokasi_incoterm'] = $post['lokasi_incoterm'][$key2];
                    $input_item[$key2]['ppi_sumber_hps'] = $post['sumber_hps'][$key2];
                    $input_item[$key2]['ppi_hps'] = $post['hps'][$key2] > 0 ?  $post['hps'][$key2] : 0;
                    $input_item[$key2]['ppi_lampiran'] = $post['doc_attachment_inp_'][$key2];
                    $input_item[$key2]['ppi_tax_code'] = $post['tax_code'][$key2];
                    $input_item[$key2]['ppi_dev_date'] = $post['ppi_dev_date'][$key2];
                    $input_item[$key2]['ppi_pdt'] = (int)$post['ppi_pdt'][$key2];
                    $input_item[$key2]['ppi_type_po'] = $post['ppi_type_po'][$key2];
                    $input_item[$key2]['ppi_po_date'] = $post['ppi_po_date'][$key2];
                    $input_item[$key2]['ppi_tender_date'] = $post['ppi_tender_date'][$key2];
                    $input_item[$key2]['ppi_status_update'] = $post['ppi_status_update'][$key2];
                    //$input_item[$key2]['ppi_temp_vol'] = $post['ppi_temp_vol'][$key2];
                    $input_item[$key2]['ppi_pr_order'] = $post['ppi_pr_order'][$key2];
                    $input_item[$key2]['ppi_update_at'] = $post['ppi_update_at'][$key2];
                    $input_item[$key2]['ppi_retention'] = $post['pr_retention'][$key2];

                    if (!isset($post['periode_pengadaan'][$key2]) or $post['periode_pengadaan'][$key2] == '') {
                        $input_item[$key2]['ppi_periode_pengadaan'] = null;
                    } else {
                        $input_item[$key2]['ppi_periode_pengadaan'] = $post['periode_pengadaan'][$key2];
                        $input_item[$key2]['ppi_spk_code'] = $perencanaan['ppm_project_id'];
                    }

                    $kode = $post['item_kode'][$key2];

                    if ($tipe_pengadaan_header == "barang") {
                        $com = $this->Commodity_m->getMatCatalog($kode)->row_array();
                    } else {
                        $com = $this->Commodity_m->getSrvCatalog($kode)->row_array();
                    }

                    if ($tipe_pengadaan_header == "asset") {
                        $input_item[$key2]['ppi_no_asset'] = $post['no_asset'][$key2];
                        $input_item[$key2]['ppi_sub_number'] = $post['sub_number'][$key2];
                    }

                    $input_item[$key2]['ppi_currency'] = "IDR";
                    $input_item[$key2]['ppi_type'] = $tipe_pengadaan_header;
                }
            }

            $n++;
        }
    }

    if ($error) {

        $this->renderMessage("error");

    } else {

        $this->db->trans_begin();        

        $act = $this->Procpr_m->updateDataPR($pr_number,$input);  

        if(count($invited_vendor) < 1){
            $this->setMessage("Tidak ada vendor yang dipilih");
            $error = true;
    
        } else {
    
            $this->db->where_in("vendor_id", $invited_vendor);
            $list_vnd = $this->Vendor_m->getVendor_v2()->result_array();
    
            $this->db->where_in("pr_number", $pr_number);
            $check_prv = $this->db->get('prc_pr_vendor')->num_rows();
    
            if($check_prv > 0) {
                $this->db->where('pr_number', $pr_number);
                $this->db->delete('prc_pr_vendor');
            }
    
            foreach ($list_vnd as $key => $value) {
    
                $inp_vendor = array(
                    "pr_number" => $pr_number,
                    "vendor_id" => $value['vendor_id'],
                );
    
                $act_v = $this->db->insert('prc_pr_vendor', $inp_vendor);
    
            }
        }

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

            if(!empty($input_item)){

                $deleted = array();
                foreach ($input_item as $key => $value) {
                    $value['pr_number'] = $pr_number;
                    $ppi_id = isset($value['ppi_id']) ? $value['ppi_id'] : $key;
                    $act = $this->Procpr_m->replaceItemPR($ppi_id, $value);
                    if($act){
                        $deleted[] = $act;
                    }
                }
                $this->Procpr_m->deleteIfNotExistItemPR($pr_number,$deleted);

            }

            foreach ($input_penilaian_risiko as $key => $value) {
                if ($value['nilai_risiko'] != 0) {
                    $value['pr_number'] = $pr_number;
                    // insert section penilaian resiko
                    $act = $this->Procpr_m->replaceNilaiRisiko($value['id_risiko'], $value);
                }
            }

            $com = $post['comment_inp'][0];

            $buyerman = (isset($post['pelaksana'])) ? $post['pelaksana'] : NULL;

            if ($permintaan['pr_status'] == 1000) { //revisi or batal PR
                $histbatal = array(
                    'ppm_id' => $perencanaan_id,
                    'pph_main' => $perencanaan['ppm_sisa_anggaran'],
                    'pph_date' => date("Y-m-d H:i:s"),
                    'pph_desc' => 1010,
                    'pph_first' => $pr_number,
                    'pph_mod' => $pr_number
                );

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
                            'ppv_activity' =>  1010,
                            'ppv_no' => $pr_number,
                            'ppv_smbd_code' => $getVolumeHist['ppv_smbd_code'],
                            'ppv_unit' => $getVolumeHist['ppv_unit'],
                            'ppv_prc' => $getVolumeHist['ppv_prc'],
                            'created_datetime' => date("Y-m-d H:i:s"),
                        );

                        $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
                    }
                }
            }
        }

        if($post['status_inp'][0] == 287) {                                    
            $perencanaan_id = $post['ppm_id'];
            $response = 287;
            $com = "Lanjutkan";

            $data_update = array(
                'pr_dept_id' => $position['dept_id'],
                'pr_dept_name' => $position['dept_name'],
                'pr_created_date' => date("Y-m-d H:i:s"),
                'pr_requester_name' => $userdata['complete_name'],
                'pr_requester_pos_code' => $position['pos_id'],
                'pr_requester_pos_name' => $position['pos_name'],
                'pr_requester_id' => $userdata['employee_id']
            );
            $this->db->where('pr_number', $pr_number);
            $update_main = $this->db->update('prc_pr_main', $data_update);
        
            // insert data komentar
            $comment = $this->Comment_m->insertProcurementPR($pr_number, 1000, $com, $response);
        
            $last_id = $this->db->insert_id();
        
            $return = $this->Procedure_m->prc_pr_comment_complete($pr_number, $userdata['complete_name'], 1000, $response, $com, "", $last_id, $perencanaan_id, $userdata['employee_id'], "", $post['pr_type_of_plan'], "", "", "");
        
            if ($return['nextactivity'] == 1010) {
                $lasthist = $this->Procplan_m->getHist("", $perencanaan_id)->row_array();
                $hist = array(
                    'ppm_id' => $perencanaan_id,
                    'pph_main' => $lasthist['pph_remain'],
                    'pph_date' => date("Y-m-d H:i:s"),
                    'pph_desc' => $return['nextactivity'],
                    'pph_first' => $pr_number,
                    'pph_mod' => $pr_number
                );
                
                // potong anggaran
                // $potong = $this->Procplan_m->updateDataPerencanaanPengadaan($perencanaan_id, array('ppm_sisa_anggaran' => $post['sisa_pagu_inp']));
                // insert history anggaran
                $plan_hist = $this->Procplan_m->insertHist($hist);
        
                $check_vol = $this->Procplan_m->getVolumeHist("", $perencanaan_id)->result_array();
                if (count($check_vol) > 0) {

                    foreach ($post['item_kode'] as $key2 => $value2) {

                        $getVolumeHist = $this->Procplan_m->getVolumeHist($post['item_kode'][$key2], $perencanaan_id)->row_array();
    
                        $dataVolume = array(
                            'ppm_id' => $perencanaan_id,
                            'ppv_main' => $getVolumeHist['ppv_main'],
                            'ppv_minus' => $post['item_jumlah'][$key2],
                            'ppv_remain' => ($getVolumeHist['ppv_main'] - $post['item_jumlah'][$key2]),
                            'ppv_activity' => 1010,
                            'ppv_no' => $pr_number,
                            'ppv_smbd_code' => $post['item_kode'][$key2],
                            'ppv_unit' => $getVolumeHist['ppv_unit'],
                            'ppv_prc' => "PR",
                            'created_datetime' => date("Y-m-d H:i:s"),
                        );
    
                        $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
                    }                    
                }
            }
        
            if (!empty($return['nextactivity'])) {
        
                $comment = $this->Comment_m->insertProcurementPR($pr_number, $return['nextactivity'], "", "", "", $return['nextposcode'], $return['nextposname']);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->setMessage("Gagal mengubah data");
            $this->db->trans_rollback();

        } else {
            $this->setMessage("Sukses mengubah data");
            $this->db->trans_commit();
        }

        $this->renderMessage("success", site_url("paket_pengadaan/paket_sap"));
    }

} else {

    $this->setMessage("Nomor PR tidak ditemukan.");
    $error = true;
}

?>
