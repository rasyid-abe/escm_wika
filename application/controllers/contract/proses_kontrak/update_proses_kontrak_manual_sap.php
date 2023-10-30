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

$vendor_inp = $post['vendid'];
$this->db->where('vendor_id', (int)$vendor_inp);
$getVendor = $this->db->get("vnd_header")->row_array();

$this->db->trans_begin();


// if (is_null($vendor_inp) && is_null($post['vendname'])) {
//     $this->setMessage("Vendor belum dipilih");
//
//     if(!$error){
//         $error = true;
//     }
// }

// if ($vendor_inp != NULL && $post['vendname'] != NULL) {
//     $this->setMessage("Pilih salah satu vendor");
//
//     if(!$error){
//         $error = true;
//     }
// }


// if ($vendor_inp != NULL && $post['vendname'] == NULL) {
$vendor_name = $getVendor['vendor_name'];
$vendor_id = $getVendor['vendor_id'];
// }

//contract header
$inputHeader = array(
    'ptm_number' => $ptm_number,
    'subject_work' => $post['subject_work'],
    'scope_work' => $post['scope_work_inp'],
    'vendor_id' => $vendor_id,
    'vendor_name' => $vendor_name,
    'sign_date' => date("Y-m-d H:i:s"),
    'start_date' => $post['tgl_mulai_inp'],
    'end_date' => $post['tgl_akhir_inp'],
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
    'ctr_is_manual' => 1,
    // 'contract_number' => $this->Contract_m->getUrutCtr(date('Y'), $post['spkcodeinp']),
);

echo "<pre>";
print_r($post);
echo "<br>";
print_r($inputHeader);
die;

// #####
$this->db->where('contract_id', $post['cid']);
$this->db->update("ctr_contract_header", $inputHeader);

// #####
$contract_id = $post['cid'];
// $contract_id = 123;

// tender main
$inputTender = array(
    'ptm_number' => $ptm_number,
    // 'ptm_requester_name' => $post['request_name_inp'],
    'pr_number' => $ptm_number,
    // 'ptm_requester_pos_code' => $post['pos_id_inp'],
    // 'ptm_requester_pos_name' => $post['pos_name_inp'],
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
    // 'ptm_dept_id' => $post['dept_id_inp'],
    // 'ptm_dept_name' => $post['dept_name_inp'],
    'ptm_buyer_id' => $post['user_id_inp'],
    'ptm_project_name' => $post['nama_pekerjaan_inp'],
    'ptm_packet' => $post['subject_work_inp'],
    // 'spk_code' => $post['spkcodeinp'],
);

// #####
$this->db->where('ptm_number', $post['nomor_tender']);
$this->db->update("prc_tender_main", $inputTender);

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
                $input_item[$key2]['item_po'] = $post['item_po'][$key2];
                $input_item[$key2]['pr_number_sap'] = $post['pr_number_sap'][$key2];
                $input_item[$key2]['pr_item_sap'] = $post['pr_item_sap'][$key2];
                $input_item[$key2]['pr_type_sap'] = $post['pr_type_sap'][$key2];
                $input_item[$key2]['pr_delivery_date'] = $post['tgl_akhir_inp'];

                if ($post['item_kontrak_inp'] == "BARANG") {
                    $input_item[$key2]['pr_cat_tech'] = 0;
                } elseif ($post['item_kontrak_inp'] == "JASA") {
                    $input_item[$key2]['pr_cat_tech'] = 9;
                    $input_item[$key2]['pr_retention'] = $post['pr_retention'][$key2];
                } else {
                    $input_item[$key2]['pr_acc_assig'] = "U";
                    $input_item[$key2]['sub_number'] = $post['sub_number'][$key2];
                    $input_item[$key2]['no_asset'] = $post['no_asset'][$key2];
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

if(!empty($input_item)){
    foreach ($input_item as $key => $value) {
        $value['contract_id'] = $contract_id;
        $this->Contract_m->updateItemSap($value);
    }
}

// Generate PO
$gent = $this->generate_po('', $contract_id);
if ($gent != 'success') {
    $this->setMessage("Generate PO Gagal");

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
        $this->setMessage("Sukses mengubah data");
        $this->db->trans_commit();
    }

    $this->renderMessage("success",site_url("contract/daftar_pekerjaan"));
}

else {
    $this->renderMessage("error");
}

?>
