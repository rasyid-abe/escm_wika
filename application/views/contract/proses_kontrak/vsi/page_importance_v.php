<div class="table-responsive" style="display:none">
	<table class="table table-bordered" id="item_table">		
		<tbody>
		<?php if (!empty($vendor)) : ?>
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
			<?php endif; ?>

			<tr>
				<th colspan="2"><center>Total</center></th>
				<?php if (!empty($total_imp)) : ?>
				<?php $total_imp = array_shift($imp);

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
				<?php endif; ?>
			</tr>
		</tbody>
	</table>
</div>	