
<section class="users-list-wrapper">
	<!-- Table starts -->
	<div class="users-list-table">
		<div class="row">
			<div class="col-12">
				<br>
				<div id="gridHse"></div>
			</div>
		</div>
	</div>
	<!-- Table ends -->
</section>

<!-- Modal ADD JAWABAN -->

<?php $this->load->view('devextreme'); ?>
<script>
	const URL = '<?= base_url() ?>Hse';

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

		const d = $.Deferred();
		const data = new DevExpress.data.CustomStore({
			key: 'id',
			load() {
				var data = [];
				$.ajax({
					type: "GET",
					url: URL + '/ajax_vendor_list_hse',
					//data: "data",
					dataType: "json",
					success: function(response) {
						d.resolve(response);
					}
				});
				return d.promise();

			},
		});

		$("#gridHse").dxDataGrid({
			dataSource: data,
			showBorders: true,
			showRowLines: true,
			columnAutoWidth: true,
			allowColumnResizing: true,
			allowColumnReordering: true,
			repaintChangesOnly: true,
			editing: {
				refreshMode: 'reshape',
				mode: "form",
				allowUpdating: false,
				// allowAdding: true
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
				enabled: true
			},
			columns: [{
					dataField: "id",
					visible: false,
					allowEditing: false
				},
				{     
				    caption : "Action",
					allowEditing: false,   
					width: 'auto',          
				    cellTemplate: function (container, options) {
				        var pr_number = options.data.vendor_id;
						if(options.data.status == '' || options.data.status == null){
							$("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?= site_url() ?>/administration/master_data/hse/verivikasi/"+pr_number+"') class='btn bg-light-info btn-sm' target='_blank'>Detail</a>"))

				        .appendTo(container);
						}
				            
				    }
				},
				
				{
					caption: "Vendor Name",
					dataField: "vendor_name",


				},
				{
					caption: "Tipe Vendor",
					dataField: "vendor_type",
				},
				{
					caption: "Score CQSMS",
					dataField: "score",
					allowEditing: false,
					cellTemplate: function (container, options) {
				        var type = options.data.cqsms_type;

						if(type == 1) {
							$("<div class='btn-group'>")
				            .append($("<span>"+options.data.cqsms_total_score+"</span>"))
							.appendTo(container);
						} else {
							$("<div class='btn-group'>")
				            .append($("<span>"+options.data.score+"</span>"))
							.appendTo(container);

						}
						
				    }
				},
				{
					caption: "Status",
					dataField: "status_view",
					allowEditing: false,
					
				},
				{
					caption: "Status HSE",
					dataField: "status_hse",
					allowEditing: false,
					cellTemplate: function (container, options) {
				        var type = options.data.cqsms_type;
						var score = options.data.cqsms_total_score;
						if(type == 1) {
							if(score > 80){
								$("<div class='btn-group'>")
								.append($("<span>HIGH RISK</span>"))
								.appendTo(container);
							} else if(score > 60){
								$("<div class='btn-group'>")
								.append($("<span>MEDIUM RISK</span>"))
								.appendTo(container);
							} else {
								$("<div class='btn-group'>")
								.append($("<span>LOW RISK</span>"))
								.appendTo(container);
							}
							
						} else {
							$("<div class='btn-group'>")
				            .append($("<span>"+options.data.status_hse+"</span>"))
							.appendTo(container);

						}
						
				    }
				},

			],

			
			onToolbarPreparing: function(e) {
				e.toolbarOptions.items.unshift({
					location: "after",
					widget: "dxButton",
					options: {
						icon: "refresh",
						onClick: function(e) {
							$("#gridHse").dxDataGrid("instance").refresh();
						}
					}
				});
			},
		});
	});
</script>
