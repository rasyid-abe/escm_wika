<?php

$view = 'vendor/vendor_tools/doc_vendor/edit_doc_vendor_v';

$data = array();

// $view = 'procurement/template_evaluasi/ubah_template_evaluasi_v';

$data['id'] = $id;

$data['data'] = $this->Vendor_m->getVndDoc($id)->row_array();

$data['detail'] = $this->Vendor_m->getVndDocDetail("", $id)->result_array();

$data['vnd_type'] = $this->Vendor_m->getMasterVndType()->result_array();

$this->template($view, "Ubah Template Dokumen Vendor", $data);
