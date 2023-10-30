<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Histori Penawaran Vendor</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="card-content">
                <table id="penawaran_table" class="table table-bordered table-striped"></table>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  var $penawaran_table = $('#penawaran_table'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $penawaran_table.bootstrapTable({

      url: "<?php echo site_url('procurement/data_penawaran') ?>",
      cookieIdTable:"sanggahan",
      idField:"pbm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      sortOrder:"desc",
      sortName:"pqm_created_date_format",
      columns: [
      {
        field: 'pqm_created_date_format',
        title: 'Tanggal / Jam',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
{
        field: 'pqm_number',
        title: 'No. Penawaran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
           {
        field: 'pqm_currency',
        title: 'Mata Uang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },  
      {
        field: 'total_ppn',
        title: 'Total',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },

      ]

    });

setTimeout(function () {
  $penawaran_table.bootstrapTable('resetView');
}, 200);

});

</script>