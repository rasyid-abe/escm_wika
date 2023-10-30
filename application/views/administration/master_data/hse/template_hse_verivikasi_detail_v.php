
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
</style>
<section class="users-list-wrapper">
	<!-- Table starts -->
	<div class="users-list-table">
		<div class="row">
			<div class="col-12">
			<?php if(count($hseData) > 0 ) : ?>
			
							<div class="tab-pane" id="verifikasi_hse" role="tabpanel" aria-labelledby="verifikasi_hse-tab">
								
								<?php if($hseData['header']['cqsms_type'] == 1) : ?>
									<form id="formHse" action="<?= base_url() ?>Hse/post_hse_certificate" method="post" enctype="multipart/form-data">
									<input type="hidden" id="hseType" name="hseType" value="0">
									<input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">
									<input type="hidden" id="trx_h_id" name="trx_h_id" value="<?= $hseData['header']['id'] ?>">
									<input type="hidden" id="hseStatus" name="hseStatus" value="">
									<input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">

										<div class="form-group row">
											<div class="col-md-9">
												<div class="form-group mb-2">
													<label style="font-weight: bold;">SCORE</label>
													<input type="number" readonly id="cqsms_score" class="form-control" value="<?= $hseData['header']['cqsms_total_score'] ?>" name="cqsms_score" required placeholder="Score">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group mb-2">
												<label style="font-weight: bold;">Lampiran</label>
												<a href="<?= base_url() ?>extranet/attachment/vendor/CQSMS_<?= $hseData['header']['vendor_id'] ?>/<?= $hseData['detail'][0]['sertifikat'] ?>" target="_blank" class="form-control" >Unduh Lampiran</a>
											</div>
										</div>

										<?php if($hseData['header']['cqsms_status'] == 1) : ?>
										<div class="col-md-3">
											<div class="form-group mb-2">
												<label style="font-weight: bold;">Status</label>
												<a target="_blank" class="form-control btn btn-info" >VERIFIED</a>
											</div>
										</div>
										<?php endif; ?>

										<?php if($hseData['header']['cqsms_status'] == 2) : ?>
										<div class="col-md-3">
											<div class="form-group mb-2">
												<label style="font-weight: bold;">Status</label>
												<a target="_blank" class="form-control btn btn-info" >REVISI</a>
											</div>
										</div>
										<?php endif; ?>

										<?php if($hseData['header']['cqsms_status'] == NULL) : ?>
											<button type="submit" class="btn btn-primary mr-2" onclick="return confirm('Apakah Anda yakin simpan data ini?')" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Verifikasi</button>
											<!-- <button type="button" class="btn btn-primary mr-2" onclick="submitHse(2)" id="btnHseRevisi" name="btnHse" value="revisi"><i class="ft-check-square mr-1"></i>Revisi</button> -->
										<?php endif; ?>	

										<?php if($hseData['header']['cqsms_status'] == 2) : ?>
											<button type="button" class="btn btn-primary mr-2" onclick="submitHse(1)" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Verifikasi</button>
										<?php endif; ?>
										
								<?php endif; ?>
								
								<?php if($hseData['header']['cqsms_type'] == 0) : ?>
									<form id="formHse" action="<?= base_url() ?>Hse/post_score" method="post" enctype="multipart/form-data">
									<input type="hidden" id="hseType" name="hseType" value="0">
									<input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">
									<input type="hidden" id="trx_h_id" name="trx_h_id" value="<?= $hseData['header']['id'] ?>">



									<div class="form-group row">
									

										<?php if($hseData['header']['cqsms_status'] == 1) : ?>
										<div class="col-md-3">
											<div class="form-group mb-2">
												<label style="font-weight: bold;">Status</label>
												<a target="_blank" class="form-control btn btn-info" >VERIFIED</a>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group mb-2">
												<label style="font-weight: bold;">Nilai</label>
												<a target="_blank" class="form-control btn btn-warning" ><?= number_format($vendor_score['score']['score'],2)  ?></a>
											</div>
										</div>
										<?php endif; ?>

										<?php if($hseData['header']['cqsms_status'] == 2) : ?>
										<div class="col-md-3">
											<div class="form-group mb-2">
												<label style="font-weight: bold;">Status</label>
												<a target="_blank" class="form-control btn btn-info" >REVISI</a>
											</div>
										</div>
										<?php endif; ?>
									</div>
									<?php $i = 0; $katNo =1; ?>
									<?php foreach ($hse_cat as $key => $v) : ?>
									<div class="panel-heading card-header" style="background-color: #29A7DE;">
															<h5 align="center"><?= $katNo.'. ' ?><?= $v['kategori_name'].' '.$v['persentase']. '%' ?></h5>
															</div>
