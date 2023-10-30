<style type="text/css">
  .img_zoom:hover {
  -ms-transform: scale(2.5); /* IE 9 */
  -webkit-transform: scale(2.5); /* Safari 3-8 */
  transform: scale(2.5); 
}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Harga Barang Sumberdaya Matgis</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">
      <br>  
            <div class="row">
              <div class="col-sm-3">
              <form class="form-horizontal" method="post" action="<?php echo site_url('commodity/daftar_harga/daftar_harga_barang_sumberdaya_matgis/add');?>">
                <div class="input-group margin pull-left">
                  <input type="text" class="form-control" name="jumlah">
                  <span class="input-group-btn">
                  <button type="submit" name="action" class="btn btn-info btn-flat" value="add" >Tambah</button>
                  </span>
                </div>
                </form>
              </div>
              <div class="col-sm-9">
                <div class="btn-group pull-right">

                  <a href="<?php echo site_url('commodity/daftar_harga/daftar_harga_barang_sumberdaya_matgis/edit');?>" class="btn btn-info btn-flat">Ubah</a>

                </div>
              </div>
            </div>

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function() {

  var $table = $('#table'),
  $remove = $('#remove'),
  selections = [];

   $table.bootstrapTable({
        url: "<?php echo site_url('Commodity/data_hrg_brg_smbd_matgis') ?>",
        cookieIdTable:"mat_price_id",
        idField:"mat_price_id",
        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
        columns: [
         {
           field: 'checkbox',
           checkbox:true,
           align: 'center',
           valign: 'middle'
         },
          {
          field: 'catalog_code',
          title: 'Kode Katalog',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'image',
          title: 'Gambar',
          align: 'center',
          width:'10%',
          valign: 'middle',
          formatter: imageFormatter,
      },
        {
          field: 'short_description',
          title: 'Deskripsi',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },
          {
          field: 'price',
          title: 'Harga',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },{
          field: 'sourcing_name',
          title: 'Referensi',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
          {
          field: 'vendor_name',
          title: 'Penyedia',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
         {
          field: 'start_date',
          title: 'Mulai berlaku',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
         {
          field: 'end_date',
          title: 'Selesai berlaku',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
         {
          field: 'volume_remain',
          title: 'Sisa Volume',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'created_date',
          title: 'Tanggal Update',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        }

        ]

      });

  function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function (row) {
          return row.mat_price_id
      });
  } 

setTimeout(function () {
  $table.bootstrapTable('resetView');
}, 200);
$table.on('check.bs.table  check-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();
  var param = "";
  $.each(selections,function(i,val){
    param += val+"=1&";
  });
  $.ajax({
    url:"<?php echo site_url('Commodity/selection/selection_mat_price') ?>",
    data:param,
    type:"get"
  });

});
$table.on('uncheck.bs.table uncheck-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();

  var param = "";
  $.each(selections,function(i,val){
    param += val+"=0&";
  });
  $.ajax({
    url:"<?php echo site_url('Commodity/selection/selection_mat_price') ?>",
    data:param,
    type:"get"
  });
});
$table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row));

});
$table.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});
$remove.click(function () {
  var ids = getIdSelections();
  $table.bootstrapTable('remove', {
    field: 'id',
    values: ids
  });
  $remove.prop('disabled', true);
});

function rowNumberFormatter(value, row, index) {
    return 1+index;
}
function imageFormatter(value, row, index) {

    return '<img src="'+row.image+'" height="100" width="100" class="img_zoom" style="padding:10px;transition: transform .2s;margin: 0 auto;" />';

}

function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.mat_price_id, selections) !== -1;
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

function detailFormatter(index, row) {

  var mydata = $.getCustomJSON("<?php echo site_url('Commodity/alias_hrg_brg') ?>");

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
  return [
  '<a class="like" href="javascript:void(0)" title="Like">',
  '<i class="glyphicon glyphicon-heart"></i>',
  '</a>  ',
  '<a class="remove" href="javascript:void(0)" title="Remove">',
  '<i class="glyphicon glyphicon-remove"></i>',
  '</a>'
  ].join('');
}
window.operateEvents = {
  'click .like': function (e, value, row, index) {
    alert('You click like action, row: ' + JSON.stringify(row));
  },
  'click .remove': function (e, value, row, index) {
    $table.bootstrapTable('remove', {
      field: 'id',
      values: [row.mat_price_id]
    });
  }
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
});

</script>