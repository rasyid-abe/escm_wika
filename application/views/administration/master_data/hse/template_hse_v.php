<style>
	.modal-xxl {
		max-width: 1250px;
		margin: auto;
	}
</style>
<section class="users-list-wrapper">
	<!-- Table starts -->
	<div class="users-list-table">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-header text-muted">
							<span class="float-left"><a href="#" class="btn btn-info btn-sm mb-3" data-toggle="modal" data-target="#CqsmsPertanyaanModal"><i class="ft ft-plus"></i>Tambah</a></span>
							<span class="tags float-right">
							</span>
						</div>
						<div class="card-body">
						</div>

					</div>

				</div>
				<input type="hidden" id="vendor_type" value="">
				<div id="gridHse"></div>
			</div>
		</div>
	</div>
	<!-- Table ends -->
</section>

<!-- Modal -->
<div class="modal text-left" id="CqsmsPertanyaanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title modal-judul" id="CqsmsModalLabel">Tambah Pertanyaan Baru</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form id="CqmsPertanyaanForm" action="<?= base_url() ?>/administration/master_data/Hse/post_pertanyaan" method="post">
				<div class="modal-body">

				<label>Menggunakan Template kecelakaan 3 Tahun terakhir ?</label>
				<div class="form-group position-relative">
					<input type="checkbox" name="is_template" id="is_template" value="1">
				</div>

				<label>No Urut Pertanyaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="number" name="pertanyaan_order" id="pertanyaan_order" required placeholder="No urut" class="form-control">
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
				</div>

					<label>Nama Pertanyaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" name="pertanyaan" id="pertanyaan" required placeholder="pertanyaan" class="form-control">
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
							<input type="hidden" id="pertanyaan_classification" name="pertanyaan_classification" value="<?= $vendor_type ?>">
						</div>
					</div>

				

					<label>Kategori Pertanyaan </label>
					<div class="form-group position-relative has-icon-left">
						<select required id="kategori" class="form-control" name="kategori_id">
							<?php foreach ($kategori as $key => $value) : ?>
								<option value="<?= $value['id'] ?>"><?= $value['kategori_name'] ?></option>
							<?php endforeach; ?>
						</select>
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
					</div>

					<label>Bobot Maksimal Pertanyaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="number" id="" required name="bobot" placeholder="Maksimal" class="form-control">
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
					</div>
					<hr>
					<label>Nilai Petunjuk skor Pertanyaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="number" id="petunjuk_skor_nilai" name="" placeholder="" class="form-control">
					</textarea>
					<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
					</div>

					<label>Deskripsi Petunjuk skor Pertanyaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" id="petunjuk_skor_deskripsi" name="" placeholder="" class="form-control">
					</textarea>
					<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
						<div class="modal-footer">
						
						<input type="button" class="btn btn-info" id="btnTambahPetunjukScore" value="Tambah">
					</div>
	
					</div>
					<div class="form-group row">
							<div class="col-md-12">
							<table class="table table-bordered" id="item_table">
							<thead>
								<tr>
								<th>#</th>
								<th>Nilai</th>
								<th>Deskripsi</th>
								</tr>
							</thead>
							<tbody id="i_body_item">

							</tbody>
							</table>
							</div>

					
					</div>

					<div class="modal-footer">
						<input type="reset" onclick="clearPertanyaanModal()" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
						<input type="submit" class="btn btn-info" id="btnSimpanPertanyaan" value="Simpan">
					</div>

				</div>
		</div>

		</form>
	</div>
</div>
</div>



<!-- Modal ADD JAWABAN -->
<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/sweetalert2.all.min.js"></script>
<?php $this->load->view('devextreme'); ?>

