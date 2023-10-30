<?php

$post = $this->input->post();

//$post['evt_id'] = 69;
//$post['rfq'] = "RFQ.202212.00159";

if($post['evt_id'] == 0)
{

    //prc_evaluation_template
    $dataEvt['evt_type'] = 0;
    $dataEvt['evt_name'] = "DEFAULT_TEMPLATE_".$post['rfq'];
    $dataEvt['evt_passing_grade'] = 70;
    $dataEvt['evt_tech_weight'] = 40;
    $dataEvt['evt_price_weight'] = 60;

    $this->db->where('evt_name',$dataEvt['evt_name']);
    $get = $this->db->get("prc_evaluation_template")->row_array();

    if($get == null)
    {
        $this->Procevaltemp_m->insertDataTemplateEvaluasi($dataEvt);
        $post['evt_id'] = $this->db->insert_id();
    } else
    {
        $post['evt_id'] = $get['evt_id'];
    }
}


$where_teknis = array('evt_id' => $post['evt_id'], 'etd_mode' => '1');
$data['detail_teknis'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail2($where_teknis)->result_array();

$eva_tek = [];
$et_cache = $data['detail_teknis'];
foreach ($et_cache as $k => $v) {
    $kritek = $this->Procevaltemp_m->getTemplateEvaluasiItem($v['etd_id'])->result_array();
    $eva_tek[] = array_merge($et_cache[$k], ['kriteria' => $kritek]);
}


$where_admin = array('evt_id' => $post['evt_id'], 'etd_mode' => '0');
$data['detail'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail2($where_admin)->result_array();
$eva_adm = [];
$ea_cache = $data['detail'];

foreach ($ea_cache as $k => $v) {
    $kriadm = $this->Procevaltemp_m->getTemplateEvaluasiItem($v['etd_id'])->result_array();
    $eva_adm[] = array_merge($ea_cache[$k], ['kriteria' => $kriadm]);
}



if(count($eva_adm) == 0)
{
    if ($post['evt_id'] > 0) {
        $itemTeknisAdm['evt_id'] = $post['evt_id'];
        $itemTeknisAdm['etd_item'] = "Surat Penawaran yang ditanda tangani direksi";
        $itemTeknisAdm['etd_weight'] = 0;
        $itemTeknisAdm['etd_mode'] = 0;
        $itemTeknisAdm['rfq_no'] = $post['rfq'];
        $this->Procevaltemp_m->insertDataTemplateEvaluasiDetail($itemTeknisAdm);

        $itemTeknisAdm['evt_id'] = $post['evt_id'];
        $itemTeknisAdm['etd_item'] = "Surat pernyataan kesanggupan dan tanggung jawab mutlak";
        $itemTeknisAdm['etd_weight'] = 0;
        $itemTeknisAdm['etd_mode'] = 0;
        $itemTeknisAdm['rfq_no'] = $post['rfq'];
        $this->Procevaltemp_m->insertDataTemplateEvaluasiDetail($itemTeknisAdm);

        // $itemTeknisAdm['evt_id'] = $post['evt_id'];
        // $itemTeknisAdm['etd_item'] = "Hasil penilaian ID SCORE minimal 570 atau D3";
        // $itemTeknisAdm['etd_weight'] = 0;
        // $itemTeknisAdm['etd_mode'] = 0;
        // $itemTeknisAdm['rfq_no'] = $post['rfq'];
        // $this->Procevaltemp_m->insertDataTemplateEvaluasiDetail($itemTeknisAdm);


        $where_admin = array('evt_id' => $post['evt_id'], 'etd_mode' => '0');
        $data['detail'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail2($where_admin)->result_array();
        $ea_cache = $data['detail'];

        foreach ($ea_cache as $k => $v) {
            $kriadm = $this->Procevaltemp_m->getTemplateEvaluasiItem($v['etd_id'])->result_array();
            $eva_adm[] = array_merge($ea_cache[$k], ['kriteria' => $kriadm]);
        }
    }


}

if(count($eva_tek) == 0)
{
    //set default tech detail
    $where_teknis = array('tech_is_parent' => 1);
    $defaultTeknis = $this->Procevaltemp_m->getTemplateEvaluasiDetailDefault($where_teknis)->result_array();
   
    if ($post['evt_id'] > 0) {

    foreach ($defaultTeknis as $key => $value) {
        # code... item teknis
        $itemTeknis['evt_id'] = $post['evt_id'];
        $itemTeknis['etd_item'] = $value['tech_detail_name'];
        $itemTeknis['etd_weight'] = $value['tech_bobot'];
        $itemTeknis['etd_mode'] = 1;
        $itemTeknis['rfq_no'] = $post['rfq'];

        $insertTeknis = $this->Procevaltemp_m->insertDataTemplateEvaluasiDetail($itemTeknis);
        $etdId = $this->db->insert_id();

        $where_teknis = array('parent_id' => $value['id']);
        $defaultKriteriaTeknis = $this->Procevaltemp_m->getTemplateEvaluasiDetailDefault($where_teknis)->result_array();
        foreach ($defaultKriteriaTeknis as $k => $v) {
            # code kriteria teknis
            $itemKriteria['bobot'] = $v['tech_bobot'];
            $itemKriteria['deskripsi'] = $v['tech_detail_name'];
            $itemKriteria['detail_evaluasi_id'] = $etdId;
            $this->Procevaltemp_m->insertDataTemplateItemEvaluasi($itemKriteria);
            
        }
    }

    $where_teknis = array('evt_id' => $post['evt_id'], 'etd_mode' => '1');
    $data['detail_teknis'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail2($where_teknis)->result_array();

    $et_cache = $data['detail_teknis'];
    foreach ($et_cache as $k => $v) {
        $kritek = $this->Procevaltemp_m->getTemplateEvaluasiItem($v['etd_id'])->result_array();
        $eva_tek[] = array_merge($et_cache[$k], ['kriteria' => $kritek]);
    }
    
    }
}


$response = [
    'administrasi' => $eva_adm,
    'teknis' => $eva_tek,
    'data' => ['evt_tech_weight' => 0],
    'evt_id' => $post['evt_id']
];

if ($post['evt_id'] > 0) {

    $response = [
        'administrasi' => $eva_adm,
        'teknis' => $eva_tek,
        'data' => $this->Procevaltemp_m->getTemplateEvaluasi($post['evt_id'])->row_array(),
        'evt_id' => $post['evt_id']
    ];

}


echo json_encode($response);
