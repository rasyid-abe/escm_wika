<?php

$post = $this->input->post();

if(!empty($post)){

	$input = array();

	$ptm_number = $this->session->userdata("rfq_id");

	if(isset($post['eauction_vendor'])){

		$this->db
		->where("ppm_id",$ptm_number)
		->update("prc_eauction_history",['selected'=>0]);

		foreach ($post['eauction_vendor'] as $key => $value) {

			$this->db->where("ppm_id",$ptm_number)
			->where("id",$value)
			->where("vendor_id",$key)
			->update("prc_eauction_history",['selected'=>1]);

			$main_quo = $this->db
			->where("ptm_number",$ptm_number)
			->where("ptv_vendor_code",$key)
			->get("prc_tender_quo_main")
			->row_array();

			$item_eauction = $this->db
			->where("history_id",$value)
			->where("vendor_id",$key)
			->where("ppm_id",$ptm_number)
			->get("prc_eauction_history_item")
			->result_array();

			foreach ($item_eauction as $key => $value) {
				$this->db
				->where("tit_id",$value['tit_id'])
				->where("pqm_id",$main_quo['pqm_id'])
				->update("prc_tender_quo_item",["pqi_quantity"=>$value['qty_bid'],"pqi_price"=>$value['jumlah_bid']]);
			}

		}

	}

	$return = ['refresh'=>1];

	$this->output
	->set_content_type('application/json')
	->set_output(json_encode($return));

}