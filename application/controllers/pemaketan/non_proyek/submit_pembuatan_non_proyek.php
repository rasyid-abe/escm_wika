<?php

$post = $this->input->post();
$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if (!$position) {
    $this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

$this->form_validation->set_rules("perencanaan_pengadaan_inp", "Nomor Perencanaan Pengadaan", 'required|max_length[' . DEFAULT_MAXLENGTH . ']');

$perencanaan_id = $post['perencanaan_pengadaan_inp'];
$perencanaan = $this->Procplan_m->getPerencanaanPengadaan($perencanaan_id)->row_array();
$tipe_pengadaan_header = $post['tipe_pengadaan'];

$input['pr_type_pengadaan'] = $post['tipe_pengadaan'];
$input['pr_metode_pengadaan'] = $post['metode_pengadaan'];
$input['pr_jadwal_pengadaan_awal'] = $post['tgl_mulai_inp'];
$input['pr_jadwal_pengadaan_akhir'] = $post['tgl_akhir_inp'];
$input['pr_subject_of_work'] = (isset($post['nama_pekerjaan'])) ? $post['nama_pekerjaan'] : $perencanaan['ppm_subject_of_work'];
$input['pr_scope_of_work'] = (isset($post['deskripsi_pekerjaan'])) ? $post['deskripsi_pekerjaan'] : $perencanaan['ppm_scope_of_work'];
$input['pr_mata_anggaran'] = $perencanaan['ppm_mata_anggaran'];
$input['pr_nama_mata_anggaran'] = $perencanaan['ppm_nama_mata_anggaran'];
$input['pr_sub_mata_anggaran'] = $perencanaan['ppm_sub_mata_anggaran'];
$input['pr_nama_sub_mata_anggaran'] = $perencanaan['ppm_nama_sub_mata_anggaran'];
$input['pr_currency'] = $perencanaan['ppm_currency'];
$input['pr_sisa_anggaran'] = $perencanaan['ppm_sisa_anggaran'];
$input['pr_dept_id'] = $position['dept_id'];
$input['pr_dept_name'] = $position['dept_name'];
$input['pr_created_date'] = date("Y-m-d H:i:s");
$input['pr_requester_name'] = $userdata['complete_name'];
$input['pr_requester_pos_code'] = $position['pos_id'];
$input['pr_requester_pos_name'] = $position['pos_name'];
$input['pr_requester_id'] = $userdata['employee_id'];
$input['pr_project_name'] = $perencanaan['ppm_project_name']; //y
$input['pr_type_of_plan'] = 'rkap';
$input['pr_spk_code'] = $perencanaan['ppm_project_id']; //y
$input['pr_packet'] = $post['nama_paket']; //y
if ($tipe_pengadaan_header == 'jasa') {
    $input['prc_risiko_main'] = $post['resiko_barang_inp'];
} else {
    $input['prc_risiko_main'] = $post['resiko_barang_barang_inp'];
}

if (empty($post['joinpr'])) {
    $joinpr = null;
} else {
    $joinpr = $post['joinpr'];
}
$input['isjoin'] = $joinpr;

//start code hlmifzi
if (empty($post['swakelola_inp'])) {
    $swakelola_inp = null;
} else {
    $swakelola_inp = $post['swakelola_inp'];
}
$input['isSwakelola'] = $swakelola_inp;
//end code
$kebutuhan_id = (isset($post['lokasi_kebutuhan_inp'])) ? $post['lokasi_kebutuhan_inp'] : "";

if (!empty($kebutuhan_id)) {
    $kebutuhan = $this->Administration_m->getDistrict($kebutuhan_id)->row_array();
    $input['pr_district'] = $kebutuhan['district_name'];
    $input['pr_district_id'] = $kebutuhan_id;
}

$pengiriman_id = (isset($post['lokasi_pengiriman_inp'])) ? $post['lokasi_pengiriman_inp'] : "";
if (!empty($pengiriman_id)) {
    $pengiriman = $this->Administration_m->get_divisi_departemen($pengiriman_id)->row_array();
    $input['pr_delivery_point_id'] = $pengiriman_id;
    $type = (!empty($pengiriman['dept_type'])) ? "Divisi" : "Divisi";
    $input['pr_delivery_point'] = $type . " - " . $pengiriman['dept_name'];
}

$jenis_kontrak_inp = (isset($post['jenis_kontrak_inp'])) ? $post['jenis_kontrak_inp'] : "";
$input['pr_contract_type'] = $jenis_kontrak_inp;
$input['ppm_id'] = $perencanaan_id;
$input['pr_number'] = $this->Procpr_m->getUrutPR();

$input_doc = array();

$input_item = array();

$input_penilaian_risiko = array();

$input_risiko = array();

$input_risiko_detial = array();

$input_opportunity = array();

$n = 0;

foreach ($post as $key => $value) {

    if (is_array($value)) {

        foreach ($value as $key2 => $value2) {

            if (isset($post['doc_category_inp_tbl_cr'][$key2])) {
                $input_doc[$key2]['ppd_category'] = (isset($post['doc_category_inp_tbl_cr'][$key2])) ? $post['doc_category_inp_tbl_cr'][$key2] : "";
                $input_doc[$key2]['ppd_description'] = (isset($post['doc_desc_inp_tbl_cr'][$key2])) ? $post['doc_desc_inp_tbl_cr'][$key2] : "";
                $input_doc[$key2]['ppd_file_name'] = (isset($post['doc_attachment_inp_tbl_cr'][$key2])) ? $post['doc_attachment_inp_tbl_cr'][$key2] : "";
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
                $input_opportunity[$key2]['date_created'] = date('Y-m-d h:i:s');
                $input_opportunity[$key2]['created_by'] = $userdata['user_name'];
            }

            if ($tipe_pengadaan_header == 'jasa') {
                if (isset($post['kategori_resiko_jasa'][$key2])) {
                    $input_penilaian_risiko[$key2]['id_risiko'] = (isset($post['id_risiko'][$key2])) ? $post['id_risiko'][$key2] : '';
                    $input_penilaian_risiko[$key2]['category_risiko'] = (isset($post['kategori_resiko_jasa'][$key2])) ? $post['kategori_resiko_jasa'][$key2] : '';
                    $input_penilaian_risiko[$key2]['nilai_risiko'] = (isset($post['nilai_skala_resiko'][$key2])) ? $post['nilai_skala_resiko'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['bobot_risiko'] = (isset($post['bobot_jasa'][$key2])) ? $post['bobot_jasa'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['total_nilai_bobot'] = (isset($post['nilai_x_bobot'][$key2])) ? $post['nilai_x_bobot'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['lampiran_risiko'] = (isset($post['doc_attachment_inp_drup_jasa_' . $key2])) ? $post['doc_attachment_inp_drup_jasa_' . $key2] : '';
                }
            } else {
                if (isset($post['kategori_resiko_jasa_barang'][$key2])) {
                    $input_penilaian_risiko[$key2]['id_risiko'] = (isset($post['id_risiko_barang'][$key2])) ? $post['id_risiko_barang'][$key2] : '';
                    $input_penilaian_risiko[$key2]['category_risiko'] = (isset($post['kategori_resiko_jasa_barang'][$key2])) ? $post['kategori_resiko_jasa_barang'][$key2] : '';
                    $input_penilaian_risiko[$key2]['nilai_risiko'] = (isset($post['nilai_skala_resiko_barang'][$key2])) ? $post['nilai_skala_resiko_barang'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['bobot_risiko'] = (isset($post['bobot_jasa_barang'][$key2])) ? $post['bobot_jasa_barang'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['total_nilai_bobot'] = (isset($post['nilai_x_bobot_barang'][$key2])) ? $post['nilai_x_bobot_barang'][$key2] : 0;
                    $input_penilaian_risiko[$key2]['lampiran_risiko'] = (isset($post['doc_attachment_inp_drup_barang_' . $key2])) ? $post['doc_attachment_inp_drup_barang_' . $key2] : '';
                }
            }

            // Pengusul	Area	Opportunity	Benefit	Nilai Benefit	Probabilitas	RTL	Biaya	Hambatan
            if (
                isset($post['pengusul'][$key2]) &&
                isset($post['area'][$key2]) &&
                isset($post['opportunity'][$key2]) &&
                isset($post['benefit'][$key2]) &&
                isset($post['nilai_benefit'][$key2]) &&
                isset($post['probabilitas'][$key2]) &&
                isset($post['rtl'][$key2]) &&
                isset($post['biaya'][$key2]) &&
                isset($post['hambatan'][$key2])
            ) {
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
            } else {
                $error = true;
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
                $input_item[$key2]['ppis_pr_number'] = $post['ppis_pr_number'][$key2];
                $input_item[$key2]['ppis_pr_item'] = $post['pr_item'][$key2];
                $input_item[$key2]['ppis_delivery_date'] = $post['delivery_date'][$key2];
                $input_item[$key2]['ppis_pr_type'] = $post['pr_type_sap'][$key2];
                $input_item[$key2]['ppis_cat_tech'] = $post['ppis_cat_tech'][$key2];
                $input_item[$key2]['ppis_acc_assig'] = $post['ppis_acc_assig'][$key2];

                //add the new field from client
                $input_item[$key2]['ppi_incoterm'] = $post['incoterm'][$key2];
                $input_item[$key2]['ppi_lokasi_incoterm'] = $post['lokasi_incoterm'][$key2];
                $input_item[$key2]['ppi_sumber_hps'] = $post['sumber_hps'][$key2];
                $input_item[$key2]['ppi_hps'] = $post['hps'][$key2];
                $input_item[$key2]['ppi_lampiran'] = $post['doc_attachment_inp_smbd_pmcs'][$key2];
                $input_item[$key2]['ppi_ppn'] = $post['item_ppn_satuan'][$key2];

                if ($post['item_pph_satuan'][$key2] == '') {
                    $input_item[$key2]['ppi_pph'] = 0;
                } else {
                    $input_item[$key2]['ppi_pph'] = $post['item_pph_satuan'][$key2];
                }

                if (!isset($post['periode_pengadaan'][$key2]) or $post['periode_pengadaan'][$key2] == '') {
                    $input_item[$key2]['ppi_periode_pengadaan'] = null;
                } else {
                    $input_item[$key2]['ppi_periode_pengadaan'] = $post['periode_pengadaan'][$key2];
                    $input_item[$key2]['ppi_spk_code'] = $perencanaan['ppm_project_id'];
                }

                $tipe = $post['item_tipe'][$key2];
                $kode = $post['item_kode'][$key2];

                if ($tipe == "BARANG") {
                    $com = $this->Commodity_m->getMatCatalog($kode)->row_array();
                } else {
                    $com = $this->Commodity_m->getSrvCatalog($kode)->row_array();
                }

                //$input_item[$n]['ppi_currency']=$com['currency'];
                $input_item[$key2]['ppi_currency'] = "IDR";
                $input_item[$key2]['ppi_type'] = $tipe;
            }

            if (isset($post['rsd_item_tbl'][$key2])) {
                $input_risiko_detial[$key2]['rsd_item'] = $post['rsd_item_tbl'][$key2];
                $input_risiko_detial[$key2]['rsd_keterangan'] = $post['rsd_keterangan_tbl'][$key2];
                $input_risiko_detial[$key2]['rsd_volume'] = $post['rsd_volume_tbl'][$key2];
                $input_risiko_detial[$key2]['rsd_satuan'] = $post['rsd_satuan_tbl'][$key2];
                $input_risiko_detial[$key2]['rsd_harga_satuan'] = $post['rsd_harga_satuan_tbl'][$key2];
                $input_risiko_detial[$key2]['rsd_subtotal'] = $post['rsd_subtotal_tbl'][$key2];
            }
        }

        $n++;
    }
}


$error = false;
if ($post['status_inp'][0] == 287) {
}

if ($input['pr_sisa_anggaran'] < 0) {
    $this->setMessage("Sisa anggaran tidak boleh kurang dari 0");
    $error = true;
}

if ($post['status_inp'][0] != '289') { //Menambahkan eksepsi validasi untuk pembuatan draft permintaan pengadaan
    if (!isset($post['item_kode'])) {
        $this->setMessage("Tidak ada item yang dipilih");
        if (!$error) {
            $error = true;
        }
    }
}

if ($this->form_validation->run() == FALSE || $error) {

    //$this->pembuatan_permintaan_pengadaan();

    $this->renderMessage("error");
} else {

    $this->db->trans_begin();
    //data procurement header
    $act = $this->Procpr_m->insertDataPR($input);


    $complete_comment = 1;

    if ($act) {

        $pr_number = $input['pr_number'];

        foreach ($input_doc as $key => $value) {
            if (!empty($value['ppd_category'])) {
                $value['pr_number'] = $pr_number;

                // insert section lampiran document
                $act = $this->Procpr_m->insertDokumenPR($value);
            }
        }

        foreach ($input_item as $key => $value) {
            if (!empty($value['ppi_quantity']) && !empty($value['ppi_price'])) {
                $value['pr_number'] = $pr_number;

                // insert section item procurement
                $act = $this->Procpr_m->insertItemPR($value);
            }
        }

        foreach ($input_penilaian_risiko as $key => $value) {
            if ($value['nilai_risiko'] != 0) {
                $value['pr_number'] = $pr_number;
                // insert section penilaian resiko
                $act = $this->Procpr_m->insertNilaiRisiko($value);
            }
        }

        foreach ($input_opportunity as $key => $value) {
            $value['pr_number'] = $pr_number;

            // insert section opportunity
            $act = $this->Procpr_m->insertOpportunity($value);
        }

        foreach ($input_risiko as $key => $value) {
            $value['pr_number'] = $pr_number;

            // insert section risiko
            $act = $this->Procpr_m->insertRisiko($value);
        }

        foreach ($input_risiko_detial as $key => $value) {
            $value['pr_number'] = $pr_number;

            // insert section risiko detail
            $act = $this->Procpr_m->insertRisikoDetail($value);
        }

        $response = $post['status_inp'][0];

        $com = $post['comment_inp'][0];

        $attachment = '';

        // insert data komentar
        $comment = $this->Comment_m->insertProcurementPR($pr_number, 1000, $com, $response);

        $last_id = $this->db->insert_id();

        $return = $this->Procedure_m->prc_pr_comment_complete($pr_number, $userdata['complete_name'], 1000, $response, $com, $attachment, $last_id, $perencanaan_id, $userdata['employee_id'], $swakelola_inp, $perencanaan['ppm_type_of_plan'], "", "", "");

        if ($return['nextactivity'] == 1010) {
            $lasthist = $this->Procplan_m->getHist("", $perencanaan_id)->row_array();
            $hist = array(
                'ppm_id' => $perencanaan_id,
                'pph_main' => $lasthist['pph_remain'],
                'pph_date' => date("Y-m-d H:i:s"),
                'pph_desc' => $return['nextactivity'],
                'pph_first' => $input['pr_number'],
                'pph_mod' => $input['pr_number']
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
                        'ppv_no' => $input['pr_number'],
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
        $this->setMessage("Gagal menambah data");
        $this->db->trans_rollback();
    } else {
        $this->setMessage("Sukses menambah data");
        $this->db->trans_commit();
    }

    $this->renderMessage("success", site_url("paket_pengadaan/paket_sap"));
}
