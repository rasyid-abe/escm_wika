<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action=""  class="form-horizontal ajaxform">
		<?php
		$i = 0;
		foreach ($content as $key => $value) {
			include(VIEWPATH."/contract/matgis/view/".$value['awc_file'].".php");
		}
			include("comment_workflow_v.php");
			echo buttonback('contract_matgis/monitor_matgis/reports',lang('back'));
		?>
	</form>

</div>
