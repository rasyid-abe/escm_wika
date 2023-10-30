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

	.signature_div {

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

<table style="width: 100%;" id="table-content" class="is-content">

		<tr>

			<th style="border-right: 0px;" ><img width="50"   src="<?php echo base_url('assets/img/favicon.png') ?>"></th>
			<th colspan="6" align="left" style="border-left: 0px; border-right: 0px;"><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $tender['ptm_dept_name']; ?></th>
			<th colspan="<?php echo count($vendor) * 2; ?>" style="border-left: 0px; font-size: 120%;">DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI (DEPKN)</th>

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
					$ksong .= "<td colspan='2'>". ''."</td>";
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

		<!-- <tr>
			<td colspan="3" style="border-right: 0px;">

				<br>
				Menyetujui


				<table style="font-size: 50%;" border="0">
					<tr>
						<td style="border: 1px solid #e0e0e000;">
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="signature_div">
							  <div class="Column">
							    <label class="signature-wrapper" style="text-align: center;">
							      <label  class="signature"><?php echo $menyetujui_name[0]; ?> </label><br />
							      <?php echo $menyetujui_posisi[0]; ?>
							    </label>
							  </div>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td style="border-right: 0px; border-left: 0px;"> </td>
			<td colspan="<?php echo (count($vendor) * 2) + 7 - 9; ?>" style="border-right: 0px; border-left: 0px;">

				<br>
				Mengetahui


				<table style="font-size: 50%;" border="0">
					<tr>
						  <?php $par = 0; foreach ($mengetahui_name as $value) { ?>
						  <td style="border: 1px solid #e0e0e000;">
						  	<br>
								<br>
								<br>
								<br>
								<br>
								<br>
							  <div class="signature_div">
								  <div class="Column">
								    <label class="signature-wrapper">
								      <label  class="signature"><?php echo $value; ?> </label><br />
								      <?php echo $mengetahui_posisi[$par]; ?>
								    </label>
								  </div>
							  </div>
						  </td>
						  <?php $par += 1; } ?>
					</tr>
				</table>
			</td>
			<td style="border-right: 0px; border-left: 0px;"></td>
			<td style="border-right: 0px; border-left: 0px;"></td>

			<td colspan="3" style="border-left: 0px;">

				<?php echo $data_uskep['bakp_city'].' '.date('d M Y'); ?> <br>
				Diusulkan Oleh

				<table style="font-size: 50%;" border="0">
					<tr>



				  <?php $par = 0; foreach ($diusulkan_name as $value) { ?>
				  	<td style="border: 1px solid #e0e0e000;">
						  	<br>
								<br>
								<br>
								<br>
								<br>
					  	<div class="signature_div">
						  <div class="Column">
						    <label class="signature-wrapper">
						      <label  class="signature"><?php echo $value; ?> </label><br />
						      <?php echo $diusulkan_posisi[$par]; ?>
						    </label>
						  </div>
						</div>
						</td>
					  <?php $par += 1; } ?>
				  </tr>
				</table>
			</td>
		</tr> -->

</table>

<div style="page-break-before:always">&nbsp;</div>

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

<script type="text/php">
if ( isset($pdf) ) {
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
        	//$canvas = $dompdf->get_canvas();
        	//$h = $canvas->get_height() - 15;

            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 9;
            $pageText = "(Dokumen ini dicetak otomatis di sistem eSCM WIKA)";
            $pageText2 = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 15;
            $x = 520;
            $pdf->text(10, $y, $pageText, $font, $size);
            $pdf->text($x, $y, $pageText2, $font, $size);
        }
    ');
}
</script>

<!--
<br><br>

<table style="width: 100%;" id="table-content">
	<tr>
		<td style="width: 25%;"></td>
		<td style="width: 25%;"></td>
		<td style="width: 25%;"></td>
		<td style="width: 25%;">
			Jakarta <?php echo date('d M Y'); ?><br>Dibuat Oleh,
			<br><br><br><br><br><br><br><br>

			<b><u><?php echo $name_apropal_1; ?></b></u><br>
			<?php echo $pos_apropal_1; ?>
		</td>
	<tr>
		-->
