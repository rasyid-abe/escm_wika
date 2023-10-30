<div class="wrapper wrapper-content animated fadeInRight">
  <!-- <form method="post" action="<?php echo site_url($controller_name."/submit_change_password");?>"  class="form-horizontal"> -->
    <div class="row">
      <div class="wrapper wrapper-content">
        <div class="row">
          <div class="col-lg-3">
            <div class="card float-e-margins">
              <div class="card-content mailbox-content">
                <div class="file-manager">
                  <a class="btn btn-block btn-primary compose-mail" href="<?php echo site_url('chat/chat_compose') ?>">Compose Mail</a>
                  <div class="space-25"></div>
                  <h5>Folders</h5>
                  <ul class="folder-list m-b-md" style="padding: 0">
                    <li><a href="<?php echo site_url('chat/chat_inbox') ?>"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right"><?php echo $jml_chat?></span> </a></li>
                    <li><a href="<?php echo site_url('chat/chat_outbox') ?>"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">

              <form method="get" action="index.html" class="pull-right mail-search">
                
              </form>
              <h2>
                Inbox (16)
              </h2>
            </div>
            <div class="mail-box">

              <table class="table table-hover table-mail dataTables-example table-hover">
                <thead>
                  <tr>
                    <td>Nomor RFQ</td>
                    <td>Deskripsi RFQ</td>
                    <td>Pesan Dari</td>
                    <td>Chat Belum Dibaca</td>
                  </tr>
                </thead>
                <tbody>
                  <?php if($rfq == null) { ?>
                  <td class="mail-subject text-center" colspan="4">Tidak ada chat RFQ pada position ini</td>
                  <?php } else { ?>
                  <?php foreach ($rfq as $key) { ?>

                  <tr class="
                  <?php if($key['status'] == 1 ) {?>
                  <?php echo 'unread' ?>
                  <?php } else {?>
                  <?php echo 'read' ?>
                  <?php }?>">

                  <td class="mail-ontact"><a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$key['ptm_number']) ?>" target="_blank"><?php echo $key['ptm_number']; ?></a> </td>
                  <td class="mail-subject"><a href="mail_detail.html"><?php echo $key['ptm_subject_of_work'].$key['status']; ?></a></td>
                  <td class=""><?php echo $key['fullname']; ?></td>
                  <td class="text-center"><?php echo $key['date_added'].$key['time_added']?></td>
                </tr>
                <?php } ?>
                <?php }?>


              </tbody>
            </table>


          </div>
      </div>

    </div>
  </div>
</div>

<br>

</form>
</div>

<script>
  $(document).ready(function(){
    $('.dataTables-example').DataTable({
      pageLength: 25,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
    });

  });

</script>
