<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Histori Negosiasi</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table id="negosiasi_table" class="table table-bordered table-striped"></table>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  var $negosiasi_table = $('#negosiasi_table'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $negosiasi_table.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_message/1140') ?>",
      cookieIdTable:"sanggahan",
      idField:"pbm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      sortOrder:"desc",
      sortName:"pbm_date_format",
      columns: [
      {
        field: 'pbm_date_format',
        title: 'Tanggal / Jam',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'from_msg',
        title: 'Dari',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },

      {
        field: 'to_msg',
        title: 'Ke',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
            
      {
        field: 'pbm_message',
        title: 'Komentar',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },

      ]

    });

setTimeout(function () {
  $negosiasi_table.bootstrapTable('resetView');
}, 200);

});

</script>