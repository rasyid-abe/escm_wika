<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <!-- <h4 class="card-title float-left">Gudang</h4> -->
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="gudang" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?php echo site_url('administration/master_data/gudang/tambah') ?>" role="button"><i class="ft-plus mr-1"></i>Tambah</a>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

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

  var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/"+url);

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
  var x = row.code_war+", "+row.name_war+", "+row.location_war;
  var link = "<?php echo site_url('administration/master_data/gudang') ?>";
  return [
  '<div class="btn-group"><a class="btn btn-sm btn-info btn-xs action" href="'+link+'/ubah/'+value+'">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a> ',
    '<a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus '+x+'?\')" href="'+link+'/hapus/'+value+'">',
      '<i class="ft-trash mr-1"></i>Hapus',
      '</a> </div>',
  ].join('');
  }

  </script>

  <script type="text/javascript">
    var $gudang = $('#gudang'),
      selections = [];
  </script>

  <script type="text/javascript">
    $(function() {

      $gudang.bootstrapTable({

        url: "<?php echo site_url('administration/data_gudang') ?>",
        cookieIdTable: "gudang_tbl",
        idField: "id_war",
        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
        columns: [{
            field: 'id_war',
            title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
            align: 'center',
            width: '15%',
            formatter: operateFormatter,
          },
          {
            field: 'code_war',
            title: 'Kode Gudang',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'name_war',
            title: 'Nama Gudang',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'location_war',
            title: 'Lokasi Gudang',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'district_name',
            title: 'Kantor',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
        ]

      });
      setTimeout(function() {
        $gudang.bootstrapTable('resetView');
      }, 200);

      $gudang.on('expand-row.bs.table', function(e, index, row, $detail) {
        $detail.html(detailFormatter(index, row, "alias_gudang"));
      });

    });
  </script>
