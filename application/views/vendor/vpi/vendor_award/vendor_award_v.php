<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-header border-bottom pb-2">
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive pt-2">
                <div class="col-md-12">
                  <btn data-url="<?php echo site_url();?>/vendor/vpi/vendor_award/export_vendor_award/pdf" data-tipe="rekap"
                    class="btn btn-sm btnExport" data-toggle="tooltip" title="Export PDF" target="_blank"
                    style="background-color:red;color:white;margin-right:5px">
                    <i class="fa fa-file-pdf-o"></i> Export PDF
                  </btn>

                  <btn data-url="<?php echo site_url();?>/vendor/vpi/vendor_award/export_vendor_award_excel" data-tipe="rekap"
                    class="btn btn-sm btnExport" data-toggle="tooltip" title="Export Excel" target="_blank"
                    style="background-color:green;color:white;margin-right:5px">
                    <i class="fa fa-file-excel-o"></i> Export Excel
                  </btn>
                </div>
                <table id="table_pekerjaan" class="table table-bordered table-striped"></table>
              </div>
            </div>
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

    var mydata = $.getCustomJSON("<?php echo site_url() ?>/"+url);

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
     var addlink = "<?php echo site_url('vendor/vpi/kompilasi_vpi/add') ?>";
     var lihatlink = "<?php echo site_url('vendor/vpi/kompilasi_vpi/detail') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+addlink+'/'+value+'">',
    'Nilai',
    '</a>  ',
    '<a class="btn btn-primary btn-xs action" href="'+lihatlink+'/'+value+'">',
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

  var $table_pekerjaan = $('#table_pekerjaan'),
  selections = [];

</script>


<script type="text/javascript">

  $(function () {

    $table_pekerjaan.bootstrapTable({

      url: "<?php echo site_url('vendor/vpi/vendor_award/data') ?>",
      cookieIdTable:"daftar_pekerjaan",
      idField:"urlid",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
        {
          field: 'vendor_name',
          title: 'Nama Vendor',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
        {
          field: 'total_contract_amount',
          title: 'Nilai <br>(Total Kontrak)',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
        {
          field: 'total_score_vpi',
          title: 'Vendor <br> Performance',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },
        {
          field: 'jumlah_kontrak',
          title: 'Jumlah Kontrak',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },
        {
          field: 'total_proyek',
          title: 'Jumlah Proyek',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },
        {
          field: 'masa_kerja',
          title: 'Masa Kerja',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },{
          field: 'jumlah',
          title: 'Jumlah <br>(Total Nilai)',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },
        {
          field: 'rank',
          title: 'Rank',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },


      ]

    });
    setTimeout(function () {
      $table_pekerjaan.bootstrapTable('resetView');
    }, 200);

    $table_pekerjaan.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias"));
    });

    $('.btnExport').click(function(){

      var url = $(this).attr("data-url")

      window.open(url ,'_blank');


    })

  });

</script>
