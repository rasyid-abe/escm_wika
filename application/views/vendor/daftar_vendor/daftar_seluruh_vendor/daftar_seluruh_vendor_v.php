<style>
  .bootstrap-table {
    margin-top: 0px;
  }
</style>

<div style="display: none;" class="alert alert-notif mt-2" role="alert">
  <span id="alert-text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="row">
  <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
          <div class="card-content">
              <div class="card-body">
                  <div class="media">
                      <div class="media-body text-left">
                          <h3 class="mb-1 danger"><?php echo number_format($totalVndActive);?></h3>
                          <span>Total Active</span>
                      </div>
                      <div class="media-right align-self-center">
                          <i class="ft-briefcase danger font-large-2 float-right"></i>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
          <div class="card-content">
              <div class="card-body">
                  <div class="media">
                      <div class="media-body text-left">
                          <h3 class="mb-1 success"><?php echo number_format($totalVndSuspend);?></h3>
                          <span>Total Suspend</span>
                      </div>
                      <div class="media-right align-self-center">
                          <i class="ft-user success font-large-2 float-right"></i>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
          <div class="card-content">
              <div class="card-body">
                  <div class="media">
                      <div class="media-body text-left">
                          <h3 class="mb-1 warning"><?php echo number_format($totalVndWarning);?></h3>
                          <span>Total Warning</span>
                      </div>
                      <div class="media-right align-self-center">
                          <i class="ft-pie-chart warning font-large-2 float-right"></i>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
          <div class="card-content">
              <div class="card-body">
                  <div class="media">
                      <div class="media-body text-left">
                          <h3 class="mb-1 primary"><?php echo number_format($totalVndBlacklist);?></h3>
                          <span>Total Blacklist</span>
                      </div>
                      <div class="media-right align-self-center">
                          <i class="ft-life-buoy primary font-large-2 float-right"></i>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-bottom pb-2">
        <h4 class="float-left">Daftar Seluruh Vendor</h4>  
        <?php if (isset($sync_btn) AND $sync_btn) { ?>
          <a class="float-right" href="<?php echo site_url('vendor/daftar_vendor/sinkron_vendor') ?>" onclick="return confirm('Syncron akan membutuhkan waktu cukup lama, apakah Anda yakin?');">
              <button class="btn btn-danger btn-sm">Sinkron Semua Vendor <i class="fa fa-retweet"></i></button>
          </a>      
        <?php } ?> 
      </div>

      <div class="card-content">
        <div class="card-body">
          <?php if (isset($sync_btn) AND $sync_btn) { ?>
            <form method="post" action="<?php echo site_url('vendor/daftar_vendor/sinkron_vendor') ?>">
              <div class="input-group">
                  <input type="number" min="0" max="9999999" class="form-control col-1" name="vendor_id_sync" placeholder="Vendor ID" required>
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-primary btn-sm">Sinkron Vendor <i class="fa fa-retweet"></i></button>
                  </div>
              </div>
            </form>
          <?php } ?>

          <div class="table-responsive">

            <table id="daftar_seluruh_vendor" class="table table-bordered table-striped"></table>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

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

    var mydata = $.getCustomJSON("<?php echo site_url('Vendor') ?>/"+url);

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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('vendor/daftar_vendor') ?>";
    var link_vendor = "<?php echo site_url('vendor/sinkron_vendor') ?>";
    var link_nasabah = "<?php echo site_url('vendor/sinkron_nasabah') ?>";
    return [
      '<div class="btn-group">',
      '<a target="_blank" class="btn btn-info btn-sm action" href="'+link+'/lihat_detail_vendor/'+value+'">',
      '<i class="ft-eye mr-1"></i>Lihat',
      '</a>  ',
      '<a class="btn btn-primary btn-sm action" href="'+link_vendor+'/'+value+'">',
      '<i class="ft-refresh-cw mr-1"></i>Sync',
      '</a>  ',
      '<a class="btn btn-warning btn-sm action" href="'+link_nasabah+'/'+value+'">',
      '<i class="ft-refresh-cw mr-1"></i>Nasabah',
      '</a>  </div>'
    ].join('');
  }
  
  window.operateEvents = {
      'click .approval': function (e, value, row, index) {},
  };

  function totalTextFormatter(data) {
    return 'Total';
  }
  function totalNameFormatter(data) {
    return data.length;
  }
  function totalPriceFormatter(data) {
    var total = 0;
    $.each(data, function (i, row) {
      total += +(row.price.substring(1));
    });
    return '$' + total;
  }

</script>

<script type="text/javascript">

  var $daftar_seluruh_vendor = $('#daftar_seluruh_vendor'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $daftar_seluruh_vendor.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_daftar_seluruh_vendor') ?>",

      cookieIdTable:"vnd_header",

      idField:"vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      {
        field: 'vendor_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        valign: 'middle',
        width: '15%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'vendor_id',
        title: 'ID Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
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
        field: 'nasabah_code',
        title: 'Kode Nasabah',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'code_bp',
        title: 'Kode BP',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'alamat',
        title: 'Alamat',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'email_address',
        title: 'Email',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vnd_jenis',
        title: 'Jenis Kualifikasi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vendor_type_name',
        title: 'Type',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'reg_status_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }
      ]

    });

    setTimeout(function () {
      $daftar_seluruh_vendor.bootstrapTable('resetView');
    }, 200);

    $daftar_seluruh_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_daftar_seluruh_vendor"));
    });

    $daftar_seluruh_vendor.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('Vendor/selection/selection_vendor') ?>",
        data:param,
        type:"get"
      });

    });

    $daftar_seluruh_vendor.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('Vendor/selection/selection_vendor') ?>",
        data:param,
        type:"get"
      });
    });

    $daftar_seluruh_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });
    $daftar_seluruh_vendor.on('all.bs.table', function (e, name, args) {
      
    });
  });

  function getIdSelections() {
    return $.map($daftar_seluruh_vendor.bootstrapTable('getSelections'), function (row) {
      return row.vendor_id
    });
  }

  function responseHandler(res) {
    $.each(res.rows, function (i, row) {
      row.state = $.inArray(row.vendor_id, selections) !== -1;
    });
    return res;
  }

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

  var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }
      }
  };

  if(getUrlParameter('status') != typeof undefined){

    if (getUrlParameter('status') == 'success') {

      $('.alert-notif').addClass('bg-light-info').css('display','block')
      $('#alert-text').html(getUrlParameter('msg'))

    }else if(getUrlParameter('status') == 'fail'){

        $('.alert-notif').addClass('bg-light-warning').css('display','block')
        $('#alert-text').html(getUrlParameter('msg'))

    }else if(getUrlParameter('status') == 'not_found'){

        $('.alert-notif').addClass('bg-light-danger').css('display','block')
        $('#alert-text').html(getUrlParameter('msg'))

    }else if(getUrlParameter('status') == 'error_ws'){

        $('.alert-notif').addClass('bg-light-danger').css('display','block')
        $('#alert-text').html(getUrlParameter('msg'))
    }

    //clean param url
    var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        var clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }
  }

</script>
