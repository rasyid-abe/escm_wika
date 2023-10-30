<section class="users-list-wrapper">
	<!-- Table News Start -->
	<div class="users-list-table">
		<div class="row">
			<div class="card">
				<div class="card-header">
					<button class="btn btn-info" onclick="showForm(0)">
						<i class="fa fa-plus"></i>
						Tambah
					</button>
				</div>
				<div id="formTicket" style="display: none;">
					<form class="col-12">
						<div class="row">
							<div class="col-md-6 col-12">
								<div class="form-group mb-2">
									<label class="col-form-label">Nama Perusahaan</label>
									<input type="text" class="form-control round" id="nama_perusahaan" name="nama_perusahaan" placeholder="nama perusahaan" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="form-group mb-2">
									<label class="col-form-label">NPWP</label>
									<input type="text" class="form-control round" id="npwp_no" name="npwp_no" placeholder="nomor npwp" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-12">
								<div class="form-group mb-2">
									<label class="col-form-label">Email</label>
									<input type="email" class="form-control round" id="email_perusahaan" name="email_perusahaan" placeholder="email perusahaan" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="form-group mb-2">
									<label class="col-form-label">Telepon</label>
									<input type="text" class="form-control round" id="no_telp" name="no_telp" placeholder="nomor telepon" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-12">
								<div class="form-group mb-2">
									<label class="col-form-label">Alamat</label>
									<textarea rows="6" class="form-control round" id="alamat" name="alamat" placeholder="alamat perusahaan" required></textarea>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="form-group mb-2">
									<label class="col-form-label">Pertanyaan</label>
									<textarea rows="6" class="form-control round" id="deskripsi_pertanyaan" name="deskripsi_pertanyaan" placeholder="deskripsi pertanyaan" required></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-12">
								<div class="form-group mb-2">
									<label class="col-form-label">Kategori</label>
									<select class="form-control round" id="kategori" name="kategori" required>
										<option value="" selected disabled>Pilih</option>
										<option value="Lelang Info">Lelang Info</option>
										<option value="Pendaftaran">Pendaftaran</option>
										<option value="Aktifasi Email">Aktifasi Email</option>
										<option value="Lainnya">Lainnya</option>
									</select>
								</div>
							</div>
						</div>
						<button class="btn btn-info" onclick="saveTicket(1)" id="submit_tic" style="display: none;">Simpan</button>
						<button class="btn btn-info" onclick="saveTicket(0)" id="edit_tic" style="display: none;">Edit</button>
					</form>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Aksi</th>
							<th>No</th>
							<th>Kategori</th>
							<th>Perusahaan</th>
							<th>Email</th>
							<th>Tanggal</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="show_ticket">
					</tbody>
				</table>
			</div>
		</div>

	</div>

	<script type="text/javascript">
		var no_table = 0;
		var ticket_id = 0;
		//badge status
		var def = '<span class="badge badge-secondary">-</span>';
		var open = '<span class="badge badge-success">Open</span>';
		var closed = '<span class="badge badge-danger">Closed</span>';
		var dt = new Date();
		var date_now = formatDate(dt);
		var url_submit = '';

		function formatDate(d) {
			var a = new Date(d),
				month = '' + (d.getMonth() + 1),
				day = '' + d.getDate(),
				year = d.getFullYear(),
				jam = d.getHours(),
				menit = d.getMinutes(),
				detik = d.getSeconds();

			if (month.length < 2)
				month = '0' + month;
			if (day.length < 2)
				day = '0' + day;
			if (jam.length < 2)
				jam = '0' + jam;
			if (menit.length < 2)
				menit = '0' + menit;
			if (detik.length < 2)
				detik = '0' + detik;

			return [year, month, day].join('-') + ' ' + [jam, menit, detik].join(':');
		}

		function showForm(status) {
			var div = document.getElementById("formTicket");
			var save = document.getElementById("submit_tic");
			var edit = document.getElementById("edit_tic");
			if (div.style.display !== "none") {
				div.style.display = "none";
			} else {
				div.style.display = "block";
			}
			console.log(status);
			if (status) {
				edit.style.display = "none"
				save.style.display = "block"
			} else {
				save.style.display = "block"
				edit.style.display = "none"
			}
		}

		show_ticket();

		function show_ticket() {
			fetch("<?= site_url($controller_name . '/helpdesk/ticket/get_ticket'); ?>", {})
				.then(response => response.json())
				.then(res => {
					let data = res.get_list;
					var i;
					var html = '';
					for (i = 0; i < data.length; i++) {
						no_table = (parseInt(i) + 1);
						ticket_id = data[i].ticket_id;
						html += '<tr>' +
							'<td style="text-align:right;">' +
							'<button class="btn btn-info btn-sm" onclick="editTicket(' + data[i].ticket_id + ')">Detail</button>' +
							'</td>' +
							'<td>' + (parseInt(i) + 1) + '</td>' +
							'<td>' + data[i].kategori + '</td>' +
							'<td>' + data[i].nama_perusahaan + '</td>' +
							'<td>' + data[i].email_perusahaan + '</td>' +
							'<td>' + data[i].created_at + '</td>' +
							'<td>' + (data[i].status == 1 ? open : closed) + '</td>' +
							'</tr>';
						document.getElementById('show_ticket').innerHTML = html;

					}
				});
		}

		function editTicket(id) {
			let formData = new FormData();
			formData.append('ticket_id', id);

			fetch("<?= site_url($controller_name . '/helpdesk/ticket/get_edit_ticket'); ?>", {
					body: formData,
					method: "post"
				})
				.then(response => response.json())
				.then(res => {
					var div = document.getElementById("formTicket");
					div.style.display = "block";
					var edit = document.getElementById("edit_tic");
					edit.style.display = "block";

					let data = res.get_list[0];
					document.getElementById('nama_perusahaan').value = data.nama_perusahaan;
					document.getElementById('npwp_no').value = data.npwp_no;
					document.getElementById('email_perusahaan').value = data.email_perusahaan;
					document.getElementById('no_telp').value = data.no_telp;
					document.getElementById('alamat').value = data.alamat;
					document.getElementById('deskripsi_pertanyaan').value = data.deskripsi_pertanyaan;
					document.getElementById('kategori').value = data.kategori;
				})
		}

		function reset() {
			document.getElementById('nama_perusahaan').value = '';
			document.getElementById('npwp_no').value = '';
			document.getElementById('email_perusahaan').value = '';
			document.getElementById('no_telp').value = '';
			document.getElementById('alamat').value = '';
			document.getElementById('deskripsi_pertanyaan').value = '';
			document.getElementById('kategori').value = '';
		}

		function saveTicket(submit_status) {
			var nama_perusahaan = document.getElementById('nama_perusahaan').value;
			var npwp_no = document.getElementById('npwp_no').value;
			var email_perusahaan = document.getElementById('email_perusahaan').value;
			var no_telp = document.getElementById('no_telp').value;
			var alamat = document.getElementById('alamat').value;
			var deskripsi_pertanyaan = document.getElementById('deskripsi_pertanyaan').value;
			var kategori = document.getElementById('kategori').value;

			let formData = new FormData();
			formData.append('nama_perusahaan', nama_perusahaan);
			formData.append('npwp_no', npwp_no);
			formData.append('email_perusahaan', email_perusahaan);
			formData.append('no_telp', no_telp);
			formData.append('alamat', alamat);
			formData.append('deskripsi_pertanyaan', deskripsi_pertanyaan);
			formData.append('kategori', kategori);
			formData.append('ticket_id', ticket_id)

			if (
				nama_perusahaan != '' &&
				npwp_no != '' &&
				email_perusahaan != '' &&
				no_telp != '' &&
				alamat != '' &&
				deskripsi_pertanyaan != '' &&
				kategori != ''
			) {
				if (submit_status) {
					url_submit = '/helpdesk/ticket/submit_ticket';
				} else {
					url_submit = '/helpdesk/ticket/edit_ticket';
				}

				fetch("<?= site_url($controller_name); ?>" + url_submit, {
						body: formData,
						method: "post"
					})
					.then(response => {
						show_ticket();
						reset();
					});
			} else return false;

		}
	</script>