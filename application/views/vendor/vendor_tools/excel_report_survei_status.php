
 <?php 

$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

   
$session_query = $this->session->userdata('query_data_vendor_award');

$query = $this->db->query($session_query);

$rows = $query->result_array();


 $head = '
 <br>
 <br>
     <table>
          <tr>
          
            <td>Vendor Awards</td>
         
            </tr>
      </table>
  <br>
  <br>
      ';

 $body = '

      <table>
      <thead>
       <tr>
          <th>No</th>
          <th>Nama Vendor</th>
          <th>Total Nilai Kontrak</th>
          <th>Vendor Performance</th>
          <th>Jumlah Kontrak</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;
foreach($t_report_dist_dept as $rpo ) {

 
$content_table .=
'
<tr>
      <td>'.$no.'</td>
      <td>'.$rpo['vendor_name'].'</td>
      <td>'.$rpo['reg_status_name'].'</td>
      <td>'.$rpo['survey_date'].'</td>
      <td>'.$rpo['vc_start_date'].'</td>
</tr>
'
;

$no++;
}

$footer_table = '
</tbody>
</table>
';




$data['nameExcel'] = "Daftar Vendor Awards.xls";
$data['namePDF'] = "Daftar Vendor Awards.pdf";
$data['data']= $head.$body.$content_table.$footer_table;;
// if (!empty($param3) AND $param3 == 'excel') {
  $this->generateExcel($data);
// }elseif (!empty($param3) AND $param3 == 'pdf') {
//   $this->generatePDF($data);
// }