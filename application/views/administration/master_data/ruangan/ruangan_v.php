<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title float-left">Ruangan</h4>
          <a class="btn btn-info float-right" href="<?php echo site_url('administration/master_data/ruangan/tambah') ?>" role="button">Tambah</a>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="ruangan" class="table table-bordered table-striped"></table>
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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('administration/master_data/ruangan') ?>";
    return [
      '<div class = "btn-group"><div class = "btn-group"><a class="btn btn-sm btn-info ft ft-edit btn-xs action" href="' + link + '/ubah/' + value + '">',
      'Ubah',
      '</a>  ',
      '<a class="btn btn-sm btn-danger ft ft-trash btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus/' + value + '">',
      'Hapus',
      '</a> </div>',
    ].join('');
  }
</script>

<script type="text/javascript">
  var $ruangan = $('#ruangan'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $ruangan.bootstrapTable({

      url: "<?php echo site_url('administration/data_ruangan') ?>",
      cookieIdTable: "ruangan",
      idField: "id_room",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id_room',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '15%',
          formatter: operateFormatter,
        },
        {
          field: 'name_room',
          title: 'Nama',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'desc_room',
          title: 'Keterangan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
      ]
    });
    setTimeout(function() {
      $ruangan.bootstrapTable('resetView');
    }, 200);


  });
</script>