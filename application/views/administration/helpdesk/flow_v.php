<section class="users-list-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<a href="#" class="btn btn-info btn-sm mb-3" data-toggle="modal" data-target="#dokForm"><i class="ft ft-plus"></i> Tambah Dokumen</a>
						<div class="card-body">
							<div class="row">
								<?php foreach ($get_list as $value) { ?>
									<div class="col-md-4 col-sm-12 text-center">
										<h5 class="text-bold-400 text-uppercase"><a href="<?php echo base_url('administration/helpdesk/flow/delete_flow/' . $value['id']); ?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')" class="btn bg-light-danger btn-sm"><i class="ft ft-trash"></i></a>&nbsp; <?php echo $value['kategori']; ?></h5>
										<a href="<?php echo base_url('log/download_attachment/administration/' . $value['lampiran']); ?>" target="_blank"><i class="ft ft-file-text text-info" style="font-size:80px"></i></a>
										<div class="mb-3">
											<h5><span><?php echo $value['judul']; ?></span></h5>
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
				<h3 class="modal-title modal-judul">Tambah Flow Baru</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form name="formticket" action="<?php echo base_url('administration/helpdesk/flow/add_flow'); ?>" method="POST" enctype="multipart/form-data">
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
							<?php $curval = (isset($v['ppd_file_name'])) ? $v['ppd_file_name'] :  set_value("doc_attachment_inp[]"); ?>
							<div class="input-group align-items-center">
								<span class="input-group-btn">
									<button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo $dir ?>" data-preview="preview_file_" class="btn btn-sm btn-info upload">
										<i class="fa fa-cloud-upload"></i> Upload
									</button>
									<button type="button" data-url="<?php echo site_url('log/download_attachment/administration/' . $curval) ?>" class="btn btn-sm btn-info preview_upload mr-1" id="preview_file_">
										<i class="fa fa-share"></i> Preview
									</button>
								</span>
								<input readonly type="text" class="form-control" id="doc_attachment_inp_" name="lampiran_flow" value="<?php echo $curval ?>">
								<span class="input-group-btn">
									<button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo $dir ?>" data-preview="preview_file_" class="btn btn-sm btn-danger removefile ml-1">
										<i class="fa fa-trash"></i>
									</button>
								</span>
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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'flow') {
				if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
					toastr.info('Dokumen berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Dokumen gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}

			if ('<?php echo $this->session->flashdata('tab') ?>' == 'flow_del') {
				if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
					toastr.info('Dokumen berhasil dihapus.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Dokumen gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>