
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
</style>

<section class="users-list-wrapper">
	<!-- Table starts -->
	<div class="users-list-table">
		<div class="row">
			<div class="col-12">
                <a onclick="createPaket()" class="btn btn-info my-3" style="border-radius: 10px;">
                    <i class="ft ft-plus"></i> Create
                </a>
                <a onclick="createPaketMerge()" class="btn btn-primary my-3" style="border-radius: 10px;">
                    <i class="ft ft-plus"></i> Create (Merge)
                </a>
				<br>
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

	$(document).ready(function() {

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
					type: "GET",
					url: URL_PR + '/get_main/',
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
				enabled: false
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
				    cellTemplate: function (container, options) {
				        var pr_number = options.data.pr_number;
							$("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?php echo site_url('paket_pengadaan/paket_sap_oa/lihat/') ?>"+pr_number+"') class='btn bg-light-info btn-sm' target='_blank'>Lihat</a>"))
				            .append($("<a onclick=window.open('<?php echo site_url('paket_pengadaan/paket_sap_oa/pembuatan_permintaan_pengadaan?edit_data_pr=') ?>"+pr_number+"') class='btn bg-light-warning btn-sm'>Edit</a>"))
				            .append($("<a onclick=window.open('<?php echo site_url('paket_pengadaan/paket_sap_oa/submit_single_sap?submit_data_pr=') ?>"+pr_number+"') class='btn bg-light-danger btn-sm'>Submit</a></div>"))
				        .appendTo(container);
				    }
				},
                {
                    groupIndex: 0,
                    caption: "Header ",
                    dataField: "pr_header",
                    allowEditing: false
                },
				{
                    caption: "Nomor Perancanaan",
					dataField: "pr_number",
                    allowEditing: false
				},
				{
					caption: "Nomor PR",
					dataField: "ppis_pr_number",
                    allowEditing: false
				},
				{
					caption: "PG",
					dataField: "pr_ekgrp",
                    allowEditing: false
				},
				{
					caption: "PR Item",
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
					dataField: "ppi_description",
                    allowEditing: false
				},
				{
					caption: "A",
					dataField: "ppis_acc_assig",
                    allowEditing: false
				},
				{
					caption: "UOM",
					dataField: "ppi_unit",
                    allowEditing: false
				},
				{
					caption: "Realisasi PO",
					dataField: "total_ctr",
                    allowEditing: false
				},
				{
					caption: "QTY",
					dataField: "ppi_quantity",
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
					caption: "Sisa QTY",
					dataField: "item_remain",
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
					dataField: "ppi_price",
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
				},
				{
					caption: "Jumlah PO",
					dataField: "realisasi_po",
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
					caption: "QTY PO",
					dataField: "realisasi_qty_item",
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
					caption: "Efisiensi",
					dataField: "efisiensi_po",
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
					caption: "Sisa Komitmen",
					dataField: "sisa_kom",
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
					dataField: "pr_created_date",
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
					caption: "Dev Date (x)",
					dataField: "ppi_dev_date",
                    allowEditing: true,
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},
				{
					caption: "PDT",
					dataField: "ppi_pdt",
                    allowEditing: true
				},
				{
					caption: "Tax Code",
					dataField: "ppi_tax_code",
                    allowEditing: true,
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
					lookup: {
						dataSource: type_po,
						displayExpr: 'name',
          				valueExpr: 'id',
					},
				},
				{
					caption: "Vendor Usulan",
					dataField: "pr_vendor",
                    allowEditing: true
				},
				{
					caption: "PO Date",
					dataField: "ppi_po_date",
                    allowEditing: true,
                    dataType: "date",
                    format: 'dd/MM/yyyy'
				},
				{
					caption: "Tgl Tender",
					dataField: "ppi_tender_date",
                    allowEditing: true,
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
					dataField: "ppi_status_update",
                    allowEditing: false,
				},
				{
					caption: "Tahap/Proses",
					dataField: "status",
                    allowEditing: false,
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
	});

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

                    location.href = "<?= base_url() ?>paket_pengadaan/paket_sap_oa/pembuatan_permintaan_pengadaan?data_pr=" + json_data;

                } else {

                }
            })
        }
    }

    function createPaketMerge() {
        var data = $('#table_permintaan_pengadaan').dxDataGrid('instance').getSelectedRowKeys();

        var json_data = JSON.stringify({ data });
		// console.log(json_data);
		// return false;

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

                    location.href = "<?= base_url() ?>paket_pengadaan/paket_sap_oa/pembuatan_permintaan_pengadaan_merge?data_pr=" + json_data;

                } else {

                }
            })
        }
    }

</script>
