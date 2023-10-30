<!-- start code hlmifzi -->
<div class="wrapper wrapper-content animated fadeInRight">
   <div class="row">
      <div class="col-lg-12">
         <div class="card float-e-margins">
            <div class="card-title">
               <h5>Laporan Perencanaan Pengadaan PMCS <?php echo date('Y') ?></h5>
               <div class="card-tools">
                  <a class="collapse-link">
                     <i class="fa fa-chevron-up"></i>
                  </a>
               </div>
            </div>

            <div class="card-content">

               <div class="row">
                  <div class="col-md-12">

                     <a href="<?php site_url();?>index.php/laporan/rekap_analisa/export_laporan_kebutuhan_pmcs/pdf" type="button"
                        class="btn btn-sm pull-right" data-toggle="tooltip" title="Export Laporan PDF" target="_blank"
                        style="background-color:red;color:white;margin-right:5px">
                        <i class="fa fa-file-pdf-o"></i> Export PDF
                     </a>

                     <a href="<?php site_url();?>index.php/laporan/rekap_analisa/export_laporan_kebutuhan_pmcs/excel" type="button"
                        class="btn btn-sm pull-right" data-toggle="tooltip" title="Export Laporan Excel" target="_blank"
                        style="background-color:green;color:white;margin-right:5px">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                     </a>
                  </div>
               </div>
               <div class="row">
                  <div class="table-responsive col-md-12">

                     <table id="daftar_kebutuhan_pmcs" class="table table-bordered table-striped"></table>

                  </div>
               </div>
            </div>
         </div>


      </div>
   </div>
</div>

<script type="text/javascript">
// $('.tgl_mulai_inp').datetimepicker({
//    format: "YYYY-MM-DD"
// })
$('.date').datetimepicker({
   format: "YYYY-MM-DD"
})


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

   var mydata = $.getCustomJSON("<?php echo site_url('Vendor') ?>/" + url);

   var html = [];
   $.each(row, function(key, value) {
      var data = $.grep(mydata, function(e) {
         return e.field == key;
      });

      if (typeof data[0] !== 'undefined') {

         html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
      }
   });

   return html.join('');

}

function operateFormatter(value, row, index) {
   var link = "<?php echo site_url('procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan/lihat') ?>";
   return [
      '<a target="_blank" class="btn btn-primary btn-xs action" href="' + link +'/'+ value +
      '">',
      'Detail</i>',
      '</a>  ',
   ].join('');
}
window.operateEvents = {
   'click .approval': function(e, value, row, index) {
      //alert('You click approval action, row: ' + JSON.stringify(row));
   },
   /*
   'click .remove': function (e, value, row, index) {
     $daftar_kebutuhan_pmcs.bootstrapTable('remove', {
       field: 'id',
       values: [row.id]
     });
   }
   */
};

function totalTextFormatter(data) {
   return 'Total';
}

function totalNameFormatter(data) {
   return data.length;
}

function totalPriceFormatter(data) {
   var total = 0;
   $.each(data, function(i, row) {
      total += +(row.price.substring(1));
   });
   return '$' + total;
}
</script>

<script type="text/javascript">
var $daftar_kebutuhan_pmcs = $('#daftar_kebutuhan_pmcs'),
   selections = [];
</script>

<script type="text/javascript">
$(function() {

   $daftar_kebutuhan_pmcs.bootstrapTable({

      url: "<?php echo site_url('procurement/data_perencanaan_pengadaan_pmcs') ?>",

      cookieIdTable: "prc_plan_integrasi",

      idField: "spk_code",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [{
        field: 'ppm_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        valign:'middle',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'dept_name',
        title: 'Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'25%',
      },
      {
        field: 'spk_code',
        title: 'Kode SPK',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'project_name',
        title: 'Nama Project',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      },
      {
        field: 'coa_code',
        title: 'Kode COA',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      },
       {
        field: 'coa_name',
        title: 'Nama COA',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'smbd_code',
        title: 'Kode Sumberdaya',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'5%',
      },
      {
        field: 'smbd_name',
        title: 'Nama Sumberdaya',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      }, 
      {
        field: 'smbd_quantity',
        title: 'Volume',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'unit',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      ]

   });
   setTimeout(function() {
      $daftar_kebutuhan_pmcs.bootstrapTable('resetView');
   }, 200);

   $daftar_kebutuhan_pmcs.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_daftar_seluruh_vendor"));
   });

});




