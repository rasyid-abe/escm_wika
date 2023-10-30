<div class="row">
	<div class="col-7">
		<div class="content-header"><strong><?php echo ($viewer) ? "Lihat" : "Form"; ?> Progress PO</strong></div>			
	</div>
	<div class="col-5">
		<div class="content-header float-right">
			<a class="text-muted text-xs block h5" id="servertime"></a>
		</div>
	</div>
</div>

<?php 
$pesan = $this->session->userdata("msg");
if(!empty($pesan)){ ?>
<script type="text/javascript">
	swal("Error", "<?php echo $pesan; ?>", "error");
</script>
<?php $this->session->unset_userdata("msg"); } ?>

<form class="form-horizontal" method="post" action="<?php echo site_url('kontrak/submit_progress_wo') ?>">

	<input type="hidden" name="ids" value="<?php echo $this->input->post('ids') ?>">

	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?php echo $this->lang->line('Header'); ?></h5>
					</div>
					<div class="ibox-content">

						<div class="form-group">
							<label class="col-sm-2 control-label">Nomor Kontrak</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["contract_number"]; ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Nama Pembuat PO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["fullname"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Vendor</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["vendor_name"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Mulai PO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $this->umum->show_tanggal($header["start_date"]) ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Selesai PO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $this->umum->show_tanggal($header["end_date"]) ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi PO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["po_notes"] ?>
								</p>
							</div>
						</div>

						<?php if(!$viewer){ ?>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Progress *</label>
							<div class="col-lg-3 m-l-n">

								<input type="date" name="tanggal_inp" required class="form-control" value="<?php echo $header['progress_date'] ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi Progress *</label>
							<div class="col-lg-6 m-l-n">
								<textarea name="progress_inp" required class="form-control"><?php echo $header['progress_description'] ?></textarea>
							</div>
						</div>

						<?php $curval = (!empty($header['progress_percentage'])) ? $header['progress_percentage'] : 0 ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Presentase Progress *</label>
							<div class="col-lg-2 m-l-n">
								<div class="input-group">
									<input id="persentase" type="text" required class="form-control money" name="presentase_inp" value="<?php echo $curval ?>" readonly>
									<span class="input-group-addon">%</span>
								</div>
								
							</div>
						</div>

						<?php } else { ?>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Progress</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo date("d/m/Y",strtotime($header["progress_date"])) ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi Progress</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["progress_description"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Persentase Progress</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["progress_percentage"] ?>%
								</p>
							</div>
						</div>

						<?php } ?>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Item</h5>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">

							<table class="table table-striped table-bordered table-hover dataTables-example">

								<thead>

									<tr>
										<th>No</th>
										<th>Kode <br/>Barang / Jasa</th>
										<th>Deskripsi</th>
										<th>Satuan</th>
										<th>Harga Satuan<!-- <br/>(Sebelum Pajak) --></th>
										<th style="display: none;">Pajak</th>
										<th>Jumlah PO</th>
										<th>Jumlah sudah dikirim sebelumnya</th>
										<th>Jumlah dikirim saat ini</th>
									</tr>

								</thead>

								<tbody>

									<?php 
									$subtotal = 0;
									$subtotal_ppn = 0;
									$subtotal_pph = 0;
									$jumlahpo = 0;
									$dikirim = 0;
									$i = 1;
									foreach ($item as $key => $value) { ?>

									<tr>
										<td><?php echo $key+1 ?></td>
										<td><?php echo $value['item_code'] ?></td>
										<td><?php echo $value['short_description'] ?></td>
										<td><?php echo $value['uom'] ?></td>
										<td class="text-right"><?php echo inttomoney($value['price']) ?></td>
										<td style="display: none;">
											<?php echo (!empty($value['ppn'])) ? " PPN (".$value['ppn']."%) " : "" ?> 
											<?php echo (!empty($value['pph'])) ? " PPH (".$value['pph']."%)" : "" ?> 
										</td>
										<td class="text-right"><?php echo inttomoney($value['qty']) ?></td>
										<td class="text-right"><?php echo (!empty($value['approved_qty'])) ? inttomoney($value['approved_qty']) : 0 ?></td>
										<td class="text-right">
											<?php if(!$viewer){ ?>
											<input type="text" id="item_<?php echo $i?>" class="form-control jumlah" style="text-align: right;" name="send[<?php echo $value['po_item_id'] ?>]" value="<?php echo (!empty($value['send'])) ? inttomoney($value['send']) : 0 ?>">
											<?php } else { ?>
											<p class="form-control-static">
												<?php echo inttomoney($value['progress_qty']) ?></p>
												<?php } ?>
											</td>

										</tr>
										<?php 
										$subtotal += $value['price']*$value['qty'];
										if(!empty($value['ppn'])){
											$subtotal_ppn += $value['price']*$value['qty']*($value['ppn']/100);
										}
										if(!empty($value['pph'])){
											$subtotal_pph += $value['price']*$value['qty']*($value['pph']/100);
										}
									
										$jumlahpo += $value['qty'];
										$dikirim += $value['approved_qty'];
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
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>List Komentar</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">

						<table class="table comment dataTables-example">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Nama</th>
									<th>Tipe</th>
									<th>Aktifitas</th>
									<th>Komentar</th>
								</tr>
							</thead>
							<tbody>

								<?php if(isset($comment_list) && !empty($comment_list)){ 

									foreach ($comment_list as $kc => $vc) {
										$start_date = date("d/m/Y H:i:s",strtotime($vc['comment_date']));
										?>
										<tr>
											<td><?php echo $start_date ?></td>
											<td><?php echo $vc['comment_name'] ?></td>
											<td><?php echo $vc['comment_type'] ? "Vendor" : "Internal" ?></td>
											<td><?php echo $vc['comment_activity'] ?></td>
											<td><?php echo $vc['comments'] ?></td>
										</tr>
										<?php } } ?>

									</tbody>

								</table>

							</div>
						</div>
					</div>
				</div>

				<?php if(!$viewer){ ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Form Komentar</h5>
							</div>
							<div class="ibox-content">

								<div class="form-group">
									<label class="col-sm-2 control-label">Komentar</label>
									<div class="col-lg-10 m-l-n">
										<textarea name="komentar_inp" class="form-control"></textarea>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12 m-l-n text-center">

										<a href="javascript:window.history.go(-1);" class="btn btn-light">Kembali</a>
										<button class="btn btn-primary" type="submit">Simpan</button>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<?php } else { ?>
				<a href="javascript:window.history.go(-1);" class="btn btn-light">Kembali</a>
				<?php } ?> 

			</form>

		</div>

		<script>
			$(document).ready(function() {
				$('.dataTables-example').DataTable({
					"order": [[ 0, "desc" ]],
					"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
				});

				$('.jumlah').change(function() {
	    			
	    			var num = <?php echo $i-1 ?>;
	    			var jumlah = parseFloat(<?php echo $jumlahpo ?>);
	    			var sisa = parseFloat(<?php echo $jumlahpo ?>) - parseFloat(<?php echo $dikirim ?>)
	    			var all = 0;
	    			var lastpercent = <?php echo $curval ?>;

					for(i=1; i<=num; i++){
						all += parseFloat($("#item_"+i).val());
					}

					totalpersen = ((all/jumlah)*100)+lastpercent;

					// $("#persentase").text(totalpersen.toFixed(0));
					$("#persentase").val(totalpersen.toFixed(0));
				});

			});
		</script>