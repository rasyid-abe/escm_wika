<?php
$get_news_vendor = $this->db->get('vnd_news');
$get_news_lkpp = $this->db->get('vnd_news_lkpp');

$get_news = $get_news_vendor->result_array();
$get_lkpp = $get_news_lkpp->result_array();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png') ?>">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/page-login/fonts/icomoon/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/page-login/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/page-login/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/page-login/css/style.css">
  <title><?php echo COMPANY_NAME ?> | Login</title>
  <style>
    .chat-list {
      padding: 0;
      font-size: .8rem;
    }

    .chat-list li {
      margin-bottom: 50px;
      overflow: auto;
      color: #ffffff;
    }

    .chat-list .chat-img {
      float: left;
      width: 48px;
    }

    .chat-list .chat-img img {
      -webkit-border-radius: 50px;
      -moz-border-radius: 50px;
      border-radius: 50px;
      width: 100%;
    }

    .chat-list .chat-message {
      -webkit-border-radius: 50px;
      -moz-border-radius: 50px;
      border-radius: 50px;
      background: #ffffff;
      display: inline-block;
      padding: 10px 20px;
      position: relative;
    }

    .chat-list .chat-message:before {
      content: "";
      position: absolute;
      top: 15px;
      width: 0;
      height: 0;
    }

    .chat-list .chat-message h5 {
      margin: 0 0 5px 0;
      font-weight: 600;
      line-height: 100%;
      font-size: .9rem;
    }

    .chat-list .chat-message p {
      line-height: 18px;
      margin: 0;
      padding: 0;
    }

    .chat-list .chat-body {
      margin-left: 20px;
      float: left;
      width: 70%;
    }

    .chat-list .in .chat-message:before {
      left: -12px;
      border-bottom: 20px solid transparent;
      border-right: 20px solid #ffffff;
    }

    .chat-list .out .chat-img {
      float: right;
    }

    .chat-list .out .chat-body {
      float: right;
      margin-right: 20px;
      text-align: right;
    }

    .chat-list .out .chat-message {
      background: #ffffff;
    }

    .chat-list .out .chat-message:before {
      right: -12px;
      border-bottom: 20px solid transparent;
      border-left: 20px solid #ffffff;
    }

    .card .card-header:first-child {
      -webkit-border-radius: 0.3rem 0.3rem 0 0;
      -moz-border-radius: 0.3rem 0.3rem 0 0;
      border-radius: 0.3rem 0.3rem 0 0;
    }

    .card .card-header {
      background: #14a2b8;
      border: 0;
      font-size: 1rem;
      padding: .65rem 1rem;
      font-weight: 600;
      color: #ffffff;
    }

    .wrapper-login-scm {
      height: 100vh;
      display: flex;
    }

    .wrapper-right-sec {
      font-family: 'Poppins', sans-serif;
      justify-content: center;
      align-items: center;
      display: flex;
      position: relative;
      flex: 0 1 42%;
    }

    .card-width {
      min-width: 15rem;
      max-width: 15rem;
      min-height: 15.5rem;
      margin-right: 10px;
      display: flex;
      flex-direction: column;
    }

    .scrolling-wrapper {
      /* overflow-x: scroll;
      overflow-y: hidden;
      white-space: nowrap; */
      display: flex;
      width: 100%;
      overflow-x: scroll;
      overflow-y: hidden;
    }

    .card {
      display: inline-block;
    }

    .remove-bg-footer {
      background-color: unset;
    }

    .wrapper-news {
      background-image: url(<?php echo base_url('assets/img/backgrounds_ori.jpg') ?>);
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      /* display: grid;
      grid-template-areas:
        'titlenews'
        'news'
        'titlelkpp'
        'lkpp';
      gap: 0; */
      padding: 0.5rem 1.5rem;
      overflow-y: auto;
      flex: 1 0 58%;
    }

    .float-icons {
      position: absolute;
      bottom: 20px;
      right: 45px;
      display: flex;
      flex-direction: row-reverse;
      height: 75px;
      width: 75px;
      border-radius: 50%;
      animation-duration: 5s;
      animation-iteration-count: infinite;
      cursor: pointer;
    }

    .bounce {
      animation-name: bounce-2;
      animation-timing-function: ease;
    }

    @keyframes bounce-2 {
      0% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-30px);
      }

      100% {
        transform: translateY(0);
      }
    }

    .news-title-grid {
      grid-area: titlenews;
    }

    .news-grid {
      grid-area: news;
    }

    .lkpp-title-grid {
      grid-area: titlelkpp;
    }

    .lkpp-grid {
      grid-area: lkpp;
    }


    .color-white {
      color: #ffffff;
      text-shadow: 2px 2px black;
      padding-bottom: 0;
      margin-bottom: 0;
    }

    .first-news {
      border-radius: 10px;
      display: flex;
      padding: 10px;
    }

    .content-first-news {
      margin-left: 8px;
    }

    .first-image {
      min-width: 50%;
      max-width: 50%;
    }
  </style>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300&display=swap');
  </style>
