<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan Dokumen Vendor.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<table>
   <tr>
      <td colspan="5" style="height:200px">
         <img src="<?php echo base_url() ?>assets/img/logopdf.png" width="70%">
      </td>
   </tr>
</table>

<table>
   <tr>
      <td colspan="9" style="font-size:24px;">
         <p align="center">Laporan Dokumen Vendor</p>
      </td>
   </tr>
</table>

<table id="datatables-ss" class="table table-bordered table-striped" border="1">
   <thead>
      <tr style="background-color:#337ab7;color:#fff">
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
   <tbody>
      <?php 
       $no = 0;
       foreach ($t_report_dist_dept as $rpo) { $no++ ?>
         <?php
          if ($rpo['color_address_domisili_exp_date'] == "info") {
            $dom_Bcolor = "green";
          } else if($rpo['color_address_domisili_exp_date'] == "warning") {
             $dom_Bcolor = "orange";
          } else {
             $dom_Bcolor = "red";
          }
 
           if ($rpo['color_siup_to'] == "info") {
             $siup_Bcolor = "green";
           } else if($rpo['color_siup_to'] == "warning") {
              $siup_Bcolor = "orange";
           } else {
              $siup_Bcolor = "red";
           }
 
           if ($rpo['color_tdp_to'] == "info") {
             $tdp_Bcolor = "green";
           } else if($rpo['color_tdp_to'] == "warning") {
              $tdp_Bcolor = "orange";
           } else {
              $tdp_Bcolor = "red";
           }
 
      ?>
      <tr>
         <td><?php echo $no ?></td>
         <td><?php echo $rpo['vendor_name'] ?></td>
         <td><?php echo $rpo['reg_status_name'] ?></td>
         <td><?php echo $rpo['address_domisili_exp_date']  ?></td>
         <td style="background-color:<?php echo $dom_Bcolor; ?>;color:#fff">
            <?php echo $rpo['sisa_address_domisili_exp_date']  ?></td>
         <td><?php echo $rpo['siup_to']  ?></td>
         <td style="background-color:<?php echo $siup_Bcolor; ?>;color:#fff"><?php echo $rpo['sisa_siup_to']  ?></td>
         <td><?php echo $rpo['tdp_to']  ?></td>
         <td style="background-color:<?php echo $tdp_Bcolor; ?>;color:#fff"><?php echo $rpo['sisa_tdp_to']  ?></td>
      </tr>
      <?php }?>
   </tbody>

</table>


<table>
   <tr>
      <td colspan="3" style="height:50px">
      </td>
      <td colspan="2">
      </td>
   </tr>
</table>

<table>
   <tr>
      <td colspan="4">
      </td>
      <td colspan="6" style="text-align:center" border="1">
         Tanggal <?php echo date('d-m-Y') ?>
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
      <td colspan="2" style="text-align:center" border="1">
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
         (<b><?php echo $user ?></b> )
      </td>
   </tr>
</table>


<?
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
            <td>Vendor Awards</td>
         
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
foreach($t_report_dist_dept as $rpo) {

$content_table .=
'
<tr>
      <td>'.$no.'</td>
      <td>'.(string)htmlentities($value['vendor_name']).'</td>
      <td>'.(string)htmlentities($value['reg_status_name']).'</td>
      <td>'.(string)htmlentities($value['address_domisili_exp_date']).'</td>
      <td>'.(string)htmlentities($value['color_address_domisili_exp_date']).'</td>
      <td>'.(string)htmlentities($value['sisa_address_domisili_exp_date']).'</td>
      <td>'.(string)htmlentities($value['siup_to']).'</td>
      <td>'.(string)htmlentities($value['color_siup_to']).'</td>
      <td>'.(string)htmlentities($value['tdp_to']).'</td>
      <td>'.(string)htmlentities($value['color_tdp_to']).'</td>
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




$data['nameExcel'] = "Daftar Vendor Awards.xls";
$data['namePDF'] = "Daftar Vendor Awards.pdf";
$data['data']= $head.$body.$content_table.$footer_table. $footer_ttd;
  $this->generateExcel($data);