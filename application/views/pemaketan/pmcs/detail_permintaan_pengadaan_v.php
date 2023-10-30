<div class="wrapper wrapper-content animated fadeInRight">

  <form class="form-horizontal">

		<?php 

		$loaded = array();
		foreach ($content as $key => $value) {
			$str = "view/".$value['awc_file'].".php";
			if(!in_array($str, $loaded)){
				include($str);
				$loaded[] = $str;
			}
		}

		?>

    <?php 
    $i = 0;
    include(VIEWPATH."/comment_view_attachment_v.php"); 
    ?>

	<div class="card">				
		<div class="card-content">
			<div class="card-body">						
				<?php echo buttonback("paket_pengadaan/paket_proyek_pmcs",lang('back'),lang('save')) ?>
			</div>
		</div>
	</div>

  </form>

  <?php
  	//haqim
	include VIEWPATH.'procurement/proses_pengadaan/chat_pr_v.php';
	//end
  ?>

  

</div>
