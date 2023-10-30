<div class="wrapper wrapper-content animated fadeInRight">
  <form  class="form-horizontal">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
      <div class="card-content">
      <?php $curval = (isset($srv_hist['srv_catalog_code'])) ? $srv_hist['srv_catalog_code'] : set_value("catalog_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('catalog') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control" id="catalog_inp" name="catalog_inp" value="<?php echo $curval ?>"> 
          </div>
        </div>
      
      <?php $curval = (isset($srv_hist['short_description'])) ? $srv_hist['short_description'] : set_value("short_description") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('description') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control" id="short_description" name="short_description" value="<?php echo $curval ?>"> 
          </div>
        </div>
        
        <?php $curval = (isset($srv_hist['del_point_name'])) ? $srv_hist['del_point_name'] : set_value("del_point_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('office') ?></label>
          <div class="col-sm-10">
           <input disabled type="text" class="form-control" id="short_description" name="short_description" value="<?php echo $curval ?>"> 
          </div>
        </div>

        <?php $curval = (isset($srv_hist['sourcing_id'])) ? $srv_hist['sourcing_id'] : set_value("sourcing_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('sourcing') ?></label>
          <div class="col-sm-10">
            <select disabled class="form-control select2" style="width:100%;" name="sourcing_inp">
              <option value=""><?php echo lang('choose') ?></option>
              <?php foreach($list_sourcing as $key => $val){
                $selected = ($val['sourcing_id'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['sourcing_id'] ?>">
                <?php echo $val['sourcing_name'] ?> 
                (<?php echo ($val['sourcing_type'] == "N") ? "Nasional" : "Internasional" ?>)
                </option>
                <?php } ?>
              </select>
            </div>
          </div>

         <?php $curval = (isset($srv_hist['sourcing_date'])) ? $srv_hist['sourcing_date'] : set_value("sourcing_date_inp") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('sourcing_date') ?></label>
                <div class="col-sm-10">
                  <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input disabled type="text" name="sourcing_date_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
                  </div>
                </div>
              </div>

              <?php $curval = (isset($srv_hist['currency'])) ? $srv_hist['currency'] : set_value("currency_inp") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('currency') ?></label>
                <div class="col-sm-10">
                  <input disabled type="text" maxlength="3" class="form-control" name="currency_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = (isset($srv_hist['total_price'])) ? $srv_hist['total_price'] : set_value("total_price_inp") ?>              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('total_cost') ?></label>
                <div class="col-sm-10">
                <input disabled type="text" class="form-control money" name="total_price_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = (isset($srv_hist['vendor'])) ? $srv_hist['vendor'] : set_value("vendor_inp") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('vendor') ?></label>
                <div class="col-sm-10">
                  <input disabled type="text" class="form-control" name="vendor_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = (isset($srv_hist['notes'])) ? $srv_hist['notes'] : set_value("note_inp") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('note') ?></label>
                <div class="col-sm-10">
                  <input disabled type="text" class="form-control" name="note_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = (isset($srv_hist['is_active'])) ? $srv_hist['is_active'] : set_value("active_inp") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('active') ?>?</label>
                <div class="col-sm-10">
                  <select disabled class="form-control select2" style="width:100%;" name="active_inp">
                    <?php $selected = (0 == $curval) ? "selected" : "";  ?>
                    <option <?php echo $selected ?> value="0">Ya</option>
                    <?php $selected = (1 == $curval) ? "selected" : "";  ?>
                    <option <?php echo $selected ?> value="1">Aktif</option>
                  </select>
                </div>
              </div>

              <?php $curval = (isset($srv_hist['attachment'])) ? $srv_hist['attachment'] : set_value("attachment_inp") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
              <div class="col-sm-10">
                <div class="input-group">
                  <input disabled type="text" class="form-control" id="attachment_inp" name="attachment_inp" value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-url="<?php echo base_url("uploads/commodity/jasa/$curval") ?>" class="btn btn-primary preview_upload" id="preview_file">Preview</button> 
                  </span> 
                </div>
              </div>
            </div>
        
        </div>
      </div>
    </div>
  </div>
  </form>
</div>