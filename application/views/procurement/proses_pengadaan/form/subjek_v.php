<div class="row" id="vendor_container">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>Headline</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      
      <div class="card-content">

        <?php 
        if($permintaan["joinrfq"] == NULL ){
          $tender = $permintaan['pr_number']; 
          $text = "No. Paket Pengadaan";
        }else{
          $tender = $permintaan["joinrfq"]; 
          $text = "No. Tender";
        }
        ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo $text ?></label>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $tender ?></p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Paket</label>
          <div class="col-sm-10">
             <input type="text" class="form-control" name="nama_pekerjaan" id="nama_pekerjaan" placeholder="Wajib diisi jika ingin melakukan join paket pengadaan">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi Paket</label>
          <div class="col-sm-10">
            <textarea type="text" class="form-control" id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" placeholder="Wajib diisi jika ingin melakukan join paket pengadaan"></textarea>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>