<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends Telescoope_Controller {

  var $data;

  public function __construct(){

      // Call the Model constructor
   parent::__construct();

   $this->load->model(array("Administration_m","Comment_m", "M_global","Vendor_m","Laporan_m","Procrfq_m","Procplan_m"));

   $this->data['date_format'] = "h:i A | d M Y";

   $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

   $this->data['data'] = array();

   $this->data['post'] = $this->input->post();

   $userdata = $this->Administration_m->getLogin();

   $this->data['dir'] = 'contract';

   $this->data['controller_name'] = $this->uri->segment(1);

   $dir = './uploads/'.$this->data['dir'];

   $this->session->set_userdata("module",$this->data['dir']);

   if (!file_exists($dir)){
    mkdir($dir, 0777, true);
  }

  $config['allowed_types'] = '*';
  $config['overwrite'] = false;
  $config['max_size'] = 3064;
  $config['upload_path'] = $dir;
  $this->load->library('upload', $config);

  $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

  $selection = array(
    "laporan"
    );
  foreach ($selection as $key => $value) {
    $this->data[$value] = $this->session->userdata($value);
  }

  if(empty($userdata)){
   redirect(site_url('log/in'));
 }

}

public function index(){
  redirect(base_url());
  // include("laporan/laporan.php");
}

// VPI


public function report_vpi(){
  include("laporan/report_vpi.php");
}
public function report_vpi_print(){
  include("laporan/report_vpi_print.php");
}

public function lap_permintaan_pengadaan(){
  include("laporan/lap_permintaan_pengadaan.php");
}

public function lap_daftar_kontrak(){
  include("laporan/lap_daftar_kontrak.php");
}

public function lap_proc_value(){
  include("laporan/lap_proc_value.php");
}

public function lap_perm_cabang(){
  include("laporan/lap_perm_cabang.php");
}

public function monitor_distribusi_inv(){
  include("laporan/monitor_distribusi_inv.php");
}

public function tambah_distribusi_inv(){
  include("laporan/laporan.php");
}

public function monitor_permintaan_inv(){
  include("laporan/monitor_permintaan_inv.php");
}

public function tambah_permintaan_inv(){
  include("laporan/laporan.php");
}

public function stock_opname(){
  include("laporan/stock_opname.php");
}

public function tambah_stock_opname(){
  include("laporan/form_stock_opname.php");
}

public function semua_inv(){
  include("laporan/laporan.php");
}

public function laporan(){
  include("laporan/laporan.php");
}

public function ubah_status(){
  include("laporan/ubah_status.php");
}

public function ubah_batas(){
  include("laporan/ubah_batas.php");
}

public function detail(){
  include("laporan/detail.php");
}
public function penyesuaian(){
  include("laporan/penyesuaian.php");
}

public function picker_inv(){
  include("laporan/laporan.php");
}

public function picker_item_inv(){
  include("laporan/picker_item_inv.php");
}

public function picker_item_gudang_inv(){
  include("laporan/picker_item_gudang_inv.php");
}
// taufik
public function lap_kls_vnd($param = ""){
  include("laporan/lap_kls_vnd.php");
}

public function data_lap_kls_vnd(){
  include("laporan/data_lap_kls_vnd.php");
}
public function data_lap_klasifikasi_vendor(){
  include("laporan/data_lap_klasifikasi_vendor.php");
}

public function laporan_pdf_klasifikasi_vendor(){
  include("laporan/laporan_pdf_klasifikasi_vendor.php");
}
public function laporan_excel_klasifikasi_vendor(){
  include("laporan/laporan_excel_klasifikasi_vendor.php");
}
///////////////////////hlmifzi //////////////////////////
public function monitor_vendor(){
  $this->session->unset_userdata("tgl_awal");
  $this->session->unset_userdata("tgl_akhir");
  $this->session->unset_userdata("vendor_name");
  include("laporan/monitor_vendor/daftar_vendor.php");
}
public function data_monior_vendor_laporan(){
  include("laporan/monitor_vendor/data_daftar_seluruh_vendor.php");
}

public function laporan_excel_vendor_status(){
  include("laporan/monitor_vendor/excel_laporan_vendor_status.php");
}

public function laporan_pdf_stat_vend(){
  include("laporan/monitor_vendor/pdf_laporan_vendor_status.php");
}
/////////////////////////////////////////////////////////
public function monitor_dokumen_vendor($expired =""){
  include("laporan/monitor_dokumen_vendor/daftar_monitor_dokumen_vendor.php");
}
public function data_monitor_dokumen_vendor_laporan($expired =""){
  include("laporan/monitor_dokumen_vendor/data_monitor_dokumen_vendor_laporan.php");
}

public function laporan_excel_vend_dokumen(){
  include("laporan/monitor_dokumen_vendor/excel_laporan_dokumen_vendor.php");
}

public function laporan_pdf_vendor_dokumen(){
  include("laporan/monitor_dokumen_vendor/pdf_laporan_dokumen_vendor.php");
}


public function clear_session_monitor_vendor(){
  $this->session->unset_userdata("tgl_awal");
  $this->session->unset_userdata("tgl_akhir");
  $this->session->unset_userdata("vendor_name");
}

//////////////////////hlmifaiz///////////////////////////

//=======================================================================
public function report_progres($data){
  switch ($data) {
    case "lap_daftar_rfq":
    include("laporan/lap_daftar_rfq.php");
    break;

    case "lap_daftar_kontrak":
    include("laporan/lap_daftar_kontrak.php");
    break;

    case "lap_permintaan_pengadaan":
    include("laporan/lap_permintaan_pengadaan.php");
    break;

    default:
    echo "No Such Item";
  }
}

public function rekap_analisa($data,$param1=""){
  switch($data){
    case "report_statistik_vendor":
    include("laporan/report_statistik_vendor.php");
    break;

    case "report_kinerja_vendor":
    include("laporan/report_kinerja_vendor.php");
    break;

    case "lap_proc_value":
    include("laporan/lap_proc_value.php");
    break;

    case "lap_realisasi":
    include("laporan/lap_realisasi.php");
    break;

    case "klasifikasi_vendor":
    $this->lap_kls_vnd($param = "");
    // include("laporan/data_kls_vnd.php");
    break;

    case "report_jumlah_belanja":
    include("laporan/report_jumlah_belanja.php");
    break;

    case "report_proses_pengadaan":
    include("laporan/report_proses_pengadaan.php");
    break;

    case "report_durasi_proses":
    include("laporan/report_durasi_proses.php");
    break;

    case "report_statistik_contract":
    include("laporan/report_statistik_contract.php");
    break;

    case "laporan_history":
    include("laporan/laporan_history.php");
    break;

    case "laporan_history":
    include("laporan/laporan_history.php");
    break;

    case "laporan_klasifikasi_vendor":
    include("laporan/lap_klasifikasi_vendor.php");
    break;

    case "laporan_kebutuhan_pmcs":
    include("laporan/lap_kebutuhan_pmcs.php");
    break;

    case "detail_laporan_kebutuhan_pmcs":
    include("laporan/detail_lap_kebutuhan_pmcs.php");
    break;

    case "export_laporan_kebutuhan_pmcs":
    include("laporan/export_lap_kebutuhan_pmcs.php");
    break;

    case "lap_plan":
    $this->lap_plan();
    break;

    case "lap_tender":
    $this->lap_tender();
    break;

    case "lap_rari":
    $this->lap_rari();
    break;

    case "laporan_survey":
    $this->laporan_survey();
    break;

    case 'monitor_vendor':
    $this->monitor_vendor();
    break;

    case 'monitor_dokumen_vendor':
    $this->monitor_dokumen_vendor();
    break;

    echo "No Such Item";
    break;
  }

}

public function data_report_statistik_contract(){
  include('laporan/data_report_statistik_contract.php');
}

public function report_statistik_contract_detail($kode){
  include('laporan/report_statistik_contract_detail.php');
}

public function data_report_statistik_contract_detail($kode){
  include('laporan/data_report_statistik_contract_detail.php');
}

//hlmifzi
public function data_table_statistik_vendor($tipe){
  include("laporan/data_table_statistik_vendor.php");
}

public function data_table_kinerja_vendor(){
  include("laporan/data_table_kinerja_vendor.php");
}

public function data_table_jumlah_belanja(){
  include("laporan/data_table_jumlah_belanja.php");
}

public function data_table_ss_report_proses_pengadaan(){
  include("laporan/data_table_ss_report_proses_pengadaan.php");
}


public function data_table_ss_lap_proc_value(){
  include("laporan/data_table_lap_proc_value.php");
}

//=========Efisiensi
public function data_efisiensi_rekap(){
  include("laporan/data_efisiensi_rekap.php");
}

public function data_efisiensi_detail(){
  include("laporan/data_efisiensi_detail.php");
}

public function data_realisasi_rekap(){
  include("laporan/data_efisiensi_rekap.php");
}

public function data_realisasi_detail(){
  include("laporan/data_efisiensi_detail.php");
}

public function data_durasi_rekap(){
  include("laporan/data_durasi_rekap.php");
}

public function data_durasi_detail(){
  include("laporan/data_durasi_detail.php");
}



public function olahDataRekapEfisiensi($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){



  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(total_contract)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(jumlah)::text",$search);
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getEfisiensiRekap()->result_array();

  $data['data'] = '<p ><h3><b>Laporan Efisiensi</b></h3></p>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $thead = ($column['metode']) ? '<th style="width: 19%;">Metode Pengadaan</th>' : '' ;
  $thead .= ($column['jumlah']) ?'<th style="width: 10%;">Jumlah</th>' : '' ;
  $thead .= ($column['hps']) ? '<th style="width: 19%;">HPS</th>' : '' ;
  $thead .= ($column['total_contract']) ?'<th style="width: 19%;">Nilai Terkontrak</th>' : '' ;
  $thead .= ($column['efisiensi']) ? '<th style="width: 19%;">Efisiensi</th>' : '' ;
  $thead .= ($column['efisiensi_percent']) ? '<th style="width: 19%;">Persentase Efisiensi</th>' : '' ;


  $data['data'] .= '<table border="1px" style:"width:100%;" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['metode']) ?'<td style="width: 19%;">'.$value['metode'].'</td>' : '' ;
    $tbody .= ($column['jumlah']) ? '<td style="width: 10%;">'.$value['jumlah'].'</td>' : '' ;
    $tbody .= ($column['hps']) ? '<td style="width: 19%;">'.inttomoney($value['hps']).'</td>' : '' ;
    $tbody .= ($column['total_contract']) ?'<td style="width: 19%;">'.inttomoney($value['total_contract']).'</td>' : '' ;
    $tbody .= ($column['efisiensi']) ?'<td style="width: 19%;">'.inttomoney($value['efisiensi']).'</td>' : '' ;
    $tbody .= ($column['efisiensi_percent']) ?'<td style="width: 19%;">'.$this->truncate_number($value['efisiensi_percent'],2).'%</td>' : '' ;
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="2"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'RekapEfisiensi.pdf';

  $data['nameExcel'] = 'RekapEfisiensi.xls';

  return $data;
}


public function olahDataDetailEfisiensi($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(tanggal_penunjukan)::text",$search);
    $this->db->or_like("LOWER(ptm_dept_name)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ppm_project_name)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(contract_amount)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $this->db->where('ppi_is_sap', 1);
  $userdata = $this->data['userdata'];
  if ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'DIVISI SUPPLY CHAIN MANAGEMENT' && $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' OR preg_match('/(DIREKTUR)/i', $userdata['job_title'])) {

      $this->db->where('ptm_dept_name', $userdata['dept_name']);

  }
  $rekap = $this->Laporan_m->getEfisiensiDetail()->result_array();

  // var_dump($this->db->last_query());
  // die();
  $data['data'] = '<p ><h3><b>Laporan Efisiensi Detail</b></h3></p>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $thead = ($column['ppm_project_name']) ? '<th style="width: 10%;">Nama Proyek</th>' : '';
  $thead .= ($column['ppm_type_of_plan']) ? '<th style="width: 10%;">Jenis Pengadaan</th>' : '';
  $thead .= ($column['ppm_subject_of_work']) ? '<th style="width: 10%;">Nama Rencana Pekerjaan</th>' : '';
  $thead .= ($column['pr_packet']) ? '<th style="width: 10%;">Nama Paket</th>' : '';
  $thead .= ($column['ptm_dept_name']) ? '<th style="width: 7%;">Dept.</th>' : '';
  $thead .= ($column['hps']) ? '<th style="width: 13%;">HPS</th>' : '';
  $thead .= ($column['contract_amount']) ? '<th style="width: 13%;">Nilai Terkontrak</th>' : '';
  $thead .= ($column['efisiensi']) ? '<th style="width: 13%;">Efisiensi</th>' : '';
  $thead .= ($column['efisiensi_percent']) ? '<th style="width: 7%;">Persentase Efisiensi</th>' : '';
  $thead .= ($column['tanggal_penunjukan']) ? '<th style="width: 7%;">Tanggal Penetapan Pemenang</th>' : '';

  $data['data'] .= '<table border="1px" style:"width:100%;" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ppm_project_name']) ? '<td style="width: 10%;">'.$value['ppm_project_name'].'</td>' : '';
    $tbody .= ($column['ppm_type_of_plan']) ? '<td style="width: 10%;">'.$value['ppm_type_of_plan'].'</td>' : '';
    $tbody .= ($column['ppm_subject_of_work']) ? '<td style="width: 10%;">'.$value['ppm_subject_of_work'].'</td>' : '';
    $tbody .= ($column['pr_packet']) ? '<td style="width: 10%;">'.$value['pr_packet'].'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td style="width: 7%;">'.$value['ptm_dept_name'].'</td>' : '';
    $tbody .= ($column['hps']) ? '<td style="width: 13%;">'.inttomoney($value['hps']).'</td>' : '';
    $tbody .= ($column['contract_amount']) ? '<td style="width: 13%;">'.inttomoney($value['contract_amount']).'</td>' : '';
    $tbody .= ($column['efisiensi']) ? '<td style="width: 13%;">'.inttomoney($value['efisiensi']).'</td>' : '';
    $tbody .= ($column['efisiensi_percent']) ? '<td style="width: 7%;">'.$this->truncate_number($value['efisiensi_percent'],2).'%</td>' : '';
    $tbody .= ($column['tanggal_penunjukan']) ? '<td style="width: 7%;">'.date("d-m-Y", strtotime($value['tanggal_penunjukan'])).'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="2"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'Detail Efisiensi.pdf';

  $data['nameExcel'] = 'Detail Efisiensi.xls';

  $data['orientation'] = (count($column) > 5) ? 'L' : 'P';

  return $data;
}


