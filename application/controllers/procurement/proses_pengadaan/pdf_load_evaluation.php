<?php 

$view = 'procurement/proses_pengadaan/view/load_evaluation_v';

$this->load->model(array("Administration_m"));
$userdata = $this->Administration_m->getLogin();

$ptm_number = $this->session->userdata("rfq_id");

$data['act'] = $this->uri->segment(3, 0);

$data['viewer'] = $this->uri->segment(4, 0);

$data['activity_id'] = $this->session->userdata("activity_id");

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$eval = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

$evaluation = $eval;

$first_price = array();

$this->db->distinct()->select("ptv_vendor_code");
$history = $this->Procrfq_m->getVendorQuoHistRFQ("",$ptm_number)->result_array();

foreach ($history as $key => $value) {
	if(!isset($first_price[$value['ptv_vendor_code']])){
		$this->db->distinct()->select("total,total_ppn")->order_by("pqm_created_date","asc");
		$dat = $this->Procrfq_m->getVendorQuoHistRFQ($value['ptv_vendor_code'],$ptm_number)->row_array();
		$first_price[$value['ptv_vendor_code']] = array(
			"total"=>$dat['total'],
			"total_ppn"=>$dat['total_ppn'],
			);
	}
}

$this->db->select("ptc_position,ptc_name");
$this->db->where("ptc_activity",1141);
$this->db->where("ptm_number",$ptm_number);
$ttdApproval = $this->db->get('prc_tender_comment')->result_array();


$this->db->select("distinct on (ptc_activity) ptc_position,ptc_name");
$this->db->where("ptc_activity",1040);
$this->db->where("ptm_number",$ptm_number);
$ttdBuyer = $this->db->get('prc_tender_comment')->row_array();

////////////////////////////////////////// content //////////////////////////////////////////////////


$head = '
<br>
<br>
	 <table style="width:100%;margin-top":30px;>
			<tr>
			
			  <td colspan="9" style="padding: 2px 0px 2px 0px;text-align:center;height=100px;font-size:14px;font-weight:bold;">Evaluasi Keputusan Pemilihan Pemasok<br/>
'.$ptm_number.'</td>
		  
			  </tr>
	  </table>
 <br>
 <br>
	  ';


 $body = ' <table class="table table-bordered" id="evaluasi_teknis_harga_table" border="1" style="font-size:6pt">
 <thead>
	 <tr>
		 <th rowspan="2" style="width:20px;background-color:#1a7bb9">#</th>
		 <th rowspan="2" style="background-color:#1a7bb9;color:white;">Nilai Total</th>
		 <th rowspan="2" style="background-color:#1a7bb9;color:white;">Nama Vendor</th>
		 <th rowspan="2" style="background-color:#1a7bb9;color:white;">Administrasi</th>
		 <th colspan="5" style="background-color:#1a7bb9;color:white;">Teknis</th>
		 <th colspan="6" style="background-color:#1a7bb9;color:white;">Harga</th>
	 </tr>
	 <tr>
		 <th style="background-color:#1a7bb9;color:white">Bobot</th>
		 <th style="background-color:#1a7bb9;color:white">Nilai</th>
		 <th style="background-color:#1a7bb9;color:white">Minimum</th>
		 <th style="background-color:#1a7bb9;color:white">Hasil</th>
		 <th style="background-color:#1a7bb9;color:white">Catatan</th>
		 <th style="background-color:#1a7bb9;color:white">Bobot</th>
		 <th style="background-color:#1a7bb9;color:white">Nilai</th>
		 <th style="background-color:#1a7bb9;color:white">Hasil</th>
		 <th style="background-color:#1a7bb9;color:white">Catatan</th>
		 <th style="background-color:#1a7bb9;color:white;">Penawaran</th>
		 <th style="background-color:#1a7bb9;color:white;">Setelah Nego</th>
	 </tr>
 </thead>
 <tbody>';

