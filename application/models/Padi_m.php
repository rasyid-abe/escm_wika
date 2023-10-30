<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Padi_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function get_daftar_transaksi()
	{
		return $this->db->get("vw_padi_transaksi");;
	}

	public function get_daftar_umkm()
	{
		return $this->db->get("vw_padi_umkm");;
	}

}
