<style type="text/css">
	html{
		font-family:sans-serif;
	}
	table {
		font-size: 10px;
	}

	td {
		padding: 5px;
	}

	th {
		padding: 5px;
		font-weight: bold;
		/*background-color: #b0ffc2;*/
		background-color: #00aeef;
	}

	p{
		font-size:10px;
	}

	#table-content {
		font-size: 40%;
	}

	.is-content {
		border-collapse: collapse;
	}

	.is-content td {
		border: 1px solid black;
	}

	.is-content th {
		border: 1px solid black;
	}
</style>

<?php $tgl_penetapan_pemenang = date('Y-m-d'); ?>

<table style="width: 100%;">
<tr>
	<td width="1%"><img width="50" src="<?php echo base_url('assets/img/favicon.png') ?>"></td>
	<td ><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo "Divisi Supply Chain Management"; ?></td>

</tr>
</table>
<br>
<br>
<center>
	<h5 style="margin:0px;">BERITA ACARA KEPUTUSAN PEMENANG
		<h6 style="margin:0px;"><?php echo "NOMOR : TP.01.09/A.DSCM.00368/2020";//. $contract_number; ?></h6>
		<h6 style="margin:0px;"><?php echo "TANGGAL : ". date('d F Y', strtotime($tgl_penetapan_pemenang)); ?></h6>
	</h5>
</center>

<p>Pada hari ini <?php echo strtolower($this->terbilang->hari_indo(date('D'))); ?> tanggal <font style="font-weight:bold;"><?php echo strtolower($this->terbilang->eja(date('d')))." bulan ".date('F')." tahun ". strtolower($this->terbilang->eja(date('Y'))); ?><?php echo date('(d-m-Y)', strtotime($tgl_penetapan_pemenang)); ?></font> di <?php echo $kota; ?> telah dilaksanakan rapat penentuan/pengusulan pemutusan pemenang subkon / pemasok , untuk :</p>

<table style="width:100%;">
	<tr>
		<td width="1%;">1.</td>
		<td width="12%;">Paket Pengadaan</td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_project_name']; ?></td>
	</tr>
	<tr>
		<td width="1%;">2.</td>
		<td width="12%;">Proyek</td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_district_name']; ?></td>
	</tr>
	<tr>
		<td width="1%;">3.</td>
		<td width="12%;">Departemen/ Divisi</td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_dept_name']; ?></td>
	</tr>
	<tr>
		<td width="1%;">4.</td>
		<td width="12%;">Nilai RAB/HPS</td>
		<td style="width:1%;">:</td>
		<td><?php echo "Rp. ".inttomoney($nilai_hps); ?></td>
	</tr>
</table>

<p style="font-weight:bold;">Dengan Hasil Sebagai Berikut</p>

<p >1. Hasil Permintaan Penawaran</p>

<table style="width:100%;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Penyedia yang Diundang</th>
		<th align="center">Daftar (Ya/Tidak)</th>
		<th align="center">Memasukan Penawaran (Ya/Tidak)</th>
		<th align="center">Catatan</th>
	</tr>

	<?php
		$par = 1;
		$catatan_penawaran = array();

		foreach ($vendor_verifikasi as $key => $value) {

			$dataPenwaran = $this->Procrfq_m->isKirimPenawaran($value['pvs_vendor_code'], $ptm_id)->row_array();


			$hadir = ($value['is_attend'] == "Yes") ? "Ya" : "Tidak";
			$penawaran = ($dataPenwaran) ? "Ya" : "Tidak";

			$catatan_ = "";
			if ($data_uskep['bakp_catatan_penawran'] != '') {
				$catatan_ = explode(";", $data_uskep['bakp_catatan_penawran'])[$par - 1];
			}

			echo '<tr>
					<td align="center">'.$par.'</td>
					<td align="left">'.$value['vendor_name'].'</td>
					<td align="center">'.$hadir.'</td>
					<td align="center">'.$penawaran.'</td>
					<td align="center">'.$catatan_.'</td>
				</tr>';

				array_push($catatan_penawaran, $value['pvs_technical_remark']);

		$par += 1;
		}
	?>

