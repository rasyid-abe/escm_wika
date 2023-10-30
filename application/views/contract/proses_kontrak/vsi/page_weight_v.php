<div class="table-responsive" style="display:none">
	<table class="table table-bordered" id="item_table">		
		<tbody>
			<?php if (!empty($vendor)) : ?>
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
				<?php endif; ?>

				<tr>
					<?php if (!empty($weightimp)) : ?>
					<th colspan="2"><center>Total</center></th>
					<?php foreach ($weightimp as $key => $value){ ?>

					   <th><center><?php echo array_sum($value); ?></center></th>
					<?php }	?>
					<?php endif; ?>
				</tr>
		</tbody>
	</table>
</div>	