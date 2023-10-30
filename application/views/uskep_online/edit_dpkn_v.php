<style type="text/css">
    html{
        font-family:sans-serif;
    }
    table {
        font-size: 12px;
        border: 1px solid #fff
    }

    td {
        padding: 5px;
    }

    th {
        padding: 5px;
        font-weight: bold;
        /*background-color: #b0ffc2;*/
        background-color: #e6e7e8;
    }

    p{
        font-size:10px;
    }

    #table-content {
        font-size: 40%;
    }

    .is-content {
        border-collapse: collapse;
    }

    .is-content td {
        border: 1px solid black;
    }

    .is-content th {
        border: 1px solid black;
    }
    .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 10px;
    }
    .table td {
        line-height: 15px;
    }
    .table th, .table td {
        vertical-align: middle;
        word-break: break-all;
    }
    .bt-custom {
        border-top: 1px solid #a7a7a7 !important;
    }
    .form_header {
        border-radius: 5px;
        width: 90%;
        height: 35px;
        border: 1px solid gray;
        background-color: #fff;
    }

    .hidden{
        display: none;
    }

    .wrapper-progressBar {
        width: 100%
    }

    .progressBar {
    }

    .progressBar li {
        list-style-type: none;
        float: left;
        width: 33%;
        position: relative;
        text-align: center;
    }

    .progressBar li:before {
        content: " ";
        line-height: 30px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        border: 1px solid darkgray;
        display: block;
        text-align: center;
        margin: 0 auto 10px;
        background-color: white
    }

    .progressBar li:after {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: #ddd;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressBar li:first-child:after {
        content: none;
    }

    .progressBar li.active {
        color: dodgerblue;
    }

    .progressBar li.active:before {
        border-color: dodgerblue;
        background-color: dodgerblue
    }

    .progressBar li.active + li:after {
        background-color: dodgerblue;
    }

    .bold {
        font-weight: bold;
    }

    .sat_form {
        width: 60px;
    }

    .vol_form {
        width: 120px;
    }
    .long_form {
        width: 200px;
    }

