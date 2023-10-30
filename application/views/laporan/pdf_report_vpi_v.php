<style type="text/css">
  html {
    font-family: sans-serif;
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

  p {
    font-size: 10px;
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
    <td><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo "Divisi Supply Chain Management"; ?></td>

  </tr>
</table>
<br>
<br>

<center>
  <h5 style="margin:0px;">Report VPI <?= $year != 0 ? " - " . $year : "" ?></h5>
</center>
<br>
<h4>Tabel VPI Vendor </h4>
<table style="width:100%;" class="is-content">
  <thead>
    <tr>
      <th>No</th>
      <th>Vendor</th>
      <th>Januari</th>
      <th>Februari</th>
      <th>Maret</th>
      <th>April</th>
      <th>Mei</th>
      <th>Juni</th>
      <th>Juli</th>
      <th>Agustus</th>
      <th>September</th>
      <th>Oktober</th>
      <th>November</th>
      <th>Desember</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data_vendor as $key => $value) : ?>
      <tr>
        <td><?= $key + 1 ?></td>
        <td><?= $value['vendor_name'] ?></td>
        <td><?= $value['januari'] ?></td>
        <td><?= $value['februari'] ?></td>
        <td><?= $value['maret'] ?></td>
        <td><?= $value['april'] ?></td>
        <td><?= $value['mei'] ?></td>
        <td><?= $value['juni'] ?></td>
        <td><?= $value['juli'] ?></td>
        <td><?= $value['agustus'] ?></td>
        <td><?= $value['september'] ?></td>
        <td><?= $value['oktober'] ?></td>
        <td><?= $value['november'] ?></td>
        <td><?= $value['desember'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br>

<h4>Tabel VPI PROYEK </h4>
<table style="width:100%;" class="is-content">
  <thead>
    <tr>
      <th>No</th>
      <th>Proyek</th>
      <th>Tahun</th>
      <th>Januari</th>
      <th>Februari</th>
      <th>Maret</th>
      <th>April</th>
      <th>Mei</th>
      <th>Juni</th>
      <th>Juli</th>
      <th>Agustus</th>
      <th>September</th>
      <th>Oktober</th>
      <th>November</th>
      <th>Desember</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data_proyek as $key => $value) { ?>
      <tr>
        <td><?= $key + 1 ?></td>
        <td><?= $value['subject_work'] ?></td>
        <td><?= $value['vpi_year'] ?></td>
        <td><?= $value['januari'] ?></td>
        <td><?= $value['februari'] ?></td>
        <td><?= $value['maret'] ?></td>
        <td><?= $value['april'] ?></td>
        <td><?= $value['mei'] ?></td>
        <td><?= $value['juni'] ?></td>
        <td><?= $value['juli'] ?></td>
        <td><?= $value['agustus'] ?></td>
        <td><?= $value['september'] ?></td>
        <td><?= $value['oktober'] ?></td>
        <td><?= $value['november'] ?></td>
        <td><?= $value['desember'] ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<br>

<h4>Tabel VPI Divisi </h4>
<table style="width:100%;" class="is-content">
  <thead>
    <tr>
      <th>No</th>
      <th>Divisi</th>
      <th>Januari</th>
      <th>Februari</th>
      <th>Maret</th>
      <th>April</th>
      <th>Mei</th>
      <th>Juni</th>
      <th>Juli</th>
      <th>Agustus</th>
      <th>September</th>
      <th>Oktober</th>
      <th>November</th>
      <th>Desember</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data_divisi as $key => $value) : ?>
      <tr>
        <td><?= $key + 1 ?></td>
        <td><?= $value['dept_name'] ?></td>
        <td><?= $value['januari'] ?></td>
        <td><?= $value['februari'] ?></td>
        <td><?= $value['maret'] ?></td>
        <td><?= $value['april'] ?></td>
        <td><?= $value['mei'] ?></td>
        <td><?= $value['juni'] ?></td>
        <td><?= $value['juli'] ?></td>
        <td><?= $value['agustus'] ?></td>
        <td><?= $value['september'] ?></td>
        <td><?= $value['oktober'] ?></td>
        <td><?= $value['november'] ?></td>
        <td><?= $value['desember'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>