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
                                <h3 class="mb-1 info"><?= $vsi_summary['questionaire'] ?></h3>
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
                                <h3 class="mb-1 info"><?= $vsi_summary['responden'] ?></h3>
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
                                <h3 class="mb-1 info"><?= $vsi_summary['score_less_60'] ?></h3>
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
                              <h3 class="mb-1 info"><?= $vsi_summary['score_more_60'] ?></h3>
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
                  <h4 class="card-title">Tingkat Kepuasan Chart</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <div class="height-400">
                          <canvas id="line-chart"></canvas>
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
                  </div>
              </div>
          </div>
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
                          <canvas id="line-chart-2"></canvas>
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
                            <canvas id="scatter-logx"></canvas>
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
                                  <th>Pertanyaan</th>
                                  <th>Bobot Tingkat Kepuasan</th>
                                  <th>Bobot Tingkat Kepentingan</th>
                                  <th>Indeks Kinerja</th>
                                  <th>X</th>
                                  <th>Y</th>
                                </tr>
                              </thead>
                              <tbody>
                  							<?php foreach ($data_satisfication_map as $key => $item) : ?>
                                 <tr>
                  								<td><?= $item["pertanyaan"] ?></td>
                  								<td><?= $item["sum_kepuasan"] ?></td>
                  								<td><?= $item["sum_kepentingan"] ?></td>
                  								<td><?= $item["index_kinerja"] ?></td>
                  								<td><?= $item["avg_x_kepuasan"] ?></td>
                  								<td><?= $item["avg_y_kepentingan"] ?></td>
                  						   </tr>
                  						   <?php endforeach; ?>
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
                                    <th>Nama Vendor</th>
                                    <th>Periode</th>
                                    <!-- <th>Tahun</th> -->
                                    <th>Vsi Persentase %</th>
                                  </tr>
                              </thead>
                              <tbody>
            						        <?php if(!empty($score_rows)) : ?>
                    							<?php foreach ($score_rows as $key => $item) : ?>
                                   <tr>
                    								<td><?= $item->vendor_name ?></td>
                    								<td><?= $s_periode ?></td>
                    								<!-- <td><?= date('Y') ?></td> -->
                    								<td><?= $item->score ?></td>
                    						   </tr>
                    						   <?php endforeach; ?>
                  						   <?php endif; ?>
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
		                   <h4>List vendor VSI</h4>
                       <div id="grid_list_vendor_vsi"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="<?php echo base_url('assets'); ?>/app-assets/vendors/js/apexcharts.min.js"></script>

<script>
	var base_url = "<?= base_url() ?>";

	$(window).on("load", function () {
		var line_pertanyaan_kepuasan = <?= $label_pertanyaan_kepuasan ?>;
		var line_pertanyaan_kepentingan = <?= $label_pertanyaan_kepentingan ?>;



		// line chart question
		var ctx = $("#line-chart");
		// Chart Options
		var chartOptions = {
		responsive: true,
		maintainAspectRatio: false,
		legend: {
			position: 'bottom',
		},
		hover: {
			mode: 'label'
		},
		scales: {
			xAxes: [{
			display: true,
			gridLines: {
				color: "#F5F5F5",
				drawTicks: false,
			},
			scaleLabel: {
				display: true,
				labelString: 'Month'
			}
			}],
			yAxes: [{
			display: true,
			gridLines: {
				color: "#F5F5F5",
				drawTicks: false,
			},
			scaleLabel: {
				display: true,
				labelString: 'Value'
			}
			}]
		},
		title: {
			display: true,
			text: 'Tingkat Kepuasan'
		}
		};
		// Chart Data
		var chartData = {
		labels: line_pertanyaan_kepuasan, //["January", "February", "March", "April", "May", "June", "July"],
		datasets: <?= $data_asset_line_kepuasan ?>

		};
		var config = {
		type: 'line',

		// Chart Options
		options: chartOptions,

		data: chartData
		};
		// Create the chart
		var lineChart = new Chart(ctx, config);

		//==============END=====================//

		// line chart question kepentingan
		var ctx2 = $("#line-chart-2");
		// Chart Options
		var chartOptions2 = {
		responsive: true,
		maintainAspectRatio: false,
		legend: {
			position: 'bottom',
		},
		hover: {
			mode: 'label'
		},
		scales: {
			xAxes: [{
			display: true,
			gridLines: {
				color: "#F5F5F5",
				drawTicks: false,
			},
			scaleLabel: {
				display: true,
				labelString: 'Month'
			}
			}],
			yAxes: [{
			display: true,
			gridLines: {
				color: "#F5F5F5",
				drawTicks: false,
			},
			scaleLabel: {
				display: true,
				labelString: 'Value'
			}
			}]
		},
		title: {
			display: true,
			text: 'Tingkat Kepentingan'
		}
		};
		// Chart Data
		var chartData2 = {
		labels: line_pertanyaan_kepentingan, //["January", "February", "March", "April", "May", "June", "July"],
		datasets: <?= $data_asset_line_kepentingan ?>

		};
		var config2 = {
		type: 'line',

		// Chart Options
		options: chartOptions2,

		data: chartData2
		};
		// Create the chart
		var lineChart2 = new Chart(ctx2, config2);

		//-------------- Scatter Chart starts --------------

//Get the context of the Chart canvas element we want to select
var scatter = $("#scatter-logx");
// Chart Options
var chartOptionsScatter = {
  responsive: true,
  maintainAspectRatio: false,
  responsiveAnimationDuration: 800,
  title: {
    display: false,
    text: ''
  },
  scales: {
    xAxes: [{
      type: 'linear',
      position: 'bottom',
    //   ticks: {
    //     userCallback: function (tick) {
    //       var remain = tick / (Math.pow(10, Math.floor(Chart.helpers.log10(tick))));
    //       if (remain === 1 || remain === 2 || remain === 5) {
    //         return tick.toString() + "";
    //       }
    //       return '';
    //     },
    //   },
      gridLines: {
        zeroLineColor: "rgba(0,0,0,.1)",
        color: "#F5F5F5",
        drawTicks: true,
      },
      scaleLabel: {
        labelString: 'Value',
        display: true,
      }
    }],
    // yAxes: [{
    //   type: 'linear',
    // //   ticks: {
    // //     userCallback: function (tick) {
    // //       return tick.toString() + "";
    // //     }
    // //   },
    //   gridLines: {
    //     zeroLineColor: "#2F8BE6",
    //     color: "#F5F5F5",
    //     drawTicks: false,
    //   },
    //   scaleLabel: {
    //     labelString: 'Voltage',
    //     display: true
    //   }
    // }]
  }
};
// Chart Data
var chartDataScatter = {
  //labels: ["January", "February", "March", "April", "May", "June", "July"],
  datasets: <?= $data_scatter_chart ?>
};

var config_scatter = {
  type: 'scatter',
  // Chart Options
  options: chartOptionsScatter,
  data: chartDataScatter
};
// Create the chart
var scatterLogXChart = new Chart(scatter, config_scatter);

});

    $(document).ready(function() {
		table_list_vendor_score
		var table_list_vnd_vsi = $("#table_list_vnd_vsi").DataTable();
		var table_list_vendor_score = $("#table_list_vendor_score").DataTable();

       var year = "<?= $s_year ?>";
       var periode = "<?= $s_periode ?>";

	   var s_year = $("#s_year");
	   var s_periode = $("#s_periode");

	   s_year.val(year);
	   s_periode.val(periode);



    });

