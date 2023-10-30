<?php $this->load->view("_profile03/_tab.php") ?>

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
							<div class="form-group row last mb-3">
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
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<span><a onclick="isShowAddAlamat()" class="btn btn-info btn-sm"><i class="ft-plus"></i> Tambah</a></span>
							<?php } ?>
						</div>
						<div class="btn-group-sm float-right position-relative" id="showButtonAlamat" style="display: none">
							<a class="btn btn-info action_alamat btn-plus">Simpan</a>
							<a class="btn btn-sm empty_alamat btn-trash" title="Hapus"><i class="ft-trash"></i></a>
							<input type="hidden" id="current_alamat" value="" />
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div id="showAddAlamat" style="display: none">
								<div class="row mb-2">
									<!-- left-side -->
									<div class="col-sm">
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Tipe Alamat <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="type" name="type">
													<option value="" selected disabled>Pilih</option>
													<option value="Pusat">Pusat</option>
													<option value="Cabang">Cabang</option>
													<option value="Workshop">Workshop</option>
													<option value="Pabrik">Pabrik</option>
												</select>
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Provinsi <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="prop" name="prop">
													<option value="" selected disabled>Pilih</option>
													<?php foreach ($locations as $value) { ?>
														<option value="<?php echo $value['province_name']; ?>" ><?php echo $value['province_name']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Kota / Kabupaten <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="city" name="city" disabled>
													<option value="">Pilih</option>
												</select>
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Kecamatan <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="district" name="district" disabled>
													<option value="">Pilih</option>
												</select>
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Kelurahan <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="village" name="village" disabled>
													<option value="">Pilih</option>
												</select>
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Alamat <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<textarea rows="4" class="form-control form-control-sm" id="alamat" name="alamat" placeholder="Alamat Perusahaan"></textarea>
											</div>
										</div>
									</div>

									<!-- right-side -->
									<div class="col-sm">
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Latitude</label>
											<div class="col-sm-8">
												<input type="text" class="form-control form-control-sm" id="latitude" name="latitude" placeholder="-6.200000">
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Longitude</label>
											<div class="col-sm-8">
												<input type="text" class="form-control form-control-sm" id="longitude" name="longitude" placeholder="106.816666">
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Kode Pos</label>
											<div class="col-sm-8">
												<input type="text" maxlength="5" pattern=".{5,}" title="Masukan Kode Pos dengan benar" onkeypress="return onlyNumber(event)" class="form-control" id="kode_pos" name="kode_pos" placeholder="10000">
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">No. Telepon/HP <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<input type="text" maxlength="14" pattern=".{8,}" title="Masukan Nomor Telepon dengan benar" class="form-control form-control-sm" id="no_telp" name="no_telp" onkeypress="return onlyNumber(event)" placeholder="08123456789">
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Fax <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<input type="text" maxlength="13" pattern=".{8,}" title="Masukan Nomor Fax dengan benar" class="form-control form-control-sm" id="fax" name="fax" onkeypress="return onlyNumber(event)" placeholder="021-23765">
											</div>
										</div>
									</div>
								</div>
							</div>

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
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<span><a onclick="isShowAddKontak()" class="btn btn-info btn-sm"><i class="ft-plus"></i> Tambah</a></span>
							<?php } ?>
						</div>
						<div class="btn-group-sm float-right position-relative" id="showButtonKontak" style="display: none">
							<a class="btn btn-info action_kontak btn-plus">Simpan</a>
							<a class="btn btn-sm empty_kontak btn-trash" title="Hapus"><i class="ft-trash"></i></a>
							<input type="hidden" id="current_kontak" value="" />
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div id="showAddKontak" style="display: none">
								<div class="row mb-2">
									<div class="col-sm">
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Nama Lengkap <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<input type="text" class="form-control form-control-sm" id="nama_lengkap" name="nama_lengkap" placeholder="Nama lengkap">
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Jabatan <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<input type="text" class="form-control form-control-sm" id="jabatan" name="jabatan" placeholder="Jabatan">
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Email <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<input type="email" class="form-control form-control-sm" id="email_address" name="email_address" placeholder="Alamat Email">
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">No. Telepon/HP <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<input type="text" maxlength="14" pattern=".{8,}" title="Masukan Nomor Telepon dengan benar" class="form-control" id="no_telp_kontak" name="no_telp_kontak" onkeypress="return onlyNumber(event)" placeholder="08123456789">
											</div>
										</div>
									</div>
									<div class="col-sm">
									</div>
								</div>
							</div>

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


