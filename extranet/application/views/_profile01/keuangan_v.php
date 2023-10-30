<?php $this->load->view("_profile01/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered" method="POST" action="<?php echo site_url('_api/vendor/data/edit_keuangan'); ?>">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w">Modal <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="form-group row">
									<label class="col-md-3 label-control">Kemampuan Nyata</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $detail_vendor['kemampuanNyata']; ?>" readonly>
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
											<input type="text" class="form-control" value="<?php echo $detail_vendor['md_mata_uang']; ?>" readonly>
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
											<input type="text" class="form-control" value="<?php echo $detail_vendor['md_nilai']; ?>" readonly>
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
											<input type="text" class="form-control" value="<?php echo $detail_vendor['mu_mata_uang']; ?>" readonly>
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
											<input type="text" class="form-control" value="<?php echo $detail_vendor['mu_nilai']; ?>" readonly>
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
											<input type="text" class="form-control" value="<?php echo $detail_vendor['nilaiPekerjaanBerjalan']; ?>" readonly>
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
											<input type="text" class="form-control" value="<?php echo $detail_vendor['sisaKemampuanNyata']; ?>" readonly>
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
											<input type="text" class="form-control" value="<?php echo $detail_vendor['totalModalTahunTerakhir']; ?>" readonly>
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
			
			<!-- bank -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Bank <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#bankForm"><i class="fa fa-plus"></i> Tambah</a>
							<?php } ?>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="table-responsive">
									<table class="table table-striped table-sm table-bordered long-field" style="width: 200%">
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

			<!-- laporan -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Laporan Tahunan <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#laporanForm"><i class="fa fa-plus"></i> Tambah</a>
							<?php } ?>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="table-responsive">
									<table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
										<thead>
											<tr>
												<th>No</th>
												<th>Tahun</th>
												<th>Mata Uang</th>
												<th>Jumlah Aset/Aktiva</th>
												<th>Hutang</th>
												<th>Pendapatan</th>
												<th>Laba/Rugi Bersih</th>
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

			<!-- dnb -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w">DnB <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
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

			<div class="col-lg-12 text-center my-3">
				<a href="<?php echo site_url('registrasi_vendor/pajak'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
					<input type="submit" onclick="return confirm('Apakah Anda yakin dengan data ini?')" class="btn btn-info" value="Simpan">
				<?php } ?>
				<a href="<?php echo site_url('registrasi_vendor/saham'); ?>" class="btn btn-info btn-md">Selanjutnya</a>
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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'keuangan') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".custom-select[data-id=getkomponen]").on("change", function() {
			if ($(this).val() === "Rp" || $(this).val() === "$") {
				$("label[id=labelkomponen]").text($("option:selected", this).val());
				$("div[id=inlineFormInput]").show();
			} else {
				$("div[id=inlineFormInput]").hide();
			}
		});
		$(".custom-select[data-id=getkomponen]").trigger("change");

	});

	$(document).ready(function() {
		$(".custom-select[data-id=getkomponen2]").on("change", function() {
			if ($(this).val() === "Rp" || $(this).val() === "$") {
				$("label[id=labelkomponen2]").text($("option:selected", this).val());
				$("div[id=inlineFormInput2]").show();
			} else {
				$("div[id=inlineFormInput2]").hide();
			}
		});
		$(".custom-select[data-id=getkomponen2]").trigger("change");

	});
</script>

<script>
	$(document).ready(function() {
		$('#editbankForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('input[name="bank_name"]').attr("value", div.data('bank_name'));
			modal.find('input[name="bank_branch"]').attr("value", div.data('bank_branch'));
			modal.find('select[name="country"]').val(div.data('country')).change();
			modal.find('input[name="account_no"]').attr("value", div.data('account_no'));
			modal.find('input[name="bank_id"]').attr("value", div.data('bank_id'));
			modal.find('input[name="account_name"]').attr("value", div.data('account_name'));
			modal.find('select[name="currency"]').val(div.data('currency')).change();
		});

	});

	$('#upload-koran-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-koran-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-surat-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-surat-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

	$('#upload-laporan-edit').change(function() {
		var i = $(this).next('label').clone();
		var file = $('#upload-laporan-edit')[0].files[0].name;
		$(this).next('label').text(file);
	});

</script>

<script>
	$(document).ready(function() {
		$('#editlaporanForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('input[name="tahun"]').attr("value", div.data('tahun'));
			modal.find('select[name="mata_uang"]').val(div.data('mata_uang')).change();
			modal.find('input[name="jml_aset"]').attr("value", div.data('jml_aset'));
			modal.find('input[name="hutang"]').attr("value", div.data('hutang'));
			modal.find('input[name="pendapatan"]').attr("value", div.data('pendapatan'));
			modal.find('input[name="laba_rugi"]').attr("value", div.data('laba_rugi'));
			modal.find('input[name="total_beban"]').attr("value", div.data('total_beban'));
			modal.find('select[name="nomor_akta"]').val(div.data('isaudit')).change();
			modal.find('input[name="nama_auditor"]').attr("value", div.data('nama_auditor'));
			modal.find('textarea[name="alamat_auditor"]').html(div.data('alamat_auditor'));
			modal.find('input[name="tgl_laporan"]').attr("value", div.data('tgl_laporan'));
		});
	});
</script>
