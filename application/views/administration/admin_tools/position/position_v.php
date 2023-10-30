
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header border-bottom pb-2">
        <h4 class="card-title float-left">Posisi</h4>
      </div>

      <div class="card-body">
        <div class="card-content">
          <div class="table-responsive">
            <a class="btn btn-info" href="<?php echo site_url('administration/admin_tools/position/add_position') ?>" role="button">
              <i class="ft-plus mr-1"></i>Tambah
            </a>
            <table id="position" class="table table-bordered table-striped"></table>
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

    var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/"+url);

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
    var link = "<?php echo site_url('administration/admin_tools/position') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/ubah/'+value+'">',
    '<i class="ft-edit mr-1"></i>Ubah',
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

  var $position = $('#position'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $position.bootstrapTable({

      url: "<?php echo site_url('administration/data_position') ?>",
      cookieIdTable:"adm_pos",
      idField:"pos_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'pos_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        formatter: operateFormatter,
      },
      {
        field: 'pos_name',
        title: 'Nama Posisi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'dept_name',
        title: 'Nama Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'district_name',
        title: 'Kantor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $position.bootstrapTable('resetView');
}, 200);

$position.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_position"));
});

});

</script>
