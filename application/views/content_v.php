<style>
  .bg-breadcrumb {
    background-image: linear-gradient(to right, #00306a, #2AACE3);
    color: #fff;
    border-radius: 10px;
    height: 90px;
  }
  .content-header {
    color: #fff;
  }
  .text-muted {
    color: #fff !important;
  }

  .btn-info {
    background-color: #2AACE3;
    border-color: #2F8BE6;
    border-radius: 20px;
  }

  .btn-danger {
    background-color: #FF7376;
    border-color: #FF7376;
    border-radius: 20px;
  }

  .btn-primary {
    background-color: #00D9D0;
    border-color: #00D9D0;
    border-radius: 20px;
  }

  .btn-secondary {
    background-color: #EC9929;
    border-color: #EC9929;
    border-radius: 20px;
  }

  .btn-success {
    background-color: #56E9AE;
    border-color: #56E9AE;
    border-radius: 20px;
  }

  .bootstrap-table {
    margin-top: -40px;
  }

  a {
    color: #2AACE3;
    background-color: transparent;
  }

  .modal-judul {
    font-family: Montserrat,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
  }
  .content-wrapper {
    padding: 35px 30px;
  }
</style>
<div class="main-panel">
  <!-- BEGIN : Main Content-->
  <div class="main-content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">

      <div class="row bg-breadcrumb">
        <div class="col-7">
          <div class="content-header">
            <strong style="font-size:16px;"><?= $mytitle; ?></strong>
          </div>
        </div>
        <div class="col-5">
          <div class="float-right">
            <img src="<?= base_url('assets') ?>/app-assets/img/wika_employee.png" alt="WIKA Logo" / style="width: 215px;z-index: 999;margin-top: -50px;">            
          </div>
        </div>
      </div>

      <?php
      $message = $this->session->userdata("message");
      $validate = validation_errors();

      if(!empty($message)){ ?>

      <div class="row mt-2">
        <div class="alert bg-light-info mb-2 col-12" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php echo $message ?>
        </div>
      </div>

      <?php } $this->session->unset_userdata("message");

      if(!empty($validate)){ ?>

      <div class="row mt-2">
        <div class="alert bg-danger-info mb-2 col-12" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php echo $validate ?>
        </div>
      </div>

      <div class="row mt-2">
        <div class="alert alert-danger alert-dismissible" style="margin:10px 10px 0px 10px" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php echo $validate ?>
        </div>
      </div>

      <?php } ?>

      <?php include($body.".php"); ?>

  </div>
</div>
<!-- END : End Main Content-->
