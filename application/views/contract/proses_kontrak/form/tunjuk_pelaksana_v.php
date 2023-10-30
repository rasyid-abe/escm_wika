<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Pelaksana Kontrak</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <?php $curval = ""; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama *</label>
            <div class="col-sm-8">
            <select class="form-control" required name="pelaksana_kontrak_inp">
              <option value=""><?php echo lang('choose') ?></option>
              <?php foreach($pelaksana_kontrak as $key => $val){
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
</div>
