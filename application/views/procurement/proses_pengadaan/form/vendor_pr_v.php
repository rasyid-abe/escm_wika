<section>		
  <div class="row" id="vendor_container">
    <div class="col-12">
      <div class="card">
        
        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Daftar Vendor</h4>          
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-8">
                <p class="text-bold-700 m-0">Klasifikasi Peserta</p>                
                <i>&nbsp;</i>
                <div class="row" id="klasifikasi_peserta_cont">                  
                  <div class="card m-0 shadow col-md-3 mr-3">
                    <div class="card-body" style="padding: 15px">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="klasifikasi_kecil_inp" name="klasifikasi_kecil_inp" value="1">
                        <label class="custom-control-label" for="klasifikasi_kecil_inp">Kecil</label>
                      </div>
                    </div>
                  </div>        
               
                  <div class="card m-0 shadow col-md-3 mr-3">
                    <div class="card-body" style="padding: 15px">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="klasifikasi_menengah_inp" name="klasifikasi_menengah_inp" value="1">                        
                        <label class="custom-control-label" for="klasifikasi_menengah_inp">Menengah</label>
                      </div>
                    </div>
                  </div>
                                             
                  <div class="card m-0 shadow col-md-3 mr-3">
                    <div class="card-body" style="padding: 15px">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="klasifikasi_besar_inp" name="klasifikasi_besar_inp" value="1">
                        <label class="custom-control-label" for="klasifikasi_besar_inp">Besar</label>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>                        

            <div class="table-responsive">

              <table id="daftar_vendor" class="table table-bordered table-striped"></table>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

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

<script type="text/javascript">

  var $daftar_vendor = $('#daftar_vendor'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $("input[name='vendor_district']").change(function(){

      var val = $(this).val();
      $.ajax({
        url:"<?php echo site_url('procurement/set_session/selection_district') ?>/"+val,
        success:function(){
            $daftar_vendor.bootstrapTable('refresh');
        }
      })
      
    });

    $daftar_vendor.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_vendor_pr') ?>",
      selectItemName:"vendor_tender[]",

      cookieIdTable:"vendor_tender",

      idField:"vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      {
        field: 'checkbox',
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
        field: 'total_kontrak',
        title: 'Kontrak Aktif',
        sortable:true,
        order:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'total_tender',
        title: 'Tender Berjalan',
        sortable:true,
        order:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'address_city',
        title: 'Lokasi',
        sortable:true,
        order:true,
        align: 'center',
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
      ]

    });
    setTimeout(function () {
      $daftar_vendor.bootstrapTable('resetView');
    }, 200);

    $daftar_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

    $daftar_vendor.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('Procurement/selection/selection_vendor_tender') ?>",
        data:param,
        type:"get"
      });

    });
    $daftar_vendor.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('Procurement/selection/selection_vendor_tender') ?>",
        data:param,
        type:"get"
      });
    });
    $daftar_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });
    $daftar_vendor.on('all.bs.table', function (e, name, args) {});

    function getIdSelections() {
      return $.map($daftar_vendor.bootstrapTable('getSelections'), function (row) {
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

  function filtervendor(){
        var kecil = $("#klasifikasi_kecil_inp").prop("checked");
        var menengah = $("#klasifikasi_menengah_inp").prop("checked");
        var besar = $("#klasifikasi_besar_inp").prop("checked");
        var filtering = ["K","M","B"];
        var myfilter = "";
        var index = 0;
        if(!kecil){
            index = filtering.indexOf("K");
            if (index > -1) {
                myfilter += "";
                filtering.splice(index, 1);
            }
            $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Kecil"]})
        } else {
            myfilter += "K_";
        }
        if(!menengah){
            index = filtering.indexOf("M");
            if (index > -1) {
                myfilter += "";
                filtering.splice(index, 1);
            }
            $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Menengah"]})
        } else {
            myfilter += "M_";
        }
        if(!besar){
            index = filtering.indexOf("B");
            if (index > -1) {
                myfilter += "";
                filtering.splice(index, 1);
            }
            $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Besar"]})
        } else {
            myfilter += "B_";
        }

        var url = "<?php echo site_url('Procurement/set_session/klasifikasi') ?>";

        $.ajax({
            url : url+"/"+myfilter,
            success:function(data){
                // $("#daftar_vendor").bootstrapTable('destroy');
                $("#daftar_vendor").bootstrapTable('refresh');

                setTimeout(function () {
                    $("#daftar_vendor").bootstrapTable('resetView');
                }, 200);
            }
        });

    }

    $(document).ready(function(){
        window.setTimeout(function(){
            filtervendor();
            check_metode();
        },3000);


        $("#klasifikasi_kecil_inp,#klasifikasi_menengah_inp,#klasifikasi_besar_inp").click(function(e){
            filtervendor();
        });

        if ($('#template_evaluasi_inp').val() == '') {
            $('#klasifikasi_kecil_inp').prop( "checked", true );
            filtervendor();
        }
    });

</script>