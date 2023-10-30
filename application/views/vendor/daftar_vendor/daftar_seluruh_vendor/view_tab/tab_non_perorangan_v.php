<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Utama</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Legal</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab13" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Pajak</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab14" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Keuangan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab15" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Saham</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab16" data-toggle="tab" aria-controls="tab6" href="#tab6" aria-expanded="false">Pengurus</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab17" data-toggle="tab" aria-controls="tab7" href="#tab7" aria-expanded="false">Personil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab18" data-toggle="tab" aria-controls="tab8" href="#tab8" aria-expanded="false">Pengalaman</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab19" data-toggle="tab" aria-controls="tab9" href="#tab9" aria-expanded="false">Fasilitas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab20" data-toggle="tab" aria-controls="tab10" href="#tab10" aria-expanded="false">Produk</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab21" data-toggle="tab" aria-controls="tab11" href="#tab11" aria-expanded="false">Data Tambahan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab24" data-toggle="tab" aria-controls="tab14" href="#tab14" aria-expanded="false">Dokumen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab23" data-toggle="tab" aria-controls="tab13" href="#tab13" aria-expanded="false">CQSMS</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="base-tab22" data-toggle="tab" aria-controls="tab12" href="#tab12" aria-expanded="false">Catatan</a>
    </li>
    <?php if($header['vnd_jenis'] == "Pengadaan.com"): ?>
    <li class="nav-item">
        <a class="nav-link" id="base-tab25" data-toggle="tab" aria-controls="tab15" href="#tab15" aria-expanded="false">Vendor Performance</a>
    </li>
    <?php endif; ?>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab11">        
        <div class="form-group row">
            <label class="col-md-3 label-control">Email</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" name="email_address" value="<?php echo $header['email_address']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-mail"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 label-control">Nama Perusahaan</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" name="vendor_name" value="<?php echo $header['vendor_name']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($header['vendor_code'])) { ?>
            <div class="form-group row">
                <label class="col-md-3 label-control">No DPPM</label>
                <div class="col-md-9">
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" value="<?php echo $header['vendor_code']; ?>" readonly>
                        <div class="form-control-position">
                            <i class="ft-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="form-group row">
            <label class="col-md-3 label-control">NPWP</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" name="npwp_no" value="<?php echo $header['npwp_no']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-box"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 label-control">Tipe Instansi</label>
            <div class="col-md-9">
                <div class="position-relative">
                    <select class="select2 form-control" name="prefix" disabled>
                        <option value="" selected disabled>Pilih</option>
                        <option value="PT" <?php echo $header['prefix'] == 'PT' ? 'selected' : ''; ?>>PT</option>
                        <option value="CV" <?php echo $header['prefix'] == 'CV' ? 'selected' : ''; ?>>CV</option>
                        <option value="Koperasi" <?php echo $header['prefix'] == 'Koperasi' ? 'selected' : ''; ?>>Koperasi</option>
                        <option value="BUT" <?php echo $header['prefix'] == 'BUT' ? 'selected' : ''; ?>>BUT (Badan Usaha Terbatas)</option>
                        <option value="Sekolah / Universitas" <?php echo $header['prefix'] == 'Sekolah / Universitas' ? 'selected' : ''; ?>>Sekolah / Universitas</option>
                        <option value="Yayasan" <?php echo $header['prefix'] == 'Yayasan' ? 'selected' : ''; ?>>Yayasan</option>
                        <option value="Firma Hukum" <?php echo $header['prefix'] == 'Firma Hukum' ? 'selected' : ''; ?>>Firma Hukum</option>
                        <option value="KJPP" <?php echo $header['prefix'] == 'KJPP' ? 'selected' : ''; ?>>KJPP (Kantor Jasa Penilai Publik)</option>
                        <option value="KAP" <?php echo $header['prefix'] == 'KAP' ? 'selected' : ''; ?>>KAP (Kantor Akutan Publik)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Tipe Vendor</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <?php
                    $typev = "-";
                    if ($header['vendor_type'] == 1) {
                        $typev = "Non-Perorangan";
                    } elseif ($header['vendor_type'] == 2) {
                        $typev = "Perorangan";
                    } elseif ($header['vendor_type'] == 3) {
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
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Category Bumn Karya</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['categoryIdBumnkarya']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-tag"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Company Profile</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['companyProfile']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-tag"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Contact Mobile No</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['contactMobileNo']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-phone-call"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Facebook</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['facebook']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-facebook"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Instagram</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['instagram']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-instagram"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Twitter</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['twitter']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-twitter"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">LinkedIn</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['linkedin']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-linkedin"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Link Google Maps</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['linkGoogleMaps']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-map-pin"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Qualification</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['qualification']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-tag"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Industry Key</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['industryKey']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-tag"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Website</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['website']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-link"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row">
            <label class="col-md-3 label-control">Instance Name</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['instanceName']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-tag"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group border-bottom row last mb-3">
            <label class="col-md-3 label-control">3PL/Asuransi</label>
            <div class="col-md-9">
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" value="<?php echo $header['is_3pl_ins']; ?>" readonly>
                    <div class="form-control-position">
                        <i class="ft-tag"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- alamat-perusahaan -->
		<div class="row border-bottom">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="btn-group-sm float-left">
							<h5 class="card-title text-bold-600 mr-2">Alamat Perusahaan</h5> 
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-sm table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Tipe</th>
											<th>Alamat</th>
											<th>Provinsi</th>
											<th>Kota / Kab</th>
											<th>Kecamatan</th>
											<th>Kode Pos</th>
											<th>No Telp/HP</th>
											<th>Fax</th>
											<th>Director</th>
											<th>Front</th>
											<th>Google Maps</th>
											<th>Office</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$no = 1;
											if (isset($alamat) && !empty($alamat)) {
												foreach ($alamat as $key => $value) {
													$myid = $key + 1; ?>
											<tr>
												<td class="text-center"><?php echo $no++; ?></td>
												<td>
													<input type="hidden" value="<?php echo $value['type'] ?>" name="type[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="type">
													<?php echo $value['type'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['alamat'] ?>" name="alamat[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="alamat">
													<?php echo $value['alamat'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['province_name'] ?>" name="province_name[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="province_name">
													<?php echo $value['province_name'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['city_name'] ?>" name="city_name[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="city_name">
													<?php echo $value['city_name'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['district_name'] ?>" name="district_name[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="district_name">
													<?php echo $value['district_name'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['kode_pos'] ?>" name="kode_pos[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="kode_pos">
													<?php echo $value['kode_pos'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['no_telp'] ?>" name="no_telp[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="no_telp">
													<?php echo $value['no_telp'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['fax'] ?>" name="fax[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="fax">
													<?php echo $value['fax'] ?>
												</td>
                                                <td>
													<?php echo $value['picDirector'] ?>
												</td>
												<td>
													<?php echo $value['picFront'] ?>
												</td>
												<td>
													<?php echo $value['picGoogleMaps'] ?>
												</td>
												<td>
													<?php echo $value['picOffice'] ?>
												</td>
											</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <!-- kontak-perusahaan -->
		<div class="row border-bottom">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="btn-group-sm float-left">
							<h5 class="card-title text-bold-600 mr-2">Kontak Perusahaan</h5> 
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-sm table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Lengkap</th>
											<th>Jabatan</th>
											<th>Email</th>
											<th>No Telp/HP</th>
										</tr>
									</thead>
									<tbody>
										<?php $no_kontak = 1;
											if (isset($kontak) && !empty($kontak)) {
											foreach ($kontak as $key => $value) {
												$myid = $key + 1; ?>
											<tr>
												<td class="text-center"><?php echo $no_kontak++; ?></td>
												<td>
													<input type="hidden" value="<?php echo $value['nama_lengkap'] ?>" name="nama_lengkap[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="nama_lengkap">
													<?php echo $value['nama_lengkap'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['jabatan'] ?>" name="jabatan[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="jabatan">
													<?php echo $value['jabatan'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['email'] ?>" name="email[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="email">
													<?php echo $value['email'] ?>
												</td>
												<td>
													<input type="hidden" value="<?php echo $value['no_telp'] ?>" name="no_telp_kontak[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="no_telp_kontak">
													<?php echo $value['no_telp'] ?>
												</td>
											</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <!-- account -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header border-bottom pb-2">
						<div class="btn-group-sm float-left">
							<span class="card-title text-bold-600 mr-2">List Account</span> 
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-sm table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Email</th>
											<th>is_Master</th>
										</tr>
									</thead>
									<tbody>
										<?php $no_account = 1;
											if (isset($account) && !empty($account)) {
											foreach ($account as $key => $value) { ?>
											<tr>
												<td class="text-center"><?php echo $no_account++; ?></td>
												<td>
													<?php echo $value['email'] ?>
												</td>
												<td>
													<?php echo $value['ismaster'] ?>
												</td>
											</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

    <div class="tab-pane" id="tab2" aria-labelledby="base-tab12">
        <!-- akta-perusahaan -->
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Akta Perusahaan</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tipe Akta</th>
                                            <th>No. Akta</th>
                                            <th>Tanggal</th>
                                            <th>Nama Notaris</th>
                                            <th>Alamat Notaris</th>
                                            <th>Lampiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($akta as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['type_akta']; ?></td>
                                                <td><?php echo $value['nomor_akta']; ?></td>
                                                <td><?php echo isset($value['tgl_buat']) ? date("d-m-Y", strtotime($value['tgl_buat'])) : '-'; ?></td>
                                                <td><?php echo $value['nama_notaris']; ?></td>
                                                <td><?php echo $value['alamat_notaris']; ?></td>
                                                <td>
                                                    <?php if ($value['lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran']; ?>" target="_blank">Download</a>
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

        <!-- sk-kemenkumham -->
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">SK KEMKUMHAM</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor SK</th>
                                            <th>Tanggal</th>
                                            <th>Lampiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($sk as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['nomor_sk']; ?></td>
                                                <td><?php echo isset($value['tgl_buat']) ? date("d-m-Y", strtotime($value['tgl_buat'])) : '-'; ?></td>
                                                <td>
                                                    <?php if ($value['lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran']; ?>" target="_blank">Download</a>
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

        <!-- Izin -->
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Izin</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Izin</th>
                                            <th>Tipe Izin</th>
                                            <th>Penerbit</th>
                                            <th>Nomor / Kategori KBLI</th>
                                            <th>Tanggal Pembuatan</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Lampiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($izin as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td>
                                                    <?php
                                                    $type = "-";
                                                    if ($value['type_izin'] == 1) {
                                                        $type = "Domisili";
                                                    } elseif ($value['type_izin'] == 2) {
                                                        $type = "TDP";
                                                    } elseif ($value['type_izin'] == 3) {
                                                        $type = "SIUP";
                                                    } elseif ($value['type_izin'] == 4) {
                                                        $type = "SIUJK";
                                                    }
                                                    echo $type;
                                                    ?>
                                                </td>
                                                <td><?php echo $value['penerbit']; ?></td>
                                                <td><?php echo $value['nomor_izin']; ?></td>
                                                <td><?php echo $value['kategori']; ?></td>
                                                <td><?php echo isset($value['tgl_buat']) ? date("d-m-Y", strtotime($value['tgl_buat'])) : '-'; ?></td>
                                                <td><?php echo isset($value['tgl_kadaluarsa']) ? date("d-m-Y", strtotime($value['tgl_kadaluarsa'])) : '-'; ?></td>
                                                <td>
                                                    <?php if ($value['lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran']; ?>" target="_blank">Download</a>
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

        <!-- sertifikat -->
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Sertifikat</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tipe Sertifikat</th>
                                            <th>Nama Sertifikat</th>
                                            <th>Penerbit Sertifikat</th>
                                            <th>No. Sertifikat</th>
                                            <th>Tanggal Pembuatan</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Lampiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($sertifikat as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['type_sertifikat']; ?></td>
                                                <td><?php echo $value['nama_sertifikat']; ?></td>
                                                <td><?php echo $value['penerbit']; ?></td>
                                                <td><?php echo $value['nomor_sertifikat']; ?></td>
                                                <td><?php echo isset($value['tgl_buat']) ? date("d-m-Y", strtotime($value['tgl_buat'])) : '-'; ?></td>													
                                                <td><?php echo isset($value['tgl_kadaluarsa']) ? date("d-m-Y", strtotime($value['tgl_kadaluarsa'])) : '-'; ?></td>
                                                <td>
                                                    <?php if ($value['lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran']; ?>" target="_blank">Download</a>
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

    <div class="tab-pane" id="tab3" aria-labelledby="base-tab13">
        <!-- laporan -->
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Laporan SPT Tahunan</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Tanggal Lapor</th>
                                            <th>Lampiran Laporan SPT</th>
                                            <th>Lampiran Bukti Lapor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($spt as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['tahun']; ?></td>
                                                <td><?php echo isset($value['tgl_lapor']) ? date("d-m-Y", strtotime($value['tgl_lapor'])) : '-'; ?></td>
                                                <td>
                                                    <?php if ($value['spt_lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['spt_lampiran']; ?>" target="_blank">Download</a>
                                                    <?php } else echo '-'; ?>
                                                </td>
                                                <td>
                                                    <?php if ($value['bukti_lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['bukti_lampiran']; ?>" target="_blank">Download</a>
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
        <!-- pkp -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">PKP</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Dokumen PKP</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="select2 form-control" id="pkpStatus" name="npwp_pkp">
                                            <option value="" selected disabled>Pilih</option>
                                            <option value="Ada" <?php echo $header['npwp_pkp'] == 'Ada' ? 'selected' : ''; ?>>Ada</option>
                                            <option value="Tidak Ada" <?php echo $header['npwp_pkp'] == 'Tidak Ada' ? 'selected' : ''; ?>>Tidak Ada</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pkp">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Nomor PKP</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" maxlength="50" name="npwp_pkp_no" value="<?php echo $header['npwp_pkp_no']; ?>" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Tanggal Terbit PKP</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="sppkp_date" value="<?php echo date('Y-m-d', strtotime($header['sppkp_date'])) ?>" />
                                    </div>
                                </div>
                                <div class="form-group last row">
                                    <label class="col-md-3 label-control">Lampiran</label>
                                    <div class="col-md-9">
                                        <input type="file" id="upload-pkp" name="pkp_lampiran" style="display:none;">
                                        <label class="btn btn-info btn-sm px-2 mr-3" for="upload-pkp"><i class="ft-upload-cloud"></i> Upload file</label>
                                        <label class="custom-file-upload"></label>
                                        <?php echo form_hidden('file_lama_pkp', $header['pkp_lampiran']); ?>
                                        <?php if ($header['pkp_lampiran'] != NULL) { ?>
                                            <span>
                                                <a href="<?php echo site_url('attachment/vendor/' . $this->session->userdata('npwp_no_s') . '/') . $header['pkp_lampiran'] ?>" target="_blank"><i class="ft-download-cloud"></i> Download</a>
                                                <a href="<?php echo site_url('_api/vendor/data/hapus_lampiran_pkp?file=' . $header['pkp_lampiran']) ?>" onclick="return confirm('Apakah Anda yakin hapus file ini?')"><i class="ft-x-circle text-danger"></i></a>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- pajak -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">NPWP</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nomor NPWP</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="npwp_no" value="<?php echo $header['npwp_no']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-tag"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nama</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" id="npwp_nama" name="npwp_nama" value="<?php echo $header['npwp_nama']; ?>">
                                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="<?php echo $header['vendor_name']; ?>" style="display:none">
                                        <div class="form-control-position">
                                            <i class="ft-user"></i>
                                        </div>
                                        <div class="checkbox m-2">
                                            <input type="checkbox" name="checkbox1" id="checkbox1" onclick="myNameFunction()">
                                            <label for="checkbox1"><span>Sama dengan nama perusahaan</span></label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Alamat</label>
                                <div class="col-md-9">

                                    <div class="position-relative has-icon-left">
                                        <textarea rows="4" class="form-control" id="npwp_address" name="npwp_address"><?php echo $header['npwp_address']; ?></textarea>
                                        <?php foreach ($alamat as $value) { ?>
                                            <textarea rows="4" class="form-control" id="alamat" name="alamat" style="display:none"><?php echo $value['alamat'] ?></textarea>
                                        <?php } ?>
                                        <div class="form-control-position">
                                            <i class="ft-navigation"></i>
                                        </div>
                                        <div class="checkbox m-2">
                                            <input type="checkbox" name="checkbox2" id="checkbox2" onclick="myAddressFunction()">
                                            <label for="checkbox2"><span>Sama dengan alamat perusahaan</span></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Provinsi</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="select2 form-control" name="npwp_prop">
                                            <option value="" selected disabled>Pilih</option>
                                            <option value="DKI Jakarta" <?php echo $header['npwp_prop'] == 'DKI Jakarta' ? 'selected' : ''; ?>>DKI Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Kabupaten</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="select2 form-control" name="npwp_city">
                                            <option value="" selected disabled>Pilih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Kecamatan</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="select2 form-control" name="npwp_district">
                                            <option value="" selected disabled>Pilih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Kode Pos</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" maxlength="5" pattern=".{5,}" class="form-control" title="Masukan kode pos dengan benar" onkeypress="return onlyNumber(event)" name="npwp_postcode" value="<?php echo $header['npwp_postcode']; ?>">
                                        <div class="form-control-position">
                                            <i class="ft-file-text"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row last mb-3">
                                <label class="col-md-3 label-control">Lampiran NPWP</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <input type="file" id="upload" name="npwp_lampiran" style="display:none;">
                                        <label class="btn btn-info btn-sm px-2 mr-3" for="upload"><i class="ft-upload-cloud"></i> Upload file</label>
                                        <label class="custom-file-upload"></label>
                                        <?php echo form_hidden('file_lama', $header['npwp_lampiran']); ?>
                                        <?php if ($header['npwp_lampiran'] != NULL) { ?>
                                            <span>
                                                <a href="<?php echo site_url('attachment/vendor/' . $this->session->userdata('npwp_no_s') . '/') . $header['npwp_lampiran'] ?>" target="_blank"><i class="ft-download-cloud"></i> Download</a>
                                                <a href="<?php echo site_url('_api/vendor/data/hapus_lampiran_npwp?file=' . $header['npwp_lampiran']) ?>" onclick="return confirm('Apakah Anda yakin hapus file ini?')"><i class="ft-x-circle text-danger"></i></a>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab4" aria-labelledby="base-tab14">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Modal</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Kemampuan Nyata</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['kemampuanNyata']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Modal Disetor Currency</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['md_mata_uang']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Modal Disetor Nilai</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['md_nilai']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Modal Usaha Currency</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['mu_mata_uang']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Modal Usaha Nilai</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['mu_nilai']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Nilai Pekerjaan Berjalan</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['nilaiPekerjaanBerjalan']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Sisa Kemampuan Nyata</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['sisaKemampuanNyata']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row last mb-3">
                                <label class="col-md-3 label-control">Total Modal Tahun Terakhir</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" value="<?php echo $header['totalModalTahunTerakhir']; ?>" readonly>
                                        <div class="form-control-position">
                                            <i class="ft-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Bank</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- bank -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Bank</th>
                                            <th>Nama Cabang Bank</th>
                                            <th>Negara</th>
                                            <th>Nomor Rekening</th>
                                            <th>Swift Code</th>
                                            <th>Nama Pemilik Rekening</th>
                                            <th>Mata Uang</th>
                                            <th>Rekening Koran</th>
                                            <th>Surat Pernyataan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($bank as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['bank_name']; ?></td>
                                                <td><?php echo $value['bank_branch']; ?></td>
                                                <td><?php echo $value['country']; ?></td>
                                                <td><?php echo $value['account_no']; ?></td>
                                                <td><?php echo $value['bank_id']; ?></td>
                                                <td><?php echo $value['account_name']; ?></td>
                                                <td><?php echo $value['currency']; ?></td>
                                                <td>
                                                    <?php if ($value['rek_koran_lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['rek_koran_lampiran']; ?>" target="_blank">Download</a>
                                                    <?php } else echo '-'; ?>
                                                </td>
                                                <td>
                                                    <?php if ($value['surat_pernyataan'] != NULL) { ?>
                                                        <a href="<?php echo $value['surat_pernyataan']; ?>" target="_blank">Download</a>
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

        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Laporan Tahunan</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- laporan -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 150%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Mata Uang</th>
                                            <th>Jumlah Aset</th>
                                            <th>Hutang</th>
                                            <th>Pendapatan</th>
                                            <th>Profit</th>
                                            <th>Total Beban</th>
                                            <th>Type</th>
                                            <th>Nama Auditor</th>
                                            <th>Alamat Auditor</th>
                                            <th>Lampiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($laporan as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['year']; ?></td>
                                                <td><?php echo $value['currency']; ?></td>
                                                <td><?php echo $value['asset']; ?></td>
                                                <td><?php echo $value['hutang']; ?></td>
                                                <td><?php echo $value['income']; ?></td>
                                                <td><?php echo $value['netprofit']; ?></td>
                                                <td><?php echo $value['finrpttotalcapital']; ?></td>
                                                <td><?php echo $value['type']; ?></td>
                                                <td><?php echo $value['auditorname']; ?></td>
                                                <td><?php echo $value['auditoraddress']; ?></td>
                                                <td><a href="<?php echo $value['attachment']; ?>" target="_blank">Download</a></td>													
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

        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">List DnB</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- dnb -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Attachment</th>
                                            <th>Nama Dokumen</th>
                                            <th>Type</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        if(isset($dnb)) {
                                            foreach ($dnb as $value) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td>
                                                        <a href="<?php echo $value['attachment']; ?>" target="_blank">Download</a>
                                                    </td>													
                                                    <td><?php echo $value['docname']; ?></td>
                                                    <td><?php echo $value['doctype']; ?></td>
                                                    <td><?php echo $value['notes']; ?></td>
                                                </tr>
                                            <?php } ?>
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

    <div class="tab-pane" id="tab5" aria-labelledby="base-tab15">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Saham</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 150%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tipe Pemegang Saham</th>
                                            <th>Nama Pemegang Saham</th>
                                            <th>Jumlah Saham</th>
                                            <th>Alamat</th>
                                            <th>Negara</th>
                                            <th>Provinsi</th>
                                            <th>Kota</th>
                                            <th>Kecamatan</th>
                                            <th>Kode Pos</th>
                                            <th>Nomor Telepon</th>
                                            <th>Lampiran KTP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($saham as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['tipe_saham']; ?></td>
                                                <td><?php echo $value['nama_pemegang']; ?></td>
                                                <td><?php echo $value['jml_kepemilikan']; ?></td>
                                                <td><?php echo $value['address']; ?></td>
                                                <td><?php echo $value['country']; ?></td>
                                                <td><?php echo $value['prop']; ?></td>
                                                <td><?php echo $value['city']; ?></td>
                                                <td><?php echo $value['district']; ?></td>
                                                <td><?php echo $value['kode_pos']; ?></td>
                                                <td><?php echo $value['no_telp']; ?></td>
                                                <td>
                                                    <?php if ($value['lampiran_npwp'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran_npwp']; ?>" target="_blank">Download</a>
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

    <div class="tab-pane" id="tab6" aria-labelledby="base-tab16">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Pengurus</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 150%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Posisi</th>
                                            <th>Nama Lengkap</th>
                                            <th>Kewarganegaraan</th>
                                            <th>No. KTP / Personal ID / Passport / KITAS</th>
                                            <th>NPWP / Tax ID</th>
                                            <th>Lampiran Personal ID</th>
                                            <th>Lampiran NPWP</th>
                                            <th>Negara</th>
                                            <th>Alamat</th>
                                            <th>Provinsi</th>
                                            <th>Kota</th>
                                            <th>Kecamatan</th>
                                            <th>Kode Pos</th>
                                            <th>Nomor Telepon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($pengurus as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['position']; ?></td>
                                                <td><?php echo $value['name']; ?></td>
                                                <td><?php echo $value['nationality']; ?></td>
                                                <td><?php echo $value['ktp']; ?></td>
                                                <td><?php echo $value['npwp']; ?></td>
                                                <td>
                                                    <?php if ($value['lampiran_ktp'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran_ktp']; ?>" target="_blank">Download</a>
                                                    <?php } else echo '-'; ?>
                                                </td>
                                                <td>
                                                    <?php if ($value['lampiran_npwp'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran_npwp']; ?>" target="_blank">Download</a>
                                                    <?php } else echo '-'; ?>
                                                </td>
                                                <td><?php echo $value['address']; ?></td>
                                                <td><?php echo $value['country']; ?></td>
                                                <td><?php echo $value['province']; ?></td>
                                                <td><?php echo $value['city']; ?></td>
                                                <td><?php echo $value['district']; ?></td>
                                                <td><?php echo $value['post_code']; ?></td>
                                                <td><?php echo $value['phone']; ?></td>
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

    <div class="tab-pane" id="tab7" aria-labelledby="base-tab17">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Personil</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 150%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Karyawan</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No. KTP / Personal ID</th>
                                            <th>NPWP / Tax ID</th>
                                            <th>Negara</th>
                                            <th>Provinsi</th>
                                            <th>Kota</th>
                                            <th>Kecamatan</th>
                                            <th>Kode Pos</th>
                                            <th>Nomor Telepon</th>
                                            <th>Status Karyawan</th>
                                            <th>Jenjang Pendidikan</th>
                                            <th>Pelatihan/Sertifikasi</th>
                                            <th>Pengalaman Pekerjaan</th>
                                            <th>Tanggal Mulai Bekerja</th>
                                            <th>Tanggal Terakhir Bekerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($personil as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['nama_karyawan']; ?></td>
                                                <td><?php echo $value['gender']; ?></td>
                                                <td><?php echo $value['nomor_ktp']; ?></td>
                                                <td><?php echo $value['nomor_npwp']; ?></td>
                                                <td><?php echo $value['country']; ?></td>
                                                <td><?php echo $value['province']; ?></td>
                                                <td><?php echo $value['city']; ?></td>
                                                <td><?php echo $value['district']; ?></td>
                                                <td><?php echo $value['kode_pos']; ?></td>
                                                <td><?php echo $value['no_telp']; ?></td>
                                                <td><?php echo $value['status_karyawan']; ?></td>
                                                <td><?php echo $value['jenjang_pendidikan']; ?></td>
                                                <td>
                                                    <?php if ($value['sertifikat_lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['sertifikat_lampiran']; ?>" target="_blank">Download</a>
                                                    <?php } else echo '-'; ?>
                                                </td>
                                                <td>
                                                    <?php if ($value['kontrak_kerja_lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['kontrak_kerja_lampiran']; ?>" target="_blank">Download</a>
                                                    <?php } else echo '-'; ?>
                                                </td>
                                                <td><?php echo isset($value['tgl_mulai']) ? date("d-m-Y", strtotime($value['tgl_mulai'])) : '-'; ?></td>
                                                <td><?php echo isset($value['tgl_selesai']) ? date("d-m-Y", strtotime($value['tgl_selesai'])) : '-'; ?></td>													
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

    <div class="tab-pane" id="tab8" aria-labelledby="base-tab18">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Pengalaman</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered dataTables-example" style="width: 150%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pekerjaan</th>
                                            <th>Ruang Lingkup Pekerjaan</th>
                                            <th>Lokasi/Tempat Pekerjaan</th>
                                            <th>Nama Pemberi Pekerjaan</th>
                                            <th>Alamat Pemberi Pekerjaan</th>
                                            <th>No. Telp Pemberi Pekerjaan</th>
                                            <th>Nomor Kontrak</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Mata Uang</th>
                                            <th>Nilai Kontrak</th>
                                            <th>Lampiran Copy Kontrak/PO</th>
                                            <th>Lampiran Referensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($exp_work as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['nama_pekerjaan']; ?></td>
                                                <td><?php echo $value['ruang_lingkup']; ?></td>
                                                <td><?php echo $value['lokasi_kerja']; ?></td>
                                                <td><?php echo $value['nama_pemberi']; ?></td>
                                                <td><?php echo $value['alamat']; ?></td>
                                                <td><?php echo $value['no_telp']; ?></td>
                                                <td><?php echo $value['nomor_kontrak']; ?></td>
                                                <td><?php echo isset($value['tgl_kontrak']) ? date("d-m-Y", strtotime($value['tgl_kontrak'])) : '-'; ?></td>
                                                <td><?php echo isset($value['tgl_selesai']) ? date("d-m-Y", strtotime($value['tgl_selesai'])) : '-'; ?></td>
                                                <td><?php echo $value['currency']; ?></td>
                                                <td><?php echo number_format($value['nilai'],2,",","."); ?></td>
                                                <td>
                                                    <?php if ($value['kontrak_lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['kontrak_lampiran']; ?>" target="_blank">Download</a>
                                                    <?php } else echo '-'; ?>
                                                </td>
                                                <td>
                                                    <?php if ($value['referensi_lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['referensi_lampiran']; ?>" target="_blank">Download</a>
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

    <div class="tab-pane" id="tab9" aria-labelledby="base-tab19">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Fasilitas</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 150%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tipe</th>
                                            <th>Nama</th>
                                            <th>Jumlah</th>
                                            <th>Spesifikasi</th>
                                            <th>Merek</th>
                                            <th>Tahun Beli/Pembuatan</th>
                                            <th>Kondisi (%)</th>
                                            <th>Lokasi</th>
                                            <th>Kepemilikan</th>
                                            <th>Waktu Pembelian</th>
                                            <th>Lampiran Izin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ($fasilitas as $value) { ?>
                                            <tr>                                                    
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['tipe_fasilitas']; ?></td>
                                                <td><?php echo $value['nama_fasilitas']; ?></td>
                                                <td><?php echo $value['jumlah']; ?></td>
                                                <td><?php echo $value['specification']; ?></td>
                                                <td><?php echo $value['merek']; ?></td>
                                                <td><?php echo $value['tahun']; ?></td>
                                                <td><?php echo $value['kondisi']; ?></td>
                                                <td><?php echo $value['lokasi']; ?></td>
                                                <td><?php echo $value['kepemilikan']; ?></td>
                                                <td><?php echo $value['purchase_date']; ?></td>
                                                <td>
                                                    <?php if ($value['lampiran'] != NULL) { ?>
                                                        <a href="<?php echo $value['lampiran']; ?>" target="_blank">Download</a>
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

    <div class="tab-pane" id="tab10" aria-labelledby="base-tab20">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 float-left">Produk</h5>
                        <a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#katalogForm"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Nama Produk</th>
                                            <th>Nama Group</th>
                                            <th>Brand</th>
                                            <th>Source</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ($produk as $value) { ?>
                                            <tr>                                                    
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['product_code']; ?></td>
                                                <td><?php echo $value['product_name']; ?></td>
                                                <td><?php echo $value['name_group']; ?></td>
                                                <td><?php echo $value['brand']; ?></td>
                                                <td><?php echo $value['source']; ?></td>
                                                <td><?php echo $value['type']; ?></td>                                                    
                                                <td>
                                                    <?php if($value['status'] == 2) { ?>
                                                        <a href="<?php echo site_url('vendor/delete_katalog?id='. $value['id'] . '&vendor_id=' . $header['vendor_id'] ); ?>" onclick="return confirm('Apakah Anda yakin akan hapus data ini?')" class="btn btn-sm btn-danger"><i class="ft-trash"></i></a>
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

    <div class="tab-pane" id="tab11" aria-labelledby="base-tab21">
        <!-- kategorisasi -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom pb-2">
                        <h5 class="card-title text-bold-600">Kategorisasi</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Kualifikasi</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="select2 form-control" name="fin_class" style="width: 50%" disabled>
                                            <option value="">Pilih</option>
                                            <option value="I" <?php echo $header['fin_class'] == 'I' ? 'selected' : ''; ?>>Mikro</option>
                                            <option value="K" <?php echo $header['fin_class'] == 'K' ? 'selected' : ''; ?>>Kecil</option>
                                            <option value="M" <?php echo $header['fin_class'] == 'M' ? 'selected' : ''; ?>>Menengah</option>
                                            <option value="B" <?php echo $header['fin_class'] == 'B' ? 'selected' : ''; ?>>Besar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Tipe Penyedia</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="select2 form-control" name="cot_kelompok" style="width: 50%" disabled>
                                            <option value="" selected disabled>Pilih</option>
                                            <?php foreach ($adm_cot as $value) { ?>
                                                <option value="<?php echo $value['ack_id']; ?>" <?php echo $header['cot_kelompok'] == $value['ack_id'] ? 'selected' : ''; ?>><?php echo $value['ack_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Pengalaman Tertinggi (10 thn terakhir)</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" maxlength="17" class="form-control currency" name="nilai_pengalaman" value="<?php echo number_format($header['nilai_pengalaman'], 0, ',', '.'); ?>" required>
                                        <div class="form-control-position">
                                            <i class="ft-bar-chart-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Lampiran Bukti Kontrak</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <?php if ($header['upload_bukti_kontrak'] != NULL) { ?>
                                            <span>
                                                <a class="btn bg-light-success btn-sm" href="<?php echo base_url('extranet/attachment/vendor/' . $header['vendor_id'] . '/') . $header['upload_bukti_kontrak'] ?>" target="_blank"><i class="ft-download-cloud"></i> Download file</a>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Kemampuan Keuangan Untuk Bekerja</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" maxlength="17" class="form-control currency" name="kemampuan_keuangan" value="<?php echo number_format($header['kemampuan_keuangan'], 0, ',', '.'); ?>" required>
                                        <div class="form-control-position">
                                            <i class="ft-archive"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Kapasitas Produksi</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" maxlength="8" class="form-control currency" name="kapasitas_produk" value="<?php echo number_format($header['kapasitas_produk'], 0, ',', '.'); ?>" required>
                                        <div class="form-control-position">
                                            <i class="ft-hard-drive"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group last row">
                                <label class="col-md-3 label-control">Satuan</label>
                                <div class="col-md-9">
                                    <div class="position-relative has-icon-left">
                                        <input type="text" maxlength="20" class="form-control" name="satuan" value="<?php echo $header['satuan']; ?>" required>
                                        <div class="form-control-position">
                                            <i class="ft-hard-drive"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- klasifikasi -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom pb-2">
                        <div class="btn-group-sm float-left">
                            <span class="card-title text-bold-600 mr-2">Klasifikasi Bidang Usaha</span> 
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="bidang_table" class="table table-striped table-sm table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Type</th>
                                            <th>Nama Bidang</th>
                                            <th>Nama Sub Bidang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no_bidang = 1;
                                            if (isset($bidang) && !empty($bidang)) {
                                            foreach ($bidang as $key => $value) {
                                                $myid = $key + 1; ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no_bidang++; ?></td>
                                                <td>
                                                    <input type="hidden" value="<?php echo $value['type'] ?>" name="tipe_bidang[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="tipe_bidang">
                                                    <?php echo $value['type'] ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" value="<?php echo $value['bidang_name'] ?>" name="nama_bidang[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="nama_bidang">
                                                    <?php echo $value['bidang_name'] ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" value="<?php echo $value['sub_bidang_name'] ?>" name="nama_sub_bidang[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="nama_sub_bidang">
                                                    <?php echo $value['sub_bidang_name'] ?>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom pb-2">
                        <h5 class="card-title text-bold-600">Modal</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <h6 class="text-bold-700">Modal Usaha</h6>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Mata Uang</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="custom-select select2 form-control" name="mu_mata_uang" style="width: 30%" disabled>
                                            <option selected disabled>Pilih...</option>
                                            <option value="IDR" <?php echo $header['mu_mata_uang'] == 'IDR' ? 'selected' : ''; ?>>IDR</option>
                                            <option value="USD" <?php echo $header['mu_mata_uang'] == 'USD' ? 'selected' : ''; ?>>USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group last row">
                                <label class="col-md-3 label-control">Nilai</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <input type="text" maxlength="17" class="form-control currency" name="mu_nilai" value="<?php echo number_format($header['mu_nilai'], 0, ',', '.'); ?>" onkeypress="return onlyNumber(event)">										
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-bold-700">Modal Disetor</h6>
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Mata Uang</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <select class="custom-select select2 form-control" name="md_mata_uang" style="width: 30%" disabled>
                                            <option value="" selected disabled>Pilih...</option>
                                            <option value="IDR" <?php echo $header['md_mata_uang'] == 'IDR' ? 'selected' : ''; ?>>IDR</option>
                                            <option value="USD" <?php echo $header['md_mata_uang'] == 'USD' ? 'selected' : ''; ?>>USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group last row">
                                <label class="col-md-3 label-control">Nilai</label>
                                <div class="col-md-9">
                                    <div class="position-relative">
                                        <input type="text" maxlength="17" class="form-control currency" name="md_nilai" value="<?php echo number_format($header['md_nilai'], 0, ',', '.'); ?>" onkeypress="return onlyNumber(event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- profile -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 float-left">Company Profile</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tipe File</th>
                                            <th>Nama File</th>
                                            <th>Tanggal Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ($company as $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td>
                                                    <?php 
                                                        $type = '--';
                                                        if ($value['tipe_file'] == 1) { $type = 'Foto'; }
                                                        elseif ($value['tipe_file'] == 2) { $type = 'Video'; }
                                                        elseif ($value['tipe_file'] == 3) { $type = 'Dokumen'; }
                                                        echo $type;
                                                    ?>
                                                </td>
                                                <td><a href="<?php echo site_url('attachment/vendor/'.$this->session->userdata('npwp_no_s').'/' . $value['nama_file']); ?>" target="_blank">View</a></td>
                                                <td class="text-right"><?php echo date("d-m-Y H:i:s", strtotime($value['created_at'])); ?></td>                                                                    
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

        <!-- anak-perusahaan -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600">Anak Perusahaan</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Pilih Anak Perusahaan</label>
                                <div class="col-md-9">
                                    <div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-1" <?php echo $anak_1 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Bangunan Gedung Tbk" disabled>
										<label for="color-checkbox-1"><span>PT Wijaya Karya Bangunan Gedung Tbk</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-2" <?php echo $anak_2 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Rekayasa Konstruksi" disabled>
										<label for="color-checkbox-2"><span>PT Wijaya Karya Rekayasa Konstruksi</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-3" <?php echo $anak_3 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Realty" disabled>
										<label for="color-checkbox-3"><span>PT Wijaya Karya Realty</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-4" <?php echo $anak_4 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Serang Panimbang" disabled>
										<label for="color-checkbox-4"><span>PT Wijaya Karya Serang Panimbang</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-5" <?php echo $anak_5 > 0 ? "checked" : "" ?> value="PT WIKA Tirta Jaya Jatiluhur" disabled>
										<label for="color-checkbox-5"><span>PT WIKA Tirta Jaya Jatiluhur</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-6" <?php echo $anak_6 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Beton Tbk" disabled>
										<label for="color-checkbox-6"><span>PT Wijaya Karya Beton Tbk</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-7" <?php echo $anak_7 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Industri Konstruksi" disabled>
										<label for="color-checkbox-7"><span>PT Wijaya Karya Industri Konstruksi</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-8" <?php echo $anak_8 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Bitumen" disabled>
										<label for="color-checkbox-8"><span>PT Wijaya Karya Bitumen</span></label>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab14" aria-labelledby="base-tab24">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Dokumen</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Attachment</th>
                                            <th>Nama Dokumen</th>
                                            <th>Type</th>
                                            <th>Notes</th>
                                            <th>Jenis</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ($dnb as $value) { ?>
                                            <tr>                                                    
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['attachment']; ?></td>
                                                <td><?php echo $value['docname']; ?></td>
                                                <td><?php echo $value['doctype']; ?></td>      
                                                <td><?php echo $value['notes']; ?></td>
                                                <td><?php echo $value['jenis']; ?></td>
                                                <td><?php echo $value['created_at']; ?></td>
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

    <div class="tab-pane" id="tab13" aria-labelledby="base-tab23">
        <div class="row border-bottom">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">CQSMS</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Approve Date</th>
                                            <th>Grade</th>
                                            <th>Nilai Awal</th>
                                            <th>Nilai Akhir</th>
                                            <th>Pengurangan Qhse</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ($cqsms as $value) { ?>
                                            <tr>                                                    
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $value['cqsmsapproveddate']; ?></td>
                                                <td><?php echo $value['cqsmsgrade']; ?></td>
                                                <td><?php echo $value['cqsmsnilaiawal']; ?></td>
                                                <td><?php echo $value['cqsmsnilaiakhir']; ?></td>
                                                <td><?php echo $value['cqsmspenguranganqhse']; ?></td>
                                                <td><?php echo $value['cqsmstype']; ?></td>                                                 
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

    <div class="tab-pane" id="tab12" aria-labelledby="base-tab22">
        <!-- lampiran -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Lampiran Vendor</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="form-group row">
                                <label class="col-md-4 label-control">Surat Pernyataan Vendor</label>
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <?php if ($header['vendor_lampiran'] != NULL) { ?>
                                            <span><a class="btn btn-info btn-sm" href="<?php echo base_url('extranet/attachment/vendor/'. $header['vendor_id'] .'/') . $header['vendor_lampiran']?>" target="_blank">Download</a></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <!-- catatan -->
        <div class="row">   
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom pb-2">
                        <h5 class="card-title text-bold-600 mr-2">Daftar Komentar</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table comment table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>User</th>
                                            <th>Posisi</th>
                                            <th>Activity</th>
                                            <th>Response</th>
                                            <th>Komentar</th>
                                            <th>File</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if(isset($comment_list) && !empty($comment_list)){

                                        foreach ($comment_list as $kc => $vc) {

                                        $start_date = date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_date']));
                                        $end_date = (isset($vc['comment_end_date']) && !empty(strtotime($vc['comment_end_date']))) ? date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_end_date'])) : "";
                                        ?>
                                        <tr>
                                        <td><?php echo $start_date ?></td>
                                        <td><?php echo $end_date  ?></td>
                                        <td><?php echo $vc['comment_name'] ?></td>
                                        <td><?php echo $vc['position'] ?></td>
                                        <td><?php echo $vc['activity_name'] ?></td>
                                        <td><?php echo $vc['response'] ?></td>
                                        <td><?php echo $vc['comments'] ?></td>
                                        <td><a href="<?php echo site_url("log/download_attachment/".$dir."/".$vc['attachment']) ?>" target="_blank"><?php echo $vc['attachment'] ?></a></td>
                                        </tr>
                                        <?php } } ?>

                                    </tbody>
                                </table>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tab15" aria-labelledby="base-tab5">
        <!-- vendor performance -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Vendor Push Performance</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            
                                <input type="hidden" id="vendorId" value="<?= $header['vendor_id'] ?>" >
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Pasal Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="penaltyArticle" id="penaltyArticle" value="<?php  ($vnd_push_performance != NULL) ? print($vnd_push_performance['penaltyArticle']) : ""; ?>" <?php  ($vnd_push_performance != NULL) ?  print("readonly") : ""; ?> >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Deskripsi Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="penaltyDescription" id="penaltyDescription" value="<?php  ($vnd_push_performance != NULL) ? print($vnd_push_performance['penaltyDescription']) : ""; ?>" <?php  ($vnd_push_performance != NULL) ?  print("readonly") : ""; ?> >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Tanggal Akhir Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="date" class="form-control" name="penaltyEnddate" id="penaltyEnddate" value="<?php  ($vnd_push_performance != NULL) ? print($vnd_push_performance['penaltyDescription']) : ""; ?>" <?php  ($vnd_push_performance != NULL) ?  print("readonly") : ""; ?> >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Tanggal Mulai Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="date" class="form-control" name="penaltyStartdate" id="penaltyStartdate" value="<?php  ($vnd_push_performance != NULL) ? print($vnd_push_performance['penaltyDescription']) : ""; ?>" <?php  ($vnd_push_performance != NULL) ?  print("readonly") : ""; ?> >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Status Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                                <select id="penaltyStatusId" class="form-control" name="penaltyStatusId"  <?php  ($vnd_push_performance != NULL) ?  print("readonly") : ""; ?>>
                                                    <option <?php  ($vnd_push_performance != NULL) ?  print("selected") : ""; ?> value="1">Kuning</option>
                                                    <option <?php  ($vnd_push_performance != NULL) ?  print("selected") : ""; ?> value="2">Merah</option>
                                                    <option <?php  ($vnd_push_performance != NULL) ?  print("selected") : ""; ?> value="3">Hitam</option>
                                                </select>
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">NPWP</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="vendorNpwp" id="vendorNpwp" value="<?php  ($vnd_push_performance != NULL) ? print($vnd_push_performance['vendorNpwp']) : print($header['npwp_no']); ?>" readonly >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <?php  if($vnd_push_performance == NULL) : ?>
                                <p><button type="button" onclick="post_vnd_performance()" class="btn btn-primary" data-bs-toggle="button" aria-pressed="false" autocomplete="off">submit</button>  </p>                            
                                <?php endif; ?>
                            </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

<!-- modal-katalog -->
<div class="modal fade text-left" id="katalogForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-bold-700">Data Katalog</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">                       
                    <div class="row">
                        <div class="col-md-4">
                            <label class="text-bold-700">Level 1 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="form-control" name="level1" id="level1">  
                                <option value="" disabled selected>Pilih</option>        
                                <?php foreach($level1 as $v1) { ?>
                                    <option value="<?php echo $v1['resources_code_id'];?>"><?php echo $v1['name'];?></option>                                   
                                <?php } ?>
                            </select>

                            <label class="text-bold-700 mt-3">Level 2 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="form-control" name="level2" id="level2" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 3 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="form-control" name="level3" id="level3" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-4">                            
                            <label class="text-bold-700">Level 4</label>
                            <select class="form-control" name="level4" id="level4" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 5</label>
                            <select class="form-control" name="level5" id="level5" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 6</label>
                            <select class="form-control" name="level6" id="level6" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-4">                            
                            <label class="text-bold-700">Level 7</label>
                            <select class="form-control" name="level7" id="level7" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 8</label>
                            <select class="form-control" name="level8" id="level8" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Satuan Dasar</label>
                            <select class="form-control" name="uom_id" id="uom_id">   
                                <option value="">Pilih Satuan Dasar</option>                                                      
                                <?php foreach ($get_uoms as $value) { ?>
                                    <option value="<?php echo $value['name'];?>"><?php echo $value['name'];?></option>   
                                <?php } ?>  
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Term Of Delivery</label>                            
                            <select class="form-control" name="tod_id" id="tod_id">  
                                <option value="">Pilih Term Of Delivery</option>   
                                <?php foreach ($get_tod as $value) { ?>
                                    <option value="<?php echo $value['name'];?>"><?php echo $value['name'];?></option>   
                                <?php } ?>  
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Catatan</label>                            
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $header['vendor_id']; ?>" />
                                <textarea rows="6" class="form-control" name="note" id="note" placeholder="Product note"></textarea>
                                <div class="form-control-position">
                                    <i class="ft-file-text"></i>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Batal">
                    <input type="button" id="add_katalog" class="btn btn-info" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function post_vnd_performance() {
        if (confirm('Apakah anda yakin ingin submit data ke Pengadaan.com ?')) {
            
            $("#vndPerformanceForm").serialize()
            $('#loading_upload').modal("show");
            $.ajax({
                type: "POST",
                url: "<?= site_url() ?>/BumnKarya/post_vnd_performance",
                data: {penaltyArticle : $("#penaltyArticle").val(), penaltyDescription : $("#penaltyDescription").val(),penaltyEnddate : $("#penaltyEnddate").val(),penaltyStartdate : $("#penaltyStartdate").val(),penaltyStatusId : $("#penaltyStatusId").val(),vendorId : $("#vendorId").val(),vendorNpwp : $("#vendorNpwp").val()},
                dataType: "json",
                error: function (response) {
                    $('#loading_upload').modal("hide");
                },
                success: function (response) {
                    alert(response.message)
                    if(response.code == 200)
                    {
                        location.reload();
                    }
                    $('#loading_upload').modal("hide");
                }
            });
        }
    }
</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'katalog') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				}
			}
		}
	})
</script>

<script type="text/javascript">   
    $(document).ready(function(){ 
        $('#add_katalog').click(function () { 
            var level1 = $('#level1').val();   
            var level2 = $('#level2').val();   
            var level3 = $('#level3').val();   
            var level4 = $('#level4').val();   
            var level5 = $('#level5').val();   
            var level6 = $('#level6').val();   
            var level7 = $('#level7').val();   
            var level8 = $('#level8').val();    
            var uom_id = $('#uom_id').val();   
            var tod_id = $('#tod_id').val();   
            var note = $('#note').val();   
            var vendor_id = $('#vendor_id').val();   

            $.ajax({
                type : 'POST',
                url	: "<?php echo site_url('vendor/submit_katalog'); ?>",
                data : {
                    level1:level1,
                    level2:level2,
                    level3:level3,
                    level4:level4,
                    level5:level5,
                    level6:level6,
                    level7:level7,
                    level8:level8,
                    uom_id:uom_id,
                    tod_id:tod_id,
                    note:note,
                    vendor_id:vendor_id
                },
                cache : false,
                success	: function(status){ 
                    if (status == 1) {
                        toastr.info('Data Berhasil Disimpan.', '<i class="ft ft-check-square"></i> Success!');
                        setInterval('location.reload()', 2000);
                    } else if (status == 2) {
                        toastr.error('Data Belum Terisi Lengkap.', '<i class="ft ft-alert-triangle"></i> Error!');
                    } else if (status == 3) {
                        toastr.error('Data Gagal Disimpan.', '<i class="ft ft-alert-triangle"></i> Error!');
                    } 
                }
            });
        });
    });            
</script> 

<script type="text/javascript">    
    $(document).ready( function(){
        $("#level1").on("change", function () {
            let level1 = $("#level1").val();
            $.ajax({
                url: "<?php echo base_url('vendor/get_level2');?>",
                data: { kategori: level1 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level2 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level2 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level2").html(level2).removeAttr("disabled");
                },
            });
        });

        $("#level2").on("change", function () {
            let level2 = $("#level2").val();
            $.ajax({
                url: "<?php echo site_url('vendor/get_level3');?>",
                data: { level2: level2 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level3 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level3 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level3").html(level3).removeAttr("disabled");
                },
            });
        });

        $("#level3").on("change", function () {
            let level3 = $("#level3").val();
            $.ajax({
                url: "<?php echo site_url('vendor/get_level4');?>",
                data: { level3: level3 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level4 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level4 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level4").html(level4).removeAttr("disabled");
                },
            });
        });

        $("#level4").on("change", function () {
            let level4 = $("#level4").val();
            $.ajax({
                url: "<?php echo site_url('vendor/get_level5');?>",
                data: { level4: level4 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level5 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level5 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level5").html(level5).removeAttr("disabled");
                },
            });
        });

        $("#level5").on("change", function () {
            let level5 = $("#level5").val();
            $.ajax({
                url: "<?php echo site_url('vendor/get_level6');?>",
                data: { level5: level5 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level6 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level6 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level6").html(level6).removeAttr("disabled");
                },
            });
        });

        $("#level6").on("change", function () {
            let level6 = $("#level6").val();
            $.ajax({
                url: "<?php echo site_url('vendor/get_level7');?>",
                data: { level6: level6 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level7 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level7 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level7").html(level7).removeAttr("disabled");
                },
            });
        });

        $("#level7").on("change", function () {
            let level7 = $("#level7").val();
            $.ajax({
                url: "<?php echo site_url('vendor/get_level8');?>",
                data: { level7: level7 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level7 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level8 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level8").html(level8).removeAttr("disabled");
                },
            });
        });
    });
</script>