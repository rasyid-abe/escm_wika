
<?php //print_r($items);?>
<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>ITEM <?php echo $title?></h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">
        <div class="table-responsive">
          <table class="table table-bordered" id="item_table">
            <thead>
              <tr>
                <th>Pilih</th>
                <th>Kode Barang/Jasa</th>
                <th>Deskripsi Detail</th>
                <th>Harga Satuan</th>
                <th style="display: none">Pajak</th>
                <th>Jumlah Awal</th>
                <th>Jumlah PO</th>
                <th>Jumlah Maximum</th>
                <th>Jumlah </th>
                <th>Satuan</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $subtotal = 0;
              $subtotal_ppn = 0;
              $subtotal_pph = 0;

              $no=0;
              $qty=0;
              $qty_max=0;
              $max_q=0;
              foreach ($items as $key => $value) {
                $no+=1;
                //print_r($reff);die;

                switch ($reff) {
                  case 'contract':
                  case 'po':
                  $this->db->select_sum('total_qty');
                  $this->db->from('vw_sum_item_wo');
                  $this->db->where("contract_id=".$id." AND item_code= '".$value['item_code']."'");
                  $max_q = $this->db->get()->row()->total_qty;
                  if($state==0){
                    $reff='contract';
                  }else{
                    $reff='wo';
                  }
                  break;

                  case 'si': //sppm
                  $this->db->select_sum('sppm_qty');
                  $this->db->from('vw_sum_item_sppm');
                  $this->db->where("si_id=".$id." AND item_code= '".$value['item_code']."'");
                  //echo $this->db->last_query();die;
                  $max_q = $this->db->get()->row()->sppm_qty;
                  break;


                  default:
                  $value['qty'];
                  break;
                }

                //echo $this->db->last_query();die;
                $qty_max=isset($value['qty'])?($value['qty']-$max_q):0;

                if($state!==0){
                  $qty=isset($value['qty'])?$value['qty']:0;
                }else{
                  $qty=0;
                }
                ?>
                <tr>
                  <td>
                    <input type="checkbox" <?php echo ($qty>0) ? "checked" : "" ?> class="item" name="item[<?php echo $value[$reff.'_item_id'] ?>]" value="1">
                    <input type="hidden" name="<?php echo $reff?>_item_id[]" value="<?php echo $value[$reff.'_item_id'] ?>">
                  </td>

                  <td><?php echo $value['item_code'] ?></td>
                  <td><?php echo $value['short_description'] ?></td>
                  <td class="text-right"><?php echo inttomoney($value['price']) ?>
                    <input type="hidden" class="price" value="<?php echo $value['price'] ?>">
                  </td>
                  <td class="text-right" style="display: none">
                    <?php echo (!empty($value['ppn'])) ? " PPN (".$value['ppn']."%) " : "" ?> <br/>
                    <?php echo (!empty($value['pph'])) ? " PPH (".$value['pph']."%)" : "" ?>
                    <input type="text" class="tax_ppn" value="<?php echo $value['ppn'] ?>">
                    <input type="text" class="tax_pph" value="<?php echo $value['pph'] ?>">
                  </td>
                  <td>
                    <p class="qty_max"><?php echo $value['qty'];?></p>
                  </td>
                    <td>
                    <p class="qty_max"><?php echo $value['qty']-$qty_max;?></p>
                  </td>
                  <td>
                    <p class="qty_max"><?php echo $qty_max;?></p>
                    <input type="hidden" class="qty_max" name="qty_max[<?php echo $value[$reff.'_item_id'] ?>]" value="<?php echo $qty_max?>">
                  </td>

                  <td>
                    <input type="text" class="form-control qty" style="width:120px;text-align: right;" name="qty_data[<?php echo $value[$reff.'_item_id'] ?>]" value="<?php echo $qty ?>">
                  </td>

                  <td><?php echo $value['uom'] ?></td>
                </tr>
                <?php
                $subtotal += $value['price']*$value['qty'];
                if(!empty($value['ppn'])){
                  $subtotal_ppn += $value['price']*$value['qty']*($value['ppn']/100);
                }
                if(!empty($value['pph'])){
                  $subtotal_pph += $value['price']*$value['qty']*($value['pph']/100);
                }
              }
              //echo "subtotal :".$subtotal;
              ?>
            </tbody>
          </table>
        </div>
        <hr>

        <div class="form-group">
          <div class="col-sm-5">
          </div>
          <label class="col-sm-4 control-label">Jumlah</label>
          <div class="col-sm-3">
            <p class="form-control-static text-right" id="total_alokasi"><?php echo inttomoney($subtotal) ?></p>
            <input type="hidden" name="total_alokasi_inp" id="total_alokasi_inp" value="<?php echo $subtotal?>">
          </div>
        </div>

        <div class="form-group" style="display: none">
          <div class="col-sm-5">
          </div>
          <label class="col-sm-4 control-label">PPN</label>
          <div class="col-sm-3">
            <p class="form-control-static text-right" id="ppn"><?php echo inttomoney($subtotal_ppn) ?></p>
            <input type="hidden" name="ppn_inp" id="ppn_inp" value="<?php echo $subtotal_ppn ?>">
          </div>
        </div>

        <div class="form-group" style="display: none">
          <div class="col-sm-5">
          </div>
          <label class="col-sm-4 control-label">PPH</label>
          <div class="col-sm-3">
            <p class="form-control-static text-right" id="pph"><?php echo inttomoney($subtotal_pph) ?></p>
            <input type="hidden" name="pph_inp" id="pph_inp" value="<?php echo $subtotal_pph ?>">
          </div>
        </div>

        <div class="form-group" style="display: none">
          <div class="col-sm-5">
          </div>
          <label class="col-sm-4 control-label">Nilai PO Setelah PPN &amp; PPH</label>
          <div class="col-sm-3">
            <p class="form-control-static text-right text-red" id="total_alokasi_ppn"><?php echo inttomoney($subtotal+$subtotal_ppn+$subtotal_pph) ?></p>
            <input type="hidden" name="total_alokasi_ppn_inp" id="total_alokasi_ppn_inp"
            value="<?php echo $subtotal+$subtotal_ppn+$subtotal_pph ?>">
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
set_total();
$(".qty").on("change",function(){
  set_total();
});

