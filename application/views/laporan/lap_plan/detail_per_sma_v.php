<div class="form-group ">
   <div class="col-lg-12">
      <br>
      <hr class="hr-line-solid">
      <br>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th colspan="3"><center>PER SUB MATA ANGGARAN</center></th>
            </tr> 
         </thead>
          <tbody>
            <?php 
            $lma = "";
            $llma = "";
            $totrkap = 0;
            $nsum = 0;
            $i = 1;
            foreach (array_reverse($persma) as $key => $value) { 
               if ($lma != $value['sma']) {
                ?>

                  <tr>
                     <th><center><?php echo $i; ?></center></th>
                     <th><center><?php echo $value['sma']; ?></center></th>
                     <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($value['sum'])) ?></th>
                  </tr>
                  <?php 
                  $i++;
                  $sum = 0;
                  $ldept = $value;
                  
                  foreach ($persm as $k => $v) {     
                     if ($k == $value['sma']) { 
                        $lk = count($v['data']);
                        $x = 0;
                        foreach (array_reverse($v['data']) as $ky => $val) {

                           // if ($ldept == $val['dept']) {  
                              // $sum += $val['sum'];
                           // }else{
                              $sum = $val['sum'];
                           // }
                           if ($ldept != $val['dept']) {  
                              ?>

                              <tr>
                                 <td></td>
                                 <td><center><?php echo $val['dept']; ?></center></td> 
                                 <td style="text-align: right;"><?php echo str_replace(',', '.',  number_format( $sum)) ?></td>
                              </tr>

                           <?php }
                        $ldept = $val['dept'];
                        }        
                     }       
                  }
            $lma = $value['sma'];
            $totrkap += $value['sum'];
             }  } ?>
            <tr>
               <th></th>
               <th style="text-align: center;">Total</th>
               <th style="text-align: right;"><?php echo str_replace(',', '.',  number_format($totrkap)) ?></th>
            </tr>
         </tbody>
            
      </table>
   </div>
</div>