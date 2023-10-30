<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procurementapi_m extends CI_Model {
	
	public function check_vnd($npwp){ //check vendor by npwp_no
		return $this->db->where("npwp_no", $npwp)->get("vnd_header")->row_array();
	}

	public function insert_project($data = array()) { //insert project wika pis
		$this->db->insert("project_info", $data);
		return $this->db->insert_id();
	}

	public function cust_code($vendor = '', $code = ''){ //insert nasabah code
		$this->db->where("vendor_id", $vendor);
		$this->db->update("vnd_header", array("customer_code"=>$code));
		return $this->db->affected_rows();
	}

	public function insert_hcis($data = array()) { //insert data karyawan hcis
		$this->db->insert("intg_hcis", $data);
		return $this->db->insert_id();
	}

	public function insert_invoice($vendor = '', $status = '') { //insert status invoice nasabah
		$this->db->where(array("vendor_id"=>$vendor, "invoice_stat"=>NULL));
		$this->db->update("ctr_invoice_header", array("invoice_stat"=>$status));
		return $this->db->affected_rows();
	}

}