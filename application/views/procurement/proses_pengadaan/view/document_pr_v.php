<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Dokumen</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <table class="table table-striped">
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
              if (isset($document) && !empty($document)) {
                foreach ($document as $k => $v) {
                  $no = ($k+1);
              ?>
                  <tr>
                    <td>
                      <?php echo $no ?>
                      <input type="hidden" class="doc_id_inp" value="<?php echo $v['ppd_id'] ?>" name="doc_id_inp[<?php echo $no ?>]" data-no="<?php echo $no ?>">
                    </td>
                    <td class='text-left'>
                      <input type="hidden" class="doc_category_inp" value="<?php echo $v['ppd_category'] ?>" name="doc_category_inp[<?php echo $no ?>]" data-no="<?php echo $no ?>">
                      <?php echo $v['ppd_category'] ?>
                    </td>
                    <td class="text-left">
                      <input type="hidden" class="doc_attachment_inp" value="<?php echo $v['ppd_file_name']; ?>" name="doc_attachment_inp[<?php echo $no ?>]" data-no="<?php echo $no ?>">
                      <a href="<?php echo site_url("log/download_attachment/procurement/tender/") . $v['ppd_file_name'] ?>" target="_blank"><?php echo $v['ppd_file_name'] ?></a>
                    </td>
                    <td class="text-left">
                      <input type="hidden" class="doc_desc_inp" value="<?php echo $v['ppd_description'] ?>" name="doc_desc_inp[<?php echo $no ?>]" data-no="<?php echo $no ?>"><?php echo $v['ppd_description'] ?>
                    </td>
                  </tr>

              <?php }
              } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>