<input type="hidden" name="vendor_id" value="<?php echo $header['vendor_id']?>">
<input type="hidden" name="wo_id" value="<?php echo $header['wo_id']?>">
<input type="hidden" name="bapb_id" value="<?php echo $header['bapb_id']?>">
<input type="hidden" name="state" value="<?php echo $state?>">
<input type="hidden" name="contract_id" value="<?php echo $header['contract_id']?>">

<?php $curval = (isset($header['inv_number'])) ? $header['inv_number']: ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Nomor Tagihan *</label>
  <div class="col-sm-8">
    <input type="text" name="inv_number" id="inv_number" class="form-control" value="<?php echo $curval ?>" required>
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
  <label class="col-sm-2 control-label">Tanggal Invoice *</label>
  <div class="col-sm-4">
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="date" name="tgl_inv" id="tgl_inv" class="form-control" value="<?php echo $curval ?>" required>
      </div>
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
  <div class="col-lg-8">
    <?php if($state==0 || $state==3){ ?>
    <input type="file" class="form-control" name="attachment" id="inv_attachment" required accept="<?php echo ALLOWED_EXT_FILES ?>">
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
      $('#inv_attachment').bind('change', function(event) {
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
