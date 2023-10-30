<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Generate Bidder List</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <?php /*
        <div class="card-content">
          <form method="get" class="form-horizontal">
            <div class="form-group">

             <?php $curval = $klasifikasi_gbl; ?>
             <label class="col-md-2 control-label">Klasifikasi</label>
             <div class="col-md-2">
               <select name="klasifikasi" id="klasifikasi" class="form-control">
                <option value="">Semua</option>
                <?php $pilihan=array(
                  "K" => 'Kecil',
                  "M" => 'Menengah',
                  "B" => 'Besar',
                  );
                foreach($pilihan as $key => $val){
                  $selected = ($key == $curval) ? "selected" : ""; 
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

           <div class="form-group">
            <label class="col-sm-2 control-label">Item</label>
            <div class="col-sm-6">
              <div class="input-group">
                <span class="input-group-btn">
                 <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_BARANG_PATH.'/picker') ?>" class="btn btn-primary picker barang_btn">Barang</button> 
                 <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_JASA_PATH.'/picker') ?>" class="btn btn-primary picker jasa_btn">Jasa</button> 
               </span>
               <?php $curval = $this->session->userdata("item_gbl"); ?>
               <input type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">

             </div>

           </div>

         </div>

         <div class="form-group">
           <?php $curval = $kantor_gbl; ?>
           <label class="col-md-2 control-label">Kantor</label>
           <div class="col-md-4">
             <select name="kantor" id="kantor" class="form-control">
              <option value="">--Pilih--</option>
              <?php $pilihan=$kantor;
              foreach($pilihan as $key => $val){
                $selected = ($val['district_code'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['district_code'] ?>"><?php echo $val['district_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </form>

        <div class="table-responsive">            

          <table id="generate_bidder_list" class="table table-bordered table-striped"></table>

        </div>

        <div class="table-responsive">            

          <table id="generate_bidder_list" class="table table-bordered table-striped"></table>

        </div>

      </div>
 */ ?>
        <div class="card-content">
          <form method="get" class="form-horizontal">
            <div class="form-group">
              <?php $curval = isset($tipe_gbl) ? "" : ""; ?>
              <label class="col-md-1 control-label">Tipe</label>
              <div class="col-md-2">
                <select name="tipe" id="tipe" class="form-control">
                  <?php $pilihan = array(
                    "unspsc" => 'UNSPSC',
                    "smbd" => 'Sumberdaya'
                  );
                  foreach ($pilihan as $key => $val) {
                    $selected = ($key == $curval) ? "selected" : "";
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                  <?php } ?>
                </select>
              </div>
              <?php $curval = $klasifikasi_gbl; ?>
              <label class="col-md-1 control-label">Klasifikasi</label>
              <div class="col-md-2">
                <select name="klasifikasi" id="klasifikasi" class="form-control">
                  <option value="">Semua</option>
                  <?php $pilihan = array(
                    "K" => 'Kecil',
                    "M" => 'Menengah',
                    "B" => 'Besar',
                  );
                  foreach ($pilihan as $key => $val) {
                    $selected = ($key == $curval) ? "selected" : "";
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">Kode</label>
              <div class="col-sm-7">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" id="klir" name="klir" class="btn btn-danger">Semua</button>
                    <button type="button" id="btn_brg" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_GRUP_BARANG_PATH . '/picker') ?>" class="btn btn-primary picker barang_btn">Pilih Grup Barang</button>
                    <button type="button" id="btn_jasa" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_GRUP_JASA_PATH . '/picker') ?>" class="btn btn-primary picker jasa_btn">Pilih Grup Jasa</button>
                    <button type="button" id="btn_matgis" data-id="kode_item" data-url="<?php echo site_url('commodity/katalog/grup_matgis/picker') ?>" class="btn btn-primary picker">Pilih Grup Matgis</button>
                  </span>
                  <?php $curval = $item_gbl; ?>
                  <input type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">
                </div>

              </div>
              <?php $curval = $kantor_gbl; ?>
              <label class="col-md-1 control-label" style="display: none;">Kantor</label>
              <div class="col-md-3" style="display: none;">
                <select name="kantor" id="kantor" class="form-control select2">
                  <option value="">Pilih</option>
                  <?php
                  foreach ($kantor as $key => $val) {
                    $selected = ($val['district_id'] == $curval) ? "selected" : "";
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_name'] ?></option>
                  <?php } ?>
                </select>
              </div>


            </div>
          </form>
        </div>
        <div class="card-content">
          <!-- <div class="row">
          <div class="col-md-12">
                <btn data-url="<?php echo site_url(); ?>/laporan/laporanPdfDetail" data-tipe="rekap"
                  class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan PDF" target="_blank"
                  style="background-color:red;color:white;margin-right:5px">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </btn>

                <btn data-url="<?php echo site_url(); ?>/laporan/laporanExcelDetail" data-tipe="rekap"
                  class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan Excel" target="_blank"
                  style="background-color:green;color:white;margin-right:5px">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </btn>
            </div>
          </div> -->
          <div class="table-responsive">

            <table id="generate_bidder_list" class="table table-bordered table-striped"></table>

          </div>

        </div>

      </div>


    </div>
  </div>
</div>

