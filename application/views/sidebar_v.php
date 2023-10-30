<!-- main menu-->
<style>
  .app-sidebar .sidebar-content {
    /* background-image: linear-gradient(to bottom, #00C4E3, #044594), url('<?= base_url('assets/app-assets/img/') ?>sidebar-bg/07.jpg'); */
    background-image: linear-gradient(to bottom, rgb(41 167 222), rgb(0 67 121 / 74%)),url('<?= base_url('assets/app-assets/img/') ?>sidebar-bg/07.jpg');

  }

  .app-sidebar .logo {
    background-color: #29a7de;
  }
</style>
  <div class="app-sidebar menu-fixed" data-scroll-to-active="true">
    <div class="sidebar-header">
      <div class="logo clearfix"><a class="logo-text float-left" href="<?php echo base_url(); ?>">

          <div class="logo-img">
            <img src="<?php echo base_url('assets/img/escm_white.png'); ?>" class="menu-title" alt="e-SCM Logo" style="width: 6.5rem; margin-left: 170%;">
          </div>

        </a><a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="expanded"></i></a><a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a></div>
    </div>
    <div class="sidebar-content main-menu-content">
      <div class="nav-container">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <?php include("menu_v.php") ?>
        </ul>
      </div>
    </div>

    <!-- main menu content-->
    <div class="sidebar-background"></div>

  </div>
