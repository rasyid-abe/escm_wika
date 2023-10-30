<?php
$userdata = $this->data['userdata'];

$error = false;

$post = $this->input->post();

$input = array();

$this->db->trans_begin();

$input['cad_contract_id'] = $post['cad_contract_id_edit'];
$input['cad_ptm_number'] = $post['cad_ptm_number_edit'];
$input['cad_comment'] = $post['cad_comment_edit'];
$input['cad_user_id'] = $userdata['pos_id'];
$input['cad_position'] =  $userdata['pos_name'];
$input['cad_user_name'] =  $userdata['complete_name'];
$input['cad_created_date'] = date("Y-m-d H:i:s");
$input['cad_obj_nilai'] = $post['cad_obj_nilai_edit'];
$input['cad_lampiran'] = $post['cad_lampiran_edit'];
$input['cad_respon'] = $post['cad_respon_edit'];
$input['cad_no_telp'] = $post['cad_no_telp_edit'];
$input['cad_divisi'] = $userdata['dept_name'];

$this->db->where('id', $post['cad_id']);
$act = $this->db->update("ctr_comment_all_div", $input);

if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    $this->setMessage("Gagal mengubah data");
    $this->renderMessage("error");
} else {
    $this->db->trans_commit();
    $this->setMessage("Berhasil mengubah data");
    $this->renderMessage("success");
    redirect(site_url("contract/monitor/monitor_kontrak/lihat/" . $post['cad_contract_id_edit'] . "#form-comment"));
}