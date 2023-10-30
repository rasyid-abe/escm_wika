<?php 

$userdata = $this->data['userdata'];

$url = site_url()."/laporan/crawl_analisa_plan/xlsx";

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
          <td>Analisa Perencanaan</td>  
          </tr>
    </table>
<br>';


$body = file_get_contents($url);

 $footer_ttd = ' <br>
 <br>
 <br>
  <table>
    <tr>
      <td colspan="3">Tanggal '.date('d-m-Y').'</td>
    </tr>
    <tr>
      <td>Disetujui oleh</td>
      <td>Diperiksa oleh</td>
      <td>Dibuat oleh</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td>.....................</td>
      <td>....................</td>
      <td>(<b>'.$userdata['complete_name'].'</b> )</td>
    </tr>
  </table>';




$data['nameExcel'] = "Laporan Analisa Perencanaan.xls";
$data['data']= $head.$body.$footer_ttd;

// echo $data['data']; 
  $this->generateExcel($data);