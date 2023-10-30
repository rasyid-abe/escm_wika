<form class="form-horizontal">  
  <div class="row">
      <div class="col-12">
          <div class="card">
            
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title"></h4>
            </div>

            <div class="card-content">
              <div class="card-body">
                <div id="gridHeaderKewenangan" ></div>
              </div>
            </div>

          </div>
      </div>
  </div>
</form>

<?php $this->load->view('devextreme'); ?>

<script>
  $(document).ready(function () {

    var divisi = <?= $divisi ?>;
    var   = <?= $tipe_pengadaan ?>;
    var proyek = <?= $tipe_proyek ?>;
    var uskep = <?= $tipe_uskep ?>;
    var tipe_plan = <?= $tipe_plan ?>;
    var tipe_kontrak_matgis = <?= $tipe_kontrak_matgis ?>;

    const URL = '<?= base_url() ?>Master_kewenangan';
    const d = $.Deferred();
    const ordersStore = new DevExpress.data.CustomStore({
    key: 'id',
    load() {
      var data = [];
				
				$.ajax({
					type: "GET",
					url: URL + '/get_header/',
					//data: "data",
					dataType: "json",
					success: function(response) {
						d.resolve(response.data);
					}
				});
				return d.promise();
    },
    insert(values) {

      $.ajax({
					type: "POST",
					url: URL + '/insert_header/',
					data: {values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridHeaderKewenangan').dxDataGrid("instance").refresh();
            }

            location.reload();
					}
				});
      // return sendRequest(`${URL}/insert_score/`, 'POST', {
      //   values: JSON.stringify(values),
      // });
    },
    update(key, values) {

      $.ajax({
					type: "POST",
					url: URL + '/update_header/',
					data: {key: key, values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridHeaderKewenangan').dxDataGrid("instance").refresh();
            }

            location.reload();
					}
				});

      // return sendRequest(`${URL}/update_score`, 'POST', {
      //   key,
      //   values: JSON.stringify(values),
      // });
    },
    remove(key) {
      $.ajax({
					type: "POST",
					url: URL + '/delete_header/',
					data: {key: key},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridHeaderKewenangan').dxDataGrid("instance").refresh();
            }

            location.reload();
					}
				});
      // return sendRequest(`${URL}/delete_score`, 'POST', {
      //   key,
      // });
    },
  });

  const dataGrid = $('#gridHeaderKewenangan').dxDataGrid({
    dataSource: ordersStore,
    showBorders: true,
    editing: {
      mode: 'popup',
      allowAdding: true,
      allowUpdating: true,
      allowDeleting: true,
      popup: {
        title: 'Header Kewenangan',
        showTitle: true,
        width: 700,
        height: 525,
      },
    },
    scrolling: {
      mode: 'virtual',
    },
    columns: [
      {     
				  caption : "Action",
					allowEditing: false,   
					width: '80',          
				    cellTemplate: function (container, options) {
				        var id = options.data.id;
					
							$("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?= base_url() ?>procurement/procurement_tools/detail_template_kewnangan/"+id+"') class='btn bg-light-info btn-sm' target='_self'>Detail</a>"))

				        .appendTo(container);
						
				            
				    }
				},
    
      {
        dataField: 'komisi',
        caption: 'Komisi',
        validationRules: [{ type: "required" }],
      },
      {
        dataField: 'tipe_proyek',
        caption: 'Tipe Proyek',
        lookup: {
                                  dataSource: proyek,
                                  valueExpr: "name",
                                  displayExpr: "name",
                                  //searchExpr: ['pos_id', 'job_title']
                              },
                              //  validationRules: [{ type: "required" }],
      },
      {
                              caption: "Nilai RAB",
                              dataField: "nilai_rab_start",
                              dataType: "number",
                              format: '#,##0.00;(#,##0.00)',
                              //precision: 0,
                              editorOptions: {
                                  min: 0,
                                  format: "#,##0.00;(#,##0.00)"
                              },
                              validationRules: [{ type: "numeric" }],
      },
      {
                              caption: "Nilai RAB",
                              dataField: "nilai_rab_end",
                              dataType: "number",
                              format: '#,##0.00;(#,##0.00)',
                              //precision: 0,
                              editorOptions: {
                                  min: 0,
                                  format: "#,##0.00;(#,##0.00)"
                              },
                              validationRules: [{ type: "numeric" }],
      },
      {
        groupIndex: 1,
        dataField: 'tipe_uskep',
        caption: 'Tipe Uskep',
        lookup: {
                                  dataSource: uskep,
                                  valueExpr: "name",
                                  displayExpr: "name",
                                  //searchExpr: ['pos_id', 'job_title']
        },
                              validationRules: [{ type: "required" }],
      },
      {
        groupIndex: 0,
        dataField: 'tipe_plan',
        caption: 'Tipe Plan',
        validationRules: [{ type: "required" }],
        lookup: {
                                  dataSource: tipe_plan,
                                  valueExpr: "code",
                                  displayExpr: "name",
                                  //searchExpr: ['pos_id', 'job_title']
        },
      },
      {
        dataField: 'tipe_kontrak_matgis',
        caption: 'Tipe Kontrak Matgis',
        lookup: {
                                  dataSource: tipe_kontrak_matgis,
                                  valueExpr: "code",
                                  displayExpr: "name",
                                  //searchExpr: ['pos_id', 'job_title']
        },
      },
      ],
      
      
    }).dxDataGrid('instance');

  });

</script>