public function olahDataRekapRealisasi($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){



  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(total_contract)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(jumlah)::text",$search);
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getEfisiensiRekap()->result_array();

  $data['data'] = '<p align="center"><h3><b>Laporan Rencana VS Realisasi</b></h3></p>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';


  $thead = ($column['metode']) ? '<th style="width: 25%;">Metode Pengadaan</th>' : '' ;
  $thead .= ($column['jumlah']) ?'<th style="width: 25%;">Jumlah</th>' : '' ;
  $thead .= ($column['hps']) ? '<th style="width: 25%;">HPS</th>' : '' ;
  $thead .= ($column['total_contract']) ?'<th style="width: 25%;">Nilai Terkontrak</th>' : '' ;


  $data['data'] .= '<table border="1px" style:"width:100%;" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;text-align:center">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {

    $tbody = ($column['metode']) ?'<td style="width: 25%;">'.$value['metode'].'</td>' : '' ;
    $tbody .= ($column['jumlah']) ? '<td style="width: 25%;">'.$value['jumlah'].'</td>' : '' ;
    $tbody .= ($column['hps']) ? '<td style="width: 25%;">'.inttomoney($value['hps']).'</td>' : '' ;
    $tbody .= ($column['total_contract']) ?'<td style="width: 25%;">'.inttomoney($value['total_contract']).'</td>' : '' ;
    $data['data'] .= '<tr style="text-align:center">'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="2"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'RekapEfisiensi.pdf';

  $data['nameExcel'] = 'RekapEfisiensi.xls';

  return $data;
}


