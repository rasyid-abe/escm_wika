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

        <?php $curval = $permintaan["pr_subject_of_work"]  ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Paket</label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = $permintaan["pr_scope_of_work"] ; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi Paket</label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        </div>

      </div>


