<?php 

  $view = 'procurement/template_evaluasi/template_petunjuk_score_v';

  $data = array();

  $id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

  $this->db->where('etd_id', $id);
  $detail = $this->db->get('prc_evaluation_template_detail')->row_array();
  

  $data['id'] = $id;

  // $data['data'] = $this->Procevaltemp_m->getTemplateEvaluasi($id)->row_array();

  // $data['detail'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail($id)->result_array();

  $this->template($view,"Petunjuk Score Evaluasi '".$detail['etd_item']."'",$data);