
<?php 
$this->load->view("devextreme");
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
  

    <div class="card">
      <div class="card-body table-responsive">
      <div id="itemGrid"></div>
    </div>

  </section>  
</div>

<script>
  $(document).ready(function () {

    const URL = '<?= site_url() ?>/TenderPo';
    const ordersStore = new DevExpress.data.CustomStore({
    key: 'id',
    load() {
      //var data = [];
      //d.resolve(data);
      var d = $.Deferred();
				$.ajax({
					type: "GET",
					url: URL + '/get_ajax_data/',
					//data: "data",
					dataType: "json",
					success: function(response) {
            d.resolve(response.data);
            //return d.promise();
					}
				});
				return d.promise();
    },
 
    update(key, values) {
      var d = $.Deferred();
      $.ajax({
					type: "POST",
					url: URL + '/update_ajax_data/',
					data: {key: key, values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						//d.resolve();
            if(response.code == 200)
            {
              d.resolve(response.data);
              $('#itemGrid').dxDataGrid("instance").refresh();
              
            }

            //location.reload();
					}
				});
				return d.promise();
      // return sendRequest(`${URL}/update_score`, 'POST', {
      //   key,
      //   values: JSON.stringify(values),
      // });
    },

    insert: function (values) {
        // ...
        var d = $.Deferred();
      $.ajax({
					type: "POST",
					url: URL + '/insert_ajax_data/',
					data: {values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						//d.resolve();
            if(response.code == 200)
            {
              d.resolve(response.data);
              $('#itemGrid').dxDataGrid("instance").refresh();
              
            }

            //location.reload();
					}
				});
				return d.promise();
    },
    remove: function (key) {
        // ...
        var d = $.Deferred();
      $.ajax({
					type: "POST",
					url: URL + '/remove_ajax_data/',
					data: {key: key},
					dataType: "json",
					success: function(response) {
						//d.resolve();
            if(response.code == 200)
            {
              d.resolve(response.data);
              $('#itemGrid').dxDataGrid("instance").refresh();
              
            }

            //location.reload();
					}
				});
				return d.promise();
    }
  });

  const dataGrid = $('#itemGrid').dxDataGrid({
    dataSource: ordersStore,
    hoverStateEnabled: true,
      rowAlternationEnabled: true,
      showBorders: true,
      allowColumnResizing: true,
      columnResizingMode: "nextColumn",
      columnAutoWidth: true,
      allowColumnReordering: true,
      showRowLines: true,
      grouping: {
        autoExpandAll: true,
      },
      groupPanel: {
        visible: true
      },
      scrolling: {
        mode: "virtual"
      },
      filterRow: {
        visible: true
      },
      headerFilter: {
        visible: true,
        allowSearch: true
      },
      height: function() {
        return window.innerHeight / 1.40;
      },
    scrolling: {
      mode: 'virtual',
    },
    columns: [

    {
      dataField: 'DOC_NO',
    },
    {
      dataField: 'DOC_TYPE',
    },{
      dataField: 'VENDOR',
    },{
      dataField: 'DOC_DATE',
    },{
      dataField: 'INCOTERMS1',
    },{
      dataField: 'INCOTERMS2',
    },{
      dataField: 'RETENTION_PERCENTAGE',
    },{
      dataField: 'DOWNPAY_PERCENT',
    },{
      dataField: 'DOWNPAY_DUEDATE',
    },{
      dataField: 'PO_ITEM',
    },{
      dataField: 'MATERIAL',
      caption: 'MATERIAL / SERVICE'
    },{
      dataField: 'QUANTITY',
      caption: 'QTY'

    },{
      dataField: 'PO_UNIT',
      caption: 'UOM'

    },{
      dataField: 'NET_PRICE',
      caption: 'PRICE PER UNIT'

    },{
      dataField: 'PREQ_NO',
      caption: 'PR NUMBER'

    },{
      dataField: 'PREQ_ITEM',
      caption: 'PR ITEM'

    },
    {
      dataField: 'DELIVERY_DATE',
    },
    {
      dataField: 'ASSET_NO',
    },{
      dataField: 'SUB_NUMBER',
    },{
      dataField: 'TAX_CODE',
    },{
      dataField: 'SERVICE',
    },
    // {
    //   dataField: 'SERVICE_QTY',
    // },{
    //   dataField: 'BASE_UOM',
    // },{
    //   dataField: 'GR_PRICE',
    // },
    {
      dataField: 'RUANG_LINGKUP',
    },{
      dataField: 'JANGKA_WAKTU',
    },{
      dataField: 'SOURCE',
    },{
      dataField: 'RFQ_NO',
    },

    ],
    onToolbarPreparing: function (e) {
                        let toolbarItems = e.toolbarOptions.items;

                        toolbarItems.forEach(function (item) {
                           
                        });


                        toolbarItems.push({
                            widget: "dxButton",
                            location: "after",
                            options: {
                                icon: "refresh", onClick: function () {
                                    $("#itemGrid").dxDataGrid("instance").refresh();
                                }
                            }
                        });

                        
                        toolbarItems.push({
                            widget: "dxButton",
                            location: "after",
                            options: {
                                icon: "upload", onClick: function () {
                                }
                            }
                        });

      },
    
    
  }).dxDataGrid('instance');

  });

 

</script>
 
