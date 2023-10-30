<?php 

	$view = 'commodity/hrg_jasa/detail_hist_hrg_jasa_v';

 	$data = array();
	
	$data['srv_hist'] = $this->Commodity_m->getSrvHistDat($id)->row_array();

	$data['list_sourcing'] = $this->Commodity_m->getSourcing($data['srv_hist']['sourcing_id'])->result_array();

	// var_dump($data['mat_hist']);
	
	$this->template($view,"Detail History Harga Jasa",$data);