public function olahDataDetailRealisasi($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(tanggal_penunjukan)::text",$search);
    $this->db->or_like("LOWER(ptm_dept_name)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ppm_project_name)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(contract_amount)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortOrder);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getEfisiensiDetail()->result_array();

  // var_dump($this->db->last_query());
  // die();
  $data['data'] = '<p align="center"><h3><b>Laporan Rencana VS Realisasi Detail</b></h3></p>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';


  $thead = ($column['ppm_project_name']) ? '<th style="width: 20%;">Nama Proyek</th>' : '';
  $thead .= ($column['ptm_subject_of_work']) ? '<th style="width: 20%;">Jenis Pengadaan</th>' : '';
  $thead .= ($column['ptm_dept_name']) ? '<th style="width: 15%;">Dept.</th>' : '';
  $thead .= ($column['hps']) ? '<th style="width: 15%;">HPS</th>' : '';
  $thead .= ($column['contract_amount']) ? '<th style="width: 15%;">Nilai Terkontrak</th>' : '';
  $thead .= ($column['tanggal_penunjukan']) ? '<th style="width: 15%;">Tanggal Penetapan Pemenang</th>' : '';

  $data['data'] .= '<table border="1px" width="100%" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;text-align:center">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ppm_project_name']) ? '<td style="width: 20%;">'.$value['ppm_project_name'].'</td>' : '';
    $tbody .= ($column['ptm_subject_of_work']) ? '<td style="width: 20%;">'.$value['ptm_subject_of_work'].'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td style="width: 15%;">'.$value['ptm_dept_name'].'</td>' : '';
    $tbody .= ($column['hps']) ? '<td style="width: 15%;">'.inttomoney($value['hps']).'</td>' : '';
    $tbody .= ($column['contract_amount']) ? '<td style="width: 15%;">'.inttomoney($value['contract_amount']).'</td>' : '';
    $tbody .= ($column['tanggal_penunjukan']) ? '<td style="width: 15%;">'.date("d-m-Y", strtotime($value['tanggal_penunjukan'])).'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="2px"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'DetailRealisasi.pdf';

  $data['nameExcel'] = 'DetailRealisasi.xls';

  return $data;
}



public function olahDataRekapStatistikCon($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){
  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(statistik_kontrak)",$search);
    $this->db->or_like("(jml)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }


  $rawdata = $this->db->get('vw_statistik_kontrak')->result_array();
  $data['data'] = '<p colspan="4" style="padding: 2px 0px 2px 0px;text-align:center;height=100px;font-size:14px;font-weight:bold;"><h3><b>Laporan Statistik Contract</b></h3></p>';

  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';

  $thead = ($column['statistik_kontrak']) ? '<th style="width: 70%;">Statistik Contract</th>' : '';
  $thead .= ($column['jml']) ? '<th style="width: 30%;">Jumlah</th>' : '';
  $data['data'] .= '<table border="1px" style:"width:100%;" cellpadding="2">
                      <thead style=" border: 1px solid #ddd;">
                        <tr style="background-color:#337ab7;color:white;text-align:center;">'.$thead.'</tr>
                      </thead>
                      <tbody>';

  foreach ($rawdata as $key => $value) {
    $tbody = ($column['statistik_kontrak']) ? '<td style="width: 70%">'.$value['statistik_kontrak'].'</td>' : '';
    $tbody .= ($column['jml']) ? '<td style="width: 30%;text-align:center;">'.$value['jml'].'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'.</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="3"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'RekapStatistikContract.pdf';

  $data['nameExcel'] = 'RekapStatistikContract.xls';

  return $data;
}


public function olahDataDetailStatistikCon($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){
  $userdata = $this->Administration_m->getLogin();

  switch ($metode) {
    case 'aktif':
        $table = 'vw_get_contract_aktif';
        break;

    case 'batal':
        $table = 'vw_get_contract_batal';
        break;

    case 'selesai':
        $table = 'vw_get_contract_selesai';
        break;

    case 'expired':
        $table = 'vw_get_contract_expired';
        break;

    case '3bln':
        $table = 'vw_get_contract_expired<3';
        break;

    case '1bln':
        $table = 'vw_get_contract_expired<1';
        break;

    default:
        $table = 'vw_get_contract_aktif';
        break;
}
  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(contract_number)",$search);
    $this->db->or_like("(subject_work)::text",$search);
    $this->db->group_end();
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }


  $rawdata = $this->db->get($table)->result_array();
  $data['data'] = '<p align="center"><h3><b>Laporan Statistik Contract</b></h3></p>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $thead = ($column['contract_number']) ? '<th style="width: 70%;">Nomor Kontrak</th>' : '';
  $thead .= ($column['subject_work']) ? '<th style="width: 30%;">Deskripsi</th>' : '';
  $data['data'] .= '<table border="1px" style:"width:100%;" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;text-align:center;">'.$thead.'</tr></thead><tbody>';

  foreach ($rawdata as $key => $value) {
    $tbody = ($column['contract_number']) ? '<td style="width: 70%;">'.$value['contract_number'].'</td>' : '';
    $tbody .= ($column['subject_work']) ? '<td style="width: 30%;">'.$value['subject_work'].'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'.</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="2"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'DetailStatistikContract.pdf';

  $data['nameExcel'] = 'DetailStatistikContract.xls';

  return $data;
}



public function olahDataRekapDurasi($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){



  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(av)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('ptp_tender_method',0);
      break;

    case 2:
      $this->db->where('ptp_tender_method',1);
      break;

    case 3:
      $this->db->where('ptp_tender_method',2);
      break;

    default:
      $this->db->where('ptp_tender_method IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getDurasiRekap()->result_array();

  $data['data'] = '<p style="text-align:center"><h3><b>Laporan Durasi</b></h3></p>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $thead = ($column['metode']) ?'<th style="width: 70%;">Metode Pengadaan</th>' : '' ;
  $thead .= ($column['av']) ?'<th style="width: 30%;">Lama Proses Pengadaan</th>' : '' ;
  $data['data'] .= '<table border="1px" width="100%" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['metode']) ? '<td style="width: 70%;">'.$value['metode'].'</td>' : '' ;
    $tbody .= ($column['av']) ? '<td style="width: 30%;">'.$value['av'].'</td>' : '' ;
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="3"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'RekapLeadTime.pdf';

  $data['nameExcel'] = 'RekapLeadTime.xls';

  return $data;
}




public function olahDataDetailDurasi($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("LOWER(ptm_dept_name)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ppm_project_name)",$search);
    $this->db->or_like("(av)::text","(".str_replace(',', '.', str_replace('.', '', $search)).")::text");
    $this->db->or_like("(ptm_created_date)::text","(".$search.")::text");
    $this->db->or_like("(ptm_completed_date)::text","(".$search.")::text");
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getDurasiDetail()->result_array();
// var_dump($column);
// die()
  // $data['data'] = '<p style="text-align:center"><h3><b>Laporan Durasi</b></h3></p>';

  $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $thead = ($column['ppm_project_name']) ? '<th style="width: 20%;">Nama Proyek</th>' : '';
  $thead .= ($column['ppm_subject_of_work']) ? '<th style="width: 15%;">Nama Rencana Pengadaan</th>' : '';
  $thead .= ($column['pr_packet']) ? '<th style="width: 15%;">Nama Paket</th>' : '';
  $thead .= ($column['ptm_type_of_plan']) ? '<th style="width: 10%;">Jenis Pengadaan</th>' : '';
  $thead .= ($column['ptm_dept_name']) ? '<th style="width: 15%;">Dept.</th>' : '';
  $thead .= ($column['ptm_created_date']) ? '<th style="width: 10%;">Mulai Pengadaan</th>' : '';
  $thead .= ($column['ptm_completed_date']) ? '<th style="width: 10%;">Akhir Pengadaan</th>' : '';
  $thead .= ($column['av']) ? '<th style="width: 10%;">Lama Pengadaan</th>' : '';
  $data['data'] .= '<table border="1px" style:"width:100%;" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;text-align:center">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ppm_project_name']) ? '<td style="width: 20%;">'.$value['ppm_project_name'].'</td>' : '';
    $tbody .= ($column['ppm_subject_of_work']) ? '<td style="width: 15%;">'.$value['ppm_subject_of_work'].'</td>' : '';
    $tbody .= ($column['pr_packet']) ? '<td style="width: 15%;">'.$value['pr_packet'].'</td>' : '';
    $tbody .= ($column['ptm_type_of_plan']) ? '<td style="width: 10%;">'.$value['ptm_type_of_plan'].'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td style="width: 15%;">'.$value['ptm_dept_name'].'</td>' : '';
    $tbody .= ($column['ptm_created_date']) ? '<td style="width: 10%;">'.date("d-m-Y", strtotime($value['ptm_created_date'])).'</td>' : '';
    $tbody .= ($column['ptm_completed_date']) ? '<td style="width: 10%;">'.date("d-m-Y", strtotime($value['ptm_completed_date'])).'</td>' : '';
    $tbody .= ($column['av']) ? '<td style="width: 10%;">'.$value['av'].'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }


  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="3"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'DetailLeadTime.pdf';

  $data['nameExcel'] = 'DetailLeadTime.xls';

  $data['orientation'] = 'L';

  return $data;
}







public function olahDataDetailGenerateList($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){
  $userdata = $this->Administration_m->getLogin();
  // var_dump($column);
  // die();
  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(vendor_name)",$search);
    $this->db->or_like("LOWER('fin_class_name')",$search);
    $this->db->or_like("LOWER(reg_status_name)",$search);
    $this->db->group_end();
  }
  $klasifikasi_gbl = $this->session->userdata("klasifikasi_gbl");

  switch ($klasifikasi_gbl) {

    case 'K':
      $this->db->where('fin_class','K');
      break;

    case 'M':
      $this->db->where('fin_class','M');
      break;

    case 'B':
      $this->db->where('fin_class','B');
      break;

    default:
      $this->db->where('fin_class IS NOT NULL');
      break;
  }
  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortOrder);
  }else {
    $this->db->order_by('vendor_id','asc');
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }
  $rekap = $this->db->get("vw_vnd_header")->result_array();
  // var_dump($this->db->last_query());

  //   die();
  $data['data'] = '<table><tr><td>Laporan Durasi<td></tr></table>';

  $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $thead = ($column['vendor_name']) ? '<th style="width: 50%;">Nama Vendor</th>' : '' ;
  $thead .= ($column['fin_class_name']) ? '<th style="width: 25%;text-align:center">Klasifikasi</th>' : '' ;
  $thead .= ($column['reg_status_name']) ? '<th style="width: 25%;text-align:center">Status</th>' : '' ;