</head>

<body style="overflow: hidden; font-family: 'Poppins', sans-serif; height: 100%;">
  <div class="wrapper-login-scm">
    <div class="wrapper-news">
      <span class="color-white">News Update</span>
      <div class="shadow-lg rounded" style="background-color: rgba(255, 255, 255, 0.85);">
        <?php
        if (isset($get_news)) {
          foreach ($get_news as $k => $v) {
            if ($k == 0) { ?>
              <div class="first-news">
                <img class="img-fluid first-image" src="<?= base_url('uploads/administration/' . $v['image']) ?>" alt="News Image">
                <div class="content-first-news">
                  <small class="text-muted"><?php echo date("d M Y H:i", strtotime($v['created_at'])); ?></small>
                  <h5><?= substr($v['tittle'], 0, 100); ?></h5>
                  <h6><?= substr($v['content'], 0, 100); ?><?= strlen($v['content']) > 100 ? "..." : "" ?></h6>
                </div>
              </div>
          <?php
            }
          } ?>
          <div class="d-flex flex-row flex-wrap justify-content-start align-items-start" style="padding: 10px;">
            <?php foreach ($get_news as $k => $v) {
              if ($k == 0) {
              } else {
            ?>
                <div class="card-width">
                  <img class="img-fluid" src="<?= base_url('uploads/administration/' . $v['image']) ?>" alt="News Image">
                  <small class="float-left text-muted"><?php echo date("d M Y H:i", strtotime($v['created_at'])); ?></small>
                  <h5 class="card-title"><?= substr($v['tittle'], 0, 100); ?></h5>
                  <h6><?= substr($v['content'], 0, 100); ?><?= strlen($v['content']) > 100 ? "..." : "" ?></h6>
                  <span class="tags float-right">
                    <span class="badge bg-warning"><?php echo $v['kategori']; ?></span>
                  </span>
                </div>
            <?php }
            }
            ?>
          </div>
        <?php
        } ?>
      </div>

      <span class="color-white">LKPP News</span>
      <div class="shadow-lg rounded" style="background-color: rgba(255, 255, 255, 0.85);">
        <?php
        if (isset($get_lkpp)) {
          foreach ($get_lkpp as $k => $v) {
            if ($k == 0) { ?>
              <div class="first-news">
                <img class="img-fluid first-image" src="<?= $v['link_img']; ?>" alt="LKPP Image">
                <div class="content-first-news">
                  <small class="text-muted"><?php echo date("d M Y H:i", strtotime($v['date_created'])); ?></small>
                  <h5><?= substr($v['link_title'], 0, 100); ?></h5>
                  <h6><?= substr($v['link_content'], 0, 100); ?><?= strlen($v['link_content']) > 100 ? "..." : "" ?></h6>
                </div>
              </div>
          <?php
            }
          } ?>
          <div class="d-flex flex-row flex-wrap justify-content-start align-items-start" style="padding: 10px;">
            <?php foreach ($get_lkpp as $k => $v) {
              if ($k == 0) {
              } else {
            ?>
                <div class="card-width">
                  <img class="img-fluid" src="<?= $v['link_img']; ?>" alt="LKPP Image">
                  <small class="float-left text-muted"><?php echo date("d M Y H:i:s", strtotime($v['date_created'])); ?></small>
                  <h5 class="card-title"><?= substr($v['link_title'], 0, 100); ?></h5>
                  <h6><?= substr($v['link_content'], 0, 100); ?><?= strlen($v['link_content']) > 100 ? "..." : "" ?></h6>
                </div>
            <?php }
            }
            ?>
          </div>
        <?php
        } ?>
      </div>
    </div>
    <div class="wrapper-right-sec">
      <div class="col-md-7">
        <div class="col">
          <div class="text-center py-3">
            <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-responsive" style="height: 30%; width: 30%">
          </div>
          <p class="my-4 text-center">Electronic Supply Chain Management <br /><strong><?php echo COMPANY_NAME ?></strong></p>
          <?php
          $pesan = $this->session->userdata('message');
          $pesan = (empty($pesan)) ? "" : $pesan;
          if (!empty($pesan)) { ?>
            <div class="alert alert-info">
              <?php echo $pesan ?>
            </div>
          <?php }
          $this->session->unset_userdata('message'); ?>

          <h4 class="mb-3 text-center"><strong>eSCM Intranet</strong></h4>

          <form class="m-t" role="form" id="login_form" method="post" action="<?php echo site_url("log/in") ?>">
            <div class="form-group first">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username_login" placeholder="Username" required="">
            </div>
            <div class="form-group last mb-3">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password_login" placeholder="Password" required="">
            </div>

            <div class="d-flex mb-3 align-items-center">
              <span class="ml-auto"><a href="#" id="forgot-btn" class="forgot-pass">Forgot Password</a></span>
            </div>
            <input type="submit" value="Login" class="btn btn-block btn-info">
          </form>

          <form class="m-t" role="form" id="forgot_form" method="post" style="display:none;" action="<?php echo site_url("log/forgot") ?>">
            <div class="form-group">
              <input type="email" class="form-control" name="email_login" placeholder="Email" required="">
            </div>

            <div class="d-flex mb-3 align-items-center">
              <span class="ml-auto"><a href="#" id="login-btn" class="login-pass">Back to login</a></span>
            </div>

            <input type="submit" value="Submit" class="btn btn-block btn-primary">
          </form>

          <div class="p-3 text-center">
            <p class="text-center">
              <strong>Informasi eSCM</strong>
              <br />
              Email : info.scm@wika.co.id
              <br />
              <strong>© <?php echo COMPANY_NAME ?></strong>
            </p>
          </div>

          <div class="text-center" style="display: none" id="crPhone">
            <small>© <?php $made = 2018;
                      echo ($made == DATE('Y')) ? $made : $made . '-' . DATE('Y') ?> All Right Reserved</small>
          </div>

          <div class="col-md-12 text-right" style="background: rgba(255,255,255,1); width: 100%; height: 100%">
            <div class="text-center">
              <img src="<?php echo base_url(); ?>assets/img/escm.png" style="width: 28%; height: 13%">
            </div>
          </div>
        </div>
      </div>
      <div onclick="helpdesk()" class="float-icons bounce shadow-lg p-3 bg-white">
        <img src="<?php echo base_url(); ?>assets/img/help-desk.png">
      </div>
    </div>
  </div>

  <script src="<?php echo base_url(); ?>assets/page-login/js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/page-login/js/bootstrap.min.js"></script>

  <script>
    $(function() {
      $("#forgot-btn").click(function() {
        $("#forgot_form").show();
        $("#login_form").hide();
      });
      $("#login-btn").click(function() {
        $("#forgot_form").hide();
        $("#login_form").show();
      });

      function sesuaikan() {
        var width = parseInt($(window).width());
        if (width > 480) {
          $(".slideInRight").removeClass("loginColumns");
          $(".slideInRight").addClass("loginColumns-d");
          $('#crPhone').hide();
          $('#crPC').show();
        } else {
          $(".slideInRight").removeClass("loginColumns-d");
          $(".slideInRight").addClass("loginColumns");
          $('#crPhone').show();
          $('#crPC').hide();
        }
      }
      sesuaikan();
      $(window).on('resize', function() {

        sesuaikan();
      });
    });
    $('#container-news-cards').on('scroll', function(e) {
      const valScroll = e.currentTarget.scrollLeft
      const maxScrollLeft = e.currentTarget.scrollWidth - e.currentTarget.clientWidth;
      console.log('maxScrollLeft', maxScrollLeft)
      // console.log('valScroll', valScroll)
    })

    function helpdesk() {
      window.open('/helpdesk', '_blank')
    }
  </script>

</body>

</html>