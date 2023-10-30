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

</style>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="wrapper-progressBar">
                <ul class="progressBar">
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN SISTEM PENILAIAN</b></p></li>
                    <li class=""><p style="margin:0px;font-size:14px;"><b>DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI</b></p></li>
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

    <form method="post" action="<?php echo site_url($controller_name."/submit_dsp");?>"  class="form-horizontal ajaxform">

        <div class="row mt-3 mb-3">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-sm-2 mb-2 control-label text-left text-bold-700"><strong>Paket Pengadaan</strong> <span class="text-danger text-bold-700">*</span></label>
                    <div class="col-sm-10 mb-2">
                        <input type="text" class="form-control" name="paketPengadaan" id="paketPengadaan" placeholder="Paket Pengadaan" value="<?php echo trim($pengadaan) ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 mb-2 control-label text-left text-bold-700"><strong>Proyek</strong> <span class="text-danger text-bold-700">*</span></label>
                    <div class="col-sm-10 mb-2">
                        <select class="form-control select2" name="project" id="project">
                            <option value="">Pilih Proyek</option>
                            <?php foreach($projects as $key => $val){ ?>
                                <option value='<?php echo $val['kode_spk']; ?>' <?= $proyek == $val['kode_spk'] ? 'selected' : '' ?>><?php echo $val['nama_spk']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 mb-2 control-label text-left text-bold-700"><strong>Nomor RFQ</strong> <span class="text-danger text-bold-700">*</span></label>
                    <div class="col-sm-10 mb-2">
                        <input type="text" class="form-control" name="nomor_rfq" placeholder="Nomor RFQ" value="<?= $no_rfq ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="row <?php echo $edit ? 'hidden' : '' ?>" id="vend_section">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-12 control-label text-left text-bold-700"><strong>Penyedia Barang dan Jasa </strong> <img class="hidden" style="cursor: pointer;" width="20" height="20" src="<?php echo base_url('assets/img/add.png') ?>" id="add_penyedia"/></label>
                </div>
                <table width="100%" id="add_penyedia_tbl">
                    <input type="hidden" name="twin" value="<?php echo $winner ?>">
                    <?php if ($winner < 2): ?>
                        <tr>
                            <td width="100%">
                                <select class="form-control select2" name="vendor" class="vend_val">
                                    <option value="">Pilih Vendor</option>
                                    <?php foreach($bidderList as $key => $val){ ?>
                                        <option value='<?php echo $val['vendor_name'] .'-'. $val['vendor_id']; ?>'><?php echo $val['vendor_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-right"></td>
                        </tr>
                    <?php else: ?>
                        <?php for ($i=0; $i < $winner; $i++) {?>
                            <tr>
                                <td width="100%">
                                    <select class="form-control select2" name="vendor" class="vend_val">
                                        <option value="">Pilih Vendor</option>
                                        <?php foreach($bidderList as $key => $val){ ?>
                                            <option value='<?php echo $val['vendor_name'] .'-'. $val['vendor_id']; ?>'><?php echo $val['vendor_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="text-right"></td>
                            </tr>
                        <?php } ?>
                    <?php endif; ?>
                </table>
                <span class=" m-2 btn btn-primary" id="proses_tabel">Proses</span>
                <span class="btn btn-danger" onclick="history.back()">Kembali</span>
            </div>
        </div>
        <div id="tbl_inp_dsp">
            <div class="row">
            <div class="col-12 table-responsive">
                <table style="width: 100%" class="table table-striped m-0" id="tbl_penilaian">
                    <tr>
                        <th style='vertical-align: middle; width: 10%' class="text-center" rowspan="2">No</th>
                        <th style='vertical-align: middle; min-width:200px;' class="text-left" rowspan="2">Uraian</th>
                        <th style='vertical-align: middle; min-width:250px;' class="text-center" rowspan="2">Bobot</th>
                        <th class="text-center" style="width: 50%" colspan="<?= $span ?>">Penyedia Barang dan Jasa</th>
                    </tr>
                    <tr>
                        <?php foreach ($vend as $k => $v): ?>
                            <th style="word-break: break-all;" class="text-center">
                                <?php echo $v['vendor_name'] ?>
                                <input type="hidden" name="vendor_list[]" value="<?php echo $v['vendor_id'] ?>">
                            </th>
                        <?php endforeach; ?>
                    </tr>
                    <tr style="background-color: #2aace3;color: #fff;">
                        <td class="text-center">I</td>
                        <td align="left"><b>ADMINISTRASI</b> <span class=" m-2 btn-sm btn btn-success" onclick="add_administrasi(<?= $span ?>);"><i class="ft ft-plus"></i></span></td>
                        <td class="text-center"><b>Wajib</b></td>
                        <td colspan="<?= $span ?>"></td>
                    </tr>
                    <tr>
                        <td></td><td>Putusan</td><td></td>
                        <?php foreach ($adm_status as $k => $v): ?>
                            <td class="text-center">
                                <span id="status_<?= $k ?>" class="stats_adm"><?php echo $v ?></span>
                                <input type="hidden" id="val_status_<?= $k ?>" name="status_adm_vendor[]" value="<?php echo $v ?>" />
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tbody id="row_adm_putusan">

                        <?php foreach ($adm_poin as $k => $v): ?>
                            <tr id="head_putusan_p<?= $k ?>" class="head_putusan">
                                <input type="hidden" name="adm_uniq[]" value="p<?= $k ?>">
                                <th>
                                    <span class="btn-sm btn btn-danger" onclick="remove_adm(head_putusan_p<?= $k ?>, <?= $span ?>);"><i class="ft ft-trash"></i></span>
                                    <span class="btn-sm btn btn-info" onclick="add_sub_administrasi(<?=$k+1?>, <?= count($adm_poin)?>, <?= $span ?>, 'p<?= $k ?>');">Sub <i class="ft ft-plus"></i></span>
                                </th>
                                <th colspan="2"><input type="text" class="form_header administrasi_poin" name="administrasi_poin_p<?= $k ?>" value="<?php echo $v->title ?>" required></th>
                                <th colspan="<?= $span ?>"></th>
                            <tr>

                            <?php foreach ($v->sub as $ke => $va): ?>
                                <tr id="row_putusan_sub_sp<?= $ke ?><?= $k ?>" class="sub_head_putusan_p<?= $k ?>">
                                    <td>
                                        <span class="btn-sm btn btn-danger" onclick="remove_adm(row_putusan_sub_sp<?= $ke ?><?= $k ?>, <?= $span ?>);"><i class="ft ft-trash"></i></span>
                                    </td>
                                    <td><input type="text" class="form_header" name="sub_administrasi_poin_text_p<?= $k ?>[]" value="<?php echo $v->sub[$ke] ?>"></td>
                                    <td><input type="text" class="form_header" name="sub_administrasi_poin_bobot_p<?= $k ?>[]" value="<?php echo $v->bobot[$ke] ?>"></td>

                                    <?php foreach ($v->vendor as $i => $e): ?>
                                        <td>
                                            <select class="form-control form_header select_adm_putusan_<?= $i ?>" name="adm_pilihan_<?= $i ?>_p<?= $k ?>[]" onchange="is_pass(<?= $i ?>)">
                                                <option value="">Pilih</option>
                                                <option value="Ya" <?= $v->vendor[$i][$ke] == 'Ya' ? 'selected' : '' ?>>Ya</option>
                                                <option value="Tidak" <?= $v->vendor[$i][$ke] == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
                                            </select>
                                        </td>
                                    <?php endforeach; ?>

                                <tr>
                            <?php endforeach; ?>
                            <tbody id="adm_st_<?= $k+1?>" class="class_st_adm"></tbody>

                        <?php endforeach; ?>

                    </tbody>
                    <tr style="background-color: #2aace3;color: #fff;">
                        <td class="text-center">II</td>
                        <td align="left"><b>TEKNIS</b> <span class=" ml-2 btn-sm btn btn-success" onclick="add_teknis_point(<?= $span ?>);"><i class="ft ft-plus"></i></span></td>
                        <td ><input type="text" class="form_header numz" name="teknis_percent" value="<?php echo $percent_teknis ?>" onchange="set_percent(<?= $span ?>)" onkeyup="return only_number(event)" required> %</td>
                        <td colspan="<?= $span ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Threshold</td>
                        <td><input type="text" class="form_header numz" onchange="count_after_change(<?= $span ?>)" onkeyup="return only_number(event)" name="threshold_tek" value="<?php echo $threshold ?>" required></td>
                        <?php foreach ($status as $k => $v): ?>
                            <td class="text-center">
                                <span id="status_thresh_<?= $k ?>" class="stats_adm"><strong><?php echo $v ?></strong></span>
                                <input type="hidden" id="val_status_thresh_<?= $k ?>" name="status_tek_vendor[]" value="<?php echo $v ?>" />
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nilai</td>
                        <td></td>
                        <?php foreach ($nilai as $k => $v): ?>
                            <td class="text-center">
                                <span id="teknis_nilai_vend<?= $k ?>"><strong id="nilai_tek_<?= $k ?>"><?php echo $v ?></strong></span>
                                <input type="hidden" id="ftek_nilai_<?= $k ?>" name="nilai_tek[]" value="<?php echo $v ?>" />
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nilai x Bobot</td>
                        <td></td>
                        <?php foreach ($bobot as $k => $v): ?>
                            <td id="teknis_bobot_vend<?= $k ?>" class="text-center"><strong id="nnb<?= $k ?>"><?php echo $v ?></strong></td>
                            <input id="ftek_bobot_<?= $k ?>" type="hidden" name="bobot_tek[]" value="<?php echo $v ?>" />
                        <?php endforeach; ?>
                    </tr>
                    <tbody id="row_tek">

                        <?php foreach ($tek_poin as $k => $v): ?>
                            <tr id="point_teknis_<?= $k ?>" class="point_teknis">
                                <input type="hidden" name="tekuniq[]" value="<?= $k ?>">
                                <th>
                                    <span class="btn-sm btn btn-danger" onclick="remove_tek(point_teknis_<?= $k ?>, <?= $span ?>, '<?= $k ?>');"><i class="ft ft-trash"></i></span>
                                    <span class="btn-sm btn btn-info" onclick="add_teknis_head('<?= $k+1?>', <?= count($tek_poin)?>, <?= $span ?>, '<?= $k ?>');">Sub <i class="ft ft-plus"></i></span>
                                </th>
                                <th><input type="text" class="form_header" name="teknis_point_<?= $k ?>" value="<?php echo $v->title ?>" required></th>
                                <th><input type="text" class="form_header numz" id="tek_perc_<?= $k ?>" onchange="re_count_tek(<?= $span ?>, '<?= $k ?>')" name="teknis_percent_<?= $k ?>" value="<?php echo $v->bobot ?>" onkeyup="return only_number(event)"> %</th>

                                <?php foreach ($v->hasil as $ke => $va): ?>
                                    <th class="text-center">
                                        <span id="teknis_point_<?= $ke?>_<?= $k ?>"><strong class="tpp_<?= $ke?> teknis_point_<?= $ke?>_<?= $k ?>"><?php echo $va ?></strong></span>
                                        <input type="hidden" id="has_poin<?= $ke?>_<?= $k ?>" name="hasil_poin_<?= $ke?>_<?= $k ?>" value="<?php echo $va ?>" />
                                    </th>
                                <?php endforeach; ?>

                            </tr>

                            <?php foreach ($v->sub->sub_poin as $e => $a): ?>
                                <?php if ($e == 0): ?>
                                    <tr id="head_teknis_ts<?= $k?>" class="sub_point_teknis_<?= $k ?>">
                                        <th></th>
                                        <th><input type="text" class="form_header" name="putusan_text_<?= $k ?>[]" value="<?php echo $a ?>"></th>
                                        <th><input type="text" class="form_header" name="putusan_bobot_<?= $k ?>[]" value="<?php echo $v->sub->sub_bobot[$e] ?>"> %</th>

                                        <?php foreach ($vend as $key => $value): ?>
                                            <th class="inp_poin_<?= $key ?>_<?= $k ?>" rowspan=1>
                                                <input type="text" onchange="count_teknis(<?= $key ?>, '<?= $k ?>')" class="form_header numz chk chg<?= $key ?>" name="teknis_head_vend_<?= $key ?>_<?= $k ?>" value="<?php echo $v->input[$key] ?>" id="teknis_head_vend_<?= $key ?>_<?= $k ?>" onkeyup="return only_number(event)">
                                            </th>
                                        <?php endforeach; ?>

                                    <tr>
                                <?php else: ?>
                                    <tr id="head_teknis_ts<?= $k ?>" class="sub_point_teknis_<?= $k ?>">
                                        <th>
                                            <span class="btn-sm btn btn-danger" onclick="remove_tek(head_teknis_ts<?= $k ?>, <?= $span ?>, '<?= $k ?>');"><i class="ft ft-trash"></i></span>
                                        </th>
                                        <th><input type="text" class="form_header" name="putusan_text_<?= $k ?>[]" value="<?php echo $a ?>"></th>
                                        <th><input type="text" class="form_header" name="putusan_bobot_<?= $k ?>[]" value="<?php echo $v->sub->sub_bobot[$e] ?>"> %</th>

                                        <?php foreach ($vend as $key => $value): ?>
                                            <th></th>
                                        <?php endforeach; ?>

                                    <tr>
                                <?php endif; ?>

                                <tbody id="sub_teknis_<?= $k+1?><?= $e+1 ?>" class="head_tek_sub_<?= $k+1 ?>"></tbody>
                            <?php endforeach; ?>

                            <tbody id="point_tek_<?= $k+1 ?>" class="poin_tek_head"></tbody>

                        <?php endforeach; ?>

                    </tbody>
                    <tr style="background-color: #2aace3;color: #fff;">
                        <td class="text-center">III</td>
                        <td align="left"><b>HARGA</b></td>
                        <td id="harga_perc" class="text-center"><?php echo $percent_harga ?></td>
                        <td colspan="<?= $span ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nilai HPS</td>
                        <td><input type="text" class="form_header uang last" name="nilai_hps" onchange="count_harga('<?= $span ?>')" onkeyup="return prevent_letter(event, 'uang')" value="<?php echo $nilai_hps ?>"></td>
                        <td colspan="<?= $span ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nilai</td>
                        <td></td>
                        <?php foreach ($nilai_hrg as $k => $v): ?>
                            <td class="text-center">
                                <span id="nilai_nilai_vend<?= $k ?>"><strong class="hrg" id="nli<?= $k ?>"><?php echo $v ?></strong></span>
                                <input type="hidden" class="nbnb" id="nilnil_vend<?= $k ?>" name="nilnil_vend[]" value="<?php echo $v ?>" />
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nilai x Bobot</td>
                        <td></td>
                        <?php foreach ($bobot_hrg as $k => $v): ?>
                            <td class="text-center">
                                <span id="nilai_bobot_vend<?=$k?>"><strong class="hrg" id="bbt<?=$k?>"><?php echo $v ?></strong></span>
                                <input type="hidden" class="nbnb" id="botbot_vend<?=$k?>" name="botbot_vend[]" value="<?php echo $v ?>" />
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Aspek Harga</th>
                        <th></th>
                        <th colspan="<?= $span ?>"></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Harga Negosiasi Final (dalam Rupiah)</td>
                        <td></td>
                        <?php foreach ($harga_nego as $k => $v): ?>
                            <td>
                                <input type="text" class="form_header uang nego last" onkeyup="return prevent_letter(event, 'uang')" onchange="count_harga('<?= $span ?>')" id="nego_final_vend<?=$k?>" name="nego_final_vend[]" value="<?php echo $v ?>">
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Deviasi terhadap Nilai HPS</td>
                        <td></td>
                        <?php foreach ($deviasi as $k => $v): ?>
                            <td class="text-center">
                                <span id="deviasi_hps_vend<?=$k?>" class="stats_adm"><strong class="hrg" id="hps<?=$k?>"><?php echo $v ?></strong></span>
                                <input type="hidden" class="nbnb" id="defdef_vend<?=$k?>" name="defdef_vend[]" value="<?php echo $v ?>" />
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th></th>
                        <th><strong>Total %</strong></th>
                        <th class="text-center" id="total_perc"><strong>100%</strong></th>
                        <th colspan="<?= $span ?>"></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2"><strong>NILAI EVALUASI TOTAL (NET)</strong></th>
                        <?php foreach ($evaluasi as $k => $v): ?>
                            <th class="text-center">
                                <strong id="eval_t<?=$k?>"><strong id="eval_hh<?=$k?>"><?php echo $v ?></strong></strong>
                                <input type="hidden" class="nbnb" id="evaeva_vend<?=$k?>" name="evaeva_vend[]" value="<?php echo $v ?>" />
                            </th>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2"><strong>PERINGKAT PEMENANG</strong></th>
                        <?php foreach ($peringkat as $k => $v): ?>
                            <th class="text-center">
                                <strong id="peringkat_vend<?=$k?>"><?php echo $v ?></strong>
                                <input type="hidden" class="nbnb" id="rankrank_vend<?=$k?>" name="rankrank_vend[]" value="<?php echo $v ?>" />
                            </th>
                        <?php endforeach; ?>
                    </tr>
                    <input type="hidden" name="edit_f" value="1">
                </table>
                <br>
            </div>
            </div>
        </div>
        <table id="esigntbl" style="width: 100%" class="table table-striped m-0">
            <tr style="background-color: #2aace3;">
                <th colspan="5">
                    E-Sign Kewenangan
                    <select style="width: 200px" class="ml-2 form_header" id="tipePlan" name="tipe_plan">
                        <option value="">Tipe Plan</option>
                        <option value="rkp" <?= $tipe_plan == 'rkp' ? 'selected' : '' ?>>PROYEK</option>
                        <option value="rkap" <?= $tipe_plan == 'rkap' ? 'selected' : '' ?>>NON PROYEK</option>
                        <option value="rkp_matgis" <?= $tipe_plan == 'rkp_matgis' ? 'selected' : '' ?>>MATGIS</option>
                    </select>
                    <select style="width: 200px" class="ml-2 form_header" id="komisi" name="komisi_">
                        <option value="">Komisi</option>
                        <option value="PUSAT" <?= $komisi_ == 'PUSAT' ? 'selected' : '' ?>>PUSAT</option>
                        <option value="DIVISI" <?= $komisi_ == 'DIVISI' ? 'selected' : '' ?>>DIVISI</option>
                        <option value="PROYEK" <?= $komisi_ == 'PROYEK' ? 'selected' : '' ?>>PROYEK</option>
                    </select>
                </th>
            </tr>
            <tr id="">
                <input type="hidden" name="keg_id" id="kegid" value="<?php echo $esign->kegiatan_id ?>">
                <input type="hidden" name="nipemploy" id="nipemploy" value="<?php echo $esign->nip ?>">
                <input type="hidden" name="hpemploy" id="hpemploy" value="<?php echo $esign->hp ?>">
                <td>
                    <select style="width: 300px" class="form_header select2" id="nmKew" name="nm_kew" readonly>
                        <option value="<?php echo $esign->nama ?>"><?php echo $esign->nama ?></option>
                    </select>
                </td>
                <td><input type="text" class="form_header form-control" name="fun_bidang" value="<?php echo $esign->fun_bidang ?>" id="fun_bidang" readonly></td>
                <td><input type="text" class="form_header form-control" name="job_title" value="<?php echo $esign->job_title ?>" id="job_title" readonly></td>
                <td><input type="text" class="form_header form-control" name="tempat" value="<?php echo $esign->tempat ?>"></td>
                <td><input type="date" class="form_header form-control" name="tanggal_ttd" value="<?php echo $esign->tanggal ?>"></td>
            </tr>
        </table>
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
        // console.log('start');
        // let d = $(this).val();
        // $.ajax({
        //     url: '<?php echo site_url($controller_name."/check_typlan_dsp");?>',
        //     method: 'post',
        //     data: {'tplan' : d},
        //     dataType: 'json',
        //     success: function(data) {
        //         opt_kom = `<option value="">Komisi</option>`
        //         if (data[0].komisi == null) {
        //             $('#komisi').html(opt_kom).attr("disabled", true);
        //             $(`#fun_bidang`).val('')
        //             $(`#job_title`).val('')
        //         } else {
        //             $.each(data, function(i, v) {
        //                 opt_kom += `<option value="${v.komisi}">${v.komisi}</option>`
        //             })
        //         }
        //     }
        // })
        $('#komisi').removeAttr('disabled');

        if (!$(`#required`).hasClass('hidden')) {
            $(`#required`).addClass('hidden')
        }
        // console.log('done');
    })

    $(`#komisi`).on('change', function() {
        if ($(`select[name=project]`).val() == '') {
            alert('Proyek harus dipilih!')
            $(this).val('');
            return false
        }
        console.log('start komisi');
        $(`#myLoader`).modal('show');
        let d = $(`#tipePlan`).val();
        let e = $(this).val();
        let s = $(`select[name=project]`).val();
        $.ajax({
            url: '<?php echo site_url($controller_name."/check_komisi_dsp");?>',
            method: 'post',
            data: {'komisi' : e, 'tplan':d, 'spk':s},
            dataType: 'json',
            success: function(res) {
                setTimeout(function() {

					data = res[0]
					nama = res[1]

					$(`#fun_bidang`).val(data[0].nm_fungsi_bidang)
					$(`#job_title`).val(data[0].job_title)
					$(`#kegid`).val(data[0].kegiatan_id)
					$(`#nipemploy`).val(data[0].nip)
					$(`#hpemploy`).val(data[0].handphone_1)
					$('#required').removeClass('hidden');

					opt_nm = `<option value="">Nama</option>`
					$.each(nama, function(i, v) {
						opt_nm += `<option value="${v.nm_peg}">${v.nm_peg}</option>`

					})
					$('#nmKew').html(opt_nm).removeAttr('disabled');

					$('#myLoader').modal('toggle');
					console.log('done');
				}, 1000);
            }
        })
    })

    let list_vend = '';
    $(document).ready(function(){
        $( '.uang' ).mask('0.000.000.000', {reverse: true});
        selectRefresh2()
        console.log('get list vendor');
        $.ajax({
            url: '<?php echo site_url($controller_name."/get_list_vendor");?>',
            method: 'post',
            data: {},
            dataType: 'json',
            success: function(data) {
                res_vendor = '<option value="">Pilih Vendor</option>';
                $.each(data[0], function(key, val){
                    res_vendor += '<option value="'+val.vendor_name+'-'+val.vendor_id+'">'+val.vendor_name+'</option>';
                });
                list_vend = res_vendor;
                selectRefresh2()
                console.log('done');
                $('#add_penyedia').removeClass('hidden')
            }
        })
    })

    function selectRefresh() {
        $('#add_penyedia_tbl .select2').select2({
            tags: true,
            placeholder: "Pilih",
            allowClear: true,
            width: '100%'
        });
    }

    function selectRefresh2() {
        $('#kegid .select2').select2({
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

    $(`#ajax_submit`).on('click', function() {
        let pengadaan = $(`input[name=paketPengadaan]`).val()
        let proyek = $(`#project`).val()
        let no_rfq = $(`input[name=nomor_rfq]`).val()

        let vendor=[];
        $("select[name=vendor]").each(function(){
            if ($(this).val() != '') {
                vendor.push($(this).val());
            }
        });

        let administrasi_poin = [];
        $(".administrasi_poin").each(function(){
            if ($(this).val() != '') {
                administrasi_poin.push($(this).val());
            }
        });

        let arr_adm = []
        let arr_admin = []
        for (var i = 0; i < administrasi_poin.length; i++) {

        }

        let data = [pengadaan, proyek, no_rfq, vendor, administrasi_poin];

        console.log(data);

        // $.ajax({
        //     url: '<?php echo site_url($controller_name."/submit_dsp");?>',
        //     method: 'post',
        //     data: {'data':'datadata'},
        //     dataType: 'json',
        //     success: function(data) {
        //         console.log(data);
        //     }
        // })
    })

    $('#add_penyedia').on('click', function() {
        var uniq = rand(3);
        var id_vend = 'vend_uniq_' + uniq;
        let html = '<tr id="'+id_vend+'"><td><select class="form-control select2" name="vendor" class="vend_val">'+list_vend+'</select></td><td><img class="ml-1" style="cursor: pointer;" width="20" height="20" src="<?php echo base_url('assets/img/remove.png') ?>" onclick="remove_ttd('+id_vend+')"/></td></tr>';
        $("#add_penyedia_tbl").append(html);
        selectRefresh()
    })

    $('#proses_tabel').on('click', function() {
        $(`#esigntbl`).removeClass('hidden')

        var vendor=[];
        $("select[name=vendor]").each(function(){
            if ($(this).val() != '') {
                vendor.push($(this).val());
            }
        });

        if(vendor.length < 1) {
            alert('Vendor harus dipilih!')
            return false;
        }
        $('#vend_section').addClass('hidden')


        let span_c = vendor.length

        let head_vend = def_head_vend(vendor)
        let adm_putusan = def_adm_putusan(vendor)
        let teknis = def_teknis_default(vendor)
        let threshold = def_teknis_threshold(vendor)
        let nilai = def_harga_nilai(vendor)
        let nego_final = def_nego_final(vendor)
        let deviasi_hps = def_deviasi_hps(vendor)
        let evaluasi_total = def_evaluasi_total(vendor)
        let peringkat = def_peringkat(vendor)

        var table = `
        <div class="row">
        <div class="col-12 table-responsive">
            <table style="width: 100%" class="table table-striped m-0" id="tbl_penilaian">
                <tr>
                    <th style='vertical-align: middle; width: 10%' class="text-center" rowspan="2">No</th>
                    <th style='vertical-align: middle; min-width:200px;' class="text-left" rowspan="2">Uraian</th>
                    <th style='vertical-align: middle; min-width:250px;' class="text-center" rowspan="2">Bobot</th>
                    <th class="text-center" style="width: 50%" colspan="${span_c}">Penyedia Barang dan Jasa <span class=" m-2 btn-sm btn btn-warning" onclick="form_reload();"><i class="ft ft-edit"></i></span></th>
                </tr>
                <tr>
                    ${head_vend}
                </tr>
                <tr style="background-color: #2aace3;color: #fff;">
                    <td class="text-center">I</td>
                    <td align="left"><b>ADMINISTRASI</b> <span class=" m-2 btn-sm btn btn-success" onclick="add_administrasi(${span_c});"><i class="ft ft-plus"></i></span></td>
                    <td class="text-center"><b>Wajib</b></td>
                    <td colspan="${span_c}"></td>
                </tr>
                <tr>
                    ${adm_putusan}
                </tr>
                <tbody id="row_adm_putusan"></tbody>
                <tr style="background-color: #2aace3;color: #fff;">
                    <td class="text-center">II</td>
                    <td align="left"><b>TEKNIS</b> <span class=" ml-2 btn-sm btn btn-success" onclick="add_teknis_point(${span_c});"><i class="ft ft-plus"></i></span></td>
                    <td ><input type="text" class="form_header numz" name="teknis_percent" value="" onchange="set_percent(${span_c})" onkeyup="return only_number(event)" required> %</td>
                    <td colspan="${span_c}"></td>
                </tr>
                <tr>
                    ${threshold}
                </tr>
                <tr>
                    <td></td>
                    <td>Nilai</td>
                    <td></td>
                    ${teknis[0]}
                </tr>
                <tr>
                    <td></td>
                    <td>Nilai x Bobot</td>
                    <td></td>
                    ${teknis[1]}
                </tr>
                <tbody id="row_tek"></tbody>
                <tr style="background-color: #2aace3;color: #fff;">
                    <td class="text-center">III</td>
                    <td align="left"><b>HARGA</b></td>
                    <td id="harga_perc" class="text-center">###</td>
                    <td colspan="${span_c}"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Nilai HPS</td>
                    <td><input type="text" class="form_header uang last" name="nilai_hps" onchange="count_harga('${span_c}')" onkeyup="return prevent_letter(event, 'uang')" value="" readonly></td>
                    <td colspan="${span_c}"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Nilai</td>
                    <td></td>
                    ${nilai[0]}
                </tr>
                <tr>
                    <td></td>
                    <td>Nilai x Bobot</td>
                    <td></td>
                    ${nilai[1]}
                </tr>
                <tr>
                    <th></th>
                    <th>Aspek Harga</th>
                    <th></th>
                    <th colspan="${span_c}"></th>
                </tr>
                <tr>${nego_final}</tr>
                <tr>${deviasi_hps}</tr>
                <tr>
                    <th></th>
                    <th><strong>Total %</strong></th>
                    <th class="text-center" id="total_perc"><strong>100%</strong></th>
                    <th colspan="${span_c}"></th>
                </tr>
                <tr>${evaluasi_total}</tr>
                <tr>${peringkat}</tr>
            </table>
            <br>
        </div>
        </div>
        `;

        $('#tbl_inp_dsp').html(table)
    })

    function form_reload() {
        if(confirm("Perhatian! Ubah vendor akan mereset seluruh form yang telah diisi.")){
            $('#vend_section').removeClass('hidden')
            $('#tbl_inp_dsp').html('')
            $(`#esigntbl`).addClass('hidden')
        }
    }

    function def_head_vend(vendor) {
        var cont = '';
        $.each(vendor, function(i, v) {
            d = v.split("-");
            cont += `
            <th style="word-break: break-all;" class="text-center">${d[0]}
                <input type="hidden" name="vendor_list[]" value="${d[1]}"
            </th>`;
        })

        return cont;
    }

    function def_adm_putusan(vendor) {
        let ve = vendor.length
        var cont = `<td></td><td>Putusan</td><td></td>`;

        $.each(vendor, function(i, v) {
            cont += `<td class="text-center"><span id="status_${i}" class="stats_adm">###</span><input type="hidden" id="val_status_${i}" name="status_adm_vendor[]" value="" /></td>`;
        })
        return cont;

    }

    function def_teknis_default(vendor) {
        let ve = vendor.length
        var nilai = '' ;
        var bobot = '';

        for (var i = 0; i < ve; i++) {
            nilai += `<td class="text-center"><span id="teknis_nilai_vend${i}">###</span><input type="hidden" id="ftek_nilai_${i}" name="nilai_tek[]" value="" /></td>`;
            bobot += `<td id="teknis_bobot_vend${i}" class="text-center">###</td><input id="ftek_bobot_${i}" type="hidden" name="bobot_tek[]" value="" />`;
        }

        return [nilai, bobot];
    }

    function def_harga_nilai(vendor) {
        let ve = vendor.length
        var nilai = '' ;
        var bobot = '';

        for (var i = 0; i < ve; i++) {
            nilai += `<td class="text-center"><span id="nilai_nilai_vend${i}">###</span><input type="hidden" class="nbnb" id="nilnil_vend${i}" name="nilnil_vend[]" value="" /></td>`;
            bobot += `<td class="text-center"><span id="nilai_bobot_vend${i}">###</span><input type="hidden" class="nbnb" id="botbot_vend${i}" name="botbot_vend[]" value="" /></td>`;
        }

        return [nilai, bobot];
    }

    function def_teknis_threshold(vendor) {
        let ve = vendor.length
        var cont = `<td></td><td>Threshold</td><td><input type="text" class="form_header numz" onchange="count_after_change(${ve})" onkeyup="return only_number(event)" name="threshold_tek" value="" required></td>`;

        $.each(vendor, function(i, v) {
            cont += `<td class="text-center"><span id="status_thresh_${i}" class="stats_adm">###</span><input type="hidden" id="val_status_thresh_${i}" name="status_tek_vendor[]" value="" /></td>`;
        })
        return cont;
    }

    function def_nego_final(vendor) {
        let ve = vendor.length
        var cont = `
            <td></td>
            <td>Harga Negosiasi Final (dalam Rupiah)</td>
            <td></td>
        `;

        $.each(vendor, function(i, v) {
            cont += `<td><input type="text" class="form_header uang nego last" onkeyup="return prevent_letter(event, 'uang')" onchange="count_harga('${ve}')" id="nego_final_vend${i}" name="nego_final_vend[]" value="" readonly></td>`;
        })
        return cont;
    }

    function def_deviasi_hps(vendor) {
        let ve = vendor.length
        var cont = `
            <td></td>
            <td>Deviasi terhadap Nilai HPS</td>
            <td></td>
        `;

        $.each(vendor, function(i, v) {
            cont += `<td class="text-center"><span id="deviasi_hps_vend${i}" class="stats_adm">###</span><input type="hidden" class="nbnb" id="defdef_vend${i}" name="defdef_vend[]" value="" /></td>`;
        })
        return cont;
    }

    function def_evaluasi_total(vendor) {
        let ve = vendor.length
        var cont = `
            <th></th>
            <th colspan="2"><strong>NILAI EVALUASI TOTAL (NET)</strong></th>
        `;

        $.each(vendor, function(i, v) {
            cont += `<th class="text-center"><strong id="eval_t${i}">###</strong><input type="hidden" class="nbnb" id="evaeva_vend${i}" name="evaeva_vend[]" value="" /></th>`;
        })
        return cont;
    }

    function def_peringkat(vendor) {
        let ve = vendor.length
        var cont = `
            <th></th>
            <th colspan="2"><strong>PERINGKAT PEMENANG</strong></th>
        `;

        $.each(vendor, function(i, v) {
            cont += `<th class="text-center"><strong id="peringkat_vend${i}">###</strong><input type="hidden" class="nbnb" id="rankrank_vend${i}" name="rankrank_vend[]" value="" /></th>`;
        })
        return cont;
    }

    function add_administrasi(vendor) {
        let r = $('.class_st_adm').length;
        rr = r + 1;

        var p = $(".head_putusan").length;
        var un = parseInt(p) + 1
        var uniq = rand(3)
        var html = `
        <tr id="head_putusan_${uniq}" class="head_putusan">
            <input type="hidden" name="adm_uniq[]" value="${uniq}">
            <th>
                <span class="btn-sm btn btn-danger" onclick="remove_adm(head_putusan_${uniq}, ${vendor});"><i class="ft ft-trash"></i></span>
                <span class="btn-sm btn btn-info" onclick="add_sub_administrasi('${rr}', ${un}, ${vendor}, '${uniq}');">Sub <i class="ft ft-plus"></i></span>
            </th>
            <th colspan="2"><input type="text" class="form_header administrasi_poin" name="administrasi_poin_${uniq}" value="" required></th>
            <th colspan="${vendor}"></th>
        <tr>
        `;

        if (r > 0) {
            $("#adm_st_" + r).after(html);
        } else {
            $("#row_adm_putusan").after(html);
        }

        $("#head_putusan_" + uniq).after('<tbody id="adm_st_'+rr+'" class="class_st_adm"></tbody>')
    }

    function add_sub_administrasi(u, tot, vendor, uq) {
        console.log(tot);
        var cont = ``;
        for (var i = 0; i < vendor; i++) {
            cont += `<td>
            <select class="form-control form_header select_adm_putusan_${i}" name="adm_pilihan_${i}_${uq}[]" onchange="is_pass(${i})">
                <option value="">Pilih</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
            </select>
            </td>`;
        }

        var uniq = rand(3)
        var html = `
        <tr id="row_putusan_sub_${uniq}" class="sub_head_putusan_${uq}">
            <td>
                <span class="btn-sm btn btn-danger" onclick="remove_adm(row_putusan_sub_${uniq}, ${vendor});"><i class="ft ft-trash"></i></span>
            </td>
            <td><input type="text" class="form_header" name="sub_administrasi_poin_text_${uq}[]" value=""></td>
            <td><input type="text" class="form_header" name="sub_administrasi_poin_bobot_${uq}[]" value=""></td>
            ${cont}
        <tr>
        `;

        $("#adm_st_" + u).append(html);
    }

    function is_pass(vend) {
        var status=[];
        $(`.select_adm_putusan_${vend}`).each(function(){
            status.push($(this).val());
        });

        if(jQuery.inArray("Tidak", status) != -1) {
            $('#val_status_' + vend).val('Tidak Lulus')
            $('#status_' + vend).html('<strong>Tidak Lulus</strong>')
        } else {
            $('#val_status_' + vend).val('Lulus')
            $('#status_' + vend).html('<strong>Lulus</strong>')
        }
    }

    function add_teknis_point(vendor) {
        // close form harga
        // $('.last').attr("readonly", true);
        $('.last').val(``);
        $('.hrg').html(`###`);
        $('.nbnb').val('');

        var uniq = rand(3);

        var cont = ``;
        for (var i = 0; i < vendor; i++) {
            cont += `<th class="text-center"><span id="teknis_point_${i}_${uniq}">###</span><input type="hidden" id="has_poin${i}_${uniq}" name="hasil_poin_${i}_${uniq}" value="" /></th>`;
        }

        let r = $('.poin_tek_head').length;
        rr = r + 1;

        let s = $('.head_tek_sub_' + r).length;
        ss = s + 1;

        var p = $(".point_teknis").length;
        var un = parseInt(p) + 1

        var html = `
            <tr id="point_teknis_${uniq}" class="point_teknis">
                <input type="hidden" name="tekuniq[]" value="${uniq}">
                <th>
                    <span class="btn-sm btn btn-danger" onclick="remove_tek(point_teknis_${uniq}, ${vendor}, '${uniq}');"><i class="ft ft-trash"></i></span>
                    <span class="btn-sm btn btn-info" onclick="add_teknis_head('${rr}', ${un}, ${vendor}, '${uniq}');">Sub <i class="ft ft-plus"></i></span>
                </th>
                <th><input type="text" class="form_header" name="teknis_point_${uniq}" value="" required></th>
                <th><input type="text" class="form_header numz" id="tek_perc_${uniq}" onchange="re_count_tek(${vendor}, '${uniq}')" name="teknis_percent_${uniq}" value="" onkeyup="return only_number(event)"> %</th>
                ${cont}
            </tr>
        `;

        if (s > 0) {
            $('#sub_teknis_' + r + s).after(html)
        } else {
            if (r > 0) {
                $("#point_tek_" + r).after(html);
            } else {
                $("#row_tek").after(html);
            }
        }

        $("#point_teknis_" + uniq).after('<tbody id="point_tek_'+rr+'" class="poin_tek_head"></tbody>')
    }

    function add_teknis_head(u, tot, vendor, uq) {
        // $(`#tek_perc_${uq}`).attr("readonly", false);

        var uniq = rand(3)

        var p = $(".sub_point_teknis_" + uq).length;
        var un = parseInt(p) + 1

        let uniq2 = '';
        if (uniq2 == ''){
            uniq2 = uniq
        }

        var cont = ``;
        if (p < 1){
            for (var i = 0; i < vendor; i++) {
                inn = i.toString()
                in2 = uniq.concat(inn)
                cont += `<th class="inp_poin_${i}_${uq}" rowspan=1><input type="text" onchange="count_teknis(${i}, '${uq}')" class="form_header numz chk chg${i}" name="teknis_head_vend_${i}_${uq}" value="" id="teknis_head_vend_${i}_${uq}" onkeyup="return only_number(event)"></th>`;
            }
        } else {
            for (var i = 0; i < vendor; i++) {
                cont += `<th></th>`;
                inn = i.toString()
                in2 = uniq.concat(inn)
                $('.inp_poin_' + i).attr('rowspan', p+1);
            }
        }


        let r = $('.head_tek_sub_' + u).length;
        rr = r + 1;
        uu = u.toString();
        re = u.concat(rr.toString())

        un = u.toString()
        um = un.concat(r.toString())

        if (r > 0) {
            var html = `
            <tr id="head_teknis_${uniq}" class="sub_point_teknis_${uq}">
                <th>
                    <span class="btn-sm btn btn-danger" onclick="remove_tek(head_teknis_${uniq}, ${vendor}, '${uq}');"><i class="ft ft-trash"></i></span>
                </th>
                <th><input type="text" class="form_header" name="putusan_text_${uq}[]" value=""></th>
                <th><input type="text" class="form_header" name="putusan_bobot_${uq}[]" value=""> %</th>
                ${cont}
            <tr>
            `;
            $("#sub_teknis_" + um).after(html);
        } else {
            var html = `
            <tr id="head_teknis_${uniq}" class="sub_point_teknis_${uq}">
                <th></th>
                <th><input type="text" class="form_header" name="putusan_text_${uq}[]" value=""></th>
                <th><input type="text" class="form_header" name="putusan_bobot_${uq}[]" value=""> %</th>
                ${cont}
            <tr>
            `;
            $("#point_tek_" + u).after(html);
        }

        $("#head_teknis_" + uniq).after('<tbody id="sub_teknis_'+re+'" class="head_tek_sub_'+u+'"></tbody>')
    }

    function add_sub_teknis(u, tot, vendor, uq) {
        var cont = ``;
        for (var i = 0; i < vendor; i++) {
            cont += `<td><input type="text" class="form_header" name="sub_putusan_${i}_vend[]" value=""></td>`;
        }

        var uniq = rand(3)
        var html = `
        <tr id="row_tek_sub${uniq}" class="sub_head_teknis_${uq}">
            <td class="text-right">
                <span class="btn-sm btn btn-danger" onclick="remove_ttd(row_tek_sub${uniq});"><i class="ft ft-trash"></i></span>
            </td>
            <td><input type="text" class="form_header" name="sub_putusan_${tot}_text[]" value=""></td>
            <td><input type="text" class="form_header" name="sub_putusan_${tot}_bobot[]" value=""></td>
            ${cont}
        <tr>
        `;

        $("#sub_teknis_" + u).append(html);
    }

    function remove_ttd(id) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
		$(id).remove();
	}

    function remove_tek(id, vendor, row) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
		$(id).remove();

        count_after_remove(vendor)
	}

    function count_after_remove(vendor) {
        // close form harga
        // $('.last').attr("readonly", true);
        $('.last').val(``);
        $('.hrg').html(`###`);
        $('.nbnb').val('')

        let teknis = $(`input[name=teknis_percent]`).val()
        let threshold = $(`input[name=threshold_tek]`).val()

        for (var i = 0; i < vendor; i++) {
            var nn=[];
            $(`.tpp_${i}`).each(function(){
                nn.push($(this).html());
            });

            let nilai = 0;
            for (var j = 0; j < nn.length; j++) {
                nilai += parseFloat(nn[j])
            }

            if (nilai < 1) {
                $(`#nilai_tek_${i}`).html(`<strong id="nilai_tek_${i}">###</strong>`)
                $(`#ftek_nilai_${i}`).val('');
                $(`#teknis_bobot_vend${i}`).html(`<strong id="nnb${i}">###</strong>`)
                $(`#ftek_bobot_${i}`).val('');
                $(`#status_thresh_${i}`).html(`<strong>###</strong>`)
                $(`#val_status_thresh_${i}`).val('')
            } else {
                $(`#nilai_tek_${i}`).html(`<strong id="nilai_tek_${i}">${nilai.toFixed(2)}`)
                $(`#ftek_nilai_${i}`).val(nilai.toFixed(2));

                let bbt = (nilai * teknis) / 100
                $(`#teknis_bobot_vend${i}`).html(`<strong id="nnb${i}">${bbt.toFixed(2)}</strong>`)
                $(`#ftek_bobot_${i}`).val(bbt.toFixed(2));

                if (nilai > threshold){
                    $(`#val_status_thresh_${i}`).val('Lulus')
                    $(`#status_thresh_${i}`).html(`<strong>Lulus</strong>`)
                } else {
                    $(`#val_status_thresh_${i}`).val('Tidak Lulus')
                    $(`#status_thresh_${i}`).html(`<strong>Tidak Lulus</strong>`)
                }
            }
        }
    }

    function re_count_tek(vendor, row) {
        if ($(`.sub_point_teknis_${row}`).length < 1) {
            alert('Harus tambah sub poin terlebih dahulu.')
            $(`#tek_perc_${row}`).val('')
            return false;
        }

        $('.last').val(``);
        $('.hrg').html(`###`);

        let teknis = $(`input[name=teknis_percent]`).val()
        let threshold = $(`input[name=threshold_tek]`).val()

        if (teknis != '' && threshold !=''){
            for (var vend = 0; vend < vendor; vend++) {
                let this_form = $(`#teknis_head_vend_${vend}_${row}`).val()
                let this_head = $(`#tek_perc_${row}`).val()
                if (this_head != ''){
                    let head_form = this_form * (this_head / 100)
                    $(`#teknis_point_${vend}_${row}`).html(`<strong class="tpp_${vend} teknis_point_${vend}_${row}">${head_form.toFixed(2)}</strong>`)
                    var nn=[];
                    $(`.tpp_${vend}`).each(function(){
                        nn.push($(this).html());
                    });

                    let nli = $(`.teknis_point_${vend}_${row}`).html();
                    $(`#has_poin${vend}_${row}`).val(nli)

                    let nilai = 0;
                    for (var i = 0; i < nn.length; i++) {
                        nilai += parseFloat(nn[i])
                    }

                    $(`#teknis_nilai_vend${vend}`).html(`<strong id="nilai_tek_${vend}">${nilai.toFixed(2)}</strong>`)
                    $(`#ftek_nilai_${vend}`).val(nilai.toFixed(2));

                    let nilai_tekn = $(`#nilai_tek_${vend}`).html()
                    let bobot  = nilai_tekn * (teknis / 100)
                    $(`#teknis_bobot_vend${vend}`).html(`<strong id="nnb${vend}">${bobot.toFixed(2)}</strong>`)
                    $(`#ftek_bobot_${vend}`).val(bobot.toFixed(2));
                    if (nilai > threshold){
                        $(`#val_status_thresh_${vend}`).val('Lulus')
                        $(`#status_thresh_${vend}`).html(`<strong>Lulus</strong>`)
                    } else {
                        $(`#val_status_thresh_${vend}`).val('Tidak Lulus')
                        $(`#status_thresh_${vend}`).html(`<strong>Tidak Lulus</strong>`)
                    }
                }
            }
        } else {
            alert('Form Teknis dan Threshold harus diisi!')
            $(`#tek_perc_${row}`).val('')
            return false;
        }

    }

    function set_percent(vendor) {
        let nilai = $("input[name=teknis_percent]").val()
        c = `<strong>${100-nilai}%</strong> <input type="hidden" name="percent_harga" value="${100-nilai}" />`
        $('#harga_perc').html(c)

        count_after_change(vendor)
    }

    function count_after_change(vendor) {
        $('.last').val(``);
        $('.hrg').html(`###`);
        $('.nbnb').val('')

        let teknis = $(`input[name=teknis_percent]`).val()
        let threshold = $(`input[name=threshold_tek]`).val()

        let cnn = 0
        for (var i = 0; i < vendor; i++) {

            $(`#eval_hh${i}`).html(`<strong id="eval_hh${i}">###</strong>`);
            $(`#peringkat_vend${i}`).html(`<strong id="peringkat_vend${i}">###</strong>`);
            // $(`#rankrank_vend${i}`).val(0)

            var nn=[];
            $(`.tpp_${i}`).each(function(){
                nn.push($(this).html());
            });

            if (nn.length > 0) { cnn++ }

            if (cnn > 0) {
                let nilai = 0;
                for (var j = 0; j < nn.length; j++) {
                    nilai += parseFloat(nn[j])
                }
                if (nilai < 1) {
                    $(`#nilai_tek_${i}`).html(`<strong id="nilai_tek_${i}">###</strong>`)
                    $(`#ftek_nilai_${i}`).val('');
                    $(`#teknis_bobot_vend${i}`).html(`<strong id="nnb${i}">###</strong>`)
                    $(`#ftek_bobot_${i}`).val('');
                    $(`#status_thresh_${i}`).html(`<strong>###</strong>`)
                    $(`#val_status_thresh_${i}`).val('')
                } else {
                    $(`#nilai_tek_${i}`).html(`<strong id="nilai_tek_${i}">${nilai.toFixed(2)}</strong>`)
                    $(`#ftek_nilai_${i}`).val();

                    let bbt = (nilai * teknis) / 100
                    $(`#teknis_bobot_vend${i}`).html(`<strong id="nnb${i}">${bbt.toFixed(2)}</strong>`)
                    $(`#ftek_bobot_${i}`).val(bbt.toFixed(2));

                    if (nilai > threshold){
                        $(`#val_status_thresh_${i}`).val('Lulus')
                        $(`#status_thresh_${i}`).html(`<strong>Lulus</strong>`)
                    } else {
                        $(`#val_status_thresh_${i}`).val('Tidak Lulus')
                        $(`#status_thresh_${i}`).html(`<strong>Tidak Lulus</strong>`)

                    }
                }
            }

        }
    }

    function remove_adm(id, vendor) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
		$(id).remove();

        for (var i = 0; i < vendor; i++) {
            var status=[];
            $(`.select_adm_putusan_${i}`).each(function(){
                if($(this).val() != ''){
                    status.push($(this).val());
                }
            });

            if (status.length > 0 ){
                if(jQuery.inArray("Tidak", status) != -1) {
                    $('#val_status_' + i).val('Tidak Lulus')
                    $('#status_' + i).html('<strong>Tidak Lulus</strong>')
                } else {
                    $('#val_status_' + i).val('Lulus')
                    $('#status_' + i).html('<strong>Lulus</strong>')
                }
            } else {
                $('#status_' + i).html('<strong>###</strong>')
            }
        }
	}

    function count_teknis(vend, row) {
        let teknis = $(`input[name=teknis_percent]`).val()
        let threshold = $(`input[name=threshold_tek]`).val()
        if (teknis != '' && threshold !=''){
            $('.last').val(``);
            $('.hrg').html(`###`);
            $('.nbnb').val('')

            let this_form = $(`#teknis_head_vend_${vend}_${row}`).val()
            let this_head = $(`#tek_perc_${row}`).val()
            if (this_head != ''){
                let head_form = this_form * (this_head / 100)
                $(`#teknis_point_${vend}_${row}`).html(`<strong class="tpp_${vend} teknis_point_${vend}_${row}">${head_form.toFixed(2)}</strong>`)
                var nn=[];
                $(`.tpp_${vend}`).each(function(){
                    nn.push($(this).html());
                });

                let nli = $(`.teknis_point_${vend}_${row}`).html();
                $(`#has_poin${vend}_${row}`).val(nli)

                let nilai = 0;
                for (var i = 0; i < nn.length; i++) {
                    nilai += parseFloat(nn[i])
                }

                $(`#teknis_nilai_vend${vend}`).html(`<strong id="nilai_tek_${vend}">${nilai.toFixed(2)}</strong>`)
                $(`#ftek_nilai_${vend}`).val(nilai.toFixed(2));

                let nilai_tekn = $(`#nilai_tek_${vend}`).html()
                let bobot  = nilai_tekn * (teknis / 100)
                $(`#teknis_bobot_vend${vend}`).html(`<strong id="nnb${vend}">${bobot.toFixed(2)}</strong>`)
                $(`#ftek_bobot_${vend}`).val(bobot.toFixed(2));
                if (nilai > threshold){
                    $(`#val_status_thresh_${vend}`).val('Lulus')
                    $(`#status_thresh_${vend}`).html(`<strong>Lulus</strong>`)
                } else {
                    $(`#val_status_thresh_${vend}`).val('Tidak Lulus')
                    $(`#status_thresh_${vend}`).html(`<strong>Tidak Lulus</strong>`)
                }


                // open form harga
                let chk = []
                $('.chk').each(function() {
                    if ($(this).val() != ''){
                        chk.push($(this).val())
                    }
                })

                let tchk = $('.chk').length;
                if (chk.length === tchk) {
                    $('.last').attr("readonly", false);
                }
            } else {
                $(`#teknis_head_vend_${vend}_${row}`).val('')
                alert('Bobot harus diisi!')
            }
        } else {
            $(`#teknis_head_vend_${vend}_${row}`).val('')
            alert('Form Teknis dan Threshold harus diisi!')
        }
    }

    function count_harga(ve) {
        let teknis = $(`input[name=teknis_percent]`).val()
        let hps = $(`input[name=nilai_hps]`).val()
        let nhps = parseInt(hps.split('.').join(""));

        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        });

        if (teknis != '') {
            if (hps != '') {
                var nn=[];
                $(`.nego`).each(function(){
                    if (!isNaN(parseInt($(this).val().split('.').join("")))) {
                        nn.push(parseInt($(this).val().split('.').join("")));
                    }
                });

                let l = $("input[name=teknis_percent]").val()
                let prc = (100 - l) / 100;

                let min = Math.min.apply(Math, nn);
                if (parseInt(ve) == nn.length) {
                    let rr = [];
                    for (var i = 0; i < nn.length; i++) {
                        let inn = $(`#nego_final_vend${i}`).val()
                        let in2 = parseInt(inn.split('.').join(""));
                        let nil = (min / in2) * 100;

                        $(`#nilai_nilai_vend${i}`).html(`<strong class="hrg" id="nli${i}">${nil.toFixed(2)}</strong>`)
                        $(`#nilnil_vend${i}`).val(nil.toFixed(2))
                        $(`#nilai_bobot_vend${i}`).html(`<strong class="hrg" id="bbt${i}">${(prc * nil).toFixed(2)}</strong>`)
                        $(`#botbot_vend${i}`).val((prc * nil).toFixed(2))

                        let dev = nhps - in2;
                        $(`#deviasi_hps_vend${i}`).html(`<strong class="hrg" id="hps${i}">${formatter.format(dev)}</strong>`)
                        $(`#defdef_vend${i}`).val(dev)

                        let bbh = $(`#bbt${i}`).html()
                        let bbh2 = parseFloat(bbh)

                        let bbt = $(`#nnb${i}`).html()
                        let bbt2 = parseFloat(bbt)

                        let res_eval = bbh2 + bbt2;
                        $(`#eval_t${i}`).html(`<strong id="eval_hh${i}">${res_eval.toFixed(2)}</strong>`)
                        $(`#evaeva_vend${i}`).val(res_eval.toFixed(2))

                        let fl = res_eval.toFixed(2)
                        rr.push(parseFloat(fl))
                    }

                    let ra = rr.sort(function(a,b) { return a - b;}).reverse();
                    console.log(ra);
                    for (var i = 0; i < nn.length; i++) {
                        let evalflo = parseFloat($(`#eval_hh${i}`).html());
                        let rank = ra.indexOf(evalflo) + 1;
                        $(`#peringkat_vend${i}`).html(`<strong>${rank}</strong>`)
                        $(`#rankrank_vend${i}`).val(rank)
                    }
                }
            } else {
                alert('Nilai HPS harus diisi!')
                $(`#nego_final_vend${vend}`).val('')
            }
        } else {
            alert('Bobot Teknis harus diisi!')
            $(`#nego_final_vend${vend}`).val('')
        }
    }

    function prevent_letter(e, le) {
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(`.uang`).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
        });
    }

    function only_number(e) {
        if(event.which >= 37 && event.which <= 40) return;
        // format number
        $(`.numz`).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            ;
        });
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


    // {
    //     administrasi : {
    //         0 : {
    //             title : 'judul poin 1',
    //             sub : {
    //                 0 : 'sub poin 11',
    //                 1 : 'sub poin 12',
    //                 2 : 'sub poin 13'
    //             },
    //             bobot : {
    //                 0 : 'bobot poin 11',
    //                 1 : 'bobot poin 12',
    //                 2 : 'bobot poin 13',
    //             },
    //             vendor : {
    //                 0 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //                 1 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //                 2 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //             }
    //         },
    //         1 : {
    //             title : 'judul poin 2',
    //             sub : {
    //                 0 : 'sub poin 21',
    //                 1 : 'sub poin 22',
    //                 2 : 'sub poin 23'
    //             },
    //             bobot : {
    //                 0 : 'bobot poin 21',
    //                 1 : 'bobot poin 22',
    //                 2 : 'bobot poin 23',
    //             },
    //             vendor : {
    //                 0 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //                 1 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //                 2 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //             }
    //         },
    //         2 : {
    //             title : 'judul poin 2',
    //             sub : {
    //                 0 : 'sub poin 11',
    //                 1 : 'sub poin 12',
    //                 2 : 'sub poin 13'
    //             },
    //             bobot : {
    //                 0 : 'bobot poin 11',
    //                 1 : 'bobot poin 12',
    //                 2 : 'bobot poin 13',
    //             },
    //             vendor : {
    //                 0 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //                 1 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //                 2 : {
    //                     status : true,
    //                     pilihan : {
    //                         0: 'ya',
    //                         1: 'ya',
    //                         2: 'ya'
    //                     },
    //                 },
    //             }
    //         }
    //     },
    //     teknis : {
    //         percent_teknis : 40%,
    //         thershold : 70,
    //         nilai {
    //             //vendor
    //             0 : 100,
    //             1 : 100,
    //             2 : 100,
    //         },
    //         niaixbobot : {
    //             //vendor
    //             0 : 50,
    //             1 : 50,
    //             2 : 50,
    //         }
    //         status : {
    //             //vendor
    //             0 : 'lulus'
    //             1 : 'lulus'
    //             2 : 'lulus',
    //         }
    //         poin : {
    //             // loop poin
    //             0 : {
    //                 title : 'Poin 1',
    //                 bobot : 20%,
    //                 hasil : {
    //                     //vendor
    //                     0 : 69,
    //                     1 : 89,
    //                     2 : 70
    //                 },
    //                 nilai_input : {
    //                     //vendor
    //                     0 : 69,
    //                     1 : 89,
    //                     2 : 70
    //                 }
    //                 sub_poin : {
    //                     // loop sub poin
    //                     0 : {
    //                         title : 'sub_poin 11',
    //                         desc : '100 - 80',
    //                     },
    //                     1 : {
    //                         title : 'sub_poin 12',
    //                         desc : '80 - 60',
    //                     }
    //                 }
    //             },
    //             1 : {
    //                 title : 'Poin 2',
    //                 bobot : 80%,
    //                 hasil : {
    //                     //vendor
    //                     0 : 69,
    //                     1 : 89,
    //                     2 : 70
    //                 },
    //                 nilai_input : {
    //                     //vendor
    //                     0 : 69,
    //                     1 : 89,
    //                     2 : 70
    //                 }
    //                 sub_poin : {
    //                     0 : {
    //                         title : 'sub_poin 21',
    //                         desc : '100 - 80',
    //                     },
    //                     1 : {
    //                         title : 'sub_poin 22',
    //                         desc : '80 - 60',
    //                     }
    //                 }
    //             },
    //         }
    //     },
    //     harga : {
    //         percent_harga : 60%,
    //         nilai_hps : 100000,
    //         nilai : {
    //             //vendor
    //             0 : 50,
    //             1 : 50,
    //             2 : 50
    //         },
    //         nilaixbobot : {
    //             // vendor
    //             0 : 56,
    //             1 : 56,
    //             2 : 70
    //         }
    //         harga_nego : {
    //             0 : 100000,
    //             1 : 200000,
    //             2 : 300000
    //         },
    //         deviasi : {
    //             0 : 100000,
    //             1 : 200000,
    //             2 : 300000
    //         },
    //         nilai_evaluasi : {
    //             0 : 100000,
    //             1 : 200000,
    //             2 : 300000
    //         },
    //         peringkat : {
    //             0 : 1,
    //             1 : 2,
    //             2 : 3
    //         }
    //     }
    // }

    //
    // {
    //     id : id,
    //     paket_pengadaan: 'alsdfja',
    //     proyek: 'jkasdfl',
    //     nomor_rfq: 'alskfja',
    //     percent_teknis: 90,
    //     threshold: 70,
    //     vendor : {
    //         0 : {
    //             administrasi : {
    //                 status_administrasi: 'lulus',
    //                 poin_administrasi : {
    //                     0 : {
    //                         head_poin: 'head poin1',
    //                         sub_poin: {
    //                             0 : subpoin1,
    //                             1 : subpoin2,
    //                             2 : subpoin3,
    //                         },
    //                         bobot_poin: {
    //                             0 : bobot1,
    //                             1 : bobot2,
    //                             2 : bobot3
    //                         },
    //                         pilihan_status: {
    //                             0 : pilihan1,
    //                             1 : pilihan2,
    //                             2 : pilihan3
    //                         }
    //                     },
    //                     1 : {
    //                         head_poin: 'head poin2',
    //                         sub_poin: {
    //                             0 : subpoin1,
    //                             1 : subpoin2,
    //                             2 : subpoin3,
    //                         },
    //                         bobot_poin: {
    //                             0 : bobot1,
    //                             1 : bobot2,
    //                             2 : bobot3
    //                         },
    //                         pilihan_status: {
    //                             0 : pilihan1,
    //                             1 : pilihan2,
    //                             2 : pilihan3
    //                         }
    //                     },
    //                     2 : {
    //                         head_poin: 'head poin3',
    //                         sub_poin: {
    //                             0 : subpoin1,
    //                             1 : subpoin2,
    //                             2 : subpoin3,
    //                         },
    //                         bobot_poin: {
    //                             0 : bobot1,
    //                             1 : bobot2,
    //                             2 : bobot3
    //                         },
    //                         pilihan_status: {
    //                             0 : pilihan1,
    //                             1 : pilihan2,
    //                             2 : pilihan3
    //                         }
    //                     },
    //                 },
    //             },
    //             teknis : {
    //                 status : 'lulus'
    //                 nilai: 100,
    //                 bobotxnilai : 80,
    //                 poin_teknis : {
    //                     0 : {
    //
    //                     },
    //                     1 : {
    //
    //                     },
    //                     2 : {
    //
    //                     },
    //                 }
    //             }
    //         },
    //     }
    // }
</script>
