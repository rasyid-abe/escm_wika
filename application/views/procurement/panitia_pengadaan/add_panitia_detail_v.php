<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_panitia_detail");?>" class="form-horizontal">
		<div class="row">
			<input type="hidden" name="committee_id" value="<?php echo $committee_id ?>">
			<div class="col-lg-12">
				<div class="card float-e-margins">
					<div class="card-title">
						<h5>Detail Panitia</h5>
						<div class="card-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="card-content">

						<?php $curval = set_value("abct_inp"); ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Jabatan</label>
							<div class="col-sm-6">
								<select class="form-control select2" required name="abct_inp" id="abct">
									<?php foreach ($committeetype as $key => $value) {
										$selected = ($value['id_abct'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $value['id_abct'] ?>"><?php echo $value['name_abct'] ?></option>
										<?php } ?>
								</select>
							</div>
						</div>

						<?php $curval = set_value("employeeid_inp"); ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Name</label>

							<div class="col-sm-6" id="employee_t">
								<input type="text" name="employee_inp" class="form-control valid" required>
							</div>
							
							<div class="col-sm-6" id="employee_n">
								<select required class="form-control select2" name="employeeid_inp">
									<option value="">Pilih</option>
									<?php 
									foreach($employee as $key => $val){
										$selected = ($val['id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['id'] ?>"><?php echo $val['fullname'] ?> - <?php echo $val['pos_name'] ?></option>
										<?php } ?>
								</select>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo buttonsubmit('procurement/procurement_tools/panitia_pengadaan/ubah/'.$committee_id,lang('back'),lang('save')) ?>
			</div>
		</div>
	</div>
</form>

<script>
	
	$(document).ready(function(){

		var tipe = ""
		$('#employee_t').hide(400);

		$('#abct').on('change', function() {
		 	
		 	tipe = this.value;
			
			if (tipe != "1") {
				console.log(tipe)
				$('#employee_n').hide(400);
				$('#employee_t').show(400);
			}else{
				$('#employee_t').hide(400);
				$('#employee_n').show(400);
			}
		});


	});

</script>