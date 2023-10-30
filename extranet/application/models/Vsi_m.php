<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Vsi_m extends CI_Model
{

  public function getKuesioner($id="", $template="", $header=""){

    if(!empty($id)){

      $this->db->where("avk_id",$id);

    }
    if(!empty($template)){

      $this->db->where("template_id",$template);

    }
    if(!empty($header)){

      $this->db->where("avk_header",$header);

    }
    
    $this->db->order_by("avk_id", "asc");

    return $this->db->get("adm_vsi_kuesioner");
  }

  public function getTemplateKuesioner($id=""){

    if(!empty($id)){

      $this->db->where("atk_id",$id);

    }

    $this->db->order_by("atk_id", "desc");
    $this->db->where("atk_status", "Aktif");

    return $this->db->get("adm_vsi_template_kuesioner");
  }

  public function getTemplateContractor($id=""){

    if(!empty($id)){

      $this->db->where("questmaster_id",$id);

    }
    $this->db->join("vnd_vsi_contractor y", "y.vvc_id = x.cont_id");
    return $this->db->get("vnd_vsi_contractor_template x");
  }

  public function getContractor($id=""){

    if(!empty($id)){

      $this->db->where("vvc_id",$id);

    }

    $this->db->order_by("vvc_id", "asc");
    $this->db->limit(10);
    return $this->db->get("vnd_vsi_contractor");
  }

  public function perContractor($data=array())
  {

    $was = $this->db->where('vvc_name', $data['vvc_name'])->get("vnd_vsi_contractor")->row_array();
    if ($was) {
      return $was['vvc_id'];
    }else{
      $this->db->insert("vnd_vsi_contractor", $data);
      return $this->db->insert_id();
    }
    
  }

  public function insertContractorTemplate($data=array()){

    $this->db->insert("vnd_vsi_contractor_template", $data);
    return $this->db->insert_id();    
  }

  public function getVndQuest($id, $vnd){

    if(!empty($id)){

      $this->db->where("vvq_id",$id);

    }
    if(!empty($vnd)){

      $this->db->where("vendor_code",$vnd);

    }
    $this->db->order_by("vvq_id", "desc");
    return $this->db->get("vnd_vsi_quest");    
  }

  public function getVndKuesioner($template="", $header=""){

    if(!empty($template)){

      $this->db->where("questmaster_id",$template);

    }
    if(!empty($header)){

      $this->db->where("vvk_quest_header",$header);

    }
    $this->db->order_by("vvk_id", "asc");
    return $this->db->get("vnd_vsi_kuesioner");    
  }

  public function insertVndQuest($data=array()){

    $this->db->insert("vnd_vsi_quest", $data);
    return $this->db->insert_id();    
  }

  public function insertVndKuesioner($data=array()){

    $this->db->insert("vnd_vsi_kuesioner", $data);
    return $this->db->insert_id();    
  }

  public function getListVsi()
  {
    return $this->db->where("vendor_id", $this->session->userdata("userid"))->get("vw_contract_active");
  }

  public function getPeriode()
  {  
    $month = (int)date('m');
    return $this->db->where(array('status'=>1, 'month'=>$month))->get("periode_vsi");
  }

  public function getVendorData($id = "")
  {
    if (!empty($id)) 
    {
      return $this->db->where("vendor_id", $id)->get("vnd_header");
    }
  }

}