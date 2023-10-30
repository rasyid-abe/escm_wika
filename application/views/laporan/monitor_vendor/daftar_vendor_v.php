<!-- start code hlmifzi -->
<div class="wrapper wrapper-content animated fadeInRight">
   <div class="row">

      <div class="col-lg-12">
         <div class="card float-e-margins p-4">
            <div class="card-title">
               <h5>Klasifikasi Vendor</h5>
               <div class="card-tools">
                  <a class="collapse-link">
                     <i class="fa fa-chevron-up"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-user">
                     <li><a href="#">Config option 1</a>
                     </li>
                     <li><a href="#">Config option 2</a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="card-content">
               <div class="form-group">
                  <div class="row">
                     <label class="col-sm-2 control-label">Tanggal Registrasi</label>
                     <div class="col-sm-4">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                           <input type="text" name="tgl_mulai_inp" class="form-control tgl_mulai_inp date">
                        </div>
                     </div>
                     <div class="col-sm-4 date">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                           <input type="text" name="tgl_akhir_inp" class="form-control tgl_akhir_inp date">
                        </div>
                     </div>
                  </div>
               </div>

               <div class="form-group">
                  <div class="row">
                     <label class="col-sm-2 control-label">Nama Vendor</label>
                     <div class="col-sm-4">
                        <input type="text" name="vendor_name" class="form-control vendor_name">
                     </div>
                  </div>
               </div>

               <div class="row" style="margin-top: 20px">

                  <label class="col-sm-2 control-label">Jenis Status</label>
                  <div class="col-sm-10">
                     <div class="i-checks col-lg-3">
                        <label class="">
                           <div class="iradio_square-green Active" style="position: relative;">
                              <input type="checkbox"
                                 value="9" name="jenis_status" id="tipe" data-tipe="Active"
                                 style="position: absolute; opacity: 0;">
                                 <ins class="iCheck-helper"
                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                           </div> <i></i>&nbsp;&nbsp; Active
                        </label>
                     </div>

                     <div class="i-checks col-lg-3">
                        <label class="">
                           <div class="iradio_square-green Inactive" style="position: relative;"><input type="checkbox"
                                 value="3" name="jenis_status" id="tipe" data-tipe="Inactive"
                                 style="position: absolute; opacity: 0;"><ins class="iCheck-helper"
                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                           </div> <i></i>&nbsp;&nbsp; Inactive
                        </label>
                     </div>

                     <div class="i-checks col-lg-3">
                        <label class="">
                           <div class="iradio_square-green Suspended" style="position: relative;"><input type="checkbox"
                                 value="-2" name="jenis_status" id="tipe" data-tipe="Suspended"
                                 style="position: absolute; opacity: 0;"><ins class="iCheck-helper"
                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                           </div> <i></i>&nbsp;&nbsp; Suspended
                        </label>
                     </div>

                     <div class="i-checks col-lg-3">
                        <label class="">
                           <div class="iradio_square-green Blacklist" style="position: relative;"><input type="checkbox"
                                 value="-3" name="jenis_status" id="tipe" data-tipe="Blacklist"
                                 style="position: absolute; opacity: 0;"><ins class="iCheck-helper"
                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                           </div> <i></i>&nbsp;&nbsp; Blacklist
                        </label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>




      <div class="col-lg-12">
         <div class="card float-e-margins p-4">
            <div class="card-title">
               <h5>Monitoring Vendor</h5>
               <div class="card-tools">
                  <a class="collapse-link">
                     <i class="fa fa-chevron-up"></i>
                  </a>
               </div>
            </div>

            <div class="card-content">

               <div class="row">
                  <div class="col-md-12">
                     <a type="button" class="btn btn-sm btn-default pull-right refresh" data-toggle="tooltip"
                        title="Refresh" target="_blank" style="color:white;margin-right:5px">
                        <i class="fa fa-refresh"></i>
                     </a>

                     <a href="<?php site_url();?>index.php/laporan/laporan_pdf_stat_vend" type="button"
                        class="btn btn-sm pull-right" data-toggle="tooltip" title="Export Laporan PDF" target="_blank"
                        style="background-color:red;color:white;margin-right:5px">
                        <i class="fa fa-file-pdf-o"></i> Export PDF
                     </a>

                     <a href="<?php site_url();?>index.php/laporan/laporan_excel_vendor_status" type="button"
                        class="btn btn-sm pull-right" data-toggle="tooltip" title="Export Laporan Excel" target="_blank"
                        style="background-color:green;color:white;margin-right:5px">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                     </a>
                  </div>
               </div>
               <div class="row">
                  <div class="table-responsive col-md-12">

                     <table id="daftar_seluruh_vendor" class="table table-bordered table-striped"></table>

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
   var link = "<?php echo site_url('vendor/daftar_vendor') ?>";
   return [
      '<a target="_blank" class="btn btn-primary btn-xs action" href="' + link + '/lihat_detail_vendor/' + value +
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
     $daftar_seluruh_vendor.bootstrapTable('remove', {
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
var $daftar_seluruh_vendor = $('#daftar_seluruh_vendor'),
   selections = [];
</script>

<script type="text/javascript">
$(document).ready(function() {
      
$(function() {

   $daftar_seluruh_vendor.bootstrapTable({

      url: "<?php echo site_url('Laporan/data_monior_vendor_laporan') ?>",

      cookieIdTable: "vnd_header",

      idField: "vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [{
            field: 'vendor_id',
            title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
            align: 'center',
            valign: 'middle',
            width: '10%',
            events: operateEvents,
            formatter: operateFormatter,
         },
         {
            field: 'vendor_name',
            title: 'Nama Vendor',
            sortable: true,
            order: true,
            searchable: true,
            align: 'left',
            valign: 'middle'
         },
         //start code hlmifzi
         {
            field: 'reg_status_name',
            title: 'Status',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
         },
         {
            field: 'end_date',
            title: 'Aktif / Pasif Berkontrak',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
         },
         {
            field: 'vc_start_date',
            title: 'Tanggal Registrasi',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
         },
      ]

   });
   setTimeout(function() {
      $daftar_seluruh_vendor.bootstrapTable('resetView');
   }, 200);

   $daftar_seluruh_vendor.on('expand-row.bs.table', function(e, index, row, $detail) {
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

$(document).ready(function() {
   $(".columns").hide();
   $('input[placeholder=Search]').hide();
});


$(".refresh").on("click", function() {
   var url = "<?php echo site_url('laporan/clear_session_monitor_vendor') ?>";
   $.ajax({
      url: url,
      success: function(data) {
         $("#daftar_seluruh_vendor").bootstrapTable('refresh');
      }
   });

})


$('.tgl_mulai_inp').on('dp.change', function(e) {
   var mulai = $(this).val();
   var url = "<?php echo site_url('laporan/set_session/tgl_awal') ?>";
   $.ajax({
      url: url + "/" + mulai,
      success: function(data) {
         $("#daftar_seluruh_vendor").bootstrapTable('refresh');
      }
   });

});


$('.tgl_akhir_inp').on('dp.change', function(e) {
   var akhir = $(this).val();
   var url = "<?php echo site_url('laporan/set_session/tgl_akhir') ?>";
   $.ajax({
      url: url + "/" + akhir,
      success: function(data) {
         $("#daftar_seluruh_vendor").bootstrapTable('refresh');
      }
   });

});

$('.vendor_name').on('keyup change', function(e) {
   var vendor_name = $(this).val();
   var url = "<?php echo site_url('laporan/set_session/vendor_name') ?>";
   $.ajax({
      url: url + "/" + vendor_name,
      success: function(data) {
         $("#daftar_seluruh_vendor").bootstrapTable('refresh');
      }
   });

});

Active = "";
Inactive = "";
Suspended = "";
Blacklist = "";

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
      }

      $('#daftar_seluruh_vendor').bootstrapTable('refresh', {
         url: "<?php echo site_url('Laporan/data_monior_vendor_laporan') ?>?Active=" + Active +
            "&Inactive=" + Inactive +
            "&Suspended=" + Suspended +
            "&Blacklist=" + Blacklist,
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
      }
      $('#daftar_seluruh_vendor').bootstrapTable('refresh', {
         url: "<?php echo site_url('Laporan/data_monior_vendor_laporan') ?>?Active=" + Active +
            "&Inactive=" + Inactive +
            "&Suspended=" + Suspended +
            "&Blacklist=" + Blacklist,
      });
   }

});

   var getUrlParameter = function getUrlParameter(sParam) {
       var sPageURL = window.location.search.substring(1),
           sURLVariables = sPageURL.split('&'),
           sParameterName,
           i;

       for (i = 0; i < sURLVariables.length; i++) {
           sParameterName = sURLVariables[i].split('=');

           if (sParameterName[0] === sParam) {
               return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
           }
       }
   };
   
   setTimeout(function() {
      if (getUrlParameter('status') != '') {

         let status_params = getUrlParameter('status');
         let status_val = $('[data-tipe='+status_params+']').val();
         $("input[name=jenis_status][data-tipe="+status_params+"]").trigger('click');

      }
   }, 500);
   


     });

</script>