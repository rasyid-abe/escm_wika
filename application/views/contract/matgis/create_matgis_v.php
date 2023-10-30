<style media="screen">
.label-success, .badge-success {
  background-color: #5b9c1f;
  color: #FFFFFF;
}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5><?php echo $sub_title?></h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">
          <div class="table-responsive">
            <!-- <a class="btn btn-primary" href="<?php //echo site_url().'/contract/push_wo_matgis' ?>">Push PO/Work Order Matgis</a> -->
            <table id="table_work_order" class="table table-bordered table-striped"></table>
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

function stat_format(value,row,index){
  return ['<span class="label label-success">'+value+'</span>'].join();
}
function detailFormatter(index, row, url) {

  var mydata = $.getCustomJSON("<?php echo site_url('contract') ?>/"+url);

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
  var link = "<?php echo site_url('contract_matgis') ?>";
  return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/process_matgis/<?php echo $mod?>/'+value+'">',
    'Proses',
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
function totalFormatter(data) {

  var total = 0;

  if (data.length > 0) {

    var field = this.field;

    total = data.reduce(function(sum, row) {
      return sum + (+row[field]);
    }, 0);
    var num = '$' + total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    return num;
  }

  return '';
};

var $table_work_order = $('#table_work_order'),
selections = [];

</script>
<script type="text/javascript">

$(function () {

  $table_work_order.bootstrapTable({

    url: "<?php echo site_url('data_matgis/data_create_matgis/po')?>",
    cookieIdTable:"daftar_work_order",
    idField:"ccc_id",
    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
    columns: [
      {
        field: "contract_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: operateFormatter,
      },
      {
        field: 'ptm_number',
        title: 'Nomor Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'contract_number',
        title: 'Nomor Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'scope_work',
        title: 'Deskripsi Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'30%',
      },

      {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'qty_contract',
        title: 'Qty Contract',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'qty_wo',
        title: 'Qty PO',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'remain',
        title: 'Sisa Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },

      {
        field: 'awa_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
        formatter: stat_format,
      },

    ]

  });
  setTimeout(function () {
    $table_work_order.bootstrapTable('resetView');
  }, 200);

  $table_work_order.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias_work_order"));
  });

});

var url = window.location;

//check if redirct url
//http://devwika.test/index.php/contract/work_order_matgis/work_order_matgis
if(url=='<?php echo base_url() ?>index.php/contract_matgis/create_matgis/wo'){
  url='<?php echo base_url() ?>index.php/contract/work_order_matgis/work_order_matgis';
}
if(url=='<?php echo base_url() ?>index.php/contract_matgis/create_matgis/skbdn'){
  url='<?php echo base_url() ?>index.php/contract/work_order_matgis/skbdn';
}
if(url=='<?php echo base_url() ?>index.php/contract_matgis/create_matgis/si'){
  url='<?php echo base_url() ?>index.php/contract/work_order_matgis/shipping_instruction';
}
if(url=='<?php echo base_url() ?>index.php/contract_matgis/create_matgis/sppm'){
  url='<?php echo base_url() ?>index.php/contract/work_order_matgis/sppm';
}
if(url=='<?php echo base_url() ?>index.php/contract_matgis/create_matgis/bapb'){
  url='<?php echo base_url() ?>index.php/contract/work_order_matgis/bapb';
}
// for sidebar menu entirely but not cover treeview
$('ul.metismenu a').filter(function() {
  return this.href == url;
}).parent().addClass('active');

// for treeview
$('ul.metismenu a').filter(function() {
  return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

$("#hapus_file").click(function(){
  $("#matgis_file").attr("src", "");
  $.ajax({
    url: "contract/DeleteFile/"+$("#filename").val(),
    type: "post",
    data: {filename:$("#filename").val()} ,
    success: function (response) {
      alert("file dihapus");
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
})
// NOTE: Check SI Number Exisit or not
$("#si_number").focusout(function(e){
  $.ajax({
    url: "contract_matgis/number_exist/ctr_si_header/"+$("#si_number").val(),
    type: "post",
    success: function (response) {
      if(response=="true"){
        alert("NO SI sudah ada");
        $("#si_number").focus();
        $("#si_number").select();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
});

$("#transporter_id").change(function(){
  $.ajax({
    url: "contract_matgis/get_vendor_address/"+$("#transporter_id").val(),
    type: "post",
    success: function (response) {
      $("#transporter_address").val(response);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
});

</script>
