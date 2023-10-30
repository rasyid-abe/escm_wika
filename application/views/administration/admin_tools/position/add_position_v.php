  <form method="post" action="<?php echo site_url($controller_name."/submit_add_position");?>"  class="form-horizontal">

  <div class="row">
    <div class="col-12">
      <div class="card">
        
        <div class="card-header border-bottom pb-2">
            <h4 class="card-title">Tambah Posisi</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
              <?php $curval = set_value("pos_name_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Nama Posisi</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="pos_name_inp" maxlength="255" name="pos_name_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = set_value("job_title_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Jabatan</label>
                <div class="col-sm-5">
                <select required class="form-control select2" name="job_title_inp">
                  <option value="">Pilih</option>
                  <?php 
                  foreach($jobtitle as $key => $val){
                    $selected = ($val['job_title'] == $curval) ? "selected" : ""; 
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['job_title'] ?>"><?php echo $val['job_title'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <?php $curval = set_value("dept_id_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Departemen</label>
                <div class="col-sm-5">
                <select required class="form-control select2" name="dept_id_inp">
                  <option value="">Pilih</option>
                  <?php 
                  foreach($dept as $key => $val){
                    $selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dept_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <?php $curval = set_value("district_id_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Kantor</label>
                <div class="col-sm-5">
                <select required class="form-control select2" name="district_id_inp">
                  <option value="">Pilih</option>
                  <?php 
                  foreach($district as $key => $val){
                    $selected = ($val['district_id'] == $curval) ? "selected" : ""; 
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
        <?php echo buttonsubmit('administration/admin_tools/position',lang('back'),lang('save')) ?>      
    </div>
  </div>

</form>