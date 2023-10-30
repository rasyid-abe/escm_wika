<div class="table-responsive">
	<table class="table table-bordered" id="item_table">
		<thead>			
			<tr>
				<th rowspan="2" style="width:10px" >No</th>
				<th rowspan="2"><center>Nama Vendor</center></th>
				<th colspan="<?php echo count($header) ?>" ><center><?php echo "Weight-i" ?></center></th>
			</tr>
			
			<tr>
				<?php $i=1;
				foreach ($header as $k => $v) { ?>
					<th ><center><?php echo "W-i".$i ?></center></th>
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
					foreach ($quest[$ky] as $keys => $values) {
						$weightimp[$keys][$ky] = $values['vvk_imp_score']/$impvend[$ky];
					 ?>
						<td>
							<center><?php echo $weightimp[$keys][$ky] ?></center>
						</td>
						<?php  }	?>
						
				</tr>
			<?php $i++; } ?>
				<tr>
					<th colspan="2"><center>Total</center></th>
					<?php foreach ($weightimp as $key => $value){ ?>

					   <th><center><?php echo array_sum($value); ?></center></th>
					<?php }	?>
				</tr>
		</tbody>
	</table>
</div>	