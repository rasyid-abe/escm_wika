
<input type="hidden" name="vendor_id" value="<?php echo $header['vendor_id']?>">
<input type="hidden" name="wo_id" value="<?php echo $header['wo_id']?>">
<input type="hidden" name="bapb_id" value="<?php echo $header['bapb_id']?>">
<input type="hidden" name="state" value="<?php echo $state?>">
<input type="hidden" name="contract_id" value="<?php echo $header['contract_id']?>">

<?php $curval = (isset($header['inv_number'])) ? $header['inv_number']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor Tagihan</label>
  <div class="col-sm-8">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['bank'])) ? $header['bank']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Bank</label>
  <div class="col-sm-8">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['no_rekening'])) ? $header['no_rekening']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">No Rekening</label>
  <div class="col-sm-8">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>


<?php $curval = (isset($header['tgl_inv'])) ?  date("Y-m-d",strtotime($header["tgl_inv"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Invoice</label>
  <div class="col-sm-4">
      <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['inv_notes'])) ? $header['inv_notes']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Catatan Tagihan</label>
  <div class="col-sm-8">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>