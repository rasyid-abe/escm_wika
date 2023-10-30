<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Waktu Proses Seluruh Departemen</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">
          	
            <div id="rkp" style="min-width: 410px; max-width: 900px; height: <?php echo $hrkp."px;" ?>; margin: 0 auto"></div>
 			
 			<div id="rkap" style="min-width: 410px; max-width: 900px; height: <?php echo $hrkap."px;" ?>; margin: 0 auto"></div>

          </div>

        </div>
      </div>

    </div>
  </div>
</div>



<script>
	Highcharts.chart('rkap', {
	    chart: {
	        type: 'bar'
	    },
	    title: {
	        text: 'Waktu Proses (Rata - Rata) Non Proyek'
	    },
	    subtitle: {
	        text: ' '
	    },
	    xAxis: {
	        // categories: ['Dept 1', 'Dept 2', 'Dept 3', 'Dept 4', 'Dept 5'],
	        type: 'category',
	        title: {
	            text: null
	        }
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: 'Durasi (hari kalender)',
	            align: 'high'
	        },
	        labels: {
	            overflow: 'justify'
	        }
	    },
	    tooltip: {
	        valueSuffix: '',
	        formatter: function () {
	                  return '<b>' + this.point.y + ' Hari </b><br>' + this.point.total + ' RFQ, '+ this.point.fail + ' RFQ Gagal';
	              }
	    },
	    plotOptions: {
	        bar: {
	            dataLabels: {
	                enabled: true
	            }
	        }
	    },
	    legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'top',
	        x: -40,
	        y: 80,
	        // enabled: false,
	        floating: true,
	        borderWidth: 1,
	        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
	        shadow: true
	    },
	    credits: {
	        enabled: false
	    },
	    series: [{
	        name: 'Max durasi pengadaan : 13 hari',
	        data: [

	        <?php foreach ($datarkap as $key => $value) { ?>
	        	
	        	{
	        	name : '<?php echo $value["dept"] ?>',
	        	y : <?php echo round($value['dur'], 2) ?>,
	        	total : <?php echo $value['total'] ?>,
	        	fail : <?php echo $value['fie'] ?>,
	        	color: '<?php echo $value["colour"] ?>'
	       		},

	        <?php } ?>
	        // {
	        // 	name : 'fdf',
	        // 	y : 23,
	        // 	rfq : 323,
	        // 	rfqf : 323,
	        // 	color: '#aaff99'
	        // },{
	        // 	name : 'hkkj',
	        // 	y : 55,	
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // },{
	        // 	name : 'aasd',
	        // 	y : 51,
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // },{
	        // 	name : ' dg',
	        // 	y : 3,
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // },{
	        // 	name : 'fsfds',
	        // 	y : 5,
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // }

	        ]
	    }]
	});
</script>
<script>
	Highcharts.chart('rkp', {
	    chart: {
	        type: 'bar'
	    },
	    exporting: {
	          sourceWidth: 1360,
	          sourceHeight: 800,
	      },
	    title: {
	        text: 'Waktu Proses (Rata - Rata) Proyek'
	    },
	    subtitle: {
	        text: ' '
	    },
	    xAxis: {
	        // categories: ['Dept 1', 'Dept 2', 'Dept 3', 'Dept 4', 'Dept 5'],
	        type: 'category',
	        title: {
	            text: null
	        }
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: 'Durasi (hari kalender)',
	            align: 'high'
	        },
	        labels: {
	            overflow: 'justify'
	        }
	    },
	    tooltip: {
	        valueSuffix: '',
	        formatter: function () {
	                 return '<b>' + this.point.y + ' Hari </b><br>' + this.point.total + ' RFQ, '+ this.point.fail + ' RFQ Gagal';
	              }
	    },
	    plotOptions: {
	        bar: {
	            dataLabels: {
	                enabled: true
	            }
	        }
	    },
	    legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'top',
	        x: -40,
	        y: 80,
	        // enabled: false,
	        floating: true,
	        borderWidth: 1,
	        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
	        shadow: true
	    },
	    credits: {
	        enabled: false
	    },
	    series: [{
	        name: 'Max durasi pengadaan : 13 hari',
	        data: [

	        <?php foreach ($datarkp as $key => $value) { ?>
	        	
	        	{
	        	name : '<?php echo $value["dept"] ?>',
	        	y : <?php echo round($value['dur'], 2) ?>,
	        	total : <?php echo $value['total'] ?>,
	        	fail : <?php echo $value['fie'] ?>,
	        	color: '<?php echo $value["colour"] ?>'
	       		},

	        <?php } ?>
	        // {
	        // 	name : 'fdf',
	        // 	y : 23,
	        // 	rfq : 323,
	        // 	rfqf : 323,
	        // 	color: '#aaff99'
	        // },{
	        // 	name : 'hkkj',
	        // 	y : 55,	
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // },{
	        // 	name : 'aasd',
	        // 	y : 51,
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // },{
	        // 	name : ' dg',
	        // 	y : 3,
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // },{
	        // 	name : 'fsfds',
	        // 	y : 5,
	        // 	rfq : 323,
	        // 	rfqf : 323
	        // }

	        ]
	    }]
	});
</script>
