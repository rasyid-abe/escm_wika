<?php $ctr_type = (isset($kontrak['contract_type'])) ? $kontrak["contract_type"] : ""; ?>
 <div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
        <h4 class="card-title float-left">Daftar Sumberdaya</h4>
      </div>

      <div class="card-content">
        <div class="card-body">

          <div class="table-responsive">
              <table class="table" >
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama Sumberdaya</th>
                      <?php if ($is_sap == 1): ?>

                      <?php endif; ?>
                      <th>Item PO</th>
                      <th>Volume</th>
                      <th>Satuan</th>
                      <th>Harga Satuan</th>
                      <th>Subtotal</th>
                      <th>Incoterm</th>
                      <th>Lokasi Incoterm</th>
                      <th>Sumber HPS</th>
                      <th>HPS</th>
                      <th>Subtotal HPS</th>
                      <th style="display: none;">Pajak</th>
                      <?php if ($is_sap == 1): ?>
                          <th>No Asset</th>
                          <th>Sub Number</th>
                          <th>Tax Code</th>
                          <th>Action</th>
                      <?php endif; ?>
                    </tr>

                  </thead>

                  <tbody>

                    <?php
                    $subtotal = 0;
                    $subtotal_ppn = 0;
                    $subtotal_pph = 0;
                    foreach ($item as $key => $value) { ?>
                    <tr>
                      <td class="align-middle"><?php echo $key+1 ?></td>
                      <td class="align-middle"><?php echo $value['tit_code'] ?></td>
                      <td class="align-middle"><?php echo $value['tit_description'] ?></td>
                      <?php if ($is_sap == 1): ?>
                          <td class="align-middle"><?php echo ($key+1) * 10 ?></td>
                      <?php endif; ?>
                      <td class="text-right align-middle"><?php echo inttomoney($value['tit_quantity']) ?></td>
                      <td class="align-middle"><?php echo $value['tit_unit'] ?></td>
                      <td class="text-right align-middle"><?php echo inttomoney($value['tit_price']) ?>
                        <input type="hidden" class="form-control price" value="<?php echo $value['tit_price'] ?>">
                      </td>
                      <td class="text-right align-middle"><?php echo inttomoney($value['tit_quantity'] * $value['tit_price']) ?></td>
                      <td class="align-middle"><?= $value['tit_incoterm'] ?></td>
                      <td class="align-middle"><?= $value['tit_lokasi_incoterm'] ?></td>
                      <td class="align-middle"><?= $value['tit_sumber_hps'] ?></td>
                      <td class="align-middle"><?= $value['tit_hps'] ?></td>
                      <td class="align-middle"><?= inttomoney($value['tit_quantity'] * $value['tit_hps'] ) ?></td>
                      <td style="display: none;">
                        <?php echo (!empty($value['tit_ppn'])) ? " PPN (".$value['tit_ppn']."%) " : "" ?>
                        <?php echo (!empty($value['tit_pph'])) ? " PPH (".$value['tit_pph']."%)" : "" ?>
                      </td>
                      <?php if ($is_sap == 1): ?>
                          <td class="align-middle" style="width: 100px;">
                              <input type="number" class="" name="no_asset" value="">
                          </td>
                          <td class="align-middle">
                              <input type="number" class="" name="sub_number" value="">
                          </td>
                          <td width="10%" class="align-middle">
                              <select class="bg-select" name="ctr_tax_code" value="<?php echo $curval ?>">
                                  <option value="" selected disabled>Pilih Tax Code</option>
                                  <?php foreach ($tax_code as $k => $v): ?>
                                      <option value="<?php echo $v['tax_code'] ?>" <?php echo $curval == $v['tax_code'] ? 'selected' : '' ?>><?php echo $v['tax_code'].' - '.$v['description'] ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </td>
                          <td class="align-middle"> <button type="submit" class="btn btn-sm btn-info" name="save">Save</button> </td>
                      <?php endif; ?>
                    </tr>
                    <?php
                    $subtotal += $value['tit_price']*$value['tit_quantity'];
                    if(!empty($value['tit_ppn'])){
                      $subtotal_ppn += $value['tit_price']*$value['tit_quantity']*($value['tit_ppn']/100);
                    }
                    if(!empty($value['tit_pph'])){
                    $subtotal_pph += $value['tit_price']*$value['tit_quantity']*($value['tit_pph']/100);
                  }
                } ?>

              </tbody>

            </table> <hr/>
          </div>

          <div class="row form-group mt-3">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Nilai Kontrak</label>
            <div class="col-sm-2">
              <?php $nilai_kontrak = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>
              <p class="form-control-static text-right text-bold-700"> <?php echo $nilai_kontrak ?></p>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Total RAB</label>
            <div class="col-sm-2">
              <p class="form-control-static text-right text-bold-700"> <?php echo inttomoney($rab) ?></p>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Efisiensi/Inefisiensi</label>
            <div class="col-sm-2">
              <p class="form-control-static text-right text-bold-700"> <?php echo inttomoney($rab - $kontrak['contract_amount']); ?></p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
