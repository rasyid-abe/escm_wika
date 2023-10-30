<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Klasifikasi Vendor</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
  <div class="card-content">
          <form method="get" class="form-horizontal">
            <div class="form-group">
             <?php $curval = $klasifikasi_gbl; ?>
             <label class="col-md-1 control-label">Klasifikasi</label>
             <div class="col-md-2">
               <select name="klasifikasi" id="klasifikasi" class="form-control">
                <option value="">Semua</option>
                <?php $pilihan=array(
                  "K" => 'Kecil',
                  "M" => 'Menengah',
                  "B" => 'Besar',
                  );
                foreach($pilihan as $key => $val){
                  $selected = ($key == $curval) ? "selected" : ""; 
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
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
          </form>
        </div>
        <div class="card-content">
        
          <div class="table-responsive">            

            <table id="lap_kls_vnd" class="table table-bordered table-striped"></table>

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

var method = 0

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

    var mydata = $.getCustomJSON("<?php echo site_url('Vendor') ?>/"+url);

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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('laporan') ?>";
    return [
    '<a target="_blank" class="btn btn-primary btn-xs action" target="_blank" href="'+link+'/lihat_detail_vendor/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $lap_kls_vnd.bootstrapTable('remove', {
      field: 'id',
      values: [row.id]
    });
  }
  */
};
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

  var $lap_kls_vnd = $('#lap_kls_vnd'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {
    var vnd_type = '';

  function reset_session(tipe=""){
          var url2 = "<?php echo site_url('procurement/set_session/klasifikasi_gbl') ?>";
          $.ajax({
            url : url2,
            success:function(data){

            }
          });
  }

  //  $("#klir").click(function(){
  //   window.location.assign('<?php echo site_url('laporan/lap_kls_vnd/1'); ?>');
  // });

   $("#klasifikasi").change(function(){

    var myfilter = $(this).val();
    method = myfilter
    console.log(method)
    var url = "<?php echo site_url('procurement/set_session/klasifikasi_gbl') ?>";
    $.ajax({
      url : url+"/"+myfilter,
      success:function(data){
        $("#lap_kls_vnd").bootstrapTable('refresh');
      }
    });

  });

   $lap_kls_vnd.bootstrapTable({

    url: "<?php echo site_url('laporan/data_lap_kls_vnd') ?>",

    cookieIdTable:"vw_prc_bidder_list",

    idField:"vendor_id",

    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

    columns: [
    {
      field: 'vendor_id',
      title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
      align: 'center',
      width: '10%',
      events: operateEvents,
      formatter: operateFormatter,
    },
    {
      field: 'vendor_name',
      title: 'Nama Vendor',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'fin_class_name',
      title: 'Klasifikasi',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'reg_status_name',
      title: 'Status',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    ]

  });
   setTimeout(function () {
    $lap_kls_vnd.bootstrapTable('resetView');
  }, 200);

  $.each($lap_kls_vnd.bootstrapTable('getColumns'), function(i,  v){
    
    columnDetail[v.field] = true
    console.log(columnDetail)
  })

   $lap_kls_vnd.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias_lap_kls_vnd"));
  });

   
$lap_kls_vnd.on('search.bs.table', function (e, text) {
  searchDetail = text
  // console.log(searchDetail)
})
$lap_kls_vnd.on('column-switch.bs.table', function (e, field, checked) {
    columnDetail[field] = checked
})


 });

  $('#filterMetode').change(function(){

    var metode = $(this).val()

    method = metode
    $lap_kls_vnd.bootstrapTable('refresh', {
        url: "<?php echo site_url('Laporan/data_realisasi_detail') ?>?metode=" +metode
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
    console.log(columnDetail)
    if(tipe == 'detail'){
        search = searchDetail
        column = columnDetail
        limit = $lap_kls_vnd.bootstrapTable('getOptions').pageSize
        rawOffset =  $lap_kls_vnd.bootstrapTable('getOptions').pageNumber
        sortName = $lap_kls_vnd.bootstrapTable('getOptions').sortName
        sortOrder = $lap_kls_vnd.bootstrapTable('getOptions').sortOrder
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
    console.log(method)
    window.open(url+'/lapklsvnd/'+method+'?search='+search+'&limit='+limit+'&offset='+offset+'&sortName='+sortName+'&sortOrder='+sortOrder+'&column='+column, '_blank');
    

  })


</script>