<hr>
									<div class="form-group row">
										<?php $no = 1; foreach ($hseQuestionList as $question) :?>
										<?php if ($question['kategori_id'] == $v['id']) :?>
										<div class="col-md-6">
											<div class="form-group mb-2">
												<label style="font-weight: bold;"><?= $katNo.'.'.$no ?><?= $question['pertanyaan'] ?></label>
												<!-- jawaban -->
												<div class="col-md-9">
												<?php if((int)$question['is_template'] != 1) : ?>
													<?php foreach ($question['jawaban'] as $answer) :?>
													<div class="form-check form-check-inline">
														<label class="form-check-label">
															<input disabled <?php if(isset($hseData['detail'][$question['id']]['jawaban_id'])) { ?> <?php if($answer['id'] == $hseData['detail'][$question['id']]['jawaban_id'] ) echo "checked" ?>  <?php } ?>  class="form-check-input" type="radio" name="pertanyaan_[<?= $question['id']; ?>]" id="jawaban_<?= $answer['id'] ?>" value="<?= $question['id'] ?>_<?= $answer['id'] ?>_<?= $answer['score'] ?>"> <?= $answer['jawaban'] ?>
														</label>
													</div>
													<?php endforeach; ?>
													<?php  else : ?>
														<table class="table border">
											<thead>
											<th>Tahun</th>
											<th>Klasifikasi</th>
											<th>Jumlah</th>
											</thead>
											<tbody>
												
												<?php $rs = 1; foreach ($catatanKecelakaan as $key => $value) : ?>
												<tr>
													<td> <?php if($rs == 1 || $rs == 7 || $rs == 13) { ?>  <input type="text" readonly class="form-control" value="<?= $value['tahun'] ?>" name=""> <?php } ?></td>
													<td> <?= $value['klasifikasi'] ?></td>
													<td><input type="text" readonly class="form-control"value="<?= $value['jawaban'] ?>"></td>

												</tr>
												<?php $rs++; endforeach; ?>
												
											</tbody>
										</table>
													<?php  endif; ?>
													<div class="form-check form-check-inline">
											
														<label class="form-check-label">
														<input type="text" readonly style="width: 300px;" value="<?=$hseData['detail'][$question['id']]['notes'] ?>" class="form-control" placeholder="Deskripsi"></input>
														</label>
                                                        
													</div>
												</div>
											</div>											
										</div>	

										<div class="col-md-2">
										<label style="font-weight: bold;">Score</label>
										<select name="score[<?= $hseData['detail'][$question['id']]['trx_h_detail_id'] ?>]"  required  class="form-control" >
										<option value=""></option>

											<?php foreach ($question['petunjuk_score'] as $key => $value) : ?>
												<option <?php if($hseData['detail'][$question['id']]['answer_score'] == $value['bobot_petunjuk'] ) echo "selected"; ?> value="<?= $value['bobot_petunjuk'] ?>"><?= $value['bobot_petunjuk'] ?></option>
											<?php endforeach; ?>
										</select>
										
												<!-- <input type="number" onchange="fCompareScore(<?= $hseData['detail'][$question['id']]['trx_h_detail_id'] ?>)" required name="score[<?= $hseData['detail'][$question['id']]['trx_h_detail_id'] ?>]" style="width: 300px;" value="<?= $hseData['detail'][$question['id']]['answer_score'] ?>" id="score_<?= $hseData['detail'][$question['id']]['trx_h_detail_id'] ?>" class="form-control" placeholder="Max Score <?= $hseData['detail'][$question['id']]['bobot'] ;?>"></input>
												<input type="hidden" id="max_score_<?= $hseData['detail'][$question['id']]['trx_h_detail_id'] ?>" name="max_score[<?= $hseData['detail'][$question['id']]['trx_h_detail_id'] ?>]" style="width: 300px;" value="<?= $hseData['detail'][$question['id']]['bobot'] ?>" class="form-control" placeholder="Max Score <?= $hseData['detail'][$question['id']]['bobot'] ;?>"></input> -->
										
										</div>
										<div class="col-md-2">
										<label class="form-check-label" style="margin-top: 19px;">
														<button type="button" class="button" data-toggle="popover" data-html="true" title="Petunjuk penilaian" data-content="<?php foreach ($question['petunjuk_score'] as $key => $value) {echo "<p>Nilai <b>".$value['bobot_petunjuk']."</b> = ".$value['deskripsi']."</p>"; } ?>">Petunjuk Score</button>
														</label>
										</div>

										<div class="col-md-2">
											<div class="form-group mb-2">
												<label style="font-weight: bold;">Lampiran</label>
												<a href="<?php if(isset($hseData['detail'][$question['id']]['sertifikat'])){ ?><?php if($hseData['detail'][$question['id']]['sertifikat'] != "-") {?> <?= base_url() ?>extranet/attachment/vendor/CQSMS_<?= $hseData['header']['vendor_id'] ?>/<?= $hseData['detail'][$question['id']]['sertifikat'] ?> <?php } } ?>" target="_blank" class="form-control" >Unduh Lampiran</a>
											</div>
										</div>
										<?php $i++; $no++;  ?>
										<?php endif; ?>
										<?php endforeach; ?>
										
									</div>
									<div class="form-group row">
									<div class="col-12">
										<table class="table">
										<thead>
											<th>SubTotal <?= $v['kategori_name']; ?></th>
											<th>Persentase</th>
											<th>Nilai</th>

										</thead>
										<tbody>
										<?php foreach ($vendor_score['sub_score_category'] as $key => $value) : ?>
										<?php if($value['kategori_id'] == $v['id']) : ?>
										<tr>
											<td><?= number_format($value['sub_total'],2); ?></td>
											<td><?= number_format($value['persentase']) ?>%</td>
											<td><?= number_format($value['score'],2) ?></td>
										</tr>
										<?php endif; ?>
										<?php endforeach; ?>
										</tbody>
										</table>
									</div>
									</div>
									<?php $katNo++; ?>
									<?php endforeach; ?>
										<?php if($hseData['header']['cqsms_status'] == 0 || $hseData['header']['cqsms_status'] == null) : ?>
											<button type="submit" class="btn btn-primary mr-2" onclick="return confirm('Apakah Anda yakin simpan data ini?')" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Submit</button>
										<?php endif; ?>	

										<?php if($hseData['header']['cqsms_status'] == 2) : ?>
											<button type="button" class="btn btn-primary mr-2" onclick="submitHse(1)" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Verifikasi</button>
										<?php endif; ?>									
									</form>
								<?php endif; ?>
							</div>
		
						<?php endif; ?>

			</div>
		</div>
		
	</div>
	<!-- Table ends -->
