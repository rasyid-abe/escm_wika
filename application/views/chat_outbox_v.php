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

          <div class="col-lg-9 animated fadeInRight">
              <div class="mail-box-header">

                  <form method="get" action="index.html" class="pull-right mail-search">
                      <div class="input-group">
                          <input type="text" class="form-control input-sm" name="search" placeholder="Search email">
                          <div class="input-group-btn">
                              <button type="submit" class="btn btn-sm btn-primary">
                                  Search
                              </button>
                          </div>
                      </div>
                  </form>
                  <h2>
                      Outbox (16)
                  </h2>
              </div>
                  <div class="mail-box">

                  <table class="table table-hover table-mail">
                  <tbody>
                  <tr class="unread">
                      <td class="mail-ontact"><a href="mail_detail.html">Anna Smith</a></td>
                      <td class="mail-subject"><a href="mail_detail.html">Lorem ipsum dolor noretek imit set.</a></td>
                      <td class=""><i class="fa fa-paperclip"></i></td>
                      <td class="text-right mail-date">6.10 AM</td>
                  </tr>
                  <tr class="unread">
                      <td class="mail-ontact"><a href="mail_detail.html">Jack Nowak</a></td>
                      <td class="mail-subject"><a href="mail_detail.html">Aldus PageMaker including versions of Lorem Ipsum.</a></td>
                      <td class=""></td>
                      <td class="text-right mail-date">8.22 PM</td>
                  </tr>
                  <tr class="read">
                      <td class="mail-ontact"><a href="mail_detail.html">Facebook</a> </td>
                      <td class="mail-subject"><a href="mail_detail.html">Many desktop publishing packages and web page editors.</a></td>
                      <td class=""></td>
                      <td class="text-right mail-date">Jan 16</td>
                  </tr>
                  
                  </tbody>
                  </table>


                  </div>
              </div>

         </div>
 
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-md-12">
        <div style="margin-bottom: 60px;">
          <?php echo buttonsubmit('home',lang('back')) ?>
        </div>
      </div>
    </div>

  </form>
</div>