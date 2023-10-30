<?php 

$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

   
$session_query = $this->session->userdata('query_data_vendor_award');

$query = $this->db->query($session_query);

$rows = $query->result_array();


 $head = '
 <br>
 <br>
     <table style="width:100%;margin-top":30px;>
          <tr>
          
            <td colspan="9" style="padding: 2px 0px 2px 0px;text-align:center;height=100px;font-size:14px;font-weight:bold;">Vendor Awards</td>
         
            </tr>
      </table>
  <br>
  <br>
      ';

 $body = '

      <table cellpadding="5" style="solid #ddd;border-collapse: collapse; text-align: center;" width="100%" border="1">
      <thead style=" border: 1px solid #ddd;">
       <tr style="background-color:#337ab7;color:white;">
          <th style="width:30px">No</th>
          <th style="width:160px">Nama Vendor</th>
          <th style="width:100px">Total Nilai Kontrak</th>
          <th>Vendor Performance</th>
          <th>Jumlah Kontrak</th>
          <th>Jumlah Proyek</th>
          <th>Masa Kerja</th>
          <th>Jumlah / Total Nilai</th>
          <th style="width:40px">Rank</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;
foreach($rows as $key => $value) {

 
$content_table .=
'
<tr>
      <td style="width:30px;margin:10 10;">'.$no.'</td>
      <td style="width:160px">'.$value['vendor_name'].'</td>
      <td style="width:100px">'.inttomoney($value['total_contract_amount']).'</td>
      <td>'.(string)htmlentities(!empty($value['total_score_vpi']) ? inttomoney($value['total_score_vpi']) : "-").'</td>
      <td>'.inttomoney($value['jumlah_kontrak']).'</td>
      <td>'.inttomoney($value['total_proyek']).'</td>
      <td>'.inttomoney($value['masa_kerja']).'</td>
      <td>'.inttomoney($value['jumlah']).'</td>
      <td style="width:40px">'.$value['rank'].'</td>
</tr>
'
;

$no++;
}

$footer_table = '
</tbody>
</table>
';
  $footer_ttd = '<br><br><table cellpadding="2px"><tr><td colspan="4"></td><td colspan="6" style="text-align:center" border="1">Tanggal '.date('d-m-Y').'</td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">Disetujui oleh</td><td colspan="2" style="text-align:center" border="1">Diperiksa oleh</td><td colspan="2" style="text-align:center" border="1">Dibuat oleh</td></tr><tr><td colspan="4" style="height:50px"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" style="text-align:center" border="1"></td><td colspan="2" border="1"></td></tr><tr><td colspan="4"></td><td colspan="2" style="text-align:center" border="1">.....................</td><td colspan="2" style="text-align:center" border="1">....................</td><td colspan="2" style="text-align:center" border="1">(<b>'.$userdata ['complete_name'].'</b> )</td></tr></table>';




$data['nameExcel'] = "Daftar Vendor Awards.xls";
$data['namePDF'] = "Daftar Vendor Awards.pdf";
$data['data']= $head.$body.$content_table.$footer_table.$footer_ttd;
$data['colspan'] = 10;
$data['orientation'] = 'L';
$data['image_width'] = '110';
if (!empty($param3) AND $param3 == 'excel') {
  $this->generateExcel($data);
}elseif (!empty($param3) AND $param3 == 'pdf') {
  $this->generatePDF($data);
}