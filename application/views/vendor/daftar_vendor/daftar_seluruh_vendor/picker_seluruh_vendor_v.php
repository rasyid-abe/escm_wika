<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Daftar Seluruh Vendor</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="card-content">

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
    return [
    '<a target="_blank" class="btn btn-primary btn-xs action" href="'+link+'/lihat_detail_vendor/'+value+'">',
    'Lihat',
    '</a>  ',
    '<a class="btn btn-primary btn-xs action" href="'+link_vendor+'/'+value+'">',
    'Sync',
    '</a>  '
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
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
        title: '#',
        field: 'radio',
        radio:true,
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
        field: 'reg_status_name',
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
  $daftar_seluruh_vendor.bootstrapTable('resetView');
}, 200);

$daftar_seluruh_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_daftar_seluruh_vendor"));
});

$daftar_seluruh_vendor.on('check.bs.table  check-all.bs.table', function () {
// $remove.prop('disabled', !$daftar_seluruh_vendor.bootstrapTable('getSelections').length);

selections = getIdSelections();
var param = "";
$.each(selections,function(i,val){
  param += val+"=1&";
});
// $.ajax({
//   url:"<?php echo site_url('Vendor/selection/selection_vendor') ?>",
//   data:param,
//   type:"get"
// });
$.ajax({
    url:"<?php echo site_url('Vendor/picker') ?>",
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
  // $.ajax({
  //   url:"<?php echo site_url('Vendor/selection/selection_vendor') ?>",
  //   data:param,
  //   type:"get"
  // });
  $.ajax({
    url:"<?php echo site_url('Vendor/picker') ?>",
    data:param,
    type:"get"
  });
});

$daftar_seluruh_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row));

});
$daftar_seluruh_vendor.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
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


</script>