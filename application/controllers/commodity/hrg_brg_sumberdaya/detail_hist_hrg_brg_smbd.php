<?php 

	$view = 'commodity/hrg_brg/detail_hist_hrg_v';

 	$data = array();
	
	$data['mat_hist'] = $this->Commodity_m->getMatHistDat($id)->row_array();

	$data['list_sourcing'] = $this->Commodity_m->getSourcing($data['mat_hist']['sourcing_id'])->result_array();
	// var_dump($data['mat_hist']);
	
	$this->template($view,"Detail History Harga Barang",$data);