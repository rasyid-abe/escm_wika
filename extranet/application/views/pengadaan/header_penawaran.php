<div class="row">
	<div class="col-12">
		<div class="card">

			<div class="card-header border-bottom pb-2">
				<h4 class="card-title"><?php echo $this->lang->line('Penawaran'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<form role="form" id="header" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal">	
					<input type="hidden" id="section" name="section" value="header">
					<input type="hidden" id="pqmid" name="pqmid" value="<?php if(isset($header)){ echo $header["pqm_id"]; } ?>">
					<div class="row form-group">
						<label class="col-sm-3 control-label text-right">
							<?php echo $this->lang->line('Nomor Pengadaaan'); ?>
						</label>
						<div class="col-lg-6 m-l-n"><input readonly id="tenderid" name="tenderid" type="text" class="form-control" value="<?php echo $tenderid; ?>"></div>
					</div>
					<div class="row form-group">
						<label class="col-sm-3 control-label text-right">
							<?php echo $this->lang->line('Nomor Penawaran'); ?> *
						</label>
						<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> id="nopenawaran" name="nopenawaran" type="text" class="form-control" value="<?php if(isset($header)){ echo $header["pqm_number"]; } ?>" required></div>
					</div>
					<div class="row form-group">
						<label class="col-sm-3 control-label text-right">
							<?php echo $this->lang->line('Tipe Penawaran'); ?> *	
						</label>
						<div class="col-md-2 m-l-n">
							<select <?php echo $readonly ?> class="form-control" name="tipepenawaran" id="tipepenawaran" required>
								<option value="">--<?php echo $this->lang->line('Pilih'); ?>--</option>
								<?php 
								$ptp_quo_type = array("A");
								if(substr($prep['ptp_quo_type'], 1,1) == 1){
									$ptp_quo_type[] = "B";
								}
								if(substr($prep['ptp_quo_type'], 2,1) == 1){
									$ptp_quo_type[] = "C";
								}
								foreach ($ptp_quo_type as $key => $value) { 
									$v = (isset($header["pqm_type"])) ? $header["pqm_type"] : "";
									?>
									<option value="<?php echo $value ?>" <?php echo ($v == $value) ? "selected" : "" ?> >
										<?php echo $this->lang->line('Tipe'); ?> <?php echo $value ?>
									</option>
									<?php } ?>

								</select>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-3 control-label text-right">
								Target Penilaian TKDN (%)
							</label>
							<div class="col-md-2 m-l-n"><input <?php echo $readonly ?> id="kandunganlokal" name="kandunganlokal" placeholder="%" type="number" min="0" max="100" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_local_content"]; } ?>"></div>
						</div>

						<div class="row form-group">
							<label class="col-sm-3 control-label text-right">
								Jangka Waktu Garansi/Pemeliharaan *
							</label>
							<div class="col-md-2 m-l-n"><input <?php echo $readonly ?> id="garansi_t" name="garansi_t" type="number" class="form-control" required value="<?php echo (isset($header['pqm_guarantee_time'])) ? $header["pqm_guarantee_time"] : "" ?>">
							</div>
							<div class="col-md-2 m-l-n">
								<select <?php echo $readonly ?> class="form-control m-b" name="garansi_u" id="garansi_u" required>
									<?php 
									$curval = (isset($header["pqm_guarantee_unit"])) ? $header["pqm_guarantee_unit"] : "";
									foreach (array("Hari","Bulan","Tahun") as $key => $value) { ?>
									<option <?php echo ($value == $curval) ? "selected" : "" ?> ><?php echo $value ?></option>
									<?php } ?>
								</select>
							</div>
							<?php if(empty($readonly)){ ?>
							<div class="col-md-2 m-l-n">
								<button class="btn btn-info btn-sm" type="button" id="samakan_garansi">Samakan Semua Item</button>
							</div>
							<?php } ?>
						</div>

						<div class="row form-group">
							<label class="col-sm-3 control-label text-right">
								Jangka Waktu Penyerahan / Pelaksanaan *
							</label>
							<div class="col-md-2 m-l-n"><input <?php echo $readonly ?> id="penyerahan_t" name="penyerahan_t" type="number" class="form-control" required value="<?php echo (isset($header['pqm_deliverable_time'])) ? $header["pqm_deliverable_time"] : "" ?>">
							</div>
							<div class="col-md-2 m-l-n">
								<select <?php echo $readonly ?> class="form-control m-b" name="penyerahan_u" id="penyerahan_u" required>
									<?php 
									$curval = (isset($header["pqm_deliverable_unit"])) ? $header["pqm_deliverable_unit"] : "";
									foreach (array("Hari","Bulan","Tahun") as $key => $value) { ?>
									<option <?php echo ($value == $curval) ? "selected" : "" ?> ><?php echo $value ?></option>
									<?php } ?>
								</select>
							</div>
							<?php if(empty($readonly)){ ?>
							<div class="col-md-2 m-l-n">
								<button class="btn btn-info btn-sm" type="button" id="samakan_penyerahan">Samakan Semua Item</button>
							</div>
							<?php } ?>
						</div>

						<div class="row form-group" id="selesai">
							<label class="col-sm-3 control-label text-right">
								<?php echo $this->lang->line('Berlaku Hingga'); ?> *
							</label>
							<div class="col-md-4 m-l-n input-group">
								<input <?php echo $readonly ?> id="berlakuhingga" name="berlakuhingga" type="date" class="form-control" value="<?php if(isset($header)) { echo date("Y-m-d", strtotime($header["pqm_valid_thru"])); } ?>" required>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-3 control-label text-right">
								<?php echo $this->lang->line('Lampiran Penawaran'); ?> *
							</label>
							<div class="col-lg-6 m-l-n">
								<?php if(empty($readonly)){ ?>
								<input <?php echo $readonly ?> id="lampiran_penawaran" name="lampiran_penawaran" type="file" class="file" <?php echo !isset($header) ? 'required' : '' ?> accept="<?php echo ALLOWED_EXT_FILES ?> ">
								<small id="error"></small>
								<div class="col-sm-0" style="font-size: 11px">
			                        <i>Max file 10 MB 
			                        <br>
			                          Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
			                        </i>
			                      </div>
								<?php } ?>
								<?php if(isset($header)){ ?>
								<p class="form-control-static">
									<a target="_blank" href="<?php echo site_url('pengadaan/download/penawaran/'.$this->umum->forbidden($this->encryption->encrypt($header["pqm_att_quo"]), 'enkrip')); ?>">
										<?php echo $header["pqm_att_quo"]; ?>
									</a>
								</p>
								<?php } ?>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 control-label text-right">
								<?php echo $this->lang->line('Catatan'); ?>
							</label>
							<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> id="catatan" name="catatan" type="text" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_notes"]; } ?>"></div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 control-label text-right">
								<?php echo $this->lang->line('Mata Uang'); ?>
							</label>
							<div class="col-md-4 m-l-n">
								<select class="form-control m-b" id="currency" name="pqm_currency">
									<?php foreach($currency as $row) { ?>									
										<option value="<?php echo $row["curr_code"] ?>"
										data-rates='<?php echo $row["sell"] ?>'
										<?php if(isset($header)) { if(($header["pqm_currency"] == $row["curr_code"])){ echo "selected";} } ?>><?php echo $row["curr_code"]." - ".$row["curr_name"] ?></option>
									<?php } ?>
								</select>
								<input type="hidden" name="pqm_rate_curs" id="pqm_rate_curs" value="<?php echo (isset($header)) ? $header["pqm_rate_curs"] : "" ?>">
							</div>
						</div>
					</form>	
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	$('#currency').change(function(){
		$('#pqm_rate_curs').val($(this).find(':selected').data('rates'));
	});

	$(document).ready(function(){

		$('#lampiran_penawaran').bind('change', function(event) {
			$('#error_msg').remove();
			var ext = $(this).val().split('.').pop().toLowerCase();
			var files = event.target.files;      
				console.log(files)
			// alert(files[0].size)
			if (files[0].size > 10485760) {
				$(this).val('');
				$('#error').append("<span style='color:red' id='error_msg'>File tidak boleh lebih dari 10MB</span>");
			}else if($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
				$(this).val('');
				$('#error').append("<span style='color:red' id='error_msg'>Format file tidak sesuai</span>");
			}
		});

		$("#samakan_garansi").click(function(){

			var unit = $("#garansi_u").val();
			var time = $("#garansi_t").val();

			$(".guarantee_time_item").val(time);
			$(".guarantee_unit_item option:contains('"+unit+"')").prop("selected",true);

		});

		$("#samakan_penyerahan").click(function(){

			var unit = $("#penyerahan_u").val();
			var time = $("#penyerahan_t").val();

			$(".deliverable_time_item").val(time);
			$(".deliverable_unit_item option:contains('"+unit+"')").prop("selected",true);

		});

		
		$('#tipepenawaran').change(function(event) {
			$('#tipe_penawaran_item').val($('#tipepenawaran').val()).trigger('change');
		});

	});

</script>