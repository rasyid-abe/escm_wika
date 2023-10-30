<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procevaltemp_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getTemplateEvaluasi($id = ""){

		if(!empty($id)){

			$this->db->where("evt_id",$id);

		}

		return $this->db->get("prc_evaluation_template");

	}

	public function getTemplateEvaluasiDetail($id = ""){

		if(!empty($id)){

			$this->db->where("evt_id",$id);

		}

		return $this->db->get("prc_evaluation_template_detail");

	}

	public function getTemplateEvaluasiDetail2($where=array()){

		if(!empty($where)){
			$this->db->where($where);
		}

		return $this->db->get("prc_evaluation_template_detail");
	}

	public function getTemplateEvaluasiDetailDefault($where=array()){

		if(!empty($where)){
			$this->db->where($where);
		}

		return $this->db->get("prc_evaluation_template_detail_default");
	}

	public function getTemplateEvaluasiItem($id = ""){

		if(!empty($id)){
			$this->db->where("detail_evaluasi_id",$id);
		}

		return $this->db->get("prc_evaluation_petunjuk_score");

	}

	public function insertDataTemplateEvaluasi($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_evaluation_template",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function insertDataTemplateItemEvaluasi($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_evaluation_petunjuk_score",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function insertDataTemplateEvaluasiDetail($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_evaluation_template_detail",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function updateDataTemplateEvaluasi($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('evt_id',$id)->update('prc_evaluation_template',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataTemplateEvaluasiDetail($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('etd_id',$id)->update('prc_evaluation_template_detail',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataTemplateItemEvaluasi($id, $input = array()){
		if(!empty($id) && !empty($input)){
			$this->db->where('id',$id)->update('prc_evaluation_petunjuk_score',$input);
			return $this->db->affected_rows();
		}
	}

	public function replaceTemplateEvaluasiDetail($id,$input){

		if(!empty($id) && !empty($input)){

			$this->db->where(array("evt_id"=>$input['evt_id'],"etd_id"=>$id));
			$check = $this->getTemplateEvaluasiDetail()->row_array();
			if(!empty($check)){
				$last_id = $check['etd_id'];
				$this->updateDataTemplateEvaluasiDetail($last_id,$input);
			} else {
				$this->insertDataTemplateEvaluasiDetail($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}

	}

	public function deleteIfNotExistTemplateEvaluasiDetail($id,$deleted){
		$this->db->where_not_in("etd_id",$deleted)->where("evt_id",$id)->delete("prc_evaluation_template_detail");
		return $this->db->affected_rows();
	}

	public function deleteTemplateEvaluasi($id = ""){

		if (!empty($id)){
			
			$del = $this->db->where('evt_id',$id)->delete('prc_evaluation_template_detail');

			if($del){
				$this->db->where('evt_id',$id)->delete('prc_evaluation_template');
			}

			return $this->db->affected_rows();
		}
	}

	public function deleteTemplateEvaluasiDetailByParent($id = ""){

		if (!empty($id)){
			
			$this->db->where('evt_id',$id)->delete('prc_evaluation_template_detail');
			
			return $this->db->affected_rows();
		}
	}

	public function deleteTemplateEvaluasiDetail($id = ""){

		if (!empty($id)){
			
			$this->db->where('etd_id',$id)->delete('prc_evaluation_template_detail');
			
			return $this->db->affected_rows();
		}
	}

	public function deleteTemplateEvaluasiItem($id = ""){

		if (!empty($id)){
			
			$this->db->where('id',$id)->delete('prc_evaluation_petunjuk_score');
			
			return $this->db->affected_rows();
		}
	}

}