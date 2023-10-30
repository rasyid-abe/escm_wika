<?php// print_r($header);?>
<?php $curval = (isset($header['contract_id'])) ? $header['contract_id'] : ""; ?>
<input type="hidden" name="contract_id" value="<?php echo $curval ?>">
<?php $curval = (isset($header['contract_id'])) ? $header['wo_id'] : ""; ?>
<input type="hidden" name="wo_id" value="<?php echo $curval ?>">
<?php
$curval=$header['spk_number']."-".$header['spk_name'];
?>
<div class="form-group">
  <label class="col-sm-2 control-label">No SPK</label>
  <div class="col-sm-6">
    <p class="form-control-static"><?php  echo $curval?></p>
  </div>
</div>

<?php
$curval=$header['wo_number'];
?>
<div class="form-group">
  <label class="col-sm-2 control-label">No PO</label>
  <div class="col-sm-6">
    <p class="form-control-static"><?php  echo $curval?></p>
  </div>
</div>

<?php $curval = (isset($header['si_date']))?$header['si_date']:date("Y-m-d");
$curval=date_create($curval);
$curval=date_format($curval,"Y-m-d");
?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal SI</label>
  <div class="col-sm-6">
      <p class="form-control-static"><?php  echo $curval?></p>
  </div>
</div>
<div class="card float-e-margins">
  <div class="card-title">
    <h5>Transporter</h5>
    <div class="card-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>
  </div>
  <div class="card-content">
    <!-- Start Content -->
    <?php

    if($header['nomor_kontrak_transporter']==""){
      $this->db->where('vendor_id',$header['transporter_id']);
      $vnd=$this->db->get('ctr_vnd_transporter')->row_array();
      $curval = "(".$vnd['nomor_kontrak'].")".$vnd['vendor_name'];
    }else{
      $curval = (isset($header['nomor_kontrak_transporter'])) ? $header['nomor_kontrak_transporter'] : "" ;
    }
?>
    <div class="form-group">
      <label class="col-sm-2 control-label">No. Kontrak Transporter*</label>
      <div class="col-sm-8">
        <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

    <?php $curval = (isset($header['transporter_address'])) ? $header['transporter_address'] : "" ; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Alamat Transporter</label>
      <div class="col-sm-8">
          <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

    <?php $curval = (isset($header['transporter_pic'])) ? $header['transporter_pic'] : ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">PIC Transporter</label>
      <div class="col-sm-8">
          <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>
    <!-- End Content -->
  </div>
</div>

<div class="card float-e-margins">
  <div class="card-title">
    <h5>Pickup Vendor</h5>
    <div class="card-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>
  </div>
  <div class="card-content">
    <?php $curval = (isset($header['vendor_name'])) ? $header['vendor_name'] :""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Perusahaan</label>
      <div class="col-sm-8">
        <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

    <?php $curval = (isset($header['vendor_id'])) ? $header['vendor_id']:0; ?>
    <input type="hidden" name="vendor_id" id="vendor_id" class="form-control" value="<?php echo $curval ?>">

    <?php $curval = (isset($header['address_street'])) ? $header['address_street']: "" ; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Alamat Pickup</label>
      <div class="col-sm-8">
        <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

    <?php $curval = (isset($header['vendor_pic'])) ? $header['vendor_pic'] : ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">PIC Pickup</label>
      <div class="col-sm-8">
          <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>
  </div>
</div>


<div class="card float-e-margins">
  <div class="card-title">
    <h5>Delivery</h5>
    <div class="card-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>
  </div>
  <div class="card-content">
    <?php $curval = (isset($header['delivery_name'])) ? $header['delivery_name'] : "" ; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Perusahaan</label>
      <div class="col-sm-8">
          <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

    <?php $curval = (isset($header['delivery_address'])) ? $header['delivery_address'] : "" ; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Alamat Delivery</label>
      <div class="col-sm-8">
          <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

    <?php $curval = (isset($header['delivery_pic'])) ? $header['delivery_pic'] : "" ; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">PIC Delivery</label>
      <div class="col-sm-8">
          <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

    <?php $curval = (isset($header['delivery_date'])) ?  date("Y-m-d",strtotime($header['delivery_date'])) : ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tanggal Delivery</label>
      <div class="col-sm-4">
          <p class="form-control-static"><?php  echo $curval?></p>
      </div>
    </div>

  </div>

</div>
<input type="hidden" name="no_kontrak" id="no_kontrak">
<input type="hidden" name="email_transporter" id="email_transporter">

<script type="text/javascript">

$("#transporter_id").change(function(){
  if( $(this).val()==""){

    $("#nomor_kontrak_transporter").prop('readonly', false);
    $("#transporter_address").val("");
    $('#no_kontrak').val("");
  }else {
    $.ajax({
      url: "index.php/contract_matgis/get_vendor_transporter_address/"+$("#transporter_id").val(),
      type: "post",
      success: function (response) {
        //console.log("success");
        $("#transporter_address").val(response['address_vendor']);
        $('#no_kontrak').val(response['nomor_kontrak']);
        $('#email_transporter').val(response['email']);
        $("#nomor_kontrak_transporter").prop('readonly', true);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }
});

$("#nomor_kontrak_transporter").focus(function(){
  $('#transporter_id').removeAttr('required');
});

$("#transporter_id").focus(function(){
  $('#nomor_kontrak_transporter').removeAttr('required');
});


</script>
