<?php
$this->load->library('terbilang');
$view = "laporan/pdf_report_vpi_v.php";
$data = array();
$year = 0;
$param = $_GET;
if (isset($param['year'])) {
    $year = $param['year'];
}

$getYear = $this->db->get('vw_year_list');

$data = array();
$data['year'] = $getYear->result_array();

$data['data_vendor'] = [];
$data['data_proyek'] = [];
$data['data_divisi'] = [];

$this->db->where('vpi_year', $year);

$data_vendor = $this->db->get('vw_report_vpi_score_vendor')->result_array();
$data_proyek = $this->db->get('vw_report_vpi_score_proyek')->result_array();
$data_divisi = $this->db->get('vw_report_vpi_score_dept')->result_array();

$data['data_vendor'] = $data_vendor;
$data['data_proyek'] = $data_proyek;
$data['data_divisi'] = $data_divisi;
$data['year'] = $year;
$this->load->view($view, $data);

$html = $this->output->get_output();

// print_r($html);
// exit;
$dompdf = new Dompdf\Dompdf();
$dompdf->set_paper('a4');
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->set_option("isPhpEnabled", true);
$dompdf->load_html($html);
$dompdf->render();
$filename = "REPORT-VPI-" .  $year . '.pdf';
$output = $dompdf->output();
file_put_contents('uploads/' . $filename, $output);

$data_update = array(
    'filename' => $filename,
    'is_generate' => 1,
);

$full_url = base_url() . "uploads/" . $filename;
redirect($full_url);
exit;
