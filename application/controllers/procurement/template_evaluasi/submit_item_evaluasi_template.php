<?php
$post = $this->input->post();

$input = array();
$postdetail = array();
$prep = array();
$evt_id = NULL;
$error = false;

$userdata = $this->data['userdata'];
$works_id = $this->session->userdata('works_id');
$ptm_number = $this->session->userdata('rfq_id');

$input['evt_type'] = $post['evt_type'];

if ($post['etd_mode'] == 1) { //jika teknis
    $input['evt_tech_weight']   = moneytoint($post['evt_value']);
    $input['evt_passing_grade'] =  moneytoint($post['evt_passing_grade']);
    $input['evt_price_weight']  = (int)100 - (int)$input['evt_tech_weight'];
} else {
    $input['evt_tech_weight']   = moneytoint($post['evt_value']);
}

$this->db->trans_begin();

if(empty($post['evt_id']) || $post['evt_id'] ==""){ //Jika kosong maka insert
    $act = $this->Procevaltemp_m->insertDataTemplateEvaluasi($input);
    $postdetail['evt_id'] = $this->db->insert_id();
    $prep['evt_id'] = $postdetail['evt_id'];
    $evt_id = $postdetail['evt_id'];

    //Update EVT_ID to RFQ
    $this->Procrfq_m->updatePrepRFQ($ptm_number, $prep);

} else { // jika ada maka update

    $evt_id = $post['evt_id'];
    $this->Procevaltemp_m->updateDataTemplateEvaluasi($post['evt_id'], $input);

    $data['valtemp'] = $this->Procevaltemp_m->getTemplateEvaluasi($post['evt_id'])->row_array();
}

$postdetail['evt_id'] = $evt_id;
$postdetail['etd_item'] = $post['etd_item'];
$postdetail['etd_weight'] = $post['etd_weight'];
$postdetail['etd_mode'] = $post['etd_mode'];
$postdetail['rfq_no'] = $post['evt_rfq_no'];


$evt_details = $this->Procevaltemp_m->insertDataTemplateEvaluasiDetail($postdetail);

if($evt_details){
    $etd_id = $this->db->insert_id();
    $item['detail_evaluasi_id'] = $etd_id;

    foreach ($post['bobot'] as $key => $bobot) {
        $item['bobot'] = $bobot;
        $item['deskripsi'] = $post['deskripsi'][$key];
        $evt_item = $this->Procevaltemp_m->insertDataTemplateItemEvaluasi($item);
    }
}

// $where_admin = array('evt_id' => $data['prep']['evt_id'], 'etd_mode' => '0');
//
// $data['detail2'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail2($where_admin)->result_array();

$response = [];

if ($this->db->trans_status() === FALSE)
{
    $response['msg'] = "Gagal menambah data!";
    $response['sts'] = false;
    $response['evt_id'] = $evt_id;

    $this->db->trans_rollback();
    $this->renderMessage("error");
}
else
{
    $response['msg'] = "Sukses menambah data!";
    $response['sts'] = true;
    $response['evt_id'] = $evt_id;
    $this->db->trans_commit();
}

echo json_encode($response);
