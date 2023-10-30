<div class="picker-container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Katalog Material Strategis</h5>
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

      url:"<?php echo site_url('Procurement/get_item_matgis')."?&spk_code=".$spk_code."&last_item_code=".$last_item_code ?>",
      cookieIdTable:"picker_sumberdaya",
      idField:"smbd_catalog_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'smbd_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }, {
        field: 'group_smbd_name',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },

      {
        field: 'smbd_name',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'price',
        title: 'Harga',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
       {
        field: 'unit',
        title: 'Satuan',
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
    url:"<?php echo site_url('Commodity/picker') ?>",
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
    url:"<?php echo site_url('Commodity/picker') ?>",
    data:param,
    type:"get"
  });
});
$table.on('expand-row.bs.table', function (e, index, row, $detail) {

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
    return row.smbd_catalog_code
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.smbd_catalog_code, selections) !== -1;
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

</script>