<script>
	var URL = "<?php echo base_url() ?>" + "administration/master_data/Hse/";

	$(document.body).on("click",".edit_item",function(){
  
		//cek_group();

		$(this).parent().parent().remove();
		
		//set_total();

		return false;

	});


	$(document).ready(function() {
		<?php if ($this->session->flashdata("success") == true) { ?>
			toastr.success('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		<?php if ($this->session->flashdata("error") == true) { ?>
			toastr.error('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>
		

		$("#btnTambahPetunjukScore").click(function (e) { 
			
			e.preventDefault();
			var no =1;
			var nilai = $("#petunjuk_skor_nilai").val();
			var deskripsi = $("#petunjuk_skor_deskripsi").val();


			
			if(nilai ==  "" || deskripsi == '') {
				alert("Nilai Atau petunjuk tidak boleh 0");
				return false;
			}

		
			var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
			html += "<td><input type='hidden' class='kode_item' data-no='"+no+"' name='petunjuk_score_nilai[]' value='"+nilai+"'/>"+nilai+"</td>";
			html += "<td><input type='hidden' class='tipe_item' data-no='"+no+"' name='petunjuk_score_deskripsi[]' value='"+deskripsi+"'/>"+deskripsi+"</td>";			
			
			html += "</tr>";
			$("#item_table").append(html);
			clearItem();
		});


		$("#btnSave").click(function(e) {
			e.preventDefault();
			var pertanyaan = $("#pertanyaan").val();
			var pertanyaan_kategori = $("#kategori").val();

			$(this).attr('disabled', true);

			$.ajax({
				type: "POST",
				url: URL + "/post_pertanyaan",
				data: {
					pertanyaan: pertanyaan,
					pertanyaan_kategori: pertanyaan_kategori
				},
				dataType: "json",
				success: function(response) {
					if (response.code == 200) {
						clearPertanyaanModal();
						toastr.success('Notification !', response.message);
						$("#CqsmsPertanyaanModal").modal('hide');
						window.location.href = URL
					} else {
						toastr.error('Notification !', response.message);
					}
					$(this).attr('disabled', false);
				}
			});
		});

		$("#btnJawabanSave").click(function(e) {
			e.preventDefault();
			var pertanyaan_id = $("#jawaban_pertanyaan_id").val();
			var jawaban = $("#jawaban").val();
			var jawaban_id = $("#jawaban_id").val();

			var score = $("#score").val();

			$(this).attr('disabled', true);
			if ($("#btnJawabanSave").val() == 'Simpan') {
				$.ajax({
					type: "POST",
					url: URL + "post_jawaban",
					data: {
						pertanyaan_id: pertanyaan_id,
						jawaban: jawaban,
						score: score
					},
					dataType: "json",
					success: function(response) {
						if (response.code == 200) {
							clearPertanyaanModal();
							toastr.success('Notification !', response.message);
							$("#CqsmsPertanyaanModal").modal('hide');
							window.location.href = URL
						} else {
							toastr.error('Notification !', response.message);
						}
						$(this).attr('disabled', false);
					}
				});

			} else {
				$.ajax({
					type: "POST",
					url: URL + "put_jawaban",
					data: {
						jawaban_id: jawaban_id,
						pertanyaan_id: pertanyaan_id,
						jawaban: jawaban,
						score: score
					},
					dataType: "json",
					success: function(response) {
						if (response.code == 200) {
							clearPertanyaanModal();
							toastr.success('Notification !', response.message);
							$("#CqsmsPertanyaanModal").modal('hide');
							window.location.href = URL
						} else {
							toastr.error('Notification !', response.message);
						}
						$(this).attr('disabled', false);
					}
				});
			}

		});

		$("#btnEdit").click(function(e) {
			e.preventDefault();
			var pertanyaan_id = $("#pertanyaan_id").val();
			var pertanyaan = $("#pertanyaan_edit").val();
			var pertanyaan_type = $("#pertanyaan_type_edit").val();
			var pertanyaan_classification = $("#pertanyaan_classification_edit").val();

			$(this).attr('disabled', true);

			$.ajax({
				type: "POST",
				url: URL + "put_pertanyaan",
				data: {
					pertanyaan_id: pertanyaan_id,
					pertanyaan: pertanyaan,
					pertanyaan_type: pertanyaan_type,
					pertanyaan_classification: pertanyaan_classification
				},
				dataType: "json",
				success: function(response) {
					if (response.code == 200) {
						clearPertanyaanModal();
						toastr.success('Notification !', response.message);
						$("#CqsmsPertanyaanModal").modal('hide');
						window.location.href = URL
					} else {
						toastr.error('Notification !', response.message);
					}
					$(this).attr('disabled', false);
				}
			});

		});
	});

	function fDelete(id) {
		$.ajax({
			type: "POST",
			url: URL + 'delete_pertanyaan/',
			data: {
				id: id
			},
			dataType: "json",
			success: function(response) {
				console.log(response);
				if (response.code == 200) {

					toastr.success('NOTIFICATION !', response.message);

					window.location.href = URL
				} else {
					toastr.error('Notification !', response.message);
				}

			}
		});
	}

	function fEdit(pertanyaanId, pertanyaan, kategori_id) {
		$("#pertanyaan_id").val(pertanyaanId);
		$("#pertanyaan_edit").val(pertanyaan);
		$("#kategori_edit").val(kategori_id);

		$('#btnEdit').attr('disabled', false);
		$("#CqsmsPertanyaanEditModal").modal('show');
	}

	function fNonActive(pertanyaanId, pertanyaan, pertanyaan_type, pertanyaan_classification, pertanyaan_is_active) {
		$.ajax({
			type: "POST",
			url: URL + "put_pertanyaan",
			data: {
				pertanyaan_id: pertanyaanId,
				pertanyaan: pertanyaan,
				pertanyaan_type: pertanyaan_type,
				pertanyaan_classification: pertanyaan_classification,
				pertanyaan_is_active: pertanyaan_is_active
			},
			dataType: "json",
			success: function(response) {
				if (response.code == 200) {
					clearPertanyaanModal();
					toastr.success('Notification !', response.message);
					$("#CqsmsPertanyaanModal").modal('hide');
					window.location.href = URL
				} else {
					toastr.error('Notification !', response.message);
				}
				$(this).attr('disabled', false);
			}
		});
	}

	function clearPertanyaanModal() {
		var pertanyaan = $("#pertanyaan").val("");
	}

	function clearJawabanModal() {
		$("#jawaban").val("");
		$("#score").val("");

	}

	function fTambahJawaban(id) {
		$("#jawaban_pertanyaan_id").val(id);
		$("#CqsmsJawabanModalLabel").text('Tambah Jawaban');
		$("#btnJawabanSave").val('Simpan')

		$("#CqsmsJawabanModal").modal('show');
	}

	function fEditJawaban(id, pertanyaan_id, jawaban, score) {
		$("#CqsmsJawabanModalLabel").text('Edit Jawaban');

		$("#jawaban_pertanyaan_id").val(pertanyaan_id);
		$("#jawaban_id").val(id);
		$("#jawaban").val(jawaban);

		$("#score").val(score);
		$("#btnJawabanSave").val('Edit');

		$("#CqsmsJawabanModal").modal('show');
	}

	function fDeleteJawaban(id) {
		$.ajax({
			type: "POST",
			url: URL + 'delete_jawaban/',
			data: {
				id: id
			},
			dataType: "json",
			success: function(response) {

				if (response.code == 200) {

					toastr.success('NOTIFICATION !', response.message);

					window.location.href = URL
				} else {
					toastr.error('Notification !', response.message);
				}

			}
		});
	}

	function fshowSettings(pertanyaanId, pertanyaan, pertanyaan_type, pertanyaan_classification) {

		$("#cqsms_modal_setting_pertanyaan").modal('show');
	}

	function fSaveSettings() {
		Swal.fire({
			title: 'WARNING',
			text: "Yakin Simpan  ?",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
			backdrop: true,
			allowOutsideClick: false
		}).then((result) => {
			if (result.value) {
				$("#cqsmsSettingForm").submit();

			} else {

			}
		})
	}

	function clearItem()
	{
		$('#petunjuk_skor_nilai').val("");
		$('#petunjuk_skor_deskripsi').val("");
		

	}

</script>

<script>
	const URL = '<?= base_url() ?>Hse';

	function sendRequest(url, method = 'GET', data,gridId = '') {
		const d = $.Deferred();

		$.ajax(url, {
			method,
			data,
			dataType: "json",
			cache: false,
			xhrFields: {
				withCredentials: true
			},
			success: function(response) {
				//console.log(response);
				if(response.code == 403) {
					DevExpress.ui.notify(response.message, "error", 1900);

				} else {
					DevExpress.ui.notify(response.message, "success", 1900);
					if(gridId != '') {
						$("#"+gridId).dxDataGrid("instance").refresh();
					}
					location.reload();
				}
			}
		}).done((result) => {
			d.resolve(method === 'GET' ? result.data : result);
		}).fail((xhr) => {
			d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
		});

		return d.promise();
	}


	$(document).ready(function() {
		const d = $.Deferred();
		const data = new DevExpress.data.CustomStore({
			key: 'id',
			load() {
				var data = [];
				var vendor_type = $('#vendor_type').val();
				$.ajax({
					type: "GET",
					url: URL + '/ajax_get_pertanyaan_list/' + vendor_type,
					//data: "data",
					dataType: "json",
					success: function(response) {
						d.resolve(response.data);
					}
				});
				return d.promise();

			},
			update(key, values) {
				return sendRequest(`${URL}/ajax_update_pertanyaan_list`, 'POST', {
					key,
					values: JSON.stringify(values),
				},"gridHse");
			},
			remove(key) {
				return sendRequest(`${URL}/ajax_delete_pertanyaan_list`, 'POST', {
					key,
				},"gridHse");
			},
		});

		$("#gridHse").dxDataGrid({
			dataSource: data,
			showBorders: true,
			showRowLines: true,
			columnAutoWidth: true,
			allowColumnResizing: true,
			allowColumnReordering: true,
			editing: {
				refreshMode: 'reshape',
				mode: "popup",
				allowUpdating: true,
				allowDeleting: true,

				// allowAdding: true
			},
			filterRow: {
				visible: true,
				applyFilter: "auto"
			},
			grouping: {
				autoExpandAll: false,
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
					caption: "No Urut",
					dataField: "order_no",
					width :300

				},
				// {     
				//     caption : "Action",
				// 	allowEditing: false,             
				//     cellTemplate: function (container, options) {
				//         var pr_number = options.key.id;
				//             $("<div class='btn-group'>")
				//             .append($("<a onclick=window.open('<?= base_url() ?>procurement/hps/create/"+pr_number+"') class='btn bg-light-info btn-sm' target='_blank'>Non Active</a>"))

				//         .appendTo(container);
				//     }
				// },
				{
					caption: "Kategori Name",
					dataField: "kategori_id",
					lookup: {
						dataSource: new DevExpress.data.CustomStore({
							cacheRawData: false,
							loadMode: "raw",
							load: function() {
								return $.getJSON(URL + "/ajax_getListCategory");
							}
						}),
						valueExpr: "id",
						displayExpr: "kategori_name",
						searchExpr: ['id', 'kategori_name']
					},
					groupIndex: 0
				},
				{
					caption: "Bobot Kategori",
					dataField: "persentase",
					allowEditing: false,
					visible: false,
					width : 50,
				},
				{
					caption: "Pertanyaan",
					dataField: "pertanyaan",
					width :300

				},
				{
					caption: "Nilai Tertinggi Pertanyaan",
					dataField: "bobot",
					allowEditing: true
				},

			],

			masterDetail: {
				enabled: true,
				template(container, options) {
					const data = options.data;
					const URL = '<?= base_url() ?>Hse';

					const d = $.Deferred();
					const jawabanStore = new DevExpress.data.CustomStore({
						key: 'id',
						load() {

							$.ajax({
								type: 'GET',
								url: URL + '/ajax_get_petunjuk_score/' + data.id,
								data: data,
								dataType: "json",
								success: function(response) {
									d.resolve(response);
								},
							});
							return d.promise();
						},

						insert(values) {
							return sendRequest(`${URL}/ajax_insert_petunjuk_score/`+data.id, 'POST', {
								values: JSON.stringify(values),
							},"gridHse");
						},
						
						update(key, values) {
							return sendRequest(`${URL}/ajax_update_petunjuk_score`, 'POST', {
								key,
								values: JSON.stringify(values),
							},"gridHse");
						},
						remove(key) {
							return sendRequest(`${URL}/ajax_delete_petunjuk_score`, 'POST', {
								key,
							},"gridHse");
						},
					});

					$('<div>')
						.addClass('master-detail-caption')
						.text("Petunjuk Score dari : " + data.pertanyaan)
						.appendTo(container);

					$('<div>')
						.dxDataGrid({
							dataSource: jawabanStore,
							width: 1424,
							showBorders: true,
							showRowLines: true,
							columnAutoWidth: true,
							allowColumnResizing: true,
							allowColumnReordering: true,
							editing: {
								refreshMode: 'reshape',
								mode: "form",
								allowUpdating: true,
								allowAdding: true,
								allowDeleting : true
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
									dataField: 'id',
									visible: false,
									allowEditing: false,
								},
								{
									dataField: 'pertanyaan_id',
									visible: false,
									allowEditing: false,
								},
								// {     
								// 	caption : "Action",             
								// 	cellTemplate: function (container, options) {
								// 		var hpsMainId = options.data.id;
								// 			$("<div class='btn-group'>")
								// 			.append($("<a onclick=window.open('<?= base_url() ?>procurement/hps/detail/"+hpsMainId+"') class='btn bg-light-warning btn-sm' target='_blank'><i class='ft-edit'></i></a>"))
								// 		.appendTo(container);
								// 	}
								// },
								{
									caption: 'Nilai',
									dataField: 'bobot_petunjuk',
									dataType: "number",
								},
								{
									caption: 'Deskripsi',
									dataField: 'deskripsi',
								},


							]

						}).appendTo(container);
				},
			},
			// summary: {
			//     totalItems: [{
			//         column: 'pr_number',
			//         summaryType: 'count'
			//     }],
			// },
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
