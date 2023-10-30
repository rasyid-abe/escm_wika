<style media="screen">
.label-success, .badge-success {
  background-color: #5b9c1f;
  color: #FFFFFF;
}
</style>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js "></script>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5><?php echo $sub_title?></h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">
          <div class="table-responsive">
            <table id="table_monitor" class="table table-bordered table-striped"></table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

/** add active class and stay opened when selected */
var url = window.location;

//check if redirct url
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/monev'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_report_monev';
}
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/wo'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_wo_matgis';
}
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/si'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_si';
}
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/sppm'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_sppm';
}
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/do'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_do';
}
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/sj'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_sj';
}
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/bapb'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_bapb';
}
if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/invoice'){
  url='<?php echo base_url()?>index.php/contract/monitoring_matgis/monitor_invoice';
}


// for sidebar menu entirely but not cover treeview
$('ul.metismenu a').filter(function() {
  return this.href == url;
}).parent().addClass('active');

// for treeview
$('ul.metismenu a').filter(function() {

  return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

var $table_monitor_pengadaan = $('#table_monitor_pengadaan'),
$table_monitor_pr = $('#table_monitor_pr'),
selections = [];
var searchDetail,
columnDetail = {};

function wo_act(value, row, index) {
  var link = "<?php echo site_url('contract_matgis') ?>";
  return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/process_matgis/<?php echo $mod?>/'+value+'/2">',
    'Lihat',
    '</a>  ',
  ].join('');
}

function numberWithCommas(x) {

  if(x!==null){
    x=parseFloat(x);
    return (x=x+'').replace(new RegExp('\\B(?=(\\d{3})+'+(~x.indexOf('.')?'\\.':'$')+')','g'),',');

  }else{
    return 0;
  }

}

function TextAccepted(x){
  var d="";
  if(x==1){
    d='<i class="fa fa-check"></i>';
  }else{
    d="";
  }
  return d;
}

function number_format(value, row, index) {
  return [numberWithCommas(value)].join('');
}

function text_accepted(value, row, index) {
  return [TextAccepted(value)].join('');
}

var $table_monitor = $('#table_monitor');
var selections = [];

function stat_format(value,row,index){
  if(row['status']==2041){
    return ['<span class="label label-danger">'+value+'</span>'].join();
  }else{
    return ['<span class="label label-success">'+value+'</span>'].join();
  }

}

function operateFormatter(value, row, index) {
    return [
    value
    /*
    '<a class="remove" href="javascript:void(0)" title="Remove">',
    '<i class="glyphicon glyphicon-remove"></i>',
    '</a>'
    */
    ].join('');
  }

$(function () {

  $table_monitor.bootstrapTable({
    dom: 'Bfrtip',
    buttons: [
      'copyHtml5',
      'excelHtml5',
      'csvHtml5',
      'pdfHtml5'
    ],
    url: "<?php echo site_url('data_matgis/monitoring_task_matgis/'.$mod) ?>",
    cookieIdTable:"table_monitor",
    idField:"cwo_id",

    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

    columns: [
      <?php
      switch ($mod) {
        // case 'wo':
        // include APPPATH.'views/contract/matgis/screens/monitor_wo.php';
        // break;
        // case 'si':
        // include APPPATH.'views/contract/matgis/screens/monitor_si.php';
        // break;
        // case 'sppm':
        // include APPPATH.'views/contract/matgis/screens/monitor_sppm.php';
        // break;
        // case 'bapb':
        // include APPPATH.'views/contract/matgis/screens/monitor_bapb.php';
        // break;
        // case 'do':
        // include APPPATH.'views/contract/matgis/screens/monitor_do.php';
        // break;
        // case 'sj':
        // include APPPATH.'views/contract/matgis/screens/monitor_sj.php';
        // break;
        // case 'inv':
        // include APPPATH.'views/contract/matgis/screens/monitor_inv.php';
        // break;
        case 'monev':
        include APPPATH.'views/contract/matgis/screens/monitor_monev.php';
        break;
        case 'reports':
        include APPPATH.'views/contract/matgis/screens/monitor_reports.php';
        break;
        default:
        break;
      }
      ?>
    ]

  });
  setTimeout(function () {
    $table_monitor.bootstrapTable('resetView');
  }, 200);

  $table_monitor.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias"));
  });

});

</script>

<?php if(isset($export) && !empty($export)){ ?>
  <script type="text/javascript">

  $('.btnExport').click(function(){

    var url = $(this).attr("data-url")
    var tipe = $(this).attr("data-tipe")
    var search = ""
    var column
    var data
    var limit = 0
    var rawOffset = 0
    var offset = 0
    var sortName = ''
    var sortOrder = ''

    if(tipe == 'rekap'){
      // search = searchRekap
      // column = columnRekap
    }else{
      search = searchDetail
      column = columnDetail
      limit = $table_monitor_pengadaan.bootstrapTable('getOptions').pageSize
      rawOffset =  $table_monitor_pengadaan.bootstrapTable('getOptions').pageNumber
      sortName = $table_monitor_pengadaan.bootstrapTable('getOptions').sortName
      sortOrder = $table_monitor_pengadaan.bootstrapTable('getOptions').sortOrder
    }

    if(search == undefined){
      search = ""
    }

    if(sortName == undefined){
      sortName = ""
    }
    // column = JSON.stringify(column)
    // data = {
    //   search: search,
    //   // column: column,
    //   metode: method
    // }

    // data = JSON.stringify(data)
    column = JSON.stringify(column)
    console.log(search)
    window.open(url+'/rfq/'+0+'?search='+search+'&limit='+limit+'&offset='+offset+'&sortName='+sortName+'&sortOrder='+sortOrder+'&column='+column, '_blank');


  })
  </script>
<?php } ?>
