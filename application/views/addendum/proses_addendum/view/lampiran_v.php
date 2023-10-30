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

       <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Kirim ke Vendor?</th>
            <th>File</th>
          </tr>
        </thead>

        <tbody>
         <?php 
         $sisa = 5;
         if(isset($document) && !empty($document)){
          foreach ($document as $k => $v) {
            if(!empty($v['filename'])){
              ?>
              <tr>
                <td><?php echo $k+1 ?></td>
                <td><?php echo $v['description'] ?></td>
                <td><?php echo ($v['publish']) ? "Ya" : "Tidak" ?></td>
                <td><a href="<?php echo INTRANET_UPLOAD_FOLDER."uploads/contract/document/".$v['filename'] ?>" target="_blank"><?php echo $v['filename'] ?></a></td>
              </tr>

              <?php } } } ?>
            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>