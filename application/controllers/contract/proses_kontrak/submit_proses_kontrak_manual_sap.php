<?php

$error = false;

$post = $this->input->post();

if (!isset($post['item_kode'])) {
    $this->setMessage("Section daftar sumberdaya harus diisi");

    if(!$error){
      $error = true;
    }
}

if (isset($post['usk'])) {
    $ptm_number = $post['nomor_tender'];
} else {
    $ptm_number = $this->Procrfq_m->getUrutRFQ();

}

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
    'ctr_spe_pos' => $userdata['pos_id'],
    'ctr_doc_type' => $post['ctr_doc_type'],
    'ctr_down_payment' => $post['ctr_down_payment'] == '' ? 0 : $post['ctr_down_payment'],
    'ctr_down_payment_date' => $post['ctr_down_payment_date'] == '' ? null : $post['ctr_down_payment_date'],
    'ctr_scope' => $post['ctr_scope'],
    'ctr_delivery_date' => $post['tgl_akhir_inp'],
    'is_sap' => 1,
    'pengadaan_method' => $post['mth_pengadaan'],
    'spk_code' => $post['spkcodeinp'],
    'ctr_is_manual' => 1,
    'contract_number' => $this->Contract_m->getUrutCtr(date('Y'), $post['spkcodeinp']),
);
// #####
$this->db->insert("ctr_contract_header", $inputHeader);

// #####
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
    'ptm_status' => 1901,
    'ptm_dept_name' => $post['dept_name_inp'],
    'ptm_buyer_id' => $post['user_id_inp'],
    'ptm_project_name' => $post['nama_pekerjaan_inp'],
    'ptm_packet' => $post['subject_work_inp'],
    'spk_code' => $post['spkcodeinp'],
    'is_sap' => '1',
);

// comment
$spew = array(
    "job_title" => "PELAKSANA PENGADAAN",
    "pos_id" => $post['pos_id_inp']
);

$getdata = $this->db->select("pos_id, pos_name, employee_id")
->where($spew)
->get("user_login_rule")
->row_array();

if($getdata['pos_name'] == '') {
    $this->setMessage("Posisi anda tidak dapat memproses kontrak ini.");
    $error = true;
}

$inputComment = array(
    'ptm_number' => $ptm_number,
    'contract_id' => $contract_id,
    'ccc_response' => 'Simpan dan Lanjutkan',
    'ccc_name' => $userdata['complete_name'],
    'ccc_end_date' => date("Y-m-d H:i:s"),
    'ccc_activity' => 2010,
    'ccc_user' => $userdata['employee_id'],
    'ccc_comment' => 'Pembuatan Kontrak Manual SAP',
    'ccc_position' => $getdata['pos_name'],
    'ccc_pos_code' => $getdata['pos_id'],
    'ccc_start_date' => date("Y-m-d H:i:s"),
);

$input_item = array();
$input_item_rfq = array();
$input_doc = array();
$input_jaminan = array();
$input_milestone = array();
$input_person = array();
$input_detail_item = array();
$input_risiko = array();

