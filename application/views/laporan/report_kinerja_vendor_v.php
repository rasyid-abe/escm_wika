<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Kinerja Vendor</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <table id="table_kinerja_vendor" class="table table-bordered table-striped"></table>

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
  var link = "<?php echo site_url('laporan/detail_rfq/lap_proc_value') ?>";
  return [
 '<a class="action" href="'+link+'/kinerja_vendor/'+row.status_vendor+'">',
 ''+row.jml+'',
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

var $table_kinerja_vendor = $('#table_kinerja_vendor'),
selections = [];

</script>

<script type="text/javascript">

$(function () {

  $table_kinerja_vendor.bootstrapTable({

    url: "<?php echo site_url('laporan/data_table_kinerja_vendor') ?>",
    cookieIdTable:"kinerja_vendor",
    idField:"vendor_status",
    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
    columns: [
    {
      field: 'vendor_status',
      title: 'Vendor Status',
      sortable:true,
      order:true,
      searchable:true,
      align: 'left',
      halign: 'center',
      valign: 'middle',
      width:'60%',
    },
    {
      field: 'jml',
      title: 'Jumlah',
      sortable:true,
      order:true,
      searchable:true,
      align: 'left',
      halign: 'center',
      valign: 'middle',
      width:'40%',
      formatter: operateFormatter,
      },
    ]

  });
  setTimeout(function () {
    $table_kinerja_vendor.bootstrapTable('resetView');
  }, 200);

  $table_kinerja_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias"));
  });

});



</script>

