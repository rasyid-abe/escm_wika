<section class="users-list-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<a href="#" class="btn btn-info btn-sm mb-3" data-toggle="modal" data-target="#dokForm"><i class="ft ft-plus"></i> Tambah Video</a>						
						<div class="card-body">
							<div class="row">
								<?php foreach ($get_list as $value) { ?>
									<div class="col-md-6 col-12">
										<h5 class="text-bold-400 text-uppercase"><a href="<?php echo base_url('administration/helpdesk/video/delete_video/' . $value['id']);?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')" class="btn bg-light-danger btn-sm"><i class="ft ft-trash"></i></a>&nbsp; <?php echo $value['kategori'];?></h5>
										<video width="350" height="250" controls>
											<source src="<?php echo base_url('uploads/user_guide/' . $value['kategori'] . '/' . $value['lampiran']);?>" type="video/mp4">
										</video>
										<div class="mb-3">
											<h4><span><?php echo $value['judul'];?></span></h4>
										</div>
									</div>	
								<?php } ?>														
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade text-left" id="dokForm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title modal-judul">Tambah Video Baru</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form name="formticket" action="<?php echo base_url('administration/helpdesk/video/add_video'); ?>" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
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
						<div class="col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Judul</label>
								<input type="text" class="form-control round" name="judul" placeholder="Judul video" required>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group mb-2">
								<label class="col-form-label">Lampiran</label>
								<input type="file" class="form-control round" name="lampiran" required>
							</div>
						</div>											
					</div>
				</div>
				<div class="modal-footer">
					<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
					<input type="submit" class="btn btn-info mr-2" onclick="return confirm('Apakah Anda yakin simpan data ini?')" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'video') {
				if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
					toastr.info('Video berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Video gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}

			if ('<?php echo $this->session->flashdata('tab') ?>' == 'video_del') {
				if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
					toastr.info('Video berhasil dihapus.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Video gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>