</style>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="wrapper-progressBar">
                <ul class="progressBar">
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN SISTEM PENILAIAN</b></p></li>
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI</b></p></li>
                    <li class=""><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PEMENANG</b></p></li>
                </ul>
            </div>
        </div>
    </div>

    <br>
    <!-- <br>
    <center class="mt-3">
    	<p style="margin:0px;font-size:14px;"><b>DOKUMEN SISTEM PENILAIAN</b></p>
    </center>
    <br> -->
    <!-- <span class=" m-2 btn btn-primary" id="ajax_submit">Submit</span> -->

    <form method="post" action="<?php echo site_url($controller_name."/submit_dpkn");?>"  class="form-horizontal ajaxform">

        <div class="row">
            <div class="col-sm-12 table-responsive">
                <table style="width: 100%" class="table-striped" id="tbl_dpkn">
                    <tr>
                        <th colspan="6" rowspan="2"></th>
                        <th colspan="<?php echo $import['span'] ?>" class="text-center">PENYEDIA</th>
                    </tr>
                    <tr>
                        <input type="hidden" name="rfq_no" value="<?php echo $import['rfq'] ?>">
                        <input type="hidden" name="kode_spk" value="<?php echo $import['kode_spk'] ?>">
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <th rowspan="3" colspan="2"><?php echo $v['vendor_name'] ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th colspan="2">Paket Pengadaan</th>
                        <th colspan="4"><?php echo $import['pengadaan'] ?> <input type="hidden" name="Pengadaan" value="<?php echo $import['pengadaan'] ?>"> </th>
                    </tr>
                    <tr>
                        <th colspan="2">Proyek</th>
                        <th colspan="4"><?php echo $import['proyek'] ?> <input type="hidden" name="proyek" value="<?php echo $import['code_proyek'] ?>"> </th>
                    </tr>
                    <tr><th colspan="6"></th><th colspan="<?php echo $import['span'] ?>"></th></tr>
                    <tr class="bg-blue">
                        <th>1</th>
                        <th colspan="5">DATA PENYEDIA</th>
                        <th colspan="<?php echo $import['span'] ?>"></th>
                    </tr>
                    <tr>
                        <td>1.1</td>
                        <td colspan="5">Alamat</td>
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <input type="hidden" name="vendor_list[]" value="<?php echo $v['vendor_id'] ?>">
                            <td colspan="2"><?php echo $v['address_street'] ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>1.2</td>
                        <td colspan="5">Kontak Personal</td>
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <td colspan="2"><?php echo $v['contact_name'] ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>1.3</td>
                        <td colspan="5">No. Telpon / Fax</td>
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <td colspan="2"><?php echo $v['contact_phone_no'] ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>1.4</td>
                        <td colspan="5">Penawaran No. / Tanggal</td>
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <td colspan="2"><input type="text" class="" name="penawaran_tgl[]" value="<?php echo $tgl_penawaran[$key] ?>"></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>1.5</td>
                        <td colspan="5">BA Klarifikasi dan Negosiasi Tgl</td>
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <td colspan="2"><input type="text" class="" name="klarifikasi_nego[]" value="<?php echo $klarifikasi_nego[$key] ?>"></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr><th colspan="6"></th><th colspan="<?php echo $import['span'] ?>"></th></tr>
                    <tr>
                        <th>2</th>
                        <th colspan="3">DATA PEKERJAAN / SPESIFIKASI <span class=" ml-2 btn-sm btn btn-info" onclick="add_penawaran('<?php echo count($import['vendor']) ?>')"><i class="ft ft-plus"></i></span></th>
                        <th colspan="2">RABP (IDR)</th>
                        <th colspan="<?php echo $import['span'] ?>"></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>SAT</th>
                        <th>VOLUME</th>
                        <th>H. Satuan</th>
                        <th>Harga</th>
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <th>H. Satuan</th>
                            <th>Harga</th>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="bold">
                        <td>A).</td>
                        <td colspan="4">Penawaran</td>
                        <td></td>
                        <td colspan="<?php echo $import['span'] ?>"></td>
                    </tr>
                    <?php foreach ($poin_penawaran as $k => $va): ?>
                        <<tr id="pen_p<?= $k ?>">
                            <td>
                                <span class="btn-sm btn btn-danger" onclick="remove_count(pen_p<?= $k ?>, 'p<?= $k ?>', <?= count($import['vendor'])?>);"><i class="ft ft-trash"></i></span>
                            </td>
                            <td>
                                <input type="text" class="vol_form" name="text_pen[]" onchange="change_nego_text('ch_pen_text_p<?= $k ?>', 'p<?= $k ?>')" id="ch_pen_text_p<?= $k ?>" value="<?php echo $va->poin ?>" required>
                            </td>
                            <td>
                                <input type="text" class="sat_form" name="sat_pen[]" onchange="change_nego_sat('ch_pen_sat_p<?= $k ?>', 'p<?= $k ?>')" id="ch_pen_sat_p<?= $k ?>" value="<?php echo $va->satuan ?>" required>
                            </td>
                            <td>
                                <input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" name="vol_pen[]" onchange="change_nego_vol('ch_pen_vol_p<?= $k ?>', 'p<?= $k ?>',<?= count($import['vendor'])?>)" id="ch_pen_vol_p<?= $k ?>" value="<?php echo $va->volume ?>" required>
                            </td>
                            <td>
                                <input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" onchange="count_harga('penhrgsatp<?= $k ?>', 'p<?= $k ?>')" id="penhrgsatp<?= $k ?>" name="hrg_sat_pen[]" value="<?php echo $va->harga_satuan ?>" required>
                            </td>
                            <td>
                                <input type="text" class="vol_form totpen" name="harga_pen[]" id="penhrgp<?= $k ?>" value="<?php echo $va->total_harga ?>" readonly>
                            </td>

                            <?php foreach ($import['vendor'] as $id => $val): ?>
                                <td>
                                    <input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" onchange="count_harga_vend('penhrgsat<?= $id ?>p<?= $k ?>', 'p<?= $k ?>', <?= $id ?>)" id="penhrgsat<?= $id ?>p<?= $k ?>" name="hrg_sat_pen_vend_<?= $id ?>[]" value="<?php echo $va->vendor_sat[$id] ?>" required>
                                </td>
                                <td>
                                    <input type="text" class="vol_form total<?= $id ?>" name="harga_pen_vend_<?= $id ?>[]" value="<?php echo $va->vendor_hrg[$id] ?>" id="penhrg<?= $id ?>p<?= $k ?>" readonly>
                                </td>
                            <?php endforeach; ?>

                        </tr>
                    <?php endforeach; ?>
                    <tbody id="tr_penawaran"></tbody>
                    <tr>
                        <th></th>
                        <th>TOTAL</th>
                        <th colspan="2"></th>
                        <th colspan="2" id="totpen1" class="text-right"><?php echo $total_rab ?></th>
                        <input type="hidden" name="total_rbap" value="<?php echo $total_rab ?>" id="total_rbap" />
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <input type="hidden" name="total_ppen[]" value="<?php echo $total_penawaran_vendor[$key] ?>" id="total_ppen<?= $key; ?>" />
                            <th colspan="2" id="tot_pen_vend<?= $key; ?>" class="text-right"><?php echo $total_penawaran_vendor[$key] ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="bold">
                        <td>B).</td>
                        <td>Negosiasi</td>
                        <td></td>
                        <td colspan="<?php echo $import['span'] ?>"></td>
                    </tr>
                    <?php foreach ($poin_negosiasi as $k => $va): ?>
                        <tr class="sub_pen_p<?= $k ?>">
                            <td>-</td>
                            <td><input type="text" class="vol_form" name="text_nego[]" value="<?php echo $va->poin ?>" id="p<?= $k ?>_nego_text" readonly></td>
                            <td><input type="text" class="sat_form" name="sat_nego[]" value="<?php echo $va->satuan ?>" id="p<?= $k ?>_nego_sat" readonly></td>
                            <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form" name="vol_nego[]" id="p<?= $k ?>_nego_vol" value="<?php echo $va->volume ?>" readonly></td>
                            <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form" id="negohrgsatp<?= $k ?>" name="hrg_sat_nego[]" value="<?php echo $va->harga_satuan ?>" readonly></td>
                            <td><input type="text" class="vol_form totneg" name="harga_nego[]" id="negohrgp<?= $k ?>" value="<?php echo $va->total_harga ?>" readonly></td>

                            <?php foreach ($import['vendor'] as $id => $value): ?>
                                <td>
                                    <input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" onchange="count_harga_vend_nego('negohrgsat<?= $id ?>p<?= $k ?>', 'p<?= $k ?>', <?= $id ?>)" id="negohrgsat<?= $id ?>p<?= $k ?>" name="hrg_sat_nego_vend_<?= $id ?>[]" value="<?php echo $va->vendor_sat[$id] ?>" required>
                                </td>
                                <td><input type="text" class="vol_form totalnego<?= $id ?>" name="harga_nego_vend_<?= $id ?>[]" value="<?php echo $va->vendor_hrg[$id] ?>" id="negohrg<?= $id ?>p<?= $k ?>" readonly></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tbody id="tr_nego"></tbody>
                    <tr>
                        <th></th>
                        <th>TOTAL</th>
                        <th colspan="2"></th>
                        <th colspan="2" id="totnego1" class="text-right"><?php echo $total_rab ?></th>
                        <?php foreach ($import['vendor'] as $key => $v): ?>
                            <input type="hidden" name="total_ppeneg[]" value="<?php echo $total_negosiai_vendor[$key] ?>" id="total_ppeneg<?= $key; ?>" />
                            <th colspan="2" id="tot_nego_vend<?= $key; ?>" class="text-right"><?php echo $total_negosiai_vendor[$key] ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr><th colspan="6"></th><th colspan="<?php echo $import['span'] ?>"></th></tr>
                    <tr>
                        <th>3</th>
                        <th colspan="3">KLARIFIKASI <span class="ml-2 btn-sm btn btn-info" onclick="add_klarifikasi('<?php echo count($import['vendor']) ?>')"><i class="ft ft-plus"></i></span></th>
                        <th colspan="2"></th>
                        <th colspan="<?php echo $import['span'] ?>"></th>
                    </tr>
				<?php foreach ($klarifikasi as $k => $v): ?>
                        <tr id="klar_a<?= $k ?>">
                            <td><span class="btn-sm btn btn-danger"  onclick="remove_elem(klar_a<?= $k ?>);"><i class="ft ft-trash"></i></span></td>
                            <td colspan="3"><input type="text" name="poin_klarifikasi[]" value="<?php echo $v->poin ?>" required></td>
                            <td colspan="2"><input type="text" name="klar_rabp[]" value="<?php echo $v->rabp ?>" required></td>
                            <?php foreach ($v->vendor as $ke => $va): ?>
                                <td colspan="2"><input type="text" name="klar_per_vend<?= $ke ?>[]" value="<?php echo $v->vendor[$ke] ?>" required></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tbody id="tr_klatifikasi"></tbody>
                    <tr><th colspan="6"></th><th colspan="<?php echo $import['span'] ?>"></th></tr>
                    <tr>
                        <td colspan="12">Catatan Komisi Pengadaan <span class="ml-2 btn-sm btn btn-info" onclick="add_catatan()"><i class="ft ft-plus"></i></span></td>
                    </tr>
				<?php if (count($catatan) > 1): ?>
                        <?php foreach ($catatan as $k => $v): ?>
                            <tr id="note_n<?= $k ?>">
                            <td><span class="btn-sm btn btn-danger" onclick="remove_elem(note_n<?= $k ?>);"><i class="ft ft-trash"></i></span></td>
                            <td colspan="2"><input type="text" class="long_form" name="note[]" value="<?php echo $catatan[$k] ?>"></td>
                            <td colspan="9"></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tbody id="note_kom"></tbody>
                </table>
                <hr>
                <table style="width: 100%" class="table-striped" id="tbl_esign" border="1">
                    <tr>
                        <th colspan="3" class="ml-3">
                            <input type="hidden" name="keg_id" id="kegid" value="<?php echo $keg_id ?>">
                            E-Sign Kewenangan
                            <select style="width: 200px" class="ml-2 form_header" id="tipePlan" name="tipe_plan">
                                <option value="">Tipe Plan</option>
                                <option value="rkp" <?php echo $tipePlan == 'rkp' ? 'selected' : '' ?>>PROYEK</option>
                                <option value="rkap" <?php echo $tipePlan == 'rkap' ? 'selected' : '' ?>>NON PROYEK</option>
                                <option value="rkp_matgis" <?php echo $tipePlan == 'rkp_matgis' ? 'selected' : '' ?>>MATGIS</option>
                            </select>
                            <select style="width: 200px" class="ml-2 form_header" id="komisi" name="komisi_">
                                <option value="">Komisi</option>
                                <option value="PUSAT" <?php echo $komisi == 'PUSAT' ? 'selected' : '' ?>>PUSAT</option>
                                <option value="DIVISI" <?php echo $komisi == 'DIVISI' ? 'selected' : '' ?>>DIVISI</option>
                                <option value="PROYEK" <?php echo $komisi == 'PROYEK' ? 'selected' : '' ?>>PROYEK</option>
                            </select>
                            <select style="width: 200px" class="ml-2 form_header" id="tipeProyek" name="tipe_proyek">
                                <option value="">Tipe Proyek</option>
                                <option value="KECIL" <?php echo $tipeProyek == 'KECIL' ? 'selected' : '' ?>>KECIL</option>
                                <option value="MENENGAH" <?php echo $tipeProyek == 'MENENGAH' ? 'selected' : '' ?>>MENENGAH</option>
                                <option value="BESAR" <?php echo $tipeProyek == 'BESAR' ? 'selected' : '' ?>>BESAR</option>
                            </select>
                            <!-- <span id="addesign" class="ml-2 btn-sm btn btn-info hidden" onclick="add_esign()"><i class="ft ft-plus"></i></span> -->
                        </th>
                        <!-- <th colspan="3"></th> -->
                    </tr>
                    <tbody id="tr_esign">

                        <tr>
                            <td colspan="7" align="center"><b>Komisi Pengadaan <?php echo $komisi ?> (<?php echo $tipeProyek ?>)</b></td>
                        </tr>
                        <tr>
                            <th align="center">No</th>
                            <th>Nama</th>
                            <th>Fungsi Bidang</th>
                            <th>Posisi</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Tanda Tangan</th>
                        </tr>
                        <?php foreach ($esign[0] as $k => $v): ?>
                            <tr>
                                <td align="center"><?= $k + 1?></td>
                                <td style="width: 300px; text: white;">
									<input class="form-control" type="text" name="nm_kew[]" value="<?php echo $val_esign->nm_kew[$k] ?>" /readonly>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="fungsi_bidang[]" value="<?php echo $val_esign->fungsi_bidang[$k] ?>" /readonly>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="job_title[]" value="<?php echo $val_esign->job_title[$k] ?>" /readonly>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="kategori[]" value="<?php echo $val_esign->kategori[$k] ?>" /readonly>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="posisi[]" value="<?php echo $val_esign->posisi[$k] ?>" /readonly>
                                </td>
                                <td >......................</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
					<input type="hidden" name="edit_f" value="1">
                </table>
            </div>
        </div>

        <div id="required" class="card">
            <div class="card-content">
                <div class="card-body">
                    <?php echo buttonsubmit('#',lang('back'),lang('save')) ?>
                </div>
            </div>
        </div>

    </form>

