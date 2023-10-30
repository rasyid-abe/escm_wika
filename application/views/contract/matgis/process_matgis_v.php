<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url("contract_matgis/submit_process_matgis/".$mod."/".$id);?>"  class="form-horizontal ajaxform">
		<?php
		foreach ($content as $key => $value) {
			//include($value['awc_type']."/".$value['awc_file'].".php");
			include(VIEWPATH."/contract/matgis/".$value['awc_type']."/".$value['awc_file'].".php");
		}
		$i = 0;
			include(VIEWPATH."/comment_workflow_v.php");
			echo buttonsubmit('contract_matgis/task_lists',lang('back'),lang('save'));
			?>
	</form>

</div>
