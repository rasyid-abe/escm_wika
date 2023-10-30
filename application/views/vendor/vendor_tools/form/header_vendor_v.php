<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Header Vendor</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
			<?php $curval = $data["vendor_name"]; ?>
			<div class="row form-group">
				<label class="col-sm-3 control-label text-right">Nama Vendor</label>
				<div class="col-sm-9">
					<p class="form-control-static" id="vendor_name_inp"><a href="<?php echo site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$data['vendor_id']) ?>" target="_blank"><?php echo $curval ?></a></p>
				</div>
			</div>

			<?php $curval = $data["address_street"]; ?>
			<div class="row form-group">
				<label class="col-sm-3 control-label text-right">Alamat</label>
				<div class="col-sm-9">
					<p class="form-control-static" id="address_street_inp"><?php echo $curval ?></p>
				</div>
			</div>

			<?php if ($activity_id != 6091) { ?>
			<?php $curval = set_value("vnd_type_inp"); ?>
			<div class="row form-group">
				<label class="col-sm-3 control-label text-right">Tipe Vendor <br>(Dokumen PQ/Tambahan) <span class="text-bold-700 text-danger">*</span></label>
				<div class="col-sm-4">
				<select class="form-control" id="vnd_type_inp" name="vnd_type_inp" required <?= !empty($curval) ? "disabled" : "" ?>>
					<option value="">-- Pilih --</option>
					<?php foreach ($vendor_type as $key => $value) { ?>
						<option value="<?= $value['vtm_id'] ?>"
							<?= $curval == $value['vtm_id'] ? "selected" : ""?>
							>
							<?= $value['vtm_name'].' - '.$value['vtm_description'] ?></option>
					<?php } ?>
				</select>
				</div>
			</div>

			<?php $curval = set_value("template_inp"); ?>
			<div class="row form-group">
				<label class="col-sm-3 control-label text-right">Template <span class="text-bold-700 text-danger">*</span></label>
				<div class="col-sm-4">
				<select class="form-control" id="template_inp" name="template_inp" required <?= !empty($curval) ? "disabled" : "" ?>>
					<option value="">-- Pilih --</option>
				</select>
				</div>
			</div>
			<?php } ?>

			<div class="row form-group">
				<label class="col-sm-3 control-label text-right">Survei <span class="text-bold-700 text-danger">*</span></label>
				<div class="col-sm-5">
					<div class="i-checks">
						<label class=""> 
						<div class="iradio_square-green ysurvei" style="position: relative;">
							<input type="checkbox" value="3" name="survey_inp" id="data" class="survei" data-tipe="sw" style="position: absolute; opacity: 0;" >
							<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
							</ins>
						</div>
						<i></i>&nbsp;&nbsp; Rekomendasi Survei
						</label>
					</div>
					<div class="i-checks">
						<label class=""> 
						<div class="iradio_square-green nsurvei" style="position: relative;">
							<input type="checkbox" value="4" name="survey_inp" id="data" class="survei" data-tipe="mw" style="position: absolute; opacity: 0;">
							<ins class="iCheck-helper" checked style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
							</ins>
						</div> 
						<i></i>&nbsp;&nbsp; Rekomendasi Tidak Survei
						</label>
					</div> 
				</div>
			</div>

			<?php $curval = "" ?>
			<div class="form-group" id="attachment_div">
				<label class="col-sm-3 control-label text-right">Lampiran Rekomendasi</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-btn">
							<button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "activation/survei" ?>" data-preview="preview_file" class="btn btn-primary upload">
								<i class="fa fa-cloud-upload"></i>
							</button> 
							<button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "activation/survei" ?>" data-preview="preview_file" class="btn btn-danger removefile">
								<i class="fa fa-remove"></i>
							</button> 
						</span> 
						<input readonly type="text" class="form-control" id="doc_attachment_inp" name="doc_attachment_inp" value="<?php echo $curval ?>">
						<span class="input-group-btn">
							<button type="button" data-url="<?php echo site_url("log/download_attachment/activation/survei/".$curval) ?>" class="btn btn-primary preview_upload" id="preview_file">
								<i class="fa fa-share"></i>
							</button> 
						</span> 
					</div>
					<div class="col-sm-0" style="font-size: 11px">
						<i>Max file 5 MB 
						<br>
							Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
						</i>
					</div>
				</div>
			</div>

			<?php if ($activity_id > 6091) { ?>
				<?php $curval = $data["reg_isactivate"]; ?>
				<div class="row form-group">
					<label class="col-md-3 control-label text-right">Status <span class="text-bold-700 text-danger">*</span></label>
					<div class="col-md-2">
						<select class="form-control" name="reg_isactivate_inp" required>
							<option value="" readonly>--Pilih--</option>
							<?php $pilihan=array(
								'0' => 'Non Aktif',
								'1' => 'Aktif',
								);
							foreach($pilihan as $key => $val){
								$selected = ($key == $curval) ? "selected" : ""; 
								?>
								<option  value="<?php echo $key ?>"><?php echo $val ?></option>
								<?php } ?>
							</select>
					</div>
				</div>

				<?php $curval = ""; ?>
				<div class="row form-group">
					<label class="col-md-3 control-label text-right">Kantor Daftar <span class="text-bold-700 text-danger">*</span></label>
					<div class="col-md-4">
						<select class="form-control" name="district_inp" required>
							<option value="" readonly>--Pilih--</option>
							<?php 
							foreach($district as $key => $val){
								$selected = ($val['district_id'] == $curval) ? "selected" : ""; 
								?>
								<option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_name'] ?></option>
								<?php } ?>
							</select>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-3 control-label text-right">COT <span class="text-bold-700 text-danger">*</span></label>
					<div class="col-md-4">
						<select class="form-control" name="cot_inp" required>
							<option value="" readonly>--Pilih--</option>
							<?php 
							foreach($cot as $key => $val){
								$selected = ($val['cot_id'] == $curval) ? "selected" : ""; 
								?>
								<option <?php echo $selected ?> value="<?php echo $val['cot_id'] ?>"><?php echo $val['jenis_nasabah'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-sm-3 control-label text-right">Tanggal Survey</label>
					<div class="col-sm-3">
						<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="text" name="survey_date_inp" class="form-control survey_date valid"  id="survey_date" value="" aria-invalid="false">
						</div>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-sm-3 control-label text-right"><?php echo lang('attachment') ?></label>
					<div class="col-sm-7">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "activation/document" ?>" data-preview="preview_file" class="btn btn-primary upload">
									<i class="fa fa-cloud-upload"></i>
								</button> 
								<button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "activation/document" ?>" data-preview="preview_file" class="btn btn-danger removefile">
									<i class="fa fa-remove"></i>
								</button> 
							</span> 
							<input readonly type="text" class="form-control" id="doc_attachment_inp" name="doc_attachment_inp" value="<?php echo $curval ?>">
							<span class="input-group-btn">
								<button type="button" data-url="<?php echo site_url("log/download_attachment/activation/".$curval) ?>" class="btn btn-primary preview_upload" id="preview_file">
									<i class="fa fa-share"></i>
								</button> 
							</span> 
						</div>
						<div class="col-sm-0" style="font-size: 11px">
							<i>Max file 5 MB 
							<br>
								Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
							</i>
						</div>
					</div>
				</div>

				<?php if($data["nasabah_code"]==NULL || $data["nasabah_code"]==''){?>	
					<?php $curval = ""?>
					<div class="row form-group">
						<label class="col-sm-3 control-label text-right">Kode Nasabah</label>
						<div class="col-sm-9">
							<p class="form-control-static" id="customer_code_inp">Auto Generate</p>
						</div>
					</div>
				<?php } ?>

				<?php if($data["nasabah_code"]!=NULL){ ?>
					<?php $curval = $data["nasabah_code"]; ?>
					<div class="row form-group">
						<label class="col-sm-3 control-label text-right">Kode Nasabah</label>
						<div class="col-sm-9">
							<p class="form-control-static" id="customer_code_inp"><?php echo $curval ?></p>
						</div>
					</div>
				<?php }?>			  
			<?php } ?>

        </div>
      </div>

    </div>
  </div>
</div>

<script>
	
	$('#attachment_div').hide()

	var lib = false

	$(document).ready(function () {
		$('.survey_date').datetimepicker({format:"YYYY-MM-DD HH:mm:ss"})

		$('input[type=checkbox][data-tipe=sw]').change(function() {
		if ($(this).is(':checked')) {
			$('.ysurvei').addClass('checked');
			$('.nsurvei').removeClass('checked');
			$('input[type=checkbox][data-tipe=mw]').attr("checked",false);
			$("#attachment_div").show(500);
			lib = true
		} else {
		$('.ysurvei').removeClass('checked');
			$("#attachment_div").hide(500);
			lib = false
		}
		});

		$('input[type=checkbox][data-tipe=mw]').change(function() {
			if ($(this).is(':checked')) {
				$('.nsurvei').addClass('checked');
				$('.ysurvei').removeClass('checked');
				$('input[type=checkbox][data-tipe=sw]').attr("checked",false);
				$("#attachment_div").hide(500);
				lib = false
			} else {
			$('.nsurvei').removeClass('checked');
				$("#attachment_div").hide(500);
				lib = false
			}
		});

		$('#vnd_type_inp').change(function(event) {
			/* Act on the event */
			let vnd_type = $('#vnd_type_inp').val()
			$.ajax({
				url: "<?= site_url('vendor/data_template_doc_pq/') ?>"+"/"+vnd_type,
				type: 'GET',
			})
			.done(function(data) {
				data = $.parseJSON(data);
				let html = "<option value=''> -- Pilih -- </option>"
				$.each(data.rows, function(index, val) {
					html += "<option value='"+val.avd_id+"'> "+val.avd_name+" </option>";
				});

				$('#template_inp').html(html)

			})
			.fail(function() {
				console.log("error getting template");
			})
			.always(function() {
			});
		});

	});

	if ( $('input[type=checkbox][data-tipe=sw]').is(':checked')) {
		alert("fs")
	}

</script>