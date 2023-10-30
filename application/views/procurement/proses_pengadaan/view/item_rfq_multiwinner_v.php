<?php if($permintaan['ptm_type_of_plan'] == "rkp_matgis"){ ?>

<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap.min.css">

<div class="row">
    <div class="col-12">        
        <div class="card">
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">ITEM MULTI WINNER MATGIS</h4>
            </div>  

            <div class="card-content">
              <div class="card-body">
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
                          <td class="total_percent_<?php echo $key+1 ?>">100</td> <!-- sementara hardcode -->
                        
                          <?php foreach ($evaluation as $k => $v) {
                              if($v['adm'] == "Lulus" && $v['pass'] == "Lulus"){
                              ?>
                          <td>

                          <input type="text" disabled name="winner_inp[<?php echo $value['tit_id'] ?>][<?php echo $v['ptv_vendor_code'] ?>]" class="form-control money winner" data-v-min="0" data-v-max="100" data-m-dec="20" data-a-pad="false" data-qty="<?php echo $value['tit_quantity'] ?>" data-code="<?php echo $value['tit_id'] ?>" data-id="<?php echo $v['ptv_vendor_code'] ?>" value="<?php echo (isset($winner_weight[$value['tit_id']][$v['ptv_vendor_code']])) ? $winner_weight[$value['tit_id']][$v['ptv_vendor_code']]['percentage'] : 0 ?>">
                          <span class="vendor_winner" data-code="<?php echo $value['tit_id'] ?>" data-id="<?php echo $v['ptv_vendor_code'] ?>">Jml : <?php echo (isset($winner_weight[$value['tit_id']][$v['ptv_vendor_code']])) ? inttomoney($winner_weight[$value['tit_id']][$v['ptv_vendor_code']]['percentage']/100 * $value['tit_quantity'] ) : 0 ?></span>
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
</div>

<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript">
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
  
</script>

<?php } else { 
  include(VIEWPATH."/procurement/proses_pengadaan/view/item_rfq_multiwinner_non_matgis_v.php");
} ?>