<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_kategori_pajak");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>Tambah Kategori Pajak</h5>
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

          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div style="margin-bottom: 60px;">
          <?php echo buttonsubmit('administration/master_data/kategori_pajak',lang('back'),lang('save')) ?>
        </div>
      </div>
    </div>

  </form>
</div>