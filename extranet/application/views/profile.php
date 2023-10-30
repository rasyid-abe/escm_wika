<style>
	.button {
	  background-color: #29A7DE; /* Green */
	  border: none;
	  color: white;
	  padding: 10px 12px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 10px;
	}

	.tooltip.show {
		opacity: 1;
	}

	.tooltip-inner {
		background-color: #29A7DE;
		box-shadow: 0px 0px 4px black;
		opacity: 1 !important;
	}

	.tooltip.bs-tooltip-right .arrow:before {
		border-right-color: #29A7DE !important;
	}

	.tooltip.bs-tooltip-left .arrow:before {
		border-left-color: #29A7DE !important;
	}

	.tooltip.bs-tooltip-bottom .arrow:before {
		border-bottom-color: #29A7DE !important;
	}

	.tooltip.bs-tooltip-top .arrow:before {
		border-top-color: #29A7DE !important;
	}
	.section-tab {
		max-height: 250px;
		padding: 1rem;
		overflow-y: auto;
		direction: ltr;
		scrollbar-color: #d4aa70 #e4e4e4;
		scrollbar-width: thin;
	}

	.section-tab::-webkit-scrollbar {
		width: 20px;
	}

	.section-tab::-webkit-scrollbar-track {
		background-color: #e4e4e4;
		border-radius: 100px;
	}

	.section-tab::-webkit-scrollbar-thumb {
		border-radius: 100px;
		border: 5px solid transparent;
		background-clip: content-box;
		background-color: #2F8BE6;
	}
</style>

<?php 
	if($get_header['vendor_type'] == 1) { 
	
		include ('view_profile/type_1.php');
		
	} elseif($get_header['vendor_type'] == 2) { 
		
		include ('view_profile/type_2.php');

	} 
?>

<!-- Modal loading -->
<div class="modal fade" id="myLoader" tabindex="-1" role="dialog" aria-labelledby="myLoaderLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<center>
					<h3 class="modal-title" id="myLoaderLabel">Loading...</h3>
				</center>
				<br />
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						<span class="sr-only">100% Complete</span>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
		$('.dataTables-example').DataTable({
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		<?php if ($must_upload) { ?>
			//	code
		<?php } ?>


		$('.file').bind('change', function(e) {
			var no = $(this).attr("data-no")
			$('.error_msg').remove();
			var ext = $(this).val().split('.').pop().toLowerCase();
			var files = e.target.files;
			console.log(files)
			// alert(files[0].size)
			if (files[0].size > 5242880) {
				$(this).val('');
				$('.error[data-no="' + no + '"]').append("<span style='color:red' class='error_msg'>file tidak boleh lebih dari 5MB <br/></span>");
			} else if ($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
				$(this).val('');
				$('.error[data-no="' + no + '"]').append("<span style='color:red' class='error_msg'>format file tidak sesuai <br/></span>");
			}
		})

		$('#upload_file_form').on('submit', function(e) {
			e.preventDefault();

			var form_data = new FormData(this);
			$.each($('.file')[0].files, function(i, file) {
				form_data.append(i, file);
			});
			$.ajax({
				url: '<?= site_url('home/submit_doc_pq') ?>',
				type: 'POST',
				data: form_data,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('#myLoader').modal('show')
					$('[type="submit"]').prop('disabled', true)
				},
				success: function(res) {
					console.log(res)
					res = JSON.parse(res)
					if (res == 'success') {
						swal({
								title: "Berhasil Menyimpan Data",
								type: "success"
							},
							function() {
								window.location.assign('<?php echo site_url(); ?>');
							});
					} else if (res == 'failed') {
						swal({
							title: "Error!",
							text: "Gagal Menyimpan Data",
							type: "error"
						});
					} else {
						swal({
							title: "Error!",
							text: "Terjadi Kesalahan Teknis",
							type: "error"
						});

					}

				},
				error: function() {
					swal({
						title: "Error!",
						text: "Terjadi Kesalahan Teknis",
						type: "error"
					});
				},
				complete: function() {
					$('#myLoader').modal('hide')
					$('[type="submit"]').prop('disabled', false)
				}
			});

		})

	});
</script>
