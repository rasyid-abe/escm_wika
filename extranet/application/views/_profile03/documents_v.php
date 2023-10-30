<?php $this->load->view("_profile03/_tab.php") ?>

<section class="bordered-striped-form-layout">
	<!-- row starts -->
	<div class="match-height">
		<form class="form-bordered" method="POST" action="<?php echo site_url('_api/vendor/data/download_documents'); ?>" enctype="multipart/form-data">
			<!-- info-akun -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title-w">Download all file</h5>
						</div>
						<div class="card-content">
							<div class="card-body">
								<!-- content -->
								<div class="col-lg-12 text-center my-3">
									<input type="submit" onclick="return confirm('Apakah Anda yakin ingin mendownload semua file?')" class="btn btn-info" value="Download">
								</div>
							</div>
						</div>
					</div>
				</div>
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
		$('.zero-configuration').DataTable({
			ordering: false
		});
	});

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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'utama') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '3') {
					toastr.error('Bukti upload kontrak wajib diisi.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '4') {
					toastr.error('PUSAT hanya boleh 1 alamat.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}
	})
</script>

<script>
	$(document).ready(function() {
		$('#editkontakForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('#nama_lengkap').attr("value", div.data('nama_lengkap'));
			modal.find('#jabatan').attr("value", div.data('jabatan'));
			modal.find('#email_address').attr("value", div.data('email'));
			modal.find('#no_telp').attr("value", div.data('no_telp'));
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('#editalamatForm').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('#type').val(div.data('type')).change();
			modal.find('#alamat').val(div.data('alamat'));
			modal.find('#prop').val(div.data('prop')).change();
			modal.find('#city').val(div.data('city')).change();
			modal.find('#district').val(div.data('district')).change();
			modal.find('#kode_pos').attr("value", div.data('kode_pos'));
			modal.find('#no_telp').attr("value", div.data('no_telp'));
			modal.find('#fax').attr("value", div.data('fax'));
		});
	});
</script>