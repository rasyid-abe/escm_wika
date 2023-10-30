<style scoped>
    .custom-table thead th {
        vertical-align: middle;
        text-align: center;
        padding: 0.5rem 2rem;
    }

    .wrapper-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
</style>
<?php
    $user_get = $this->db->get('adm_user')->result_array();
?>

<div class="row" id="sec-ris" style="display: none">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span class="wrapper-header">
                    <div class="title-header d-flex align-items-center">
                        <h4 class="card-title ">Identifikasi Risiko dan Mitigasinya</h4>
                        <a onclick="isRisiko()" class="btn btn-sm btn-info btn-tambah ml-2 rounded">
                            <i class="ft ft-plus"></i>Tambah
                        </a>
                    </div>
                    <div class="wrapper-button" id="btnSaveRisiko" style="display: none;">
                        <span class="wrapper-action">
                            <a class="btn btn-sm btn-info btn-action-edit action_risiko">Simpan</a>
                            <a onclick="resetFormRisiko()" class="btn btn-sm btn-action-delete">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                            <input type="hidden" id="risiko_id_edit">
                            <input type="hidden" id="risiko_no_edit">
                        </span>
                    </div>
                </span>
                <div class="row mb-2" id="addInputRisiko" style="display: none;">
                    <div class="col-md">
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
                    <div class="col-md">
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
                    <div class="col-12">
                        <div class="form-group col-md-12 mb-1">
                            <label class="col-sm-2 control-label p-0" style="max-width: 15.9%;">Mitigasi</label>
                            <div class="col-sm-10 pl-0">
                                <input type="text" class="form-control" name="rs_mitigasi" id="rs_mitigasi" placeholder="Masukkan Mitigasi">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped custom-table" style="width:100%">
                <thead>
                    <tr>
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
                <tbody id="daftar-risiko">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function isRisiko() {
        var div = document.getElementById("addInputRisiko");
        var smbd_save = document.getElementById("btnSaveRisiko");
        if (div.style.display !== "none") {
            div.style.display = "none";
            smbd_save.style.display = "none";
        } else {
            div.style.display = "flex";
            smbd_save.style.display = "flex";
        }
    }
    $('.action_risiko').click(function() {
        // two variable for edit datas
        var current_no = $('#risiko_id_edit').val();
        var id_edit = $('#risiko_no_edit').val();

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
            rs_level_risiko === '' || rs_pic === '' || rs_mitigasi === '') {
            alert("Semua input Risiko harus diisi!");
            return false;
        } else {
            var html = "<tr><td><input type='hidden' class='kategori' data-no='" + no + "' name='kategori[" + no + "]' value='" + rs_kategori + "'>" + rs_kategori + "</td>";
            html += "<td><input type='hidden' class='risiko' data-no='" + no + "' name='risiko[" + no + "]' value='" + rs_risiko + "'>" + rs_risiko + "</td>";
            html += "<td><input type='hidden' class='penyebab' data-no='" + no + "' name='penyebab[" + no + "]' value='" + rs_penyebab + "'>" + rs_penyebab + "</td>";
            html += "<td><input type='hidden' class='dampak' data-no='" + no + "' name='dampak[" + no + "]' value='" + rs_dampak + "'>" + rs_dampak + "</td>";
            html += "<td><input type='hidden' class='rating_probabilitas' data-no='" + no + "' name='rating_probabilitas[" + no + "]' value='" + rs_rating_probabilitas + "'>" + rs_rating_probabilitas + "</td>";
            html += "<td><input type='hidden' class='rating_dampak' data-no='" + no + "' name='rating_dampak[" + no + "]' value='" + rs_rating_dampak + "'>" + rs_rating_dampak + "</td>";
            html += "<td><input type='hidden' class='level_risiko' data-no='" + no + "' name='level_risiko[" + no + "]' value='" + rs_level_risiko + "'>" + rs_level_risiko + "</td>";
            html += "<td><input type='hidden' class='mitigasi' data-no='" + no + "' name='mitigasi[" + no + "]' value='" + rs_mitigasi + "'>" + rs_mitigasi + "</td>";
            html += "<td><input type='hidden' class='pic' data-no='" + no + "' name='pic[" + no + "]' value='" + rs_pic + "'>" + rs_pic + "</td>";
            html += "<td><button type='button' class='btn btn-info btn-xs edit-risiko' data-no='" + no + "'><i class='fa fa-edit'></i></button></td></tr>";

            $("#daftar-risiko").append(html);
            resetFormRisiko();
        }
    })

    $(document.body).on("click", ".edit-risiko", function() {
        var no = $(this).attr('data-no');
        var rs_kategori = $(".kategori[data-no='" + no + "']").val();
        var rs_risiko = $(".risiko[data-no='" + no + "']").val();
        var rs_penyebab = $(".penyebab[data-no='" + no + "']").val();
        var rs_dampak = $(".dampak[data-no='" + no + "']").val();
        var rs_rating_probabilitas = $(".rating_probabilitas[data-no='" + no + "']").val();
        var rs_rating_dampak = $(".rating_dampak[data-no='" + no + "']").val();
        var rs_level_risiko = $(".level_risiko[data-no='" + no + "']").val();
        var rs_pic = $(".pic[data-no='" + no + "']").val();
        var rs_mitigasi = $(".mitigasi[data-no='" + no + "']").val();

        $('#rs_kategori').val(rs_kategori);
        $('#rs_risiko').val(rs_risiko);
        $('#rs_penyebab').val(rs_penyebab);
        $('#rs_dampak').val(rs_dampak);
        $('#rs_rating_probabilitas').val(rs_rating_probabilitas);
        $('#rs_rating_dampak').val(rs_rating_dampak);
        $('#rs_level_risiko').val(rs_level_risiko);
        $("#rs_pic").select2("val", "");
        $('#rs_mitigasi').val(rs_mitigasi);

        $(this).parent().parent().remove();
    })

    function resetFormRisiko() {
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