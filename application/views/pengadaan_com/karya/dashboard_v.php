
<div class="card">
    <div class="card-body">
        <div class="form_dt_search mb-2" id="form_dt_search">
      		<label>Filter Dashboard Summary</label>
      		<form method="GET" action="<?= base_url() ?>pengadaan_com/karya">
      		    <div class="row">
                  <div class="form-group col-md-3">
                  <input class="form-control" type="date" value="<?= $dateStart ?>" name="dateStart">
                  </div>
                  <div class="form-group col-md-3">
                      <input class="form-control" type="date" value="<?= $dateEnd ?>" name="dateEnd">
                  </div>
                  <div class="col-md-2">
                      <button type="submit" class="btn bg-light-warning" id="dt_cari_act"><i class="ft-search"></i> Submit</button>
                  </div>
              </div>
      		</form>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="mb-1 danger font-medium-3"><?= $totalVndActive ?></h3>
                            <span>Total Vendor Active</span>
                        </div>
                        <div class="media-right align-self-center">
                            <i class="ft-user-check success font-large-2 float-right"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="mb-1 info font-medium-3"><?= $totalVndSuspend ?></h3>
                            <span>Total Vendor Suspend</span>
                        </div>
                        <div class="media-right align-self-center">
                            <i class="ft-user-x info font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="mb-1 warning font-medium-3"><?= $totalVndWarning ?></h3>
                            <span>Total Vendor Warning</span>
                        </div>
                        <div class="media-right align-self-center">
                            <i class="ft-alert-triangle warning font-large-2 float-right"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="mb-1 success font-medium-3"><?= $totalVndBlacklist ?></h3>
                            <span>Total Vendor Blacklist</span>
                        </div>
                        <div class="media-right align-self-center">
                        <i class="ft-archive danger font-large-2 float-right"></i>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    
  </div>
  <!-- =========================chart======================= -->

  <div class="row">
  <div class="col-6">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Vendor Register Analytic</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="chartVndRegister">
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="col-6">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Vendor Activated Analytic </h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="chartVndActivated">
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Vendor Status Analytic</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="chartListVndStatus">
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Vendor Analytic CQSMS</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="chartlistVndCqsms">
          </div>
        </div>
      </div>

    </div>
  </div>

</div>


<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Analytic List Top Ten Unspsc</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="chartlistTopTenUnspsc">
          </div>
        </div>
      </div>

    </div>
  </div>

</div>


<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">List Top Kbli</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="gridlistTopTenKbli">
          </div>
        </div>
      </div>

    </div>
  </div>

</div>


<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Vendor SKN</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="chartlistVndSkn">
          </div>
        </div>
      </div>

    </div>
  </div>

</div>


<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Vendor Location</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="chartlistVndLocation">
          </div>
        </div>
      </div>

    </div>
  </div>

</div>





