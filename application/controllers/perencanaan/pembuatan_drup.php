<?php 
 
  $view = 'perencanaan/pembuatan_drup_v';

  $position = $this->Administration_m->getPosition("PELAKSANA PENGADAAN");

  if(!$position){
    $this->noAccess("Hanya Buyer yang dapat membuat DRUP");
  }

  $data = array();

  $data['userdata'] = $this->data['userdata'];

  $data['data_matgis'] = json_encode($this->Procurement_m->get_data_matgis());  

  $this->db->distinct();
  $this->db->select('coa_id');
  $this->db->select('kode_perkiraan');
  $this->db->select('nama_perkiraan');
  $this->db->join('adm_coa_new', 'adm_coa_new.id = prc_proses_drup.coa_id');
  $drup_data = $this->db->get('prc_proses_drup');

  $this->db->select('(SELECT SUM(prc.volume * prc.harga_satuan) FROM prc_proses_drup prc) AS total', FALSE);
  $total_data = $this->db->get('prc_proses_drup');

  $coa_data = $this->db->get('adm_coa_new');
  
  $data['drup_data'] = $drup_data->result_array();
  $data['coa_data'] = $coa_data->result_array();
  $data['total_data'] = $total_data->row_array();

  $this->db->where('is_locked', '0');
	$data['adm_user'] = $this->db->get('adm_user')->result_array();

  $this->db->where('is_active', 'true');
  $this->db->order_by('curr_code', 'desc');
	$data['currency'] = $this->db->get('adm_curr')->result_array();
	
	$data['dept_name'] = $this->db->select('dept_name')->where('dept_active', '1')->get("adm_dept")->result_array();

  $this->template($view, "Pembuatan Daftar Rencana Umum Pengadaan (DRUP)", $data);
?>