<div class="wrapper wrapper-content animated fadeInRight">
  <form class="form-horizontal ajaxform">

    <?php 
      foreach ($content as $key => $value) {

        include(VIEWPATH."procurement/proses_pengadaan/view/".$value['awc_file'].".php");
      }
    ?>

    <?php $i = 0; include(VIEWPATH."/comment_view_v.php") ?>

    <?php echo buttonback('procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan',lang('back')) ?>

  </form>

</div>