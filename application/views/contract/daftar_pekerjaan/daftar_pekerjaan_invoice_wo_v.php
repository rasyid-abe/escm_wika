<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Daftar Pekerjaan Invoice WO</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">

            <table id="table_invoice_wo" class="table table-bordered table-striped"></table>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  function wo_act_invoice(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_invoice_wo/'+value+'">',
    'Proses',
    '</a>  ',
    ].join('');
  }

  var $table_invoice_wo = $('#table_invoice_wo');
  var selections = [];

  $(function () {

    $table_invoice_wo.bootstrapTable({

      url: "<?php echo site_url('contract/data_invoice_wo') ?>",
      cookieIdTable:"daftar_invoice_wo",
      idField:"po_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "po_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: wo_act_invoice,
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
        field: 'invoice_number',
        title: 'No. Invoice',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },

       {
        field: 'created_date',
        title: 'Tanggal Dibuat',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
       {
        field: 'invoice_date',
        title: 'Tanggal Tagihan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      
      {
        field: 'invoice_notes',
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
      $table_invoice_wo.bootstrapTable('resetView');
    }, 200);

  });

</script>