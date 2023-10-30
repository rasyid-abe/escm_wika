<form method="post" action="<?php echo site_url($controller_name."/submit_change_password");?>"  class="form-horizontal">

  <div class="row">
    <div class="col-12">
      <div class="card">
        
        <div class="card-header border-bottom pb-2">
            <h4 class="card-title">Form Ubah Password</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
              <?php $curval = $userdata['complete_name']; ?>
              <div class="row form-group">
                <label class="col-sm-3 control-label text-right">User</label>
                <div class="col-sm-5">
                <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <?php $curval = set_value("password_lama_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-3 control-label text-right">Password Lama</label>
                <div class="col-sm-5">
                <input type="password" class="form-control" required id="password_lama_inp" maxlength="28" name="password_lama_inp">
                </div>
              </div>

              <?php $curval = set_value("password_baru_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-3 control-label text-right">Password Baru</label>
                <div class="col-sm-5">
                <input type="password" class="form-control" required id="password_baru_inp" maxlength="28" name="password_baru_inp">
                </div>
              </div>

              <?php $curval = set_value("password_baru_ulang_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-3 control-label text-right">Ulangi Password Baru</label>
                <div class="col-sm-5">
                <input type="password" class="form-control" required id="password_baru_ulang_inp" maxlength="28" name="password_baru_ulang_inp">
                </div>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">				
        <div class="card-content">
          <div class="card-body">			                  
            <?php echo buttonsubmit('home',lang('back'),lang('save')) ?>      
          </div>
        </div>
      </div>
    </div>
  </div>

</form>