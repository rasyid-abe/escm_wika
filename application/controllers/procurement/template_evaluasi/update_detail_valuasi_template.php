<?php

    $post = $this->input->post();
    $error = false;

    $userdata = $this->data['userdata'];
    $works_id = $this->session->userdata('works_id');
    $ptm_number = $this->session->userdata('rfq_id');


    $item['etd_item'] = $post['etd_item'];
    $item['etd_weight'] = $post['etd_weight'];

    $this->db->trans_begin();

    $data['results'] = $this->Procevaltemp_m->updateDataTemplateEvaluasiDetail($post['id'],$item);
  
    if ($this->db->trans_status() === FALSE) {
        $this->setMessage("Gagal menambah data");
        $this->db->trans_rollback();
       // $this->renderMessage("error");
       //$this->output->set_content_type('application/json')->set_output(json_encode($data));
    } else {
        $this->setMessage("Sukses menambah data");
        $this->db->trans_commit();
        //redirect(site_url("procurement/daftar_pekerjaan/proses_tender/".$works_id));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }