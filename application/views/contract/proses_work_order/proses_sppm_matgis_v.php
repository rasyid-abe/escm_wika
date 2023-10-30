<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_proses_sppm_matgis");?>"  class="form-horizontal ajaxform">
		<?php //print_r($data);die;?>
		<input type="hidden" name="id" value="<?php echo $id ?>">

		<?php
		 //print_r($content);
		 //die();
		foreach ($content as $key => $value) {

			include($value['awc_type']."/".$value['awc_file'].".php");

		}


		?>

		<?php
		$i = 0;
		include(VIEWPATH."/comment_workflow_v.php");


		?>

		<?php echo buttonsubmit(site_url($controller_name."/submit_proses_sppm_matgis"));?>

	</form>

</div>
