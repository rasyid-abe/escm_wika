<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Pesan Negosiasi</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="row form-group">
              <label class="col-sm-2 control-label">Vendor</label>
              <div class="col-sm-5">
                <select class="form-control select2 vendor" style="width:100%;" name="vendor_nego_inp">
                  <option value="">Pilih Vendor</option>
                  <?php foreach ($vendor as $kx => $vx) { ?>
                  <option value="<?php echo $vx['ptv_vendor_code'] ?>"><?php echo $vx['vendor_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-sm-2 control-label">Pesan *</label>
              <div class="col-sm-8">
                <textarea name="msg_nego_inp" maxlength="1000" class="form-control" placeholder="isi jika ingin melakukan negosiasi" style="margin: 0px 309.601px 0px 0px; width: 493px; height: 68px;"></textarea>
              </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
