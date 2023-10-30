
<input type="hidden" name="vendor_id" value="<?php echo $header['vendor_id']?>">
<input type="hidden" name="wo_id" value="<?php echo $header['wo_id']?>">
<input type="hidden" name="state" value="<?php echo $state?>">
<input type="hidden" name="contract_id" value="<?php echo $header['contract_id']?>">

<?php $curval = (isset($header['sj_number'])) ? $header['sj_number']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor SJ</label>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Nomor DO</label>
  <?php
  $this->db->where('do_id',$header['do_id']);
  $do_number=$this->db->get('ctr_do_header')->row_array()['do_number'];
  ?>
  <?php $curval = $do_number ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>

<!-- <?php //$curval = (isset($header[$mod.'_title'])) ? $header[$mod.'_title']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Judul Surat Jalan</label>
  <div class="col-sm-8">
    <p class="form-control-static"><?php //echo $curval ?></p>
  </div>
</div> -->

<?php $curval = (isset($header['no_mobil'])) ? $header['no_mobil']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">No. Mobil</label>
  <div class="col-sm-8">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['tgl_pembuatan_sj'])) ?  date("Y-m-d",strtotime($header["tgl_pembuatan_sj"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Pembuatan SJ</label>
  <div class="col-sm-4">
      <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['tgl_pengiriman_sj'])) ?  date("Y-m-d",strtotime($header["tgl_pengiriman_sj"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Pengiriman SJ</label>
  <div class="col-sm-4">
      <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['sj_notes'])) ? $header['sj_notes']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Catatan SJ</label>
  <div class="col-sm-8">
      <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>
