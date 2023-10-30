<div id="small-chat">
  <a href="index.php/laporan/xlsx_analisa_plan" type="button" class="btn btn-sm pull-right" data-toggle="tooltip" title="" target="_blank" style="background-color:green;color:white;margin-right:5px" data-original-title="Export Laporan Excel">
      <i class="fa fa-file-excel-o"></i> Export Excel
   </a>

  <a href="index.php/laporan/pdf_analisa_plan" type="button" class="btn btn-sm pull-right" data-toggle="tooltip" title="" target="_blank" style="background-color:red;color:white;margin-right:5px" data-original-title="Export Laporan PDF">
      <i class="fa fa-file-pdf-o"></i> Export PDF
   </a>
</div>

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
                   </center>
                 </div>


                 <div class="form-group col-sm-12">
                   <center>
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
                     <a class="btn btn-primary btn-rounded btn-block" href="<?php site_url();?>index.php/laporan/laporan_excel_klasifikasi_vendor">Lihat Perencanaan Per Departemen</a>
                   </div>
                   <div class="form-group col-sm-6">
                     <a class="btn btn-primary btn-rounded btn-block" href="#">Lihat Perencanaan Per COA</a>
                   </div>
                 </div>


           
               <!-- <?php  include("lap_plan/total_v.php"); ?> -->

               <?php  include("lap_plan/all_dept_v.php"); ?>
               
               <?php  include("lap_plan/detail_per_dept_v.php"); ?>

               <?php  include("lap_plan/detail_per_ma_v.php"); ?>
               
               <?php  include("lap_plan/detail_per_sma_v.php"); ?>
               
               <?php  include("lap_plan/detail_per_coa_v.php"); ?>
               
               &nbsp;
               
            </div>

         </div>
      </div>

   </div>
</div>