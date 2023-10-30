<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Template Evaluasi</h5>
          <div class="card-tools">
          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">
            <table id="table" class="table table-bordered table-striped"></table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


  var $table = $('#table'),
  $remove = $('#remove'),
  selections = [];

  $(function () {

$table.bootstrapTable({
  url: "<?php echo site_url('Procurement/data_template_evaluasi') ?>",
  cookieIdTable:"template_evaluasi",
  idField:"evt_id",
  <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
columns: [
  {
    field: 'radio',
    radio:true,
    align: 'center',
    valign: 'middle'
  },
   {
    field: 'evt_name',
    title: 'Nama',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle'
  },
   {
    field: 'evt_type',
    title: 'Jenis',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle'
  },


  {
    field: 'evt_passing_grade',
    title: 'Passing Grade',
    sortable:true,
    order:true,
    searchable:true,
    align: 'right',
    valign: 'middle'
  },

  {
    field: 'evt_tech_weight',
    title: 'Bobot Teknis',
    sortable:true,
    order:true,
    searchable:true,
    align: 'right',
    valign: 'middle'
  },

   {
    field: 'evt_price_weight',
    title: 'Bobot Harga',
    sortable:true,
    order:true,
    searchable:true,
    align: 'right',
    valign: 'middle'
  },

  ]

});
setTimeout(function () {
  $table.bootstrapTable('resetView');
}, 200);
$table.on('check.bs.table  check-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();
  var param = "";
  $.each(selections,function(i,val){
    param += val+"=1&";
  });
  $.ajax({
    url:"<?php echo site_url('Procurement/picker') ?>",
    data:param,
    type:"get"
  });

});
$table.on('uncheck.bs.table uncheck-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();

  var param = "";
  $.each(selections,function(i,val){
    param += val+"=0&";
  });
  $.ajax({
    url:"<?php echo site_url('Procurement/picker') ?>",
    data:param,
    type:"get"
  });
});
$table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row));

});
$table.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});
$remove.click(function () {
  var ids = getIdSelections();
  $table.bootstrapTable('remove', {
    field: 'id',
    values: ids
  });
  $remove.prop('disabled', true);
});

});
function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
    return row.evt_id
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.evt_id, selections) !== -1;
  });
  return res;
}

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

function detailFormatter(index, row) {

  var mydata = $.getCustomJSON("<?php echo site_url('Procurement/alias_template_evaluasi') ?>");

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
  return [
  '<a class="like" href="javascript:void(0)" title="Like">',
  '<i class="glyphicon glyphicon-heart"></i>',
  '</a>  ',
  '<a class="remove" href="javascript:void(0)" title="Remove">',
  '<i class="glyphicon glyphicon-remove"></i>',
  '</a>'
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
