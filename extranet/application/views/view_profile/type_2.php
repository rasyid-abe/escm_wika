<div class="wrapper wrapper-content animated fadeIn">
    <div class="row m-t-lg">
        <div class="col-lg-12">
            <div class="tabs-container">

                <div class="tabs-left">
                    <div class="section-tab">
                        <a class="badge badge-secondary mt-1 active" data-toggle="tab" href="#tab-1">Data Utama</a>
                        <a class="badge badge-secondary mt-1 active" data-toggle="tab" href="#tab-2">Data Pendidikan</a>
                        <a class="badge badge-secondary mt-1 active" data-toggle="tab" href="#tab-3">Data Pengalaman</a>
                        <a class="badge badge-secondary mt-1 active" data-toggle="tab" href="#tab-4">Data Pelatihan</a>
                    </div>

                    <div class="tab-content ">											
                        <div id="tab-1" class="tab-pane active">
                            <!-- info-akun -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title text-bold-600">Informasi Akun <span class="text-danger">(*)</span></h5>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <!-- content -->
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Email</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="email_address" value="<?php echo $get_header['email_address']; ?>" readonly>
                                                            <div class="form-control-position">
                                                                <i class="ft-mail"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Nama Lengkap</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="vendor_name" value="<?php echo $get_header['vendor_name']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">KTP/Nomor Identitas</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="id_card" value="<?php echo $get_header['id_card']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">NPWP</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="npwp_no" value="<?php echo $get_header['npwp_no']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Tempat Lahir</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="birth_place" value="<?php echo $get_header['birth_place']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Tanggal Lahir</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="birth_date" value="<?php echo $get_header['birth_date']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Status</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="status_fp" value="<?php echo $get_header['status_fp']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-user"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row last mb-3">
                                                    <label class="col-md-3 label-control text-right">Tipe Vendor</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <?php
                                                            $typev = "-";
                                                            if ($get_header['vendor_type'] == 1) {
                                                                $typev = "Non-Perorangan";
                                                            } elseif ($get_header['vendor_type'] == 2) {
                                                                $typev = "Perorangan";
                                                            } elseif ($get_header['vendor_type'] == 3) {
                                                                $typev = "Luar Negeri";
                                                            }
                                                            ?>
                                                            <input type="text" class="form-control" name="type_vendor" value="<?php echo $typev; ?>" readonly>
                                                            <div class="form-control-position">
                                                                <i class="ft-tag"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- alamat -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title text-bold-600">Alamat <span class="text-danger">(*)</span></h5>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <!-- content -->
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Negara</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="address_country" value="<?php echo $get_header['address_country']; ?>" readonly>
                                                            <div class="form-control-position">
                                                                <i class="ft-mail"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Provinsi</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="addres_prop" value="<?php echo $get_header['addres_prop']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Kabupaten</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="address_city" value="<?php echo $get_header['address_city']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Kecamatan</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="address_district" value="<?php echo $get_header['address_district']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Alamat Detail</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="address_street" value="<?php echo $get_header['address_street']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-briefcase"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>								
                                                <div class="form-group row last mb-3">
                                                    <label class="col-md-3 label-control text-right">Kode Pos</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="address_postcode" value="<?php echo $get_header['address_postcode']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-user"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>																
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- kontak -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title text-bold-600">Kontak <span class="text-danger">(*)</span></h5>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <!-- content -->
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Nama Kontak</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="contact_name" value="<?php echo $get_header['contact_name']; ?>" readonly>
                                                            <div class="form-control-position">
                                                                <i class="ft-mail"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>														
                                                <div class="form-group row last mb-3">
                                                    <label class="col-md-3 label-control text-right">Nomor Kontak</label>
                                                    <div class="col-md-9">
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="contact_phone_no" value="<?php echo $get_header['contact_phone_no']; ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="ft-user"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>																
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- lampiran -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title text-bold-600">Lampiran <span class="text-danger">(*)</span></h5>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <!-- content -->
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Lampiran Kontrak</label>
                                                    <div class="col-md-9">
                                                        <?php 
                                                            $lampiran = isset($get_header['contract_attachment']) ? $get_header['contract_attachment'] : "#";
                                                            $label = isset($get_header['contract_attachment']) ? "Download" : "---";
                                                        ?>
                                                        <a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
                                                    </div>
                                                </div>														
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Lampiran KTP</label>
                                                    <div class="col-md-9">
                                                        <?php 
                                                            $lampiran = isset($get_header['id_attachment']) ? $get_header['id_attachment'] : "#";
                                                            $label = isset($get_header['id_attachment']) ? "Download" : "---";
                                                        ?>
                                                        <a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
                                                    </div>
                                                </div>														
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Lampiran Referensi</label>
                                                    <div class="col-md-9">
                                                        <?php 
                                                            $lampiran = isset($get_header['ref_doc_attachment']) ? $get_header['ref_doc_attachment'] : "#";
                                                            $label = isset($get_header['ref_doc_attachment']) ? "Download" : "---";
                                                        ?>
                                                        <a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
                                                    </div>
                                                </div>														
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control text-right">Lampiran NPWP</label>
                                                    <div class="col-md-9">
                                                        <?php 
                                                            $lampiran = isset($get_header['tax_attachment']) ? $get_header['tax_attachment'] : "#";
                                                            $label = isset($get_header['tax_attachment']) ? "Download" : "---";
                                                        ?>
                                                        <a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
                                                    </div>
                                                </div>														
                                                <div class="form-group row last mb-3">
                                                    <label class="col-md-3 label-control text-right">Lampiran SIM</label>
                                                    <div class="col-md-9">
                                                        <?php 
                                                            $lampiran = isset($get_header['sim_attachment']) ? $get_header['sim_attachment'] : "#";
                                                            $label = isset($get_header['sim_attachment']) ? "Download" : "---";
                                                        ?>
                                                        <a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
                                                    </div>
                                                </div>																
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1 font-medium-1">Data Pendidikan</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Institute</th>
                                                        <th>Jenjang</th>
                                                        <th>Gelar</th>
                                                        <th>Kota</th>
                                                        <th>Tahun</th>
                                                        <th>Lampiran</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($get_pendidikan as $value) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td><?php echo $value['institute']; ?></td>
                                                            <td><?php echo $value['degree']; ?></td>
                                                            <td><?php echo $value['major']; ?></td>
                                                            <td><?php echo $value['city']; ?></td>
                                                            <td><?php echo $value['year']; ?></td>
                                                            <td>
                                                                <?php if ($value['attachment'] != NULL) { ?>
                                                                    <a href="<?php echo $value['attachment']; ?>" target="_blank">Download</a>
                                                                <?php } else echo '-'; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1 font-medium-1">Data Pengalaman</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Perusahaan</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Lokasi</th>
                                                        <th>Posisi</th>
                                                        <th>Nama Projek</th>
                                                        <th>Lampiran</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($get_pengalaman as $value) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td><?php echo $value['company_name']; ?></td>
                                                            <td><?php echo $value['start_date']; ?></td>
                                                            <td><?php echo $value['end_date']; ?></td>
                                                            <td><?php echo $value['location']; ?></td>
                                                            <td><?php echo $value['position']; ?></td>
                                                            <td><?php echo $value['project_name']; ?></td>
                                                            <td>
                                                                <?php if ($value['attachment'] != NULL) { ?>
                                                                    <a href="<?php echo $value['attachment']; ?>" target="_blank">Download</a>
                                                                <?php } else echo '-'; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1 font-medium-1">Data Pelatihan</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Lokasi</th>
                                                        <th>Nama Pelatihan</th>
                                                        <th>Nama Perusahaan</th>
                                                        <th>Tahun</th>
                                                        <th>Lampiran</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($get_pelatihan as $value) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td><?php echo $value['city']; ?></td>
                                                            <td><?php echo $value['name']; ?></td>
                                                            <td><?php echo $value['institute']; ?></td>
                                                            <td><?php echo $value['year']; ?></td>
                                                            <td>
                                                                <?php if ($value['attachment'] != NULL) { ?>
                                                                    <a href="<?php echo $value['attachment']; ?>" target="_blank">Download</a>
                                                                <?php } else echo '-'; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
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