<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">

    <div class="col-lg-12">

      <?php
      $mod= 'po';
      $title="Monitoring Pekerjaan PO Matgis";
      include APPPATH.'views/contract/matgis/screens/monitor_po.php';

      $mod= 'skbdn';
      $title="Monitoring SKBDN Matgis";
      include APPPATH.'views/contract/matgis/screens/monitor_skbdn.php';

      $mod= 'si';
      $title="Monitoring SI";
      include APPPATH.'views/contract/matgis/screens/monitor_si.php';

      $mod= 'sppm';
      $title="Monitoring SPPM";
      include APPPATH.'views/contract/matgis/screens/monitor_sppm.php';

      $mod= 'do';
      $title="Monitoring Delivery Order";
      include APPPATH.'views/contract/matgis/screens/monitor_do.php';

      $mod= 'sj';
      $title="Monitoring Surat Jalan";
      include APPPATH.'views/contract/matgis/screens/monitor_sj.php';

      $mod= 'bapb';
      $title="Monitoring BAST";
      include APPPATH.'views/contract/matgis/screens/monitor_bapb.php';

      $mod= 'inv';
      $title="Monitoring Tagihan";
      include APPPATH.'views/contract/matgis/screens/monitor_inv.php';

      ?>

    </div>

  </div>

</div>

<script type="text/javascript">

 /** add active class and stay opened when selected */
var url = window.location;
//http://devwika.test/index.php/contract/work_order_matgis/task_lists_matgis
//check if redirct url

if(url=='<?php echo base_url()?>index.php/contract_matgis/monitor_matgis/reports'){
  url='<?php echo base_url()?>index.php/contract/work_order_matgis/work_order_matgis';
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