</table>

<p >2. Hasil Evaluasi Penilaian</p>

<p style="margin-left: 10px;">2.1 Administrasi</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Lulus</th>
		<th align="center">Tidak Lulus</th>
		<th align="center">Catatan</th>
	</tr>

	<?php
		$par = 1;
		foreach ($evaluation as $key => $value) {

			$lulus = "";
			$tidak_lulus = "";
			if ($value['adm'] == "Lulus") {
				$lulus = "Lulus";
				$tidak_lulus = "";
			} else {
				$lulus = "";
				$tidak_lulus = "Tidak Lulus";
			}
			echo '<tr>
					<td align="center">'.$par.'</td>
					<td align="left">'.$value['vendor_name'].'</td>
					<td align="center">'.$lulus.'</td>
					<td align="center">'.$tidak_lulus.'</td>
					<td align="center">'.$catatan_penawaran[$par-1].'</td>
				</tr>';


			$par += 1;
		}
	?>
</table>

<p style="margin-left: 10px;">2.2 Teknis</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Nilai</th>
		<th align="center">Nilai x Bobot</th>
		<th align="center">Catatan</th>
	</tr>

	<?php
		$par = 1;
		foreach ($evaluation as $key => $value) {


			echo '<tr>
					<td align="center">'.$par.'</td>
					<td align="left">'.$value['vendor_name'].'</td>
					<td align="center">'.number_format($value['pte_technical_value'], 2, '.', '').'</td>
					<td align="center">'.number_format($value['pte_technical_weight'], 2, '.', '').'</td>
					<td align="center">'.$value['pte_technical_remark'].'</td>
				</tr>';


			$par += 1;
		}
	?>

</table>

<p style="margin-left: 10px;">2.3 Harga</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Harga Negosiasi</th>
		<th align="center">Efisiensi</th>
		<th align="center">Nilai</th>
		<th align="center">Nilai x Bobot</th>
	</tr>

	<?php
		$par = 1;
		foreach ($evaluation as $key => $value) {

			echo '<tr>
					<td align="center">'.$par.'</td>
					<td align="left">'.$value['vendor_name'].'</td>
					<td align="right">Rp. '.inttomoney($value['amount']).'</td>
					<td align="right">Rp. '.inttomoney(($nilai_hps - $value['amount'])).'</td>
					<td align="center">'.number_format($value['pte_price_value'], 2, '.', '').'</td>
					<td align="center">'.number_format($value['pte_price_weight'], 2, '.', '').'</td>
				</tr>';


			$par += 1;
		}
	?>

</table>

<p style="margin-left: 10px;">2.4 Total</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Total Nilai</th>
		<th align="center">Peringkat</th>
		<th align="center">Keterangan</th>
	</tr>

	<?php
		$par = 1;
		foreach ($evaluation as $key => $value) {

			echo '<tr>
					<td align="center">'.$par.'</td>
					<td align="left">'.$value['vendor_name'].'</td>
					<td align="center">'.number_format($value['total'], 2, '.', '').'</td>
					<td align="center">'.$par.'</td>
					<td align="center"></td>
				</tr>';


			$par += 1;
		}
	?>

</table>


<p >3. Komisi Pengadaan sepakat memutuskan pemenang untuk paket pekerjaan di atas adalah:</p>

<table style="width:100%; margin-left: 10px;"  class="is-content">

	<?php
		$par = 1;
		foreach ($evaluation as $key => $value) {

			if ($par == 1) { ?>

				<tr>
					<td width="12%;">Nama Penyedia</td>
					<td style="width:1%;">:</td>
					<td><?php echo $value['vendor_name']; ?></td>
				</tr>
				<tr>
					<td width="12%;">Omset Kontrak </td>
					<td style="width:1%;">:</td>
					<td><?php echo 'Rp. '.inttomoney($value['amount']); ?></td>
				</tr>


			<?php }

			$par += 1;
		}
	?>


</table>

<p >4. Catatan - catatan :</p>


