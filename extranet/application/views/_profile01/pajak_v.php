<?php $this->load->view("_profile01/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered" method="POST" action="<?php echo site_url('_api/vendor/data/edit_pajak'); ?>" enctype="multipart/form-data">
			<!-- laporan -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Laporan SPT Tahunan <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#sptForm"><i class="fa fa-plus"></i> Tambah</a>
							<?php } ?>
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
							<h5 class="card-title-w">PKP</h5>
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
												<option value="Ada" <?php echo $detail_vendor['npwp_pkp'] == 'Ada' ? 'selected' : ''; ?>>Ada</option>
												<option value="Tidak Ada" <?php echo $detail_vendor['npwp_pkp'] == 'Tidak Ada' ? 'selected' : ''; ?>>Tidak Ada</option>
											</select>
										</div>
									</div>
								</div>
								<div class="pkp">
									<div class="form-group row">
										<label class="col-md-3 label-control">Nomor PKP</label>
										<div class="col-md-9">
											<input type="text" class="form-control" maxlength="50" name="npwp_pkp_no" value="<?php echo $detail_vendor['npwp_pkp_no']; ?>" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 label-control">Tanggal Terbit PKP</label>
										<div class="col-md-9">
											<input type="date" class="form-control" name="sppkp_date" value="<?php echo date('Y-m-d', strtotime($detail_vendor['sppkp_date'])) ?>" />
										</div>
									</div>
									<div class="form-group last row">
										<label class="col-md-3 label-control">Lampiran</label>
										<div class="col-md-9">
											<input type="file" id="upload-pkp" name="pkp_lampiran" style="display:none;">
											<label class="btn btn-info btn-sm px-2 mr-3" for="upload-pkp"><i class="ft-upload-cloud"></i> Upload file</label>
											<label class="custom-file-upload"></label>
											<?php echo form_hidden('file_lama_pkp', $detail_vendor['pkp_lampiran']); ?>
											<?php if ($detail_vendor['pkp_lampiran'] != NULL) { ?>
												<span>
													<a href="<?php echo site_url('attachment/vendor/' . $this->session->userdata('npwp_no_s') . '/') . $detail_vendor['pkp_lampiran'] ?>" target="_blank"><i class="ft-download-cloud"></i> Download</a>
													<a href="<?php echo site_url('_api/vendor/data/hapus_lampiran_pkp?file=' . $detail_vendor['pkp_lampiran']) ?>" onclick="return confirm('Apakah Anda yakin hapus file ini?')"><i class="ft-x-circle text-danger"></i></a>
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
							<h5 class="card-title-w">NPWP <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="form-group row">
									<label class="col-md-3 label-control">Nomor NPWP</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="npwp_no" value="<?php echo $detail_vendor['npwp_no']; ?>" readonly>
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
											<input type="text" class="form-control" id="npwp_nama" name="npwp_nama" value="<?php echo $detail_vendor['npwp_nama']; ?>">
											<input type="text" class="form-control" id="vendor_name" name="vendor_name" value="<?php echo $detail_vendor['vendor_name']; ?>" style="display:none">
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
											<textarea rows="4" class="form-control" id="npwp_address" name="npwp_address"><?php echo $detail_vendor['npwp_address']; ?></textarea>
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
												<option value="DKI Jakarta" <?php echo $detail_vendor['npwp_prop'] == 'DKI Jakarta' ? 'selected' : ''; ?>>DKI Jakarta</option>
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
												<option value="Jakarta Timur" <?php echo $detail_vendor['npwp_city'] == 'Jakarta Timur' ? 'selected' : ''; ?>>Jakarta Timur</option>
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
												<option value="Duren Sawit" <?php echo $detail_vendor['npwp_district'] == 'Duren Sawit' ? 'selected' : ''; ?>>Duren Sawit</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control">Kode Pos</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" maxlength="5" pattern=".{5,}" class="form-control" title="Masukan kode pos dengan benar" onkeypress="return onlyNumber(event)" name="npwp_postcode" value="<?php echo $detail_vendor['npwp_postcode']; ?>">
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
											<?php echo form_hidden('file_lama', $detail_vendor['npwp_lampiran']); ?>
											<?php if ($detail_vendor['npwp_lampiran'] != NULL) { ?>
												<span>
													<a href="<?php echo site_url('attachment/vendor/' . $this->session->userdata('npwp_no_s') . '/') . $detail_vendor['npwp_lampiran'] ?>" target="_blank"><i class="ft-download-cloud"></i> Download</a>
													<a href="<?php echo site_url('_api/vendor/data/hapus_lampiran_npwp?file=' . $detail_vendor['npwp_lampiran']) ?>" onclick="return confirm('Apakah Anda yakin hapus file ini?')"><i class="ft-x-circle text-danger"></i></a>
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

			<div class="col-lg-12 text-center my-3">
				<a href="<?php echo site_url('registrasi_vendor/legal'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
					<input type="submit" onclick="return confirm('Apakah Anda yakin dengan data ini?')" class="btn btn-info" value="Simpan">
				<?php } ?>
				<a href="<?php echo site_url('registrasi_vendor/keuangan'); ?>" class="btn btn-info btn-md">Selanjutnya</a>
			</div>
		</form>
	</div>
	<!-- Table ends -->
</section>

<script>
	(function(window, document, $) {
		'use strict';
		// Basic Select2 select
		$(".select2").select2({
			dropdownAutoWidth: true,
			width: '100%'
		});

	})(window, document, jQuery);

	$(document).ready(function() {
		$('.zero-configuration').DataTable({
			ordering: false
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'pajak') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '3') {
					toastr.error('Lampiran NPWP wajib diisi.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}
	})

	$('#pkpStatus').change(function() {
		if (this.value == 'Tidak Ada') {
			$('input[name="npwp_pkp_no"]').val('');
			$('input[name="sppkp_date"]').val('');
		}
	});

	$('#upload-bukti').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-bukti')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-bukti-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-bukti-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-spt').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-spt')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-spt-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-spt-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-pkp').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-pkp')[0].files[0].name;
		$(this).next('label').text(file);
	});

	function myNameFunction() {
		var checkBox = document.getElementById("checkbox1");
		var text1 = document.getElementById("vendor_name");
		var text2 = document.getElementById("npwp_nama");
		if (checkBox.checked == true) {
			text2.value = "<?php echo $detail_vendor['vendor_name']; ?>";
		} else {
			text2.value = "<?php echo $detail_vendor['npwp_nama']; ?>";
		}
	}

	function myAddressFunction() {
		var checkBox = document.getElementById("checkbox2");
		var text1 = document.getElementById("alamat");
		var text2 = document.getElementById("npwp_address");
		if (checkBox.checked == true) {
			text2.value = "<?php echo $value['alamat']; ?>";
		} else {
			text2.value = "<?php echo $detail_vendor['npwp_address']; ?>";
		}
	}
</script>

<script>
	$(document).ready(function() {
		$('#editsptForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('input[name="tahun"]').attr("value", div.data('tahun'));
			modal.find('input[name="tgl_lapor"]').attr("value", div.data('tgl_lapor'));
		});
	});
</script>