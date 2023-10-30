<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url("contract_ext_matgis/submit_process_matgis");?>"  class="form-horizontal ajaxform">
		<?php
		foreach ($content as $key => $value) {
			include(VIEWPATH."/contract/matgis/".$value['awc_type']."/".$value['awc_file'].".php");
		}
		$i = 0;
			include(VIEWPATH."/contract/matgis/comment_workflow_v.php");
			echo buttonsubmit('kontrak',lang('back'),lang('save'));
			?>
	</form>

</div>
