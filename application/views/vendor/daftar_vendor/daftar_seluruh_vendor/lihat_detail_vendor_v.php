<div class="row match-height">
  <div class="col-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title">Detail Data Vendor <?php echo $header['vendor_name'];?></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
              <form class="form-bordered">
                <?php
                  if ($header['vendor_type'] == 1) {
                    
                    include('view_tab/tab_non_perorangan_v.php');
                    
                  } elseif ($header['vendor_type'] == 2) {
                    
                    include('view_tab/tab_perorangan_v.php');

                  } elseif ($header['vendor_type'] == 3) {
                    
                    include('view_tab/tab_luar_negeri_v.php');
                    
                  }
                ?>                
              </form>
            </div>
        </div>
    </div>
</div>