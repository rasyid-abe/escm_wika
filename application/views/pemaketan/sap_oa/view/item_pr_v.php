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
                  <th>No</th>
                  <th>Kode SDA</th>
                  <th>PR Number</th>
                  <th>PR Item</th>
                  <th>PR Type</th>
                  <th>Date Delivery</th>
                  <th>Cat Tech</th>
                  <th>Acc Assig</th>
                  <th>Nama Sumber Daya</th>
                  <th>Volume</th>
                  <th>Satuan</th>
                  <th>Harga Satuan RAB</th>
                  <th>Subtotal RAB</th>
                  <th>Incoterm</th>
                  <th>Lokasi Incoterm</th>
                  <th>Retention</th>
                  <th>Sumber HPS</th>
                  <th>HPS</th>
                  <th>Subtotal HPS</th>
                  <th>Lampiran</th>
                  <th style="display: none">Pajak</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $subtotal = 0;
                $subtotalhps = 0;
                if (isset($item) && !empty($item)) {
                  foreach ($item as $key => $value) {
                    $idnya = $key + 1;

                ?>

                    <tr>
                      <td><?= $idnya ?></td>
                      <td>
                        <?php echo $value['ppi_code'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_pr_number'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_pr_item'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_pr_type'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_delivery_date'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_cat_tech'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppis_acc_assig'] ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_description'] ?>
                      </td>
                      <td class="text-right">
                        <?php echo inttomoney($value['ppi_quantity']) ?>
                      </td>
                      <td>
                        <?php echo $value['ppi_unit'] ?>
                      </td>
                      <td class="text-right">
                        <?php echo inttomoney($value['ppi_price']) ?>
                      </td>
                      <td class="text-right" id="subtotal_rab">
                        <?php echo inttomoney($value['ppi_price'] * $value['ppi_quantity']) ?>
                      </td>
                      <td class="text-right" style="display: none">
                        <input type="hidden" value="<?php echo $value['ppi_ppn'] ?>" name="item_ppn_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppn_satuan_item">
                        <?php echo (!empty($value['ppi_ppn'])) ? " PPN (" . $value['ppi_ppn'] . "%) " : "" ?>
                        <input type="hidden" value="<?php echo $value['ppi_pph'] ?>" name="item_pph_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pph_satuan_item">
                        <?php echo (!empty($value['ppi_pph'])) ? " PPH (" . $value['ppi_pph'] . "%)" : "" ?>
                      </td>
                      <td>
                        <?= $value['ppi_incoterm'] ?>
                      </td>
                      <td>
                        <?= $value['ppi_lokasi_incoterm'] ?>
                      </td>
                      <td>
                          <?= $value['ppi_retention'] ?> %
                      </td>
                      <td>
                        <?= $value['ppi_sumber_hps'] ?>
                      </td>
                      <td>
                        <?= inttomoney($value['ppi_hps']) ?>
                      </td>
                      <td id="subtotal_hps">
                        <?= inttomoney($value['ppi_hps'] * $value['ppi_quantity']) ?>
                      </td>
                      <td>
                        <a href="<?= site_url('log/download_attachment/procurement/tender/' . $value['ppi_lampiran']); ?>">
                          <?php echo $value['ppi_lampiran'] ?>
                        </a>
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
                <p class="form-control-static text-right" id="total_rab"><?= inttomoney($subtotal) ?></p>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-5">
              </div>
              <label class="col-sm-4 control-label text-right">Total HPS</label>
              <div class="col-sm-3">
                <p class="form-control-static text-right" id="total_hps"><?= inttomoney($subtotalhps) ?></p>
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