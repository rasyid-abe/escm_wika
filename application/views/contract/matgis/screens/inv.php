<?php $curval = (isset($header['contract_id'])) ? $header['contract_id'] : ""; ?>
<input type="hidden" name="contract_id" value="<?php echo $curval ?>">
<?php $curval = (isset($header['contract_id'])) ? $header['wo_id'] : ""; ?>
<input type="hidden" name="wo_id" value="<?php echo $curval ?>">
<?php $curval = (isset($header['tgl_inv'])) ?  date("d-m-Y",strtotime($header['tgl_inv'])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Invoice</label>
  <div class="col-sm-10 form-control-static">
    <p><?php echo $curval;?></p>
    <!-- <div class="input-group date">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <input type="date" required name="create_date" id="create_date" class="form-control" value="<?//php echo $curval ?>">
  </div> -->
</div>
</div>

<div class="form-group">
  <?php $curval = (isset($header['contract_id'])) ? $header['contract_id'] : ""; ?>
  <input type="hidden" name="contract_id" value="<?php echo $curval ?>">
  <label class="col-sm-2 control-label">Nomor Kontrak</label>
  <?php $curval = (isset($header['contract_number'])) ? $header['contract_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Nomor WO</label>
  <?php $curval = (isset($header['wo_number'])) ? $header['wo_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor Surat Jalan</label>
  <?php $curval = (isset($header['sj_number'])) ? $header['sj_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">File TTD Invoice *</label>
  <div class="col-sm-4">
    <input type="file" name="userfile" id="userfile" size="20" />
  </div>
</div>
