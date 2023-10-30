<?php $this->load->view("_profile01/_tab.php") ?>

<div class="match-height">
	<form class="form-bordered" method="POST" action="<?php echo site_url('registrasi_vendor/submit_data_utama'); ?>" enctype="multipart/form-data">

		<!-- profile -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header border-bottom pb-2">
						<div class="btn-group-sm float-left">
							<span class="card-title text-bold-600 mr-2">Company Profile <span class="text-danger">(*)</span></span> 
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14) { ?>
								<span><a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_profile"><i class="ft-plus"></i> Tambah</a></span>
							<?php } ?>
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div class="table-responsive">
								<table id="company_table" class="table table-striped table-sm table-bordered long-field" style="width: 100%">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th>Tipe File</th>
											<th>Nama File</th>
											<th class="text-center">Tanggal Upload</th>
											<th class="text-center">Hapus</th>
										</tr>
									</thead>
									<tbody>
										<?php $no_company = 1;
											if (isset($company) && !empty($company)) {
											foreach ($company as $key => $value) {
												$myid = $key + 1; ?>
											<tr>
												<td class="text-center"><?php echo $no_company++; ?></td>
												<td>
													<?php echo $value['tipe_file'] ?>
												</td>
												<td>
													<a href="<?php echo base_url('attachment/vendor/' . $value['vendor_id'] . '/' . $value['lampiran'])?>" target="_blank"><?php echo $value['lampiran']; ?></a>
												</td>
												<td class="text-center"><?php echo date("d-m-Y H:i:s", strtotime($value['created_at'])); ?></td>
												<td class="text-center">
													<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14) { ?>
														<a href="<?php echo site_url('registrasi_vendor/delete_profile_lampiran/' . $value['id']. '/' . $value['lampiran']) ?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')" class="btn btn-danger btn-sm">
															<i class="ft-trash"></i>
														</a>
													<?php } else { echo '--' ;} ?>
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

		<!-- kategorisasi -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title text-bold-600">Kategorisasi <span class="text-danger">(*)</span></h5>
					</div>
					<div class="card-content">
						<div class="card-body">
							<!-- content -->
							<div class="form-group row">
								<label class="col-md-3 label-control">Kualifikasi</label>
								<div class="col-md-9">
									<div class="position-relative">
										<select class="select2 form-control" name="fin_class" required>
											<option value="" selected disabled>Pilih</option>
											<option value="I" <?php echo $detail_vendor['fin_class'] == 'I' ? 'selected' : ''; ?>>Mikro</option>
											<option value="K" <?php echo $detail_vendor['fin_class'] == 'K' ? 'selected' : ''; ?>>Kecil</option>
											<option value="M" <?php echo $detail_vendor['fin_class'] == 'M' ? 'selected' : ''; ?>>Menengah</option>
											<option value="B" <?php echo $detail_vendor['fin_class'] == 'B' ? 'selected' : ''; ?>>Besar</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 label-control">Tipe Penyedia</label>
								<div class="col-md-9">
									<div class="position-relative">
										<select class="select2 form-control" name="cot_kelompok" required>
											<option value="" selected disabled>Pilih</option>
											<?php foreach ($adm_cot as $value) { ?>
												<option value="<?php echo $value['ack_id']; ?>" <?php echo $detail_vendor['cot_kelompok'] == $value['ack_id'] ? 'selected' : ''; ?>><?php echo $value['ack_name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 label-control">Pengalaman Tertinggi (10 thn terakhir)</label>
								<div class="col-md-9">
									<div class="position-relative has-icon-left">
										<input type="text" maxlength="17" class="form-control currency" onkeypress="return onlyNumber(event)" name="nilai_pengalaman" value="<?php echo number_format($detail_vendor['nilai_pengalaman'], 0, ',', '.'); ?>" required>
										<div class="form-control-position">
											<i class="ft-bar-chart-2"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 label-control">Upload Bukti Kontrak</label>
								<div class="col-md-9">
									<div class="position-relative">
										<input type="file" id="upload" name="upload_bukti_kontrak" style="display:none;">
										<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14) { ?>
											<label class="btn btn-info btn-sm px-2 mr-2" for="upload"><i class="ft-upload-cloud"></i> Upload file</label>
											<label class="custom-file-upload"></label>
										<?php } ?>
										<?php echo form_hidden('file_lama', $detail_vendor['upload_bukti_kontrak']); ?>
										<?php if ($detail_vendor['upload_bukti_kontrak'] != NULL) { ?>
											<span>
												<a class="btn bg-light-success btn-sm" href="<?php echo base_url('attachment/vendor/' . $this->session->userdata('userid') . '/') . $detail_vendor['upload_bukti_kontrak'] ?>" target="_blank"><i class="ft-download-cloud"></i> Download file</a>
											</span>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 label-control">Kemampuan Keuangan Untuk Bekerja</label>
								<div class="col-md-9">
									<div class="position-relative has-icon-left">
										<input type="text" maxlength="17" class="form-control currency" name="kemampuan_keuangan" onkeypress="return onlyNumber(event)" value="<?php echo number_format($detail_vendor['kemampuan_keuangan'], 0, ',', '.'); ?>" required>
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
										<input type="text" maxlength="8" class="form-control currency" onkeypress="return onlyNumber(event)" name="kapasitas_produk" value="<?php echo number_format($detail_vendor['kapasitas_produk'], 0, ',', '.'); ?>" required>
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
										<input type="text" maxlength="20" class="form-control" name="satuan" value="<?php echo $detail_vendor['satuan']; ?>" required>
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
							<span class="card-title text-bold-600 mr-2">Klasifikasi Bidang Usaha <span class="text-danger">(*)</span></span> 
							<span><a onclick="isShowAddBidang()" class="btn btn-info btn-sm"><i class="ft-plus"></i> Tambah</a></span>
						</div>
						<div class="btn-group-sm float-right position-relative" id="showButtonBidang" style="display: none">
							<a class="btn btn-info action_bidang btn-plus">Simpan</a>
							<a class="btn btn-sm empty_bidang btn-trash" title="Hapus"><i class="ft-trash"></i></a>
							<input type="hidden" id="current_bidang" value="" />
						</div>
					</div>
					<div class="card-content">
						<div class="card-body">
							<div id="showAddBidang" style="display: none">
								<div class="row mb-2">
									<div class="col-sm">
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Tipe Bidang <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="tipe_bidang" name="tipe_bidang">
													<option value="">Pilih</option>
													<option value="Barang">Barang</option>
													<option value="Jasa">Jasa</option>
												</select>
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Nama Bidang <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="nama_bidang" name="nama_bidang">
													<option value="">Pilih</option>
													<option value="Sipil">Sipil</option>
													<option value="Mekanikal">Mekanikal</option>
													<option value="Elektrikal">Elektrikal</option>
													<option value="Gedung">Gedung</option>
													<option value="ATK">ATK</option>
													<option value="TI">TI</option>
													<option value="HSE">CQSMS</option>
													<option value="Furnitur">Furnitur</option>
													<option value="Makanan dan Minuman">Makanan dan Minuman</option>
													<option value="Logistik">Logistik</option>
													<option value="Jasa Kesehatan">Jasa Kesehatan</option>
													<option value="Jasa Keuangan">Jasa Keuangan</option>
													<option value="Konsultan Lainnya">Konsultan Lainnya</option>
													<option value="Jasa Lainnya">Jasa Lainnya</option>
												</select>
											</div>
										</div>
										<div class="row p-2">
											<label class="col-sm-4 control-label text-right">Nama Sub Bidang <span class="text-danger text-bold-700">*</span></label>
											<div class="col-sm-8">
												<select class="select2 form-control form-control-sm" id="nama_sub_bidang" name="nama_sub_bidang">
													<option value="">Pilih</option>
													<option value="Struktur, Pondasi">Struktur, Pondasi</option>
													<option value="Piping, Lifting">Piping, Lifting</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm">
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<table id="bidang_table" class="table table-striped table-sm table-bordered" style="width: 100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Type</th>
											<th>Nama Bidang</th>
											<th>Nama Sub Bidang</th>
											<th>Aksi</th>
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
												<td>
													<button data-no="<?php echo $myid ?>" class="btn btn-warning btn-sm edit_bidang" type="button">
														<i class="fa fa-edit"></i>
														<input type="hidden" name="bidang_id[<?php echo $myid ?>]" value="<?php echo $myid ?>" />
													</button>
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
					<div class="card-header">
						<h5 class="card-title text-bold-600">Modal <span class="text-danger">(*)</span></h5>
					</div>
					<div class="card-content">
						<div class="card-body">
							<!-- content -->
							<h6 class="text-bold-700">Modal Usaha</h6>
							<div class="form-group row">
								<label class="col-md-3 label-control">Mata Uang</label>
								<div class="col-md-9">
									<div class="position-relative">
										<select class="custom-select select2 form-control" name="mu_mata_uang">
											<option selected disabled>Pilih...</option>
											<option value="IDR" <?php echo $detail_vendor['mu_mata_uang'] == 'IDR' ? 'selected' : ''; ?>>IDR</option>
											<option value="USD" <?php echo $detail_vendor['mu_mata_uang'] == 'USD' ? 'selected' : ''; ?>>USD</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group last row">
								<label class="col-md-3 label-control">Nilai</label>
								<div class="col-md-9">
									<div class="position-relative">
										<input type="text" maxlength="17" class="form-control currency" name="mu_nilai" value="<?php echo number_format($detail_vendor['mu_nilai'], 0, ',', '.'); ?>" onkeypress="return onlyNumber(event)">										
									</div>
								</div>
							</div>

							<h6 class="text-bold-700">Modal Disetor</h6>
							<div class="form-group row">
								<label class="col-md-3 label-control">Mata Uang</label>
								<div class="col-md-9">
									<div class="position-relative">
										<select class="custom-select select2 form-control" name="md_mata_uang">
											<option value="" selected disabled>Pilih...</option>
											<option value="IDR" <?php echo $detail_vendor['md_mata_uang'] == 'IDR' ? 'selected' : ''; ?>>IDR</option>
											<option value="USD" <?php echo $detail_vendor['md_mata_uang'] == 'USD' ? 'selected' : ''; ?>>USD</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group last row">
								<label class="col-md-3 label-control">Nilai</label>
								<div class="col-md-9">
									<div class="position-relative">
										<input type="text" maxlength="17" class="form-control currency" name="md_nilai" value="<?php echo number_format($detail_vendor['md_nilai'], 0, ',', '.'); ?>" onkeypress="return onlyNumber(event)">
									</div>
								</div>
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
						<h5 class="card-title text-bold-600">Anak Perusahaan <span class="text-danger">(*)</span></h5>
					</div>
					<div class="card-content">
						<div class="card-body">
							<!-- content -->
							<div class="form-group row">
								<label class="col-md-3 label-control">Pilih Anak Perusahaan</label>
								<div class="col-md-9">
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-1" <?php echo $anak_1 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Bangunan Gedung Tbk">
										<label for="color-checkbox-1"><span>PT Wijaya Karya Bangunan Gedung Tbk</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-2" <?php echo $anak_2 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Rekayasa Konstruksi">
										<label for="color-checkbox-2"><span>PT Wijaya Karya Rekayasa Konstruksi</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-3" <?php echo $anak_3 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Realty">
										<label for="color-checkbox-3"><span>PT Wijaya Karya Realty</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-4" <?php echo $anak_4 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Serang Panimbang">
										<label for="color-checkbox-4"><span>PT Wijaya Karya Serang Panimbang</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-5" <?php echo $anak_5 > 0 ? "checked" : "" ?> value="PT WIKA Tirta Jaya Jatiluhur">
										<label for="color-checkbox-5"><span>PT WIKA Tirta Jaya Jatiluhur</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-6" <?php echo $anak_6 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Beton Tbk">
										<label for="color-checkbox-6"><span>PT Wijaya Karya Beton Tbk</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-7" <?php echo $anak_7 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Industri Konstruksi">
										<label for="color-checkbox-7"><span>PT Wijaya Karya Industri Konstruksi</span></label>
									</div>
									<div class="checkbox checkbox-info mb-2">
										<input type="checkbox" name="anak_perusahaan[]" id="color-checkbox-8" <?php echo $anak_8 > 0 ? "checked" : "" ?> value="PT Wijaya Karya Bitumen">
										<label for="color-checkbox-8"><span>PT Wijaya Karya Bitumen</span></label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 text-center my-3">
            <?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14) { ?>
				<input type="submit" onclick="return confirm('Apakah Anda yakin dengan data ini?')" class="btn btn-info" value="Simpan">
			<?php } ?>
			<a href="<?php echo site_url('registrasi_vendor/documents'); ?>" onclick="return confirm('Apakah Anda yakin dengan data di atas?')" class="btn btn-info btn-md">Selanjutnya</a>
		</div>
	</form>
</div>

<div class="modal fade text-left" id="modal_profile" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form-bordered" method="POST" action="<?php echo site_url('registrasi_vendor/submit_data_profile'); ?>" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Modal Profile</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row col-sm mb-2">
						<label class="col-sm-4 control-label text-right">Tipe File <span class="text-danger text-bold-700">*</span></label>
						<div class="col-sm-8">
							<select class="select2 form-control form-control-sm" name="tipe_file" required>
								<option value="">Pilih</option>
								<option value="Foto">Foto</option>
								<option value="Video">Video</option>
								<option value="Dokumen">Dokumen</option>
							</select>
						</div>						
					</div>
					<div class="row col-sm">
						<label class="col-sm-4 control-label text-right">File Lampiran <span class="text-danger text-bold-700">*</span></label>
						<div class="col-sm-8">
							<input type="file" class="form-control form-control-sm" name="lampiran_profile"  required>							
							<div class="col-sm-0 mt-2" style="font-size: 11px">
								<i>Max file 5 MB
							</div>
						</div>						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn bg-light-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-info" onclick="return confirm('Apakah Anda yakin simpan data ini?')">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">	

	function isShowAddBidang() {
		var div_add = document.getElementById("showAddBidang");
		var div_btn = document.getElementById("showButtonBidang");
		
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

		$(".action_bidang").click(function() {

			var current_bidang = $("#current_bidang").val();
			var no_bidang = current_bidang;
			var tipe_bidang = $("#tipe_bidang").val();
			var nama_bidang = $("#nama_bidang").val();
			var nama_sub_bidang = $("#nama_sub_bidang").val();

			if (current_bidang == "") {
				if (getMaxDataNo(".edit_bidang") == null) {
					no_bidang = 1;
				} else {
					no_bidang = getMaxDataNo(".edit_bidang") + 1;
				}
			} else {}

			if (tipe_bidang == "") {

				alert("Tipe tidak boleh kosong.");

			} else if (nama_bidang == "") {

				alert("Nama bidang tidak boleh kosong.");

			} else {

				var html = "<tr>";
				html += "<td class='text-center'>" + no_bidang + "</td>";
				html += "<td><input type='hidden' class='tipe_bidang' data-no='" + no_bidang + "' name='tipe_bidang[" + no_bidang + "]' value='" + tipe_bidang + "'/>" + tipe_bidang + "</td>";
				html += "<td><input type='hidden' class='nama_bidang' data-no='" + no_bidang + "' name='nama_bidang[" + no_bidang + "]' value='" + nama_bidang + "'/>" + nama_bidang + "</td>";
				html += "<td><input type='hidden' class='nama_sub_bidang' data-no='" + no_bidang + "' name='nama_sub_bidang[" + no_bidang + "]' value='" + nama_sub_bidang + "'/>" + nama_sub_bidang + "</td>";
				html += "<td><button type='button' class='btn btn-info btn-sm edit_bidang' data-no='" + no_bidang + "'><i class='fa fa-edit'></i></button></td>";
				html += "</tr>";

				$("#bidang_table").append(html);
				$("#tipe_bidang").val("");
				$("#nama_bidang").val("");
				$("#nama_sub_bidang").val("");
			}

		});

		$(document.body).on("click", ".empty_bidang", function() {
			$("#tipe_bidang").val("");
			$("#nama_bidang").val("");
			$("#nama_sub_bidang").val("");
		});

		$(document.body).on("click", ".edit_bidang", function() {
			var no_bidang = $(this).attr('data-no');
			var tipe_bidang = $(".tipe_bidang[data-no='" + no_bidang + "']").val();
			var nama_bidang = $(".nama_bidang[data-no='" + no_bidang + "']").val();
			var nama_sub_bidang = $(".nama_sub_bidang[data-no='" + no_bidang + "']").val();
			
			$("#current_bidang").val(no_bidang);
			$("#tipe_bidang").val(tipe_bidang);
			$("#nama_bidang").val(nama_bidang);
			$("#nama_sub_bidang").val(nama_sub_bidang);

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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'tambahan') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '3') {
					toastr.error('Bukti upload kontrak wajib diisi.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '4') {
					toastr.error('PUSAT hanya boleh 1 alamat.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '5') {
					toastr.error('Lampiran profil wajib diisi.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}
	});

	$('#upload').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload')[0].files[0].name;
		$(this).next('label').text(file);
	});
</script>


