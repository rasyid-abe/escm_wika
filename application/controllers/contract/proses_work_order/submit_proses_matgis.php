<?php
$this->load->model("Procedure_matgis_m");
$error = false;
$activity_id="";
$activity_second="";
$activity_third="";
$activity_last="";
$activity_cancel="";
$post = $this->input->post();


switch ($mod) {

  case 'wo':
  $activity_id=2031; 	// Pembuatan Wo Matgis
  $activity_second=2032; 	// Persetujuan Wo Matgis
  $activity_third=2033; 	// WO Matgis Aktif
  $activity_last=2035; 		// WO Matgis Selesai
  $activity_cancel=2034; 	// Wo Matgis dibatalkan
  break;

  case 'si':
  $activity_id=2040; 	// Pembuatan SI Matgis
  $activity_last=2041; 		// SI Matgis Aktif
  $activity_cancel=2042; 	// Wo Matgis dibatalkan
  break;

  case 'sppm':
  $activity_id=2050; 	// Pembuatan SPPM Matgis
  $activity_last=2051; 		// SPPM Matgis Aktif
  $activity_cancel=2052; 	// SPPM Matgis dibatalkan
  break;

  case 'do':
  $activity_id=2060; 	// Pembuatan DO Matgis
  $activity_last=2061; 		// DO Matgis Aktif
  $activity_cancel=2062; 	// DO Matgis dibatalkan
  break;

  case 'sj':
  $activity_id=2070; 	// Pembuatan SJ Matgis
  $activity_last=2071; 		// SJ Matgis Aktif
  $activity_cancel=2072; 	// SJ Matgis dibatalkan
  break;

  case 'bapb':
  $activity_id=2080; 	// Pembuatan BAPB Matgis
  $activity_last=2081; 		// BAPB Matgis Aktif
  $activity_cancel=2082; 	// BAPB Matgis dibatalkan
  break;

  case 'invoice':
  $activity_id=2090; 	// Pembuatan Inv Matgis
  $activity_last=2091; 		// Inv Matgis Aktif
  $activity_cancel=2092; 	// Inv Matgis dibatalkan
  break;

  default:
  break;
}


$wo_id = $post['wo_id'];
$filename=(!empty($post['filename'])) ? $post['filename'] : "";
$last_comment = array();
$userdata = $this->Administration_m->getLogin();

if(!empty($id)){
  $last_comment = $this->Comment_m->getWOMatgis("",$id)->row_array();
}

//$wo_id = (!empty($last_comment['wo_id'])) ? $last_comment['wo_id'] : $post['wo_id'];


$contract_id = (!empty($last_comment['contract_id'])) ? $last_comment['contract_id'] : $post['contract_id'];

$contract = $this->Contract_m->getData($contract_id)->row_array();

$contract_doc = $this->Contract_m->getDoc("", $contract_id)->row_array();

$contract_amount = $contract['contract_amount'];

$comment_id = (!empty($last_comment['comment_id'])) ? $last_comment['comment_id'] : "";

//$this->form_validation->set_rules("scope_work_inp", "Deskripsi WO Matgis", 'required');

$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : $activity_id;

$totalwo = $this->db->select("COALESCE(SUM(sub_total),0) as total")->where("contract_id",$contract_id)->where("approved_date !=",null)
->join("ctr_wo_header a","a.wo_id=b.wo_id")->get("ctr_wo_item b")->row()->total;

$input = array();

$input_item = array();

$total_item = 0;

if($last_activity == $activity_id){

  if(isset($post['item'])){

    foreach ($post['item'] as $key => $value) {

      $qty = $post['qty_wo'][$key];
      $item = $this->db->where("contract_item_id",$key)->get("ctr_contract_item")->row_array();

      if($item['min_qty'] > $qty || $item['max_qty'] < $qty){

        $this->setMessage("Jumlah harus diantara minimum dan maksimum");

        if(!$error){
          $error = true;
        }

      } else {

        $sub_total = (1+(($item['ppn']+$item['pph'])/100))*($item['price']*$qty);

        $input_item[] = array(
          "contract_item_id"=>$key,
          "item_code"=>$item['item_code'],
          "short_description"=>$item['short_description'],
          "long_description"=>$item['long_description'],
          "price"=>$item['price'],
          "qty"=>$qty,
          "uom"=>$item['uom'],
          "sub_total"=>$sub_total,
          "ppn"=>$item['ppn'],
          "pph"=>$item['pph']
        );

        $total_item += $sub_total;

      }

    }

  } else {

    $this->setMessage("Tidak ada item yang dipilih");
    if(!$error){
      $error = true;
    }

  }

  if($totalwo+$total_item > $contract_amount){
    $this->setMessage("Nilai WO Matgis tidak dapat melebih nilai kontrak");
    if(!$error){
      $error = true;
    }
  }

}

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  //$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

