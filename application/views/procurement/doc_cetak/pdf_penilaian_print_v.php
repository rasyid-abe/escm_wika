<style type="text/css">
	html{
		font-family:sans-serif;
	}
	table {
		font-size: 10px;
	}
	
	td {
		padding: 5px;
	}

	th {
		padding: 5px;
		font-weight: bold;
		/*background-color: #b0ffc2;*/
		background-color: #00aeef;
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
</style>

<?php $tgl_penetapan_pemenang = date('Y-m-d'); ?>

<table style="width: 100%;">
<tr>
	<td width="1%"><img width="50" src="<?php echo base_url('assets/img/favicon.png') ?>"></td>
	<td ><b>PT. Wijaya Karya (Persero)Tbk</b><br><?php echo $tender['ptm_dept_name']; ?></td>
	
</tr>
</table>
<br>
<center>
	<h5 style="margin:0px;">DOKUMEN SISTEM PENILAIAN</h5>
</center>
<br>

<table style="width:100%;">
	<tr>
		<td width="12%;">Paket Pengadaan</td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_project_name']; ?></td>
	</tr>
	<tr>
		<td width="12%;">Proyek</td>
		<td style="width:1%;">:</td>
		<td><?php echo $tender['ptm_district_name']; ?></td>
	</tr>
	<tr>
		<td width="12%;">No RFQ</td>
		<td style="width:1%;">:</td>
		<td><?php echo $ptm_id; ?></td>
	</tr>
</table>

<p style="font-weight:bold;">Sistem Penilaian</p>

<table style="width:100%;" class="is-content">
<tr>
			<th align="center" rowspan="2">No</th>
			<th align="center" rowspan="2">Uraian</th>
			<th align="center" rowspan="2">Bobot</th>
			<th align="center" colspan="<?php echo count($vendor_verifikasi); ?>">Penyedia Jasa / Pemasok</th>
		</tr>

		<tr>
			<?php
			foreach ($vendor_verifikasi as $key => $value) {
				echo "<th>".$value['vendor_name']."</th>";
			}
			?>
		</tr>

		<tr>
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

		<tr>
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
				echo "<td align='center'>".$kelengkapan[$par]."</td>";
				$par += 1;
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
			echo "<td align='center'>".$kesesuaian[$par]."</td>";
			$par += 1;
		}
		?>
		</tr>


		<tr>
			<td align="center"><b>B</b></td>
			<td align="left"><b>BOQ</b></td>
			<td align="center"></td>
			<?php
			$par = 0;
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'>".$kelengkapan[$par]."</td>";
				$par += 1;
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
				echo "<td align='center'>".$kesesuaian[$par]."</td>";
				$par += 1;
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
			echo "<td align='center'>".$kesesuaian[$par]."</td>";
			$par += 1;
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

		<tr>
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

		<tr>
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

		
			<?php
			foreach ($evaluation as $key => $value) {
				echo "<td align='center'></td>";
			}
			?>
		</tr>
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


	</tr>
	

</table>

<div class="page_break"></div>
<table style="width:100%;" class="is-content">
	<tr>

		<td style="border: 0px; width: 60%"></td>
		<td colspan="2" align=" center" style="border: 0px">

			
			
		<br>
			<?php echo $data_uskep['bakp_city'].' '.date('d M Y'); ?> 
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<b><u><?php echo explode(" - ", $penilaian_ttd)[0]; ?></u></b><br>
			<?php echo explode(" - ", $penilaian_ttd)[1]; ?>


		</td>

	</tr>

</table>


<script type="text/php">
if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
        	//$canvas = $dompdf->get_canvas();
        	//$h = $canvas->get_height() - 15;

            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 9;
            $pageText = "(Dokumen ini dicetak otomatis di sistem eSCM WIKA)";
            $pageText2 = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 15;
            $x = 520;
            $pdf->text(10, $y, $pageText, $font, $size);
            $pdf->text($x, $y, $pageText2, $font, $size);
        } 
    ');
}
</script>