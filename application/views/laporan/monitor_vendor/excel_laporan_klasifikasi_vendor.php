 <?php

// header("Content-type: application/vnd.ms-excel");
// header("Content-Disposition: attachment; filename=Laporan Klasifikasi Vendor.xls");
// header("Pragma: no-cache");
// header("Expires: 0");

?>
 <!-- <table>
    <tr>
       <td>
          <p align="center">Laporan Status Vendor <?php echo $report_dist_dept ?></p>
       </td>
    </tr>
 </table>

 <table>
    <thead>
       <tr>
          <th>No</th>
          <th>Nama Vendor</th>
          <th>Status</th>
          <th>Jenis Vendor</th>
          <th>Klasifikasi</th>
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
          <td><?php echo $rpo['acj_name']  ?></td>
          <td><?php echo $rpo['fin_class_name']  ?></td>

       </tr>
       <?php }?>
    </tbody>

 </table>

 <table>
    <tr>
       <td>
       </td>
       <td>
          Tanggal <?php echo date('d-m-Y') ?>
       </td>
    </tr>
    <tr>
       <td>
       </td>
       <td>
          Disetujui oleh
       </td>
       <td>
          Diperiksa oleh
       </td>
       <td>
          Dibuat oleh
       </td>
    </tr>
    <tr>
       <td>
       </td>
       <td>

       </td>
       <td>

       </td>
       <td>
       </td>
    </tr>
    <tr>
       <td>

       </td>
       <td>
          .....................
       </td>
       <td>
          ....................
       </td>
       <td>
          (<b><?php echo $user ?></b> )
       </td>
    </tr>
 </table>
 -->

 <?php
//  var_dump($user);
//  die();

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
          <th>Jenis Vendor</th>
          <th>Klasifikasi</th>
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
      <td>'.(string)htmlentities($rpo['vendor_name']).'</td>
      <td>'.(string)htmlentities($rpo['reg_status_name']).'</td>
      <td>'.(string)htmlentities($rpo['acj_name']).'</td>
      <td>'.(string)htmlentities($rpo['fin_class_name']).'</td>
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
                        <td colspan="1" style="text-align:center" border="1">(<b>'.$user.'</b> )</td>
                      </tr>
                      </table>';




$data['nameExcel'] = "Daftar Vendor Awards.xls";
$data['data']= $head.$body.$content_table.$footer_table. $footer_ttd;
  
$this->generateExcel($data);