<style>
  fieldset.informasi-user {
    border: 1px groove #949494 !important;
    padding: 0 1.4em 0.4em 1.4em !important;
    margin: 0 0 0 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
  }
  legend.informasi-user {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
  }
  legend {
    width: 40%;
  }
</style>

<div class="modal fade" id="upld_UskepOnline" tabindex="-1" role="dialog" aria-labelledby="upld_UskepOnlineLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('uskep_online_sap/import_uskep'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih File Uskep</label>
                        <input type="file" name="fileUskep">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed hidden-print">
   <div class="container-fluid navbar-wrapper">
      <div class="navbar-header d-flex">
            <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
            <ul class="navbar-nav">
               <li class="nav-item mr-2 d-none d-lg-block">
                 <a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;">
                   <i class="ft-maximize font-medium-3"></i>
                 </a>
               </li>
               <li>
                 <img src="<?= base_url('assets/img/Logo_BUMN_Untuk_Indonesia_2020.png') ?>" width="150" />
               </li>
            </ul>
      </div>

      <div class="navbar-container">
         <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
            <ul class="navbar-nav mt-2">
               <!--- ============ New Remider Document Vendor ================ -->
               <?php if($this->data['userdata']['pos_id'] == "27") { ?>
               <li class="dropdown">
                  <a class="count-info" href="<?php echo site_url("laporan/monitor_dokumen_vendor");?>/expired">
                     <i data-toggle="tooltip" data-placement="bottom" title=""
                        data-original-title="Info Document Expired Vendor"
                        class="fa fa-clock-o"></i><?php if(count($docExVends) > 0 ) { echo $this->session->userdata('totalDocExVend'); } ?></span>
                  </a>
               </li>
               <?php } ?>

               <li class="i18n-dropdown dropdown nav-item mr-2"><a class="nav-link d-flex align-items-center dropdown-toggle dropdown-language" id="dropdown-flag" href="javascript:;" data-toggle="dropdown"><img class="langimg selected-flag" src="<?php echo base_url('assets')?>/app-assets/img/flags/ina.jpg" alt="flag" style="width:30px;"><span class="selected-language d-md-flex d-none">Indonesia</span></a>
               <!-- <li class="i18n-dropdown dropdown nav-item mr-2"><a class="nav-link d-flex align-items-center dropdown-toggle dropdown-language" id="dropdown-flag" href="javascript:;" data-toggle="dropdown"><img class="langimg selected-flag" src="<?php echo base_url('assets')?>/app-assets/img/flags/us.png" alt="flag"><span class="selected-language d-md-flex d-none">English</span></a> -->
                     <div class="dropdown-menu dropdown-menu-right text-left" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="javascript:;" data-language="en"><img class="langimg mr-2" src="<?php echo base_url('assets')?>/app-assets/img/flags/us.png" alt="flag"><span class="font-small-3">English</span></a><a class="dropdown-item" href="javascript:;" data-language="es"><img class="langimg mr-2" src="<?php echo base_url('assets')?>/app-assets/img/flags/es.png" alt="flag"><span class="font-small-3">Spanish</span></a><a class="dropdown-item" href="javascript:;" data-language="pt"><img class="langimg mr-2" src="<?php echo base_url('assets')?>/app-assets/img/flags/pt.png" alt="flag"><span class="font-small-3">Portuguese</span></a></div>
               </li>

               <li class="dropdown nav-item mr-2">
                  <a class="nav-link count-info dropdown-toggle user-dropdown d-flex align-items-end" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown">
                     <i class="ft-mail"></i><?php if($tmessages == 1) { echo $this->session->userdata('totalmessages'); } ?></span>
                  </a>
                  <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2">
                     <?php if($tmessages == 1) {?>
                        <?php foreach ($messages as $jcrr) { ?>
                           <a class="dropdown-item" href="<?php echo site_url('log/readchat/'.$jcrr['id']) ?>">
                              <div class="d-flex align-items-center">
                                 <i class="ft-message-circle"></i>&nbsp;&nbsp;<?php echo $jcrr['rfq_number'] ?> <br>
                                 &nbsp;&nbsp;&nbsp;&nbsp; <small><?php echo substr($jcrr['pesan'],0,30)?> ...</small>
                              </div>
                           </a>
                        <?php } ?>
                     <?php } else { ?>
                        <a class="dropdown-item">
                           <div class="d-flex align-items-center">
                           <?php echo $this->lang->line('no_data'); ?>
                           </div>
                        </a>
                     <?php } ?>
                  </div>
               </li>

               <!--- ============ New notif ================ -->
               <li class="dropdown nav-item mr-1"><a class="nav-link dropdown-toggle dropdown-notification" id="dropdownBasic1" href="javascript:;" data-toggle="dropdown"><i class="ft-bell font-medium-1"></i><span class="notification badge badge-pill badge-danger"><?php echo count($jobs)?></span></a>
                  <ul class="notification-dropdown dropdown-menu dropdown-menu-media dropdown-menu-right overflow-hidden">
                     <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex justify-content-between white bg-info">
                              <div class="d-flex"><i class="ft-bell font-medium-3 d-flex align-items-center mr-2"></i><span class="noti-title"><?php echo count($jobs)?> <?php echo $this->lang->line('notification'); ?></span></div>
                        </div>
                     </li>
                     <?php if(count($jobs) > 0 ) { ?>
                     <li class="scrollable-container">
                        <?php foreach ($jobsrow as $j) { $u = $j['url'].$j['id']; ?>
                           <a class="d-flex justify-content-between" href="<?php echo site_url('log/change_role/'.$j['pos_id'].'/'.str_replace("/", "-", $u)) ?>">
                              <div class="media d-flex align-items-center">
                                 <div class="media-left">
                                    <div class="mr-2"><i class="<?php echo $j['icon']; ?> font-medium-3"></i></div>
                                 </div>
                                 <div class="media-body">
                                    <?php echo $j['number']?> <br>
                                    <small><?php echo substr($j['activity'],0,30)?></small>
                                 </div>
                              </div>
                           </a>
                           <?php } ?>
                     </li>

                     <?php if(count($jobs) > 5) { ?>
                     <li class="dropdown-menu-footer">
                        <a href="<?php echo site_url('/log/alljob/')?>">
                           <div class="noti-footer text-center cursor-pointer info border-top text-bold-400 py-1">Read All Notifications (<?php echo count($jobs)-5?>)</div>
                        </a>
                     </li>
                     <?php } ?>

                     <?php } else { ?>
                        <div class="d-flex justify-content-between cursor-pointer read-notification">
                           <div class="media d-flex align-items-center">
                              <div class="media-body">
                                 <h6 class="m-0"><small class="grey lighten-1 font-italic text-center"><?php echo     $this->lang->line('no_data'); ?></small></h6>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                  </ul>
               </li>

               <li class="dropdown nav-item mr-1">
                  <a class="nav-link count-info dropdown-toggle user-dropdown d-flex align-items-end" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown">
                     <div class="user d-md-flex d-none"><span class="text-right"><i class="ft-users mr-1"></i> <?php echo     $this->lang->line('gt'); ?> </span></div>
                  </a>
                  <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2">
                     <?php foreach ($position as $key => $value) { ?>
                        <a class="dropdown-item" href="<?php echo site_url('log/change_role/'.$value['pos_id']) ?>">
                           <div class="d-flex align-items-center"><i class="ft-chevron-right mr-1"></i><span><?php echo $value['pos_name'] ?></span></div>
                        </a>
                     <?php } ?>
                  </div>

               </li>

               <li class="dropdown nav-item mr-1">
                  <a class="nav-link dropdown-toggle" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown">
                    <i class="ft-menu mr-1"></i>
                  </a>
                  <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2" style="width: 345px;">
                    <a class="nav-link" href="#">
                       <div class="user d-md-flex d-none">
                         <span class="text-right">
                            <!-- <fieldset class="p-2 w-25 mr-auto ml-2">
                              <legend class="w-auto">Informasi</legend>
                                <i class="ft-user mr-1"></i> <?= $userdata['complete_name'] ?> <br/>
                                 District = <?= $userdata['district_name'] ?> <br/>
                                 Dept. = <?= $userdata['dept_name'] ?> <br/>
                                 Posisi = <?= $userdata['pos_name'] ?>
                            </fieldset> -->
                            <fieldset class="informasi-user">
                                <legend class="scheduler-border">Informasi</legend>
                                <div class="control-group">
                                    <i class="ft-user mr-1"></i> <i><?= $userdata['complete_name'] ?></i><br/>
                                    <i><?= $userdata['district_name'] ?></i><br/>
                                    <i><?= $userdata['dept_name'] ?></i><br/>
                                    <i><?= $userdata['pos_name'] ?></i>
                                </div>
                            </fieldset>
                         </span>
                       </div>
                    </a>
                     <a class="nav-link" href="<?php echo site_url('log/change_password') ?>">
                        <div class="user d-md-flex d-none">
                          <span class="text-right">
                            <i class="ft-lock mr-1"></i> Ubah Password
                          </span>
                        </div>
                     </a>
                     <a class="nav-link" href="<?php echo site_url('log/logout') ?>" id="logout">
                        <div class="user d-md-flex d-none">
                          <span class="text-right">
                            <i class="ft-log-out mr-1"></i> Logout
                          </span>
                        </div>
                     </a>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</nav>

<script type="text/javascript">
   $(function() {
      $('a#logout').click(function() {
         if (confirm('Apakah anda yakin ingin logout?')) {
            return true;
         }

         return false;
      });
   });
</script>
