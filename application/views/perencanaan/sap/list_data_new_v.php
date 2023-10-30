<style>
    .btn-info {
        border-radius: 8px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .wrapper-switch {
        background-color: #fff;
        padding: 1rem;
        display: flex;
        border-radius: 10px;
        justify-content: space-between;
        align-items: center;
        max-width: 285px;
        box-shadow: -8px 8px 14px 0 rgb(25 42 70 / 11%);
    }

    .card-top {
        background-color: #f7f7f8;
        box-shadow: none;
    }

	.pull-right {
		margin-right: 20px;
	}

	.fixed-table-container {
		border: none !important;
	}

	.fixed-table-toolbar .bars,
	.fixed-table-toolbar .columns,
	.fixed-table-toolbar .search {
		margin-right: 10rem;
	}

	.custom-button-position {
		position: absolute;
		right: 2rem;
		top: 4.4rem;
	}

	.btn-export {
		background-color: transparent;
		/* border: none; */
		border: 2px solid #29a7de;
		border-top: 0;
		border-left: 0;
		border-right: 0;
		border-radius: 15px;
		padding: 6px;
		background-color: transparent;
	}

    #rowfil .select2 {
        width: 97% !important
    }
	
	.dx-list-item {
		width: 160px !important;
	}

	.dx-list-item-icon-container {
		display: none !important;
	}

</style>

