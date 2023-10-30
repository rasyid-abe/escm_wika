<div class="table-responsive">
	<table class="table table-bordered" id="item_table">
		<thead>			
			<tr>
				<th rowspan="2" style="width:10px" >No</th>
				<th rowspan="2"><center>Nama Vendor</center></th>
				<th colspan="<?php echo count($header) ?>" ><center><?php echo "Tingkat Kepuasan" ?></center></th>
				<th rowspan="2"><center>Total</center></th>
			</tr>
			
			<tr>
				<?php $i=1;
				foreach ($header as $k => $v) { ?>
					<th ><center><?php echo "s".$i ?></center></th>
				<?php $i++; }	?>
			</tr>
			
		</thead>
		<tbody>
			<?php 
			$i = 1; 
			$allv = 0;
			$count = [];
			foreach ($vendor as $ky => $val) { ?>
				<tr>
					<td>
						<center><?php echo $i; ?></center>
					</td>
					<td>
						<?php echo $val['vendor_name']; ?>
					</td>

					<?php 
					$tot = [];
					$i = 0;
					$eachv = 0;
					foreach ($quest[$ky] as $keys => $values) { ?>
						<td>
							<center><?php echo $values['vvk_satis_score'] ?></center>
						</td>
						<?php $eachv += $values['vvk_satis_score']; }	?>
						<td>
							<center><?php echo $eachv; ?></center>
						</td>
				</tr>
			<?php $i++; 
			$satisvend[$ky] = $eachv;
			} ?>
				<tr>
					<th colspan="2"><center>Total</center></th>
					<?php 
					
					$total_satis = array_shift($satis);

					foreach ($total_satis as $key => $vals){

					   $vals += array_sum(array_column($satis, $key)); 

					   ?>

					   <th><center><?php echo $vals ?></center></th>
					<?php 

					$satisperque[] = $vals;
					}	
					?>
					<th>
						<?php 
						$all = 0;
						foreach ($quest as $key => $value) {
							foreach ($value as $sk => $sv) {
								$all += $sv['vvk_satis_score'];
							}
						}
						?>
						<center><?php echo $all; ?></center>
					</th>
				</tr>
		</tbody>
	</table>
</div>	