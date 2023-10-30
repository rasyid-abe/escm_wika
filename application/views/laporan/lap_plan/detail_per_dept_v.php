<?php $tab = "&nbsp;&nbsp;&nbsp;&nbsp;" ?>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">    
    <div class="col-lg-12">
      <div class="card float-e-margins">
        
        <div class="card-title">
          <h5>Perencanaan Per Departemen</h5>
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
                    <td align="center" width="65%"><b><?php echo strtoupper($coadata[0]['ma'][0]['dept']) ?></b></td>
                    <td align="center" width="35%"><b>Nilai (IDR)</b></td>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $n = 0;
                    if (!empty($coadata)) {
                      foreach ($coadata as $key => $value) { ?>
                        <tr data-id="v-<?php echo $key ?>" data-parent="0" data-level="1">
                          <td data-column="name"><b>&nbsp;<?php echo $tab.$value['beban']; ?></b></td>
                          <td align="right"><?php echo str_replace(',', '.',  number_format($value['sumthree'])) ?></td>
                        </tr>
                        <?php foreach ($value['ma'] as $ky => $val) {
                        if (($value['beban'] == 'BEBAN USAHA' && $val['ma'] != 'BEBAN LANGSUNG PRODUKSI') || ($value['beban'] == 'BEBAN LANGSUNG PRODUKSI' && $val['ma'] == 'BEBAN LANGSUNG PRODUKSI')) {
                         ?>
                          <tr data-id="w-<?php echo $key.$ky ?>" data-parent="v-<?php echo $key ?>" data-level="2">
                            <td data-column="name"><b><?php echo $tab.$tab.$tab.$val['ma']; ?></b></td>
                            <td align="right"><?php echo str_replace(',', '.',  number_format($val['sumtwo'])) ?></td>
                          </tr>
                          <?php foreach ($val['sma'] as $k => $v) { ?>
                            <tr data-id="x-<?php echo $key.$ky.$k ?>" data-parent="w-<?php echo $key.$ky ?>" data-level="2">
                              <td data-column="name"><?php echo $tab.$tab.$tab.$tab.$v['sma']; ?></td>
                              <td align="right"><?php echo str_replace(',', '.',  number_format($v['sumone'])) ?></td>
                            </tr>
                              <?php foreach ($v['coa'] as $kk => $vv) { ?>
                                <tr data-id="y-<?php echo $key.$ky.$k.$kk ?>" data-parent="x-<?php echo $key.$ky.$k ?>" data-level="3">
                                  <td data-column="name"><?php echo $tab.$tab.$tab.$tab.$tab.$tab.$tab.$vv['coa']; ?></td>
                                  <td align="right"><?php echo str_replace(',', '.',  number_format($vv['sumzero'])) ?></td>
                                </tr>
                              <?php 
                              }
                            }
                            } 
                          }
                        $n += $value['sumthree'];
                      } 
                    } 
                    ?>
                    <tr>
                      <th colspan="5" style="text-align: right"><?php echo str_replace(',', '.',  number_format($n)) ?></td>
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
                      <th><center>SPK</center></th>
                      <th><center>J/O/KSO</center></th>
                      <th><center>Provinsi</center></th>
                      <th><center>Nilai Anggaran</center></th>
                   </tr> 
                </thead>
                <tbody>
                  <?php 
                  $nt = 0; 
                  if (!empty($rkp)) {
                    foreach ($rkp as $kp => $vp) { 
                      $jo = ($vp['is_jo'] == 't') ? "JO" : "Non JO";
                      ?>
                     <tr>
                        <td align="center"><?php echo $kp+1; ?></td>
                        <td align="center"><?php echo $vp['ppm_project_id']; ?></td>
                        <td align="center"><?php echo $jo ?></td>
                        <td align="center"><?php echo $vp['lokasi']; ?></td>
                        <td align="right"><?php echo str_replace(',', '.',  number_format($vp['ppm_pagu_anggaran'])) ?></td>
                     </tr>
                  <?php $nt += $vp['ppm_pagu_anggaran']; } } ?>
                    <tr>
                      <th colspan="5" style="text-align: right"><?php echo str_replace(',', '.',  number_format($nt)) ?></td>
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