<section class="users-list-wrapper">
	<!-- Table starts -->
	<div class="users-list-table">

		<div style="display: none;" class="alert alert-notif mt-2" role="alert">
			<span id="alert-text"></span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row justify-content-end mb-2">
                            <div class="col-sm-1 pt-1">
                                <span class="card-title text-bold-600 mr-2">Filter Data <i class="ft-document"></i></span>
                            </div>
                            <div class="col-sm-9 mb-2">
                                <div class="row" id="rowfil">
                                    <div class="col-sm-3">
                                        <select class="form-control select2 ml-2" style="display: none" id="pg" name="pg">
                                            <option value="">Purchasing Group</option>
                                            <?php foreach ($pg as $k => $v): ?>
                                                <option value="<?php echo $v['ppm_dept_id'] ?>"><?php echo $v['dep_code']."-".$v['ppm_dept_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control select2 ml-2" style="display: none" id="project" name="project">
                                            <option value="">Project</option>
                                            <?php foreach ($proj as $k => $v): ?>
                                                <option value="<?php echo $v['ppm_project_id'] ?>"><?php echo $v['ppm_subject_of_work'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control select2 ml-2" id="prtype" style="display: none" name="prtype">
                                            <option value="">PR Type</option>
                                            <?php foreach ($type as $k => $v): ?>
                                                <option value="<?php echo $v['pr_code'] ?>"><?php echo $v['pr_code'] . ' - ' . $v['pr_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="btn-group" style="width: 100%">
									<div type="button" class="btn btn-primary btn-sm" id="sbmt"><i class="fa fa-search"></i>&nbsp;Filter</div>
									<div type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-upload"></i>&nbsp;Import</div>
									<a href="<?php echo base_url('dir/sync_api'); ?>" onclick="return confirm('Apakah Anda yakin syncron data SAP?')" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i>&nbsp;Sync</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="tbl_pr_sap"></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<!-- Table ends -->
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('dir/import_excel'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" name="fileExcel">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('devextreme'); ?>
<script>
	const URL_PR = '<?php echo site_url('perencanaan_pengadaan') ?>';

	function sendRequest(url, method = 'GET', data) {
		const d = $.Deferred();

		$.ajax(url, {
			method,
			data,
			cache: false,
			xhrFields: {
				withCredentials: true
			},
			success: function(response) {
				location.reload();
			}
		}).done((result) => {
			d.resolve(method === 'GET' ? result.data : result);
		}).fail((xhr) => {
			d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
		});

		return d.promise();
	}

    $('#sbmt').on('click', function() {
        let filter = {
            'pg': $('#pg').val(),
            'project': $('#project').val(),
            'prtype': $('#prtype').val(),
            'pr': $('#pr').val()
        }
        show(filter)
    })

	$(document).ready(function() {
        show('')
	});

    function show(filter = '') {
        const d = $.Deferred();
		const data = new DevExpress.data.CustomStore({
			key: 'ppi_id',
			load() {
				var data = [];
				$.ajax({
					type: "POST",
					url: URL_PR + '/get_pr_grid/',
                    data: filter,
					dataType: "json",
					success: function(response) {
						d.resolve(response);
					}
				});
				return d.promise();
            }
		});

		$("#tbl_pr_sap").dxDataGrid({
			dataSource: data,
			showBorders: true,
			showRowLines: true,
			columnAutoWidth: true,
			allowColumnResizing: true,
			allowColumnReordering: false,
			repaintChangesOnly: true,
			editing: {
				mode: 'batch',
				allowUpdating: true,
				startEditAction: 'click'
			},
			filterRow: {
				visible: true,
				applyFilter: "auto"
			},
			grouping: {
				autoExpandAll: true,
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
			export: {
				enabled: true,
                allowExportSelectedData: true
			},
            selection: {
                mode: "multiple",
                allowSelectAll: true
            },
			columns: [
                {
                    groupIndex: 0,
                    caption: "Header ",
                    dataField: "head_pr",
                    allowEditing: false
                },
				{
					caption: "Nomor PR",
					dataField: "ppis_pr_number",
                    allowEditing: false
				},
				{
					caption: "A",
					dataField: "ppis_acc_assig",
                    allowEditing: false
				},
				{
					caption: "Line",
					dataField: "ppis_pr_item",
                    allowEditing: false
				},
				{
					caption: "Kode SDA",
					dataField: "ppi_code",
                    allowEditing: false
				},
				{
					caption: "Deskripsi",
					dataField: "ppi_item_desc",
                    allowEditing: false
				},
				{
					caption: "PG",
					dataField: "ppm_dept_name",
                    allowEditing: false
				},
				{
					caption: "UOM",
					dataField: "ppi_satuan",
                    allowEditing: false
				},
				{
					caption: "QTY",
					dataField: "ppi_jumlah",
                    allowEditing: false,
                    dataType: "number",
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},
				{
					caption: "Harsat",
					dataField: "ppi_harga",
                    allowEditing: false,
                    dataType: "number",
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},
				{
					caption: "Subtotal",
					dataField: "subtotal",
                    allowEditing: false,
                    dataType: "number",
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},
				{
					caption: "Price Unit",
					dataField: "ppi_temp_vol",
                    allowEditing: false,
                    dataType: "number",
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},
				{
					caption: "No Urut CostCtr",
					dataField: "ppi_pr_order",
                    allowEditing: false,
                    dataType: "number",
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},
				{
					caption: "Req Date",
					dataField: "ppms_start_date",
                    allowEditing: false,
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},
				{
					caption: "Dev Date",
					dataField: "ppis_delivery_date",
                    allowEditing: false,
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},
				{
					caption: "Update Date",
					dataField: "ppi_update_at",
                    allowEditing: false,
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},
				{
					caption: "Status",
					dataField: "status_rkp",
                    allowEditing: false
				}
			],

			onToolbarPreparing: function(e) {
				e.toolbarOptions.items.unshift({
					location: "after",
					widget: "dxButton",
					options: {
						icon: "refresh",
						onClick: function(e) {
							$("#tbl_pr_sap").dxDataGrid("instance").refresh();
						}
					}
				});
			},
		});
    }

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

	if(getUrlParameter('status') != typeof undefined){

		if (getUrlParameter('status') == 'success') {

			$('.alert-notif').addClass('bg-light-info').css('display','block')
			$('#alert-text').html(getUrlParameter('msg'))

		} else if (getUrlParameter('status') == 'fail'){

			$('.alert-notif').addClass('bg-light-warning').css('display','block')
			$('#alert-text').html(getUrlParameter('msg'))

		} else if (getUrlParameter('status') == 'not_found'){

			$('.alert-notif').addClass('bg-light-danger').css('display','block')
			$('#alert-text').html(getUrlParameter('msg'))

		} else if (getUrlParameter('status') == 'error_ws'){

			$('.alert-notif').addClass('bg-light-danger').css('display','block')
			$('#alert-text').html(getUrlParameter('msg'))
		}

	}

</script>
