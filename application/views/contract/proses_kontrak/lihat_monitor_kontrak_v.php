<style>
	.table {
		text-align: center;
	}

	.btn-action-edit {
		border-radius: 8px 0 0 8px;
		width: 100px;
	}

	.bg-update {
        background-color: #29a7de !important;
    }

	.btn-action-delete {
		border-radius: 0 8px 8px 0;
		background-color: rgb(36 36 36 / 22%);
		position: relative;
		left: -4px;
	}

	.btn-tambah {
		border-radius: 8px;
	}

	.btn-export {
		background-color: transparent;
		border: none;
	}

	.save-comment {
		position: absolute;
		right: 20px;
	}

	.table-catatan td {
		padding: 1rem !important;
	}

	.table-catatan th {
		padding: 1rem !important;
	}

	.btn-bordered {
		border-radius: 8px;
	}

	.cad_comment_value {
		width: 200px;
		text-align: left;
		top: 0;
		scroll-behavior: smooth;
		line-height: 1.7;
	}

	.segitiga {
		height: 0px;
		width: 0px;
		border-left: 1.2em solid rgb(42 171 226) !important;
		border-top: solid 2.3em transparent;
		border-bottom: solid 2.3em transparent;
		display: none;
	}

	.step {
		font-size: 11px;
		margin: auto;
		/* box-shadow: 0 0 11px rgba(33,33,33,.2); */
		padding-top: 15px;
		padding-bottom: 10px;
		/* padding-left: 10px !important; */
		border-radius: 10px;
	}

	.card {
		border-radius: 1.35rem;
	}

	.breadcrumb-escm {
		border: 1px solid #d1d3d4;
	}

	.wrapper-icon {
		display: flex;
		align-items: center;
		margin-left: 8px;
		padding: 5px;
	}

	.wrapper-icon:hover {
		background-color: #eaeaea;
		border-radius: 8px;
	}

	.shadow-none {
		width: 20%;
		border: 1px solid #d1d3d4;
		background-color: white;
	}

	textarea.form-control {
		background-color: transparent;
		color: #606060;
	}

	input.form-control {
		background-color: transparent;
		color: #606060;
	}

