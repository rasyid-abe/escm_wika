<?php 

$post = $this->input->post();

$userdata = $this->data['userdata'];

$check = $this->db->where("ppm_id",$post['id'])->get("prc_eauction_header")->row_array();

$prc = $this->db->where("ptm_currency",$post['id'])->get("prc_tender_main")->row_array();

$bid_minutes = 10;

$inp = array(
    "hps"=>$post['total_alokasi_inp'],
    "batas_atas"=>moneytoint($post['b_atas_eauction_money_inp'])+0,
    "batas_bawah"=>moneytoint($post['b_bawah_eauction_money_inp'])+0,
    "created_by"=>$userdata['employee_id'],
    "created_date"=>date("Y-m-d H:i:s"),
    "deskripsi"=>$post['deskripsi_eauction_inp'],
    "judul"=>$post['judul_eauction_inp'],
    "minimal_penurunan"=>moneytoint($post['penurunan_eauction_inp']),
    "status"=>0,
    "tanggal_berakhir"=>$post['tgl_selesai_eauction_inp'],
    "tanggal_mulai"=>$post['tgl_mulai_eauction_inp'],
    "tipe"=>$post['tipe_eauction_inp'],
    "waktu_detik"=>$post['tipe_eauction_inp'],
    "curr_id"=>$prc['ptm_currency'],
    "batas_atas_percent"=>moneytoint($post['b_atas_eauction_percent_inp'])+0,
    "batas_bawah_percent"=>moneytoint($post['b_bawah_eauction_percent_inp'])+0,
    "max_bid_per_minute"=>$bid_minutes,
    );

if(!empty($check)){
    $act = $this->db->where("ppm_id",$post['id'])->update("prc_eauction_header",$inp);
} else {
    $inp['ppm_id'] = $post['id'];
    $act = $this->db->insert("prc_eauction_header",$inp);
}

if($act){

    if(isset($post['reset_inp'])){
        $this->db->where("ppm_id",$post['id'])->delete("prc_eauction_history");
        $this->db->where("ppm_id",$post['id'])->delete("prc_eauction_history_item");
    }

    $this->db->where("ppm_id",$post['id'])->delete("prc_eauction_vendor");
    $this->db->where("ppm_id",$post['id'])->delete("prc_eauction_item");

    $vendor = $this->db->where("ptm_number",$post['id'])->get("prc_tender_vendor_status")->result_array();

    foreach ($vendor as $key => $value) {
     $inp = array(
        "bid_in_minutes"=>$bid_minutes,
        "vendor_id"=>$value['pvs_vendor_code'],
        "ppm_id"=>$post['id']
        );
     $this->db->insert("prc_eauction_vendor",$inp);
 }

 foreach ($post['harga_penurunan'] as $key => $value) {
    $inp = array(
        "tit_id"=>$key,
        "value_min"=>moneytoint($value),
        "ppm_id"=>$post['id']
        );
    $this->db->insert("prc_eauction_item",$inp);
}
$this->setMessage("Sukses mengubah data");
$this->renderMessage("success",site_url("procurement/procurement_tools/e_auction"));
} else {
  $this->renderMessage("error");
}