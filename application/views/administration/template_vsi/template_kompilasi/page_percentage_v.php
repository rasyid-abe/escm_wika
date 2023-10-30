
<div class="table-responsive">
	<div class="col-lg-7">
		<table class="table table-bordered" id="item_table">
			<thead>			
				<tr>
					<th>No</th>
					<th><center>Nama Vendor</center></th>
					<th><center>VSI</center></th>
				</tr>			
			</thead>
			<tbody>
				<?php 
				$i = 1; 
				$allv = 0;
				$count = [];
				$vsit = 0;
				foreach ($vendor as $ky => $val) { ?>
					<tr>
						<td>
							<center><?php echo $i; ?></center>
						</td>
						<td>
							<?php echo $val['vendor_name']; ?>
						</td>					
						<td><center>
							<?php 
							$pre = 0;
							foreach ($weightimp as $key => $value) {
								$pre += $value[$ky];
							}
							$vsi = ($pre/4)*100;
							$vsit += $vsi;
							echo $vsi." %";
							?>
						</center></td>	
					</tr>
				<?php $i++; }  ?>
				<tr>
					<th colspan="2"><center>Rata-Rata</center></th>
				
					<th><center><?php echo $vsit/count($vendor)." %"; ?></center></th>
				</tr>
					
			</tbody>	
		</table>
	</div>
	
	<div class="col-lg-5">

		VSI (Vendor Satisfaction Index) adalah : <p>
		Indeks yang merefleksikan tingkat kepuasan VENDOR terhadap WIKA<p>
		1. VSI  < 26% = <b>SANGAT TIDAK PUAS</b><p>
		2. VSI 26% - 60% = <b>KURANG PUAS</b><p>
		3. VSI 60% - 80% = <b>PUAS</b><p>
		4. VSI > 80% = <b>SANGAT PUAS</b>
	</div>
</div>