</style>
<script src="https://cdn.tiny.cloud/1/fomjvw28r2o4v9niehzlxvd035csn6z2f91rtszw92yr5ppm/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<div class="wrapper wrapper-content animated fadeInRight">

	<?php
		$status_1 = 'Menunggu proses';
		$status_2 = 'Menunggu proses';
		$status_3 = 'Menunggu proses';
		$status_4 = 'Menunggu proses';
		$status_5 = 'Menunggu proses';

		$color1 = 'text-dark';
		$color2 = 'text-dark';
		$color3 = 'text-dark';
		$color4 = 'text-dark';
		$color5 = 'text-dark';

		$bgcolor1 = "bg-white";
		$bgcolor2 = "bg-white";
		$bgcolor3 = "bg-white";
		$bgcolor4 = "bg-white";
		$bgcolor5 = "bg-white";

		if ($activity_id >= 2010) {
			$bgcolor1 = "bg-update";
			$color1 = 'text-white';
			$status_1 = isset($end_date_1["end_date"]) ? $end_date_1["end_date"] : "Menunggu Proses";
		}

		if ($activity_id >= 2027) {
			$bgcolor2 = "bg-update";
			$color2 = 'text-white';
			$status_2 = isset($end_date_2["end_date"]) ? $end_date_2["end_date"] : "Menunggu Proses";
		}

		if ($activity_id >= 2030) {
			$bgcolor3 = "bg-update";
			$color3 = 'text-white';
			$status_3 = isset($end_date_3["end_date"]) ? $end_date_3["end_date"] : "Menunggu Proses";
		}

		if ($activity_id >= 2901) {
			$bgcolor4 = "bg-update";
			$color4 = 'text-white';
			$status_4 = isset($end_date_4["end_date"]) ? $end_date_4["end_date"] : "Menunggu Proses";
		}

		if ($activity_id == 2903) {
			$bgcolor5 = "bg-update";
			$color5 = 'text-white';
			$status_5 = isset($end_date_5["end_date"]) ? $end_date_5["end_date"] : "Menunggu Proses";
		}
	?>

	<div class="row step mb-2">
		<div class="shadow-none rounded-0 mb-1" style="border-radius: 10px 0px 0px 10px !important;">
			<div class="px-2 py-1 <?php echo $bgcolor1;?> <?php echo $color1;?>">
				<p class="mb-1 font-weight-bold">Pembuatan Kontrak</p>
				<small><?php echo $status_1; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1">
			<div class="px-2 py-1 <?php echo $bgcolor2;?> <?php echo $color2;?>">
				<p class="mb-1 font-weight-bold">Approval Kontrak</p>
				<small><?php echo $status_2; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1">
			<div class="px-2 py-1 <?php echo $bgcolor3;?> <?php echo $color3;?>">
				<p class="mb-1 font-weight-bold">Finalisasi Kontrak</p>
				<small><?php echo $status_3; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1">
			<div class="px-2 py-1 <?php echo $bgcolor4;?> <?php echo $color4;?>">
				<p class="mb-1 font-weight-bold">Kontrak Aktif</p>
				<small><?php echo $status_4; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1" style="border-radius: 0px 10px 10px 0px !important;">
			<div class="px-2 py-1 <?php echo $bgcolor5;?> <?php echo $color5;?>">
				<p class="mb-1 font-weight-bold">Kontrak Selesai</p>
				<small><?php echo $status_5; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
	</div>

	<div class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<?php

		$loaded = array();

		foreach ($content as $key => $value) {
			$str = "view/" . $value['awc_file'] . ".php";
			if (!in_array($str, $loaded)) {
				include($str);
				$loaded[] = $str;
			}
		}

		?>

		<?php if ($history_amd_num > 1) { ?>
			<div class="row">
				<div class="col-12">
					<div class="card">

						<div class="card-header border-bottom pb-2">
							<div class="btn-group-sm float-left">
								<span class="card-title text-bold-600 mr-2">History Amandemen Kontrak</span>
							</div>
						</div>

						<div class="card-content">
							<div class="card-body">
								<div class="table-responsive table-striped">
									<table class="table comment" style="margin-bottom: 0;">
										<thead>
											<tr>
												<th>No</th>
												<th>Nomor Kontrak</th>
												<th>Nilai Kontrak</th>
												<th>Type</th>
												<th>Alasan</th>
												<th>Tanggal</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											if (isset($history_amd) && !empty($history_amd)) {
												foreach ($history_amd as $key => $value) {
											?>

													<tr>
														<td><?php echo $no++; ?></td>
														<td>
															<a href="<?php echo site_url('contract/monitor/monitor_kontrak/lihat/' . $value['contract_id']) ?>" target="_blank">
																<?php echo $value['contract_number'] ?>
															</a>
														</td>
														<td>
															<?php echo inttomoney($value['contract_amount']) ?>
														</td>
														<td>
															<?php echo $value['ctr_item_type'] ?>
														</td>
														<td>
															<?php echo $value['terminate_reason'] ?>
														</td>
														<td>
															<?php echo $value['created_date'] ?>
														</td>
													</tr>

											<?php }
											} ?>
										</tbody>
									</table>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		<?php } ?>

		<?php include 'vsi/page_uskep_online_v.php'; ?>

		<?php if ($kontrak['status'] > 2900) { ?>
			<div class="row">
				<div class="col-12">
					<div class="card">

						<div class="card-header border-bottom pb-2">
							<span class="card-title text-bold-600 mr-2">VPI</span> <span><a href="<?php echo site_url('vendor/vpi/daftar_pekerjaan/penilaian_header/' . $id) ?>" class="btn btn-info btn-sm rounded"><i class="ft-plus"></i> Nilai</a></span>
						</div>

						<div class="card-content">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table comment">
										<thead>
											<tr>
												<th style="width: 10px">No</th>
												<th>Update</th>
												<th>Bulan</th>
												<th>Tahun</th>
												<th>Nilai</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = "1";
											if (!empty($vpi_score)) : ?>
												<?php foreach ($vpi_score as $key => $item) : ?>
													<?php $dateObj   = DateTime::createFromFormat('!m', $item->vpi_month);
													$monthName = $dateObj->format('F'); // March
													?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $item->updated_datetime; ?></td>
														<td><?php echo $monthName; ?></td>
														<td><?php echo $item->vpi_year; ?></td>
														<td><?php echo $item->vpi_score; ?></td>
													</tr>
												<?php endforeach; ?>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td class="text-bold-700">Rata-rata</td>
													<td class="text-bold-700"><?php echo $vpi_score_sum['vpi_score'] / $vpi_score_num ?></td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		<?php } ?>

		<?php include 'vsi/page_question_v.php'; ?>
		<?php include 'vsi/page_importance_v.php'; ?>
		<?php include 'vsi/page_satisfaction_v.php'; ?>
		<?php include 'vsi/page_weight_v.php'; ?>
		<?php include 'vsi/page_percentage_v.php'; ?>

		<?php if ($kontrak['status'] > 2900) { ?>
			<div class="row">
				<div class="col-12">
					<div class="card">

						<div class="card-header border-bottom pb-2">
							<h4 class="card-title">VSI</h4>
						</div>

						<div class="card-content">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table comment">
										<thead>
											<tr>
												<th>Periode</th>
												<th>Tanggal & Waktu</th>
												<th>Nilai</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$vsit = 0;
											if (!empty($vendor)) :
												foreach ($vendor as $ky => $val) { ?>
													<tr>
														<td>
															<?php echo $val['periode']; ?>
														</td>
														<td>
															<?php echo $val['created_date']; ?>
														</td>
														<td>
															<?php
															$pre = 0;
															foreach ($weightimp as $key => $value) {
																$pre += $value[$ky];
															}
															$vsi = ($pre / 4) * 100;
															$vsit += $vsi;
															echo $vsi . " %";
															?>
														</td>
													</tr>
											<?php }
											endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		<?php } ?>

		<div class="row" id="form-comment">
			<div class="col-12">
				<div class="card">
					<div class="card-header border-bottom pb-2">
						<h4 class="card-title float-left">Catatan</h4>
						<button onclick="isShowAdd()" class="btn btn-sm btn-info btn-tambah ml-2">
							<i class="ft ft-plus"></i>Tambah
						</button>
						<div class="float-right">
							<img src="<?php echo base_url(); ?>/assets/icons/LIKE20px.png" class="ml-1">
							<b><?= $thumbs_down ?></b>
							<img src="<?php echo base_url(); ?>/assets/icons/DISLIKE20px.png" class="ml-1">
							<b><?= $thumbs_up ?></b>
							<img src="<?php echo base_url(); ?>/assets/icons/COMMENT20px.png" class="ml-1">
							<b><?= $comment ?></b>
							<a href="<?= $controller_name . '/pdf_comment/' . $kontrak['contract_id'] ?>">
								<button class="btn btn-export ml-1">
									<img width="20" class="mr-1" src="<?= base_url('assets/img/icons/printer.png') ?>" alt="printer-icon">
									Export <i class=" fa fa-angle-down fa-lg"></i>
								</button>
							</a>
						</div>
					</div>

					<div class="card-content">
						<div class="card-body">
							<!-- form edit -->
							<div id="showEdit" style="display: none;">
								<form action="<?php echo site_url($controller_name . '/edit_comment_contract#form-comment'); ?>" method="POST" id="comment">
									<div class="row">
										<?php $ptm_number = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : ""; ?>
										<?php $contract_id = (isset($kontrak['contract_id'])) ? $kontrak['contract_id'] : ""; ?>
										<div class="col-md-2">
											<label>Objek Catatan</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="cad_obj_nilai_edit" name="cad_obj_nilai_edit" placeholder="Objek Catatan" required>
										</div>

										<div class="col-md-2">
											<label for="lampiran">No. Telpon</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="cad_no_telp_edit" name="cad_no_telp_edit" placeholder="Nomor Telpon" required>
										</div>
									</div>
									<br>

									<div class="row form-group">
										<?php $curval = (isset($v['ppd_file_name'])) ? $v['ppd_file_name'] :  set_value("doc_attachment_inp[]"); ?>
										<label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
										<div class="col-md-4">
											<div class="input-group align-items-center">
												<span class="input-group-btn">
													<button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo $dir . '/comment' ?>" data-preview="preview_file_" class="btn btn-sm btn-info btn-bordered">
														<i class="fa fa-cloud-upload"></i> Up
													</button>
													<button type="button" data-url="<?php echo site_url('log/download_attachment/contract/comment/' . $curval) ?>" class="btn btn-sm btn-info preview_upload mr-1 btn-bordered" id="preview_file_">
														<i class="fa fa-share"></i> View
													</button>
												</span>
												<input readonly type="text" class="form-control" id="doc_attachment_inp_" name="cad_lampiran_edit" value="<?php echo $curval ?>">
												<span class="input-group-btn">
													<button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo $dir ?>" data-preview="preview_file_" class="btn btn-sm btn-danger removefile ml-1 btn-bordered">
														<i class="fa fa-trash"></i>
													</button>
												</span>
											</div>
											<div class="col-sm-0" style="font-size: 11px">
												<i>Max file 5 MB
													<br>
													Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
												</i>
											</div>
										</div>
										<label class="col-md-2">Komentar</label>
										<div class="col-md-4">
											<input type="hidden" name="cad_contract_id_edit" value="<?php echo $contract_id; ?>">
											<input type="hidden" name="cad_ptm_number_edit" value="<?php echo $ptm_number; ?>">
											<input type="hidden" id="cad_id" name="cad_id" value="">
											<textarea rows="4" class="form-control" id="cad_comment_edit" name="cad_comment_edit" placeholder="Isi komentar" required></textarea>
										</div>
										<div class="col-md-6">
											<p style="color: white !important">test</p>
										</div>
										<label class="col-md-2 mt-2">Pilih respon</label>
										<div class="col-md-4 d-flex justify-content-start mt-2">
											<input type="hiden" value="" style="display: none;" id="cad_respon_edit" name="cad_respon_edit" required>
											<div class="wrapper-icon mr-2">
												<img src="<?php echo base_url(); ?>/assets/icons/LIKE32px.png" id="thumbsup_edit" onclick="responEdit(1)">
												<span class="ml-1">baik</span>
											</div>
											<div class="wrapper-icon mr-2">
												<img src="<?php echo base_url(); ?>/assets/icons/DISLIKE32px.png" id="thumbsdown_edit" onclick="responEdit(0)">
												<span class="ml-1">buruk</span>
											</div>
											<div class="wrapper-icon">
												<img src="<?php echo base_url(); ?>/assets/icons/COMMENT32px.png" onclick="responEdit(2)" id="comment_edit">
												<span class="ml-1">comment</span>
											</div>
										</div>
									</div>
									<div class="row form-group mr-2 justify-content-end">

									</div>
									<span class="wrapper-action save-comment">
										<input type="submit" class="btn btn-sm btn-info btn-action-edit" onclick="return confirm('Apakah Anda yakin edit komentar ini?')" value="Edit"></input>
										<button type="reset" onclick=" return resetFormEdit('comment')" class="btn btn-sm btn-action-delete">
											<i class="fa fa-trash fa-lg"></i>
										</button>
									</span>
								</form>
							</div>

							<!-- form add -->
							<div id="showAdd" style="display: none;">
								<form action="<?php echo site_url($controller_name . '/submit_comment_contract#form-comment'); ?>" method="POST">
									<div class="row">
										<?php $ptm_number = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : ""; ?>
										<?php $contract_id = (isset($kontrak['contract_id'])) ? $kontrak['contract_id'] : ""; ?>
										<div class="col-md-2">
											<label>Objek Catatan</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" name="cad_obj_nilai" placeholder="Objek Catatan" required>
										</div>

										<div class="col-md-2">
											<label for="lampiran">No. Telpon</label>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="cad_no_telp" name="cad_no_telp" placeholder="Nomor Telpon" required>
										</div>
									</div>
									<br>

									<div class="row form-group">
										<label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
										<div class="col-md-4">
											<div class="input-group align-items-center">
												<span class="input-group-btn">
													<button type="button" data-id="doc_attachment_inp_add" data-folder="<?php echo $dir . '/comment' ?>" data-preview="preview_file_add" class="btn btn-sm btn-info upload btn-bordered">
														<i class="fa fa-cloud-upload"></i> Up
													</button>
													<button type="button" data-url="<?php echo site_url('log/download_attachment/contract/comment/' . $curval) ?>" class="btn btn-sm btn-info preview_upload btn-bordered mr-1" id="preview_file_add">
														<i class="fa fa-share"></i> View
													</button>
												</span>
												<input readonly type="text" class="form-control" id="doc_attachment_inp_add" name="cad_lampiran" value="<?php echo $curval ?>">
												<span class="input-group-btn">
													<button type="button" data-id="doc_attachment_inp_add" data-folder="<?php echo $dir ?>" data-preview="preview_file_add" class="btn btn-sm btn-danger removefile btn-bordered ml-1">
														<i class="fa fa-trash"></i>
													</button>
												</span>
											</div>
											<div class="col-sm-0" style="font-size: 11px">
												<i>Max file 5 MB
													<br>
													Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
												</i>
											</div>
										</div>
										<label class="col-md-2">Komentar</label>
										<div class="col-md-4">
											<input type="hidden" name="cad_contract_id" value="<?php echo $contract_id; ?>">
											<input type="hidden" name="cad_ptm_number" value="<?php echo $ptm_number; ?>">
											<input type="hidden" name="cad_ptm_number" value="<?php echo $ptm_number; ?>">
											<textarea rows="4" class="form-control" name="cad_comment" placeholder="Isi komentar" required></textarea>
										</div>
										<div class="col-md-6">
											<p style="color: white !important">test</p>
										</div>
										<label class="col-md-2 mt-2">Pilih respon</label>
										<div class="col-md-4 d-flex justify-content-start mt-2">
											<input type="hiden" value="" style="display: none;" id="cad_respon" name="cad_respon" required>
											<div class="wrapper-icon mr-2">
												<img src="<?php echo base_url(); ?>/assets/icons/LIKE32px.png" id="thumbsup" onclick="respon(1)">
												<span class="ml-1">baik</span>
											</div>
											<div class="wrapper-icon mr-2">
												<img src="<?php echo base_url(); ?>/assets/icons/DISLIKE32px.png" id="thumbsdown" onclick="respon(0)">
												<span class="ml-1">buruk</span>
											</div>
											<div class="wrapper-icon">
												<img src="<?php echo base_url(); ?>/assets/icons/COMMENT32px.png" onclick="respon(2)" id="comments">
												<span class="ml-1">comment</span>
											</div>
										</div>
									</div>

									<span class="wrapper-action save-comment">
										<input type="submit" class="btn btn-sm btn-info btn-action-edit" onclick="validateRespon()" value="Simpan"></input>
										<button type="reset" onclick=" return resetForm('comment')" class="btn btn-sm btn-action-delete">
											<i class="fa fa-trash fa-lg"></i>
										</button>
									</span>
								</form>
							</div>
						</div>
						<br>
						<div class="overflow-auto px-2">
							<table class="table table-striped table-catatan text-center">
								<thead>
									<?php if ($com_num > 0) { ?>
										<tr>
											<th scope="col">No</th>
											<th scope="col">Respon</th>
											<th scope="col">Objek Catatan</th>
											<th scope="col">Lampiran</th>
											<th scope="col">Nama</th>
											<th scope="col">Jabatan</th>
											<th scope="col">Devisi</th>
											<th scope="col">No.Telp</th>
											<th scope="col">Tanggal & Waktu</th>
											<th scope="col">Komentar</th>
											<th scope="col" style="min-width: 170px;">Aksi</th>
										</tr>
								</thead>
								<tbody>
									<?php
										foreach ($komentar as $key => $val) {
									?>
										<tr>
											<td><?php echo $key + 1 ?></td>
											<td>
												<?php
												$thumbs_up = '<img src="' . base_url() . '/assets/icons/LIKE32px.png" class="ml-1">';
												$thumbs_down = '<img src="' . base_url() . '/assets/icons/DISLIKE32px.png" class="ml-1">';
												$comment = '<img src="' . base_url() . '/assets/icons/COMMENT32px.png" class="ml-1">';

												if ($val['cad_respon'] == 1) {
													echo $thumbs_up;
												} else if ($val['cad_respon'] == 0) {
													echo $thumbs_down;
												} else {
													echo $comment;
												}
												?>
											</td>
											<td><?php echo $val['cad_obj_nilai'] ?></td>
											<td>
												<a href="<?php echo site_url('log/download_attachment/contract/comment/' . $val['cad_lampiran']) ?>"><?= $val['cad_lampiran'] ?></a>
											</td>
											<td><?php echo $val['cad_user_name'] ?></td>
											<td><?php echo $val['cad_position'] ?></td>
											<td><?php echo $val['cad_divisi'] ?></td>
											<td><?php echo $val['cad_no_telp'] ?></td>
											<td><?php echo $val['cad_created_date'] ?></td>
											<td>
												<textarea name="cad_comment" class="form-control cad_comment_value" rows="3"><?= $val['cad_comment'] ?></textarea>
											</td>
											<td>
												<span class="wrapper-action">
													<button onclick="editData(<?php echo $val['id'] ?>)" class="btn btn-sm btn-info btn-action-edit">Edit</button>
													<a href="<?php echo site_url('contract/submit_delete_comment/' . $val['id']); ?>" onclick="return confirm('Apakah Anda yakin akan hapus data ini?')" class="btn btn-sm btn-action-delete">
														<i class="fa fa-trash"></i>
													</a>
												</span>
											</td>
										</tr>

									<?php } ?>
								<?php } else { ?>
									<div class="alert bg-light-secondary text-center text-bold-700" role="alert">Belum ada komentar.</div>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		$i = 0;
		include(VIEWPATH . "/comment_view_v.php") ?>

		<div class="card">
			<div class="card-content">
				<div class="card-body">
					<div class="d-flex">
						<a href="<?php echo base_url('contract/monitor/monitor_kontrak') ?>" type="button" class="btn btn-secondary" name="button">Kembali</a>
						<?php if ($is_sap == 1): ?>
							<form class="ml-auto" action="<?php echo site_url("contract/export_txt");?>" method="post">
								<input type="hidden" name="contract_id" value="<?php echo $contract_id ?>">
								<button type="submit" class="btn btn-primary" id="ex_po" name="button">Export</button>
							</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<script>
	$(document).ready(function() {
		if ('<?php echo $_GET['msg'] ?>' != '') {
			if ('<?php echo $_GET['msg'] ?>' == 'success') {
				alert('Export PO Success!')
			} else {
				alert('Export PO Failed!')
			}
		}

		table_list_vendor_score
		var table_list_vendor_score = $("#table_list_vendor_score").DataTable();

	});

	function validateRespon() {
		let res = document.getElementById('cad_respon').value;
		if (res == '') {
			alert("Respon tidak boleh kosong!")
			return false;
		} else {
			confirm("Apakah anda yakin akan menyimpan catatan?");
		}
	}

	function editData(params) {
		var div = document.getElementById("showEdit");
		div.style.display = "block";
		var div = document.getElementById("showAdd");
		div.style.display = "none";

		<?php
		$url = site_url($controller_name . '/get_edit_comment_contract');
		?>

		let formData = new FormData();
		formData.append('id', params);

		fetch("<?= $url ?>", {
				body: formData,
				method: "post"
			})
			.then(response => response.json())
			.then(res => {
				var data = res.edits[0]
				let cad_id = document.getElementById('cad_id');
				cad_id.value = data.id;
				let cad_obj_nilai = document.getElementById('cad_obj_nilai_edit');
				cad_obj_nilai.value = data.cad_obj_nilai;
				//no tel
				let cad_no_telp = document.querySelector('input[name="cad_no_telp_edit"]');
				cad_no_telp.value = data.cad_no_telp;
				//lampiran
				let cad_lampiran = document.getElementById('doc_attachment_inp_');
				cad_lampiran.value = data.cad_lampiran;
				//komen
				// let cad_comment = document.querySelector('input[name="cad_comment_edit"]');
				// cad_comment.value = data.cad_comment;
				document.getElementById('cad_comment_edit').value = data.cad_comment;

				//respon
				let cad_respon = document.querySelector('input[name="cad_respon_edit"]');
				data.cad_comment == 't' ? cad_respon.value = 1 : cad_respon.value = 0;
			});

	}

	function isShowAdd() {
		var div = document.getElementById("showEdit");
		div.style.display = "none";
		var div = document.getElementById("showAdd");
		if (div.style.display !== "none") {
			div.style.display = "none";
		} else {
			div.style.display = "block";
		}
	}

	function showEdit(params) {
		var div = document.getElementById("showEdit");
		div.style.display = "block";
	}

	function resetForm(params) {
		// params.preventDefault();
		document.getElementById(params).reset();
		isShowAdd();
	}

	function resetFormEdit(params) {
		// params.preventDefault();
		document.getElementById(params).reset();
		isShowAdd();
	}

	function respon(params) {
		var responEl = document.querySelector('input[name="cad_respon"]');
		responEl.value = params;
		console.log(document.getElementById('comment').style);
		if (params == 1) {
			document.getElementById('thumbsup').style = 'width: 40px;'
			document.getElementById('thumbsdown').style = 'width: auto:'
			document.getElementById('comments').style = 'width: auto;'
		} else if (params == 2) {
			document.getElementById('thumbsup').style = 'width: auto;'
			document.getElementById('thumbsdown').style = 'width: auto;'
			document.getElementById('comments').style = 'width: 40px;'
		} else {
			document.getElementById('thumbsup').style = 'width: auto;'
			document.getElementById('thumbsdown').style = 'width: 40px;'
			document.getElementById('comments').style = 'width: auto;'
		}
	}

	function responEdit(params) {
		var responEl = document.querySelector('input[name="cad_respon_edit"]');
		responEl.value = params;
		if (params == 1) {
			document.getElementById('thumbsup_edit').style = 'width: 40px;'
			document.getElementById('thumbsdown_edit').style = 'width: auto:'
			document.getElementById('comment_edit').style = 'width: auto;'
		} else if (params == 2) {
			document.getElementById('thumbsup_edit').style = 'width: auto;'
			document.getElementById('thumbsdown_edit').style = 'width: auto;'
			document.getElementById('comment_edit').style = 'width: 40px;'
		} else {
			document.getElementById('thumbsup_edit').style = 'width: auto;'
			document.getElementById('thumbsdown_edit').style = 'width: 40px;'
			document.getElementById('comment_edit').style = 'width: auto;'
		}
	}

	$('#ex_po').on('click', function() {
		let cid = $('input[name=cad_contract_id]').val()
		console.log(cid);
		$.ajax({
            url: '<?php echo site_url("contract/export_txt");?>',
            method: 'post',
			data: {'contract_id': cid},
            dataType: 'json',
            success: function(data) {
				console.log(data);
            }
        })
	})
</script>
