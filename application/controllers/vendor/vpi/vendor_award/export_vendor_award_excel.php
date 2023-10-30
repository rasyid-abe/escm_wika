<?php 

$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();
   
$session_query = $this->session->userdata('query_data_vendor_award');

$query = $this->db->query($session_query);

$rows = $query->result_array();


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
          <th>Total Nilai Kontrak</th>
          <th>Vendor Performance</th>
          <th>Jumlah Kontrak</th>
          <th>Jumlah Proyek</th>
          <th>Masa Kerja</th>
          <th>Jumlah / Total Nilai</th>
          <th>Rank</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;
$total_rows = count($rows);
foreach($rows as $key => $value) {

 
$content_table .=
'
<tr>
      <td>'.$no.'</td>
      <td>'.(string)htmlentities($value['vendor_name']).'</td>
      <td>'.inttomoney($value['total_contract_amount']).'</td>
      <td>'.(string)htmlentities(!empty($value['total_score_vpi']) ? $value['total_score_vpi'] : "-").'</td>
      <td>'.(string)htmlentities($value['jumlah_kontrak']).'</td>
      <td>'.(string)htmlentities($value['total_proyek']).'</td>
      <td>'.(string)htmlentities($value['masa_kerja']).'</td>
      <td>'.(string)htmlentities($value['jumlah']).'</td>
      <td>'.(string)htmlentities($value['rank']).'</td>
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




$last_row = 11+$total_rows;
$data['nameExcel'] = "Daftar Vendor Awards.xls";
$data['bordered_cells'] = "A11:I$last_row";
$data['data']= $head.$body.$content_table.$footer_table.$footer_ttd;
$this->generateExcel($data);