<!-- ========================================== -->

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">List Vendor Active</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="gridVendorActive">
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">List Vendor Suspend</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="gridVendorSuspend">
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">List Vendor Warning</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="gridVendorWarning">
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">List Vendor Blacklist</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="gridVendorBlacklist">
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<<div id="vpi-modal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <input type="hidden" id="vendorId" value="" >
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Pasal Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="penaltyArticle" id="penaltyArticle" value="" >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Deskripsi Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="penaltyDescription" id="penaltyDescription" value="" >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Tanggal Akhir Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="date" class="form-control" name="penaltyEnddate" id="penaltyEnddate" value="" >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Tanggal Mulai Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="date" class="form-control" name="penaltyStartdate" id="penaltyStartdate" value="" >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Status Sanksi</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                                <select id="penaltyStatusId" class="form-control" name="penaltyStatusId">
                                                    <option value="1">Kuning</option>
                                                    <option value="2">Merah</option>
                                                    <option value="3">Hitam</option>
                                                </select>
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 label-control">NPWP</label>
                                    <div class="col-md-9">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="vendorNpwp" id="vendorNpwp" value="" readonly >
                                            <div class="form-control-position">
                                                <i class="ft-file"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                
                                <p><button type="button" id="btnPushVpi" onclick="post_vnd_performance()" class="btn btn-primary" data-bs-toggle="button" aria-pressed="false" autocomplete="off">submit</button>  </p>                            
                                
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('devextreme'); ?>
<script>
   function post_vnd_performance() {
        if (confirm('Apakah anda yakin ingin submit data ke Pengadaan.com ?')) {
            
            
            $('#loading_upload').modal("show");
            $.ajax({
                type: "POST",
                url: "<?= site_url() ?>/BumnKarya/post_vnd_performance",
                data: {penaltyArticle : $("#penaltyArticle").val(), penaltyDescription : $("#penaltyDescription").val(),penaltyEnddate : $("#penaltyEnddate").val(),penaltyStartdate : $("#penaltyStartdate").val(),penaltyStatusId : $("#penaltyStatusId").val(),vendorId : $("#vendorId").val(),vendorNpwp : $("#vendorNpwp").val()},
                dataType: "json",
                error: function (response) {
                    $('#loading_upload').modal("hide");
                },
                success: function (response) {
                    alert(response.message)
                    if(response.code == 200)
                    {
                        location.reload();
                    }
                    //$("#vendorId").val(options.data.vendorId);
                    $("#vpi-modal").modal("hide");
                    $('#loading_upload').modal("hide");
                }
            });
        }
    }

    function get_vendor_performance(id) {
      $("#penaltyArticle").val("");
      $("#penaltyDescription").val("");
      $("#penaltyEnddate").val("");
      $("#penaltyStartdate").val("");
      $("#penaltyStatusId").val("");
      $("#vendorNpwp").val("");

      $("#penaltyArticle").removeAttr("readonly");
                    $("#penaltyDescription").removeAttr("readonly");
                    $("#penaltyEnddate").removeAttr("readonly");
                    $("#penaltyStartdate").removeAttr("readonly");
                    $("#penaltyStatusId").removeAttr("readonly");
                    $("#vendorNpwp").removeAttr("readonly");
                    $("#btnPushVpi").show();


            $.ajax({
                type: "POST",
                url: "<?= site_url() ?>/BumnKarya/get_vendor_performance/"+id,
                dataType: "json",
                error: function (response) {
                    //$('#loading_upload').modal("hide");
                    alert("data tidak ada !");
                },
                success: function (response) {
                    //$("#vendorId").val(options.data.vendorId);
                    if(response != null)
                    {
                      $("#penaltyArticle").val(response.penaltyArticle);
                    $("#penaltyDescription").val(response.penaltyDescription);
                    $("#penaltyEnddate").val(response.penaltyEnddate);
                    $("#penaltyStartdate").val(response.penaltyStartdate);
                    $("#penaltyStatusId").val(response.penaltyStatusId);
                    $("#vendorNpwp").val(response.vendorNpwp);

                    $("#penaltyArticle").attr("readonly",true);
                    $("#penaltyDescription").attr("readonly",true);
                    $("#penaltyEnddate").attr("readonly",true);
                    $("#penaltyStartdate").attr("readonly",true);
                    $("#penaltyStatusId").attr("readonly",true);
                    $("#vendorNpwp").attr("readonly",true);
                    $("#btnPushVpi").hide();
                    }
                   


                }
            });
        
    }

