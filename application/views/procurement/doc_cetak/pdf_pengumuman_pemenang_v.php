<style>
page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  font-family : 'Poppins', sans-serif;  
}

p  {
  margin-bottom: -10px;
}
page[size="A4"] {  
  width: 21cm;
  height: 29.7cm; 
}

page[size="LETTER"] {  
  width: 21.59cm;
  height: 27.94cm; 
}

page[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 21cm;  
}
page[size="A3"] {
  width: 29.7cm;
  height: 42cm;
}
page[size="A3"][layout="landscape"] {
  width: 42cm;
  height: 29.7cm;  
}
page[size="A5"] {
  width: 14.8cm;
  height: 21cm;
}
page[size="A5"][layout="landscape"] {
  width: 21cm;
  height: 14.8cm;  
}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
    font-family : 'Poppins', sans-serif;  
  }
}
.wrapper_letter{
    
    overflow:auto;
}


.c1{
   float:left;

}


.c2{

    float:right;
}


</style>
<table style="width: 100%;">
<thead>
  <tr>
    <td><img src="<?= base_url() ?>assets/img/kop_surat_wika.png" width="100%"> </td>
  </tr>
</thead>
</table>
<table style="width: 100%;">
<tbody>
<tr>
    <td style="width: 10%;">Nomor</td>
    <td>: <?= $surat['nomor_surat_2'] ?></td>
    <td></td>
    <td align="right"><?php if($surat['tempat'] == "" || $surat['tanggal'] == "") { ?>Jakarta, <?= date('d-m-Y') ?><?php }else { echo $surat['tempat'].", ".$surat['tanggal']; } ?></td>
  </tr>
  <tr>
    <td style="width: 10%;">Lampiran</td>
    <td>: <?= $surat['nomor_lampiran'] ?></td>
    <td></td>
    <td></td>
  </tr>
</tbody>
</table>
<br>
<br>
<p>Kepada Yth.</p>
<p><strong>Direktur Utama </strong></p>
<?php foreach ($list_direktur as $key => $value) :?>
<p><?= $value['dir_name'] ?></p>
<?php endforeach; ?>

<p>Perihal : <strong>Pengumuman Pemenang </strong></p>
<br>
<br>
<p>Dengan hormat,</p>
<p>Berdasarkan hasil Evaluasi Klarifikasi dan Negosiasi pada tanggal <?= $tender['ptp_quot_opening_date'] ?>, berikut kami sampaikan hasil penetapan pemenang <strong><em>Pekerjaan <?= $tender['ptm_project_name']; ?></em></strong> dengan rincian sebagai berikut:</p>
<p></p>
<table style="width: 100%;" border="0.5px">
<tbody>
<tr>
<td style="width: 20%;">
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
</tr>
<tr>
<td>
NPWP
</td>
<?php
				$par = 1;
				foreach ($evaluation as $key => $value) {
					
					if (true) { ?>
						<td></td>
						
					<?php }

					$par += 1;
				}
			?>
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

