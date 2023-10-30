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
    $uris = $pr_number;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span class="wrapper-header">
                    <div class="title-header d-flex align-items-center">
                        <h4 class="card-title ">Identifikasi Risiko dan Mitigasinya</h4>
                    </div>                   
                </span>
            </div>

            <table class="table table-striped custom-table" style="width:100%">
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
                    </tr>
                    <tr>
                        <th rowspan="4">Probabilitas</th>
                        <th rowspan="3">Dampak</th>
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
                        "</tr>";
                    no++;
                }
                $('#daftar-risiko').html(html);
            }
        });
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
</script>