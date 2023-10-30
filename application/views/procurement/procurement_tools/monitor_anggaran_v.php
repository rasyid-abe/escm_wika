<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Daftar Anggaran</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <table id="table_monitor_anggaran" class="table table-bordered table-striped"></table>

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
    var link = "<?php echo site_url('procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/lihat/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

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

  var $table_monitor_anggaran = $('#table_monitor_anggaran'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_monitor_anggaran.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_monitor_anggaran') ?>",
      cookieIdTable:"monitor_pengadaan",
      idField:"ptm_number",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'ppm_id',
        title: 'lihat',
        align: 'center',
        width:'10%',
        formatter: operateFormatter,
        valign: 'middle'
      },
     {
        field: 'ppm_planner',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }, {
        field: 'ppm_subject_of_work',
        title: 'Nama Program',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'ppm_dept_name',
        title: 'Divisi/Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'ppm_renc_kebutuhan_vw',
        title: 'Rencana Kebutuhan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'ppm_renc_pelaksanaan_vw',
        title: 'Rencana Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'ppm_status_name',
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
      $table_monitor_anggaran.bootstrapTable('resetView');
    }, 200);

    $table_monitor_anggaran.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias"));
    });

  });

</script>

