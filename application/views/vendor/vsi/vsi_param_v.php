<div class="card">
    <div class="card-body">
        <div class="form_dt_search mb-2" id="form_dt_search">
      		<label>Filter Laporan</label>
      		<form method="GET" action="<?= base_url() ?>vendor/vsi">
      		    <div class="row">
                  <div class="form-group col-md-3">
                      <select class="select2 form-control" id="s_periode" name="periode">
                          <option value="1">Periode 1</option>
                          <option value="2">Periode 2</option>
                      </select>
                  </div>
                  <div class="form-group col-md-3">
                      <select class="select2 form-control" id="s_year" name="year">
	                      <?php foreach($year as $v) : ?>
                        <option value="<?= $v['year'] ?>"><?= $v['year'] ?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="col-md-2">
                      <button type="submit" class="btn bg-light-warning" id="dt_cari_act" name="button"><i class="ft-search"></i> Submit</button>
                  </div>
              </div>
      		</form>
        </div>
    </div>
</div>

<div class="users-list-table">
  <div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <a href="<?php ?>">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h3 class="mb-1 info"><?= $card_quest ?></h3>
                                <span>Questionnaire</span>
                            </div>
                						<div class="media-right align-self-center">
                  						<i class="ft-activity danger font-large-2 float-right"></i>
                  					</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <a href="<?php ?>">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
		                    <div class="media">
                            <div class="media-body text-left">
                                <h3 class="mb-1 info"><?= $card_responden ?></h3>
                                <span>Responden</span>
                            </div>
                						<div class="media-right align-self-center">
                  						<i class="ft-user danger font-large-2 float-right"></i>
                  					</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <a href="<?php ?>">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
		                    <div class="media">
                            <div class="media-body text-left">
                                <h3 class="mb-1 info"><?= $card_vsi_less ?></h3>
                                <span>Vsi score < 60%</span>
                            </div>
                						<div class="media-right align-self-center">
                  						<i class="ft-user-minus danger font-large-2 float-right"></i>
                  					</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <a href="<?php ?>">
          <div class="card">
              <div class="card-content">
                  <div class="card-body">
		                    <div class="media">
                          <div class="media-body text-left">
                              <h3 class="mb-1 info"><?= $card_vsi_more ?></h3>
                              <span>Vsi more > 60%</span>
                          </div>
                  				<div class="media-right align-self-center">
                    				<i class="ft-user-plus danger font-large-2 float-right"></i>
                    			</div>
                      </div>
                  </div>
              </div>
          </div>
        </a>
    </div>
  </div>

  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Tingkat Kepentingan Chart</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <div class="height-400">
                          <div id="line-chart-importance"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
            <div class="card-body">
               <h4>Tabel nilai index Kepentingan</h4>
               <hr>
               <div id="grid_nilai_index_kepentingan"></div>
               <table class="table table-bordered" id="item_table">	
               <thead>
			
			<tr>
				<th rowspan="2" style="width:10px" >No</th>
				<th rowspan="2"><center>Nama Vendor</center></th>
				<th colspan="<?php echo count($header) ?>" ><center><?php echo "Tingkat Kepentingan" ?></center></th>
				<th rowspan="2"><center>Total</center></th>
			</tr>
			
			<tr>
				<?php $i=1;
				foreach ($header as $k => $v) { ?>
					<th ><center><?php echo "i".$i ?></center></th>
				<?php $i++; }	?>
			</tr>
			
		</thead>	
		<tbody>
		<?php if (!empty($vendor)) : ?>
			<?php $i = 1; foreach ($vendor as $ky => $val) { ?>
				<tr>
					<td>
						<center><?php echo $i; ?></center>
					</td>
					<td>
						<?php echo $val['vendor_name']; ?>
					</td>

					<?php 
					$tot = 0;
					$eachv = 0;
					foreach ($quest[$ky] as $keys => $values) { ?>
						<td>
							<center><?php echo $values['vvk_imp_score'] ?></center>
						</td>
					<?php 
					$tot += $values['vvk_imp_score']; } ?>
						<td>
							<center><?php echo $tot; ?></center>
						</td>
				</tr>
			<?php $i++;
			$impvend[$ky] = $tot;
			 } ?>
			<?php endif; ?>

			<tr>
				<th colspan="2"><center>Total</center></th>
				<?php if (!empty($total_imp)) : ?>
				<?php $total_imp = array_shift($imp);

				foreach ($total_imp as $key => &$value){
					$value += array_sum(array_column($imp, $key)); 
					?>

					<th><center><?php echo $value; ?></center></th>
				<?php 
				$impperque[] = $value;
				}	?>
				<th>
					<?php 
					$all = 0;
					foreach ($quest as $key => $value) {
						foreach ($value as $sk => $sv) {
							$all += $sv['vvk_imp_score'];
						}
					}
					?>
					<center><?php echo $all; ?></center>
				</th>
				<?php endif; ?>
			</tr>
		</tbody>
	</table>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Tingkat Kepuasan Chart</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <div class="height-400">
                          <div id="line-chart-satis"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-content">
                  <div class="card-body">
                     <h4>Tabel nilai index Kepuasan</h4>
              		   <hr>
            			   <div id="grid_nilai_index_kepuasan"></div>
                           <div class="table-responsive">
	<table class="table table-bordered" id="item_table">
		<thead>			
			<tr>
				<th rowspan="2" style="width:10px" >No</th>
				<th rowspan="2"><center>Nama Vendor</center></th>
				<th colspan="<?php echo count($header) ?>" ><center><?php echo "Tingkat Kepuasan" ?></center></th>
				<th rowspan="2"><center>Total</center></th>
			</tr>
			
			<tr>
				<?php $i=1;
				foreach ($header as $k => $v) { ?>
					<th ><center><?php echo "s".$i ?></center></th>
				<?php $i++; }	?>
			</tr>
			
		</thead>
		<tbody>
			<?php 
			$no = 1; 
			$allv = 0;
			$count = [];
			foreach ($vendor as $ky => $val) { ?>
				<tr>
					<td>
						<center><?php echo $no; ?></center>
					</td>
					<td>
						<?php echo $val['vendor_name']; ?>
					</td>

					<?php 
					$tot = [];
					$i = 0;
					$eachv = 0;
					foreach ($quest[$ky] as $keys => $values) { ?>
						<td>
							<center><?php echo $values['vvk_satis_score'] ?></center>
						</td>
						<?php $eachv += $values['vvk_satis_score']; }	?>
						<td>
							<center><?php echo $eachv; ?></center>
						</td>
				</tr>
			<?php $no++; 
			$satisvend[$ky] = $eachv;
			} ?>
				<tr>
					<th colspan="2"><center>Total</center></th>
					<?php 
					
					$total_satis = array_shift($satis);

					foreach ($total_satis as $key => $vals){

					   $vals += array_sum(array_column($satis, $key)); 

					   ?>

					   <th><center><?php echo $vals ?></center></th>
					<?php 

					$satisperque[] = $vals;
					}	
					?>
					<th>
						<?php 
						$all = 0;
						foreach ($quest as $key => $value) {
							foreach ($value as $sk => $sv) {
								$all += $sv['vvk_satis_score'];
							}
						}
						?>
						<center><?php echo $all; ?></center>
					</th>
				</tr>
		</tbody>
	</table>
