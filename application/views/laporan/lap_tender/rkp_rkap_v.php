
<div class="wrapper wrapper-content animated fadeInRight">
   <div class="row">    
      <div class="col-lg-12">
         <div class="card float-e-margins">
        
            <div class="card-title">
               <h5>Perencanaan Seluruh Departemen</h5>
               <div class="card-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
               </div>
            </div>

            <div class="card-content" >


               <div class="form-group ">

                  <div class="col-lg-12">
                  <br>

                     <div class="col-lg-6">
                        <table class="table table-bordered " >
                           <thead>
                              <tr>
                                 <th colspan="3"><center>RFQ</center></th>
                              </tr> 
                              <tr>
                                 <th><center>Departemen</center></th>
                                 <th><center>Proyek</center></th>
                                 <th><center>Non Proyek</center></th>
                              </tr> 
                           </thead>
                          <tbody>
                              <?php 
                                 $ldeprfq = "";
                                 $rkprfq = 0;
                                 $rkaprfq = 0;
                                 foreach (array_reverse($rfq) as $key => $value) { 
                                    if ($ldeprfq != $value['dept_name']) { ?>
                                       <tr>
                                          <td align="center"><a href="<?php echo site_url('/laporan/lap_tender/per_dept').'/'.$value['dept_id'] ?>" target="_blank" ><?php echo $value['dept_name'] ?></a></td>
                                          <td align="right"><?php echo str_replace(',', '.',  number_format($value['sumrkp'])) ?></td>
                                          <td align="right"><?php echo str_replace(',', '.',  number_format($value['sumrkap'])) ?></td>
                                       </tr>
                                 <?php 
                                 $rkprfq += $value['sumrkp'];
                                 $rkaprfq += $value['sumrkap'];
                                 $ldeprfq = $value['dept_name'];
                                  } } ?>
                               <tr>
                                  <th style="text-align: center" valign="center" rowspan="2">Total</th>
                                  <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($rkprfq)) ?></th>
                                  <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($rkaprfq)) ?></th>
                               </tr>
                               <tr>
                                  <th colspan="2"><center><?php echo str_replace(',', '.',  number_format($rkprfq+$rkaprfq)) ?></center></th>
                            </tbody>
                        </table>
                     </div>


                     <div class="col-lg-6">
                        <table class="table table-bordered">
                           <thead>
                              <tr>
                                 <th colspan="3"><center>KONTRAK</center></th>
                              </tr> 
                              <tr>
                                 <th><center>Departemen</center></th>
                                 <th><center>Proyek</center></th>
                                 <th><center>Non Proyek</center></th>
                              </tr>
                           </thead>
                            <tbody>
                              <?php 
                              $ldepctr = "";
                              $rkpctr = 0;
                              $rkapctr = 0;
                              foreach (array_reverse($contract) as $key => $value) { 
                                 if ($ldepctr != $value['dept_name']) { ?>
                                    <tr>
                                       <td align="center"><a href="<?php echo site_url('/laporan/lap_tender/per_dept').'/'.$value['dept_id'] ?>" target="_blank" ><?php echo $value['dept_name'] ?></a></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['sumrkp'])) ?></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['sumrkap'])) ?></td>
                                    </tr>
                              <?php 
                              $rkpctr += $value['sumrkp'];
                              $rkapctr += $value['sumrkap'];
                              $ldepctr = $value['dept_name'];
                               } } ?>
                              <tr>
                                 <th style="text-align: center" valign="center" rowspan="2">Total</th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($rkpctr)) ?></th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($rkapctr)) ?></th>
                              </tr>
                              <tr>
                                 <th colspan="2"><center><?php echo str_replace(',', '.',  number_format($rkpctr+$rkapctr)) ?></center></th>
                           </tbody>
                              
                        </table>
                     </div>
                  </div>

               </div>
               &nbsp;

            </div>
         </div>
      </div>
   </div>
</div>