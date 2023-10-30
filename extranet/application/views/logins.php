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
  <title>eSCM <?php echo COMPANY_NAME ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap');

    .registration-button {
      color: #14a2b8 !important;
      text-decoration: none;
      letter-spacing: 0.12em;
      display: inline-block;
      position: relative;
      cursor: pointer;
    }

    .registration-button:after {
      background: none repeat scroll 0 0 transparent;
      bottom: 0;
      content: "";
      display: block;
      height: 2px;
      top: 65%;
      position: absolute;
      background: #14a2b8;
      transition: width 0.3s ease 0s, left 0.3s ease 0s;
      width: 0;
    }

    .registration-button:hover:after {
      width: 100%;
      left: 0;
    }

    .wrapper-regis {
      display: flex;
      justify-content: space-around;
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
      background-image: url(<?php echo base_url('assets/page-login/images/bg_1.jpg') ?>);
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
      left: 45px;
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

    .lelangs {
      position: absolute;
      top: 20px;
      border-top-left-radius: unset;
      border-bottom-left-radius: unset;
      width: 300px;
      transition: all .2s ease-in-out;
      cursor: pointer;
      animation: fadeIn 2s;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        left: -278px;
      }

      100% {
        opacity: 1;
        left: 0;
      }
    }

    .lelangs:hover {
      background-color: #80b8f2 !important;
      /* transform: scale(1.1); */
      transition: all .2s ease-in-out;
    }
  </style>
</head>

