<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Suspend Vendor</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">             
            <table id="daftar_pekerjaan_vendor" class="table table-bordered table-striped"></table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  $(function () {

    $daftar_pekerjaan_vendor.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_daftar_pekerjaan_vendor') ?>",
     
      cookieIdTable:"vw_daftar_pekerjaan_vendor",
      
      idField:"vendor_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
      {
        field: 'vendor_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatterSuspend,
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'activity',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $daftar_pekerjaan_vendor.bootstrapTable('resetView');
}, 200);

$daftar_pekerjaan_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_daftar_pekerjaan_vendor"));
});

});

</script>
