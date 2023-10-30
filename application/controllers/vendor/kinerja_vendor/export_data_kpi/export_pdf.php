<?php 

$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

   
$session_query = $this->session->userdata('query_export_kpi_vendor');

$query = $this->db->query($session_query);

$rows = $query->result_array();


 $head = '
 <br>
 <br>
     <table style="width:100%;margin-top":30px;>
          <tr>
          
            <td colspan="9" style="padding: 2px 0px 2px 0px;text-align:center;height=100px;font-size:14px;font-weight:bold;">Laporan KPI</td>
         
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
          <th>Klasifikasi</th>
          <th>Invited</th>
          <th>Register</th>
          <th>Quote</th>
          <th>Win</th>
          <th>Rata-rata score VPI</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;
foreach($rows as $key => $value) {

 
$content_table .=
'
<tr>
      <td style="width:30px">'.$no.'</td>
      <td style="width:100px">'.$value['vendor_name'].'</td>
      <td>'.$value['fin_class_name'].'</td>
      <td>'.$value['invited'].'</td>
      <td>'.$value['reg'].'</td>
      <td>'.$value['quote'].'</td>
      <td>'.$value['win'].'</td>
      <td>'.$value['average_score'].'</td>
</tr>
'
;

$no++;
}

$footer_table = '
</tbody>
</table>
';




$data['namePDF'] = "Laporan KPI.pdf";
$data['data']= $head.$body.$content_table.$footer_table;

$this->generatePDF($data);