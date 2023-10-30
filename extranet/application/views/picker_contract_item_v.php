
<div class="picker-container">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Katalog Sumberdaya</h5>
        </div>
        <div class="ibox-content">

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

      url: "<?php echo site_url('Kontrak/get_contract_item')."?contract_id=".$contract_id ?>",
      cookieIdTable:"picker_item_contract",
      idField:"item_code",
      striped:true,
      sidePagination:'server',
      smartDisplay:false,
      cookie:true,
      cookieExpire:'1h',
      showExport:false,
      exportTypes:['json', 'xml', 'csv', 'txt', 'excel'],
      showFilter:true,
      flat:true,
      keyEvents:false,
      showMultiSort:false,
      reorderableColumns:false,
      resizable:false,
      pagination:true,
      cardView:false,
      detailView:false,
      search:true,
      showRefresh:true,
      showToggle:true,
      clickToSelect:true,
      showColumns:true,
      columns: [
      {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'item_code',
        title: 'Kode Item',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }, {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },

      {
        field: 'formatted_qty',
        title: 'Volume',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
       {
        field: 'uom',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
       {
        field: 'formatted_volume_remain',
        title: 'Sisa Volume',
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
    url:"<?php echo site_url('Kontrak/picker') ?>",
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
    url:"<?php echo site_url('Kontrak/picker') ?>",
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
    return row.item_code
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.item_code, selections) !== -1;
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

// function detailFormatter(index, row) {

//   var mydata = $.getCustomJSON("<?php echo site_url('Commodity/alias_kat_jasa') ?>");

//   var html = [];
//   $.each(row, function (key, value) {
//    var data = $.grep(mydata, function(e){ 
//      return e.field == key; 
//    });

//    if(typeof data[0] !== 'undefined'){

//      html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
//    }
//  });

//   return html.join('');

// }

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
window.operateEvents = {
  'click .like': function (e, value, row, index) {
    alert('You click like action, row: ' + JSON.stringify(row));
  },
  'click .remove': function (e, value, row, index) {
    $table.bootstrapTable('remove', {
      field: 'id',
      values: [row.item_code]
    });
  }
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