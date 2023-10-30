<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title float-left">Daftar Kantor</h4>
          <a class="btn btn-info float-right" href="<?php echo site_url('administration/master_data/daftar_kantor/add_daftar_kantor') ?>" role="button">Tambah</a>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="daftar_kantor" class="table table-bordered table-striped"></table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('administration/master_data/daftar_kantor') ?>";
    return [
      '<div class = "btn-group"><a class="btn btn-sm btn-info ft ft-edit btn-xs action" href="' + link + '/ubah/' + value + '">',
      'Ubah',
      '</a>  ',
      '<a class="btn btn-sm btn-danger ft ft-trash btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus/' + value + '">',
      'Hapus',
      '</a> </div> ',
    ].join('');
  }
</script>

<script type="text/javascript">
  var $daftar_kantor = $('#daftar_kantor'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $daftar_kantor.bootstrapTable({

      url: "<?php echo site_url('administration/data_daftar_kantor') ?>",
      cookieIdTable: "adm_district",
      idField: "district_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'district_id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '10%',
          formatter: operateFormatter,
        },
        {
          field: 'district_code',
          title: 'Kode Kantor',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'district_prefix',
          title: 'Singkatan Kantor',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'district_name',
          title: 'Nama Kantor',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
      ]

    });
    setTimeout(function() {
      $daftar_kantor.bootstrapTable('resetView');
    }, 200);

  });
</script>