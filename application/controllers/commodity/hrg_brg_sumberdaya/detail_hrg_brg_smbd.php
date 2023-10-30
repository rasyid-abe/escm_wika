<?php 

	$view = 'commodity/hrg_brg_sumberdaya/detail_hrg_brg_smbd_v';

 	$data = array();
	
	$data['mat_price'] = $this->Commodity_m->getMatDatSmbd($id)->row_array();

	$data['list_sourcing'] = $this->Commodity_m->getSourcing($data['mat_price']['sourcing_id'])->result_array();

	// var_dump($data['mat_hist']);
	
	$this->template($view,"Detail Harga Barang Sumberdaya",$data);