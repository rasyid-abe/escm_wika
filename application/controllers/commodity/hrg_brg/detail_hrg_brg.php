<?php 

	$view = 'commodity/hrg_brg/detail_hrg_brg_v';

 	$data = array();
	
	$data['mat_price'] = $this->Commodity_m->getMatDat($id)->row_array();

	$data['list_sourcing'] = $this->Commodity_m->getSourcing($data['mat_price']['sourcing_id'])->result_array();

	// $data['comment_list'] = $this->Comment_m->getCommodityPrice([94, 95]);

	// var_dump($data['mat_hist']);
	
	$this->template($view,"Detail Harga Barang",$data);