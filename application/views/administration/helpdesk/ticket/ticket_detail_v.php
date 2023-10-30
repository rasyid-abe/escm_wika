<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/pages/app-chat.css">

<section id="bordered-striped-form-layout">
    <div class="row match-height">
        <!-- Bordered Form Layout starts -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">Silahkan Respon Ticket</h4>
                    <?php

                    $status = '<span class="badge badge-secondary float-right">-</span>';
                    if ($data_detail->status == 1) {
                        $status = '<span class="badge badge-success float-right">Open</span>';
                    } elseif ($data_detail->status == 2) {
                        $status = '<span class="badge badge-danger float-right">Closed</span>';
                    }
                    echo $status;
                    ?>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" action="<?php echo base_url('administration/helpdesk/ticket/edit_ticket'); ?>">
                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Ticket ID</label>
                                        <input type="text" class="form-control" name="ticket_id" value="<?php echo $data_detail->ticket_id; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Status</label>
                                        <select class="select2 form-control" name="status">
                                            <option value="" selected disabled>Pilih</option>
                                            <option value="1" <?php echo $data_detail->status == 1 ? 'selected' : ''; ?>>Open</option>
                                            <option value="2" <?php echo $data_detail->status == 2 ? 'selected' : ''; ?>>Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Kategori</label>
                                        <input type="text" class="form-control" name="kategori" value="<?php echo $data_detail->kategori; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Nama Perusahaan</label>
                                        <input type="text" class="form-control" name="nama_perusahaan" value="<?php echo $data_detail->nama_perusahaan; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Nomor NPWP</label>
                                        <input type="text" class="form-control" name="npwp_no" value="<?php echo $data_detail->npwp_no; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email_perusahaan" value="<?php echo $data_detail->email_perusahaan; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Nomor Telepon</label>
                                        <input type="text" class="form-control" name="no_telp" value="<?php echo $data_detail->no_telp; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Alamat</label>
                                        <textarea rows="4" class="form-control" name="alamat" placeholder="alamat perusahaan"><?php echo $data_detail->alamat; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Deskripsi Pertanyaan</label>
                                        <textarea rows="4" class="form-control" name="deskripsi_pertanyaan" placeholder="deskripsi pertanyaan"><?php echo $data_detail->deskripsi_pertanyaan; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group position-relative">
                                        <label>Deskripsi Jawaban</label>
                                        <textarea rows="4" class="form-control" name="deskripsi_jawaban" placeholder="deskripsi jawaban"><?php echo $data_detail->deskripsi_jawaban; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-sm mr-2" onclick="return confirm('Apakah Anda yakin akan Simpan?')"><i class="ft-check-square mr-1"></i> Simpan</button>
                            <a href="<?php echo base_url('administration/helpdesk/ticket'); ?>" class="btn btn-secondary btn-sm"><i class="ft-x mr-1"></i> Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bordered Form Layout ends -->
        <!-- Striped Row Form Layout ends -->
    </div>
</section>

