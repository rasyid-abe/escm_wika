<div class="form-group">
  <?php $curval = (isset($header['contract_id'])) ? $header['contract_id'] : ""; ?>
  <input type="hidden" name="contract_id" value="<?php echo $curval ?>">
  <label class="col-sm-2 control-label">Nomor Kontrak</label>
  <?php $curval = (isset($header['contract_number'])) ? $header['contract_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor PO</label>
  <?php $curval = (isset($header['wo_id'])) ? $header['wo_id'] : ""; ?>
  <input type="hidden" name="wo_id" value="<?php echo $curval ?>">
  <?php $curval = (isset($header['wo_number'])) ? $header['wo_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Nama Vendor</label>
  <?php $curval = (isset($header['vendor_name'])) ? $header['vendor_name'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
  <?php $curval = (isset($header['vendor_id'])) ? $header['vendor_id'] : ""; ?>
  <input type="hidden" name="vendor_id" value="<?php echo $curval ?>">
</div>

<?php $curval = (isset($header['sppm_number'])) ? $header['sppm_number'] : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor SPPM *</label>
  <div class="col-sm-8">
      <input type="text" name="sppm_number" id="sppm_number" class="form-control" value="<?php echo $curval ?>" required>
  </div>
</div>

<?php $curval = (isset($header['sppm_date'])) ?  date("Y-m-d",strtotime($header['sppm_date'])) : date("Y-m-d"); ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal SPPM *</label>
  <div class="col-sm-4">
    <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="date" required name="sppm_date" class="form-control" value="<?php echo $curval ?>" required>
    </div>
  </div>
</div>

<?php $curval = (isset($header['tgl_expected_delivery'])) ?  date("Y-m-d",strtotime($header['tgl_expected_delivery'])) : date("Y-m-d");; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Permintaan Pengiriman *</label>
  <div class="col-sm-4">
    <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="date" required name="sppm_request_date" class="form-control" value="<?php echo $curval ?>" required>
    </div>
  </div>
</div>

<?php $curval = (isset($header['sppm_title'])) ? $header['sppm_title']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Judul SPPM</label>
  <div class="col-sm-8">
    <input type="text" name="sppm_title" id="sppm_title" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>
