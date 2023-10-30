<?php
// NOTE: Content Response Si
// 01-12-2018 07:41

?>
<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>SPPM (Surat Permintaan Pengiriman Material)</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">
        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor SPPM</label>
          <div class="col-sm-10">
            <p class="form-control-static">
              <?php $curval = (isset($sppm_id)) ? $sppm_id : ""; ?>
              <input type="hidden"  name="sppm_id" id="sppm_id" value="<?php echo $curval ?>">
              <?php $curval = (isset($sppm_number)) ? $sppm_number : ""; ?>
              <?php if(!empty($curval)){ ?>
                <?php echo $curval ?>
              <?php } else { ?>
                <!-- AUTO NUMBER -->
                <?php $curval = (isset($sppm_number)) ? $sppm_number: ""; ?>
                <input type="text" required name="sppm_number" id="sppm_number" value="<?php echo $curval ?>">
              <?php } ?>
            </p>
          </div>
        </div>
        <div class="form-group">
          <?php $curval = (isset($contract_id)) ? $contract_id : ""; ?>
          <input type="hidden" name="contract_id" value="<?php echo $curval ?>">
          <label class="col-sm-2 control-label">Nomor Kontrak</label>
          <?php $curval = (isset($contract_number)) ? $contract_number : ""; ?>
          <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor WO</label>
          <?php $curval = (isset($wo_id)) ? $wo_id : ""; ?>
          <input type="hidden" name="wo_id" value="<?php echo $curval ?>">
          <?php $curval = (isset($wo_number)) ? $wo_number : ""; ?>
          <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Vendor</label>
          <?php $curval = (isset($vendor_name)) ? $vendor_name : ""; ?>
          <p class="col-sm-10 form-control-static"><?php echo $curval ?></p>
          <?php $curval = (isset($vendor_id)) ? $vendor_id : ""; ?>
          <input type="hidden" name="vendor_id" value="<?php echo $curval ?>">
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Upload File SPPM</label>
          <input type="hidden" name="filename" id="filename">
          <div class="col-sm-10">
            <span class="input-group-btn">
              <button type="button" data-id="" data-folder="<?php echo $dir ?>" data-preview="" class="btn btn-primary upload">upload file</button>
              <button type="button" class="btn btn-danger" id="hapus_file">Hapus File</button>
            </span>
          </div>

        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Upload Preview</label>
          <img id="matgis_file" width="250">
        </div>

        <?php $curval = (isset($sppm_date)) ?  date("Y-m-d",strtotime($sppm_date)) : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tanggal SPPM</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="date" required name="sppm_date" class="form-control" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>
        <?php $curval = (isset($sppm_request_date)) ?  date("Y-m-d",strtotime($sppm_request_date)) : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tanggal Permintaan Pengiriman</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="date" required name="sppm_request_date" class="form-control" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>

        <?php $curval = (isset($sppm_title)) ? $sppm_title: ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Judul SPPM</label>
          <div class="col-sm-8">
            <input type="text" name="sppm_title" id="sppm_title" class="form-control" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($sppm_notes)) ? $sppm_notes : "" ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Catatan SPPM</label>
          <div class="col-sm-8">
            <textarea class="form-control" required name="sppm_notes" id="sppm_notes"><?php echo $curval ?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function () {
  $("#hapus_file").click(function(){
    $("#matgis_file").attr("src", "");
    $.ajax({
      url: "contract/DeleteFile/"+$("#filename").val(),
      type: "post",
      data: {filename:$("#filename").val()} ,
      success: function (response) {
        alert("file dihapus");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });

  });
  // NOTE: Check SI Number Exisit or not
  $("#sppm_number").focusout(function(){
    $.ajax({
      url: "contract_matgis/number_exist/ctr_sppm_header/"+$("#sppm_number").val(),
      type: "post",
      success: function (response) {
        if(response=="true"){
          alert("NO SPPM sudah ada");
          $("#sppm_number").focus();
          $("#sppm_number").select();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  });

});
</script>
