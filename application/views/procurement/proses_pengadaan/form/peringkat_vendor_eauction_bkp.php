<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Peringkat Vendor E-Auction</h4>
      </div>

      <div class="card-content">
        <div class="card-body eauction">
            <div class="row">
                <?php foreach ($eauction_item as $key => $value) { 
                $jdl = explode("-", $key);

                ?>

                <div class="col-lg-12">

                <div class="text-center" style="margin: 24px 0">
                  <h2 style="margin:0"><?php echo $jdl[1] ?></h2>
                </div>

                <?php foreach ($value as $k => $v) { 
                  $x = $eauction_hist[$k];
                  ?>


                  <div data-vendor="<?php echo $jdl[0] ?>" data-id="<?php echo $x['id'] ?>" class="col-lg-6 col-md-6 chose-cont <?php echo !empty($x['selected']) ? "selected" : "" ?>">

                      <input <?php echo ($permintaan['ptm_type_of_plan'] == "rkp_matgis") ? "" : "disabled" ?> type="radio" <?php echo !empty($x['selected']) ? "checked" : "" ?> class="eauction_vendor_radio" data-vendor="<?php echo $jdl[0] ?>" value="<?php echo $x['id'] ?>" name="eauction_vendor[<?php echo $jdl[0] ?>]">

                    <span style="font-weight: <?php echo !empty($x['selected']) ? "bold" : "none" ?>"><?php echo $x['judul'] ?> (<?php echo inttomoney($x['jumlah_bid']) ?>)</span>
                    <span style="float: right;font-weight: <?php echo !empty($x['selected']) ? "bold" : "none" ?>"><?php echo date('d/m/Y H:i',strtotime($x['tgl_bid'])) ?></span>

                    <table style="margin-top: 8px" class="table table-bordered">

                    <thead>
                      <tr >
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Barang</th>
                        <th colspan="2">Jumlah</th>
                        <th colspan="2">Harga</th>
                      </tr>
                      <tr>
                        <th>Awal</th>
                        <th>Akhir</th>
                        <th>Awal</th>
                        <th>Akhir</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php foreach ($v as $k2 => $v2) { ?>
                      <tr>
                        <td><?php echo $v2['tit_code'] ?></td>
                        <td><?php echo $v2['tit_description'] ?></td>
                        <td><?php echo inttomoney($v2['tit_quantity']) ?></td>
                        <td><?php echo inttomoney($v2['qty_bid']) ?></td>
                        <td><?php echo inttomoney($v2['tit_price']) ?></td>
                        <td><?php echo inttomoney($v2['jumlah_bid']) ?></td>
                      </tr>
                    <?php } ?>

                  </tbody>

                </table>


                </div>
                <?php } ?>



                </div>

                <?php } ?>

                </div>

                <div class="table-responsive">

                <table id="peringkat_vendor_eauction" class="table table-bordered table-striped"></table>

                </div>
        </div>
      </div>

    </div>
  </div>
</div>

<style type="text/css">
.eauction .chose-cont{

}
.eauction .chose-cont.selected{

}
</style>

<script type="text/javascript">

  var $peringkat_vendor_eauction = $('#peringkat_vendor_eauction'),
  selections = [];

  $(function () {

    $(".eauction_vendor_radio").change(function(){
      $(".eauction .chose-cont[data-vendor='"+$(this).data('vendor')+"']").removeClass('selected');
      $(".eauction .chose-cont[data-vendor='"+$(this).data('vendor')+"'][data-id='"+$(this).val()+"']").addClass('selected');
      
      var data = $('form').serialize();
      $.ajax({
        url:"<?php echo site_url('Procurement/calculate_eauction') ?>",
        data,
        method:"post",
        success:function(){
          $peringkat_vendor_eauction.bootstrapTable('refresh');
        }
      })
    });

    $peringkat_vendor_eauction.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_peringkat_vendor_eauction') ?>?metode="+$( "#tipe_eauction_inp option:selected" ).val(),
      idField:"vendor_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [

      {
        field: 'rank',
        title: 'Peringkat',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'jumlah_bid',
        title: 'Total',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },

      ]

    });
    setTimeout(function () {
      $peringkat_vendor_eauction.bootstrapTable('resetView');
    }, 200);

    $peringkat_vendor_eauction.bootstrapTable('refresh');

    $("button.eauction_vendor").click(function(){
      $(this).find('input:radio').prop('checked',true);
    });

  });

</script>