<script type="text/javascript">
  var searchDetail
  var searchRekap
  var method = 0

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
      '<a target="_blank" class="btn btn-primary btn-xs action" target="_blank" href="' + link + '/lihat_detail_vendor/' + value + '">',
      'Lihat',
      '</a>  ',
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function(e, value, row, index) {
      //alert('You click approval action, row: ' + JSON.stringify(row));
    },
    /*
    'click .remove': function (e, value, row, index) {
      $generate_bidder_list.bootstrapTable('remove', {
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
  var $generate_bidder_list = $('#generate_bidder_list'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {
    var vnd_type = '';
    $("#btn_matgis").hide()

    $("#tipe").change(function() {

      if ($(this).val() == 'unspsc') {
        $("#btn_matgis").hide()
        $("#btn_brg").attr("data-url", "<?php echo site_url(COMMODITY_GRUP_BARANG_PATH . '/picker') ?>");
        $("#btn_jasa").attr("data-url", "<?php echo site_url(COMMODITY_GRUP_BARANG_PATH . '/picker') ?>");
        reset_session();
      } else if ($(this).val() == 'smbd') {

        $("#btn_matgis").show()
        $("#btn_brg").attr("data-url", "<?php echo site_url(COMMODITY_GRUP_BARANG_PATH . '_sumberdaya/picker') ?>");
        $("#btn_jasa").attr("data-url", "<?php echo site_url(COMMODITY_GRUP_BARANG_PATH . '_sumberdaya/picker') ?>");
        reset_session("smbd");
      }
    });

    function reset_session(tipe = "") {

      var url1 = "<?php echo site_url('procurement/set_session/item_gbl') ?>";
      $.ajax({
        url: url1,
        success: function(data) {

          var url2 = "<?php echo site_url('procurement/set_session/klasifikasi_gbl') ?>";
          $.ajax({
            url: url2,
            success: function(data) {

              var url3 = "<?php echo site_url('procurement/set_session/kantor_gbl') ?>";
              $.ajax({
                url: url3,
                success: function(data) {
                  if (tipe != '') {
                    $("#generate_bidder_list").bootstrapTable('refresh', {
                      url: "<?php echo site_url('Vendor/data_generate_bidder_list?tipe=smbd') ?>"
                    });
                  } else {
                    $("#generate_bidder_list").bootstrapTable('refresh', {
                      url: "<?php echo site_url('Vendor/data_generate_bidder_list') ?>"
                    });
                  }

                }
              });

            }
          });
        }
      });

      $('#kode_item').val('');
    }

    $("#klir").click(function() {
      window.location.assign('<?php echo site_url('vendor/daftar_vendor/generate_bidder_list/1'); ?>');
    });

    $("#kode_item").change(function() {

      var myfilter = $(this).val();
      var url = "<?php echo site_url('procurement/set_session/item_gbl') ?>";
      $.ajax({
        url: url + "/" + myfilter,
        success: function(data) {
          $("#generate_bidder_list").bootstrapTable('refresh');
        }
      });

    });

    $("#klasifikasi").change(function() {

      var myfilter = $(this).val();
      method = myfilter
      var url = "<?php echo site_url('procurement/set_session/klasifikasi_gbl') ?>";
      $.ajax({
        url: url + "/" + myfilter,
        success: function(data) {
          $("#generate_bidder_list").bootstrapTable('refresh');
        }
      });

    });

    $("#kantor").change(function() {

      var myfilter = $(this).val();
      var url = "<?php echo site_url('procurement/set_session/kantor_gbl') ?>";
      $.ajax({
        url: url + "/" + myfilter,
        success: function(data) {
          $("#generate_bidder_list").bootstrapTable('refresh');
        }
      });

    });

    $generate_bidder_list.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_generate_bidder_list') ?>",

      cookieIdTable: "vw_prc_bidder_list",

      idField: "vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [{
          field: 'vendor_id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
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
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'win',
          title: 'Win',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'invited',
          title: 'Invited',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'reg',
          title: 'Reg',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'quote',
          title: 'Quote',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'reg_status_name',
          title: 'Status',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
      ]

    });
    setTimeout(function() {
      $generate_bidder_list.bootstrapTable('resetView');
    }, 200);

    $generate_bidder_list.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_generate_bidder_list"));
    });


    $generate_bidder_list.on('search.bs.table', function(e, text) {
      searchDetail = text
      // console.log(searchDetail)
    })



  });



  $('.btnExport').click(function() {

    var url = $(this).attr("data-url")
    var tipe = $(this).attr("data-tipe")
    var search = ""
    var column
    var data
    var limit = $generate_bidder_list.bootstrapTable('getOptions').pageSize
    var rawOffset = $generate_bidder_list.bootstrapTable('getOptions').pageNumber
    var offset = limit * (rawOffset - 1)

    if (tipe == 'rekap') {
      search = searchRekap
    } else {
      search = searchDetail
    }

    if (search == undefined) {
      search = ""
    }
    // column = JSON.stringify(column)
    // data = {
    //   search: search,
    //   // column: column,
    //   metode: method
    // }

    // data = JSON.stringify(data)

    window.open(url + '/bidderlist/' + method + '?limit=' + limit + "&offset=" + offset, '_blank');


  })
</script>