<table style="width:100%;margin-left: 10px;" id="tabel-catatan">
	<tr>
		<td width="2%;">-</td>
		<td colspan="2">Semua Peserta Rapat menyepakati keputusan</td>
	</tr>
	<tr>
		<td width="2%;">-</td>
		<td colspan="2" valign="middle">Dengan Alasan pengusulan sebagai berikut : </td>
	</tr>
	<?php $par = 1; foreach ($catatan as  $valuec) { ?>
		<tr class="cat">
			<td width="1%;" ></td>
			<td width="1%;" ><?php echo $par; ?></td>
			<td ><?php echo $valuec; ?></td>
		</tr>
	<?php $par += 1; }  ?>

</table>

<div style="page-break-before:always"></div>
<!-- ====================================================== PENILAIAN ================================================================= -->
<style type="text/css">
	html{
		font-family:sans-serif;
	}
	table {
		font-size: 10px;
	}

	td {
		padding: 5px;
	}

	th {
		padding: 5px;
		font-weight: bold;
		/*background-color: #b0ffc2;*/
		background-color: #00aeef;
	}

	p{
		font-size:10px;
	}

	#table-content {
		font-size: 40%;
	}

	.is-content {
		border-collapse: collapse;
	}

	.is-content td {
		border: 1px solid black;
	}

	.is-content th {
		border: 1px solid black;
	}
	.button {
	  background-color: #4CAF50; /* Green */
	  border: none;
	  color: white;
	  padding: 15px 32px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 10px;
	}
</style>

<?php $tgl_penetapan_pemenang = date('Y-m-d'); ?>

<table style="width: 100%;">
<tr>
	<td width="1%"><img width="50" src="<?php echo base_url('assets/img/favicon.png') ?>"></td>
	<td ><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $tender['ptm_dept_name']; ?></td>

</tr>
</table>
<br>
<center>
	<h5 style="margin:0px;">DOKUMEN SISTEM PENILAIAN</h5>
</center>
<br>

<table style="width:100%;">
	<tr>
		<td width="12%;">Paket Pengadaan</td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_project_name']; ?></td>
	</tr>
	<tr>
		<td width="12%;">Proyek</td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_district_name']; ?></td>
	</tr>
	<tr>
		<td width="12%;">No RFQ</td>
		<td style="width:1%;">:</td>
		<td><?php echo $ptm_id; ?></td>
	</tr>
</table>

<p style="font-weight:bold;">Sistem Penilaian</p>

