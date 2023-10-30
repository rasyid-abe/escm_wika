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

	.page_break { page-break-before: always; }

</style>

<table style="width: 100%;" id="table-content" class="is-content">

	<tr>

		<th colspan="2" style="border-right: 0px;" ><img width="50"   src="<?php echo base_url('assets/img/favicon.png') ?>"></th>
		<th colspan="4" align="left" style="border-left: 0px; border-right: 0px;"><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $this->data['userdata']['dept_name'] ?></th>
		<th colspan="<?php echo count($vendor) * 2; ?>" style="border-left: 0px; font-size: 120%;">DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI (DEPKN)</th>

	</tr>

	<tr>

		<th colspan="6"></th>
		<th colspan="<?php echo count($vendor) * 2; ?>">PENYEDIA</th>

	</tr>

	<tr>

		<th colspan="6"><?php echo $pengadaan ?><br>Proyek : <?php echo $proyek; ?></th>
		<?php foreach ($vendor as $key => $value): ?>
			<th colspan="2"><?php echo $value['vendor_name'] ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<th align="center">1</th>
		<th colspan="5">DATA PENYEDIA</th>
		<?php foreach ($vendor as $key => $value): ?>
			<th colspan="2"></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.1</td>
		<td colspan="5">Alamat</td>
		<?php foreach ($vendor as $key => $value): ?>
			<th colspan="2"><?php echo $value['address_street'] ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.2</td>
		<td colspan="5">Kontak Personal</td>
		<?php foreach ($vendor as $key => $value): ?>
			<th colspan="2"><?php echo $value['contact_phone_no'] ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.3</td>
		<td colspan="5">No. Telp/Fax</td>
		<?php foreach ($vendor as $key => $value): ?>
			<th colspan="2"><?php echo $value['address_phone_no'] ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.4</td>
		<td colspan="5">Penawaran No./Tangal</td>
		<?php foreach ($tgl_penawaran as $key => $value): ?>
			<th colspan="2"><?php echo $value ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.5</td>
		<td colspan="5">BA Klarifikasi dan Negosiasi Tgl.</td>
		<?php foreach ($klarifikasi_nego as $key => $value): ?>
			<th colspan="2"><?php echo $value ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td colspan="<?php echo ($cols * 2) + 6?>"></td>
	</tr>

	<tr>
		<th>2</th>
		<th colspan="3">DATA PEKERJAAN/SPESIFIKASI</th>
		<th colspan="2">RABP</th>
		<?php foreach ($vendor as $key => $value): ?>
			<th colspan="2"></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<th></th>
		<th></th>
		<th>Sat</th>
		<th>Vol</th>
		<th>Hrg Satuan</th>
		<th>Harga</th>
		<?php foreach ($vendor as $key => $value): ?>
			<th>Hrg Satuan</th>
			<th>Harga</th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">
			<b>A).</b><br>
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo $k+1 ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b><U>PENAWARAN</U></b><br>
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo $v->poin ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b></b><br>
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo $v->satuan ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo number_format((int)$v->volume,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo number_format((int)$v->harga_satuan,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo number_format((int)$v->total_harga,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>

		<?php foreach ($vendor as $a => $b): ?>
			<td align="right">
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_sat[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
			<td align="right">
			<?php foreach ($poin_pena as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_hrg[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td></td>
		<td colspan="3"><b>TOTAL</b></td>
		<td colspan="2" align="right"><b>Rp. <?php echo number_format((int)$rab_pena,0,',','.') ?></b></td>
		<?php foreach ($vend_pena as $key => $value): ?>
			<td colspan="2" align="right"><b>Rp. <?php echo number_format((int)$value,0,',','.') ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">
			<b>B).</b><br>
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo $k+1 ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b><U>Negosiasi</U></b><br>
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo $v->poin ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b></b><br>
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo $v->satuan ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo number_format((int)$v->volume,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo number_format((int)$v->harga_satuan,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo number_format((int)$v->total_harga,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>

		<?php foreach ($vendor as $a => $b): ?>
			<td align="right">
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_sat[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
			<td align="right">
			<?php foreach ($poin_nego as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_hrg[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td></td>
		<td colspan="3"><b>TOTAL</b></td>
		<td colspan="2" align="right"><b>Rp. <?php echo number_format((int)$rab_pena,0,',','.') ?></b></td>
		<?php foreach ($vend_nego as $key => $value): ?>
			<td colspan="2" align="right"><b>Rp. <?php echo number_format((int)$value,0,',','.') ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td colspan="<?php echo ($cols * 2) + 6?>"></td>
	</tr>

	<tr>
		<th>3</th>
		<th colspan="5">KLARIFIKASI</th>
		<?php foreach ($vendor as $key => $value): ?>
			<th colspan="2"></th>
		<?php endforeach; ?>
	</tr>

	<?php foreach ($klarifikasi as $key => $value): ?>
		<tr>
			<td align="center">3.<?php echo $key +1 ?></td>
			<td colspan="3"><?php echo $value->poin ?></td>
			<td align="center" colspan="2"><?php echo $value->rabp ?></td>
			<?php foreach ($value->vendor as $i => $v): ?>
				<td align="center" colspan="2"><?php echo $v ?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>

	<tr>
		<td colspan="<?php echo ($cols * 2) + 6?>"></td>
	</tr>
</table>

<!-- <table style="width: 100%; font-size: 50%">
	<tr>
		<td>
			<br>
			Menyetujui
			<br><br><br><br><br><br><br>
			<b><u><?php echo $esign->nm_kew[$idx_ketua] ?></u></b><br>
			<?php echo $esign->job_title[$idx_ketua] .' '. $esign->fungsi_bidang[$idx_ketua] ?>
		</td>
		<?php $i=0; foreach ($esign->nm_kew as $key => $value): ?>
			<?php if ($key != $idx_ketua): ?>
				<?php if ($key != $idx_usulan): ?>
					<td align="center">
						<?php if ($i == 0): ?>
							<br>
							Mengetahui
							<br><br><br><br><br><br><br>
							<b><u><?php echo $esign->nm_kew[$key] ?></u></b><br>
							<?php echo $esign->job_title[$key] .' '. $esign->fungsi_bidang[$key] ?>
						<?php else: ?>
							<br><br><br><br><br><br><br><br>
							<b><u><?php echo $esign->nm_kew[$key] ?></u></b><br>
							<?php echo $esign->job_title[$key] .' '. $esign->fungsi_bidang[$key] ?>
						<?php endif; ?>
					</td>
				<?php endif; ?>
			<?php $i++; endif; ?>
		<?php endforeach; ?>

		<td>
			<?php echo 'Jakarta' ?>, <?php echo date('d M Y') ?> <br>
			Diusulkan Oleh <br>
			<br><br><br><br><br><br>
			<b><u><?php echo $esign->nm_kew[$idx_usulan] ?></u></b><br>
			<?php echo $esign->job_title[$idx_usulan] .' '. $esign->fungsi_bidang[$idx_usulan] ?>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			Catatan Komisi Pengadaan: <br>
			<?php if ($notes != ""): ?>
				<?php foreach ($notes as $key => $value): ?>
					<?php echo $key + 1 ?>. <?php echo $value ?> <br>
				<?php endforeach; ?>
			<?php endif; ?>
		</td>
	</tr>
</table> -->

<div class="page_break"></div>
<center><p style="font-weight:bold;">Komisi Pengadaan <?php echo $title['komisi'] ?> (<?php echo $title['tipe_proyek'] ?>)</p></center>
<table style="width:100%; font-size: 70%" class="is-content" id="es">
	<tr>
		<th align="center" style="width: 20px;">No</th>
		<th align="center">Nama</th>
		<th align="center" style="width: 210px;">Posisi</th>
		<th align="center" style="width: 100px;">Kategori</th>
		<th align="center" style="width: 100px;">Deskripsi</th>
		<th align="center" style="width: 300px;">E-Sign</th>
	</tr>
	<?php foreach ($esign->nm_kew as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v ?></td>
			<td align="center"><?php echo $esign->job_title[$k] ?></td>
			<td align="center"><?php echo $esign->kategori[$k] ?></td>
			<td align="center"><?php echo $esign->posisi[$k] ?></td>
			<td align="center" style="height:50px;"></td>
		</tr>
	<?php endforeach; ?>
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
