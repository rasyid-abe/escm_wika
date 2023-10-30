<?php $this->load->view("_profile03/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered">
			<!-- akta-perusahaan -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Akta Perusahaan <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#aktaForm"><i class="fa fa-plus"></i> Tambah</a>
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
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">SK KEMKUMHAM</h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#skForm"><i class="fa fa-plus"></i> Tambah</a>
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

			<!-- ijin -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Ijin <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#izinForm"><i class="fa fa-plus"></i> Tambah</a>
							<?php } ?>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="table-responsive">
									<table class="table table-striped table-sm table-bordered long-field" style="width:150%">
										<thead>
											<tr>
												<th>No</th>
												<th>Nomor Ijin</th>
												<th>Tipe Ijin</th>
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
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Sertifikat</h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#sertifikatForm"><i class="fa fa-plus"></i> Tambah</a>
							<?php } ?>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="table-responsive">
									<table class="table table-striped table-sm table-bordered long-field" style="width:150%">
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

			<div class="col-lg-12 text-center my-3">
				<a href="<?php echo site_url('registrasi_vendor/utama'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<a href="<?php echo site_url('registrasi_vendor/pajak'); ?>" onclick="return confirm('Apakah Anda yakin dengan data di atas?')" class="btn btn-info btn-md">Selanjutnya</a>
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

	$(document).ready(function() {
		$('.long-field').DataTable({
			ordering: false,
			scrollX: true
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'legal') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '3') {
					toastr.error('Akta pendirian sudah terdaftar.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}
	})

	$('#upload-akta-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-akta-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-sk').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-sk')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-sk-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-sk-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-ijin').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-ijin')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-ijin-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-ijin-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-srt').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-srt')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-srt-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-srt-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});
</script>

<script>
	$(document).ready(function() {
		$('#editaktaForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('select[name="type_akta"]').val(div.data('type_akta')).change();
			modal.find('input[name="nomor_akta"]').attr("value", div.data('nomor_akta'));
			modal.find('input[name="tgl_buat"]').attr("value", div.data('tgl_buat'));
			modal.find('input[name="nama_notaris"]').attr("value", div.data('nama_notaris'));
			modal.find('textarea[name="alamat_notaris"]').val(div.data('alamat_notaris'));
		});
	});

	$(document).ready(function() {
		$('#editskForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('input[name="nomor_sk"]').attr("value", div.data('nomor_sk'));
			modal.find('input[name="tgl_buat"]').attr("value", div.data('tgl_buat'));
		});
	});

	$(document).ready(function() {
		$('#editijinForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('select[name="type_izin"]').val(div.data('type_izin')).change();
			modal.find('input[name="penerbit"]').attr("value", div.data('penerbit'));
			modal.find('input[name="kategori"]').attr("value", div.data('kategori'));
			modal.find('input[name="tgl_buat"]').attr("value", div.data('tgl_buat'));
			modal.find('input[name="tgl_kadaluarsa"]').attr("value", div.data('tgl_kadaluarsa'));
		});
	});

	$(document).ready(function() {
		$('#editsertifikatForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('select[name="type_sertifikat"]').val(div.data('type_sertifikat')).change();
			modal.find('input[name="nama_sertifikat"]').attr("value", div.data('nama_sertifikat'));
			modal.find('input[name="penerbit"]').attr("value", div.data('penerbit'));
			modal.find('input[name="nomor_sertifikat"]').attr("value", div.data('nomor_sertifikat'));
			modal.find('input[name="tgl_buat"]').attr("value", div.data('tgl_buat'));
			modal.find('input[name="tgl_kadaluarsa"]').attr("value", div.data('tgl_kadaluarsa'));
		});
	});
</script>