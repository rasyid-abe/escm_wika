<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">    
        <div class="col-lg-12">
            <div class="card float-e-margins">
        
                <div class="card-title">
                  <h5>Total Pelaksanaan</h5>
                  <div class="card-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>

                <div class="card-content">

                    <div class="form-group">
                    
                        <div class="col-lg-12">
                            <div class="form-group col-sm-12">
                            
                                <center>
                                    <div style="min-height: 200px" class="widget style lazur-bg p-xl text-center " >
                                        <div class="form-group">
                                            <div class="col-1 text-right">
                                                <h3>Efisiensi IDR <?php echo str_replace(',', '.',  number_format($efisiensi)) ?> &nbsp;&nbsp;&nbsp;</h3>
                                                <h3><?php echo round($preeff, 2)?> % &nbsp;&nbsp;&nbsp;</h3>
                                            </div>
                                            <br>
                                            <div class="m-b-md">
                                                <h1 class="font-bold">IDR <?php echo str_replace(',', '.',  number_format($total)) ?></h1>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <h3>BARANG  IDR <?php echo str_replace(',', '.',  number_format($total_barang+$total_multi)) ?></h3>
                                            </div>
                                            
                                            <div class="col-sm-6 text-center">
                                                 <h3>JASA  IDR <?php echo str_replace(',', '.',  number_format($total_jasa)) ?></h3>
                                            </div>
                                        </div>

                                    </div>
                                </center>

                                <center>
                                    <div style="min-height: 140px" class="widget style lazur-bg p-xl text-center " >
                                        <div class="form-group">
                                           <div class="col-sm-6 text-left">
                                               <h3 class="control-label">PROYEK</label>
                                               <p>
                                               <h2 >IDR <?php echo str_replace(',', '.',  number_format($total_rkp)) ?></h2>
                                            </div>
                                        
                                            <div class="col-sm-6 text-right">
                                                 <h3 class="control-label">NON PROYEK</label>
                                                    <p>
                                                 <h2 >IDR <?php echo str_replace(',', '.',  number_format($total_rkap)) ?></h2>
                                           </div>
                                        </div>


                                    </div>
                                </center>

                                <!-- <br>

                                <center>
                                    <div style="min-height: 340px" class="widget style lazur-bg p-xl text-center " >
                                        <div class="form-group">
                                            <div class="col-sm-6 text-center">
                                                <h2 class="control-label">RFQ</h2>
                                                <hr>
                                                <br>
                                                <br>
                                                <h2 >IDR <?php echo str_replace(',', '.',  number_format($totalrkp)) ?></h2>
                                                <br>
                                                <br>
                                                <hr>
                                                <div class="form-group col-sm-12">
                                                    
                                                    <div class="form-group col-sm-6">
                                                        <h3>BARANG</h3>
                                                        <p>
                                                        <h3>IDR 400.000.000</h3>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <h3>JASA</h3>
                                                        <p>
                                                        <h3>IDR 400.000.000</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-sm-6 text-center">
                                                <h2 class="control-label">KONTRAK</h2>
                                                <hr>
                                                <br>
                                                <br>
                                                <h2 >IDR <?php echo str_replace(',', '.',  number_format($totalrkp)) ?></h2>
                                                <br>
                                                <br>
                                                <hr>
                                                <div class="form-group col-sm-12">
                                                    
                                                    <div class="form-group col-sm-6">
                                                        <h3>BARANG</h3>
                                                        <p>
                                                        <h3>IDR 400.000.000</h3>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <h3>JASA</h3>
                                                        <p>
                                                        <h3>IDR 400.000.000</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </center> -->
                            </div>               
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <div class="form-group col-sm-3">
                          <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_tender/rfq_contract" target="_blank">Detail RFQ dan Kontrak</a>
                        </div>

                        <div class="form-group col-sm-3">
                          <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_tender/rkp_rkap" target="_blank">Detail Proyek dan Non Proyek</a>
                        </div>

                        <div class="form-group col-sm-3">
                          <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_tender/time_duration"target="_blank">Detail Waktu Proses</a>
                        </div>

                        <div class="form-group col-sm-3">
                          <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/lap_tender/total_rfq"target="_blank">Detail RFQ Total</a>
                        </div>

                    </div>
                    &nbsp;
                </div>
            </div>
        </div>
    </div>
</div>
