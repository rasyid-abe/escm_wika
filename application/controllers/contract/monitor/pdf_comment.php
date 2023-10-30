<?php

$contract_id = $this->uri->segment(3, 0);

$data['id'] = $contract_id;

$this->data['dir'] = CONTRACT_FOLDER;

$kontrak = $this->Contract_m->getData($contract_id)->row_array();

// comment
$this->db->where('cad_contract_id', $kontrak['contract_id']);
$komentar = $this->db->get('ctr_comment_all_div');

// count thumbs
$thumbs_up = $this->db->where('cad_contract_id', $kontrak['contract_id']);
$thumbs_up->where('cad_respon', 1);
$thumbs_up = $this->db->get('ctr_comment_all_div');
$data['thumbs_up'] = $thumbs_up->num_rows();

$thumbs_down = $this->db->where('cad_contract_id', $kontrak['contract_id']);
$thumbs_down->where('cad_respon', 2);
$thumbs_down = $this->db->get('ctr_comment_all_div');
$data['thumbs_down'] = $thumbs_down->num_rows();

$comment = $this->db->where('cad_contract_id', $kontrak['contract_id']);
$comment->where('cad_respon', 3);
$comment = $this->db->get('ctr_comment_all_div');
$data['comment'] = $comment->num_rows();

$data['komentar'] = $komentar->result_array();
$data['com_num'] = $komentar->num_rows();

$this->session->set_userdata("contract_id", $contract_id);
$view = 'contract/proses_kontrak/cetak_komentar_kontrak_v';
$this->load->view($view, $data);

$html = $this->output->get_output();
$html .= '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">';

$dompdf = new Dompdf\Dompdf();
$dompdf->set_paper('A4', 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$filename = "Comment-".date('YmdHis').'.pdf';
$output = $dompdf->output();
file_put_contents('uploads/' . $filename, $output);


$data_update = array(
    'filename' => $filename,
    'is_generate' => 1,
);

$name_doc = "BAKP";
$full_url = base_url() . "uploads/" . $filename;
redirect($full_url);
