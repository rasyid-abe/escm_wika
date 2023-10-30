<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/daftar_pekerjaan_view");?>"  class="form-horizontal">

  <?php include("view/header_v.php") ?>

  <?php include("view/detail_progress_v.php") ?>

  <?php include("view/item_v.php") ?>

  <?php include("view/milestone_v.php") ?>

  <?php include("view/lampiran_v.php") ?>

  <?php include("view/bastp_v.php") ?>

  <?php include("view/komentar_v.php") ?>

  <div class="card">				
    <div class="card-content">
      <div class="card-body">			                    
        <?php echo buttonsubmit('',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

  </form>

</div>