<form method="post" action="<?php echo site_url($controller_name."/submit_hierarchy_position");?>"  class="form-horizontal">

<input type="hidden" name="id" value="<?php echo $id ?>"/>
<input type="hidden" name="act" value="<?php echo $act ?>"/>
<input type="hidden" name="type" value="<?php echo $type ?>"/>

<div class="row">
  <div class="col-lg-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h5>Add Hierarchy Position</h5>            
      </div>

      <div class="card-content">

        <div class="card-body">
          <?php $curval = ($act != "add") ? $hie['parent_id'] : $id; ?>
          <div class="row form-group">
            <label class="col-sm-3 control-label">Parent Name</label>
            <div class="col-sm-6">
              <?php if($act != "add" OR $id == 'tambah'){ ?>
              <select class="form-control select2" name="parent_id_inp">
                <option value="">Pilih</option>
                <?php 
                foreach($parent_id as $key => $val){
                  $selected = ($val['auth_hie_id'] == $curval) ? "selected" : ""; 
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $val['auth_hie_id'] ?>"><?php echo $val['pos_name'] ?></option>
                  <?php } ?>
                </select>
                <?php } else { ?>
                <p class="form-control-static"><?php echo (!empty($hie['pos_name'])) ? $hie['pos_name'] : $hie_parent['pos_name']; ?></p>
                <input type="hidden" name="parent_id_inp" value="<?php echo $curval ?>"/>
              <?php } ?>
            </div>
          </div>

          <?php $curval = ($act != "add") ? $hie['pos_id'] : ""; ?>
          <div class="row form-group">
            <label class="col-sm-3 control-label">Job Position Name</label>
            <div class="col-sm-6">
             <select <?php echo ($act != "add") ? "disabled" : "required" ?> class="form-control select2" name="pos_id_inp">
              <option value="">Pilih</option>
              <?php 
              foreach($pos_id as $key => $val){
                $selected = ($val['pos_id'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['pos_id'] ?>"><?php echo $val['pos_name'] ?></option>
                <?php } ?>
              </select>
              <?php if($act != "add"){ ?>
              <input type="hidden" name="pos_id_inp" value="<?php echo $curval ?>"/>
              <?php } ?>
            </div>
          </div>

          <?php $curval = ($act != "add") ? $hie['max_amount'] : 0; ?>
          <div class="row form-group">
            <label class="col-sm-3 control-label">Maximum Amount Authority</label>
            <div class="col-sm-3">
              <input type="text" class="form-control money" id="max_amt_hrcpst_inp" name="max_amount_inp" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = $hie['currency']; ?>
          <div class="row form-group">
            <label class="col-sm-3 control-label">Currency</label>
            <div class="col-sm-3">
             <select required class="form-control select2" name="curr_code_inp">
              <option value="">Pilih</option>
              <?php 
              foreach($curr_id as $key => $val){
                $selected = ($val['curr_code'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['curr_code'] ?>"><?php echo $val['curr_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="row my-3">
            <?php echo buttonsubmit('administration/admin_tools/hierarchy_position',lang('back'),lang('save')) ?>              
          </div>
        </div>

      </div>
  </div>
</div>
</form>
