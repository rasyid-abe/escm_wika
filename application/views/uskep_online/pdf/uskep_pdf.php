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
		<td width="1%"><img src="<?php echo base_url('assets/img/favicon.png');?>" width="50"></td>
		<td ><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $this->data['userdata']['dept_name'] ?></td>

	</tr>
</table>
<br>
<center>
	<?php if ($bakp['mtode'] == "Penunjukan_Langsung"): ?>
		<h5 style="margin:0px;">BERITA ACARA KEPUTUSAN PENUNJUKAN LANGSUNG
	<?php else: ?>
		<h5 style="margin:0px;">BERITA ACARA KEPUTUSAN PEMENANG
	<?php endif; ?>
		<h6 style="margin:0px;"><?php echo "NOMOR : " . $bakp['nomor_bakp']; ?></h6>
		<h6 style="margin:0px;"><?php echo "TANGGAL : ". date('d F Y', strtotime($bakp['tgl_bakp'])); ?></h6>
	</h5>
</center>
<br>
<h6>Pada hari ini <?php echo $bakp['hari'] ?> tanggal <?php echo $bakp['tanggal'] ?> bulan <?php echo $bakp['bulan'] ?> tahun <?php echo $bakp['tahun'] ?> (<?php echo $bakp['fultgl'] ?>) di <?php echo $bakp['tempat'] ?> telah dilaksanakan rapat
penentuan/pengusulan pemutusan pemenang subkon / pemasok , untuk :</h6>


