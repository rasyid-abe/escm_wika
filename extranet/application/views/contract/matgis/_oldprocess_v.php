<style media="screen">
.wrapper-content {
  padding: 10px 5px 20px;
}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url("contract_ext_matgis/submit_process_matgis/".$mod);?>" enctype="multipart/form-data"  class="form-horizontal ajaxform">
    <?php include('header_matgis_v.php'); ?>
    <?php
    include('item_matgis_v.php');
    $i = 0;
    include(VIEWPATH."/matgis/comment_workflow_v.php");
    echo buttonsubmit('kontrak',lang('back'),lang('save'));?>
  </form>
</div>
