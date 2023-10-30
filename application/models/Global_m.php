<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_m extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model("Administration_m");

	}
	public function insert_table($table_name,$data)
	{
		$this->db->insert($table_name,$data);
	}
	public function get_data($table,$where=null,$out=1)
	{
		$this->db->where($where);
		if($out==1){
			$hsl=$this->db->get($table)->row_array();
		}else{
			$hsl=$this->db->get($table)->result_array();
		}

		return $hsl;
	}

	public function get_contract_matgis($contract_id,$out=0)
	{
		$qry='SELECT DISTINCT a.contract_id,
		a.contract_number,
		a.status,
		a.vendor_id,
		a.vendor_name,
		p.pr_dept_id AS dept_id,
		p.pr_dept_name,
		a.ptm_number,
		a.subject_work,
		a.scope_work,
		a.contract_amount,
		COALESCE(vw_sum_contract.total_qty, (0)::numeric) AS qty_contract,
		COALESCE(vw_sum_contract.total_price, (0)::numeric) AS price_contract,
		COALESCE(vw_sum_wo.total_qty, (0)::numeric) AS qty_wo,
		COALESCE(vw_sum_wo.total_price, (0)::numeric) AS price_wo,
		(COALESCE(vw_sum_contract.total_qty, (0)::numeric) - COALESCE(vw_sum_wo.total_qty, (0)::numeric)) AS remain,
		adm_wkf_activity.awa_name
		FROM (((((((ctr_contract_header a
			JOIN ctr_contract_item b ON ((a.contract_id = b.contract_id)))
			JOIN prc_tender_item i ON ((b.tit_id = i.tit_id)))
			JOIN prc_tender_main m ON (((i.ptm_number)::text = (m.ptm_number)::text)))
			JOIN prc_pr_main p ON (((m.pr_number)::text = (p.pr_number)::text)))
			JOIN vw_sum_contract ON ((vw_sum_contract.contract_id = a.contract_id)))
			LEFT JOIN vw_sum_wo ON ((vw_sum_wo.contract_id = a.contract_id)))
			JOIN adm_wkf_activity ON ((a.status = adm_wkf_activity.awa_id)))
			WHERE ((a.status = 2901) AND (a.ctr_is_matgis = 1)
			AND a.contract_id='.$contract_id.')';

			if($out==1){
				$hsl=$this->db->query($qry)->row_array();
			}else{
				$hsl=$this->db->query($qry)->result_array();
			}
			return $hsl;
		}

		public function get_sj_matgis($wo_id,$out=0)
		{
			$qry=' SELECT
			"public".ctr_sj_header.sj_number,
			"public".ctr_sj_header.creator_employee,
			"public".ctr_sj_header.creator_pos,
			"public".ctr_sj_header.contract_id,
			"public".ctr_sj_header.vendor_id,
			"public".ctr_sj_header.currency,
			"public".ctr_sj_header.si_date,
			"public".ctr_sj_header.created_date,
			"public".ctr_sj_header.sj_notes,
			"public".ctr_sj_header.sj_id,
			"public".ctr_sj_header.wo_id,
			"public".ctr_sj_header.do_id,
			"public".ctr_sj_header.transporter_id,
			"public".ctr_sj_header.si_id,
			"public".ctr_sj_header.tgl_pembuatan_sj,
			"public".ctr_sj_header.tgl_pengiriman_sj,
			"public".ctr_sj_header.alokasi_sj,
			"public".ctr_sj_header.judul_sj,
			"public".ctr_sj_header.status,
			"public".ctr_sj_header.no_mobil,
			"public".ctr_sj_header.sj_total,
			"public".adm_wkf_activity.awa_name,
			"public".ctr_contract_header.contract_number,
			"public".ctr_do_header.do_number,
			"public".vnd_header.vendor_name AS transporter_name,
			"public".vw_sum_sj.total_qty AS qty_sj,
			"public".vw_sum_sj.total_price AS price_sj,
			"public".ctr_wo_header.wo_number,
			"public".ctr_bapb_item.bapb_item_id
			FROM
			(((((("public".ctr_sj_header
				JOIN "public".adm_wkf_activity ON (("public".ctr_sj_header.status = "public".adm_wkf_activity.awa_id)))
				LEFT JOIN "public".ctr_contract_header ON (("public".ctr_sj_header.contract_id = "public".ctr_contract_header.contract_id)))
				LEFT JOIN "public".ctr_do_header ON (("public".ctr_sj_header.do_id = "public".ctr_do_header.do_id)))
				LEFT JOIN "public".vnd_header ON (("public".ctr_sj_header.transporter_id = "public".vnd_header.vendor_id)))
				JOIN "public".vw_sum_sj ON (("public".ctr_sj_header.sj_id = "public".vw_sum_sj.sj_id)))
				JOIN "public".ctr_wo_header ON (("public".ctr_sj_header.wo_id = "public".ctr_wo_header.wo_id)))
				LEFT JOIN "public".ctr_bapb_item ON "public".ctr_bapb_item.sj_id = "public".ctr_sj_header.sj_id WHERE bapb_item_id is null AND ctr_wo_header.wo_id='.$wo_id;

				if($out==1){
					$hsl=$this->db->query($qry)->row_array();
				}else{
					$hsl=$this->db->query($qry)->result_array();
				}
				return $hsl;
			}

			public function update_table($table,$data,$id)
			{
				switch ($table) {

					case 'ctr_wo_header';
					$this->db->where('wo_id', $id);
					break;
					case 'ctr_wo_item';
					$this->db->where('wo_item_id', $id);
					break;
					case 'ctr_wo_comment';
					$this->db->where('cwo_id', $id);
					break;
					case 'ctr_wo_doc';
					$this->db->where('doc_id', $id);
					break;

					case 'ctr_si_header';
					$this->db->where('si_id', $id);
					break;
					case 'ctr_si_item';
					$this->db->where('si_item_id', $id);
					break;
					case 'ctr_si_comment';
					$this->db->where('cwo_id', $id);
					break;
					case 'ctr_si_doc';
					$this->db->where('doc_id', $id);
					break;

					case 'ctr_sppm_header';
					$this->db->where('sppm_id', $id);
					break;
					case 'ctr_sppm_item';
					$this->db->where('sppm_item_id', $id);
					break;
					case 'ctr_sppm_comment';
					$this->db->where('cwo_id', $id);
					break;
					case 'ctr_sppm_doc';
					$this->db->where('doc_id', $id);
					break;

					case 'ctr_do_header':
					$this->db->where('do_id', $id);
					break;
					case 'ctr_sj_header':
					$this->db->where('sj_id', $id);
					break;

					case 'ctr_bapb_header';
					$this->db->where('bapb_id', $id);
					break;
					case 'ctr_bapb_item';
					$this->db->where('bapb_item_id', $id);
					break;
					case 'ctr_bapb_comment';
					$this->db->where('cwo_id', $id);
					break;
					case 'ctr_bapb_doc';
					$this->db->where('doc_id', $id);
					break;

					break;
					case 'ctr_inv_header':
					$this->db->where('inv_id', $id);
					break;
					case 'ctr_inv_item';
					$this->db->where('inv_item_id', $id);
					break;
					case 'ctr_inv_comment';
					$this->db->where('cwo_id', $id);
					break;
					case 'ctr_inv_doc';
					$this->db->where('doc_id', $id);
					break;

					default:
					$this->db->where('wo_id', $id);
					break;
				}
				$this->db->update($table, $data);
				return ($this->db->affected_rows() > 0) ? true : false;
				//$this->db->last_query();die;
			}
		}
