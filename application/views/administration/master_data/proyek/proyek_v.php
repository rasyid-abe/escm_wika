<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <!-- <h4 class="card-title float-left">Nama Proyek</h4> -->
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="proyek" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?php echo site_url('administration/master_data/proyek/tambah') ?>" role="button">
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

  function operateFormatter(value, row, index) {
    var link = "<?= site_url('administration/master_data/proyek') ?>";
    return [
      '<div class="btn-group"><a class="btn btn-sm btn-info btn-xs action" href="' + link + '/ubah/' + value + '">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a>  ',
      '<a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus/' + value + '">',
      '<i class="ft-trash mr-1"></i>Hapus',
      '</a> </div>',
    ].join('');
  }
</script>

<script type="text/javascript">
  var $proyek = $('#proyek'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $proyek.bootstrapTable({

      url: "<?php echo site_url('administration/data_proyek') ?>",
      cookieIdTable: "proyek",
      idField: "id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '15%',
          formatter: operateFormatter,
        },
        {
          field: 'project_name',
          title: 'Nama Proyek',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'description',
          title: 'Deskripsi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'date_start',
          title: 'Tanggal Mulai',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'date_end',
          title: 'Tanggal Akhir',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'status',
          title: 'Status',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle'
        },
      ]
    });
    setTimeout(function() {
      $proyek.bootstrapTable('resetView');
    }, 200);


  });
</script>