const dataSource = <?php echo $vndNewRegister ?>;
var dataSourceActivated = <?php echo $vndNewActivated ?>;
var listVndLocation = <?php echo $listVndLocation ?>;


    $('#chartVndRegister').dxPieChart({
    size: {
      width: 600,
    },
    palette: 'bright',
    dataSource,
    export: {
      enabled: true,
    },
    series: [
      {
        argumentField: 'register',
        valueField: 'val',
        label: {
          visible: true,
          connector: {
            visible: true,
            width: 1,
          },
        },
      },
    ],
    title: 'Vendor Register Summary',
    onPointClick(e) {
      const point = e.target;

      toggleVisibility(point);
    },
    onLegendClick(e) {
      const arg = e.target;

      toggleVisibility(this.getAllSeries()[0].getPointsByArg(arg)[0]);
    },
  });


  $('#chartVndActivated').dxPieChart({
    size: {
      width: 600,
    },
    palette: 'soft',
    dataSource: dataSourceActivated,
    export: {
      enabled: true,
    },
    series: [
      {
        argumentField: 'register',
        valueField: 'val',
        label: {
          visible: true,
          connector: {
            visible: true,
            width: 1,
          },
        },
      },
    ],
    title: 'Vendor Activated Summary',
    onPointClick(e) {
      const point = e.target;

      toggleVisibility(point);
    },
    onLegendClick(e) {
      const arg = e.target;

      toggleVisibility(this.getAllSeries()[0].getPointsByArg(arg)[0]);
    },
  });

  $('#chartlistVndLocation').dxPieChart({
    type: 'doughnut',
    palette: 'pastel',
    dataSource : listVndLocation,
    export: {
      enabled: true,
    },
    
    series: [
      {
        argumentField: 'provinceName',
        valueField: 'total',
        label: {
          visible: true,
          connector: {
            visible: true,
            width: 1,
          },
        },
      },
    ],
    title: 'Vendor Location',
    onPointClick(e) {
      const point = e.target;

      toggleVisibility(point);
    },
    onLegendClick(e) {
      const arg = e.target;

      toggleVisibility(this.getAllSeries()[0].getPointsByArg(arg)[0]);
    },
  });

  function toggleVisibility(item) {
    if (item.isVisible()) {
      item.hide();
    } else {
      item.show();
    }
  }

var listVndStatus = <?php echo $listVndStatus ?>;
var listVndCqsms = <?php echo $listVndCqsms ?>;
var listTopTenUnspsc = <?php echo $listTopTenUnspsc ?>;

var listVndSkn = <?php echo $listVndSkn ?>;




$('#chartListVndStatus').dxChart({
    dataSource: listVndStatus,
    palette: 'soft',
    title: {
      text: 'List Vendor Status',
    },
    export: {
      enabled: true,
    },
    commonSeriesSettings: {
      type: 'bar',
      valueField: 'totalVendor',
      argumentField: 'regName',
      ignoreEmptyPoints: true,
      label: {
        visible: true,
        format: {
          type: 'fixedPoint',
          precision: 0,
        },
    }
    },
    seriesTemplate: {
      nameField: 'regName',
    },
  });

  
$('#chartlistVndCqsms').dxChart({
    dataSource: listVndCqsms,
    palette: 'bright',
    title: {
      text: 'List Vendor CQSMS',
    },
    export: {
      enabled: true,
    },
    commonSeriesSettings: {
      type: 'bar',
      valueField: 'totalCategory',
      argumentField: 'categoryName',
      ignoreEmptyPoints: true,
      label: {
        visible: true,
        format: {
          type: 'fixedPoint',
          precision: 0,
        },
    }
    },
    seriesTemplate: {
      nameField: 'categoryName',
    },
  });


  
$('#chartlistTopTenUnspsc').dxChart({
    dataSource: listTopTenUnspsc,
    palette: 'soft pastel',
    title: {
      text: 'List Top Ten Unspsc',
    },
    export: {
      enabled: true,
    },
    commonSeriesSettings: {
      type: 'bar',
      valueField: 'totalPerCategory',
      argumentField: 'productClassName',
      ignoreEmptyPoints: true,
      label: {
        visible: true,
        format: {
          type: 'fixedPoint',
          precision: 0,
        },
    }
    },
    seriesTemplate: {
      nameField: 'productClassName',
    },
  });

  
$('#chartlistVndSkn').dxChart({
    dataSource: listVndSkn,
    palette: 'pastel',
    title: {
      text: 'Vendor SKN',
    },
    export: {
      enabled: true,
    },
    commonSeriesSettings: {
      type: 'bar',
      valueField: 'jumlahVendor',
      argumentField: 'rangeSkn',
      ignoreEmptyPoints: true,
      label: {
        visible: true,
        format: {
          type: 'fixedPoint',
          precision: 0,
        },
    }
    },
    seriesTemplate: {
      nameField: 'rangeSkn',
    },
  });

var listTopTenKbli = {
            load: function () {
                var items = $.Deferred();
                var data = <?= $listTopTenKbli; ?>;
                items.resolve(data);
                return items.promise();
            }
        };

