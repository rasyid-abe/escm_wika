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
                    <li><a href="<?php echo site_url('chat/chat_inbox') ?>"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right">16</span> </a></li>
                    <li><a href="<?php echo site_url('chat/chat_outbox') ?>"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-9">
            <div class="mail-box-header">
              <h2>
                Compose mail
              </h2>
            </div>
            <div class="mail-box">
              <div class="mail-body">

                <form class="form-horizontal" method="get">
                  <div class="form-group"><label class="col-sm-2 control-label">To:</label>

                    <div class="col-sm-10"><input type="text" class="form-control" value="alex.smith@corporat.com"></div>
                  </div>
                  <div class="form-group"><label class="col-sm-2 control-label">Subject:</label>

                    <div class="col-sm-10"><input type="text" class="form-control" value=""></div>
                  </div>

                  <div class="form-group"><label class="col-sm-2 control-label">Lampiran:</label>

                    <div class="col-sm-10"><input type="file" class="form-control" value=""></div>
                  </div>
                </form>

              </div>

              <div class="mail-text h-10">

                <div class="summernote" style="display: none;">
                  <h3>Hello Jonathan! </h3>
                  dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
                  when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                  typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                  <br>
                  <br>                
                </div>
                <div class="mail-body text-right tooltip-demo">
                  <a href="mailbox.html" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Send"><i class="fa fa-reply"></i> Send</a>
                  <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                </div>
                <div class="clearfix"></div>

              </div>
            </div>

          </form>
        </div>