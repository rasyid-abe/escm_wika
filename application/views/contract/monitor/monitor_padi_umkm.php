<div class="row">
	<div class="col-12">
		<div class="card">
			
			<div class="card-header border-bottom pb-2">
				<h4 class="card-title">Data PaDi UMKM</h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_padi_umkm" class="table table-bordered table-striped"></table>
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
				<h4 class="card-title">Data PaDi Transaksi</h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_padi_transaksi" class="table table-bordered table-striped"></table>
					</div>
				</div>
			</div>

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

	function operateUmkm(value, row, index) {
		var link = "#";
		return [
		'<a onclick=pushPadi("'+value+'") class="btn btn-danger btn-sm">',
		'<i class="ft-trash"></i> Hapus',
		'</a>  ',
		].join('');
	}

	function operateTransaksi(value, row, index) {
		var link = "#";
		return [
		'<a onclick=pushPadi("'+value+'") class="btn btn-danger btn-sm">',
		'<i class="ft-trash"></i> Hapus',
		'</a>  ',
		].join('');
	}

	function pushPadi(param) {

		alert("Delete Berhasil");
	}

</script>

<script type="text/javascript">

  var $table_padi_umkm = $('#table_padi_umkm'), selections = [];  

  var $table_padi_transaksi = $('#table_padi_transaksi'), selections = [];  

</script>

<script type="text/javascript">

	$(function () {

		$table_padi_umkm.bootstrapTable({

			url: "<?php echo site_url('contract/data_padi_umkm/') ?>",		

			cookieIdTable:"padi_umkm",
			
			idField:"uid",
			pageSize: 10, //your page size here
        	pageList: [10],//list of page sizes
			<?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG_NOSEARCH ?>
			columns: [  
				{
					field: "uid",
					title: '#',
					align: 'center',
					width:'8%',
					valign: 'middle',
					formatter: operateUmkm,
				}, 
				{
					field: 'uid',
					title: 'ID',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},     
				{
					field: 'nama_umkm',
					title: 'Nama UMKM',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
				{
					field: 'provinsi',
					title: 'Provinsi',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
				{
					field: 'kota',
					title: 'Kota',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
				{
					field: 'timestamp',
					title: 'Waktu/Tanggal',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
			]

		});

		setTimeout(function () {
			$table_padi_umkm.bootstrapTable('resetView');
		}, 200);

	});

</script>

<script type="text/javascript">

	$(function () {

		$table_padi_transaksi.bootstrapTable({

			url: "<?php echo site_url('contract/data_padi_transaksi/') ?>",		

			cookieIdTable:"padi_transaksi",
			
			idField:"transaksi_id",

			pageSize: 10, //your page size here
        pageList: [10],//list of page sizes
			<?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG_NOSEARCH ?>

			columns: [  
				{
					field: "timestamp",
					title: '#',
					align: 'center',
					width:'8%',
					valign: 'middle',
					formatter: operateTransaksi,
				}, 
				{
					field: 'transaksi_id',
					title: 'ID',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},     
				{
					field: 'nama_umkm',
					title: 'Nama UMKM',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
				{
					field: 'nama_project',
					title: 'Nama Project',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
				{
					field: 'kategori_project',
					title: 'Kategori',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
				{
					field: 'total_nilai_project',
					title: 'Total Nilai',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
				{
					field: 'deskripsi_project',
					title: 'Deskripsi',
					align: 'center',
					valign: 'middle',
					width:'20%',
				},
			]

		});

		setTimeout(function () {
			$table_padi_transaksi.bootstrapTable('resetView');
		}, 200);

	});

</script>