<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Penetapan Pelaksana Pekerjaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="col-sm-4">
              </div>
              <div class="col-sm-4">
                <h2 align="center"><strong>
                  <?php if (isset($permintaan['vendor_name'])) { ?>
                    <a href='<?php echo site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$permintaan['vendor_id']) ?>' target='_blank'>
                    <?php echo $permintaan['vendor_name'];
                  }else{
                    echo "_";
                  } ?>
                  </a>
                </strong></h2>
              </div>
              <div class="col-sm-4">
              </div>
        </div>
      </div>

    </div>
  </div>
</div>