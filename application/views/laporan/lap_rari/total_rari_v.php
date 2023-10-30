<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">    
    <div class="col-lg-12">
      <div class="card float-e-margins">
        
        <div class="card-title">
          <h5>Total Ra vs Ri</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="card-content" >

          <div class="form-group">
            
            <div class="form-group col-sm-12">
              <div class="form-group col-sm-6">
                <center>
                    <h2>RENCANA PENGADAAN</h2>
                    <div style="min-height: 200px" class="widget style lazur-bg p-xl text-center " >
                        <div class="form-group">
                          <div class="m-b-md">
                              <br/><br/><h1 class="font-bold">IDR <?php echo str_replace(',', '.',  number_format($totalplan)) ?></h1>
                          </div>
                        </div>
                   </div>
                   
                  <div class="widget lazur-bg p-xl text-center" style="min-height: 130px">

                    <div class="form-group">
                    
                      <div class="col-sm-6 text-left">
                          <h3 class="control-label">PROYEK</label>
                          <p>
                          <h3 >IDR <?php echo str_replace(',', '.',  number_format($totalrkp)) ?></h3>
                       </div>
                   
                       <div class="col-sm-6 text-right">
                            <h3 class="control-label">NON PROYEK</label>
                               <p>
                            <h3 >IDR <?php echo str_replace(',', '.',  number_format($totalrkap)) ?></h3>
                      </div>
                   </div>

                  </div>       
                </center>
              </div>
              <div class="form-group col-sm-6">
                <center>
                    <h2>REALISASI PENGADAAN</h2>
                    <div style="min-height: 200px" class="widget style lazur-bg p-xl text-center " >
                        <div class="form-group">
                            <div class="col-1 text-right">
                                <h3>Efisiensi IDR <?php echo str_replace(',', '.',  number_format($efisiensi)) ?> &nbsp;&nbsp;&nbsp;</h3>
                                <h3><?php echo round($preeff, 2)?> % &nbsp;&nbsp;&nbsp;</h3>
                            </div>
                            <br>
                            <div class="m-b-md">
                                <h1 class="font-bold">IDR <?php echo str_replace(',', '.',  number_format($totalrari)) ?></h1>
                            </div>
                           
                        </div>

                    </div>
                    <div class="widget lazur-bg p-xl text-center" style="min-height: 130px">

                      <div class="form-group">
                      
                        <div class="col-sm-6 text-left">
                            <h3 class="control-label">PROYEK</label>
                            <p>
                            <h3 >IDR <?php echo str_replace(',', '.',  number_format($total_rkp)) ?></h3>
                         </div>
                     
                         <div class="col-sm-6 text-right">
                              <h3 class="control-label">NON PROYEK</label>
                                 <p>
                              <h3 >IDR <?php echo str_replace(',', '.',  number_format($total_rkap)) ?></h3>
                        </div>
                     </div>
                </center>
              </div>
              <br>
              <br>

              <div class="form-group col-sm-12">
              <div class="form-group col-sm-6">
                <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_rari/all_dept_rari"target="_blank">Detail Per Departemen</a>
              </div>

              <div class="form-group col-sm-6">
                <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_rari/all_coa_rari"target="_blank">Detail Per COA</a>
              </div>
            </div>
            </div>
            &nbsp;
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
