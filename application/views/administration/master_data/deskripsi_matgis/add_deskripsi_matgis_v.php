<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_deskripsi_matgis");?>"  class="form-horizontal">

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

            <?php $curval = set_value("label_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Judul</label>
              <div class="col-sm-10">
                <input required type="text" class="form-control" id="label_inp" maxlength="240" name="label_inp" value="<?php echo $curval ?>">
              </div>
            </div>

            <?php $curval = set_value("desc_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Deskripsi</label>
              <div class="col-sm-10">
                <input required type="text" class="form-control" id="desc_inp" maxlength="400" name="desc_inp" value="<?php echo $curval ?>">
              </div>
            </div>

         </div>
       </div>
     </div>
   </div>

   <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('administration/master_data/deskripsi_matgis',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>