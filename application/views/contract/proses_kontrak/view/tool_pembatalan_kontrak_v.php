<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Daftar Kontrak</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_pembatalan_kontrak" class="table table-bordered table-striped"></table>
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

    var mydata = $.getCustomJSON("<?php echo site_url('Contract') ?>/"+url);

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
    var link = "<?php echo site_url('Contract/') ?>";
    return [
    '<a class="btn btn-info dialog" href="#" data-url="'+link+'/proses_pembatalan_kontrak/'+value+'">',
    'Ubah',
    '</a>  ',
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
  },
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

  var $table_pembatalan_kontrak = $('#table_pembatalan_kontrak'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_pembatalan_kontrak.bootstrapTable({

      url: "<?php echo site_url('Contract/data_monitor_kontrak/tools') ?>",
      cookieIdTable:"pembatalan_kontrak",
      idField:"contract_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'contract_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        valign: 'middle',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'vw_ctr_monitor.ptm_number',
        title: 'Nomor Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'contract_number',
        title: 'Nomor Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'subject_work',
        title: 'Deskripsi Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'contract_type',
        title: 'Tipe',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'status_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      ]

    });
    
  setTimeout(function () {
    $table_pembatalan_kontrak.bootstrapTable('resetView');
  }, 200);

  $table_pembatalan_kontrak.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias_pembatalan_kontrak"));
  });

  });

</script>