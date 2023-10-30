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
    font-size: 12; 
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

<p>Perihal : <strong>Penunjukan Penyedia</strong></p>
<br>
<br>
<p>Dengan hormat,</p>
<p>Berdasarkan penawaran saudara tertanggal <?= $tender['ptp_quot_opening_date'] ?> serta Berita Acara Klarifikasi dan Negosiasi pada tanggal <?= $tender['ptp_quot_opening_date'] ?>, maka sesuai hasil evaluasi dan klarifikasi teknis yang telah kami lakukan maka dengan ini kami <strong>Menunjuk Sebagai Penyedia:</strong></p>
<p>Nama Pekerjaan : <?= $tender['ptm_project_name']; ?></p>
<p>Nama Perusahaan : <?= $vendor['vendor_name']; ?></p>
<p>Alamat Perusahaan : <?= $vendor['address_street']; ?></p>
<p>Nilai : <?= number_format($evaluation[0]['amount'],2); ?> kondisi sesuai negosiasi</p>
<p>Ketentuan Penunjukan : Terlampir</p>
<br>
<p>Sebagai tindak lanjut dari Surat Penunjukan Penyedia ini saudara diharuskan untuk menyampaikan jaminan pelaksanaan (jika dipersyaratkan) dan menandatangani kontrak. Demikian Surat Penunjukan ini dikeluarkan untuk dapat dilaksanakan sebagaimana mestinya, atas perhatian dan kerjasamanya kami sampaikan terima kasih.</p>
<br>
<p style="text-align: center;"></p>
<br>
<table style="width: 100%;">
    <thead>
      
    </thead>
    <tbody>
        <tr>
            <td style="width: 40%;" scope="row"></td>
            <td style="width: 20%;" scope="row"></td>

            <td style="width: 40%;"><p>Hormat Kami,</p></td>
            
        </tr>
       
        <tr>
        <td style="width: 30%;" scope="row"><p><strong></strong></p></td>
            <td style="width: 20%;" scope="row"></td>
            <td style="width: 30%;"><p><strong>PT WIJAYA KARYA (Persero) Tbk</strong></p></td>
            
        </tr>
        <tr>
        <td style="width: 40%;" scope="row"><p><em>,</em></p></td>
            <td style="width: 20%;" scope="row"></td>
            <td style="width: 40%;"><p>Manajemen<em>,</em></p></td>
            
        </tr>

        <tr>
        <td style="width: 40%;" scope="row"><br></td>
            <td style="width: 20%;" scope="row"></td>
            <td style="width: 40%;"></td>
            
        </tr>

        <tr>
        <td style="width: 40%;" scope="row"><br></td>
            <td style="width: 20%;" scope="row"></td>
            <td style="width: 40%;"></td>
            
        </tr>
        <tr>
        <td style="width: 40%;"scope="row"><p></p></td>
            <td style="width: 20%;" scope="row"></td>
            <td style="width: 40%;"><p><?= $manajer_proyek ?></p></td>
            
        </tr>

    </tbody>
</table>