<body>

  <div class="wrapper-login-scm">
    <div class="bg order-1 order-md-2 wrapper-news">
      <span class="color-white">News Update</span>
      <div class="shadow-lg rounded" style="background-color: rgba(255, 255, 255, 0.85);">
        <?php
        if (isset($get_news)) {
          foreach ($get_news as $k => $v) {
            if ($k == 0) { ?>
              <div class="first-news">
                <img class="img-fluid first-image" src="<?= str_replace("extranet/", "", base_url()) . ('uploads/administration/' . $v['image']) ?>" alt="News Image">
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
                  <img class="img-fluid" src="<?= str_replace("extranet/", "", base_url()) . ('uploads/administration/' . $v['image']) ?>" alt="News Image">
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
    <div class="d-flex align-items-center contents order-2 order-md-1">
      <div onclick="lelangs()" class="alert alert-primary lelangs" role="alert">
        <span>
          Pengumuman Pelelangan
        </span>
        <img src="<?= base_url("assets/img/caret-right-solid.png") ?>" alt="caret" width="15" style="right: 8px; position: absolute; top: 37%;">

      </div>
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <div class="text-center py-3">
              <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-responsive" style="height: 30%; width: 30%">
            </div>
            <div class="my-4 text-center text-bold-700">Electronic Supply Chain Management <br /><strong><?php echo COMPANY_NAME ?></strong></div>
            <hr />
            <?php
            $pesan = $this->session->userdata('message');
            $pesan = (empty(trim($pesan))) ? "" : $pesan;
            if (!empty($pesan)) { ?>
              <div class="alert alert-danger">
                <?php echo $pesan ?>
              </div>
            <?php } else { ?>

              <div class="alert alert-success text-center" id="alert-alert" style="font-size: 0.9rem">
                <?php echo $this->lang->line("Gunakan e-mail dan password dari Pendaftaran Rekanan"); ?>
              </div>
            <?php }
            $this->session->unset_userdata('message'); ?>
            <form class="m-t" role="form" id="login_form" method="post" action="<?php echo site_url("welcome/in") ?>">

              <div class="form-group" style="display: none">
                <btn class="btn btn-success" id="helpleh">?</btn>
                <select class="form-control m-b" name="bahasa" style="width: 85%;float: right; padding-left: 0%">
                  <option value="indonesia">Bahasa Indonesia</option>
                  <option value="english">English</option>
                </select>
              </div>

              <div class="form-group first">
                <label for="username">Email</label>
                <input type="text" name="username_login" class="form-control" placeholder="Email" id="username_login" required>
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" name="password_login" class="form-control" placeholder="Password" id="password_login" required>
              </div>

              <div class="form-group text-center" id="form_captcha" style="display: none">
                <img src="<?php echo site_url('welcome/gambar') ?>" style="width: 40%;" alt="CAPTCHA"><br /><br />
                <input type="text" name="captcha" class="form-control form-control-sm" placeholder="Type Text Above" required>
              </div>

              <button id="logins" type="submit" class="btn btn-info block mb-3"><?php echo $this->lang->line('Login'); ?></button>
              <btn class="btn btn-info tombolButtons" id="arrowDown" style="float: right; width: 15%;"> &#x2193; </btn>
              <btn class="btn btn-info tombolButtons" id="arrowUp" style="display: none;float: right; width: 15%;"> &#x2191; </btn>

            </form>
            <span class="wrapper-regis">
              <p>
                Belum memiliki akun?
              </p>
              <a data-toggle="modal" data-target="#register" class="registration-button">
                <i class="fa fa-plus"></i>
                Registrasi
              </a>
            </span>

            
<!-- <div class="animated bounceInDown" style="-webkit-animation-duration: 1.5s;
            animation-duration: 2s;" >
<a href="<?php echo site_url("welcome/lelang"); ?>">
<button class="btn btnSpesial btn-sm  btn-block"  style="height: 100px; padding-left: 25%; padding-top: 5%; font-size: 14px">
<div class="row">
<div class="isiBtnSpesial">
<p class="isiButtonSpesial"><?php echo $this->lang->line('Pengumuman Pelelangan'); ?></p>
</div>
<div class="panahBtnSpesial">&#9658;</div>
</div>
</button>
</a>
</div>

</div> -->


            <div class="text-center" style="display: none" id="crPhone">
              <small>© <?php $made = 2018;
                        echo ($made == DATE('Y')) ? $made : $made . '-' . DATE('Y') ?> All Right Reserved</small>
            </div>

            <div class="col-md-12 text-right" style="background: rgba(255,255,255,1); width: 100%; height: 100%">
              <div class="text-center py-3">
                <img src="<?php echo base_url(); ?>assets/img/escm.png" style="width: 28%; height: 13%">
              </div>
            </div>
          </div>
          <div onclick="helpdesk()" class="float-icons bounce shadow-lg p-3 bg-white">
            <img src="<?php echo base_url(); ?>assets/img/help-desk.png">
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade text-left mt-5" id="register" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <label class="modal-title text-text-bold-600">Pilih Jenis Vendor Anda</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">x</span>
            </button>
          </div>
          <div class="row">
            <div class="col-xl-4 col-12">
              <a href="<?php echo base_url('index.php/registrasi/account?type=1'); ?>">
                <div class="d-flex justify-content-center mt-4 mb-4 hoverin">
                  <img src="<?php echo base_url('assets'); ?>/app-assets/img/photos/02.jpg" class="avatar mr-3" width="60" height="60">
                  <div class="align-self-center">
                    <h6 class="m-0">Non-Perorangan</h6>
                    <small class="text-muted font-small-2">Vendor</small>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-12">
              <a href="<?php echo base_url('index.php/registrasi/account?type=2'); ?>">
                <div class="d-flex justify-content-center mt-4 mb-4 hoverin">
                  <img src="<?php echo base_url('assets'); ?>/app-assets/img/photos/04.jpg" class="avatar mr-3" width="60" height="60">
                  <div class="align-self-center">
                    <h6 class="m-0">Perorangan</h6>
                    <small class="text-muted font-small-2">Vendor</small>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-12">
              <a href="<?php echo base_url('index.php/registrasi/rekanan'); ?>" target="_blank">
                <div class="d-flex justify-content-center mt-4 mb-4 hoverin">
                  <img src="<?php echo base_url('assets'); ?>/app-assets/img/photos/03.jpg" class="avatar mr-3" width="60" height="60">
                  <div class="align-self-center">
                    <h6 class="m-0">Pengadaan.com</h6>
                    <small class="text-muted font-small-2">Vendor</small>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/page-login/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/page-login/js/bootstrap.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $(function() {
          var width = parseInt($(window).width());
          if (width > 480) {
            $(".slideInRight").addClass("loginColumns-d");
            $("#azzaz").addClass("loginPengadaan-d");
            $('#logins').css('width', '100%');
            $('.tombolButtons').hide();
            $('#crPC').show();
            $('#crPhone').hide();
          } else {
            $(".slideInRight").addClass("loginColumns");
            $("#azzaz").hide();
            $('#arrowDown').show();
            $('#logins').css('width', '80%');
            $(".isiButtonSpesial").addClass("wordWrap")
            $('#crPC').hide();
            $('#crPhone').show();
          }
        });

        $("#logins").click(function() {
          if ($("#login_form").validate().form()) {
            $("#logins").prop("disabled", true);
            $("#logins").text("Please Wait...");
          }
        });

        $('.tombolButtons').click(function() {
          if ($('#arrowDown').is(':visible')) {
            $('#arrowUp').show();
            $('#arrowDown').hide();
          } else {
            $('#arrowDown').show();
            $('#arrowUp').hide();
          }
          $('#btnButtons').toggle("slow");
        })
      });

      $('#password_login').bind("change keyup input", function() {
        if ($('#username_login').val()) {

          $('#form_captcha').show("slow");
        }
      })
      $('#username_login').bind("change keyup input", function() {
        if ($('#password_login').val()) {

          $('#form_captcha').show("slow");
        }
      })

      function helpdesk() {
        window.open('/extranet/helpdesk', '_blank')
      }

      function lelangs() {
        window.open('/extranet/welcome/lelang', '_blank')
      }
    </script>

</body>

</html>