<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins p-4">
        <div class="card-title">
          <h5>Lead Time</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <!-- <form method="post" action="<?php// echo site_url($controller_name."/submit_ubah_permintaan_pengadaan");?>"  class="form-horizontal ajaxform">
            <?php// $curval = set_value("jumlah_item_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-2">
              <input type="date" class="form-control money" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php //echo $curval ?>">
             </div>
             <div class="col-sm-1"><p class="form-control-static" align="center">S/D</p></div>
             <div class="col-sm-2">
              <input type="date" class="form-control money" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php // echo $curval ?>">
             </div>
           </div>
         </form> -->
         <!-- <div class="form-group">
              <label class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-2">
              <input type="date" class="form-control money" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php //echo $curval ?>">
             </div>
             <div class="col-sm-1"><p class="form-control-static" align="center">S/D</p></div>
             <div class="col-sm-2">
              <input type="date" class="form-control money" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php // echo $curval ?>">
             </div>
           </div> -->
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
         <div class="col-md-6">
            <label class="col-md-2">Filter per metode: </label>
            <div class="col-md-5">
              <select id="filterMetode" class="form-control filter">
                  <option value="0" select>All</option>
                  <option value="1">Penunjukkan Langsung</option>
                  <option value="2">Pemilihan Langsung</option>
                  <option value="3">Pelelangan</option>
                </select>
              </div>
            </div>
            <table id="rekap" class="table table-bordered table-striped"></table>
          <!-- <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td>No.</td>
                <td>Metode</td>
                <td>Jumlah</td>
                <td>Nilai OE</td>
                <td>Kontrak</td>
                <td>Efisiensi Nilai</td>
                <td>Efisiensi Persentase</td>
              </tr>
            </thead>
            <tbody>
              <?php 
              // $i = 1;
              // foreach ($total as $key => $value) { ?>
              <tr>
                <td><?php //echo $i++; ?></td>
                <td><?php //echo $label[$key] ?></td>
                <td><?php //echo inttomoney($value['jumlah']) ?></td>
                <td><?php //echo inttomoney($value['oe']) ?></td>
                <td><?php //echo inttomoney($value['kontrak']) ?></td>
                <td><?php //echo inttomoney($value['oe']-$value['kontrak']) ?></td>
                <td><?php //echo inttomoney($value['kontrak']/$value['oe']*100) ?> %</td>
              </tr>
              <?php //} ?> 
            </tbody> 
          </table> -->

        </div>

      </div>
    </div>

    <div class="card float-e-margins p-4">
        <div class="card-title">
          <h5>Lead Time Detail</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">
          <div class="row">
            <div class="col-md-12">
                <btn data-url="<?php echo site_url();?>/laporan/laporanPdfDetail" data-tipe="detail"
                  class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan PDF" target="_blank"
                  style="background-color:red;color:white;margin-right:5px">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </btn>

                <btn data-url="<?php echo site_url();?>/laporan/laporanExcelDetail" data-tipe="detail"
                  class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan Excel" target="_blank"
                  style="background-color:green;color:white;margin-right:5px">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </btn>
            </div>
          </div>
         <div class="table-responsive">
            <table id="detail" class="table table-bordered table-striped"></table>
          

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

var $rekap = $('#rekap'),
selections = [];

</script>

<script type="text/javascript">

$(function () {

  $rekap.bootstrapTable({

    url: "<?php echo site_url('laporan/data_durasi_rekap') ?>",
    cookieIdTable:"vw_durasi_rekap",
    idField:"metode",
    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
    columns: [
    {
      field: 'metode',
      title: 'Metode Pengadaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'av',
      title: 'Lama Proses Pengadaan',
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

$rekap.on('expand-row.bs.table', function (e, index, row, $detail) {
$rekap.html(detailFormatter(index,row,"alias_rekap"));
});

$.each($rekap.bootstrapTable('getColumns'), function(i,  v){
  columnRekap[v.field] = true
})

$rekap.on('search.bs.table', function (e, text) {
  searchRekap = text
})

$rekap.on('column-switch.bs.table', function (e, field, checked) {
  columnRekap[field] = checked
})

});


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

var $detail = $('#detail'),
selections = [];


$(function () {

  $detail.bootstrapTable({

    url: "<?php echo site_url('laporan/data_durasi_detail') ?>",
    cookieIdTable:"vw_durasi_detail",
    idField:"ptm_number",
    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
    columns: [
    {
      field: 'ptm_number',
      title: 'Nomor Pengadaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'ppm_project_name',
      title: 'Nama Proyek',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'ppm_subject_of_work',
      title: 'Nama Rencana Pekerjaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'pr_packet',
      title: 'Nama Paket',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'ptm_type_of_plan',
      title: 'Jenis Pengadaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'ptm_dept_name',
      title: 'Dept',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'ptm_created_date',
      title: 'Mulai Pengadaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'ptm_completed_date',
      title: 'Akhir Pengadaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'av',
      title: 'Lama Pengadaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    ]

  });
setTimeout(function () {
$detail.bootstrapTable('resetView');
}, 200);

$.each($detail.bootstrapTable('getColumns'), function(i,  v){
  columnDetail[v.field] = true
})

$detail.on('expand-row.bs.table', function (e, index, row, $detail) {
$detail.html(detailFormatter(index,row,"alias_detail"));
});

$detail.on('search.bs.table', function (e, text) {
  searchDetail = text
})

$detail.on('column-switch.bs.table', function (e, field, checked) { 
 columnDetail[field] = checked
})

});


  $('#filterMetode').change(function(){

    var metode = $(this).val()

    method = metode

    $rekap.bootstrapTable('refresh', {
         url: "<?php echo site_url('Laporan/data_durasi_rekap') ?>?metode=" +metode
      })
    $detail.bootstrapTable('refresh', {
        url: "<?php echo site_url('Laporan/data_durasi_detail') ?>?metode=" +metode
    })
  })
  

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

    if(rawOffset != 0){
      offset = limit * (rawOffset -1)
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
    window.open(url+'/durasi/'+method+'?search='+search+'&limit='+limit+'&offset='+offset+'&sortName='+sortName+'&sortOrder='+sortOrder+'&column='+column, '_blank');
    

  })

</script>