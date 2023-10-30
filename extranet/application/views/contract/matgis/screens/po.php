<?php //print_r($header);
$cur="";
?>
<?php $curval = (isset($header['spk_number'])) ? $header['spk_number']."-".$header['spk_name'] : "" ; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor SPK*</label>
  <div class="col-sm-6">
    <?php if(!$curval==""):?>
      <p class="form-control-static">
        <?php echo $curval ?>
      </p>
    <?php else:?>
      <input type="hidden" name="name_spk" id="name_spk" value="" />
      <select class="form-control" name="spk_number" id="spk_number" required <?php if($state==2){echo "readonly='TRUE'";} ?>>
        <option value="" readonly>--Pilih SPK--</option>
        <?php
        foreach($spk_list as $key => $val){
          $selected = ($val['kode_spk'] == $curval) ? "selected" : "";
          ?>
          <option <?php echo $selected ?> data-spk="<?php echo $val['nama_spk'] ?>" value="<?php echo $val['kode_spk'] ?>"><?php echo $val['kode_spk'] ?>-<?php echo $val['nama_spk'] ?></option>
        <?php } ?>
      </select>
    <?php endif;?>
  </div>
</div>

<?php $curval = (isset($header['contract_number'])) ? $header['contract_number'] : "AUTO NUMBER"; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor Kontrak</label>
  <div class="col-sm-10">
    <p class="form-control-static">
      <a href="<?php echo site_url('contract/monitor/monitor_kontrak/lihat/'.$header['contract_id']) ?>" target="_blank">
        <?php echo $curval ?>
      </a>
    </p>
  </div>
</div>



<?php $curval = (isset($header['contract_id'])) ? $header['contract_id'] : ""; ?>
<input type="hidden" name="contract_id" value="<?php echo $curval ?>">

<?php $curval = (isset($header['wo_id'])) ? $header['wo_id'] : ""; ?>
<input type="hidden" name="wo_id" value="<?php echo $curval ?>">

<?php $curval = (isset($header['ptm_number'])) ? $header['ptm_number'] : "AUTO NUMBER"; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor Pengadaan</label>
  <div class="col-sm-10">
    <p class="form-control-static">
      <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$curval); ?>" target="_blank">
        <?php echo $curval ?>
      </a>
    </p>
  </div>
</div>

<?php $curval = (isset($header['vendor_name'])) ? $header['vendor_name'] : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Vendor</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($header['start_date'])) ?  date("Y-m-d",strtotime($header["start_date"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Mulai PO*</label>
  <div class="col-sm-4">
      <p class="form-control-static"><?php echo $curval ?></p>
      <input type="hidden" name="tgl_mulai_inp"  value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = (isset($header['end_date'])) ? date("Y-m-d",strtotime($header["end_date"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Berakhir PO*</label>
  <div class="col-sm-4">
      <p class="form-control-static"><?php echo $curval ?></p>
      <input type="hidden" name="tgl_akhir_inp"  value="<?php echo $curval ?>">
  </div>
</div>

<?php $contract_amount = (isset($header['contract_amount'])) ? $header['contract_amount'] : 0; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Total Nilai Kontrak</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo inttomoney($contract_amount) ?></p>
  </div>
</div>

<?php $totalwo = (isset($totalwo)) ? $totalwo : 0; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Total Nilai PO yang sudah dikeluarkan</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo inttomoney($totalwo) ?></p>
  </div>
</div>

<?php $curval = $contract_amount-$totalwo; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Sisa Nilai Kontrak</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo inttomoney($curval) ?></p>
  </div>
</div>

<script type="text/javascript">
$('#spk_number').on("change",function(){
  spk_name=$(this).find(':selected').data('spk');
  console.log(spk_name);
  $('#name_spk').val(spk_name);
});
</script>
