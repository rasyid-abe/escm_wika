<style>
	.card {
		border-radius: 1.35rem;
	}

	.breadcrumb-escm {
		border: 1px solid #d1d3d4;
	}

	.wrapper-icon {
		display: flex;
		align-items: center;
		margin-left: 8px;
		padding: 5px;
	}

	.wrapper-icon:hover {
		background-color: #eaeaea;
		border-radius: 8px;
	}

	.shadow-none {
		width: 20%;
		border: 1px solid #d1d3d4;
		background-color: white;
	}

	textarea.form-control {
		background-color: transparent;
		color: #606060;
	}

	input.form-control {
		background-color: transparent;
		color: #606060;
	}

</style>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="form-horizontal">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom pb-2">
                        <h4 class="card-title">Detail Data GR/SES</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">                            
							<form class="form-bordered">
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Dev ID</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['devid']; ?>">
											<div class="form-control-position">
												<i class="ft-cpu"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Package ID</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['packageid']; ?>">
											<div class="form-control-position">
												<i class="ft-minus-square"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">PO Number</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['po_number']; ?>">
											<div class="form-control-position">
												<i class="ft-codepen"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">PO Item</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['po_item']; ?>">
											<div class="form-control-position">
												<i class="ft-codepen"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Prctr</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['prctr']; ?>">
											<div class="form-control-position">
												<i class="ft-battery"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Co Code</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['cocode']; ?>">
											<div class="form-control-position">
												<i class="ft-minus-circle"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Entry UOM</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['entry_uom']; ?>">
											<div class="form-control-position">
												<i class="ft-hard-drive"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Mat Doc</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['mat_doc']; ?>">
											<div class="form-control-position">
												<i class="ft-file"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Doc Year</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['doc_year']; ?>">
											<div class="form-control-position">
												<i class="ft-cpu"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Posting Date</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['psting_date']; ?>">
											<div class="form-control-position">
												<i class="ft-calendar"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Mat Doc Item</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['matdoc_itm']; ?>">
											<div class="form-control-position">
												<i class="ft-file"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Ref Doc</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['ref_doc']; ?>">
											<div class="form-control-position">
												<i class="ft-file"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Material</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['material']; ?>">
											<div class="form-control-position">
												<i class="ft-cpu"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Plant</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['plant']; ?>">
											<div class="form-control-position">
												<i class="ft-feather"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Stge Loc</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['stge_loc']; ?>">
											<div class="form-control-position">
												<i class="ft-navigation"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Move Type</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['move_type']; ?>">
											<div class="form-control-position">
												<i class="ft-crosshair"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 label-control text-right">Quantity</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['quantity']; ?>">
											<div class="form-control-position">
												<i class="ft-cpu"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row last mb-3">
									<label class="col-md-3 label-control text-right">Tanggal Syncron</label>
									<div class="col-md-9">
										<div class="position-relative has-icon-left">
											<input type="text" class="form-control" value="<?php echo $row['sync_at']; ?>">
											<div class="form-control-position">
												<i class="ft-box"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="btn-group btn-group-sm">
									<a href="<?php echo site_url('contract/gr_ses'); ?>" class="btn btn-secondary"><i class="ft-arrow-left mr-1"></i>Kembali</a>
								</div>
							</form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

	</div>
</div>
