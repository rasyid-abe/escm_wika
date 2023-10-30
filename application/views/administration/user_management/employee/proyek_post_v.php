<div class="wrapper wrapper-content">  
    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins p-3">
          <div class="card-title">
            <h5>Proyek</h5>
          </div>

          <div class="card-content">
            <div class="table-responsive">
              <a class="btn btn-primary" href="<?php echo site_url('administration/user_management/employee/add_proyek_post/' . $id) ?>" role="button">Tambah</a>
              <table id="proyek_post" class="table table-bordered table-striped"></table>
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
    var link = "<?php echo site_url('administration/user_management/employee') ?>";
    return [
      '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus_proyek_post/' + value + '">',
      'Hapus',
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
    $.each(data, function(i, row) {
      total += +(row.price.substring(1));
    });
    return '$' + total;
  }
</script>

<script type="text/javascript">
  var $proyek_post = $('#proyek_post'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $proyek_post.bootstrapTable({

      url: "<?php echo site_url('administration/data_proyek_post/' . $id) ?>",
      cookieIdTable: "adm_employee_proyek",
      idField: "id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          formatter: operateFormatter2,
        },
        {
          field: 'ppm_project_id',
          title: 'Project ID',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'ppm_project_name',
          title: 'Project Name',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'ppm_dept_id',
          title: 'Dept ID',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'ppm_dept_name',
          title: 'Dept Name',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        }
      ]

    });
    setTimeout(function() {
      $proyek_post.bootstrapTable('resetView');
    }, 200);

    $proyek_post.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_employee"));
    });

  });
</script>