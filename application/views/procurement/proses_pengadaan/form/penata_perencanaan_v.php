<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Penata Perancanaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <?php $curval = ""; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Penata Perencanaan *</label>
              <div class="col-sm-6">
              <select class="form-control" name="penata_perencanaan">
                <option value=""><?php echo lang('choose') ?></option>
                <?php foreach($penata_perencana as $key => $val){
                  $selected = ($val['employee_id'] == $curval) ? "selected" : ""; 
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $val['employee_id'] ?>"><?php echo $val['fullname'] ?> - <?php echo $val['pos_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>