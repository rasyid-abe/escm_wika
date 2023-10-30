<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>Manajer Pengadaan</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

        <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama *</label>
          <div class="col-sm-8">
           <select class="form-control" required name="manager_inp">
             <option value=""><?php echo lang('choose') ?></option>
             <?php foreach($manajer_pengadaan as $key => $val){
              $selected = ($val['employee_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['employee_id'] ?>">
              <?php echo $val['complete_name'] ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>