<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header border-bottom pb-2">
                <span class="card-title text-bold-600 mr-2"><?php echo strtoupper($kontrak['subject_work']) ?></span>
                <span class="text-info text-bold-700"><i class="ft-cpu"></i> <?php echo $kontrak['ctr_jenis'] == "MANUAL" ? "Kontrak Manual"  : "Lelang Electronik"; ?></span>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 pl-4">
                            <?php $curval = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>
                            <div class="form-group">
                                <label class="control-label text-right text-bold-700">Nilai Kontrak</label>
                                <p class="form-control-static text-bold-700 font-large-1 text-info" id="total_alokasi_header"><?php echo $curval ?></p>
                                <input type="hidden" name="total_alokasi_inp" value="<?php echo $curval ?>">
                            </div>
                        </div>

                        <input type="hidden" name="is_sap" value="<?php echo $is_sap ?>">

                        <!-- left-side -->
                        <div class="col-md row">

                            <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : "AUTO NUMBER"; ?>
                            <?php $curval = $kontrak['ptm_number']; ?>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Nomor Tender</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> :
                                        <?php if ($kontrak['ctr_jenis'] == "MANUAL") { ?>
                                            <?php echo $curval ?>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/' . $curval) ?>" target="_blank">
                                                <?php echo $curval ?>
                                            </a>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['contract_number'])) ? $kontrak['contract_number'] : "AUTO NUMBER"; ?>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Nomor Kontrak</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> :
                                        <?php echo $curval ?>
                                    </p>
                                </div>
                            </div>

                            <?php if ($kontrak['amandemen_number'] != NULL || $kontrak['amandemen_number'] != "") { ?>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Kontrak Sebelumnya</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"> :
                                            <?php echo $kontrak['amandemen_number']; ?>
                                        </p>
                                    </div>
                                </div>

                            <?php } ?>

                            <?php $curval = (isset($tender['ptm_buyer'])) ? $tender['ptm_buyer'] : ""; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Buyer</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> : <?php echo $curval ?></p>
                                </div>
                            </div>

                            <?php $curval = (isset($tender['ptm_dept_name'])) ? $tender['ptm_dept_name'] : ""; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Divisi</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> : <?php echo $curval ?></p>
                                </div>
                            </div>

                            <?php $curval = (isset($tender['ptm_project_name'])) ? $tender['ptm_project_name'] : ""; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Proyek</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> : <?php echo $curval ?></p>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['ctr_item_type'])) ? $kontrak["ctr_item_type"] : set_value("item_kontrak_inp"); ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Jenis Kontrak <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 styleSelect">
                                    <select class="form-control bg-select" required name="item_kontrak_inp" value="<?php echo $curval ?>">
                                        <option value="">Pilih Jenis Kontrak</option>
                                        <?php foreach ($contract_item as $key => $val) {
                                            $selected = ($val == $curval) ? "selected" : "";
                                            ?>
                                            <option <?php echo $selected ?> value="<?php echo $val ?>"><?php echo $val ?></option>
                                        <?php } ?>
                                    </select>
                                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                </div>
                            </div>

                            <?php if ($is_sap == 1): ?>
                                <?php $curval = (isset($kontrak['ctr_doc_type'])) ? $kontrak["ctr_doc_type"] : $kontrak["ctr_doc_type"]; ?>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Tipe PO <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 styleSelect">
                                        <select class="form-control bg-select" required name="ctr_doc_type" value="<?php echo $curval ?>">
                                            <option value="" selected disabled>Pilih Tipe PO</option>
                                            <?php foreach ($doc_type as $k => $v): ?>
                                                <option value="<?php echo $v['code'] ?>" <?php echo $curval == $v['code'] ? 'selected' : '' ?>><?php echo $v['code'].' - '.$v['description'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label mt-2 text-bold-700">Download Template</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static mt-2">
                                        <a href="<?php echo base_url('user_guide/SPK [surat perintah kerja].zip'); ?>" class="btn btn-info btn-sm">SPK</a>
                                        <a href="<?php echo base_url('user_guide/SPB[surat pemesanan barang] .zip'); ?>" class="btn btn-info btn-sm">SPB</a>
                                        <a href="<?php echo base_url('user_guide/PPJ [Perjanjian Pengadaan Jasa] .zip'); ?>" class="btn btn-info btn-sm">PPJ</a>
                                        <a href="<?php echo base_url('user_guide/PPB [Perjanjian Pengadaan Barang].zip'); ?>" class="btn btn-info btn-sm">PPB</a>
                                    </p>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['subject_work'])) ? $kontrak['subject_work'] : set_value("subject_work_inp"); ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Paket Pengadaan <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input class="form-control" required name="subject_work_inp" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['scope_work'])) ? $kontrak['scope_work'] : set_value("scope_work_inp"); ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label mt-2 text-bold-700">Deskripsi <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 mt-2">
                                    <textarea class="form-control" required name="scope_work_inp"><?php echo $curval ?></textarea>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['ctr_scope'])) ? $kontrak['ctr_scope'] : ""; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Ruang Lingkup <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 mt-2">
                                    <textarea class="form-control" name="ctr_scope"><?php echo $curval; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- right-side -->
                        <div class="col-md row">

                            <?php $curval = (isset($kontrak['vendor_name'])) ? $kontrak['vendor_name'] : ""; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Vendor/Penyedia</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> : <?php echo $curval ?></p>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['contract_type'])) ? $kontrak['contract_type'] : set_value("lokasi_kebutuhan_inp"); ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Tipe Kontrak</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> : <?php echo $curval ?></p>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['currency']) && !empty($kontrak['currency'])) ? $kontrak['currency'] : $tender['ptm_currency']; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Mata Uang</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"> : <?php echo $curval ?></p>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Nilai RAB</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static text-bold-700"> : <?php echo inttomoney($rab); ?></p>
                                </div>
                            </div>

                            <?php if ($is_sap == 1): ?>
                                <?php $curval = (isset($kontrak['ctr_down_payment']) && !empty($kontrak['ctr_down_payment'])) ? $kontrak['ctr_down_payment'] : ""; ?>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Persen DP</label>
                                    <div class="col-sm-8">
                                        <input type="number" max="100" name="ctr_down_payment" class="form-control" value="<?php echo $curval ?>">
                                    </div>
                                </div>

                                <?php $curval = (isset($kontrak['ctr_down_payment_date']) && !empty($kontrak['ctr_down_payment_date'])) ? $kontrak['ctr_down_payment_date'] : ''; ?>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Tanggal Akhir DP</label>
                                    <div class="col-sm-8">
                                        <div class="input-group date">
                                            <input type="date" name="ctr_down_payment_date" required onchange="valid_date_dp()" class="form-control" value="<?php echo $curval ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php $curval = (isset($kontrak['start_date']) && !empty($kontrak['start_date'])) ?  date("Y-m-d", strtotime($kontrak["start_date"])) : set_value("tgl_mulai_inp"); ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Tanggal Mulai Kontrak <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <input type="date" name="tgl_mulai_inp" required onchange="valid_date_aw()" class="form-control" value="<?php echo $curval ?>">
                                    </div>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['end_date']) && !empty($kontrak['end_date'])) ? date("Y-m-d", strtotime($kontrak["end_date"])) : set_value("tgl_akhir_inp"); ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Tanggal Berakhir Kontrak <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <input type="date" name="tgl_akhir_inp" required onchange="valid_date_ak()" class="form-control" value="<?php echo $curval ?>">
                                    </div>
                                </div>
                            </div>
                            <?php if ($activity_id == 2030) : ?>
                                <?php $curval = (isset($kontrak['sign_date']) && !empty($kontrak['sign_date'])) ? date("Y-m-d", strtotime($kontrak["sign_date"])) : set_value("tgl_sign_inp"); ?>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Tanggal Penandatanganan <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group date">
                                            <input type="date" name="tgl_sign_inp" required class="form-control" value="<?php echo $curval ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label mb-2">Bidang Pekerjaan</label>
                                <div class="col-sm-8 mb-2 styleSelect">
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
                                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                </div>
                            </div>

                            <?php $curval = (isset($kontrak['ctr_term_condition'])) ? $kontrak['ctr_term_condition'] : set_value("ctr_term_condition"); ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label mt-2 text-bold-700">Term and Condition <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" required name="ctr_term_condition"><?php echo $curval ?></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- <script src="//cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'ctr_scope' );