// var_dump($thead);
// die();
  $data['data'] .= '<table border="1px" cellpadding="3" width="100%"><thead><tr style="background-color:#337ab7;color:white;">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
     if ($value['fin_class'] == 'K') {
       $klas = 'Kecil';
     } else if ($value['fin_class'] == 'M'){
      $klas = 'Menegah';
     } else {
      $klas = 'Besar';
     }
    $tbody = ($column['vendor_name']) ? '<td style="width: 50%;">'.$value['vendor_name'].'</td>' : '' ;
    $tbody .= ($column['fin_class_name']) ? '<td style="width: 25%;text-align:center">'.$klas.'</td>' : '' ;
    $tbody .= ($column['reg_status_name']) ? '<td style="width: 25%;text-align:center">'.$value['reg_status_name'].'</td>' : '' ;

    $data['data'] .= '<tr style="">'.$tbody.'</tr>';
  }


  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="3"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'Detailgenerate_bidder_list.pdf';

  $data['nameExcel'] = 'Detailgenerate_bidder_list.xls';

  return $data;
}




public function olahDataDetailRfq($search = "",$metode = "", $limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_requester_name)",$search);
    $this->db->or_like("LOWER(ptm_scope_of_work)",$search);
    $this->db->or_like("LOWER(ptm_requester_pos_name)",$search);
    $this->db->or_like("LOWER(ptm_packet)",$search);
    $this->db->or_like("LOWER(status)",$search);
    $this->db->or_like("LOWER(jenis_pengadaan)",$search);
    $this->db->or_like("LOWER(last_pos)",$search);
    $this->db->group_end();
  }

  $this->db->where('ptm_status',1901);

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Procrfq_m->getMonitorRFQ()->result_array();

  $data['data'] = '<table><tr><td>Laporan RFQ Aktif</td></tr></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $thead = ($column['ptm_number']) ? '<th style="width: 20%;">No. Tender</th>' : '';
  $thead .= ($column['ptm_requester_name']) ? '<th style="width: 20%;">User</th>' : '';
  $thead .= ($column['ptm_subject_of_work']) ? '<th style="width: 15%;">Nama Rencana Pekerjaan</th>' : '';
  $thead .= ($column['ptm_dept_name']) ?'<th style="width: 15%;">Divisi/Departemen</th>' : '';
  $thead .= ($column['last_pos']) ? '<th style="width: 15%;">Posisi saat Ini</th>' : '';
  $thead .= ($column['status']) ? '<th style="width: 15%;">Status</th>' : '';
  $data['data'] .= '<table border="1px" style:"width:100%;" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ptm_number']) ? '<td style="width: 20%;">'.$value['ptm_number'].'</td>' : '';
    $tbody .= ($column['ptm_requester_name']) ? '<td style="width: 20%;">'.$value['ptm_requester_name'].'</td>' : '';
    $tbody .= ($column['ptm_subject_of_work']) ? '<td style="width: 15%;">'.$value['ptm_subject_of_work'].'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td style="width: 15%;">'.$value['ptm_dept_name'].'</td>' : '';
    $tbody .= ($column['last_pos']) ? '<td style="width: 15%;">'.$value['last_pos'].'</td>' : '';
    $tbody .= ($column['status']) ? '<td style="width: 15%;">'.$value['status'].'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }


  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table cellpadding="3"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';

  $data['namePDF'] = 'LaporanRFQAktif.pdf';

  $data['nameExcel'] = 'LaporanRFQAktif.xls';

  return $data;
}


//=========

//hlmifzi
public function detail_rfq($jenis = '',$isi ='' ,$kode_group = '', $fin_class = '', $tgl_akhir =''){
  switch($jenis){
    case "lap_proc_value":
    include("laporan/all_rfq.php");
    break;

    /*case "report_kinerja_vendor":
    include("laporan/report_kinerja_vendor.php");
    break;

    case "lap_proc_value":
    include("laporan/lap_proc_value.php");
    break;

    case "report_jumlah_belanja":
    include("laporan/report_jumlah_belanja.php");
    break;

    case "report_proses_pengadaan":
    include("laporan/report_proses_pengadaan.php");
    break;

    case "report_durasi_proses":
    include("laporan/report_durasi_proses.php");
    break;

    case "report_statistik_contract":
    include("laporan/report_statistik_contract.php");
    break;*/

    default:
    echo "No Such Item";
  }

}


