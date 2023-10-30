<div class="table-responsive" style="display:none">
	<div class="col-lg-7">
		<table class="table table-bordered" id="item_table">			
			<tbody>
				<?php if (!empty($vendor)) : ?>
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
				<?php endif; ?>
				<tr>
					<th colspan="2"><center>Rata-Rata</center></th>
				
					<th><center><?php echo $vsit/count($vendor)." %"; ?></center></th>
				</tr>					
			</tbody>	
		</table>
	</div>	
</div>