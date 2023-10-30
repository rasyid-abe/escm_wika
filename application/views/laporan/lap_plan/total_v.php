<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">    
    <div class="col-lg-12">
      <div class="card float-e-margins">
        
        <div class="card-title">
          <h5>Total Perencanaan</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="card-content" >

          <div class="form-group">
            
            <div class="form-group col-sm-12">
              <center>
                 <div class="widget style1 lazur-bg p-xl text-center " >
                    <div class="m-b-md">
                        <h1 class="font-bold">IDR <?php echo str_replace(',', '.',  number_format($total)) ?></h1>
                    </div>
                 </div>
                 
                <div class="widget lazur-bg p-xl text-center" style="min-height: 130px">

                  <div class="form-group">
                  
                    <div class="col-sm-6 text-left">
                        <h3 class="control-label">PROYEK</label>
                        <p>
                        <h2 >IDR <?php echo str_replace(',', '.',  number_format($totalrkp)) ?></h2>
                     </div>
                 
                     <div class="col-sm-6 text-right">
                          <h3 class="control-label">NON PROYEK</label>
                             <p>
                          <h2 >IDR <?php echo str_replace(',', '.',  number_format($totalrkap)) ?></h2>
                    </div>
                 </div>

                </div>       
              </center>

              <br>
              <br>

              <div class="form-group col-sm-6">
                <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_plan/all_dept"target="_blank">Detail Perencanaan Per Departemen</a>
              </div>

              <div class="form-group col-sm-6">
                <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_plan/all_coa"target="_blank">Detail Perencanaan Per COA</a>
              </div>
            </div>
            &nbsp;
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
