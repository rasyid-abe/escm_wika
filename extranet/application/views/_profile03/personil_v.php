<?php $this->load->view("_profile03/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered">
			<!-- personil -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w float-left">Data Personil <span class="text-danger">(*)</span></h5>
							<?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
								<a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#personilForm"><i class="fa fa-plus"></i> Tambah</a>
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

			<div class="col-lg-12 text-center my-3">
				<a href="<?php echo site_url('registrasi_vendor/pengurus'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<a href="<?php echo site_url('registrasi_vendor/pengalaman'); ?>" class="btn btn-info btn-md">Selanjutnya</a>
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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'personil') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>
