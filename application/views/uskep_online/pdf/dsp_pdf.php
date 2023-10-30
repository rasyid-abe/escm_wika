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
	.page_break { page-break-before: always; }
</style>

<?php $tgl_penetapan_pemenang = date('Y-m-d'); ?>

<table style="width: 100%;">
<tr>
	<td width="1%"><img width="50" src="<?php echo base_url('assets/img/favicon.png') ?>"></td>
	<td ><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $this->data['userdata']['dept_name'] ?></td>

</tr>
</table>
<br>
<center>
	<h5 style="margin:0px;">DOKUMEN SISTEM PENILAIAN</h5>
</center>
<br>

<table style="width:100%;">
	<tr>
		<td width="25%;">Paket Pengadaan</td>
		<td style="width:1%;">:</td>
		<td><?php echo $pengadaan; ?></td>
	</tr>
	<tr>
		<td width="12%;">Proyek</td>
		<td style="width:1%;">:</td>
		<td><?php echo $proyek; ?></td>
	</tr>
	<tr>
		<td width="12%;">No RFQ</td>
		<td style="width:1%;">:</td>
		<td><?php echo $no_rfq; ?></td>
	</tr>
</table>

<p style="font-weight:bold;">Sistem Penilaian</p>

<table style="width:100%;" class="is-content">
	<tr>
		<th align="center" rowspan="2">No</th>
		<th align="center" rowspan="2">Uraian</th>
		<th align="center" rowspan="2">Bobot</th>
		<th align="center" colspan="<?php echo $cols; ?>">Penyedia Jasa / Pemasok</th>
	</tr>

	<tr>
		<?php foreach ($vendor as $key => $value): ?>
			<th><?php echo $value['vendor_name'] ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td colspan="<?php echo $cols + 3 ?>"></td>
	</tr>

	<tr>
		<th align="center">I</th>
		<th align="left"><b>ADMINISTRASI</b></th>
		<th align="center"><b>Wajib</b></th>
		<?php foreach ($vendor as $key => $value): ?>
			<th></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Putusan</td>
		<td align="center"></td>
		<?php foreach ($adm_status as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<?php foreach ($adm_poin as $key => $value): ?>
		<tr>
			<td align="center"><b><?php echo $alpha[$key]  ?></b></td>
			<td colspan="<?php echo $cols + 2 ?>"><b><?php echo $value->title ?></b></td>
		</tr>
		<?php foreach ($value->sub as $idx => $val): ?>
			<tr>
				<td align="center"><?php echo $idx+1 ?></td>
				<td><?php echo $value->sub[$idx] ?></td>
				<td align="center"><?php echo $value->bobot[$idx] ?></td>
				<?php foreach ($vendor as $i => $v): ?>
					<td align="center"><?php echo $value->vendor[$i][$idx] ?></td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	<?php endforeach; ?>

	<tr>
		<td colspan="<?php echo $cols + 3 ?>"></td>
	</tr>

	<tr>
		<th align="center">II</th>
		<th align="left"><b>TEKNIS</b></th>
		<th align="center"><?php echo $tek_percent.'%'; ?></th>
		<th colspan="<?php echo $cols ?>"></th>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Threshold</td>
		<td align="center"><?php echo $threshold.''; ?></td>
		<?php foreach ($tek_status as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Nilai</td>
		<td align="center"></td>
		<?php foreach ($tek_nilai as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Nilai x Bobot</td>
		<td align="center"></td>
		<?php foreach ($tek_bobot as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<?php foreach ($tek_poin as $key => $value): ?>
		<tr>
			<td align="center"><b><?php echo $key+1 ?></b></td>
			<td><b><?php echo $value->title ?></b></td>
			<td align="center"><?php echo $value->bobot ?></td>
			<?php foreach ($vendor as $k => $v): ?>
				<td align="center"><?php echo $value->hasil[$k] ?></td>
			<?php endforeach; ?>
		</tr>
		<?php foreach ($value->sub->sub_poin as $k => $v): ?>
			<tr>
				<td></td>
				<td> - <?php echo $value->sub->sub_poin[$k] ?></td>
				<td align="center"><?php echo $value->sub->sub_bobot[$k] ?></td>
				<?php if ($k < 1): ?>
					<?php foreach ($vendor as $i => $va): ?>
						<td align="center" rowspan="<?php echo count($value->sub->sub_poin) == NULL ? "" : count($value->sub->sub_poin) ?>"><?php echo $value->input[$i] ?></td>
					<?php endforeach; ?>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	<?php endforeach; ?>

	<tr>
		<td colspan="<?php echo $cols + 3 ?>"></td>
	</tr>

	<tr>
		<th align="center">III</th>
		<th align="left"><b>HARGA</b></th>
		<th align="center"><?php echo $hrg_percent.'%'; ?></th>
		<th colspan="<?php echo $cols ?>"></th>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left"><b>Nilai HPS</b></td>
		<td align="center"><?php echo $hrg_hps; ?></td>
		<td colspan="<?php echo $cols ?>"></td>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left"><b>Nilai</b></td>
		<td align="center"></td>
		<?php foreach ($hrg_nilai as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left"><b>Nilai x Bobot </b></td>
		<td align="center"></td>
		<?php foreach ($hrg_bobot as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"><b>A</b></td>
		<td align="left"><b>ASKPEK HARGA</b></td>
		<td align="center"></td>
		<td colspan="<?php echo $cols ?>"></td>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>Harga Negosiasi Final (dalam rupiah)</b></td>
		<?php foreach ($hrg_nego as $key => $value): ?>
			<td align="center"><b><?php echo $value ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>Deviasi Terhadap Nilai HPS</b></td>
		<?php foreach ($hrg_dev as $key => $value): ?>
			<td align="center"><b><?php echo $value ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>NILAI EVALUASI TOTAL (NET)</b></td>
		<?php foreach ($hrg_eva as $key => $value): ?>
			<td align="center"><b><?php echo $value ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>PERINGKAT</b></td>
		<?php foreach ($hrg_rank as $key => $value): ?>
			<td align="center"><b><?php echo $value ?></b></td>
		<?php endforeach; ?>
	</tr>
</table>
<div class="page_break"></div>
<table style="width:100%;" class="is-content">
	<tr>

		<td style="border: 0px; width: 60%"></td>
		<td colspan="2" align=" center" style="border: 0px">

			<br>
			<?php echo $esign->tempat.', '.date('d M Y',strtotime($esign->tanggal)); ?>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<b><u><?php echo $esign->nama ?></u></b><br>
			<?php echo $esign->job_title . ' ' . $esign->fun_bidang ?>



		</td>

	</tr>

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
