<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Daftar Pengadaan</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <table id="table_monitor_pengadaan" class="table table-bordered table-striped"></table>

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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/') ?>";
    return [
    '<a class="btn btn-primary btn-xs dialog" href="#" data-url="'+link+'/proses_pembatalan_paket/'+value+'">',
    'Ubah',
    '</a>  ',
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $table_monitor_pengadaan.bootstrapTable('remove', {
      field: 'id',
      values: [row.ptm_number]
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

  var $table_monitor_pengadaan = $('#table_monitor_pengadaan'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_monitor_pengadaan.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_pr_rfq_kontrak') ?>",
      cookieIdTable:"monitor_pengadaan",
      idField:"pr_number",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'pr_number',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        // width:'5%',
        valign: 'middle',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'pr_number',
        title: 'No Paket',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'rfq_numb',
        title: 'No Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'ctr_numb',
        title: 'No Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'pr_requester_name',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }, 
      {
        field: 'pr_subject_of_work',
        title: 'Nama Rencana Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'pr_packet',
        title: 'Nama Paket Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'pr_dept_name',
        title: 'Divisi/Departemen',
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
        valign: 'middle',
        width:'25%',
      },
      ]

    });
setTimeout(function () {
  $table_monitor_pengadaan.bootstrapTable('resetView');
}, 200);

$table_monitor_pengadaan.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_permintaan_pengadaan"));
});

});

</script>