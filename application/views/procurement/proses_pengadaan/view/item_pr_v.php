<?php if ($permintaan['pr_type'] == "MATERIAL STRATEGIS") {
  include(VIEWPATH . "procurement/proses_pengadaan/view/item_pr_matgis_v.php");
} else { ?>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Item Sumber Daya</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
            <table class="table table-striped table-responsive" id="item_table">
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
                  <th rowspan="2" class="is_ass">No Asset</th>
                  <th rowspan="2" class="is_ass">Sub Number</th>
                  <th rowspan="2">Lampiran</th>
                  <th rowspan="2">Update Date</th>
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
                if (isset($item_sap) && !empty($item_sap)) {
                  foreach ($item_sap as $key => $value) {
                    $idnya = $key + 1;
                ?>
                    <tr>
                      <td><?php echo $idnya ?></td>
                      <td>
                        <?php echo $value['ppis_pr_number'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_acc_assig'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_pr_item'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_code'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_description'] ?>
                      </td>
                      <td>
                        <?php echo $value['pr_ekgrp'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_unit'] ?>
                      </td>
                      <td class="text-right">
                        <?php echo inttomoney($value['ppi_quantity']) ?>
                      </td>
                      <td class="text-right">
                        <?php echo inttomoney($value['ppi_price']) ?>
                      </td>
                      <td class="text-right" id="subtotal_rab">
                        <?php echo inttomoney($value['ppi_price'] * $value['ppi_quantity']) ?>
                      </td>
                      <td>
                        <?php echo $value['pr_created_date'] != '' ? $value['pr_created_date'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_delivery_date'] != '' ? $value['ppis_delivery_date'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_dev_date'] != '' ? $value['ppi_dev_date'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_status_update'] != '' ? $value['ppi_status_update'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_po_date'] != '' ? $value['ppi_po_date'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_tender_date'] != '' ? $value['ppi_tender_date'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['realisasi_po'] != '' ? $value['realisasi_po'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['realisasi_qty_item'] != '' ? $value['realisasi_qty_item'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['total_po'] != '' ? $value['total_po'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['efisiensi_po'] != '' ? $value['efisiensi_po'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['item_remain'] != '' ? inttomoney($value['item_remain']) : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['sisa_kom'] != '' ? $value['sisa_kom'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['quantity'] != '' ? $value['quantity'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_pdt'] != '' ? $value['ppi_pdt'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_tax_code'] != '' ? $value['ppi_tax_code'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_type_po'] != '' ? $value['ppi_type_po'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_pr_type'] != '' ? $value['ppis_pr_type'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_cat_tech'] != '' ? $value['ppis_cat_tech'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_incoterm'] != '' ? $value['ppi_incoterm'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_lokasi_incoterm'] != '' ? $value['ppi_lokasi_incoterm'] : '-'; ?>
                      </td>
                      <td>
                          <?php echo $value['ppi_retention'] != '' ? $value['ppi_retention'] . ' %' : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_sumber_hps'] != '' ? $value['ppi_sumber_hps'] : '-'; ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_hps'] != '' ? inttomoney($value['ppi_hps']) : '-'; ?>
                      </td>
                      <td id="subtotal_hps">
                        <?php echo inttomoney($value['ppi_hps'] * $value['ppi_quantity']) ?>
                      </td>
                      <div class="is_ass">
                        <td>
                            <input type="hidden" value="<?php echo $value['ppi_no_asset'] ?>" name="ppi_no_asset[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="no_asset">
                            <?php echo $value['ppi_no_asset'] ?>
                        </td>
                        <td>
                            <input type="hidden" value="<?php echo $value['ppi_sub_number'] ?>" name="sub_number[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="sub_number">
                            <?php echo $value['ppi_sub_number'] ?>
                        </td>
                      </div>
                      <td>
                        <?php if($value['ppi_lampiran'] != '') { ?>
                          <a href="<?php echo site_url('log/download_attachment/procurement/tender/' . $value['ppi_lampiran']); ?>">
                            <?php echo $value['ppi_lampiran'] ?>
                          </a>
                        <?php } else { ?>
                          -
                        <?php } ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_update_at'] ?>
                      </td>
                    </tr>
                <?php
                    $subtotal += $value['ppi_price'] * $value['ppi_quantity'];
                    $subtotalhps += $value['ppi_hps'] * $value['ppi_quantity'];
                  }
                } ?>

              </tbody>
            </table>

            <hr>
            <div class="row form-group">
              <div class="col-sm-5">
              </div>
              <label class="col-sm-4 control-label text-right">Total RAB</label>
              <div class="col-sm-3">
                <p class="form-control-static text-right" id="total_rab"><?php echo inttomoney($subtotal) ?></p>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-5">
              </div>
              <label class="col-sm-4 control-label text-right">Total HPS</label>
              <div class="col-sm-3">
                <p class="form-control-static text-right" id="total_hps"><?php echo inttomoney($subtotalhps) ?></p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      <?php if (!$perencanaan['ppm_is_integrated']) { ?>
        $('.int_item').css('display', 'none');
      <?php } else { ?>
        $('.int_item').css('display', '');
      <?php } ?>
      $('[data-toggle="popover"]').popover();

    })
  </script>
<?php } ?>