<table style="width:100%;" class="is-content">
<tr>
			<th align="center" rowspan="2">No</th>
			<th align="center" rowspan="2">Uraian</th>
			<th align="center" rowspan="2">Bobot</th>
			<th align="center" colspan="<?php echo count($vendor_verifikasi); ?>">Penyedia Jasa / Pemasok</th>
		</tr>

		<tr>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<th>".$value['vendor_name']."</th>";
			}
			?>
		</tr>

		<tr>
			<td align="center">I</td>
			<td align="left"><b>ADMINISTRASI</b></td>
			<td align="center"><b>Wajib</b></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Putusan</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".$value['adm']."</b></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"><b>A</b></td>
			<td align="left"><b>Surat Penawaran yang ditanda tangani direksi</b></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center">1</td>
			<td align="left">Kelengkapan</td>
			<td align="center">(ada/tidak)</td>
			<?php
			$par = 0;
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".$kelengkapan[$par]."</td>";
				$par += 1;
			}
			?>
		</tr>

	<tr>
		<td align="center">2</td>
		<td align="left">Kesesuaian</td>
		<td align="center">(sesuai/tidak sesuai)</td>
		<?php
		$par = 0;
		foreach ($evaluation as $key => $value) {
			echo "<td align='center'>".$kesesuaian[$par]."</td>";
			$par += 1;
		}
		?>
		</tr>


		<tr>
			<td align="center"><b>B</b></td>
			<td align="left"><b>BOQ</b></td>
			<td align="center"></td>
			<?php
			$par = 0;
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".$kelengkapan[$par]."</td>";
				$par += 1;
			}
			?>
		</tr>

		<tr>
			<td align="center">1</td>
			<td align="left">Kelengkapan</td>
			<td align="center">(ada/tidak)</td>
			<?php
			$par = 0;
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".$kesesuaian[$par]."</td>";
				$par += 1;
			}
			?>
			</tr>

	<tr>
		<td align="center">2</td>
		<td align="left">Kesesuaian</td>
		<td align="center">(sesuai/tidak sesuai)</td>
		<?php
		$par = 0;
		foreach ($evaluation as $key => $value) {
			echo "<td align='center'>".$kesesuaian[$par]."</td>";
			$par += 1;
		}
		?>
		</tr>


		<tr>
			<td align="center"></td>
			<td align="left"></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center">II</td>
			<td align="left"><b>TEKNIS</b></td>
			<td align="center"><?php echo $evaluation_method['evt_tech_weight'].'%'; ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Threshold</td>
			<td align="center"><?php echo $evaluation_method['evt_passing_grade'].''; ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".number_format($value['pte_technical_value'], 2, '.', '')."</td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai x Bobot</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['pte_technical_weight'], 2, '.', '')."</b></td>";
			}
			?>
		</tr>
		<?php

		$par = 1;
		foreach ($evaluation_method_details as $key => $value) {

			$content_a = '';
			$content_b = '';
			$bobotNilai = $value['etd_weight']/100;

			foreach ($evaluation as $key => $value2) {

				$dataQuo = $this->Procrfq_m->getPQMID($value2['ptv_vendor_code'], $ptm_id)->row_array();
				$dataEval = $this->Procrfq_m->getQuoTech($dataQuo['pqm_id'], $value['etd_item'])->row_array();

				if ($value['etd_weight'] == 0) {
					if ($dataEval['pqt_check_vendor'] == 1) {
						$dataEval['pqt_value'] = 100;
					}
				}

				$content_a .= "<td align='center'><b>".$bobotNilai * $dataEval['pqt_value']."</b></td>";
				$content_b .= "<td rowspan='' align='center'><b>".number_format($dataEval['pqt_value'], 2, '.', '')."</b></td>";

			}

			echo '
			<tr>
				<td align="center">'.$par.'</td>
				<td align="left"><b>'.$value['etd_item'].'</b></td>
				<td align="center"><b>'.$value['etd_weight'].'%</b></td>
				'.$content_a.'
			</tr>

			';

			$this->db->where('detail_evaluasi_id', $value['etd_id']);
			$petunjukScoreList = $this->db->get('prc_evaluation_petunjuk_score')->result_array();

			if(count($petunjukScoreList) > 0)
			{
				foreach($petunjukScoreList as $key_score => $v_score) {
					# code...
					echo '
					<tr>
						<td align="center">-</td>
						<td align="left"><b>'.$v_score['deskripsi'].'</b></td>
						<td align="center">'.$v_score['bobot'].'</td>
						'.$content_b.'
					</tr>

					';

				}
			}




		$par += 1;
		}


		?>
		<tr>
			<td align="center"></td>
			<td align="left"></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center">III</td>
			<td align="left"><b>HARGA</b></td>
			<td align="center"><?php echo $evaluation_method['evt_price_weight'].'%'; ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai HPS</td>
			<td align="center"><?php echo number_format($nilai_hps, 2); ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".number_format($value['pte_price_value'], 2, '.', '')."</td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai x Bobot</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['pte_price_weight'], 2, '.', '')."</b></td>";
			}
			?>
		</tr>


			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>
		<tr>
			<td align="center">A</td>
			<td align="left"><b>ASPEK HARGA</b></td>
			<td align="center"><?php  ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>


		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>Harga Negosiasi Final(dalam Rupiah)</b></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['amount'], 2)."</b></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>Deviasi Terhadap Nilai HPS</b></td>
			<?php
			foreach ($evaluation as $key => $value) {
				$amount = $nilai_hps - $value['amount'];
				echo "<td align='center'><b>".number_format($amount, 2)."</b></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>NILAI EVALUASI TOTAL (NET)</b></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['total'], 2, '.', '')."</b></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>PERINGKAT</b></td>
			<?php
			$par = 1;
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".$par."</b></td>";
				$par += 1;
			}
			?>
		</tr>


	</tr>


