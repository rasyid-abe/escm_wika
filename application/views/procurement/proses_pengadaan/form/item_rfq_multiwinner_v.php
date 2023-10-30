<?php if($permintaan['ptm_type_of_plan'] == "rkp_matgis"){ ?>

<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap.min.css">
<div class="row">
<div class="col-lg-12">
  <div class="card float-e-margins">
    <div class="card-title">
      <h5>ITEM MULTI WINNER MATGIS</h5>
      <div class="card-tools">
        <a class="collapse-link">
          <i class="fa fa-chevron-up"></i>
        </a>
      </div>
    </div>
    <div class="card-content">

      <table class="table table-bordered datatabless" id="item_table">
        <thead>
          <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Departemen</th>
            <th>Item</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Tujuan</th>
            <th>Total persentase (%)</th>
            <?php 
            $total_win = 0;
            foreach ($evaluation as $k => $v) {
              if($v['adm'] == "Lulus" && $v['pass'] == "Lulus"){ ?>
               <th><?php echo $v['vendor_name'] ?> (%)</th>
             <?php $total_win++; } } ?>
           </tr>
         </thead>
         <tbody>
          <?php 
          $subtotal = 0;
          $subtotal_ppn = 0;
          $subtotal_pph = 0;
           
          foreach ($item as $key => $value) { ?>

            <input type="hidden" name="tit_code_inp[]" id="tit_code_inp" value="<?php echo $value['tit_id'] ?>">

            <tr>
              <td><?php echo $key+1 ?></td>
              <td name="tit_code"><?php echo $value['tit_code'] ?></td>
               <td><?php echo $value['pr_dept_name'] ?></td>
              <td><?php echo $value['tit_description'] ?></td>
              <td class="text-right"><?php echo inttomoney($value['tit_quantity']) ?></td>
              <td><?php echo $value['tit_unit'] ?></td>
      <td><?php echo $value['tit_tujuan'] ?></td>

              <?php $total_percent = isset($submitted_item[$value['tit_id']]['total_percent']) ? inttomoney($submitted_item[$value['tit_id']]['total_percent']) : inttomoney(0);
              $style = $total_percent != 100 ? "color:red;font-weight:bold" : "";
               ?>

              <td class="total_percent total_percent_<?php echo $key+1 ?>"> <span style="<?php echo $style ?>"> <?php echo $total_percent ?> </span></td>
             
              <?php foreach ($evaluation as $k => $v) {
                  if($v['adm'] == "Lulus" && $v['pass'] == "Lulus"){
                    $val_percent = 0;
                    $jml = 0;
                    if (isset($submitted_item) AND count($submitted_item > 0)) {
                      $val_percent = $submitted_item[$value['tit_id']][$v['ptv_vendor_code']]['percentage'];
                      $jml = $submitted_item[$value['tit_id']][$v['ptv_vendor_code']]['weight'];
                    }
              ?>
              
             <td>
              <input type="text" name="winner_inp[<?php echo $value['tit_id'] ?>][<?php echo $v['ptv_vendor_code'] ?>]" class="form-control money winner percent_<?php echo $key+1 ?>" data-v-min="0" data-v-max="100" data-m-dec="20" data-a-pad="false" data-qty="<?php echo $value['tit_quantity'] ?>" data-code="<?php echo $value['tit_id'] ?>" data-tpid="<?php echo $key+1 ?>" data-id="<?php echo $v['ptv_vendor_code'] ?>" value="<?php echo $val_percent ?>">
              <span class="vendor_winner" data-code="<?php echo $value['tit_id'] ?>" data-id="<?php echo $v['ptv_vendor_code'] ?>">Jml : <?php echo inttomoney($jml) ?></span>
             </td>
             <?php } } ?>
             
           <?php } ?>
         </tr>

       </tbody>
       
     </table>

  </div>

</div>
</div>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript">

function price_to_number(v){
if(!v){return 0;}

v=v.split('.').join('');
v=v.split(',').join('.');
return Number(v.replace(/[^0-9.]/g, ""));
}

function number_to_price(v){
if(v==0){return '0,00';}
v=parseFloat(v);
v=v.toFixed(20).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
v=v.split('.').join('*').split(',').join('.').split('*').join(',');
return v;
}
 
$(document).ready(function(){

    $('.datatabless').DataTable({
    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    "search": {
      "smart": false,
    },
    "ordering": false,
    fixedColumns:   {
          leftColumns: 7,
      },
      scrollX:        true,
      scrollCollapse: true,

  });

    $('.total_percent').each(function(){

      if (price_to_number($(this).text()) != 100) {

        $(this).css({
          'color': 'red',
          'font-weight': 'bold'
        });

      }
      
      
    })


    $(document.body).on("change",".winner",function(){

    var id = $(this).data('id');

    var code = $(this).data('code');

    var qty = $(this).data('qty');

    if ($(this).val() != '') {
      var percent = price_to_number($(this).val());
    }else{
      var percent = price_to_number(0);
      $(this).val(0)
    }


    var res = percent*qty/100;

    $(".vendor_winner[data-id='"+id+"'][data-code='"+code+"']").text("Jml : "+inttomoney(res));

    var total_percent_id = $(this).data('tpid');

    var current_total_percent = 0;

    $('.percent_'+total_percent_id).each(function(){

      current_total_percent += price_to_number(this.value)
      
    })

    if (current_total_percent != 100) {

      $(".total_percent_"+total_percent_id).text(inttomoney(current_total_percent)).css({
        'color': 'red',
        'font-weight': 'bold'
      });

    }else{
      $(".total_percent_"+total_percent_id).text(inttomoney(current_total_percent)).css({
        'color': 'black',
        'font-weight': 'normal'
      });
    }     


  });

});

</script>

<?php } else { 
include(VIEWPATH."/procurement/proses_pengadaan/form/item_rfq_multiwinner_non_matgis_v.php");
} ?>