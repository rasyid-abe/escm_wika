<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>LAMPIRAN</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

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
         if(isset($documents)){
          foreach ($documents as $k => $v) {
            if($v['filename']!==""){
              ?>
              <tr>
                <td><?php echo $k+1 ?></td>
                <td><?php echo $v["category"] ?></td>
                <td><?php echo $v['description'] ?></td>
                <td><a href="<?php echo site_url('log/download_attachment_extranet/'.$reff.'/'.$vendor_id.'/'.$v['filename']) ?>" target="_blank">
                <?php echo $v['filename'] ?>
                </a></td>
              </tr>

              <?php } } } ?>
            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>
