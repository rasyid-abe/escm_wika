<?php 

$data = array();
$vvh_id = $param3;

$data['vvh_id'] = $vvh_id;
$this->db->select('vvh_tipe');
$vvh_tipe = $this->Vendor_m->getVPIHeader("",$vvh_id)->row()->vvh_tipe;
$kompilasi_header = $this->Vendor_m->getVPIKompilasi($vvh_id)->row_array();
$data['kompilasi_header'] = $kompilasi_header;

$this->db->where('vk_id', $kompilasi_header['vk_id']);
$saved_kompilasi_score = $this->Vendor_m->getVPIKompilasiScore()->result_array();

$kompilasi_score = [];
foreach ($saved_kompilasi_score as $key => $value) {
  $kompilasi_score[$value['vks_parameter']] = $value['vks_id'];
}
$data['kompilasi_score'] = $kompilasi_score;


$this->db->select('b.vendor_name,b.contract_number,b.subject_work,b.contract_id,c.ptm_dept_id,c.ptm_dept_name,vvh_date,vvh_tipe');
$this->db->join('ctr_contract_header b', 'b.contract_id = vnd_vpi_header.vvh_contract_id');
$this->db->join('prc_tender_main c', 'c.ptm_number = b.ptm_number', 'left');
$data['vvh_data'] = $this->Vendor_m->getVPIHeader("",$vvh_id)->row_array();

	$date = $data['vvh_data']['vvh_date'];
 	$dateconverted=DateTime::createFromFormat('Ym', $date ); 
 	$data['vvh_data']['vvh_date_text']=$dateconverted->format('F Y'); 

if ($vvh_tipe == 'barang' OR $vvh_tipe == 'jasa') {

  $view = 'vendor/vpi/monitor_pekerjaan/penilaian_vpi_'.$vvh_tipe.'_v';
	include('penilaian_vpi_barang_jasa.php');

}elseif ($vvh_tipe == 'konsultan') {

	$view = 'vendor/vpi/monitor_pekerjaan/penilaian_vpi_konsultan_v';
  include('penilaian_vpi_konsultan.php');
  
}else{
	redirect();
}

$this->template($view,"Penilaian VPI ".ucfirst($vvh_tipe),$data);
?>