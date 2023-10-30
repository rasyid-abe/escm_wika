<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>Buyer</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama *</label>
          <div class="col-sm-8">
           <select class="form-control select2" required name="pelaksana">
             <option value=""><?php echo lang('choose') ?></option>
             <?php

               foreach ($pelaksana as $key => $vv) {
                 $selected = ($vv['employee_id'] == $curval) ? "selected" : "";
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $vv['employee_id'] ?>">
                  <?php
                  echo $vv['fullname']." - ".$vv['pos_name'] ?>
                  </option>

              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
