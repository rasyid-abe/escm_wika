<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title"><?php echo lang('comment') ?></h4>
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
