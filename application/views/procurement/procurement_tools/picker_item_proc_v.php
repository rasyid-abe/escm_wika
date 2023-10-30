<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Item Pengadaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">
            <table id="daftar_item_pengadaan" class="table table-bordered table-striped"></table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('inventory') ?>/"+url);

    var html = [];
    $.each(row, function (key, value) {
     var data = $.grep(mydata, function(e){ 
       return e.field == key; 
     });

     if(typeof data[0] !== 'undefined'){

       html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
     }
   });

    return html.join('');

  }

</script>

<script type="text/javascript">

  var $daftar_item_pengadaan = $('#daftar_item_pengadaan'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $daftar_item_pengadaan.bootstrapTable({

      url: "<?php echo site_url('procurement/data_item_proc') ?>",
      cookieIdTable:"daftar_item_pengadaan",
      
      idField:"id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'kode',
        title: 'Kode',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
      },
      {
        field: 'deskripsi',
        title: 'Nama',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
      },

      {
        field: 'jumlah',
        title: 'Jumlah',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
      },
      {
        field: 'satuan',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
      },
      {
        field: 'harga_satuan',
        title: 'Harga',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle',
      },
      {
        field: 'keterangan',
        title: 'Keterangan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
      },
      ]
    });
    setTimeout(function () {
      $daftar_item_pengadaan.bootstrapTable('resetView');
    }, 200);

    $daftar_item_pengadaan.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";

      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('inventory/picker') ?>",
        data:param,
        type:"get"
      });

    });
    $daftar_item_pengadaan.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";

      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('inventory/picker') ?>",
        data:param,
        type:"get"
      });

    });

  });
  function getIdSelections() {
    return $.map($daftar_item_pengadaan.bootstrapTable('getSelections'), function (row) {
      return row.id;
    });
  }

</script>