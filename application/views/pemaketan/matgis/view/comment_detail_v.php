<style>
    .btn-action-delete {
        left: 0px;
    }

    .wrapper-icon {
        display: flex;
        align-items: center;
        margin-left: 8px;
        padding: 5px;
        cursor: pointer;
    }

    .wrapper-icon:hover {
        background-color: #eaeaea;
        border-radius: 8px;
        cursor: pointer;
    }

    .wrapper-icon-active {
        background-color: #eaeaea;
        border-radius: 8px;
        cursor: pointer;
    }

    /* animate loading */
    #loadingcmt {
        width: 5rem;
        height: 5rem;
        border: 10px solid #f3f3f3;
        border-top: 11px solid #2aace3;
        border-radius: 100%;
        margin: auto;
        display: none;
        animation: spin 1s infinite linear;
    }

    #loadingcmt.display {
        display: block;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
<div class="row" id="form-comment">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title float-left">Catatan</h4>
                <a onclick="isShowCmt()" class="btn btn-sm btn-info btn-tambah ml-2">
                    <i class="ft ft-plus"></i>Tambah
                </a>
                <div class="float-right">
                    <img src="<?php echo base_url(); ?>/assets/icons/LIKE20px.png" class="ml-1">
                    <b><?= $thumbs_down ?></b>
                    <img src="<?php echo base_url(); ?>/assets/icons/DISLIKE20px.png" class="ml-1">
                    <b><?= $thumbs_up ?></b>
                    <img src="<?php echo base_url(); ?>/assets/icons/COMMENT20px.png" class="ml-1">
                    <b><?= $comment ?></b>
                    <a href="<?= $controller_name . '/pdf_comment/' ?>">
                        <button class="btn btn-export ml-1">
                            <img width="20" class="mr-1" src="<?= base_url('assets/img/icons/printer.png') ?>" alt="printer-icon">
                            Export <i class=" fa fa-angle-down fa-lg"></i>
                        </button>
                    </a>
                </div>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <!-- form edit -->
                    <div id="showEdit" style="display: none;">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Objek Catatan</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="prc_obj_nilai_edit" name="prc_obj_nilai_edit" placeholder="Objek Catatan">
                            </div>

                            <div class="col-md-2">
                                <label for="lampiran">No. Telpon</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="prc_no_telp_edit" name="prc_no_telp_edit" placeholder="Nomor Telpon">
                            </div>
                        </div>
                        <br>

                        <div class="row form-group">
                            <?php $curval = set_value("prc_lampiran_edit"); ?>
                            <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
                            <div class="col-md-4">
                                <div class="input-group align-items-center">
                                    <span class="input-group-btn">
                                        <button type="button" data-id="prc_lampiran_edit" data-folder="<?php echo $dir ?>" data-preview="preview_file" class="btn btn-info upload rounded">
                                            <i class="fa fa-cloud-upload"></i> Up
                                        </button>
                                        <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/tender/' . $curval) ?>" class="btn btn-info preview_upload rounded mr-1" id="preview_file">
                                            <i class="fa fa-share"></i> View
                                        </button>
                                    </span>
                                    <input readonly type="text" class="form-control valid" id="prc_lampiran_edit" name="prc_lampiran_edit" value="<?php echo $curval ?>">
                                    <span class="input-group-btn">
                                        <button type="button" data-id="prc_lampiran_edit" data-folder="<?php echo $dir ?>" data-preview="preview_file" class="btn btn-danger removefile rounded ml-1">
                                            <i class="fa fa-trash"></i> Del
                                        </button>
                                    </span>
                                </div>
                                <div class="col-sm-0" style="font-size: 11px">
                                    <i>Max file 5 MB
                                        <br>
                                        Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                                    </i>
                                </div>
                            </div>
                            <label class="col-md-2">Komentar</label>
                            <div class="col-md-4">
                                <input type="hidden" id="cad_id" name="cad_id" value="">
                                <textarea rows="4" class="form-control" id="prc_comment_edit" name="prc_comment_edit" placeholder="Isi komentar"></textarea>
                            </div>
                            <div class="col-md-6">
                                <p style="color: transparent !important">test</p>
                            </div>
                            <label class="col-md-2 mt-2">Pilih respon</label>
                            <div class="col-md-4 d-flex justify-content-start mt-2">
                                <input type="hidden" value="" id="prc_respon_edit" name="prc_respon_edit">
                                <div id="response-comment1" class="wrapper-icon mr-2" onclick="respon(1)">
                                    <img src="<?php echo base_url(); ?>/assets/icons/LIKE32px.png" id="thumbsup">
                                    <span class="ml-1">baik</span>
                                </div>
                                <div id="response-comment0" class="wrapper-icon mr-2" onclick="respon(0)">
                                    <img src="<?php echo base_url(); ?>/assets/icons/DISLIKE32px.png" id="thumbsdown">
                                    <span class="ml-1">buruk</span>
                                </div>
                                <div id="response-comment2" class="wrapper-icon" onclick="respon(2)">
                                    <img src="<?php echo base_url(); ?>/assets/icons/COMMENT32px.png" id="comment">
                                    <span class="ml-1">comment</span>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="row form-group mr-2 justify-content-end">
                        </div>
                        <br>
                        <span class="d-flex justify-content-end">
                            <input type="hidden" id="comment_id_edit" name="comment_id_edit">
                            <input type="hidden" id="comment_id_edit_id" name="comment_id_edit_id">
                            <a type="submit" class="btn btn-sm btn-info btn-action-edit save-submit">Submit</a>
                            <a type="reset" onclick="resetForm()" class="btn btn-sm btn-action-delete">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                        </span>
                    </div>
                    <div id="loadingcmt"></div>
                </div>
                <br>
                <?php
                if ($this->uri->segment(5, 0)) {
                    $uris = $this->uri->segment(5, 0);
                } else {
                    $uris = $this->uri->segment(4, 0);
                }
                ?>
                <div class="overflow-auto px-2">
                    <table class="table table-striped table-catatan text-center table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Respon</th>
                                <th scope="col">Objek Penilaian</th>
                                <th scope="col">Lampiran</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Divisi</th>
                                <th scope="col">No Telpon</th>
                                <th scope="col">Tanggal & Waktu</th>
                                <th scope="col">Komentar</th>
                                <th scope="col" style="min-width: 170px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-comments">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const loaderCmt = document.querySelector("#loadingcmt");
    // showing loading
    function displayLoadingCmt() {
        loaderCmt.classList.add("display");
        // to stop loading after some time
        setTimeout(() => {
            loaderCmt.classList.remove("display");
        }, 3000);
    }

    // hiding loading 
    function hideLoadingCmt() {
        loaderCmt.classList.remove("display");
    }

    function getMaxDataNo(selector) {
        var min = null,
            max = null;
        $(selector).each(function() {
            var no_pp = parseInt($(this).attr('data-no'), 10);
            if ((max === null) || (no_pp > max)) {
                max = no_pp;
            }
        });
        return max;
    }

    fetchData();

    function fetchData() {
        let thumbs_up = '<img src="<?= base_url() ?>/assets/icons/LIKE32px.png" class="ml-1">';
        let thumbs_down = '<img src="<?= base_url() ?>/assets/icons/DISLIKE32px.png" class="ml-1">';
        let comment = '<img src="<?= base_url() ?>/assets/icons/COMMENT32px.png" class="ml-1">';

        $.ajax({
            url: '<?= site_url($controller_name . "/get_comment_permintaan_pengadaan/" . $uris); ?>',
            method: 'post',
            dataType: 'json',
            success: function(res) {
                var i;
                var respon = "";
                var no = 1;
                var html = "";
                for (i = 0; i < res.data.length; i++) {
                    if (res.data[i].pr_respon == '1') {
                        respon = thumbs_up;
                    } else if (res.data[i].pr_respon == '0') {
                        respon = thumbs_down;
                    } else {
                        respon = comment;
                    }
                    html = html + "<tr>" +
                        "<td><input type='hidden' id='number-tbl' class='number-tbl' data-no=" + no + " value=" + no + ">" + no + "</td>" +
                        "<td><input type='hidden' class='respon' id='respon' data-no=" + no + " value=" + res.data[i].pr_respon + ">" + respon + "</td>" +
                        "<td><input type='hidden' class='objek_catatan' id='objek_catatan' data-no=" + no + " value=" + JSON.stringify(res.data[i].pr_obj_nilai) + ">" + res.data[i].pr_obj_nilai + "</td>" +
                        "<td><input type='hidden' class='lampiran_catatan' id='lampiran_catatan' data-no=" + no + " value=" + JSON.stringify(res.data[i].pr_lampiran) + ">" +
                        "<a href=" + document.location.origin + '/log/download_attachment/procurement/comment/' + res.data[i].pr_lampiran + ">" + res.data[i].pr_lampiran + "</a></td>" +
                        "<td><input type='hidden' id='username' data-no=" + no + " value=" + JSON.stringify(res.data[i].pr_user_name) + ">" + res.data[i].pr_user_name + "</td>" +
                        "<td><input type='hidden' id='jabatan' data-no=" + no + " value=" + JSON.stringify(res.data[i].pr_position) + ">" + res.data[i].pr_position + "</td>" +
                        "<td><input type='hidden' id='jabatan' data-no=" + no + " value=" + JSON.stringify(res.data[i].pr_divisi) + ">" + res.data[i].pr_divisi + "</td>" +
                        "<td><input type='hidden' class='no_telp' id='no_telp' data-no=" + no + " value=" + JSON.stringify(res.data[i].pr_no_telp) + ">" + res.data[i].pr_no_telp + "</td>" +
                        "<td>" + res.data[i].pr_created_date + "</td>" +
                        "<td style='min-width: 200px;'><textarea disabled id='comment_value' name='ppc_comment' data-no=" + no + " class='form-control ppc_comment_value comment_value' rows='3'>" + res.data[i].pr_comment + "</textarea></td>" +
                        "<td style='min-width: 200px;'><span class='wrapper-action'><a class='btn btn-sm btn-info btn-action-edit edit-comment' data-no=" + no + " data-id=" + res.data[i].id + " >Edit</a><a onclick='onDeleteComment(" + res.data[i].id + ")' class='btn btn-sm btn-action-delete'><i class='fa fa-trash'></i></a></span></td>" +
                        "</tr>";
                    no++;
                }
                $('#table-comments').html(html);
            }
        });
    };

    $('.save-submit').click(function() {
        var current_no = $('#comment_id_edit').val();
        var id_edit = $('#comment_id_edit_id').val();
        var no = current_no;
        if (id_edit == "") {
            if (getMaxDataNo(".number-tbl") == null) {
                no = 1;
            } else {
                no = getMaxDataNo(".number-tbl") + 1;
            }
        }
        var obj_nilai = $('#prc_obj_nilai_edit').val();
        var no_telp = $('#prc_no_telp_edit').val();
        var lampiran = ($('#prc_lampiran_edit').val());
        var comment = $('#prc_comment_edit').val();
        var respons = $('#prc_respon_edit').val();

        if (obj_nilai === '' || lampiran === '' || no_telp === '' || comment === '' || respons === '') {
            alert("Semua input catatan harus diisi!");
            return false;
        } else {
            displayLoadingCmt();
            var formData = new FormData();
            formData.append('prc_obj_nilai_edit', obj_nilai);
            formData.append('prc_no_telp_edit', no_telp);
            formData.append('prc_lampiran_edit', lampiran);
            formData.append('prc_comment_edit', comment);
            formData.append('prc_respon_edit', respons);

            if (id_edit == "") {
                <?php $url_save = site_url($controller_name . "/save_comment_permintaan_pengadaan/" . $uris); ?>
                fetch("<?= $url_save ?>", {
                        body: formData,
                        method: "post"
                    })
                    .then(response => response.json())
                    .then(res => {
                        fetchData();
                        hideLoadingCmt();
                    })
                    .catch(err => console.log(err));
            } else {
                <?php $url_edit = site_url($controller_name . "/edit_comment_permintaan_pengadaan/" . $uris); ?>
                formData.append('prc_id', id_edit);

                fetch("<?= $url_edit ?>", {
                        body: formData,
                        method: "post"
                    })
                    .then(response => response.json())
                    .then(res => {
                        fetchData();
                        hideLoadingCmt();
                    })
                    .catch(err => console.log(err));
            }
            resetForm();
        }

    });

    $(document.body).on("click", ".edit-comment", function() {
        var edit = document.getElementById("showEdit");
        edit.style.display = "block";

        var ids = $(this).attr('data-id');
        var params = $(this).attr('data-no');

        $('#comment_id_edit_id').val(ids);
        $('#comment_id_edit').val(params);
        var respon = $('.respon[data-no= ' + params + ']').val();
        var objek_catatan = $('.objek_catatan[data-no= ' + params + ']').val();
        var lampiran_catatan = $('.lampiran_catatan[data-no= ' + params + ']').val();
        var no_telp = $('.no_telp[data-no= ' + params + ']').val();
        var comment_value = $('.comment_value[data-no= ' + params + ']').val();

        $('#prc_obj_nilai_edit').val(objek_catatan)
        $('#prc_no_telp_edit').val(no_telp)
        $('#prc_lampiran_edit').val(lampiran_catatan)
        $('#prc_comment_edit').val(comment_value)
        $('#prc_respon_edit').val(respon)
        if (respon == 1) {
            $("#response-comment1").addClass("wrapper-icon-active");
            $("#response-comment0").removeClass("wrapper-icon-active");
            $("#response-comment2").removeClass("wrapper-icon-active");
        } else if (respon == 2) {
            $("#response-comment2").addClass("wrapper-icon-active");
            $("#response-comment1").removeClass("wrapper-icon-active");
            $("#response-comment0").removeClass("wrapper-icon-active");
        } else {
            $("#response-comment0").addClass("wrapper-icon-active");
            $("#response-comment1").removeClass("wrapper-icon-active");
            $("#response-comment2").removeClass("wrapper-icon-active");
        }
        $(this).parent().parent().parent().remove();
    })

    function onDeleteComment(id) {
        displayLoadingCmt();
        let cf = "Apakah yakin menghapus catatan ini?";
        <?php $url_del = site_url($controller_name . "/delete_comment_permintaan_pengadaan"); ?>
        let fd = new FormData();
        fd.append('id', id);

        if (confirm(cf) === true) {
            fetch("<?= $url_del ?>", {
                    body: fd,
                    method: "post"
                })
                .then(response => response.json())
                .then(res => {
                    fetchData();
                    hideLoadingCmt();
                });
        }
    }

    function isShowCmt() {
        var div = document.getElementById("showEdit");
        if (div.style.display !== "none") {
            div.style.display = "none";
        } else {
            div.style.display = "block";
        }
    }

    function resetForm(params) {
        $('#comment_id_edit').val("");
        $('#comment_id_edit_id').val("");
        $('#number-tbl').val("");
        $('#prc_obj_nilai_edit').val("");
        $('#prc_no_telp_edit').val("");
        $('#prc_lampiran_edit').val("");
        $('#prc_comment_edit').val("");
        $('#prc_respon_edit').val("");
        $("#response-comment1").removeClass("wrapper-icon-active");
        $("#response-comment0").removeClass("wrapper-icon-active");
        $("#response-comment2").removeClass("wrapper-icon-active");
    }

    function respon(params) {
        var responEl = document.querySelector('input[name="prc_respon_edit"]');
        responEl.value = params;
        if (params == 1) {
            $("#response-comment1").addClass("wrapper-icon-active");
            $("#response-comment0").removeClass("wrapper-icon-active");
            $("#response-comment2").removeClass("wrapper-icon-active");
        } else if (params == 2) {
            $("#response-comment2").addClass("wrapper-icon-active");
            $("#response-comment1").removeClass("wrapper-icon-active");
            $("#response-comment0").removeClass("wrapper-icon-active");
        } else {
            $("#response-comment0").addClass("wrapper-icon-active");
            $("#response-comment1").removeClass("wrapper-icon-active");
            $("#response-comment2").removeClass("wrapper-icon-active");
        }
    }
</script>