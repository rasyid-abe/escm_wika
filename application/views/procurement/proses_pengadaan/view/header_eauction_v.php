<?php if($prep['ptp_eauction']){ ?>

	<div class="row">
		<div class="col-12">
			<div class="card">
			
			<div class="card-header border-bottom pb-2">
				<h4 class="card-title">Riwayat E-Reverse Auction</h4>
			</div>

			<div class="card-content">
				<div class="card-body">
					<table class="table table-bordered" id="item_table">
						<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Judul</th>
								<th>Deskripsi</th>
								<th>Tipe</th>
								<th>Mulai</th>
								<th>Selesai</th>
								
								<th>Batas Atas</th>
								<th>Batas Bawah</th>
							</tr>
						</thead>
						<tbody>
						<?php 

						if(isset($hist_eauction_header) && !empty($hist_eauction_header)){
							foreach ($hist_eauction_header as $key => $value) { ?>

								<tr>
									<td>
										<?php echo $key+1 ?>
									</td>
									<td>
										<?php echo date(DEFAULT_FORMAT_DATE,strtotime($value['created_date'])); ?>
									</td>
									<td>
										<?php echo $value['judul'] ?>
									</td>
									<td>
										<?php echo $value['deskripsi'] ?>
									</td>
									<td>
										<?php echo ($value['tipe'] == "A") ? "Paket" : "Itemize" ?>
									</td>
									<td>
										<?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($value['tanggal_mulai'])) ?>
									</td>
									<td>
										<?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($value['tanggal_berakhir'])) ?>
									</td>
									<td class="text-right">
										<?php echo inttomoney($value['batas_atas']) ?> (<?php echo $value['batas_atas_percent'] ?>%)
									</td>
									<td class="text-right">
										<?php echo inttomoney($value['batas_bawah']) ?> (<?php echo $value['batas_bawah_percent'] ?>%)
									</td>
									
								</tr>

							<?php } } ?>

						</tbody>
					</table>
				</div>
			</div>

			</div>
		</div>
	</div>

<?php } ?>