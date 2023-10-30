<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Statistik Kontrak</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">
        <div class="row">
          <div class="col-md-12">
                <btn data-url="<?php echo site_url();?>/laporan/laporanPdfRekap" data-tipe="rekap"
                  class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan PDF" target="_blank"
                  style="background-color:red;color:white;margin-right:5px">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </btn>

                <btn data-url="<?php echo site_url();?>/laporan/laporanExcelRekap" data-tipe="rekap"
                  class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan Excel" target="_blank"
                  style="background-color:green;color:white;margin-right:5px">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </btn>
            </div>
          </div>
         <div class="table-responsive">
         <table id="rekap" class="table table-bordered table-striped"></table>
          <!-- <table class="table table-bordered table-striped">
            <thead style="text-align: center;">
              <tr>
                <td>Statistik Kontrak</td>
                <td>Jumlah</td>
              </tr>
            </thead>
            <tbody>
              <?php
              // foreach ($total as $key => $value) {
              //     if ($value['statistik_kontrak'] == 'Kontrak Aktif') {
              //       $isi = 'k1';
              //     } elseif ($value['statistik_kontrak'] == 'Kontrak Expired < 3 Bulan') {
              //       $isi = 'k2';
              //     } elseif ($value['statistik_kontrak'] == 'Kontrak Expired < 1 Bulan') {
              //       $isi = 'k3';
              //     } elseif ($value['statistik_kontrak'] == 'Kontrak Expired') {
              //       $isi = 'k4';
              //     } elseif ($value['statistik_kontrak'] == 'Kontrak Selesai') {
              //       $isi = 'k4';
                  // }
              ?>
              
              
              <tr>
                <td><?php// echo $value['statistik_kontrak'] ?></td>
                <td>
                  <a href="index.php/laporan/detail_rfq/lap_proc_value/<?php// echo $isi ?>"><?php// echo $value['jml'] ?>
                  </a>
                </td>
              </tr>
            <?php //} ?> 
            </tbody> 
          </table> -->

        </div>

      </div>
    </div>

  </div>
</div>
</div>
<script type="text/javascript">

var searchRekap,
columnRekap = {};

var searchDetail,
columnDetail = {};

var method

$(document).ready(function(){
  method = 0
})

jQuery.extend({
  getCustomJSON: function(url) {
    var result = null;
    $.ajax({
      url: url,
      type: 'get',
      dataType: 'json',
      async: false,
      success: function(data) {
        result = data;
      }
    });
    return result;
  }
});

function detailFormatter(index, row, url) {
  var mydata = $.getCustomJSON("<?php echo site_url('laporan') ?>/"+url);

  var html = [];
  $.each(row, function (key, value) {
   var data = $.grep(mydata, function(e){ 
     return e.field == key; 
   });

   if(typeof data[0] !== 'undefined'){

     html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
   }
 });

  return html.join('');

}

function totalTextFormatter(data) {
return 'Total';
}
function totalNameFormatter(data) {
return data.length;
}
function totalPriceFormatter(data) {
var total = 0;
$.each(data, function (i, row) {
  total += +(row.price.substring(1));
});
return '$' + total;
}

</script>

<script type="text/javascript">

var $rekap = $('#rekap'),
selections = [];


$(function () {

  $rekap.bootstrapTable({

    url: "<?php echo site_url('laporan/data_report_statistik_contract') ?>",
    cookieIdTable:"vw_efisiensi_rekap",
    idField:"metode",
    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
    columns: [
    {
      field: 'statistik_kontrak',
      title: 'Statistik Kontrak',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'jml',
      title: 'Jumlah',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    ]

  });
setTimeout(function () {
$rekap.bootstrapTable('resetView');
}, 200);

$.each($rekap.bootstrapTable('getColumns'), function(i,  v){
  columnRekap[v.field] = true
})

$rekap.on('expand-row.bs.table', function (e, index, row, $detail) {
$rekap.html(detailFormatter(index,row,"alias_rekap"));
});

$rekap.on('search.bs.table', function (e, text) {
  searchRekap = text
  // console.log(searchRekap)
})

$rekap.on('column-switch.bs.table', function (e, field, checked) {
  columnRekap[field] = checked 
})

});
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
        search = searchRekap
        column = columnRekap
        limit = $rekap.bootstrapTable('getOptions').pageSize
        rawOffset =  $rekap.bootstrapTable('getOptions').pageNumber
        sortName = $rekap.bootstrapTable('getOptions').sortName
        sortOrder = $rekap.bootstrapTable('getOptions').sortOrder
      }else{
        search = searchDetail
        column = columnDetail
        limit = $detail.bootstrapTable('getOptions').pageSize
        rawOffset =  $detail.bootstrapTable('getOptions').pageNumber
        sortName = $detail.bootstrapTable('getOptions').sortName
        sortOrder = $detail.bootstrapTable('getOptions').sortOrder
      }

    if(search == undefined){
      search = ""
    }

    if(sortName == undefined){
      sortName = ""
    }
    

    if(rawOffset != 0){
      offset = limit * (rawOffset -1)
    }
    // column = JSON.stringify(column)
    // data = {
    //   search: search,
    //   // column: column,
    //   metode: method
    // }

    // data = JSON.stringify(data)
    column = JSON.stringify(column)
    console.log(column)
    window.open(url+'/statistikCon/'+method+'?search='+search+'&limit='+limit+'&offset='+offset+'&sortName='+sortName+'&sortOrder='+sortOrder+'&column='+column, '_blank');
    

  })
</script>