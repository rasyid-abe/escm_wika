<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <!-- <h4 class="card-title float-left">Delegasi Pekerjaan</h4> -->
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="kpi_proses" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?php echo site_url('administration/master_data/delegasi_tugas/add_delegasi_tugas') ?>" role="button"><i class="ft-plus mr-1"></i>Tambah</a>
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

  function operateFormattera(value, row, index) {
    var link = "<?php echo site_url('administration/master_data/delegasi_tugas') ?>";
    return [
      '<a class="btn btn-sm btn-info btn-xs action" href="' + link + '/ubah/' + value + '">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a>  ',
      /* '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="'+link+'/delete/'+value+'">',
       'Hapus',
       '</a>  ',*/
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
  var $satker = $('#kpi_proses'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $satker.bootstrapTable({

      url: "<?php echo site_url('administration/data_delegasi_tugas') ?>",
      cookieIdTable: "adm_delegasi",
      idField: "id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '15%',
          formatter: operateFormattera,
        },
        {
          field: 'start_date',
          title: 'Tanggal Mulai',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
        },
        {
          field: 'end_date',
          title: 'Tanggal Berakhir',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'from_name',
          title: 'Dari',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'to_name',
          title: 'Kepada',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'notes',
          title: 'Alasan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'label',
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
      $satker.bootstrapTable('resetView');
    }, 200);

    $satker.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_satker"));
    });

  });
</script>
