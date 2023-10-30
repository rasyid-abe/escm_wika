<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Daftar Seluruh Pekerjaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">
            <table id="table_pekerjaan" class="table table-bordered table-striped"></table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

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

    var mydata = $.getCustomJSON("<?php echo site_url() ?>/"+url);

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
    var link = "<?php echo site_url('log/change_role/') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/'+value+'">',
    'Proses',
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

  var $table_pekerjaan = $('#table_pekerjaan'),
  selections = [];

</script>


<script type="text/javascript">

  $(function () {

    $table_pekerjaan.bootstrapTable({

      url: "<?php echo site_url('Log/data_all_job') ?>",
      cookieIdTable:"daftar_pekerjaan",
      idField:"urlid",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'urlid',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        formatter: operateFormatter,
        valign: 'middle'
      },
      {
        field: 'number',
        title: 'Nomor/Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'activity',
        title: 'Aktivitas',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }, {
        field: 'pos_name',
        title: 'Posisi Saat Ini',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      }
      ]

    });
    setTimeout(function () {
      $table_pekerjaan.bootstrapTable('resetView');
    }, 200);

    $table_pekerjaan.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias"));
    });

  });

</script>