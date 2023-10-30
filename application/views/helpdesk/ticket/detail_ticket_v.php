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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets') ?>/app-assets/css/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/pages/app-chat.css">
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
    </style>
    <!-- END: Custom CSS-->
</head>
<!-- END : Head-->

<body>

    <div class="container">
        <div class="text-center p-md-4 p-sm-1 py-1 p-0">
            <h1 class="faq-title">Monitor Ticket Chat</h1>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="chat-application overflow-hidden">
                    <div class="app-content-overlay"></div>
                    <div class="chat-name p-2">
                        <div class="media p-1 align-items-center">
                            <div class="media-body row">
                                <div class="col-2">
                                    <a href="<?php echo base_url('helpdesk/check_ticket'); ?>" class="btn btn-sm btn-info mr-2"><i class="ft ft-arrow-left mr-1"></i>Kembali</a>
                                </div>
                                <div class="col-10">
                                    <div class="table-responsive">
                                        <table class="table m-0 table-sm">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Ticket Information</th>
                                                    <th colspan="2">User Information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Ticket Status</td>
                                                    <td>
                                                        <?php
                                                        $status = '<span class="badge badge-secondary">-</span>';
                                                        if ($data_detail['status'] == 1) {
                                                            $status = '<span class="badge badge-success">Open</span>';
                                                        } elseif ($data_detail['status'] == 2) {
                                                            $status = '<span class="badge badge-danger">Closed</span>';
                                                        }
                                                        echo $status;
                                                        ?>
                                                    </td>
                                                    <td>Company Name</td>
                                                    <td><?php echo $data_detail['nama_perusahaan']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Ticket Date</td>
                                                    <td><?php echo date("d-m-Y h:i:s", strtotime($data_detail['created_at'])); ?></td>
                                                    <td>Phone</td>
                                                    <td><?php echo $data_detail['no_telp']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Category</td>
                                                    <td><?php echo $data_detail['kategori']; ?></td>
                                                    <td>Email</td>
                                                    <td><?php echo $data_detail['email_perusahaan']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="chat-app-window position-relative">
                        <div class="chats">
                            <?php foreach ($res as $value) { ?>
                                <?php if ($value['message_left'] != NULL) { ?>
                                    <div class="chat chat-left">
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p><?php echo $value['message_left']; ?></p>
                                                <p class="text-muted"><?php echo date("d-m-Y h:i:s", strtotime($value['date_create'])); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($value['lampiran_left'] != NULL) { ?>
                                    <div class="chat chat-left">
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p><a href="<?php echo base_url('attachment/ticket/' . $value['ticket_id'] . '/' . $value['lampiran_left']); ?>" target="_blank"><i class="ft-file"></i> View file</a></p>
                                                <p class="text-muted"><?php echo date("d-m-Y h:i:s", strtotime($value['date_create'])); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($value['lampiran_right'] != NULL) { ?>
                                    <div class="chat">
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p><a href="<?php echo $this->config->item('internal_url') . 'attachment/ticket/' . $value['ticket_id'] . '/' . $value['lampiran_right']; ?>" target="_blank"><i class="ft-file"></i> View file</a></p>
                                                <p class="text-muted"><?php echo date("d-m-Y h:i:s", strtotime($value['date_create'])); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($value['message_right'] != NULL) { ?>
                                    <div class="chat">
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p><?php echo $value['message_right']; ?></p>
                                                <p class="text-muted"><?php echo date("d-m-Y h:i:s", strtotime($value['date_create'])); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </section>

                    <section class="chat-app-form px-3 py-2">
                        <form class="d-flex align-items-center" method="POST" action="<?php echo base_url('helpdesk/add_chat'); ?>" enctype="multipart/form-data">
                            <button type="submit" <?php echo $data_detail['status'] == 2 ? 'disabled' : ''; ?> class="btn btn-info d-lg-flex align-items-center" onclick="return confirm('Apakah Anda yakin kirim pesan ini?')">
                                <i class="<?php echo $data_detail['status'] == 2 ? 'ft-slash' : 'ft-send'; ?>"></i>
                                <span class="d-none d-lg-block ml-1">Kirim</span>
                            </button>
                            <input type="hidden" name="ticket_id" value="<?php echo $data_detail['ticket_id']; ?>">
                            <input type="text" class="form-control chat-message-send mx-2" name="message_left" placeholder="Type your message here">
                            <input type="file" name="lampiran_left">
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer undefined undefined mt-5">
        <p class="clearfix m-0"><span><strong>Copyright</strong> &copy; PT WIJAYA KARYA TBK &copy; 2018 - <?php echo date('Y'); ?> &nbsp;</span><span class="d-none d-sm-inline-block"></span></p>
    </footer>

    <script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/vendors.min.js"></script>
    <script src="<?php echo base_url('assets') ?>/app-assets/js/app-chat.js"></script>
    <script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/toastr.min.js"></script>
    <script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/abe-toast.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            toasterOptions();
            response_data();

            function response_data() {
                if ('<?= $this->session->flashdata('tab') ?>' == 'chat') {
                    if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
                        toastr.info('Pesan berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
                    } else {
                        toastr.error('Pesan gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
                    }
                }
            }

        })
    </script>

</body>

</html>