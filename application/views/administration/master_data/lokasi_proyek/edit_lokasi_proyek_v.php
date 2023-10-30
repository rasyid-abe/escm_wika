<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="card float-e-margins">
					<div class="card-title">
						<h5>Ubah MDIV</h5>
						<div class="card-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="card-content">

						<?php $curval = $data['region_name'];   ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Lokasi Proyek *</label>
							<div class="col-sm-5">
							  <input required type="text" class="form-control" id="region_inp" maxlength="255" name="region_inp" value="<?php echo $curval ?>">
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 60px;">
					<?php echo buttonsubmit('administration/master_data/lokasi_proyek',lang('back'),lang('save')) ?>
				</div>
			</div>
		</div>

	</form>
</div>
		
