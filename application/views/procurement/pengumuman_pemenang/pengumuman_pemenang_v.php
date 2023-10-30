

<div class="wrapper_letter">
    <div class="c1"></div>
    <div class="c2">No.Dok : WIKA-DAN-PM-03-01</div>
   
</div>
<div class="wrapper_letter">
    <div class="c1"></div>
    <div class="c2">No. Rev. : <strong><em>06 Amd 0</em></strong><strong><em>2</em></strong></div>
   
</div>
<br>
<div class="wrapper_letter">
    <div class="c1">Nomor :</div>
    <div class="c2">Jakarta <?= date('ymdhis') ?></div>
</div>
<p>Lampiran : -</p>
<br>
<br>
<p>Kepada Yth.</p>
<p><strong>Direktur Utama </strong></p>
<?php foreach ($list_direktur as $key => $value) :?>
<p><?= $value['nm_peg'] ?></p>
<?php endforeach; ?>

<p>Perihal : <strong>Pengumuman Pemenang </strong></p>
<br>
<br>
<p>Dengan hormat,</p>
<p>Berdasarkan hasil Evaluasi Klarifikasi dan Negosiasi pada tanggal <?= $tender['ptp_quot_opening_date'] ?>, berikut kami sampaikan hasil penetapan pemenang <strong><em>Pekerjaan <?= $tender['ptm_project_name']; ?></em></strong> dengan rincian sebagai berikut:</p>
<p></p>
<table style="width: 50%;">
<tbody>
<tr>
<td>
Nama Penyedia
</td>
<?php
				$par = 1;
				foreach ($evaluation as $key => $value) {
					

					if (true) { ?>
						<td style="width: 30%;"><?php echo $value['vendor_name']; ?></td>
						
					<?php }

					$par += 1;
				}
			?>
<!-- <td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td> -->
</tr>
<tr>
<td>
NPWP
</td>
<td >&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>
Urutan Pemenang
</td>
<?php
				$par = 1;
				foreach ($evaluation as $key => $value) {
					
					if (true) { ?>
						<td><?php echo $par ?></td>
						
					<?php }

					$par += 1;
				}
			?>

</tr>
</tbody>
</table>
<br>
<p>Untuk penyedia lain yang ingin mengajukan sanggahan apabila menemukan:</p>
<ol>
<li>Panitia/Tim lelang salah dalam melakukan evaluasi</li>
<li>Terindikasi penyimpangan</li>
<li>Rekayasa / persekongkolan</li>
</ol>
<p>Pengajuan sanggahan paling lambat diajukan 2 (dua) hari dari surat ini dikeluarkan disertai dengan jaminan sebesar 10% dari nilai penawaran. Jaminan tersebut akan dikembalikan apabila terbukti dan akan menjadi milik Wika apabila tidak terbukti.</p>
<p>Demikian Surat pengumuman ini dikeluarkan untuk dapat dilaksanakan sebagaimana mestinya, atas perhatian dan kerjasamanya kami sampaikan terima kasih.</p>
<table style="width: 100%;">
<tbody>
<tr>
<td>&nbsp;</td>
<td style="width: 30%;">Hormat Kami,</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<p><strong>PT WIJAYA KARYA (Persero) Tbk</strong></p>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<p><strong>Manajemen,</strong></p>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td></td>
<td>
<p><?= $ketua_komisi ?></p>
</td>
</tr>
</tbody>
</table>
<br>
<a href="<?php echo base_url()."index.php/procurement/surat_pengumuman_pemenang/".$tender['ptm_number']; ?>" target="_blank" class="btn btn-info btn-sm" style="margin: 5px;font-size:11px;"><i class="ft ft-file"></i> Generate PDF</a>
		
