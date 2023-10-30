<section class="users-list-wrapper">
	<!-- Table News Start -->
	<div class="users-list-table">
		<div class="row">
			<div class="col-md-12 mt-3">
        <hr/>
          <div class="content-header">
            <span>
              <a href="#" class="btn btn-info btn-sm mb-1 mr-2" title="Tambah Berita LKPP" data-toggle="modal" data-target="#newsForm">
                <i class="ft ft-plus"></i>
              </a>
            </span>
    				<strong style="color:#29a7de">Berita Utama</strong>
          </div>
        <hr/>
			</div>
		</div>
		<div class="row">
			<?php foreach ($get_list as $value) { ?>
				<div class="col-lg-4 col-md-6 col-sm-12">
					<div class="card">
						<div class="card-header mb-2">
							<h4 class="card-title"><?php echo substr($value['tittle'], 0, 100); ?></h4>
						</div>
						<div class="card-content">
							<div class="card-img">
								<img class="img-fluid" src="<?= base_url('uploads/administration/' . $value['image'])?>">
							</div>
							<div class="card-body">
								<p class="card-text"><?php echo substr($value['content'], 0, 100); ?></p>
							</div>
						</div>
						<div class="card-footer text-muted pt-0">
							<span class="float-left"><?php echo date("d-m-Y H:i:s", strtotime($value['created_at'])); ?></span>
							<span class="tags float-right">
								<span class="badge bg-warning"><?php echo $value['kategori']; ?></span>
							</span>
						</div>
						<a href="<?= site_url('administration/document/news/hapus/' . $value['news_id']);?>" onclick="return confirm('Apakah Anda yakin hapus data di ini?')" class="btn btn-outline-danger m-3">Hapus</a>
					</div>
				</div>
			<?php } ?>
		</div>

	</div>
	<!-- Table News End -->

	<div class="row">
		<div class="col-12">
			<hr/>
				<div class="content-header">
					<span>
            <a href="#" class="btn btn-info btn-sm mb-1 mr-2" title="Tambah Berita LKPP" data-toggle="modal" data-target="#lkppForm">
              <i class="ft ft-plus"></i>
            </a>
          </span>
          <strong style="color:#29a7de">Berita LKPP</strong>
				</div>
			<hr/>
		</div>
	</div>
	<div class="row">
		<?php foreach ($get_lkpp as $value) { ?>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="card">
					<div class="card-content">
						<img class="card-img-top img-fluid" src="<?= $value['link_img'];?>" alt="img">
						<div class="card-body">
							<h4 class="card-title"><?php echo $value['link_title'];?></h4> <hr/>
							<p class="card-text"><?php echo substr($value['link_content'], 0, 120);?>...</p>
							<a href="<?php echo site_url('administration/document/news/hapus_lkpp/' . $value['id']);?>" onclick="return confirm('Apakah Anda yakin hapus data di ini?')" class="btn btn-outline-danger">Hapus</a>
							<a href="<?php echo $value['link_lanjutan'];?>" target="_blank" class="btn btn-outline-info">Selengkapnya</a>
							<p class="card-text text-muted mt-2"><?php echo date("d-m-Y H:i:s", strtotime($value['date_created'])); ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>

	<!-- Modal-news -->
	<div class="modal fade text-left" id="newsForm" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title modal-judul">Tambah Berita Baru</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
					</button>
				</div>
				<form name="formnews" action="<?= base_url('administration/submit_news'); ?>" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
					<div class="modal-body">
						<label>Kategori</label>
						<div class="form-group position-relative">
							<select class="select2 form-control" name="kategori" required>
								<option value="" selected disabled>Pilih</option>
								<option value="Internal">Internal</option>
								<option value="Eksternal">Eksternal</option>
							</select>
						</div>

						<label>Title</label>
						<div class="form-group position-relative has-icon-left">
							<input type="text" class="form-control round" name="tittle" placeholder="Masukan Judul" required>
							<div class="form-control-position">
								<i class="ft-file font-medium-2 text-muted"></i>
							</div>
						</div>
						<label>Content</label>
						<div class="form-group position-relative has-icon-left">
							<textarea rows="6" class="form-control round" name="content" placeholder="Deskripsi konten" required></textarea>
							<div class="form-control-position">
								<i class="ft-file font-medium-2 text-muted"></i>
							</div>
						</div>
						<label>Masukan Gambar (Format .jpg)</label>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-12">
										<input type="file" class="form-control-file" name="image" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
						<input type="submit" class="btn btn-info" onclick="return confirm('Apakah Anda yakin dengan data di atas?')" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal-lkpp -->
	<div class="modal fade text-left" id="lkppForm" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title modal-judul">Tambah Berita LKPP Baru</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
					</button>
				</div>
				<form name="formlkpp" action="<?php echo base_url('administration/submit_news_lkpp'); ?>" method="POST">
					<div class="modal-body">
						<label>Link Gambar</label>
						<div class="form-group position-relative has-icon-left">
							<input type="text" class="form-control round" name="link_img" placeholder="Link gambar" required>
							<div class="form-control-position">
								<i class="ft-airplay font-medium-2 text-muted"></i>
							</div>
						</div>

						<label>Deskripsi Judul</label>
						<div class="form-group position-relative has-icon-left">
							<textarea rows="6" class="form-control round" name="link_title" placeholder="Deskripsi judul" required></textarea>
							<div class="form-control-position">
								<i class="ft-clipboard font-medium-2 text-muted"></i>
							</div>
						</div>

						<label>Deskripsi Konten</label>
						<div class="form-group position-relative has-icon-left">
							<textarea rows="6" class="form-control round" name="link_content" placeholder="Deskripsi konten" required></textarea>
							<div class="form-control-position">
								<i class="ft-file-text font-medium-2 text-muted"></i>
							</div>
						</div>

						<label>Link Lanjutan</label>
						<div class="form-group position-relative has-icon-left">
							<input type="text" class="form-control round" name="link_lanjutan" placeholder="Link lanjutan" required>
							<div class="form-control-position">
								<i class="ft-link font-medium-2 text-muted"></i>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
						<input type="submit" class="btn btn-info" onclick="return confirm('Apakah Anda yakin dengan data di atas?')" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>

</section>

<script>
	$(document).ready(function() {
		var multipleRowsTable = $(".selection-multiple-rows").DataTable();
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();
		response_del();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'news') {
				if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
					toastr.info('News berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('News gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		function response_del() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'news_del') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('News berhasil dihapus.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('News gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}
	})

	function validateForm() {
		if (document.forms["formnews"]["tittle"].value == "") {
			alert("Tittle tidak boleh kosong");
			document.forms["formnews"]["tittle"].focus();
			return false;
		}
		if (document.forms["formnews"]["content"].value == "") {
			alert("Content Tidak Boleh Kosong");
			document.forms["formnews"]["content"].focus();
			return false;
		}
		if (document.forms["formnews"]["image"].value == "") {
			alert("Masukan Image");
			document.forms["formnews"]["image"].focus();
			return false;
		}
	}
</script>