$n = 0;
$path = 'uploads/contract/milestone/';
$files = $_FILES;
foreach ($post as $key => $value) {

    if(is_array($value)){

        foreach ($value as $key2 => $value2) {

            if(isset($post['item_kode'][$key2])){
                $input_item[$key2]['item_code'] = trim($post['item_kode'][$key2]);
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

                if (isset($post['usk'])) {
                    if (count($_FILES) > 0) {
                        $this->load->library('upload');
                        $_FILES['myfile[]']['name']= $files['myfile']['name'][$key2];
                        $_FILES['myfile[]']['type']= $files['myfile']['type'][$key2];
                        $_FILES['myfile[]']['tmp_name']= $files['myfile']['tmp_name'][$key2];
                        $_FILES['myfile[]']['error']= $files['myfile']['error'][$key2];
                        $_FILES['myfile[]']['size']= $files['myfile']['size'][$key2];

                        $this->upload->initialize($this->set_upload_options($path));
                        if ($this->upload->do_upload('myfile[]')) {
                            $file_data 	= $this->upload->data();
                            $input_item[$key2]['lampiran'] = $file_data['file_name'];
                        }
                    }
                } else {
                    $input_item[$key2]['lampiran'] = $post['doc_attachment_inp_'][$key2];
                }

                $input_item[$key2]['tax_code'] = $post['tax_code'][$key2];
                $input_item[$key2]['item_po'] = (int)$post['item_po'][$key2];
                $input_item[$key2]['pr_number_sap'] = $post['pr_number_sap'][$key2];
                $input_item[$key2]['pr_item_sap'] = $post['pr_item_sap'][$key2];
                $input_item[$key2]['pr_type_sap'] = $post['pr_type_sap'][$key2];
                $input_item[$key2]['pr_delivery_date'] = $post['tgl_akhir_inp'];

                if(isset($post['pr_delivery_date']))
                {
                    $input_item[$key2]['pr_delivery_date'] = $post['pr_delivery_date'][$key2];

                }

                if ($post['item_kontrak_inp'] == "BARANG") {
                    $input_item[$key2]['pr_acc_assig'] = "Q";
                    $input_item[$key2]['pr_cat_tech'] = 0;
                } elseif ($post['item_kontrak_inp'] == "JASA") {
                    $input_item[$key2]['pr_cat_tech'] = 9;
                    $input_item[$key2]['pr_acc_assig'] = "N"; // or P
                    $input_item[$key2]['pr_retention'] = (int)$post['pr_retention'][$key2];
                } else {
                    $input_item[$key2]['pr_acc_assig'] = "U";
                    $input_item[$key2]['sub_number'] = (int)$post['sub_number'][$key2];
                    $input_item[$key2]['no_asset'] = (int)$post['no_asset'][$key2];
                }

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
        }

        $n++;

    }

}

$ppmidd = $post['ppmid'] != '' ? $post['ppmid'] : $post['ppm_id'];

#### SUBMIT AND GENERATE PO
if (!$error) {
    if ($vendor_inp == NULL && $post['vendor_name_inp'] != NULL) {
        $this->db->insert("vnd_header", $inputVendor);
    }
    $contract_id = $this->db->insert_id();
    $inputComment['contract_id'] = $contract_id;
    $this->db->insert("prc_tender_main", $inputTender);
    $insert_first_comment = $this->db->insert("ctr_contract_comment", $inputComment);

    $getdataNext = $this->Procedure2_m->getNextState(
    "hap_pos_code",
    "hap_pos_name",
    "vw_prc_hierarchy_approval_10",
    "hap_pos_code = (select distinct hap_pos_parent
    from vw_prc_hierarchy_approval_10 where hap_pos_code = ".$getdata['pos_id']." AND hap_pos_parent IS NOT NULL)");

    if($insert_first_comment){
        $comment = $this->Comment_m->insertContract($ptm_number,"2027","","","",$getdataNext['nextPosCode'],$getdataNext['nextPosName'],$contract_id,NULL);

        $check_vol = $this->Procplan_m->getVolumeHist("", $ppmidd)->result_array();
        if (count($check_vol) > 0) {

            foreach ($post['item_kode'] as $key2 => $value2) {

                if (!empty($ppm_id)){
                    $this->db->where('ppm_id', $ppmidd);
                }
                
                $this->db->where('ppv_smbd_code', $post['item_kode'][$key2]);
                $this->db->limit(1);
                $this->db->order_by('ppv_id', 'desc');
                $getVolumeHist = $this->db->get("prc_plan_volume")->row_array();

                $dataVolume = array(
                    'ppm_id' => $ppmidd,
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
}

if(!$error){
    if(isset($post['nomor_tender'])){
        $this->db->where('no_rfq', $post['nomor_tender']);
        if ($this->db->update("uskep_online", ['is_draft' => 0])) {
            $error = true;
        }
    }

    $gent = $this->generate_po('', $contract_id);

    if ($gent != 'success') {
        $this->setMessage("Generate PO Gagal");

        if(!$error){
            $error = true;
        }
    }

    if ($this->db->trans_status() === FALSE)  {
        $this->setMessage("Gagal mengubah data");
        $this->db->trans_rollback();
    }
    else  {
        $this->setMessage("Sukses mengubah data");
        $this->db->trans_commit();
    }

    $this->renderMessage("success",site_url("contract/monitor/monitor_kontrak"));
} else {
    $this->renderMessage("error");
}

?>
