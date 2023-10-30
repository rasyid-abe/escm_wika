	<?php $this->load->view("_profile02/_tab.php") ?>

	<div class="match-height">
		<form class="form-bordered" method="POST" action="<?php echo site_url('#'); ?>" enctype="multipart/form-data">
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
									<label class="col-md-3 label-control text-right">Email</label>
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
									<label class="col-md-3 label-control text-right">Nama Lengkap</label>
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
									<label class="col-md-3 label-control text-right">KTP/Nomor Identitas</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="id_card" value="<?php echo $detail_vendor['id_card']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">NPWP</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="npwp_no" value="<?php echo $detail_vendor['npwp_no']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Tempat Lahir</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="birth_place" value="<?php echo $detail_vendor['birth_place']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Tanggal Lahir</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="birth_date" value="<?php echo $detail_vendor['birth_date']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row last mb-3">
									<label class="col-md-3 label-control text-right">Tipe Vendor</label>
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

			<!-- alamat -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title text-bold-600">Alamat <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Negara</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="address_country" value="<?php echo $detail_vendor['address_country']; ?>" readonly>
											<div class="form-control-position">
												<i class="ft-mail"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Provinsi</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="addres_prop" value="<?php echo $detail_vendor['addres_prop']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Kabupaten</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="address_city" value="<?php echo $detail_vendor['address_city']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Kecamatan</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="address_district" value="<?php echo $detail_vendor['address_district']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Alamat Detail</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="address_street" value="<?php echo $detail_vendor['address_street']; ?>" required>
											<div class="form-control-position">
												<i class="ft-briefcase"></i>
											</div>
										</div>
									</div>
								</div>								
								<div class="form-group row last mb-3">
									<label class="col-md-3 label-control text-right">Kode Pos</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="address_postcode" value="<?php echo $detail_vendor['address_postcode']; ?>" required>
											<div class="form-control-position">
												<i class="ft-user"></i>
											</div>
										</div>
									</div>
								</div>																
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- kontak -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title text-bold-600">Kontak <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Nama Kontak</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="contact_name" value="<?php echo $detail_vendor['contact_name']; ?>" readonly>
											<div class="form-control-position">
												<i class="ft-mail"></i>
											</div>
										</div>
									</div>
								</div>														
								<div class="form-group row last mb-3">
									<label class="col-md-3 label-control text-right">Nomor Kontak</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" name="contact_phone_no" value="<?php echo $detail_vendor['contact_phone_no']; ?>" required>
											<div class="form-control-position">
												<i class="ft-user"></i>
											</div>
										</div>
									</div>
								</div>																
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- lampiran -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title text-bold-600">Lampiran <span class="text-danger">(*)</span></h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Lampiran Kontrak</label>
									<div class="col-md-9">
										<?php 
											$lampiran = isset($detail_vendor['contract_attachment']) ? $detail_vendor['contract_attachment'] : "#";
											$label = isset($detail_vendor['contract_attachment']) ? "Download" : "---";
										?>
										<a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
									</div>
								</div>														
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Lampiran KTP</label>
									<div class="col-md-9">
										<?php 
											$lampiran = isset($detail_vendor['id_attachment']) ? $detail_vendor['id_attachment'] : "#";
											$label = isset($detail_vendor['id_attachment']) ? "Download" : "---";
										?>
										<a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
									</div>
								</div>														
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Lampiran Referensi</label>
									<div class="col-md-9">
										<?php 
											$lampiran = isset($detail_vendor['ref_doc_attachment']) ? $detail_vendor['ref_doc_attachment'] : "#";
											$label = isset($detail_vendor['ref_doc_attachment']) ? "Download" : "---";
										?>
										<a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
									</div>
								</div>														
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Lampiran NPWP</label>
									<div class="col-md-9">
										<?php 
											$lampiran = isset($detail_vendor['tax_attachment']) ? $detail_vendor['tax_attachment'] : "#";
											$label = isset($detail_vendor['tax_attachment']) ? "Download" : "---";
										?>
										<a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
									</div>
								</div>														
								<div class="form-group row last mb-3">
									<label class="col-md-3 label-control text-right">Lampiran SIM</label>
									<div class="col-md-9">
										<?php 
											$lampiran = isset($detail_vendor['sim_attachment']) ? $detail_vendor['sim_attachment'] : "#";
											$label = isset($detail_vendor['sim_attachment']) ? "Download" : "---";
										?>
										<a href="<?php echo $lampiran ?>"><?php echo $label;?></a>
									</div>
								</div>																
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-12 text-center my-3">
				<a href="<?php echo site_url('registrasi_perorangan/pendidikan'); ?>" onclick="return confirm('Apakah Anda yakin dengan data di atas?')" class="btn btn-info btn-md">Selanjutnya</a>
			</div>
		</form>
	</div>