</div>

<script>

    $(`#tipePlan`).on('change', function() {
        var attr = $(`#tipeProyek`).attr('name');
        if (typeof attr !== 'disabled') {
            $(`#tipeProyek`).attr('disabled')
        }

        if (!$(`#required`).hasClass('hidden')) {
            $(`#required`).addClass('hidden')
        }

        $('#komisi').removeAttr('disabled');
    })

    $(`#komisi`).on('change', function() {
        $('#tipeProyek').removeAttr('disabled');

        if (!$(`#required`).hasClass('hidden')) {
            $(`#required`).addClass('hidden')
        }
    })

    $(`#tipeProyek`).on('change', function() {
        $(`#myLoader`).modal('show');
        console.log('start tipeProyek');

        let tipePlan = $(`#tipePlan`).val();
        let komisi = $(`#komisi`).val();
        let tipeProyek = $(this).val();
        let spk = $(`input[name=kode_spk]`).val()

        var kewenangan = `
        <tr>
            <td colspan="7" align="center"><b>Komisi Pengadaan ${komisi} (${tipeProyek})</b></td>
        </tr>
        <tr>
            <th align="center">No</th>
            <th>Nama</th>
            <th>Fungsi Bidang</th>
            <th>Posisi</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Tanda Tangan</th>
        </tr>`;

        $.ajax({
            url: '<?php echo site_url($controller_name."/check_kewenangan_dpkn");?>',
            method: 'post',
            data: {'komisi' : komisi, 'tipePlan':tipePlan, 'tipeProyek':tipeProyek, 'spk':spk},
            dataType: 'json',
            success: function(res) {
                setTimeout(function() {
					data = res[0]
                    $(`#kegid`).val(res[1])
                    $.each(data, function(i,v) {

                        opt_nm = `<option value="">Nama</option>`
                        $.each(v.nama, function(id, va) {
                            opt_nm += `<option value="${va}">${va}</option>`
                        })

                        kewenangan += `<tr><td align="center">${i+1}</td><td style="width: 300px; text: white;"><select class="form-control form_header select2" id="nmKew" name="nm_kew[]">${opt_nm}</select></td><td><input class="form-control" type="text" name="fungsi_bidang[]" value="${v.nm_fungsi_bidang}" /readonly></td><td><input class="form-control" type="text" name="job_title[]" value="${v.job_title}" /readonly></td><td><input class="form-control" type="text" name="kategori[]" value="${v.kategori}" /readonly></td><td><input class="form-control" type="text" name="posisi[]" value="${v.posisi}" /readonly></td><td >......................</td></tr>
                        `
                    })
                    $(`#required`).removeClass('hidden')

                    $(`#tr_esign`).html(kewenangan)
                    selectRefresh()
                    console.log('doneee');
                    $(`#myLoader`).modal('hide');
				}, 1000);
            }
        })
    })

    function prevent_letter(e, le) {
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(`.uang`).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            ;
        });
    }

    function selectRefresh() {
        $('#tbl_esign .select2').select2({
            tags: true,
            placeholder: "Pilih",
            allowClear: true,
            width: '100%'
        });
    }

    var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });

    function rand(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
        }
        return result;
    }

    function add_catatan() {
        var uniq = rand(3);

        let elem = `
        <tr id="note_${uniq}">
        <td><span class="btn-sm btn btn-danger" onclick="remove_elem(note_${uniq});"><i class="ft ft-trash"></i></span></td>
        <td colspan="2"><input type="text" class="long_form" name="note[]" value=""></td>
        <td colspan="9"></td>
        </tr>
        `
        $("#note_kom").append(elem);
    }

    function add_klarifikasi(vendor) {
        var uniq = rand(3);

        elem = ``
        for (var i = 0; i < parseInt(vendor); i++) {
            elem += `<td colspan="2"><input type="text" name="klar_per_vend${i}[]" value="" required></td>`
        }

        let html = `
        <tr id="klar_${uniq}">
            <td><span class="btn-sm btn btn-danger"  onclick="remove_elem(klar_${uniq});"><i class="ft ft-trash"></i></span></td>
            <td colspan="3"><input type="text" name="poin_klarifikasi[]" value="" required></td>
            <td colspan="2"><input type="text" name="klar_rabp[]" value="" required></td>
            ${elem}
        </tr>
        `
        $("#tr_klatifikasi").append(html);
    }

    function add_penawaran(vendor) {
        var uniq = rand(3);

        let pena = ''
        let nego = ''
        for (var i = 0; i < parseInt(vendor); i++) {
            pena += `
            <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" onchange="count_harga_vend('penhrgsat${i}${uniq}', '${uniq}', ${i})" id="penhrgsat${i}${uniq}" name="hrg_sat_pen_vend_${i}[]" value="" required></td>
            <td><input type="text" class="vol_form total${i}" name="harga_pen_vend_${i}[]" value="" id="penhrg${i}${uniq}" readonly></td>
            `
            nego += `
            <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" onchange="count_harga_vend_nego('negohrgsat${i}${uniq}', '${uniq}', ${i})" id="negohrgsat${i}${uniq}" name="hrg_sat_nego_vend_${i}[]" value="" required></td>
            <td><input type="text" class="vol_form totalnego${i}" name="harga_nego_vend_${i}[]" value="" id="negohrg${i}${uniq}" readonly></td>
            `
        }

        let cont_pena = `
            <tr id="pen_${uniq}">
                <td><span class="btn-sm btn btn-danger" onclick="remove_count(pen_${uniq}, '${uniq}', ${parseInt(vendor)});"><i class="ft ft-trash"></i></span></td>
                <td><input type="text" class="vol_form" name="text_pen[]" onchange="change_nego_text('ch_pen_text_${uniq}', '${uniq}')" id="ch_pen_text_${uniq}" value="" required></td>
                <td><input type="text" class="sat_form" name="sat_pen[]" onchange="change_nego_sat('ch_pen_sat_${uniq}', '${uniq}')" id="ch_pen_sat_${uniq}" value="" required></td>
                <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" name="vol_pen[]" onchange="change_nego_vol('ch_pen_vol_${uniq}', '${uniq}',${vendor})" id="ch_pen_vol_${uniq}" value="" required></td>
                <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form uang" onchange="count_harga('penhrgsat${uniq}', '${uniq}')" id="penhrgsat${uniq}" name="hrg_sat_pen[]" value="" required></td>
                <td><input type="text" class="vol_form totpen" name="harga_pen[]" id="penhrg${uniq}" value="" readonly></td>
                ${pena}
            </tr>
        `;

        let cont_nego = `
            <tr class="sub_pen_${uniq}">
                <td>-</td>
                <td><input type="text" class="vol_form" name="text_nego[]" value="" id="${uniq}_nego_text" readonly></td>
                <td><input type="text" class="sat_form" name="sat_nego[]" value="" id="${uniq}_nego_sat" readonly></td>
                <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form" name="vol_nego[]" id="${uniq}_nego_vol" value="" readonly></td>
                <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="vol_form" id="negohrgsat${uniq}" name="hrg_sat_nego[]" value="" readonly></td>
                <td><input type="text" class="vol_form totneg" name="harga_nego[]" id="negohrg${uniq}" value="" readonly></td>
                ${nego}
            </tr>
        `;

        $("#tr_penawaran").append(cont_pena);
        $("#tr_nego").append(cont_nego);
    }

    function count_harga(id, uniq) {
        let vol = $(`#ch_pen_vol_${uniq}`).val()
        if (vol == '') {
            alert('Volume harus diisi!')
            $(`#${id}`).val('')
            return false;
        }

        // satuan
        let ini = $(`#${id}`).val()
        let res = ini * vol
        $(`#penhrg${uniq}`).val(res)

        var nn=[];
        $(`.totpen`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        $(`#totpen1`).html(formatter.format(sum))


        // app
        $(`#negohrgsat${uniq}`).val(ini)

        // nego
        let inii = $(`#${id}`).val();
        let ress = inii * vol;
        $(`#negohrg${uniq}`).val(ress)

        $(`#totnego1`).html(formatter.format(sum))

        $(`#total_rbap`).val(sum);
    }

    function count_harga_vend(id, uniq, vend) {
        let vol = $(`#ch_pen_vol_${uniq}`).val()
        if (vol == '') {
            alert('Volume harus diisi!')
            $(`#${id}`).val('')
            return false;
        }
        let ini = $(`#${id}`).val()
        let res = ini * vol

        $(`#penhrg${vend}${uniq}`).val(res)

        var nn=[];
        $(`.total${vend}`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        $(`#tot_pen_vend${vend}`).html(formatter.format(sum))
        $(`#total_ppen${vend}`).val(sum)
    }

    function count_harga_vend_nego(id, uniq, vend) {
        let vol = $(`#${uniq}_nego_vol`).val()
        if (vol == '') {
            alert('Volume harus diisi!')
            $(`#${id}`).val('')
            return false;
        }
        let ini = $(`#${id}`).val()
        let res = ini * vol

        $(`#negohrg${vend}${uniq}`).val(res)

        var nn=[];
        $(`.totalnego${vend}`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        $(`#tot_nego_vend${vend}`).html(formatter.format(sum))
        $(`#total_ppeneg${vend}`).val(sum)
    }

    function change_nego_text(id, uniq) {
        $(`#${uniq}_nego_text`).val($(`#${id}`).val())
    }

    function change_nego_sat(id, uniq) {
        $(`#${uniq}_nego_sat`).val($(`#${id}`).val())
    }

    function change_nego_vol(id, uniq, vendor) {
        $(`#${uniq}_nego_vol`).val($(`#${id}`).val())

        let rab = $(`#penhrgsat${uniq}`).val()
        let volval = $(`#${id}`).val()

        let rabtot = volval * rab
        $(`#penhrg${uniq}`).val(rabtot)
        $(`#negohrg${uniq}`).val(rabtot)
        // if (rab != '') {
        // }

        var nn=[];
        $(`.totpen`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        $(`#totpen1`).html(formatter.format(sum))
        $(`#totnego1`).html(formatter.format(sum))

        for (var i = 0; i < parseInt(vendor); i++) {
            let hs_ven = $(`#penhrgsat${i}${uniq}`).val()
            $(`#penhrg${i}${uniq}`).val(volval  * hs_ven)

            var nn1=[];
            $(`.total${i}`).each(function(){
                if($(this).val() != ''){
                    console.log($(this).val());
                    nn1.push($(this).val())
                }
            });

            let sum1 = 0;
            for (var j = 0; j < nn1.length; j++) {sum1 += parseInt(nn1[j])}
            $(`#tot_pen_vend${i}`).html(formatter.format(sum1))

            let hsn_ven = $(`#negohrgsat${i}${uniq}`).val()
            $(`#negohrg${i}${uniq}`).val(volval  * hsn_ven)

            var nn2=[];
            $(`.totalnego${i}`).each(function(){
                if($(this).val() != ''){
                    nn2.push($(this).val())
                }
            });

            let sum2 = 0;
            for (var k = 0; k < nn2.length; k++) {sum2 += parseInt(nn2[k])}
            $(`#tot_nego_vend${i}`).html(formatter.format(sum2))

        }

    }

    function remove_count(id, uniq, vend) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
		$(id).remove();

        var nn=[];
        $(`.totpen`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        if (nn.length > 0){
            $(`#totpen1`).html(formatter.format(sum))
            $(`#totnego1`).html(formatter.format(sum))
            $(`#total_rbap`).val(sum);
        } else {
            $(`#totpen1`).html('')
            $(`#totnego1`).html('')
            $(`#total_rbap`).val('');
        }

        for (var i = 0; i < vend; i++) {
            clvend = []
            $(`.total${i}`).each(function(){
                if($(this).val() != ''){
                    clvend.push($(this).val())
                }
            });
            if (clvend.length > 0) {
                let sumto = 0;
                for (var j = 0; j < clvend.length; j++) {sumto += parseInt(clvend[j])}
                $(`#tot_pen_vend${i}`).html(formatter.format(sumto))
                $(`#total_ppen${i}`).val(sumto)
            } else {
                $(`#tot_pen_vend${i}`).html('###')
                $(`#total_ppen${i}`).val('')
            }

            clvendn = []
            $(`.totalnego${i}`).each(function(){
                if($(this).val() != ''){
                    clvendn.push($(this).val())
                }
            });
            if (clvendn.length > 0) {
                let sumton = 0;
                for (var j = 0; j < clvendn.length; j++) {sumton += parseInt(clvendn[j])}
                $(`#tot_nego_vend${i}`).html(formatter.format(sumton))
                $(`#total_ppeneg${i}`).val(sumton)
            } else {
                $(`#tot_nego_vend${i}`).html('###')
                $(`#total_ppeneg${i}`).val('')
            }
        }

	}

    function remove_elem(id) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
		$(id).remove();
	}

	// Restricts input for the given textbox to the given inputFilter.
	function setInputFilter(textbox, inputFilter) {
    ["input"].forEach(function(event) {
        textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = "";
        }
        });
    });
    }

    // Install input filters.
    setInputFilter(document.getElementById("telp_inp"), function(value) {
    return /^-?\d*$/.test(value); });

	function getMaxDataNo(selector) {
      var min=null, max=null;
      $(selector).each(function() {
        var no_pp = parseInt($(this).attr('data-no'), 10);
        if ((max===null) || (no_pp > max)) { max = no_pp; }
      });
      return max;
    }

</script>
