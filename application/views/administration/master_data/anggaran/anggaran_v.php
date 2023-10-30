<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title float-left">Anggaran (COA)</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="anggaran" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?php echo site_url('administration/master_data/anggaran/tambah') ?>" role="button"><i class="ft-plus mr-1"></i>Tambah</a>
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

  function operateFormatter(value, row, index) {

    var link = "<?php echo site_url('administration/master_data/anggaran') ?>";
    return [
      '<div class="btn-group"><a class="btn btn-sm btn-info btn-xs action" href="' + link + '/ubah/' + value + '">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a>  ',
      '<a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus/' + value + '">',
      '<i class="ft-trash mr-1"></i>Hapus',
      '</a></div>',
    ].join('');
  }

  function valuePusat(value, row, index) {
    if (row['pusat'] == 't') {
      return[
        '<i class="ft-check mr-1"></i>'
      ].join('');
    } else {
      return[
        '<i class="ft-x mr-1"></i>'
      ].join('');
    }
  }

  function valueProyek(value, row, index) {
    if (row['proyek'] == 't') {
      return[
        '<i class="ft-check mr-1"></i>'
      ].join('');
    } else {
      return[
        '<i class="ft-x mr-1"></i>'
      ].join('');
    }
  }

  function valueDevisi(value, row, index) {
    if (row['devisi'] == 't') {
      return[
        '<i class="ft-check mr-1"></i>'
      ].join('');
    } else {
      return[
        '<i class="ft-x mr-1"></i>'
      ].join('');
    }
  }

</script>

<script type="text/javascript">
  var $anggaran = $('#anggaran'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $anggaran.bootstrapTable({

      url: "<?php echo site_url('administration/data_anggaran') ?>",
      cookieIdTable: "anggaran",
      value: "yes",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '15%',
          formatter: operateFormatter,
        },
        {
          field: 'kode_perkiraan',
          title: 'Kode Perkiraan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'nama_perkiraan',
          title: 'Nama Perkiraan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'pusat',
          title: 'Pusat',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          formatter: valuePusat,
        },
        {
          field: 'devisi',
          title: 'Devisi',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle',
          formatter: valueDevisi
        },
        {
          field: 'proyek',
          title: 'Proyek',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle',
          formatter: valueProyek
        }
        /*
        {
          field: 'year_cc',
          title: 'Tahun Anggaran',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'dept_name',
          title: 'Departemen',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },
        */
      ]
    });
    setTimeout(function() {
      $anggaran.bootstrapTable('resetView');
    }, 200);

  });
</script>
