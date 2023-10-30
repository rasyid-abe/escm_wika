<?php 
//hlmifzi
$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

$post = $this->input->post();

$tgl_awal        = !empty($this->session->userdata('tgl_awal')) ? $this->session->userdata('tgl_awal') : 0;
$tgl_akhir       = !empty($this->session->userdata('tgl_akhir')) ? $this->session->userdata('tgl_akhir') : 0;
// $report_tulis = $this->db->query("SELECT
//   (SELECT district_name FROM adm_district WHERE district_id = $district_id) as district_name,
//   (SELECT satker_name FROM adm_satker WHERE satker_id = $satker_id) as satker_name")->row_array();

$report_dist_dept = '';

    if (!empty($range_awal)) {
       $report_dist_dept .= ' Dari Tanggal <label class="btn btn-xs btn-primary">'.$tgl_awal.'</label> ';
    }
    if (!empty($tgl_akhir_inp)) {
        $report_dist_dept .= ' Sampai Tanggal  <label class="btn btn-xs btn-primary">'.$tgl_akhir.'</label> ';
    }
    
$d['report_dist_dept']  = $report_dist_dept;
// $session_query = $this->session->userdata('statvendQ');
// $query = $this->db->query($session_query);
$session_query = $this->session->userdata('statvendQ');

$explodeLimit = explode('LIMIT',$session_query,2);

$query = $this->db->query($explodeLimit[0]);
$sess['tgl_awal'] = $tgl_awal;
$sess['tgl_akhir'] = $tgl_akhir;
$this->session->set_userdata($sess);

$rows = $query->result_array();

foreach ($rows as $key => $value) {
  $now = date("Y-m-d");
  $rows[$key]['vc_start_date'] = !empty($value['vc_start_date']) ? date("Y-m-d",strtotime($value['vc_start_date'])) : "-" ;

  //////////////////// aktif kontrak 3 tahun ///////////////////////////
  $rows[$key]['end_date'] = !empty($value['end_date']) ? "<label class='label label-success'>Aktif ".date("Y-m-d",strtotime($value['end_date']))."</label>" : "<label class='label label-danger'>Pasif</label>" ;
  $d1 = new DateTime($now);
  $d2 = new DateTime($value['end_date']);
  $numberDays = $d1->diff($d2)->m + ($d1->diff($d2)->y*12);
  if ($numberDays > 36 && strtotime($domisiliDate) < strtotime($now) ){
    $rows[$key]['end_date'] = "<label class='label label-danger'>Pasif</label>" ;
  } else {

  }
  /////////////////////aktif kontrak >3 tahun ////////////////////////////

}

$d['t_report_dist_dept'] = $rows;
$d['user'] = $userdata['complete_name'];

$view = 'laporan/monitor_vendor/excel_report_vendor_status';

$this->load->view($view,$d);

 $head = '<br>
 <br>
 <br>
 <br>
 <br>
 <br>
     <table>
          <tr>
          <td></td>
            <td></td>          
            <td>Laporan Status Vendor '.$report_dist_dept.'</td>
         
            </tr>
      </table>
  <br>
  <br>
      ';

 $body = '

       <table>
      <thead >
       <tr >
          <th>No</th>
          <th>Nama Vendor</th>
          <th>Status</th>
          <th>Aktif/Pasif Berkontrak</th>
          <th>Tanggal Registrasi</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;
foreach($rows as $rpo) {

$content_table .= 
    '
     <tr>
      <td >'.$no++.'</td>
      <td >'.(string)htmlentities($rpo['vendor_name']) .'</td>
      <td>'.(string)htmlentities($rpo['reg_status_name']) .'</td>
      <td>'.$rpo['end_date'].'</td>
      <td>'.(string)htmlentities($rpo['vc_start_date'])  .'</td>
    </tr>
    '
     ;
       }

      $footer_table = '
              </tbody>             
              </table>
      ';

      $ttd = ' <br>
 <br>
 <br>
             <table>
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


$data['nameExcel'] = "Laporan Status Vendor.xls";
$data['data']= $head.$body.$content_table.$footer_table.$ttd;

$this->generateExcel($data);