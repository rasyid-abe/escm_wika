<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png') ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/page-login/fonts/icomoon/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/page-login/css/owl.carousel.min.css">
    
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title><?php echo COMPANY_NAME ?> | Login</title>
        <style>
            .a_link_qr{
            color:#fff !important;
            text-decoration : none !important;
            }
        </style>
    </head>
    <body>
        <div class="row mt-1" >
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="text-center py-3">
                    <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-responsive" style="height: 30%; width: 30%">
                </div>
                <p class="text-center">Electronic Supply Chain Management <br/><strong><?php echo COMPANY_NAME ?></strong></p>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row" >
            <div class="col-12" >
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card-header">
                                <h4 class="card-title">Vendor Terpilih</h4>
                            </div>
                            <div class="table-responsive">
                            <div class="wrapper wrapper-content animated fadeIn">
                                <div class="row m-t-lg">
                                    <div class="col-lg-12">
                                        <!-- perubahan d m Y H:i:s dari hlmifzi -->
                                        <div class="tabs-container">
                                            <div class="tabs-left">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#tab-1">Data Utama</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-3">Pengurus Perusahaan</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-5">Barang/Jasa</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-6">SDM</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-7">Sertifikasi</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-8">Fasilitas/Peralatan</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-9">Pengalaman Proyek</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-10">Data Tambahan</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-11">Data Dokumen</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-12">Dokumen PQ</a></li>
                                                </ul>
                                                <div class="tab-content ">
                                                    <div id="tab-1" class="tab-pane active">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Nama Perusahaan
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th>Prefiks</th>
                                                                            <td><?php echo $header['prefix']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Prefiks Lainnya</th>
                                                                            <td><?php echo $header['prefix_other']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Nama Perusahaan</th>
                                                                            <td><?php echo $header['vendor_name']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Sufiks</th>
                                                                            <td><?php echo $header['suffix']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Sufiks Lainnya</th>
                                                                            <td><?php echo $header['suffix_other']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Tipe Perusahaan</th>
                                                                            <td>
                                                                                <ol>
                                                                                    <?php foreach ($tipe as $row) {
                                                                                        echo "<li>" . $row['company_type'] . "</li>" ?>
                                                                                    <?php } ?>
                                                                                </ol>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Email Registrasi</th>
                                                                            <td><?php echo $header['email_address']; ?></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Kode Nasabah
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th>Kode Nasabah</th>
                                                                            <td><?php echo $query['nasabah_code']; ?></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Kontak Perusahaan
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Jenis</th>
                                                                                    <th>Alamat</th>
                                                                                    <th>Kota</th>
                                                                                    <th>Negara</th>
                                                                                    <th>Telp Kantor-1</th>
                                                                                    <th>Telp Kantor-2</th>
                                                                                    <th>Fax</th>
                                                                                    <th>Website</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($alamat as $row) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["type"] ?></td>
                                                                                    <td><?php echo $row["address"] ?></td>
                                                                                    <td><?php echo $row["city"] ?></td>
                                                                                    <td><?php echo $row["country"] ?></td>
                                                                                    <td><?php echo $row["telephone1_no"] ?></td>
                                                                                    <td><?php echo $row["telephone2_no"] ?></td>
                                                                                    <td><?php echo $row["fax"] ?></td>
                                                                                    <td><?php echo $row["website"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Kontak Person
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th>Nama</th>
                                                                            <td><?php echo $header['contact_name']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Jabatan</th>
                                                                            <td><?php echo $header['contact_pos']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Nomor Telepon</th>
                                                                            <td><?php echo $header['contact_phone_no']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Alamat Email</th>
                                                                            <td><?php echo $header['contact_email']; ?></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="tab-3" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Dewan Komisaris
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Jabatan</th>
                                                                                    <th>Telepon</th>
                                                                                    <th>Email</th>
                                                                                    <th>KTP</th>
                                                                                    <th>NPWP</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($board as $row) {
                                                                                    if ($row["type"] == "BOC") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["name"] ?></td>
                                                                                    <td><?php echo $row["pos"]; ?></td>
                                                                                    <td><?php echo $row["telephone_no"] ?></td>
                                                                                    <td><?php echo $row["email_address"] ?></td>
                                                                                    <td><?php echo $row["ktp_no"] ?></td>
                                                                                    <td><?php echo $row["npwp_no"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Dewan Direksi
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Jabatan</th>
                                                                                    <th>Telepon</th>
                                                                                    <th>Email</th>
                                                                                    <th>KTP</th>
                                                                                    <th>NPWP</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($board as $row) {
                                                                                    if ($row["type"] == "BOD") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["name"] ?></td>
                                                                                    <td><?php echo $row["pos"]; ?></td>
                                                                                    <td><?php echo $row["telephone_no"] ?></td>
                                                                                    <td><?php echo $row["email_address"] ?></td>
                                                                                    <td><?php echo $row["ktp_no"] ?></td>
                                                                                    <td><?php echo $row["npwp_no"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-5" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Barang yang Bisa Dipasok
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Jenis Komoditas</th>
                                                                                    <th>Nama Barang</th>
                                                                                    <th>Merk</th>
                                                                                    <th>Sumber</th>
                                                                                    <th>Tipe</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($barang as $row) {
                                                                                    if ($row["catalog_type"] == "M") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["product_description"]; ?></td>
                                                                                    <td><?php echo $row["product_name"] ?></td>
                                                                                    <td><?php echo $row["brand"] ?></td>
                                                                                    <td><?php echo $row["source"] ?></td>
                                                                                    <td><?php echo $row["catalog_type"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Jasa yang Bisa Dipasok
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Jenis Komoditas</th>
                                                                                    <th>Nama Barang</th>
                                                                                    <th>Merk</th>
                                                                                    <th>Sumber</th>
                                                                                    <th>Tipe</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($barang as $row) {
                                                                                    if ($row["catalog_type"] == "S") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["product_description"]; ?></td>
                                                                                    <td><?php echo $row["product_name"] ?></td>
                                                                                    <td><?php echo $row["brand"] ?></td>
                                                                                    <td><?php echo $row["source"] ?></td>
                                                                                    <td><?php echo $row["catalog_type"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-6" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Tenaga Ahli Utama
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Pendidikan Terakhir</th>
                                                                                    <th>Pengalaman</th>
                                                                                    <th>Status</th>
                                                                                    <th>Kewarganegaraan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($sdm as $row) {
                                                                                    if ($row["type"] == "PRIMER") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["name"]; ?></td>
                                                                                    <td><?php echo $row["last_education"] ?></td>
                                                                                    <td><?php echo $row["year_exp"] ?></td>
                                                                                    <td><?php echo $row["emp_status"] ?></td>
                                                                                    <td><?php echo $row["emp_type"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Tenaga Ahli Pendukung
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Pendidikan Terakhir</th>
                                                                                    <th>Pengalaman</th>
                                                                                    <th>Status</th>
                                                                                    <th>Kewarganegaraan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($sdm as $row) {
                                                                                    if ($row["type"] == "SUPPORT") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["name"]; ?></td>
                                                                                    <td><?php echo $row["last_education"] ?></td>
                                                                                    <td><?php echo $row["year_exp"] ?></td>
                                                                                    <td><?php echo $row["emp_status"] ?></td>
                                                                                    <td><?php echo $row["emp_type"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-7" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Keterangan Sertifikasi
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Jenis</th>
                                                                                    <th>Nama Sertifikat</th>
                                                                                    <th>Nomor Sertifikat</th>
                                                                                    <th>Dikeluarkan Oleh</th>
                                                                                    <th>Berlaku Mulai</th>
                                                                                    <th>Berlaku Sampai</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($sertifikasi as $row) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["type"]; ?></td>
                                                                                    <td><?php echo $row["cert_name"] ?></td>
                                                                                    <td><?php echo $row["cert_no"] ?></td>
                                                                                    <td><?php echo $row["issued_by"] ?></td>
                                                                                    <td><?php echo date("d-m-Y", $row['valid_from']['time'] / 1000) ?></td>
                                                                                    <td><?php echo date("d-m-Y", $row['valid_to']['time'] / 1000) ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-8" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Keterangan Fasilitas/Peralatan
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Kategori</th>
                                                                                    <th>Nama Peralatan</th>
                                                                                    <th>Spesifikasi</th>
                                                                                    <th>Kuantitas</th>
                                                                                    <th>Tahun Pembuatan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($fasilitas as $row) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["category"]; ?></td>
                                                                                    <td><?php echo $row["equip_name"] ?></td>
                                                                                    <td><?php echo $row["spec"] ?></td>
                                                                                    <td><?php echo $row["year_made"] ?></td>
                                                                                    <td><?php echo $row["quantity"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-9" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Pekerjaan
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama Pelanggan</th>
                                                                                    <th>Nama Proyek</th>
                                                                                    <th>Keterangan Proyek</th>
                                                                                    <th>Nilai</th>
                                                                                    <th>No Kontrak</th>
                                                                                    <th>Tanggal Dimulai</th>
                                                                                    <th>Tanggal Selesai</th>
                                                                                    <th>Contact Person</th>
                                                                                    <th>No Kontak</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($pengalaman as $row) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["client_name"]; ?></td>
                                                                                    <td><?php echo $row["project_name"] ?></td>
                                                                                    <td><?php echo $row["description"] ?></td>
                                                                                    <td><?php echo ($row["currency"]) ?><?php echo inttomoney($row["amount"]); ?></td>
                                                                                    <td><?php echo $row["contract_no"] ?></td>
                                                                                    <td><?php echo date("d-m-Y", $row["start_date"]['time'] / 1000) ?></td>
                                                                                    <td><?php echo date("d-m-Y", $row["end_date"]['time'] / 1000) ?></td>
                                                                                    <td><?php echo $row["contact_person"] ?></td>
                                                                                    <td><?php echo $row["contact_no"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-10" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Prinsipal
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Alamat</th>
                                                                                    <th>Kota</th>
                                                                                    <th>Negara</th>
                                                                                    <th>Kode Pos</th>
                                                                                    <th>Kualifikasi</th>
                                                                                    <th>Hubungan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($tambahan as $row) {
                                                                                    if ($row["type"] == "PRINCIPAL") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["name"]; ?></td>
                                                                                    <td><?php echo $row["address"] ?></td>
                                                                                    <td><?php echo $row["city"] ?></td>
                                                                                    <td><?php echo $row["country"] ?></td>
                                                                                    <td><?php echo $row["post_code"] ?></td>
                                                                                    <td><?php echo $row["qualification"] ?></td>
                                                                                    <td><?php echo $row["relationship"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Afiliasi
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Alamat</th>
                                                                                    <th>Kota</th>
                                                                                    <th>Negara</th>
                                                                                    <th>Kode Pos</th>
                                                                                    <th>Kualifikasi</th>
                                                                                    <th>Hubungan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($tambahan as $row) {
                                                                                    if ($row["type"] == "AFFILIATE") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["name"]; ?></td>
                                                                                    <td><?php echo $row["address"] ?></td>
                                                                                    <td><?php echo $row["city"] ?></td>
                                                                                    <td><?php echo $row["country"] ?></td>
                                                                                    <td><?php echo $row["postCode"] ?></td>
                                                                                    <td><?php echo $row["qualification"] ?></td>
                                                                                    <td><?php echo $row["relationship"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Subkontraktor
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Alamat</th>
                                                                                    <th>Kota</th>
                                                                                    <th>Negara</th>
                                                                                    <th>Kode Pos</th>
                                                                                    <th>Kualifikasi</th>
                                                                                    <th>Hubungan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($tambahan as $row) {
                                                                                    if ($row["type"] == "SUBCONTRACTOR") { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["name"]; ?></td>
                                                                                    <td><?php echo $row["address"] ?></td>
                                                                                    <td><?php echo $row["city"] ?></td>
                                                                                    <td><?php echo $row["country"] ?></td>
                                                                                    <td><?php echo $row["postCode"] ?></td>
                                                                                    <td><?php echo $row["qualification"] ?></td>
                                                                                    <td><?php echo $row["relationship"] ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-11" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Dokumen
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>File</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $i = 1;
                                                                                    foreach ($dokumen as $row) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $row["vnd_suppdoc_desc"]; ?></td>
                                                                                    <td><a href="<?php echo $url_doc . "/" . $row["vnd_suppdoc_filename"] ?>" target="_blank"><?php echo $row["vnd_suppdoc_filename"] ?></a></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $i++;
                                                                                    }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="tab-12" class="tab-pane">
                                                        <div class="panel-body">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    Dokumen PQ
                                                                </div>
                                                                <div style="padding: 15px;">
                                                                    <div class="table-responsive">
                                                                        <br>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-12 control-label">Tipe Vendor : <?php echo (isset($doc_pq[0]['vtm_name']) ? $doc_pq[0]['vtm_name'] : "") ?></label>
                                                                            <label class="col-sm-12 control-label">Template : <?php echo (isset($doc_pq[0]['avd_name']) ? $doc_pq[0]['avd_name'] : "") ?></label>
                                                                            <label class="col-sm-12 control-label">Nilai SHE : <?php echo (isset($doc_pq[0]['vdp_she_main']) ? $doc_pq[0]['vdp_she_main'] : "") ?></label>
                                                                        </div>
                                                                        <div class="col-sm-8" style="margin-top:5px">
                                                                            <div class="col-md-6 col-sm-6 alert alert-dismissible alert-info">
                                                                                <strong>Keterangan</strong><br/>
                                                                                0 - 60&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Risiko Rendah<br/>
                                                                                61 - 80&nbsp;&nbsp;&nbsp;&nbsp;: Risiko Menengah<br/>
                                                                                81 - 100&nbsp;&nbsp;: Risiko Tinggi<br/>
                                                                            </div>
                                                                        </div>
                                                                        <br><br>
                                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 2%">No</th>
                                                                                    <th>Nama Dokumen</th>
                                                                                    <th>File</th>
                                                                                    <!-- <th>SHE</th> -->
                                                                                    <!-- <th>Tanggal Berlaku</th>
                                                                                        <th>Tanggal Expired</th> -->
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php 
                                                                                    $i = 1;
                                                                                    foreach ($doc_pq as $key => $value) { ?>
                                                                                <tr>
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $value["vdd_name"]; ?></td>
                                                                                    <td>
                                                                                        <a href="<?php echo site_url('log/download_attachment_extranet/Dokumen PQ/'.$value['vendor_id'].'/'.$value['doc_file']) ?>" target="_blank"><?php echo $value['doc_file'] ?></a>
                                                                                        <!-- <td><?php echo $value["vdp_she"]; ?></td> -->
                                                                                    </td>
                                                                                </tr>
                                                                                <?php $i++; } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            $(document).ready(function() {
              $('.dataTables-example').DataTable({
                "lengthMenu": [
                  [5, 10, 25, 50, -1],
                  [5, 10, 25, 50, "All"]
                ]
              });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script src="<?php echo base_url(); ?>assets/page-login/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/page-login/js/bootstrap.min.js"></script>
    </body>
</html>