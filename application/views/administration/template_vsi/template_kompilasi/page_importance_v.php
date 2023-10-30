<div class="table-responsive">
	<table class="table table-bordered" id="item_table">
		<thead>
			
			<tr>
				<th rowspan="2" style="width:10px" >No</th>
				<th rowspan="2"><center>Nama Vendor</center></th>
				<th colspan="<?php echo count($header) ?>" ><center><?php echo "Tingkat Kepentingan" ?></center></th>
				<th rowspan="2"><center>Total</center></th>
			</tr>
			
			<tr>
				<?php $i=1;
				foreach ($header as $k => $v) { ?>
					<th ><center><?php echo "i".$i ?></center></th>
				<?php $i++; }	?>
			</tr>
			
		</thead>
		<tbody>
			<?php $i = 1; foreach ($vendor as $ky => $val) { ?>
				<tr>
					<td>
						<center><?php echo $i; ?></center>
					</td>
					<td>
						<?php echo $val['vendor_name']; ?>
					</td>

					<?php 
					$tot = 0;
					$eachv = 0;
					foreach ($quest[$ky] as $keys => $values) { ?>
						<td>
							<center><?php echo $values['vvk_imp_score'] ?></center>
						</td>
					<?php 
					$tot += $values['vvk_imp_score']; } ?>
						<td>
							<center><?php echo $tot; ?></center>
						</td>
				</tr>
			<?php $i++;
			$impvend[$ky] = $tot;
			 } ?>
				<tr>
					<th colspan="2"><center>Total</center></th>
					<?php 
					
					$total_imp = array_shift($imp);

					foreach ($total_imp as $key => &$value){
					   $value += array_sum(array_column($imp, $key)); 
					   ?>

					   <th><center><?php echo $value; ?></center></th>
					<?php 
					$impperque[] = $value;
					}	?>
					<th>
						<?php 
						$all = 0;
						foreach ($quest as $key => $value) {
							foreach ($value as $sk => $sv) {
								$all += $sv['vvk_imp_score'];
							}
						}
						?>
						<center><?php echo $all; ?></center>
					</th>
				</tr>

		</tbody>
	</table>
</div>	