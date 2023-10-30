<?php $this->load->view("_profile01/_header.php") ?>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets'); ?>/app-assets/vendors/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets'); ?>/app-assets/vendors/css/datatables/dataTables.bootstrap4.min.css">

<section class="bordered-striped-form-layout">
    <!-- row starts -->
    <div class="match-height">

	<div class="row" id="hasHse" style="display: none;">
		<div class="col-12 text-center">
		<img src="<?php echo site_url('assets'); ?>/app-assets/img/maintenance.png" alt="" class="img-fluid maintenance-img mt-2" height="300" width="300">
		<h1 class="mt-4">Vsi sudah input !</h1>
		<div class="maintenance-text w-75 mx-auto mt-4">
		
		</div>
	
		</div>
     </div>
<form action="<?= $actionPostPertanyaan; ?>" method="post" enctype="multipart/form-data">
<?php foreach($questionType as $typeValue) : ?>
	<div class="row" id="form_cqsms_question">
				<input type="hidden" id="vsi_type" name="vsi_type[]">/
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title-w"></h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
							
                                <!-- content -->
								<div class="form-group row">
								<?php foreach ($questionList as $question) :?>
								<div class="col-md-9">
									<div class="form-group mb-2">
										<label style="font-weight: bold;"><?= $question['pertanyaan'] ?></label>
										<!-- jawaban -->
										<div class="col-md-12">
										<?php foreach ($question['jawaban'] as $answer) :?>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input required class="form-check-input" type="radio" name="jawaban[<?= $question['pertanyaan_id']; ?>]" id="pertanyaan_<?= $question['pertanyaan_id'] ?>" value="<?= $question['pertanyaan_id'] ?>_<?= $answer['id'] ?>_<?= $answer['score'] ?>"> <?= $answer['jawaban'] ?>
											</label>
										
										</div>
										<?php endforeach; ?>
										<!-- <div class="form-check form-check-inline">
											
											<label class="form-check-label">
											<input type="text" class="form-control" name="desc[]" placeholder="Deskripsi"></input>
											</label>
										
										</div> -->
										</div>
									
										
									</div>
									
								</div>
								

								<div class="col-md-3">
								<div class="form-group mb-2">
								<label style="font-weight: bold;">Unggah Sertifikat</label>
								<input type="file" class="" id="cqsms_certificate_" name="cqsms_certificate[]">
                                </div>
								</div>
								<?php endforeach; ?>
								
								</div>
								
							
                                

                            </div>
                        </div>
                    </div>
                </div>
    	</div>
		
<?php endforeach; ?>
<!-- Pertanyaan -->
<button type="submit" class="btn btn-primary mr-2" name="btnSaveKirim" value="kirm"><i class="ft-check-square mr-1"></i>Kirim</button>
</form>
    </div>
    <!-- Table ends -->
</section>


<?php $this->load->view("_profile01/_footer.php") ?>
<script src="<?php echo site_url('assets') ?>/app-assets/vendors/js/sweetalert2.all.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        
       <?php if($vendorHasInput) : ?>
		$("#hasHse").show();
	    <?php else : ?>
			response_data();
		<?php endif; ?>


		
		function response_data() {
			
			<?php if ( $this->session->flashdata('success') == true ) { ?>
				toastr.info('<?php echo $this->session->flashdata('success') ?>', '<i class="ft ft-check-square"></i> Success!');
				

			<?php } else if ( $this->session->flashdata('error') == true ) { ?>
				toastr.error('<?php echo $this->session->flashdata('error') ?>', '<i class="ft ft-check-square"></i> Error!');
			<?php } else { ?>
					//asking_hse();
			<?php } ?>
				
		}

        function asking_hse() {
			Swal.fire({
			title: 'WARNING',
			text: "Sudah ada sertifikat CQMS dari BUMN Karya ?",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Ada!',
			cancelButtonText: 'Tidak',
			backdrop: true,
			allowOutsideClick : false
			}).then((result) => {
			
			if (result.value) {
				$("#form_cqsms_score").show();
				
			} else {
				$("#form_cqsms_question").show();

			}
			})
		}

    })
</script>