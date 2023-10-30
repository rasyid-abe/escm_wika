<?php 

$id = $this->uri->segment(5,0);

$view = 'administration/template_vsi/kuesioner/kuesioner_v';

$data = [
		  'jumlah' => 1,
		  'id' => $id
		];

$this->template($view,"Template Kuesioner Kepuasan Vendor",$data);