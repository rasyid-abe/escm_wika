<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_ruangan");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>Form</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="card-content">

            <?php $curval = set_value("name_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="name_inp" maxlength="50" name="name_inp" value="<?php echo $curval ?>">
              </div>
            </div>

            <?php $curval = set_value("desc_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Keterangan</label>
              <div class="col-sm-5">
                <textarea class="form-control" id="desc_inp" name="desc_inp"><?php echo $curval ?></textarea>
              </div>
            </div>

            <?php $curval = set_value("attachment_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" data-id="attachment_inp" data-folder="<?php echo $dir ?>" data-preview="preview_file" class="btn btn-primary upload">...</button> 
                  </span> 
                  <input readonly type="text" class="form-control" id="attachment_inp" name="attachment_inp" value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-url="" class="btn btn-primary preview_upload" id="preview_file">Preview</button> 
                  </span> 
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
          <?php echo buttonsubmit('administration/master_data/ruangan',lang('back'),lang('save')) ?>
        </div>
      </div>
    </div>

  </form>
</div>