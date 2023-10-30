<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
       <div class="card float-e-margins">
      
      <?php 
        include 'daftar_pekerjaan/daftar_pekerjaan_aktivasi.php';
        include 'daftar_pekerjaan/daftar_pekerjaan_verifikasi.php';
        include 'daftar_pekerjaan/daftar_pekerjaan_suspend.php';
        include 'daftar_pekerjaan/daftar_pekerjaan_suspend_com.php';
        include 'daftar_pekerjaan/daftar_pekerjaan_blacklist.php';
      ?>

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

    var mydata = $.getCustomJSON("<?php echo site_url('Vendor') ?>/"+url);

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

  function operateFormatterAktivasi(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/vendor_tools/aktivasi_vendor_form/'+value+'">',
    'Proses',
    '</a>  '
    ].join('');
  }

  function operateFormatterVerifikasiDocPQ(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/vendor_tools/verifikasi_dokumen_pq/'+value+'">',
    'Proses',
    '</a>  '
    ].join('');
  }

  function operateFormatterSuspend(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_vendor_form/'+value+'">',
    'Proses Suspend',
    '</a>  '
    ].join('');
  }

  function operateFormatterSuspendCommodity(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_vendor_commodity_form/'+value+'">',
    'Proses Suspend Commodity',
    '</a>  '
    ].join('');
  }

  function operateFormatterBlacklist(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_blacklist_vendor_form/'+value+'">',
    'Proses Blacklist',
    '</a>  '
    ].join('');
  }
  
  function operateFormatterVerifikasi(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_verifikasi_form/'+value+'">',
    'Verifikasi',
    '</a>  '
    ].join('');
  }
  
  function operateFormatterSetujuSurvei(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_persetujuan_survei_form/'+value+'">',
    'Proses',
    '</a>  '
    ].join('');
  }
  function operateFormatterHasilSurvei(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_hasil_survei_form/'+value+'">',
    'Proses',
    '</a>  '
    ].join('');
  }

  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $daftar_pekerjaan_vendor.bootstrapTable('remove', {
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
  $.each(data, function (i, row) {
    total += +(row.price.substring(1));
  });
  return '$' + total;
}

</script>

<script type="text/javascript">

  var $daftar_pekerjaan_vendor = $('#daftar_pekerjaan_vendor'),
      $daftar_pekerjaan_vendor_aktivasi = $('#aktivasi_vendor'),
      $suspend_commodity_vendor = $('#suspend_commodity_vendor'),
      $blacklist_vendor = $('#blacklist_vendor'),
      $daftar_pekerjaan_verifikasi = $('#verifikasi_vendor'),
      $daftar_pekerjaan_persetujuan_survei = $('#persetujuan_survei'),
      $daftar_pekerjaan_hasil_survei = $('#hasil_survei'),
  selections = [];

</script>
