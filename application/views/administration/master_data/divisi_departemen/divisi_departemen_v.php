<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <!-- <h4 class="card-title float-left">Divisi/Departemen</h4> -->
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="divisi_departemen" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?= site_url('administration/master_data/divisi_departemen/add_divisi_departemen') ?>" role="button">
                  <i class="ft-plus mr-1"></i>Tambah
                </a>
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
    var link = "<?php echo site_url('administration/master_data/divisi_departemen') ?>";
    return [
      '<div class = "btn-group"> <a class="btn btn-sm btn-info btn-xs action" href="' + link + '/ubah/' + value + '">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a>  ',
      '<a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menonaktifkan data?\')" href="' + link + '/nonaktif/' + value + '">',
      '<i class="ft-power mr-1"></i>Nonaktif',
      '</a> </div> ',
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
  var $divisi_departemen = $('#divisi_departemen'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $divisi_departemen.bootstrapTable({

      url: "<?php echo site_url('administration/data_divisi_departemen') ?>",
      cookieIdTable: "adm_dept",
      idField: "dept_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'dept_id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '15%',
          formatter: operateFormatter,
        },
        {
          field: 'dep_code',
          title: 'Kode',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '10%',
        },
        {
          field: 'dept_name',
          title: 'Nama',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'district_name',
          title: 'Kantor',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'dept_type_name',
          title: 'Tipe',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'dept_active',
          title: 'Status',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
      ]

    });
    setTimeout(function() {
      $divisi_departemen.bootstrapTable('resetView');
    }, 200);

    $divisi_departemen.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_divisi_departemen"));
    });

  });
</script>