</script>

<script>
	const dataInputKepuasanSource = <?= $data_input_kepuasan; ?>;
	const dataInputKepentinganSource = <?= $data_input_kepentingan; ?>;

	$(() => {
		$("#grid_nilai_index_kepuasan").dxPivotGrid({
			allowSortingBySummary: true,
			allowSorting: true,
			allowFiltering: true,
			allowExpandAll: true,
			height: 440,
			showBorders: true,
			fieldChooser: {
			enabled: false,
			},
            dataSource: {
			fields: [{
				caption: 'Vendor Name',
				width: 120,
				dataField: 'vendor_name',
				area: 'row',
			},  {
				dataField: 'pertanyaan',
				area: 'column',

			}, {
				caption: 'Score',
				dataField: 'answer_score',
				dataType: 'number',
				summaryType: 'sum',
				ormat: 'number',
				area: 'data',
			}],
			store: dataInputKepuasanSource,
			},
        });
	});

	$(() => {
		$("#grid_nilai_index_kepentingan").dxPivotGrid({
			allowSortingBySummary: true,
			allowSorting: true,
			allowFiltering: true,
			allowExpandAll: true,
			height: 440,
			showBorders: true,
			fieldChooser: {
			enabled: false,
			},
            dataSource: {
			fields: [{
				caption: 'Vendor Name',
				width: 120,
				dataField: 'vendor_name',
				area: 'row',
			},  {
				dataField: 'pertanyaan',
				area: 'column',

			}, {
				caption: 'Score',
				dataField: 'answer_score',
				dataType: 'number',
				summaryType: 'sum',
				ormat: 'number',
				area: 'data',
			}],
			store: dataInputKepentinganSource,
			},
        });
	});

</script>

<script>
	$(document).ready(function () {

		var listVendorSource = {
            load: function () {
                var items = $.Deferred();
                var data = <?= $rows; ?>;
                items.resolve(data);
                return items.promise();
            }
        };

        $("#grid_list_vendor_vsi").dxDataGrid({
            dataSource: listVendorSource,
            showBorders: true,
            showRowLines: true,
            columnAutoWidth: true,
            allowColumnResizing: true,
            allowColumnReordering: true,
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            headerFilter: {
                visible: true
            },
            paging: {
                pageSize: 10
			},
			groupPanel: {
                        visible: true
            },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [5, 10, 20],
                showInfo: true
			},
			export: {
                enabled: true
            },
            columns: [
                {
                    caption: "Vendor Name",
                    dataField: "vendor_name",
				},

				{
                    caption: "Periode",
                    dataField: "periode",
				},

				{
                    caption: "year",
                    dataField: "year",
				},

			]
        });
	});
</script>
