<style type="text/css">
	html{
		font-family:sans-serif;
	}
	table {
		font-size: 12px;
	}

	td {
		padding: 5px;
	}

	th {
		padding: 5px;
		font-weight: bold;
		/*background-color: #b0ffc2;*/
		background-color: #e6e7e8;
	}

	p{
		font-size:10px;
	}

	#table-content {
		font-size: 40%;
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
	.table td {
		line-height: 15px;
	}
	.table th, .table td {
		vertical-align: middle;
	}
	.bt-custom {
    border-top: 1px solid #a7a7a7 !important;
	}
</style>

<form method="POST" action="<?php echo base_url(); ?>index.php/procurement/pdf_penilaian_print">
<input type="hidden" name="id" value="<?php echo $ptm_id; ;?>">
<?php $tgl_penetapan_pemenang = date('Y-m-d'); ?>

<table style="width: 100%;display:none;">
<tr>
	<td width="1%"><img width="50" src="<?php echo base_url('assets/img/favicon.png') ?>"></td>
	<td ><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $tender['ptm_dept_name']; ?></td>

</tr>
</table>
<br>
<br>
<center>
	<p style="margin:0px;font-size:14px;"><b>DOKUMEN SISTEM PENILAIAN</b></p>
</center>
<button type="submit" target="_blank" class="btn btn-info btn-sm" style="margin: 5px;cursor: pointer;font-size:11px;float:right;">Simpan</button>
<br>
<br>

<table style="width:100%;">
	<tr>
		<td width="12%;"><b>Paket Pengadaan</b></td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_packet']; ?></td>
	</tr>
	<tr>
		<td width="12%;"><b>Proyek</b></td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_project_name']; ?></td>
	</tr>
	<tr>
		<td width="12%;"><b>No RFQ</b></td>
		<td style="width:1%;">:</td>
		<td><?php echo $ptm_id; ?></td>
	</tr>
