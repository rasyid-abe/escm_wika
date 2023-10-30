<?php

$post = $this->input->post();
$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(3, 0);
$type = (isset($post['type'])) ? $post['type'] : $this->uri->segment(4, 0);

$userdata = $this->data['userdata'];
$works_id = $this->session->userdata('works_id');
$ptm_number = $this->session->userdata('rfq_id');

$this->db->trans_begin();

if(!empty($type)){
    $data['results'] = $this->Procevaltemp_m->deleteTemplateEvaluasiDetail($id);
} else {
    $data['results'] = $this->Procevaltemp_m->deleteTemplateEvaluasiItem($id);
}

$res = [];
if ($this->db->trans_status() === FALSE)
{
    $res['msg'] = "Gagal menghapus data";
    $res['sts'] = false;
    $this->db->trans_rollback();
    $this->renderMessage("error");
}
else
{
    $res['msg'] = "Sukses menghapus data";
    $res['sts'] = true;
    $this->db->trans_commit();
}
echo json_encode($res);
