<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Procedure_matgis_m extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Global_m");
  }

  public function ctr_comment_complete(
    $total_item = 0,
    $mod = "",
    $id = "", //key of mod
    $activity_id = 0,
    $response = 0,
    $comment = "",
    $attachment = "",
    $comment_id = 0,
    $contract_id = 0,
    $userdata = null,
    $wo_id = 0,
    $dept_code=0,
    $sppm_id=0
  ) {
    // echo $total_item;
    // echo $mod;
    // echo $id;
    //print_r($activity);die();
    // echo $response;
    // echo $comment;
    // echo $comment_id;
    // echo $contract_id;


    //Load declared
    //include("shared/declared.php");
    include APPPATH . 'controllers/shared/declared.php';
    $activity_next=0;
    $nextPosCode  = "";
    $nextPosName  = "";
    $lastPosCode  = "";
    $lastPosName  = "";
    $lastActivity = "";
    $nextActivity = 0;
    $w_response=array("awr_id"=>$response);
    $response_text = $this->Global_m->get_data("adm_wkf_response", $w_response)['awr_name'];
    $inserted_comment = 0;
    $modv="";
    if($mod=='skbdn'){
      $modv='wo';
    }elseif($mod=='po'){
      $modv='wo';
    }else{
      $modv=$mod;
    }
    //get current activity

    $where_data   = array('cwo_name' => null,$modv.'_id'=>$id);
    $comment_data = $this->Global_m->get_data("ctr_" . $modv . "_comment", $where_data);
    $lastPosName  = $comment_data['cwo_position'];
    $lastPosCode  = $comment_data['cwo_pos_code'];
    $nextPosCode  = $lastPosCode;
    $nextPosName  = $lastPosName;
    $lastActivity = $comment_data['cwo_activity'];
    $comment_id   = $comment_data['cwo_id'];


    //check commentdata if last status update cwo_name null else
    $reff=$mod;
    $pos_id               = "";
    $pos_name             = "";
    $approved_date        = "";
    $current_approver_pos = "";
    $current_approver_id  = 0;
    $wewenang_rp          = 0;

    //print_r($response);die;
    switch (strtoupper($response_text)) {
      case "SIMPAN SEBAGAI DRAFT PO": //response simpan sebagai draft
      $pos_id       = $userdata['pos_id'];
      $pos_name     = $userdata['pos_name'];
      $activity_next = $activity_draft; //kembali ke aktifitas awal
      break;

      case "SIMPAN DAN LANJUT PO": //response simpan dan lanjut WO Matgis
      $activity_next = $activity_second;
      //$pic = $this->Administration_m->getPosition("PIC USER"); // default position PIC User
      $pic         = $this->Contract_matgis_m->get_rkp_position_by_title(array("adm_auth_hie_rkp.pos_id=".$userdata['pos_id']));
      $pos_id      = $pic['hap_pos_parent'];
      $pos_name    = $pic['hap_pos_parent_name'];
      $wewenang_rp = $pic['hap_amount'];
      //print_r($pic);die;
      break;


      case "SETUJU PO": //response Setuju
      $pic = $this->Contract_matgis_m->get_rkp_position_by_title(array("adm_auth_hie_rkp.pos_id =".$userdata['pos_id']));
      $wewenang_rp = $pic['hap_amount'];
      $cek=$wewenang_rp>(double)$total_item;

      if ($cek) {
        //next state
        $activity_next = $activity_approved_po;
        //kembali ke pic awal
        //print_r($dept_code);die;
        $smallest_dept = $this->Contract_matgis_m->get_smallest_rkp_position($dept_code);
        $pic2=$this->db->where('wo_id',$id)->get('ctr_wo_header')->row_array();
        $pos_id   = $pic2['vendor_id'];
        $pos_name = $pic2['vendor_name'];

        // print_r($activity_next);
        // print_r($pos_id);
        // print_r($pos_name);
        // die;
      } else {
        //loop state
        $pos_id      = $pic['hap_pos_parent'];
        $pos_name    = $pic['hap_pos_parent_name'];
        $activity_next = $activity_second;

      }
      break;

      case "REVISI PO":
      $activity_next = $activity_revise_po;
      $smallest_dept = $this->Contract_matgis_m->get_smallest_rkp_position($dept_code);
      $pic2 = $this->Contract_matgis_m->get_rkp_position_by_title(array("adm_auth_hie_rkp.pos_id=".$smallest_dept['hap_pos_code']));
      $pos_id   = $pic2['hap_pos_code'];
      $pos_name = $pic2['hap_pos_name'];
      break;

      case "SIMPAN SKBDN" :
      $activity_next = 2033;
      $pos_id       = $userdata['pos_id'];
      $pos_name     = $userdata['pos_name'];
      break;

      case "SIMPAN DAN LANJUT SI": //response simpan lanjut SI
      $activity_next = $activity_last;
      $pos_id       = $userdata['pos_id'];
      $pos_name     = $userdata['pos_name'];
      break;

      case "SIMPAN DAN LANJUT DO": //response simpan lanjut DO
      case "SIMPAN DAN LANJUT SJ": //response simpan lanjut SJ
      case "SIMPAN DAN LANJUT BAPB": //response simpan lanjut BAPB
      break;

      case "SIMPAN DAN LANJUT INVOICE": //response simpan lanjut Inv
      $activity_next = $activity_last;
      $pos_id       = $userdata['pos_id'];
      $pos_name     = $userdata['pos_name'];
      break;

      case "SIMPAN DAN LANJUT SPPM": //response simpan lanjut SPPM
      $pic = $this->Contract_matgis_m->get_rkp_position_by_title(array("adm_auth_hie_rkp.pos_id =".$userdata['pos_id']));
      $pos_id      = $pic['hap_pos_parent'];
      $pos_name    = $pic['hap_pos_parent_name'];
      $reff="sppm";
      $activity_next = $activity_second;

      //si di convert ke SPPM

      break;

      case "SETUJU SPPM": //response simpan lanjut SPPM
      $activity_next = $activity_last;
      $pic2=$this->db->where('sppm_id',$sppm_id)->get('ctr_sppm_header')->row_array();
      $pos_id       = $userdata['pos_id'];
      $pos_name     = $userdata['pos_name'];
      break;


      case "SIMPAN SEBAGAI DRAFT SI": //response simpan draft SI
      case "SIMPAN SEBAGAI DRAFT SPPM": //response simpan draft SPPM
      case "SIMPAN SEBAGAI DRAFT DO": //response simpan draft DO
      case "SIMPAN SEBAGAI DRAFT SJ": //response simpan draft SJ
      case "SIMPAN SEBAGAI DRAFT BAPB": //response simpan draft BAPB
      case "SIMPAN SEBAGAI DRAFT INVOICE": //response simpan draft Inv
      $activity_next = $activity_draft;
      $pos_id       = $userdata['pos_id'];
      $pos_name     = $userdata['pos_name'];
      break;

      case "BATALKAN WO": //response tidak setuju Draft WO Matgis
      case "BATALKAN SI": //response cancel SI
      case "BATALKAN DO": //response cancel DO
      case "BATALKAN SJ": //response cancel SJ
      case "BATALKAN BAPB": //response cancel BAPB
      case "BATALKAN INVOICE": //response cancel Inv
      $activity_next = $activity_cancel;
      break;

      case "TOLAK SPPM": //response simpan lanjut SPPM
      $activity_next = $activity_cancel;
      $smallest_dept = $this->Contract_matgis_m->get_smallest_rkp_position($dept_code);
      $pic2 = $this->Contract_matgis_m->get_rkp_position_by_title(array("adm_auth_hie_rkp.pos_id=".$smallest_dept['hap_pos_code']));
      $pos_id   = $pic2['hap_pos_code'];
      $pos_name = $pic2['hap_pos_name'];
      //Penolakan di balikan ke PIC USER
      //kembalikan SI menjadi aktif
      $this->db->where('sppm_id',$id);
      $si_id=$this->db->get('ctr_sppm_header')->row()->si_id;


      $comment_arr = array(
        "si_id"          => $si_id,
        "cwo_pos_code"   => $pos_id,
        "cwo_position"   => $pos_name,
        "cwo_name"       => null,
        "cwo_activity"   => 2042, //SI Back to Active
        "cwo_start_date" => date("Y-m-d H:i:s"),
        "contract_id"    => (int)$contract_id,
      );
      $this->Global_m->insert_table("ctr_si_comment", $comment_arr);
      break;

      case "SETUJU BAPB": //response simpan lanjut SPPM
      //$pic2 = $this->Contract_matgis_m->get_smallest_rkp_position($dept_code);
      //$pic2=$this->db->where('bapb_id',$id)->get('ctr_bapb_header')->row_array();
      $pic2=$this->db->query('SELECT * FROM ctr_bapb_comment WHERE wo_id='.$wo_id.' AND cwo_activity=2080')->row_array();
      //print_r($pic2);die;
      $activity_next = $activity_last;
      $pos_id   = $pic2['cwo_pos_code'];
      $pos_name = $pic2['cwo_position'];

      break;

      case "TAGIHAN DITERIMA": //response simpan sebagai draft
      $pos_id       = $userdata['pos_id'];
      $pos_name     = $userdata['pos_name'];
      $activity_next = $activity_last; //kembali ke aktifitas awal
      //echo $activity_next; die;
      break;

    }
    if($mod=='skbdn'){
      $reff="wo";
    }elseif($mod=='po'){
      $reff="wo";
    }
    else{
      $reff=$mod;
    }

    //Update comments for last
    if(isset($lastActivity)){
      $comment_arr = array(
        "cwo_response"   => $response_text,
        "cwo_name"       => $userdata['user_name'],
        "cwo_end_date"   => date("Y-m-d H:i:s"),
        "cwo_comment"    => $comment,
        "cwo_attachment" => $attachment,
        "cwo_user"       => $userdata["id"]
      );
      $this->Global_m->update_table("ctr_" . $reff . "_comment", $comment_arr, $comment_id);
      //echo $this->db->last_query();die;
    }

    if ($activity_id==$activity_first || $activity_next == $activity_cancel) {
      //Final close there's no next comment
      $data = array();
      if($activity_id==$activity_first){
        $this->db->where($reff.'_id',$id);
        $this->db->where('cwo_activity',$activity_id);
        $data=$this->db->get('ctr_'.$reff.'_comment')->result_array();
        //echo $this->db->last_query();
      }
      if(empty($data)){
        $comment_arr = array(
          $reff . "_id"     => $id,
          "cwo_pos_code"   =>  $userdata['pos_id'],
          "cwo_position"   =>  $userdata['pos_name'],
          "cwo_activity"   => $activity_id,
          "cwo_start_date" => date("Y-m-d H:i:s"),
          "contract_id"    => $contract_id,
          "cwo_response"   => $response_text,
          "cwo_name"       => $userdata['user_name'],
          "cwo_end_date"   => date("Y-m-d H:i:s"),
          "cwo_comment"    => $comment,
          "cwo_user"       => $userdata['id']
        );
        //Update comments for last
        //Beginning stat come to here
        $inserted_comment_id = $this->Global_m->insert_table("ctr_" . $reff . "_comment", $comment_arr);
        //echo $this->db->last_query();
      }
      //die;

      if ($activity_next == $activity_cancel) {
        $data = array('status' => $activity_id, 'active' => 0);
      } else {
        $data = array('status' => $activity_id, $reff . '_total' => $total_item);
      }
      $this->Global_m->update_table("ctr_" . $reff . "_header", $data, $id);
    }


    if($activity_id!==$activity_last){
      $comment_arr = array(
        $reff . "_id"     => $id,
        "cwo_pos_code"   => $pos_id,
        "cwo_position"   => $pos_name,
        "cwo_name"       => null,
        "cwo_activity"   => $activity_next, //next activity
        "cwo_start_date" => date("Y-m-d H:i:s"),
        "contract_id"    => (int)$contract_id,
      );
      $this->Global_m->insert_table("ctr_" . $reff . "_comment", $comment_arr);
      //echo $this->db->last_query();die;

      if($activity_next==2093){ // Invoice Diterima
        $data = array('status' => $activity_next, 'current_approver_pos' => $pos_name, 'current_approver_id' => $pos_id, 'approved_date' => date("Y-m-d H:i:s"),'accepted'=>1);
      }else{
        $data = array('status' => $activity_next, 'current_approver_pos' => $pos_name, 'current_approver_id' => $pos_id, 'approved_date' => date("Y-m-d H:i:s"));
      }

      $this->Global_m->update_table("ctr_" . $reff . "_header", $data, $id);
      //echo $this->db->last_query();die;
    }


  }

  public function get_item_wo($id)
  {
    $this->db->where("wo_id", $id);
    return $this->db->get("ctr_wo_item")->result_array();
  }

  public function duplicate_item_bapb_to_inv($bapb_id, $inv_id)
  {
    $qry = 'INSERT INTO "ctr_inv_item" (
      "contract_item_id",
      "sppm_id",
      "item_code",
      "short_description",
      "long_description",
      "price",
      "qty",
      "uom",
      "sub_total",
      "ppn",
      "pph" ) SELECT
      "contract_item_id",
      ' . $inv_id . ',
      "item_code",
      "short_description",
      "long_description",
      "price",
      "qty",
      "uom",
      "sub_total",
      "ppn",
      "pph"
      FROM
      "ctr_si_item"
      WHERE
      bapb_id =' . $bapb_id;
      $sql = $this->db->query($qry);
      return ($this->db->affected_rows() > 0);
    }


    public function duplicate_item_si_to_sppm($si_id, $sppm_id)
    {
      $qry = 'INSERT INTO "ctr_sppm_item" (
        "contract_item_id",
        "sppm_id",
        "item_code",
        "short_description",
        "long_description",
        "price",
        "qty",
        "uom",
        "sub_total",
        "ppn",
        "pph" ) SELECT
        "contract_item_id",
        ' . $sppm_id . ',
        "item_code",
        "short_description",
        "long_description",
        "price",
        "qty",
        "uom",
        "sub_total",
        "ppn",
        "pph"
        FROM
        "ctr_si_item"
        WHERE
        si_id =' . $si_id;
        $sql = $this->db->query($qry);
        return ($this->db->affected_rows() > 0);
      }

      public function duplicate_item_wo_to_si($wo_id, $si_id)
      {
        $qry = 'INSERT INTO "ctr_si_item" (
          "wo_id",
          "contract_item_id",
          "si_id",
          "item_code",
          "short_description",
          "long_description",
          "price",
          "qty",
          "uom",
          "sub_total",
          "ppn",
          "pph" ) SELECT
          "wo_id",
          "contract_item_id",
          ' . $si_id . ',
          "item_code",
          "short_description",
          "long_description",
          "price",
          "qty",
          "uom",
          "sub_total",
          "ppn",
          "pph"
          FROM
          "ctr_wo_item"
          WHERE
          wo_id =' . $wo_id;
          $sql = $this->db->query($qry);
          return ($this->db->affected_rows() > 0);
        }

        public function number_exist($table, $number)
        {
          switch ($table) {
            case 'ctr_wo_header':
            $this->db->where('wo_number', $number);
            break;
            case 'ctr_si_header':
            $this->db->where('si_number', $number);
            break;
            case 'ctr_sppm_header':
            $this->db->where('sppm_number', $number);
            break;
            case 'ctr_do_header':
            $this->db->where('do_number', $number);
            break;
            case 'ctr_sj_header':
            $this->db->where('sj_number', $number);
            break;
            case 'ctr_bapb_header':
            $this->db->where('bapb_number', $number);
            break;
            case 'ctr_inv_header':
            $this->db->where('inv_number', $number);
            break;
            default:
            $this->db->where('id', $id);
            break;
          }
          $hsl = $this->db->get($table);
          //echo $hsl->num_rows(); die;
          if ($hsl->num_rows() > 0) {
            return true;
          } else {
            return false;
          }
        }

        public function set_active_header_rec($table, $id, $state = 1)
        {
          //default state=1 active 0 inactive
          $data = array('active' => $state);
          switch ($table) {
            case 'ctr_wo_header':
            $this->db->where('wo_id', $id);
            break;
            case 'ctr_si_header':
            $this->db->where('si_id', $id);
            break;
            case 'ctr_sppm_header':
            $this->db->where('sppm_id', $id);
            break;
            case 'ctr_do_header':
            $this->db->where('do_id', $id);
            break;
            case 'ctr_sj_header':
            $this->db->where('sj_id', $id);
            break;
            case 'ctr_bapb_header':
            $this->db->where('bapb_id', $id);
            break;
            case 'ctr_inv_header':
            $this->db->where('inv_id', $id);
            break;
            default:
            $this->db->where('wo_id', $id);
            break;
          }
          $this->db->update($table, $data);
        }
        public function set_active_item_rec($table, $id, $state = 1)
        {
          //default state=1 active
          $data = array('active' => $state);
          switch ($table) {
            case 'ctr_wo_item':
            $this->db->where('wo_id', $id);
            break;
            case 'ctr_si_item':
            $this->db->where('si_id', $id);
            break;
            case 'ctr_sppm_item':
            $this->db->where('sppm_id', $id);
            break;
            case 'ctr_do_item':
            $this->db->where('do_id', $id);
            break;
            case 'ctr_sj_item':
            $this->db->where('sj_id', $id);
            break;
            case 'ctr_bapb_item':
            $this->db->where('bapb_id', $id);
            break;
            case 'ctr_inv_item':
            $this->db->where('inv_id', $id);
            break;
            default:
            $this->db->where('wo_id', $id);
            break;
          }
          $this->db->update($table, $data);
        }

        public function set_active_comment_rec($table, $id, $state = 1)
        {
          //default state=1 active
          $data = array('active' => $state);
          switch ($table) {
            case 'ctr_wo_comment':
            $this->db->where('wo_id', $id);
            break;
            case 'ctr_si_comment':
            $this->db->where('si_id', $id);
            break;
            case 'ctr_sppm_comment':
            $this->db->where('sppm_id', $id);
            break;
            case 'ctr_do_comment':
            $this->db->where('do_id', $id);
            break;
            case 'ctr_sj_comment':
            $this->db->where('sj_id', $id);
            break;
            case 'ctr_bapb_comment':
            $this->db->where('bapb_id', $id);
            break;
            case 'ctr_inv_comment':
            $this->db->where('inv_id', $id);
            break;
            default:
            $this->db->where('wo_id', $id);
            break;
          }
          $this->db->update($table, $data);
        }

      }