</div>	
                  </div>
              </div>
          </div>
      </div>
  </div>

		<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Index Kepuasan Vendor Chart</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="height-400">
                            <div id="container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                       <h4>Tabel bobot VSI </h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered selection-multiple-rows">
                            <thead>
            <tr>
                <th><center>NO</center></th>
                <th><center>Faktor-Faktor Yang Dinilai</center></th>
                <th><center>Bobot Tingkat Kepuasan</center></th>
                <th><center>Bobot Tingkat Kepentingan</center></th>
                <th><center>Indeks Kerja</center></th>
                <th><center>X</center></th>
                <th><center>Y</center></th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $ts=0; $ti=0; $tx=0; $x=0; $y=0; $i=1; $j=1; $hd="";
        foreach ($quest[0] as $key => $value) { ?>
            <tr>
                <?php if ($hd != $value['vvk_quest_header'] && $key > 0) { $i++; $j = 1;  } ?>
                <td id="no<?php echo $key ?>"><center><?php echo $i.".".$j ?></center></td>
                <?php  $hd = $value['vvk_quest_header']; $j++;  ?>
                <td id="name<?php echo $key ?>"><?php echo $value['vvk_quest_name']; ?></td>
                <td><center><?php echo $satisperque[$key]; $ts += $satisperque[$key]; ?></center></td>
                <td><center><?php echo $impperque[$key]; $ti += $impperque[$key]; ?></center></td>
                <td><center><?php echo number_format($satisperque[$key]/$impperque[$key]*100, 2); $tx += $satisperque[$key]/$impperque[$key]*100 ?></center></td>
                <td id="x<?php echo $key ?>"><center><?php echo number_format($satisperque[$key]/count($vendor), 2); $x += $satisperque[$key]/count($vendor)?></center></td>
                <td id="y<?php echo $key ?>"><center><?php echo number_format($impperque[$key]/count($vendor), 2); $y += $impperque[$key]/count($vendor) ?></center></td>
            </tr>
        <?php } ?>

            <tr>
                <th colspan="2"><center>Total</center></th>
                <th><center><?php echo number_format($ts, 2)?></center></th>
                <th><center><?php echo number_format($ti, 2)?></center></th>
                <th><center><?php echo number_format($tx, 2)?></center></th>
                <th><center><?php echo number_format($x, 2)?></center></th>
                <th><center><?php echo number_format($y, 2)?></center></th>
            </tr>
            <tr>
                <th colspan="2"><center>Rata - Rata</center></th>
                <th><center><?php echo number_format($ts/count($quest[0]), 2)?></center></th>
                <th><center><?php echo number_format($ti/count($quest[0]), 2)?></center></th>
                <th><center><?php echo number_format($tx/count($quest[0]), 2)?></center></th>
                <th><center><?php echo number_format($x/count($quest[0]), 2)?></center></th>
                <th><center><?php echo number_format($y/count($quest[0]), 2)?></center></th>
            </tr>
        </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


		<div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-content">
                  <div class="card-body">
                     <h4>Score VSI per vendor</h4>
                      <div class="table-responsive">
                          <table id="table_list_vendor_score" class="table table-striped table-bordered selection-multiple-rows">
                              <thead>
                                  <tr>
                                  <th>No</th>

                                    <th>Nama Vendor</th>
                                    <th>Vsi Persentase %</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php 
                                      $i = 1; 
                                      $allv = 0;
                                      $count = [];
                                      $vsit = 0;
                              $more60 = 0;
                              $less60 = 0;
                      
                                foreach ($vendor as $ky => $val) {
                                        $pre = 0;
                                        $tot = 0;
                                    foreach ($quest[$ky] as $keys => $values) {
                                      $tot += $values['vvk_imp_score'];
                                      $impvend[$ky] = $tot;
                                      $weightimp[$keys][$ky] = $values['vvk_imp_score']/$impvend[$ky];
                                    }
                      
                                    foreach ($weightimp as $key => $value) {
                                                      $pre += $value[$ky];
                                    }
                                                  $vsi = ($pre/4)*100;
                      
                                    $vsit += $vsi;

                                ?>
                                <tr>
                                    <td>
                                        <center><?php echo $i; ?></center>
                                    </td>
                                    <td>
                                        <?php echo $val['vendor_name']; ?>
                                    </td>					
                                    <td><center>
                                        <?php 
                                        $pre = 0;
                                        foreach ($weightimp as $key => $value) {
                                            $pre += $value[$ky];
                                        }
                                        $vsi = ($pre/4)*100;
                                        $vsit += $vsi;
                                        echo number_format($vsi,2)." %";
                                        ?>
                                    </center></td>	
                                </tr>



                            <?php
                                   
                                $i++; 
                            }
                                  
                                      
                                      $average=  $vsit/count($vendor);
                                
                                ?>

                               </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>


