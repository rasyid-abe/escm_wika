<section>
    <div class="row">
        <div class="col-12">
            <div class="card p-4">

                <div class="card-header border-bottom pb-2">
                    <h4 class="card-title float-left">Daftar Pengadaan <span id="subtitle"></span></h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <?php echo (isset($export) && !empty($export)) ? $export : '' ;?>
                        <table id="table_monitor_pengadaan" class="table table-bordered table-striped"></table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script type="text/javascript">


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

    var mydata = $.getCustomJSON("<?php echo site_url('Procurement') ?>/"+url);

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
  function operateFormatter2(value, row, index) {
    var link = "<?php echo site_url('procurement/procurement_tools/monitor_pengadaan') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/lihat_permintaan/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/procurement_tools/monitor_pengadaan') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/lihat/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
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

  var $table_monitor_pengadaan = $('#table_monitor_pengadaan'),
  $table_monitor_pr = $('#table_monitor_pr'),
  selections = [];
  var searchDetail,
  columnDetail = {};

</script>

<script type="text/javascript">

  $(function () {

    $table_monitor_pengadaan.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_monitor_pengadaan') ?>",
      cookieIdTable:"monitor_pengadaan",
      idField:"ptm_number",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'ptm_number',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        formatter: operateFormatter,
        valign: 'middle'
      },
      {
        field: 'ptm_number',
        title: 'No. Tender',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'ptm_requester_name',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }, {
        field: 'ptm_subject_of_work',
        title: 'Nama Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
      {
        // field: 'ptm_requester_pos_name',
        field: 'ptm_dept_name',
        title: 'Divisi/Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'last_pos',
        title: 'Posisi saat Ini',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      },
      {
        field: 'status',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      },
      ]

    });
    setTimeout(function () {
      $table_monitor_pengadaan.bootstrapTable('resetView');
    }, 200);

    $.each($table_monitor_pengadaan.bootstrapTable('getColumns'), function(i,  v){
      columnDetail[v.field] = true
    })

    $table_monitor_pengadaan.on('search.bs.table', function (e, text) {
      searchDetail = text
      // console.log(searchRekap)
    })

    $table_monitor_pengadaan.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias"));
    });

    $table_monitor_pengadaan.on('column-switch.bs.table', function (e, field, checked) {
      columnDetail[field] = checked
    })

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

  var getUrlParameter = function getUrlParameter(sParam) {
       var sPageURL = window.location.search.substring(1),
           sURLVariables = sPageURL.split('&'),
           sParameterName,
           i;

       for (i = 0; i < sURLVariables.length; i++) {
           sParameterName = sURLVariables[i].split('=');

           if (sParameterName[0] === sParam) {
               return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
           }
       }
   };

   setTimeout(function() {
      if (getUrlParameter('type') != '') {

         let status_params = getUrlParameter('type');
         $table_monitor_pengadaan.bootstrapTable('refresh', {url: '<?php echo site_url('Procurement/data_monitor_pengadaan') ?>'+'/'+status_params})

         if (status_params == 'rfq_ongoing') {
          $('#subtitle').html('Sedang Diproses');
         }else if (status_params == 'rfq_selesai') {
          $('#subtitle').html('Selesai');
         }

      }
   }, 500);
  </script>
<?php } ?>
