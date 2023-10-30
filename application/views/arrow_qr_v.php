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
            .a_link_qr{
            color:#fff !important;
            text-decoration : none !important;
            }
        </style>
    </head>
    <body>
        <div class="row mt-5" >
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="text-center py-3">
                    <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-responsive" style="height: 30%; width: 30%">
                </div>
                <p class="text-center">Electronic Supply Chain Management <br/><strong><?php echo COMPANY_NAME ?></strong></p>
                <div class="row" >
                    <div class="col-6 pull-right text-right" >
                        <a href="<?php echo site_url("createpdf/data_vendor_pemenang/".$contract['tender_id']) ?>" class="btn btn-block btn-md btn-primary a_link_qr">Vendor Pemenang</a>
                    </div>
                    <div class="col-6 pull-left" >
                        <a href="<?php echo site_url("contract/daftar_pekerjaan/proses_kontrak/".$contract['comment_id']) ?>" class="btn btn-block btn-md btn-primary a_link_qr">Contract</a>
                    </div>
                </div>
                <div class="col-md-12 text-right" style="background: rgba(255,255,255,1); width: 100%; height: 100%">
                    <div class="text-center py-3">
                        <img src="<?php echo base_url(); ?>assets/img/iproc.png" style="width: 28%; height: 13%">
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <script src="<?php echo base_url(); ?>assets/page-login/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/page-login/js/bootstrap.min.js"></script>
        <script></script>
    </body>
</html>