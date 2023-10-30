<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>LAMPIRAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

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
                <?php $url=base_url().'index.php/log/download_attachment/matgis/'.$reff.'/'.$v['filename'];
                $url=str_replace("extranet/","",$url);
                ?>
                <td><a href="<?php echo $url?>" target="_blank">
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