$(".item").on("change",function(){
  var checked = $(this).prop('checked');
  if(!checked) {
    $(this).parent().parent().find(".qty").val(0);
  }
  set_total();
});

set_total();

function set_total(){

  var total_alokasi = 0;
  var ppn = 0;
  var pph = 0;
  var total_alokasi_ppn = 0;

  $("#item_table tr").each(function(){

    var item =  $(this).find(".item").prop('checked');

    if(item){
      $(this).find(".qty").prop('readonly',false);
    } else {
      $(this).find(".qty").prop('readonly',true);
    }

    var price = (!isNaN($(this).find(".price").val())) ? parseFloat($(this).find(".price").val()) : 0;
    var qty = (!isNaN($(this).find(".qty").val())) ? parseFloat($(this).find(".qty").val()) : 0;
    var qty_max = (!isNaN($(this).find(".qty_max").val())) ? parseFloat($(this).find(".qty_max").val()) : 0;

    var ppn_persen = ($(this).find(".tax_ppn").val()) ? $(this).find(".tax_ppn").val()/100 : 0;
    var pph_persen = ($(this).find(".tax_pph").val()) ? $(this).find(".tax_pph").val()/100 : 0;

    total_alokasi += (price*qty);
    console.log(total_alokasi);
    var ppn_nominal = (price*qty) * ppn_persen;

    ppn += ppn_nominal;
    var pph_nominal = (price*qty) * pph_persen;
    pph += pph_nominal;
    total_alokasi_ppn += (price*qty) + ppn_nominal + pph_nominal;
    // console.log(qty);
    // console.log(qty_max);
    if(qty>qty_max){
      alert('Quantity tidak boleh lebih besar dari alokasi');
      $(this).find(".qty").focus();
    }
  });
  console.log(total_alokasi);

  $("#total_alokasi").text(inttomoney(total_alokasi));
  $("#total_alokasi_inp").val(total_alokasi);
  //$("#ppn").text(inttomoney(ppn));
  //$("#ppn_inp").val(ppn);
  //$("#pph").text(inttomoney(pph));
  //$("#pph_inp").val(pph);
  //$("#total_alokasi_ppn").text(inttomoney(total_alokasi_ppn));
  //$("#total_alokasi_ppn_inp").val(total_alokasi_ppn);

}
jQuery("form").submit(function(e) {

  $("#item_table tr").each(function(){

    var qty = (!isNaN($(this).find(".qty").val())) ? parseFloat($(this).find(".qty").val()) : 0;
    var qty_max = (!isNaN($(this).find(".qty_max").val())) ? parseFloat($(this).find(".qty_max").val()) : 0;

    var item =  $(this).find(".item").prop('checked');

    if(item){
      if(qty>qty_max){
        e.preventDefault();
        alert("qty tidak boleh lebih besar");
        return false;
      }

      //throw new Error("my error message");

      if(qty<=0){
        e.preventDefault();
        alert("qty tidak boleh minus atau 0");
        return false;
      }
    }

  });

});
</script>
