<?php $tab = "&nbsp;&nbsp;&nbsp;&nbsp;" ?>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">    
    <div class="col-lg-12">
      <div class="card float-e-margins">
        
        <div class="card-title">
          <h5>Perencanaan <?php echo strtoupper($coadata[0]['dept']) ?></h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="card-content" >


          <div class="form-group">

            <div class="col-lg-12">
            <div><b>NON PROYEK</b></div>
            </p>
             <table id="tree-table" class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <td align="center" width="65%"><b>COA</b></td>
                    <td align="center" width="35%"><b>Perencanaan (IDR)</b></td>
                    <td align="center" width="35%"><b>Realisasi (IDR)</b></td>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $n = 0;
                    $nt = 0;
                    if (!empty($coadata)) {
                      foreach ($coadata as $key => $value) { ?>
                        <tr data-id="v-<?php echo $key ?>" data-parent="0" data-level="1">
                          <td data-column="name"><b>&nbsp;<?php echo $value['beban']; ?></b></td>
                          <td align="right"><?php echo str_replace(',', '.',  number_format($value['sumthree'])) ?></td>
                          <td align="right"><?php echo str_replace(',', '.',  number_format($value['threesum'])) ?></td>
                        </tr>
                        <?php foreach ($value['ma'] as $ky => $val) { 
                          
                          if (($value['beban'] == 'BEBAN USAHA' && $val['ma'] != 'BEBAN LANGSUNG PRODUKSI') || ($value['beban'] == 'BEBAN LANGSUNG PRODUKSI' && $val['ma'] == 'BEBAN LANGSUNG PRODUKSI')) {
                            ?>
                          <tr data-id="w-<?php echo $key.$ky ?>" data-parent="v-<?php echo $key ?>" data-level="2">
                            <td data-column="name"><?php echo $tab.$val['ma']; ?></td>
                            <td align="right"><?php echo str_replace(',', '.',  number_format($val['sumtwo'])) ?></td>
                            <td align="right"><?php echo str_replace(',', '.',  number_format($val['twosum'])) ?></td>
                          </tr>
                          <?php foreach ($val['sma'] as $kk => $vv) { ?>
                            <tr data-id="x-<?php echo $key.$ky.$kk ?>" data-parent="w-<?php echo $key.$ky ?>" data-level="2">
                              <td data-column="name"><?php echo $tab.$vv['sma']; ?></td>
                              <td align="right"><?php echo str_replace(',', '.',  number_format($vv['sumone'])) ?></td>
                              <td align="right"><?php echo str_replace(',', '.',  number_format($vv['onesum'])) ?></td>
                            </tr>
                            <?php foreach ($vv['coa'] as $k => $v) { ?>
                                <tr data-id="y-<?php echo $key.$ky.$kk.$k ?>" data-parent="x-<?php echo $key.$ky.$kk ?>" data-level="3">
                                <td data-column="name"><?php echo $tab.$tab.$tab.$tab.$v['coa']; ?></td>
                                <td align="right"><?php echo str_replace(',', '.',  number_format($v['sumzero'])) ?></td>
                                <td align="right"><?php echo str_replace(',', '.',  number_format($v['zerosum'])) ?></td>
                              </tr>
                            <?php 
                              }
                            }
                          } 
                        }
                        $n += $value['sumthree'];
                        $nt += $value['threesum'];
                      } 
                    } 
                    ?>
                    <tr>
                      <th></th>
                      <th style="text-align: right"><?php echo str_replace(',', '.',  number_format($n)) ?></td>
                      <th style="text-align: right"><?php echo str_replace(',', '.',  number_format($nt)) ?></td>
                    </tr>
                </tbody>
                
              </table>
             
            </div>
            &nbsp;
          </div>
          <hr class=".hr-line-solid">
          <div class="form-group">

            <div class="col-lg-12">
            <div><b>PROYEK</b></div>
            </p>
               <table class="table table-bordered " >
                <thead>
                   <tr>
                      <th><center>No</center></th>
                      <!-- <th><center>No RFQ</center></th> -->
                      <th><center>SPK</center></th>
                      <th><center>Perencanaan</center></th>
                      <th><center>J/O/KSO</center></th>
                      <th><center>Provinsi</center></th>
                      <th><center>Nilai Anggaran</center></th>
                      <th><center>Realisasi</center></th>
                   </tr> 
                </thead>
                <tbody>
                  <?php 
                  $nt = 0; 
                  $pt = 0;
                  $lppm = "";
                  if (!empty($rkp)) {
                    foreach ($rkp as $kp => $vp) { 
                      $jo = ($vp['is_jo'] == 't') ? "JO" : "Non JO";
                      ?>
                     <tr>
                        <td align="center"><?php echo $kp+1; ?></td>
                        <!-- <td align="center"><?php //echo $vp['ptm_number']; ?></td> -->
                        <td align="center"><?php echo $vp['ppm_project_id']; ?></td>
                        <td align="center"><?php echo $vp['ppm_subject_of_work']; ?></td>
                        <td align="center"><?php echo $jo ?></td>
                        <td align="center"><?php echo $vp['lokasi']; ?></td>
                        <td align="right"><?php echo str_replace(',', '.',  number_format($vp['ppm_pagu_anggaran'])) ?></td>
                        <td align="right"><?php echo str_replace(',', '.',  number_format($vp['total_rfq'])) ?></td>
                     </tr>
                  <?php 
                    $pt += $vp['total_rfq'];
                    if ($vp['ppm_id'] != $lppm) {
                      $nt += $vp['ppm_pagu_anggaran'];
                    }else{
                      $nt = $vp['ppm_pagu_anggaran'];
                    }
                    $lppm = $vp['ppm_id'];
                   } } ?>
                    <tr>
                      <th colspan="5" ></th>
                      <th style="text-align: right"><?php echo str_replace(',', '.',  number_format($nt)) ?></td>
                      <th style="text-align: right"><?php echo str_replace(',', '.',  number_format($pt)) ?></td>
                    </tr>
                </tbody>
              </table>
            </div>
            &nbsp;
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

