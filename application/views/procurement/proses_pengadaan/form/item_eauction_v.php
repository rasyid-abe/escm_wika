<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">ITEM EAUCTION</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <table class="table table-bordered default" id="item_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kode</th>
                  <th>Tipe</th>
                  <th>Item</th>
                  <th>Jumlah</th>
                  <th>Satuan</th>
                  <th>Harga Satuan<!-- <br/>(Sebelum Pajak) --></th>
                  <th class="type_b">Harga Penurunan</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $total = 0;
                foreach ($item as $key => $value) { 
                  $subtotal = $value['tit_price']*$value['tit_quantity']; 
                  $total += $subtotal;
                  $val = (isset($eauction_detail[$value['tit_id']])) ? $eauction_detail[$value['tit_id']] : 0
                  ?>
                  <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $value['tit_code'] ?></td>
                    <td><?php echo $value['tit_type'] ?></td>
                    <td><?php echo $value['tit_description'] ?></td>
                    <td class="text-right"><?php echo inttomoney($value['tit_quantity']) ?></td>
                    <td><?php echo $value['tit_unit'] ?></td>
                    <td class="text-right"><?php echo inttomoney($value['tit_price']) ?></td>
                    <td class="text-right type_b">
                    <input type="text" class="form-control money" name="harga_penurunan[<?php echo $value['tit_id'] ?>]" value="<?php echo $val ?>">
                    </td>
                    <td class="text-right"><?php echo inttomoney($subtotal) ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
        </div>
      
    </div>
  </div>
</div>