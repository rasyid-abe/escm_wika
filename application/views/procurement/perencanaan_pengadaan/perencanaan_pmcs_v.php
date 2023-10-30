<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="card-content">
          <div class="table-responsive">
            <div class="card" style="border-radius: 30px;">
              <div class="card-body">
                <a href="<?= base_url('procurement/perencanaan_pengadaan/perencanaan_pmcs/')?>" class="btn btn-info" onclick="return confirm('Apakah Anda yakin Syncron data?')" style="margin-bottom: -65px;">
                  <i class="ft-refresh-cw mr-1"></i> Syncron
                </a>
                <table id="table_perencanaan_pmcs" class="table table-bordered table-striped"></table>
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
      var view ='<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_perencanaan_pengadaan/lihat/'+value+'">Lihat</a>';
    <?php } ?>
    <?php if($edit){ ?>
      var edit ='<a class="btn btn-primary btn-xs action" href="'+link+'/update_daftar_perencanaan/ubah/'+value+'">Ubah</a>';
    <?php } ?>
    return [view,edit].join('');
}
window.operateEvents = {
  'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
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

</script>

<script type="text/javascript">
  var $table_perencanaan_pmcs = $('#table_perencanaan_pmcs'),
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
                // $('#submit_file_csv').attr('disabled',true);

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

    $table_perencanaan_pmcs.bootstrapTable({

      url: "<?php echo site_url('procurement/data_perencanaan_pmcs') ?>/<?php echo ($edit) ? 'update' : '' ?>",
      cookieIdTable:"perencanaan_pmcs",
      idField:"ppm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'smbd_code',
        title: 'Kode Sumber Daya',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      }, {
        field: 'smbd_name',
        title: 'Nama Sumber Daya',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'unit',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'smbd_quantity',
        title: 'Volume',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      }
      ]

    });
setTimeout(function () {
  $table_perencanaan_pmcs.bootstrapTable('resetView');
}, 200);

});

</script>
