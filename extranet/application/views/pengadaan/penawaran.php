<?php
if (isset($readonly)) {
	if ($readonly == "1") {
		$readonly = "disabled";
	} else {
		$readonly = "";
	}
} else {
	$readonly = "";
}
?>

<?php
$submit_url = "pengadaan/submitquo";
include("header_penawaran.php");
?>

<div class="row">
	<div class="col-12">
		<div class="card">

			<div class="card-header border-bottom pb-2">
				<h4 class="card-title"><?php echo $this->lang->line('Item Administrasi'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<form role="form" id="adm" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal" enctype='multipart/form-data'>
						<input type="hidden" id="section" name="section" value="adm">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 5%; text-align: center"><?php echo $this->lang->line('Nomor'); ?></th>
									<th style="width: 45%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th style="width: 15%; text-align: center"><?php echo $this->lang->line('Respon Vendor'); ?></th>
									<th style="width: 35%; text-align: center"><?php echo $this->lang->line('Lampiran'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!isset($header)) {
									$i = 1;
									foreach ($template as $row) {
										if ($row["etd_mode"] == "0") { ?>
											<tr>
												<td style="text-align: center"><?php echo $i; ?></td>
												<td><?php echo $row["etd_item"]; ?></td>
												<input type="hidden" name="desks_<?php echo $i ?>" id="desks_<?php echo $i ?>" value="<?php echo $row["etd_item"]; ?>">
												<td>
													<div class="i-checks">
														<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly ?> type="radio" id="radio_<?php echo $i; ?>" value="1" name="radio_<?php echo $i; ?>" required> <?php echo $this->lang->line('Ada'); ?>

														</label>
													</div>
													<div class="i-checks">
														<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly ?> type="radio" id="radio_<?php echo $i; ?>" value="0" name="radio_<?php echo $i; ?>"> <?php echo $this->lang->line('Tidak'); ?>

														</label>
													</div>
												</td>
												<td>
													<input id="lampiran_adm_<?php echo $i; ?>" name="lampiran_adm_<?php echo $i; ?>" type="file" class="file adm_attach" accept="<?php echo ALLOWED_EXT_FILES ?>">
													<div class="col-sm-0" style="font-size: 11px">
														<i>Max file 5 MB
															<br>
															Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
														</i>
													</div>
												</td>
											</tr>
								<?php $i++;
										}
									}
								} ?>
								<?php
								if (isset($header)) {
									$i = 1;
									foreach ($template as $row) {
										if ($row["pqt_weight"] == "") {
								?>
											<tr>
												<td style="text-align: center"><?php echo $i; ?></td>
												<td><?php echo $row["pqt_item"]; ?></td>
												<input type="hidden" name="desks_<?php echo $i ?>" id="desks_<?php echo $i ?>" value="<?php echo $row["pqt_item"]; ?>">
												<input type="hidden" name="pqtids_<?php echo $i ?>" id="pqtids_<?php echo $i ?>" value="<?php echo $row["pqt_id"]; ?>">
												<td>
													<div class="i-checks">
														<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly ?> type="radio" id="radio_<?php echo $i; ?>" value="1" name="radio_<?php echo $i; ?>" required <?php if (($row["pqt_check_vendor"] == "1")) {
																																																							echo "checked";
																																																						} ?>> <?php echo $this->lang->line('Ada'); ?>

														</label>
													</div>
													<div class="i-checks">
														<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly ?> type="radio" id="radio_<?php echo $i; ?>" value="0" name="radio_<?php echo $i; ?>" <?php if (($row["pqt_check_vendor"] == "0")) {
																																																					echo "checked";
																																																				} ?>> <?php echo $this->lang->line('Tidak Ada'); ?>

														</label>
													</div>
												</td>
												<td>
													<?php if (empty($readonly)) { ?>
														<input <?php echo $readonly ?> id="lampiran_adm_<?php echo $i; ?>" name="lampiran_adm_<?php echo $i; ?>" type="file" class="file adm_attach_1" accept="<?php echo ALLOWED_EXT_FILES ?>">
													<?php } ?>
													<div class="col-sm-0" style="font-size: 11px">
														<i>Max file 5 MB
															<br>
															Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
														</i>
													</div>

													<a target="_blank" href="<?php echo site_url('pengadaan/download/administrasi/' . $this->umum->forbidden($this->encryption->encrypt($row["pqt_attachment"]), 'enkrip')); ?>"><?php echo $row["pqt_attachment"]; ?></a>
												</td>
											</tr>
								<?php $i++;
										}
									}
								} ?>
								<input type="hidden" name="num_adm" id="num_adm" value="<?php echo $i ?>">
							</tbody>
						</table>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">

			<div class="card-header border-bottom pb-2">
				<h4 class="card-title"><?php echo $this->lang->line('Item Teknis'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<form role="form" id="teknis" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal" enctype='multipart/form-data'>
						<input type="hidden" id="section" name="section" value="teknis">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="text-align: center"><?php echo $this->lang->line('Nomor'); ?></th>
									<th style="width: 40%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('Bobot'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('Respon Vendor'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('Lampiran'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!isset($header)) {
									$i = 1;
									foreach ($template as $row) {
										if ($row["etd_mode"] == "1") { ?>
											<tr>
												<td style="text-align: center"><?php echo $i; ?></td>
												<td><?php echo $row["etd_item"]; ?></td>
												<td style="text-align: center"><?php echo $row["etd_weight"] . "%"; ?></td>
												<input type="hidden" name="desk_<?php echo $i ?>" id="desk_<?php echo $i ?>" value="<?php echo $row["etd_item"]; ?>">
												<input type="hidden" name="weight_<?php echo $i ?>" id="weight_<?php echo $i ?>" value="<?php echo $row["etd_weight"]; ?>">
												<td><input <?php echo $readonly ?> type="text" class="form-control" name="respon_<?php echo $i ?>" id="respon_<?php echo $i ?>" required></td>
												<td><input id="lampiran_tek_<?php echo $i; ?>" name="lampiran_tek_<?php echo $i; ?>" type="file" class="file tek_attach" accept="<?php echo ALLOWED_EXT_FILES ?>">
													<div class="col-sm-0" style="font-size: 11px">
														<i>Max file 5 MB
															<br>
															Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
														</i>
													</div>
												</td>
											</tr>
								<?php $i++;
										}
									}
								} ?>
								<?php
								if (isset($header)) {
									$i = 1;
									foreach ($template as $row) {
										if ($row["pqt_weight"] != "") {
								?>
											<tr>
												<td style="text-align: center"><?php echo $i; ?></td>
												<td><?php echo $row["pqt_item"]; ?></td>
												<td style="text-align: center"><?php echo $row["pqt_weight"] . "%"; ?></td>
												<input type="hidden" name="desk_<?php echo $i ?>" id="desk_<?php echo $i ?>" value="<?php echo $row["pqt_item"]; ?>">
												<input type="hidden" name="pqtid_<?php echo $i ?>" id="pqtid_<?php echo $i ?>" value="<?php echo $row["pqt_id"]; ?>">
												<td><input <?php echo $readonly ?> type="text" class="form-control" name="respon_<?php echo $i ?>" id="respon_<?php echo $i ?>" required value="<?php echo $row["pqt_vendor_desc"] ?>"></td>
												<td>
													<?php if (empty($readonly)) { ?>
														<input <?php echo $readonly ?> id="lampiran_tek_<?php echo $i; ?>" name="lampiran_tek_<?php echo $i; ?>" type="file" class="file tek_attach_1">
													<?php } ?>
													<div class="col-sm-0" style="font-size: 11px">
														<i>Max file 5 MB
															<br>
															Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
														</i>
													</div>
													<a target="_blank" href="<?php echo site_url('pengadaan/download/teknis/' . $this->umum->forbidden($this->encryption->encrypt($row["pqt_attachment"]), 'enkrip')); ?>">
														<?php echo $row["pqt_attachment"]; ?>
													</a>
												</td>
											</tr>
								<?php $i++;
										}
									}
								} ?>
								<input type="hidden" name="num_tek" id="num_tek" value="<?php echo $i ?>">
							</tbody>
						</table>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>

<?php
include("item_komersil_penawaran.php");
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-content">
				<div class="card-body text-center">
					<?php if (empty($readonly)) { ?>
						<button class="btn btn-info" type="submit" id="submitBtn"><?php echo $this->lang->line('Kirim Penawaran'); ?></button>
						<button style="display: none;" type="submit" id="submitDraftBtn" class="btn btn-info btn-outline"><?php echo $this->lang->line('Simpan Sebagai Draft'); ?></button>
						<button class="btn btn-secondary" id="backBtn"><?php echo $this->lang->line('Kembali'); ?></button>
					<?php } else { ?>
						<button class="btn btn-secondary" id="backBtn"><?php echo $this->lang->line('Kembali'); ?></button>
					<?php } ?>
					<?php if (isset($winner)) { ?>
						<p class="text-danger mt-2" style="font-size:150%;"><?php echo $this->lang->line('Selamat, Anda dinyatakan sebagai pemenang pengadaan ini'); ?></p>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		if ($("[name='modo']").val() == 'insert' || $("[name='submitStatus']").val() == 'draft') {
			$('#submitDraftBtn').css('display', 'inline');;
		}

		var total_adm_attach = $('.adm_attach').length;
		var i;
		for (i = 1; i <= total_adm_attach; i++) {
			$('#lampiran_adm_' + i).bind('change', function(event) {
				var ext = $(this).val().split('.').pop().toLowerCase();
				var files = event.target.files;

				if (files[0].size > 5242880) {
					$(this).val('');
					alert('File tidak boleh lebih dari 5MB');
				} else if ($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
					$(this).val('');
					alert('Format file tidak sesuai');
				}
			});
		}

		var total_adm_attach_1 = $('.adm_attach_1').length;
		var i;
		for (i = 1; i <= total_adm_attach_1; i++) {
			$('#lampiran_adm_' + i).bind('change', function(event) {
				var ext = $(this).val().split('.').pop().toLowerCase();
				var files = event.target.files;

				if (files[0].size > 5242880) {
					$(this).val('');
					alert('File tidak boleh lebih dari 5MB');
				} else if ($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
					$(this).val('');
					alert('Format file tidak sesuai');
				}
			});
		}

		var total_tek_attach = $('.tek_attach').length;
		var i;
		for (i = 1; i <= total_tek_attach; i++) {
			$('#lampiran_tek_' + i).bind('change', function(event) {
				var ext = $(this).val().split('.').pop().toLowerCase();
				var files = event.target.files;

				if (files[0].size > 5242880) {
					$(this).val('');
					alert('File tidak boleh lebih dari 5MB');
				} else if ($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
					$(this).val('');
					alert('Format file tidak sesuai');
				}
			});
		}

		var total_tek_attach_1 = $('.tek_attach_1').length;
		var i;
		for (i = 1; i <= total_tek_attach_1; i++) {
			$('#lampiran_tek_' + i).bind('change', function(event) {
				$('#error_msg_' + i).remove();
				var ext = $(this).val().split('.').pop().toLowerCase();
				var files = event.target.files;

				if (files[0].size > 5242880) {
					$(this).val('');
					alert('File tidak boleh lebih dari 5MB');
				} else if ($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
					$(this).val('');
					alert('Format file tidak sesuai');
				}
			});
		}

		$("#backBtn").click(function() {
			window.history.back();
		});

		var cur = "Rp";
		set_field_ontipepenawaran();

		// $('#bid_bond').focus();
		$('#bid_bond').blur();

		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});

		$('#selesai .input-group.date').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			startDate: '+1d',
			format: "yyyy-mm-dd"
		});

		//Ubah Blocked Item Komersial Field
		$('#tipepenawaran').change(function() {
			set_field_ontipepenawaran();
		});

		//Ubah Mata Uang
		$('#currency').change(function() {
			var kurs = $('#currency').val();
			var total = $("#totalss").text();
			total = total.split(" ");
			var subtotal = $("#subtotalss").text();
			subtotal = subtotal.split(" ");
			var ppn = $("#ppnss").text();
			ppn = ppn.split(" ");
			$("#totalss").text(kurs + " " + total[1]);
			$("#subtotalss").text(kurs + " " + subtotal[1]);
			$("#ppnss").text(kurs + " " + ppn[1]);
		});

		$("#adm").validate({
			// the errorPlacement has to take the table layout into account
			errorPlacement: function(error, element) {
				error.appendTo(element.parent().parent().parent().next());
			}
		});


		$("#backBtn").click(function() {
			window.history.back();
		});



		$("#submitBtn").click(function() {
			submit("1");
		})

		//simpan sebagai draft
		$("#submitDraftBtn").click(function() {
			submit("2")
		})

		function submit(status) {

			if (status == 2) {
				$("[name='submitStatus']").val('draft');
			} else {
				$("[name='submitStatus']").val('permanent');
			}

			//validate scroll to field
			var scrollme
			$('input[name^="respon_"]').each(function() {
				var respon = $(this).val();
				if (respon == "") {
					scrollme = 1
				} else {
					scrollme = 0
				}
			});
			var num_adm = $('#num_adm').val() - 1;
			var radios = 0
			var total = 0
			for (i = 1; i <= num_adm; i++) {
				a = i;
				i = a;
				radios = $('input[name=radio_' + i + ']:checked').val();
				radios *= radios
			}
			total = radios

			var np = $("#nopenawaran").val();
			var tp = $("#tipepenawaran").val();
			var gt = $("#garansi_t").val();
			var pt = $("#penyerahan_t").val();
			var bh = $("#berlakuhingga").val();
			var lp = $("#lampiran_penawaran").val();

			if ((lp == "" && $("#modo").val() != "edit") || np == "" || tp == "" || pt == "" || bh == "") {
				scroll_header()
			} else if (isNaN(total)) {
				scroll_adm()
			} else if (scrollme == 1) {
				scroll_teknis()
			}

			//end validate

			//Submit All Form
			if ($("#header").validate().form() && $("#adm").validate().form() &&
				$("#bidbond").validate().form() && $("#teknis").validate().form() &&
				$("#komersial").validate().form()) {
				button_disabled();

				$("#header").ajaxSubmit({
					success: function(msg) {
						if (msg == "1") {

							$("#bidbond").ajaxSubmit({
								success: function(msg) {

								},
								error: function() {
									swal("Error", "<?php echo $this->lang->line('Pesan-0 : Data Gagal Disimpan'); ?>", "error");
									button_enabled();
								}
							});

							$("#adm").ajaxSubmit({
								success: function(msg) {
									$("#teknis").ajaxSubmit({
										success: function(msg) {
											$("#komersial").ajaxSubmit({
												success: function(msg) {
													$("#detail_item").ajaxSubmit({
														error: function() {
															swal("Error", "<?php echo $this->lang->line('Data detail item sumberdaya Gagal Disimpan'); ?>", "error");
															button_enabled();
														}
													})
													if (msg == "2a") {
														swal("Error", "<?php echo $this->lang->line('Data Header gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														redirect("/home");
													} else if (msg == "3a") {
														swal("Error", "<?php echo $this->lang->line('Data Administrasi gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													} else if (msg == "4a") {
														swal("Error", "<?php echo $this->lang->line('Data Teknis gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													} else if (msg == "5a") {
														swal("Error", "<?php echo $this->lang->line('Gagal Update Status Vendor. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													} else if (msg == "6a") {
														swal("Error", "<?php echo $this->lang->line('Data Komersial gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													} else if (msg == "9z") {
														swal("Error", "<?php echo $this->lang->line('Data expired bos gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													} else if ($.isNumeric(msg)) {
														if (status == 1) {
															swal({
																	title: "<?php echo $this->lang->line('Selamat, Penawaran Anda Berhasil Dikirim'); ?>",
																	type: "success"
																},
																function() {
																	window.location.assign('<?php echo site_url(); ?>');
																});
														} else if (status == 2) {
															swal({
																	title: "<?php echo $this->lang->line('Data Berhasil Disimpan'); ?>",
																	type: "success"
																},
																function() {
																	window.location.assign('<?php echo site_url(); ?>');
																});
														}

													}
												},
												error: function() {
													swal("Error", "<?php echo $this->lang->line('Pesan-1 : Data Gagal Disimpan'); ?>", "error");
													button_enabled();
												}
											});
										},
										error: function() {
											swal("Error", "<?php echo $this->lang->line('Pesan-2 : Data Gagal Disimpan'); ?>", "error");
											button_enabled();
										}
									});
								},
								error: function() {
									swal("Error", "<?php echo $this->lang->line('Pesan-3 : Data Gagal Disimpan'); ?>", "error");
									button_enabled();
								}
							});
						} else {
							if (msg.substring(0, 3) == "<p>") {
								msg = msg.replace("<p>", "");
								msg = msg.replace("</p>", "");
								swal("Error", msg, "error");
								button_enabled();
							} else {
								swal("Error", "<?php echo $this->lang->line('Pesan-4 : Data Gagal Disimpan'); ?>", "error");
								button_enabled();
							}
						}
					},
					error: function() {
						swal("Error", "<?php echo $this->lang->line('Pesan-5 : Data Gagal Disimpan'); ?>", "error");
						button_enabled();
					}
				});
			}
		};
	});

	function fnChange(id, param) {
		var check = "_" + id;
		if (id == "") {
			check = "";
		}

		var cur = $('#currency').val() + " ";
		var current_val = parseFloat(accounting.unformat($("#" + param + check).val()));
		var nonformat = current_val;
		var format = accounting.formatNumber(current_val, 2, ",");


		$("#" + param + check).val(format);
		$("#" + param + check + "_input").val(nonformat);

		if (param == "qty" || param == "price") {
			//Ubah Total Per Item
			var total = $("#qty" + check + "_input").val() * $("#price" + check + "_input").val();
			var format = accounting.formatNumber(total, 2, ",");
			$("#total" + check).val(format);

			//Ubah Total Sebelum PPN
			var num = parseInt($('#num_item').val()) - 1;
			var subtotal = 0;
			//var totalpajak = 0;
			var subppn = 0;
			var subpph = 0;

			for (i = 1; i <= num; i++) {
				subtotal = subtotal + parseFloat(accounting.unformat($("#total_" + i).val()));
				//totalpajak = totalpajak + parseFloat(accounting.unformat($("#total_"+i).val())*$("#tax_"+i).val());
				subppn = subppn + parseFloat(accounting.unformat($("#total_" + i).val()) * $("#taxppn_" + i).val());
				subpph = subpph + parseFloat(accounting.unformat($("#total_" + i).val()) * $("#taxpph_" + i).val());
			}
			$("#totalss").text(cur + accounting.formatNumber(subtotal, 2, ","));

			$("#subtotalss").text(cur + accounting.formatNumber(subtotal + subpph + subppn, 2, ","));
			//$("#ppnss").text(cur+accounting.formatNumber(totalpajak, 2, ","));
			$("#totalppn").text(cur + accounting.formatNumber(subppn, 2, ","));
			$("#totalpph").text(cur + accounting.formatNumber(subpph, 2, ","));

		}
	}

	function set_field_ontipepenawaran() {
		var tipe = $('#tipepenawaran').val();
		var num = parseInt($('#num_item').val()) - 1;
		if (tipe == 'A') {
			for (i = 1; i <= num; i++) {
				a = i;
				$("#desc_" + i).val($("#desc_" + i + "_temp").val());
				$("#qty_" + i).val($("#qty_" + i + "_temp").val());
				$("#qty_" + i + "_input").val($("#qty_" + i + "_temp").val());
				$("#total_" + i).val("");
				$("#desc_" + i).attr("readonly", true);
				$("#qty_" + i).attr("readonly", true);
				// $("#price_"+i).focus();
				$("#price_" + i).blur();
				i = a;
			}
		} else if (tipe == 'B') {
			for (i = 1; i <= num; i++) {
				a = i;
				if ($("#modo").val() != "edit") {
					$("#desc_" + i).val("");
				}
				$("#desc_" + i).attr("readonly", false);
				$("#qty_" + i).val($("#qty_" + i + "_temp").val());
				$("#qty_" + i + "_input").val($("#qty_" + i + "_temp").val());
				$("#qty_" + i).attr("readonly", true);
				$("#total_" + i).val("");
				// $("#price_"+i).focus();
				$("#price_" + i).blur();
				i = a;
			}
		} else if (tipe == 'C') {
			for (i = 1; i <= num; i++) {
				a = i;
				if ($("#modo").val() != "edit") {
					$("#desc_" + i).val("");
					$("#qty_" + i).val("");
				}
				$("#qty_" + i + "_input").val(0);
				$("#total_" + i).val("");
				$("#desc_" + i).attr("readonly", false);
				$("#qty_" + i).attr("readonly", false);
				// $("#price_"+i).focus();
				$("#price_" + i).blur();
				i = a;
			}
		}
	}

	function button_disabled() {
		$("#submitBtn").prop("disabled", true);
		$("#backBtn").prop("disabled", true);
		$("#submitBtn").text("<?php echo $this->lang->line('Sedang Mengirim Penawaran'); ?>...");
		$('#submitDraftBtn').css('display', 'none');
	}

	function button_enabled() {
		$("#submitBtn").prop("disabled", false);
		$("#backBtn").prop("disabled", false);
		$("#submitBtn").text("<?php echo $this->lang->line('Kirim Penawaran'); ?>");
		if ($('#modo').val() == 'insert') {
			$('#submitDraftBtn').css('display', 'inline');
		}
	}

	function scroll_header() {
		$('html, body').animate({
			scrollTop: $("#header").offset().top
		}, 1000);
	}

	function scroll_adm() {
		$('html, body').animate({
			scrollTop: $("#adm").offset().top
		}, 1000);
	}

	function scroll_teknis() {
		$('html, body').animate({
			scrollTop: $("#teknis").offset().top
		}, 1000);
	}
</script>