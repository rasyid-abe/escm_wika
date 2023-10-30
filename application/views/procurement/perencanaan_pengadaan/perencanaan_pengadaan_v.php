<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Data Rencana Pengadaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive">

            <table id="table_perencanaan_pengadaan" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('procurement') ?>/"+url);

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
    var link = "<?php echo site_url('procurement/perencanaan_pengadaan') ?>";
    var view = "";
    var edit = "";
    <?php if($view){ ?>
      var view ='<a class="btn btn-info btn-sm action" href="'+link+'/daftar_perencanaan_pengadaan/lihat/'+value+'"><i class="ft-search"></i> Lihat</a>';
    <?php } ?>
    <?php if($edit){ ?>
      var edit ='<a class="btn btn-info btn-sm action" href="'+link+'/update_daftar_perencanaan/ubah/'+value+'"><i class="ft-search"></i> Ubah</a>';
    <?php } ?>
    return [view,edit].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    
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

  var $table_perencanaan_pengadaan = $('#table_perencanaan_pengadaan'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {
        var bar = $('.bar-csv');
        var percent = $('.percent-csv');

        $('#uploadFormCsv').ajaxForm({
          dataType:  'json',
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function(xhr) {
                // status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                $('#stop_upload_csv').click(function(){
                // return false;
                xhr.abort();
                $('#file-uploader-csv').val("");
                setTimeout(function () {
                $('#loading_upload_csv').modal('hide');
                }, 100);                

              })
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#loading_upload_csv').modal("show");
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                if (percentComplete == 100) {
                setTimeout(function () {
                $('#loading_upload_csv').modal('hide');
                }, 500);
              }
            },
            success: function(responseJSON, statusText, xhr) {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);

                console.log(responseJSON)
                if (responseJSON == "fail") {

                    alert('Gagal menambah perencanaan');

                  }
                  else{
                    alert('Sukses menambah perencanaan');
                  }
            },
            error: function (xhr, status, error) {
           console.log(error)
          },

    });

    $table_perencanaan_pengadaan.bootstrapTable({

      url: "<?php echo site_url('procurement/data_perencanaan_pengadaan') ?>/<?php echo ($edit) ? 'update' : '' ?>",
      cookieIdTable:"perencanaan_pengadaan",
      idField:"ppm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
        {
          field: 'ppm_id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          valign:'middle',
          width:'10%',
          events: operateEvents,
          formatter: operateFormatter,
        },
        {
          field: 'ppm_created_date_vw',
          title: 'Tanggal Buat',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
        {
          field: 'ppm_planner',
          title: 'User',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'20%',
        }, {
          field: 'ppm_subject_of_work',
          title: 'Nama Program',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle',
          width:'20%',
        },
        {
          field: 'ppm_dept_name',
          title: 'Divisi/Departemen',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle',
          width:'20%',
        },
        {
          field: 'ppm_status_name',
          title: 'Status',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
      ]

    });

    setTimeout(function () {
      $table_perencanaan_pengadaan.bootstrapTable('resetView');
    }, 200);

    $table_perencanaan_pengadaan.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_perencanaan_pengadaan"));
    });

  });

</script>
