
<input type="hidden" name="vendor_id" value="<?php echo $header['vendor_id']?>">
<input type="hidden" name="transporter_id" value="<?php echo $header['transporter_id']?>">
<input type="hidden" name="wo_id" value="<?php echo $header['wo_id']?>">
<input type="hidden" name="si_id" value="<?php echo $header['si_id']?>">
<input type="hidden" name="state" value="<?php echo $state?>">
<input type="hidden" name="contract_id" value="<?php echo $header['contract_id']?>">

<?php $curval = (isset($header['bapb_number'])) ? $header['bapb_number']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor BAST</label>
  <div class="col-sm-8">
    <input type="text" name="bapbo_number" id="bapb_number" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = (isset($header[$mod.'_title'])) ? $header[$mod.'_title']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Judul BAST</label>
  <div class="col-sm-8">
    <input type="text" name="bapb_title" id="bapb_title" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>


<?php $curval = (isset($header['tgl_pembuatan_bapb'])) ?  date("Y-m-d",strtotime($header["tgl_pembuatan_bapb"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Pembuatan BAST</label>
  <div class="col-sm-4">
    <?php if($type_form=='view'):?>
      <p class="form-control-static"><?php echo $curval ?></p>
    <?php else:?>
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="date" required name="tgl_pembuatan_bapb" id="tgl_pembuatan_bapb" class="form-control" value="<?php echo $curval ?>">
      </div>
    <?php endif;?>
  </div>
</div>

<?php $curval = (isset($header['tgl_penerimaan_bapb'])) ?  date("Y-m-d",strtotime($header["tgl_penerimaan_bapb"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Penerimaan BAST</label>
  <div class="col-sm-4">
    <?php if($type_form=='view'):?>
      <p class="form-control-static"><?php echo $curval ?></p>
    <?php else:?>
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="date" required name="tgl_penerimaan_bapb" id="tgl_penerimaan_bapb" class="form-control" value="<?php echo $curval ?>">
      </div>
    <?php endif;?>
  </div>
</div>

<?php $curval = (isset($header['bapb_notes'])) ? $header['bapb_notes']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Catatan BAST</label>
  <div class="col-sm-8">
    <input type="textarea" name="bapb_notes" id="bapb_notes" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">
    Lampiran *
  </label>
  <div class="col-lg-3 m-l-n">
    <?php if($type_form=='form'){ ?>
    <input type="file" class="form-control" name="attachment">
    <?php } else { ?>
    <p class="form-control-static">
      <?php echo (!empty($header['attachment'])) ? $header['attachment'] : ""; ?>
    </p>
    <?php } ?>
  </div>
</div>
