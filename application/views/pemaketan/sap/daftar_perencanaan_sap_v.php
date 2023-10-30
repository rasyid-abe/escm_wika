<style>
	.btn-trash {
		border-radius: 0 8px 8px 0 !important;
		background-color: rgb(36 36 36 / 22%);
		right: 0%;
		position: absolute;
	}

	.btn-plus {
		padding: 0.25rem 2rem !important;
		border-radius: 8px 0 0 8px !important;
		right: 30px;
		position: absolute;
	}

	.btn-action-edit {
		border-radius: 8px;
		width: 100px;
	}

	.btn-action-delete {
		border-radius: 0 8px 8px 0;
		background-color: rgb(36 36 36 / 22%);
		position: relative;
		left: 0px;
	}

	.form-control {
		border: 2px solid #29a7de;
		border-top: 0;
		border-left: 0;
		border-right: 0;
		border-radius: 15px;
		padding: 6px;
		background-color: transparent;
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
                                        <select class="form-control select2 ml-2" style="display: none" id="prtype" name="prtype">
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
									<div type="button" class="btn btn-primary btn-sm" id="sbmt"><i class="fa fa-search"></i> Filter</div>
									<div type="button" class="btn btn-warning btn-sm" onclick="createPaket()"><i class="ft ft-plus"></i> Create Join</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-12">                				
				<div id="table_permintaan_pengadaan"></div>
			</div>
		</div>
	</div>
	<!-- Table ends -->
</section>

<?php $this->load->view('devextreme'); ?>
<script>
	const URL_PR = '<?php echo site_url('master_pr') ?>';

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
            'prtype': $('#prtype').val()
        }
        show(filter)
    })

	$(document).ready(function() {
        show('')
	});

	function show(filter = '') {

		<?php if ($this->session->flashdata("success") == true) { ?>
			toastr.success('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		<?php if ($this->session->flashdata("error") == true) { ?>
			toastr.error('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		const tax_code = [{name: 'V1'}, {name: 'V2'}, {name: 'V3'}, {name: 'V4'}];
		const type_po = [{id:'ZW01' ,name: 'PO WIKA ProyNon Matg'}, {id: 'ZW02', name:'PO WIKA NonProy'}, {id: 'ZW03', name:'PO WIKA Matgis'}, {id: 'ZW04', name:'PO WIKA Import'}, {id: 'ZW05', name:'PO Internal'}, {id: 'ZW06', name:'PO Asset'}, {id: 'ZW07', name:'PO Low Value Asset'}, {id: 'ZW08', name:'PO Return'}];

		const d = $.Deferred();
		const data = new DevExpress.data.CustomStore({
			key: 'ppi_id',
			load() {
				var data = [];
				$.ajax({
					type: "POST",
					url: URL_PR + '/get_main/',
					data: filter,
					dataType: "json",
					success: function(response) {
						d.resolve(response);
					}
				});
				return d.promise();

			},
            update(key, values) {
                $.ajax({
                    type: "POST",
                    url: URL_PR + '/update_pr/',
                    data: {key: key, values : JSON.stringify(values)},
                    dataType: "json",
                    success: function(response) {
                        d.resolve();
                        if(response.code == 200)
                        {
                            $('#table_permintaan_pengadaan').dxDataGrid("instance").refresh();
                        }
						location.reload();
                    }
                });
            }
		});

		$("#table_permintaan_pengadaan").dxDataGrid({
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
				visible: false
			},
			paging: {
				pageSize: 25
			},
			groupPanel: {
				visible: false
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
			columns: [{
					dataField: "pr_number",
					visible: false,
					allowEditing: false
				},
				{     
				    caption : "Action",
					allowEditing: false,   
					width: 'auto',      
					alignment: 'center',    
				    cellTemplate: function (container, options) {
				        var pr_number = options.data.pr_number;
							$("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?php echo site_url('paket_pengadaan/paket_sap/lihat/') ?>"+pr_number+"') class='btn bg-light-info btn-sm' target='_blank'>Lihat</a>"))
				            .append($("<a onclick=window.open('<?php echo site_url('paket_pengadaan/paket_sap/pembuatan_permintaan_pengadaan?edit_data_pr=') ?>"+pr_number+"') class='btn bg-light-warning btn-sm'>Edit</a>"))
				            .append($("<a onclick=window.open('<?php echo site_url('paket_pengadaan/paket_sap/submit_single_sap?submit_data_pr=') ?>"+pr_number+"') class='btn bg-light-danger btn-sm'>Submit</a></div>"))
				        .appendTo(container);				            
				    }
				},				
                {
                    groupIndex: 0,
                    caption: "Header ",
                    dataField: "pr_header",
                    allowEditing: false,
					alignment: 'center'
                },
				{
                    caption: "Nomor Perancanaan",
					dataField: "pr_number",
                    allowEditing: false,
					alignment: 'left'
				},
				{
					caption: "Nomor PR",
					dataField: "ppis_pr_number",
                    allowEditing: false,
					alignment: 'center'
				},		
				{
					caption: "A",
					dataField: "ppis_acc_assig",	
                    allowEditing: false,
					alignment: 'center'	
				},			
				{
					caption: "Line",
					dataField: "ppis_pr_item",
                    allowEditing: false,
					alignment: 'center'
				},				
				{
					caption: "Kode SDA",
					dataField: "ppi_code",		
					allowEditing: false,
					alignment: 'center'
				},				
				{
					caption: "Deskripsi",
					dataField: "ppi_description",			
					allowEditing: false,
					alignment: 'left'
				},											
				{
					caption: "PG",
					dataField: "pr_ekgrp",
                    allowEditing: false,
					alignment: 'center'
				},								
				{
					caption: "UOM",
					dataField: "ppi_unit",			
                    allowEditing: false,
					alignment: 'center'
				},										
				{
					caption: "QTY",
					dataField: "ppi_quantity",				
                    allowEditing: false,
                    dataType: "number",
					alignment: 'center',
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},	
				{
					caption: "Harsat",
					dataField: "ppi_price",				
                    allowEditing: false,
                    dataType: "number",
					alignment: 'right',
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
					alignment: 'right',
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},			
				{
					caption: "Req Date",
					dataField: "pr_created_date",				
                    allowEditing: false,
					alignment: 'center',
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},	
				{
					caption: "Dev Date",
					dataField: "ppis_delivery_date",				
                    allowEditing: false,
					alignment: 'center',
                    dataType: "date",
                    format: 'dd/MM/yyyy'  
				},	
				{
					caption: "Delivery Date",
					dataField: "ppi_dev_date",				
                    allowEditing: true,
					alignment: 'center',
                    dataType: "date",
                    format: 'dd/MM/yyyy'  
				},	
				{
					caption: "Status",
					dataField: "ppi_status_update",				
                    allowEditing: false,
					alignment: 'center'
				},
				{
					caption: "Rencana Tgl PO",
					dataField: "ppi_po_date",				
                    allowEditing: true,
					alignment: 'center',
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},				
				{
					caption: "Tgl Tender",
					dataField: "ppi_tender_date",				
                    allowEditing: true,
					alignment: 'center',
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},	
				{
					caption: "Nama Vendor",
					dataField: "pr_vendor",
                    allowEditing: false,
					alignment: 'center'
				},
				{
					caption: 'Realisasi PO',
					alignment: 'center',
					columns: [{
						caption: "Jumlah PO",
						dataField: "realisasi_po",
						allowEditing: false,
						alignment: 'center',
						dataType: "number",
						format: '#,##0.00;(#,##0.00)',
						editorOptions: {
							min: 0,
							format: "#,##0.00;(#,##0.00)"
						},
						validationRules: [{ type: "numeric" }]
					}, {
						caption: "QTY",
						dataField: "realisasi_qty_item",
						allowEditing: false,
						alignment: 'center',
						dataType: "number",
						format: '#,##0.00;(#,##0.00)',
						editorOptions: {
							min: 0,
							format: "#,##0.00;(#,##0.00)"
						},
						validationRules: [{ type: "numeric" }]
					}, {
						caption: "Nilai PO",
						dataField: "total_po",			
						allowEditing: false,
						alignment: 'right'
					}],
				},	
				{
					caption: "Catatan Efisiensi",
					dataField: "efisiensi_po",
                    allowEditing: false,
					alignment: 'center',
                    dataType: "number",
                    format: '#,##0.00;(#,##0.00)',
                    editorOptions: {
                        min: 0,
                        format: "#,##0.00;(#,##0.00)"
                    },
                    validationRules: [{ type: "numeric" }]
				},
				{
					caption: 'Sisa Komitmen',
					alignment: 'center',
					columns: [{
						caption: "QTY",
						dataField: "item_remain",
						allowEditing: false,
						alignment: 'center',
						dataType: "number",
						format: '#,##0.00;(#,##0.00)',
						editorOptions: {
							min: 0,
							format: "#,##0.00;(#,##0.00)"
						},
						validationRules: [{ type: "numeric" }]
					}, {
						caption: "Cost",
						dataField: "sisa_kom",
						allowEditing: false,
						alignment: 'center',
						dataType: "number",
						format: '#,##0.00;(#,##0.00)',
						editorOptions: {
							min: 0,
							format: "#,##0.00;(#,##0.00)"
						},
						validationRules: [{ type: "numeric" }]
					}],
				},																		
				{
					caption: "QTY (GR/SES)",
					dataField: "quantity",
					allowEditing: false,
					alignment: 'center'
				},																														
				{
					caption: "Price Unit",
					dataField: "ppi_temp_vol",
                    allowEditing: false,
					alignment: 'right',
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
					alignment: 'center'
				},																														
				{
					caption: "PDT",
					dataField: "ppi_pdt",				
                    allowEditing: true,
					alignment: 'center'
				},				
				{
					caption: "Tax Code",
					dataField: "ppi_tax_code",				
                    allowEditing: true,
					alignment: 'center',
					lookup: {
						dataSource: tax_code,
						displayExpr: 'name',
						valueExpr: 'name',
					},
				},				
				{
					caption: "Type PO",
					dataField: "ppi_type_po",				
                    allowEditing: true,
					alignment: 'center',
					lookup: {
						dataSource: type_po,
						displayExpr: 'name',
          				valueExpr: 'id',
					},
				},																
				{
					caption: "Update Date",
					dataField: "ppi_update_at",				
                    allowEditing: false,
					alignment: 'center',
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},												
				{
					caption: "Tahap/Proses",
					dataField: "status",				
                    allowEditing: false,
					alignment: 'left'
				}			
			],

			onToolbarPreparing: function(e) {
				e.toolbarOptions.items.unshift({
					location: "after",
					widget: "dxButton",
					options: {
						icon: "refresh",
						onClick: function(e) {
							$("#table_permintaan_pengadaan").dxDataGrid("instance").refresh();
						}
					}
				});
			},
		});
	};

    function createPaket() {
        var data = $('#table_permintaan_pengadaan').dxDataGrid('instance').getSelectedRowKeys();

        var json_data = JSON.stringify({ data });

        if(data.length < 2)
        {
            Swal.fire({
                title: 'WARNING',
                text: "Minimal 2 item",
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                backdrop: true,
                allowOutsideClick: false
            }).then((result) => {
            
            })

        } else {
            Swal.fire({
                title: 'WARNING',
                text: "Apakah Data Sudah Benar?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                backdrop: true,
                allowOutsideClick: false

            }).then((result) => {

                if (result.value) {

                    location.href = "<?= base_url() ?>paket_pengadaan/paket_sap/pembuatan_permintaan_pengadaan?data_pr=" + json_data;

                } else {

                }
            })
        }
    }

</script>
