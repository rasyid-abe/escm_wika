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
	<?php if ($mtode == "Penunjukan_Langsung"): ?>
		<h5 style="margin:0px;">BERITA ACARA KEPUTUSAN PENUNJUKAN LANGSUNG
	<?php else: ?>
		<h5 style="margin:0px;">BERITA ACARA KEPUTUSAN PEMENANG
	<?php endif; ?>
		<h6 style="margin:0px;"><?php echo "NOMOR : " . $nomor_bakp; ?></h6>
		<h6 style="margin:0px;"><?php echo "TANGGAL : ". date('d F Y', strtotime($tgl_bakp)); ?></h6>
	</h5>
</center>
<br>
<h6>Pada hari ini <?php echo $hari ?> tanggal <?php echo $tanggal ?> bulan <?php echo $bulan ?> tahun <?php echo $tahun ?> (<?php echo $fultgl ?>) di <?php echo $tempat ?> telah dilaksanakan rapat
penentuan/pengusulan pemutusan pemenang subkon / pemasok , untuk :</h6>

<table style="width:100%;">
	<tr>
		<td width="1%;">1.</td>
		<td width="20%;">Paket Pengadaan</td>
		<td style="width:1%;">:</td>
		<td><?php echo $pengadaan; ?></td>
	</tr>
	<tr>
		<td width="1%;">2.</td>
		<td width="12%;">Proyek</td>
		<td style="width:1%;">:</td>
		<td><?php echo $proyek; ?></td>
	</tr>
	<tr>
		<td width="1%;">3.</td>
		<td width="12%;">Departemen/ Divisi</td>
		<td style="width:1%;">:</td>
		<td><?php echo $this->data['userdata']['dept_name'] ?></td>
	</tr>
	<tr>
		<td width="1%;">4.</td>
		<td width="12%;">Nilai RAB/HPS</td>
		<td style="width:1%;">:</td>
		<td><?php echo "Rp. ".inttomoney($nilai_rab); ?></td>
	</tr>
</table>
<br>
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
	<?php foreach ($vendor as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $daftar[$k] ?></td>
			<td align="center"><?php echo $penawaran[$k] ?></td>
			<td><?php echo $catatan_tbl1[$k] ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<p >2. Hasil Evaluasi Penilaian</p>

<p style="margin-left: 10px;">2.1 Administrasi</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Status</th>
		<th align="center">Catatan</th>
	</tr>
	<?php foreach ($vendor as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $status21[$k] ?></td>
			<td><?php echo $catatan_tbl21[$k] ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<p style="margin-left: 10px;">2.2 Teknis (Bobot <?php echo $tek_perc ?>%, Threshold <?php echo $threshold ?>)</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Nilai</th>
		<th align="center">Nilai x Bobot</th>
		<th align="center">Catatan</th>
	</tr>
	<?php foreach ($vendor as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $nilai22[$k] ?></td>
			<td align="center"><?php echo $bobot22[$k] ?></td>
			<td><?php echo $catatan_tbl22[$k] ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<p style="margin-left: 10px;">2.3 Harga (Bobot <?php echo $hrg_perc ?>%, HPS Rp. <?php echo $hrg_hps ?>)</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Harga Negosiasi</th>
		<th align="center">Efisiensi</th>
		<th align="center">Nilai</th>
		<th align="center">Nilai x Bobot</th>
	</tr>
	<?php foreach ($vendor as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="right">Rp. <?php echo $nego23[$k] ?></td>
			<td align="right">Rp. <?php echo number_format((int)$effi23[$k],0,',','.') ?></td>
			<td align="center"><?php echo $nilai23[$k] ?></td>
			<td align="center"><?php echo $bobot23[$k] ?></td>
		</tr>
	<?php endforeach; ?>
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
	<?php foreach ($vendor as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $nilai24[$k] ?></td>
			<td align="center"><?php echo $rank24[$k] ?></td>
			<td align="center"><?php echo $tatatan_tbl24[$k] ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<p >3. Komisi Pengadaan sepakat memutuskan pemenang untuk paket pekerjaan di atas adalah:</p>

<table style="width:50%; margin-left: 10px;">
	<tr>
		<td align="center">No</td>
		<td>Nama Penyedia</td>
		<td align="right">Omset Kontrak</td>
	</tr>
	<?php foreach ($ven_win as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><b><?php echo $v ?></b></td>
			<td align="right"><b>Rp. <?php echo $ven_omZ[$k] ?></b></td>
		</tr>
	<?php endforeach; ?>
</table>

<p >4. Catatan - catatan :</p>

<table style="width:100%;margin-left: 10px;" id="tabel-catatan">
	<?php foreach ($note as $k => $v): ?>
		<?php if (is_object($v)): ?>
			<tr>
				<td width="3%">-</td>
				<td><?php echo $v->poin ?></td>
			</tr>
			<?php if (isset($v->sub_poin)): ?>
				<?php $no = 1; foreach ($v->sub_poin as $key => $value): ?>
					<?php if ($value != ''): ?>
						<tr>
							<td></td>
							<td><?php echo $no ?> <?php echo $value ?></td>
						</tr>
					<?php $no++; endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</table>
<p style="font-weight:bold;">Demikian Berita Acara Ini dibuat, untuk dilaksanakan dan diproses lebih lanjut</p>
<div class="page_break"></div>
<center><p style="font-weight:bold;">Komisi Pengadaan <?php echo $title['komisi'] ?> (<?php echo $title['tipe_proyek'] ?>)</p></center>
<table style="width:100%;" class="is-content" id="es">
	<tr>
		<th align="center" style="width: 20px;">No</th>
		<th align="center">Nama</th>
		<th align="center" style="width: 110px;">Posisi</th>
		<th align="center" style="width: 50px;">Kategori</th>
		<th align="center" style="width: 60px;">Deskripsi</th>
		<th align="center" style="width: 200px;">E-Sign</th>
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
