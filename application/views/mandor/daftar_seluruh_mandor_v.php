<div class="wrapper wrapper-content animated fadeInRight">

  <div style="display: none;" class="alert alert-notif" role="alert">
    <span id="alert-text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Daftar Seluruh Mandor</h5>
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
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a target="_blank" class="btn btn-primary btn-xs action" href="'+link+'/lihat_detail_mandor/'+value+'">',
    'Lihat',
    '</a>  '
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $daftar_seluruh_vendor.bootstrapTable('remove', {
      field: 'id',
      values: [row.id]
    });
  }
  */
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

      url: "<?php echo site_url('Vendor/data_daftar_seluruh_mandor') ?>",
      
      cookieIdTable:"vnd_header",
      
      idField:"vendor_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
      {
        field: 'vmh_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        valign: 'middle',
        width: '10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'vmh_npwp',
        title: 'No NPWP',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vmh_name',
        title: 'Nama Mandor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vmh_bank_no_account',
        title: 'Kode Nasabah',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vmh_address',
        title: 'Alamat',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vmh_email',
        title: 'Email',
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
$.ajax({
  url:"<?php echo site_url('Vendor/selection/selection_vendor') ?>",
  data:param,
  type:"get"
});

});

$daftar_seluruh_vendor.on('uncheck.bs.table uncheck-all.bs.table', function () {
  // $remove.prop('disabled', !$daftar_seluruh_vendor.bootstrapTable('getSelections').length);

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
  //console.log(name, args);
});
// $remove.click(function () {
//   var ids = getIdSelections();
//   $daftar_seluruh_vendor.bootstrapTable('remove', {
//     field: 'id',
//     values: ids
//   });
//   $remove.prop('disabled', true);
// });

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

        $('.alert-notif').addClass('alert-info').css('display','block')
        $('#alert-text').html(getUrlParameter('msg'))

      }else if(getUrlParameter('status') == 'fail'){

         $('.alert-notif').addClass('alert-warning').css('display','block')
         $('#alert-text').html(getUrlParameter('msg'))

      }else if(getUrlParameter('status') == 'error_ws'){

         $('.alert-notif').addClass('alert-danger').css('display','block')
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