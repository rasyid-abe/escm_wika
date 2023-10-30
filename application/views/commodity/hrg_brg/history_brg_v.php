<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>HISTORY KATALOG BARANG</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">
        <div class="table-responsive">
          <table id="table_history_catalog" class="table table-bordered table-striped"></table>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function barang_act(value, row, index) {
    var link = "<?php echo site_url('commodity/detail_history_barang/') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" target="_blank" href="'+link+'/'+value+'">',
    'Detail',
    '</a>  ',
    ].join('');
  }

  var $table_history_catalog = $('#table_history_catalog');
  var selections = [];

  $(function () {

    $table_history_catalog.bootstrapTable({

      url: "<?php echo site_url('commodity/data_history_barang/'.$i)?>",
      cookieIdTable:"daftar_history_catalog",
      idField:"cmh_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "cmh_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        valign: 'middle',
        formatter: barang_act,
        width: '5%'
      },
      {
        field: 'update_by_user',
        title: 'Sumber',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width: '13%'
      },
      {
        field: 'mat_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width: '12%'
      },
      {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '45%'
      },
      {
        field: 'currency',
        title: 'Mata Uang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '5%' 
      },
      {
        field: 'cost',
        title: 'Total Biaya',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width: '15%'
      },
      {
        field: 'updated_datetime',
        title: 'Tanggal',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width: '5%'
      },
      ]

    });
    setTimeout(function () {
      $table_history_catalog.bootstrapTable('resetView');
    }, 200);

    $table_history_catalog.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_barang"));
    });

  });

</script>