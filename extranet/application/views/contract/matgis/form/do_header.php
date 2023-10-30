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
  <label class="col-sm-2 control-label">Nomor DO *</label>
  <div class="col-sm-8">
    <input type="text" name="do_number" id="do_number" class="form-control" value="<?php echo $curval ?>" required>
  </div>
</div>


<?php $curval = (isset($header['do_title'])) ? $header['do_title']: ""; ?>
<div class="form-group" style="display: none">
  <label class="col-sm-2 control-label">Judul DO</label>
  <div class="col-sm-8">
    <input type="text" name="do_title" id="do_title" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = (isset($header['do_notes'])) ? $header['do_notes']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Catatan DO</label>
  <div class="col-sm-8">
    <input type="textarea" name="do_notes" id="do_notes" class="form-control" value="<?php echo $curval ?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">
    Lampiran *
  </label>
  <div class="col-lg-3 m-l-n">
    <?php if($state==0){ ?>
    <input type="file" class="form-control" id="do_attachment" name="attachment" accept="<?php echo ALLOWED_EXT_FILES ?>" required>
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
