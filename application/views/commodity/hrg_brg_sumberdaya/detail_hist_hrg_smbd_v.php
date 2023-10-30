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
      <?php $curval = (isset($mat_hist['mat_catalog_code'])) ? $mat_hist['mat_catalog_code'] : set_value("catalog_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('catalog') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control" id="catalog_inp" name="catalog_inp" value="<?php echo $curval ?>"> 
          </div>
        </div>
      
      <?php $curval = (isset($mat_hist['short_description'])) ? $mat_hist['short_description'] : set_value("short_description") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('description') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control" id="short_description" name="short_description" value="<?php echo $curval ?>"> 
          </div>
        </div>
        
        <?php $curval = (isset($mat_hist['del_point_name'])) ? $mat_hist['del_point_name'] : set_value("del_point_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('office') ?></label>
          <div class="col-sm-10">
           <input disabled type="text" class="form-control" id="short_description" name="short_description" value="<?php echo $curval ?>"> 
          </div>
        </div>
    
        <?php $curval = (isset($mat_hist['sourcing_id'])) ? $mat_hist['sourcing_id'] : set_value("sourcing_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('sourcing') ?></label>
          <div class="col-sm-10">
            <select disabled class="form-control select2" style="width:100%;" name="sourcing_inp[]">
              <option value=""> - </option>
              <?php foreach($list_sourcing as $key => $mat_histal){
                $selected = ($mat_histal['sourcing_id'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $mat_histal['sourcing_id'] ?>">
                <?php echo $mat_histal['sourcing_name'] ?> 
                (<?php echo ($mat_histal['sourcing_type'] == "N") ? "Nasional" : "Internasional" ?>)
                </option>
                <?php } ?>
            </select>
          </div>
        </div>

        <?php $curval = (isset($mat_hist['sourcing_date'])) ? $mat_hist['sourcing_date'] : set_value("sourcing_date_inp") ?>
        <?php $curval = date("d M Y H:i:s",strtotime($curval)) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('sourcing_date') ?></label>
          <div class="col-sm-10">
            <div class="input-group date">
              <input disabled type="text" name="sourcing_date_inp[]" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>
      
        <?php $curval = (isset($mat_hist['currency'])) ? $mat_hist['currency'] : set_value("currency_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('currency') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" maxlength="3" class="form-control" name="currency_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['unit_price'])) ? $mat_hist['unit_price'] : set_value("unit_price_inp") ?>
        <?php $curval = inttomoney($curval) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('unit_price') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control money" name="unit_price_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['handling_cost'])) ? $mat_hist['handling_cost'] : set_value("handling_cost_inp") ?>
        <?php $curval = inttomoney($curval) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('handling_cost') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control money" name="handling_cost_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['insurance_cost'])) ? $mat_hist['insurance_cost'] : set_value("insurance_cost_inp") ?>
        <?php $curval = inttomoney($curval) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('insurance_cost') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control money" name="insurance_cost_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['freight_cost'])) ? $mat_hist['freight_cost'] : set_value("freight_cost_inp") ?>
        <?php $curval = inttomoney($curval) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('freight_cost') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control money" name="freight_cost_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['tax_duty'])) ? $mat_hist['tax_duty'] : set_value("tax_duty_inp") ?>
        <?php $curval = inttomoney($curval) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('tax_duty') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control money" name="tax_duty_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>


        <?php $curval = (isset($mat_hist['total_cost'])) ? $mat_hist['total_cost'] : set_value("total_cost_inp") ?>
        <?php $curval = inttomoney($curval) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('total_cost') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control money" name="total_cost_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['discount'])) ? $mat_hist['discount'] : set_value("discount_inp") ?>
        <?php $curval = inttomoney($curval) ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('discount') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control money" name="discount_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['vendor'])) ? $mat_hist['vendor'] : set_value("vendor_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('vendor') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control" name="vendor_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['notes'])) ? $mat_hist['notes'] : set_value("note_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('note') ?></label>
          <div class="col-sm-10">
            <input disabled type="text" class="form-control" name="note_inp[]" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($mat_hist['is_active'])) ? $mat_hist['is_active'] : set_value("active_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('active') ?>?</label>
          <div class="col-sm-10">
            <select disabled class="form-control select2" style="width:100%;" name="active_inp[]">
              <?php $selected = (0 == $curval) ? "selected" : "";  ?>
              <option <?php echo $selected ?> value="0">Ya</option>
              <?php $selected = (1 == $curval) ? "selected" : "";  ?>
              <option <?php echo $selected ?> value="1">Aktif</option>
            </select>
          </div>
        </div>

        <?php $curval = (isset($mat_hist['attachment'])) ? $mat_hist['attachment'] : set_value("attachment_inp") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input disabled type="text" class="form-control" id="attachment_inp_" name="attachment_inp[]" value="<?php echo $curval ?>">
              <span class="input-group-btn">
                <button type="button" data-url="<?php echo base_url("uploads/commodity/barang/$curval") ?>" class="btn btn-primary preview_upload" id="preview_file_">Preview</button> 
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