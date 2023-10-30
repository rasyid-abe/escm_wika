<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5><?php echo lang('comment') ?></h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content"> 
        <table class="table comment">
          <thead>
            <tr>
              <th><?php echo lang('date') ?></th>
              <th><?php echo lang('user') ?></th>
              <th><?php echo lang('position') ?></th>
              <th><?php echo lang('response') ?></th>
              <th><?php echo lang('comment') ?></th>
            </tr>
          </thead>
          <tbody>

            <?php
             if(isset($comment_list) && !empty($comment_list)){ 

              foreach ($comment_list as $kc => $vc) {
                $start_date = date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_date']));
                ?>
                <tr>
                  <td><?php echo $start_date ?></td>
                  <td><?php echo $vc['comment_name'] ?></td>
                  <td><?php echo $vc['pos_name'] ?></td>
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
