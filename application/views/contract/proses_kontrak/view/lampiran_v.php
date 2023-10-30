<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
        <h4 class="card-title float-left">Dokumen</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Dokumen</th>
                <th>Lampiran</th>
                <th>Signor</th>
                <th>Tanggal Upload</th>
                <th>Keterangan</th>
                <th>Kirim Vendor</th>
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
                  <td><?php echo $v['name_input'] ?></td>
                  <td><a href="<?php echo site_url("log/download_attachment/contract/document/".$v['filename']) ?>" target="_blank"><?php echo $v['filename'] ?></a></td>                  
                  <td><?php echo $v['signor'] ?></td>
                  <td><?php echo $v['upload_date'] ?></td>
                  <td><?php echo $v['description'] ?></td>
                  <td>                    
                    <?php echo $v['publish'] == '1' ? 'Ya' : 'Tidak'; ?>
                  </td>
                </tr>

                <?php } } } ?>
              </tbody>
            </table>
        </div>
      </div>

    </div>
  </div>
</div>