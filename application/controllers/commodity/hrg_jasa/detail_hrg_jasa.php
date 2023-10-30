<?php 

	$view = 'commodity/hrg_jasa/detail_hrg_jasa_v';

 	$data = array();
	
	$data['srv_price'] = $this->Commodity_m->getSrvDat($id)->row_array();

	$data['list_sourcing'] = $this->Commodity_m->getSourcing($data['srv_price']['sourcing_id'])->result_array();
	// var_dump($data['mat_hist']);
	
	$this->template($view,"Detail Harga Jasa",$data);