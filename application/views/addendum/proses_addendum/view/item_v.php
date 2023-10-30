<div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>ITEM</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">

           <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang/Jasa</th>
              <th>Deskripsi</th>
              <th>Harga Satuan</th>
              <th>Satuan</th>
              <th>Jumlah</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($item as $key => $value) { ?>
          
            <tr>
              <td><?php echo $key+1 ?></td>
              <td><?php echo $value['item_code'] ?></td>
              <td><?php echo $value['short_description'] ?></td>
              <td class="text-right"><?php echo inttomoney($value['price']) ?></td>
              <td><?php echo $value['uom'] ?></td>
              <td class="text-right"><?php echo inttomoney($value['qty']) ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>