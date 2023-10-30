<?php $this->load->view("_profile02/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered">
			<!-- personil -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title text-bold-600">Data Pengalaman <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="table-responsive">
									<table class="table table-striped table-sm table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Nama Perusahaan</th>
												<th>Tanggal Mulai</th>
												<th>Tanggal Selesai</th>
												<th>Lokasi</th>
												<th>Posisi</th>
												<th>Nama Projek</th>
												<th>Lampiran</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											foreach ($exp_work as $value) { ?>
												<tr>
													<td class="text-center"><?php echo $no++; ?></td>
													<td><?php echo $value['company_name']; ?></td>
													<td><?php echo $value['start_date']; ?></td>
													<td><?php echo $value['end_date']; ?></td>
													<td><?php echo $value['location']; ?></td>
													<td><?php echo $value['position']; ?></td>
													<td><?php echo $value['project_name']; ?></td>
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
				<a href="<?php echo site_url('registrasi_perorangan/pendidikan'); ?>" class="btn btn-secondary btn-md">Kembali</a>
				<a href="<?php echo site_url('registrasi_perorangan/pelatihan'); ?>" class="btn btn-info btn-md">Selanjutnya</a>
			</div>
		</form>
	</div>
	<!-- Table ends -->
</section>

