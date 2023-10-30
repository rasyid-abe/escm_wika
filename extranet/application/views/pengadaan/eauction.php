<form method="post" action="<?php echo site_url("pengadaan/view");?>"  class="form-horizontal ajaxform">
  <input type="hidden" name="ids" value="<?php echo (isset($tender['ptm_number'])) ? $tender["ptm_number"] : ""; ?>">
  <div class="row">
    <div class="col-lg-12">

      <?php if(!empty($message)){ ?>
      <div class="alert alert-danger" role="alert"><?php echo $message ?></div>
      <?php } ?>


      <div class="card float-e-margins">
        <div class="card-header">
          <div class="card-title"> 
            <h5>HEADER</h5>
          </div>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">

                <?php $curval = (isset($tender['ptm_number'])) ?  $tender["ptm_number"] : ""; ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label text-right">Nomor Tender</label>
                  <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $curval ?></p>

                  </div>
                </div>

                <?php $curval = (isset($tender['ptm_subject_of_work'])) ?  $tender["ptm_subject_of_work"] : ""; ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label text-right">Deskripsi Tender</label>
                  <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $curval ?></p>
                  </div>
                </div>

                <?php $curval = (isset($tender['judul'])) ?  $tender["judul"] : ""; ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label text-right">Judul E-Auction</label>
                  <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $curval ?></p>
                  </div>
                </div>

                <?php $curval = (isset($tender['deskripsi'])) ?  $tender["deskripsi"] : ""; ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label text-right">Deskripsi</label>
                  <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $curval ?></p>
                  </div>
                </div>

                <div class="row form-group">
                  <label class="col-sm-2 control-label text-right">Waktu</label>
                  <div class="col-sm-10">
                    <p class="form-control-static">
                      <?php echo date("d/m/Y H:i:s",$dari); ?>
                      - 
                      <?php echo date("d/m/Y H:i:s",$sampai); ?>

                    </p>
                  </div>
                </div>

                <div class="row form-group">
                  <label class="col-sm-2 control-label text-right">Durasi</label>
                  <div class="col-sm-10">
                    <p class="form-control-static"><?php
                    $time = gmdate("H:i:s", $sampai-$dari);
                    $time = explode(':', $time);
                    $no = 1;
                    foreach ($time as $v) {
                      if($no == 1){
                          $word = 'jam';
                        }else if($no == 2){
                          $word = 'menit';
                        }else{
                          $word = 'detik';
                        }
                        echo $v.' '.$word.' ';
                        $no++;
                    }
                    ?> </p>

                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-header">
          <div class="card-title">
            <h5>PENAWARAN TOTAL</h5>
          </div>
        </div>

        <div class="ibox-content">

          <?php if($sampai-time() <= 0){ ?>
          <h1 class="text-right" style="font-weight: bold;"><?php echo inttomoney($last_quo['jumlah_bid']) ?></h1>
          <?php } else { ?>
          <input type="text" <?php echo ($tender['tipe'] != "A") ? "readonly" : "" ?> name="penawaran_inp" class="form-control input-lg money text-right" value="<?php echo moneytoint($last_quo['jumlah_bid']) ?>" style="font-size:24pt">
          <?php } ?>

        </div>
      </div>
    </div>
  </div>

  <?php if($tender['tipe'] != "A"){ ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-header">
          <div class="card-title">
            <h5>ITEM</h5>
          </div>
        </div>

        <div class="card-content">
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Deskripsi</th>
                  <th>Jumlah</th>
                  <th>Harga Satuan</th>
                  <th>Harga Total Penawaran</th>
                </tr>
              </thead>

              <tbody>
              <?php 
                $total = 0;
                $i = 1;
                foreach ($item as $key => $value) { 
                  $harga = (isset($history_item[$value['tit_id']])) ? $history_item[$value['tit_id']] : $value['pqi_price'];
                  $subtotal = $harga*$value['pqi_quantity']; 
                  $total += $subtotal;
                  $no = $key+1;
              ?>
                <tr data-key="<?php echo $no ?>">
                  <td><?php echo $no ?></td>
                  <td><p class="form-control-static"><?php echo $value['tit_code'] ?></p></td>
                  <td><p class="form-control-static"><?php echo $value['pqi_description'] ?></p></td>
                  <td>
                  <p class="form-control-static" id="qty<?php echo $value['tit_id'] ?>">
                    <?php echo inttomoney($value['pqi_quantity']) ?> <?php echo $value['tit_unit'] ?>
                  </p>
                  <input type="hidden" class="jumlah_inp" name="jumlah_inp[<?php echo $value['tit_id'] ?>]" value="<?php echo $value['pqi_quantity'] ?>" id="jumlah_<?php echo $i ?>">
                  </td>
                  <td>
                  <?php if($sampai-time() <= 0){ ?>
                  <p class="text-right form-control-static" style="font-weight: bold;">
                    <?php echo inttomoney($harga) ?>            
                  </p>
                  <?php } else { ?>
                  <input class="form-control text-right money harga_inp" type="text" data-key="<?php echo $no ?>" name="harga_inp[<?php echo $value['tit_id'] ?>]" value="<?php echo $harga ?>" id="harga_<?php echo $i ?>">
                  <?php } ?>
                  </td>
                  <td>
                    <p class="subtotal text-right form-control-static" id="shargaitem_<?php echo $i ?>">
                        <?php echo inttomoney($subtotal) ?>
                        <input type="hidden" id="hargaitem_<?php echo $value['tit_id'] ?>" name="hargaitem" value="<?php echo $subtotal ?>">
                      </div>
                    </p>
                  </td>
                </tr>
                <?php $i++; } ?>
                <input type="hidden" id="num_item" name="num_item" value="<?php echo $i ?>">
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<div class="card">
  <div class="card-content">
    <div class="card-body">      
      <?php 
          $link = 'pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("eauction"), 'enkrip');
          if($sampai-time() > 0){ 
            echo buttonsubmit($link,'Back','Save');
          } else {
            echo buttonback($link,'Back');
          }
      ?>
    </div>
  </div>
</div>

</form>

<?php if($sampai-time() > 0){ ?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script type="text/javascript" src="<?php echo base_url('assets/js/autoNumeric-min.js') ?>"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.5.5/numeral.min.js"></script>
<style type="text/css">
  #toast-container > .toast-info:before {
    content: "";
  }
</style>
<script type="text/javascript">
  
  $(document).on('change', '.harga_inp', function() {
    var num = $("#num_item").val()
    for (var i = 1; i < num; i++) {
      var price = moneytoint($("#harga_"+i).val())
      var qty = moneytoint($("#jumlah_"+i).val())
      $("#shargaitem_"+i).text(inttomoney(price*qty))
    }
  })

window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);

