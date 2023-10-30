<!DOCTYPE html>
<html class="loading" lang="en">
<!-- BEGIN : Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="author" content="PIXINVENT">
    <title>PT WIJAYA KARYA (Persero) Tbk</title>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets') ?>/img/favicon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/vendors/css/prism.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets') ?>/app-assets/css/toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/jquery.mask.js">
    <style>
        html,
        body {
            font-family: "Avenir";
            background: url("<?php echo base_url('assets/img/bg-reg.jpg') ?>") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        li {
            font-size: 16px;
            text-align: justify;
        }

        .colh {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .title-main {
            font-size: 28px;
            color: #565655;
            padding: 15px 15px 5px 15px;
            font-weight: 700;
        }

        .title-sub {
            font-size: 18px;
            color: #565655;
            margin-bottom: 0;
            margin-top: 0;
            padding: 10px 10px 0 10px;
            font-weight: 700;
        }

        .text-confirm {
            font-size: 20px;
            padding: 0;
            margin-bottom: 0;
            font-weight: 700;
            color: #565656;
        }

        #toast-container {
            transform: translateY(30vh);
        }
    </style>
    <!-- END: Custom CSS-->
</head>
<!-- END : Head-->

<!-- BEGIN : Body-->

<body class="vertical-layout">
    <div class="container">
        <div class="wrapper">
            <div class="main-panel">
                <!-- BEGIN : Main Content-->
                <div class="main-content">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <section class="timeline-left timeline-wrapper col-sm-10 col-12 offset-sm-1">
                            <div class="row text-center py-5">
                                <div class="col-12">
                                    <h3 class="text-center title-main"><?php echo $title; ?></h3>
                                    <h4 class="text-center title-sub"><?php echo $sub; ?></h4>
                                </div>
                            </div>
                            <ul class="timeline">
                                <li class="timeline-line mt-4"></li>
                                <li class="timeline-group">
                                    <h5><span class="badge badge-info cursor-default">I. KETENTUAN UMUM</span></h5>
                                </li>
                            </ul>
                            <ul class="timeline">
                                <li class="timeline-line"></li>
                                <li class="timeline-item">
                                    <div class="timeline-card card shadow-z-2">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <ol class="content-of-terms" type="1">
                                                    <li>Sistem Online Procuement adalah perangkat lunak aplikasi yang bertujuan memfasilitasi Vendor agar dapat melakukan transaksi pengadaan barang dan jasa melalui media internet.</li>
                                                    <li>Vendor wajib tunduk pada persyaratan yang tertera dalam ketentuan ini serta kebijakan lain yang ditetapkan oleh PT. Anggada Duta Wisesa sebagai pengelola situs <a href="https://vendor.pengadaan.com">https://vendor.pengadaan.com</a> perusahaan yang melakukan proses pengadaan melalui Pengadaan.com</li>
                                                    <li>Transaksi melalui Sistem Online Procurement hanya boleh dilakukan/diikuti oleh vendor yang sudah terdaftar dan teraktivasi untuk bisa mengikuti transaksi secara elektronik.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <ul class="timeline">
                                <li class="timeline-line mt-4"></li>
                                <li class="timeline-group">
                                    <h5><span class="badge badge-info cursor-default text-wrap">II. PERSYARATAN KEANGGOTAAN E-PROCUREMENT <a href="https://pengadaan.com" class="text-white">Pengadaan.com</a></span></h5>
                                </li>
                            </ul>
                            <ul class="timeline">
                                <li class="timeline-line"></li>
                                <li class="timeline-item">
                                    <div class="timeline-card card shadow-z-2">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <ol class="content-of-terms" type="1">
                                                    <li>Vendor harus berbentuk badan usaha atau perseorangan dan dianggap mampu melakukan perbuatan hukum.</li>
                                                    <li>Untuk mendapatkan akun dalam Sistem Online Procurement, calon Vendor terlebih dahulu harus melakukan registrasi online dengan data yang benar dan akurat, sesuai dengan keadaan yang sebenarnya.</li>
                                                    <li>Calon Vendor dapat melakukan transaksi melalui Sistem Online Procurement, apabila telah menerima konfirmasi aktivasi keanggotaannya dari Sistem Online Procurement.</li>
                                                    <li>Satu badan usaha hanya bisa memiliki satu akun yang sesuai dengan email serta NPWP dari badan usaha tersebut.</li>
                                                    <li>Vendor wajib memperbaharui data perusahaannya jika tidak sesuai lagi dengan keadaan yang sebenarnya atau jika tidak sesuai dengan ketentuan ini.</li>
                                                    <li>
                                                        Akun dalam Sistem Online Procurement akan berakhir apabila:
                                                        <ul>
                                                            <li>Vendor mengundurkan diri dengan cara mengirimkan email atau surat kepada PT. Anggada Duta Wisesa sebagai pengelola situs <a href="https://vendor.pengadaan.com">https://vendor.pengadaan.com</a> dan mendapatkan email atau surat konfirmasi atas pengunduran dirinya.</li>
                                                            <li>Melanggar ketentuan yang telah ditetapkan oleh PT. Anggada Duta Wisesa sebagai pengelola situs <a href="https://vendor.pengadaan.com">https://vendor.pengadaan.com</a> dan mendapatkan email atau surat konfirmasi atas pengunduran dirinya.</li>
                                                        </ul>
                                                    </li>
                                                    <li>Vendor setuju bahwa transaksi melalui Sistem Online Procurement tidak boleh menyalahi peraturan perundangan maupun etika bisnis yang berlaku di Indonesia.</li>
                                                    <li>Vendor tunduk pada semua peraturan yang berlaku di Indonesia yang berhubungan dengan, tetapi tidak terbatas pada, penggunaan jaringan yang terhubung pada jasa dan transmisi data teknis, baik di wilayah Indonesia maupun ke luar dari wilayah Indonesia melalui Sistem Online Procurement yang sesuai Undang-Undang Republik Indonesia Nomor 11, Tahun 2008, Tentang Informasi dan Transaksi Elektronik (UU ITE).</li>
                                                    <li>Vendor menyadari bahwa usaha apapun untuk dapat menembus sistem komputer dengan tujuan memanipulasi Sistem Online Procurement merupakan tindakan melanggar hukum.</li>
                                                    <li>PT. Anggada Duta Wisesa sebagai pengelola situs <a href="https://vendor.pengadaan.com">https://vendor.pengadaan.com</a> berhak memutuskan perjanjian dengan Vendor secara sepihak apabila Vendor dianggap tidak dapat menaati ketentuan yang ada.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <ul class="timeline">
                                <li class="timeline-line mt-4"></li>
                                <li class="timeline-group">
                                    <h5><span class="badge badge-info cursor-default text-wrap">III. TANGGUNG JAWAB PENYEDIA BARANG DAN JASA</span></h5>
                                </li>
                            </ul>
                            <ul class="timeline">
                                <li class="timeline-line"></li>
                                <li class="timeline-item">
                                    <div class="timeline-card card shadow-z-2">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <ol class="content-of-terms" type="1">
                                                    <li>Vendor bertanggung jawab atas penjagaan kerahasiaan password‐nya dan bertanggung jawab atas transaksi dan kegiatan lain yang menggunakan akun miliknya.</li>
                                                    <li>Vendor setuju untuk segera memberitahukan kepada PT. Anggada Duta Wisesa sebagai pengelola situs <a href="https://vendor.pengadaan.com">https://vendor.pengadaan.com</a> apabila mengetahui adanya penyalahgunaan akun miliknya oleh pihak lain yang tidak berhak dan/atau jika ada gangguan keamanan atas akun miliknya itu.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <div class="col-10 offset-1 text-center">
                                <h1 class="text-confirm mb-4">Apakah anda setuju dengan syarat dan ketentuan di atas?</h1>
                                <a href="<?php echo base_url(); ?>" class="btn btn-secondary btn-md"><strong>Tidak</strong></a>
                                <a href="#" class="btn btn-info btn-md" data-toggle="modal" data-target="#registerForm"><strong>Ya</strong></a>
                            </div>
                        </section>
                        <!-- Modal -->
                        <?php
                        $type_v = $_GET['type'];
                        if ($type_v == 1) {
                            $type_v = "Non-Perorangan";
                        } elseif ($type_v == 2) {
                            $type_v = "Perorangan";
                        } elseif ($type_v == 3) {
                            $type_v = "Luar Negeri";
                        } elseif ((int)$type_v < 1 || (int)$type_v > 3) {
                            $type_v = "N/A";
                        }
                        ?>
                        <div class="modal fade text-left mt-3" id="registerForm" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <label class="modal-title text-text-bold-600"><strong>Form Registrasi</strong></label>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formRegister" action="<?php echo base_url('index.php/registrasi/add_vendor'); ?>" method="POST">
                                            <div class="form-row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group position-relative">
                                                        <label for="form-action-3">Tipe Vendor</label>
                                                        <input type="hidden" id="type_inp" name="type_vendor" value="<?php echo $_GET['type']; ?>">
                                                        <input type="text" class="form-control" id="type_vendor" value="<?php echo $type_v; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group position-relative">
                                                        <label for="form-action-4">Alamat Email</label>
                                                        <input type="email" class="form-control" placeholder="Masukkan alamat email" id="email_address" name="email_address" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nomor NPWP</label>
                                                <input type="text" class="form-control" pattern=".{20,}" title="Masukan NPWP dengan benar" placeholder="Masukkan nomor NPWP perusahaan" id="npwp_no" name="npwp_no" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control" id="pass1" placeholder="Masukkan password" name="password" required>
                                                    <div class="form-control-position" onclick="showPass1()">
                                                        <i class="ft-eye-off"></i>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group">
                                                <label>Ulangi Password</label>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control" id="pass2" placeholder="Masukkan ulang password" name="repeat_password" required>
                                                    <div class="form-control-position" onclick="showPass2()">
                                                        <i class="ft-eye-off"></i>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <hr />
                                            <button type="button" class="btn btn-secondary float-left" data-dismiss="modal"><strong>Batal</strong></button>
                                            <button type="submit" class="btn btn-info float-right"><strong>Simpan</strong></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade text-left mt-5" id="confirmRegister" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog shadow-z-3" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <label class="modal-title text-bold-600"><strong>Konfirmasi Data Registrasi</strong></label>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 col-12 control-label text-right">Tipe Vendor</label>
                                                <div class="col-md-8 col-12 text-bold-700">
                                                    <span class="confirmRegType"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group py-2">
                                            <div class="row">
                                                <label class="col-md-4 col-12 control-label text-right">Alamat Email</label>
                                                <div class="col-md-8 col-12 text-bold-700">
                                                    <span class="confirmEmail"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="row">
                                                <label class="col-md-4 col-12 control-label text-right">Nomor NPWP</label>
                                                <div class="col-md-8 col-12 text-bold-700">
                                                    <span class="confirmNpwp"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <p>
                                        <h6 style="text-align:center; color: #005db5; font-weight:700">Apakah Anda sudah yakin dengan data Ini?</h6>
                                        </p>
                                        <hr />
                                        <button type="button" class="btn btn-info float-right" id="btnSubmitConfirm"><strong>Ya, lanjutkan</strong></button>
                                        <button type="button" class="btn btn-secondary float-left" data-dismiss="modal"><strong>Batal</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END : End Main Content-->

                <!-- BEGIN : Footer-->
                <footer class="footer undefined undefined mt-5">
                    <p class="clearfix m-0"><span><strong>Copyright</strong> &copy; PT WIJAYA KARYA TBK &copy; 2018 - <?php echo date('Y'); ?> &nbsp;</span><span class="d-none d-sm-inline-block"></span></p>
                </footer>
                <!-- End : Footer-->
                <!-- Scroll to top button -->
                <button class="btn btn-info scroll-top" type="button"><i class="ft-arrow-up"></i></button>

            </div>
        </div>
    </div>
    <!-- END Notification Sidebar-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url('assets'); ?>/app-assets/vendors/js/vendors.min.js"></script>
    <script src="<?php echo base_url('assets'); ?>/app-assets/js/scroll-top.js"></script>
    <script src="<?php echo base_url('assets'); ?>/app-assets/js/components-modal.min.js"></script>
    <script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/toastr.min.js"></script>
    <script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/abe-toast.js"></script>
    <script src="<?php echo base_url('assets') ?>/app-assets/js/jquery.mask.min.js"></script>
    <script>
        $(function() {
            $('#btnSubmitConfirm').click(function() {
                $('#formRegister').submit();
            })

            $('#formRegister').submit(function(e) {
                e.preventDefault();
                if (!($('#confirmRegister').hasClass('show'))) {
                    $('.confirmRegType').text($('#type_vendor').val());
                    $('.confirmEmail').text($('#email_address').val());
                    $('.confirmNpwp').text($('#npwp_no').val());
                    $('#confirmRegister').modal('show');
                    return false;
                } else {
                    loc1 = "<?php echo base_url('index.php/registrasi/success'); ?>";
                    var type_id = $('#type_inp').val();
                    var email_address = $('#email_address').val();
                    var password = $('#pass1').val();
                    var password_rep = $('#pass2').val();
                    var npwp_no = $('#npwp_no').val();

                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url('index.php/registrasi/add_vendor'); ?>',
                        data: {
                            type_vendor: type_id,
                            email_address: email_address,
                            password: password,
                            password_rep: password_rep,
                            npwp_no: npwp_no
                        },
                        success: function(status) {
                            console.log(status);
                            toastr.options = {
                                "positionClass": "toast-top-center"
                            }

                            if (status == 1) {
                                location.href = loc1;

                            } else if (status == 2) {
                                toastr.error('Format email salah.', '<i class="ft ft-alert-triangle"></i> Error!');
                            } else if (status == 3) {
                                toastr.error('Nomor NPWP sudah digunakan.', '<i class="ft ft-alert-triangle"></i> Error!');
                            } else if (status == 4) {
                                toastr.error('Konfirmasi password harus sama.', '<i class="ft ft-alert-triangle"></i> Error!');
                            } else if (status == 5) {
                                toastr.error('Alamat email sudah digunakan.', '<i class="ft ft-alert-triangle"></i> Error!');
                            } else {
                                toastr.error('Registrasi vendor gagal.', '<i class="ft ft-alert-triangle"></i> Error!');
                            }
                        },
                    });
                }
            })
        })
    </script>
    <script>
        function showPass1() {
            var x = document.getElementById("pass1");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function showPass2() {
            var x = document.getElementById("pass2");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            toasterOptions();
            response_data();

            function response_data() {
                if ('<?php echo $this->session->flashdata('register') ?>' == 'fail') {
                    toastr.error('Nomor NPWP Sudah Digunakan.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        })

        $('#npwp_no').mask('99.999.999.9-999.999');
    </script>
    <!-- END: Custom CSS-->
</body>
<!-- END : Body-->

</html>