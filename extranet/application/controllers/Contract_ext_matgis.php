<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Contract_ext_matgis extends MY_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->helper("general");
    $this->load->model('Contract_m');
    $this->load->model('Global_m');
    $this->load->model('Workflow_m');
    //$this->load->model('Administration_m');
    $this->load->helper('language');
    //$userdata = $this->Administration_m->getLogin();
    $this->data['dir'] = 'contract';
    $dir = './uploads/' . $this->data['dir'];

    $this->session->set_userdata('module', $this->data['dir']);
    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }
    $config['allowed_types'] = '*';
    $config['overwrite']     = false;
    $config['max_size']      = 3064;
    $config['upload_path']   = $dir;
    $this->load->library('upload', $config);
    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

    // if (empty($userdata)) {
    //     redirect(site_url('log/in'));
    // }
  }

  //include APPPATH.'controllers/shared/declared.php';
  public function monitor_wo_matgis(){
    //print_r(base_url());die;
    $data['list']=$this->Contract_m->get_wo_matgis();
    $data['judul'] = "List Monitor WO Matgis";
    $this->layout->view('wo_matgis/list', $data);
  }
  public function number_exists($table, $number)
  {
    $feedback = '';
    if ($this->Contract_m->number_exist($table, strtoupper($number))) {
      $feedback = true;
    } else {
      $feedback = false;
    }
    return $feedback;
  }
  public function process_matgis($mod, $id=0, $state = 0)
  {
    //print_r(APPPATH);die;
    //$path=APPPATH.'\controllers\\';
    //echo "here";die;
    switch ($mod) {
      case 'po':
      include('matgis/process/process_matgis_po.php');
      break;
      case 'do':
      include('matgis/process/process_matgis_do.php');
      break;
      case 'sj':

      include('matgis/process/process_matgis_sj.php');
      break;
      case 'bapb':
      include('matgis/process/process_matgis_bapb.php');
      break;
      case 'inv':
      include('matgis/process/process_matgis_inv.php');
      break;

      default:
      // code...
      break;
    }
}
    public function submit_process_matgis()
    {
      $mod=$this->input->post('mod');
      switch ($mod) {
        case 'po':
        include('matgis/submit_process/submit_process_matgis_po.php');
        break;
        case 'do':
        include('matgis/submit_process/submit_process_matgis_do.php');
        break;
        case 'sj':
        include('matgis/submit_process/submit_process_matgis_sj.php');
        break;
        case 'bapb':
        include('matgis/submit_process/submit_process_matgis_bapb.php');
        break;
        case 'inv':
        include('matgis/submit_process/submit_process_matgis_inv.php');
        break;

        default:
        // code...
        break;
      }
    }



  public function old_submit_process_matgis($mod)
  {

    include("shared/declared.php");
    $post=$this->input->post();
    $error = false;
    $response = $post['status_inp'][0];
    $comment  = $post['comment_inp'][0];
    $attachment =isset($post['attachment'])?$post['attachment']:"";
    $wo_id=$post['wo_id'];
    $contract_id=$post['contract_id'];
    $response_text="";
    $comment_id=0;
    $last_comment = array();
    $userdata = $this->session->userdata();
    //print_r($userdata);die;
    $activity_id=$post['activity_id'];
    $id=$post['id'];
    $new_id=$id;
    $state=$post['state'];
    $total_item=0;
    $sess = $this->session->all_userdata();
    $data="";
    $filename="";

    if ( ! $this->upload->do_upload('attachment'))
    {
    }
    else
    {
      $data = array('upload_data' => $this->upload->data());
      $filename=$data['upload_data']['file_name'];
    }

    $last_comment = $this->Global_m->get_data("ctr_".$mod."_comment",array($mod."_id"=>$id,"cwo_name"=>null));

    if(!empty($last_comment)){
      $activity_id=$last_comment['cwo_activity'];
    }else{
      $activity_id=$activity_first;
    }

    if($post["type_form"]!=="view"){
      $this->db->trans_begin();
      $inputs=null;
      $input_items=null;
      $add_inputs=null;
      $items=null;
      //get init value
      //ambil data yg sudah ada
      if($mod!=='wo'){
        $inputs = array(
          $mod."_number"=>strtoupper($post[$mod."_number"]),
          "creator_employee"=>$userdata['userid'],
          "creator_pos"=>"Vendor",
          "contract_id"=>$post['contract_id'],
          "wo_id"=>$post['wo_id'],
          "vendor_id"=>$post['vendor_id'],
          "created_date"=>date("Y-m-d H:i:s"),
          $mod."_notes"=>$post[$mod.'_notes'],
          "status"=>$activity_id,
          $mod."_total"=>$post['total_alokasi_inp'],
        );
      }
      //add additional data based on Module
      switch ($mod) {
        case 'do':
        $add_inputs = array(
          "sppm_id"=>$post['sppm_id'],
          "do_title"=>$post['do_title'],
        );
        break;
        case 'sj':
        $add_inputs= array(
          'si_id' =>$post['id'],
          //'transporter_id' =>$post['transporter_id'],
          'do_id'=>$post['do_id'],
          "no_mobil"=>$post['no_mobil'],
          "sj_total"=>$post['total_alokasi_inp'],
          "tgl_pembuatan_sj"=>$post['tgl_pembuatan_sj'],
          "tgl_pengiriman_sj"=>$post['tgl_pengiriman_sj'],
          "judul_sj"=>$post['sj_title'],
        );
        break;
        case 'bapb':
        $add_inputs= array(
          'sj_id' =>$post['id'],
          "tgl_pembuatan_bapb"=>$post['tgl_pembuatan_bapb'],
          "tgl_penerimaan_bapb"=>$post['tgl_penerimaan_bapb'],
          "bapb_title"=>$post['bapb_title'],
        );
        break;
        case 'inv':
        $add_inputs= array(
          'bapb_id' =>$post['id'],
          "tgl_inv"=>$post['tgl_inv'],
          "bank"=>$post['bank'],
          "no_rekening"=>$post['no_rekening'],
          "inv_notes"=>$post['inv_notes'],
        );
        break;
        default:
        // code...
        break;
      }
      $inputs=$inputs+$add_inputs;

      if($state==1){
        $this->Global_m->update_table("ctr_".$mod."_header",$inputs,$id);
        $new_id=$id;
      }elseif($state==0){

        if($mod!=='wo'){
          $this->Global_m->insert_table("ctr_".$mod."_header",$inputs);
          $new_id = $this->db->insert_id();
        }

        if($mod=='inv'){
          $this->db->where('bapb_id',$id);
          $this->db->update('ctr_bapb_header',array('inv_id'=>$new_id));
          //duplicate detail invoice
          $this->Contract_m->duplicate_item_bapb_to_inv($id,$new_id);
        }
      }else{
        $new_id=$id;
      }


      //details items submitted
      $items=isset($post['item'])?$post['item']:null;
      $total_item=0; // var for total items

      if($items){//check if there's item selected
        //begin foeach items
        $ref=$post["reff"]; //referensi action sebelum nya
        $add_items=array();

        if($mod!=='wo'){
          foreach ($items as $key => $value) {
            $qty = $post['qty_data'][$key];
            $max_qty = $post['qty_max'][$key];

            $dt=$this->Global_m->get_data("ctr_".$ref."_item",array($ref."_item_id"=>$key));
            $sub_total = (1+(($dt['ppn']+$dt['pph'])/100))*($dt['price']*$qty);
            $input_items = array(

              $mod."_id"=>$new_id,
              "item_code"=>$dt["item_code"],
              "short_description"=>$dt["short_description"],
              "long_description"=>$dt["long_description"],
              "price"=>$dt["price"],
              "qty"=>$qty,//perubahan hanya di sini
              //"qty_remain"=>$qty_remain-$qty,
              "uom"=>$dt["uom"],
              "sub_total"=>$sub_total,
              "ppn"=>$dt["ppn"],
              "pph"=>$dt["pph"],

            );

            switch ($mod) {
              case 'do':
              $add_items= array('sppm_id' => $post['sppm_id'] );
              break;
              case 'sj':
              $add_items= array('do_id' => $post['do_id'] );
              break;
              case 'bapb':
              $add_items= array('sj_id' => $post['id'] );
              break;
              case 'inv':
              $add_items= array('bapb_id' => $post['bapb_id'] );
              break;

              default:
              break;
            }
            $input_items+=$add_items;
            $total_item += $sub_total;

            if($qty>$max_qty){
              $this->setMessage("Quantity harus lebih kecil dari Max Value");
              $error=true;
            }

            if($state==1 || $state==3){
              $this->Global_m->update_table("ctr_".$mod."_item",$input_items,$new_id);
            }elseif($state==0){
              $this->Global_m->insert_table("ctr_".$mod."_item",$input_items);
            }
          }//end foeach items
        }

        $dh = array($mod.'_total' =>$total_item);
        $this->Global_m->update_table("ctr_".$mod."_header",$dh,$new_id);


      }else{
        switch ($mod) {
          case 'do':
          case 'sj':
          case 'bapb':
          //validasi Total WO dan Kontrak
          $this->setMessage("Tidak ada item yang dipilih");
          if(!$error){
            $error = true;
          }
          break;
          case 'wo':
          $total_wo=0;
          if($total_wo+$total_item > $contract_amount){
            $this->setMessage("Nilai WO Matgis tidak dapat melebih nilai kontrak");
            if(!$error){
              $error = true;
            }
          }
          break;

          default:
          // code...
          break;
        }
      }

      //attachment
      if($filename!==""){
        $file_data = array(
          $mod."_id"=>$new_id,
          'category'=>"File",
          'filename'=>$filename,
          'status'=>1,
          'description'=>'File '.$mod);
          $file_ex=$this->Global_m->get_data("ctr_".$mod."_doc",array($mod.'_id' => $new_id));
          //print_r($file_ex);die;
          if(isset($file_ex)){
            $this->Global_m->update_table("ctr_".$mod."_doc",$file_data,$new_id);
          }else{
            $this->Global_m->insert_table("ctr_".$mod."_doc",$file_data);
          }
        }

      }
      //End if Type Form view
      //complete comments
      $nextPosCode  = "";
      $nextPosName  = "";
      $lastPosCode  = "";
      $lastPosName  = "";
      $nextActivity = 0;
      $activity_ins=0;
      $pos_id       = 0;
      $pos_name     = "";
      $w_response=array("awr_id"=>$response);
      $response_text = $this->Global_m->get_data("adm_wkf_response", $w_response)["awr_name"];
      switch (strtoupper($response_text)) {
        case "VENDOR SETUJU PO":
        $activity_ins = 2037; //Pembuatan SKBDN
        $dta=$this->db->query('SELECT DISTINCT * FROM ctr_wo_comment WHERE wo_id='.$id.' AND cwo_activity=2031')->row_array();
        //echo $this->db->last_query();die;
        $pos_id=$dta['cwo_pos_code'];
        $pos_name=$dta['cwo_position'];
        //echo "data";
        //print_r($dta);die;
        break;
        case "VENDOR TOLAK PO":
        $activity_ins = 2034;
        $where=array('wo_id'=>$id,'cwo_activity'=>2031);
        $dta=$this->db->where($where)->get('ctr_wo_comment')->row_array();
        $pos_id=$dta['cwo_pos_code'];
        $pos_name=$dta['cwo_position'];
        break;
        case "SIMPAN SEBAGAI DRAFT DO": //response simpan draft DO
        $activity_ins = 2060;
        $pos_id=$userdata['userid'];
        $pos_name=$userdata['nama_vendor'];
        break;
        case "SIMPAN SEBAGAI DRAFT SJ": //response simpan draft SJ
        case "SIMPAN SEBAGAI DRAFT INVOICE": //response simpan draft Inv
        $activity_ins = $activity_first;
        break;

        case "SIMPAN DAN LANJUT DO": //response simpan lanjut DO
        $activity_ins= 2062;
        $pos_id=$userdata['userid'];
        $pos_name=$userdata['nama_vendor'];
        break;

        case "SIMPAN DAN LANJUT SJ": //response simpan lanjut SJ
        $activity_ins = 2072; //Pembuatan SKBDN
        $dta=$this->db->query('SELECT * FROM ctr_wo_comment WHERE wo_id='.$id.' AND cwo_activity=2037')->row_array();
        $pos_id=$dta['cwo_pos_code'];
        $pos_name=$dta['cwo_position'];
        break;

        case "SIMPAN DAN LANJUT INVOICE": //response simpan lanjut Inv
        $activity_ins = $activity_second;
        $dta=$this->db->query('SELECT * FROM ctr_wo_comment WHERE wo_id='.$wo_id.' AND cwo_activity=2037')->row_array();
        $pos_id=$dta['cwo_pos_code'];
        $pos_name=$dta['cwo_position'];
        break;

        case "SIMPAN DAN LANJUT BAPB": //response simpan lanjut Inv
        $dta=$this->db->query('SELECT * FROM ctr_wo_comment WHERE wo_id='.$wo_id.' AND cwo_activity=2037')->row_array();
        //echo $this->db->last_query();die;
        $pos_id=$dta['cwo_pos_code'];
        $pos_name=$dta['cwo_position'];
        $activity_ins = $activity_second;
        break;

        case "SIMPAN SEBAGAI DRAFT BAPB": //response simpan lanjut Inv
        $activity_ins = 2080;
        $dta=$this->db->query('SELECT * FROM ctr_wo_comment WHERE wo_id='.$wo_id.' AND cwo_activity=2037')->row_array();
        $pos_id=$dta['cwo_pos_code'];
        $pos_name=$dta['cwo_position'];

        break;

      }

      //Current Activity



      //echo $response_text;die;

      //die;
      if(!$error){
        if ($this->db->trans_status() === FALSE) {
          $this->setMessage("Gagal mengubah data");
          $this->db->trans_rollback();
        }
        else{
          $this->setMessage("Sukses mengubah data");
          $this->db->trans_commit();
        }
        $this->renderMessage("success",site_url("kontrak"));
      }else{
        $this->renderMessage("error");
      }

    } //End Function
  }
