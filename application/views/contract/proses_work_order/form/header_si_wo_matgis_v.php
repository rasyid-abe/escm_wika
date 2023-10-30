<?php
// NOTE: Content Response Si
// 01-12-2018 07:41

?>
<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>Shipping Instruction</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">
        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor SI</label>
          <div class="col-sm-10">
            <p class="form-control-static">
              <?php $curval = (isset($si_id)) ? $si_id : ""; ?>
              <input type="hidden"  name="si_id" id="si_id" value="<?php echo $curval ?>">
              <?php $curval = (isset($si_number)) ? $si_number : ""; ?>
              <?php if(!empty($curval)){ ?>
                <?php echo $curval ?>
              <?php } else { ?>
                <!-- AUTO NUMBER -->
                <?php $curval = (isset($si_number)) ? $si_number: ""; ?>
                <input type="text" required name="si_number" id="si_number" value="<?php echo $curval ?>">
              <?php } ?>
            </p>
            <?php $curval = (isset($id)) ? $id: ""; ?>
            <input type="hidden"  name="id" id="id" value="<?php echo $curval ?>">

            <?php $curval = (isset($wo_id)) ? $wo_id : ""; ?>
            <input type="hidden" name="wo_id" value="<?php echo $curval ?>">
            <?php $curval = (isset($contract_id)) ? $contract_id : ""; ?>
            <input type="hidden" name="contract_id" value="<?php echo $curval ?>">

          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Upload Shipping Instruction</label>
          <input type="hidden" name="filename" id="filename">
          <div class="col-sm-10">
            <span class="input-group-btn">
              <button type="button" data-id="" data-folder="<?php echo $dir ?>" data-preview="" class="btn btn-primary upload">upload SI</button>
              <button type="button" class="btn btn-danger" id="hapus_file">Hapus SI</button>
            </span>
          </div>

        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Upload Preview</label>
          <img id="matgis_file" width="250">
        </div>

        <?php $curval = (isset($si_date)) ?  date("Y-m-d",strtotime($si_date)) : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tanggal SI</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="date" required name="si_date" class="form-control" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>
        <?php $curval = (isset($transporter_id)) ? $transporter_id : "" ; ?>
        <div class="form-group">
          <label class="col-md-2 control-label">Nama Transporter</label>
          <div class="col-md-6">
            <select class="form-control" name="transporter_id" id="transporter_id" required>
              <option value="" readonly>--Pilih Transporter--</option>
              <?php
              foreach($transporter as $key => $val){
                $selected = ($val['vendor_id'] == $curval) ? "selected" : "";
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['vendor_id'] ?>"><?php echo $val['vendor_name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <?php $curval = (isset($transporter_address)) ? $transporter_address : "" ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Alamat Transporter</label>
          <div class="col-sm-8">
            <textarea class="form-control" required name="transporter_address" id="transporter_address"><?php echo $curval ?></textarea>
          </div>
        </div>

        <?php $curval = (isset($transporter_pic)) ? $transporter_pic : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">PIC Transporter</label>
          <div class="col-sm-8">
            <input type="text" name="transporter_pic" id="transporter_pic" class="form-control" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($nama_barang)) ? $nama_barang: ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Barang</label>
          <div class="col-sm-8">
            <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="<?php echo $curval ?>">
          </div>
        </div>


        <?php $curval = (isset($vendor_name)) ? $vendor_name : $vendor_info->vendor_name; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Perusahaan(Pickup/Vendor)</label>
          <div class="col-sm-8">
            <input type="text" name="vendor_name" id="vendor_name" class="form-control" value="<?php echo $curval ?>">
          </div>
        </div>
        <?php $curval = (isset($vendor_id)) ? $vendor_id : $vendor_info->vendor_id; ?>
        <input type="hidden" name="vendor_id" id="vendor_id" class="form-control" value="<?php echo $curval ?>">
        <?php $curval = (isset($vendor_address)) ? $vendor_address: $vendor_info->address_street ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Alamat Pickup</label>
          <div class="col-sm-8">
            <textarea class="form-control" required name="vendor_address" id="vendor_address"><?php echo $curval ?></textarea>
          </div>
        </div>
        <?php $curval = (isset($vendor_pic)) ? $vendor_pic : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">PIC Pickup</label>
          <div class="col-sm-8">
            <input type="text" name="vendor_pic" id="vendor_pic" class="form-control" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($delivery_name)) ? $delivery_name : "" ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Perusahaan(Delivery)</label>
          <div class="col-sm-8">
            <input type="text" name="delivery_name" id="delivery_name" class="form-control" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($delivery_address)) ? $delivery_address : "" ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Alamat Delivery</label>
          <div class="col-sm-8">
            <textarea class="form-control" required name="delivery_address"><?php echo $curval ?></textarea>
          </div>
        </div>

        <?php $curval = (isset($delivery_pic)) ? $delivery_pic : "" ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">PIC Delivery</label>
          <div class="col-sm-8">
            <input type="text" name="delivery_pic" id="delivery_pic" class="form-control" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($delivery_date)) ?  date("Y-m-d",strtotime($delivery_date)) : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tanggal Delivery</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="date" required name="delivery_date" id="delivery_date" class="form-control" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>

        <?php $curval = (isset($si_notes)) ? $si_notes : "" ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Catatan Shipment Instruction</label>
          <div class="col-sm-8">
            <textarea class="form-control" required name="si_notes"><?php echo $curval ?></textarea>
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
  $("#si_number").focusout(function(e){
    $.ajax({
      url: "contract_matgis/number_exist/ctr_si_header/"+$("#si_number").val(),
      type: "post",
      success: function (response) {
        if(response=="true"){
          alert("NO SI sudah ada");
          $("#si_number").focus();
          $("#si_number").select();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  });

  $("#transporter_id").change(function(){
    $.ajax({
      url: "contract_matgis/get_vendor_address/"+$("#transporter_id").val(),
      type: "post",
      success: function (response) {
        $("#transporter_address").val(response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  });
});
</script>