</table>
<!-- =======================================================DEPKN=================================================================================== -->
<style type="text/css">

	td {
		padding: 8px;
	}

	th {
		padding: 8px;
	}

	#table-content {
		font-size: 50%;
	}

	.is-content {
  		border-collapse: collapse;
	}

	.is-content td {
  		border: 1px solid black;
	}

	.is-content th {
  		border: 1px solid black;
	}

	.signature {
	  border: 0;
	  border-bottom: 1px solid #000;
	}


	.signature-wrapper {
	  display: block;
	  text-align: center;
	}

	.button {
	  background-color: #4CAF50; /* Green */
	  border: none;
	  color: white;
	  padding: 15px 32px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 10px;
	}

</style>
<div style="page-break-before:always"></div>
<center>
	<h5 style="margin:0px;">DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI (DEPKN)

	</h5>
</center>
<br>
<br>
<table style="width: 100%;" id="table-content" class="is-content">

		<tr>

			<td style="border-right: 0px;" ><img width="50"   src="<?php echo base_url('assets/img/favicon.png') ?>"></td>
			<td colspan="6" align="left" style="border-left: 0px; border-right: 0px; font-weight: bold;"><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $tender['ptm_dept_name']; ?></td>
			<td colspan="<?php echo count($vendor) * 2; ?>" style="border-left: 0px; font-size: 120%;font-weight: bold;"></td>

		</tr>

		<tr>

			<th colspan="7"></th>
			<th colspan="<?php echo count($vendor) * 2; ?>">PENYEDIA</th>

		</tr>

		<tr>

			<th colspan="7"><?php echo $tender['ptm_project_name']; ?><br>Proyek : <?php echo $tender['ptm_district_name']; ?></th>
			<?php
				$address = "";
				$cp = "";
				$telpon = "";
				$no_penawaran = "";
				$tgl = "";
				$ksong = "";
				foreach ($vendor as $value) {
					$dataQuoHeader = $this->Procrfq_m->getQuoItemHeaderRFQ($ptm_number, $value['vendor_id'])->row_array();

					echo "<th colspan='2'>".$value['vendor_name']."</th>";
					$address .= "<td colspan='2'>". $value['address_street'] ."</td>";
					$cp .= "<td colspan='2'>". $value['contact_pos'] ."</td>";
					$telpon .= "<td colspan='2'>". $value['contact_phone_no'] ."</td>";
					$no_penawaran .= "<td colspan='2'>". $dataQuoHeader['pqm_number'] ."</td>";
					$tgl .= "<td colspan='2'>". $dataQuoHeader['pqm_created_date']."</td>";
					$ksong .= "<th colspan='2'>". ''."</th>";
					//print_r($value);
				}
			?>

		</tr>

		<tr>

			<th align="center">1</th>
			<th colspan="6" align="left">DATA PENYEDIA</th>
			<?php echo $ksong; ?>

		</tr>

		<tr>

			<td align="center">1.1</td>
			<td colspan="6">Alamat</td>
			<?php echo $address; ?>
		</tr>

		<tr>

			<td align="center">1.2</td>
			<td colspan="6">Kontak Personal</td>
			<?php echo $cp; ?>

		</tr>

		<tr>

			<td align="center">1.3</td>
			<td colspan="6">No. Telpon / Fax</td>
			<?php echo $telpon; ?>

		</tr>

		<tr>

			<td align="center">1.4</td>
			<td colspan="6">Penawaran  No. / Tanggal</td>
			<?php echo $no_penawaran; ?>

		</tr>

		<tr>

			<td align="center">1.5</td>
			<td colspan="6">BA Klarifikasi dan Negosiasi  Tgl.</td>
			<?php echo $tgl; ?>

		</tr>

		<tr>

			<th align="center">2</th>
			<th colspan="4" align="left">DATA PEKERJAAN / SPESIFIKASI</th>
			<th colspan="2">RABP</th>
			<?php
				foreach ($vendor as $value) {
					echo "<th colspan='2'></th>";
				}
			?>

		</tr>

		<tr>
			<th></th>
			<th></th>
			<th>Ukuran</th>
			<th>Vol</th>
			<th>Sat</th>
			<th>Harga Satuan</th>
			<th>Jumlah Harga (Rp)</th>
			<?php
				foreach ($vendor as $value) {
					echo "<th>Harga Satuan</th><th>Jumlah Harga (Rp)</th>";
				}
			?>

		</tr>


		<?php

			$content_total = "<tr><td></td><td  align ='center'><b>TOTAL</b></td>";
			$content_deviasi = "<tr><td></td><td align ='center'><b>EFISIENSI</b></td>";

			$total_vendor = array();
			$par = 0;
			foreach ($vendor as $value21) {
				$total_vendor[$par] = 0;
				$par += 1;
			}

			$total_bap = 0;

			$nomor = 1;

			foreach ($item as $value) {

				$id_tit = $value['tit_id'];

				$dataSMb = $this->Procrfq_m->getSmbCatalogByCode(trim($value['tit_code']))->row_array();

				$ukuran = "";
				if ($dataSMb) {
					$ukuran = $dataSMb['ukuran'];
				}

				$content_vendor = "";

				$par = 0;
				foreach ($vendor as $value2) {

					//print_r($value2);

					$pqm_id = $value2['pqm_id'];
					//$vendor_id = $value2['pqm_id'];

					//$data_penawaran_awal = $this->Procrfq_m->getVendorQuoHistRFQ($value2['pvs_vendor_code'], $ptm_number)->result_array();
					//print_r($data_penawaran_awal);
					//$list_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->result_array();
					$list_vendor_penawaran = $this->Procrfq_m->getQuoItemHistRFQ($value2['vendor_id'], $id_tit)->row_array();
					$data_vendor_penawaran = array();

					if ($list_vendor_penawaran) {
						$data_vendor_penawaran = $list_vendor_penawaran;
					} else {
						$data_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->row_array();
					}


					$content_vendor .= "<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'])
					."</td><td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity'])."</td>";

					$total_vendor[$par] += ($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity']);
					$par += 1;
				}

				$nomor_text = $nomor;
				if ($nomor == 1) {
					$nomor_text = "<b>A).</b><br><br>".$nomor;
					$value['tit_description'] = "<b><u>PENAWARAN</u></b><br><br>".$value['tit_description'];
				}

				echo "<tr >
					<td style ='padding:0px;border-bottom:0px;border-top:0px;' align='center'>".$nomor_text."</td>
					<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_description']."</td>
					<td style ='border-bottom:0px;border-top:0px;'>".$ukuran."</td>
					<td style ='border-bottom:0px;border-top:0px;' align='right'>".$value['tit_quantity']."</td>
					<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_unit']."</td>
					<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price'])."</td>
					<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price']*$value['tit_quantity'])."</td>".

					$content_vendor


					."</tr>";
				$nomor += 1;

				$total_bap += ($value['tit_price'] * $value['tit_quantity']);


			}

			$content_total .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b>Rp. ".inttomoney($total_bap)."</b></td>";
			$content_deviasi .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b></b></td>";
			foreach ($total_vendor as $t_vendor) {
				$content_total .= "<td><b></b></td><td align ='right'><b>Rp. ".inttomoney($t_vendor)."</b></td>";

				$total_deviasi = $total_bap - $t_vendor;
				if ($total_deviasi < 0) {
					$total_deviasi = "<span style='color:red;'>Rp. (".inttomoney(abs($total_deviasi)).")</span>";
				} else {
					$total_deviasi = "<span>Rp. ".inttomoney($total_deviasi)."</span>";
				}

				$content_deviasi .= "<td><b></b></td><td align ='right'><b>".$total_deviasi."</b></td>";
			}
			$content_total .= "</tr>";
			$content_deviasi .= "</tr>";

			echo $content_total;
			//echo $content_deviasi;


		?>

		<?php

			$content_total = "<tr><td></td><td  align ='center'><b>TOTAL</b></td>";
			$content_deviasi = "<tr><td></td><td align ='center'><b>EFISIENSI</b></td>";

			$total_vendor = array();
			$par = 0;
			foreach ($vendor as $value21) {
				$total_vendor[$par] = 0;
				$par += 1;
			}

			$total_bap = 0;

			$nomor = 1;
			foreach ($item as $value) {

				$id_tit = $value['tit_id'];

				$dataSMb = $this->Procrfq_m->getSmbCatalogByCode(trim($value['tit_code']))->row_array();
				$ukuran = "";
				if ($dataSMb) {
					$ukuran = $dataSMb['ukuran'];
				}

				$content_vendor = "";

				$par = 0;
				foreach ($vendor as $value2) {

					//print_r($value2);

					$pqm_id = $value2['pqm_id'];
					//$vendor_id = $value2['pqm_id'];

					//$data_penawaran_awal = $this->Procrfq_m->getVendorQuoHistRFQ($value2['pvs_vendor_code'], $ptm_number)->result_array();
					//print_r($data_penawaran_awal);
					//$list_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->result_array();

					$data_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->row_array();


					$content_vendor .= "<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'])
					."</td><td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity'])."</td>";

					$total_vendor[$par] += ($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity']);
					$par += 1;
				}

				$nomor_text = $nomor;
				if ($nomor == 1) {
					$nomor_text = "<b>B).</b><br><br>".$nomor;
					$value['tit_description'] = "<b><u>NEGOSIASI</u></b><br><br>".$value['tit_description'];
				}

				echo "<tr >
					<td style ='padding:0px;border-bottom:0px;border-top:0px;' align='center'>".$nomor_text."</td>
					<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_description']."</td>
					<td style ='border-bottom:0px;border-top:0px;'>".$ukuran."</td>
					<td style ='border-bottom:0px;border-top:0px;' align='right'>".$value['tit_quantity']."</td>
					<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_unit']."</td>
					<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price'])."</td>
					<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price']*$value['tit_quantity'])."</td>".

					$content_vendor


					."</tr>";
				$nomor += 1;

				$total_bap += ($value['tit_price'] * $value['tit_quantity']);


			}

			$content_total .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b>Rp. ".inttomoney($total_bap)."</b></td>";
			$content_deviasi .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b></b></td>";
			foreach ($total_vendor as $t_vendor) {
				$content_total .= "<td><b></b></td><td align ='right'><b>Rp. ".inttomoney($t_vendor)."</b></td>";

				$total_deviasi = $total_bap - $t_vendor;
				if ($total_deviasi < 0) {
					$total_deviasi = "<span style='color:red;'>Rp. (".inttomoney(abs($total_deviasi)).")</span>";
				} else {
					$total_deviasi = "<span>Rp. ".inttomoney($total_deviasi)."</span>";
				}

				$content_deviasi .= "<td><b></b></td><td align ='right'><b>".$total_deviasi."</b></td>";
			}
			$content_total .= "</tr>";
			$content_deviasi .= "</tr>";

			echo $content_total;
			echo $content_deviasi;


		?>

		<tr>

			<th align="center">3</th>
			<th colspan="4" align="left">KLARIFIKASI</th>
			<th colspan="2"></th>


			<?php
				foreach ($vendor as $value) {
					echo "<th colspan='2'>".''."</th>";
				}
			?>

		</tr>

		<?php $ii = 1; foreach ($item_klarifikasi as $key => $item) : ?>
			<tr>

			<td align="center">3.<?= $ii ?></td>
			<td colspan="4" align="left"><i><?= $item['item_name'] ?></i></td>
			<td colspan="2"></td>

			<?php
			$ik = 0;
				foreach ($vendor as $value) {
					//echo "<td colspan='2'>".$tender['ptm_project_name']."</td>";
					$valuess = $item['item_value'] != '' ? explode(";", $item['item_value'])[$ik] : "";
					echo "<td colspan='2'>".$valuess."</td>";
					$ik++;
				}
			?>

		</tr>
		<?php $ii++; endforeach; ?>

		<tr>

			<td align="center"></td>
			<td colspan="4" align="left"></td>
			<td colspan="2"></td>


			<?php
				foreach ($vendor as $value) {
					echo "<td colspan='2'></td>";
				}
			?>

		</tr>



</table>
<!-- ============================================ KOLOM ESIGN ====================================================================================== -->

<div style="page-break-before:always"></div>

<center><b><p style="font-weight:bold;">(BAKP) KOMISI  PENGADAAN <?= $header_kewenangan['komisi'] ?> (<?= $tender['ptm_tender_project_type'] ?>)</p></b></center>

<center><p style="font-weight:bold;">Komisi  Pengadaan Divisi</p></center>

<table style="width:100%;" class="is-content" id="tabel-ttd">

	<tr>
		<th align="center">No</th>
		<th align="center">Nama</th>
		<th align="center"></th>
		<th align="center">Tanda Tangan</th>
		<th align="center">Keterangan</th>
	</tr>

	<?php

		$par = 1;
		$par1 = 0;
		foreach ($panitia_name as $value) {

			$nama_array = explode(" - ", $value);
			$nama = $nama_array[0];
			$pos = "";
			if (count($nama_array) > 1) {
				$pos = $nama_array[1];
			}

			echo "<tr>
				<td align='center' style='height:60px;'>$par</td>
				<td>".$nama."</td>
				<td align='center'>".$panitia_ketua[$par1]."</td>
				<td align='center'>........................</td>
				<td align='center'>".$pos."</td>
			</tr>";
			$par += 1;
			$par1 += 1;
		}

	?>

</table>
<!-- =================================================== TTD PENILAIAN ======================================================= -->

<div style="page-break-before:always"></div>
<center><p style="font-weight:bold;">DOKUMEN SISTEM PENILAIAN</p></center>

<table style="width:100%;" class="is-content" id="tabel-ttd">

	<tr>
		<th align="center">No</th>
		<th align="center">Tanggal</th>
		<th align="center">Nama</th>
		<th align="center">Tanda Tangan</th>
	</tr>
	<tr>
		<td align="center" style='height:60px;'>1</td>
		<td align="center"><?php echo $data_uskep['bakp_city'].' '.date('d M Y'); ?> </td>
		<td align="center"><?php echo explode(" - ", $penilaian_ttd)[0]; ?></td>
		<td align="center">........................</td>

	</tr>


</table>

<div style="page-break-before:always"></div>

<center><b><p style="font-weight:bold;">(DEPKN) KOMISI  PENGADAAN <?= $header_kewenangan['komisi'] ?> (<?= $tender['ptm_tender_project_type'] ?>)</p></b></center>

<center><p style="font-weight:bold;">Komisi  Pengadaan Divisi</p></center>

<table style="width:100%;" class="is-content" id="tabel-ttd">

	<tr>
		<th align="center">No</th>
		<th align="center">Nama</th>
		<th align="center"></th>
		<th align="center">Tanda Tangan</th>
		<th align="center">Keterangan</th>
	</tr>

	<?php

		$par = 1;
		$par1 = 0;
		foreach ($panitia_name_d as $value) {

			$nama_array = explode(" - ", $value);
			$nama = $nama_array[0];
			$pos = "";
			if (count($nama_array) > 1) {
				$pos = $nama_array[1];
			}

			echo "<tr>
				<td align='center' style='height:60px;'>$par</td>
				<td>".$nama."</td>
				<td align='center'>".$panitia_ketua_d[$par1]."</td>
				<td align='center'>........................</td>
				<td align='center'>".$pos."</td>
			</tr>";
			$par += 1;
			$par1 += 1;
		}

	?>

</table>
<!-- =================================================== TTD DEPKN ======================================================= -->

<script type="text/php">
if ( isset($pdf) ) {
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
        	//$canvas = $dompdf->get_canvas();
        	//$h = $canvas->get_height() - 15;

            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 9;
            $pageText = "(Dokumen ini dicetak oleh Buyer)";

            $pageText2 = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 15;
            $x = 520;
            $pdf->text(10, $y, $pageText, $font, $size);
            $pdf->text($x, $y, $pageText2, $font, $size);
        }
    ');
}
</script>
