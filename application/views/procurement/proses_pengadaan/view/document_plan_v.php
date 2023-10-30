<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Dokumen</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <table class="table table-bordered default">
          <thead>
            <tr>
              <th>No</th>
              <th>Kategori</th>
              <th>Deskripsi</th>
              <th>File</th>
            </tr>
          </thead>

          <tbody>
          <?php 
          $sisa = 5;
          if(isset($document) && !empty($document)){
            foreach ($document as $k => $v) {
              if(!empty($v['ppd_file_name'])){
                ?>
                <tr>
                  <td><?php echo $k+1 ?></td>
                  <td><?php echo $v["ppd_category"] ?></td>
                  <td><?php echo $v['ppd_description'] ?></td>
                  <td><a href="<?php echo site_url('log/download_attachment/procurement/perencanaan/'.$v['ppd_file_name']) ?>" target="_blank">
                  <?php echo $v['ppd_file_name'] ?>
                  </a></td>
                </tr>

                <?php } } } ?>
              </tbody>
            </table>
        </div>
      </div>

    </div>
  </div>
</div>
