<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	public function insert_table($table_name,$data)
	{
		$this->db->insert($table_name,$data);
	}
	public function get_data($table,$where=null,$out=1)
	{
		if($where!==null){
			$this->db->where($where);
		}
		if($out==1){
				$hsl=$this->db->get($table)->row_array();
		}else{
			$hsl=$this->db->get($table)->result_array();
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
			$this->db->where('bapb_id', $id);
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
			default:
			$this->db->where('wo_id', $id);
			break;
		}
		$this->db->update($table, $data);
		return ($this->db->affected_rows() > 0) ? true : false;
		//$this->db->last_query();die;
	}
}
