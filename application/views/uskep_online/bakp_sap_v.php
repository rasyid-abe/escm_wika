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
                    <?php if ($mtode != ''): ?>
                        <li class="active"><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PENUNJUKAN LANGSUNG</b></p></li>
                    <?php else: ?>
                        <li class="active"><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PEMENANG</b></p></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <br>

    <form method="post" action="<?= site_url($controller_name."/submit_bakp");?>"  class="form-horizontal ajaxform">

        <?php if (isset($cid)): ?>
            <input type="hidden" name="is_cid" value="<?= $cid ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12 table-responsive">
                <table style="width: 100%">
                    <input type="hidden" name="no_rfq" value="<?= $import['no_rfq'] ?>">
                    <tr>
                        <td width="15%"><h6>Nomor :</h6></td>
                        <td><input type="text" name="nomor_bakp" class="form-control form_header" value="" /></td>
                    </tr>
                    <tr>
                        <td><h6>Tanggal :</h6></td>
                        <td><input type="date" name="tgl_bakp" class="form-control form_header" value="<?= date('Y-m-d') ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h6>Pada hari ini, <input type="text" name="hari" value="<?= $this->terbilang->hari_indo(date('D')); ?>">
                                tanggal <input type="text" name="tanggal" value="<?= ucfirst(strtolower($this->terbilang->eja(date('d')))) ?>">
                                bulan <input type="text" name="bulan" value="<?= $this->terbilang->bulan_indo(date('m')) ?>">
                                tahun <input type="text" name="tahun" value="<?= ucwords(strtolower($this->terbilang->eja(date('Y')))) ?>">
                                ( <input type="date" name="fultgl" value="<?= date('Y-m-d') ?>"> )
                                di <input type="text" name="tempat" value="<?= !empty($data_uskep['bakp_city']) ? $data_uskep['bakp_city'] : 'Jakarta' ?>"> telah dilaksanakan <br>
                                rapat penentuan/pengusulan pemutusan pemenang subkon / pemasok , untuk :
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">Paket Pengadaan</td>
                        <td class="bold"><?= $import['pengadaan'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Proyek</td>
                        <td class="bold"><?= $import['proyek'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Divisi</td>
                        <td class="bold"><?= $userdata['dept_name'] ?></td>
                    </tr>
                    <tr>
                        <input type="hidden" name="nilrab" value="<?= $import['nilai_rab'] ?>">
                        <td class="bold">Nilai RAB/HPS</td>
                        <td class="bold">Rp. <?= number_format($import['nilai_rab'],0,',','.') ?></td>
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
                            <td><?= $key + 1 ?></td>
                            <td><?= $value ?></td>
                            <td>
                                <select class="form_header form-control" name="daftar[]" required>
                                    <option value="">Pilih</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                            <td>
                                <select class="form_header form-control" name="penawaran[]" required>
                                    <option value="">Pilih</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="catatan_tbl1[]" class="form-control form_header" value="" /></td>
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
                            <td><?= $key + 1 ?></td>
                            <td colspan="2"><?= $value ?></td>
                            <td colspan="2"><?= $import['status_adm'][$key] ?></td>
                            <input type="hidden" name="statlulus[]" value="<?= $import['status_adm'][$key] ?>">
                            <td><input type="text" name="catatan_tbl21[]" class="form-control form_header" value="" /></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <th width="3%">2.2</th>
                        <th colspan="5">Teknis (Bobot <?= $import['tek_perc'] ?>%, Threshold <?= $import['threshold'] ?>)</th>
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
                            <td><?= $key + 1 ?></td>
                            <td colspan="2"><?= $value ?></td>
                            <td><?= $import['tek_nilai'][$key] ?></td>
                            <td><?= $import['tek_bobot'][$key] ?></td>
                            <input type="hidden" name="nil22[]" value="<?= $import['tek_nilai'][$key] ?>">
                            <input type="hidden" name="bot22[]" value="<?= $import['tek_bobot'][$key] ?>">
                            <td><input type="text" name="catatan_tbl22[]" class="form-control form_header" value="" /></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <th width="3%">2.3</th>
                        <th colspan="5">Harga (Bobot <?= $import['hrg_perc'] ?>%, HPS <?= $import['hrg_hps'] ?>)</th>
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
                            <td><?= $key + 1 ?></td>
                            <td><?= $value ?></td>
                            <td><?= "Rp " . number_format($import['hrg_nego'][$key], 2, ",", ".") ?></td>
                            <td><?= "Rp " . number_format($import['effisien'][$key], 2,',','.') ?></td>
                            <td><?= $import['hrg_nilai'][$key] ?></td>
                            <td><?= $import['hrg_bobot'][$key] ?></td>
                            <input type="hidden" name="neg23[]" value="<?= $import['hrg_nego'][$key] ?>">
                            <input type="hidden" name="eff23[]" value="<?= $import['effisien'][$key] ?>">
                            <input type="hidden" name="nil23[]" value="<?= $import['hrg_nilai'][$key] ?>">
                            <input type="hidden" name="bot23[]" value="<?= $import['hrg_bobot'][$key] ?>">
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
                            <td><?= $key+1 ?></td>
                            <td colspan="2"><?= $value ?></td>
                            <td><?= $import['hrg_tot_nilai'][$key] ?></td>
                            <td><?= $import['peringkat'][$key] ?></td>
                            <input type="hidden" name="nil24[]" value="<?= $import['hrg_tot_nilai'][$key] ?>">
                            <input type="hidden" name="ran24[]" value="<?= $import['peringkat'][$key] ?>">
                            <td><input type="text" name="tatatan_tbl24[]" class="form-control form_header" value="" /></td>
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
                            <td><?= $key + 1 ?></td>
                            <td><b><?= $value ?></b></td>
                            <td align="right"><b><?= "Rp " . number_format($import['vendor_omz'][$key], 2, ",", ".") ?></b></td>
                            <td></td>
                            <input type="hidden" name="ven_win[]" value="<?= $value ?>">
                            <input type="hidden" name="ven_omZ[]" value="<?= $import['vendor_omz'][$key] ?>">
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
                    <tr id="row_note_Xnb1">
                        <td class="text-right">
                            <input type="hidden" name="uniq_row_note[]" value="Xnb1">
                            <span class="btn-sm btn btn-info" onclick="add_sub_note('Xnb1', '1');">Sub <i class="ft ft-plus"></i></span>
                            <span class="btn-sm btn btn-danger" onclick="remove_note(row_note_Xnb1);"><i class="ft ft-trash"></i></span>
                        </td>
                        <td><input type="text" name="note_note[]" class="form-control form_header" value="Semua Peserta Rapat menyepakati keputusan tersebut , tanpa ada yang memberikan catatan khusus."></td>
                    </tr>
                    <tbody id="another_row_1" class="class_st_adm"></tbody>
                    <tr id="row_note_Xnb2">
                        <td width="10%" class="text-right">
                            <input type="hidden" name="uniq_row_note[]" value="Xnb2">
                            <span class="btn-sm btn btn-info" onclick="add_sub_note('Xnb2', '2');">Sub <i class="ft ft-plus"></i></span>
                            <span class="btn-sm btn btn-danger" onclick="remove_note(row_note_Xnb2);"><i class="ft ft-trash"></i></span>
                        </td>
                        <td><input type="text" name="note_note[]" class="form-control form_header" value="Apabila pemenang menolak/mengundurkan diri atau terbukti sanggahannya maka pejabat pengadaan harus melakukan salahsatu dari hal-hal berikut: "></td>
                    </tr>
                    <tbody id="another_row_2" class="class_st_adm">
                        <tr id="sub_row_note_ab1" class="sub_row_note_Xnb2">
                            <td class="text-right"><span class="btn-sm btn btn-danger" onclick="remove_note(sub_row_note_ab1);"><i class="ft ft-trash"></i></span></td>
                            <td><input type="text" name="sub_note_note_Xnb2[]" class="form-control form_header ml-4" style="width: 80%" value="Menegosiasi penyedia peringkat kedua agar sesuai dengan kondisi peringkat kesatu."></td>
                        </tr>
                        <tr id="sub_row_note_ab2" class="sub_row_note_Xnb2">
                            <td class="text-right"><span class="btn-sm btn btn-danger" onclick="remove_note(sub_row_note_ab2);"><i class="ft ft-trash"></i></span></td>
                            <td><input type="text" name="sub_note_note_Xnb2[]" class="form-control form_header ml-4" style="width: 80%"value="Menetapkan penyedia peringkat kedua sebagai pemenang."></td>
                        </tr>
                        <tr id="sub_row_note_ab3" class="sub_row_note_Xnb2">
                            <td class="text-right"><span class="btn-sm btn btn-danger" onclick="remove_note(sub_row_note_ab3);"><i class="ft ft-trash"></i></span></td>
                            <td><input type="text" name="sub_note_note_Xnb2[]" class="form-control form_header ml-4" style="width: 80%"value="Melakukan tender ulang."></td>
                        </tr>
                    </tbody>
                    <tbody id="another_row_3" class="class_st_adm"></tbody>
                </table>
                <br>
                <input type="hidden" name="is_sap" value=1>

                <table style="width: 100%" id="tbl_esign">
                    <tr class="">
                        <th colspan="2">
                            <span class="ml-2 btn-sm btn btn-info" onclick="add_sign()"><i class="ft ft-plus"></i> Add Signatory</span>
                        </th>
                    </tr>
                    <tbody id="tr_esign"></tbody>
                </table>
            </div>
        </div>


        <div id="required" class="card">
            <div class="card-content">
                <div class="card-body">
                    <?= buttonsubmit('contract/manual_sap',lang('back'),lang('save')) ?>
                </div>
            </div>
        </div>

    </form>

</div>

<script>

    let list_hcis = '';
    $(document).ready(function(){

        $.ajax({
            url: '<?php echo site_url($controller_name."/get_list_vendor");?>',
            method: 'post',
            data: {},
            dataType: 'json',
            success: function(data) {
                hcis_nm = `<option value="">Pilih Nama TTD</option>`
                $.each(data[3], function(id, va) {
                    hcis_nm += `<option value="${va.nip}_${va.nm_peg}_${va.posisi}">${va.nm_peg} - ${va.posisi}</option>`
                })
                list_hcis = hcis_nm
            }
        })
    })

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
            url: '<?= site_url($controller_name."/check_kewenangan_dpkn");?>',
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
            <td width="10%" class="text-right">
                <span class="btn-sm btn btn-danger" onclick="remove_note(sub_row_note_${uniq});"><i class="ft ft-trash"></i></span>
            </td>
            <td><input type="text" name="sub_note_note_${un}[]" class="form-control form_header ml-4" style="width: 80%" value="" /></td>
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

    function add_sign() {
        var uniq = rand(3);

        let html = `
        <tr id="sign_${uniq}">
            <td width="5%" class="text-right"><span class="btn-sm btn btn-danger" onclick="remove_elem(sign_${uniq});"><i class="ft ft-trash"></i></span></td>
            <td>
                <select class="form-control ff form_header select2" id="nmKew" name="nm_kew[]">${list_hcis}</select>
                <input type="hidden" name="kategori[]" value="Mengusulkan">
                <input type="hidden" name="posisi[]" value="Anggota">
            </td>
        </tr>
        `
        $("#tr_esign").append(html);
        selectRefresh()
    }

    function remove_elem(id) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
        $(id).remove();
    }

</script>
