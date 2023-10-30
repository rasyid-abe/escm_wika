<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo $url_submit ?>"  class="form-horizontal ajaxform">

  	<?php if(isset($id) && !empty($id)){ ?>
  	 <input type="hidden" name="id" value="<?php echo $id ?>">
  	<?php } ?>

<?php 
foreach ($content as $key => $value) {

	$t = ($view) ? "view" : $value['awc_type'];

	include(VIEWPATH."procurement/proses_pengadaan/".$t."/".$value['awc_file'].".php");
}

?>

<?php 
$i = 0;
include(VIEWPATH."/comment_workflow_v.php") ?>

<?php echo buttonsubmit('procurement/daftar_pekerjaan',lang('back'),lang('save')) ?>

</form>

</div>