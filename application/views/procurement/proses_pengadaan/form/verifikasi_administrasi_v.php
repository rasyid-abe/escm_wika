<div class="row" id="vendor_container">
    <div class="col-12">
      <div class="card">
        
        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">VERIFIKASI ADMINISTRASI</h4>          
        </div>

        <div class="card-content">
          <div class="card-body">

            <div class="row">
              <div class="col-xs-2">
                <p>Nomor Pengadaan</p>
              </div>

              <div class="col-xs-3">
                <p><strong><?php echo $ptm_number ?></strong></p>
              </div>

              <div class="col-xs-2">
                <p>Nama Vendor</p>
              </div>

              <div class="col-xs-3">
                <p><strong><?php echo $vendor['vendor_name'] ?></strong></p>
              </div>
            </div>

            <?php if(!empty($administrasi) AND $status_vendor['pvs_status'] != 2 AND $status_vendor['pvs_status'] != 20){ ?>

            <form id="vendor<?php echo $vendor['vendor_id'] ?>">

              <input type="hidden" name="id" value="<?php echo $ptm_number ?>" />
              <input type="hidden" name="vnd" value="<?php echo $vendor['vendor_id'] ?>" />

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Lampiran</th>
                    <th>Cek Vendor</th>
                    <th>Cek Evaluasi</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($administrasi as $key => $value) { ?>

                  <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $value['pqt_item'] ?></td>            
                    <td>
                      <a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/administrasi/'.$vendor['vendor_id'].'/'.$value['pqt_attachment']); ?>">
                      <?php echo $value['pqt_attachment'] ?>
                    </td>            
                    <td class="text-center">
                      <div class="">
                        <label>
                          <input type="checkbox" disabled name="check_vendor[<?php echo $value['pqt_id'] ?>]" <?php echo ($value['pqt_check_vendor'] == 1) ? "checked" : "" ?>>
                          <?php if($value['pqt_check_vendor'] == 1){ ?>
                          <input type="hidden" name="check_vendor[<?php echo $value['pqt_id'] ?>]" value="on">
                          <?php } ?>
                        </label>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="">
                        <label>
                          <input type="checkbox" <?php echo ($act == "view") ? "disabled" : "" ?> name="check_evaluation[<?php echo $value['pqt_id'] ?>]" <?php echo ($value['pqt_check'] == 1) ? "checked" : "" ?>>
                        </label>
                      </div>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              
              <hr>

              <h4>Catatan</h4>
              
              <?php if($act == "edit"){ ?>
                <textarea class="form-control" name="note"><?php echo $status_vendor['pvs_technical_remark'] ?></textarea>
              <?php } else { ?>
                  <p><?php echo $status_vendor['pvs_technical_remark'] ?></p>
              <?php } ?>
                  
              <div class="row mt-3">
                <div class="col-sm-12 text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Tutup</button>
                    <?php if(!empty($administrasi) && $act == "edit"){ ?>
                    <button class="btn btn-info save_vadm" data-id="<?php echo $vendor['vendor_id'] ?>" type="button">Simpan</button>
                    <?php } ?>          
                </div>
              </div>  
            </form>

            <?php } else { ?>

            <h2 class="text-center">Vendor tidak dapat di verifikasi</h2>
            <br/>

            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>    