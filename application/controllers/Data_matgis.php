<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_matgis extends Telescoope_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model(array("Procedure_matgis_m","Settings_m","Contract_matgis_m"));
  }

  public function data_create_matgis($mod)
  {
    $get = $this->input->get();
    $filtering = $this->uri->segment(4, 0);
    $userdata = $this->Administration_m->getLogin();
    //print_r($userdata);die;
    $params = array();
    switch ($mod) {
      case 'po':
      $reff="contract";
      break;
      case 'skbdn':
      case 'si':
      case 'sppm':
      case 'bapb':
      $reff="po";
      break;
      default:
      // code...
      break;
    }
    $id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
    $order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
    $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
    $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
    $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
    $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "contract_id";

    if(!empty($search)){
      $this->db->group_start();
      $this->db->like($reff.'_notes',$search);
      $this->db->or_like('vendor_name',$search);
      $this->db->or_where($reff."_number",$search);
      $this->db->group_end();
    }

    switch ($mod) {
      case 'po':
      array_push($params,'dept_id='.$userdata['dept_id']);
      break;

      case 'skbdn':
      case 'si':
      case 'sppm':
      case 'bapb':
      array_push($params,'ctr_wo_header.dept_id='.$userdata['dept_id']);
      //array_push($params,'(vw_sum_wo.total_qty-vw_sum_wo.total_qty)>0');
      break;
      default:
      // code...
      break;
    }

    $data['total'] = $this->Contract_matgis_m->get_data($mod,$params,'create')->num_rows();
    $rows = $this->Contract_matgis_m->get_data($mod,$params,'create')->result_array();
    //echo $this->db->last_query(); die;
    $data['rows'] = $rows;
    echo json_encode($data);
  }

  public function monitoring_task_matgis($mod)
  {
    $userdata = $this->Administration_m->getLogin();
    $get = $this->input->get();
    $filtering = $this->uri->segment(4, 0);
    $params = array();
    $id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
    $order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
    $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
    $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
    $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
    $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : $mod."_id";

    if(!empty($search)){
      $this->db->group_start();
      
      if ($mod != 'monev') {
         $this->db->or_like("LOWER(vendor_name)",$search);
      }
      
      $this->db->or_where($mod."_number",$search);
      $this->db->group_end();
    }
    if(!empty($order)){
      $this->db->order_by($field_order,$order);
    }
    if(!empty($limit)){
      $this->db->limit($limit,$offset);
    }
    switch ($mod) {
      case 'po':
      $params = array('dept_id='.$userdata['dept_id']);
      break;
      case 'si':
      case 'sppm':
      case 'bapb':
      $params = array('ctr_wo_header.dept_id='.$userdata['dept_id']);
      break;
      case 'monev':
      $params = array('dept_id='.$userdata['dept_id']);
      break;

      default:
      $params = array('ctr_wo_header.dept_id='.$userdata['dept_id']);
      break;
    }

    $data['total'] = $this->Contract_matgis_m->get_data($mod,$params,'monitor')->num_rows();
    $rows = $this->Contract_matgis_m->get_data($mod,$params,'monitor')->result_array();

    foreach ($rows as $key => $value) {


        if (isset($value['do_id'])) {
          $rows[$key]['url_do'] = "<a href=".site_url("contract_matgis/process_matgis/do/".$value['do_id']."/2")."  target='_blank'>".$value['do_number']."</a>";
        }

        if (isset($value['do_filename'])) {
           $rows[$key]['lampiran_do'] = "<a href=".site_url("log/download_attachment_extranet/DO/".$value['vendor_id']."/".$value['do_filename'])."  target='_blank'>".$value['do_filename']."</a>";
        }

        if (isset($value['sj_id'])) {
          $rows[$key]['url_sj'] = "<a href=".site_url("contract_matgis/process_matgis/sj/".$value['sj_id']."/2")."  target='_blank'>".$value['sj_number']."</a>";
        }

       if (isset($value['bapb_id']) AND isset($value['bapb_number'])) {
         $rows[$key]['url_bapb'] = "<a href=".site_url("contract_matgis/process_matgis/bapb/".$value['bapb_id']."/2")."  target='_blank'>".$value['bapb_number']."</a>";
       }

        if (isset($value['inv_id'])) {
           $rows[$key]['url_inv'] = "<a href=".site_url("contract_matgis/process_matgis/inv/".$value['inv_id']."/2")."  target='_blank'>".$value['inv_number']."</a>";
        }



    }

    $data['rows'] = $rows;
    echo json_encode($data);
  }


  public function data_task_matgis($mod)
  {
    //echo "here";die;
    include("shared/declared.php");
    $userdata = $this->Administration_m->getLogin();
    $get = $this->input->get();
    $filtering = $this->uri->segment(4, 0);
    $params = array();
    $id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
    $order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
    $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
    $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
    $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
    $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : $mod."_id";
    $smallest_dept = $this->Contract_matgis_m->get_smallest_rkp_position($userdata['dept_id']);
    array_push($params,'ctr_wo_header.dept_id='.$userdata['dept_id']);
    $reff=$mod;
    $urut="";
    if(!empty($userdata['pos_id'])){
      $user=$userdata['pos_id'];

      if($mod=="approval_sppm"){
        array_push($params,'ctr_sppm_header.current_approver_id='.$userdata['pos_id']);
        array_push($params,'ctr_sppm_header.status=2053');
      }
      if($mod=="sppm"){
        $urut='ORDER BY ord desc';
      }
      if($mod=="bapb"){
        array_push($params,'ctr_bapb_header.current_approver_id='.$userdata['pos_id']);
      }
      if($mod=='inv'){
        array_push($params,'ctr_inv_header.current_approver_id='.$userdata['pos_id']);
      }
      if($mod=='po'){
        array_push($params,'ctr_wo_header.current_approver_id='.$userdata['pos_id']);
        $reff="wo";
      }
      if($mod=='skbdn'){
        array_push($params,'ctr_wo_header.current_approver_id='.$userdata['pos_id']);
        array_push($params,'ctr_wo_header.status=2037');
        $reff='wo';
      }
      if($mod=='si'){
        array_push($params,'ctr_wo_header.current_approver_id='.$userdata['pos_id']);
        array_push($params,'ctr_wo_header.status=2033');
        $reff='wo';
      }

      if($mod=='bapb'){
        array_push($params,'ctr_bapb_header.current_approver_id='.$userdata['pos_id']);
        $reff='bapb';
      }
      if($mod=='inv'){
        array_push($params,'ctr_inv_header.current_approver_id='.$userdata['pos_id']);
        $reff='inv';
      }
    }

    if(!empty($search)){
      $this->db->group_start();
      $this->db->like("LOWER($mod.'_notes')",$search);
      $this->db->or_like("LOWER('vendor_name')",$search);
      $this->db->or_where($mod."_number",$search);
      $this->db->group_end();
    }

    if(!empty($order)){
      $this->db->order_by($field_order,$order);
    }

    if(!empty($limit)){
      $this->db->limit($limit,$offset);
    }
    //array_push($params,'ctr_'.$mod.'_header.status not in('.$activity_cancel.','.$activity_last.')');
    //print_r($params);die;
    $sql = $this->Contract_matgis_m->get_data($mod,$params,'task',$urut,$user);
    //echo $this->db->last_query();die;
    $rows=$sql->result_array();

    $total=$sql->num_rows();

    $data['total'] = $total;
    $data['rows'] = $rows;

    echo json_encode($data);

  }
}
