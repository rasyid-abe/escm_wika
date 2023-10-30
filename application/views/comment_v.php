<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title"><?php echo lang('comment') ?></h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <?php $curval = set_value("comment_inp[$i]"); ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label"><?php echo lang('comment') ?> *</label>
              <div class="col-sm-10">
                <textarea name="comment_inp[<?php echo $i ?>]" required class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>

            <br/>
            
            <table class="table comment">
              <thead>
                <tr>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th><?php echo lang('user') ?></th>
                  <th><?php echo lang('position') ?></th>
                  <th><?php echo lang('response') ?></th>
                  <th><?php echo lang('comment') ?></th>
                </tr>
              </thead>
              <tbody>

                <?php if(isset($comment_list[$i]) && !empty($comment_list[$i])){ 

                  foreach ($comment_list[$i] as $kc => $vc) {
                    $start_date = date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_date']));
                    $end_date = (isset($vc['comment_end_date'])) ? date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_end_date'])) : $start_date;
                    ?>
                    <tr>
                      <td><?php echo $start_date ?></td>
                      <td><?php echo $end_date  ?></td>
                      <td><?php echo $vc['comment_name'] ?></td>
                      <td><?php echo $vc['position'] ?></td>
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
