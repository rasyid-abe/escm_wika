<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Daftar Pengadaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">
            <table id="table_monitor_pengadaan" class="table table-bordered table-striped"></table>
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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/procurement_tools/monitor_pengadaan') ?>";
    return [
    '<a class="btn btn-info btn-md action" target="_blank" href="'+link+'/lihat/'+value+'">',
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
  selections = [];

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
        field: 'ptm_packet',
        title: 'Nama Paket',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },      
      {
        field: 'jenis_pengadaan',
        title: 'Jenis Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'ptm_pagu_anggaran',
        title: 'Anggaran',
        sortable:true,
        order:true,
        align: 'right',
        valign: 'middle',
        dataType: "number",
        format: "#,##0;(#,##0)",
        width:'20%',
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
      {
        field: 'tender_metode',
        title: 'Metode',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      },
      {
        field: 'jml_bidder',
        title: 'Bidder',
        align: 'center',
        width:'10%',
        valign: 'middle'
      },
      ]

    });
    setTimeout(function () {
      $table_monitor_pengadaan.bootstrapTable('resetView');
    }, 200);

    $table_monitor_pengadaan.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias"));
    });

  });

</script>