<!-- START PDF BAKP -->
<table style="width:100%;">
	<tr>
		<td width="1%;">1.</td>
		<td width="20%;">Paket Pengadaan</td>
		<td style="width:1%;">:</td>
		<td><?php echo $bakp['pengadaan']; ?></td>
	</tr>
	<tr>
		<td width="1%;">2.</td>
		<td width="12%;">Proyek</td>
		<td style="width:1%;">:</td>
		<td><?php echo $bakp['proyek']; ?></td>
	</tr>
	<tr>
		<td width="1%;">3.</td>
		<td width="12%;">Departemen/ Divisi</td>
		<td style="width:1%;">:</td>
		<td><?php echo $this->data['userdata']['dept_name'] ?></td>
	</tr>
	<tr>
		<td width="1%;">4.</td>
		<td width="12%;">Nilai RAB/Cosplan</td>
		<td style="width:1%;">:</td>
		<td><?php echo "Rp. ".inttomoney($bakp['nilai_rab']); ?></td>
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
	<?php foreach ($bakp['vendor'] as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $bakp['daftar'][$k] ?></td>
			<td align="center"><?php echo $bakp['penawaran'][$k] ?></td>
			<td><?php echo $bakp['catatan_tbl1'][$k] ?></td>
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
	<?php foreach ($bakp['vendor'] as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $bakp['status21'][$k] ?></td>
			<td><?php echo $bakp['catatan_tbl21'][$k] ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<p style="margin-left: 10px;">2.2 Teknis (Bobot <?php echo $bakp['tek_perc'] ?>%, Threshold <?php echo $bakp['threshold'] ?>)</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Nilai</th>
		<th align="center">Nilai x Bobot</th>
		<th align="center">Catatan</th>
	</tr>
	<?php foreach ($bakp['vendor'] as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $bakp['nilai22'][$k] ?></td>
			<td align="center"><?php echo $bakp['bobot22'][$k] ?></td>
			<td><?php echo $bakp['catatan_tbl22'][$k] ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<p style="margin-left: 10px;">2.3 Harga (Bobot <?php echo $bakp['hrg_perc'] ?>%, HPS Rp. <?php echo $bakp['hrg_hps'] ?>)</p>

<table style="width:100%;margin-left: 10px;" class="is-content">
	<tr>
		<th align="center">No</th>
		<th align="center">Nama Rekanan</th>
		<th align="center">Harga Negosiasi</th>
		<th align="center">Efisiensi</th>
		<th align="center">Nilai</th>
		<th align="center">Nilai x Bobot</th>
	</tr>
	<?php foreach ($bakp['vendor'] as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="right">Rp. <?php echo number_format($bakp['nego23'][$k],0,',','.') ?></td>
			<td align="right">Rp. <?php echo number_format((int)$bakp['effi23'][$k],0,',','.') ?></td>
			<td align="center"><?php echo $bakp['nilai23'][$k] ?></td>
			<td align="center"><?php echo $bakp['bobot23'][$k] ?></td>
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
	<?php foreach ($bakp['vendor'] as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v['vendor_name'] ?></td>
			<td align="center"><?php echo $bakp['nilai24'][$k] ?></td>
			<td align="center"><?php echo $bakp['rank24'][$k] ?></td>
			<td align="center"><?php echo $bakp['tatatan_tbl24'][$k] ?></td>
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
	<?php foreach ($bakp['ven_win'] as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><b><?php echo $v ?></b></td>
			<td align="right"><b>Rp. <?php echo number_format($bakp['ven_omZ'][$k],0,',','.') ?></b></td>
		</tr>
	<?php endforeach; ?>
</table>

<p >4. Catatan - catatan :</p>

<table style="width:100%;margin-left: 10px;" id="tabel-catatan">
	<?php foreach ($bakp['note'] as $k => $v): ?>
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
<!-- END PDF BAKP -->

<div class="page_break"></div>

<!-- START PDF DSP -->

<?php $tgl_penetapan_pemenang = date('Y-m-d'); ?>

<table style="width: 100%;">
	<tr>
		<td width="1%"><img src="<?php echo base_url('assets/img/favicon.png');?>" width="50"></td>
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
		<td><?php echo $dsp['pengadaan']; ?></td>
	</tr>
	<tr>
		<td width="12%;">Proyek</td>
		<td style="width:1%;">:</td>
		<td><?php echo $dsp['proyek']; ?></td>
	</tr>
	<tr>
		<td width="12%;">No RFQ</td>
		<td style="width:1%;">:</td>
		<td><?php echo $dsp['no_rfq']; ?></td>
	</tr>
</table>

<p style="font-weight:bold;">Sistem Penilaian</p>

<table style="width:100%;" class="is-content">
	<tr>
		<th align="center" rowspan="2">No</th>
		<th align="center" rowspan="2">Uraian</th>
		<th align="center" rowspan="2">Bobot</th>
		<th align="center" colspan="<?php echo $dsp['cols']; ?>">PENYEDIA BARANG DAN JASA</th>
	</tr>

	<tr>
		<?php foreach ($dsp['vendor'] as $key => $value): ?>
			<th><?php echo $value['vendor_name'] ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td colspan="<?php echo $dsp['cols'] + 3 ?>"></td>
	</tr>

	<tr>
		<th align="center">I</th>
		<th align="left"><b>ADMINISTRASI</b></th>
		<th align="center"><b>Wajib</b></th>
		<?php foreach ($dsp['vendor'] as $key => $value): ?>
			<th></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Putusan</td>
		<td align="center"></td>
		<?php foreach ($dsp['adm_status'] as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<?php foreach ($dsp['adm_poin'] as $key => $value): ?>
		<tr>
			<td align="center"><?php echo $dsp['alpha'][$key] ?></td>
			<td><?php echo $value ?></td>
			<td align="center"><?php echo $dsp['adm_bobot'][$key] ?></td>
			<?php foreach ($dsp['adm_vendor'] as $i => $v): ?>
				<td align="center" class="text-center"><?php echo $dsp['adm_vendor'][$i][$key] ?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>

	<tr>
		<td colspan="<?php echo $dsp['cols'] + 3 ?>"></td>
	</tr>

	<tr>
		<th align="center">II</th>
		<th align="left"><b>TEKNIS</b></th>
		<th align="center"><?php echo $dsp['tek_percent'].'%'; ?></th>
		<th colspan="<?php echo $dsp['cols'] ?>"></th>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Threshold</td>
		<td align="center"><?php echo $dsp['threshold'].''; ?></td>
		<?php foreach ($dsp['tek_status'] as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Nilai</td>
		<td align="center"></td>
		<?php foreach ($dsp['tek_nilai'] as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left">Nilai x Bobot</td>
		<td align="center"></td>
		<?php foreach ($dsp['tek_bobot'] as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<?php foreach ($dsp['tek_poin'] as $key => $value): ?>
		<?php if ($key == 0): ?>
			<tr style='background-color: lightgray; font-weight: bold'>
				<td align="center">A</td>
				<td colspan="<?php echo $dsp['cols'] + 2 ?>">ASPEK MUTU</td>
			</tr>
		<?php elseif ($key == 3): ?>
			<tr style='background-color: lightgray; font-weight: bold'>
				<td align="center">B</td>
				<td colspan="<?php echo $dsp['cols'] + 2 ?>">ASPEK WAKTU</td>
			</tr>
		<?php elseif ($key == 4): ?>
			<tr style='background-color: lightgray; font-weight: bold'>
				<td align="center">C</td>
				<td colspan="<?php echo $dsp['cols'] + 2 ?>">ASPEK SHE</td>
			</tr>
		<?php elseif ($key == 5): ?>
			<tr style='background-color: lightgray; font-weight: bold'>
				<td align="center">D</td>
				<td colspan="<?php echo $dsp['cols'] + 2 ?>">ASPEK KEUANGAN</td>
			</tr>
		<?php endif; ?>
		<tr>
			<td align="center"><b><?php echo $key+1 ?></b></td>
			<td><b><?php echo $value->title ?></b></td>
			<td align="center"><?php echo $value->bobot ?></td>
			<?php foreach ($dsp['vendor'] as $k => $v): ?>
				<td align="center"><?php echo $value->hasil[$k] ?></td>
			<?php endforeach; ?>
		</tr>

		<?php foreach ($value->sub->sub_poin as $k => $v): ?>
			<?php if ($k == 0): ?>
				<tr>
					<td></td>
					<td> - <?php echo $value->sub->sub_poin[$k] ?></td>
					<td align="center"><?php echo $value->sub->sub_bobot[$k] ?></td>

					<?php foreach ($dsp['vendor'] as $i => $va): ?>
						<?php if ($key == 5): ?>
							<td align="center" ><?php echo $value->input[$i] ?></td>
						<?php else: ?>
							<td align="center" rowspan="<?php echo count($value->sub->sub_poin) == NULL ? "" : count($value->sub->sub_poin) ?>"><?php echo $value->input[$i] ?></td>
						<?php endif; ?>
					<?php endforeach; ?>
				</tr>
			<?php else: ?>
				<tr>
					<td></td>
					<td> - <?php echo $value->sub->sub_poin[$k] ?></td>
					<td align="center"><?php echo $value->sub->sub_bobot[$k] ?></td>

					<?php foreach ($dsp['vendor'] as $i => $va): ?>
						<?php if ($key == 5): ?>
							<td align="center"><?php echo $dsp['idScore'][$i] ?></td>
						<?php endif; ?>
					<?php endforeach; ?>
				</tr>
			<?php endif; ?>

		<?php endforeach; ?>

	<?php endforeach; ?>

	<tr>
		<td colspan="<?php echo $dsp['cols'] + 3 ?>"></td>
	</tr>

	<tr>
		<th align="center">III</th>
		<th align="left"><b>HARGA</b></th>
		<th align="center"><?php echo $dsp['hrg_percent'].'%'; ?></th>
		<th colspan="<?php echo $dsp['cols'] ?>"></th>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left"><b>Nilai Cost Plan (RAB)</b></td>
		<td align="center"><?php echo number_format($dsp['hrg_hps'],0,',','.') ?></td>
		<td colspan="<?php echo $dsp['cols'] ?>"></td>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left"><b>Nilai</b></td>
		<td align="center"></td>
		<?php foreach ($dsp['hrg_nilai'] as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left"><b>Nilai x Bobot </b></td>
		<td align="center"></td>
		<?php foreach ($dsp['hrg_bobot'] as $key => $value): ?>
			<td align="center"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr style='background-color: lightgray; font-weight: bold'>
		<td align="center"><b>A</b></td>
		<td align="left" colspan="<?php echo $dsp['cols'] + 2?>"><b>ASKPEK HARGA</b></td>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>Harga Negosiasi Final (dalam rupiah)</b></td>
		<?php foreach ($dsp['hrg_nego'] as $key => $value): ?>
			<td align="center"><b><?php echo number_format($value,0,',','.') ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>Deviasi Terhadap Nilai Cost Plan (RAB)</b></td>
		<?php foreach ($dsp['hrg_dev'] as $key => $value): ?>
			<td align="center"><b><?php echo $value ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>NILAI EVALUASI TOTAL (NET)</b></td>
		<?php foreach ($dsp['hrg_eva'] as $key => $value): ?>
			<td align="center"><b><?php echo $value ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center"></td>
		<td align="left" colspan="2"><b>PERINGKAT</b></td>
		<?php foreach ($dsp['hrg_rank'] as $key => $value): ?>
			<td align="center"><b><?php echo $value ?></b></td>
		<?php endforeach; ?>
	</tr>
</table>
<!-- END PDF DSP -->

<div class="page_break"></div>

<!-- START PDF DEPKN -->

<table style="width: 100%;" id="table-content" class="is-content">

	<tr>

		<td colspan="2" align="center" style="border-right: 0px;" ><img src="<?php echo base_url('assets/img/favicon.png');?>" width="50"></td>
		<td colspan="5" align="left" style="border-left: 0px; border-right: 0px;"><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $this->data['userdata']['dept_name'] ?></td>
		<td colspan="<?php echo count($depkn['vendor']) * 2; ?>" style="border-left: 0px; font-size: 120%; font-weight: bold;">DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI (DEPKN)</td>

	</tr>

	<tr>

		<th colspan="7"></th>
		<th colspan="<?php echo count($depkn['vendor']) * 2; ?>">PENYEDIA</th>

	</tr>

	<tr>

		<th colspan="7"><?php echo $depkn['pengadaan'] ?><br>Proyek : <?php echo $depkn['proyek']; ?></th>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<th colspan="2"><?php echo $value['vendor_name'] ?></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<th align="center">1</th>
		<th colspan="6">DATA PENYEDIA</th>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<th colspan="2"></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.1</td>
		<td colspan="6">Alamat</td>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<td colspan="2"><?php echo $value['address_street'] ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.2</td>
		<td colspan="6">Kontak Personal</td>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<td colspan="2"><?php echo $value['contact_name'] ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.3</td>
		<td colspan="6">No. Telp/Fax</td>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<td colspan="2"><?php echo $value['address_phone_no'] ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.4</td>
		<td colspan="6">Penawaran No./Tangal</td>
		<?php foreach ($depkn['tgl_penawaran'] as $key => $value): ?>
			<td colspan="2"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">1.5</td>
		<td colspan="6">BA Klarifikasi dan Negosiasi Tgl.</td>
		<?php foreach ($depkn['klarifikasi_nego'] as $key => $value): ?>
			<td colspan="2"><?php echo $value ?></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td colspan="<?php echo ($depkn['cols'] * 2) + 7?>"></td>
	</tr>

	<tr>
		<th>2</th>
		<th colspan="3">DATA PEKERJAAN/SPESIFIKASI</th>
		<th colspan="3">RABP</th>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<th colspan="2"></th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<th></th>
		<th></th>
		<th>PR</th>
		<th>Sat</th>
		<th>Vol</th>
		<th>Hrg Satuan</th>
		<th>Harga</th>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<th>Hrg Satuan</th>
			<th>Harga</th>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">
			<b>A).</b><br>
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo $k+1 ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b><U>PENAWARAN</U></b><br>
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo $v->poin ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b></b><br>
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo $v->pr ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b></b><br>
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo $v->satuan ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo number_format((int)$v->volume,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo number_format((int)$v->harga_satuan,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo number_format((int)$v->total_harga,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>

		<?php foreach ($depkn['vendor'] as $a => $b): ?>
			<td align="right">
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_sat[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
			<td align="right">
			<?php foreach ($depkn['poin_pena'] as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_hrg[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td></td>
		<td colspan="3"><b>TOTAL</b></td>
		<td colspan="3" align="right"><b>Rp. <?php echo number_format((int)$depkn['rab_pena'],0,',','.') ?></b></td>
		<?php foreach ($depkn['vend_pena'] as $key => $value): ?>
			<td colspan="2" align="right"><b>Rp. <?php echo number_format((int)$value,0,',','.') ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td align="center">
			<b>B).</b><br>
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo $k+1 ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b><U>Negosiasi</U></b><br>
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo $v->poin ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b></b><br>
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo $v->pr ?><br>
			<?php endforeach; ?>
		</td>
		<td>
			<b></b><br>
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo $v->satuan ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo number_format((int)$v->volume,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo number_format((int)$v->harga_satuan,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>
		<td align="right">
			<b></b><br>
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo number_format((int)$v->total_harga,0,',','.') ?><br>
			<?php endforeach; ?>
		</td>

		<?php foreach ($depkn['vendor'] as $a => $b): ?>
			<td align="right">
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_sat[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
			<td align="right">
			<?php foreach ($depkn['poin_nego'] as $k => $v): ?>
				<?php echo number_format((int)$v->vendor_hrg[$a],0,',','.') ?><br>
			<?php endforeach; ?>
			</td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td></td>
		<td colspan="3"><b>TOTAL</b></td>
		<td colspan="3" align="right"><b>Rp. <?php echo number_format((int)$depkn['rab_pena'],0,',','.') ?></b></td>
		<?php foreach ($depkn['vend_nego'] as $key => $value): ?>
			<td colspan="2" align="right"><b>Rp. <?php echo number_format((int)$value,0,',','.') ?></b></td>
		<?php endforeach; ?>
	</tr>

	<tr>
		<td colspan="<?php echo ($depkn['cols'] * 2) + 7?>"></td>
	</tr>

	<tr>
		<th>3</th>
		<th colspan="6">KLARIFIKASI</th>
		<?php foreach ($depkn['vendor'] as $key => $value): ?>
			<th colspan="2"></th>
		<?php endforeach; ?>
	</tr>

	<?php foreach ($depkn['klarifikasi'] as $key => $value): ?>
		<tr>
			<td align="center">3.<?php echo $key +1 ?></td>
			<td colspan="6"><?php echo $value->poin ?></td>
			<!-- <td align="center" colspan="3"><?php echo $value->rabp ?></td> -->
			<?php foreach ($value->vendor as $i => $v): ?>
				<td align="center" colspan="2"><?php echo $v ?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>

	<tr>
		<td colspan="<?php echo ($depkn['cols'] * 2) + 7?>"></td>
	</tr>
</table>
<!-- START PDF DEPKN -->

<div class="page_break"></div>

<center><p style="font-weight:bold;">DOKUMEN BAKP</p></center>
<center><p style="font-weight:bold;">TIM PEJABAT PEMUTUS (BAKP)</p></center>
<table style="width:100%;" class="is-content" id="es">
	<tr>
		<th align="center" style="width: 20px;">No</th>
		<th align="center">Nama</th>
		<th align="center" style="width: 110px;">Posisi</th>
		<th align="center" style="width: 50px;">Kategori</th>
		<th align="center" style="width: 60px;">Deskripsi</th>
		<th align="center" style="width: 200px;">E-Sign</th>
	</tr>
	<?php foreach ($bakp['esign_bakp']->nm_kew as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v ?></td>
			<td align="center"><?php echo $bakp['esign_bakp']->job_title[$k] ?></td>
			<td align="center"><?php echo $bakp['esign_bakp']->kategori[$k] ?></td>
			<td align="center"><?php echo $bakp['esign_bakp']->posisi[$k] ?></td>
			<td align="center" style="height:50px;"></td>
		</tr>
	<?php endforeach; ?>
</table>
<div class="page_break"></div>

<center><p style="font-weight:bold;">DOKUMEN DSP</p></center>
<center><p style="font-weight:bold;">TIM PEJABAT PELAKSANA (TPPL)</p></center>

<table style="width:100%;" class="is-content" id="es">
	<tr>
		<th align="center" style="width: 20px;">No</th>
		<th align="center">Nama</th>
		<th align="center" style="width: 110px;">Posisi</th>
		<th align="center" style="width: 50px;">Kategori</th>
		<th align="center" style="width: 60px;">Deskripsi</th>
		<th align="center" style="width: 200px;">E-Sign</th>
	</tr>
	<?php foreach ($depkn['esign_dpkn']->nm_kew as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v ?></td>
			<td align="center"><?php echo $depkn['esign_dpkn']->job_title[$k] ?></td>
			<td align="center"><?php echo $depkn['esign_dpkn']->kategori[$k] ?></td>
			<td align="center"><?php echo $depkn['esign_dpkn']->posisi[$k] ?></td>
			<td align="center" style="height:50px;"></td>
		</tr>
	<?php endforeach; ?>
</table>

<div class="page_break"></div>

<center><p style="font-weight:bold;">DOKUMEN DEPKN</p></center>
<center><p style="font-weight:bold;">TIM PEJABAT PELAKSANA (TPPL)</p></center>
<table style="width:100%;" class="is-content" id="es">
	<tr>
		<th align="center" style="width: 20px;">No</th>
		<th align="center">Nama</th>
		<th align="center" style="width: 110px;">Posisi</th>
		<th align="center" style="width: 50px;">Kategori</th>
		<th align="center" style="width: 60px;">Deskripsi</th>
		<th align="center" style="width: 200px;">E-Sign</th>
	</tr>
	<?php foreach ($depkn['esign_dpkn']->nm_kew as $k => $v): ?>
		<tr>
			<td align="center"><?php echo $k + 1 ?></td>
			<td><?php echo $v ?></td>
			<td align="center"><?php echo $depkn['esign_dpkn']->job_title[$k] ?></td>
			<td align="center"><?php echo $depkn['esign_dpkn']->kategori[$k] ?></td>
			<td align="center"><?php echo $depkn['esign_dpkn']->posisi[$k] ?></td>
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