</table>
<br>
<!-- <p style="font-weight:bold;">Sistem Penilaian</p> -->
<div class="table-responsive" style="text-align:center;">
	<table style="width:100%;" class="table m-0">
		<tr>
			<th align="center" rowspan="2">No</th>
			<th align="center" rowspan="2">Uraian</th>
			<th align="center" rowspan="2">Bobot</th>
			<th align="center" colspan="<?php echo count($vendor_verifikasi); ?>">Penyedia Barang dan Jasa</th>
		</tr>

		<tr>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<th class='bt-custom'>".$value['vendor_name']."</th>";
			}
			?>
		</tr>

		<tr style="background-color: #2aace3;color: #fff;">
			<td align="center">I</td>
			<td align="left"><b>ADMINISTRASI</b></td>
			<td align="center"><b>Wajib</b></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Putusan</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".$value['adm']."</b></td>";
			}
			?>
		</tr>

		<tr style="background-color: #e6e7e8;">
			<td align="center"><b>A</b></td>
			<td align="left"><b>Surat Penawaran yang ditanda tangani direksi</b></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center">1</td>
			<td align="left">Kelengkapan</td>
			<td align="center">(ada/tidak)</td>
			<?php
			$par = 0;
			foreach ($evaluation as $key => $value) {
				if($value['adm'] == "Lulus")
				{
					if ($data_uskep['penilaian_kelengkapan'] == '') {
						echo "<td align='center'><select class='form-control' name='kelengkapan[]'><option>Ada</option><option >Tidak</option></select></td>";
					} else {
						if (explode(";", $data_uskep['penilaian_kelengkapan'])[$par] == "Ada") {
							echo "<td align='center'><select class='form-control' name='kelengkapan[]'><option selected>Ada</option><option>Tidak</option></select></td>";
						} else {
							echo "<td align='center'><select class='form-control' name='kelengkapan[]'><option>Ada</option><option selected>Tidak</option></select></td>";
						}
					}
					$par += 1;
				}

			}
			?>
		</tr>

	<tr>
		<td align="center">2</td>
		<td align="left">Kesesuaian</td>
		<td align="center">(sesuai/tidak sesuai)</td>
		<?php
		$par = 0;
		foreach ($evaluation as $key => $value) {
			if($value['adm'] == "Lulus")
			{
				if ($data_uskep['penilaian_kesesuaian'] == '') {
					echo "<td align='center'><select class='form-control' name='kesesuaian[]'><option>Sesuai</option><option>Tidak Sesuai</option></select></td>";
				} else {
					if (explode(";", $data_uskep['penilaian_kesesuaian'])[$par] == "Sesuai") {
						echo "<td align='center'><select class='form-control' name='kesesuaian[]'><option selected>Sesuai</option><option>Tidak Sesuai</option></select></td>";
					} else {
						if (explode(";", $data_uskep['penilaian_kesesuaian'])[$par] == "Sesuai") {
							echo "<td align='center'><select class='form-control' name='kesesuaian[]'><option selected>Sesuai</option><option>Tidak Sesuai</option></select></td>";
						} else {
							echo "<td align='center'><select class='form-control' name='kesesuaian[]'><option>Sesuai</option><option selected>Tidak Sesuai</option></select></td>";
						}
					}

					$par += 1;

				}
			}
		}
			?>
		</tr>


		<tr style="background-color: #e6e7e8;">
			<td align="center"><b>B</b></td>
			<td align="left"><b>BOQ</b></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center">1</td>
			<td align="left">Kelengkapan</td>
			<td align="center">(ada/tidak)</td>
			<?php
			$par = 0;
			foreach ($evaluation as $key => $value) {
				if($value['adm'] == "Lulus")
				{
				if ($data_uskep['penilaian_kelengkapan'] == '') {
					echo "<td align='center'><select class='form-control' name='kelengkapan[]'><option>Ada</option><option >Tidak</option></select></td>";
				} else {
					if (explode(";", $data_uskep['penilaian_kelengkapan'])[$par] == "Ada") {
						echo "<td align='center'><select class='form-control' name='kelengkapan[]'><option selected>Ada</option><option>Tidak</option></select></td>";
					} else {
						echo "<td align='center'><select class='form-control' name='kelengkapan[]'><option>Ada</option><option selected>Tidak</option></select></td>";
					}
				}
				$par += 1;
			}
			}
			?>
		</tr>

	<tr>
		<td align="center">2</td>
		<td align="left">Kesesuaian</td>
		<td align="center">(sesuai/tidak sesuai)</td>
		<?php
		$par = 0;
		foreach ($evaluation as $key => $value) {
			if($value['adm'] == "Lulus")
				{
			if ($data_uskep['penilaian_kesesuaian'] == '') {
				echo "<td align='center'><select class='form-control' name='kesesuaian_boq[]'><option>Sesuai</option><option>Tidak Sesuai</option></select></td>";
			} else {
				if (explode(";", $data_uskep['penilaian_kesesuaian'])[$par] == "Sesuai") {
					echo "<td align='center'><select class='form-control' name='kesesuaian_boq[]'><option selected>Sesuai</option><option>Tidak Sesuai</option></select></td>";
				} else {
					if (explode(";", $data_uskep['penilaian_kesesuaian'])[$par] == "Sesuai") {
						echo "<td align='center'><select class='form-control'' name='kesesuaian_boq[]'><option selected>Sesuai</option><option>Tidak Sesuai</option></select></td>";
					} else {
						echo "<td align='center'><select class='form-control' name='kesesuaian_boq[]'><option>Sesuai</option><option selected>Tidak Sesuai</option></select></td>";
					}
				}

				$par += 1;
			}
			}
		}
			?>
		</tr>


		<tr>
			<td align="center"></td>
			<td align="left"></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>

		<tr style="background-color: #2aace3;color: #fff;">
			<td align="center">II</td>
			<td align="left"><b>TEKNIS</b></td>
			<td align="center"><?php echo $evaluation_method['evt_tech_weight'].'%'; ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Threshold</td>
			<td align="center"><?php echo $evaluation_method['evt_passing_grade'].''; ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".number_format($value['pte_technical_value'], 2, '.', '')."</td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai x Bobot</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['pte_technical_weight'], 2, '.', '')."</b></td>";
			}
			?>
		</tr>




		<?php

		$par = 1;
		foreach ($evaluation_method_details as $key => $value) {

			$content_a = '';
			$content_b = '';
			$bobotNilai = $value['etd_weight']/100;

			foreach ($evaluation as $key => $value2) {

				$dataQuo = $this->Procrfq_m->getPQMID($value2['ptv_vendor_code'], $ptm_id)->row_array();
				$dataEval = $this->Procrfq_m->getQuoTech($dataQuo['pqm_id'], $value['etd_item'])->row_array();

				if ($value['etd_weight'] == 0) {
					if ($dataEval['pqt_check_vendor'] == 1) {
						$dataEval['pqt_value'] = 100;
					}
				}

				$content_a .= "<td align='center'><b>".$bobotNilai * $dataEval['pqt_value']."</b></td>";
				$content_b .= "<td rowspan='' align='center'><b>".number_format($dataEval['pqt_value'], 2, '.', '')."</b></td>";

			}

			echo '
			<tr>
				<td align="center">'.$par.'</td>
				<td align="left"><b>'.$value['etd_item'].'</b></td>
				<td align="center"><b>'.$value['etd_weight'].'%</b></td>
				'.$content_a.'
			</tr>

			';

			$this->db->where('detail_evaluasi_id', $value['etd_id']);
			$petunjukScoreList = $this->db->get('prc_evaluation_petunjuk_score')->result_array();

			if(count($petunjukScoreList) > 0)
			{
				foreach($petunjukScoreList as $key_score => $v_score) {
					# code...
					echo '
					<tr>
						<td align="center">-</td>
						<td align="left"><b>'.$v_score['deskripsi'].'</b></td>
						<td align="center">'.$v_score['bobot'].'</td>
						'.$content_b.'
					</tr>

					';

				}
			}




		$par += 1;
		}


		?>
		<tr>
			<td align="center"></td>
			<td align="left"></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>

		<tr style="background-color: #2aace3;color: #fff;">
			<td align="center">III</td>
			<td align="left"><b>HARGA</b></td>
			<td align="center"><?php echo $evaluation_method['evt_price_weight'].'%'; ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai HPS</td>
			<td align="center"><?php echo number_format($nilai_hps, 2); ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".number_format($value['pte_price_value'], 2, '.', '')."</td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left">Nilai x Bobot</td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['pte_price_weight'], 2, '.', '')."</b></td>";
			}
			?>
		</tr>

		<!-- <tr>
			<td align="center"></td>
			<td align="left"></td>
			<td align="center"></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr> -->
		<tr>
			<td align="center">A</td>
			<td align="left"><b>ASPEK HARGA</b></td>
			<td align="center"><?php  ?></td>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<td></td>";
			}
			?>
		</tr>


		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>Harga Negosiasi Final(dalam Rupiah)</b></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['amount'], 2)."</b></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>Deviasi Terhadap Nilai HPS</b></td>
			<?php
			foreach ($evaluation as $key => $value) {
				$amount = $nilai_hps - $value['amount'];
				echo "<td align='center'><b>".number_format($amount, 2)."</b></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>NILAI EVALUASI TOTAL (NET)</b></td>
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".number_format($value['total'], 2, '.', '')."</b></td>";
			}
			?>
		</tr>

		<tr>
			<td align="center"></td>
			<td align="left" colspan="2"><b>PERINGKAT</b></td>
			<?php
			$par = 1;
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'><b>".$par."</b></td>";
				$par += 1;
			}
			?>
		</tr>


		<tr>

			<td colspan="<?php echo (count($evaluation) + 3 - 2); ?>" style="border: 0px"></td>
			<td colspan="2" align=" center" style="border: 0px">

				<br>
				<?php echo $data_uskep['bakp_city'].' '.date('d M Y'); ?>
				<br>
				<br>
				<br>
				<br>
				<br>
				<select class="form-control select2" name="penilaian_ttd">
					<?php
						foreach ($nama_user_approval as $value) {
							if ($data_uskep['penilaian_ttd'] ==  $value) {
								echo '<option selected>'.$value.'</option>';
							} else {
								echo '<option>'.$value.'</option>';
							}

						}
					?>
				</select>

			</td>

		</tr>

	</table>
</div>

</form>


<?php if($data_uskep['penilaian_ttd'] != "" && $data_uskep['penilaian_is_share'] == null ) : ?>
<!-- <a onclick="fUploadDoc()" class="btn btn-info btn-sm" style="margin-top: -90px;"><i class="ft ft-upload"></i> Upload & Share E-Sign</a> -->
<?php endif; ?>

<?php if($data_uskep['penilaian_ttd'] != "" && $data_uskep['penilaian_is_share'] != null ) : ?>
<a href="<?php echo base_url()."index.php/PrivyPenilaianUskep/save_doc/".$ptm_id; ?>" class="btn btn-info btn-lg" style="margin: 5px;"><i class="ft ft-upload"></i> Get PDF E-sign</a>
<?php endif; ?>

<?php $this->load->view('devextreme'); ?>

<script>


		function fUploadDoc() {
			$(`#myLoader`).modal('show');
		var url = '<?php echo base_url()."index.php/PrivyPenilaianUskep/upload_doc/".$ptm_id; ?>';
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
</script>