$content_table = "";
$no=1;
foreach ($evaluation as $key => $value) {

	if($value['adm'] == "Lulus"){ 
		$ColorAdm = "blue";
	} else { 
		$ColorAdm = "red";
	}
	if($value['pass'] == "Lulus"){ 
		$ColorTech = "blue";
	} else { 
		$ColorTech = "red";
	}
	if($value['pass_price'] == "Lulus"){ 
		$ColorPrice = "blue";
	} else { 
		$ColorPrice = "red";
	}

	if(isset($first_price[$value['ptv_vendor_code']]['total_ppn'])) { 
      $amountQuo = inttomoney($first_price[$value['ptv_vendor_code']]['total_ppn']);
    } else {
      $amountQuo = inttomoney($value['amount']);
	 }

	 if(isset($first_price[$value['ptv_vendor_code']]['total_ppn'])) {
	 $amountNegotiable = inttomoney($value['amount']);
	 } else {
		 $amountNegotiable ="";
	 }

$content_table .=
'
<tr>
   <td style="width:20px">'.$no++.'</td>
   <td>'.inttomoney($value['total']).'</td>
   <td>'.$value['vendor_name'].'</td>
   <td style="color:'.$ColorAdm.'">'.$value['adm'].'</td>
   <td>'.inttomoney($value['pte_technical_weight']).'</td>
   <td>'.inttomoney($value['pte_technical_value']) .'</td>
   <td>'.inttomoney($value['pte_passing_grade']).'</td>
   <td style="color:'.$ColorTech.'">'.$value['pass'].'</td>
   <td>'.$value['pte_technical_remark'].'</td>
   <td>'.inttomoney($value['pte_price_weight']).'</td>
   <td>'.inttomoney($value['pte_price_value']).'</td>
   <td style="color:'.$ColorPrice.'">'.$value['pass_price'].'</td>
   <td>'.$value['pte_price_remark'].'</td>
   <td>'.$amountQuo.'</td>
   <td>'.$amountNegotiable.'</td>

</tr>
'
;
}



$footer_table = '
</tbody>
</table>
';



$ttdPosition = "";
foreach ($ttdApproval as $key => $value) {
	$ttdPosition .= '
	  <td colspan="2" style="text-align:center" border="1">
         '.$value['ptc_position'].'
	  </td>
	';
}


$ttdNya = "";
foreach ($ttdApproval as $key => $value) {
	$ttdNya .= '
	<td colspan="2" style="text-align:center" border="1">
     
	</td>
	';
}

$ttdHirarki = "";
foreach ($ttdApproval as $key => $value) {
	$ttdHirarki .= '
	  <td colspan="2" style="text-align:center" border="1">
         <b>'.$value['ptc_name'].'</b>
	  </td>
	';
}

$ttd = '
<br />
<br />
<br />

<table>
  <tr>
      <td colspan="4">
    </td>
    <td colspan="6" style="text-align:center"  border="1">
      Tanggal '.date('d-m-Y').'
    </td>
  </tr>
   <tr>
      <td colspan="4">
		</td>
		'.$ttdPosition.'
		<td colspan="2" style="text-align:center" border="1">
         '.$ttdBuyer['ptc_position'].' )
      </td>
   </tr>
   <tr>
      <td colspan="4" style="height:50px">
      </td>
		 '.$ttdNya.'
		 <td colspan="2" style="text-align:center" border="1">
		</td>
   </tr>
   <tr>
      <td colspan="4">
       
      </td>
		'.$ttdHirarki.'
      <td colspan="2" style="text-align:center" border="1">
         (<b>'.$ttdBuyer['ptc_name'].'</b> )
      </td>
   </tr>
</table>
';




$data['namePDF'] = "Laporan Teknis & Harga.pdf";
$data['data']= $head.$body.$content_table.$footer_table.$ttd;
// $data['data']= $head.$body.$content_table.$footer_table.$ttd;

$this->generatePDF($data);