<style scoped>
    .custom-table thead th {
        vertical-align: middle;
        text-align: center;
        padding: 0.5rem 2rem;
    }

    /* animate loading */
    #loading {
        width: 5rem;
        height: 5rem;
        border: 10px solid #f3f3f3;
        border-top: 11px solid #2aace3;
        border-radius: 100%;
        margin: auto;
        display: none;
        animation: spin 1s infinite linear;
    }

    #loading.display {
        display: block;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span class="wrapper-header">
                    <div class="title-header d-flex align-items-center">
                        <h4 class="card-title ">Detail Item Sumber Daya</h4>
                    </div>
                </span>
                <table class="table table-striped custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Keterangan</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody id="detail-itempr" style="text-align: center;">
                        <?php
                        $subtotal_detail_item = 0;
                        if (isset($risiko_detail) && !empty($risiko_detail)) {
                            foreach ($risiko_detail as $k => $v) {
                                $subtotal_detail_item_sum = (float)$v['rsd_volume'] * (float)$v['rsd_harga_satuan'];
                                $subtotal_detail_item += $subtotal_detail_item_sum;
                        ?>
                                <tr>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='id_detail_item' id='id_detail_item' name='id_detail_item[<?= ($k + 1) ?>]' value='<?= $v['id'] ?>'>
                                        <?= ($k + 1) ?>
                                    </td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_item_tbl' id='rsd_item_tbl' name='rsd_item_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_item'] ?>'>
                                        <?= $v['rsd_item'] ?>
                                    </td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_keterangan_tbl' id='rsd_keterangan_tbl' name='rsd_keterangan_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_keterangan'] ?>'>
                                        <?= $v['rsd_keterangan'] ?>
                                    </td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_volume_tbl' id='rsd_volume_tbl' name='rsd_volume_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_volume'] ?>'>
                                        <?= $v['rsd_volume'] ?>
                                    </td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_satuan_tbl' id='rsd_satuan_tbl' name='rsd_satuan_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_satuan'] ?>'>
                                        <?= $v['rsd_satuan'] ?>
                                    </td>
                                    <td>
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_harga_satuan_tbl' id='rsd_harga_satuan_tbl' name='rsd_harga_satuan_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_harga_satuan'] ?>'>
                                        <?= $v['rsd_harga_satuan'] ?>
                                    </td>
                                    <td class="subtotal">
                                        <input data-no='<?= ($k + 1) ?>' type='hidden' class='rsd_subtotal_tbl' id='rsd_subtotal_tbl' name='rsd_subtotal_tbl[<?= ($k + 1) ?>]' value='<?= $v['rsd_volume'] * $v['rsd_harga_satuan'] ?>'>
                                        <?= inttomoney($v['rsd_volume'] * $v['rsd_harga_satuan']); ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="row form-group mr-2 mt-2 mb-2">
                    <div class="col-sm-5">
                    </div>
                    <label class="col-sm-3 control-label text-right">Total</label>
                    <div class="col-sm-3">
                        <p class="form-control-static text-right" id="subtotal_detail"><?= $subtotal_detail_item ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>