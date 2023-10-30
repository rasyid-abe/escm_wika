<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Verifikasi Dokumen PQ</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">             
            <table id="verifikasi_doc_pq" class="table table-bordered table-striped"></table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  $(function () {
    let $verifikasi_doc_pq = $('#verifikasi_doc_pq')
    $verifikasi_doc_pq.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_verifikasi_doc_pq/') ?>",
     
      cookieIdTable:"vw_daftar_pekerjaan_vendor_aktivasi",
      
      idField:"vendor_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
      {
        field: 'vdp_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'15%',
        events: operateEvents,
        formatter: operateFormatterVerifikasiDocPQ,
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
        field: 'vdp_status_name',
        title: 'Status Verifikasi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'status_vendor',
        title: 'Status Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $verifikasi_doc_pq.bootstrapTable('resetView');
}, 200);

$verifikasi_doc_pq.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_daftar_pekerjaan_vendor_aktivasi"));
});

});

</script>