<form method="post" action="<?php echo site_url($controller_name."/submit_proyek_post");?>" class="form-horizontal">
	<input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">
	<div class="row">
		<div class="col-12">
			<div class="card">
			
				<div class="card-header border-bottom pb-2">
					<h4 class="card-title">Proyek Details</h4>
				</div>

				<div class="card-content">
					<div class="card-body">
						<?php $curval = set_value("ppm_id_inp"); ?>
						<div class="row form-group">
							<label class="col-sm-2 control-label">Proyek</label>
							<div class="col-sm-6">
								<select class="form-control select2" name="ppm_id_inp">
									<?php foreach ($proyek_post as $key => $value) { ?>
										<option value="<?php echo $value['ppm_id'] ?>"><?php echo $value['ppm_project_name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo buttonsubmit('administration/user_management/employee/ubah/'.$employee_id,lang('back'),lang('save')) ?>
		</div>
	</div>

</form>