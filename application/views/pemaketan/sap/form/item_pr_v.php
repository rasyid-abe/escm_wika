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
                    <span class="card-title text-bold-600 mr-2">Item Sumber Daya</span>
                </div>
                <div class="btn-group-sm float-right position-relative" id="showButtonItem" style="display: none;">
                    <a class="btn btn-info btn-sm action_item btn-plus">Simpan</a>
                    <a class="btn btn-sm empty_item btn-trash" title="Hapus"><i class="ft-trash"></i></a>
                    <input type="hidden" id="current_item" name="current_item" value="" />
                </div>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div id="showAddItem" style="display: none;">
                        <div class="col-md-6 row">
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Kode <span class="text-danger text-bold-700">*</span></strong></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <?php $curval = set_value("kode_item"); ?>
                                        <input readonly type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">                                        
                                    </div>
                                </div>
                            </div>

                            <?php $curval = set_value("deskripsi_item"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Deskripsi</strong></label>
                                <div class="col-sm-8">
                                    <p class="form-control-static" maxlength="1000" id="deskripsi_item"><?php echo $curval ?></p>
                                </div>
                            </div>

                            <?php $curval = set_value("jumlah_item_inp"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Volume <span class="text-danger text-bold-700">*</span></strong></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control money" maxlength="40" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
                                    <small id="max_volume"></small>
                                </div>
                            </div>

                            <?php $curval = set_value("satuan_item_inp"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Satuan</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control" maxlength="12" name="satuan_item_inp" id="satuan_item_inp" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("harga_satuan_item_inp"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Harga Satuan</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control money" maxlength="40" name="harga_satuan_item_inp" id="harga_satuan_item_inp" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppis_pr_number"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>PR Number</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control" maxlength="12" name="ppis_pr_number" id="ppis_pr_number" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppis_pr_item"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>PR Item</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control" maxlength="12" name="ppis_pr_item" id="ppis_pr_item" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppis_pr_type"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>PR Type</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control" maxlength="12" name="ppis_pr_type" id="ppis_pr_type" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppis_delivery_date"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Delivery Date</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control" maxlength="12" name="ppis_delivery_date" id="ppis_delivery_date" value="<?php echo $curval ?>">
                                </div>
                            </div>
                            
                            <?php $curval = set_value("ppis_cat_tech"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Cat Tech</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control" maxlength="12" name="ppis_cat_tech" id="ppis_cat_tech" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppis_acc_assig"); ?>
                            <div class="col-md-12 form-group mb-1">
                                <label class="col-sm-4 control-label"><strong>Acc Assig</strong></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="true" class="form-control" maxlength="12" name="ppis_acc_assig" id="ppis_acc_assig" value="<?php echo $curval ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 row">

                            <?php $curval = set_value("pr_retention"); ?>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label"><strong>Retention</strong></label>
                                <div class="col-sm-8">
                                    <input type="number" max="100" class="form-control" name="pr_retention" id="pr_retention" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppi_dev_date"); ?>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label"><strong>Delivery Date</strong>  <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" name="ppi_dev_date" id="ppi_dev_date" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppi_po_date"); ?>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label"><strong>Rencana Tgl PO</strong>  <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" name="ppi_po_date" id="ppi_po_date" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = set_value("ppi_tender_date"); ?>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label"><strong>Tgl Tender</strong>  <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" name="ppi_tender_date" id="ppi_tender_date" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php if ($pr_main['pr_type_pengadaan'] == 'asset') {?>
                                <?php $curval = set_value("no_asset"); ?>
                                <div class="row form-group col-md-12 mb-1 is_ass">
                                    <label class="col-sm-4 control-label"><strong>No Asset</strong></label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="no_asset" id="no_asset" value="<?php echo $curval ?>">
                                    </div>
                                </div>

                                <?php $curval = set_value("sub_number"); ?>
                                <div class="row form-group col-md-12 mb-1 is_ass">
                                    <label class="col-sm-4 control-label"><strong>Sub Number</strong></label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="sub_number" id="sub_number" value="<?php echo $curval ?>">
                                    </div>
                                </div>
                            <?php } ?>

                            <?php $curval = set_value("tax_code"); ?>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Tax Code <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control bg-select" id="tax_code" name="tax_code">
                                        <option value="" selected disabled>Pilih Tax Code</option>
                                        <?php foreach ($tax_code as $k => $v): ?>
                                            <option value="<?php echo $v['tax_code'] ?>" <?php echo $curval == $v['tax_code'] ? 'selected' : '' ?>><?php echo $v['tax_code'].' - '.$v['description'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Incoterm <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control bg-select" name="incoterm_inp" id="incoterm_inp">
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
                                </div>
                            </div>
                            
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Lokasi Incoterm <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="lokasi_incoterm" id="lokasi_incoterm" value="">
                                </div>
                            </div>                                                

                            <div class="row form-group col-md-12 mb-1">
                                <?php $curval = set_value("tipe_item"); ?>
                                <label class="col-sm-4 control-label">Sumber HPS <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control bg-select" name="sumber_hps" id="sumber_hps">
                                        <?php foreach ($sumber_hps as $k => $v) { ?>
                                            <option value="<?php echo $v['value'] ?>"><?php echo $v['option'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group col-md-12 mb-1">
                                <?php $curval = set_value("hps"); ?>
                                <label class="col-sm-4 control-label">HPS <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control money" maxlength="40" name="hps" id="hps" value="<?php echo $curval ?>">                                    
                                </div>
                                <small id="error_jml"></small>
                            </div>

                            <div class="row form-group col-md-12">
                                <?php $curval = (isset($v['ppd_file_name'])) ? $v['ppd_file_name'] :  set_value("doc_attachment_inp[]"); ?>
                                <label class="col-sm-4 control-label"><?php echo lang('attachment') ?></label>
                                <div class="col-sm-8">
                                    <div class="input-group align-items-center">
                                        <span class="input-group-btn">
                                            <button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo "procurement/tender/" ?>" data-preview="preview_file_" class="btn btn-sm btn-info upload btn-bordered">
                                                <i class="fa fa-cloud-upload"></i> Up
                                            </button>
                                            <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/tender/' . $curval) ?>" class="btn btn-sm btn-info preview_upload mr-1 btn-bordered" id="preview_file_">
                                                <i class="fa fa-share"></i> View
                                            </button>
                                        </span>
                                        <input readonly type="text" class="form-control" id="doc_attachment_inp_" name="lampiran_item" value="<?php echo $curval ?>">
                                        <span class="input-group-btn">
                                            <button type="button" data-id="doc_attachment_inp_" data-folder="<?php echo "procurement/tender/" ?>" data-preview="preview_file_" class="btn btn-sm btn-danger removefile ml-1 btn-bordered">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="col-sm-0" style="font-size: 11px">
                                        <i>Max file 5 MB
                                            <br>
                                            Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                                        </i>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="ppi_dev_date" id="ppi_dev_date" value="">
                            <input type="hidden" name="ppi_pdt" id="ppi_pdt" value="">
                            <input type="hidden" name="ppi_type_po" id="ppi_type_po" value="">
                            <input type="hidden" name="ppi_status_update" id="ppi_status_update" value="">
                            <input type="hidden" name="ppi_temp_vol" id="ppi_temp_vol" value="">
                            <input type="hidden" name="ppi_pr_order" id="ppi_pr_order" value="">
                            <input type="hidden" name="ppi_update_at" id="ppi_update_at" value="">
                            <input type="hidden" name="ppi_retention" id="ppi_retention" value="">
                            <input type="hidden" name="quantity" id="quantity" value="">
                            <input type="hidden" name="sisa_kom" id="sisa_kom" value="">
                            <input type="hidden" name="item_remain" id="item_remain" value="">
                            <input type="hidden" name="efisiensi_po" id="efisiensi_po" value="">
                            <input type="hidden" name="total_po" id="total_po" value="">
                            <input type="hidden" name="realisasi_qty_item" id="realisasi_qty_item" value="">
                            <input type="hidden" name="realisasi_po" id="realisasi_po" value="">
                            <input type="hidden" name="pr_created_date" id="pr_created_date" value="">
                            <input type="hidden" name="pr_ekgrp" id="pr_ekgrp" value="">
                            <input type="hidden" name="pr_spk_code" id="pr_spk_code" value="">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" id="item_table">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Nomor PR</th>
                                    <th rowspan="2">A</th>
                                    <th rowspan="2">Line</th>
                                    <th rowspan="2">Kode SDA</th>
                                    <th rowspan="2">Deskripsi</th>
                                    <th rowspan="2">PG</th>
                                    <th rowspan="2">UOM</th>
                                    <th rowspan="2">Qty</th>
                                    <th rowspan="2">Harga Satuan (RAB)</th>
                                    <th rowspan="2">Subtotal (RAB)</th>
                                    <th rowspan="2">Req Date</th>
                                    <th rowspan="2">Dev Date</th>
                                    <th rowspan="2">Delivery Date</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">Rencana Tgl PO</th>
                                    <th rowspan="2">Tgl Tender</th>
                                    <th colspan="3">Realisasi PO</th>
                                    <th rowspan="2">Efisiensi</th>
                                    <th colspan="2">Sisa Komitmen</th>
                                    <th rowspan="2">Qty GR/SES</th>
                                    <th rowspan="2">PDT</th>
                                    <th rowspan="2">Tax Code</th>
                                    <th rowspan="2">Type PO</th>
                                    <th rowspan="2">PR Type</th>
                                    <th rowspan="2">Cat Tech</th>
                                    <th rowspan="2">Incoterm</th>
                                    <th rowspan="2">Lokasi Incoterm</th>
                                    <th rowspan="2">Retention</th>
                                    <th rowspan="2">Sumber HPS</th>
                                    <th rowspan="2">HPS</th>
                                    <th rowspan="2">Subtotal HPS</th>

                                    <?php if ($pr_main['pr_type_pengadaan'] == 'asset') {?>
                                        <th rowspan="2" class="is_ass">No Asset</th>
                                        <th rowspan="2" class="is_ass">Sub Number</th>
                                    <?php } ?>

                                    <th rowspan="2">Lampiran</th>
                                    <th rowspan="2">Update Date</th>
                                    <th rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                    <th>Jumlah PO</th>
                                    <th>Qty</th>
                                    <th>Nilai PO</th>
                                    <th>Qty</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $subtotal = 0;
                                $subtotalhps = 0;
                                $no = 1;
                                // echo "<pre>";
                                if (isset($pr_item) && !empty($pr_item)) {
                                    foreach ($pr_item as $key => $value) {
                                        $idnya = $key + 1;
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $no++; ?>                                                                                                                                                                                                
                                                <input type="hidden" value="<?php echo $value['ppi_temp_vol'] ?>" name="ppi_temp_vol[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_temp_vol">
                                                <input type="hidden" value="<?php echo $value['ppi_pr_order'] ?>" name="ppi_pr_order[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_pr_order">                                                
                                                <input type="hidden" value="<?php echo $value['pr_spk_code'] ?>" name="pr_spk_code[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pr_spk_code">
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_pr_number'] ?>" name="ppis_pr_number[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppis_pr_number">
                                                <?php echo $value['ppis_pr_number'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_acc_assig'] ?>" name="ppis_acc_assig[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppis_acc_assig">
                                                <?php echo $value['ppis_acc_assig'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_pr_item'] ?>" name="ppis_pr_item[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppis_pr_item">
                                                <?php echo $value['ppis_pr_item'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_code'] ?>" name="item_kode[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="kode_item">
                                                <?php echo $value['ppi_code'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_description'] ?>" name="item_deskripsi[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="deskripsi_item">
                                                <?php echo $value['ppi_description'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['pr_ekgrp'] ?>" name="pr_ekgrp[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pr_ekgrp">
                                                <?php echo $value['pr_ekgrp'] ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_unit'] ?>" name="item_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="satuan_item">
                                                <?php echo $value['ppi_unit'] ?>
                                            </td>
                                            <td class="text-right">
                                                <input type="hidden" value="<?php echo $value['ppi_quantity'] ?>" name="item_jumlah[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_item">
                                                <?php echo inttomoney($value['ppi_quantity']) ?>
                                            </td>
                                            <td class="text-right">
                                                <input type="hidden" value="<?php echo $value['ppi_price'] ?>" name="item_harga_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="harga_satuan_item">
                                                <?php echo inttomoney($value['ppi_price']) ?>
                                            </td>
                                            <td class="text-right">
                                                <input type="hidden" value="<?php echo $value['ppi_price'] * $value['ppi_quantity'] ?>" name="item_subtotal[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="subtotal_item">
                                                <?php echo inttomoney($value['ppi_price'] * $value['ppi_quantity']) ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['pr_created_date'] ?>" name="pr_created_date[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pr_created_date">
                                                <?php echo $value['pr_created_date'] != '' ? $value['pr_created_date'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_delivery_date'] ?>" name="ppis_delivery_date[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppis_delivery_date">
                                                <?php echo $value['ppis_delivery_date'] != '' ? $value['ppis_delivery_date'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_dev_date'] ?>" name="ppi_dev_date[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_dev_date">
                                                <?php echo $value['ppi_dev_date'] != '' ? $value['ppi_dev_date'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_status_update'] ?>" name="ppi_status_update[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_status_update">
                                                <?php echo $value['ppi_status_update'] != '' ? $value['ppi_status_update'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_po_date'] ?>" name="ppi_po_date[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_po_date">
                                                <?php echo $value['ppi_po_date'] != '' ? $value['ppi_po_date'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_tender_date'] ?>" name="ppi_tender_date[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_tender_date">
                                                <?php echo $value['ppi_tender_date'] != '' ? $value['ppi_tender_date'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['realisasi_po'] ?>" name="realisasi_po[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="realisasi_po">
                                                <?php echo $value['realisasi_po'] != '' ? $value['realisasi_po'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['realisasi_qty_item'] ?>" name="realisasi_qty_item[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="realisasi_qty_item">
                                                <?php echo $value['realisasi_qty_item'] != '' ? $value['realisasi_qty_item'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['total_po'] ?>" name="total_po[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="total_po">
                                                <?php echo $value['total_po'] != '' ? $value['total_po'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['efisiensi_po'] ?>" name="total_po[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="efisiensi_po">
                                                <?php echo $value['efisiensi_po'] != '' ? $value['efisiensi_po'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['item_remain'] ?>" name="item_remain[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="item_remain">
                                                <?php echo $value['item_remain'] != '' ? inttomoney($value['item_remain']) : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['sisa_kom'] ?>" name="sisa_kom[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="sisa_kom">
                                                <?php echo $value['sisa_kom'] != '' ? $value['sisa_kom'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['quantity'] ?>" name="quantity[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="quantity">
                                                <?php echo $value['quantity'] != '' ? $value['quantity'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_pdt'] ?>" name="ppi_pdt[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_pdt">
                                                <?php echo $value['ppi_pdt'] != '' ? $value['ppi_pdt'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_tax_code'] ?>" name="tax_code[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="tax_code">
                                                <?php echo $value['ppi_tax_code'] != '' ? $value['ppi_tax_code'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_type_po'] ?>" name="ppi_type_po[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_type_po">
                                                <?php echo $value['ppi_type_po'] != '' ? $value['ppi_type_po'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_pr_type'] ?>" name="ppis_pr_type[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppis_pr_type">
                                                <?php echo $value['ppis_pr_type'] != '' ? $value['ppis_pr_type'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppis_cat_tech'] ?>" name="ppis_cat_tech[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppis_cat_tech">
                                                <?php echo $value['ppis_cat_tech'] != '' ? $value['ppis_cat_tech'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_incoterm'] ?>" name="incoterm[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="incoterm">
                                                <?php echo $value['ppi_incoterm'] != '' ? $value['ppi_incoterm'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_lokasi_incoterm'] ?>" name="lokasi_incoterm[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="lokasi_incoterm">
                                                <?php echo $value['ppi_lokasi_incoterm'] != '' ? $value['ppi_lokasi_incoterm'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_retention'] ?>" name="pr_retention[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pr_retention">
                                                <?php echo $value['ppi_retention'] != '' ? $value['ppi_retention'] . ' %' : '-';  ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_sumber_hps'] ?>" name="sumber_hps[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="sumber_hps">
                                                <?php echo $value['ppi_sumber_hps'] != '' ? $value['ppi_sumber_hps'] : '-'; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_hps'] ?>" name="hps[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="hps">
                                                <?php echo $value['ppi_hps'] != '' ? inttomoney($value['ppi_hps']) : '-'; ?>
                                            </td>
                                            <td id="subtotal_hps">
                                                <?php echo inttomoney($value['ppi_hps'] * $value['ppi_quantity']) ?>
                                            </td>

                                            <?php if ($pr_main['pr_type_pengadaan'] == 'asset') {?>

                                                <td class="is_ass">
                                                    <input type="hidden" value="<?php echo $value['ppi_no_asset'] ?>" name="no_asset[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="no_asset">
                                                    <?php echo $value['ppi_no_asset'] ?>
                                                </td>
                                                <td class="is_ass"> 
                                                    <input type="hidden" value="<?php echo $value['ppi_sub_number'] ?>" name="sub_number[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="sub_number">
                                                    <?php echo $value['ppi_sub_number'] ?>
                                                </td>

                                            <?php } ?>

                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_lampiran'] ?>" name="doc_attachment_inp_[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="doc_attachment_inp_">
                                                <?php if($value['ppi_lampiran'] != '') { ?>
                                                    <a href='<?php echo site_url("log/download_attachment/procurement/tender/".$value['ppi_lampiran']) ?>' target="_blank"><?php echo $value['ppi_lampiran'] ?></a>
                                                <?php } else { ?>
                                                    -
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo $value['ppi_update_at'] ?>" name="ppi_update_at[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppi_update_at">
                                                <?php echo $value['ppi_update_at'] ?>
                                            </td>
                                            <td>
                                                <button data-no="<?php echo $idnya ?>" class="btn btn-info btn-sm edit_item" onclick="isShowAddItem()" type="button">
                                                    <i class="fa fa-edit"></i>
                                                    <?php $curval = (isset($value['ppi_id'])) ? $value['ppi_id'] :  ""; ?>
                                                    <input type="hidden" name="item_id[<?php echo $idnya ?>]" value="<?php echo $curval ?>" />
                                                </button>
                                            </td>
                                        </tr>

                                        <?php
                                        $subtotal += $value['ppi_price'] * $value['ppi_quantity'];
                                        $subtotalhps += $value['ppi_hps'] * $value['ppi_quantity'];
                                    }
                                } ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="row form-group mt-3">
                        <div class="col-sm-5">
                        </div>
                        <label class="col-sm-5 control-label text-right">Total RAB</label>
                        <div class="col-sm-2">
                            <p class="form-control-static text-right" id="total_alokasi"> <?php echo inttomoney($subtotal) ?></p>
                            <input type="hidden" name="total_alokasi_inp" id="total_alokasi_inp" value="<?php echo $subtotal ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-5">
                        </div>
                        <label class="col-sm-5 control-label text-right">Total HPS</label>
                        <div class="col-sm-2">
                            <p class="form-control-static text-right" id="total_hps"><?php echo inttomoney($subtotalhps) ?></p>
                            <input type="hidden" name="total_hps_inp" id="total_hps_inp">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
              
        var url = "<?php echo site_url('Procurement/get_item_perencanaan_sap') ?>";

        $('.int_item').css('display', 'none');

        $(".action_item").click(function() {

            var url_file = '<?php echo site_url("log/download_attachment/procurement/tender/") ?>';
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
            var incoterm = $('#incoterm_inp').val();
            var lokasi_incoterm = $('#lokasi_incoterm').val();
            var sumber_hps = $('#sumber_hps').val();
            var hps = $('#hps').val();
            var hps_int = $('#hps').autoNumeric('get');
            var doc_attachment_inp_ = $('#doc_attachment_inp_').val();
            var no_asset = $('#no_asset').val();
            var sub_number = $('#sub_number').val();
            var tax_code = $('#tax_code').val();
            var ppi_dev_date = $('#ppi_dev_date').val();
            var ppi_pdt = $('#ppi_pdt').val();
            var ppi_type_po = $('#ppi_type_po').val();
            var ppi_po_date = $('#ppi_po_date').val();
            var ppi_tender_date = $('#ppi_tender_date').val();
            var ppi_status_update = $('#ppi_status_update').val();
            var ppi_temp_vol = $('#ppi_temp_vol').val();
            var ppi_pr_order = $('#ppi_pr_order').val();
            var ppi_update_at = $('#ppi_update_at').val();
            var pr_retention = $('#pr_retention').val();
            var ppis_pr_number = $("#ppis_pr_number").val();
            var ppis_pr_item = $("#ppis_pr_item").val();
            var ppis_pr_type = $("#ppis_pr_type").val();
            var ppis_delivery_date = $("#ppis_delivery_date").val();
            var ppis_cat_tech = $("#ppis_cat_tech").val();
            var ppis_acc_assig = $("#ppis_acc_assig").val();
            var quantity = $("#quantity").val();
            var sisa_kom = $("#sisa_kom").val();
            var item_remain = $("#item_remain").val();
            var efisiensi_po = $("#efisiensi_po").val();
            var total_po = $("#total_po").val();
            var realisasi_qty_item = $("#realisasi_qty_item").val();
            var realisasi_po = $("#realisasi_po").val();
            var pr_created_date = $("#pr_created_date").val();
            var pr_ekgrp = $("#pr_ekgrp").val();

            if (kode === '' || jumlah === '' || harga_satuan === '' || sumber_hps === '' || hps === '' || tax_code === '' || ppi_dev_date === '' || ppi_po_date === '' || ppi_tender_date === '') {
                alert("Semua input mandarory (*) wajib diisi.");
                return false;
            }

            if (harga_satuan_int < 1) {

                alert("Harga tidak boleh kurang dari 1");
                return false;

            } else if (jumlah_int < 1) {

                alert("Jumlah tidak boleh kurang dari 1");
                return false;

            } else {
                let tppo = $('#tipe_pengadaan').val()
                var subtotal_hps = parseFloat(hps_int) * parseFloat(jumlah_int);
                var subtotal_hps_int = subtotal_hps;
                subtotal_hps = inttomoney(subtotal_hps);

                var x = parseFloat(jumlah_int) * parseFloat(harga_satuan_int);
                var subtotal = inttomoney(x);
                harga_satuan = inttomoney(harga_satuan_int);

                var html = "<tr>";
                html += "<td class='text-center'>" + no + "</td>";
                html += "<td><input type='hidden' class='ppis_pr_number' data-no='" + no + "' name='ppis_pr_number[" + no + "]' value='" + ppis_pr_number + "'/>" + ppis_pr_number + "</td>";
                html += "<td><input type='hidden' class='ppis_acc_assig' data-no='" + no + "' name='ppis_acc_assig[" + no + "]' value='" + ppis_acc_assig + "'/>" + ppis_acc_assig + "</td>";
                html += "<td><input type='hidden' class='ppis_pr_item' data-no='" + no + "' name='ppis_pr_item[" + no + "]' value='" + ppis_pr_item + "'/>" + ppis_pr_item + "</td>";
                html += "<td><input type='hidden' class='kode_item' data-no='" + no + "' name='item_kode[" + no + "]' value='" + kode + "'/>" + kode + "</td>";
                html += "<td><input type='hidden' class='deskripsi_item' data-no='" + no + "' name='item_deskripsi[" + no + "]' value='" + deskripsi + "'/>" + deskripsi + "</td>";
                html += "<td><input type='hidden' class='pr_ekgrp' data-no='" + no + "' name='pr_ekgrp[" + no + "]' value='" + pr_ekgrp + "'/>" + pr_ekgrp + "</td>";
                html += "<td><input type='hidden' class='satuan_item' data-no='" + no + "' name='item_satuan[" + no + "]' value='" + satuan + "'/>" + satuan + "</td>";
                html += "<td class='text-right'><input type='hidden' class='max_item' data-no='" + no + "' name='max_item[" + no + "]' value='" + max_notif + "'/> <input type='hidden' class='jumlah_item' data-no='" + no + "' name='item_jumlah[" + no + "]' value='" + jumlah_int + "'/>" + jumlah + "</td>";
                html += "<td class='text-right'><input type='hidden' class='harga_satuan_item' data-no='" + no + "' name='item_harga_satuan[" + no + "]' value='" + harga_satuan_int + "'/>" + harga_satuan + "</td>";
                html += "<td class='text-right'><input type='hidden' class='subtotal_item' data-no='" + no + "' name='item_subtotal[" + no + "]' value='" + x + "'/>" + subtotal + "</td>"
                html += "<td><input type='hidden' class='pr_created_date' data-no='" + no + "' name='pr_created_date[" + no + "]' value='" + pr_created_date + "'/>" + pr_created_date + "</td>";
                html += "<td><input type='hidden' class='ppis_delivery_date' data-no='" + no + "' name='ppis_delivery_date[" + no + "]' value='" + ppis_delivery_date + "'/>" + ppis_delivery_date + "</td>";
                html += "<td><input type='hidden' class='ppi_dev_date' data-no='" + no + "' name='ppi_dev_date[" + no + "]' value='" + ppi_dev_date + "'/>" + ppi_dev_date + "</td>";
                html += "<td><input type='hidden' class='ppi_status_update' data-no='" + no + "' name='ppi_status_update[" + no + "]' value='" + ppi_status_update + "'/>" + ppi_status_update + "</td>";
                html += "<td><input type='hidden' class='ppi_po_date' data-no='" + no + "' name='ppi_po_date[" + no + "]' value='" + ppi_po_date + "'/>" + ppi_po_date + "</td>";
                html += "<td><input type='hidden' class='ppi_tender_date' data-no='" + no + "' name='ppi_tender_date[" + no + "]' value='" + ppi_tender_date + "'/>" + ppi_tender_date + "</td>";
                html += "<td><input type='hidden' class='realisasi_po' data-no='" + no + "' name='realisasi_po[" + no + "]' value='" + realisasi_po + "'/>" + realisasi_po + "</td>";
                html += "<td><input type='hidden' class='realisasi_qty_item' data-no='" + no + "' name='realisasi_qty_item[" + no + "]' value='" + realisasi_qty_item + "'/>" + realisasi_qty_item + "</td>";
                html += "<td><input type='hidden' class='total_po' data-no='" + no + "' name='total_po[" + no + "]' value='" + total_po + "'/>" + total_po + "</td>";
                html += "<td><input type='hidden' class='efisiensi_po' data-no='" + no + "' name='efisiensi_po[" + no + "]' value='" + efisiensi_po + "'/>" + efisiensi_po + "</td>";
                html += "<td><input type='hidden' class='item_remain' data-no='" + no + "' name='item_remain[" + no + "]' value='" + item_remain + "'/>" + item_remain + "</td>";
                html += "<td><input type='hidden' class='sisa_kom' data-no='" + no + "' name='sisa_kom[" + no + "]' value='" + sisa_kom + "'/>" + sisa_kom + "</td>";
                html += "<td><input type='hidden' class='quantity' data-no='" + no + "' name='quantity[" + no + "]' value='" + quantity + "'/>" + quantity + "</td>";
                html += "<td><input type='hidden' class='ppi_pdt' data-no='" + no + "' name='ppi_pdt[" + no + "]' value='" + ppi_pdt + "'/>" + ppi_pdt + "</td>";
                html += "<td><input type='hidden' class='tax_code' data-no='" + no + "' name='tax_code[" + no + "]' value='" + tax_code + "'/>" + tax_code + "</td>";
                html += "<td><input type='hidden' class='ppi_type_po' data-no='" + no + "' name='ppi_type_po[" + no + "]' value='" + ppi_type_po + "'/>" + ppi_type_po + "</td>";
                html += "<td><input type='hidden' class='ppis_pr_type' data-no='" + no + "' name='ppis_pr_type[" + no + "]' value='" + ppis_pr_type + "'/>" + ppis_pr_type + "</td>";
                html += "<td><input type='hidden' class='ppis_cat_tech' data-no='" + no + "' name='ppis_cat_tech[" + no + "]' value='" + ppis_cat_tech + "'/>" + ppis_cat_tech + "</td>";
                html += "<td><input type='hidden' class='incoterm' data-no='" + no + "' name='incoterm[" + no + "]' value='" + incoterm + "'/>" + incoterm + "</td>";
                html += "<td><input type='hidden' class='lokasi_incoterm' data-no='" + no + "' name='lokasi_incoterm[" + no + "]' value='" + lokasi_incoterm + "'/>" + lokasi_incoterm + "</td>";
                html += "<td><input type='hidden' class='pr_retention' data-no='" + no + "' name='pr_retention[" + no + "]' value='" + pr_retention + "'/>" + pr_retention + " %</td>";
                html += "<td><input type='hidden' class='sumber_hps' data-no='" + no + "' name='sumber_hps[" + no + "]' value='" + sumber_hps + "'/>" + sumber_hps + "</td>";
                html += "<td><input type='hidden' class='hps' data-no='" + no + "' name='hps[" + no + "]' value='" + hps_int + "'/>" + inttomoney(hps_int) + "</td>";
                html += "<td><input type='hidden' class='subtotal_hps' data-no='" + no + "' name='subtotal_hps[" + no + "]' value='" + subtotal_hps_int + "'/>" + subtotal_hps + "</td>";
                if (tppo == "asset") {
                    html += "<td><input type='hidden' class='no_asset' data-no='" + no + "' name='no_asset[" + no + "]' value='" + no_asset + "'/>" + no_asset + "</td>";
                    html += "<td><input type='hidden' class='sub_number' data-no='" + no + "' name='sub_number[" + no + "]' value='" + sub_number + "'/>" + sub_number + "</td>";
                }
                html += "<input type='hidden' class='ppi_temp_vol' data-no='" + no + "' name='ppi_temp_vol[" + no + "]' value='" + ppi_temp_vol + "'/>";
                html += "<input type='hidden' class='ppi_pr_order' data-no='" + no + "' name='ppi_pr_order[" + no + "]' value='" + ppi_pr_order + "'/>";
                html += "<td><input type='hidden' class='doc_attachment_inp_' data-no='" + no + "' name='doc_attachment_inp_[" + no + "]' value='" + doc_attachment_inp_ + "'/><a href='"+url_file+doc_attachment_inp_+"'>"+doc_attachment_inp_+"</a></td>";
                html += "<td><input type='hidden' class='ppi_update_at' data-no='" + no + "' name='ppi_update_at[" + no + "]' value='" + ppi_update_at + "'/>" + ppi_update_at + "</td>";
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
                $('#incoterm_inp').val("");
                $('#lokasi_incoterm').val("");
                $('#sumber_hps').val("");
                $('#hps').val("");
                $('#doc_attachment_inp_').val("");
                $('#no_asset').val("");
                $('#sub_number').val("");
                $('#tax_code').val("");
                $('#ppi_dev_date').val("");
                $('#ppi_pdt').val("");
                $('#ppi_type_po').val("");
                $('#ppi_po_date').val("");
                $('#ppi_tender_date').val("");
                $('#ppi_status_update').val("");
                $('#ppi_temp_vol').val("");
                $('#ppi_pr_order').val("");
                $('#ppi_update_at').val("");
                $('#pr_retention').val("");
                $("#ppis_pr_number").val("");
                $("#ppis_pr_item").val("");
                $("#ppis_pr_type").val("");
                $("#ppis_delivery_date").val("");
                $("#ppis_cat_tech").val("");
                $("#ppis_acc_assig").val("");
                $("#quantity").val("");
                $("#sisa_kom").val("");
                $("#item_remain").val("");
                $("#efisiensi_po").val("");
                $("#total_po").val("");
                $("#realisasi_qty_item").val("");
                $("#realisasi_po").val("");
                $("#pr_created_date").val("");
                $("#pr_ekgrp").val("");
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
            $('#incoterm_inp').val("");
            $('#lokasi_incoterm').val("");
            $('#sumber_hps').val("");
            $('#hps').val("");
            $('#doc_attachment_inp_').val("");
            $('#no_asset').val("");
            $('#sub_number').val("");
            $('#tax_code').val("");            
            $('#ppi_dev_date').val("");
            $('#ppi_pdt').val("");
            $('#ppi_type_po').val("");
            $('#ppi_po_date').val("");
            $('#ppi_tender_date').val("");
            $('#ppi_status_update').val("");
            $('#ppi_temp_vol').val("");
            $('#ppi_pr_order').val("");
            $('#ppi_update_at').val("");
            $('#pr_retention').val("");
            $("#ppis_pr_number").val("");
            $("#ppis_pr_item").val("");
            $("#ppis_pr_type").val("");
            $("#ppis_delivery_date").val("");
            $("#ppis_cat_tech").val("");
            $("#ppis_acc_assig").val("");
            $("#quantity").val("");
            $("#sisa_kom").val("");
            $("#item_remain").val("");
            $("#efisiensi_po").val("");
            $("#total_po").val("");
            $("#realisasi_qty_item").val("");
            $("#realisasi_po").val("");
            $("#pr_created_date").val("");
            $("#pr_ekgrp").val("");
        });        

        $(document.body).on("click", ".edit_item", function() {        
            var no = $(this).attr('data-no');            
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
            var ppi_dev_date = $(".ppi_dev_date[data-no='" + no + "']").val();
            var ppi_pdt = $(".ppi_pdt[data-no='" + no + "']").val();
            var ppi_type_po = $(".ppi_type_po[data-no='" + no + "']").val();
            var ppi_po_date = $(".ppi_po_date[data-no='" + no + "']").val();
            var ppi_tender_date = $(".ppi_tender_date[data-no='" + no + "']").val();
            var ppi_status_update = $(".ppi_status_update[data-no='" + no + "']").val();
            var ppi_temp_vol = $(".ppi_temp_vol[data-no='" + no + "']").val();
            var ppi_pr_order = $(".ppi_pr_order[data-no='" + no + "']").val();
            var ppi_update_at = $(".ppi_update_at[data-no='" + no + "']").val();
            var pr_retention = $(".pr_retention[data-no='" + no + "']").val();
            var ppis_pr_number = $(".ppis_pr_number[data-no='" + no + "']").val();
            var ppis_pr_item = $(".ppis_pr_item[data-no='" + no + "']").val();
            var pr_spk_code = $(".pr_spk_code[data-no='" + no + "']").val();
            var ppis_pr_type = $(".ppis_pr_type[data-no='" + no + "']").val();            
            var ppis_delivery_date = $(".ppis_delivery_date[data-no='" + no + "']").val();
            var ppis_cat_tech = $(".ppis_cat_tech[data-no='" + no + "']").val();
            var ppis_acc_assig = $(".ppis_acc_assig[data-no='" + no + "']").val();
            var quantity = $(".quantity[data-no='" + no + "']").val();
            var sisa_kom = $(".sisa_kom[data-no='" + no + "']").val();
            var item_remain = $(".item_remain[data-no='" + no + "']").val();
            var efisiensi_po = $(".efisiensi_po[data-no='" + no + "']").val();
            var total_po = $(".total_po[data-no='" + no + "']").val();
            var realisasi_qty_item = $(".realisasi_qty_item[data-no='" + no + "']").val();
            var realisasi_po = $(".realisasi_po[data-no='" + no + "']").val();
            var pr_created_date = $(".pr_created_date[data-no='" + no + "']").val();
            var pr_ekgrp = $(".pr_ekgrp[data-no='" + no + "']").val();                

            $.ajax({
                url: url + "?id=" + kode + "&spk_code=" + pr_spk_code + "&",
                dataType: "json",
                cache: false,
                success: function(data) {
                    $('.int_item').css('display', '');
                    var mydata = data.rows[0];
                    $('#harga_satuan_item_inp').attr('disabled', 'disabled');
                    $('#max_volume').html("<span id='max'><i>batas max " + parseFloat(mydata.ppv_remain).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 8
                    }) + " " + mydata.unit + "</i></span>");
                    $("#jumlah_item_inp").on('keyup', function(e) {                                          
                        $.ajax({
                            url: "<?php echo site_url('Procurement/get_volume') ?>" + "?smbd_code=" + kode + "&spk_code=" + pr_spk_code,
                            dataType: 'json',
                        })
                        .done(function(data_vol) {                                
                            var data_vol = data_vol.rows[0];
                            var vol_remain = data_vol.ppv_remain;
                            if (parseFloat(($("#jumlah_item_inp").val()).replace(/\./g, '')) > parseFloat(vol_remain)) {
                                alert("Jumlah tidak boleh lebih dari " + vol_remain + ' ' + $("#satuan_item_inp").val());
                                $("#jumlah_item_inp").val(0);
                                $("#jumlah_item_inp").focus();
                            }
                        })
                        .fail(function() {
                            console.log("error");
                        });
                    });
                    return false;
                }
            });

            max_notif_item = $(".max_item[data-no='" + no + "']").val();
            $('#max_volume').html(max_notif_item);
            $("#current_item").val(no);
            $("#kode_item").val(kode);
            $("#deskripsi_item").text(deskripsi);
            $("#jumlah_item_inp").val(inttomoney(jumlah));
            $("#satuan_item_inp").val(satuan);
            $("#harga_satuan_item_inp").val(inttomoney(harga_satuan));
            $('#incoterm_inp').val(incoterm);
            $('#lokasi_incoterm').val(lokasi_incoterm);
            $('#sumber_hps').val(sumber_hps);
            $('#hps').val(hps);
            $('#doc_attachment_inp_').val(doc_attachment_inp_);
            $('#no_asset').val(no_asset);
            $('#sub_number').val(sub_number);
            $('#tax_code').val(tax_code);
            $('#ppi_dev_date').val(ppi_dev_date);
            $('#ppi_pdt').val(ppi_pdt);
            $('#ppi_type_po').val(ppi_type_po);
            $('#ppi_po_date').val(ppi_po_date);
            $('#ppi_tender_date').val(ppi_tender_date);
            $('#ppi_status_update').val(ppi_status_update);
            $('#ppi_temp_vol').val(ppi_temp_vol);
            $('#ppi_pr_order').val(ppi_pr_order);
            $('#ppi_update_at').val(ppi_update_at);
            $('#pr_retention').val(pr_retention);
            $("#ppis_pr_number").val(ppis_pr_number);
            $("#ppis_pr_item").val(ppis_pr_item);
            $("#ppis_pr_type").val(ppis_pr_type);
            $("#ppis_delivery_date").val(ppis_delivery_date);
            $("#ppis_cat_tech").val(ppis_cat_tech);
            $("#ppis_acc_assig").val(ppis_acc_assig);
            $("#quantity").val(quantity);
            $("#sisa_kom").val(sisa_kom);
            $("#item_remain").val(item_remain);
            $("#efisiensi_po").val(efisiensi_po);
            $("#total_po").val(total_po);
            $("#realisasi_qty_item").val(realisasi_qty_item);
            $("#realisasi_po").val(realisasi_po);
            $("#pr_created_date").val(pr_created_date);
            $("#pr_ekgrp").val(pr_ekgrp);

            $(this).parent().parent().remove();

            set_total();

            return false;

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
    
    })

    function isShowAddItem() {
        let tppo = $('#tipe_pengadaan').val()
        if (tppo != '') {
            if (tppo != "asset") {
                $('.is_ass').addClass("hide")
            } else {
                $('.is_ass').removeClass("hide")
            }
            if (tppo == "jasa") {
                $('.is_jas').removeClass("hide")
            } else {
                $('.is_jas').addClass("hide")
            }
        } else {
            alert('Tipe pengadaan pada header harus dipilih.')
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
