<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header border-bottom pb-2">
				<h4 class="card-title"><?php echo $this->lang->line('Informasi Negosiasi'); ?></h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<table class="table">						
						<tr>
							<th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
							<td>
							<a href="<?php echo site_url('pengadaan/lihat_pengadaan/'.$this->umum->forbidden($this->encryption->encrypt($tenderid), 'enkrip'))?>" target="_blank">
							<?php echo $tenderid ?>
								
							</a>
							</td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Nomor Penawaran'); ?></th>
							<td><?php echo $header["pqm_number"] ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header border-bottom pb-2">
				<h4 class="card-title"><?php echo $this->lang->line('Riwayat Pesan Negosiasi'); ?></h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<table class="table table-striped table-bordered dataTables-example" >
						<thead>
							<tr>
								<th>No</th>
								<th><?php echo $this->lang->line('Dari'); ?></th>
								<th><?php echo $this->lang->line('Kepada'); ?></th>
								<th><?php echo $this->lang->line('Isi Pesan'); ?></th>
								<th><?php echo $this->lang->line('Tanggal'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$ii = 1;
								foreach($pesan as $row) { 
									if($row["pbm_user"] != ""){
										$dari = COMPANY_NAME;
										$ke = $this->session->userdata("nama_vendor");
										$style = "style=\"background: #e2e2e2;\"";
									}
									else{
										$ke = COMPANY_NAME;
										$dari = $this->session->userdata("nama_vendor");
										$style = "style=\"background: #ddf7df;\"";
									}
									?>
									<tr <?php echo $style ?>>
										<td><?php echo $ii; ?></td>
										<td><?php echo $dari ?></td>
										<td><?php echo $ke ?></td>
										<td><?php echo $row["pbm_message"] ?></td>
										<td><?php echo $this->umum->show_tanggal($row["pbm_date"]) ?></td>
									</tr>
									<?php
									$ii++;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if($prep['ptm_status'] == 1140) { ?>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header border-bottom pb-2">
					<h4 class="card-title"><?php echo $this->lang->line('Pesan Negosiasi'); ?></h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<p class="text-success" style="font-size:105%;"><?php echo $this->lang->line('Harap ubah rincian penawaran anda, ketika menawarkan harga baru. Klik'); ?> &nbsp;&nbsp;
						
						<button type="button" class="btn btn-outline btn-danger btn-sm mr-1" data-toggle="modal" data-target="#large">
							<?php echo $this->lang->line('Ubah Harga'); ?> 
						</button>

						<?php echo $this->lang->line('untuk mengubah harga'); ?></p>

						<form id="komentar" method="POST" action="<?php echo site_url('pengadaan/submit_nego') ?>" class="form-horizontal">	
							<input type="hidden" name="pta_id" id="pta_id" value="<?php if(isset($pesan[0]["pta_id"])) { echo $pesan[0]["pta_id"]; } else { echo "1140"; } ?>">
							<input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $tenderid ?>">
							<textarea required class="form-control" rows="5" id="comment" name="comment" placeholder="Pesan negosiasi (wajib diisi)"></textarea>
						</form>
						<div class=" text-center mt-3">
							<button class="btn btn-info" type="submit" id="submitBtn"><?php echo $this->lang->line('Kirim Negosiasi'); ?></button>
							<button class="btn btn-secondary" id="backBtn"><?php echo $this->lang->line('Kembali'); ?></button>						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } else { ?>

	<div class="row">
		<div class="col-12">
			<div class="card">				
				<div class="card-content">
					<div class="card-body text-center">
						<button class="btn btn-secondary" id="backBtn"><?php echo $this->lang->line('Kembali'); ?></button>			
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>


<!-- Modal-nego -->
<div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Negosiasi</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>

			<?php $idpick = "picker_pick_nego"; ?>
			
			<div class="modal-body">
				<?php
					if(isset($readonly)){
						if($readonly == "1"){
							$readonly = "readonly";
						}
						else{
							$readonly = "";
						}
					}
					else{
						$readonly = "";
					}
				?>
				<?php 
					$submit_url = "pengadaan/submitnegos";
					include("header_penawaran.php");
					include("item_komersil_penawaran.php");
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" id=<?php echo $idpick ?>><?php echo $this->lang->line('Simpan'); ?></button>
				<button type="button" class="btn btn-secondary" id="dismiss" data-dismiss="modal"><?php echo $this->lang->line('Keluar'); ?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var cur = "Rp";
		set_field_ontipepenawaran();
		
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
		$('#tipepenawaran').change(function(){
			set_field_ontipepenawaran();
		});
		
		//Ubah Mata Uang
		$('#currency').change(function(){
			var kurs = $('#currency').val();
			var total = $("#totalss").text();
			total = total.split(" ");
			var subtotal = $("#subtotalss").text();
			subtotal = subtotal.split(" ");
			var ppn = $("#ppnss").text();
			ppn = ppn.split(" ");
			$("#totalss").text(kurs+" "+total[1]);
			$("#subtotalss").text(kurs+" "+subtotal[1]);
			$("#ppnss").text(kurs+" "+ppn[1]);
		});
		
		$("#adm").validate({
			// the errorPlacement has to take the table layout into account
			errorPlacement: function(error, element) {
			error.appendTo(element.parent().parent().parent().next());
			}
		});	

	});

	function fnChange(id,param){
		var check = "_"+id;
		if(id == ""){
			check = "";
		}
		
		var cur = $('#currency').val()+" ";
		var current_val = parseFloat(accounting.unformat($("#"+param+check).val()));
		var nonformat = current_val;
		var format = accounting.formatNumber(current_val, 2, ",");
		
		
		$("#"+param+check).val(format);
		$("#"+param+check+"_input").val(nonformat);
	
		if(param == "qty" || param == "price"){
			//Ubah Total Per Item
			var total = $("#qty"+check+"_input").val() * $("#price"+check+"_input").val();
			var format = accounting.formatNumber(total, 2, ",");
			$("#total"+check).val(format);
			
			//Ubah Total Sebelum PPN
			var num = parseInt($('#num_item').val())-1;
			var subtotal = 0;
			var subppn = 0;
			var subpph = 0;

			for (i = 1; i <= num; i++) {
			subtotal = subtotal + parseFloat(accounting.unformat($("#total_"+i).val()));
			subppn = subppn + ((parseFloat(accounting.unformat($("#ppn_"+i).val())) * parseFloat(accounting.unformat($("#total_"+i).val())) ) / 100);
			subpph = subpph + ((parseFloat(accounting.unformat($("#pph_"+i).val())) * parseFloat(accounting.unformat($("#total_"+i).val())) ) / 100);
			}
			$("#totalss").text(cur+accounting.formatNumber(subtotal, 2, ","));
			var pajak = "<?php echo $pajak ?>";
			if(pajak == 1){
			$("#subtotalss").text(cur+accounting.formatNumber(subtotal+subpph+subppn, 2, ","));
			//$("#ppnss").text(cur+accounting.formatNumber((subpph+subppn), 2, ","));
			$("#totalppn").text(cur+accounting.formatNumber((subppn), 2, ","));
			$("#totalpph").text(cur+accounting.formatNumber((subpph), 2, ","));
			}
			else{
			$("#subtotalss").text(cur+accounting.formatNumber(subtotal, 2, ","));
			//$("#ppnss").text(cur+accounting.formatNumber(0, 2, ","));
			$("#totalppn").text(cur+accounting.formatNumber((subppn), 2, ","));
			$("#totalpph").text(cur+accounting.formatNumber((subpph), 2, ","));
			}
		}
	}
	
	function set_field_ontipepenawaran(){
		var tipe = $('#tipepenawaran').val();
		var num = parseInt($('#num_item').val())-1;
		if(tipe == 'A'){
			for (i = 1; i <= num; i++) { 
			a = i;
			$("#desc_"+i).val($("#desc_"+i+"_temp").val());
			$("#qty_"+i).val($("#qty_"+i+"_temp").val());
			$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
			$("#total_"+i).val("");
			$("#desc_"+i).attr("readonly", true);
			$("#qty_"+i).attr("readonly", true);
			$("#price_"+i).blur();
			i = a;
			}
		}
		else if(tipe == 'B'){
			for (i = 1; i <= num; i++) { 
			a = i;
			if($("#modo").val() != "edit"){
				$("#desc_"+i).val("");
			}
			$("#desc_"+i).attr("readonly", false);
			$("#qty_"+i).val($("#qty_"+i+"_temp").val());
			$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
			$("#qty_"+i).attr("readonly", true);
			$("#total_"+i).val("");
			$("#price_"+i).blur();
			i = a;
			}
		}
		else if(tipe == 'C'){
			for (i = 1; i <= num; i++) { 
			a = i;
			if($("#modo").val() != "edit"){
				$("#desc_"+i).val("");
				$("#qty_"+i).val("");
			}
			$("#qty_"+i+"_input").val(0);
			$("#total_"+i).val("");
			$("#desc_"+i).attr("readonly", false);
			$("#qty_"+i).attr("readonly", false);
			$("#price_"+i).blur();
			i = a;
			}
		}
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.dataTables-example').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});

		$("#picker_pick_nego").click(function(){

			var np = $("#nopenawaran").val();
			var tp = $("#tipepenawaran").val();
			var gt = $("#garansi_t").val();
			var pt = $("#penyerahan_t").val();
			var bh = $("#berlakuhingga").val();
			var lp = $("#lampiran_penawaran").val();

			if ((lp == "" && $("#modo").val() != "edit")  || np == "" || tp == ""  || gt == "" || pt == "" || bh == "") {
				scroll_header()
			}			

			if($("#header").validate().form() && $("#komersial").validate().form()){
				$("#header").ajaxSubmit({
					success: function(msg){
						if(msg == "1"){
							$("#bidbond").ajaxSubmit({
								success: function(msg){

								},error: function(){
									swal("Error", "<?php echo $this->lang->line('Pesan-0 : Data Gagal Disimpan'); ?>", "error");
									button_enabled();
								}
							});
							$("#komersial").ajaxSubmit({
								success: function(msg){
									if(msg == "1"){
										swal({
											title: "<?php echo $this->lang->line('Data Berhasil Disimpan'); ?>",
											text: "<?php echo $this->lang->line('Silahkan isi pesan negosiasi dibawah ini'); ?>...",
											type: "success"
										},
										function(){
											$("#picker").modal("hide");
											return false;
										});
									}
									else{
										swal("Error", "Pesan-3: Data Komersial Gagal Disimpan", "error");
									}
								},
								error: function(){
									swal("Error", "Pesan-2: Data Komersial Gagal Disimpan", "error");
								}
							});
						}
						else{
							msg = msg.replace("<p>", "");
							msg = msg.replace("</p>", "");
							swal("Error", msg, "error");
						}
					},
					error: function(){
						swal("Error", "Pesan-1: Data Header Gagal Disimpan", "error");
					}
				});
			}
		});
		
		$("#backBtn").click(function(){
			window.history.back();
		});
		
		$("#submitBtn").click(function(){
			if($("#komentar").validate().form()){
				button_disabled();
				$("#komentar").ajaxSubmit({
					success: function(msg){
						if(msg == "1"){
							swal({
								title: "<?php echo $this->lang->line('Selamat, Negosiasi Anda Berhasil Dikirim'); ?>",
								type: "success"
							},
							function(){
								window.location.assign('<?php echo site_url(); ?>');
							});
						}
						else if(msg == "xx1"){
							swal("Error", "Pesan: Harap Masukan Nilai Sesuai Hasil Negosiasi Terakhir", "error");
						}
						else{
							swal("Error", "Pesan-1: Data Gagal Disimpan", "error");
							button_enabled();
						}
					},
					error: function(){
						swal("Error", "Pesan-2: Data Gagal Disimpan", "error");
						button_enabled();
					}
				});
			}
		});
	});
	
	function button_disabled(){
		$("#submitBtn").prop("disabled", true);
		$("#backBtn").prop("disabled", true);
		$("#submitBtn").text("<?php echo $this->lang->line('Sedang Mengirim Negosiasi'); ?>...");	
	}
	
	function button_enabled(){
		$("#submitBtn").prop("disabled", false);
		$("#backBtn").prop("disabled", false);
		$("#submitBtn").text("<?php echo $this->lang->line('Kirim Negosiasi'); ?>");	
	}
	function scroll_header(){
		$('#picker').animate({
			scrollTop: $("#nopenawaran").offset().top
		}, 1000);
	}
</script>