<div class="chat-application overflow-hidden mt-3">
    <div class="app-content-overlay"></div>
    <div class="chat-name p-2">
        <div class="media p-1 align-items-center">
            <div class="media-body">
                <span class="text-bold-700">Monitor Chat</span>
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
                                <a href="<?php echo base_url('administration/helpdesk/ticket/delete_chat/' . $value['id']); ?>" onclick="return confirm('Apakah Anda yakin hapus pesan ini?')"><i class="ft-trash text-danger"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($value['lampiran_left'] != NULL) { ?>
                    <div class="chat chat-left">
                        <div class="chat-body">
                            <div class="chat-content">
                                <p><a href="<?php echo $this->config->item('ekstranet_url') . 'attachment/ticket/' . $value['lampiran_left']; ?>" target="_blank"><i class="ft-file"></i> View file</a></p>
                                <p class="text-muted"><?php echo date("d-m-Y h:i:s", strtotime($value['date_create'])); ?></p>
                                <a href="<?php echo base_url('administration/helpdesk/ticket/delete_chat/' . $value['id']); ?>" onclick="return confirm('Apakah Anda yakin hapus pesan ini?')"><i class="ft-trash text-danger"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($value['lampiran_right'] != NULL) { ?>
                    <div class="chat">
                        <div class="chat-body">
                            <div class="chat-content">
                                <p><a style="color:#fff" href="<?php echo base_url('log/download_attachment/administration/' . $value['lampiran_right']); ?>" target="_blank"><i class="ft-file"></i> View file</a></p>
                                <p class="text-muted"><?php echo date("d-m-Y h:i:s", strtotime($value['date_create'])); ?></p>
                                <a href="<?php echo base_url('administration/helpdesk/ticket/delete_chat/' . $value['id']); ?>" onclick="return confirm('Apakah Anda yakin hapus pesan ini?')"><i class="ft-trash" style="color:#fff"></i></a>
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
                                <a href="<?php echo base_url('administration/helpdesk/ticket/delete_chat/' . $value['id']); ?>" onclick="return confirm('Apakah Anda yakin hapus pesan ini?')"><i class="ft-trash" style="color:#fff"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <section class="card px-3 py-2" id="form">
        <form class="d-flex align-items-center" method="POST" action="<?php echo base_url('administration/helpdesk/ticket/add_chat'); ?>#form" enctype="multipart/form-data">
            <button type="submit" <?php echo $data_detail->status == 2 ? 'disabled' : ''; ?> class="btn btn-info d-lg-flex align-items-center" onclick="return confirm('Apakah Anda yakin kirim pesan ini?')">
                <i class="<?php echo $data_detail->status == 2 ? 'ft-slash' : 'ft-send'; ?>"></i>
                <span class="d-none d-lg-block ml-1">Kirim</span>
            </button>
            <input type="hidden" name="ticket_id" value="<?php echo $data_detail->ticket_id; ?>">
            <input type="text" class="form-control chat-message-send mx-2" name="message_right" placeholder="Type your message here">
            
            <?php $curval = (isset($v['ppd_file_name'])) ? $v['ppd_file_name'] :  set_value("doc_attachment_inp[]"); ?>
            <div class="input-group align-items-center">
                <span class="input-group-btn">
                    <button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo $dir ?>" data-preview="preview_file_" class="btn btn-sm btn-info upload">
                        <i class="fa fa-cloud-upload"></i> Upload
                    </button>
                    <button type="button" data-url="<?php echo site_url('log/download_attachment/administration/' . $curval) ?>" class="btn btn-sm btn-info preview_upload" id="preview_file_">
                        <i class="fa fa-share"></i> Preview
                    </button>
                </span>
                <input readonly type="text" class="form-control" id="doc_attachment_inp_" name="lampiran_right" value="<?php echo $curval ?>">
                <span class="input-group-btn">
                    <button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo $dir ?>" data-preview="preview_file_" class="btn btn-sm btn-danger removefile">
                        <i class="fa fa-trash"></i>
                    </button>
                </span>
            </div>
        </form>
    </section>
</div>


<script src="<?php echo base_url('assets') ?>/app-assets/js/app-chat.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        toasterOptions();
        response_data();
        response_chat();
        response_chat_del();

        function response_data() {
            if ('<?php echo $this->session->flashdata('tab') ?>' == 'ticket') {
                if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
                    toastr.info('Ticket berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Ticket gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }

        function response_chat() {
            if ('<?php echo $this->session->flashdata('tab') ?>' == 'chat') {
                if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
                    toastr.info('Chat berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Chat gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }

        function response_chat_del() {
            if ('<?php echo $this->session->flashdata('tab') ?>' == 'chat_del') {
                if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
                    toastr.info('Chat berhasil dihapus.', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Chat gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }

    })
</script>