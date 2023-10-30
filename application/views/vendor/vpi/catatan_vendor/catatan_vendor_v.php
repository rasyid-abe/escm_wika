<style>
  .bootstrap-table {
    margin-top: 0px;
  }
  .fixed-table-container {
    border: none;
  }
  .fixed-table-container thead th {
    border: none;
  }
  .table th, .table td {
    border: none;
  }
  .fixed-table-container tbody td {
    border: none;
  }
  .form-control {
    border: 2px solid #29a7de;
    border-radius: 1.35rem;
    border-top: none;
    border-left: none;
    border-right: none;
  }
  .form-control:focus {
    border-color: #29a7de;
  }
  .fixed-table-toolbar .columns {
    margin-left: 40px;
  }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <!-- <div class="card float-e-margins"> -->
        <!-- <div class="card-body"> -->
          <div class="table-responsive">
            <div class="card">
              <div class="card-body">
                <table id="table_pekerjaan" class="table m-0"></table>
              </div>
            </div>
            <!-- <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Penjelasan</th>
                  <th>Status</th>
                  <th>Lampiran</th>
                  <th>Pemberi Catatan</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; foreach ($catatan as $value) { ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo $value['note']; ?></td>
                        <td class="text-center">
                          <?php if ($value['is_good'] == 1) {
                            echo '<span class="badge badge-success">Baik</span>';
                          } else echo '<span class="badge badge-danger">Kurang Baik</span>'; ?>
                        </td>
                        <td>
                            <?php if ($value['lampiran'] != NULL) { ?>
                                <a href="<?php echo base_url('attachment/vpi/catatan/' . $value['lampiran']); ?>" target="_blank">Download</a>
                            <?php } ?>
                        </td>
                        <td><?php echo $value['nama']; ?></td>
                        <td><?php echo $value['date_create']; ?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table> -->
          </div>
        <!-- </div>
      </div> -->
    </div>
  </div>
</div>
<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>
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

      url: "<?= site_url('vendor/vpi/catatan_vendor/data') ?>",
      cookieIdTable:"daftar_pekerjaan",
      idField:"urlid",
      <?= DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
        {
          field: 'nama',
          title: 'Nama',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
        {
          field: 'is_good',
          title: 'Rank',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
        {
          field: 'note',
          title: 'Catatan',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },
        {
          field: 'lampiran',
          title: 'Lampiran',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        },
        {
          field: 'date_create',
          title: 'Tanggal',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'10%',
        }
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