</section>

<!-- Modal ADD JAWABAN -->
<?php $this->load->view('devextreme'); ?>
<script>
	const URL = '<?= base_url() ?>administration/hse/verifikasi';

	function sendRequest(url, method = 'GET', data) {
		const d = $.Deferred();

		$.ajax(url, {
			method,
			data,
			cache: false,
			xhrFields: {
				withCredentials: true
			},
			success: function(response) {
				location.reload();
			}
		}).done((result) => {
			d.resolve(method === 'GET' ? result.data : result);
		}).fail((xhr) => {
			d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
		});

		return d.promise();
	}

	function fCompareScore (detailId) {
		var inputScore = $("#score_"+detailId).val();
		var maxScore = $("#max_score_"+detailId).val();
		
		
		if(parseInt(inputScore) > parseInt(maxScore) ){
			alert("Melebihi Maksimal Score !");
			$('#score_'+detailId).val("");
			$('#score_'+detailId).focus();
		}

	}


	$(document).ready(function() {
		$('[data-toggle="popover"]').popover();

		<?php if ($this->session->flashdata("success") == true) { ?>
			toastr.success('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		<?php if ($this->session->flashdata("error") == true) { ?>
			toastr.error('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		const d = $.Deferred();
		const data = new DevExpress.data.CustomStore({
			key: 'id',
			load() {
				var data = [];
				$.ajax({
					type: "GET",
					url: URL + '/ajax_vendor_list_hse',
					//data: "data",
					dataType: "json",
					success: function(response) {
						d.resolve(response);
					}
				});
				return d.promise();

			},
		});

		$("#gridHse").dxDataGrid({
			dataSource: data,
			showBorders: true,
			showRowLines: true,
			columnAutoWidth: true,
			allowColumnResizing: true,
			allowColumnReordering: true,
			repaintChangesOnly: true,
			editing: {
				refreshMode: 'reshape',
				mode: "form",
				allowUpdating: false,
				// allowAdding: true
			},
			filterRow: {
				visible: true,
				applyFilter: "auto"
			},
			grouping: {
				autoExpandAll: true,
			},
			headerFilter: {
				visible: true
			},
			paging: {
				pageSize: 25
			},
			groupPanel: {
				visible: true
			},
			pager: {
				showPageSizeSelector: true,
				allowedPageSizes: [25, 50, 100],
				showInfo: true
			},
			export: {
				enabled: true
			},
			columns: [{
					dataField: "id",
					visible: false,
					allowEditing: false
				},
				{     
				    caption : "Action",
					allowEditing: false,             
				    cellTemplate: function (container, options) {
				        var pr_number = options.data.id;
						if(options.data.status == '' || options.data.status == null){
							$("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?= base_url() ?>administration/hse/verifikasi/detail/"+pr_number+"') class='btn bg-light-info btn-sm' target='_blank'>Verifikasi</a>"))

				        .appendTo(container);
						}
				            
				    }
				},
				
				{
					caption: "Vendor Name",
					dataField: "vendor_name",


				},
				{
					caption: "Status",
					dataField: "status_view",
					allowEditing: false,
				},

			],

			
			onToolbarPreparing: function(e) {
				e.toolbarOptions.items.unshift({
					location: "after",
					widget: "dxButton",
					options: {
						icon: "refresh",
						onClick: function(e) {
							$("#gridHse").dxDataGrid("instance").refresh();
						}
					}
				});
			},
		});
	});
</script>
