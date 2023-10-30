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

<div class="form-group">
  <label class="col-sm-2 control-label">Nomor SPPM</label>
  <?php $curval = (isset($header['sppm_number'])) ? $header['sppm_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>

<?php $curval = (isset($header['sppm_date'])) ?  date("Y-m-d",strtotime($header['sppm_date'])) : date("Y-m-d"); ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal SPPM *</label>
  <div class="col-sm-4">
  <p class="form-control-static"><?php echo $curval?></p>
  </div>
</div>

<?php $curval = (isset($header['tgl_expected_delivery'])) ?  date("Y-m-d",strtotime($header['tgl_expected_delivery'])) : date("Y-m-d");; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Permintaan Pengiriman *</label>
  <div class="col-sm-4">
  <p class="form-control-static"><?php echo $curval?></p>
  </div>
</div>

<?php $curval = (isset($header['sppm_title'])) ? $header['sppm_title']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Judul SPPM</label>
  <div class="col-sm-8">
  <p class="form-control-static"><?php echo $curval?></p>
  </div>
</div>
