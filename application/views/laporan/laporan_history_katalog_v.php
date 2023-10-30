<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        
        <div class="card-title">
          <h5>History Harga Katalog</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        
        <div class="card-content">
        
          <div class="row">
            <div class="table-responsive">
              <div id="container" style="margin:1.5em 1em; height: 600px " ></div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<div id="preview"></div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<script>

var datsu = <?php echo $dats ?>;
// console.log(datsu)
 
var monthCats = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
var year = new Date().getFullYear()
Highcharts.chart('container', {

    title: {
        text: 'History Harga Katalog Sumber Daya Matgis'
    },

    subtitle: {
        text: 'Tahun '+ year
    },

    yAxis: {
        title: {
            text: 'Harga Barang'
        }
    },
    // chart: {
    //         marginBottom: 0,
    //         spacingBottom: 0,
    //         height : 500
    // },
    // legend: {
    //     margin : 500,
    //     navigation: {
    //         activeColor: '#3E576F',
    //         animation: true,
    //         arrowSize: 12,
    //         inactiveColor: '#CCC',
    //         style: {
    //             fontWeight: 'bold',
    //             color: '#333',
    //             fontSize: '12px'
    //         }
    //     }
    // },

        chart: {
            marginBottom: 170,
            events: {
                load: function(e){
                    // $('#preview').html(this.getCSV())
                }
            }
        },
        
        legend: {
            align: 'center',
            verticalAlign: 'bottom',
            x: 0,
            y: 0
        },
    // legend: {
    //     layout: 'vertical',
    //     align: 'right',
    //     // verticalAlign: 'bottom',
    //     x: 0,
    //     y: 0
    // },
    xAxis: {         
        // type: 'category',
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    exporting: {
        sourceWidth: 1200,
        sourceHeight: 700,
        chartOptions: {
            subtitle: null,
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true
                    }
                }
            }
        }
    },
    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            // pointStart: 
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function() {
        return this.point.currency.replace(':val', this.y);        
      }
    },
    credits: {
        text : '', //'http://stackoverflow.com/users/1011544/jlbriggs',
        href : '' //http://stackoverflow.com/users/1011544/jlbriggs?tab=profile'
    },

    series : datsu,

/*
    series:
        [            
            {
            name: 'Beton Ready Mix Kelas E',
            data: [
                {
                'name':'A10045',
                'y':792000
                },
                {
                'name':'A10045',
                'y':792000
                },
                {
                'name':'A10045',
                'y':792000
                }
            ]},
            {
            name: 'Beton Ready Mix Kelas P',
            data: [
                {
                'name':'A10046',
                'y':1147500
                },
                {
                'name':'A10046',
                'y':1147500
                },
                {
                'name':'A10046',
                'y':1147500
                }
            ]}  
        ],
*/
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
</script>