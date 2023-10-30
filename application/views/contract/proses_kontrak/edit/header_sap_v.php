<style>
.text-bold-700 {
    font-weight: 700 !important;
}
.form-control {
    background-color: #29a7de;
}
.form-control-static {
    color: #29a7de;
}
</style>

<div class="row">
    <div class="col-12">

        <div class="d-flex justify-content-between mb-3">
            <div>
                <div class="row pt-2 pl-4">
                    <p class="text-bold-600 mr-2" style="font-size:15px;"><b><?php echo strtoupper($kontrak['subject_work'])?></b></p>
                    <span class="text-info text-bold-700"><i class="ft-cpu"></i> <?php echo $kontrak['ctr_jenis'] == "MANUAL" ? "Kontrak Manual"  : "Lelang Electronik"; ?></span>
                </div>
            </div>
            <div class="mr-3"></div>
        </div>

        <div class="row pl-3">
            <div class="col-12">
                <?php $curval = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>
                <input type="hidden" name="nilai_kontrak_inp" value="<?php echo $curval ?>">
                <div class="form-group mb-5">
                    <div class="col-sm-4">
                        <label class="control-label text-right text-bold-700">Nilai Kontrak</label>
                        <p class="text-bold-700 text-info" style="font-size:24px;"><b><?php echo $curval ?></b></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pl-3">
            <!-- left-side -->
            <div class="col">
                <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : "AUTO NUMBER"; ?>
                <?php $curval = $kontrak['ptm_number'];?>

                <input type="hidden" name="is_sap" value="<?php echo $is_sap ?>">
                <input type="hidden" name="nomor_tender" value="<?php echo $curval ?>">
                <input type="hidden" name="cid" value="<?php echo $kontrak['contract_id'] ?>">

                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Nomor Tender</label>
                    <div class="col-sm-8">
                        <p class="form-control-static"> :
                            <?php if($kontrak['ctr_jenis'] == "MANUAL") { ?>
                                <?php echo $curval ?>
                            <?php } else { ?>
                                <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$curval) ?>" target="_blank">
                                    <?php echo $curval ?>
                                </a>
                            <?php } ?>
                        </p>
                    </div>
                </div>

                <?php $curval = (isset($kontrak['contract_number'])) ? $kontrak['contract_number'] : "AUTO NUMBER"; ?>

                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Nomor Kontrak</label>
                    <div class="col-sm-8">
                        <p class="form-control-static"> :
                            <?php echo $curval ?>
                        </p>
                    </div>
                </div>

                <?php if ($kontrak['amandemen_number'] != NULL || $kontrak['amandemen_number'] != "") { ?>

                    <div class="form-group">
                        <label class="col-sm-4 control-label text-left text-bold-700">Kontrak Sebelumnya</label>
                        <div class="col-sm-8">
                            <p class="form-control-static"> :
                                <?php echo $kontrak['amandemen_number']; ?>
                            </p>
                        </div>
                    </div>

                <?php } ?>

                <?php

                $curval = (isset($tender['ptm_buyer'])) ? $tender['ptm_buyer'] : "";

                if($kontrak['ctr_jenis'] == "MANUAL") {
                    $curval = (isset($tenderManual['ptm_buyer'])) ? $tenderManual['ptm_buyer'] : $tender['ptm_buyer'];
                }

                ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Buyer</label>
                    <div class="col-sm-8">
                        <p class="form-control-static"> : <?php echo $curval ?></p>
                        <input type="hidden" class="form-control" name="request_name_inp" id="request_name_inp" value="<?php echo $userdata['complete_name'] ?>" readonly>
                        <input type="hidden" name="user_id_inp" id="user_id_inp" value="<?php echo $userdata['id'] ?>">
                        <input type="hidden" name="pos_id_inp" id="pos_id_inp" value="<?php echo $userdata['pos_id'] ?>">
                        <input type="hidden" name="pos_name_inp" id="pos_name_inp" value="<?php echo $userdata['pos_name'] ?>">
                        <input type="hidden" name="district_id_inp" id="district_id_inp" value="<?php echo $userdata['district_id'] ?>">
                        <input type="hidden" name="district_name_inp" id="district_name_inp" value="<?php echo $userdata['district_name'] ?>">
                    </div>
                </div>

                <?php

                $curval = (isset($tender['ptm_dept_name'])) ? $tender['ptm_dept_name'] : "";
                $curvalid = (isset($tender['ptm_dept_id'])) ? $tender['ptm_dept_id'] : "";

                if($kontrak['ctr_jenis'] == "MANUAL") {
                    $curval = (isset($tenderManual['ptm_dept_name'])) ? $tenderManual['ptm_dept_name'] : $tender['ptm_dept_name'];
                    $curvalid = (isset($tenderManual['ptm_dept_id'])) ? $tenderManual['ptm_dept_id'] : "";
                }

                ?>
                <input type="hidden" name="dept_id_inp" value="<?php echo $curvalid ?>">
                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Divisi</label>
                    <div class="col-sm-8">
                        <p class="form-control-static"> : <?php echo $curval ?></p>
                    </div>
                </div>

                <?php

                $curval = (isset($tender['ptm_project_name'])) ? $tender['ptm_project_name'] : "";

                if($kontrak['ctr_jenis'] == "MANUAL") {
                    $curval = (isset($tenderManual['ptm_project_name'])) ? $tenderManual['ptm_project_name'] : $tender['ptm_project_name'];
                }

                ?>
                <div class="form-group">
                    <input type="hidden" name="nama_pekerjaan_inp" value="<?php echo $curval ?>">
                    <label class="col-sm-4 control-label text-left text-bold-700">Proyek</label>
                    <div class="col-sm-8">
                        <p class="form-control-static"> : <?php echo $curval ?></p>
                    </div>
                </div>

                <?php if (isset($read)): ?>
                    <?php $curval = (isset($kontrak['ctr_item_type'])) ? $kontrak["ctr_item_type"] : set_value("item_kontrak_inp"); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-left text-bold-700">Jenis Kontrak</label>
                        <div class="col-sm-8">
                            <select class="form-control bg-select" required name="item_kontrak_inp" value="<?php echo $curval ?>">
                                <option value="" selected disabled>Pilih Jenis Kontrak</option>
                                <?php foreach ($contract_item as $key => $val) {
                                    $selected = ($val == $curval) ? "selected" : ""; ?>
                                    <option <?php echo $selected ?> value="<?php echo $val ?>"><?php echo $val ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php else: ?>
                    <?php $curval = (isset($kontrak['ctr_item_type'])) ? $kontrak["ctr_item_type"] : set_value("item_kontrak_inp"); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-left text-bold-700">Jenis Kontrak</label>
                        <div class="col-sm-8">
                            <select class="form-control bg-select" required name="item_kontrak_inp" value="<?php echo $curval ?>">
                                <option value="" selected disabled>Pilih Jenis Kontrak</option>
                                <?php foreach ($contract_item as $key => $val) {
                                    $selected = ($val == $curval) ? "selected" : "";
                                    if ($selected == "selected") {?>
                                        <option <?php echo $selected ?> value="<?php echo $val ?>"><?php echo $val ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ($is_sap == 1): ?>
                    <?php $curval = (isset($kontrak['ctr_doc_type'])) ? $kontrak["ctr_doc_type"] : $kontrak["ctr_doc_type"]; ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-bold-700 mt-2">Tipe PO</label>
                        <div class="col-sm-8">
                            <select class="form-control bg-select mt-2" required name="ctr_doc_type" value="<?php echo $curval ?>">
                                <option value="" selected disabled>Pilih Tipe PO</option>
                                <?php foreach ($doc_type as $k => $v): ?>
                                    <?php if ($curval == $v['code']): ?>
                                        <option value="<?php echo $v['code'] ?>" <?php echo $curval == $v['code'] ? 'selected' : '' ?>><?php echo $v['code'].' - '.$v['description'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($kontrak['ctr_jenis'] == 'MANUAL') { ?>
                    <?php $curval = (isset($kontrak['type_winner'])) ? $kontrak["type_winner"] : set_value("type_winner_inp"); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-left text-bold-700 mt-2">Pemenang </label>
                        <div class="col-sm-8">
                            <select class="form-control bg-select mt-2" required name="type_winner_inp" value="<?php echo $curval ?>">
                                <option value="">Pilih</option>
                                <option value="Single Winner" <?php echo $curval == 'Single Winner' ? 'selected' : ''; ?> >Single Winner</option>
                                <option value="Multiple Winner" <?php echo $curval == 'Multiple Winner' ? 'selected' : ''; ?> >Multiple Winner</option>
                            </select>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- right-side -->
            <div class="col pt-4 mt-3">

                <?php $curval = (isset($kontrak['vendor_name'])) ? $kontrak['vendor_name'] : ""; ?>
                <input type="hidden" name="vendid" value="<?php echo $kontrak['vendor_id'] ?>">
                <input type="hidden" name="vendname" value="<?php echo $kontrak['vendor_name'] ?>">
                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Vendor/Penyedia</label>
                    <div class="col-sm-8">
                        <p class="form-control-static"> : <?php echo $curval ?></p>
                    </div>
                </div>

                <?php $curval = (isset($kontrak['contract_type'])) ? $kontrak['contract_type'] : set_value("lokasi_kebutuhan_inp"); ?>
                <input type="hidden" name="tipe_kontrak_inp" value="<?php echo $curval ?>">
                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Tipe Kontrak</label>
                    <div class="col-sm-8">
                        <p> : <?php echo $curval ?></p>
                    </div>
                </div>

                <?php $curval = (isset($kontrak['currency']) && !empty($kontrak['currency'])) ? $kontrak['currency'] : $tender['ptm_currency']; ?>
                <input type="hidden" name="mata_uang_inp" value="<?php echo $curval ?>">
                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Mata Uang</label>
                    <div class="col-sm-8">
                        <p> : <?php echo $curval ?></p>
                    </div>
                </div>

                <?php $totalrab = (isset($subtotal_rab['subtotal_rab'])) ? inttomoney($subtotal_rab['subtotal_rab']) : 0; ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Nilai RAB</label>
                    <div class="col-sm-8">
                        <p> : <?php echo inttomoney($rab) ?></p>
                    </div>
                </div>

                <?php if ($is_sap == 1): ?>
                    <?php $curval = (isset($kontrak['ctr_down_payment']) && !empty($kontrak['ctr_down_payment'])) ? $kontrak['ctr_down_payment'] : ""; ?>
                    <input type="hidden" name="ctr_down_payment" value="<?php echo $curval ?>">
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-bold-700">Persen DP</label>
                        <div class="col-sm-8">
                            <p> : <?php echo (int)$curval ?> %</p>
                        </div>
                    </div>

                    <?php $curval = (isset($kontrak['ctr_down_payment_date']) && !empty($kontrak['ctr_down_payment_date'])) ? $kontrak['ctr_down_payment_date'] : ''; ?>
                    <input type="hidden" name="ctr_down_payment_date" value="<?php echo $curval ?>">
                    <div class="form-group mt-2">
                        <label class="col-sm-4 control-label text-bold-700">Tanggal Akhir DP</label>
                        <div class="col-sm-8">
                            <div class="date">
                                <p class="form-control-static"> : <?php echo ($curval != '') ? date("d/m/Y",strtotime($curval)) : ''; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700">Bidang Pekerjaan</label>
                    <div class="col-sm-8 ">
                        <select class="form-control bg-select" name="kategori_pekerjaan_inp">
                            <option value="" selected disabled>Pilih Bidang Pekerjaan</option>
                            <option value="Pekerjaan Sipil" <?php echo $kontrak['kategori_pekerjaan'] == 'Pekerjaan Sipil' ? 'selected' : ''; ?>>Pekerjaan Sipil</option>
                            <option value="Mekanikal" <?php echo $kontrak['kategori_pekerjaan'] == 'Mekanikal' ? 'selected' : ''; ?>>Mekanikal</option>
                            <option value="Elektrikal" <?php echo $kontrak['kategori_pekerjaan'] == 'Elektrikal' ? 'selected' : ''; ?>>Elektrikal</option>
                            <option value="Gedung" <?php echo $kontrak['kategori_pekerjaan'] == 'Gedung' ? 'selected' : ''; ?>>Gedung</option>
                            <option value="ATK" <?php echo $kontrak['kategori_pekerjaan'] == 'ATK' ? 'selected' : ''; ?>>ATK</option>
                            <option value="TI" <?php echo $kontrak['kategori_pekerjaan'] == 'TI' ? 'selected' : ''; ?>>TI</option>
                            <option value="HSE" <?php echo $kontrak['kategori_pekerjaan'] == 'HSE' ? 'selected' : ''; ?>>CQSMS</option>
                            <option value="Furnitur" <?php echo $kontrak['kategori_pekerjaan'] == 'Furnitur' ? 'selected' : ''; ?>>Furnitur</option>
                            <option value="Makanan dan Minuman" <?php echo $kontrak['kategori_pekerjaan'] == 'Makanan dan Minuman' ? 'selected' : ''; ?>>Makanan dan Minuman</option>
                            <option value="Logistik" <?php echo $kontrak['kategori_pekerjaan'] == 'Logistik' ? 'selected' : ''; ?>>Logistik</option>
                            <option value="Jasa Kesehatan" <?php echo $kontrak['kategori_pekerjaan'] == 'Jasa Kesehatan' ? 'selected' : ''; ?>>Jasa Kesehatan</option>
                            <option value="Jasa Keuangan" <?php echo $kontrak['kategori_pekerjaan'] == 'Jasa Keuangan' ? 'selected' : ''; ?>>Jasa Keuangan</option>
                            <option value="Konsultan Lainnya" <?php echo $kontrak['kategori_pekerjaan'] == 'Konsultan Lainnya' ? 'selected' : ''; ?>>Konsultan Lainnya</option>
                            <option value="Jasa Lainnya" <?php echo $kontrak['kategori_pekerjaan'] == 'Jasa Lainnya' ? 'selected' : ''; ?>>Jasa Lainnya</option>
                        </select>
                    </div>
                </div>

                <?php $curvalStart = (isset($kontrak['start_date'])) ?  $kontrak["start_date"] : set_value("tgl_mulai_inp"); ?>
                <?php $curvalEnd = (isset($kontrak['end_date'])) ?  $kontrak["end_date"] : set_value("tgl_akhir_inp"); ?>
                <input type="hidden" name="tgl_mulai_inp" value="<?php echo $curvalStart ?>">
                <input type="hidden" name="tgl_akhir_inp" value="<?php echo $curvalEnd ?>">
                <div class="form-group">
                    <label class="col-sm-4 control-label text-left text-bold-700 mt-2">Jangka Waktu Pelaksanaan</label>
                    <div class="col-sm-6 mt-2">
                        <p class="form-control-static"> : <?php echo date("d/m/Y",strtotime($curvalStart)) ?> - <?php echo date("d/m/Y",strtotime($curvalEnd)) ?></p>
                    </div>
                </div>
                <?php if ($is_sap == 1): ?>
                    <?php $curval = (isset($kontrak['ctr_po_number'])) ? $kontrak['ctr_po_number'] : ""; ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-left text-bold-700">PO Number</label>
                        <div class="col-sm-6">
                            <p class="form-control-static"> : <?= $curval ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php $curval = (isset($kontrak['end_date'])) ?  $kontrak["end_date"] : set_value("tgl_akhir_inp"); ?>
                <div class="form-group" style="display:none;">
                    <label class="col-sm-4 control-label text-left">Tanggal Berakhir Kontrak</label>
                    <div class="col-sm-6">
                        <p class="form-control-static"> : <?php echo date("d/m/Y",strtotime($curval)) ?></p>
                    </div>
                </div>

            </div>
        </div>
        <?php $curval = (isset($kontrak['subject_work'])) ? $kontrak['subject_work'] : set_value("subject_work_inp"); ?>
        <input type="hidden" name="subject_work_inp" value="<?php echo $curval ?>">
        <div class="form-group">
            <label class="col-sm-2 mt-2 ml-3 control-label text-left text-bold-700">Paket Pengadaan</label>
            <div class="col-sm-9 mt-2">
                <input class="form-control" style="background-color:#fff;color:#606060;" name="subject_work" value="<?php echo $curval ?>"/>
            </div>
        </div>

        <?php $curval = (isset($kontrak['scope_work'])) ? $kontrak['scope_work'] : set_value("scope_work_inp"); ?>
        <div class="form-group">
            <label class="col-sm-2 control-label text-left pt-2 ml-3 text-bold-700">Deskripsi</label>
            <div class="col-sm-9 pt-2">
                <textarea class="form-control richtext" required name="scope_work_inp" placeholder="Deskripsi pengadaan"><?php echo $curval ?></textarea>
            </div>
        </div>

        <?php $curval = (isset($kontrak['ctr_term_condition'])) ? $kontrak['ctr_term_condition'] : $kontrak['ctr_scope']; ?>
        <div class="form-group">
            <label class="col-sm-2 control-label text-left pt-2 ml-3 text-bold-700">Ruang Lingkup</label>
            <div class="col-sm-9 pt-2">
                <textarea class="form-control richtext" required name="ctr_scope"><?php echo $curval ?></textarea>
            </div>
        </div>


    </div>
</div>
<script src="https://cdn.tiny.cloud/1/fomjvw28r2o4v9niehzlxvd035csn6z2f91rtszw92yr5ppm/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '.richtext',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
});
</script>

<script>
function post_vnd_contract() {
    if (confirm('Apakah anda yakin ingin submit data ke Pengadaan.com ?')) {

        $('#loading_upload').modal("show");
        $.ajax({
            type: "POST",
            url: "<?= site_url() ?>/BumnKarya/post_vnd_contract",
            data: {contract_id : $("#contract_id").val()},
            dataType: "json",
            error: function (response) {
                $('#loading_upload').modal("hide");
            },
            success: function (response) {
                alert(response.message)
                if(response.code == 200)
                {
                    location.reload();
                }
                $('#loading_upload').modal("hide");
            }
        });
    }
}
</script>
