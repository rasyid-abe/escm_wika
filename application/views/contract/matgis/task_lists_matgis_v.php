<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">

    <div class="col-lg-12">

      <?php
      $mod= 'po';
      $title="Daftar Pekerjaan PO Matgis";
      include APPPATH.'views/contract/matgis/list_task_matgis_v.php';

      $mod= 'skbdn';
      $title="Daftar Pekerjaan SKBDN Matgis";
      include APPPATH.'views/contract/matgis/list_task_skbdn_v.php';

      $mod = 'si';
      $title="Daftar Pekerjaan Shipping Instruction";
      include APPPATH.'views/contract/matgis/list_task_si_v.php';


      $mod= 'sppm';
      $title="Daftar Pekerjaan SPPM";
      include APPPATH.'views/contract/matgis/list_task_sppm_v.php';

      $mod= 'approval_sppm';
      $title="Daftar Pekerjaan Approval SPPM";
      include APPPATH.'views/contract/matgis/list_task_approval_sppm_v.php';

      $mod= 'bapb';
      $title="Daftar Pekerjaan BAST";
      include APPPATH.'views/contract/matgis/list_task_bapb_v.php';


      $mod= 'inv';
      $title="Daftar Pekerjaan Tagihan";
      include APPPATH.'views/contract/matgis/list_task_inv_v.php';
      ?>

    </div>

  </div>

</div>

<script type="text/javascript">

 /** add active class and stay opened when selected */
var url = window.location;
//http://devwika.test/index.php/contract/work_order_matgis/task_lists_matgis
//check if redirct url
if(url=='<?php echo base_url()?>index.php/contract_matgis/task_lists'){
  url='<?php echo base_url()?>index.php/contract/work_order_matgis/task_lists_matgis';
}

// for sidebar menu entirely but not cover treeview
$('ul.metismenu a').filter(function() {
   return this.href == url;
}).parent().addClass('active');

// for treeview
$('ul.metismenu a').filter(function() {

   return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

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
