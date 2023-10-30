<style>
  .bootstrap-table {
    margin-top: 0px;
  }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Katalog Barang</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <table id="table_kat_brg" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Katalog Barang Sumberdaya</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <table id="table_kat_brg_smbd" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Katalog Jasa</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_kat_jasa" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Katalog Jasa Sumberdaya</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_kat_jasa_smbd" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Harga Barang</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_hrg_brg" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Harga Barang Sumberdaya</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_hrg_brg_smbd" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Harga Jasa</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_hrg_jasa" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Harga Jasa Sumberdaya</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_hrg_jasa_smbd" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('commodity') ?>/"+url);

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
    '<a class="btn btn-success btn-xs approval" href="'+value+'" title="Approval">',
    '<i class="ft-arrow-up-right mr-1"></i>Proses',
    '</a>  ',
  /*
  '<a class="remove" href="javascript:void(0)" title="Remove">',
  '<i class="glyphicon glyphicon-remove"></i>',
  '</a>'
  */
  ].join('');
}
window.operateEvents = {
  'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $table_kat_brg.bootstrapTable('remove', {
      field: 'id',
      values: [row.mat_catalog_code]
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

  var $table_kat_brg_smbd = $('#table_kat_brg_smbd'),
  $table_kat_jasa_smbd = $('#table_kat_jasa_smbd'),
  $table_hrg_brg_smbd = $('#table_hrg_brg_smbd'),
  $table_hrg_jasa_smbd = $('#table_hrg_jasa_smbd'),
  $table_kat_brg = $('#table_kat_brg'),
  $table_kat_jasa = $('#table_kat_jasa'),
  $table_hrg_brg = $('#table_hrg_brg'),
  $table_hrg_jasa = $('#table_hrg_jasa'),
  selections = [];

</script>

<script type="text/javascript">
    $(function () {

    $table_kat_brg.bootstrapTable({

      url: "<?php echo site_url('commodity/data_mat_catalog/approval') ?>",
      cookieIdTable:"mat_catalog",
      idField:"mat_catalog_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'mat_catalog_code',
        title: 'Kode Barang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      }, {
        field: 'mat_group_code',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
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
        field: 'uom',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }

      ]

    });
setTimeout(function () {
  $table_kat_brg.bootstrapTable('resetView');
}, 200);

$table_kat_brg.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_mat_catalog"));
});

});


 //table pekerjaan sumberdaya
 $(function () {

    $table_kat_brg_smbd.bootstrapTable({

      url: "<?php echo site_url('commodity/data_mat_catalog_smbd/approval') ?>",
      cookieIdTable:"mat_catalog",
      idField:"mat_catalog_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'mat_catalog_code',
        title: 'Kode Barang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      }, {
        field: 'group_code',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },{
        field: 'unspsc_group_code',
        title: 'UNSPSC Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
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
        field: 'uom',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }

      ]

    });
setTimeout(function () {
  $table_kat_brg_smbd.bootstrapTable('resetView');
}, 200);

$table_kat_brg_smbd.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_mat_catalog"));
});

});


</script>


<script type="text/javascript">
  $(function () {

    $table_kat_jasa.bootstrapTable({

      url: "<?php echo site_url('commodity/data_kat_jasa/approval') ?>",
      cookieIdTable:"kat_jasa",
      idField:"kat_jasa_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'srv_catalog_code',
        title: 'Kode Jasa',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      }, {
        field: 'srv_group_code',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },

      {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      }


      ]

    });
setTimeout(function () {
  $table_kat_jasa.bootstrapTable('resetView');
}, 200);

$table_kat_jasa.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_kat_jasa"));
});

});

  //sumberdaya
  $(function () {

    $table_kat_jasa_smbd.bootstrapTable({

      url: "<?php echo site_url('commodity/data_kat_jasa_smbd/approval') ?>",
      cookieIdTable:"kat_jasa_smbd",
      idField:"kat_jasa_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'srv_catalog_code',
        title: 'Kode Jasa',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      }, {
        field: 'srv_group_code',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },{
        field: 'unspsc_code',
        title: 'UNSPSC Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },

      {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      }


      ]

    });
setTimeout(function () {
  $table_kat_jasa_smbd.bootstrapTable('resetView');
}, 200);

$table_kat_jasa_smbd.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_kat_jasa"));
});

});

</script>

<script type="text/javascript">
  $(function () {

    $table_hrg_brg.bootstrapTable({

      url: "<?php echo site_url('commodity/data_hrg_brg/approval') ?>",
      cookieIdTable:"hrg_brg",
      idField:"hrg_brg_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
{
        field: 'mat_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
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
        field: 'sourcing_name',
        title: 'Referensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'vendor',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'status_name',
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
  $table_hrg_brg.bootstrapTable('resetView');
}, 200);

$table_hrg_brg.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_hrg_brg"));
});

});

  //sumberdaya

  $(function () {

    $table_hrg_brg_smbd.bootstrapTable({

      url: "<?php echo site_url('commodity/data_hrg_brg_smbd/approval') ?>",
      cookieIdTable:"hrg_brg",
      idField:"hrg_brg_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
{
        field: 'mat_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
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
        field: 'sourcing_name',
        title: 'Referensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'vendor',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'status_name',
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
  $table_hrg_brg_smbd.bootstrapTable('resetView');
}, 200);

$table_hrg_brg_smbd.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_hrg_brg"));
});

});

</script>

<script type="text/javascript">
$(function () {

    $table_hrg_jasa.bootstrapTable({

      url: "<?php echo site_url('commodity/data_hrg_jasa/approval') ?>",
      cookieIdTable:"hrg_jasa",
      idField:"hrg_jasa_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'srv_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
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
        field: 'sourcing_name',
        title: 'Referensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'vendor',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'status',
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
  $table_hrg_jasa.bootstrapTable('resetView');
}, 200);

$table_hrg_jasa.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_hrg_jasa"));
});

});

//sumberdaya
  $(function () {

    $table_hrg_jasa_smbd.bootstrapTable({

      url: "<?php echo site_url('commodity/data_hrg_jasa_smbd/approval') ?>",
      cookieIdTable:"hrg_jasa",
      idField:"hrg_jasa_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'srv_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
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
        field: 'sourcing_name',
        title: 'Referensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'vendor',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'status_name',
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
  $table_hrg_jasa_smbd.bootstrapTable('resetView');
}, 200);

$table_hrg_jasa_smbd.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_hrg_jasa"));
});

});

</script>
