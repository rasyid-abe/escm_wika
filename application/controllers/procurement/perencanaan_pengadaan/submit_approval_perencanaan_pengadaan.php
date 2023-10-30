<?php

$post = $this->input->post();
$last_id = $post['id'];

$input = array();

$key2 = 0;

$userdata = $this->data['userdata'];

$this->form_validation->set_rules("status_inp[$key2]", "lang:status #$key2", 'required');
$this->form_validation->set_rules("lang:comment #$key2", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');


$status = $post['status_inp'][$key2];

if($status == 2 || $status == 3){
  $input['ppm_approved_date'] = date("Y-m-d H:i:s");
  $input['ppm_approved_pos_code'] = $userdata['pos_id'];
  $input['ppm_approved_pos_name'] = $userdata['pos_name'];
}

$plan = $this->Procplan_m->getPerencanaanPengadaan($last_id)->row_array();

$wkf = array(1=>"Tolak",2=>"Setuju",3=>"Setuju",4=>"Tolak");

$activity_list = array(1=>"Permintaan Persetujuan VP",2=>"Permintaan Persetujuan PIC Anggaran", 3=>"Permintaan Persetujuan PIC Anggaran");

$response = $wkf[$status];

// $activity = $activity_list[$plan['ppm_status']];

$com = $post['comment_inp'][0];


$input_comment = array();

$next_jobtitle = $this->Procedure_m->getNextJobTitlePlan($userdata['pos_id'],$plan['ppm_pagu_anggaran'],$plan['ppm_type_of_plan']);

// $next_pos_id = $status == '3' || $status == '2' ? ($next_jobtitle[0]['hap_pos_parent'] != null ? $next_jobtitle[0]['hap_pos_parent'] : 212) : $plan['ppm_planner_pos_code'];
//$next_pos_id = $status == '3' || $status == '2' || $status == '1' ? ($next_jobtitle != null ? $next_jobtitle : 212) : $plan['ppm_planner_pos_code'];
$next_pos_id = $status != '4' ? ($next_jobtitle != null ? $next_jobtitle : 212) : $plan['ppm_planner_pos_code'];


$input['ppm_next_pos_id'] = $next_pos_id;

$activity = "Permintaan Persetujuan ".$userdata['pos_name'];

if ($next_pos_id == 212) {
    $status = 3;
 }

$input['ppm_status']=$status;

if ($this->form_validation->run() == FALSE){

  $this->renderMessage("error");

  //$this->approval_perencanaan_pengadaan();

} else {


  $this->db->trans_begin();

  $act = $this->Procplan_m->updateDataPerencanaanPengadaan($last_id,$input);

  //echo $this->db->last_query();

  if($act){
    $dateopen = $this->input->post('dateopen');

    $this->Comment_m->insertProcurementPlan($last_id,$com,$response,$activity,$dateopen,$next_pos_id);

    //haqim mail drp send

      // $this->Procedure_m->prc_plan_comment_complete($last_id,$plan['ppm_dept_name'],$plan['ppm_planner_pos_name'],"APPROVAL PERENCANAAN PENGADAAN",$plan['ppm_planner'],$status[0]);

      $this->Procedure_m->prc_plan_comment_complete($plan['ppm_id'],$plan['ppm_dept_name'],$plan['ppm_planner_pos_name'],$plan['ppm_planner_pos_code'],"APPROVAL PERENCANAAN PENGADAAN ".strtoupper($plan['ppm_subject_of_work']),$next_pos_id,$status); 

      if($plan['ppm_type_of_plan'] == "rkp_matgis" 
        && $status == 3 
        && $plan['ppm_status'] == 2){

        $i['pr_number'] = $this->Procpr_m->getUrutPR().'-N';
        $i['pr_requester_name'] = $plan['ppm_planner'];
        $i['ppm_id'] = $plan['ppm_id'];
        $i['pr_requester_pos_code'] = $plan['ppm_planner_pos_code'];
        $i['pr_requester_pos_name'] = $plan['ppm_planner_pos_name'];
        $i['pr_created_date'] = date("Y-m-d H:i:s");
        $i['pr_subject_of_work'] = $plan['ppm_subject_of_work'];
        $i['pr_scope_of_work'] = $plan['ppm_scope_of_work']."/".$plan['ppm_dept_name'];
        $i['pr_district_id'] = $plan['ppm_district_id'];
        $i['pr_district'] = $plan['ppm_district_name'];
        $i['pr_currency'] = $plan['ppm_currency'];
        $i['pr_status'] = 1001;
        $i['pr_dept_id'] = $plan['ppm_dept_id'];
        $i['pr_dept_name'] = $plan['ppm_dept_name'];
        $i['pr_mata_anggaran'] = $plan['ppm_mata_anggaran'];
        $i['pr_nama_mata_anggaran'] = $plan['ppm_nama_mata_anggaran'];
        $i['pr_sub_mata_anggaran'] = $plan['ppm_sub_mata_anggaran'];
        $i['pr_nama_sub_mata_anggaran'] = $plan['ppm_nama_sub_mata_anggaran'];
        $i['pr_pagu_anggaran'] = (int) $plan['ppm_pagu_anggaran'];
        $i['pr_requester_id'] = $plan['ppm_planner_id'];
        $i['pr_type_of_plan'] = $plan['ppm_type_of_plan'];
        $i['pr_project_name'] = $plan['ppm_subject_of_work']." / ".$plan['ppm_dept_name'];
        $i['pr_type'] = "MATERIAL STRATEGIS";
        $i['pr_packet'] = $plan['ppm_subject_of_work'];

        $sisa_anggaran = (int) ($plan['ppm_sisa_anggaran']) ? $plan['ppm_sisa_anggaran'] : 0;

        $x = $this->db->where("ppm_id",$plan['ppm_id'])
        ->get("prc_plan_item")->result_array();

        foreach ($x as $key2 => $value2) {
          
          $item['ppi_code'] = $value2['ppi_code'];
          $item['pr_number'] = $i['pr_number'];
          $item['ppi_description'] = $value2['ppi_item_desc'];
          $item['ppi_quantity'] = $value2['ppi_jumlah'];
          $item['ppi_unit'] = $value2['ppi_satuan'];
          $item['ppi_price'] = $value2['ppi_harga'];
          $item['ppi_currency'] = $i['pr_currency'];
          $item['ppi_type'] = 'MULTIPLE';
          $item['ppi_ppn'] = 0;
          $item['ppi_pph'] = 0;
		      $item['ppi_pr_tujuan'] = $value2['ppi_tujuan'];

          $this->db->insert("prc_pr_item",$item);

          $sisa_anggaran -= $item['ppi_price']*$item['ppi_quantity'];

        }

        $i['pr_sisa_anggaran'] = (int) $sisa_anggaran;

        $comment['ppc_pos_code'] = $i['pr_requester_pos_code'];
        $comment['ppc_position'] = $i['pr_requester_pos_name'];
        
        $comment['pr_number'] = $i['pr_number'];
        $comment['ppc_activity'] = $i['pr_status'];
        $comment['ppc_start_date'] = date("Y-m-d H:i:s");
        $comment['ppc_comment'] = "[SYSTEM] MATERIAL STRATEGIS IPROC";

        $this->db->insert("prc_pr_main",$i);

        $this->db->insert("prc_pr_comment",$comment);

      }
    
    //end

  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal approve data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses approve data");
    $this->db->trans_commit();
  }

  $this->renderMessage("success",site_url("procurement/daftar_pekerjaan"));

}
