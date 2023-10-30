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

          <tbody id="item_table">
          <?php 
            $total = 0;
          foreach ($item as $key => $value) {
            $subtotal = $value['price']*$value['qty']; 
                $total += $subtotal;
           ?>
          
            <tr>
              <!-- <td><?php echo $key+1 ?></td> -->
              <td><input type="checkbox" class="item_ammend" name="item[<?php echo $value['ammend_item_id'] ?>]" value="<?php echo $value['ammend_item_id'] ?>"></td>
              <td>
                <?php echo $value['item_code'] ?>
                <input type="text" style="display: none" name="item_id[<?php echo $value['ammend_item_id'] ?>]" value="<?php echo $value['ammend_item_id'] ?>">
              </td>
              <td>
                <?php echo $value['short_description'] ?>
                 <input type="text" style="display: none" name="item_code[<?php echo $value['ammend_item_id'] ?>]" value="<?php echo $value['item_code'] ?>">
              </td>
              <td><input class="form-control money price" style="width:120px;text-align: right;" name="price[<?php echo $value['ammend_item_id'] ?>]" value="<?php echo $value['price'] ?>" readonly></td>
              <td><?php echo $value['uom'] ?></td>
              <td><input class="form-control money qty" style="width:120px;text-align: right;" name="qty[<?php echo $value['ammend_item_id'] ?>]" value="<?php echo $value['qty'] ?>" readonly></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

                    <hr>
<div class="form-group">
    <div class="col-sm-5">
    </div>
    <label class="col-sm-4 control-label">Total Nilai</label>
    <div class="col-sm-3">
      <p class="form-control-static text-right" id="total_alokasi"> <?php echo inttomoney($total) ?></p>
      <input type="hidden" name="total_alokasi_inp" id="total_alokasi_inp" value="<?php echo $total ?>">
    </div>
  </div>

  <!-- <div class="form-group">
    <div class="col-sm-5">
    </div>
    <label class="col-sm-4 control-label">PPN</label>
    <div class="col-sm-3">
      <p class="form-control-static text-right" id="ppn"><?php echo inttomoney($total*0.1) ?></p>
      <input type="hidden" name="ppn_inp" id="ppn_inp" value="<?php echo $total*0.1 ?>">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-5">
    </div>
    <label class="col-sm-4 control-label">Total PR Setelah PPN</label>
    <div class="col-sm-3">
      <p class="form-control-static text-right text-red" id="total_alokasi_ppn"><?php echo inttomoney($total+($total*0.1)) ?></p>
      <input type="hidden" name="total_alokasi_ppn_inp" id="total_alokasi_ppn_inp" value="<?php echo $total+($total*0.1) ?>">
    </div>
  </div> -->

      </div>
    </div>
  </div>
</div>



<script type="text/javascript">

  $(".qty, .price").on("change",function(){
    set_total();
  });

  $(".item_ammend").on("change",function(){
    var checked = $(this).prop('checked');
    set_total();
  });
  

  function set_total(){

    var total_alokasi = 0;
    
    $("#item_table tr").each(function(){

      var item =  $(this).find(".item_ammend").prop('checked');

      if(item){
        $(this).find(".qty").prop('readonly',false)
        $(this).find(".price").prop('readonly',false);
      } else {
        $(this).find(".qty").prop('readonly',true)
        $(this).find(".price").prop('readonly',true);
      }

      var p = (!isNaN(parseFloat($(this).find(".price").val()))) ? price_to_number($(this).find(".price").val()) : 0;
      var q = (!isNaN(parseFloat($(this).find(".qty").val()))) ? price_to_number($(this).find(".qty").val()) : 0;
      
      total_alokasi += (p*q);
      console.log(total_alokasi)
    });

    $("#total_alokasi, #nilai_kontrak_inp").text(inttomoney(total_alokasi));
    $("#total_alokasi_inp").val(total_alokasi);

  }

  function price_to_number(v){
    if(!v){return 0;}
    v=v.split('.').join('');
    v=v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
  }


</script>
