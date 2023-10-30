<?php $this->load->view("_profile01/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered">
			<!-- pengurus -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Pengurus Perusahaan <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#pengurusForm"><i class="fa fa-plus"></i> Tambah</a>
							<?php } ?>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
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

			<div class="col-lg-12 text-center my-3">
				<a href="<?php echo site_url('registrasi_vendor/saham'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<a href="<?php echo site_url('registrasi_vendor/personil'); ?>" class="btn btn-info btn-md">Selanjutnya</a>
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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'pengurus') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>
