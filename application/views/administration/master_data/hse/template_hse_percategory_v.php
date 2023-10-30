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
					
				</div>
				<div id="gridContainer"></div>
			</div>
		</div>
	</div>
	<!-- Table ends -->
</section>

<?php $this->load->view('devextreme'); ?>

<script>
	var URL = "<?php echo base_url() ?>" + "administration/master_data/Hse/";

	$(document).ready(function() {
		<?php if ($this->session->flashdata("success") == true) { ?>
			toastr.success('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		<?php if ($this->session->flashdata("error") == true) { ?>
			toastr.error('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>
		// Row selection (multiple rows)

		var multipleRowsTable = $(".selection-multiple-rows").DataTable();

		$(".selection-multiple-rows tbody").on("click", "tr", function() {
			$(this).toggleClass("selected");
		});

		$("#row-count").on("click", function() {
			alert(
				multipleRowsTable.rows(".selected").data().length + " row(s) selected"
			);
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
</script>

<script>
	const URL = '<?= base_url() ?>administration/master_data/hse';

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


	$(document).ready(function() {
		const d = $.Deferred();
		const data = new DevExpress.data.CustomStore({
		
			load() {
				var data = <?= $cod_kelompok_list ?>;
				d.resolve(data);
				
				return d.promise();

			},
			
		});

		$("#gridContainer").dxDataGrid({
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
					dataField: "ack_id",
					visible: false,
					allowEditing: false
				},
				{     
				    caption : "Action",
					allowEditing: false, 
					width : 'auto',            
				    cellTemplate: function (container, options) {
				        var pr_number = options.data.ack_id;
						$("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?= base_url() ?>administration/master_data/hse/"+pr_number+"') class='btn bg-light-info btn-sm' target='_blank'>tambah pertanyaan</a>"))

				        .appendTo(container);
				            
				    }
				},
				{
					caption: "Nama Tipe Vendor",
					dataField: "ack_name",
					
				},
				

			],
			onToolbarPreparing: function(e) {
				e.toolbarOptions.items.unshift({
					location: "after",
					widget: "dxButton",
					options: {
						icon: "refresh",
						onClick: function(e) {
							$("#gridContainer").dxDataGrid("instance").refresh();
						}
					}
				});
			},
		});
	});
</script>
