<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name . "/submit_edit_user_access"); ?>" class="form-horizontal">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins p-3">
          <div class="card-title">
            <h5>Ubah User</h5>
          </div>
          <div class="card-content">

            <div class="form-group row mb-1">
              <div class="col-md-6">
                <?php $curval = $data["employeeid"]; ?>
                <label class="col-sm-4 control-label">Employee Name</label>
                <div class="col-sm-8">
                  <select required class="form-control" name="employeeid_inp">
                    <option value="">Pilih</option>
                    <?php
                    foreach ($employee_name as $key => $val) {
                      $selected = ($val['id'] == $curval) ? "selected" : "";
                    ?>
                      <option <?php echo $selected ?> value="<?php echo $val['id'] ?>"><?php echo $val['fullname'] ?> - <?php echo $val['pos_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <?php $curval = $data["user_name"]; ?>
                <label class="col-sm-4 control-label">Username</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="user_name_inp" maxlength="50" name="user_name_inp" value="<?php echo $curval ?>">
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <?php $curval = $data["complete_name"]; ?>
                <label class="col-sm-4 control-label">Nama Lengkap User</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="complete_name_inp" maxlength="255" name="complete_name_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label class="col-sm-4 control-label">Password</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="password_inp" maxlength="255" name="password_inp" value="">
                </div>
              </div>
            </div>

            <div class="form-group">
              <?php $curval = $data["is_locked"]; ?>
              <label class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <div class="checkbox">
                  <label>
                    <?php $selected = (0 == $curval) ? "" : "checked";  ?>
                    <input type="checkbox" <?php echo $selected ?> name="is_locked_inp" value="1"> Terkunci
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div style="margin-bottom: 60px;">
          <?php echo buttonsubmit('administration/user_management/user_access', lang('back'), lang('save')) ?>
        </div>
      </div>
    </div>
  </form>
</div>