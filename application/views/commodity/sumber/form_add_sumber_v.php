<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_sumber");?>"  class="form-horizontal">

    <?php //echo buttonsubmit('commodity/data_referensi/sumber') ?>

    <input type="hidden" name="jumlah" value="<?php echo $jumlah ?>">

    <?php for ($i=0; $i < $jumlah; $i++) { ?>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>Form #<?php echo $i ?></h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">

            <?php $curval = set_value("name_inp[$i]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('sourcing') ?> *</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" required name="name_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
              </div>
            </div>

            <?php $curval = set_value("type_inp[$i]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('type') ?> *</label>
              <div class="col-sm-10">
                <select name="type_inp[<?php echo $i ?>]" class="form-control">
                  <?php $selected = ($curval == "N") ? "selected" : ""; ?>
                  <option <?php echo $selected ?> value="N">Nasional</option>
                  <?php $selected = ($curval == "I") ? "selected" : ""; ?>
                  <option <?php echo $selected ?> value="I">Internasional</option>
                </select>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <?php } ?>

    <?php echo buttonsubmit('commodity/data_referensi/sumber',lang('back'),lang('save')) ?>

  </form>

</div>