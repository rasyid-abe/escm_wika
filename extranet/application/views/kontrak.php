<div class="row">
	<div class="col-7">
		<div class="content-header"><strong><?php echo $this->lang->line('Monitor Kontrak'); ?></strong></div>			
	</div>
	<div class="col-5">
		<div class="content-header float-right">
			<a class="text-muted text-xs block h5" id="servertime"></a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">

			<div class="card-header border-bottom pb-2">
				<h4 class="card-title"><?php echo $this->lang->line('Header'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Nomor Pengadaaan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["ptm_number"]; ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Nomor Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["contract_number"] ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Nama Pengguna Barang/Jasa'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["ctr_spe_complete_name"] ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Vendor'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["vendor_name"] ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Tipe Penawaran'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["contract_type"] ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Tanggal Penandatanganan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["sign_date"]) ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Tanggal Mulai Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["start_date"]) ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Tanggal Berakhir Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["end_date"]) ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Nilai Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->cetakuang($nilai, $header["currency"]); ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Judul Pekerjaan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["subject_work"] ?></div>
					</div>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Deskripsi Pekerjaan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["scope_work"] ?></div>
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
				<h4 class="card-title"><?php echo $this->lang->line('Jaminan Pelaksanaan'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Nama Bank'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["pf_bank"]; ?></div>
					</div>
					<br>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Nomor Jaminan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["pf_number"] ?></div>
					</div>
					<br>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Mulai Berlaku'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["pf_start_date"]) ?></div>
					</div>
					<br>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Berlaku Hingga'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["pf_end_date"]) ?></div>
					</div>
					<br>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Nilai Jaminan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->cetakuang($header["pf_amount"], $header["currency"]) ?></div>
					</div>
					<br>
					<div class="row form-group"><label class="col-sm-4 control-label text-right"><?php echo $this->lang->line('Lampiran'); ?></label>						
						<div class="col-lg-6 m-l-n"><a target="_blank" href="<?php echo INTRANET_DOWNLOAD_URL."contract/jaminan/".$header["pf_attachment"] ?>"><?php echo $header["pf_attachment"] ?></a></div>
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
				<h4 class="card-title"><?php echo $this->lang->line('Item Kontrak'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>No</th>
									<th><?php echo $this->lang->line('Kode Barang/Jasa'); ?></th>
									<th><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th><?php echo $this->lang->line('Harga Satuan'); ?></th>
									<th><?php echo $this->lang->line('Satuan'); ?></th>
									<th><?php echo $this->lang->line('Jumlah'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								foreach($item as $row) { ?>
								<tr>
									<td><?php echo $i ?></td>
									<td><?php echo $row["tit_id"] ?></td>
									<td><?php echo $row["short_description"] ?></td>
									<td><?php echo inttomoney($row["price"]) ?></td>
									<td><?php echo $row["uom"] ?></td>
									<td><?php echo inttomoney($row["qty"]) ?></td>
								</tr>
								<?php
								$i++;
								}
								?>
							</tbody>
						</table>
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
				<h4 class="card-title"><?php echo $this->lang->line('Milestone'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>No</th>
									<th><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th><?php echo $this->lang->line('Target Tanggal'); ?></th>
									<th><?php echo $this->lang->line('Bobot (%)'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								foreach($milestone as $row) { ?>
								<tr>
									<td><?php echo $i ?></td>
									<td><?php echo $row["description"] ?></td>
									<td><?php echo $this->umum->show_tanggal($row["target_date"]) ?></td>
									<td><?php echo $row["progress_percentage"] ?></td>
								</tr>
								<?php
								$i++;
								}
								?>
							</tbody>
						</table>
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
				<h4 class="card-title"><?php echo $this->lang->line('Lampiran'); ?></h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>No</th>
									<th><?php echo $this->lang->line('Kategori'); ?></th>
									<th><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th><?php echo $this->lang->line('Nama File'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								foreach($lampiran as $row) { ?>
								<tr>
									<td><?php echo $i ?></td>
									<td><?php echo $row["category"] ?></td>
									<td><?php echo $row["description"] ?></td>
									<td><a href="<?php echo INTRANET_DOWNLOAD_URL."contract/document/".$row["filename"] ?>"><?php echo $row["filename"] ?></a></td>
								</tr>
								<?php
								$i++;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php if ($trm_num > 0) { ?>
		
	<div class="row">
		<div class="col-12">
			<div class="card">

				<div class="card-header border-bottom pb-2">
					<h4 class="card-title">Form Mengundurkan Diri</h4>
				</div>

				<div class="card-content">
					<div class="card-body">
						<div class="row form-group"><label class="col-sm-2 control-label text-right text-bold-700">Alasan Mengundurkan Diri</label>
							<div class="col-lg-6">: <?php echo $trm_row["reason"]; ?></div>
						</div>
						<div class="row form-group"><label class="col-sm-2 control-label text-right text-bold-700">Tanggal/Waktu</label>
							<div class="col-lg-6">: <?php echo $trm_row["created_date"]; ?></div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

<?php } else { ?>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body row">
						<div class="col-sm"></div>
						<div class="col-sm">
							<a href="#" class="btn btn-danger btn-block text-bold-700" data-toggle="modal" data-target="#large">
								Mengundurkan Diri 
							</a>
						</div>
						<div class="col-sm"></div>
					</div>
				</div>

			</div>
		</div>
	</div>

<?php } ?>

<!-- Modal -->
<div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Mengundurkan Diri</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form action="<?php echo site_url('kontrak/submit_terminasi');?>" method="POST">
				<div class="modal-body">
					<h5>Apakah Anda yakin akan Mengundurkan Diri?</h5>					
					<hr/>
					<h5>Alasan : </h5>
					<input type="hidden" name="ptm_number" value="<?php echo $header["ptm_number"]; ?>">
					<input type="hidden" name="contract_number" value="<?php echo $header["contract_number"]; ?>">
					<input type="hidden" name="contract_id" value="<?php echo $header["contract_id"]; ?>">
					<textarea rows="6" cols="100" class="form-control" name="reason" placeholder="The reason is..."></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn bg-light-secondary" data-dismiss="modal">Batal</button>
					<input type="submit" class="btn btn-danger text-bold-700" onclick="return confirm('Apakah anda yakin?')" value="Kirim">
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.dataTables-example').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
	});
</script>