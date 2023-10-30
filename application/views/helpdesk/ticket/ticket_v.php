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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets') ?>/app-assets/vendors/css/datatables/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets') ?>/app-assets/css/toastr/toastr.min.css">
    <style>
        html,
        body {
            font-family: "Avenir";
            background: url("<?php echo base_url('assets/img/bg-blue.jpg') ?>") no-repeat center center fixed;
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
    </style>
    <!-- END: Custom CSS-->
</head>
<!-- END : Head-->

<body class="vertical-layout">
    <div class="container">
        <div class="wrapper">
            <div class="main-panel">
                <div class="text-center p-md-4 p-sm-1 py-1 p-0">
                    <h1 class="faq-title">Check Ticket Perusahaan</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
                </div>
                <section class="users-list-wrapper">
                    <!-- document Start -->
                    <div class="users-list-table">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-header border-bottom p-2">
                                            <a aria-expanded="false" aria-controls="accordion" class="card-title text-info">CHECK TICKET</a>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="<?php echo base_url('helpdesk/check_ticket'); ?>">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control square" name="email_address" placeholder="Masukan Email" required>
                                                            </div>
                                                            <div class="col md-3">
                                                                <button type="submit" class="btn btn-sm btn-info"><i class="ft-search"></i> Cari</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered selection-multiple-rows">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Status</th>
                                                            <th>Kategori</th>
                                                            <th>Perusahaan</th>
                                                            <th>Pertanyaan</th>
                                                            <th>Tanggal</th>
                                                            <th>Detail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        foreach ($ticket as $value) { ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $no++; ?></td>
                                                                <td>
                                                                    <?php
                                                                    $status = '<span class="badge badge-secondary">-</span>';
                                                                    if ($value['status'] == 1) {
                                                                        $status = '<span class="badge badge-success">Open</span>';
                                                                    } elseif ($value['status'] == 2) {
                                                                        $status = '<span class="badge badge-danger">Closed</span>';
                                                                    }
                                                                    echo $status;
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $value['kategori']; ?></td>
                                                                <td><?php echo $value['nama_perusahaan']; ?></td>
                                                                <td><?php echo $value['deskripsi_pertanyaan']; ?></td>
                                                                <td><?php echo date("d-m-Y h:i:s", strtotime($value['created_at'])); ?></td>
                                                                <td><a href="<?php echo base_url('helpdesk/detail/') . $value['ticket_id'] ?>" target="_blank" class="btn btn-sm btn-info"> Detail</a></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dokument End -->
                    <div class="text-right">
                        <a href="<?php echo base_url('helpdesk') ?>" class="btn bg-light-info"><i class="ft-rotate-ccw"></i> Kembali</a>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <footer class="footer undefined undefined mt-5">
        <p class="clearfix m-0"><span><strong>Copyright</strong> &copy; PT WIJAYA KARYA TBK &copy; 2018 - <?php echo date('Y'); ?> &nbsp;</span><span class="d-none d-sm-inline-block"></span></p>
    </footer>
</body>

<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/toastr.min.js"></script>
<script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/abe-toast.js"></script>

<script>
    $(document).ready(function() {
        // Row selection (multiple rows)
        var multipleRowsTable = $(".selection-multiple-rows").DataTable();

        $(".selection-multiple-rows tbody").on("click", "tr", function() {
            $(this).toggleClass("selected");
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        toasterOptions();
        response_data();

        function response_data() {
            if ('<?php echo $this->session->flashdata('ticket_s') ?>' == 'aktif') {
                if ('<?php echo $this->session->flashdata('ticket_s') ?>' == '1') {
                    toastr.error('Tidak ada ticket yang tersedia.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }

    })
</script>