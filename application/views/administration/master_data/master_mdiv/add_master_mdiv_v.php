<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>Tambah Master MDIV</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="card-content">

          <?php $curval = set_value("region_inp");   ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Wilayah</label>
            <div class="col-sm-5">
              <select required class="form-control" name="region_inp" id="region_inp">
                <option value="">Pilih</option>
                <?php 
                  foreach($region as $key => $val){
                  // $selected = ($key == $curval) ? "selected" : ""; ?> 
                <option value="<?php echo $val['region_id'] ?>"><?php echo $val['region_name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <?php $curval = set_value("pos_inp");   ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Posisi Manajer</label>
            <div class="col-sm-5">
              <select required class="form-control" name="pos_inp" id="pos_inp">
                <option value="">Pilih</option>
                <?php 
                  foreach($posisi as $key => $val){
                  // $selected = ($key['pos_id'] == $curval) ? "selected" : ""; ?> 
                <option value="<?php echo $val['pos_id'] ?>"><?php echo $val['pos_name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <?php $curval = set_value("dept_inp");  ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Divisi/Departemen</label>
            <div class="col-sm-5">
              <select required class="form-control" name="dept_inp" id="dept_inp">
                <option value="">Pilih</option>
                <?php 
                  foreach($dept as $key => $val){
                  // $selected = ($key['dept_id'] == $curval) ? "selected" : ""; ?> 
                <option value="<?php echo $val['dept_id'] ?>"><?php echo $val['dept_name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('administration/master_data/master_mdiv',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>
