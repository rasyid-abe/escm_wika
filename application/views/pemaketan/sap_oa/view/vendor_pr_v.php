<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Daftar Vendor Terpilih</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table id="daftar_vendor" class="table table-bordered table-striped"></table>
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

</script>

<script type="text/javascript">

var $daftar_vendor = $('#daftar_vendor'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $daftar_vendor.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_vendor_pr_view/selected') ?>",
      selectItemName:"vendor_tender[]",
      idField:"vendor_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [

      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'total_kontrak',
        title: 'Kontrak Aktif',
        sortable:true,
        order:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'total_tender',
        title: 'Tender Berjalan',
        sortable:true,
        order:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'address_city',
        title: 'Lokasi',
        sortable:true,
        order:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'fin_class',
        title: 'Klasifikasi Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'pvs_status',
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
      $daftar_vendor.bootstrapTable('resetView');
    }, 200);

    $daftar_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });
    
  });
</script>