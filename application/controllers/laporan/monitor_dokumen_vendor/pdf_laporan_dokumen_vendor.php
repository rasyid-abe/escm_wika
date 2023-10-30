<?php 
//hlmifzi


$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

$post = $this->input->post();
   
$session_query = $this->session->userdata('docVendQ');

$explodeLimit = explode('LIMIT',$session_query,2);

$query = $this->db->query($explodeLimit[0]);
$rows = $query->result_array();

foreach ($rows as $key => $value) {
 
  $domisiliDate = !empty($value['address_domisili_exp_date']) ? $value['address_domisili_exp_date'] : null  ;
  $siupDate     = !empty($value['siup_to']) ? $value['siup_to'] : null  ;
  $tdpDate      = !empty($value['tdp_to']) ? $value['tdp_to'] : null  ;

  $now = date("Y-m-d");
  $d1 = new DateTime($now);
  $d2 = new DateTime($domisiliDate);
  $numberDays = $d2->diff($d1)->format("%a");
 
    if ($numberDays > 60 && strtotime($domisiliDate) > strtotime($now) ){
      $labelColor = "info";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";
    } else if ($numberDays < 60 && $numberDays > 0 && strtotime($domisiliDate) > strtotime($now)){
      $labelColor = "warning";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";

    } else if(strtotime($domisiliDate) < strtotime($now)){
      $labelColor = "danger";
      $minus = "";
      $numberDays = "Sudah Kadaluarsa";
    }
  $TDPCount = '<label class="label label-'.$labelColor.'">'.$minus."".$numberDays.'</label>';
  $rows[$key]['address_domisili_exp_date'] = empty($domisiliDate) ? "-" : date('Y-m-d',strtotime($domisiliDate)).'<br/>' ;
  $rows[$key]['sisa_address_domisili_exp_date'] = $TDPCount ;
  $rows[$key]['color_address_domisili_exp_date'] = $labelColor ;
  
  
  $d1 = new DateTime($now);
  $d2 = new DateTime($siupDate);
  $numberDays =  $d2->diff($d1)->format("%a");
    if ($numberDays > 60 && strtotime($siupDate) > strtotime($now) ){
      $labelColor = "info";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";
    } else if ($numberDays < 60 && $numberDays > 0 && strtotime($siupDate) > strtotime($now)){
      $labelColor = "warning";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";

    } else if(strtotime($siupDate) < strtotime($now)){
      $labelColor = "danger";
      $minus = "";
      $numberDays = "Sudah Kadaluarsa";
    }
  $TDPCount = '<label class="label label-'.$labelColor.'">'.$minus."".$numberDays.'</label>';
  $rows[$key]['siup_to'] = empty($siupDate) ? "-" : date('Y-m-d',strtotime($siupDate)).'<br/>';
  $rows[$key]['sisa_siup_to'] = $TDPCount;
  $rows[$key]['color_siup_to'] = $labelColor;

  $d1 = new DateTime($now);
  $d2 = new DateTime($tdpDate);
  $numberDays =  $d2->diff($d1)->format("%a");
    if ($numberDays > 60 && strtotime($tdpDate) > strtotime($now) ){
      $labelColor = "info";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";
    } else if ($numberDays < 60 && $numberDays > 0 && strtotime($tdpDate) > strtotime($now)){
      $labelColor = "warning";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";

    } else if(strtotime($tdpDate) < strtotime($now)){
      $labelColor = "danger";
      $minus = "";
      $numberDays = "Sudah Kadaluarsa";
    }
  $TDPCount = '<label class="label label-'.$labelColor.'">'.$minus."".$numberDays.'</label>';
  $rows[$key]['tdp_to'] = empty($tdpDate) ? "-" : date('Y-m-d',strtotime($tdpDate)).'<br/>';
  $rows[$key]['sisa_tdp_to'] = $TDPCount;
  $rows[$key]['color_tdp_to'] = $labelColor;

}


/*$view = 'aset/report_aset_pdf';

$this->load->view($view,$d);*/


 $head = '
 <br>
 <br>
     <table style="width:100%;margin-top":30px;>
          <tr>
          
            <td colspan="9" style="padding: 2px 0px 2px 0px;text-align:center;height=100px;font-size:14px;font-weight:bold;">Laporan Status Vendor</td>
         
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
          <th style="width:100px">Nama Vendor</th>
          <th>Status</th>
          <th>Tangal Berlaku Domisili</th>
          <th>Masa Berlaku Domisili</th>
          <th>Tangal Berlaku SIUP</th>
          <th>Masa Berlaku SIUP</th>
          <th>Tangal Berlaku TDP</th>
          <th>Masa Berlaku TDP</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;
foreach($rows as $rpo) {

          if ($rpo['color_address_domisili_exp_date'] == "info") {
            $dom_Bcolor = "#2ECC71";
          } else if($rpo['color_address_domisili_exp_date'] == "warning") {
             $dom_Bcolor = "#E67E22";
          } else {
             $dom_Bcolor = "#E74C3C";
          }
 
           if ($rpo['color_siup_to'] == "info") {
             $siup_Bcolor = "#2ECC71";
           } else if($rpo['color_siup_to'] == "warning") {
              $siup_Bcolor = "#E67E22";
           } else {
              $siup_Bcolor = "#E74C3C";
           }
 
           if ($rpo['color_tdp_to'] == "info") {
             $tdp_Bcolor = "#2ECC71";
           } else if($rpo['color_tdp_to'] == "warning") {
              $tdp_Bcolor = "#E67E22";
           } else {
              $tdp_Bcolor = "#E74C3C";
           }
 
$content_table .=
'
<tr>
   <td style="width:30px">'.$no++.'</td>
   <td style="width:100px">'.$rpo['vendor_name'] .'</td>
   <td style="text-align:center">'.$rpo['reg_status_name'] .'</td>
   <td style="text-align:center">'.$rpo['address_domisili_exp_date'] .'</td>
   <td style="text-align:center;background-color:'.$dom_Bcolor.';color:#fff">'.$rpo['sisa_address_domisili_exp_date'] .'</td>
   <td style="text-align:center">'.$rpo['siup_to'] .'</td>
   <td style="text-align:center;background-color:'.$siup_Bcolor.';color:#fff">'.$rpo['sisa_siup_to'] .'</td>
   <td style="text-align:center">'.$rpo['tdp_to'] .'</td>
   <td style="text-align:center;background-color:'.$tdp_Bcolor.';color:#fff">'.$rpo['sisa_tdp_to'] .'</td>
</tr>
'
;
}

$footer_table = '
</tbody>
</table>
';

$ttd = '
<br />
<br />
<br />

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



$data['namePDF'] = "Laporan Dokumen Vendor.pdf";
$data['data']= $head.$body.$content_table.$footer_table.$ttd;

$this->generatePDF($data);