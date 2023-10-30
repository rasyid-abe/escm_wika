<?php 

$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

   
$session_query = $this->session->userdata('query_data_kebutuhan_pmcs');

$query = $this->db->query($session_query);

$rows = $query->result_array();


 $head = '
 <br>
 <br>
     <table style="width:100%;margin-top:30px;">
          <tr>
          
            <td colspan="9" style="padding: 2px 0px 2px 0px;text-align:center;height=100px;font-size:14px;font-weight:bold;">Laporan Kebutuhan PMCS '.date('Y').'</td>
         
            </tr>
      </table>
  <br>
  <br>
      ';

 $body = '
      <table cellpadding="5" style="solid #ddd;border-collapse: collapse; text-align: center;" width="100%" border="1" nobr="true">
      <thead style=" border: 1px solid #ddd;">
       <tr style="background-color:#337ab7;color:white;">
          <th style="width:30px;">No</th>
          <th style="width:100px">Departemen</th>
          <th style="width:50px">Kode SPK</th>
          <th style="width:110px">Nama Project</th>
          <th>Kode COA</th>
          <th>Nama COA</th>
          <th>Kode Sumberdaya</th>
          <th style="width:100px">Nama Sumberdaya</th>
          <th style="width:80px">Volume</th>
          <th style="width:40px">Satuan</th>
        </tr>
      </thead>
      <tbody>';


$content_table = '';
$no = 1;

foreach($rows as $key => $value) {

 
$content_table .=
'

<tr nobr="true">
      <td style="width:30px">'.(string)htmlentities($no).'</td>
      <td style="width:100px">'.(string)htmlentities($value['dept_name']).'</td>
      <td style="width:50px">'.(string)htmlentities($value['spk_code']).'</td>
      <td style="width:110px">'.(string)htmlentities($value['project_name']).'</td>
      <td>'.(string)htmlentities($value['coa_code']).'</td>
      <td>'.(string)htmlentities($value['coa_name']).'</td>
      <td>'.(string)htmlentities($value['smbd_code']).'</td>
      <td style="width:100px">'.(string)htmlentities($value['smbd_name']).'</td>
      <td style="width:80px">'.(string)htmlentities($value['smbd_quantity']).'</td>
      <td style="width:40px">'.(string)htmlentities($value['unit']).'</td>
</tr>
'
;

$no++;
}

$footer_table = '
</tbody>
</table>
';


$data = array();
$total_rows = count($rows);

//config excel
$last_row = 12+$total_rows;//data dimulai dari row A12,
$data['bordered_cells'] = "A12:J$last_row";
$data['img_header_position'] = "D1";
$data['nameExcel'] = "Laporan Kebutuhan PMCS ".date('Y').".xls";
$br_tambahan = (!empty($param1) AND $param1 == 'excel') ? " <br><br><br><br>" : "";
//end

//config pdf
$data['namePDF'] = "Laporan Kebutuhan PMCS ".date('Y').".pdf";
$data['colspan'] = 10;
$data['orientation'] = 'L';
$data['image_width'] = '110';
//end


$data['data'] = $br_tambahan.$head.$body.$content_table.$footer_table;


if (!empty($param1) AND $param1 == 'excel') {
  $this->generateExcel($data);
}elseif (!empty($param1) AND $param1 == 'pdf') {
  $this->generatePDF($data);
}
