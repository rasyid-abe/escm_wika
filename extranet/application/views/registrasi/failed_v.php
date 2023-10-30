
<!DOCTYPE html>
<html class="loading" lang="en">
<!-- BEGIN : Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="author" content="PIXINVENT">
    <title>PT WIJAYA KARYA (Persero) Tbk</title>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets')?>/img/favicon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/vendors/css/prism.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets');?>/app-assets/css/components.css">   
    <style>
        html, body { 
            font-family: "Avenir"; 
            background: url("<?php echo base_url('assets/img/bg-reg.jpg')?>") no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .title-main {
            font-size: 28px;
            color: #565655;
            padding: 15px 15px 5px 15px;
            font-weight: 700;
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
                            <div class="row text-center pt-5">
                                <div class="col-12">
                                    <h3 class="text-center title-main"><?php echo $title; ?></h3>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-content">
                                    <div class="card-body text-center py-4">
                                        <span class="badge badge-danger py-2 px-4 font-medium-3 text-wrap" style="max-width: 100%;">Tidak terhubuh dengan server.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-10 offset-1 mt-4 text-center">
                                <a href="<?php echo base_url();?>" class="btn btn-info btn-md"><strong>Login</strong></a>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- END : End Main Content-->

                <!-- BEGIN : Footer-->
                <footer class="footer undefined undefined mt-5">
                    <p class="clearfix m-0"><span><strong>Copyright</strong> &copy; PT WIJAYA KARYA TBK &copy; 2018 - <?php echo date('Y');?> &nbsp;</span><span class="d-none d-sm-inline-block"></span></p>
                </footer>

            </div>
        </div>
    </div>
    <!-- END Notification Sidebar-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url('assets');?>/app-assets/vendors/js/vendors.min.js"></script>
    <!-- END: Custom CSS-->
</body>
<!-- END : Body-->
</html>