</div>

<input type="text" name="quota" id="quota" value="<?php echo count($quest[0]) ?>" style="display: none">
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>


<script>
    
    $(document).ready(function(){

        // var que = $('#no0').text()
        // console.log(que)

    });

</script>


<script>

Highcharts.chart('line-chart-importance', {

title: {
    text: ''
},

subtitle: {
    text: ''
},

xAxis: {
        categories: <?= $line_question; ?>
    },
    yAxis: {
        title: {
            text: 'Score (1 - 4)'
        }
    },

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
        pointStart: 0
    }
},

series: <?= $chart_imp; ?>,

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}

});



Highcharts.chart('line-chart-satis', {

title: {
    text: ''
},

subtitle: {
    text: ''
},

xAxis: {
        categories: <?= $line_question; ?>
    },
    yAxis: {
        title: {
            text: 'Score (1 - 4)'
        }
    },

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
        pointStart: 0
    }
},

series: <?= $chart_satis; ?>,

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}

});


var d          = new Date();
var pointStart = d.getTime();
    //-------------------------------------------------------
//set a 'line' marker type for use in bullet charts 
Highcharts.Renderer.prototype.symbols.vline = function(x, y, width, height) {
    return ['M',x ,y + width / 2,'L',x+height,y + width / 2];
};
Highcharts.Renderer.prototype.symbols.hline = function(x, y, width, height) {
    return ['M',x ,y + height / 2,'L',x+width,y + width / 2];
};
//-------------------------------------------------------
Highcharts.setOptions({
    global: {
        useUTC:false
    },
    colors: [
        'rgba( 0,   154, 253, 0.9 )', //bright blue
        'rgba( 253, 99,  0,   0.9 )', //bright orange
        'rgba( 40,  40,  56,  0.9 )', //dark
        'rgba( 253, 0,   154, 0.9 )', //bright pink
        'rgba( 154, 253, 0,   0.9 )', //bright green
        'rgba( 145, 44,  138, 0.9 )', //mid purple
        'rgba( 45,  47,  238, 0.9 )', //mid blue
        'rgba( 177, 69,  0,   0.9 )', //dark orange
        'rgba( 140, 140, 156, 0.9 )', //mid
        'rgba( 238, 46,  47,  0.9 )', //mid red
        'rgba( 44,  145, 51,  0.9 )', //mid green
        'rgba( 103, 16,  192, 0.9 )'  //dark purple
    ],
    chart: {
        alignTicks:false,
        type:'',
        margin:[60,25,100,90],
        //borderRadius:10,
        //borderWidth:1,
        //borderColor:'rgba(156,156,156,.25)',
        //backgroundColor:'rgba(204,204,204,.25)',
        //plotBackgroundColor:'rgba(255,255,255,1)',
        style: {
            // fontFamily: 'Abel,serif'
        },
        events:{
            load: function() {
                this.credits.element.onclick = function() {
                    window.open(
                      'http://stackoverflow.com/users/1011544/jlbriggs?tab=profile'
                    );
                 }
            }
        }           
    },
    credits: {
        text : '', //'http://stackoverflow.com/users/1011544/jlbriggs',
        href : '' //http://stackoverflow.com/users/1011544/jlbriggs?tab=profile'
    },
    title: {
        text:'Test Chart Title',
        align:'left',
        margin:10,
        x: 50,
        style: {
            fontWeight:'bold',
            color:'rgba(0,0,0,.9)'
        }
    },
    subtitle: {
        text:'Test Chart Subtitle',   
        align:'left',
        x: 52,
    },
    legend: { enabled: true },
    plotOptions: {
        area: {
            lineWidth:1,
            marker: {
                enabled:false,
                symbol:'circle',
                radius:4
            }
        },
        arearange: {
            lineWidth:1
        },
        areaspline: {
            lineWidth:1,
            marker: {
                enabled:false,
                symbol:'circle',
                radius:4
            }
        },
        areasplinerange: {
            lineWidth:1
        },
        boxplot: {
            groupPadding:0.05,
            pointPadding:0.05,
            fillColor:'rgba(255,255,255,.75)'
        },
        bubble: {
            minSize:'0.25%',
            maxSize:'17%'
        },
        column: {
            //stacking:'normal',
            groupPadding:0.05,
            pointPadding:0.05
        },
        columnrange: {
            groupPadding:0.05,
            pointPadding:0.05
        },
        errorbar: {
            color: 'rgba(0,0,0,.75)',
            groupPadding:0.05,
            pointPadding:0.05,
            showInLegend:true        
        },
        line: {
            lineWidth:1,
            marker: {
                enabled:false,
                symbol:'circle',
                radius:4
            }
        },
        scatter: {
            marker: {
                symbol: 'circle',
                radius:5
            }
        },
        spline: {
            lineWidth:1,
            marker: {
                enabled:false,
                symbol:'circle',
                radius:4
            }
        },
        series: {
            shadow: false,
            borderWidth:0,
            states: {
                hover: {
                    lineWidthPlus:0,
                }
            }
        }
    },
    xAxis: {
        title: {
            text: 'X Axis Title',
            rotation:0,
            textAlign:'center',
            style:{ 
                color:'rgba(0,0,0,.9)'
            }
        },
        labels: { 
            style: {
                color: 'rgba(0,0,0,.9)',
                fontSize:'10px'
            }
        },
        lineWidth:.5,
        lineColor:'rgba(0,0,0,.5)',
        tickWidth:.5,
        tickLength:3,
        tickColor:'rgba(0,0,0,.75)'
    },
    yAxis: {
        minPadding:0,
        maxPadding:0,
        gridLineColor:'rgba(204,204,204,.25)',
        gridLineWidth:0.5,
        title: { 
            text: 'Y Axis<br/>Title',
            rotation:0,
            textAlign:'right',
            style:{ 
                color:'rgba(0,0,0,.9)',
            }
        },
        labels: { 
            style: {
                color: 'rgba(0,0,0,.9)',
                fontSize:'10px'
            }
        },
        lineWidth:.5,
        lineColor:'rgba(0,0,0,.5)',
        tickWidth:.5,
        tickLength:3,
        tickColor:'rgba(0,0,0,.75)'
    }
}); 
    