</script> -->
<script type="text/javascript">
function valid_date_dp() {
    let dp = $('[name="ctr_down_payment_date"]').val()
    let aw = $('[name="tgl_mulai_inp"]').val()
    let ak = $('[name="tgl_akhir_inp"]').val()

    if (dp != '') {
        if ((aw != '') || (ak != '')) {
            if ((dp < aw) || (dp > ak)) {
                alert('Tanggal DP tidak boleh lebih kecil dari tanggal awal dan akhir kontrak!')
                $('[name="ctr_down_payment_date"]').val('')
            }
        }
    }
}

function valid_date_aw() {
    let dp = $('[name="ctr_down_payment_date"]').val()
    let aw = $('[name="tgl_mulai_inp"]').val()
    let ak = $('[name="tgl_akhir_inp"]').val()

    if (aw != '') {
        if ((dp != '') || (ak != '')) {
            if ((dp > aw) || (aw > ak)) {
                alert('Tanggal awal kontrak tidak boleh lebih kecil dari tanggal dp dan tidak boleh lebih besar dari tanggal akhir kontrak!')
                $('[name="tgl_mulai_inp"]').val('')
            }
        }
    }
}

function valid_date_ak() {
    let dp = $('[name="ctr_down_payment_date"]').val()
    let aw = $('[name="tgl_mulai_inp"]').val()
    let ak = $('[name="tgl_akhir_inp"]').val()

    if (ak != '') {
        if ((aw != '') || (dp != '')) {
            if ((ak < aw) || (dp > ak)) {
                alert('Tanggal akhir kontrak tidak boleh lebih kecil dari tanggal awal kontrak dan tanggal dp!')
                $('[name="tgl_akhir_inp"]').val('')
            }
        }
    }
}

$(document).ready(function() {
    if ($('[name="tgl_mulai_inp"]').val() != '') {
        $('[name="tgl_akhir_inp"]').attr('min', $(this).val());
    }

    $('[name="tgl_mulai_inp"]').change(function(event) {
        if ($(this).val() != '') {
            $('[name="tgl_akhir_inp"]').attr('min', $(this).val());
        }
    });

    $('[name="tgl_akhir_inp"]').rules('add', {
        messages: {
            min: "Tidak boleh kurang dari Tanggal Mulai Kontrak"
        }
    });

    <?php if ($activity_id == 2030) : ?>
    if ($('[name="tgl_akhir_inp"]').val() != '') {
        $('[name="tgl_sign_inp"]').attr('max', $(this).val());
    }

    $('[name="tgl_akhir_inp"]').change(function(event) {
        if ($(this).val() != '') {
            $('[name="tgl_sign_inp"]').attr('max', $(this).val());
        }
    });

    $('[name="tgl_sign_inp"]').rules('add', {
        messages: {
            max: "Tidak boleh lebih dari Tanggal Akhir Kontrak"
        }
    });
    <?php endif ?>

});

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
</script>
