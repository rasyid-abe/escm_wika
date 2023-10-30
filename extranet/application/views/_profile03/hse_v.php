<style>
	.modal-xxl {
		max-width: 1250px;
		margin: auto;
	}
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

  .phead {
	padding: 1.5rem 1.5rem;
    color: #fff;
    border-color: #2F8BE6;
    background-color: #4698e9; }
	
</style>
<section class="bordered-striped-form-layout">
    <!-- row starts -->
    <div class="match-height">

	<div class="row" id="hasHse" style="display: none;">
		<div class="col-12 text-center">
		<img src="<?php echo base_url('assets'); ?>/app-assets/img/maintenance.png" alt="" class="img-fluid maintenance-img mt-2" height="300" width="300">
		<h1 class="mt-4">CQSMS sudah terkirim !</h1>
		<div class="maintenance-text w-75 mx-auto mt-4">
		
		</div>
	
		</div>
     </div>
		
 <!-- lampiran -->
 <div class="row" id="form_cqsms_score" style="display: none;"	>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
						<h5 class="card-title-w">Form CQSMS <?= $type ?>, <?= $cot_kelompok ?></h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
								<form action="<?= $actionPost; ?>" method="post" enctype="multipart/form-data">
								<div class="form-group row">
								<div class="col-md-9">
								<div class="form-group mb-2">
                                	<label style="font-weight: bold;">Sudah ada lampiran CQMS dari BUMN Karya ?</label>
                                	<input type="number" id="score" class="form-control" name="cqsms_score" required placeholder="Score">
                                </div>
								</div>

								<div class="col-md-3">
								<div class="form-group mb-2">
								<label style="font-weight: bold;">Unggah Dokumen</label>
                                	<div class="custom-file">
                                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="cqsms_certificate">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
									</div>
                                </div>
								</div>
								</div>
								<button type="submit" class="btn btn-primary mr-2" name="btnSaveKirim" value="kirm"><i class="ft-check-square mr-1"></i>Kirim</button>
								<!-- <button type="submit" class="btn btn-secondary mr-2" name="btnSaveSimpan" value="simpan"><i class="ft-check-square mr-1"></i>Simpan</button> -->

								</form>
                                <!-- content -->
								
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<!-- Pertanyaan -->
 <div class="row" id="form_cqsms_question" style="display: none;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
						<h5 class="card-title-w">Form CQSMS <?= $type ?>, <?= $cot_kelompok ?></h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
							<form class="needs-validation" novalidate action="<?= $actionPostPertanyaan; ?>" method="post" enctype="multipart/form-data">
                                <!-- content -->
								<?php $i = 0; $katNo =1; ?>
								<?php foreach ($hse_cat as $key => $v) : ?>
									<div class="phead">
															<h5 align="center"><?= $katNo.'. ' ?><?= $v['kategori_name'].' '.$v['persentase']. '%' ?></h5>
															</div>
<hr>
									<div class="form-group row">
								<?php $no = 1; foreach ($questionList as $question) :?>
								<?php if ($question['kategori_id'] == $v['id']) :?>
								<div class="col-md-9">
									<div class="controls form-group">
										<label style="font-weight: bold;"><?= $katNo.'.'.$no ?> <?= $question['pertanyaan'] ?></label>
										<!-- jawaban -->

										<div class="col-md-9">
										<?php if((int)$question['is_template'] != 1) : ?>
										<?php $jawabanNo=0; foreach ($question['jawaban'] as $answer) :?>
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input class="form-check-input" required onclick="fFilesMandatory(<?= $jawabanNo ?>,<?= $i ?>)" type="radio" name="jawaban[<?= $question['id']; ?>]" id="pertanyaan_<?= $question['id'] ?>" value="<?= $question['id'] ?>_<?= $answer['id'] ?>_<?= $jawabanNo ?>"> <?= $answer['jawaban'] ?>
												<div class="invalid-feedback">
												Please Fill The Field 
												</div>
											</label>
											

										</div>
										<?php $jawabanNo++; endforeach; ?>
										<?php else : ?>
											<input type="hidden" name="jawaban[<?= $question['id']; ?>]" value="<?= $question['id'] ?>_<?= $question['jawaban'][0]['id'] ?>"> 
										<table class="table border">
											<thead>
											<th>Tahun</th>
											<th>Klasifikasi</th>
											<th>Jumlah</th>


											</thead>
											<tbody>
												<?php for ($ik=0; $ik < 3; $ik++) : ?>
												<?php $rs = 1; foreach ($catatanKecelakaan as $key => $value) : ?>
												<tr>
													<td> <?php if($rs == 1 || $rs == 7 || $rs == 13) { ?>  <input type="text" id="tahun_kecelakaan_<?= $ik ?>" onchange="fchangeKecelakaanKerja(<?= $i ?>)" class="form-control" name="tahun_kecelakaan[]"> <?php } ?></td>
													<td><input  type="hidden" name="klasifikasi_kecelakaan[]" value="<?= $value['klasifikasi'] ?>"> <?= $value['klasifikasi'] ?></td>
													<td><input  type="text" class="form-control" name="jumlah_kecelakaan[]"></td>

												</tr>
												<?php $rs++; endforeach; ?>
												<?php endfor; ?>
											</tbody>
										</table>
										<?php endif; ?>


										<div class="form-check form-check-inline">
											
											<label class="form-check-label">
											<input type="text" style="width: 300px;" class="form-control" name="desc[<?= $question['id'] ?>]" placeholder="Deskripsi"></input>
											</label>

											<label class="form-check-label">
											<input type="text" style="width: 200px;" readonly class="form-control" placeholder="maksimal Nilai <?= $question['bobot'] ?>"></input>
											</label>

											<label class="form-check-label">
														<button type="button" class="button" data-toggle="tooltip" data-placement="right" data-html="true"  title="<?php foreach ($question['petunjuk_score'] as $key => $value) {echo "<p>Nilai <b>".$value['bobot_petunjuk']."</b> = ".$value['deskripsi']."</p>"; } ?>">Petunjuk Score</button>
											</label>

										
										</div>
										</div>
									
										
									</div>
									
								</div>
								

								<div class="col-md-3">
								<div class="form-group mb-2">
								<label style="font-weight: bold;">Unggah lampiran</label>
								<input type="file"  aria-label="file example" class="form-control" id="files_<?= $i ?>" name="cqsms_certificate[<?= $question['id'] ?>]">
								<div class="invalid-feedback">File Unggahan Tidak Boleh Kosong !</div>
                                </div>
								</div>
								<?php $i++; $no++; ?>

								<?php endif; ?>

								<?php endforeach; ?>
								
								</div>
								<?php $katNo++; endforeach; ?>

								
								<button type="submit" class="btn btn-primary mr-2" name="btnSaveKirim" id="btnSaveKirim" value="kirm"><i class="ft-check-square mr-1"></i>Kirim</button>
								</form>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- Table ends -->
</section>


<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/sweetalert2.all.min.js"></script>



<script type="text/javascript">

	$(document).ready(function() {

$('[data-toggle="popover"]').popover();
  $('[data-toggle="tooltip"]').tooltip()


	
   <?php if($hasHse) : ?>
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
				if('<?=$vendor_lengkap?>' == 'true' ){
					asking_hse();

				} else {
					data_blm_lengkap();
				}
		<?php } ?>
			
	}

	function asking_hse() {
		Swal.fire({
		title: 'WARNING',
		text: "Sudah ada lampiran CQMS dari BUMN Karya ?",
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

	function data_blm_lengkap() {
		Swal.fire({
		title: 'WARNING',
		text: "Data Blm lengkap, harap isi data terlebih dahulu",
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya',
		cancelButtonText: 'Tidak',
		backdrop: true,
		allowOutsideClick : false
		}).then((result) => {
		
		if (result.value) {
			window.open('<?= site_url() ?>' + '/home/profile','_self');
			//$("#form_cqsms_score").show();
			
		} else {
			//$("#form_cqsms_question").show();
			window.open('<?= site_url() ?>' + '/home/profile','_self');

		}
		})
	}

	

});
	

	function fFilesMandatory(param,filesId) {

		if(param == 0) {	
			$('#files_'+filesId).attr('required',true);
		} else {
			$('#files_'+filesId).attr('required',false);
		}
	}

	function fchangeKecelakaanKerja(id) {
		var val = $("#tahun_kecelakaan_0").val();
		if(val != "") $('#files_'+id).attr('required',true);
		
	}

	
	

	
	(function () {
	'use strict'

	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation')

	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
		.forEach(function (form) {
		form.addEventListener('submit', function (event) {
			if (!form.checkValidity()) {
			event.preventDefault()
			event.stopPropagation()
			}

			form.classList.add('was-validated')
		}, false)
		})
	})()

    
</script>