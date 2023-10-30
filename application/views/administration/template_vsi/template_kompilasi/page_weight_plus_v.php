<div class="table-responsive">
	<table class="table table-bordered" id="item_table">
		<thead>			
			<tr>
				<th rowspan="2" style="width:10px" >No</th>
				<th rowspan="2"><center>Nama Vendor</center></th>
				<th colspan="<?php echo count($header) ?>" ><center><?php echo "Weight-i*s" ?></center></th>
				<th rowspan="2"><center>Total</center></th>
			</tr>
			
			<tr>
				<?php $i=1;
				foreach ($header as $k => $v) { ?>
					<th ><center><?php echo "W-i*s".$i ?></center></th>
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
					$summ = 0;
					$i = 0;
					foreach ($quest[$ky] as $keys => $values) {
						$weightimp[$keys][$ky] = $values['vvk_satis_score']*$weightimp[$keys][$ky];
						$weightkuadrat[$ky][$keys] = $values['vvk_satis_score']*$weightimp[$keys][$ky];

						$summ += $weightimp[$keys][$ky]; 
					 ?>
						<td>
							<center><?php echo $weightimp[$keys][$ky] ?></center>
						</td>
					<?php  }	?>
					<td>
						<center><?php echo $summ ?></center>
					</td>
						
				</tr>
			<?php $i++; } ?>
				<tr>
					<th colspan="2"><center>Total</center></th>
					<?php 
					$sumt = 0;
					foreach ($weightimp as $key => $value){ 
						$sumt += array_sum($value) ?> 
					   <th><center><?php echo array_sum($value); ?></center></th>
					<?php }	?>
						<th>
							<center><?php echo $sumt ?></center>
						</th>
				</tr>

		</tbody>
	</table>
</div>	