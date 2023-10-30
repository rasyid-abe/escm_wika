<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url("contract_matgis/submit_proses_matgis/wo");?>"  class="form-horizontal ajaxform">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<?php
		// print_r($content);
		// die();
		foreach ($content as $key => $value) {

			include($value['awc_type']."/".$value['awc_file'].".php");

		}


		?>

		<?php
		$i = 0;
		include(VIEWPATH."/comment_workflow_v.php");
		?>

		<?php echo buttonsubmit('contract/work_order_matgis',lang('back'),lang('save')) ?>

	</form>

</div>
