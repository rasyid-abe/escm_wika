<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Blacklist Vendor</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">             
            <table id="blacklist_vendor" class="table table-bordered table-striped"></table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  $(function () {

    $blacklist_vendor.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_daftar_pekerjaan_blacklist_vendor') ?>",

      cookieIdTable:"vw_daftar_pekerjaan_blacklist_vendor",

      idField:"vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      {
        field: 'vendor_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatterBlacklist,
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
  $blacklist_vendor.bootstrapTable('resetView');
}, 200);

$blacklist_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_blacklist_vendor"));
});

});

</script>