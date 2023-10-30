<?php
if(isset($readonly)){
if($readonly == "1"){
$readonly = "readonly";
}
else{
	$readonly = "";
}
}
else{
$readonly = "";
}
if($modes == "harga"){
	$hanyabaca = " disabled";
}
else{
	$hanyabaca = "";
}

?>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-12">
			<div class="card" style="border-radius: 20px;">
				<div class="card-header border-bottom pb-2">
					<div class="btn-group-sm">
						<h4 class="card-title"><?php echo $this->lang->line('Penawaran'); ?></h4>                    
					</div>                
				</div>
				<div class="card-content">
					<div class="card-body">                    
						<form role="form" id="header" method="POST" action="<?php echo site_url('pengadaan/submit_duatahap') ?>" class="form-horizontal">	
							<input type="hidden" id="section" name="section" value="header">
							<input type="hidden" id="pqmid" name="pqmid" value="<?php if(isset($header)){ echo $header["pqm_id"]; } ?>">
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nomor Pengadaaan'); ?></label>
								<div class="col-lg-6 m-l-n"><input readonly id="tenderid" name="tenderid" type="text" class="form-control" value="<?php echo $tenderid; ?>"></div>
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nomor Penawaran'); ?> *</label>
								<div class="col-lg-6 m-l-n"><input <?php echo $readonly; echo $hanyabaca; ?> id="nopenawaran" name="nopenawaran" type="text" class="form-control" value="<?php if(isset($header)){ echo $header["pqm_number"]; } ?>" required></div>
							</div>
							<div class="form-group" style="display: none"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Tipe Penawaran'); ?> *</label>
								<div class="col-md-2 m-l-n"><select <?php echo $readonly; echo $hanyabaca; ?> class="form-control m-b" name="tipepenawaran" id="tipepenawaran" required>
									<option value="">--<?php echo $this->lang->line('PILIH'); ?>--</option>
									<option value="A" selected <?php if(isset($header)) { if(($header["pqm_type"] == "A")){ echo "selected";} } ?>><?php echo $this->lang->line('Tipe'); ?> A</option>
									<option value="B" <?php if(isset($header)) { if(($header["pqm_type"] == "B")){ echo "selected";} } ?>><?php echo $this->lang->line('Tipe'); ?> B</option>
									<option value="C" <?php if(isset($header)) { if(($header["pqm_type"] == "C")){ echo "selected";} } ?>><?php echo $this->lang->line('Tipe'); ?> C</option>
								</select>
								</div>
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nilai Bidbond'); ?></label>
								<div class="col-lg-6 m-l-n"><input <?php echo $readonly; echo $hanyabaca; ?> onblur="fnChange('','bid_bond')" type="text" id="bid_bond" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_bid_bond_value"]; } ?>"></div>
								<input type="hidden" id="bid_bond_input" name="bid_bond_input" value="<?php if(isset($header)) { echo $header["pqm_bid_bond_value"]; } ?>">
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Lampiran Bidbond'); ?> <small>(Max 2MB)</small></label>
								<div class="col-lg-6 m-l-n"><input <?php echo $readonly; echo $hanyabaca; ?> id="lampiran_bidbond" name="lampiran_bidbond" type="file" class="file"><?php if(isset($header)){ ?><a href="<?php echo site_url('pengadaan/download/bidbond/'.$this->umum->forbidden($this->encryption->encrypt($header["pqm_att"]), 'enkrip')); ?>"><?php echo $header["pqm_att"]; ?></a><?php } ?></div>
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label">Target Penilaian TKDN (%)</label>
								<div class="col-md-2 m-l-n"><input <?php echo $readonly; echo $hanyabaca; ?> id="kandunganlokal" name="kandunganlokal" placeholder="%" type="number" min="0" max="100" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_local_content"]; } ?>"></div>
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Jangka Waktu Pelaksanaan'); ?> *</label>
								<div class="col-md-2 m-l-n"><input <?php echo $readonly; echo $hanyabaca; ?> id="jangkawaktu" name="jangkawaktu" type="number" class="form-control" required value="<?php if(isset($header)) { echo $header["pqm_delivery_time"]; } ?>">
								</div>
								<div class="col-md-2 m-l-n">
									<select <?php echo $readonly ?> class="form-control m-b" name="timeunit" id="timeunit" required>
										<option value="D" <?php if(isset($header)) { if(($header["pqm_delivery_unit"] == "D")){ echo "selected";} } ?>><?php echo $this->lang->line('HARI'); ?></option>
										<option value="M" <?php if(isset($header)) { if(($header["pqm_delivery_unit"] == "M")){ echo "selected";} } ?>><?php echo $this->lang->line('BULAN'); ?></option>
										<option value="Y" <?php if(isset($header)) { if(($header["pqm_delivery_unit"] == "Y")){ echo "selected";} } ?>><?php echo $this->lang->line('TAHUN'); ?></option>
									</select>
								</div>
							</div>
							<div class="row form-group" id="selesai"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Berlaku Hingga'); ?> *</label>
								<div class="col-md-4 m-l-n input-group date">
									<input <?php echo $readonly; echo $hanyabaca; ?> id="berlakuhingga" name="berlakuhingga" type="date" class="form-control" value="<?php if(isset($header)) { echo date("Y-m-d", strtotime($header["pqm_valid_thru"])); } ?>" required>
								</div>
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Lampiran Penawaran'); ?> * <small>(Max 10MB)</small></label>
								<div class="col-lg-6 m-l-n"><input <?php echo $readonly; echo $hanyabaca; ?> id="lampiran_penawaran" name="lampiran_penawaran" type="file" class="file" required><?php if(isset($header)){ ?><a href="<?php echo site_url('pengadaan/download/penawaran/'.$this->umum->forbidden($this->encryption->encrypt($header["pqm_att_quo"]), 'enkrip')); ?>"><?php echo $header["pqm_att_quo"]; ?></a><?php } ?></div>
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Catatan'); ?></label>
								<div class="col-lg-6 m-l-n"><input <?php echo $readonly; echo $hanyabaca; ?> id="catatan" name="catatan" type="text" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_notes"]; } ?>"></div>
							</div>
							<div class="row form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Mata Uang'); ?></label>
								<div class="col-md-4 m-l-n"><select <?php echo $readonly; echo $hanyabaca; ?> class="form-control m-b" name="currency" id="currency">
									<?php foreach($currency as $row) { ?>
									<option value="<?php echo $row["curr_code"] ?>" <?php if(isset($header)) { if(($header["pqm_currency"] == $row["curr_code"])){ echo "selected";} } ?>><?php echo $row["curr_code"]." - ".$row["curr_name"] ?></option>
									<?php } ?>
								</select>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card" style="border-radius: 20px;">
				<div class="card-header border-bottom pb-2">
					<div class="btn-group-sm">
						<h4 class="card-title"><?php echo $this->lang->line('Item Administrasi'); ?></h4>                    
					</div>                
				</div>
				<div class="card-content">
					<div class="card-body">                    
						<form role="form" id="adm" method="POST" action="<?php echo site_url('pengadaan/submit_duatahap') ?>" class="form-horizontal">	
							<input type="hidden" id="section" name="section" value="adm">
							<table class="table table-striped">
								<thead>
									<tr>
										<th style="width: 5%; text-align: center"><?php echo $this->lang->line('Nomor'); ?></th>
										<th style="width: 60%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
										<th style="width: 15%; text-align: center"><?php echo $this->lang->line('Respon Vendor'); ?></th>
										<th style="width: 20%; text-align: center"><?php echo $this->lang->line('Lampiran'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!isset($header)) { $i = 1; foreach($template as $row) { if($row["etd_mode"] == "0") {?>
										<tr>
											<td style="text-align: center"><?php echo $i; ?></td>
											<td><?php echo $row["etd_item"]; ?></td>
											<input type="hidden" name="desks_<?php echo $i ?>" id="desks_<?php echo $i ?>" value="<?php echo $row["etd_item"]; ?>">
											<td>
												<div class="i-checks">
													<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly; echo $hanyabaca; ?> type="radio" id="radio_<?php echo $i; ?>" value="1" name="radio_<?php echo $i; ?>" required> <?php echo $this->lang->line('Ada'); ?> </label>
												</div>
												<div class="i-checks">
													<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly; echo $hanyabaca; ?> type="radio" id="radio_<?php echo $i; ?>" value="0" name="radio_<?php echo $i; ?>"> <?php echo $this->lang->line('Tidak Ada'); ?></label>
												</div>
											</td>
											<td>
												<input id="lampiran_adm_<?php echo $i; ?>" name="lampiran_adm_<?php echo $i; ?>" type="file" class="file adm_attach" accept="<?php echo ALLOWED_EXT_FILES ?>">
												<div class="col-sm-0" style="font-size: 11px">
														<i>Max file 5 MB 
														<br>
														Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
														</i>
												</div>
											</td>	
										</tr>
									<?php $i++;}} } ?>
									<?php
										if(isset($header)) { 
											$i = 1; foreach($template as $row) { if($row["pqt_weight"] == "") {
											?>
											<tr>
												<td style="text-align: center"><?php echo $i; ?></td>
												<td><?php echo $row["pqt_item"]; ?></td>
												<input type="hidden" name="desks_<?php echo $i ?>" id="desks_<?php echo $i ?>" value="<?php echo $row["pqt_item"]; ?>">
												<input type="hidden" name="pqtids_<?php echo $i ?>" id="pqtids_<?php echo $i ?>" value="<?php echo $row["pqt_id"]; ?>">
												<td>
													<div class="i-checks">
														<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly; echo $hanyabaca; ?> type="radio" id="radio_<?php echo $i; ?>" value="1" name="radio_<?php echo $i; ?>" required <?php if(($row["pqt_check_vendor"] == "1")){ echo "checked";} ?>> <?php echo $this->lang->line('Ada'); ?></label>
													</div>
													<div class="i-checks">
														<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly; echo $hanyabaca; ?> type="radio" id="radio_<?php echo $i; ?>" value="0" name="radio_<?php echo $i; ?>" <?php if(($row["pqt_check_vendor"] == "0")){ echo "checked";} ?>><?php echo $this->lang->line('Tidak Ada'); ?></label>
													</div>
												</td>
												<td>
													<?php if(empty($readonly)){ ?>
													<input <?php echo $readonly; echo $hanyabaca; ?> id="lampiran_adm_<?php echo $i; ?>" name="lampiran_adm_<?php echo $i; ?>" type="file" class="file adm_attach_1" accept="<?php echo ALLOWED_EXT_FILES ?>">
													<?php } ?>
													<div class="col-sm-0" style="font-size: 11px">
															<i>Max file 5 MB 
															<br>
															Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
															</i>
													</div>

													<a target="_blank" href="<?php echo site_url('pengadaan/download/administrasi/'.$this->umum->forbidden($this->encryption->encrypt($row["pqt_attachment"]), 'enkrip')); ?>"><?php echo $row["pqt_attachment"]; ?></a>
												</td>
											</tr>
											<?php $i++; }}} ?>
											<input type="hidden" name="num_adm" id="num_adm" value="<?php echo $i ?>">
								</tbody>
							</table>	
						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card" style="border-radius: 20px;">
				<div class="card-header border-bottom pb-2">
					<div class="btn-group-sm">
						<h4 class="card-title"><?php echo $this->lang->line('Item Teknis'); ?></h4>                    
					</div>                
				</div>
				<div class="card-content">
					<div class="card-body">                    
						<form role="form" id="teknis" method="POST" action="<?php echo site_url('pengadaan/submit_duatahap') ?>" class="form-horizontal">	
							<input type="hidden" id="section" name="section" value="teknis">
							<table class="table table-striped">
								<thead>
									<tr>
										<th style="width: 5%; text-align: center"><?php echo $this->lang->line('Nomor'); ?></th>
										<th style="width: 40%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
										<th style="width: 5%; text-align: center"><?php echo $this->lang->line('Bobot'); ?></th>
										<th style="width: 30%; text-align: center"><?php echo $this->lang->line('Respon Vendor'); ?></th>
										<th style="width: 20%; text-align: center"><?php echo $this->lang->line('Lampiran'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!isset($header)) { $i = 1; foreach($template as $row) { if($row["etd_mode"] == "1") {?>
										<tr>
											<td style="text-align: center"><?php echo $i; ?></td>
											<td><?php echo $row["etd_item"]; ?></td>
											<td style="text-align: center"><?php echo $row["etd_weight"]."%"; ?></td>
											<input type="hidden" name="desk_<?php echo $i ?>" id="desk_<?php echo $i ?>" value="<?php echo $row["etd_item"]; ?>">
											<input type="hidden" name="weight_<?php echo $i ?>" id="weight_<?php echo $i ?>" value="<?php echo $row["etd_weight"]; ?>">
											<td><input <?php echo $readonly; echo $hanyabaca; ?> type="text" class="form-control" name="respon_<?php echo $i ?>" id="respon_<?php echo $i ?>" required></td>
											<td><input id="lampiran_tek_<?php echo $i; ?>" name="lampiran_tek_<?php echo $i; ?>" type="file" class="file tek_attach" accept="<?php echo ALLOWED_EXT_FILES ?>">
											<div class="col-sm-0" style="font-size: 11px">
													<i>Max file 5 MB 
													<br>
													Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
													</i>
											</div>
											</td>
										</tr>
									<?php $i++;}} }?>
									<?php
										if(isset($header)) { 
											$i = 1; foreach($template as $row) { if($row["pqt_weight"] != "") {
											?>
											<tr>
												<td style="text-align: center"><?php echo $i; ?></td>
												<td><?php echo $row["pqt_item"]; ?></td>
												<td style="text-align: center"><?php echo $row["pqt_weight"]."%"; ?></td>
												<input type="hidden" name="desk_<?php echo $i ?>" id="desk_<?php echo $i ?>" value="<?php echo $row["pqt_item"]; ?>">
												<input type="hidden" name="pqtid_<?php echo $i ?>" id="pqtid_<?php echo $i ?>" value="<?php echo $row["pqt_id"]; ?>">
												<td><input <?php echo $readonly; echo $hanyabaca; ?> type="text" class="form-control" name="respon_<?php echo $i ?>" id="respon_<?php echo $i ?>" required value="<?php echo $row["pqt_vendor_desc"] ?>"></td>
												<td>
													<?php if(empty($readonly)){ ?>
													<input <?php echo $readonly; echo $hanyabaca; ?> id="lampiran_tek_<?php echo $i; ?>" name="lampiran_tek_<?php echo $i; ?>" type="file" class="file tek_attach_1">
													<?php } ?>
													<div class="col-sm-0" style="font-size: 11px">
														<i>Max file 5 MB 
														<br>
														Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
														</i>
												</div>
													<a target="_blank" href="<?php echo site_url('pengadaan/download/teknis/'.$this->umum->forbidden($this->encryption->encrypt($row["pqt_attachment"]), 'enkrip')); ?>">
														<?php echo $row["pqt_attachment"]; ?>
													</a>
												</td>
											</tr>
											<?php $i++; }}} ?>
											<input type="hidden" name="num_tek" id="num_tek" value="<?php echo $i ?>">
											<input type="hidden" id="modo" name="modo" value="<?php if(isset($header)) { echo "edit"; } else { echo "insert"; } ?>" >
								</tbody>
							</table>	
						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if($modes == 'harga') { ?>
		<div class="row">
			<div class="col-12">
				<div class="card" style="border-radius: 20px;">
					<div class="card-header border-bottom pb-2">
						<div class="btn-group-sm float-left">
							<h4 class="card-title"><?php echo $this->lang->line('Item Komersial'); ?></h4>                    
						</div>                
					</div>
					<div class="card-content">
						<div class="card-body">                    
							<form role="form" id="komersial" method="POST" action="<?php echo site_url('pengadaan/submit_duatahap') ?>" class="form-horizontal">	
							<input type="hidden" id="section" name="section" value="komersial">
							<table class="table table-striped">
								<thead>
									<tr>
										<th style="text-align: center"><?php echo $this->lang->line('No'); ?></th>
										<th style="width: 20%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
										<th style="text-align: center"><?php echo $this->lang->line('Jumlah'); ?></th>
										<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Deskripsi'); ?> </th>
										<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Jumlah'); ?> </th>
										<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Harga Satuan'); ?></th>
										<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Sub Total'); ?></th>
									</tr>
								</thead>
								<tbody>
										<?php if(!($quos)) { $i = 1; foreach($item as $row) { ?>
											<tr>
											<td style="text-align: center"><?php echo $i ?></td>
											<td><?php echo $row["tit_description"] ?></td>
											<input type="hidden" id="desc_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_description"] ?>">
											<input type="hidden" id="tit_<?php echo $i ?>" name="tit_<?php echo $i ?>" value="<?php echo $row["tit_id"] ?>">
											<td><?php echo $row["tit_quantity"] ?></td>
											<input type="hidden" id="qty_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_quantity"] ?>">
											<td><input <?php echo $readonly ?> type="text" class="form-control" id="desc_<?php echo $i ?>" name="desc_<?php echo $i ?>" required></td>
											<td><input <?php echo $readonly ?>onblur="fnChange('<?php echo $i ?>','qty')" type="text" class="form-control" id="qty_<?php echo $i ?>" name="qty_<?php echo $i ?>" required></td>
											<input type="hidden" id="qty_<?php echo $i ?>_input" name="qty_<?php echo $i ?>_input" value="" min="1" required>
											<td><input <?php echo $readonly ?> onblur="fnChange('<?php echo $i ?>','price')" type="text" class="form-control" id="price_<?php echo $i ?>" name="price_<?php echo $i ?>" required></td>
											<input type="hidden" id="price_<?php echo $i ?>_input" name="price_<?php echo $i ?>_input" value="" min="1" required>
											<td><input readonly type="text" class="form-control" id="total_<?php echo $i ?>" name="total_<?php echo $i ?>" value=""></td>
										</tr>
										<?php $i++;} } ?>
										<?php
											if($quos) { 
												$i = 1; foreach($item as $row) {
												?>
												<tr>
												<td style="text-align: center"><?php echo $i ?></td>
												<td><?php echo $row["tit_description"] ?></td>
												<input type="hidden" id="desc_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_description"] ?>">
												<input type="hidden" id="pqiid_<?php echo $i ?>" name="pqiid_<?php echo $i ?>" value="<?php echo $row["pqi_id"] ?>">
												<td><?php echo $row["tit_quantity"] ?></td>
												<input type="hidden" id="qty_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_quantity"] ?>">
												<td><input <?php echo $readharga ?> type="text" class="form-control" id="desc_<?php echo $i ?>" name="desc_<?php echo $i ?>" value ="<?php echo $row["pqi_description"] ?>" required></td>
												<td><input <?php echo $readharga ?> onblur="fnChange('<?php echo $i ?>','qty')" type="text" class="form-control" id="qty_<?php echo $i ?>" name="qty_<?php echo $i ?>" value ="<?php echo $row["pqi_quantity"] ?>" required></td>
												<input type="hidden" id="qty_<?php echo $i ?>_input" name="qty_<?php echo $i ?>_input" value="" min="1" value ="<?php echo $row["pqi_quantity"] ?>" required>
												<td><input <?php echo $readharga ?> onblur="fnChange('<?php echo $i ?>','price')" type="text" class="form-control" id="price_<?php echo $i ?>" name="price_<?php echo $i ?>" value ="<?php echo $row["pqi_price"] ?>" required></td>
												<input type="hidden" id="price_<?php echo $i ?>_input" name="price_<?php echo $i ?>_input" value="" min="1" value ="<?php echo $row["pqi_price"] ?>" required>
												<td><input readonly type="text" class="form-control" id="total_<?php echo $i ?>" name="total_<?php echo $i ?>" value=""></td>
											</tr>
											<?php $i++; }} ?>
											<input type="hidden" id="num_item" name="num_item" value="<?php echo $i ?>">
											<input id="tenderids" name="tenderids" type="hidden" value="<?php echo $tenderid; ?>">
											<input type="hidden" id="pqmid" name="pqmid" value="<?php if(isset($header)){ echo $header["pqm_id"]; } ?>">
											<input type="hidden" id="modo" name="modo" value="<?php if($quos) { echo "edit"; } else { echo "insert"; } ?>" >
								</tbody>
							</table>	
							<table class="table invoice-total">
								<tbody>
									<tr>
										<td><strong><?php echo $this->lang->line('Total Sebelum PPN'); ?>:</strong></td>
										<td id="totalss"></td>
									</tr>
									<tr>
									<!--   <td><strong><?php //echo $this->lang->line('PPN'); ?> : </strong></td>
										<td id="ppnss"></td> -->
									</tr>
									<tr>
										<td><strong><?php echo $this->lang->line('Total'); ?> : </strong></td>
										<td id="subtotalss"></td>
									</tr>
								</tbody>
							</table>
						</form>	
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
		<div class="col-12">
			<div class="card" style="border-radius: 20px;">				
				<div class="card-content">
					<div class="card-body text-center">                    
						<?php if(!isset($readonly) || $readonly != "readonly" || $readharga != "readonly") { ?>
							<?php if($modes == 'teknis') { ?>
								<button class="btn btn-info" type="submit" id="submitBtn"><?php echo $this->lang->line('Kirim Penawaran Teknis'); ?></button>
							<?php } else {  ?>
								<button class="btn btn-info" type="submit" id="submitBtn1"><?php echo $this->lang->line('Kirim Penawaran Harga'); ?></button>
							<?php } ?>
							
							<button class="btn btn-secondary" id="backBtn"><?php echo $this->lang->line('Kembali'); ?></button>
						<?php } ?>
						
						<?php if(isset($winner)) { ?>
						<p class="text-danger" style="font-size:150%;"><?php echo $this->lang->line('Selamat, Anda dinyatakan sebagai pemenang pengadaan ini'); ?></p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var cur = "Rp";
		set_field_ontipepenawaran();
		
		// $('#bid_bond').focus();
		$('#bid_bond').blur();
		
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		
		$('#selesai .input-group.date').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			startDate: '+1d',
			format: "yyyy-mm-dd"
		});
		
		//Ubah Blocked Item Komersial Field
		$('#tipepenawaran').change(function(){
			set_field_ontipepenawaran();
		});
		
		//Ubah Mata Uang
		$('#currency').change(function(){
			var kurs = $('#currency').val();
			var total = $("#totalss").text();
			total = total.split(" ");
			var subtotal = $("#subtotalss").text();
			subtotal = subtotal.split(" ");
			var ppn = $("#ppnss").text();
			ppn = ppn.split(" ");
			$("#totalss").text(kurs+" "+total[1]);
			$("#subtotalss").text(kurs+" "+subtotal[1]);
			$("#ppnss").text(kurs+" "+ppn[1]);
		});
		
		$("#adm").validate({
			// the errorPlacement has to take the table layout into account
			errorPlacement: function(error, element) {
				error.appendTo(element.parent().parent().parent().next());
			}
		});
		
		$("#backBtn").click(function(){
		window.history.back();
		});
		
		$("#submitBtn").click(function(){
			
			//=========================================
			var scrollme
			 $('input[name^="respon_"]').each(function() {
			     var respon = $(this).val();
			      if (respon == ""){
				 	scrollme = 1
			      } else {
			      	 scrollme = 0
			      }
			 });
			 console.log(scrollme)
			var num_adm = $('#num_adm').val()-1;
			var radios = 0
			var total = 0
			for (i = 1; i <= num_adm; i++) { 
				a = i;
				i = a;
				radios = $('input[name=radio_'+i+']:checked').val();
				radios *= radios
			}
			total = radios

			var np = $("#nopenawaran").val();
			var jw = $("#jangkawaktu").val();
			var bh = $("#berlakuhingga").val();
			var lp = $("#lampiran_penawaran").val();

			if ((lp == "" && $("#modo").val() != "edit")  || np == "" || jw == "" || bh == "") {
				scroll_header()
			}else if(isNaN(total)){
				scroll_adm()
			}else if(scrollme == 1){
				scroll_teknis()
			}
			//==========================================

			//Submit All Form
			if($("#header").validate().form() && $("#adm").validate().form() && $("#teknis").validate().form()){
			button_disabled();
				$("#header").ajaxSubmit({
					success: function(msg){
						if(msg == "1"){
							$("#bidbond").ajaxSubmit({
							success: function(msg){

							},error: function(){
								swal("Error", "<?php echo $this->lang->line('Pesan-0 : Data Gagal Disimpan'); ?>", "error");
								button_enabled();
							}
						});
							$("#adm").ajaxSubmit({
								success: function(msg){
									$("#teknis").ajaxSubmit({
										success: function(msg){
													if(msg == "2a"){
														swal("Error", "<?php echo $this->lang->line('Data Header gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													}
													else if(msg == "3a"){
														swal("Error", "<?php echo $this->lang->line('Data Administrasi gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													}
													else if(msg == "4a"){
														swal("Error", "<?php echo $this->lang->line('Data Teknis gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
														button_enabled();
													}
													else if(msg == "999"){
														swal({
															title: "<?php echo $this->lang->line('Selamat, Penawaran Anda Berhasil Dikirim'); ?>",
															text: "<?php echo $this->lang->line('Penawaran Anda Akan Dievaluasi oleh'); ?><?php echo COMPANY_NAME ?>",
															type: "success"
														},
														function(){
															window.location.assign('<?php echo site_url(); ?>');
														});
													}
												},
												error: function(){
													swal("Error", "<?php echo $this->lang->line('Pesan-1 : Data Gagal Disimpan'); ?>", "error");
													button_enabled();
												}
									});
								},
								error: function(){
									swal("Error", "<?php echo $this->lang->line('Pesan-3 : Data Gagal Disimpan'); ?>", "error");
									button_enabled();
								}
							});
						}
						else{
						if(msg.substring(0, 3) == "<p>"){	
							msg = msg.replace("<p>", "");
							msg = msg.replace("</p>", "");
							swal("Error", msg, "error");
							button_enabled();
						}
						else{
							swal("Error", "<?php echo $this->lang->line('Pesan-4 : Data Gagal Disimpan'); ?>", "error");
							button_enabled();
						}
						}
					},
					error: function(){
						swal("Error", "<?php echo $this->lang->line('Pesan-5 : Data Gagal Disimpan'); ?>", "error");
						button_enabled();
					}
				});
			}
		});
		
		$("#submitBtn1").click(function(){
			//Submit All Form
			if($("#komersial").validate().form()){
			button_disabled();
				$("#komersial").ajaxSubmit({
					success: function(msg){
					if(msg == "5a"){
					swal("Error", "<?php echo $this->lang->line('Gagal Update Status Vendor. Harap Masukan Data Kembali'); ?>", "error");
					button_enabled();
					}
					else if(msg == "6a"){
					swal("Error", "<?php echo $this->lang->line('Data Komersial gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
					button_enabled();
					}
					else if($.isNumeric(msg)){
						swal({
						title: "<?php echo $this->lang->line('Selamat, Penawaran Anda Berhasil Dikirim'); ?>",
						type: "success"
						},
						function(){
						window.location.assign('<?php echo site_url(); ?>');
						});
						}
					},
					error: function(){
						swal("Error", "<?php echo $this->lang->line('Pesan-1 : Data Gagal Disimpan'); ?>", "error");
						button_enabled();
					}
				});
			}
		});
	});
	
	function fnChange(id,param){
		var check = "_"+id;
		if(id == ""){
			check = "";
		}
		
		var cur = $('#currency').val()+" ";
		var current_val = parseFloat(accounting.unformat($("#"+param+check).val()));
		var nonformat = current_val;
		var format = accounting.formatNumber(current_val, 2, ",");
		
		
		$("#"+param+check).val(format);
		$("#"+param+check+"_input").val(nonformat);
		
		if(param == "qty" || param == "price"){
			//Ubah Total Per Item
			var total = $("#qty"+check+"_input").val() * $("#price"+check+"_input").val();
			var format = accounting.formatNumber(total, 2, ",");
			$("#total"+check).val(format);
			
			//Ubah Total Sebelum PPN
			var num = parseInt($('#num_item').val())-1;
			var subtotal = 0;
			
			var subppn = 0;
			var subpph = 0;

			for (i = 1; i <= num; i++) {
				subtotal = subtotal + parseFloat(accounting.unformat($("#total_"+i).val()));
			}

			$("#totalss").text(cur+accounting.formatNumber(subtotal, 2, ","));
			$("#subtotalss").text(cur+accounting.formatNumber(subtotal, 2, ","));			
		}
	}
	
	function set_field_ontipepenawaran(){
		var tipe = $('#tipepenawaran').val();
		var num = parseInt($('#num_item').val())-1;
		if(tipe == 'A'){
			for (i = 1; i <= num; i++) { 
				a = i;
				$("#desc_"+i).val($("#desc_"+i+"_temp").val());
				$("#qty_"+i).val($("#qty_"+i+"_temp").val());
				$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
				$("#total_"+i).val("");
				$("#desc_"+i).attr("readonly", true);
				$("#qty_"+i).attr("readonly", true);
				// $("#price_"+i).focus();
				$("#price_"+i).blur();
				i = a;
			}
		}
		else if(tipe == 'B'){
			for (i = 1; i <= num; i++) { 
				a = i;
				if($("#modo").val() != "edit"){
				$("#desc_"+i).val("");
				}
				$("#desc_"+i).attr("readonly", false);
				$("#qty_"+i).val($("#qty_"+i+"_temp").val());
				$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
				$("#qty_"+i).attr("readonly", true);
				$("#total_"+i).val("");
				$("#price_"+i).blur();
				i = a;
			}
		}
		else if(tipe == 'C'){
			for (i = 1; i <= num; i++) { 
				a = i;
				if($("#modo").val() != "edit"){
				$("#desc_"+i).val("");
				$("#qty_"+i).val("");
				}
				$("#qty_"+i+"_input").val(0);
				$("#total_"+i).val("");
				$("#desc_"+i).attr("readonly", false);
				$("#qty_"+i).attr("readonly", false);				
				$("#price_"+i).blur();
				i = a;
			}
		}
	}
	
	function button_disabled(){
		$("#submitBtn").prop("disabled", true);
		$("#submitBtn1").prop("disabled", true);
		$("#backBtn").prop("disabled", true);
		$("#submitBtn").text("<?php echo $this->lang->line('Sedang Mengirim Penawaran'); ?>...");
		$("#submitBtn1").text("<?php echo $this->lang->line('Sedang Mengirim Penawaran'); ?>...");
	}
	
	function button_enabled(){
		$("#submitBtn").prop("disabled", false);
		$("#submitBtn1").prop("disabled", false);
		$("#backBtn").prop("disabled", false);
		$("#submitBtn").text("<?php echo $this->lang->line('Kirim Penawaran Teknis'); ?>");
		$("#submitBtn1").text("<?php echo $this->lang->line('Kirim Penawaran Harga'); ?>");
	}

	function scroll_header(){
		$('html, body').animate({
			scrollTop: $("#header").offset().top
		}, 1000);
	}
	function scroll_adm(){
		$('html, body').animate({
			scrollTop: $("#adm").offset().top
		}, 1000);
	}
	function scroll_teknis(){
		$('html, body').animate({
			scrollTop: $("#teknis").offset().top
		}, 1000);
	}
</script>