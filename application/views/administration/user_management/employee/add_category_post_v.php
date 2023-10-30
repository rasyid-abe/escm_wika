<form method="post" action="<?php echo site_url($controller_name."/submit_cat_post");?>" class="form-horizontal">
	<input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">
	<div class="row">
		<div class="col-12">
			<div class="card">
			
				<div class="card-header border-bottom pb-2">
					<h4 class="card-title">Kategori Detail</h4>
				</div>

				<div class="card-content">
					<div class="card-body">
						<?php $curval = set_value("category_inp"); ?>
						<div class="row form-group">
							<label class="col-sm-2 control-label">Kategori</label>
							<div class="col-sm-6">
								<select class="form-control select2" name="category_inp">
									<option value="Civil Materials">Civil Materials</option>									
									<option value="Civil Services">Civil Services</option>									
									<option value="Building Materials and Services">Building Materials and Services</option>									
									<option value="EPCC Materials and Services">EPCC Materials and Services</option>									
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