<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_suspend_vendor");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="card float-e-margins">
					<div class="card-title">
						<h5>Suspend Vendor</h5>
						<div class="card-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="card-content">

					<?php $curval = $data["vendor_name"]; ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Vendor</label>
							<div class="col-sm-9">
								<p class="form-control-static" id="vendor_name_inp"><?php echo $curval ?></p>
							</div>
						</div>

						<?php $curval = $data["address_street"]; ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alamat</label>
							<div class="col-sm-9">
								<p class="form-control-static" id="address_street_inp"><?php echo $curval ?></p>
							</div>
						</div>

						<?php $curval = set_value("expiredfrom_inp"); ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Dari Tanggal</label>
							<div class="col-sm-3">
								<input type="text" class="form-control datetimepicker" name="expiredfrom_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = set_value("expiredto_inp"); ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Sampai Tanggal</label>
							<div class="col-sm-3">
								<input type="text" class="form-control datetimepicker" name="expiredto_inp" value="<?php echo $curval ?>">
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<?php $i=0; include(VIEWPATH."/comment_v.php") ?>

		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 60px;">
					<?php echo buttonsubmit('vendor/kinerja_vendor/suspend_vendor',lang('back'),lang('save')) ?>
				</div>
			</div>
		</div>

	</form>
</div>