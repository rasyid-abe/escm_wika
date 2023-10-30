
  <form class="col-md-12" method="post" action="<?php echo site_url($controller_name."/submit_add_anggaran");?>">
    <div class="card">
      <div class="card-body">
         <div class="form-group">
            <label class="control-label">Kode Anggaran</label>
            <input type="text" class="form-control" maxlength="12" name="kode_perkiraan">
          </div>

          <div class="form-group">
            <label class="control-label">Nama Anggaran</label>
            <input type="text" class="form-control" maxlength="255" name="nama_perkiraan">
          </div>

          <div class="form-group">
            <label class="checkbox-inline col-sm-3">
              <input type="checkbox" class="form-check-input" value="t" name="pusat"> Pusat
            </label>
            <label class="checkbox-inline col-sm-3">
              <input type="checkbox" class="form-check-input" value="t" name="devisi"> Divisi
            </label>
            <label class="checkbox-inline col-sm-3">
              <input type="checkbox" class="form-check-input" value="t" name="proyek"> Proyek
            </label>
          </div>

          <!-- <?php $curval = set_value("subcode_inp"); ?>
          <div class="form-group" style="display: none">
            <label class="col-sm-2 control-label">Kode COA*</label>
            <div class="col-sm-8">
            <input type="text" required maxlength="50" class="form-control" id="subcode_inp" maxlength="50" name="subcode_inp" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = set_value("subname_inp"); ?>
          <div class="form-group" style="display: none">
            <label class="col-sm-2 control-label">Nama COA*</label>
            <div class="col-sm-8">
              <input type="text" required class="form-control" id="subname_inp" maxlength="255" name="subname_inp" value="<?php echo $curval ?>">
            </div>
          </div> -->

        </div>
      </div>
      <?= buttonsubmit('administration/master_data/anggaran',lang('back'),lang('save')) ?>

    </form>