$("#gridlistTopTenKbli").dxDataGrid({
    dataSource: listTopTenKbli,
    showBorders: true,
    showRowLines: true,
    columnAutoWidth: true,
    allowColumnResizing: true,
    allowColumnReordering: true,
    filterRow: {
        visible: true,
        applyFilter: "auto"
    },
    headerFilter: {
        visible: true
    },
    paging: {
        pageSize: 10
    },
    groupPanel: {
        visible: true
    },
    pager: {
        showPageSizeSelector: true,
        allowedPageSizes: [10, 25, 50],
        showInfo: true
    },
    onContentReady: function (e) {
                e.element.find(".dx-datagrid-export-button").dxButton("instance").option("icon", "export");
            },
    export: {
        enabled: true
    },
    summary: {
                totalItems: [{
                    column: "totalKbli",
                    summaryType: "sum",
                    //format : "number",
                    //valueFormat: "number",
                    displayFormat: "TOTAL : {0}",
                    valueFormat: "#,##0.00;(#,##0.00)"
                }]
            },
    columns: [{
            dataField: "vendorId",
            visible: false,
            allowEditing: false
        },
        
        {
            caption: "KBLI Desc Name",
            dataField: "kbliDesc",

        },
        
        {
            caption: "Total KBLI",
            dataField: "totalKbli",
            dataType: 'number',  
        },

       
        

    ],
});




