
<input type="hidden" name="vendor_id" value="<?php echo $header['vendor_id']?>">
<input type="hidden" name="transporter_id" value="<?php echo $header['transporter_id']?>">
<input type="hidden" name="wo_id" value="<?php echo $header['wo_id']?>">
<input type="hidden" name="bapb_id" value="<?php echo $header['bapb_id']?>">
<input type="hidden" name="state" value="<?php echo $state?>">
<input type="hidden" name="contract_id" value="<?php echo $header['contract_id']?>">

<?php $curval = (isset($header['inv_number'])) ? $header['inv_number']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor Tagihan</label>
  <div class="col-sm-8">
    <input type="text" name="inv_number" id="inv_number" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = (isset($header['bank'])) ? $header['bank']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Bank</label>
  <div class="col-sm-8">
    <input type="text" name="bank" id="bank" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = (isset($header['no_rekening'])) ? $header['no_rekening']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">No Rekening</label>
  <div class="col-sm-8">
    <input type="text" name="no_rekening" id="no_rekening" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>


<?php $curval = (isset($header['tgl_inv'])) ?  date("Y-m-d",strtotime($header["tgl_inv"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Invoice</label>
  <div class="col-sm-4">
    <?php if($type_form=='view'):?>
      <p class="form-control-static"><?php echo $curval ?></p>
    <?php else:?>
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="date" required name="tgl_inv" id="tgl_inv" class="form-control" value="<?php echo $curval ?>">
      </div>
    <?php endif;?>
  </div>
</div>

<?php $curval = (isset($header['inv_notes'])) ? $header['inv_notes']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Catatan Tagihan</label>
  <div class="col-sm-8">
    <input type="textarea" name="inv_notes" id="inv_notes" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">
    Lampiran *
  </label>
  <div class="col-lg-3 m-l-n">
    <?php if($state==0 || $state==3){ ?>
    <input type="file" class="form-control" name="attachment">
    <?php } else { ?>
    <p class="form-control-static">
      <?php echo (!empty($header['attachment'])) ? $header['attachment'] : ""; ?>
    </p>
    <?php } ?>
  </div>
</div>
