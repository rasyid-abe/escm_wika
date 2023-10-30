<?php if(!empty($message)){ ?>	
	<div class="alert bg-light-info alert-dismissible mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
		</button>
		<span><?php echo $message ?></span>
	</div>
<?php $this->session->unset_userdata("message"); } ?>

<div class="row">
	<div class="col-12">
		<div class="card">

			<div class="card-header border-bottom pb-2">
				<h4 class="card-title"><?php if(!isset($title) || empty($title)) { echo $this->lang->line('Daftar Pekerjaan'); } else { echo $title; } ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered datatabless">
							<thead>
							<tr>
								<th>Action</th>
								<th><?php echo $this->lang->line('Status'); ?></th>
								<th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
								<th><?php echo $this->lang->line('Nomor Kontrak'); ?></th>
								<th><?php echo $this->lang->line('Deskripsi Pekerjaan'); ?></th>
								<th><?php echo $this->lang->line('Jenis Kontrak'); ?></th>
								<th><?php echo $this->lang->line('Tanggal Mulai Kontrak'); ?></th>
								<th><?php echo $this->lang->line('Tanggal Berakhir Kontrak'); ?></th>
								<th><?php echo $this->lang->line('Nilai Kontrak'); ?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($list as $row) { ?>
							<tr>
								<form action="<?php echo site_url('kontrak/view') ?>" method="POST">
									<input type="hidden" id="ids" name="ids" value="<?php echo $row["contract_id"]; ?>">
									<td style="text-align: center;"><button type="submit" class="btn btn-info"><?php echo $this->lang->line('Pilih'); ?></button></td>
									<td><?php echo $row["status"]; ?></td>
									<td><?php echo $row["ptm_number"]; ?></td>
									<td><?php echo $row["contract_number"]; ?></td>
									<td><?php echo $row["subject_work"]; ?></td>
									<td><?php echo $row["contract_type"]; ?></td>
									<td><?php echo $this->umum->show_tanggal($row["start_date"]) ?></td>
									<td><?php echo $this->umum->show_tanggal($row["end_date"]) ?></td>
									<td><?php echo $this->umum->cetakuang($row["total_ppn"], $row["currency"])?></td>
								</form>
							</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.datatabless').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
	});
</script>