//echo "error:".$error;die;

if ($error){

  $this->renderMessage("error");


} else {

  $this->db->trans_begin();

  if(!empty($wo_id)){

    if($last_activity == $activity_id){

      $input = array(
        "start_date"=>$post['tgl_mulai_inp'],
        "end_date"=>$post['tgl_akhir_inp'],
        "wo_notes"=>$post['scope_work_inp'],
      );

      $act = $this->Contract_m->updateWODataMatgis($wo_id,$input);
    }

  } else {

    $ptm = $this->db
    ->where("contract_id",$contract_id)
    ->join("prc_tender_main a","a.ptm_number=b.ptm_number")
    ->get("ctr_contract_header b")->row_array();

    //$po_number = $this->Contract_m->getUrutWOMatgis();
    $wo_number=(!empty($post['wo_number'])) ? $post['wo_number'] : "";
    $skbdn_no=(!empty($post['skbdn_no'])) ? $post['skbdn_no'] : "";
    $skbdn_penerbit=(!empty($post['skbdn_penerbit'])) ? $post['skbdn_penerbit'] : "";
    $skbdn_tanggal_terbit=(!empty($post['skbdn_tanggal_terbit'])) ? $post['skbdn_tanggal_terbit'] : "";

    $input = array(
      "wo_number"=>$wo_number,
      "creator_employee"=>$userdata['id'],
      "creator_pos"=>$userdata['pos_name'],
      "contract_id"=>$contract['contract_id'],
      "vendor_id"=>$contract['vendor_id'],
      "vendor_name"=>$contract['vendor_name'],
      "currency"=>$contract['currency'],
      "start_date"=>$post['tgl_mulai_inp'],
      "end_date"=>$post['tgl_akhir_inp'],
      "created_date"=>date("Y-m-d H:i:s"),
      "wo_notes"=>$post['scope_work_inp'],
      "status"=>$activity_id,
      "ctr_amount"=>$contract['contract_amount'],
      "ctr_doc"=>$contract_doc['filename'],
      "ctr_skbdn_no"=>$skbdn_no,
      "ctr_skbdn_penerbit"=>$skbdn_penerbit,
      "ctr_skbdn_tanggal_terbit"=>$skbdn_tanggal_terbit
    );

    $act = $this->Contract_m->insertWODataMatgis($input);
    $wo_id = $this->db->insert_id();

    if($filename!==""){
      $data = array(
        'wo_id' =>$wo_id,
        'category'=>"skbdn",
        'filename'=>$filename,
        'status'=>1,
        'description'=>'upload skbdn' );
        $this->Contract_m->save_doc_matgis($data);
      }
      $comment_id = $this->db->insert_id();
    }

    if(!empty($input_item)){
      $deleted = array();
      foreach ($input_item as $key => $value) {
        $value['wo_id'] = $wo_id;
        if(!empty($id)){
          $act = $this->db->where(array("wo_id"=>$wo_id,"contract_item_id"=>$value['contract_item_id']))
          ->update("ctr_wo_item",$value);
        } else {
          $this->Contract_m->insertWOItemMatgis($value);
        }
        if($act){
          $deleted[] = $act;
        }
      }

    }
    //echo $this->db->last_query();die;

    $response = $post['status_inp'][0];
    $comment  = $post['comment_inp'][0];

    //Insert ctr_wo_comment

    $comment_id = $this->db->insert_id();
    $return = $this->Procedure_matgis_m->ctr_comment_complete(
    "wo",
    $wo_id,
    $last_activity,
    $response,
    $comment,"",
    $comment_id,
    $contract_id,$userdata);

    if(!$error){
      if ($this->db->trans_status() === FALSE)
      {
        $this->setMessage("Gagal mengubah data");
        $this->db->trans_rollback();
      }
      else
      {
        $this->setMessage("Sukses mengubah data");
        $this->db->trans_commit();
      }

      $this->renderMessage("success",site_url("contract/work_order_matgis/daftar_pekerjaan_matgis"));
    } else {
      $this->renderMessage("error");
    }
  }
