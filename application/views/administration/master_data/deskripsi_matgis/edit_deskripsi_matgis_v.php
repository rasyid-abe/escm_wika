<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_deskripsi_matgis");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="card float-e-margins">
					<div class="card-title">
						<h5>Form</h5>
						<div class="card-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="card-content">

						<?php $curval = $data["label"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<p class="form-control-static"><?php echo $curval ?></p>
							</div>
						</div>

						<?php $curval = $data["desc"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi</label>
							<div class="col-sm-10">
								<p class="form-control-static"><?php echo $curval ?></p>
							</div>
						</div>

						<?php $curval = $data["status"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-3">
								<select required class="form-control" name="status_inp">
									<?php if($curval == 2){ ?>
										<option value="1">Setujui</option>
										<option value="3">Tolak</option>
									<?php } else { ?>
										<?php $selected = ($curval == 1) ? "selected" : ""; ?>
										<option <?php echo $selected ?> value="1">Aktif</option>
										<?php $selected = ($curval == 0) ? "selected" : ""; ?>
										<option <?php echo $selected ?> value="0">Nonaktif</option>
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
				<div style="margin-bottom: 60px;">
					<?php echo buttonsubmit('administration/master_data/deskripsi_matgis',lang('back'),lang('save')) ?>
				</div>
			</div>
		</div>

	</form>
</div>