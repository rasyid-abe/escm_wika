<style media="screen">
.label-success, .badge-success {
  background-color: #5b9c1f;
  color: #FFFFFF;
}
</style>
<div class="card float-e-margins">
  <div class="card-title">
    <h5><?php echo $title ?></h5>
    <div class="card-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>
  </div>
  <div class="card-content">
    <div class="table-responsive">
      <table id="table_pekerjaan_<?php echo $mod ?>" class="table table-bordered table-striped"></table>
    </div>
  </div>
</div>

<script type="text/javascript">

function <?php echo $mod ?>_act_matgis(value, row, index) {
  var link = "<?php echo site_url('contract_matgis') ?>";
  var butt='Lihat';
  var par="";
  return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/process_matgis/<?php echo $mod ?>/'+value+'/2">',
    butt,
    '</a>  ',
  ].join('');
}


function stat_format(value,row,index){
  return ['<span class="label label-success">'+value+'</span>'].join();
}
var $table_pekerjaan_<?php echo $mod ?>= $('#table_pekerjaan_<?php echo $mod ?>');
var selections = [];

$(function () {

  $table_pekerjaan_<?php echo $mod ?>.bootstrapTable({

    url: "<?php echo site_url('data_matgis/monitoring_task_matgis/' . $mod ) ?>",
    cookieIdTable:"monitoring_pekerjaan_<?php echo $mod ?>",
    idField:"<?php echo $mod ?>_id",
    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
    columns: [
      {
        field: "do_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: <?php echo $mod ?>_act_matgis,
      },
      {
        field: 'contract_number',
        title: 'Nomor Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',

      },
      {
        field: 'wo_number',
        title: 'Nomor PO',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',

      },
      {
        field: 'si_number',
        title: 'Nomor SI',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',

      },
      {
        field: 'sppm_number',
        title: 'Nomor SPPM',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',

      },
      {
        field: 'do_number',
        title: 'Nomor DO',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',

      },
      {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'current_approver_pos',
        title: 'Posisi Terakhir',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'awa_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        formatter: stat_format,
      },

    ]

  });
  setTimeout(function () {
    $table_pekerjaan_<?php echo $mod ?>.bootstrapTable('resetView');
  }, 200);

  $table_pekerjaan_<?php echo $mod ?>.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias_wo"));
  });

});
/** add active class and stay opened when selected */
/** add active class and stay opened when selected */
var url = window.location;

//check if redirct url
if(url=='<?php echo base_url() ?>index.php/contract_matgis/task_lists'){
  url='<?php echo base_url() ?>index.php/contract/work_order_matgis/task_list_matgis';
}

// for sidebar menu entirely but not cover treeview
$('ul.metismenu a').filter(function() {
  return this.href == url;
}).parent().addClass('active');

// for treeview
$('ul.metismenu a').filter(function() {

  return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
</script>
