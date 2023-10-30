<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Daftar Vendor Terpilih</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table id="daftar_vendor_absen" class="table table-bordered table-striped"></table>
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

    var mydata = $.getCustomJSON("<?php echo site_url('Procurement') ?>/"+url);

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

</script>

<?php 
$list_vnd = $this->session->userdata("selection_vendor_tender");
foreach ($vendor_status as $key => $value) { 
  if($list_vnd != null){
    $val = (in_array($value['pvs_vendor_code'], $list_vnd)) ? 1 : 0;
  } else {
    $val = 0;
  }
  ?>
  <input type="hidden" class="vendor_hadir" name="vendor_hadir[<?php echo $value['pvs_vendor_code'] ?>]" data-id="<?php echo $value['pvs_vendor_code'] ?>" value="<?php echo $val ?>">
<?php } ?>

<script type="text/javascript">

  var $daftar_vendor_absen = $('#daftar_vendor_absen'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $daftar_vendor_absen.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_vendor_tender/selected') ?>",
      
      selectItemName:"vendor_attend_tender[]",
      
      cookieIdTable:"vendor_tender",
      
      idField:"vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      pageSize:100,
      
      pageList:[100],

      columns: [
      {
        field: 'checkbox',
        title:'Hadir?',
        checkbox:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'fin_class',
        title: 'Klasifikasi Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
       {
        field: 'lkp_description',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      
      ]

    });
    setTimeout(function () {
      $daftar_vendor_absen.bootstrapTable('resetView');
    }, 200);

    $daftar_vendor_absen.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

    $daftar_vendor_absen.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $(".vendor_hadir").val(0);

      $.each(selections,function(i,val){
        param += val+"=1&";
        $(".vendor_hadir[data-id='"+val+"']").val(1);
      });

      $.ajax({
        url:"<?php echo site_url('Procurement/selection/selection_vendor_tender_hadir') ?>",
        data:param,
        type:"get"
      });

    });
    $daftar_vendor_absen.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $(".vendor_hadir").val(0);

      $.each(selections,function(i,val){
        param += val+"=1&";
        $(".vendor_hadir[data-id='"+val+"']").val(1);
      });

      $.ajax({
        url:"<?php echo site_url('Procurement/selection/selection_vendor_tender_hadir') ?>",
        data:param,
        type:"get"
      });

    });
    $daftar_vendor_absen.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });
    $daftar_vendor_absen.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});

    function getIdSelections() {
      return $.map($daftar_vendor_absen.bootstrapTable('getSelections'), function (row) {
        return row.vendor_id
      });
    }
    function responseHandler(res) {
      $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.vendor_id, selections) !== -1;
      });
      return res;
    }

  });

</script>