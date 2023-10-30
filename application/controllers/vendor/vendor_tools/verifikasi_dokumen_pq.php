<?php 

$view = "vendor/vendor_tools/verifikasi_dokumen_pq_v";

$data = array();

$data['header'] = $this->Vendor_m->getDaftarPekerjaanVerifikasiDocPQ($id)->row_array();
$data['files'] = $this->Vendor_m->getDocPqDetail($id)->result_array();
$data['workflow_list'] = array(2 => "Setuju", -1 => "Revisi");
$comment_list = $this->Comment_m->getDocPQ($id)->result_array();
$data['comment_list'][0] = $comment_list;


$this->template($view,"Verifikasi Dokumen PQ",$data);