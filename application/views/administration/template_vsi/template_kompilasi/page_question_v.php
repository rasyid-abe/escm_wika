<div class="table-responsive">
	<table class="table table-bordered" id="item_table">
		<thead>
			<tr>
				<th rowspan="3" style="width: 10px">No</th>
				<th rowspan="3" ><center>Nama Vendor</center></th>
				<?php 
				$isi = "";
				$ch = 1;
				foreach ($header as $key => $value) { 

					if ($ch <= count($headname) ) { ?>
					
						<th colspan="<?php echo $th[$value['vvk_quest_header']]*2 ?>"><center><?php echo $headname[$key] ?></center></th>

					<?php 
				} 
				// $isi = $value['vvk_quest_header'];
					$ch++;
				 } ?>									
			</tr>
			
			<tr>
				<?php 
				foreach ($header as $k => $v) { ?>
					<th colspan="2"><center><?php echo $v['vvk_quest_name']."" ?></center></th>
				<?php }	?>
			</tr>
			
			<tr>
				<?php 
				for ($i=0; $i < count($header)*2 ; $i++) {  
					if ( $i % 2 == 0) {	?>
						<th ><center>Tingkat Kepuasan</center></th>
				<?php }else{ ?>
						<th ><center>Tingkat Kepentingan</center></th>
				<?php }	} ?>	
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

		</tbody>
	</table>
</div>