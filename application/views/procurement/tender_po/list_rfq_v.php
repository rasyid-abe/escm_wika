 
  <div class="row">
    <div class="col-12">
      <div class="card">        
        <div class="card-header border-bottom pb-2">
            <span class="card-title float-left text-bold">Daftar Pekerjaan RFQ-Undangan</span>
            <span class="float-right">
              <a href="<?php echo site_url('contract/manual_sap/pl'); ?>" class="btn btn-info btn-sm" target="_blank" title="Pembelian Langsung"><i class="ft-plus"></i> Pembelian Langsung</a>
            </span>
        </div>
        <div class="card-content">
          <div class="card-body">
              <div class="table-responsive">
                  <table id="table_pekerjaan_rfq_sap" class="table table-bordered table-striped"></table>
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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/proses/'+value+'">',
    'Proses',
    '</a>  ',
  ].join('');
}

 function operateFormatter2(value, row, index) {
    var link = "<?php echo site_url('Sap/Report_po') ?>";
    return [
    '<a class="btn btn-info btn-xs action" target="_blank" href="'+link+'/'+value+'">',
    'Cetak PO',
    '</a>  ',
  ].join('');
}



 function operateFormatter3(value, row, index) {
   var link = "<?php echo site_url('procurement/perencanaan_pengadaan/rekapitulasi_perencanaan_pengadaan') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/approval/'+value+'">',
    'Proses',
    '</a>',

  ].join('');
}

  function operateFormatter4(value, row, index) {
    var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/proses/'+value+'">',
    'Proses',
    '</a>  ',
  ].join('');
}

function operateFormatter5(value, row, index) {
    var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
    //console.log(row);
    if(value != null)
    {
        return [
      '<a class="btn btn-info btn-xs" onclick=fGeneratePoNumber("'+value+'") >',
      'Sync',
      '</a>  ',
    ].join('');
    } else {
      return [
        '-',
  ].join('');
    }
    
}

function fGeneratePoNumber(filename) {
        var url = '<?php echo site_url()."/Sap/update_po_number/"; ?>';
			$.ajax({
	            type: "GET",
	            url: url+filename,
	            dataType: "JSON",
	            success: function (response) {
					// $(`#myLoader`).modal('hide');
	                if(response.status == "SUCCESS"){
	                    alert("update po number berhasil !");
	                } else {
	                    alert(response.message);
	                }
	            }
	        });
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

  var 
  $table_pekerjaan_rfq_sap = $('#table_pekerjaan_rfq_sap');


</script>



<script type="text/javascript">

  $(function () {

  
$table_pekerjaan_rfq_sap.bootstrapTable({
url: "<?php echo site_url('Procurement/data_pekerjaan_rfq_sap_po') ?>",
cookieIdTable:"daftar_pekerjaan_rfq",
idField:"ptc_id",
<?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
columns: [
  {
    field: 'ptm_number',
    title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
    align: 'center',
    width:'10%',
    valign: 'middle',
    formatter: operateFormatter2,
  },
  {
    field: 'ctr_po_number',
    title: 'NO. PO',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
  },
  {
    field: 'ptm_number',
    title: 'No. Tender',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
  },

  {
    field: 'vendor_name',
    title: 'Nama Vendor',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
  },
  {
    field: 'ptm_requester_name',
    title: 'User',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
  }, 
  {
    field: 'ptm_subject_of_work',
    title: 'Nama Rencana Pengadaan',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle',
  },
  {
    field: 'ptm_packet',
    title: 'Nama Paket',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle',
  },
  {
    field: 'jenis_pengadaan',
    title: 'Jenis Pengadaan',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle',
  },
  {
    field: 'activity',
    title: 'Aktifitas',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
  },
  {
    field: 'status_po',
    title: 'Status',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
  },
  {
    field: 'waktu',
    title: 'Waktu',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
  },
]

});
setTimeout(function () {
$table_pekerjaan_rfq.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_rfq.on('expand-row.bs.table', function (e, index, row, $detail) {
$detail.html(detailFormatter(index,row,"alias_rfq"));
});

});

</script>
