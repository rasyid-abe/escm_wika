<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Monitor SI Matgis</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">
            <table id="table_monitor_wo" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>


    </div>
  </div>
</div>

<script type="text/javascript">

  function wo_act(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/lihat_wo_matgis/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

  var $table_pekerjaan_wo = $('#table_monitor_wo');
  var selections = [];

  $(function () {

    $table_pekerjaan_wo.bootstrapTable({

      url: "<?php echo site_url('contract_matgis/data_monitor_si') ?>",
      cookieIdTable:"daftar_pekerjaan_wo",
      idField:"cwo_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "cwo_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: wo_act,
      },
      {
        field: 'wo_number',
        title: 'Nomor WO',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'contract_number',
        title: 'Nomor Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },

      {
        field: 'wo_notes',
        title: 'Deskripsi Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'contract_type',
        title: 'Tipe',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'awa_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'cwo_start_date',
        title: 'Waktu',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      ]

    });
    setTimeout(function () {
      $table_pekerjaan_wo.bootstrapTable('resetView');
    }, 200);

    $table_pekerjaan_wo.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_wo"));
    });

  });

</script>
