<?php $tab = "&nbsp;&nbsp;&nbsp;&nbsp;" ?>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">    
    <div class="col-lg-12">
      <div class="card float-e-margins">
        
        <div class="card-title">
          <h5>Perencanaan Per Coa</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="card-content" >


          <div class="form-group">

            <div class="col-lg-12">
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
                          <td data-column="name"><b>&nbsp;<?php echo $tab.$value['beban']; ?></b></td>
                          <td align="right"><?php echo str_replace(',', '.',  number_format($value['sumfour'])) ?></td>
                          <td align="right"><?php echo str_replace(',', '.',  number_format($value['foursum'])) ?></td>
                        </tr>
                        <?php foreach ($value['ma'] as $ky => $val) {

                        if (($value['beban'] == 'BEBAN USAHA' && $val['ma'] != 'BEBAN LANGSUNG PRODUKSI') || ($value['beban'] == 'BEBAN LANGSUNG PRODUKSI' && $val['ma'] == 'BEBAN LANGSUNG PRODUKSI')) {
                         ?>
                          <tr data-id="w-<?php echo $key.$ky ?>" data-parent="v-<?php echo $key ?>" data-level="2">
                            <td data-column="name"><?php echo $tab.$tab.$tab.$val['ma']; ?></td>
                            <td align="right"><?php echo str_replace(',', '.',  number_format($val['sumthree'])) ?></td>
                            <td align="right"><?php echo str_replace(',', '.',  number_format($val['threesum'])) ?></td>
                          </tr>
                          <?php foreach ($val['sma'] as $k => $v) { ?>
                            <tr data-id="x-<?php echo $key.$ky.$k ?>" data-parent="w-<?php echo $key.$ky ?>" data-level="3">
                              <td data-column="name"><?php echo $tab.$tab.$tab.$tab.$tab.$v['sma']; ?></td>
                              <td align="right"><?php echo str_replace(',', '.',  number_format($v['sumtwo'])) ?></td>
                              <td align="right"><?php echo str_replace(',', '.',  number_format($v['twosum'])) ?></td>
                            </tr>
                            <?php foreach ($v['coa'] as $kk => $vv) { ?>
                              <tr data-id="y-<?php echo $key.$ky.$k.$kk ?>" data-parent="x-<?php echo $key.$ky.$k ?>" data-level="4">
                                <td data-column="name"><?php echo $tab.$tab.$tab.$tab.$tab.$tab.$tab.$vv['data']; ?></td>
                                <td align="right"><?php echo str_replace(',', '.',  number_format($vv['sumone'])) ?></td>
                                <td align="right"><?php echo str_replace(',', '.',  number_format($vv['onesum'])) ?></td>
                              </tr>
                              <?php 
                                $ldept = "";
                                foreach (array_reverse($vv['dept']) as $ks => $vs) { 
                                  if ($vs['dept'] != $ldept) { ?>
                                    <tr data-id="z-<?php echo $key.$ky.$k.$kk.$ks ?>" data-parent="y-<?php echo $key.$ky.$k.$kk ?>" data-level="5">
                                      <td data-column="name"><?php echo $tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$vs['dept']; ?></td>
                                      <td align="right"><?php echo str_replace(',', '.',  number_format($vs['pagu'])) ?></td>
                                      <td align="right"><?php echo str_replace(',', '.',  number_format($vs['real'])) ?></td>
                                    </tr>
                                  <?php 
                                  }
                                  $ldept = $vs['dept'];
                                }
                              }
                            }
                          } 
                        }
                        $n += $value['sumfour'];
                        $nt += $value['foursum'];
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
        </div>
      </div>
    </div>
  </div>
</div>

