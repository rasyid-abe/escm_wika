<?php $this->load->view("_profile02/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title text-bold-600">Data Pelatihan <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="table-responsive">
									<table class="table table-striped table-sm table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Lokasi</th>
												<th>Nama Pelatihan</th>
												<th>Nama Perusahaan</th>
												<th>Tahun</th>
												<th>Lampiran</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($training as $value) { ?>
												<tr>
													<td class="text-center"><?php echo $no++; ?></td>
													<td><?php echo $value['city']; ?></td>
													<td><?php echo $value['name']; ?></td>
													<td><?php echo $value['institute']; ?></td>
													<td><?php echo $value['year']; ?></td>
													<td>
														<?php if ($value['attachment'] != NULL) { ?>
															<a href="<?php echo $value['attachment']; ?>" target="_blank">Download</a>
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
				<a href="<?php echo site_url('registrasi_perorangan/pengalaman_cv'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<a href="<?php echo site_url('registrasi_perorangan/catatan'); ?>" class="btn btn-info btn-md">Selanjutnya</a>
			</div>
		</form>
	</div>
	<!-- Table ends -->
</section>