//y laporan hasi; survey
public function laporan_survey(){
  $this->session->unset_userdata("tgl_awal_s");
  $this->session->unset_userdata("tgl_akhir_s");
  $this->session->unset_userdata("tgl_awal");
  $this->session->unset_userdata("tgl_akhir");
  $this->session->unset_userdata("vendor_name");
  include("laporan/monitor_vendor/laporan_survei.php");
}

public function data_survei_vendor(){
  include("laporan/monitor_vendor/data_survei_vendor.php");
}

public function laporan_pdf_survei_vend(){
  include("laporan/monitor_vendor/pdf_laporan_vendor_survei.php");
}
public function laporan_excel_vendor_survei(){
  include("laporan/monitor_vendor/excel_laporan_vendor_survei.php");
}
//y end

public function memoIntoExcel($param){
  $this->load->model('Memo_m');
  include("laporan/memoIntoExcel.php");
}
//=======================================================================

// FUNCTION EXPORT EXCEL

public function olahDataDetailDurasiExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("LOWER(ptm_dept_name)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ppm_project_name)",$search);
    $this->db->or_like("(av)::text","(".str_replace(',', '.', str_replace('.', '', $search)).")::text");
    $this->db->or_like("(ptm_created_date)::text","(".$search.")::text");
    $this->db->or_like("(ptm_completed_date)::text","(".$search.")::text");
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getDurasiDetail()->result_array();

  $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table><tr><td colspan="6">Laporan Durasi</td></tr></table>';

  $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // var_dump($column);
  // die();
  $thead = ($column['ppm_project_name']) ? '<th style="width: 20%;">Nama Proyek</th>' : '';
  $thead .= ($column['ppm_subject_of_work']) ? '<th style="width: 15%;">Nama Rencana Pengadaan</th>' : '';
  $thead .= ($column['pr_packet']) ? '<th style="width: 15%;">Nama Paket</th>' : '';
  $thead .= ($column['ptm_type_of_plan']) ? '<th style="width: 10%;">Jenis Pengadaan</th>' : '';
  $thead .= ($column['ptm_dept_name']) ? '<th style="width: 15%;">Dept.</th>' : '';
  $thead .= ($column['ptm_created_date']) ? '<th style="width: 10%;">Mulai Pengadaan</th>' : '';
  $thead .= ($column['ptm_completed_date']) ? '<th style="width: 10%;">Akhir Pengadaan</th>' : '';
  $thead .= ($column['av']) ? '<th style="width: 10%;">Lama Pengadaan</th>' : '';
  $data['data'] .= '<table><thead><tr>'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ppm_project_name']) ? '<td>'.(string)htmlentities($value['ppm_project_name']).'</td>' : '';
    $tbody .= ($column['ppm_subject_of_work']) ? '<td  >'.(string)htmlentities($value['ptm_subject_of_work']).'</td>' : '';
    $tbody .= ($column['pr_packet']) ? '<td style="width: 15%;">'.(string)htmlentities($value['pr_packet']).'</td>' : '';
    $tbody .= ($column['ptm_type_of_plan']) ? '<td style="width: 10%;">'.(string)htmlentities($value['ptm_type_of_plan']).'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td >'.(string)htmlentities($value['ptm_dept_name']).'</td>' : '';
    $tbody .= ($column['ptm_created_date']) ? '<td >'.date("d-m-Y", strtotime($value['ptm_created_date'])).'</td>' : '';
    $tbody .= ($column['ptm_completed_date']) ? '<td  >'.date("d-m-Y", strtotime($value['ptm_completed_date'])).'</td>' : '';
    $tbody .= ($column['av']) ? '<td  >'.(string)htmlentities($value['av']).'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }


  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                        <td colspan="6">Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">.....................</td>
                        <td colspan="2" style="text-align:center" border="1">....................</td>
                        <td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'DetailLeadTime.pdf';

  $data['nameExcel'] = 'DetailLeadTime.xls';

  return $data;
}

public function olahDataDetailRfqExcel($search = "",$metode = "", $limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_requester_name)",$search);
    $this->db->or_like("LOWER(ptm_scope_of_work)",$search);
    $this->db->or_like("LOWER(ptm_requester_pos_name)",$search);
    $this->db->or_like("LOWER(ptm_packet)",$search);
    $this->db->or_like("LOWER(status)",$search);
    $this->db->or_like("LOWER(jenis_pengadaan)",$search);
    $this->db->or_like("LOWER(last_pos)",$search);
    $this->db->group_end();
  }

  $this->db->where('ptm_status',1901);

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Procrfq_m->getMonitorRFQ()->result_array();
  $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<table><tr><td colspan="6">Laporan RFQ Aktif</td></tr></table>';
  $data['data'] .= '<br />';
  $thead = ($column['ptm_number']) ? '<th>No. Tender</th>' : '';
  $thead .= ($column['ptm_requester_name']) ? '<th >User</th>' : '';
  $thead .= ($column['ptm_subject_of_work']) ? '<th>Nama Rencana Pekerjaan</th>' : '';
  $thead .= ($column['ptm_dept_name']) ?'<th >Divisi/Departemen</th>' : '';
  $thead .= ($column['last_pos']) ? '<th>Posisi saat Ini</th>' : '';
  $thead .= ($column['status']) ? '<th>Status</th>' : '';
  $data['data'] .= '<table><thead><tr>'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ptm_number']) ? '<td>'.(string)htmlentities($value['ptm_number']).'</td>' : '';
    $tbody .= ($column['ptm_requester_name']) ? '<td>'.(string)htmlentities($value['ptm_requester_name']).'</td>' : '';
    $tbody .= ($column['ptm_subject_of_work']) ? '<td>'.(string)htmlentities($value['ptm_subject_of_work']).'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td>'.(string)htmlentities($value['ptm_dept_name']).'</td>' : '';
    $tbody .= ($column['last_pos']) ? '<td>'.(string)htmlentities($value['last_pos']).'</td>' : '';
    $tbody .= ($column['status']) ? '<td>'.(string)htmlentities($value['status']).'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }


  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                        <td colspan="6">Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">.....................</td>
                        <td colspan="2" style="text-align:center" border="1">....................</td>
                        <td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'LaporanRFQAktif.pdf';

  $data['nameExcel'] = 'LaporanRFQAktif.xls';

  return $data;
}

public function olahDataDetailGenerateListExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){
  $userdata = $this->Administration_m->getLogin();
  // var_dump($column);
  // die();
  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(vendor_name)",$search);
    $this->db->or_like("LOWER('fin_class_name')",$search);
    $this->db->or_like("LOWER(reg_status_name)",$search);
    $this->db->group_end();
  }
  $klasifikasi_gbl = $this->session->userdata("klasifikasi_gbl");

  switch ($klasifikasi_gbl) {

    case 'K':
      $this->db->where('fin_class','K');
      break;

    case 'M':
      $this->db->where('fin_class','M');
      break;

    case 'B':
      $this->db->where('fin_class','B');
      break;

    default:
      $this->db->where('fin_class IS NOT NULL');
      break;
  }
  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortOrder);
  }else {
    $this->db->order_by('vendor_id','asc');
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }
  $rekap = $this->db->get("vw_vnd_header")->result_array();
  // var_dump($this->db->last_query());

  //   die();
  $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .='<table><tr><td></td><td></td><td>Laporan Durasi</td></tr></table>';
  $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';

  $thead = ($column['vendor_name']) ? '<th>Nama Vendor</th>' : '<th></th>' ;
  $thead .= ($column['fin_class_name']) ? '<th>Klasifikasi</th>' : '<th></th>' ;
  $thead .= ($column['reg_status_name']) ? '<th>Status</th>' : '<th></th>' ;

  // spasi phpexcel
  // $data['data'] = '<table><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr></table>';
  //  $data['data'] .= '<p ><h3><b>Laporan Durasi</b></h3></p>';

  $data['data'] .= '<table><thead><tr><td></td>'.$thead.'</tr></thead><tbody>';


  foreach ($rekap as $key => $value) {
     if ($value['fin_class'] == 'K') {
       $klas = 'Kecil';
     } else if ($value['fin_class'] == 'M'){
      $klas = 'Menegah';
     } else {
      $klas = 'Besar';
     }
    $tbody = ($column['vendor_name']) ? '<td>'.(string)htmlentities($value['vendor_name']).'</td>' : '<td></td>' ;
    $tbody .= ($column['fin_class_name']) ? '<td>'.($klas).'</td>' : '<td></td>' ;
    $tbody .= ($column['reg_status_name']) ? '<td>'.(string)htmlentities($value['reg_status_name']).'</td>' : '<td></td>' ;

    $data['data'] .= '<tr><td></td>'.$tbody.'</tr>';
  }


  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                      <td></td>
                      <td></td>
                        <td>Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                      <td></td>
                        <td>Disetujui oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                      <td></td>
                        <td colspan="1" style="text-align:center" border="1">.....................</td>
                        <td colspan="1" style="text-align:center" border="1">....................</td>
                        <td colspan="1" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'Detailgenerate_bidder_list.pdf';

  $data['nameExcel'] = 'Detailgenerate_bidder_list.xls';

  return $data;
}

public function olahDataRekapEfisiensiExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){



  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(total_contract)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(jumlah)::text",$search);
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getEfisiensiRekap()->result_array();
  $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<table><tr><td colspan="6">Laporan Efisiensi</td></tr></table>';

  $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';

  $thead = ($column['metode']) ? '<th>Metode Pengadaan</th>' : '<th></th>' ;
  $thead .= ($column['jumlah']) ?'<th>Jumlah</th>' : '<th></th>' ;
  $thead .= ($column['hps']) ? '<th>HPS</th>' : '<th></th>' ;
  $thead .= ($column['total_contract']) ?'<th>Nilai Terkontrak</th>' : '<th></th>' ;
  $thead .= ($column['efisiensi']) ? '<th>Efisiensi</th>' : '' ;
  $thead .= ($column['efisiensi_percent']) ? '<th>Persentase Efisiensi</th>' : '<th></th>' ;


  $data['data'] .= '<table><thead><tr>'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['metode']) ?'<td>'.(string)htmlentities($value['metode']).'</td>' : '' ;
    $tbody .= ($column['jumlah']) ? '<td>'.(string)htmlentities($value['jumlah']).'</td>' : '' ;
    $tbody .= ($column['hps']) ? '<td>'.inttomoney($value['hps']).'</td>' : '' ;
    $tbody .= ($column['total_contract']) ?'<td>'.inttomoney($value['total_contract']).'</td>' : '' ;
    $tbody .= ($column['efisiensi']) ?'<td>'.inttomoney($value['efisiensi']).'</td>' : '' ;
    $tbody .= ($column['efisiensi_percent']) ?'<td>'.$this->truncate_number($value['efisiensi_percent'],2).'%</td>' : '' ;
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                        <td colspan="6">Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">.....................</td>
                        <td colspan="2" style="text-align:center" border="1">....................</td>
                        <td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'RekapEfisiensi.pdf';

  $data['nameExcel'] = 'RekapEfisiensi.xls';

  return $data;
}

public function olahDataDetailEfisiensiExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(tanggal_penunjukan)::text",$search);
    $this->db->or_like("LOWER(ptm_dept_name)",$search);
    $this->db->or_like("LOWER(ppm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ppm_project_name)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(contract_amount)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }
  $this->db->where('ppi_is_sap', 1);
  $userdata = $this->data['userdata'];
  if ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'DIVISI SUPPLY CHAIN MANAGEMENT' && $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' OR preg_match('/(DIREKTUR)/i', $userdata['job_title'])) {

      $this->db->where('ptm_dept_name', $userdata['dept_name']);

  }
  $rekap = $this->Laporan_m->getEfisiensiDetail()->result_array();

  // var_dump($column);
  // die();
    $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<table><tr><td colspan="8">Laporan Efisiensi Detail</td></tr></table>';

  $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';

  $thead = ($column['ppm_project_name']) ? '<th>Nama Proyek</th>' : '<th></th>';
  $thead .= ($column['ppm_subject_of_work']) ? '<th>Jenis Pengadaan</th>' : '<th></th>';
  $thead .= ($column['ptm_dept_name']) ? '<th>Dept.</th>' : '<th></th>';
  $thead .= ($column['hps']) ? '<th>HPS</th>' : '<th></th>';
  $thead .= ($column['contract_amount']) ? '<th>Nilai Terkontrak</th>' : '<th></th>';
  $thead .= ($column['efisiensi']) ? '<th>Efisiensi</th>' : '';
  $thead .= ($column['efisiensi_percent']) ? '<th>Persentase Efisiensi</th>' : '<th></th>';
  $thead .= ($column['tanggal_penunjukan']) ? '<th>Tanggal Penetapan Pemenang</th>' : '<th></th>';

  $data['data'] .= '<table><thead><tr>'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ppm_project_name']) ? '<td>'.(string)htmlentities($value['ppm_project_name']).'</td>' : '';
    $tbody .= ($column['ppm_subject_of_work']) ? '<td>'.(string)htmlentities($value['ptm_subject_of_work']).'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td>'.(string)htmlentities($value['ptm_dept_name']).'</td>' : '';
    $tbody .= ($column['hps']) ? '<td>'.inttomoney($value['hps']).'</td>' : '';
    $tbody .= ($column['contract_amount']) ? '<td >'.inttomoney($value['contract_amount']).'</td>' : '';
    $tbody .= ($column['efisiensi']) ? '<td>'.inttomoney($value['efisiensi']).'</td>' : '';
    $tbody .= ($column['efisiensi_percent']) ? '<td>'.$this->truncate_number($value['efisiensi_percent'],2).'%</td>' : '';
    $tbody .= ($column['tanggal_penunjukan']) ? '<td>'.date("d-m-Y", strtotime($value['tanggal_penunjukan'])).'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                        <td colspan="8">Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="4" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">.....................</td>
                        <td colspan="4" style="text-align:center" border="1">....................</td>
                        <td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'DetailRealisasi.pdf';

  $data['nameExcel'] = 'DetailRealisasi.xls';

  return $data;
}

public function olahDataDetailRealisasiExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){


  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(tanggal_penunjukan)::text",$search);
    $this->db->or_like("LOWER(ptm_dept_name)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ppm_project_name)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(contract_amount)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortOrder);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getEfisiensiDetail()->result_array();

  // var_dump($this->db->last_query());
  // die();
  //   $data['data'] = '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<table><tr><td colspan="6">Laporan Rencana VS Realisasi Detail</td></tr></table>';

  $data['data'] = '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';


  $thead = ($column['ppm_project_name']) ? '<th>Nama Proyek</th>' : '<th></th>';
  $thead .= ($column['ptm_subject_of_work']) ? '<th >Jenis Pengadaan</th>' : '<th></th>';
  $thead .= ($column['ptm_dept_name']) ? '<th>Dept.</th>' : '<th></th>';
  $thead .= ($column['hps']) ? '<th>HPS</th>' : '';
  $thead .= ($column['contract_amount']) ? '<th>Nilai Terkontrak</th>' : '<th></th>';
  $thead .= ($column['tanggal_penunjukan']) ? '<th>Tanggal Penetapan Pemenang</th>' : '<th></th>';

  $data['data'] = '<br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <table><tr><td></td><td></td><td>Laporan Rencana VS Realisasi Detail</td></tr></table>
                    <br>
                    <table><thead><tr>'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['ppm_project_name']) ? '<td>'.(string)htmlentities($value['ppm_project_name']).'</td>' : '';
    $tbody .= ($column['ptm_subject_of_work']) ? '<td>'.(string)htmlentities($value['ptm_subject_of_work']).'</td>' : '';
    $tbody .= ($column['ptm_dept_name']) ? '<td>'.$value['ptm_dept_name'].'</td>' : '';
    $tbody .= ($column['hps']) ? '<td>'.inttomoney($value['hps']).'</td>' : '';
    $tbody .= ($column['contract_amount']) ? '<td >'.inttomoney($value['contract_amount']).'</td>' : '';
    $tbody .= ($column['tanggal_penunjukan']) ? '<td>'.date("d-m-Y", strtotime($value['tanggal_penunjukan'])).'</td>' : '';
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                      <td></td>
                      <td></td>
                        <td>Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr></tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                        <td colspan="2" style="text-align:center" border="1">.....................</td>
                        <td colspan="2" style="text-align:center" border="1">....................</td>
                        <td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'DetailRealisasi.pdf';

  $data['nameExcel'] = 'DetailRealisasi.xls';

  return $data;
}

public function olahDataRekapDurasiExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){



  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(av)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('ptp_tender_method',0);
      break;

    case 2:
      $this->db->where('ptp_tender_method',1);
      break;

    case 3:
      $this->db->where('ptp_tender_method',2);
      break;

    default:
      $this->db->where('ptp_tender_method IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getDurasiRekap()->result_array();
    $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<table><tr><td colspan="2">Laporan Durasi</td></tr></table>';

  $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';

  $thead = ($column['metode']) ?'<th >Metode Pengadaan</th>' : '' ;
  $thead .= ($column['av']) ?'<th>Lama Proses Pengadaan</th>' : '' ;
  $data['data'] .= '<table border="1px" width="100%" cellpadding="2"><thead><tr style="background-color:#337ab7;color:white;">'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {
    $tbody = ($column['metode']) ? '<td >'.(string)htmlentities($value['metode']).'</td>' : '' ;
    $tbody .= ($column['av']) ? '<td>'.(string)htmlentities($value['av']).'</td>' : '' ;
    $data['data'] .= '<tr>'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                        <td colspan="3">Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                        <td colspan="1" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                        <td colspan="1" style="text-align:center" border="1">.....................</td>
                        <td colspan="1" style="text-align:center" border="1">....................</td>
                        <td colspan="1" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'RekapLeadTime.pdf';

  $data['nameExcel'] = 'RekapLeadTime.xls';

  return $data;
}

public function olahDataDetailStatistikConExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){
  $userdata = $this->Administration_m->getLogin();

  switch ($metode) {
    case 'aktif':
        $table = 'vw_get_contract_aktif';
        break;

    case 'batal':
        $table = 'vw_get_contract_batal';
        break;

    case 'selesai':
        $table = 'vw_get_contract_selesai';
        break;

    case 'expired':
        $table = 'vw_get_contract_expired';
        break;

    case '3bln':
        $table = 'vw_get_contract_expired<3';
        break;

    case '1bln':
        $table = 'vw_get_contract_expired<1';
        break;

    default:
        $table = 'vw_get_contract_aktif';
        break;
}
  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(contract_number)",$search);
    $this->db->or_like("(subject_work)::text",$search);
    $this->db->group_end();
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }


  $rawdata = $this->db->get($table)->result_array();
  $data['data'] = '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<table><tr><td></td><td colspan="2">Laporan Statistik Contract</td></tr></table>';

  $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';

  $thead = ($column['contract_number']) ? '<th >Nomor Kontrak</th>' : '<th></th>';
  $thead .= ($column['subject_work']) ? '<th >Deskripsi</th>' : '<th></th>';
  $data['data'] .= '<table ><thead><tr><td></td>'.$thead.'</tr></thead><tbody>';

  foreach ($rawdata as $key => $value) {
    $tbody = ($column['contract_number']) ? '<td >'.(string)htmlentities($value['contract_number']).'</td>' : '';
    $tbody .= ($column['subject_work']) ? '<td >'.(string)htmlentities($value['subject_work']).'</td>' : '';
    $data['data'] .= '<tr><td></td>'.$tbody.'.</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                      <td></td>
                      <td></td>
                        <td>Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                      <td></td>
                        <td colspan="1" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                      <td></td>
                        <td colspan="1" style="text-align:center" border="1">.....................</td>
                        <td colspan="1" style="text-align:center" border="1">....................</td>
                        <td colspan="1" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  // $data['namePDF'] = 'DetailStatistikContract.pdf';

  $data['nameExcel'] = 'DetailStatistikContract.xls';

  return $data;
}

public function olahDataRekapRealisasiExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){



  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(total_contract)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(jumlah)::text",$search);
    $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  switch ($metode) {

    case 1:
      $this->db->where('metode_id',0);
      break;

    case 2:
      $this->db->where('metode_id',1);
      break;

    case 3:
      $this->db->where('metode_id',2);
      break;

    default:
      $this->db->where('metode_id IS NOT NULL');
      break;
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }

  $rekap = $this->Laporan_m->getEfisiensiRekap()->result_array();
$data['data'] = '<br>';
  $data['data'] .= '<br>';
  $data['data'] .= '<br>';
  $data['data'] .= '<br>';
  $data['data'] .= '<br>';
  $data['data'] .= '<br>';
  $data['data'] .= '<table><tr><td colspan="4">Laporan Rencana VS Realisasi</td></tr></table>';

  $data['data'] .= '<br>';



  $thead = ($column['metode']) ? '<th  >Metode Pengadaan</th>' : '<th></th>' ;
  $thead .= ($column['jumlah']) ?'<th  >Jumlah</th>' : '<th></th>' ;
  $thead .= ($column['hps']) ? '<th  >HPS</th>' : '<th></th>' ;
  $thead .= ($column['total_contract']) ?'<th  >Nilai Terkontrak</th>' : '<th></th>' ;


  $data['data'] .= '<br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br><table ><thead><tr >'.$thead.'</tr></thead><tbody>';

  foreach ($rekap as $key => $value) {

    $tbody = ($column['metode']) ?'<td  >'.(string)htmlentities($value['metode']).'</td>' : '' ;
    $tbody .= ($column['jumlah']) ? '<td  >'.(string)htmlentities($value['jumlah']).'</td>' : '' ;
    $tbody .= ($column['hps']) ? '<td  >'.inttomoney($value['hps']).'</td>' : '' ;
    $tbody .= ($column['total_contract']) ?'<td  >'.inttomoney($value['total_contract']).'</td>' : '' ;
    $data['data'] .= '<tr style="text-align:center">'.$tbody.'</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                        <td colspan="4">Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                        <td colspan="1" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                        <td colspan="1" style="text-align:center" border="1">.....................</td>
                        <td colspan="2" style="text-align:center" border="1">....................</td>
                        <td colspan="1" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'RekapEfisiensi.pdf';

  $data['nameExcel'] = 'RekapEfisiensi.xls';

  return $data;
}

public function olahDataRekapStatistikConExcel($search = "",$metode = "",$limit = "",$offset = "",$sortName = "",$sortOrder = "", $column = ""){
  $userdata = $this->Administration_m->getLogin();

  if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(statistik_kontrak)",$search);
    $this->db->or_like("(jml)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

  if(!empty($sortName) && !empty($sortOrder)){
    $this->db->order_by($sortName,$sortName);
  }

  if(!empty($limit) && !empty($offset)){
    $this->db->limit($limit,$offset);
  }


  $rawdata = $this->db->get('vw_statistik_kontrak')->result_array();
  // $data['data'] = '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<table><tr><td colspan="2">Laporan Statistik Contract</td></tr></table>';

  $data['data'] = '<br />';
  // $data['data'] .= '<br />';
  // $data['data'] .= '<br />';

  $thead = ($column['statistik_kontrak']) ? '<th>Statistik Contract</th>' : '';
  $thead .= ($column['jml']) ? '<th >Jumlah</th>' : '';
  $data['data'] = '<br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <table><tr><td></td><td></td><td>Laporan Statistik Contract</td></tr></table>
                    <table >
                      <thead>
                        <tr ><th></th>'.$thead.'</tr>
                      </thead>
                      <tbody>';

  foreach ($rawdata as $key => $value) {
    $tbody = ($column['statistik_kontrak']) ? '<td >'.(string)htmlentities($value['statistik_kontrak']).'</td>' : '';
    $tbody .= ($column['jml']) ? '<td >'.(string)htmlentities($value['jml']).'</td>' : '';
    $data['data'] .= '<tr><td></td>'.$tbody.'.</tr>';
  }

  $data['data'] .= '</tbody></table>';

  $data['data'] .= '<br />';
  $data['data'] .= '<br />';
  $data['data'] .= '<br />';

  $data['data'] .= '<table>
                      <tr>
                      <td></td>
                      <td></td>
                        <td colspan="2">Tanggal '.date('d-m-Y').'</td>
                      </tr>
                      <tr>
                      <td></td>
                        <td colspan="1" style="text-align:center" border="1">Disetujui oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Diperiksa oleh</td>
                        <td colspan="1" style="text-align:center" border="1">Dibuat oleh</td>
                      </tr>
                      <tr></tr>
                      <tr></tr>
                      <tr></tr>
                      <tr>
                      <td></td>
                        <td colspan="1" style="text-align:center" border="1">.....................</td>
                        <td colspan="1" style="text-align:center" border="1">....................</td>
                        <td colspan="1" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td>
                      </tr>
                      </table>';

  $data['namePDF'] = 'RekapStatistikContract.pdf';

  $data['nameExcel'] = 'RekapStatistikContract.xls';

  return $data;
}

public function laporanPdfRekap($type="",$metode=""){
  $get = $this->input->get();

  $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
  $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : "";
  $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : "";
  $sortName = (isset($get['sortName']) && !empty($get['sortName'])) ? $get['sortName'] : "";
  $sortOrder = (isset($get['sortOrder']) && !empty($get['sortOrder'])) ? $get['sortOrder'] : "";
  $column = (isset($get['column']) && !empty($get['column'])) ? json_decode($get['column'],true) : array();

  switch ($type) {
    case 'efisiensi':

      $data = $this->olahDataRekapEfisiensi($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'durasi':

      $data = $this->olahDataRekapDurasi($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'realisasi':

      $data = $this->olahDataRekapRealisasi($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'statistikCon':

      $data = $this->olahDataRekapStatistikCon($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;
    default:
      # code...
      break;
  }
  $this->generatePDF($data);
}

public function laporanExcelRekap($type = "", $metode = ""){
  $get = $this->input->get();

  $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
  $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : "";
  $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : "";
  $sortName = (isset($get['sortName']) && !empty($get['sortName'])) ? $get['sortName'] : "";
  $sortOrder = (isset($get['sortOrder']) && !empty($get['sortOrder'])) ? $get['sortOrder'] : "";
  $column = (isset($get['column']) && !empty($get['column'])) ? json_decode($get['column'],true) : array();


  switch ($type) {
    case 'efisiensi':

      $data = $this->olahDataRekapEfisiensiExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'durasi':

      $data = $this->olahDataRekapDurasiExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'realisasi':

      $data = $this->olahDataRekapRealisasiExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'statistikCon':

      $data = $this->olahDataRekapStatistikConExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;
    default:
      # code...
      break;
  }
  $this->generateExcel($data);

}

public function laporanPdfDetail($type = "", $metode = ""){
  $get = $this->input->get();

  $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
  $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : "";
  $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : "";
  $sortName = (isset($get['sortName']) && !empty($get['sortName'])) ? $get['sortName'] : "";
  $sortOrder = (isset($get['sortOrder']) && !empty($get['sortOrder'])) ? $get['sortOrder'] : "";
  $column = (isset($get['column']) && !empty($get['column'])) ? json_decode($get['column'],true) : array();

  switch ($type) {
    case 'efisiensi':

      $data = $this->olahDataDetailEfisiensi($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'durasi':

      $data = $this->olahDataDetailDurasi($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'rfq':

      $data = $this->olahDataDetailRfq($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'realisasi':

      $data = $this->olahDataDetailRealisasi($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'lapklsvnd':

      $data = $this->olahDataDetailGenerateList($search,$metode,$limit,$offset,$sortName,$sortOrder,$column);
      break;

    case 'statistikCon':

      $data = $this->olahDataDetailStatistikCon($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;
    default:
      # code...
      break;
  }

  // echo "<pre>";
  // print_r($userdata);
  // echo "<br>";
  // print_r($this->db->get_where('vw_efisiensi_detail', ['ptm_dept_name' => $userdata['dept_name']])->result_array());
  // die;

  $this->generatePDF($data);

}

public function laporanExcelDetail($type = "", $metode = ""){
  $get = $this->input->get();

  $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
  $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : "";
  $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : "";
  $sortName = (isset($get['sortName']) && !empty($get['sortName'])) ? $get['sortName'] : "";
  $sortOrder = (isset($get['sortOrder']) && !empty($get['sortOrder'])) ? $get['sortOrder'] : "";
  $column = (isset($get['column']) && !empty($get['column'])) ? json_decode($get['column'],true) : array();

  switch ($type) {
    case 'efisiensi':

      $data = $this->olahDataDetailEfisiensiExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'durasi':

      $data = $this->olahDataDetailDurasiExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'rfq':

      $data = $this->olahDataDetailRfqExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

    case 'realisasi':

      $data = $this->olahDataDetailRealisasiExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;
    default:

    case 'lapklsvnd':

      $data = $this->olahDataDetailGenerateListExcel($search,$metode,$limit,$offset,$sortName,$sortOrder,$column);
      break;

    case 'statistikCon':

      $data = $this->olahDataDetailStatistikConExcel($search, $metode, $limit, $offset, $sortName, $sortOrder, $column);
      break;

      # code...
      break;
  }
  $this->generateExcel($data);

}

public function crawl_analisa_plan($export=""){
  include("laporan/lap_plan.php");
}

public function pdf_analisa_plan(){
  include("laporan/pdf_analisa_plan.php");
}

public function xlsx_analisa_plan(){
  include("laporan/xlsx_analisa_plan.php");
}

public function lap_plan($param = '', $id= ''){

  switch ($param) {

    case 'all_dept':
      include("laporan/lap_plan/all_dept.php");
      break;

    case 'dept':
      include("laporan/lap_plan/per_dept.php");
      break;

    case 'all_coa':
      include("laporan/lap_plan/all_coa.php");
      break;

    default:
      include("laporan/lap_plan/total.php");
      break;
  }
}


public function lap_tender($param = '', $id = ''){

  switch ($param) {
    case 'rfq_contract':
      include("laporan/lap_tender/rfq_contract.php");
      break;

    case 'rkp_rkap':
      include("laporan/lap_tender/rkp_rkap.php");
      break;

    case 'time_duration':
      include("laporan/lap_tender/time_duration.php");
      break;

    case 'total_rfq':
      include("laporan/lap_tender/total_rfq.php");
      break;

    case 'per_dept':
      include("laporan/lap_tender/per_dept.php");
      break;

    case 'data_per_dept':
      include("laporan/lap_tender/data_per_dept.php");
      break;

    default:
      include("laporan/lap_tender/total_tender.php");
      break;
  }
}

public function lap_rari($param = '', $id = ''){

  switch ($param) {
    case 'all_dept_rari':
      include("laporan/lap_rari/all_dept_rari.php");
      break;

    case 'dept_rari':
      include("laporan/lap_rari/per_dept_rari.php");
      break;

    case 'all_coa_rari':
      include("laporan/lap_rari/all_coa_rari.php");
      break;

    default:
      include("laporan/lap_rari/total_rari.php");
      break;
  }
}

}
