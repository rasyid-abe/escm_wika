<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.semanticui.min.css" rel="stylesheet">
<style>

.input-group > .form-control:not(:first-child), .input-group > .custom-select:not(:first-child) {
  background-color: #e9ecef;
}

.form-control {
  font-size: 12px;
  background-color: #f7f7f8;
  outline: none;
}

.form-control:hover {
  border-color: #29a7de;
}

.dataTables_wrapper .dataTables_filter input {
  border: 2px solid #29a7de;
  border-top: 0;
  border-left: 0;
  border-right: 0;
  border-radius: 15px;
  padding: 6px;
  background-color: transparent;
  margin-left: 11px;
}

</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom pb-2">
                <span class="card-title text-bold-600 mr-2 float-left">Daftar Pembuatan Proyek <?php echo $year; ?> (Non PMCS)</span>
                <span><a href="<?php echo site_url('perencanaan_pengadaan/pr_proyek_non_pmcs/pembuatan_proyek_non_pmcs'); ?>" class="btn btn-info btn-sm rounded"><i class="ft-plus"></i> Tambah</a></span>
                  <span><a href="<?php echo site_url('perencanaan_pengadaan/sync'); ?>" onclick="return confirm('Apakah anda yakin untuk Syncron Proyek CRM?');" class="btn btn-warning btn-sm rounded"><i class="ft-refresh-cw"></i> Sync</a></span>
                <div class="btn-group-sm float-right">
                  <form method="POST" action="<?php echo site_url('administration/master_data/data_crm'); ?>">
                    <div class="input-group">
                        <select class="form-control col-12" name="periode_inp">
                          <option value="">Pilih Tahun</option>
                          <option value="2022">2022</option>
                          <option value="2021">2021</option>
                          <option value="2020">2020</option>
                        </select>
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-sm btn-info"><i class="ft-save"></i> Search</button>
                        </div>
                    </div>
                  </form>
                </div>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="dt-table" class="table table-hover">
                          <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>HPS</th>
                                <th>Jadwal Tender</th>
                                <th>Jenis Proyek</th>
                                <th>Kode Proyek</th>
                                <th>Kode Divisi</th>
                                <th>Nama Proyek</th>
                                <th>SBU</th>
                                <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php if(isset($getCrm)) { ?>

                            <?php $no=1; foreach ($getCrm as $v) { ?>
                              <tr>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $v['Customer'];?></td>
                                <td class="text-right"><?php echo inttomoney($v['HPS']);?></td>
                                <td><?php echo $v['JadwalTender'];?></td>
                                <td class="text-center"><?php echo $v['JenisProyek'];?></td>
                                <td class="text-center"><?php echo $v['KodeProyek'];?></td>
                                <td class="text-center"><?php echo $v['KodeDivisi'];?></td>
                                <td><?php echo $v['NamaProyek'];?></td>
                                <td><?php echo $v['SBU'];?></td>
                                <td><?php echo $v['Status'];?></td>
                              </tr>
                            <?php } ?>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

  $(document).ready(function () {
    $('#dt-table').DataTable();
    $('.dataTables_length').addClass('bs-select');
  });

</script>


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
