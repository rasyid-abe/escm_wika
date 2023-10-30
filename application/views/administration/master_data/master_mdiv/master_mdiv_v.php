<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <!-- <h4 class="card-title float-left">Master MDIV</h4> -->
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="master_mdiv" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?php echo site_url('administration/master_data/master_mdiv/add') ?>" role="button"><i class="ft-plus mr-1"></i>Tambah</a>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

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
    var link = "<?php echo site_url('administration/master_data/master_mdiv') ?>";
    return [
      '<div class="btn-group"><a class="btn btn-sm btn-info btn-xs action" href="' + link + '/edit/' + value + '">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a>  ',
      '<a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menonaktifkan data?\')" href="' + link + '/nonaktif/' + value + '">',
      '<i class="ft-power mr-1"></i>Nonaktif',
      '</a></div>',
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
  var $master_mdiv = $('#master_mdiv'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $master_mdiv.bootstrapTable({

      url: "<?php echo site_url('administration/master_data/master_mdiv/data') ?>",
      cookieIdTable: "adm_master_mdiv",
      idField: "amm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'amm_id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '15%',
          formatter: operateFormatter,
        },
        {
          field: 'region_name',
          title: 'Wilayah',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '20%',
        },
        {
          field: 'pos_name',
          title: 'Posisi Manajer',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '15%',
        },
        {
          field: 'dept_name',
          title: 'Divisi/Departemen',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '22%',
        },
        {
          field: 'created_datetime',
          title: 'Created Date',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '13%',
        },
        {
          field: 'updated_datetime',
          title: 'Updated Date',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '13%',
        },
        {
          field: 'active',
          title: 'Status',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '5%',
        },
      ]

    });
    setTimeout(function() {
      $master_mdiv.bootstrapTable('resetView');
    }, 200);

    $master_mdiv.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_master_mdiv"));
    });

  });
</script>
