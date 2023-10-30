<script>
var finalEventDt = new Date("feb 31, 2022 15:37:25").getTime();

var x = setInterval(function() {

  var now = new Date().getTime();

  var delay_total = finalEventDt - now;

  var days = Math.floor(delay_total / (1000 * 60 * 60 * 24));
  var hours = Math.floor((delay_total % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((delay_total % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((delay_total % (1000 * 60)) / 1000);

  document.getElementById("example").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  if (delay_total < 0) {
    clearInterval(x);
    document.getElementById("example").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-bottom pb-2" style="background-color: #2aace3ba;text-align:center;border-radius: 25px 25px 0px 0px;">
        <h5 class="card-title">Sisa Waktu<div id="example"></div></h5>
      </div>

      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Peringkat Vendor E-Auction</h4>
      </div>



      <div class="card-content">
          <div class="card-body">
            <div class="row">
              <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModal">
                Lihat Riwayat
              </button>
            </div>
            <div class="table-responsive">
                <table id="peringkat_vendor_eauction" class="table table-bordered table-striped"></table>
            </div>
          </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Riwayat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="width:150%;">
        <!-- <table class="table">
          <thead>
            <tr>
              <th scope="col">Penawaran Sebelumnya</th>
              <th scope="col">Penawaran Saat Ini</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($v as $k2 => $v2) { ?>
              <tr>
                <td>E-Auction : <?php echo $v2['judul'] ?></td>
                <td>@mdo</td>
              </tr>
            <?php } ?>
          </tbody>
        </table> -->
        <?php foreach ($eauction_item as $key => $value) {
          $jdl = explode("-", $key);
          ?>

          <div class="col-lg-12">

            <div class="text-left" style="margin: 12px 0">
              <h4><?= $jdl[1] ?></h4>
            </div>

              <?php foreach ($value as $k => $v) {
                $x = $eauction_hist[$k];
              ?>
              <div class="col-lg-4 col-md-6" style="color:<?php echo !empty($x['selected']) ? "green" : "" ?>;border:1px solid #0054a6;padding:10px 12px;">

              <span style="font-weight: bold"><?php echo inttomoney($x['jumlah_bid']) ?></span>
              <span style="float: right;font-weight: bold"><?php echo date('d/m/Y H:i',strtotime($x['tgl_bid'])) ?></span>

              <?php foreach ($v as $k2 => $v2) { ?>
                <ul style="margin-top: 12px">
                  <li>
                    E-Auction : <?php echo $v2['judul'] ?>
                  </li>
                  <li>
                    Kode : <?php echo $v2['tit_code'] ?>
                    </li>
                    <li>
                    Barang : <?php echo $v2['tit_description'] ?>
                  </li>
                  <li>
                    Jumlah : <?php echo inttomoney($v2['tit_quantity']) ?> <?php echo ($v2['tit_quantity'] != $v2['qty_bid']) ? " -> ".inttomoney($v2['qty_bid']) : "" ?>
                  </li>
                  <li>
                    Harga : <?php echo inttomoney($v2['tit_price']) ?> <?php echo ($v2['tit_price'] != $v2['jumlah_bid']) ? " -> ".inttomoney($v2['jumlah_bid']) : "" ?>
                  </li>
                </ul>
                <?php } ?>
                </div>
              <?php } ?>
          </div>

        <?php } ?>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  var $peringkat_vendor_eauction = $('#peringkat_vendor_eauction'),
  selections = [];

  $(function () {

    $peringkat_vendor_eauction.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_peringkat_vendor_eauction') ?>?metode="+$( "#tipe_eauction_inp option:selected" ).val(),
      idField:"vendor_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: '<span class="dot"></span>',
        title: 'Online',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
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
      }
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
