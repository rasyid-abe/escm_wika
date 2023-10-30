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
					foreach ($quest[$ky] as $keys => $values) { ?>
						<td>
							<center><?php echo $values['vvk_satis_score'] ?></center>
						</td>
						<td>
							<center><?php echo $values['vvk_imp_score'] ?></center>
						</td>
					<?php }	?>
				</tr>
			<?php $i++; } ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>