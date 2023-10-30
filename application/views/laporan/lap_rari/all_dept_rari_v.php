
<div class="wrapper wrapper-content animated fadeInRight">
   <div class="row">    
      <div class="col-lg-12">
         <div class="card float-e-margins">
        
            <div class="card-title">
               <h5>Ra vs Ri Seluruh Departemen</h5>
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
                                 <th colspan="3"><center>PROYEK</center></th>
                              </tr> 
                              <tr>
                                 <th><center>Departemen</center></th>
                                 <th><center>Perencanaan</center></th>
                                 <th><center>Realisai</center></th>
                              </tr> 
                           </thead>
                           <tbody>
                              <?php 
                              $ldep = "";
                              $totrkp = 0;
                              $realrkp = 0;
                              foreach (array_reverse($rkpdept) as $key => $value) { 
                                 if ($ldep != $value['dept']) { ?>
                                    <tr>
                                       <td align="center"><a href="<?php echo site_url('/laporan/lap_rari/dept_rari').'/'.$value["dept_id"] ?>" target="_blank" ><?php echo $value['dept']; ?></a></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['sum'])) ?></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['real'])) ?></td>
                                    </tr>
                              <?php 
                              $totrkp += $value['sum'];
                              $realrkp += $value['real'];
                              $ldep = $value['dept'];
                               } } ?>
                              <tr>
                                 <th style="text-align: center;">Total</th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($totrkp)) ?></th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($realrkp)) ?></th>
                              </tr>
                           </tbody>
                        </table>
                     </div>


                     <div class="col-lg-6">
                        <table class="table table-bordered">
                           <thead>
                              <tr>
                                 <th colspan="3"><center>NON PROYEK</center></th>
                              </tr> 
                              <tr>
                                 <th><center>Departemen</center></th>
                                 <th><center>Perencanaan</center></th>
                                 <th><center>Realisai</center></th>
                              </tr> 
                           </thead>
                            <tbody>
                              <?php 
                              $ldep = "";
                              $totrkap = 0;
                              $realrkap = 0;
                              foreach (array_reverse($rkapdept) as $key => $value) { 
                                 if ($ldep != $value['dept']) { ?>
                                    <tr>
                                        <td align="center"><a href="<?php echo site_url('/laporan/lap_rari/dept_rari').'/'.$value["dept_id"] ?>" target="_blank" ><?php echo $value['dept']; ?></a></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['sum'])) ?></td>
                                       <td align="right"><?php echo str_replace(',', '.',  number_format($value['real'])) ?></td>
                                    </tr>
                              <?php 
                              $totrkap += $value['sum'];
                              $realrkap += $value['real'];
                              $ldep = $value['dept'];
                               } } ?>
                              <tr>
                                 <th style="text-align: center;">Total</th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($totrkap)) ?></th>
                                 <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($realrkap)) ?></th>
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