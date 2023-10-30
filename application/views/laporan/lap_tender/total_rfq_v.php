<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>RFQ Seluruh departemen</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <button class="btn btn-info  dim btn-medium-dim btn-outline" type="button" style="height:70px;width:500px">
            <h2>
              Efisiensi IDR <?php echo str_replace(',', '.',  number_format($efisiensi)) ?>   
              <?php echo "(".round($persentase, 2)."%)" ?>  
            </h2>
          </button>
             
          <div class="table-responsive">

            <table id="table_pekerjaan_kontrak" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('contract') ?>/"+url);

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
    var link = "<?php echo site_url('contract/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_kontrak/'+value+'">',
    'Proses',
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

  var $table_pekerjaan_kontrak = $('#table_pekerjaan_kontrak'),
  $table_pekerjaan_adendum = $('#table_pekerjaan_adendum'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_kontrak.bootstrapTable({

      url: "<?php echo site_url('laporan/lap_tender/data_per_dept') ?>",
      cookieIdTable:"daftar_pekerjaan_kontrak",
      idField:"ccc_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      // {
      //   field: "ccc_id",
      //   title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
      //   align: 'center',
      //   width:'8%',
      //   valign: 'middle',
      //   formatter: operateFormatter,
      // },
      {
        field: 'ptm_number',
        title: 'Nomor RFQ',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'ptm_dept_name',
        title: 'Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'ptm_packet',
        title: 'Paket Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'type',
        title: 'B/J',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'ptm_project_name',
        title: 'Proyek',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        
      },
      {
        field: 'kirim_rfq',
        title: 'Kirim RFQ',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'tunjuk',
        title: 'Penunjukan Pemenang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'durasi',
        title: 'Durasi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'vendor_name',
        title: 'Pemenang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
    
      {
        field: 'hps',
        title: 'HPS',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
    
      {
        field: 'total_contract',
        title: 'Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
    
      {
        field: 'efisiensi',
        title: 'Efisiensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
    
    
      {
        field: 'selisih_persen',
        title: 'Efisiensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
    
      ]

    });
setTimeout(function () {
  $table_pekerjaan_kontrak.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_kontrak.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_kontrak"));
});

});

</script>

<script>
   
$(document).ready(function() {
   $(".columns").hide();
   $(".form-control").hide()
});
</script>