var sampai = <?php echo $sampai ?>;
setInterval(function(){
  var sekarang =  Math.floor(new Date().getTime() / 1000);
  
  if ((sampai - sekarang) == 0){
    $('#waktu').hide();
    sweetAlert({
                title:'Perhatian!',
                text: 'Waktu eAuction Telah Habis',
                type:'warning'
          },function(isConfirm){
            window.location.href = '<?php echo base_url() ?>';
          });
          // $('.swal2-confirm').click(function(){
                
          // });
  }
}, 1000);

function calculate($first_load=''){
    var total = 0;
    
  $(".harga_inp").each(function(i,v){

    // var harga = moneytoint($(this).val());
    // var harga = parseFloat($(this).val());
    if ($first_load) {
      var harga = parseFloat($(this).val());
    }else{
      var harga = moneytoint($(this).val());
    }
    var jumlah = $(this).parent().parent().find(".jumlah_inp").val();
    // total += parseInt(harga*jumlah)*1.1;
    total += parseInt(harga*jumlah);

  });
  // alert(total_harga)
  $("input[name='penawaran_inp']").val(inttomoney(total));

  //===================================================================
  
}


calculate(true);

$(".harga_inp").change(function(){

calculate(false);

});

  $("input.money").autoNumeric({
    aSep: '.',
    aDec: ',', 
    aSign: ''
  });

function isInt(n){
  return Number(n) === n && n % 1 === 0;
}

function isFloat(n){
  return n === Number(n) && n % 1 !== 0;
}

  function inttomoney(money){

  money = parseFloat(money);

  money = numeral(money).format('0,0.00');

  money = money.replace(".","_");

  money = money.replace(/,/g,".");

  money = money.replace("_",",");

  return money;
}

function moneytoint(money){

  if(!isInt(money)){

    money = money.replace(/\./g,"");

    money = money.replace(",",".");

    money = parseInt(money);

}

  return money;
}

function update_lowest(money){
  $(".lowest_bid").text(money);
}

function update_latest(money){
  $(".latest_bid").html(money);
}

setInterval(function(){

  $.ajax({
    url:"<?php echo site_url('pengadaan/eauction_list') ?>",
    dataType:"json",
    success:function(data){
      update_latest(data.latest_bid);
      //update_lowest(data.lowest_bid);
    }
  })

},1000);

toastr.options.closeButton = false;
toastr.options.extendedTimeOut = 0;
toastr.options.timeOut = 0;
toastr.options.tapToDismiss = false;
toastr.info('<center><h4 id="waktu"></h4>Penawaran Terakhir Anda : <span class="latest_bid" style="font-weight: bold;">0</span></center>');

  $('#toast-container').css({'margin-top' : '4%',  'position' : 'absolute'});

var deadline = '<?php echo date("Y-m-d H:i:s",$sampai) ?>';

function getTimeRemaining(endtime){
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor( (t/1000) % 60 );
  var minutes = Math.floor( (t/1000/60) % 60 );
  var hours = Math.floor( (t/(1000*60*60)) % 24 );
  var days = Math.floor( t/(1000*60*60*24) );
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime){
  var clock = document.getElementById(id);
  var timeinterval = setInterval(function(){
    var t = getTimeRemaining(endtime);
    clock.innerHTML = '<strong>' + t.days + '</strong> Hari ' +
    '<strong>'+ t.hours + '</strong> Jam ' +
    '<strong>' + t.minutes + '</strong> Menit ' +
    '<strong>' + t.seconds+ '</strong> Detik ';
    if(t.total<=0){
      clearInterval(timeinterval);
        window.location.reload();
      }
    },1000);
}

function updateClock(id){
  var clock = document.getElementById(id);
  var t = getTimeRemaining(deadline);
  clock.innerHTML = 'days: ' + t.days + '<br>' +
  'hours: '+ t.hours + '<br>' +
  'minutes: ' + t.minutes + '<br>' +
  'seconds: ' + t.seconds;
  if(t.total<=0){
    clearInterval(timeinterval);
  }
}

initializeClock('waktu', deadline);

</script>
<?php } ?>