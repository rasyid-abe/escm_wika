 <?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan Status Vendor.xls");
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
       <td colspan="5" style="font-size:24px;">
          <p align="center">Laporan Status Vendor <?php echo $report_dist_dept ?></p>
       </td>
    </tr>
 </table>

 <table id="datatables-ss" class="table table-bordered table-striped" border="1">
    <thead>
       <tr style="background-color:#337ab7;color:#fff">
          <th>No</th>
          <th>Nama Vendor</th>
          <th>Status</th>
          <th>Tabggal Survey</th>
          <th>Tanggal Registrasi</th>
       </tr>
    </thead>
    <tbody>
       <?php 
       $no = 0;
       foreach ($t_report_dist_dept as $rpo) { $no++ ?>
       <tr>
          <td><?php echo $no ?></td>
          <td><?php echo $rpo['vendor_name'] ?></td>
          <td><?php echo $rpo['reg_status_name'] ?></td>
          <td><?php echo $rpo['survey_date']  ?></td>
          <td><?php echo $rpo['vc_start_date']  ?></td>
       </tr>
       <?php }?>
    </tbody>

 </table>

 <table>
    <tr>
       <td colspan="2">
       </td>
       <td colspan="4" style="text-align:center" border="1">
          Tanggal <?php echo date('d-m-Y') ?>
       </td>
    </tr>
    <tr>
       <td colspan="2">
       </td>
       <td colspan="1" style="text-align:center" border="1">
          Disetujui oleh
       </td>
       <td colspan="1" style="text-align:center" border="1">
          Diperiksa oleh
       </td>
       <td colspan="1" style="text-align:center" border="1">
          Dibuat oleh
       </td>
    </tr>
    <tr>
       <td colspan="2" style="height:50px">
       </td>
       <td colspan="1" style="text-align:center" border="1">

       </td>
       <td colspan="1" style="text-align:center" border="1">

       </td>
       <td colspan="1" border="1">
       </td>
    </tr>
    <tr>
       <td colspan="2">

       </td>
       <td colspan="1" style="text-align:center" border="1">
          .....................
       </td>
       <td colspan="1" style="text-align:center" border="1">
          ....................
       </td>
       <td colspan="1" style="text-align:center" border="1">
          (<b><?php echo $user ?></b> )
       </td>
    </tr>
 </table>