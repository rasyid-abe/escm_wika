<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.js"></script>
<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Detail Vendor</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table id="riwayat_eauction" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="text-center" data-field='peringkat' data-sort-order="asc" data-order='asc' data-sortable="true" data-sort-order="asc">No</th>
                      <th class="text-center" data-field='nama_vendor'>Nama Vendor</th>
                      <th class="text-center" data-field='penawaran_saat_ini'>Penawaran</th>
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script type="text/javascript">
function makeid(length) {
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }


  $(function () {
    var table_peringkat_penawar = $('#riwayat_eauction')
    Pusher.logToConsole = true;

    var pusher = new Pusher('<?php $this->load->config("pusher"); echo $this->config->item('PUSHER_key');?>', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      table_peringkat_penawar.bootstrapTable('refresh', {
        useCurrentPage: false,
        includeHiddenRows: true,
        unfiltered: true
      });
      //table_peringkat_penawar.bootstrapTable('append', JSON.parse(data['message']))
    });



});
</script>

<script type="text/javascript">
  jQuery.extend({
    getCustomJSON: function(url) {
      var result = null;
      $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(data) {
          result = data;
        }
      });
      return result;
    }
  });

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('Procurement') ?>/"+url);

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

  var $riwayat_eauction = $('#riwayat_eauction'),
  selections = [];

  function operateFormatter2(value, row, index) { 
      var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
      return [
      '<a class="btn btn-info btn-xs action" target="_blank" href="'+link+'/eacution_detail/?id='+value+'">',
      'Lihat',
      '</a>',
    ].join('');
  }


  $(function () {
    var urls = "<?php echo site_url('Procurement/data_vendor_eacution_history') ?>?id=<?php echo $_GET['id']?>";
    console.log(urls);
    $riwayat_eauction.bootstrapTable({
      url: urls,
      idField:"vendor_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        
        field: 'number',
        title: 'No',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        order: 'asc'
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        //sortable:true,
        order:false,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'tgl_bid',
        title: 'Tanggal',
       // sortable:true,
        //order:false,
        searchable:false,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'jumlah_bid',
        title: 'Penawaran',
        //sortable:true,
        //order:false,
        searchable:false,
        align: 'center',
        valign: 'middle'
      },
      ]
    });

    
    setTimeout(function () {
      $riwayat_eauction.bootstrapTable('resetView');
    }, 200);
  
    $riwayat_eauction.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

  });
</script>