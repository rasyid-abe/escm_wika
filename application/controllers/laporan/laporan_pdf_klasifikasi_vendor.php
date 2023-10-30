<?php 
//tfk


$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

$post = $this->input->post();

$post = $this->input->post();

$tgl_awal        = !empty($this->session->userdata('tgl_awal')) ? $this->session->userdata('tgl_awal') : 0;
$tgl_akhir       = !empty($this->session->userdata('tgl_akhir')) ? $this->session->userdata('tgl_akhir') : 0;
$tgl_survei_awal        = !empty($this->session->userdata('tgl_survei_awal')) ? $this->session->userdata('tgl_survei_awal') : 0;
$tgl_survei_akhir       = !empty($this->session->userdata('tgl_survei_akhir')) ? $this->session->userdata('tgl_survei_akhir') : 0;
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
    
    
$report_dist_dept  = $report_dist_dept;
$session_query = $this->session->userdata('klasifikasi');


$explodeLimit = explode('LIMIT',$session_query,2);

$query = $this->db->query($explodeLimit[0]);
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


/*$view = 'aset/report_aset_pdf';

$this->load->view($view,$d);*/


 $head = '
 <br>
 <br>
     <table style="width:100%;margin-top":30px;>
          <tr>
          
            <td colspan="4" style="padding: 2px 0px 2px 0px;text-align:center;height=100px;font-size:14px;font-weight:bold;">Laporan Klasifikasi Vendor '.$report_dist_dept.'</td>
         
            </tr>
      </table>
  <br>
  <br>
      ';

 $body = '

       <table style="solid #ddd;border-collapse: collapse;" width="100%" border="1">
      <thead style=" border: 1px solid #ddd;">
       <tr style="background-color:#337ab7;color:white;">
          <th style="width:30px">No</th>
          <th style="width:150px">Nama Vendor</th>
          <th>Status</th>
          <th>Jenis Vendor</th>
          <th>Klasifikasi</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;
foreach($rows as $rpo) {

$content_table .= 
    '
     <tr>
      <td style="width:30px">'.$no++.'</td>
      <td style="width:150px">'.$rpo['vendor_name'] .'</td>
      <td style="text-align:center">'.$rpo['reg_status_name'] .'</td>
      <td style="text-align:center">'.$rpo['acj_name']  .'</td>
      <td style="text-align:center">'.$rpo['fin_class_name']  .'</td>
    </tr>
    '
     ;
       }

      $footer_table = '
              </tbody>             
              </table>
      ';

      $ttd = '  
      <br/>
      <br/>
      <br/>


      <table>
  <tr>
      <td colspan="4">
    </td>
    <td colspan="6" style="text-align:center"  border="1">
      Tanggal '.date('Y-m-d').'
    </td>
  </tr>
   <tr>
      <td colspan="4">
      </td>
      <td colspan="2" style="text-align:center" border="1">
         Disetujui oleh
      </td>
      <td colspan="2" style="text-align:center" border="1">
         Diperiksa oleh
      </td>
      <td colspan="2" style="text-align:center"  border="1">
         Dibuat oleh
      </td>
   </tr>
   <tr>
      <td colspan="4" style="height:50px">
      </td>
       <td colspan="2" style="text-align:center" border="1">
     
      </td>
      <td colspan="2" style="text-align:center" border="1">
        
      </td>
      <td colspan="2" border="1">
      </td>
   </tr>
   <tr>
      <td colspan="4">
       
      </td>
      <td colspan="2" style="text-align:center" border="1">
        .....................
      </td>
      <td colspan="2" style="text-align:center" border="1">
         ....................
      </td>
      <td colspan="2" style="text-align:center" border="1">
         (<b>'.$userdata ['complete_name'].'</b> )
      </td>
   </tr>
</table>

';



$data['namePDF'] = "Laporan Klasifikasi Vendor.pdf";
$data['data']= $head.$body.$content_table.$footer_table.$ttd;

$this->generatePDF($data);