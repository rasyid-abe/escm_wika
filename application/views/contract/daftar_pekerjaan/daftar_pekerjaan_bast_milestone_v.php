<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Daftar Pekerjaan BAST Milestone</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">

            <table id="table_bast_milestone" class="table table-bordered table-striped"></table>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  function milestone_act_bast(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_bast_milestone/'+value+'">',
    'Proses',
    '</a>  ',
    ].join('');
  }

  var $table_bast_milestone = $('#table_bast_milestone');
  var selections = [];

  $(function () {

    $table_bast_milestone.bootstrapTable({

      url: "<?php echo site_url('contract/data_bast_milestone') ?>",
      cookieIdTable:"daftar_bast_milestone",
      idField:"milestone_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "milestone_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: milestone_act_bast,
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
        field: 'description',
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
        field: 'percentage',
        title: 'Persentase',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle',

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
      $table_bast_milestone.bootstrapTable('resetView');
    }, 200);

  });

</script>