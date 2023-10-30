<div class="row">
	<div class="col-7">
		<div class="content-header"><strong><?php echo ($viewer) ? "Lihat" : "Form"; ?> Invoice Milestone</strong></div>			
	</div>
	<div class="col-5">
		<div class="content-header float-right">
			<a class="text-muted text-xs block h5" id="servertime"></a>
		</div>
	</div>
</div>

<form class="form-horizontal" method="post" action="<?php echo site_url('kontrak/submit_invoice_milestone') ?>" enctype="multipart/form-data">
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?php echo $this->lang->line('Header'); ?></h5>
					</div>
					<div class="ibox-content">

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Nomor Kontrak
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<input type="hidden" name="milestone_id" value="<?php echo $header['milestone_id']?>">
									<?php echo $header["contract_number"]; ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Judul Kontrak
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["subject_work"] ?>

								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Deskripsi Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["description"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Target Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo date("d/m/Y",strtotime($header["target_date"])) ?>
								</p>
							</div>
						</div>  

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Presentase Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["percentage"] ?> % 

								</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Riwayat Progress</h5>
					</div>
					<div class="ibox-content">

						<table class="table table-striped table-bordered table-hover milestone_table">

							<thead>

								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Deskripsi Progress</th>
									<th>Persentase</th>
								</tr>

							</thead>

							<tbody>

								<?php 
								foreach ($item as $key => $value) { ?>

								<tr>
									<td><?php echo $key+1 ?></td>
									<td><?php echo date('d/m/Y',strtotime($value['progress_date'])) ?></td>
									<td><?php echo $value['description'] ?></td>
									<td><?php echo $value['percentage'] ?> %</td>
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
					<h5>BASTP/B</h5>
				</div>
				<div class="ibox-content">

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Nomor BASTP/B
						</label>
						<div class="col-lg-6 m-l-n">
							<p class="form-control-static">
								<?php echo $header['bastp_number']?>
							</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Tanggal
						</label>
						<div class="col-lg-3 m-l-n">		
							<p class="form-control-static">
								<?php echo $header['bastp_date']; ?>
							</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Judul
						</label>
						<div class="col-lg-6 m-l-n">
							
							<p class="form-control-static">
								<?php echo $header['bastp_title']; ?>
							</p>
	
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Berita Acara
						</label>
						
						<div class="col-lg-6 m-l-n">
							<p class="form-control-static">
								<?php echo $header['bastp_description']; ?>
							</p>
							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Lampiran
						</label>
						<div class="col-lg-3 m-l-n">
							<p class="form-control-static">
								<a href="<?php echo site_url('kontrak/download/bast_milestone/'.$this->umum->forbidden($this->encryption->encrypt($header["bastp_attachment"]), 'enkrip')); ?>" target="_blank">
								<?php echo $header['bastp_attachment']; ?>
								</a>

							</p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Penagihan</h5>
				</div>
				<div class="ibox-content">

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Nomor Invoice *
						</label>
						<div class="col-lg-6 m-l-n">
							<p class="form-control-static">
								<?php 
								// echo (!empty($header['invoice_number'])) ? $header['invoice_number'] : "AUTO NUMBER"; 
									if (!$viewer) { ?>
										<input type="text" class="form-control" required name="invoice_number" value="<?php echo !empty($header['invoice_number']) ? $header['invoice_number'] : ''; ?>">
								<?php }else{ 

									echo $header['invoice_number'];
												
									 }
								?>

							</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Tanggal *
						</label>
						<div class="col-lg-3 m-l-n">
							<?php if(!$viewer){ ?>
							<input type="date" class="form-control"  name="tgl_invoice" value="<?php echo (!empty($header['invoice_date'])) ? date("Y-m-d",strtotime($header['invoice_date'])) : date('Y-m-d') ?>" required>
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['invoice_date'])) ? date("Y-m-d",strtotime($header['invoice_date'])) : ""; ?>
							</p>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Judul *
						</label>
						<div class="col-lg-6 m-l-n">
							<?php if(!$viewer){ ?>
							<input type="text" class="form-control" required name="judul_invoice" value="<?php echo (!empty($header['invoice_title'])) ? $header['invoice_title'] : "";  ?>">
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['invoice_title'])) ? $header['invoice_title'] : ""; ?>
							</p>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Keterangan Tagihan *
						</label>
						<div class="col-lg-6 m-l-n">
						<?php if(!$viewer){ ?>
							<textarea name="desk_invoice" class="form-control" required><?php echo (!empty($header['invoice_description'])) ? $header['invoice_description'] : ""; ?>
							</textarea>
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['invoice_description'])) ? $header['invoice_description'] : ""; ?>
							</p>
							<?php } ?>
							
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-2 control-label">
							Rekening Bank * 
						</label>

						<div class="col-lg-6 m-l-n">
							<?php if(!$viewer){ ?>
							<select class="form-control" id="sel1" name="bank_inp" required="">
								<option value=""> -- Pilih Rekening Bank -- </option>
								<?php foreach ($bank as $row) {?>
									<option value="<?php echo $row['accountNo']?> - <?php echo $row['bankName'] ?>" <?php echo isset($header["bank_account"]) AND $header["bank_account"] == $row['accountNo'].' - '.$row['bankName'] ? 'selected' : '' ?> ><?php echo $row['accountNo']?> - <?php echo $row['bankName'] ?>
									</option>
								<?php } ?>
							 </select>
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['invoice_title'])) ? $header['invoice_title'] : ""; ?>
							</p>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Lampiran *
						</label>
						<div class="col-lg-3 m-l-n">
							<?php if(!$viewer){ ?>
							<input type="file" class="form-control" required name="lampiran_milestone_invoice">
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['invoice_attachment'])) ? $header['invoice_attachment'] : ""; ?>
							</p>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- item list -->

		  <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Item List &nbsp; <button type="button" class="btn btn-xs btn-default" data-toggle="popover" title="List Item" data-content="Item dan volume/jumlahnya pada termin ini"><span class="glyphicon glyphicon-question-sign"></span></button></h5>
                    </div>
               	<div class="ibox-content">


            <table class="table table-bordered milestone_table" id="item_table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Item</th>
                  <th>Volume</th>
                  <th>Satuan</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if(isset($item_progress) && !empty($item_progress)){
                	$no= 1;
                  foreach ($item_progress as $key => $value) {
                   ?>

                  <tr>
                    <td>
                      <?php echo $no ?>
                    </td>
                    <td>
                      <?php echo $value['item_code'] ?>
                    </td>
                    <td>
                      <?php echo $value['short_description'] ?>
                    </td>
                    <td class="text-right">
                      <?php echo inttomoney($value['qty_progress']) ?>
                    </td>
                    <td>
                      <?php echo $value['uom'] ?>
                    </td>
                  </tr>

                  <?php
                  $no++;
               } } ?>

             </tbody>
            </table>


                    </div>
                </div>
            </div>
        </div>

        <!-- End item list -->

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

						<table class="table comment milestone_table">
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
				$('.milestone_table').DataTable({
					"order": [[ 0, "desc" ]],
					"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
				});
			});
		</script>