<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}


	public function getEfisiensiRekap(){
		return $this->db->get('vw_efisiensi_rekap');
	}

	public function getEfisiensiDetail(){
		return $this->db->get('vw_efisiensi_detail');
	}

	public function getDurasiRekap(){
		return $this->db->get('vw_rata_durasi_proses');
	}

	public function getDurasiDetail(){
		return $this->db->get('vw_rata_durasi_proses_detail');
	}

	public function getPriceKatalog(){
		
		return $this->db
					->select("
						a.mat_catalog_code,
						a.mat_group_code,
						a.short_description,
						a.long_description ,
						b.total_cost,
						b.updated_datetime")
					->where("is_matgis", "t")
					->join("com_mat_price_smbd b", "a.mat_catalog_code = b.mat_catalog_code", "left")
					->get("com_mat_catalog_smbd a");
	}
	
	public function getHistoryKatalog($mat_code){
		
		if (!empty($mat_code)) {

			return $this->db
				->select("mat_catalog_code, updated_datetime, total_cost")
				->where("mat_catalog_code", $mat_code)
				->order_by("updated_datetime", "desc")
				->get("com_mat_hist");
		}
	}

	public function get_rari($id=''){
		if (!empty($id)) {
			$this->db->where("ppm_dept_id", $id);
		}

		return $this->db->get("vw_rari");
	}

	public function get_coa_rari($id=''){
		if (!empty($id)) {
			$this->db->where("ptm_dept_id", $id);
		}

		return $this->db->get("vw_coa_rari");
	}

	public function getPlan($id=""){
		
		if (!empty($id)) {
			$this->db->where("ppm_dept_id", $id);			
		}

		return $this->db->get("vw_lap_plan");
	}

	public function getTender($id=""){
		
		if (!empty($id)) {
			$this->db->where("ptm_dept_id", $id);			
		}

		$this->db->where("ptm_number !=", NULL);
		return $this->db->get("vw_lap_tender");
	}

	public function getRari($id=''){
		if (!empty($id)) {
			$this->db->where("ptm_dept_id", $id);
		}

		return $this->db->get("vw_lap_rari");
	}
}