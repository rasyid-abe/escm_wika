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
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI</b></p></li>
                    <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN SISTEM PENILAIAN</b></p></li>
                    <?php if ($mtd == "Penunjukan_Langsung"): ?>
                        <li class=""><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PENUNJUKAN LANGSUNG</b></p></li>
                    <?php else: ?>
                        <li class=""><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PEMENANG</b></p></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <br>

    <form method="post" action="<?php echo site_url($controller_name."/submit_dsp");?>"  class="form-horizontal ajaxform">

        <div class="row mt-3 mb-3">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-sm-2 mb-2 control-label text-left text-bold-700"><strong>Paket Pengadaan</strong> <span class="text-danger text-bold-700">*</span></label>
                    <div class="col-sm-10 mb-2">
                        <input type="text" class="form-control" name="paketPengadaan" id="paketPengadaan" placeholder="Paket Pengadaan" value="<?php echo trim($pengadaan) ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 mb-2 control-label text-left text-bold-700"><strong>Proyek</strong> <span class="text-danger text-bold-700">*</span></label>
                    <div class="col-sm-10 mb-2">
                        <select class="form-control" name="project" id="project">
                            <?php foreach($projects as $key => $val){ ?>
                                <?php if ($proyek == $val['ppm_project_id']): ?>
                                    <option value='<?php echo $val['ppm_project_id']; ?>' ><?php echo $val['ppm_subject_of_work']; ?></option>
                                <?php endif; ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 mb-2 control-label text-left text-bold-700"><strong>Nomor RFQ </strong> <span class="text-danger text-bold-700">*</span></label>
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
                        <td align="left"><b>ADMINISTRASI</b></td>
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

                        <?php $ik = 0; foreach ($adm_poin as $k => $v): ?>

                            <tr id="head_putusan_p<?= $ik ?>" class="head_putusan">
                                <input type="hidden" name="adm_uniq[]" value="p<?= $ik ?>">
                                <td align="center"><?= $alpha[$ik]; ?></td>
                                <td><input type="text" class="form_header administrasi_poin" name="sub_administrasi_poin_text[]" value="<?php echo $v ?>" required></td>
                                <td><input type="text" class="form_header" name="sub_administrasi_poin_bobot[]" value="<?php echo $adm_bobot[$ik] ?>"></td>
                                <?php $jk = 0; foreach ($adm_vendor as $ke => $va): ?>
                                    <td>
                                        <select class="form-control form_header select_adm_putusan_<?= $ke?>" name="adm_pilihan_<?= $ke ?>[]" onchange="is_pass(<?= $ke ?>)">
                                            <option value="">Pilih</option>
                                            <option <?= $adm_vendor[$ke][$ik] == "Ya" ? 'selected' : '' ?> value="Ya">Ya</option>
                                            <option <?= $adm_vendor[$ke][$ik] == "Tidak" ? 'selected' : '' ?> value="Tidak">Tidak</option>
                                        </select>
                                    </td>
                                <?php $jk++; endforeach; ?>
                            <tr>
                            <tbody id="adm_st_<?= $ik+1?>" class="class_st_adm"></tbody>

                        <?php $ik++; endforeach; ?>

                    </tbody>
                    <tr style="background-color: #2aace3;color: #fff;">
                        <td class="text-center">II</td>
                        <td align="left"><b>TEKNIS</b></td>
                        <td>
                            <select class="form-control form_header" name="teknis_percent" onchange="set_percent(<?= $span ?>)">
                                <option <?= $percent_teknis == 20 ? 'selected' : ''?> value="20">20%</option>
                                <option <?= $percent_teknis == 30 ? 'selected' : ''?> value="30">30%</option>
                                <option <?= $percent_teknis == 40 ? 'selected' : ''?> value="40">40%</option>
                                <option <?= $percent_teknis == 50 ? 'selected' : ''?> value="50">50%</option>
                            </select>
                        </td>
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

                            <?php if ($k == 0): ?>
                    			<tr style='background-color: lightgray; font-weight: bold'>
                    				<td align="center">A</td>
                    				<td colspan="<?php echo $span + 2 ?>">ASPEK MUTU</td>
                    			</tr>
                    		<?php elseif ($k == 3): ?>
                    			<tr style='background-color: lightgray; font-weight: bold'>
                    				<td align="center">B</td>
                    				<td colspan="<?php echo $span + 2 ?>">ASPEK WAKTU</td>
                    			</tr>
                    		<?php elseif ($k == 4): ?>
                    			<tr style='background-color: lightgray; font-weight: bold'>
                    				<td align="center">C</td>
                    				<td colspan="<?php echo $span + 2 ?>">ASPEK SHE</td>
                    			</tr>
                    		<?php elseif ($k == 5): ?>
                    			<tr style='background-color: lightgray; font-weight: bold'>
                    				<td align="center">D</td>
                    				<td colspan="<?php echo $span + 2 ?>">ASPEK KEUANGAN</td>
                    			</tr>
                    		<?php endif; ?>

                            <tr id="point_teknis_<?= $k ?>" class="point_teknis">
                                <input type="hidden" name="tekuniq[]" value="<?= $k ?>">
                                <th class="text-center"><?= $k+1; ?></th>
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

                                        <?php if ($k == 5): ?>

                                            <?php foreach ($vend as $key => $value): ?>
                                                <th class="text-center inp_poin_<?= $key ?>_<?= $k ?>" rowspan=1>
                                                    <span id="idrow_<?= $key ?>_<?= $k ?>"><?php echo $v->input[$key] ?></span>
                                                    <input type="hidden" onchange="count_teknis(<?= $key ?>, '<?= $k ?>')" class="form_header numz chk chg<?= $key ?>" name="teknis_head_vend_<?= $key ?>_<?= $k ?>" value="<?php echo $v->input[$key] ?>" id="teknis_head_vend_<?= $key ?>_<?= $k ?>" onkeyup="return only_number(event)">
                                                </th>
                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <?php foreach ($vend as $key => $value): ?>
                                                <th class="inp_poin_<?= $key ?>_<?= $k ?>" rowspan=1>
                                                    <input type="text" onchange="count_teknis(<?= $key ?>, '<?= $k ?>')" class="form_header numz chk chg<?= $key ?>" name="teknis_head_vend_<?= $key ?>_<?= $k ?>" value="<?php echo $v->input[$key] ?>" id="teknis_head_vend_<?= $key ?>_<?= $k ?>" onkeyup="return only_number(event)">
                                                </th>
                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    <tr>

                                <?php else: ?>
                                    <tr id="head_teknis_ts<?= $k ?>" class="sub_point_teknis_<?= $k ?>">
                                        <th></th>
                                        <th><input type="text" class="form_header" name="putusan_text_<?= $k ?>[]" value="<?php echo $a ?>"></th>
                                        <th><input type="text" class="form_header" name="putusan_bobot_<?= $k ?>[]" value="<?php echo $v->sub->sub_bobot[$e] ?>"> %</th>

                                        <?php foreach ($vend as $key => $value): ?>
                                            <?php if ($k == 5): ?>
                                                <th>
                                                    <input type="text" onchange="count_teknis2(<?= $key ?>, '006', <?= $span ?>, <?= count($tek_poin)-1?>)" class="form_header numz chk2 chg2<?= $key ?>" name="idScore[]" value="<?= $idScore[$key] ?>" id="teknis_head_vend2_<?= $key ?>_006" onkeyup="return only_number(event)">
                                                </th>
                                            <?php else: ?>
                                                <th></th>
                                            <?php endif; ?>
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
                        <td>Nilai Cost Plan (RAB)</td>
                        <td class="text-center">
                            <span id="nnhps"><?php echo "Rp " . number_format($nilai_hps, 2, ",", ".") ?></span>
                            <input type="hidden" name="nilai_hps" value="<?php echo $nilai_hps ?>">
                        </td>
                        <td>
                            <div class="btn btn-sm btn-primary" onclick="count_harga('<?= $span ?>')">Proses<div>
                        </td>
                        <td colspan="<?= $span -1 ?>"></td>
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
                        <th class="text-center">A</th>
                        <th>Aspek Harga</th>
                        <th></th>
                        <th colspan="<?= $span ?>"></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Harga Negosiasi Final (dalam Rupiah)</td>
                        <td></td>
                        <?php foreach ($harga_nego as $k => $v): ?>
                            <td class="text-center">
                                <span id="lbl_nego_final_vend<?=$k?>"><?php echo "Rp " . number_format($v, 2, ",", ".") ?></span>
                                <input type="hidden" class="form_header uang nego" onkeyup="return prevent_letter(event, 'uang')" onchange="count_harga('<?= $span ?>')" id="nego_final_vend<?=$k?>" name="nego_final_vend[]" value="<?php echo $v ?>" readonly>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Deviasi terhadap Nilai Cost Plan (RAB)</td>
                        <td></td>
                        <?php foreach ($deviasi as $k => $v): ?>
                            <td class="text-center">
                                <span id="deviasi_hps_vend<?=$k?>" class="stats_adm"><strong class="hrg" id="hps<?=$k?>"><?php echo "Rp " . number_format($v, 2, ",", ".") ?></strong></span>
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
        <!-- <table id="esigntbl" style="width: 100%" class="table table-striped m-0">
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
        </table> -->
        <input type="hidden" name="is_sap" value=1>
        <div id="required" class="card">
            <div class="card-content">
                <div class="card-body">
                    <?php if (isset($cid)): ?>
                        <?php echo buttonsubmit('contract/daftar_pekerjaan/edit/' . $cid,lang('back'),lang('save')) ?>
                    <?php else: ?>
                        <?php echo buttonsubmit('contract/manual_sap',lang('back'),lang('save')) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </form>

</div>

<script type="text/javascript">

    $(`#tipePlan`).on('change', function() {
        $('#komisi').removeAttr('disabled');


        if (!$(`#required`).hasClass('hidden')) {
            $(`#required`).addClass('hidden')
        }
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

                    if (data.length < 1) {
                        $('#myLoader').modal('toggle');
                        alert('Data tidak tersedia!')
                        return false;
                    }
					$(`#fun_bidang`).val(data[0].nm_fungsi_bidang)
					$(`#job_title`).val(data[0].job_title)
					$(`#kegid`).val(data[0].kegiatan_id)
					$(`#nipemploy`).val(data[0].nip)
					$(`#hpemploy`).val(data[0].handphone_1)
					$('#required').removeClass('hidden');
                    $('#ttdemp').removeClass('hidden');

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

    $('#add_penyedia').on('click', function() {
        var uniq = rand(3);
        var id_vend = 'vend_uniq_' + uniq;
        let html = '<tr id="'+id_vend+'"><td><select class="form-control select2" name="vendor" class="vend_val">'+list_vend+'</select></td><td><img class="ml-1" style="cursor: pointer;" width="20" height="20" src="<?php echo base_url('assets/img/remove.png') ?>" onclick="remove_ttd('+id_vend+')"/></td></tr>';
        $("#add_penyedia_tbl").append(html);
        selectRefresh()
    })

    function def_head_vend(vendor, vendd) {
        var cont = '';
        $.each(vendor, function(i, v) {
            cont += `
            <th style="word-break: break-all;" class="text-center">${vendor[i]}
                <input type="hidden" name="vendor_list[]" value="${vendd[i]}">
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
        var cont = `<td></td><td>Threshold</td><td><input type="text" class="form_header numz" onchange="count_after_change(${ve})" onkeyup="return only_number(event)" name="threshold_tek" value="70" required></td>`;

        $.each(vendor, function(i, v) {
            cont += `<td class="text-center"><span id="status_thresh_${i}" class="stats_adm">###</span><input type="hidden" id="val_status_thresh_${i}" name="status_tek_vendor[]" value="" /></td>`;
        })
        return cont;
    }

    function def_nego_final(vendor, nego) {
        let ve = vendor.length
        var cont = `
            <td></td>
            <td>Harga Negosiasi Final (dalam Rupiah) nnn</td>
            <td></td>
        `;

        $.each(nego, function(i, v) {
            vv = parseInt(v)
            cont += `<td><input type="number" class="form_header nego" id="nego_final_vend${i}" name="nego_final_vend[]" value="${vv}"></td>`;
        })
        return cont;
    }

    function def_deviasi_hps(vendor) {
        let ve = vendor.length
        var cont = `
            <td></td>
            <td>Deviasi terhadap Nilai Cost Plan (RAB)</td>
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

        <tr>
        `;

        if (r > 0) {
            $("#adm_st_" + r).after(html);
        } else {
            $("#row_adm_putusan").after(html);
        }

        $("#head_putusan_" + uniq).after('<tbody id="adm_st_'+rr+'" class="class_st_adm"></tbody>')
        add_sub_administrasi(rr, un, vendor, uniq)
    }

    function add_sub_administrasi(u, tot, vendor, uq) {
        var cont = ``;
        for (var i = 0; i < vendor; i++) {
            cont += `<td>
            <select class="form-control form_header select_adm_putusan_${i}" name="adm_pilihan_${i}[]" onchange="is_pass(${i})">
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
            <td><input type="text" class="form_header" name="sub_administrasi_poin_text[]" value=""></td>
            <td><input type="text" class="form_header" name="sub_administrasi_poin_bobot[]" value=""></td>
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

            $('.chg'+vend).val(0)
            $('.chg2'+vend).val(0)
            $('.chg'+vend).prop('readonly', true);
            $('.chg2'+vend).prop('readonly', true);

            $(`#teknis_point_${vend}_001`).html(0)
            $(`#has_poin${vend}_001`).val(0)
            $(`#teknis_point_${vend}_002`).html(0)
            $(`#has_poin${vend}_002`).val(0)
            $(`#teknis_point_${vend}_003`).html(0)
            $(`#has_poin${vend}_003`).val(0)
            $(`#teknis_point_${vend}_004`).html(0)
            $(`#has_poin${vend}_004`).val(0)
            $(`#teknis_point_${vend}_005`).html(0)
            $(`#has_poin${vend}_005`).val(0)
            $(`#teknis_point_${vend}_006`).html(0)
            $(`#has_poin${vend}_006`).val(0)

            $(`#status_thresh_${vend}`).html('Tidak Lulus')
            $(`#val_status_thresh_${vend}`).val('Tidak Lulus')

            $(`#teknis_nilai_vend${vend}`).html(0)
            $(`#ftek_nilai_${vend}`).val(0)

            $(`#teknis_bobot_vend${vend}`).html(0)
            $(`#ftek_bobot_${vend}`).val(0)

        } else {
            $('#val_status_' + vend).val('Lulus')
            $('#status_' + vend).html('<strong>Lulus</strong>')

            $('.chg'+vend).val('')
            $('.chg2'+vend).val('')
            $('.chg'+vend).prop('readonly', false);
            $('.chg2'+vend).prop('readonly', false);

            $(`#teknis_point_${vend}_001`).html('')
            $(`#has_poin${vend}_001`).val('')
            $(`#teknis_point_${vend}_002`).html('')
            $(`#has_poin${vend}_002`).val('')
            $(`#teknis_point_${vend}_003`).html('')
            $(`#has_poin${vend}_003`).val('')
            $(`#teknis_point_${vend}_004`).html('')
            $(`#has_poin${vend}_004`).val('')
            $(`#teknis_point_${vend}_005`).html('')
            $(`#has_poin${vend}_005`).val('')
            $(`#teknis_point_${vend}_006`).html('')
            $(`#has_poin${vend}_006`).val('')

            $(`#status_thresh_${vend}`).html('###')
            $(`#val_status_thresh_${vend}`).val('###')

            $(`#teknis_nilai_vend${vend}`).html('###')
            $(`#ftek_nilai_${vend}`).val('###')

            $(`#teknis_bobot_vend${vend}`).html('###')
            $(`#ftek_bobot_${vend}`).val('###')
        }
    }

    function add_teknis_point(vendor) {
        // close form harga
        $('.last').attr("readonly", true);
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
        $('.last').attr("readonly", true);
        $('.last').val(``);
        $('.hrg').html(`###`);
        $('.nbnb').val('')

        let teknis = $(`select[name=teknis_percent]`).val()
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

        let teknis = $(`select[name=teknis_percent]`).val()
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
        let nilai = $("select[name=teknis_percent]").val()
        c = `<strong>${100-nilai}%</strong> <input type="hidden" name="percent_harga" value="${100-nilai}" />`
        $('#harga_perc').html(c)

        count_after_change(vendor)
    }

    function count_after_change(vendor) {
        $('.last').val(``);
        $('.hrg').html(`###`);
        $('.nbnb').val('')

        let teknis = $(`select[name=teknis_percent]`).val()
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

    function count_teknis2(vend, row, veto, p) {
        let nn = []
        $('.chk2').each(function() {
            if ($(this).val() != ''){
                nn.push(parseInt($(this).val()))
            }
        })
        let max = Math.max.apply(Math, nn)

        let thval = $(`#teknis_head_vend2_${vend}_006`).val()
        let valm = (thval / max ) * 100
        $(`#teknis_head_vend_${vend}_${p}`).val(valm)

        for (var i = 0; i < veto; i++) {
            if (i != vend) {
                th = $(`#teknis_head_vend2_${i}_006`).val()
                vx = (th / max) * 100
                $(`#teknis_head_vend_${i}_${p}`).val(vx.toFixed(0))
            }
        }

        count_teknis(vend, p)

        for (var i = 0; i < veto; i++) {
            if (i != vend) {
                count_teknis(i, p)
            }
        }
    }

    function count_teknis(vend, row) {
        let teknis = $(`select[name=teknis_percent]`).val()
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
        let teknis = $(`select[name=teknis_percent]`).val()
        let hps = $(`input[name=nilai_hps]`).val()
        console.log(hps);
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

                let l = $("select[name=teknis_percent]").val()
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
                    for (var i = 0; i < nn.length; i++) {
                        let evalflo = parseFloat($(`#eval_hh${i}`).html());
                        let rank = ra.indexOf(evalflo) + 1;
                        $(`#peringkat_vend${i}`).html(`<strong id="peringkat_vend${i}">${rank}</strong>`)
                        $(`#rankrank_vend${i}`).val(rank)
                    }
                }
            } else {
                alert('Nilai Cost Plan (RAB) harus diisi!')
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

</script>
