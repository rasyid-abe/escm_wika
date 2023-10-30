<?php
$sumber_hps = [
    [
        'value' => '',
        'option' => 'Pilih sumber HPS',
    ],
    [
        'value' => 'a. RAB proyek yang telah disahkan didalam RKP',
        'option' => 'a. RAB proyek yang telah disahkan didalam RKP',
    ],
    [
        'value' => 'b. Informasi biaya satuan yang dipublikasikan secara resmi oleh Badan Pusat Statistik (BPS)',
        'option' => 'b. Informasi biaya satuan yang dipublikasikan secara resmi oleh Badan Pusat Statistik (BPS)',
    ],
    [
        'value' => 'c. Informasi biaya satuan yang dipublikasikan secara resmi oleh asosiasi terkait dan sumber
        data lain yang dapat dipertanggungjawabkan',
        'option' => 'c. Informasi biaya satuan yang dipublikasikan secara resmi oleh asosiasi terkait dan sumber
        data lain yang dapat dipertanggungjawabkan',
    ],
    [
        'value' => 'd. Daftar biaya/tarif barang/jasa yang dikeluarkan oleh pabrikan / distributor tunggal',
        'option' => 'd. Daftar biaya/tarif barang/jasa yang dikeluarkan oleh pabrikan / distributor tunggal',
    ],
    [
        'value' => 'e. Biaya kontrak sebelumnya atau yang sedang berjalan dengan mempertimbangkan faktor perubahan biaya',
        'option' => 'e. Biaya kontrak sebelumnya atau yang sedang berjalan dengan mempertimbangkan faktor perubahan biaya',
    ],
    [
        'value' => 'f. Inflasi tahun sebelumnya, suku bunga berjalan dan/atau kurs tengah Bank Indonesia',
        'option' => 'f. Inflasi tahun sebelumnya, suku bunga berjalan dan/atau kurs tengah Bank Indonesia',
    ],
    [
        'value' => 'g. Hasil perbandingan dengan kontrak sejenis, baik yang dilakukan dengan instansi lain maupun pihak lain',
        'option' => 'g. Hasil perbandingan dengan kontrak sejenis, baik yang dilakukan dengan instansi lain maupun pihak lain',
    ],
    [
        'value' => 'h. Perkiraan perhitungan biaya yang dilakukan oleh konsultan perencanaan',
        'option' => 'h. Perkiraan perhitungan biaya yang dilakukan oleh konsultan perencanaan',
    ],
    [
        'value' => 'i. Norma indeks; dan/atau',
        'option' => 'i. Norma indeks; dan/atau',
    ],
    [
        'value' => 'j. Informasi lain yang dapat dipertanggungjawabkan',
        'option' => 'j. Informasi lain yang dapat dipertanggungjawabkan',
    ]
];
?>
<style scoped>
    .search-icon {
        position: absolute;
        top: 4%;
        right: 1%;
        background-color: #f7f7f8;
        color: #000;
        border: #e0e0e0;
    }

    .search-icon:hover {
        background-color: #f7f7f8;
        color: #000;
    }

    .hide {
        display: none;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header border-bottom pb-2">
                <div class="btn-group-sm float-left">
                    <!-- <img src="<?php echo base_url('assets/img/favicon.png');?>" width="50">
                    <img src="<?php echo base_url('assets/img/escm.png'); ?>" class="menu-title" alt="e-SCM Logo" style="width: 6.5rem; margin-left: 170%;"> -->
                    <span class="card-title text-bold-600 mr-2">Daftar Sumberdaya</span>
                </div>
            </div>

            <div class="card-content">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table" id="item_table">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode</th>
                                    <th>Nama Sumberdaya</th>
                                    <th>Item PO</th>
                                    <th>PR Number</th>
                                    <th>Item PR</th>
                                    <th>Tipe PR</th>
                                    <th>Volume</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    <th>Incoterm &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th>Lokasi Incoterm &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th class="is_jas">Retention &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th>Sumber HPS &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th>HPS &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th>Subtotal HPS</th>
                                    <th class="is_ass">No Asset &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th class="is_ass">Sub Number &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th>Tax Code &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</th>
                                    <th>Delivery Date</th>
                                    <th>Lampiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $subtotal = 0;
                                $subtotalhps = 0;
                                $no = 1;

                                // echo "<pre>";
                                // print_r($aitem);
                                // die;
                                if (isset($aitem) && !empty($aitem)) {
                                    foreach ($aitem as $key => $value) {
                                        $idnya = $key + 1;
                                        ?>

                                        <tr>
                                            <td class="text-center">
                                                <?php echo $no++; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_code'] ?>" name="item_kode[]" data-no="<?php echo $idnya ?>" class="kode_item">
                                                <?php echo $value['ppi_code'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_item_desc'] ?>" name="item_deskripsi[]" data-no="<?php echo $idnya ?>" class="deskripsi_item">
                                                <?php echo $value['ppi_item_desc'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $idnya * 10 ?>" name="item_po[]" data-no="<?php echo $idnya ?>" class="item_po">
                                                <?= $idnya * 10 ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_pr_number'] ?>" name="pr_number_sap[]" data-no="<?php echo $idnya ?>" class="pr_number_sap">
                                                <?php echo $value['ppis_pr_number'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_pr_item'] ?>" name="pr_item_sap[]" data-no="<?php echo $idnya ?>" class="pr_item_sap">
                                                <?php echo $value['ppis_pr_item'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_pr_type'] ?>" name="pr_type_sap[]" data-no="<?php echo $idnya ?>" class="pr_type_sap">
                                                <?php echo $value['ppis_pr_type'] ?>
                                            </td>
                                            <td class="text-right">
                                                <!-- # -->
                                                <input type="hidden" value="<?php echo $value[0] ?>" name="item_jumlah[]" data-no="<?php echo $value[0] ?>" class="jumlah_item" id="qty<?php echo $idnya?>">
                                                <?php echo inttomoney($value[0]) ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_satuan'] ?>" name="item_satuan[]" data-no="<?php echo $idnya ?>" class="satuan_item">
                                                <?php echo $value['ppi_satuan'] ?>
                                            </td>
                                            <td class="text-right">
                                                <input type="hidden" value="<?php echo (int)str_replace(".", "", $value[1]) ?>" name="item_harga_satuan[]" data-no="<?php echo $idnya ?>" class="harga_satuan_item">
                                                <?php echo inttomoney((int)str_replace(".", "", $value[1])) ?>
                                            </td>
                                            <td class="text-right">
                                                <input type="hidden" value="<?php echo (int)str_replace(".", "", $value[2]) * $value[0] ?>" name="item_subtotal[]" data-no="<?php echo $idnya ?>" class="subtotal_item">
                                                <?php echo inttomoney((int)str_replace(".", "", $value[2]) * $value[0]) ?>
                                            </td>
                                            <td>
                                                <select name="incoterm[]" id="incoterm" class="form-control bg-select">
                                                    <option value="">Pilih</option>
                                                    <option value="Ex work">Ex work (EXW-nama tempat penyerahan)</option>
                                                    <option value="Free Carrier">Free Carrier (FCA)</option>
                                                    <option value="Free on Board">Free on Board (FOB)</option>
                                                    <option value="Free Alongside Ship">Free Alongside Ship (FAS)</option>
                                                    <option value="Carrier Insurance Freight">Carrier Insurance Freight (CIF)</option>
                                                    <option value="Carrier insurance paid to">Carrier insurance paid to (CIP)</option>
                                                    <option value="Cost Freight">Cost Freight (CFR)</option>
                                                    <option value="Carriage paid to">Carriage paid to (CPT)</option>
                                                    <option value="Delivery Duty Paid">Delivery Duty Paid (DDP)</option>
                                                    <option value="Delivered at place">Delivered at place (DAP)</option>
                                                    <option value="Delivered at Terminal">Delivered at Terminal (DAT)</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="lokasi_incoterm[]" id="lokasi_incoterm" value="">
                                            </td>
                                            <td class="is_jas">
                                                <input type="number" max="100" class="form-control" name="pr_retention[]" id="pr_retention" value="">
                                            </td>
                                            <td>
                                                <select name="sumber_hps[]" id="sumber_hps" class="form-control">
                                                    <?php foreach ($sumber_hps as $k => $v) { ?>
                                                        <option value="<?= $v['value'] ?>"><?= $v['option'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value[2] ?>" name="hps[]" data-no="<?php echo $idnya ?>" class="subtotal_item">
                                                <?php echo inttomoney($value[2]) ?>

                                                <!-- <input type="text" id="hps<?= $idnya ?>" class="form-control" maxlength="40" name="hps[]" id="hps" onchange="chps('<?= $idnya ?>');" value=""> -->
                                            </td>
                                            <td>
                                                <input type="hidden" name="subtotalhps[]" id="subhps<?= $idnya ?>" value="<?php echo $value[1] * $value[0] ?>" class="hpss">
                                                <?php echo inttomoney($value[1] * $value[0]) ?>
                                            </td>

                                            <td class="is_ass">
                                                <input type="number" class="form-control" name="no_asset[]" id="no_asset" value="">
                                            </td>
                                            <td class="is_ass">
                                                <input type="number" class="form-control" name="sub_number[]" id="sub_number" value="">
                                            </td>

                                            <td>
                                                <select id="tax_code" name="tax_code[]" class="form-control">
                                                    <option value="" selected disabled>Pilih Tax Code</option>
                                                    <?php foreach ($tax_code as $k => $v): ?>
                                                        <option value="<?php echo $v['tax_code'] ?>" <?php echo $curval == $v['tax_code'] ? 'selected' : '' ?>><?php echo $v['tax_code'].' - '.$v['description'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td class="">
                                                <input type="date" class="form-control" name="pr_delivery_date[]" id="pr_delivery_date" value=<?= $value['ppis_delivery_date'] ?>>
                                            </td>
                                            <td>
                                                <input type="file" class"form-control bg-select" id="myfile" name="myfile[]">
                                            </td>
                                        </tr>

                                        <?php
                                        $subtotal += (int)str_replace(".", "", $value[2]) * $value['ppi_is_sap'];
                                        $subtotalhps += $value[1] * $value[0];
                                    }
                                } ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="row form-group mt-3">
                        <div class="col-sm-5">
                        </div>
                        <label class="col-sm-5 control-label text-right">Nilai Kontrak</label>
                        <div class="col-sm-2">
                            <p class="form-control-static text-right" id="total_hps"><?= inttomoney($subtotalhps) ?></p>
                            <input type="hidden" name="total_hps_inp" id="total_hps_inp">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-5">
                        </div>
                        <label class="col-sm-5 control-label text-right">Total RAB</label>
                        <div class="col-sm-2">
                            <p class="form-control-static text-right" id="total_alokasi"> <?php echo inttomoney($subtotal) ?></p>
                            <input type="hidden" name="total_alokasi_inp" id="total_alokasi_inp" value="<?php echo $subtotal ?>">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

function chps(a) {
    let hps = $('#hps'+a).val()
    let qty = $('#qty'+a).val()

    $('#subhps'+a).val(hps*qty)
    $('#subtotal_hps'+a).html(hps*qty)

    var nn2=[];
    $(`.hpss`).each(function(){
        if($(this).val() != ''){
            nn2.push($(this).val())
        }
    });

    let sum2 = 0;
    for (var k = 0; k < nn2.length; k++) {sum2 += parseInt(nn2[k])}

    $('#total_hps').html(sum2)
    $('#total_hps_inp').val(sum2)
}

function set_total() {

    var total_alokasi = 0;
    var total_alokasi_header = 0;
    var sub_hps = 0;

    $("#item_table tr").each(function() {

        var item = (!isNaN($(this).find(".harga_satuan_item").val())) ? parseFloat($(this).find(".harga_satuan_item").val()) : 0;
        var qty = (!isNaN($(this).find(".jumlah_item").val())) ? parseFloat($(this).find(".jumlah_item").val()) : 0;
        var subtotal = (!isNaN($(this).find(".subtotal_item").val())) ? parseFloat($(this).find(".subtotal_item").val()) : 0;
        var total_hps = ($(this).find(".subtotal_hps").val()) ? $(this).find(".subtotal_hps").val() : 0;

        total_alokasi += (item * qty);
        sub_hps += parseFloat(total_hps);
    });

    var total_pagu = parseFloat($("#total_pagu_inp").val());
    var sisa_pagu_awal = parseFloat($("#sisa_pagu_awal_inp").val());
    var sisa_pagu = parseFloat(sisa_pagu_awal) - parseFloat(total_alokasi);

    $("#total_alokasi").text(inttomoney(total_alokasi));
    $("#total_alokasi_header").text(inttomoney(total_alokasi));
    $("#total_alokasi_inp").val(total_alokasi);
    $("#total_hps").text(inttomoney(sub_hps));
    $("#total_hps_inp").val(sub_hps);

    $("#sisa_pagu").text(inttomoney(sisa_pagu));
    $("#sisa_pagu_inp").val(sisa_pagu);

}

$(document).ready(function() {

    var item_int_btn_url = "<?php echo site_url('procurement/get_picker_sumberdaya_sap') ?>";

    if ($('#kode_spk').val() != '') {
        $('#item_int_btn').attr('data-url', item_int_btn_url + "?spk_code=" + $("#kode_spk").val())
    }

    // ajax header
    function check_plan_tender() {
        var id = $("#perencanaan_pengadaan_inp").val();
        var url = "<?php echo site_url('Procurement/data_perencanaan_pengadaan') ?>";
        var spk_code = "";
        $.ajax({
            url: url + "?id=" + id,
            dataType: "json",
            success: function(data) {
                console.log(data);
                var mydata = data.rows[0];
                $('#item_int_btn').attr('data-url', item_int_btn_url)
                $("#nama_pekerjaan_inp").val(mydata.ppm_project_id + " - " + mydata.ppm_subject_of_work);
                $("#spk_code_inp").val(mydata.ppm_project_id)
                $("#kode_spk").val(mydata.ppm_project_id);
                $("#ppm_id").val(mydata.ppm_id);
                $("#deskripsi_pekerjaan").val(mydata.ppm_scope_of_work);
                $("#mata_anggaran").text(mydata.ppm_mata_anggaran + " - " + mydata.ppm_nama_mata_anggaran);
                if (mydata.ppm_sub_mata_anggaran == 0) {
                    getProjectCost(id);
                } else {
                    var sub_mata_anggaran = mydata.ppm_sub_mata_anggaran + " - " + mydata.ppm_nama_sub_mata_anggaran;
                    $("#sub_mata_anggaran").html(sub_mata_anggaran);
                }

                $("#pagu_anggaran,#total_pagu").text(mydata.ppm_pagu_anggaran);
                $("#sisa_anggaran,#sisa_pagu").text(mydata.ppm_sisa_anggaran);
                $("#total_pagu_inp").val(moneytoint(mydata.ppm_pagu_anggaran));
                $("#total_sisa_inp,#sisa_pagu_awal_inp").val(moneytoint(mydata.ppm_sisa_anggaran));
                $('#item_int_btn').attr('data-url', item_int_btn_url + "?spk_code=" + $("#kode_spk").val())

                if (mydata.ppm_is_integrated == 1) {
                    $('.not_integrated').hide();
                    $('.integrated').show();
                } else {
                    $('.integrated').hide();
                    $('.not_integrated').show();
                }

                if (mydata.ppm_kode_rencana != null) {
                    $.ajax({
                        url: "<?php echo site_url('Procurement/daftar_paket_pengadaan') ?>" + "?program_code=" + mydata.ppm_kode_rencana,
                        dataType: "json",
                        success: function(data) {
                            var drpdownhtml = "";
                            $.each(data.rows, function(i, val) {

                                drpdownhtml += "<option value='" + val.pps_paket_pengadaan_name + "'>" + val.pps_paket_pengadaan_name + "</option>";

                            });
                            var selecthtml = "<select class='form-control' name='nama_paket' id='nama_paket' required='true'>" + drpdownhtml + "</select>";
                            $('#nama_paket_div').html(selecthtml);
                            $('#nama_paket_div').removeClass("col-sm-8");
                            $('#nama_paket_div').addClass("col-sm-5");
                        }
                    })


                } else {
                    var htmlnamapr = "<input type='text' class='form-control' name='nama_paket' id='nama_paket' required='true' value='<?php echo $curval ?>'>";
                    $('#nama_paket_div').html(htmlnamapr);
                    $('#nama_paket_div').removeClass("col-sm-5");
                    $('#nama_paket_div').addClass("col-sm-8");
                }
            }
        });
    }

    function getProjectCost(id) {

        $.ajax({
            url: "<?php echo site_url('Procurement/perencanaan_pengadaan/get_project_cost') ?>" + "?ppm_id=" + id,
            dataType: "json",
            success: function(data) {
                var mata_anggaran = "";
                $.each(data.rows, function(i, val) {

                    mata_anggaran += val.coa_code + " " + val.coa_name + "<br/>";

                });

                $("#sub_mata_anggaran").html(mata_anggaran);
            }
        })
    }

    $(document.body).on("change", "#perencanaan_pengadaan_inp", function() {

        check_plan_tender();

    });

    $('.int_item').css('display', 'none');

    var uri_pp = '<?php echo site_url('Procurement/periode_pengadaan_picker') ?>';

    if ($('#kode_spk').val() == '') {
        $('.int_item').css('display', 'none');
        $('.not_integrated').show();
        $('.integrated').hide();
    } else {
        $('.integrated').show();
        $('.not_integrated').hide();
        $('.int_item').css('display', '');
    }

    $(document.body).on("change", "#kode_item", function() {

        var id = $(this).val();
        var url = "<?php echo site_url('Procurement/get_item_perencanaan_sap') ?>";

        if ($('#kode_spk').val() == '') {
            $('.int_item').css('display', 'none');
            $.ajax({
                url: url + "?id=" + id,
                dataType: "json",
                success: function(data) {
                    var mydata = data.rows[0];
                    $('#harga_satuan_item_inp').attr('disabled', false);
                    $("#deskripsi_item").html(mydata.short_description);
                    $("#deskripsi_pekerjaan").html(mydata.ppm_scope_of_work);
                    $("#jumlah_item_inp").val(1);
                    $("#satuan_item_inp").val(mydata.uom);
                    $("#harga_satuan_item_inp").val(mydata.total_price);
                    $("#pr_number_sap").val(mydata.ppis_pr_number);
                    $("#pr_item_sap").val(mydata.ppis_pr_item);
                    $("#pr_type_sap").val(mydata.ppis_pr_type);
                }
            });
        } else {
            //function delay
            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            $.ajax({
                url: url + "?id=" + id + "&spk_code=" + $('#kode_spk').val() + "&",
                dataType: "json",
                cache: false,
                success: function(data) {
                    $('.int_item').css('display', '');
                    var mydata = data.rows[0];
                    console.log(mydata);
                    $('#harga_satuan_item_inp').attr('disabled', 'disabled');
                    $("#deskripsi_item").html(mydata.smbd_name);
                    $('#max_volume').html("<span id='max'><i>batas max " + parseFloat(mydata.ppv_remain).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 8
                    }) + " " + mydata.unit + "</i></span>");
                    $("#jumlah_item_inp").val(1);
                    $("#satuan_item_inp").val(mydata.unit);
                    $("#harga_satuan_item_inp").val(mydata.price);
                    $("#pr_number_sap").val(mydata.ppis_pr_number);
                    $("#pr_item_sap").val(mydata.ppis_pr_item);
                    $("#pr_type_sap").val(mydata.ppis_pr_type);
                    $("#jumlah_item_inp").on('keyup', function(e) {
                        delay(function() {

                            $.ajax({
                                url: "<?php echo site_url('Procurement/get_volume') ?>" + "?smbd_code=" + $('#kode_item').val() + "&spk_code=" + $('#kode_spk').val(),
                                dataType: 'json',
                            })
                            .done(function(data_vol) {
                                var data_vol = data_vol.rows[0];
                                var vol_remain = data_vol.ppv_remain;
                                if (parseFloat(($("#jumlah_item_inp").val()).replace(/\./g, '')) > parseFloat(vol_remain)) {
                                    alert("Jumlah tidak boleh lebih dari " + vol_remain + ' ' + $("#satuan_item_inp").val());
                                    $("#jumlah_item_inp").val(1);
                                    $("#jumlah_item_inp").focus();
                                }

                            })
                            .fail(function() {
                                console.log("error");
                            })


                        }, 500);
                    });
                    return false;
                }
            });

        }

    });

    $(".action_item").click(function() {

        var url_file = '<?php echo site_url("log/download_attachment/contract/milestone/") ?>';
        var current_item = $("#current_item").val();
        var no = current_item;

        if (current_item == "") {
            if (getMaxDataNo(".edit_item") == null) {
                no = 1;
            } else {
                no = getMaxDataNo(".edit_item") + 1;
            }
        }

        var kode = $("#kode_item").val();
        var max_notif = $('#max_volume').html();
        var deskripsi = $("#deskripsi_item").text();
        var jumlah = $("#jumlah_item_inp").val();
        var satuan = $("#satuan_item_inp").val();
        var harga_satuan = $("#harga_satuan_item_inp").val();
        var jumlah_int = $("#jumlah_item_inp").autoNumeric('get');
        var harga_satuan_int = $("#harga_satuan_item_inp").autoNumeric('get');

        var incoterm = $('#incoterm').val();
        var lokasi_incoterm = $('#lokasi_incoterm').val();
        var sumber_hps = $('#sumber_hps').val();
        var hps = $('#hps').val();
        var hps_int = $('#hps').autoNumeric('get');
        var doc_attachment_inp_ = $('#doc_attachment_inp_').val();
        var no_asset = $('#no_asset').val();
        var sub_number = $('#sub_number').val();
        var tax_code = $('#tax_code').val();
        var pr_retention = $('#pr_retention').val();

        var pr_number_sap = $("#pr_number_sap").val();
        var pr_item_sap = $("#pr_item_sap").val();
        var pr_type_sap = $("#pr_type_sap").val();

        if (kode === '' || jumlah === '' || harga_satuan === '' || incoterm === '' || lokasi_incoterm === '' || sumber_hps === '' ||
        hps === '') {
            alert("Semua input mandarory (*) harus diisi!");
            return false;
        }

        if (harga_satuan_int < 1) {

            alert("Harga tidak boleh kurang dari 1");

        } else if (jumlah_int < 1) {

            alert("Jumlah tidak boleh kurang dari 1");

        } else {
            let tppo = $('#tppo').val()
            var subtotal_hps = parseFloat(hps_int) * parseFloat(jumlah_int);
            var subtotal_hps_int = subtotal_hps;
            subtotal_hps = inttomoney(subtotal_hps);

            var x = parseFloat(jumlah_int) * parseFloat(harga_satuan_int);
            var subtotal = inttomoney(x);
            harga_satuan = inttomoney(harga_satuan_int);

            var html = "<tr>";
            html += "<td class='text-center'>" + no + "</td>";
            html += "<td><input type='hidden' class='kode_item' data-no='" + no + "' name='item_kode[" + no + "]' value='" + kode + "'/>" + kode + "</td>";
            html += "<td><input type='hidden' class='deskripsi_item' data-no='" + no + "' name='item_deskripsi[" + no + "]' value='" + deskripsi + "'/>" + deskripsi + "</td>";

            html += "<td><input type='hidden' class='item_po' data-no='" + (no * 10) + "' name='item_po[" + no + "]' value='" + (no * 10) + "'/>" + (no * 10) + "</td>";

            html += "<td><input type='hidden' class='pr_number_sap' data-no='" + no + "' name='pr_number_sap[" + no + "]' value='" + pr_number_sap + "'/>" + pr_number_sap + "</td>";
            html += "<td><input type='hidden' class='pr_item_sap' data-no='" + no + "' name='pr_item_sap[" + no + "]' value='" + pr_item_sap + "'/>" + pr_item_sap + "</td>";
            html += "<td><input type='hidden' class='pr_type_sap' data-no='" + no + "' name='pr_type_sap[" + no + "]' value='" + pr_type_sap + "'/>" + pr_type_sap + "</td>";

            html += "<td class='text-right'><input type='hidden' class='max_item' data-no='" + no + "' name='max_item[" + no + "]' value='" + max_notif + "'/> <input type='hidden' class='jumlah_item' data-no='" + no + "' name='item_jumlah[" + no + "]' value='" + jumlah_int + "'/>" + jumlah + "</td>";
            html += "<td><input type='hidden' class='satuan_item' data-no='" + no + "' name='item_satuan[" + no + "]' value='" + satuan + "'/>" + satuan + "</td>";
            html += "<td class='text-right'><input type='hidden' class='harga_satuan_item' data-no='" + no + "' name='item_harga_satuan[" + no + "]' value='" + harga_satuan_int + "'/>" + harga_satuan + "</td>";
            html += "<td class='text-right'><input type='hidden' class='subtotal_item' data-no='" + no + "' name='item_subtotal[" + no + "]' value='" + x + "'/>" + subtotal + "</td>"

            html += "<td><input type='hidden' class='incoterm' data-no='" + no + "' name='incoterm[" + no + "]' value='" + incoterm + "'/>" + incoterm + "</td>";
            html += "<td><input type='hidden' class='lokasi_incoterm' data-no='" + no + "' name='lokasi_incoterm[" + no + "]' value='" + lokasi_incoterm + "'/>" + lokasi_incoterm + "</td>";

            if (tppo == "JASA") {
                html += "<td><input type='hidden' class='pr_retention' data-no='" + no + "' name='pr_retention[" + no + "]' value='" + pr_retention + "'/>" + pr_retention + "</td>";
            }

            html += "<td><input type='hidden' class='sumber_hps' data-no='" + no + "' name='sumber_hps[" + no + "]' value='" + sumber_hps + "'/>" + sumber_hps + "</td>";
            html += "<td><input type='hidden' class='hps' data-no='" + no + "' name='hps[" + no + "]' value='" + hps_int + "'/>" + inttomoney(hps_int) + "</td>";

            html += "<td><input type='hidden' class='subtotal_hps' data-no='" + no + "' name='subtotal_hps[" + no + "]' value='" + subtotal_hps_int + "'/>" + subtotal_hps + "</td>";

            if (tppo == "ASSET") {
                html += "<td><input type='hidden' class='no_asset' data-no='" + no + "' name='no_asset[" + no + "]' value='" + no_asset + "'/>" + no_asset + "</td>";
                html += "<td><input type='hidden' class='sub_number' data-no='" + no + "' name='sub_number[" + no + "]' value='" + sub_number + "'/>" + sub_number + "</td>";
            }

            html += "<td><input type='hidden' class='tax_code' data-no='" + no + "' name='tax_code[" + no + "]' value='" + tax_code + "'/>" + tax_code + "</td>";

            html += "<td><input type='hidden' class='doc_attachment_inp_' data-no='" + no + "' name='doc_attachment_inp_[" + no + "]' value='" + doc_attachment_inp_ + "'/><a href='"+url_file+doc_attachment_inp_+"'>"+doc_attachment_inp_+"</a></td>";

            html += "<td><button type='button' class='btn btn-info btn-sm edit_item' data-no='" + no + "'><i class='fa fa-edit'></i></button></td>";
            html += "</tr>";

            $("#item_table").append(html);
            $("#kode_item").val("");
            $("#deskripsi_item").text("");
            $("#max_volume").html("");
            $("#jumlah_item_inp").val("");
            $("#satuan_item_inp").val("");
            $("#harga_satuan_item_inp").val("");
            $("#current_item").val("");

            $("#kode_item").val("");
            $('#nama_sumberdaya').text("");
            $('#incoterm').val("");
            $('#lokasi_incoterm').val("");
            $('#sumber_hps').val("");
            $('#hps').val("");
            $('#doc_attachment_inp_').val("");
            $('#no_asset').val("");
            $('#sub_number').val("");
            $('#tax_code').val("");
            $('#pr_retention').val("");

            $("#pr_number_sap").val("");
            $("#pr_item_sap").val("");
            $("#pr_type_sap").val("");
        }

        set_total();

        if ($('#sisa_pagu_inp').val() < 0) {
            $('#sisa_pagu').css({
                "font-weight": 'bold',
                "color": 'red'
            });
        } else {
            $('#sisa_pagu').removeAttr('style')
        }

        $('.edit_item').click(function() {
            $('#sisa_pagu').removeAttr('style')

        })
        $('[data-toggle="popover"]').popover();
    });

    $(document.body).on("click", ".empty_item", function() {
        $('#max_volume').html('');
        $("#current_item").val("");
        $("#kode_item").val("");
        $("#deskripsi_item").text("");
        $("#jumlah_item_inp").val("");
        $("#satuan_item_inp").val("");
        $("#harga_satuan_item_inp").val("");

        $('#incoterm').val("");
        $('#lokasi_incoterm').val("");
        $('#sumber_hps').val("");
        $('#hps').val("");
        $('#doc_attachment_inp_').val("");
        $('#no_asset').val("");
        $('#sub_number').val("");
        $('#tax_code').val("");
        $('#pr_retention').val("");

        $("#pr_number_sap").val("");
        $("#pr_item_sap").val("");
        $("#pr_type_sap").val("");

        // cek_group();

    });

    function cek_group() {

        var no = parseInt($("#item_table tr").length);

        if (no == 1) {
            $.ajax({
                url: "<?php echo site_url('procurement/set_session/code_group/') ?>",
                success: function() {

                }
            })
        }

    }

    $(document.body).on("click", ".edit_item", function() {
        var no = $(this).attr('data-no');
        max_notif_item = $(".max_item[data-no='" + no + "']").val();
        $('#max_volume').html(max_notif_item);
        var kode = $(".kode_item[data-no='" + no + "']").val();
        var deskripsi = $(".deskripsi_item[data-no='" + no + "']").val();
        var jumlah = $(".jumlah_item[data-no='" + no + "']").val();
        var satuan = $(".satuan_item[data-no='" + no + "']").val();
        var harga_satuan = $(".harga_satuan_item[data-no='" + no + "']").val();

        var incoterm = $(".incoterm[data-no='" + no + "']").val();
        var lokasi_incoterm = $(".lokasi_incoterm[data-no='" + no + "']").val();
        var sumber_hps = $(".sumber_hps[data-no='" + no + "']").val();
        var hps = $(".hps[data-no='" + no + "']").val();
        var hps_int = $(".hps[data-no='" + no + "']").val();
        var doc_attachment_inp_ = $(".doc_attachment_inp_[data-no='" + no + "']").val();
        var no_asset = $(".no_asset[data-no='" + no + "']").val();
        var sub_number = $(".sub_number[data-no='" + no + "']").val();
        var tax_code = $(".tax_code[data-no='" + no + "']").val();
        var pr_retention = $(".pr_retention[data-no='" + no + "']").val();
        var pr_number_sap = $(".pr_number_sap[data-no='" + no + "']").val();
        var pr_item_sap = $(".pr_item_sap[data-no='" + no + "']").val();
        var pr_type_sap = $(".pr_type_sap[data-no='" + no + "']").val();
        // var item_po = $(".item_po[data-no='" + no + "']").val();


        $("#current_item").val(no);
        $("#kode_item").val(kode);
        $("#deskripsi_item").text(deskripsi);
        $("#jumlah_item_inp").val(inttomoney(jumlah));
        $("#satuan_item_inp").val(satuan);
        $("#harga_satuan_item_inp").val(inttomoney(harga_satuan));

        $('#incoterm').val(incoterm);
        $('#lokasi_incoterm').val(lokasi_incoterm);
        $('#sumber_hps').val(sumber_hps);
        $('#hps').val(hps);
        $('#doc_attachment_inp_').val(doc_attachment_inp_);
        $('#no_asset').val(no_asset);
        $('#sub_number').val(sub_number);
        $('#tax_code').val(tax_code);
        $('#pr_retention').val(pr_retention);

        $("#pr_number_sap").val(pr_number_sap);
        $("#pr_item_sap").val(pr_item_sap);
        $("#pr_type_sap").val(pr_type_sap);
        // $('#item_po').val(item_po);

        // cek_group();

        $(this).parent().parent().remove();

        set_total();

        return false;

    });

})

function isShowAddItem() {
    let iai = $('#perencanaan_pengadaan_inp').val()
    let tppo = $('#tppo').val()
    if ((tppo != '') && (iai != '')) {
        if (tppo != "ASSET") {
            $('.is_ass').addClass("hide")
        } else {
            $('.is_ass').removeClass("hide")
        }
        if (tppo == "JASA") {
            $('.is_jas').removeClass("hide")
        } else {
            $('.is_jas').addClass("hide")
        }
    } else {
        alert('Proyek dan Jenis kontrak pada header harus dipilih')
        return false;
    }

    let kode = $('#kode_spk').val()
    if (kode != '') {
        $('.integrated').show();
        $('.not_integrated').hide();
        $('.int_item').css('display', '');
    }

    var div_add = document.getElementById("showAddItem");
    var div_btn = document.getElementById("showButtonItem");
    if (div_add.style.display !== "none") {
        div_add.style.display = "none";
    } else {
        div_add.style.display = "block";
    }

    if (div_btn.style.display !== "none") {
        div_btn.style.display = "none";
    } else {
        div_btn.style.display = "block";
    }
}
 </script>
