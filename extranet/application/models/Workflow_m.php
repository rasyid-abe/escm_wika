<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workflow_m extends CI_Model {

  public function get_comment($code = "",$id = "",$mod){

    $this->db->select("cwo_id as comment_id,
    ".$mod."_id,
    contract_id,
    cwo_start_date as comment_date,
    cwo_end_date as comment_end_date,
    cwo_name as comment_name,
    cwo_response as response,
    cwo_comment as comments,
    cwo_activity as activity,
    cwo_position as position,
    cwo_end_date as end_date,
    cwo_attachment as attachment,
    (SELECT awa_name FROM adm_wkf_activity WHERE awa_id=cwo_activity) as activity_name,
    cwo_user as user_id");

    if(!empty($code)){
      $this->db->where($mod."_id = '".$code."'");
    }

    if(!empty($id)){
      $this->db->where("cwo_id",$id);
    }

    $this->db->order_by("cwo_id","desc");
    $sql=$this->db->get("ctr_".$mod."_comment");
    //echo $this->db->last_query();die;
    return $sql;


  }
  public function get_activity($id = ""){
    if(!empty($id)){
      $this->db->where("awa_id",$id);
    }
    return $this->db->get("adm_wkf_activity");
  }

  public function get_response($awr = "",$awa = ""){
    if(!empty($awr)){
      $this->db->where("awr_id",$awr);
    }
    if(!empty($awa)){
      $this->db->where("awa_id",$awa);
    }
    return $this->db->get("adm_wkf_response");
  }


  public function get_response_list($code){
    $data = $this->get_response("",$code)->result_array();
    $ret = array();
    foreach ($data as $key => $value) {
      $ret[$value['awr_id']] = $value['awr_name'];
    }
    return $ret;
  }
  public function get_content_by_activity($id = ""){

		if(!empty($id)){

			$this->db->where("awa_id",$id);

		}

		$this->db->order_by("awc_sequence","asc");

		return $this->db->get("adm_wkf_content");

	}
  function get_doc_type(){
    return $this->db->get('ctr_doc_matgis_type');
  }
  public function get_comment_matgis($code = "",$id = "",$mod){

    $this->db->select("cwo_id as comment_id,
    ".$mod."_id,
    contract_id,
    cwo_start_date as comment_date,
    cwo_end_date as comment_end_date,
    cwo_name as comment_name,
    cwo_response as response,
    cwo_comment as comments,
    cwo_activity as activity,
    cwo_position as position,
    cwo_end_date as end_date,
    cwo_attachment as attachment,
    (SELECT awa_name FROM adm_wkf_activity WHERE awa_id=cwo_activity) as activity_name,
    cwo_user as user_id");

    if(!empty($code)){
      $this->db->where($mod."_id = '".$code."'");
    }

    if(!empty($id)){
      $this->db->where("cwo_id",$id);
    }

    $this->db->order_by("cwo_id","desc");
    $sql=$this->db->get("ctr_".$mod."_comment");
    //echo $this->db->last_query();die;
    return $sql;


  }

}
