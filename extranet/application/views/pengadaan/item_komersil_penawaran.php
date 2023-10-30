<style type="text/css">
    .komersial th {
        text-align: center;
        border: 1px solid #DDDDDD !important;
    }

    .komersial td {
        border: 1px solid #DDDDDD !important;
    }

    .custom-table thead th {
        vertical-align: middle;
        text-align: center;
        padding: 0.5rem 2rem;
    }

    .wrapper-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .btn-action-edit {
        border-radius: 8px 0 0 8px;
        width: 100px;
    }

    .btn-action-delete {
        border-radius: 0 8px 8px 0;
        background-color: rgb(36 36 36 / 22%);
        position: relative;
        left: -4px !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Item Sumberdaya</h4>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <form role="form" id="komersial" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal">
                        <input type="hidden" id="section" name="section" value="komersial">
                        <input type="hidden" id="pqmid" name="pqmid" value="<?php if (isset($header)) { echo $header["pqm_id"]; } ?>">

                        <div class="table">
                            <table class="table table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2"><?php echo $this->lang->line('No'); ?></th>
                                        <th colspan="3">Item Tender</th>
                                        <th colspan="6">Penawaran</th>
                                    </tr>
                                    <tr>

                                        <th><?php echo $this->lang->line('Deskripsi'); ?></th>
                                        <th>Qty</th>
                                        <th style="display: none;">Pajak</th>
                                        <th>Keterangan *</th>
                                        <th><?php echo $this->lang->line('Jumlah'); ?> *</th>
                                        <th><?php echo $this->lang->line('Harga Satuan'); ?> *</th>
                                        <th><?php echo $this->lang->line('Sub Total'); ?> *</th>
                                        <th>Garansi *</th>
                                        <th>Penyerahan / Pelaksanaan *</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($item as $row) {
                                    ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo $i ?></td>
                                            <td>
                                                <?php echo $row["tit_description"] ?>
                                                <input type="hidden" id="desc_<?php echo $i ?>_temp" value="<?php echo $row["tit_description"] ?>">
                                                <input type="hidden" id="tit_<?php echo $i ?>" name="tit_<?php echo $i ?>" value="<?php echo (isset($row["tit_id"])) ? $row["tit_id"] : "" ?>">
                                                <input type="hidden" id="pqiid_<?php echo $i ?>" name="pqiid_<?php echo $i ?>" value="<?php echo (isset($row["pqi_id"])) ? $row["pqi_id"] : "" ?>">
                                            </td>
                                            <td>
                                                <?php echo number_format($row["tit_quantity"], 2) ?>
                                            </td>
                                            <td style="display: none;">
                                                PPN : <?php echo (!empty($row["tit_ppn"])) ? $row["tit_ppn"] : 0 ?> %
                                                <input type="hidden" id="ppn_<?php echo $i ?>" name="ppn_<?php echo $i ?>" value="<?php echo $row["tit_ppn"]; ?>">
                                                <br />
                                                PPH : <?php echo (!empty($row["tit_pph"])) ? $row["tit_pph"] : 0 ?> %
                                                <input type="hidden" id="pph_<?php echo $i ?>" name="pph_<?php echo $i ?>" value="<?php echo $row["tit_pph"]; ?>">
                                            </td>
                                            <td>
                                                <textarea class="form-control d-none" id="desc_<?php echo $i ?>" name="desc_<?php echo $i ?>" required><?php echo (isset($row["pqi_description"])) ? $row["pqi_description"] : $row["tit_description"] ?></textarea>
                                                <?php echo (isset($row["pqi_description"])) ? $row["pqi_description"] : $row["tit_description"] ?>
                                            </td>
                                            <td>
                                                <input <?php echo $readonly ?>onblur="fnChange('<?php echo $i ?>','qty')" type="text" class="form-control money" id="qty_<?php echo $i ?>" name="qty_<?php echo $i ?>" required value="<?php echo (isset($row["pqi_quantity"])) ? number_format($row["pqi_quantity"], 2) : "" ?>">
                                                <input class="form-control money" type="hidden" id="qty_<?php echo $i ?>_input" name="qty_<?php echo $i ?>_input" value="<?php echo (isset($row["pqi_quantity"])) ? $row["pqi_quantity"] : "" ?>" min="1" required>
                                                <input class="form-control money" type="hidden" id="qty_<?php echo $i ?>_temp" name="qty_<?php echo $i ?>" value="<?php echo $row["tit_quantity"] ?>">
                                            </td>

                                            <td>
                                                <input <?php echo $readonly ?> onblur="fnChange('<?php echo $i ?>','price')" type="text" class="form-control money" id="price_<?php echo $i ?>" name="price_<?php echo $i ?>" value="<?php echo (isset($row["pqi_price"])) ? $row["pqi_price"] : "" ?>" required>
                                                <input type="hidden" id="price_<?php echo $i ?>_input" name="price_<?php echo $i ?>_input" value="<?php echo (isset($row["pqi_price"])) ? $row["pqi_price"] : "" ?>" min="1" required>
                                            </td>

                                            <td>
                                                <input readonly type="text" class="form-control" id="total_<?php echo $i ?>" name="total_<?php echo $i ?>" value="">
                                                <input type="hidden" id="taxppn_<?php echo $i ?>" name="taxppn_<?php echo $i ?>" value="<?php echo $row["tit_ppn"] / 100 ?>">
                                                <input type="hidden" id="taxpph_<?php echo $i ?>" name="taxpph_<?php echo $i ?>" value="<?php echo $row["tit_pph"] / 100 ?>">
                                            </td>

                                            <td>
                                                <input <?php echo $readonly ?> type="text" class="form-control col-sm-6 guarantee_time_item float-left" id="guarantee_<?php echo $i ?>" name="guarantee_<?php echo $i ?>" value="<?php echo (isset($row["pqi_guarantee"])) ? $row["pqi_guarantee"] : 0 ?>" required>
                                                <select <?php echo $readonly ?> class="form-control col-sm-6 guarantee_unit_item float-right" name="guarantee_type_<?php echo $i ?>">
                                                    <?php
                                                    $curval = (isset($row["pqi_guarantee_type"])) ? $row["pqi_guarantee_type"] : "";
                                                    foreach (array("Hari", "Bulan", "Tahun") as $key => $value) { ?>
                                                        <option <?php echo ($value == $curval) ? "selected" : "" ?>><?php echo $value ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td>
                                                <input <?php echo $readonly ?> type="text" class="form-control col-sm-6 deliverable_time_item float-left" id="deliverable_<?php echo $i ?>" name="deliverable_<?php echo $i ?>" value="<?php echo (isset($row["pqi_deliverable"])) ? $row["pqi_deliverable"] : 0 ?>" required>
                                                <select <?php echo $readonly ?> class="form-control col-sm-6 deliverable_unit_item float-right" name="deliverable_type_<?php echo $i ?>">
                                                    <?php
                                                    $curval = (isset($row["pqi_deliverable_type"])) ? $row["pqi_deliverable_type"] : "";
                                                    foreach (array("Hari", "Bulan", "Tahun") as $key => $value) { ?>
                                                        <option <?php echo ($value == $curval) ? "selected" : "" ?>><?php echo $value ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                        </tr>
                                    <?php
                                        $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>

                        <input id="tenderids" name="tenderids" type="hidden" value="<?php echo $tenderid; ?>">
                        <input type="hidden" id="num_item" name="num_item" value="<?php echo $i ?>">
                        <input type="hidden" id="modo" name="modo" value="<?php if (isset($header)) { echo "edit"; } else { echo "insert"; } ?>">
                        <input type="hidden" id="submitStatus" name="submitStatus" value="<?php if (isset($header) and isset($isDraft)) { echo "draft"; } elseif (isset($header)) { echo "permanent"; } ?>">
                        <input type="hidden" name="tipe_penawaran" id="tipe_penawaran_item">
                        
                        <table class="invoice-total float-right my-3">
                            <tbody>
                                <tr style="display: none;">
                                    <td><strong><?php echo $this->lang->line('Total Sebelum PPN'); ?> :</strong></td>
                                    <td id="totalss"></td>
                                </tr>
                                <tr style="display: none;">
                                    <td><strong><?php echo $this->lang->line('PPN'); ?> :</strong></td>
                                    <td id="totalppn"></td>
                                </tr>
                                <tr style="display: none;">
                                    <td><strong><?php echo $this->lang->line('PPH'); ?> :</strong></td>
                                    <td id="totalpph"></td>
                                </tr>
                                <tr class="text-bold-700 border border-dark">
                                    <td class="p-1"><?php echo $this->lang->line('Total'); ?> : </td>
                                    <td id="subtotalss"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span class="wrapper-header">
                    <div class="title-header d-flex align-items-center">
                        <h4 class="card-title ">Detail Item Sumber Daya</h4>
                        <a onclick="isDetailRisikoVnd()" class="btn btn-sm btn-info btn-tambah ml-2 rounded">
                            <i class="ft ft-plus"></i>Tambah
                        </a>
                    </div>
                    <div class="wrapper-button" id="btnSaveRisikoDetail" style="display: none;">
                        <span class="wrapper-action save-comment">
                            <a class="btn btn-sm btn-info btn-action-edit action_detail_item">Simpan</a>
                            <a onclick="resetFormDI()" class="btn btn-sm btn-action-delete empty_item">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                            <input type="hidden" id="detail_no_edit">
                        </span>
                    </div>
                </span>
                <div id="addInputRisikoDetail" style="display: none;">
                    <div class="row mb-2">
                        <div class="col-md row">
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Item</label>
                                <div class="col-sm-8" id="item_codes">
                                    <select name="rsd_item" id="rsd_item" class="form-control mb-1 bg-select select2 mb1-l" style="width: 100%;">
                                        <option value="">Pilih item</option>
                                        <?php foreach ($product_item->data as $key => $val) {
                                            $selected = ($val->code_1 == $curval) ? "selected" : "";
                                        ?>
                                            <option <?= $selected ?> value="<?= $val->code_1 ?>"><?= $val->code_1 ?> - <?= $val->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Volume</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control money valid" name="rsd_volume" id="rsd_volume" placeholder="Masukan Volume">
                                </div>
                            </div>
                        </div>
                        <div class="col-md row">
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Satuan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="rsd_satuan" id="rsd_satuan" placeholder="Masukan Satuan">
                                </div>
                            </div>
                            <div class="row form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label">Harga Satuan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control money valid" name="rsd_harga_satuan" id="rsd_harga_satuan" placeholder="Masukkan Harga Satuan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md row mb-1">
                            <label class="col-sm-2 control-label">Keterangan</label>
                            <div class="col-sm-10" style="padding-left: 10px;">
                                <input type="text" class="form-control" name="rsd_keterangan" id="rsd_keterangan" placeholder="Masukkan Keterangan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form role="form" id="detail_item" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal">
                <input type="hidden" id="section" name="section" value="detail_item">
                <input id="tenderids" name="tenderids" type="hidden" value="<?php echo $tenderid; ?>">
                <input type="hidden" id="modo" name="modo" value="<?php if (isset($header)) {
                                                                        echo "edit";
                                                                    } else {
                                                                        echo "insert";
                                                                    } ?>">
                <table class="table table-striped table-responsive custom-table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Keterangan</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Sub Total</th>
                            <th style="min-width: 250px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detail-itempr" style="text-align: center;">
                        <?php
                        if (isset($risiko_detail)) {
                            foreach ($risiko_detail as $k => $v) {
                        ?>
                                <tr>
                                    <td><?= ($k + 1) ?></td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='id_tbl' id='id_tbl' name='id_tbl[<?= ($k + 1) ?>]' value='<?= $v['id'] ?>'>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_item_tbl' id='rsd_item_tbl' name='rsd_item_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_item'] ?>'>
                                        <?= $v['rsd_item'] ?>
                                    </td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_keterangan_tbl' id='rsd_keterangan_tbl' name='rsd_keterangan_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_keterangan'] ?>'>
                                        <?= $v['rsd_keterangan'] ?>
                                    </td>
                                    <td>
                                        <input onchange="changeSubtotal()" data-no='<?= ($k + 1) ?>' type='text' class='form-control rsd_volume_tbl' id='rsd_volume_tbl' name='rsd_volume_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_volume'] ?>'>
                                    </td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='text' class='form-control rsd_satuan_tbl' id='rsd_satuan_tbl' name='rsd_satuan_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_satuan'] ?>'>
                                    </td>
                                    <td>
                                        <input onchange="changeSubtotal()" data-no='<?= ($k + 1) ?>' type='text' class='form-control rsd_harga_satuan_tbl' id='rsd_harga_satuan_tbl' name='rsd_harga_satuan_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_harga_satuan'] ?>'>
                                    </td>
                                    <td>
                                        <span class="subtotal_detail_vnd"></span>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_subtotal_tbl' id='rsd_subtotal_tbl' name='rsd_subtotal_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_subtotal'] ?>'>
                                    </td>
                                    <td>
                                        <a type='button' class='btn btn-sm btn-info btn-xs btn-action-edit edit_detail_item' data-no='<?= ($k + 1) ?>'>Edit</a>
                                        <a class='btn btn-sm btn-action-delete delete_detail_item' data-values="<?= $v['id'] ?>" data-no='<?= ($k + 1) ?>'><i class='fa fa-trash fa-lg'></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
            <div class="row form-group mr-2 mt-2 mb-2">
                <div class="col-sm-5">
                </div>
                <label class="col-sm-3 control-label text-right">Total</label>
                <div class="col-sm-3">
                    <p class="form-control-static text-right" id="subtotal_detail"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Bid Bond</h4>
            </div>

            <div class="card-content">
                <div class="card-body text-center">
                    <form role="form" id="bidbond" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal">
                        <input type="hidden" id="section" name="section" value="bidbond">
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $this->lang->line('Nilai Bidbond'); ?>
                            </label>
                            <div class="col-lg-3 m-l-n"><input <?php echo $readonly ?> onblur="fnChange('','bid_bond')" type="text" id="bid_bond" class="form-control" value="<?php if (isset($header)) {
                                                                                                                                                                                    echo $header["pqm_bid_bond_value"];
                                                                                                                                                                                } ?>"></div>
                            <input type="hidden" id="bid_bond_input" name="bid_bond_input" value="<?php if (isset($header)) {
                                                                                                        echo $header["pqm_bid_bond_value"];
                                                                                                    } ?>">
                            <label class="col-sm-2 control-label">
                                <?php echo $this->lang->line('Lampiran Bidbond'); ?>
                            </label>
                            <div class="col-lg-3 m-l-n">
                                <?php if (empty($readonly)) { ?>
                                    <input <?php echo $readonly ?> id="lampiran_bidbond" name="lampiran_bidbond" type="file" class="file" accept="<?php echo ALLOWED_EXT_FILES ?> ">
                                    <small id="error_bidbond"></small>
                                    <div class="col-sm-0" style="font-size: 11px">
                                        <i>Max file 2 MB
                                            <br>
                                            Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                                        </i>
                                    </div>
                                <?php } ?>
                                <?php if (isset($header)) { ?>
                                    <p class="form-control-static">
                                        <a target="_blank" href="<?php echo site_url('pengadaan/download/bidbond/' . $this->umum->forbidden($this->encryption->encrypt($header["pqm_att"]), 'enkrip')); ?>"><?php echo $header["pqm_att"]; ?></a>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".money").keydown(function(e) {
            if (e.keyCode == 188) {
                e.preventDefault();
            }
        })

        var item_table = $('.komersial').DataTable({
            "scrollX": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "pageLength": -1,
        })

        $('#tipe_penawaran_item').change(function(event) {
            setTimeout(function() {
                item_table.page.len(10).draw();
            }, 1000)

        });

        if ($('#modo').val() == 'edit') {
            setTimeout(function() {
                item_table.page.len(10).draw();
            }, 1000)
        }

        $('#submitBtn, #submitDraftBtn').click(function(event) {
            item_table.page.len(-1).draw();
        });

        $('#lampiran_bidbond').bind('change', function(event) {
            $('#error_msg_bidbond').remove();
            var ext = $(this).val().split('.').pop().toLowerCase();
            var files = event.target.files;
            console.log(files)

            if (files[0].size > 2097152) {
                $(this).val('');
                $('#error_bidbond').append("<span style='color:red' id='error_msg_bidbond'>File tidak boleh lebih dari 2MB</span>");
            } else if ($.inArray(ext, ['doc', 'docx', "xls", 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar', 'tgz', '7zip', 'tar']) == -1) {
                $(this).val('');
                $('#error_bidbond').append("<span style='color:red' id='error_msg_bidbond'>Format file tidak sesuai</span>");
            }
        });
    })
</script>

<script>
    changeSubtotal()

    function changeSubtotal() {
        let rsd_subtotal_tbl_let = 0
        $("#detail-itempr tr").each(function() {
            let rsd_volume_tbl_l = ($(this).find(".rsd_volume_tbl").val()) ? parseInt($(this).find(".rsd_volume_tbl").val()) : 0;
            let rsd_hrg_sat_tbl_l = ($(this).find(".rsd_harga_satuan_tbl").val()) ? parseInt($(this).find(".rsd_harga_satuan_tbl").val()) : 0;
            rsd_subtotal_tbl_let = rsd_volume_tbl_l * rsd_hrg_sat_tbl_l

            $(this).find(".subtotal_detail_vnd").text(rsd_subtotal_tbl_let)
            $(this).find(".rsd_subtotal_tbl").val(rsd_subtotal_tbl_let)
        })

        subtotal_change()
    }

    function subtotal_change() {
        $('#subtotal_detail').text(0)
        let result_subtotals = 0
        $("#detail-itempr tr").each(function() {
            let subtotals = ($(this).find(".rsd_subtotal_tbl").val()) ? parseInt($(this).find(".rsd_subtotal_tbl").val()) : 0;
            result_subtotals += subtotals;
        })

        $('#subtotal_detail').text(result_subtotals)
    }

    $('.action_detail_item').click(() => {
        let rsd_item_rateonly, rsd_item, rsd_item_tbl = ''
        if ($('#rsd_item').val() === '0') {
            rsd_item_tbl = $('#rsd_item_rateonly').val()
        } else {
            rsd_item_tbl = $('#rsd_item').val()
        }
        let rsd_volume = $('#rsd_volume').val()
        let rsd_satuan = $('#rsd_satuan').val()
        let rsd_harga_satuan = $('#rsd_harga_satuan').val()
        let rsd_keterangan = $('#rsd_keterangan').val()
        let current_item = $("#detail_no_edit").val()
        let no = current_item
        if (current_item == "") {
            if (getMaxDataNo(".edit_detail_item") == null) {
                no = 1;
            } else {
                no = getMaxDataNo(".edit_detail_item") + 1;
            }
        }
        if (rsd_volume === '' || rsd_satuan === '' || rsd_keterangan === '') {
            alert("Volume, Satuan, dan Keterangan Harus diisi!");
            return false
        } else {
            let rsd_subtotal_tbl = rsd_volume * rsd_harga_satuan
            let html = "<tr>"
            html += "<td>" + no + "</td>"
            html += "<td><input data-no='" + no + "' type='hidden' class='rsd_item_tbl' id='rsd_item_tbl' name='rsd_item_tbl[" + no + "]' value='" + rsd_item_tbl + "'>" + rsd_item_tbl + "</td>"
            html += "<td><input data-no='" + no + "' type='hidden' class='rsd_keterangan_tbl' id='rsd_keterangan_tbl' name='rsd_keterangan_tbl[" + no + "]' value='" + rsd_keterangan + "'>" + rsd_keterangan + "</td>"
            html += "<td><input data-no='" + no + "' onchange='changeSubtotal()' type='text' class='form-control rsd_volume_tbl' id='rsd_volume_tbl' name='rsd_volume_tbl[" + no + "]' value='" + rsd_volume + "'></td>"
            html += "<td><input data-no='" + no + "' type='text' class='form-control rsd_satuan_tbl' id='rsd_satuan_tbl' name='rsd_satuan_tbl[" + no + "]' value='" + rsd_satuan + "'></td>"
            html += "<td><input data-no='" + no + "' onchange='changeSubtotal()' type='text' class='form-control rsd_harga_satuan_tbl' id='rsd_harga_satuan_tbl' name='rsd_harga_satuan_tbl[" + no + "]' value='" + rsd_harga_satuan + "'></td>"
            html += "<td><input data-no='" + no + "' type='hidden' class='rsd_subtotal_tbl' id='rsd_subtotal_tbl' name='rsd_subtotal_tbl[" + no + "]' value='" + rsd_subtotal_tbl + "'><span class='subtotal_detail_vnd'>" + rsd_subtotal_tbl + "</span></td>"
            html += "<td><a type='button' class='btn btn-sm btn-info btn-xs btn-action-edit edit_detail_item' data-no='" + no + "'>Edit</a><a class='btn btn-sm btn-action-delete delete_detail_item'><i class='fa fa-trash fa-lg'></i></a></td>"
            html += "</tr>"

            $('#detail-itempr').append(html)
            subtotal_change()
            resetFormDI()
        }
    })

    $(document.body).on("click", ".edit_detail_item", function() {
        var div = document.getElementById("addInputRisikoDetail");
        var smbd_save = document.getElementById("btnSaveRisikoDetail");
        div.style.display = "block";
        smbd_save.style.display = "flex";
        let no = $(this).attr('data-no');
        let rsd_keterangan = $('.rsd_keterangan_tbl').val()
        let rsd_volume = $('.rsd_volume_tbl').val()
        let rsd_satuan = $('.rsd_satuan_tbl').val()
        let rsd_harga_satuan = $('.rsd_harga_satuan_tbl').val()
        $('#detail_no_edit').val(no)
        $('#rsd_keterangan').val(rsd_keterangan)
        $('#rsd_volume').val(rsd_volume)
        $('#rsd_satuan').val(rsd_satuan)
        $('#rsd_harga_satuan').val(rsd_harga_satuan)
        $(this).parent().parent().remove()
    })

    $(document.body).on("click", ".delete_detail_item", function() {
        let text = "Apakah anda yakin akan menghapus data ini?"
        if (confirm(text)) {
            $(this).parent().parent().remove()

            let formData = new FormData();
            formData.append('id_tbl_del', $(this).attr("data-values"));
            <?php $url = site_url("pengadaan/deleteDetailItem") ?>
            fetch("<?= $url ?>", {
                    body: formData,
                    method: "post"
                })
                .then(response => response.json())
                .then(res => {
                    swal("Success", "Berhasil hapus Detail Item Sumberdaya", "success");
                })
        }
    })

    function resetFormDI() {
        $('#rsd_item_rateonly').val("")
        $('#rsd_item').val("").trigger('change')
        $('#rsd_volume').val("")
        $('#rsd_satuan').val("")
        $('#rsd_harga_satuan').val("")
        $('#rsd_keterangan').val("")
    }
    const arraySumberdaya = [{
        "kode": "0",
        "nama_sumberdaya": "Lainnya (Rate Only)"
    }];

    arraySmbd()

    function arraySmbd() {
        $.ajax({
            url: '<?= site_url("procurement/proses_pengadaan/get_ecatalog"); ?>',
            method: 'get',
            dataType: 'json',
            success: async (res) => {
                let catalog = res.data;
                catalog.map(val => {
                    arraySumberdaya.push({
                        "kode": val.code_1,
                        "nama_sumberdaya": val.name
                    })
                })
                await formatSelect();
            }
        })
    };

    function formatSelect() {
        var selectList = document.getElementById("rsd_item");
        for (var i = 0; i < arraySumberdaya.length; i++) {
            var option = document.createElement("option");
            option.setAttribute("value", arraySumberdaya[i].kode);
            option.text = arraySumberdaya[i].kode + " - " + arraySumberdaya[i].nama_sumberdaya;
            selectList.appendChild(option);
        }
    }

    function changeItemSmbd() {
        let kode_item = $('#rsd_item').val();
        var inputRate = document.createElement("input");
        var appendInputs = document.getElementById("item_codes");
        inputRate.setAttribute("id", "rsd_item_rateonly");
        inputRate.setAttribute("name", "rsd_item_rateonly");
        inputRate.setAttribute("class", "form-control");
        inputRate.setAttribute("placeholder", "Masukkan rate only");

        if (kode_item === '0') {
            appendInputs.appendChild(inputRate);
        } else {
            if (appendInputs.children[2]) {
                appendInputs.removeChild(appendInputs.children[2]);
            }
        }
    }


    function isDetailRisikoVnd() {
        var div = document.getElementById("addInputRisikoDetail");
        var smbd_save = document.getElementById("btnSaveRisikoDetail");
        if (div.style.display !== "none") {
            div.style.display = "none";
            smbd_save.style.display = "none";
        } else {
            div.style.display = "block";
            smbd_save.style.display = "flex";
        }
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function getMaxDataNo(selector) {
        var min = null,
            max = null;
        $(selector).each(function() {
            var no_pp = parseInt($(this).attr('data-no'), 10);
            if ((max === null) || (no_pp > max)) {
                max = no_pp;
            }
        });
        return max;
    }
</script>