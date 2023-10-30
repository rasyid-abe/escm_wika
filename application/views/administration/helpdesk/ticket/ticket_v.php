<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets') ?>/app-assets/vendors/css/datatables/dataTables.bootstrap4.min.css" />

<section class="users-list-wrapper">
	<!-- Table starts -->
	<div class="users-list-table">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<a href="#" class="btn btn-info btn-sm mb-3" data-toggle="modal" data-target="#ticketForm"><i class="ft ft-plus"></i> Tambah Ticket</a>
							<div class="table-responsive">
								<table class="table table-striped table-bordered selection-multiple-rows">
									<thead>
										<tr>
											<th>Action</th>
											<th>No</th>
											<th>Kategori</th>
											<th>Perusahaan</th>
											<th>Email</th>
											<th>Tanggal</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$status = '<span class="badge badge-secondary">-</span>';
										foreach ($get_list as $value) {
											if ($value['status'] == 1) {
												$status = '<span class="badge badge-success">Open</span>';
											} elseif ($value['status'] == 2) {
												$status = '<span class="badge badge-danger">Closed</span>';
											}
										?>
											<tr>
												<td><a href="<?php echo base_url('administration/helpdesk/ticket/detail_ticket/') . $value['ticket_id'] ?>" target="_blank" class="btn btn-sm btn-info"> Detail</a></td>
												<td><?php echo $no++; ?></td>
												<td><?php echo $value['kategori']; ?></td>
												<td><?php echo $value['nama_perusahaan']; ?></td>
												<td><?php echo $value['email_perusahaan']; ?></td>
												<td><?php echo date("d-m-Y h:i:s", strtotime($value['created_at'])); ?></td>
												<td><?php echo $status; ?></td>
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
	</div>
	<!-- Table ends -->
</section>

<!-- Modal -->
<div class="modal fade text-left" id="ticketForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title modal-judul" id="myModalLabel">Tambah Ticket Baru</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form name="formticket" action="<?php echo base_url('administration/helpdesk/ticket/submit_ticket/') ?>" method="POST" onsubmit="return validateForm()">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Nama Perusahaan</label>
								<input type="text" class="form-control round" name="nama_perusahaan" placeholder="nama perusahaan" required>
							</div>
						</div>
						<div class="col-md-6 col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">NPWP</label>
								<input type="text" class="form-control round" name="npwp_no" placeholder="nomor npwp" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Email</label>
								<input type="email" class="form-control round" name="email_perusahaan" placeholder="email perusahaan" required>
							</div>
						</div>
						<div class="col-md-6 col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Telepon</label>
								<input type="text" class="form-control round" name="no_telp" placeholder="nomor telepon" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Alamat</label>
								<textarea rows="6" class="form-control round" name="alamat" placeholder="alamat perusahaan" required></textarea>
							</div>
						</div>
						<div class="col-md-6 col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Pertanyaan</label>
								<textarea rows="6" class="form-control round" name="deskripsi_pertanyaan" placeholder="deskripsi pertanyaan" required></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Kategori</label>
								<select class="form-control round" name="kategori" required>
									<option value="" selected disabled>Pilih</option>
									<option value="Lelang Info">Lelang Info</option>
									<option value="Pendaftaran">Pendaftaran</option>
									<option value="Aktifasi Email">Aktifasi Email</option>
									<option value="Lainnya">Lainnya</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
					<input type="submit" class="btn btn-info mr-2" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/page-login/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>


<script>
	$(document).ready(function() {
		// Row selection (multiple rows)
		var multipleRowsTable = $(".selection-multiple-rows").DataTable();

		$(".selection-multiple-rows tbody").on("click", "tr", function() {
			$(this).toggleClass("selected");
		});

		$("#row-count").on("click", function() {
			alert(
				multipleRowsTable.rows(".selected").data().length + " row(s) selected"
			);
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'ticket') {
				if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
					toastr.info('Ticket berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Ticket gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})

	function validateForm() {
		if (document.forms["formticket"]["nama_perusahaan"].value == "") {
			alert("Nama Tidak Boleh Kosong");
			document.forms["formticket"]["nama_perusahaan"].focus();
			return false;
		}
		if (document.forms["formticket"]["npwp_no"].value == "") {
			alert("NPWP Tidak Boleh Kosong");
			document.forms["formticket"]["npwp_no"].focus();
			return false;
		}
		if (document.forms["formticket"]["email_perusahaan"].value == "") {
			alert("Email Tidak boleh Kosong");
			document.forms["formticket"]["email_perusahaan"].focus();
			return false;
		}
		if (document.forms["formticket"]["no_telp"].value == "") {
			alert("No Telp Tidak boleh Kosong");
			document.forms["formticket"]["no_telp"].focus();
			return false;
		}
		if (document.forms["formticket"]["alamat"].value == "") {
			alert("Alamat Tidak boleh Kosong");
			document.forms["formticket"]["alamat"].focus();
			return false;
		}
		if (document.forms["formticket"]["deskripsi_pertanyaan"].value == "") {
			alert("Deskripsi Tidak boleh Kosong");
			document.forms["formticket"]["deskripsi_pertanyaan"].focus();
			return false;
		}
	}
</script>