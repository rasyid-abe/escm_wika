<div class="row" id="pr_container">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Daftar Join Paket Pengadaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
              <table id="daftar_pr" class="table table-bordered table-striped"></table>
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

  var $daftar_pr = $('#daftar_pr'),
  selections = [];

  $(function () {

    $daftar_pr.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_pr') ?>",
      idField:"pr_number",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      {
        field: 'checkbox',
        checkbox:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'mat_group_code',
        title: 'Kode Grup',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },      
      {
        field: 'pr_number',
        title: 'No. Paket Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },     
      {
        field: 'pr_packet',
        title: 'Nama Paket Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
       {
        field: 'pr_subject_of_work',
        title: 'Nama Program',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'pr_requester_name',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },

        {
        field: 'nilai',
        title: 'Nilai HPS',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
       {
        field: 'pr_dept_name',
        title: 'Divisi/Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
       {
        field: 'pr_number',
        title: 'Aksi',
        align: 'center',
        width:'10%',
        valign: 'middle',
        formatter: operateFormatter
      }
      ]

  });
    setTimeout(function () {
      $daftar_pr.bootstrapTable('resetView');
    }, 200);

    $daftar_pr.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

  //checked
  $daftar_pr.on('check.bs.table  check-all.bs.table', function () {
    selections = getIdSelections();
    var param = "";
    $.each(selections,function(i,val){
      param += val+"=1&";
    });
    $.ajax({
      url:"<?php echo site_url('Procurement/selection/selection_pr') ?>",
      data:param,
      type:"get"
    });
  });

  //unchecked
  $daftar_pr.on('uncheck.bs.table uncheck-all.bs.table', function () {
    selections = getIdSelections();
    var param = "";
    $.each(selections,function(i,val){
      param += val+"=0&";
    });
    $.ajax({
      url:"<?php echo site_url('Procurement/selection/selection_pr') ?>",
      data:param,
      type:"get"
    });
  });


  //get group code
  $daftar_pr.on('check.bs.table  check-all.bs.table', function () {
    selections = getGroupCode();
    var param = "";
    $.each(selections,function(i,val){
      param += val+"=1&";
    });
    $.ajax({
      url:"<?php echo site_url('Procurement/selection/selection_group') ?>",
      data:param,
      type:"get"
    });
  });

  $daftar_pr.on('uncheck.bs.table uncheck-all.bs.table', function () {
    selections = getGroupCode();
    var param = "";
    $.each(selections,function(i,val){
      param += val+"=0&";
    });
    $.ajax({
      url:"<?php echo site_url('Procurement/selection/selection_group') ?>",
      data:param,
      type:"get"
    });
  });
  //end


  $daftar_pr.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row));
  });

  $daftar_pr.on('all.bs.table', function (e, name, args) {
});

  //get pr number
  function getIdSelections() {
    return $.map($daftar_pr.bootstrapTable('getSelections'), function (row) {
      return row.pr_number
    });
  }

  //get group code
  function getGroupCode() {
    return $.map($daftar_pr.bootstrapTable('getSelections'), function (row) {
      return row.mat_group_code
    });
  }
  function responseHandler(res) {
    $.each(res.rows, function (i, row) {
      row.state = $.inArray(row.pr_number, selections) !== -1;
    });
    return res;
  }

  });

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/detail_join/') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/'+value+'" target="_blank">',
    'Detail',
    '</a>  ',
  ].join('');
}

</script>