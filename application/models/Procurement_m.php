<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procurement_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getKategoriDokumen($id = ""){

		if(!empty($id)){

			$this->db->where("ldc_id",$id);

		}

		$this->db->order_by("ldc_id","asc");

		return $this->db->get("prc_lkpdoc");

	}

		public function getPekerjaan($id = ""){

		$where = " WHERE A.ppc_name IS NULL AND A.ppc_end_date IS NULL ";

		$where2 = " WHERE C.ptc_name IS NULL AND C.ptc_end_date IS NULL ";

		$sql = "SELECT A.ppc_id,B.pr_number,A.ppc_name,A.ppc_position,B.pr_subject_of_work FROM prc_pr_comment A
		INNER JOIN prc_pr_main B ON B.pr_number = A.pr_number
		$where
		UNION ALL
		SELECT C.ptc_id,D.ptm_number,C.ptc_name,C.ptc_position,D.ptm_subject_of_work FROM prc_tender_comment C
		INNER JOIN prc_tender_main D ON C.ptm_number = D.ptm_number
		$where2";

		return $this->db->query($sql);

	}

	//=========K=========Berita Acara Aanwijzing
		public function getAanwijzingChat($ptmNumber = ""){

		  if(!empty($ptmNumber)){
			$this->db->like('key_ac',$ptmNumber);
		  }

		  $this->db->order_by('datetime_ac');

		  return $this->db->get('adm_chat');

		}

		public function getVendorByName($vendorName){

			$this->db->like("vendor_name",$vendorName);

			return $this->db->get('vnd_header');
		}

		public function getOnlineAanwijzingParticipant($ptmNumber = ""){

			if(!empty($ptmNumber)){
				$this->db->like('key_ac',$ptmNumber);
			}

			$this->db->select('name_ac');

			$this->db->where('message_ac','Online');

			$this->db->group_by('name_ac');

			return $this->db->get('adm_chat');

		}

		public function get_data_matgis()
		{
			$data = array();
			$this->db->where('ppm_type_of_plan', 'rkp_non_pmcs');

			return $this->db->get('vw_prc_matgis_header_detail')->result_array();
		}

		public function get_data_pmcs()
		{
			$data = array();
			$this->db->distinct();
			return $this->db->query("
					SELECT DISTINCT data.ppm_id,item.smbd_code,item.smbd_name,item.unit,project_name,item.smbd_quantity,price,up.ppm_id as id_update
					FROM vw_data_item_perencanaan_pmcs data
					LEFT JOIN vw_prc_plan_item_pmcs item ON data.ppm_id = item.ppm_id
					LEFT JOIN (SELECT ppm_id, smbd_code, spk_code, satuan, volume, harga_satuan FROM prc_update_pmcs GROUP BY ppm_id, smbd_code, spk_code, satuan, volume, harga_satuan) up ON item.ppm_id = up.ppm_id
					AND item.smbd_code = up.smbd_code
			")->result_array();
		}

		public function syncron()
		{
			$this->db->limit(1);
			$this->db->where('ppm_type_of_plan', 'rkp_non_pmcs');
			$this->db->where('ppm_is_integrated', 0);
			$res = $this->db->get('vw_prc_matgis_header_detail');

			// get max id
			$this->db->select_max('id');
	    	$max_pp = $this->db->get('prc_plan_integrasi')->row_array();

			if($res->num_rows() > 0) {
				$res = $res->row_array();
				$data_pp = array (
					'id' => $max_pp['id']+1,
					'spk_code' => $res['ppm_project_id'],
					'project_name' => 'Syncron From Non PMCS',
					'dept_code' => $res['ppm_dept_id'],
					'dept_name' => $res['ppm_dept_name'],
					'group_smbd_code' => 'A27',
					'group_smbd_name' => 'Batu Kali',
					'smbd_type' => 'Material',
					'smbd_code' => 'A27101',
					'smbd_name' => 'Batu Anstamping',
					'unit' => strtoupper($res['ppi_satuan']),
					'smbd_quantity' => $res['ppi_jumlah'],
					'periode_pengadaan' => '01/03/2021',
					'price' => $res['ppi_harga'],
					'total' => $res['ppi_total'],
					'coa_code' => '6101111',
					'coa_name' => 'BEBAN MATERIAL',
					'currency' => 'IDR',
					'user_id' => 'ET204472',
					'user_name' => 'Muhammad Barru Herman',
					'periode_locking' => '04/09/2021',
					'created_date' => date('Y-m-d h:i:s'),
					'updated_date' => date('Y-m-d h:i:s'),
					'is_matgis' => 'f'
				);

				$result = $this->db->insert('prc_plan_integrasi', $data_pp);

				$this->db->query("UPDATE prc_plan_main SET ppm_is_integrated = 1 WHERE ppm_project_id = '". $res['ppm_project_id'] ."'");

				$this->session->set_flashdata('tab', 'sync');
				if ($result) {
					$this->session->set_flashdata('status', '1');
					return redirect('procurement/perencanaan_pengadaan/perencanaan_pmcs');
				} else {
					$this->session->set_flashdata('status', '2');
					return redirect('procurement/perencanaan_pengadaan/perencanaan_pmcs');
				}

			} else {
				$this->session->set_flashdata('tab', 'sync');
				$this->session->set_flashdata('status', '3');
				return redirect('procurement/perencanaan_pengadaan/perencanaan_pmcs');
			}
		}

		public function get_curr()
		{
			$this->db->order_by('curr_code', 'asc');
			return $this->db->get('adm_curr')->result_array();
		}

		public function get_employee()
		{
			$role = $this->session->userdata(do_hash('ROLE'));

			$this->db->where('dept_id !=', null);
			$this->db->where('id', $role);

			return $this->db->get('vw_employee')->row_array();

		}

		public function get_item_matgis()
		{
			//$this->db->order_by('id', 'asc');
			$res = $this->db->get('vw_pr_item_non_matgis')->result_array();

			return $res;
			//exit;
		}

		public function get_matgis($id = null)
		{
			# code...
			if($id != null) $this->db->where('id', $id);

			$this->db->order_by('id', 'asc');
			return $this->db->get('adm_desc_matgis')->result_array();
		}

}
