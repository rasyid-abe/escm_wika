<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Template Dokumen Vendor</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>

        <div class="card-content">

          <div class="table-responsive">
            <a href="<?php echo site_url('vendor/vendor_tools/doc_vendor/add') ?>" type="button" class="btn btn-primary">Tambah</a>
            <table id="template_kuesioner" class="table table-bordered table-striped"></table>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  var d = new Date();
  var month = d.getMonth() + 1;

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

    var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/" + url);

    var html = [];
    $.each(row, function(key, value) {
      var data = $.grep(mydata, function(e) {
        return e.field == key;
      });

      if (typeof data[0] !== 'undefined') {

        html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
      }
    });

    return html.join('');

  }

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('vendor/vendor_tools/doc_vendor') ?>";
    return [

      '<a class="btn btn-primary btn-xs action" href="' + link + '/status/aktif/' + value + '">',
      'Aktif',
      '</a>  ',
      '<a onclick="return confirm(\'Yakin Menonaktifkan Template Ini?\')" class="btn btn-danger btn-xs action" href="' + link + '/status/nonaktif/' + value + '">',
      'Nonaktif',
      '</a>  ',
      '<a class="btn btn-info btn-xs action" href="' + link + '/edit/' + value + '">',
      'Ubah',
      '</a>  '
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
    $.each(data, function(i, row) {
      total += +(row.price.substring(1));
    });
    return '$' + total;
  }
</script>

<script type="text/javascript">
  var $table = $('#template_kuesioner'),
    $remove = $('#remove'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $table.bootstrapTable({

      url: "<?php echo site_url('vendor/vendor_tools/doc_vendor/data') ?>",
      cookieIdTable: "adm_vsi_template_kuesioner",
      idField: "avd_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'action',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '5%'
        },
        {
          field: 'avd_name',
          title: 'Nama Template',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          width: '40%',
        },
        {
          field: 'vtm_name',
          title: 'Tipe Vendor',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          width: '10%',
        },
        {
          field: 'status',
          title: 'Status',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          width: '5%',
        },
        {
          field: 'created_date',
          title: 'Created date',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          width: '13%',
        },
        {
          field: 'updated_date',
          title: 'Update date',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          width: '13%',
        },
        // {
        //   field: 'checkbox',
        //   checkbox:true,
        //   align: 'center',
        //   valign: 'middle',
        // },
      ]

    });
    setTimeout(function() {
      $table.bootstrapTable('resetView');
    }, 200);

    $table.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_position"));
    });

    $table.on('check.bs.table  check-all.bs.table', function() {
      // $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

      // selections = getIdSelections();
      // var param = "";
      // $.each(selections,function(i,val){
      //   param += val+"=1&";
      // });
      // $.ajax({
      //   url:"<?php echo site_url('Administration/selection/selection_template_kuesioner') ?>",
      //   data:param,
      //   type:"get"
      // });

      //set session atk_id
      $.ajax({
        url: "<?php echo site_url('administration/set_session/atk_id') ?>" + '/' + getIdSelections(),
        type: "get"
      });

    });
    $table.on('uncheck.bs.table uncheck-all.bs.table', function() {
      $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

      selections = getIdSelections();

      var param = "";
      $.each(selections, function(i, val) {
        param += val + "=0&";
      });
      $.ajax({
        url: "<?php echo site_url('Administration/selection/selection_template_kuesioner') ?>",
        data: param,
        type: "get"
      });
    });
    $table.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row));

    });
    $table.on('all.bs.table', function(e, name, args) {
      //console.log(name, args);
    });
    $remove.click(function() {
      var ids = getIdSelections();
      $table.bootstrapTable('remove', {
        field: 'id',
        values: ids
      });
      $remove.prop('disabled', true);
    });

    function getIdSelections() {
      return $.map($table.bootstrapTable('getSelections'), function(row) {
        return row.atk_id
      });
    }

    function responseHandler(res) {
      $.each(res.rows, function(i, row) {
        row.state = $.inArray(row.atk_id, selections) !== -1;
      });
      return res;
    }


  });
</script>