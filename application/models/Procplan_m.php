<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procplan_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getPerencanaanPengadaan($id = ""){

		if(!empty($id)){

			$this->db->where("ppm_id",$id);

		}

		return $this->db->get("vw_prc_plan_main_v2");

	}

	public function getHistoryCar($id = ""){

		if(!empty($id)){

			$this->db->where("a.phc_id",$id);

		}

		$this->db->select('a.phc_id,a.phc_name,a.phc_status,a.dept_id,c.dept_name,a.phc_type,a.phc_user_update, a.phc_created_date,COALESCE(a.phc_updated_date,a.phc_created_date) update_date, d.durasi');
		$this->db->join('vw_rata_durasi_history_car d', 'd.phc_id = a.phc_id');
		$this->db->join('adm_dept c', 'c.dept_id = a.dept_id');
		return $this->db->get("prc_history_car_main a");

	}

	public function getItemPMCS($id = ""){

		if(!empty($id)){

			$this->db->where("ppm_id",$id);
			$this->db->order_by('smbd_code', 'ASC');

		}

		return $this->db->get("vw_prc_plan_item_pmcs");

	}

	public function getPeriodePengadaanPMCS($id = "", $val = ""){

		if(!empty($id)){

			$this->db->where("spk_code",$id);
			$this->db->where("smbd_code",$val);

		}

		return $this->db->get("vw_prc_plan_periode_pmcs");

	}

	public function getItemPerencanaanPMCS($id = ""){

		if(!empty($id)){

			$this->db->where("ppm_id",$id);

		}

		return $this->db->get("vw_prc_plan_item");

	}

	public function getPolaBelanja($id){
		if(!empty($id)){

			$this->db->where("ppm_id",$id);

		}
		$this->db->where('ppm_project_id is not null');
		return $this->db->get('vw_prc_plan_main');

	}

	public function getListPolaBelanja(){

		$this->db->where('ppm_project_id is not null');
		return $this->db->get('vw_prc_plan_main');

	}

	public function getProjectCost($id){
		if(!empty($id)){

			$this->db->where("d.ppm_id",$id);

		}
		$this->db->select('a.spk_code,a.coa_code,a.coa_name');
		$this->db->join('prc_plan_main d', 'd.ppm_project_id = a.spk_code');
		return $this->db->get('prc_plan_project_cost a');

	}

	public function getDataCarMain($car_id = ""){

		if(!empty($car_id)){

			$this->db->where("phc_id",$car_id);

		}

		$this->db->order_by("phc_id","desc");

		return $this->db->get("prc_history_car_main");

	}

	public function insertDataHistoryCar($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_history_car_main",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertDataPerencanaanPengadaan($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_plan_main",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateHistoryCar($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('phc_id',$id)->update('prc_history_car_main',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataPerencanaanPengadaan($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$check = $this->db->where("ppm_id",$id)->get("prc_plan_main")->row_array();

			if(!empty($check) && empty($check['ppm_planner_pos_code'])){

				$nama = $check['ppm_planner'];

				$find_candidate = $this->db
				->select("b.employee_id,b.pos_id,b.district_id,b.dept_id,b.dept_name,b.district_name,b.pos_name,b.pos_name,b.user_name")
				->join('user_login_rule b', 'TRIM(b.complete_name)= TRIM(a.comment_name) AND b.pos_id=a.pos_id')
				->where("b.job_title","PIC USER")
				->where("a.ppm_id",$ppm_id)
				->limit(1)
				->get("prc_plan_comment a")
				->row_array();

				if(!empty($find_candidate)){

					$input['ppm_planner_pos_code'] = $find_candidate['pos_id'];

					$input['ppm_planner_pos_name'] = $find_candidate['pos_name'];

					if(empty($check['ppm_dept_name'])){

						$input['ppm_dept_name'] = $find_candidate['dept_name'];

					}

					if(empty($check['ppm_dept_id'])){

						$input['ppm_dept_id'] = $find_candidate['dept_id'];

					}

					if(empty($check['ppm_district_id'])){

						$input['ppm_district_id'] = $find_candidate['district_id'];

					}

					if(empty($check['ppm_district_name'])){

						$input['ppm_district_name'] = $find_candidate['district_name'];

					}

				}

			}

			$this->db->where('ppm_id',$id)->update('prc_plan_main',$input);

			return $this->db->affected_rows();

		}

	}

	public function getItem($code = "",$plan = ""){

		if(!empty($code)){

			$this->db->where("ppi_id",$code);

		}

		if(!empty($plan)){

			$this->db->where("ppm_id",$plan);

		}

		$this->db->order_by("ppi_id","asc");

		return $this->db->get("prc_plan_item");

	}

	public function getDokumenPerencanaan($code = "",$plan = ""){

		if(!empty($code)){

			$this->db->where("ppd_id",$code);

		}

		if(!empty($plan)){

			$this->db->where("ppm_id",$plan);

		}

		$this->db->order_by("ppd_id","asc");

		return $this->db->get("prc_plan_doc");

	}

	public function getDokumenHistoryCar($code = "",$plan = ""){

		if(!empty($code)){

			$this->db->where("phd_id",$code);

		}

		if(!empty($plan)){

			$this->db->where("phc_id",$plan);

		}

		$this->db->order_by("phd_id","asc");

		return $this->db->get("prc_history_car_doc");

	}

	public function insertDokumenHistoryCar($input){

		if (!empty($input)){

			$this->db->insert("prc_history_car_doc",$input);

			return $this->db->affected_rows();

		}

	}

	//hlmifzi
	public function insertProgressHistoryCar($code = "",$comment = "",$dateopen = ""){

		$userdata = $this->Administration_m->getLogin();

		$input['phc_id'] = $code;
		$input['hcp_activity'] = $comment;
		$input['hcp_start_date'] = $dateopen;
		$input['hcp_end_date'] = $dateopen;
		$input['hcp_user_update'] = $userdata['complete_name'];

		$this->db->insert("prc_history_car_progress",$input);

		return $this->db->affected_rows();

	}

	public function getProgressHistoryCar($code = ""){

		$this->db->select("
		hcp_activity,
		hcp_start_date,
		hcp_end_date,
		hcp_user_update");

		if(!empty($code)){

			$this->db->where("phc_id",$code);

		}

		$this->db->order_by("hcp_id","desc");

		return $this->db->get("prc_history_car_progress");

	}

	public function getMaxCarNo()
    {
        $year = date("Y");
        $bulan = date("m");
		$this->db->where("phc_id LIKE 'CAR.%'");
		$text = $this->db->select("max(phc_id) as no");
        $data = $this->db->get("prc_history_car_main");
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $t) {
                $no = $t->no;
                $tmp = ((int)substr($no, -5)) + 1;
                $hasil = 'CAR.'.$year.''.$bulan.'.' . sprintf("%05s", $tmp);
            }
        } else {
            $hasil = 'CAR.'.$year.''.$bulan.'.00001';
        }
        return $hasil;
	}

	public function getUrutWOMatgis($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(wo_id) as urut");

		$get = $this->db->get("ctr_wo_header")->row()->urut;

		return "WO.".date("Ym").".".urut_id($get+1,5);

	}

	public function insertDokumenPerencanaan($input){

		if (!empty($input)){

			$this->db->insert("prc_plan_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDokumenPerencanaan($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ppd_id',$id)->update('prc_plan_doc',$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteDokumenPerencanaan($id){

		if(!empty($id)){

			$this->db->where('ppm_id',$id)->delete('prc_plan_doc');

			return $this->db->affected_rows();

		}

	}

	public function deleteDokumenHistoryCar($id){

		if(!empty($id)){

			$this->db->where('phc_id',$id)->delete('prc_history_car_doc');

			return $this->db->affected_rows();

		}

	}

	public function deleteItem($id){

		if(!empty($id)){

			$this->db->where('ppm_id',$id)->delete('prc_plan_item');

			return $this->db->affected_rows();

		}

	}

	public function updateItem($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ppi_id',$id)->update('prc_plan_item',$input);

			return $this->db->affected_rows();

		}

	}

	public function insertItem($input){

		if (!empty($input)){

			$this->db->insert("prc_plan_item",$input);

			return $this->db->affected_rows();

		}

	}

	public function insertHist($input){

		if (!empty($input)){

			$this->db->insert("prc_plan_hist",$input);

			return $this->db->affected_rows();

		}
	}

	public function insertVolumeHist($input){

		if (!empty($input)){

			$this->db->insert("prc_plan_volume",$input);

			return $this->db->affected_rows();

		}
	}

	public function getVolumeHist($smbd_code="",$ppm_id="",$ppv_no=""){

		if (!empty($smbd_code)){

			$this->db->where('ppv_smbd_code', $smbd_code);

		}
		if (!empty($ppm_id)){

			$this->db->where('ppm_id', $ppm_id);

		}
		if (!empty($ppv_no)){

			$this->db->where('ppv_no', $ppv_no);

		}

		$this->db->limit(1);
		$this->db->order_by('ppv_id', 'desc');
		$data = $this->db->get("prc_plan_volume");

		return $data;
	}

	public function updateHist($id, $input= array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pph_first',$id)->update('prc_plan_hist',$input);

			return $this->db->affected_rows();

		}
	}

	public function getHist($prnum, $code){

		if (!empty($prnum)){

			$this->db->where("pph_first",$prnum);

		}

		if (!empty($code)){

			$this->db->where("ppm_id",$code);

		}

		$this->db->order_by("pph_id", "desc");

		return $this->db->get("prc_plan_hist");
	}

}
