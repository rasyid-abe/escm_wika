<style scoped>
    .custom-table thead th {
        vertical-align: middle;
        text-align: center;
        padding: 0.5rem 2rem;
    }

    /* animate loading */
    #loading {
        width: 5rem;
        height: 5rem;
        border: 10px solid #f3f3f3;
        border-top: 11px solid #2aace3;
        border-radius: 100%;
        margin: auto;
        display: none;
        animation: spin 1s infinite linear;
    }

    #loading.display {
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

    .wrapper-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    #btn-action-edit {
        width: 100px;
        border-radius: 8px;
    }

    .btn-action-delete {
        border-radius: 0 8px 8px 0;
        background-color: rgb(36 36 36 / 22%);
        position: relative;
        left: -4px;
    }
</style>
<?php
$user_get = $this->db->get('adm_user')->result_array();

if (isset($permintaan['ptm_number'])) {
    $pr_number = $this->db->select('pr_number');
    $pr_number = $this->db->where('ptm_number', $permintaan['ptm_number']);
    $pr_number = $this->db->get('prc_tender_main')->row_array();
    $uris = $pr_number['pr_number'];
} else {
    if ($this->uri->segment(4, 0)) {
        $uris = $this->uri->segment(4, 0);
    } else {
        $this->load->model(array("Procpr_m"));
        $uris = $this->Procpr_m->getUrutPR();
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span class="wrapper-header">
                    <div class="title-header d-flex align-items-center">
                        <h4 class="card-title ">Daftar Risiko</h4>
                        <a onclick="isRisiko()" class="btn btn-sm btn-info btn-tambah ml-2 rounded">
                            <i class="ft ft-plus"></i>Tambah
                        </a>
                    </div>
                    <div class="wrapper-button" id="btnSaveRisiko" style="display: none;">
                        <span class="wrapper-action save-comment">
                            <a class="btn btn-sm btn-info action_risiko" id="btn-action-edit">Simpan</a>
                            <input type="hidden" id="risiko_id_edit">
                            <input type="hidden" id="risiko_no_edit">
                        </span>
                    </div>
                </span>
                <div id="addInputRisiko" style="display: none;">
                    <div class="row mb-2">
                        <div class="col-md row">
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Kategori <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="rs_kategori" id="rs_kategori" placeholder="Kategori">
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Risiko <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="rs_risiko" id="rs_risiko" placeholder="Risiko">
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Penyebab <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="rs_penyebab" id="rs_penyebab" placeholder="Penyebab">
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Dampak <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="rs_dampak" id="rs_dampak" placeholder="Dampak">
                                </div>
                            </div>
                        </div>
                        <div class="col-md row">
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Rating Probabilitas <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="rs_rating_probabilitas" id="rs_rating_probabilitas" placeholder="Rating Probabilitas">
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Rating Dampak <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="rs_rating_dampak" id="rs_rating_dampak" placeholder="Rating Dampak">
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Level Risiko <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control bg-select" name="rs_level_risiko" id="rs_level_risiko">
                                        <option value="">Pilih</option>
                                        <option value="rendah">Rendah</option>
                                        <option value="menengah">Menengah</option>
                                        <option value="tinggi">Tinggi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">PIC <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control bg-select select2" style="width: 100%;" name="rs_pic" id="rs_pic">
                                        <option value="">Pilih</option>
                                        <?php foreach ($user_get as $complete_name) {
                                        ?>
                                            <option value="<?= $complete_name['complete_name'] ?>"><?= $complete_name['complete_name'] ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md row mb-1">
                            <label class="col-sm-2 control-label">Mitigasi <span class="text-danger text-bold-700">*</span></label>
                            <div class="col-sm-10" style="padding-left: 10px;">
                                <input type="text" class="form-control" name="rs_mitigasi" id="rs_mitigasi" placeholder="Masukkan Mitigasi">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="loading"></div>
            </div>

            <table class="table table-striped custom-table table-responsive">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Kategori</th>
                        <th rowspan="2">Risiko</th>
                        <th rowspan="2">Penyebab</th>
                        <th rowspan="2">Dampak</th>
                        <th colspan="2">Rating</th>
                        <th rowspan="2">Level Risiko</th>
                        <th rowspan="2">Mitigasi</th>
                        <th rowspan="2">PIC</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th rowspan="5">Probabilitas</th>
                        <th rowspan="4">Dampak</th>
                    </tr>
                </thead>
                <tbody id="daftar-risiko"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getRisiko();
    });
    const loader = document.querySelector("#loading");
    // showing loading
    function displayLoading() {
        loader.classList.add("display");
        // to stop loading after some time
        setTimeout(() => {
            loader.classList.remove("display");
        }, 3000);
    }

    // hiding loading 
    function hideLoading() {
        loader.classList.remove("display");
    }

    function isRisiko() {
        var div = document.getElementById("addInputRisiko");
        var smbd_save = document.getElementById("btnSaveRisiko");
        if (div.style.display !== "none") {
            div.style.display = "none";
            smbd_save.style.display = "none";
        } else {
            div.style.display = "block";
            smbd_save.style.display = "flex";
        }
    }
console.log("<?= $uris; ?>");
    function getRisiko() {
        $.ajax({
            url: '<?= site_url("paket_pengadaan/get_list_risiko/" . $uris); ?>',
            method: 'post',
            dataType: 'json',
            success: function(res) {
                var i;
                var respon = "";
                var no = 1;
                var html = "";
                for (i = 0; i < res.data.length; i++) {
                    html = html + "<tr>" +
                        "<td><input type='hidden' id='number-tbl' class='number-tbl' data-no=" + no + " value=" + no + ">" + no + "</td>" +
                        "<td><input type='hidden' id='kategori' data-no=" + no + " value=" + JSON.stringify(res.data[i].kategori) + ">" + res.data[i].kategori + "</td>" +
                        "<td><input type='hidden' id='risiko' data-no=" + no + " value=" + JSON.stringify(res.data[i].risiko) + ">" + res.data[i].risiko + "</td>" +
                        "<td><input type='hidden' id='penyebab' data-no=" + no + " value=" + JSON.stringify(res.data[i].penyebab) + ">" + res.data[i].penyebab + "</td>" +
                        "<td><input type='hidden' id='dampak' data-no=" + no + " value=" + JSON.stringify(res.data[i].dampak) + ">" + res.data[i].dampak + "</td>" +
                        "<td><input type='hidden' id='rating_probabilitas' data-no=" + no + " value=" + JSON.stringify(res.data[i].rating_probabilitas) + ">" + res.data[i].rating_probabilitas + "</td>" +
                        "<td><input type='hidden' id='rating_dampak' data-no=" + no + " value=" + JSON.stringify(res.data[i].rating_dampak) + ">" + res.data[i].rating_dampak + "</td>" +
                        "<td><input type='hidden' id='level_risiko' data-no=" + no + " value=" + res.data[i].level_risiko + ">" + res.data[i].level_risiko + "</td>" +
                        "<td><input type='hidden' id='mitigasi' data-no=" + no + " value=" + JSON.stringify(res.data[i].mitigasi) + ">" + res.data[i].mitigasi + "</td>" +
                        "<td><input type='hidden' id='pic' data-no=" + no + " value=" + res.data[i].pic + ">" + res.data[i].pic + "</td>" +
                        "<td style='min-width: 200px;'><span class='wrapper-action'><a class='btn btn-sm btn-info btn-action-edit edit-risiko' data-no=" + no + " data-id=" + res.data[i].id + " >Edit</a><a onclick='onDeleteRisiko(" + res.data[i].id + ")' class='btn btn-sm btn-action-delete'><i class='fa fa-trash'></i></a></span></td>" +
                        "</tr>";
                    no++;
                }
                $('#daftar-risiko').html(html);
            }
        });
    }
    $('.action_risiko').click(function() {
        // two variable for edit datas
        var current_no = $('#risiko_no_edit').val();
        var id_edit = $('#risiko_id_edit').val();

        var no = current_no;
        if (getMaxDataNo(".risiko_no_edit") == null) {
            no = 0;
        } else {
            no = getMaxDataNo(".risiko_no_edit") + 1;
        }

        var rs_kategori = $('#rs_kategori').val();
        var rs_risiko = $('#rs_risiko').val();
        var rs_penyebab = $('#rs_penyebab').val();
        var rs_dampak = $('#rs_dampak').val();
        var rs_rating_probabilitas = $('#rs_rating_probabilitas').val();
        var rs_rating_dampak = $('#rs_rating_dampak').val();
        var rs_level_risiko = $('#rs_level_risiko').val();
        var rs_pic = $('#rs_pic').val();
        var rs_mitigasi = $('#rs_mitigasi').val();
        if (rs_kategori === '' || rs_risiko === '' || rs_penyebab === '' ||
            rs_dampak === '' || rs_rating_probabilitas === '' || rs_rating_dampak === '' ||
            rs_level_risiko === '' || rs_pic === '' || rs_pic === null || rs_mitigasi === '') {
            alert("Semua input Risiko harus diisi!");
            return false;
        } else {
            displayLoading();
            var formData = new FormData();
            formData.append('rs_kategori', rs_kategori);
            formData.append('rs_risiko', rs_risiko);
            formData.append('rs_penyebab', rs_penyebab);
            formData.append('rs_dampak', rs_dampak);
            formData.append('rs_rating_probabilitas', rs_rating_probabilitas);
            formData.append('rs_rating_dampak', rs_rating_dampak);
            formData.append('rs_level_risiko', rs_level_risiko);
            formData.append('rs_pic', rs_pic);
            formData.append('rs_mitigasi', rs_mitigasi);

            if (id_edit == "") {
                <?php $url_save = site_url("paket_pengadaan/save_list_risiko/" . $uris); ?>
                fetch("<?= $url_save ?>", {
                        body: formData,
                        method: "post"
                    })
                    .then(response => response.json())
                    .then(res => {
                        getRisiko();
                        hideLoading();
                    })
                    .catch(err => console.log(err));
            } else {
                <?php $url_edit = site_url("paket_pengadaan/edit_list_risiko/" . $uris); ?>
                formData.append('id', id_edit);

                fetch("<?= $url_edit ?>", {
                        body: formData,
                        method: "post"
                    })
                    .then(response => response.json())
                    .then(res => {
                        getRisiko();
                        hideLoading();
                    })
                    .catch(err => console.log(err));
            }
            resetFormPmcs();
        }
    })

    $(document.body).on("click", ".edit-risiko", function() {
        var div = document.getElementById("addInputRisiko");
        var smbd_save = document.getElementById("btnSaveRisiko");

        div.style.display = "block";
        smbd_save.style.display = "flex";

        var ids = $(this).attr('data-id');
        var params = $(this).attr('data-no');

        $('#risiko_id_edit').val(ids);
        $('#risiko_no_edit').val(params);

        var no = $(this).attr('data-no');
        var rs_kategori = $("#kategori[data-no='" + no + "']").val();
        var rs_risiko = $("#risiko[data-no='" + no + "']").val();
        var rs_penyebab = $("#penyebab[data-no='" + no + "']").val();
        var rs_dampak = $("#dampak[data-no='" + no + "']").val();
        var rs_rating_probabilitas = $("#rating_probabilitas[data-no='" + no + "']").val();
        var rs_rating_dampak = $("#rating_dampak[data-no='" + no + "']").val();
        var rs_level_risiko = $("#level_risiko[data-no='" + no + "']").val();
        var rs_pic = $("#pic[data-no='" + no + "']").val();
        var rs_mitigasi = $("#mitigasi[data-no='" + no + "']").val();

        $('#rs_kategori').val(rs_kategori);
        $('#rs_risiko').val(rs_risiko);
        $('#rs_penyebab').val(rs_penyebab);
        $('#rs_dampak').val(rs_dampak);
        $('#rs_rating_probabilitas').val(rs_rating_probabilitas);
        $('#rs_rating_dampak').val(rs_rating_dampak);
        $('#rs_level_risiko').val(rs_level_risiko);
        $('#rs_pic').val(rs_pic);
        $('#rs_mitigasi').val(rs_mitigasi);

        $(this).parent().parent().parent().remove();
    })

    function onDeleteRisiko(params) {
        let cf = "Apakah anda yakin menghapus data ini?";
        if (confirm(cf) === true) {
            <?php $url_delete = site_url("paket_pengadaan/delete_list_risiko"); ?>
            var fd = new FormData();
            fd.append('id', params);

            fetch("<?= $url_delete ?>", {
                    body: fd,
                    method: "post"
                })
                .then(response => response.json())
                .then(res => {
                    getRisiko();
                })
                .catch(err => console.log(err));
        }
    }

    function resetFormPmcs() {
        $('#risiko_id_edit').val("");
        $('#rs_kategori').val("");
        $('#rs_risiko').val("");
        $('#rs_penyebab').val("");
        $('#rs_dampak').val("");
        $('#rs_rating_probabilitas').val("");
        $('#rs_rating_dampak').val("");
        $('#rs_level_risiko').val("");
        $("#rs_pic").select2("val", "");
        $('#rs_mitigasi').val("");
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
</script>