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

</style>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="wrapper-progressBar">
                <ul class="progressBar">
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN SISTEM PENILAIAN</b></p></li>
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI</b></p></li>
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PEMENANG</b></p></li>
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

    <form method="post" action="<?php echo site_url($controller_name."/submit_bakp");?>"  class="form-horizontal ajaxform">

        <div class="row">
            <div class="col-sm-12 table-responsive">
                <table style="width: 100%">
                    <input type="hidden" name="no_rfq" value="<?php echo $import['no_rfq'] ?>">
                    <tr>
                        <td width="15%"><h6>Nomor :</h6></td>
                        <td><input type="text" name="nomor_bakp" class="form-control form_header" value="<?php echo $nomor_bakp ?>" /></td>
                    </tr>
                    <tr>
                        <td><h6>Tanggal :</h6></td>
                        <td><input type="date" name="tgl_bakp" class="form-control form_header" value="<?php echo $tgl_bakp ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h6>Pada hari ini, <input type="text" name="hari" value="<?= strtolower($hari); ?>">
                                tanggal <input type="text" name="tanggal" value="<?= strtolower($tanggal) ?>">
                                bulan <input type="text" name="bulan" value="<?= $bulan ?>">
                                tahun <input type="text" name="tahun" value="<?= strtolower($tahun) ?>">
                                ( <input type="date" name="fultgl" value="<?= $fultgl ?>"> )
                                di <input type="text" name="tempat" value="<?= $tempat ?>"> telah dilaksanakan <br>
                                rapat penentuan/pengusulan pemutusan pemenang subkon / pemasok , untuk :
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">Paket Pengadaan</td>
                        <td class="bold"><?php echo $import['pengadaan'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Proyek</td>
                        <td class="bold"><?php echo $import['proyek'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Divisi</td>
                        <td class="bold"><?php echo $userdata['dept_name'] ?></td>
                    </tr>
                    <tr>
                        <input type="hidden" name="nilrab" value="<?php echo $import['nilai_rab'] ?>">
                        <td class="bold">Nilai RAB/HPS</td>
                        <td class="bold">Rp. <?php echo number_format($import['nilai_rab'],0,',','.') ?></td>
                    </tr>
                    <tr>
                        <td>
                            <h6 class="mt-2">Dengan hasil sebagai berikut :</h6>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%" class="table-striped table" id="tbl_dpkn">
                    <tr>
                        <th width="3%">1.</th>
                        <th colspan="4">Hasil Permintaan Penawaran</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Nama Penyedia Diundang</th>
                        <th>Daftar (Ya/Tidak)</th>
                        <th>Memasukkan Penawaran (Ya/tidak)</th>
                        <th>Catatan</th>
                    </tr>
                    <?php foreach ($import['vendor'] as $key => $value): ?>
                        <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo $value ?></td>
                            <td>
                                <select class="form_header form-control" name="daftar[]" required>
                                    <option value="">Pilih</option>
                                    <option value="Ya" <?= $daftar[$key] == 'Ya' ? 'selected' : '' ?>>Ya</option>
                                    <option value="Tidak" <?= $daftar[$key] == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
                                </select>
                            </td>
                            <td>
                                <select class="form_header form-control" name="penawaran[]" required>
                                    <option value="">Pilih</option>
                                    <option value="Ya" <?= $penawaran[$key] == 'Ya' ? 'selected' : '' ?>>Ya</option>
                                    <option value="Tidak" <?= $penawaran[$key] == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="catatan_tbl1[]" class="form-control form_header" value="<?php echo $catatan_tbl1[$key] ?>" /></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>

                <table style="width: 100%" class="table-striped table" id="tbl_dpkn">
                    <tr>
                        <th width="3%">2.</th>
                        <th colspan="5">Hasil Evaluasi Penilaian</th>
                    </tr>
                    <tr>
                        <th width="3%">2.1</th>
                        <th colspan="5">Administrasi</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th colspan="2">Nama Rekanan</th>
                        <th colspan="2">Status</th>
                        <th>Catatan</th>
                    </tr>
                    <?php foreach ($import['vendor'] as $key => $value): ?>
                        <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td colspan="2"><?php echo $value ?></td>
                            <td colspan="2"><?php echo $import['status_adm'][$key] ?></td>
                            <input type="hidden" name="statlulus[]" value="<?php echo $import['status_adm'][$key] ?>">
                            <td><input type="text" name="catatan_tbl21[]" class="form-control form_header" value="<?php echo $catatan_tbl21[$key] ?>" /></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <th width="3%">2.2</th>
                        <th colspan="5">Teknis (Bobot <?php echo $import['tek_perc'] ?>%, Threshold <?php echo $import['threshold'] ?>)</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th colspan="2">Nama Rekanan</th>
                        <th>Nilai</th>
                        <th>Nilai x Bobot</th>
                        <th>Catatan</th>
                    </tr>
                    <?php foreach ($import['vendor'] as $key => $value): ?>
                        <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td colspan="2"><?php echo $value ?></td>
                            <td><?php echo $import['tek_nilai'][$key] ?></td>
                            <td><?php echo $import['tek_bobot'][$key] ?></td>
                            <input type="hidden" name="nil22[]" value="<?php echo $import['tek_nilai'][$key] ?>">
                            <input type="hidden" name="bot22[]" value="<?php echo $import['tek_bobot'][$key] ?>">
                            <td><input type="text" name="catatan_tbl22[]" class="form-control form_header" value="<?php echo $catatan_tbl22[$key] ?>" /></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <th width="3%">2.3</th>
                        <th colspan="5">Harga (Bobot <?php echo $import['hrg_perc'] ?>%, HPS <?php echo $import['hrg_hps'] ?>)</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Nama Rekanan</th>
                        <th>Harga Negosiasi</th>
                        <th>Efisien</th>
                        <th>Nilai</th>
                        <th>Nilai x Bobot</th>
                    </tr>
                    <?php foreach ($import['vendor'] as $key => $value): ?>
                        <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo $value ?></td>
                            <td><?php echo $import['hrg_nego'][$key] ?></td>
                            <td><?php echo number_format($import['effisien'][$key],0,',','.') ?></td>
                            <td><?php echo $import['hrg_nilai'][$key] ?></td>
                            <td><?php echo $import['hrg_bobot'][$key] ?></td>
                            <input type="hidden" name="neg23[]" value="<?php echo $import['hrg_nego'][$key] ?>">
                            <input type="hidden" name="eff23[]" value="<?php echo $import['effisien'][$key] ?>">
                            <input type="hidden" name="nil23[]" value="<?php echo $import['hrg_nilai'][$key] ?>">
                            <input type="hidden" name="bot23[]" value="<?php echo $import['hrg_bobot'][$key] ?>">
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <th width="3%">2.4</th>
                        <th colspan="5">Total</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th colspan="2">Nama Rekanan</th>
                        <th>total Nilai</th>
                        <th>Peringkat</th>
                        <th>Catatan</th>
                    </tr>
                    <?php foreach ($import['vendor'] as $key => $value): ?>
                        <tr>
                            <td><?php echo $key+1 ?></td>
                            <td colspan="2"><?php echo $value ?></td>
                            <td><?php echo $import['hrg_tot_nilai'][$key] ?></td>
                            <td><?php echo $import['peringkat'][$key] ?></td>
                            <input type="hidden" name="nil24[]" value="<?php echo $import['hrg_tot_nilai'][$key] ?>">
                            <input type="hidden" name="ran24[]" value="<?php echo $import['peringkat'][$key] ?>">
                            <td><input type="text" name="tatatan_tbl24[]" class="form-control form_header" value="<?php echo $tatatan_tbl24[$key] ?>" /></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>

                <table style="width: 100%" class="table">
                    <tr>
                        <th width="5%">3.</th>
                        <th>Komisi Pengadaan sepakat memutuskan pemenang untuk paket pekerjaan di atas adalah:</th>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <td>No</td>
                        <td>Nama Penyedia</td>
                        <td align="right">Omset Kontrak</td>
                        <td width="50%"></td>
                    </tr>
                    <?php foreach ($import['vendor_win'] as $key => $value): ?>
                        <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><b><?php echo $value ?></b></td>
                            <td align="right"><b>Rp. <?php echo $import['vendor_omz'][$key] ?></b></td>
                            <td></td>
                            <input type="hidden" name="ven_win[]" value="<?php echo $value ?>">
                            <input type="hidden" name="ven_omZ[]" value="<?php echo $import['vendor_omz'][$key] ?>">
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>

                <table style="width: 100%" class="table">
                    <tr>
                        <th width="3%">4.</th>
                        <th>Catatan-catatan: <span class=" ml-2 btn-sm btn btn-info" onclick="tambah_catatan()"><i class="ft ft-plus"></i></span></th>
                    </tr>
                </table>
                <h6 class="m-2">Demikian Berita Acara Ini dibuat, untuk dilaksanakan dan diproses lebih lanjut</h6>
                <table style="width: 100%" id="tbl_notenote">
                    <?php $aa = 1; foreach ($note as $i => $v): ?>

                        <?php if (is_object($v)): ?>
                            <tr id="row_note_1<?php echo $i ?>">
                                <td width="10%" class="text-right">
                                    <input type="hidden" name="uniq_row_note[]" value="1<?php echo $i ?>" />
                                    <span class="btn-sm btn btn-info" onclick="add_sub_note('1<?php echo $i ?>', '<?php echo $aa ?>')">Sub <i class="ft ft-plus"></i></span>
                                    <span class="btn-sm btn btn-danger" onclick="remove_note(row_note_1<?php echo $i ?>)"><i class="ft ft-trash"></i></span>
                                </td>
                                <td><input type="text" name="note_note[]" class="form-control form_header" value="<?php echo $v->poin ?>" /></td>

                            </tr>
                                <?php if (isset($v->sub_poin)): ?>

                                    <?php foreach ($v->sub_poin as $key => $value): ?>
                                        <tr id="sub_row_note_2<?php echo $key ?><?php echo $i ?>" class="sub_row_note_1<?php echo $i ?>">
                                            <td width="8%" class="text-right">
                                                <span class="btn-sm btn btn-danger" onclick="remove_note(sub_row_note_2<?php echo $key ?><?php echo $i ?>);"><i class="ft ft-trash"></i></span>
                                            </td>
                                            <td><input type="text" name="sub_note_note_1<?php echo $i ?>[]" class="form-control form_header" value="<?php echo $value ?>" /></td>
                                        </tr>
                                    <?php endforeach; ?>

                                <?php endif; ?>

                                <tbody id="another_row_<?php echo $aa ?>" class="class_st_adm"></tbody>
                        <?php endif; ?>
                    <?php $aa++; endforeach; ?>
                    <tbody id="first_row"></tbody>
                </table>
                <br>
                <table class="table m-0" class="is-content" id="tbl_esign">
                    <tr>
                        <td colspan="7" align="center"><b>Komisi Pengadaan <?php echo $title['komisi'] ?> (<?php echo $title['tipe_proyek'] ?>)</b></td>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Kategori</th>
                        <th>Posisi</th>
                        <th>E-Sign</th>
                    </tr>
                    <?php foreach ($esign->nm_kew as $k => $v): ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><input class="form-control" type="text" name="nm_kew[]" value="<?php echo $v ?>" readonly></td>
                            <td><input class="form-control" type="text" name="job_title[]" value="<?php echo $esign->job_title[$k] ?>" readonly></td>
                            <td><input class="form-control" type="text" name="kategori[]" value="<?php echo $esign->kategori[$k] ?>" readonly></td>
                            <td><input class="form-control" type="text" name="posisi[]" value="<?php echo $esign->posisi[$k] ?>" readonly></td>
                            <td>..................</td>
                        </tr>
                    <?php endforeach; ?>
                    <tbody id="tr_esign"></tbody>
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
        console.log('start tipeProyek');

        let tipePlan = $(`#tipePlan`).val();
        let komisi = $(`#komisi`).val();
        let tipeProyek = $(this).val();
        let spk = $(`input[name=kode_spk]`).val()
        console.log(spk);

        var kewenangan = `
        <tr>
            <td colspan="7" align="center"><b>Komisi Pengadaan ${komisi} (${tipeProyek})</b></td>
        </tr>
        <tr>
            <th>No</th>
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
            success: function(data) {
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
            }
        })
    })

    function selectRefresh() {
        $('#tbl_esign .select2').select2({
            tags: true,
            placeholder: "Pilih Nama",
            allowClear: true,
            width: '100%'
        });
    }

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

    function tambah_catatan() {
        var uniq = rand(3);

        let r = $('.class_st_adm').length;
        rr = r + 1;

        let elem = `
        <tr id="row_note_${uniq}">
            <td width="10%" class="text-right">
                <input type="hidden" name="uniq_row_note[]" value="${uniq}" />
                <span class="btn-sm btn btn-info" onclick="add_sub_note('${uniq}', '${rr}');">Sub <i class="ft ft-plus"></i></span>
                <span class="btn-sm btn btn-danger" onclick="remove_note(row_note_${uniq});"><i class="ft ft-trash"></i></span>
            </td>
            <td><input type="text" name="note_note[]" class="form-control form_header" value="" /></td>
        </tr>`

        console.log(r);
        console.log(rr);

        if (r > 0) {
            $("#another_row_" + r).after(elem);
        } else {
            $("#first_row").after(elem);
        }

        $(`#row_note_${uniq}`).after(`<tbody id="another_row_${rr}" class="class_st_adm"></tbody>`)
    }

    function add_sub_note(un, rr) {
        var uniq = rand(3);

        let elem = `
        <tr id="sub_row_note_${uniq}" class="sub_row_note_${un}">
            <td width="8%" class="text-right">
                <span class="btn-sm btn btn-danger" onclick="remove_note(sub_row_note_${uniq});"><i class="ft ft-trash"></i></span>
            </td>
            <td><input type="text" name="sub_note_note_${un}[]" class="form-control form_header" value="" /></td>
        </tr>

        `
        $(`#another_row_${rr}`).append(elem);
    }

    function remove_note(id) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
		$(id).remove();
	}

    function add_esign() {
        var uniq = rand(3);

        var select = '<option value="">Pilih</option>';
        $.each(person, function(i, v) {
            select += `<option value="${v.complete_name}">${v.complete_name}</option>`
        })

        let elem = `
        <tr id="esign_${uniq}">
            <td><span class="btn-sm btn btn-danger" onclick="remove_note(esign_${uniq});"><i class="ft ft-trash"></i></span></td>
            <td style="width: 300px;">
            <select class="form_header form-control select2" name="name_esign[]">
                ${select}
            </select>
            </td>
            <td>
                <select class="form_header form-control" name="sebagai_esign[]">
                    <option value="">Sebagai</option>
                    <option value="Ketua">Ketua</option>
                    <option value="Anggota">Anggota</option>
                </select>
            </td>
            <td>
                <select class="form_header form-control" name="kategori_esign[]">
                    <option value="">Kategori</option>
                    <option value="Menyetujui">Menyetujui</option>
                    <option value="Mengetahui">Mengetahui</option>
                </select>
            </td>
            <td><input type="text" class="form_header form-control" name="ttd_esign[]" value="" placeholder="ttd"></td>
            <td><input type="text" class="form_header form-control" name="ket_esign[]" value="" placeholder="Keterangan"></td>
        </tr>
        `

        $("#tr_esign").append(elem);

    }

</script>
