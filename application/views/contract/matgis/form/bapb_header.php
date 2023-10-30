<?php $curval = (isset($header['contract_id'])) ? $header['contract_id'] : ""; ?>
<input type="hidden" name="contract_id" value="<?php echo $curval ?>">
<?php $curval = (isset($header['contract_id'])) ? $header['wo_id'] : ""; ?>
<input type="hidden" name="wo_id" value="<?php echo $curval ?>">
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

<?php $curval = (isset($header['bapb_title'])) ? $header['bapb_title']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Judul BAST</label>
  <div class="col-sm-10 form-control-static">
    <input type="text" name="bapb_title" id="bapb_title" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = (isset($header['tgl_pembuatan_bapb'])) ?  date("d-m-Y",strtotime($header['tgl_pembuatan_bapb'])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Pembuatan</label>
  <div class="col-sm-10 form-control-static">
     <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="date" required name="create_date" id="create_date" class="form-control" value="<?//php echo $curval ?>">
    </div>
</div>

<?php $curval = (isset($header['tgl_penerimaan_bapb'])) ?  date("d-m-Y",strtotime($header['tgl_penerimaan_bapb'])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Penerimaan</label>
  <div class="col-sm-4">
    <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="date" required name="receive_date" id="receive_date" class="form-control" value="<?//php echo $curval ?>">
    </div>
  </div>
</div>