</script>
<script type="text/javascript">
$(document).ready(function() {

var dataActive = {
            load: function () {
                var items = $.Deferred();
                var data = <?= $listVndActive; ?>;
                items.resolve(data);
                return items.promise();
            }
        };

var dataSuspend = {
            load: function () {
                var items = $.Deferred();
                var data = <?= $listVndSuspend; ?>;
                items.resolve(data);
                return items.promise();
            }
        };
        
var dataWarning = {
            load: function () {
                var items = $.Deferred();
                var data = <?= $listVndWarning; ?>;
                items.resolve(data);
                return items.promise();
            }
        };

var dataBlacklist = {
            load: function () {
                var items = $.Deferred();
                var data = <?= $listVndBlacklist; ?>;
                items.resolve(data);
                return items.promise();
            }
        };

$("#gridVendorActive").dxDataGrid({
    dataSource: dataActive,
    showBorders: true,
    showRowLines: true,
    columnAutoWidth: true,
    allowColumnResizing: true,
    allowColumnReordering: true,
    filterRow: {
        visible: true,
        applyFilter: "auto"
    },
    headerFilter: {
        visible: true
    },
    paging: {
        pageSize: 25
    },
    groupPanel: {
        visible: true
    },
    pager: {
        showPageSizeSelector: true,
        allowedPageSizes: [25, 50, 100],
        showInfo: true
    },
    onContentReady: function (e) {
                e.element.find(".dx-datagrid-export-button").dxButton("instance").option("icon", "export");
            },
    export: {
        enabled: true
    },
    
    columns: [{
            dataField: "vendorId",
            visible: false,
            allowEditing: false
        },
        
        {
            caption: "Vendor Name",
            dataField: "vendorName",
            cellTemplate: function (container, options) {
              $('<a/>').addClass('dx-link')
                                .text(options.data.vendorName)
                                    .on('dxclick', function () {
                                      $("#vendorId").val(options.data.vendorId);
                                      get_vendor_performance(options.data.vendorId);
                                      $("#vpi-modal").modal("show");


                                    })
                                    .appendTo(container);
              }

        },
        {
            caption: "Register Date",
            dataField: "registeredDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        {
            caption: "Suspend Date",
            dataField: "suspendedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Warned Date",
            dataField: "warnedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Blacklist Date",
            dataField: "blacklistedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        

    ],
});


$("#gridVendorSuspend").dxDataGrid({
    dataSource: dataSuspend,
    showBorders: true,
    showRowLines: true,
    columnAutoWidth: true,
    allowColumnResizing: true,
    allowColumnReordering: true,
    filterRow: {
        visible: true,
        applyFilter: "auto"
    },
    headerFilter: {
        visible: true
    },
    paging: {
        pageSize: 25
    },
    groupPanel: {
        visible: true
    },
    pager: {
        showPageSizeSelector: true,
        allowedPageSizes: [25, 50, 100],
        showInfo: true
    },
    onContentReady: function (e) {
                e.element.find(".dx-datagrid-export-button").dxButton("instance").option("icon", "export");
            },
    export: {
        enabled: true
    },
    
    columns: [{
            dataField: "vendorId",
            visible: false,
            allowEditing: false
        },
        
        {
            caption: "Vendor Name",
            dataField: "vendorName",
            cellTemplate: function (container, options) {
              $('<a/>').addClass('dx-link')
                                .text(options.data.vendorName)
                                    .on('dxclick', function () {
                                      $("#vendorId").val(options.data.vendorId);
                                      get_vendor_performance(options.data.vendorId);
                                      $("#vpi-modal").modal("show");


                                    })
                                    .appendTo(container);
              }
        },
        {
            caption: "Register Date",
            dataField: "registeredDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        {
            caption: "Suspend Date",
            dataField: "suspendedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Warned Date",
            dataField: "warnedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Blacklist Date",
            dataField: "blacklistedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        

    ],
});


$("#gridVendorWarning").dxDataGrid({
    dataSource: dataWarning,
    showBorders: true,
    showRowLines: true,
    columnAutoWidth: true,
    allowColumnResizing: true,
    allowColumnReordering: true,
    filterRow: {
        visible: true,
        applyFilter: "auto"
    },
    headerFilter: {
        visible: true
    },
    paging: {
        pageSize: 25
    },
    groupPanel: {
        visible: true
    },
    pager: {
        showPageSizeSelector: true,
        allowedPageSizes: [25, 50, 100],
        showInfo: true
    },
    onContentReady: function (e) {
                e.element.find(".dx-datagrid-export-button").dxButton("instance").option("icon", "export");
            },
    export: {
        enabled: true
    },
    
    columns: [{
            dataField: "vendorId",
            visible: false,
            allowEditing: false
        },
        
        {
            caption: "Vendor Name",
            dataField: "vendorName",
            cellTemplate: function (container, options) {
              $('<a/>').addClass('dx-link')
                                .text(options.data.vendorName)
                                    .on('dxclick', function () {
                                     
                                      $("#vendorId").val(options.data.vendorId);
                                      get_vendor_performance(options.data.vendorId);
                                      $("#vpi-modal").modal("show");

                                    })
                                    .appendTo(container);
              }
        },
        {
            caption: "Register Date",
            dataField: "registeredDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        {
            caption: "Suspend Date",
            dataField: "suspendedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Warned Date",
            dataField: "warnedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Blacklist Date",
            dataField: "blacklistedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        

    ],
});


$("#gridVendorBlacklist").dxDataGrid({
    dataSource: dataBlacklist,
    showBorders: true,
    showRowLines: true,
    columnAutoWidth: true,
    allowColumnResizing: true,
    allowColumnReordering: true,
    filterRow: {
        visible: true,
        applyFilter: "auto"
    },
    headerFilter: {
        visible: true
    },
    paging: {
        pageSize: 25
    },
    groupPanel: {
        visible: true
    },
    pager: {
        showPageSizeSelector: true,
        allowedPageSizes: [25, 50, 100],
        showInfo: true
    },
    onContentReady: function (e) {
                e.element.find(".dx-datagrid-export-button").dxButton("instance").option("icon", "export");
            },
    export: {
        enabled: true
    },
    
    columns: [{
            dataField: "vendorId",
            visible: false,
            allowEditing: false
        },
        
        {
            caption: "Vendor Name",
            dataField: "vendorName",
            cellTemplate: function (container, options) {
              $('<a/>').addClass('dx-link')
                                .text(options.data.vendorName)
                                    .on('dxclick', function () {
                                      $("#vendorId").val(options.data.vendorId);
                                      $("#vpi-modal").modal("show");


                                    })
                                    .appendTo(container);
              }
        },
        {
            caption: "Register Date",
            dataField: "registeredDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        {
            caption: "Suspend Date",
            dataField: "suspendedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Warned Date",
            dataField: "warnedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },

        {
            caption: "Blacklist Date",
            dataField: "blacklistedDate",
            dataType: 'date',  
            format: 'dd-MM-yyyy' 
        },
       
        

    ],
});

});
</script>
