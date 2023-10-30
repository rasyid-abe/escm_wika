<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Daftar Mata Anggaran</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

            <table id="daftar_mata_anggaran" class="table table-bordered table-striped"></table>

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


</script>

<script type="text/javascript">

  var $table = $('#daftar_mata_anggaran'),
  selections = [];

  $(function () {

    $table.bootstrapTable({

      url: "<?php echo site_url('administration/data_anggaran') ?>",
      cookieIdTable:"anggaran_ck",
      idField:"id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
 {
        field: 'kode_perkiraan',
        title: 'Kode Anggaran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'nama_perkiraan',
        title: 'Nama Anggaran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      /*

      */
      ]

    });

    setTimeout(function () {
      $table.bootstrapTable('resetView');
    }, 200);

    $table.on('check.bs.table check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('administration/picker') ?>",
        data:param,
        type:"get"
      });

    });
    $table.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('administration/picker') ?>",
        data:param,
        type:"get"
      });
    });

    $table.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});

  });
  function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
        console.log(row);
      return row.id
    });
  }
  function responseHandler(res) {
    $.each(res.rows, function (i, row) {
      row.state = $.inArray(row.id, selections) !== -1;
    });
    return res;
  }


</script>
