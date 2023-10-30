
<input type="hidden" name="vendor_id" value="<?php echo $header['vendor_id']?>">
<input type="hidden" name="wo_id" value="<?php echo $header['wo_id']?>">
<input type="hidden" name="state" value="<?php echo $state?>">
<input type="hidden" name="contract_id" value="<?php echo $header['contract_id']?>">

<?php $curval = (isset($header['sj_number'])) ? $header['SJ_number']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor SJ *</label>
  <div class="col-sm-8">
    <input type="text" name="sj_number" id="sj_number" class="form-control" value="<?php echo $curval ?>" required>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Nomor DO</label>
  <?php $curval = (isset($header['do_id'])) ? $header['do_id'] : ""; ?>
  <input type="hidden" name="do_id" value="<?php echo $curval ?>">
  <?php $curval = (isset($header['do_number'])) ? $header['do_number'] : ""; ?>
  <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
</div>

<?php $curval = (isset($header[$mod.'_title'])) ? $header[$mod.'_title']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Judul Surat Jalan</label>
  <div class="col-sm-8">
    <input type="text" name="sj_title" id="sj_title" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<!-- <?//php $curval = (isset($header['transporter_name'])) ? $header['transporter_name']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nama Transporter</label>
  <div class="col-sm-8">
      <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
  </div>
</div> -->

<?php $curval = (isset($header['no_mobil'])) ? $header['no_mobil']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">No. Mobil</label>
  <div class="col-sm-8">
    <input type="text" name="no_mobil" id="no_mobil" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = (isset($header['tgl_pembuatan_sj'])) ?  date("Y-m-d",strtotime($header["tgl_pembuatan_sj"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Pembuatan SJ</label>
  <div class="col-sm-4">
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="date" required name="tgl_pembuatan_sj" id="tgl_pembuatan_sj" class="form-control" value="<?php echo $curval ?>">
      </div>
</div>

<?php $curval = (isset($header['tgl_pengiriman_sj'])) ?  date("Y-m-d",strtotime($header["tgl_pengiriman_sj"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Pengiriman SJ</label>
  <div class="col-sm-4">
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="date" required name="tgl_pengiriman_sj" id="tgl_pengiriman_sj" class="form-control" value="<?php echo $curval ?>">
      </div>
  </div>
</div>

<?php $curval = (isset($header['sj_notes'])) ? $header['sj_notes']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Catatan SJ</label>
  <div class="col-sm-8">
    <input type="textarea" name="sj_notes" id="sj_notes" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">
    Lampiran *
  </label>
  <div class="col-sm-8">
    <?php if($state==0){ ?>
    <input type="file" class="form-control" name="attachment" id="sj_attachment" accept="<?php echo ALLOWED_EXT_FILES ?>" required>
    <div class="col-sm-0" style="font-size: 11px">
          <i>Max file 5 MB 
          <br>
            Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
          </i>
   </div>
    <?php } else { ?>
    <p class="form-control-static">
      <?php echo (!empty($header['attachment'])) ? $header['attachment'] : ""; ?>
    </p>
    <?php } ?>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
      $('#do_attachment').bind('change', function(event) {
            var ext = $(this).val().split('.').pop().toLowerCase();
            var files = event.target.files; 
            if (files[0].size > 5242880) {
              $(this).val('');
              alert('File tidak boleh lebih dari 5MB');
            }else if($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
                $(this).val('');
                alert('Format file tidak sesuai');
            }
        });
  });
</script>
