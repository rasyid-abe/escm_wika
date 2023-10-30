<?php $curval = (isset($header['wo_id'])) ? $header['wo_id'] : ""; ?>
<input type="hidden" name="wo_id" id="wo_id" value="<?php echo $curval ?>">
<?php $curval = (isset($header['contract_id'])) ? $header['contract_id'] : ""; ?>
<input type="hidden" name="contract_id" id="contract_id" value="<?php echo $curval ?>">
<?php $curval = (isset($header['vendor_id'])) ? $header['vendor_id'] : ""; ?>
<input type="hidden" name="vendor_id" value="<?php echo $curval ?>">

<div class="form-group">
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
  <label class="col-sm-2 control-label">Nomor SI</label>
  <?php $curval = (isset($header['si_id'])) ? $header['si_id'] : ""; ?>
  <input type="hidden" name="si_id" value="<?php echo $curval ?>">
  <?php $curval = (isset($header['si_number'])) ? $header['si_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Nomor SPPM</label>
  <?php $curval = (isset($header['sppm_id'])) ? $header['sppm_id'] : ""; ?>
  <input type="hidden" name="sppm_id" value="<?php echo $curval ?>">
  <?php $curval = (isset($header['sppm_number'])) ? $header['sppm_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>

</div>

<?php $curval = (isset($header['do_number'])) ? $header['do_number']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor DO</label>
  <!-- <div class="col-sm-8"> -->
      <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
  <!-- </div> -->
</div>


<?php $curval = (isset($header['do_title'])) ? $header['do_title']: ""; ?>
<div class="form-group" style="display: none;">
  <label class="col-sm-2 control-label">Judul DO</label>
  <div class="col-sm-8">
      <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['do_notes'])) ? $header['do_notes']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Catatan DO</label>
  <!-- <div class="col-sm-8"> -->
      <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
  <!-- </div> -->
</div>
