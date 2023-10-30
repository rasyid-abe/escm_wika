<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">    
        <div class="col-lg-12">
            <div class="card float-e-margins">
        
                <div class="card-title">
                  <h5>Total RFQ dan Kontrak</h5>
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
                                    <div style="min-height: 340px" class="widget style lazur-bg p-xl text-center " >
                                        <div class="form-group">
                                            <div class="col-sm-6 text-center">
                                                <h2 class="control-label">RFQ</h2>
                                                <hr>
                                                <br>
                                                <br>
                                                <h2 >IDR <?php echo str_replace(',', '.',  number_format($prcsum)) ?></h2>
                                                <br>
                                                <br>
                                                <hr>
                                                <div class="form-group col-sm-12">
                                                    
                                                    <div class="form-group col-sm-6">
                                                        <h3>BARANG</h3>
                                                        <p>
                                                        <h3>IDR <?php echo str_replace(',', '.',  number_format($prcsumb)) ?></h3>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <h3>JASA</h3>
                                                        <p>
                                                        <h3>IDR <?php echo str_replace(',', '.',  number_format($prcsumj)) ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-sm-6 text-center">
                                                <h2 class="control-label">KONTRAK</h2>
                                                <hr>
                                                <br>
                                                <br>
                                                <h2 >IDR <?php echo str_replace(',', '.',  number_format($ctrsum)) ?></h2>
                                                <br>
                                                <br>
                                                <hr>
                                                <div class="form-group col-sm-12">
                                                    
                                                    <div class="form-group col-sm-6">
                                                        <h3>BARANG</h3>
                                                        <p>
                                                        <h3>IDR <?php echo str_replace(',', '.',  number_format($ctrsumb)) ?></h3>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <h3>JASA</h3>
                                                        <p>
                                                        <h3>IDR <?php echo str_replace(',', '.',  number_format($ctrsumj)) ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>           
                        </div>
                    </div>  
                            &nbsp;  
                </div>
            </div>
        </div>
    </div>
</div>
