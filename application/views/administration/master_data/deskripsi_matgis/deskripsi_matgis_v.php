<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <!-- <h4 class="card-title float-left">Data Deskripsi Matgis</h4> -->
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="deskripsi_matgis" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?php echo site_url('administration/master_data/deskripsi_matgis/tambah') ?>" role="button"><i class="ft-plus mr-1"></i>Tambah</a>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('administration/master_data/deskripsi_matgis') ?>";
    return [
      '<a class="btn btn-sm btn-info btn-xs action" href="' + link + '/ubah/' + value + '">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a>  '
    ].join('');
  }
</script>

<script type="text/javascript">
  var $deskripsi_matgis = $('#deskripsi_matgis'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $deskripsi_matgis.bootstrapTable({

      url: "<?php echo site_url('administration/data_deskripsi_matgis') ?>",
      cookieIdTable: "adm_lane",
      idField: "lane_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '10%',
          formatter: operateFormatter
        },
        {
          field: 'label',
          title: 'Label',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
        },
        {
          field: 'desc',
          title: 'Deskripsi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
        },
        {
          field: 'status',
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
      $deskripsi_matgis.bootstrapTable('resetView');
    }, 200);


  });
</script>
