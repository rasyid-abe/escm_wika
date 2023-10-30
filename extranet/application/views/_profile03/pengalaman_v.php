<?php $this->load->view("_profile03/_tab.php") ?>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets'); ?>/app-assets/vendors/css/select2.min.css">

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered">
			<!-- pengalaman -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Data Pengalaman <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#pengalamanForm"><i class="fa fa-plus"></i> Tambah</a>
							<?php } ?>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
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
											foreach ($pengalaman as $value) { ?>
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

			<div class="col-lg-12 text-center my-3">
				<a href="<?php echo site_url('registrasi_vendor/personil'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<a href="<?php echo site_url('registrasi_vendor/peralatan'); ?>" class="btn btn-info btn-md">Selanjutnya</a>
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
		$('.dataTables-example').DataTable({
			"lengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "All"]
			]
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'pengalaman') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>