$('input[type=checkbox][data-tipe=Active]').change(function() {
   if ($(this).is(':checked')) {
      $('.Active').addClass('checked');
   } else {
      $('.Active').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Inactive]').change(function() {
   if ($(this).is(':checked')) {
      $('.Inactive').addClass('checked');
   } else {
      $('.Inactive').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Suspended]').change(function() {
   if ($(this).is(':checked')) {
      $('.Suspended').addClass('checked');
   } else {
      $('.Suspended').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Blacklist]').change(function() {
   if ($(this).is(':checked')) {
      $('.Blacklist').addClass('checked');
   } else {
      $('.Blacklist').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Suplier]').change(function() {
   if ($(this).is(':checked')) {
      $('.Suplier').addClass('checked');
   } else {
      $('.Suplier').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Vendor]').change(function() {
   if ($(this).is(':checked')) {
      $('.Vendor').addClass('checked');
   } else {
      $('.Vendor').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Mandor').change(function() {
   if ($(this).is(':checked')) {
      $('.Mandor').addClass('checked');
   } else {
      $('.Mandor').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Subkon]').change(function() {
   if ($(this).is(':checked')) {
      $('.Subkon').addClass('checked');
   } else {
      $('.Subkon').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Pegawai]').change(function() {
   if ($(this).is(':checked')) {
      $('.Pegawai').addClass('checked');
   } else {
      $('.Pegawai').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Kecil').change(function() {
   if ($(this).is(':checked')) {
      $('.Kecil').addClass('checked');
   } else {
      $('.Kecil').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Menengah]').change(function() {
   if ($(this).is(':checked')) {
      $('.Menengah').addClass('checked');
   } else {
      $('.Menengah').removeClass('checked');
   }
});

$('input[type=checkbox][data-tipe=Besar]').change(function() {
   if ($(this).is(':checked')) {
      $('.Besar').addClass('checked');
   } else {
      $('.Besar').removeClass('checked');
   }
});

// $(document).ready(function() {
//    $(".columns").hide();
//    $('input[placeholder=Search]').hide();
// });


$(".refresh").on("click", function() {
   var url = "<?php echo site_url('laporan/clear_session_monitor_vendor') ?>";
   $.ajax({
      url: url,
      success: function(data) {
         $("#daftar_kebutuhan_pmcs").bootstrapTable('refresh');
      }
   });

})


$('.tgl_mulai_inp').on('dp.change', function(e) {
   var mulai = $(this).val();
   var url = "<?php echo site_url('laporan/set_session/tgl_awal') ?>";
   $.ajax({
      url: url + "/" + mulai,
      success: function(data) {
         $("#daftar_kebutuhan_pmcs").bootstrapTable('refresh');
      }
   });

});


$('.tgl_akhir_inp').on('dp.change', function(e) {
   var akhir = $(this).val();
   var url = "<?php echo site_url('laporan/set_session/tgl_akhir') ?>";
   $.ajax({
      url: url + "/" + akhir,
      success: function(data) {
         $("#daftar_kebutuhan_pmcs").bootstrapTable('refresh');
      }
   });

});

$('.vendor_name').on('keyup change', function(e) {
   var vendor_name = $(this).val();
   var url = "<?php echo site_url('laporan/set_session/vendor_name') ?>";
   $.ajax({
      url: url + "/" + vendor_name,
      success: function(data) {
         $("#daftar_kebutuhan_pmcs").bootstrapTable('refresh');
      }
   });

});

Active = "";
Inactive = "";
Suspended = "";
Blacklist = "";
Vendor = "";
Suplier = "";
Mandor = "";
Pegawai = "";
Subkon = "";
Kecil = "";
Menengah = "";
Besar = "";


$("input[name=jenis_status]").on('click', function(e) {
   if ($(this).prop("checked")) {
      jenis_status = $(this).val();
      if (jenis_status == "9") {
         Active = "9";
      } else if (jenis_status == "3") {
         Inactive = "3";
      } else if (jenis_status == "-2") {
         Suspended = "-2";
      } else if (jenis_status == "-3") {
         Blacklist = "-3";
      } else if (jenis_status == "s1") {
         Suplier = "1";
      } else if (jenis_status == "s2") {
         Vendor = "2";
      } else if (jenis_status == "s3") {
         Mandor = "3";
      } else if (jenis_status == "s4") {
         Subkon = "4";
      } else if (jenis_status == "s5") {
         Pegawai = "5";
      } else if (jenis_status == "kecil") {
         Kecil = "Kecil";
      } else if (jenis_status == "menengah") {
         Menengah = "Menengah";
      } else if (jenis_status == "besar") {
         Besar = "Besar";
      }

      $('#daftar_kebutuhan_pmcs').bootstrapTable('refresh', {
         url: "<?php echo site_url('Laporan/data_lap_klasifikasi_vendor') ?>?Active=" + Active +
            "&Inactive=" + Inactive +
            "&Suspended=" + Suspended +
            "&Blacklist=" + Blacklist +
            "&Suplier=" + Suplier +
            "&Vendor=" + Vendor +
            "&Mandor=" + Mandor +
            "&Subkon=" + Subkon +
            "&Pegawai=" + Pegawai +
            "&Kecil=" + Kecil +
            "&Menengah=" + Menengah +
            "&Besar=" + Besar,
      });
   } else {
      jenis_status = $(this).val();
      if (jenis_status == "9" && $(this).prop("checked", false)) {
         Active = "";
      } else if (jenis_status == "3" && $(this).prop("checked", false)) {
         Inactive = "";
      } else if (jenis_status == "-2" && $(this).prop("checked", false)) {
         Suspended = "";
      } else if (jenis_status == "-3" && $(this).prop("checked", false)) {
         Blacklist = "";
      } else if (jenis_status == "s1" && $(this).prop("checked", false)) {
         Suplier = "";
      } else if (jenis_status == "s2" && $(this).prop("checked", false)) {
         Vendor = "";
      } else if (jenis_status == "s3" && $(this).prop("checked", false)) {
         Mandor = "";
      } else if (jenis_status == "s4" && $(this).prop("checked", false)) {
         Subkon = "";
      } else if (jenis_status == "s5" && $(this).prop("checked", false)) {
         Pegawai = "";
      } else if (jenis_status == "kecil" && $(this).prop("checked", false)) {
         Kecil = "";
      } else if (jenis_status == "menengah" && $(this).prop("checked", false)) {
         Menengah = "";
      } else if (jenis_status == "besar" && $(this).prop("checked", false)) {
         Besar = "";
      }
      $('#daftar_kebutuhan_pmcs').bootstrapTable('refresh', {
         url: "<?php echo site_url('Laporan/data_lap_klasifikasi_vendor') ?>?Active=" + Active +
            "&Inactive=" + Inactive +
            "&Suspended=" + Suspended +
            "&Blacklist=" + Blacklist +
            "&Suplier=" + Suplier +
            "&Vendor=" + Vendor +
            "&Mandor=" + Mandor +
            "&Subkon=" + Subkon +
            "&Pegawai=" + Pegawai +
            "&Kecil=" + Kecil +
            "&Menengah=" + Menengah +
            "&Besar=" + Besar,
      });
   }

});
</script>