//generate chart data
function randomData(points, positive, multiplier, type) {
    var chartData     = [];
    for(var i = 0; i < points; i++) {
        if(type == 'scatter') {
            var dataNodes = randomNormData(2, positive, multiplier);
            var dataPoint = [
                dataNodes[0],
                dataNodes[1],
            ];
        }
        else if(type == 'bubble') {
            var dataPoint = [
                randomNormData(1, positive, multiplier),
                randomNormData(1, positive, multiplier),
                randomNormData(1, true,     multiplier)
            ];
        }
        else if(type == 'columnrange' || type == 'arearange' || type == 'areasplinerange' || type == 'errorbar') {
            var dataNodes = randomNormData(2, positive, multiplier);
            dataNodes.sort(numSort);
            var dataPoint = {
                'low'   : dataNodes[0],
                'high'  : dataNodes[1]
            };
        }
        else if(type == 'boxplot') {
            var dataNodes = randomNormData(5, positive, multiplier);
            dataNodes.sort(numSort);
            var dataPoint = {
                'low'   : dataNodes[0],
                'q1'    : dataNodes[1],
                'median': dataNodes[2],
                'q3'    : dataNodes[3],
                'high'  : dataNodes[4]
            };
        }
        else {
            var dataPoint = randomNormData(1, positive, multiplier);
        }
        chartData.push(dataPoint);
    }
    //console.log(chartData);                              
    return chartData;
}
//random normal data
function randomNormData(points, positive, multiplier) {
    points     = !points            ? 1     : points;
    positive   = positive == 'neg'  ? 'neg' : (positive === true ? true : false);
    multiplier = !multiplier        ? 1     : multiplier;
    
    function rnd() {
        return ((
            Math.random() + 
            Math.random() + 
            Math.random() + 
            Math.random() + 
            Math.random() + 
            Math.random()
        ) - 3) / 3;
    }
    var rData = points > 1 ? [] : null;
    for (var i = 0; i < points; i++) {
        val = rnd();
        val = positive   === true ? Math.abs(val)      : (positive == 'neg' ? (0 - Math.abs(val)) : val);
        val = multiplier >   1    ? (val * multiplier) : val;
        if(points > 1) {
            rData.push(val);
        }
        else {
            rData = val;
        }
    }
    return rData;
}

