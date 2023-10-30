<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.js"></script>
<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">E-Auction Vendor</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-2">Session </div> :
            <div class="col-sm-4 status_session"></div>
          </div>
          <div class="row">
            <div class="col-sm-2">Sisa Waktu </div> :
            <div class="col-sm-4 sisa_waktu">Aktif</div>
          </div>
          <div class="row">
            <div class="col-sm-2">Tanggal berakhir</div> :
            <div class="col-sm-4">
                <input type="datetime-local" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control  tanggal_berakhir" value="">
            </div>
          </div>

            <div class="table-responsive">
                <table id="riwayat_eauction" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="text-center" data-field='online'>Online</th>
                      <th class="text-center" data-field='peringkat' data-sort-order="asc" data-order='asc' data-sortable="true" data-sort-order="asc">Peringkat</th>
                      <th class="text-center" data-field='nama_vendor'>Nama Vendor</th>
                      <th class="text-center" data-field='penawaran_saat_ini'>Penawaran Saat Ini</th>
                      <th class="text-center" data-field='penawaran_sebelumnya'>Penawaran Sebelumnya</th>
                      <th class="text-center" data-field='riwayat'>Riwayat</th>
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
  var ppm_id = "";

  $( document ).ready(function() {
    <?php
    $hist_auction = count($hist_eauction_header) == 0 ? array() : $hist_eauction_header;
    $ppmId = count($hist_eauction_header) == 0 ? array() : $hist_eauction_header[0]['ppm_id'];
    $tanggal_berakhir = count($hist_eauction_header) == 0 ? array() : $hist_eauction_header[0]['tanggal_berakhir'];

    $eauction_header = json_encode($hist_eauction_header);
    $date_end = json_encode($tanggal_berakhir);
    $date_end = str_replace('"', '', $date_end);
    ?>

    var tanggal_berakhir = "<?php echo $date_end; ?>" == "[]" ? $('.tanggal_berakhir').val() : '<?php echo $date_end; ?>';
    var date_penutup = moment(tanggal_berakhir).format('YYYY-MM-DDThh:mm:ss');
    console.log(tanggal_berakhir);
    

    ppm_id = "<?php echo $permintaan['ptm_number'] ?>"; //"<?php echo str_replace('"', '', json_encode($ppmId) ) ?>";

    $("#tanggal_berakhir").val(date_penutup);

    if(tanggal_berakhir != "")
    {
      setInterval( function() {
      var t = getTimeRemaining(tanggal_berakhir);
      var time_exp = '' + t.days + 'Hari ' +
        ''+ t.hours + 'Jam ' +
        '' + t.minutes + 'Menit ' +
        '' + t.seconds+ 'Detik ';

      $(".sisa_waktu").text(time_exp);
      if(parseInt(t.total) <= 0){
        $(".status_session").text("Tidak Aktif");
      } else {
        $(".status_session").text("Aktif");
      }
    },1000);

    } else {
      $(".sisa_waktu").text("-");
      $(".status_session").text("Tidak Aktif");

    }
    
  });

  $('.tanggal_berakhir').on('change', function(e){
    var get_date_aja = e.target.value;
    var settings = {
      "async": true,
      "crossDomain": true,
      "url": "<?php echo site_url('Procurement') ?>/submit_ubah_jadwal_akhir",
      "method": "POST",
      "headers": {
        "content-type": "application/x-www-form-urlencoded",
        "accept": "application/json",
        "cache-control": "no-cache",
      },
      "data": {
        "ppm_id": ppm_id,
        "new_date": get_date_aja
      }
    }

    $.ajax(settings).done(function (response) {
      //window.location.reload();
        setInterval( function() {
        var tanggal_berakhir = $('.tanggal_berakhir').val(); //'<?php echo $date_end; ?>';
        var t = getTimeRemaining(tanggal_berakhir);
        var time_exp = '' + t.days + 'Hari ' +
          ''+ t.hours + 'Jam ' +
          '' + t.minutes + 'Menit ' +
          '' + t.seconds+ 'Detik ';

        $(".sisa_waktu").text(time_exp);
        if(parseInt(t.total) <= 0){
          $(".status_session").text("Tidak Aktif");
        } else {
          $(".status_session").text("Aktif");
        }
      },1000);
    });
  });

  function getTimeRemaining(endtime){
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor( (t/1000) % 60 );
    var minutes = Math.floor( (t/1000/60) % 60 );
    var hours = Math.floor( (t/(1000*60*60)) % 24 );
    var days = Math.floor( t/(1000*60*60*24) );
    return {
      'total': t,
      'days': days,
      'hours': hours,
      'minutes': minutes,
      'seconds': seconds
    };
  }


  var $riwayat_eauction = $('#riwayat_eauction'),
  selections = [];

  function operateFormatter2(value, row, index) {
      var link = "<?php echo site_url('Procurement/vendor_eacution_history') ?>";
      return [
      '<a class="btn btn-info btn-xs action" target="_blank" href="'+link+'/eacution_detail/?id='+value+'">',
      'Lihat',
      '</a>',
    ].join('');
  }

  $(function () {
    var urls = "<?php echo site_url('Procurement/data_vendor_eauction') ?>";
    $riwayat_eauction.bootstrapTable({
      url: urls,
      idField:"vendor_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
        {
          
          field: 'rank',
          title: 'Peringkat',
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
          title: 'Penawaran Saat Ini',
          //sortable:true,
          //order:false,
          searchable:false,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'bid_before',
          title: 'Penawaran Sebelumnya',
          //sortable:false,
          //order:false,
          searchable:false,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'vendor_id',
          title: 'Riwayat',
          align: 'center',
          width: '10%',
          valign:'middle',
          formatter: operateFormatter2,
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