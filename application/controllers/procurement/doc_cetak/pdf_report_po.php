<?php
$this->load->library('terbilang');
$view = "procurement/doc_cetak/pdf_report_po";

$this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));

$rfq_id = $id;

$tender = $this->Procrfq_m->getMonitorRFQ($rfq_id)->row_array();

$prData = $this->Procrfq_m->getPRData($tender['pr_number'])->row_array();
$prDataComent = $this->Procrfq_m->getPRDataComment($tender['pr_number'])->result_array();
$PlainDataComent = $this->Procrfq_m->getPLainComment($prData['ppm_id'])->result_array();
$TenderDataComent = $this->Procrfq_m->getTenderComment($rfq_id)->result_array();
$UserByDepartment = $this->Procrfq_m->getListEmployeByDepartment($tender['ptm_dept_id'])->result_array();


$data=array(
	'tender' => $tender,
);

//print_r($tender);

$this->load->view($view,$data);
//$this->template($view,"Generate PDF BAKP",$data);


$html = $this->output->get_output();
//$this->load->library('dompdf_gen');

// print_r($html);
// exit;

$dompdf= new Dompdf\Dompdf();
$dompdf->set_paper('a4');
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);   
$dompdf->set_option("isPhpEnabled", true);
$dompdf->load_html($html);
$dompdf->render();

//$this->load->view($view,$data);
/*
$html = $this->output->get_output();
$this->load->library('dompdf_gen');

$dompdf=new Dompdf\Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("BAKP-".date('YmdHis').'-'.$rfq_id.'.pdf');
*/
