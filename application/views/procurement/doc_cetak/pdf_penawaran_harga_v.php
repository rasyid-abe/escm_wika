<style type="text/css">

td {
	padding: 10px;
}

th {
	padding: 10px;
}

#table-content {
	font-size: 10px !important;
}

.is-content {
	border-collapse: collapse;
}

.is-content td {
	border: 1px solid black;
}

.is-content th {
	border: 1px solid black;
}

.signature {
	border: 0;
	border-bottom: 1px solid #000;
}

.signature_div {
	display: inline-block;
	justify-content: space-between;
	width: 100%;
}

.signature-wrapper {
	display: block;
	text-align: center;
}

.button {
	background-color: #4CAF50; /* Green */
	border: none;
	color: white;
	padding: 15px 32px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 10px;
}
form label, .form-group label {
	font-size: 8px;
}
.table th, .table td  {
	padding: 10px 2rem;
}
</style>


<form method="POST" action="<?php echo base_url(); ?>index.php/procurement/pdf_penawaran_harga_print">

	<input type="hidden" name="id" value="<?php echo $ptm_number;?>">
	<div class="">
		<table id="table-content" class="table-responsive" style="font-size:10px;">
			<tr>
				<th style="border-right: 0px;" ><img width="50"   src="<?php echo base_url('assets/img/favicon.png') ?>"></th>
				<th colspan="6" align="left" style="border-left: 0px; border-right: 0px;"><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $tender['ptm_dept_name']; ?></th>
				<th colspan="<?php echo count($vendor) * 2 - 1; ?>" style="border-left: 0px; font-size: 150%;"><b>DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI (DEPKN)</b></th>
				<th align="right"><button type="submit" class="btn btn-info btn-sm float-right" style="margin: 5px;cursor: pointer;font-size: 11px;float:left;">SIMPAN</button></th>
			</tr>
			<tr>
				<th colspan="7"></th>
				<th colspan="<?php echo count($vendor) * 2; ?>">PENYEDIA</th>
			</tr>
			<tr>
				<th colspan="7"><?php echo $tender['ptm_project_name']; ?><br>Proyek : <?php echo $tender['ptm_district_name']; ?></th>
				<?php
				$address = "";
				$cp = "";
				$telpon = "";
				$no_penawaran = "";
				$tgl = "";
				$ksong = "";
				foreach ($vendor as $value) {
					$dataQuoHeader = $this->Procrfq_m->getQuoItemHeaderRFQ($ptm_number, $value['vendor_id'])->row_array();
					echo "<th colspan='2'>".$value['vendor_name']."</th>";
					$address .= "<td colspan='2'>". $value['address_street'] ."</td>";
					$cp .= "<td colspan='2'>". $value['contact_pos'] ."</td>";
					$telpon .= "<td colspan='2'>". $value['contact_phone_no'] ."</td>";
					$no_penawaran .= "<td colspan='2'>". $dataQuoHeader['pqm_number'] ."</td>";
					$tgl .= "<td colspan='2'>". $dataQuoHeader['pqm_created_date']."</td>";
					$ksong .= "<td colspan='2'>". ''."</td>";
				}
				?>
			</tr>
			<tr style="background-color: #e6e7e8;">
				<th >1</th>
				<th colspan="6" align="left">DATA PENYEDIA</th>
				<?php echo $ksong; ?>
			</tr>
			<tr>
				<td align="center">1.1</td>
				<td colspan="6">Alamat</td>
				<?php echo $address; ?>
			</tr>
			<tr>
				<td align="center">1.2</td>
				<td colspan="6">Kontak Personal</td>
				<?php echo $cp; ?>
			</tr>
			<tr>
				<td align="center">1.3</td>
				<td colspan="6">No. Telpon / Fax</td>
				<?php echo $telpon; ?>
			</tr>
			<tr>
				<td align="center">1.4</td>
				<td colspan="6">Penawaran  No. / Tanggal</td>
				<?php echo $no_penawaran; ?>
			</tr>
			<tr>
				<td align="center">1.5</td>
				<td colspan="6">BA Klarifikasi dan Negosiasi  Tgl.</td>
				<?php echo $tgl; ?>
			</tr>
			<tr style="background-color: #e6e7e8;">
				<th >2</th>
				<th colspan="4" align="left">DATA PEKERJAAN / SPESIFIKASI</th>
				<th colspan="2">RABP</th>
				<?php
				foreach ($vendor as $value) {
					echo "<th colspan='2'></th>";
				}
				?>
			</tr>
			<tr>
				<th></th>
				<th></th>
				<th>NO PR</th>
				<th>Ukuran</th>
				<th>Vol</th>
				<th>Sat</th>
				<th>Harga Satuan</th>
				<th>Jumlah Harga (Rp)</th>
				<?php
				foreach ($vendor as $value) {
					echo "<th style='text-align:right;'>Harga Satuan</th><th style='text-align:right;'>Jumlah Harga (Rp)</th>";
				}
				?>
			</tr>


			<?php

			$content_total = "<tr><td></td><td  align ='center'><b>TOTAL</b></td>";
			$content_deviasi = "<tr><td></td><td align ='center'><b>EFISIENSI</b></td>";

			$total_vendor = array();
			$par = 0;
			foreach ($vendor as $value21) {
				$total_vendor[$par] = 0;
				$par += 1;
			}

			$total_bap = 0;

			$nomor = 1;
			foreach ($item as $value) {

				$id_tit = $value['tit_id'];

				$dataSMb = $this->Procrfq_m->getSmbCatalogByCode(trim($value['tit_code']))->row_array();
				$ukuran = "";
				if ($dataSMb) {
					$ukuran = $dataSMb['ukuran'];
				}

				$content_vendor = "";

				$par = 0;
				foreach ($vendor as $value2) {

					//print_r($value2);

					$pqm_id = $value2['pqm_id'];
					//$vendor_id = $value2['pqm_id'];

					//$data_penawaran_awal = $this->Procrfq_m->getVendorQuoHistRFQ($value2['pvs_vendor_code'], $ptm_number)->result_array();
					//print_r($data_penawaran_awal);
					//$list_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->result_array();
					$list_vendor_penawaran = $this->Procrfq_m->getQuoItemHistRFQ($value2['vendor_id'], $id_tit)->row_array();
					$data_vendor_penawaran = array();

					if ($list_vendor_penawaran) {
						$data_vendor_penawaran = $list_vendor_penawaran;
					} else {
						$data_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->row_array();
					}


					$content_vendor .= "<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'])
					."</td><td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity'])."</td>";

					$total_vendor[$par] += ($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity']);
					$par += 1;
				}

				$nomor_text = $nomor;
				if ($nomor == 1) {
					$nomor_text = "<b>A).</b><br><br>".$nomor;
					$value['tit_description'] = "<b><u>PENAWARAN</u></b><br><br>".$value['tit_description'];
				}

				echo "<tr >
				<td style ='padding:0px;border-bottom:0px;border-top:0px;' align='center'>".$nomor_text."</td>
				<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_description']."</td>
				<td style ='border-bottom:0px;border-top:0px;'>".$ukuran."</td>
				<td style ='border-bottom:0px;border-top:0px;' align='right'>".$value['tit_quantity']."</td>
				<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_unit']."</td>
				<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price'])."</td>
				<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price']*$value['tit_quantity'])."</td>".

				$content_vendor


				."</tr>";
				$nomor += 1;

				$total_bap += ($value['tit_price'] * $value['tit_quantity']);


			}

			$content_total .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b>Rp. ".inttomoney($total_bap)."</b></td>";
			$content_deviasi .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b></b></td>";
			foreach ($total_vendor as $t_vendor) {
				$content_total .= "<td><b></b></td><td align ='right'><b>Rp. ".inttomoney($t_vendor)."</b></td>";

				$total_deviasi = $total_bap - $t_vendor;
				if ($total_deviasi < 0) {
					$total_deviasi = "<span style='color:red;'>Rp. (".inttomoney(abs($total_deviasi)).")</span>";
				} else {
					$total_deviasi = "<span>Rp. ".inttomoney($total_deviasi)."</span>";
				}

				$content_deviasi .= "<td><b></b></td><td align ='right'><b>".$total_deviasi."</b></td>";
			}
			$content_total .= "</tr>";
			$content_deviasi .= "</tr>";

			echo $content_total;
			//echo $content_deviasi;


			?>

			<?php

			$content_total = "<tr><td></td><td  align ='center'><b>TOTAL</b></td>";
			$content_deviasi = "<tr><td></td><td align ='center'><b>EFISIENSI</b></td>";

			$total_vendor = array();
			$par = 0;
			foreach ($vendor as $value21) {
				$total_vendor[$par] = 0;
				$par += 1;
			}

			$total_bap = 0;

			$nomor = 1;
			foreach ($item as $value) {

				$id_tit = $value['tit_id'];

				$dataSMb = $this->Procrfq_m->getSmbCatalogByCode(trim($value['tit_code']))->row_array();
				$ukuran = "";
				if ($dataSMb) {
					$ukuran = $dataSMb['ukuran'];
				}

				$content_vendor = "";

				$par = 0;
				foreach ($vendor as $value2) {

					//print_r($value2);

					$pqm_id = $value2['pqm_id'];
					//$vendor_id = $value2['pqm_id'];

					//$data_penawaran_awal = $this->Procrfq_m->getVendorQuoHistRFQ($value2['pvs_vendor_code'], $ptm_number)->result_array();
					//print_r($data_penawaran_awal);
					//$list_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->result_array();

					$data_vendor_penawaran = $this->Procrfq_m->getQuoItemRFQ($pqm_id, $id_tit)->row_array();


					$content_vendor .= "<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'])
					."</td><td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity'])."</td>";

					$total_vendor[$par] += ($data_vendor_penawaran['pqi_price'] * $data_vendor_penawaran['pqi_quantity']);
					$par += 1;
				}

				$nomor_text = $nomor;
				if ($nomor == 1) {
					$nomor_text = "<b>B).</b><br><br>".$nomor;
					$value['tit_description'] = "<b><u>NEGOSIASI</u></b><br><br>".$value['tit_description'];
				}

				echo "<tr >
				<td style ='padding:0px;border-bottom:0px;border-top:0px;' align='center'>".$nomor_text."</td>
				<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_description']."</td>
				<td style ='border-bottom:0px;border-top:0px;'>".$ukuran."</td>
				<td style ='border-bottom:0px;border-top:0px;' align='right'>".$value['tit_quantity']."</td>
				<td style ='border-bottom:0px;border-top:0px;'>".$value['tit_unit']."</td>
				<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price'])."</td>
				<td style ='border-bottom:0px;border-top:0px;' align='right'>".inttomoney($value['tit_price']*$value['tit_quantity'])."</td>".

				$content_vendor


				."</tr>";
				$nomor += 1;

				$total_bap += ($value['tit_price'] * $value['tit_quantity']);


			}

			$content_total .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b>Rp. ".inttomoney($total_bap)."</b></td>";
			$content_deviasi .= "<td></td><td></td><td></td><td><b></b></td><td align ='right'><b></b></td>";
			foreach ($total_vendor as $t_vendor) {
				$content_total .= "<td><b></b></td><td align ='right'><b>Rp. ".inttomoney($t_vendor)."</b></td>";

				$total_deviasi = $total_bap - $t_vendor;
				if ($total_deviasi < 0) {
					$total_deviasi = "<span style='color:red;'>Rp. (".inttomoney(abs($total_deviasi)).")</span>";
				} else {
					$total_deviasi = "<span>Rp. ".inttomoney($total_deviasi)."</span>";
				}

				$content_deviasi .= "<td><b></b></td><td align ='right'><b>".$total_deviasi."</b></td>";
			}
			$content_total .= "</tr>";
			$content_deviasi .= "</tr>";

			echo $content_total;
			echo $content_deviasi;


			?>

			<tr style="background-color: #e6e7e8;">

				<th >3</th>
				<th colspan="4" align="left">KLARIFIKASI &nbsp;&nbsp; <a class="btn btn-info btn-sm" onclick="fShowModalKLARIFIKASI()"><i class="ft-plus"></i></a></th>
				<th colspan="2"></th>


				<?php
				foreach ($vendor as $value) {
					echo "<th colspan='2'>".''."</th>";
				}
				?>

			</tr>

			<?php $ii = 1; foreach ($item_klarifikasi as $key => $item) : ?>
				<tr>

					<td align="center">3.<?= $ii ?></td>
					<td colspan="4" align="left"><i><?= $item['item_name'] ?></i></td>
					<td colspan="2"></td>

				</tr>

				<tr>

					<td align="center"></td>
					<td colspan="4" align="left"></td>
					<td colspan="2"></td>

					<?php
					$ik = 0;
					foreach ($vendor as $value) {
						//echo "<td colspan='2'>".$tender['ptm_project_name']."</td>";
						$valuess = $item['item_value'] != '' ? explode(";", $item['item_value'])[$ik] : "";
						echo "<td colspan='2'><textarea class='form-control' name='item_".$item['id']."[]'>".$valuess."</textarea></td>";
						$ik++;
					}
					?>

				</tr>
				<?php $ii++; endforeach; ?>

				<tr>

					<?php
					foreach ($vendor as $value) {
						echo "<td colspan='2'></td>";
					}
					?>

				</tr>
				<div class="table-responsive">
					<!-- <?php if ($data_uskep) { ?>

						<table class="table">
							<thead>
								<tr style="background-color: #e6e7e8;">
									<th scope="col">Nama</th>
									<th scope="col">Kategori</th>
									<th scope="col">Sebagai</th>
									<th scope="col">Tanda Tangan</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= $menyetujui_name[0]; ?></td>
									<td>
										<select class="form-control">
											<option>Menyetujui</option>
											<option>Mengetahui</option>
										</select>
									</td>
									<td>
										<select class="form-control">
											<option><?= $menyetujui_posisi[0]; ?></option>
										</select>
									</td>
									<td>......</td>
								</tr>
								<?php $par = 0; foreach ($mengetahui_name as $value) { ?>
									<tr>
										<td><?= $value; ?></td>
										<td>
											<select class="form-control">
												<option>Menyetujui</option>
												<option>Mengetahui</option>
											</select>
										</td>
										<td>
											<select class="form-control">
												<option><?= $mengetahui_posisi[$par]; ?></option>
											</select>
										</td>
										<td>......</td>
									</tr>
									<?php $par += 1; } ?>

									<?php $par = 0; foreach ($diusulkan_name as $value) { ?>
										<tr>
											<td><?= $value; ?></td>
											<td>
												<select class="form-control">
													<option>Menyetujui</option>
													<option>Mengetahui</option>
												</select>
											</td>
											<td>
												<select class="form-control">
													<option>Manajer</option>
													<option>General Manager</option>
													<option>Manajer Proyek Kecil</option>
												</select>
											</td>
											<td>......</td>
										</tr>
										<?php $par += 1; } ?>
									</tbody>
								</table>
							<?php } else { ?> -->
								<table class="table">
									<thead>
										<tr style="background-color: #e6e7e8;">
											<th scope="col">Nama</th>
											<th scope="col">Kategori</th>
											<th scope="col">Sebagai</th>
											<th scope="col">Tanda Tangan</th>
										</tr>
									</thead>
									<tbody>

										<?php foreach ($ttd_list as $key => $value) { ?>
											<!-- <?php if(count($ttd_list) > 0) { ?> -->
												<tr>
													<td>
														<select name="panitia_name[]" class="form-control">
															<?php foreach ($value['lists_name'] as $key2 => $value2) : ?>
																<option value="<?= $value2['nip'].'_'.$value2['fullname'].'_'.$value2['job_title'] ?>"><?= $value2['fullname'].' - '.$value2['job_title'] ?></option>
															<?php endforeach; ?>
														</select>
													</td>
													<td>
														<select name="panitia_category[]" class="form-control">
															<option value="<?= $value['posisi']; ?>"><?= $value['posisi']; ?></option>
														</select>
													</td>
													<td>
														<select name="panitia_ketua[]" class="form-control">
															<option value="<?= $value['kategori']; ?>"><?= $value['kategori']; ?></option>
														</select>
													</td>
													<td>......</td>
												</tr>
											<!-- <?php } ?> -->
										<?php } ?>
									</tbody>
								</table>
							<!-- <?php } ?> -->

						</div>


						<!-- <tr>
						<td colspan="2" style="border-right: 0px;">

						<br>
						Menyetujui


						<table style="font-size: 100%;" border="0">
						<tr>
						<td>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<div class="signature_div">
						<div class="Column">
						<label class="signature-wrapper">
						<label  class="signature"><?= $menyetujui_name[0]; ?> </label><br />
						<?= $menyetujui_posisi[0]; ?>
					</label>
				</div>
			</div>
		</td>
	</tr>
</table>
</td>
<td colspan="<?php echo (count($vendor) * 2) + 7 - 6; ?>" style="border-right: 0px; border-left: 0px;">

<br><br>
Mengetahui


<table style="font-size: 100%;" border="0">
<tr>
<?php $par = 0; foreach ($mengetahui_name as $value) { ?>
<td>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="signature_div">
<div class="Column">
<label class="signature-wrapper">
<label  class="signature"><?php echo $value; ?> </label><br />
<?php echo $mengetahui_posisi[$par]; ?>
</label>
</div>
</div>
</td>

<?php $par += 1; } ?>


</tr>
</table>
</td>
<td style="border-right: 0px; border-left: 0px;"></td>
<td style="border-right: 0px; border-left: 0px;"></td>

<td colspan="2" style="border-left: 0px;">

<?php echo $data_uskep['bakp_city'].' '.date('d M Y'); ?> <br>
Diusulkan Oleh

<table style="font-size: 100%;" border="0">
<tr>



<?php $par = 0; foreach ($diusulkan_name as $value) { ?>
<td>
<br>
<br>
<br>
<br>
<br>
<div class="signature_div">
<div class="Column">
<label class="signature-wrapper">
<label  class="signature"><?php echo $value; ?> </label><br />
<?php echo $diusulkan_posisi[$par]; ?>
</label>
</div>
</div>
</td>

<?php $par += 1; } ?>

</tr>
</table>
</td>
</tr> -->

</table>
<div class="table-responsive">
	<table class="table">
		<tr>
			<th>Nama</th>
			<th>Kategori</th>
			<th>Sebagai</th>
			<th>Tanda Tangan</th>
		</tr>
		<?php foreach ($depkn_ttd as $k => $v): ?>
			<tr>
				<td>
					<select class="form-control" name="panitia_name[]">
						<?php foreach ($v as $key => $value): ?>
							<option value="<?= $value['nip'].'_'.$value['nm_peg'].'_'.$value['nm_jabatan'] ?>"><?= $value['nm_peg'].' - '.$value['nm_jabatan'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<select class="form-control" name="panitia_category[]">
						<option>Menyetujui</option>
						<option>Mengetahui</option>
					</select>
				</td>
				<td>
					<select class="form-control" name="panitia_ketua[]">
						<option>Ketua</option>
						<option>Anggota</option>
					</select>
				</td>
				<td>............</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
</div>
</form>

<div class="modal" id="modalKlarifikasi" tabindex="-3" role="dialog" aria-labelledby="uploadLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="uploadLabel">Ubah Item Klarifikasi</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form method="POST" id="uploadForm" enctype="multipart/form-data" action="<?php echo site_url('log/doupload') ?>">
					<div id="gridItemKlarifikasi"></div>

				</form>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view('devextreme'); ?>

<div id="form_other" style="display:<?php echo ($data_uskep) ? '' : 'none'; ?>;" >

	<?php if($data_uskep['depkn_is_share'] != null ) : ?>
		<!-- <a href="<?php echo base_url()."index.php/PrivyDepkn/save_doc/".$ptm_number; ?>" class="btn btn-info btn-sm" style="margin: 5px;font-size: 11px;"><i class="ft ft-upload"></i> Get PDF E-sign</a> -->
	<?php endif; ?>

	<?php if($data_uskep['depkn_is_share'] == null ) : ?>
		<!-- <a  onclick="fUploadDoc()" class="btn btn-info btn-sm ml-3" style="margin: 5px;font-size: 11px;"><i class="ft ft-upload"></i> Upload & Share E-Sign</a> -->
	<?php endif; ?>


	<script>
	function fUploadDoc() {
		$(`#myLoader`).modal('show');
		var url = '<?php echo base_url()."index.php/PrivyDepkn/upload_doc/".$ptm_number; ?>';
		$.ajax({
			type: "GET",
			url: url,
			dataType: "JSON",
			success: function (response) {
				$(`#myLoader`).modal('hide');
				var message = response.message;
				if(response.status == "SUCCESS"){
					DevExpress.ui.notify({
						message,
						position: {
							my: 'center top',
							at: 'center top',
						},
					}, 'success', 3000);

					//DevExpress.ui.notify(response.message, "success", 1600);
				} else {
					DevExpress.ui.notify({
						message,
						position: {
							my: 'center top',
							at: 'center top',
						},
					}, 'success', 3000);
					//DevExpress.ui.notify(response.message, "error", 1600);
				}
			}
		});
	}

	function fShowModalKLARIFIKASI()
	{
		$("#modalKlarifikasi").modal("show");
	}
</script>
</div>

<script>
$(document).ready(function () {
	//location.reload();
	const URL = '<?= base_url() ?>Item_Klarifikasi';
	const d = $.Deferred();
	const ordersStore = new DevExpress.data.CustomStore({
		key: 'id',
		load() {
			var data = [];
			$.ajax({
				type: "GET",
				url: URL + '/get_data/<?= $ptm_number ?>',
				//data: "data",
				dataType: "json",
				success: function(response) {
					d.resolve(response.data);
					return d.promise();

				}
			});
			return d.promise();

		},
		insert(values) {

			$.ajax({
				type: "POST",
				url: URL + '/insert_item/<?= $ptm_number ?>',
				data: {values : JSON.stringify(values)},
				dataType: "json",
				success: function(response) {
					d.resolve();
					if(response.code == 200)
					{
						$('#gridItemKlarifikasi').dxDataGrid("instance").refresh();

					}
					location.reload();

				}

			});


		},
		update(key, values) {

			$.ajax({
				type: "POST",
				url: URL + '/update_item',
				data: {key: key, values : JSON.stringify(values)},
				dataType: "json",
				success: function(response) {
					d.resolve();
					if(response.code == 200)
					{
						$('#gridItemKlarifikasi').dxDataGrid("instance").refresh();
					}

					location.reload();
				}
			});


		},
		remove(key) {
			$.ajax({
				type: "POST",
				url: URL + '/delete_item',
				data: {key: key},
				dataType: "json",
				success: function(response) {
					d.resolve();
					if(response.code == 200)
					{
						$('#gridItemKlarifikasi').dxDataGrid("instance").refresh();
					}

					location.reload();
				}
			});

		},
	});


	const dataGrid = $('#gridItemKlarifikasi').dxDataGrid({
		dataSource: ordersStore,
		showBorders: true,
		editing: {
			mode: 'row',
			allowAdding: true,
			allowUpdating: true,
			allowDeleting: true,
		},
		scrolling: {
			mode: 'virtual',
		},
		columns: [
			{
				dataField: 'item_name',
				caption: 'Nama Item',
			}
		],

	}).dxDataGrid('instance');


});

function fModalScore()
{
	//$("#score-modal").modal("show");
}

function sendRequest(url, method = 'GET', data) {
	const d = $.Deferred();

	$.ajax(url, {
		method,
		data,
		cache: false,
	}).done((result) => {
		d.resolve(method === 'GET' ? result.data : result);
	}).fail((xhr) => {
		d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
	});

	return d.promise();
}

</script>