//sorting
function numSort(a,b) { 
    return a - b; 
} 
function numSortR(a,b) { 
    return b - a; 
} 
//category filler
function alphaCats(n) {
    var alph = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    var cats = [];
    for(var i = 0; i < n; i++) {
        if(i < alph.length) {
            cats.push(alph[i]);
        }
        else {
            var rep = Math.ceil((i / (alph.length -1)));
            var c   = (Math.ceil(i / (rep -1)) - alph.length);
            var cat = '';
            for(var j = 0; j < rep; j++) {
                cat = cat +alph[c];
            }
            cats.push(cat);
        }
    }
    return cats;
}
var monthCats = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
var dayCats5 = ['Mon','Tue','Wed','Thu','Fri'];
var dayCats7 = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];


var chart;
var type         = 'scatter';
//var dataPoints   = 25;
//var categories   = alphaCats(dataPoints);//monthCats//dayCats5//dayCats7
var titleText    = '';
var subTitleText = '';

$(function() {
    $('#container').highcharts({
        chart       : { type    : type, margin: [75,25,75,25] },
        title       : { text    : titleText     },
        subtitle    : {  text   : subTitleText  },
        legend      : { enabled : true          },
        tooltip     : {
            shared      : true,
            crosshairs  : false
        },
        plotOptions : {
            series      : {
             dataLabels: {
                enabled: true,
                       format: '{point.series.name}'
            }
             
            }
        },
        xAxis      : {
          min: 1,
          max: 4,
          tickInterval:0.1,
            offset: -542,
          title: { text: null },
        },
        yAxis      : { 
            min: 1,
          max: 4,
            tickInterval:0.1,
            offset: -567,
          title: { text: null }
        }
    }); 
    
    var seriesname = ''
    var seriesx = ''
    var seriesy = ''
    var quota = $('#quota').val()

    chart = $('#container').highcharts();
    
    for(var i=0;i<quota;i++){    
        seriesname = $('#no'+i).text()
        seriesnames = $('#name'+i).text()
        seriesx = parseFloat($('#x'+i).text())
        seriesy = parseFloat($('#y'+i).text())

        chart.addSeries({
            color: 'rgba( 0, 159, 227, 1)',
            name: seriesname+" "+seriesnames,
            data : [
            {
              "x": seriesx,
              "y": seriesy
            }]
        })
    }
    // chart.addSeries ({ 
    //   color: 'rgba( 253, 99,  0,   0.9 )',
    //   name: 'serie a',
    //   data : [
    //     {
    //       "x": 3.3,
    //       "y": 3.8
    //     }]
      
    // }),
    // chart.addSeries({ 
    //   color: 'rgba( 253, 99,  0,   0.9 )',
    //   name: 'serie b',
      
    //   data : [
    //     {
    //       "x": 3.1,
    //       "y": 3.2
    //     }]
      
    // }),
    // chart.addSeries({ 
    //   color: 'rgba( 253, 99,  0,   0.9 )',
    //   name: 'serie c',
    //   data : [
    //     {
    //       "x": 3.3,
    //       "y": 3.3
    //     }]
      
    // }),
    // chart.addSeries({ 
    //   color: 'rgba( 253, 99,  0,   0.9 )',
    //   name: 'serie d',
    //   data : [
    //     {
    //       "x": 3.0,
    //       "y": 3.0
    //     }]
      
    // });
    
});

 
</script>
