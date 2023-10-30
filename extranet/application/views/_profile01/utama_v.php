<?php $this->load->view("_profile01/_tab.php") ?>

<div class="match-height">
	<form class="form-bordered" method="POST" action="<?php echo site_url('registrasi_vendor/submit_data_utama'); ?>" enctype="multipart/form-data">
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
								<label class="col-md-3 label-control">Email</label>
								<div class="col-md-9">
									<div class="position-relative has-icon-left">
										<input type="text" class="form-control" name="email_address" value="<?php echo $detail_vendor['email_address']; ?>" readonly>
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
										<input type="text" class="form-control" name="vendor_name" value="<?php echo $detail_vendor['vendor_name']; ?>" required>
										<div class="form-control-position">
											<i class="ft-briefcase"></i>
										</div>
									</div>
								</div>
							</div>

							<?php if(isset($detail_vendor['vendor_code'])) { ?>
								<div class="form-group row">
									<label class="col-md-3 label-control">No DPPM</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $detail_vendor['vendor_code']; ?>" readonly>
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
										<input type="text" class="form-control" name="npwp_no" value="<?php echo $detail_vendor['npwp_no']; ?>" readonly>
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
										<select class="select2 form-control" name="prefix" required>
											<option value="" selected disabled>Pilih</option>
											<option value="PT" <?php echo $detail_vendor['prefix'] == 'PT' ? 'selected' : ''; ?>>PT</option>
											<option value="CV" <?php echo $detail_vendor['prefix'] == 'CV' ? 'selected' : ''; ?>>CV</option>
											<option value="Koperasi" <?php echo $detail_vendor['prefix'] == 'Koperasi' ? 'selected' : ''; ?>>Koperasi</option>
											<option value="BUT" <?php echo $detail_vendor['prefix'] == 'BUT' ? 'selected' : ''; ?>>BUT (Badan Usaha Terbatas)</option>
											<option value="Sekolah / Universitas" <?php echo $detail_vendor['prefix'] == 'Sekolah / Universitas' ? 'selected' : ''; ?>>Sekolah / Universitas</option>
											<option value="Yayasan" <?php echo $detail_vendor['prefix'] == 'Yayasan' ? 'selected' : ''; ?>>Yayasan</option>
											<option value="Firma Hukum" <?php echo $detail_vendor['prefix'] == 'Firma Hukum' ? 'selected' : ''; ?>>Firma Hukum</option>
											<option value="KJPP" <?php echo $detail_vendor['prefix'] == 'KJPP' ? 'selected' : ''; ?>>KJPP (Kantor Jasa Penilai Publik)</option>
											<option value="KAP" <?php echo $detail_vendor['prefix'] == 'KAP' ? 'selected' : ''; ?>>KAP (Kantor Akutan Publik)</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 label-control">Tipe Vendor</label>
								<div class="col-md-9">
									<div class="position-relative has-icon-left">
										<?php
										$typev = "-";
										if ($detail_vendor['vendor_type'] == 1) {
											$typev = "Non-Perorangan";
										} elseif ($detail_vendor['vendor_type'] == 2) {
											$typev = "Perorangan";
										} elseif ($detail_vendor['vendor_type'] == 3) {
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['categoryIdBumnkarya']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['companyProfile']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['contactMobileNo']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['facebook']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['instagram']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['twitter']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['linkedin']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['linkGoogleMaps']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['qualification']; ?>" readonly>
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
										<input type="text" class="form-control" value="<?php echo $detail_vendor['industryKey']; ?>" readonly>
										<div class="form-control-position">
											<i class="ft-tag"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group border-bottom row">
								<label class="col-md-3 label-control">Instance Name</label>
								<div class="col-md-9">
									<div class="position-relative has-icon-left">
										<input type="text" class="form-control" value="<?php echo $detail_vendor['instanceName']; ?>" readonly>
										<div class="form-control-position">
											<i class="ft-tag"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group border-bottom row last mb-3">
								<label class="col-md-3 label-control">Website</label>
								<div class="col-md-9">
									<div class="position-relative has-icon-left">
										<input type="text" class="form-control" value="<?php echo $detail_vendor['website']; ?>" readonly>
										<div class="form-control-position">
											<i class="ft-link"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- alamat-perusahaan -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header border-bottom pb-2">
						<div class="btn-group-sm float-left">
							<span class="card-title text-bold-600 mr-2">Alamat Perusahaan <span class="text-danger">(*)</span></span> 
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div class="table-responsive">
								<table id="alamat_table" class="table table-striped table-sm table-bordered" style="width:100%">
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
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header border-bottom pb-2">
						<div class="btn-group-sm float-left">
							<span class="card-title text-bold-600 mr-2">Kontak Perusahaan <span class="text-danger">(*)</span></span> 
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div class="table-responsive">
								<table id="kontak_table" class="table table-striped table-sm table-bordered" style="width:100%">
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
							<span class="card-title text-bold-600 mr-2">List Account <span class="text-danger">(*)</span></span> 
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

		<div class="col-lg-12 text-center my-3">			
			<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
				<input type="submit" onclick="return confirm('Apakah Anda yakin dengan data ini?')" class="btn btn-info" value="Simpan">
			<?php } ?>
			<a href="<?php echo site_url('registrasi_vendor/legal'); ?>" onclick="return confirm('Apakah Anda yakin dengan data di atas?')" class="btn btn-info btn-md">Selanjutnya</a>
		</div>
	</form>
</div>

<script type="text/javascript">	

	function isShowAddAlamat() {
		var div_add = document.getElementById("showAddAlamat");
		var div_btn = document.getElementById("showButtonAlamat");
		
		if (div_add.style.display !== "none") {
			div_add.style.display = "none";
		} else {
			div_add.style.display = "block";
		}

		if (div_btn.style.display !== "none") {
			div_btn.style.display = "none";
		} else {
			div_btn.style.display = "block";
		}
	}

	function isShowAddKontak() {
		var div_add = document.getElementById("showAddKontak");
		var div_btn = document.getElementById("showButtonKontak");
		
		if (div_add.style.display !== "none") {
			div_add.style.display = "none";
		} else {
			div_add.style.display = "block";
		}

		if (div_btn.style.display !== "none") {
			div_btn.style.display = "none";
		} else {
			div_btn.style.display = "block";
		}
	}
	
	$(document).ready(function() {

		$(".action_alamat").click(function() {

			var current_alamat = $("#current_alamat").val();
			var no = current_alamat;
			var type = $("#type").val();
			var prop = $("#prop").val();
			var city = $("#city").val();
			var district = $("#district").val();
			var village = $("#village").val();
			var alamat = $("#alamat").val();
			var latitude = $("#latitude").val();
			var longitude = $("#longitude").val();
			var kode_pos = $("#kode_pos").val();
			var no_telp = $("#no_telp").val();
			var fax = $("#fax").val();

			if (current_alamat == "") {
				if (getMaxDataNo(".edit_alamat") == null) {
					no = 1;
				} else {
					no = getMaxDataNo(".edit_alamat") + 1;
				}
			} else {}

			if (type == "") {

				alert("Type tidak boleh kosong.");

			} else if (prop == "") {

				alert("Provinsi tidak boleh kosong.");

			} else if (alamat == "") {

				alert("Alamat tidak boleh kosong.");

			} else {

				var html = "<tr>";
				html += "<td class='text-center'>" + no + "</td>";
				html += "<td><input type='hidden' class='type' data-no='" + no + "' name='type[" + no + "]' value='" + type + "'/>" + type + "</td>";
				html += "<td class='text-left'><input type='hidden' class='alamat' data-no='" + no + "' name='alamat[" + no + "]' value='" + alamat + "'/>" + alamat + "</td>";
				html += "<td class='text-left'><input type='hidden' class='prop' data-no='" + no + "' name='prop[" + no + "]' value='" + prop + "'/>" + prop + "</td>";
				html += "<td class='text-left'><input type='hidden' class='city' data-no='" + no + "' name='city[" + no + "]' value='" + city + "'/>" + city + "</td>";
				html += "<td class='text-left'><input type='hidden' class='district' data-no='" + no + "' name='district[" + no + "]' value='" + district + "'/>" + district + "</td>";
				html += "<td class='text-left'><input type='hidden' class='village' data-no='" + no + "' name='village[" + no + "]' value='" + village + "'/>" + village + "</td>";
				html += "<td class='text-left'><input type='hidden' class='latitude' data-no='" + no + "' name='latitude[" + no + "]' value='" + latitude + "'/>" + latitude + "</td>";
				html += "<td class='text-left'><input type='hidden' class='longitude' data-no='" + no + "' name='longitude[" + no + "]' value='" + longitude + "'/>" + longitude + "</td>";
				html += "<td class='text-left'><input type='hidden' class='kode_pos' data-no='" + no + "' name='kode_pos[" + no + "]' value='" + kode_pos + "'/>" + kode_pos + "</td>";
				html += "<td class='text-left'><input type='hidden' class='no_telp' data-no='" + no + "' name='no_telp[" + no + "]' value='" + no_telp + "'/>" + no_telp + "</td>";
				html += "<td class='text-left'><input type='hidden' class='fax' data-no='" + no + "' name='fax[" + no + "]' value='" + fax + "'/>" + fax + "</td>";
				html += "</tr>";

				$("#alamat_table").append(html);
				$("#type").val("");
				$("#prop").val("");
				$("#city").val("");
				$("#district").val("");
				$("#village").val("");
				$("#alamat").val("");
				$("#latitude").val("");
				$("#longitude").val("");
				$("#kode_pos").val("");
				$("#no_telp").val("");
				$("#fax").val("");
			}

		});

		$(".action_kontak").click(function() {

			var current_kontak = $("#current_kontak").val();
			var no_kontak = current_kontak;
			var nama_lengkap = $("#nama_lengkap").val();
			var jabatan = $("#jabatan").val();
			var email_address = $("#email_address").val();
			var no_telp_kontak = $("#no_telp_kontak").val();

			if (current_kontak == "") {
				if (getMaxDataNo(".edit_kontak") == null) {
					no_kontak = 1;
				} else {
					no_kontak = getMaxDataNo(".edit_kontak") + 1;
				}
			} else {}

			if (nama_lengkap == "") {

				alert("Nama lengkap tidak boleh kosong.");

			} else {

				var html = "<tr>";
				html += "<td class='text-center'>" + no_kontak + "</td>";
				html += "<td><input type='hidden' class='nama_lengkap' data-no='" + no_kontak + "' name='nama_lengkap[" + no_kontak + "]' value='" + nama_lengkap + "'/>" + nama_lengkap + "</td>";
				html += "<td><input type='hidden' class='jabatan' data-no='" + no_kontak + "' name='jabatan[" + no_kontak + "]' value='" + jabatan + "'/>" + jabatan + "</td>";
				html += "<td><input type='hidden' class='email_address' data-no='" + no_kontak + "' name='email_address[" + no_kontak + "]' value='" + email_address + "'/>" + email_address + "</td>";
				html += "<td><input type='hidden' class='no_telp_kontak' data-no='" + no_kontak + "' name='no_telp_kontak[" + no_kontak + "]' value='" + no_telp_kontak + "'/>" + no_telp_kontak + "</td>";
				html += "</tr>";

				$("#kontak_table").append(html);
				$("#nama_lengkap").val("");
				$("#jabatan").val("");
				$("#email_address").val("");
				$("#no_telp_kontak").val("");
			}

		});

		$(document.body).on("click", ".empty_alamat", function() {
			$("#type").val("");
			$("#prop").val("");
			$("#city").val("");
			$("#district").val("");
			$("#village").val("");
			$("#alamat").val("");
			$("#latitude").val("");
			$("#longitude").val("");
			$("#kode_pos").val("");
			$("#no_telp").val("");
			$("#fax").val("");
		});

		$(document.body).on("click", ".empty_kontak", function() {
			$("#nama_lengkap").val("");
			$("#jabatan").val("");
			$("#email_address").val("");
			$("#no_telp_kontak").val("");
		});

		$(document.body).on("click", ".edit_alamat", function() {
			var no = $(this).attr('data-no');
			var type = $(".type[data-no='" + no + "']").val();
			var prop = $(".prop[data-no='" + no + "']").val();
			var city = $(".city[data-no='" + no + "']").val();
			var district = $(".district[data-no='" + no + "']").val();
			var village = $(".village[data-no='" + no + "']").val();
			var alamat = $(".alamat[data-no='" + no + "']").val();
			var latitude = $(".latitude[data-no='" + no + "']").val();
			var longitude = $(".longitude[data-no='" + no + "']").val();
			var kode_pos = $(".kode_pos[data-no='" + no + "']").val();
			var no_telp = $(".no_telp[data-no='" + no + "']").val();
			var fax = $(".fax[data-no='" + no + "']").val();

			$("#current_alamat").val(no);
			$("#type").val(type);
			$("#prop").val(prop);
			$("#city").val(city);
			$("#district").val(district);
			$("#village").val(village);
			$("#alamat").val(alamat);
			$("#latitude").val(latitude);
			$("#longitude").val(longitude);
			$("#kode_pos").val(kode_pos);
			$("#no_telp").val(no_telp);
			$("#fax").val(fax);

			$(this).parent().parent().remove();

			return false;

		});

		$(document.body).on("click", ".edit_kontak", function() {
			var no_kontak = $(this).attr('data-no');
			var nama_lengkap = $(".nama_lengkap[data-no='" + no_kontak + "']").val();
			var jabatan = $(".jabatan[data-no='" + no_kontak + "']").val();
			var email_address = $(".email_address[data-no='" + no_kontak + "']").val();
			var no_telp_kontak = $(".no_telp_kontak[data-no='" + no_kontak + "']").val();
			
			$("#current_kontak").val(no_kontak);
			$("#nama_lengkap").val(nama_lengkap);
			$("#jabatan").val(jabatan);
			$("#email_address").val(email_address);
			$("#no_telp_kontak").val(no_telp_kontak);

			$(this).parent().parent().remove();

			return false;

		});
		
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'utama') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '3') {
					toastr.error('Bukti upload kontrak wajib diisi.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '4') {
					toastr.error('PUSAT hanya boleh 1 alamat.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		$("#prop").on("change", function () {
			let prop = $("#prop").val();
			$.ajax({
				url: "<?php echo site_url('registrasi_vendor/get_regency');?>",
				data: { prop: prop },
				method: "post",
				dataType: "json",
				success: function (data) {
					city = '<option value="">Pilih</option>';                    
					$.each(data, function (i, item) {   
						city += '<option value="' + item.regency_name +'">' + item.regency_name + "</option>";
					});                    
					$("#city").html(city).removeAttr("disabled");
				},
			});
		});

		$("#city").on("change", function () {
			let prop = $("#prop").val();
			let city = $("#city").val();
			$.ajax({
				url: "<?php echo site_url('registrasi_vendor/get_district');?>",
				data: { prop: prop, city: city },
				method: "post",
				dataType: "json",
				success: function (data) {
					district = '<option value="">Pilih</option>';                    
					$.each(data, function (i, item) {   
						district += '<option value="' + item.district_name +'">' + item.district_name + "</option>";
					});                    
					$("#district").html(district).removeAttr("disabled");
				},
			});
		});

		$("#district").on("change", function () {
			let prop = $("#prop").val();
			let city = $("#city").val();
			let district = $("#district").val();
			$.ajax({
				url: "<?php echo site_url('registrasi_vendor/get_village');?>",
				data: { prop: prop, city: city, district: district },
				method: "post",
				dataType: "json",
				success: function (data) {
					village = '<option value="">Pilih</option>';                    
					$.each(data, function (i, item) {   
						village += '<option value="' + item.village_name +'">' + item.village_name + "</option>";
					});                    
					$("#village").html(village).removeAttr("disabled");
				},
			});
		});
	});

	$('#upload').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload')[0].files[0].name;
		$(this).next('label').text(file);
	});
</script>


