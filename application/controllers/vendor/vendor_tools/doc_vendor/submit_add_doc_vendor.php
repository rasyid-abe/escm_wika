<?php

$post = $this->input->post();

$input = [];

$status = "Non Aktif";

if (isset($post['status_inp'])) {
  $status = 'Aktif';
}


$input  = [
  'avd_name'      => $post['nama_inp'],
  'vtm_id'        => $post['vnd_type_inp'],
  'created_date'  => date("Y-m-d H:i:s"),
  'updated_date'  => date("Y-m-d H:i:s"),
  'status'        => $status
];

$input_detail = [];

$n = 0;

foreach ($post as $key => $value) {

  if (is_array($value)) {

    foreach ($value as $key2 => $value2) {

      $input_detail[$key2]['vdd_name']      = $post['item_name'][$key2];
      // $input_detail[$key2]['vdd_type']      = $post['item_jenis'][$key2];
      $input_detail[$key2]['vdd_ref_document_pq']      = $post['ref_document_inp'][$key2] ? $post['ref_document_inp'][$key2] : null;
      $input_detail[$key2]['vdd_status']  =  1;
      $input_detail[$key2]['created_date']  =  date("Y-m-d H:i:s");
      $input_detail[$key2]['updated_date']  =  date("Y-m-d H:i:s");

    }
    $n++;
  }
}

if (empty($input_detail)) {

  $this->setMessage("Detail dokumen tidak boleh kosong");
  $this->renderMessage("error");
  
} else {

  $this->db->trans_begin();

  //ubah semua template dengan tipe vendor yang sama menjadi nonaktif supaya yang aktif hanya 1
  // if ($status == 'Aktif') {
  //    $this->db->where('vtm_id', $post['vnd_type_inp']);
  //    $this->Vendor_m->updateVndDoc("", array("status"=>"Non Aktif"));
  // }
 

  $act = $this->Vendor_m->insertVndDoc($input);

  if ($act) {

    foreach ($input_detail as $key => $value) {

      $value['avd_id'] = $act;

      $actdetail = $this->Vendor_m->insertVndDocDetail($value);
    }
  }

  if ($this->db->trans_status() === FALSE) {
    $this->setMessage("Gagal menambah data");
    $this->db->trans_rollback();
    $this->renderMessage("error");
  } else {
    $this->setMessage("Sukses menambah data");
    $this->db->trans_commit();
    $this->renderMessage("success", site_url("vendor/vendor_tools/doc_vendor"));
  }
}
