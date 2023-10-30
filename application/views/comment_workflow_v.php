<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Daftar <?php echo lang('comment') ?></h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <table class="table comment">
              <thead>
                <tr>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th><?php echo lang('user') ?></th>
                  <th><?php echo lang('position') ?></th>
                  <th><?php echo lang('activity') ?></th>
                  <th><?php echo lang('response') ?></th>
                  <th><?php echo lang('comment') ?></th>
                </tr>
              </thead>
              <tbody>

                <?php if(isset($comment_list[$i]) && !empty($comment_list[$i])){ 

                  foreach ($comment_list[$i] as $kc => $vc) {
                  $start_date = date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_date']));
                  $end_date = (isset($vc['comment_end_date']) && !empty(strtotime($vc['comment_end_date']))) ? date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_end_date'])) : "";
                  ?>
                  <tr>
                    <td><?php echo $start_date ?></td>
                    <td><?php echo $end_date  ?></td>
                    <td><?php echo $vc['comment_name'] ?></td>
                    <td><?php echo $vc['position'] ?></td>
                    <td><?php echo $vc['activity_name'] ?></td>
                    <td><?php echo $vc['response'] ?></td>
                    <td><?php echo $vc['comments'] ?></td>
                  </tr>
                <?php } } ?>
                
              </tbody>
              
            </table>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Form <?php echo lang('comment') ?></h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="row form-group">
              <?php if(isset($workflow_list) && !empty($workflow_list)){ ?>
              <label class="col-sm-1 control-label">Aksi *</label>
              <div class="col-sm-5">
                <select class="form-control select2" style="width:100%;" name="status_inp[<?php echo $i ?>]">
                  <?php foreach ($workflow_list as $kx => $vx) { ?>
                  <option value="<?php echo $kx ?>"><?php echo $vx ?></option>
                  <?php } ?>
                </select>
              </div>
              <?php } ?>
            </div>

            <!-- hlmifzi -->
            <?php 
              $uri =$this->uri->segment(1,0);
              if ($uri == "commodity") {
                $date = "dateopen[$i]"; 
              }else{
                $date = "dateopen";
              }
            ?>
            <input type="hidden" class="form-control" name="<?php echo $date ?>" value="<?php echo date("Y-m-d H:i:s");?>">

            <?php $curval = set_value("comment_inp[$i]"); ?>
            <div class="row form-group">
              <label class="col-sm-1 control-label"><?php echo lang('comment') ?></label>
              <div class="col-sm-11">
                <textarea name="comment_inp[<?php echo $i ?>]" maxlength="1000" class="form-control" placeholder="Pesan..."><?php echo $curval ?></textarea>
              </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
