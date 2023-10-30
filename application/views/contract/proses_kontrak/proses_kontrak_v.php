<style>
	.table {
		text-align: center;
	}
	.segitiga2 {
		height: 0px;
		width: 0px;
		border-left: 1.2em solid rgb(42 171 226) !important;
		border-top: solid 2.3em transparent;
		border-bottom: solid 2.3em transparent;
		display: none;
	}

	.bg-info {
		background-color: #ffffff !important;
	}

	.step {
		font-size: 11px;
		margin: auto;
		/* box-shadow: 0 0 11px rgba(33,33,33,.2); */
		padding-top: 15px;
		padding-bottom: 10px;
		/* padding-left: 10px !important; */
		border-radius: 10px;
	}

	.card {
		border-radius: 1.35rem;
	}

	.breadcrumb-escm {
		border: 1px solid #d1d3d4;
	}

	.wrapper-icon {
		display: flex;
		align-items: center;
		margin-left: 8px;
		padding: 5px;
	}

	.wrapper-icon:hover {
		background-color: #eaeaea;
		border-radius: 8px;
	}
	.shadow-none {
		width: 20%;
		border: 1px solid #d1d3d4;
		background-color: white;
		style="background-color: white;"
	}
	textarea.form-control {
		background-color: transparent;
		color: #606060;
	}
	input.form-control {
		background-color: transparent;
		color: #606060;
	}
	.bg-update {
        background-color: #29a7de !important;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">

	<?php
		$status_1 = 'Menunggu proses';
		$status_2 = 'Menunggu proses';
		$status_3 = 'Menunggu proses';
		$status_4 = 'Menunggu proses';
		$status_5 = 'Menunggu proses';

		$color1 = 'text-dark';
		$color2 = 'text-dark';
		$color3 = 'text-dark';
		$color4 = 'text-dark';
		$color5 = 'text-dark';

		$bgcolor1 = "bg-white";
		$bgcolor2 = "bg-white";
		$bgcolor3 = "bg-white";
		$bgcolor4 = "bg-white";
		$bgcolor5 = "bg-white";

		if ($activity_id >= 2010) {
			$bgcolor1 = "bg-update";
			$color1 = 'text-white';
			$status_1 = isset($end_date_1["end_date"]) ? $end_date_1["end_date"] : "Menunggu Proses";
		}

		if ($activity_id >= 2027) {
			$bgcolor2 = "bg-update";
			$color2 = 'text-white';
			$status_2 = isset($end_date_2["end_date"]) ? $end_date_2["end_date"] : "Menunggu Proses";
		}

		if ($activity_id >= 2030) {
			$bgcolor3 = "bg-update";
			$color3 = 'text-white';
			$status_3 = isset($end_date_3["end_date"]) ? $end_date_3["end_date"] : "Menunggu Proses";
		}

		if ($activity_id >= 2901) {
			$bgcolor4 = "bg-update";
			$color4 = 'text-white';
			$status_4 = isset($end_date_4["end_date"]) ? $end_date_4["end_date"] : "Menunggu Proses";
		}

		if ($activity_id == 2903) {
			$bgcolor5 = "bg-update";
			$color5 = 'text-white';
			$status_5 = isset($end_date_5["end_date"]) ? $end_date_5["end_date"] : "Menunggu Proses";
		}
	?>

	<div class="row step mb-2">
		<div class="shadow-none rounded-0 mb-1" style="border-radius: 10px 0px 0px 10px !important;">
			<div class="px-2 py-1 <?php echo $bgcolor1;?> <?php echo $color1;?>">
				<p class="mb-1 font-weight-bold">Pembuatan Kontrak</p>
				<small><?php echo $status_1; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1">
			<div class="px-2 py-1 <?php echo $bgcolor2;?> <?php echo $color2;?>">
				<p class="mb-1 font-weight-bold">Approval Kontrak</p>
				<small><?php echo $status_2; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1">
			<div class="px-2 py-1 <?php echo $bgcolor3;?> <?php echo $color3;?>">
				<p class="mb-1 font-weight-bold">Finalisasi Kontrak</p>
				<small><?php echo $status_3; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1">
			<div class="px-2 py-1 <?php echo $bgcolor4;?> <?php echo $color4;?>">
				<p class="mb-1 font-weight-bold">Kontrak Aktif</p>
				<small><?php echo $status_4; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
		<div class="shadow-none rounded-0 mb-1" style="border-radius: 0px 10px 10px 0px !important;">
			<div class="px-2 py-1 <?php echo $bgcolor5;?> <?php echo $color5;?>">
				<p class="mb-1 font-weight-bold">Kontrak Selesai</p>
				<small><?php echo $status_5; ?></small>
			</div>
			<div class="segitiga"></div>
		</div>
	</div>

	<form method="post" action="<?php echo site_url($controller_name."/submit_proses_kontrak");?>"  class="form-horizontal ajaxform">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<?php
		foreach ($content as $key => $value) {
			include($value['awc_type']."/".$value['awc_file'].".php");
		}

		?>

		<?php if ($history_amd_num > 1) { ?>
			<div class="row">
				<div class="col-12">
					<div class="card">

					<div class="card-header border-bottom pb-2">
						<div class="btn-group-sm float-left">
						<span class="card-title text-bold-600 mr-2">History Amandemen Kontrak</span>
						</div>
					</div>

					<div class="card-content">
						<div class="card-body">
						<div class="table-responsive table-striped">
							<table class="table comment" style="margin-bottom: 0;">
							<thead>
								<tr>
								<th>No</th>
								<th>Nomor Kontrak</th>
								<th>Nilai Kontrak</th>
								<th>Type</th>
								<th>Alasan</th>
								<th>Tanggal</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								if (isset($history_amd) && !empty($history_amd)) {
								foreach ($history_amd as $key => $value) {
								?>

									<tr>
									<td><?php echo $no++; ?></td>
									<td>
										<a href="<?php echo site_url('contract/monitor/monitor_kontrak/lihat/' . $value['contract_id'])?>" target="_blank">
										<?php echo $value['contract_number'] ?>
										</a>
									</td>
									<td>
										<?php echo inttomoney($value['contract_amount']) ?>
									</td>
									<td>
										<?php echo $value['ctr_item_type'] ?>
									</td>
									<td>
										<?php echo $value['terminate_reason'] ?>
									</td>
									<td>
										<?php echo $value['created_date'] ?>
									</td>
									</tr>

								<?php }
								} ?>
							</tbody>
							</table>
						</div>

						</div>
					</div>

					</div>
				</div>
			</div>
		<?php } ?>

		<?php
		$i = 0;
		include(VIEWPATH."/comment_workflow_attachment_v.php") ?>

		<div class="card">
			<div class="card-content">
				<div class="card-body">
					<?php echo buttonsubmit('contract/daftar_pekerjaan',lang('back'),lang('save')) ?>
				</div>
			</div>
		</div>

	</form>

	<script type="text/javascript">localStorage.setItem('dialogshow', "");</script>

</div>

<script>

	function getMaxDataNo(selector) {
      var min=null, max=null;
      $(selector).each(function() {
        var no_pp = parseInt($(this).attr('data-no'), 10);
        if ((max===null) || (no_pp > max)) { max = no_pp; }
      });
      return max;
    }

</script>
