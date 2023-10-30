<div class="row">
	<div class="col-7">
		<div class="content-header"><strong><?php echo $this->lang->line('Monitor Tagihan'); ?></strong></div>			
	</div>
	<div class="col-5">
		<div class="content-header float-right">
			<a class="text-muted text-xs block h5" id="servertime"></a>
		</div>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Header'); ?></h5>
				</div>
				<div class="ibox-content">
						<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nama Vendor'); ?></label>
							<div class="col-lg-6 m-l-n"><?php echo $header["vendor_name"]; ?></div>
						</div>
						<br>
						<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Tanggal Penagihan'); ?></label>
							<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["invoice_date"]) ?></div>
						</div>
						<br>
						<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nomor Penagihan'); ?></label>
							<div class="col-lg-6 m-l-n"><?php echo $header["invoice_number"] ?></div>
						</div>
						<br>
						<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nomor Kontrak'); ?></label>
							<div class="col-lg-6 m-l-n"><?php echo $header["contract_number"] ?></div>
						</div>
						<br>
						<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Rekening Bank'); ?></label>
							<div class="col-lg-6 m-l-n"><?php echo $header["bank_account"] ?></div>
						</div>
				</div>
			</div>
		</div>
	</div>


		<!-- <div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Item</h5>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">

							<table class="table table-striped table-bordered table-hover">

								<thead>

									<tr>
										<th>No</th>
										<th>Kode <br/>Barang / Jasa</th>
										<th>Deskripsi</th>
										<th>Satuan</th>
										<th>Harga Satuan<br/>(Sebelum Pajak)</th>
										<th>Pajak</th>
										<th>Jumlah WO</th>
										<th>Jumlah yang dikirim</th>
										<th>Harga</th>
									</tr>

								</thead>

								<tbody>

									<?php 
									$subtotal = 0;
									$subtotal_ppn = 0;
									$subtotal_pph = 0;
									foreach ($item as $key => $value) { ?>

									<tr>
										<td><?php echo $key+1 ?></td>
										<td><?php echo $value['item_code'] ?></td>
										<td><?php echo $value['short_description'] ?></td>
										<td><?php echo $value['uom'] ?></td>
										<td class="text-right"><?php echo inttomoney($value['price']) ?></td>
										<td >
											<?php echo (!empty($value['ppn'])) ? " PPN (".$value['ppn']."%) " : "" ?> 
											<?php echo (!empty($value['pph'])) ? " PPH (".$value['pph']."%)" : "" ?> 
										</td>
										<td class="text-right"><?php echo inttomoney($value['qty']) ?></td>
										<td class="text-right">
											<?php echo (!empty($value['approved_qty'])) ? inttomoney($value['approved_qty']) : 0 ?>
										</td>
										<td class="text-right">Rp <?php echo inttomoney($value['approved_qty']*$value['price']+($value['price']*$value['approved_qty']*($value['ppn']/100))+($value['price']*$value['approved_qty']*($value['pph']/100))) ?></td>

									</tr>
									<?php 
									$subtotal += $value['price']*$value['approved_qty']+($value['price']*$value['approved_qty']*($value['ppn']/100))+($value['price']*$value['approved_qty']*($value['pph']/100));
									} ?>

								<tr>
									<td colspan="8" class="text-right"><h3>Jumlah Total</h3></td>
									<td><h3 class="text-right">Rp <?php echo inttomoney($subtotal) ?></h3></td>
								</tr>

							</tbody>

						</table>

					</div>
				</div>
			</div>
		</div>
	</div> -->

	<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Penagihan</h5>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">

							<table class="table table-striped table-bordered table-hover">

								<thead>

									<tr>
										<th>No</th>
										<th>Penagihan</th>
										<th width="15%">Judul</th>
										<th>Valuta</th>
										<th>Persentase</th>
										<th style="display: none;">Nilai Tagihan<br/>(Sebelum Pajak)</th>
										<th>Nilai Tagihan<!-- <br/>(Sesudah Pajak) --></th>
										<th width="20%">Denda</th>
										<th>Jumlah Yang Harus Dibayar</th>
									</tr>

								</thead>

								<tbody>
									<?php 
										$tagihan = $header_invoice['contract_amount']*$header_invoice['percentage']/100;
										$tagihan_inc_tax = $tagihan + ($tagihan *10/100);
									?>

									<tr>
										<td>1</td>
										<td><?php echo $header_invoice['invoice_number'];?></td>
										<td><?php echo $header_invoice['description'];?></td>
										<td>IDR</td>
										<td class="text-right"><?php echo $header_invoice['percentage'];?>%</td>
										<td><?php echo inttomoney($tagihan);?></td>
										<td style="display: none;"><input type="hidden" name="pay_old_inp" value="<?php echo $tagihan_inc_tax;?>"><?php echo inttomoney($tagihan_inc_tax);?></td>
										<?php if($viewer){ ?>
										<td >
												<input type="number" class="form-control money form-control-danger text-right denda" placeholder="Masukkan Denda" data-bayar="<?php echo $tagihan_inc_tax;?>" maxlength="30" name="denda_inp">
										</td>
										<?php } else { ?>
										<td>									
											<?php echo inttomoney($header_invoice['denda_invoice']); ?>
										</td>
										<?php } ?>
										
										<td>
											<?php if($viewer){ ?>
													<input type="hidden" name="jml_dibayar_inp" class="pay_inp"><h5 class="pay">Rp <?php echo inttomoney($tagihan_inc_tax) ?></h5>
											<?php } else { ?>
												
												<?php echo inttomoney($header_invoice['acc_invoice']);?>
											<?php } ?>
										</td>

									</tr>				

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
					<h5>LAMPIRAN</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">

					<table class="table table-bordered default">
						<thead>
							<tr>
								<th>No</th>
								<th>Kategori</th>
								<th>Deskripsi</th>
								<th>File</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($lampiranList as $k => $v) {?>
							<tr>
								<td><?php echo $k+1 ?></td>
								<td><?php echo $v["category"] ?></td>
								<td><?php echo $v['description'] ?></td>
								<td><a href="<?php echo site_url(INTRANET_DOWNLOAD_URL.'log/download_attachment/procurement/permintaan/'.$v['filename']) ?>" target="_blank">
									<?php echo $v['filename'] ?>
								</a></td>
							</tr>
							<?php } ?>
							



						</tbody>
					</table>

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

			
			<a href="javascript:window.history.go(-1);" class="btn btn-light">Kembali</a>
		</form>

	</div>

<script>
	$(document).ready(function() {
		$('.dataTables-example').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
	});
</script>