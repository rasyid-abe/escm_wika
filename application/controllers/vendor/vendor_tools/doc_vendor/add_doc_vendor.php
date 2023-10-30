<?php

$view = 'vendor/vendor_tools/doc_vendor/add_doc_vendor_v';

$data = array();

$data['vnd_type'] = $this->Vendor_m->getMasterVndType()->result_array();

$this->template($view, "Pembuatan Template Dokumen Vendor", $data);
