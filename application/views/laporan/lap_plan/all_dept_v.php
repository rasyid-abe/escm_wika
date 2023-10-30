
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
                                 <th colspan="2"><center>PROYEK</center></th>
                              </tr> 
                           </thead>
                           <tbody>
                              <?php 
                              $ldep = "";
                              $totrkp = 0;
                              foreach (array_reverse($rkpdept) as $key => $value) { 
                                 if ($ldep != $value['dept']) { ?>
                                    <tr>
                                       <td align="center"><a href="<?php echo site_url('/laporan/lap_plan/dept').'/'.$value["dept_id"] ?>" target="_blank" ><?php echo $value['dept']; ?></a></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['sum'])) ?></td>
                                    </tr>
                              <?php 
                              $totrkp += $value['sum'];
                              $ldep = $value['dept'];
                               } } ?>
                              <tr>
                                 <th style="text-align: center;">Total</th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($totrkp)) ?></th>
                              </tr>
                           </tbody>
                        </table>
                     </div>


                     <div class="col-lg-6">
                        <table class="table table-bordered">
                           <thead>
                              <tr>
                                 <th colspan="2"><center>NON PROYEK</center></th>
                              </tr> 
                           </thead>
                            <tbody>
                              <?php 
                              $ldep = "";
                              $totrkap = 0;
                              foreach (array_reverse($rkapdept) as $key => $value) { 
                                 if ($ldep != $value['dept']) { ?>
                                    <tr>
                                        <td align="center"><a href="<?php echo site_url('/laporan/lap_plan/dept').'/'.$value["dept_id"] ?>" target="_blank" ><?php echo $value['dept']; ?></a></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['sum'])) ?></td>
                                    </tr>
                              <?php 
                              $totrkap += $value['sum'];
                              $ldep = $value['dept'];
                               } } ?>
                              <tr>
                                 <th style="text-align: center;">Total</th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($totrkap)) ?></th>
                              </tr>
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