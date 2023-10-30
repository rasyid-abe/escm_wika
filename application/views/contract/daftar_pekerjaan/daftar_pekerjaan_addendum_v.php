<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Daftar Pekerjaan Adendum</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">

            <table id="table_pekerjaan_adendum" class="table table-bordered table-striped"></table>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

 function addendum_act(value, row, index) {
  var link = "<?php echo site_url('addendum/daftar_pekerjaan') ?>";
  return [
  '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_addendum/'+value+'">',
  'Proses',
  '</a>  ',
  ].join('');
}

var $table_pekerjaan_adendum = $('#table_pekerjaan_adendum');
var selections = [];

$(function () {

  $table_pekerjaan_adendum.bootstrapTable({

    url: "<?php echo site_url('contract/data_pekerjaan_adendum') ?>",
    cookieIdTable:"daftar_pekerjaan_adendum",
    idField:"cac_id",
    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
    columns: [
    {
      field: 'cac_id',
      title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
      align: 'center',
      width:'8%',
      valign: 'middle',
      formatter: addendum_act,
    },
    {
      field: 'contract_number',
      title: 'No. Kontrak',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle',
      width:'14%',
    },
    {
      field: 'subject_work',
      title: 'Deskripsi Pekerjaan',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    }, {
      field: 'vendor_name',
      title: 'Vendor',
      sortable:true,
      order:true,
      searchable:true,
      align: 'left',
      valign: 'middle',
      width:'30%',
    },
    {
      field: 'activity',
      title: 'Status',
      sortable:true,
      order:true,
      searchable:true,
      align: 'left',
      valign: 'middle',
      width:'20%',
    },

    ]

  });
  setTimeout(function () {
    $table_pekerjaan_adendum.bootstrapTable('resetView');
  }, 200);

  $table_pekerjaan_adendum.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias_adendum"));
  });

});

</script>