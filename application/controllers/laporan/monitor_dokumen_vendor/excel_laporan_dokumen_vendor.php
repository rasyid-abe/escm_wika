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

 $head = '
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
     <table>
          <tr>
          <td></td>
            <td></td>          
            <td>Dokumen Vendor</td>
         
            </tr>
      </table>
  <br>
      ';

 $body = '

      <table>
      <thead>
       <tr>
          <th>No</th>
          <th>Nama Vendor</th>
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

$content_table .=
'
<tr>
      <td>'.$no.'</td>
      <td>'.(string)htmlentities($rpo['vendor_name']).'</td>
      <td>'.(string)htmlentities($rpo['reg_status_name']).'</td>
      <td>'.$rpo['address_domisili_exp_date'].'</td>
      <td>'.$rpo['sisa_address_domisili_exp_date'].'</td>
      <td>'.$rpo['siup_to'].'</td>
      <td>'.$rpo['sisa_siup_to'].'</td>
      <td>'.$rpo['tdp_to'].'</td>
      <td>'.$rpo['sisa_tdp_to'].'</td>
</tr>
'
;

$no++;
}

$footer_table = '
</tbody>
</table>
';

 $footer_ttd = ' <br>
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




$data['nameExcel'] = "Laporan Dokumen Vendor.xls";
// $data['namePDF'] = "Daftar Vendor Awards.pdf";
$data['data']= $head.$body.$content_table.$footer_table. $footer_ttd;
  $this->generateExcel($data);