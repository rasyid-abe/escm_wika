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

        <div class="form-group">
          <label class="col-sm-2 control-label">Kode</label>
          <div class="col-sm-6">
            <div class="input-group">
              <span class="input-group-btn">

                <button type="button" data-id="kode_item" id="picker_item_matgis_btn" data-url="<?php
                $last_code = (isset($item[0]['ppi_code']) && !empty($item[0]['ppi_code']))? $item[0]['ppi_code'] : "";
                echo site_url('procurement/picker_matgis?last_item_code='.$last_code) ?>" class="btn btn-primary picker sumberdaya_btn integrated">Pilih Material Strategis</button>

              </span>
              <?php $curval = set_value("kode_item"); ?>
              <input readonly type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>

        <?php $curval = set_value("tipe_item"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tipe</label>
          <div class="col-sm-2">
           <p class="form-control-static" id="tipe_item"><?php echo $curval ?></p>
         </div>
       </div>

       <?php $curval = set_value("deskripsi_item"); ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Deskripsi</label>
        <div class="col-sm-10">
          <p class="form-control-static" maxlength="1000" id="deskripsi_item"><?php echo $curval ?></p>
        </div>
      </div>

      <?php $curval = set_value("jumlah_item_inp"); ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Volume</label>
        <div class="col-sm-2">
         <input type="text" class="form-control money" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">

         <small id="max_volume"></small>
       </div>
       <small id="error_jml"></small>
     </div>

     <?php $curval = set_value("satuan_item_inp"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Satuan</label>
      <div class="col-sm-2">
       <input type="text" readonly="true" class="form-control" maxlength="12" name="satuan_item_inp" id="satuan_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>

   <?php $curval = set_value("harga_satuan_item_inp"); ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Harga Satuan</label>
    <div class="col-sm-4">
     <input type="text" class="form-control money" maxlength="40" name="harga_satuan_item_inp" id="harga_satuan_item_inp" value="<?php echo $curval ?>">
     <small>
      <i>Harga Satuan sudah termasuk PPH, Bunga Diskonto, dan Biaya Lainnya
      </i>
    </small>
  </div>

  <div class="col-sm-1">
    <div class="checkbox">
      <?php $curval = set_value("ppn_item_inp"); ?>
      <input type="checkbox" class="" name="ppn_item_inp" id="ppn_item_inp" value="0" style="visibility: hidden">
    </div>
  </div>


  <div class="col-sm-2">
   <div class="">
    <?php $curval = set_value("pph_item_inp"); ?>
    <select class="form-control" name="pph_item_inp" id="pph_item_inp" style="visibility: hidden">
      <option value="">Pilih</option>
    </select>
  </div>
</div>
</div>


<center>
  <a class="btn btn-primary action_item">Simpan</a>
  <a class="btn btn-light empty_item">Hapus</a>
  <input type="hidden" id="current_item" name="current_item" value=""/>
  <br>
</center>

<hr>

<table class="table table-bordered" id="item_table">
  <thead>
    <tr>
      <th>#</th>
      <th>Kode</th>
      <th>Tipe</th>
      <th>Item</th>
      <th>Volume</th>
      <th>Satuan</th>
      <th>Harga Satuan<br/><!-- (Sebelum Pajak) --></th>
      <th style="display: none">Pajak</th>
      <th>Subtotal<br/><!-- (Sebelum Pajak) --></th>
	  <th>Tujuan<br/><!-- (Sebelum Pajak) --></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $subtotal = 0;
    $subtotal_ppn = 0;
    $subtotal_pph = 0;
    if(isset($item) && !empty($item)){
      foreach ($item as $key => $value) {
        $idnya = $key+1;
        $value['ppi_ppn'] = 0;
        $value['ppi_pph'] = 0;
        ?>

        <tr>
          <td>

            <button data-no="<?php echo $idnya ?>" class="btn btn-primary btn-xs edit_item" type="button">
              <i class="fa fa-edit"></i>
              <?php $curval = (isset($value['ppi_id'])) ? $value['ppi_id'] :  ""; ?>
              <input type="hidden" name="item_id[<?php echo $idnya ?>]" value="<?php echo $curval ?>"/>

            </button>

          </td>
          <td>
            <input type="hidden" value="<?php echo trim($value['ppi_code']) ?>" name="item_kode[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="kode_item">
            <?php echo $value['ppi_code'] ?>
          </td>
          <td>
            <input type="hidden" value="<?php echo $value['ppi_item_type'] ?>" name="item_tipe[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="tipe_item">
            <?php echo $value['ppi_item_type'] ?>
          </td>
          <td>
            <input type="hidden" value="<?php echo $value['ppi_item_desc'] ?>" name="item_deskripsi[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="deskripsi_item">
            <?php echo $value['ppi_item_desc'] ?>
          </td>
          <td class="text-right">
            <input type="hidden" value="<?php echo $value['ppi_jumlah'] ?>" name="item_jumlah[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_item">
            <?php echo inttomoney($value['ppi_jumlah']) ?>
          </td>
          <td>
            <input type="hidden" value="<?php echo $value['ppi_satuan'] ?>" name="item_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="satuan_item">
            <?php echo $value['ppi_satuan'] ?>
          </td>
          <td class="text-right">
            <input type="hidden" value="<?php echo $value['ppi_harga'] ?>" name="item_harga_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="harga_satuan_item">
            <?php echo inttomoney($value['ppi_harga']) ?>
          </td>
          <td class="text-right" style="display: none">
            <input type="hidden" value="<?php echo $value['ppi_ppn'] ?>" name="item_ppn_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppn_satuan_item">
            <?php echo (!empty($value['ppi_ppn'])) ? " PPN (".$value['ppi_ppn']."%) " : "" ?>
            <input type="hidden" value="<?php echo $value['ppi_pph'] ?>" name="item_pph_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pph_satuan_item">
            <?php echo (!empty($value['ppi_pph'])) ? " PPH (".$value['ppi_pph']."%)" : "" ?>
          </td>
          <td class="text-right">
            <input type="hidden" value="<?php echo $value['ppi_harga']*$value['ppi_jumlah'] ?>" name="item_subtotal[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="subtotal_item">
            <?php echo inttomoney($value['ppi_harga']*$value['ppi_jumlah']) ?>
          </td>
		  <td>
            <input type="hidden" value="<?php echo $value['ppi_tujuan'] ?>" name="item_tujuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="tujuan_item">
            <?php echo $value['ppi_tujuan'] ?>
          </td>
        </tr>

        <?php
        $subtotal += $value['ppi_harga']*$value['ppi_jumlah'];
        if(!empty($value['ppi_ppn'])){
          $subtotal_ppn += $value['ppi_harga']*$value['ppi_jumlah']*($value['ppi_ppn']/100);
        }
        if(!empty($value['ppi_pph'])){
         $subtotal_pph += $value['ppi_harga']*$value['ppi_jumlah']*($value['ppi_pph']/100);
       }
     } } ?>

   </tbody>
 </table>

 <hr>

 <div class="form-group">
  <div class="col-sm-5">
  </div>
  <label class="col-sm-4 control-label">Nilai HPS</label>
  <div class="col-sm-3">
    <p class="form-control-static text-right" id="total_alokasi"> <?php echo inttomoney($subtotal) ?></p>
    <input type="hidden" name="pagu_anggaran_inp" id="pagu_anggaran_inp" value="<?php echo $subtotal ?>">
  </div>
</div>

<input type="hidden" name="ppn_inp" id="ppn_inp" value="<?php echo $subtotal_ppn ?>" style='visibility: hidden;'>

<input type="hidden" name="pph_inp" id="pph_inp" value="<?php echo $subtotal_pph ?>" style='visibility: hidden'>

<input type="hidden" name="total_alokasi_ppn_inp" id="total_alokasi_ppn_inp"
value="<?php echo $subtotal+$subtotal_ppn+$subtotal_pph ?>" style='visibility: hidden'>

</div>

</div>
</div>
</div>

<script type="text/javascript">

  $(function(){
    // current pph field
    $.ajax({
      url:"<?php echo site_url('administration/dropdown_pph') ?>",
      type:"get",
      dataType:"json",
      success: function(data) {
        $.each(data, function(index, row) {

          $("#pph_item_inp").append("<option value='"+row.pph_value+"'>"+row.pph_name+" - "+row.pph_value+"</option>");


        });
      }
    });

  });


  function set_total(){

    var total_alokasi = 0;
    var ppn = 0;
    var pph = 0;
    var total_alokasi_ppn = 0;

    var kode_item = null;

    $("#item_table tr").each(function(){

      if(!kode_item){
        kode_item = $(this).find(".kode_item").val();
      }

      var item = (!isNaN($(this).find(".harga_satuan_item").val())) ? $(this).find(".harga_satuan_item").val() : 0;
      var qty = (!isNaN($(this).find(".jumlah_item").val())) ? $(this).find(".jumlah_item").val() : 0;
      var subtotal = (!isNaN($(this).find(".subtotal_item").val())) ? $(this).find(".subtotal_item").val() : 0;
      var ppn_persen = ($(this).find(".ppn_satuan_item").val()) ? $(this).find(".ppn_satuan_item").val()/100 : 0;
      var pph_persen = ($(this).find(".pph_satuan_item").val()) ? $(this).find(".pph_satuan_item").val()/100 : 0;

      console.log("HARGA "+item);
      console.log("QTY "+qty);
       console.log("SUBTOTAL "+subtotal);
       console.log("PPN_PERSEN "+ppn_persen);
       console.log("PPN_PERSEN "+pph_persen);

      total_alokasi += (item*qty);
      var ppn_nominal = (item*qty) * ppn_persen;

      ppn += ppn_nominal;
      var pph_nominal = (item*qty) * pph_persen;
      pph += pph_nominal;
      total_alokasi_ppn += (item*qty) + ppn_nominal + pph_nominal;

    });

    kode_item = (kode_item) ? kode_item : "";

    var total_pagu = parseFloat($("#total_pagu_inp").val());
    var sisa_pagu_awal = parseFloat($("#sisa_pagu_awal_inp").val());
    var sisa_pagu = parseFloat(sisa_pagu_awal)-parseFloat(total_alokasi_ppn);
    // alert(sisa_pagu_awal-total_alokasi_ppn)

    $("#picker_item_matgis_btn").attr('data-url',"<?php echo site_url('procurement/picker_matgis?last_item_code=') ?>"+kode_item);

    $("#total_alokasi").text(inttomoney(total_alokasi));
    $("#pagu_anggaran_inp").val(total_alokasi);
    $("#ppn").text(inttomoney(ppn));
    $("#ppn_inp").val(ppn);
    $("#pph").text(inttomoney(pph));
    // $("#pph").text(pph);
    $("#pph_inp").val(pph);
    $("#total_alokasi_ppn").text(inttomoney(total_alokasi_ppn));
    $("#total_alokasi_ppn_inp").val(total_alokasi_ppn);
    $("#sisa_pagu").text(inttomoney(sisa_pagu));
    $("#sisa_pagu_inp").val(sisa_pagu);

  }

  $(document).ready(function(){

    $('.int_item').css('display','none');

    $(".barang_btn").click(function(){
      $("#tipe_item").text("BARANG");
    });
    $(".jasa_btn").click(function(){
      $("#tipe_item").text("JASA");
    });
    // $(".sumberdaya_btn").click(function(){
    //   $("#tipe_item").text("MULTIPLE");
    // });
    var uri_pp = '<?php echo site_url('Procurement/periode_pengadaan_picker') ?>';

    if ($('#kode_spk').val() == '') {
      $('.int_item').css('display','none');
      $('.not_integrated').show();
      $('.integrated').hide();
    }else{
      $('.integrated').show();
      $('.not_integrated').hide();
      $('.int_item').css('display','');
    }

    $(document.body).on("change","#kode_item",function(){

      var tipe = $("#tipe_item").text();

      var id = $(this).val();

      var url = "<?php echo site_url('Procurement/get_item_matgis')?>";

      // if (tipe != 'MULTIPLE' ||  $('#kode_spk').val() == '') {
        // $('.int_item').css('display','none');
        // $.ajax({
        //   url : url+"?id="+id,
        //   dataType:"json",
        //   success:function(data){
        //     var mydata = data.rows[0];
        //     console.log(mydata, 'ok')
        //     $("#deskripsi_item").html(mydata.short_description);
        //     $("#deskripsi_pekerjaan").html(mydata.ppm_scope_of_work);
        //     // $("#group_item").html(mydata.name_group);
        //     $("#tipe_item").text(mydata.tipe);
        //     $("#jumlah_item_inp").val(1);
        //     $("#satuan_item_inp").val(mydata.uom);
        //     $("#harga_satuan_item_inp").val(mydata.total_price);
        //   }
        // });
      // }else{
        //function delay
        var delay = (function(){
          var timer = 0;
          return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
          };
        })();
        $.ajax({
          url : url+"?id="+id+"&spk_code="+$('#kode_spk').val()+"&",
          dataType:"json",
          cache: false,
          success:function(data){
            $('.int_item').css('display','');
            var mydata = data.rows[0];

            $("#deskripsi_item").html(mydata.smbd_name);
            $("#tipe_item").text(mydata.tipe);
            $("#jumlah_item_inp").val(0);
            $("#satuan_item_inp").val(mydata.unit);
            $("#harga_satuan_item_inp").val(mydata.price);

            return false;
          }
        });

      // }


    });


    $(".action_item").click(function(){

      var tipe = $("#tipe_item").text();
      var current_item = $("#current_item").val();
      var no = current_item;

      if(current_item == ""){
        // no = ($("#item_table tr").length) ? parseInt($("#item_table tr").length) : 1;
        // no = ($("#item_table tr").length != 0) ? parseInt(getMaxDataNo(".edit_item"))+1 : 1;
        if (getMaxDataNo(".edit_item") == null) {
          no = 1;
        }else{
          no = getMaxDataNo(".edit_item")+1;
        }

      }else{

      }

      var kode = $("#kode_item").val();
      if (tipe == 'MULTIPLE') {

      }
      var max_notif = $('#max_volume').html();
      var deskripsi = $("#deskripsi_item").text();
      var jumlah = $("#jumlah_item_inp").val();
      var satuan = $("#satuan_item_inp").val();
      var harga_satuan = $("#harga_satuan_item_inp").val();
      var jumlah_int = $("#jumlah_item_inp").autoNumeric('get');
      var harga_satuan_int = $("#harga_satuan_item_inp").autoNumeric('get');
      var ppn = ($("#ppn_item_inp").prop('checked')) ? 10 : 0;
      // current pph field
      if ($("#pph_item_inp option:selected").val() != "" ) {
        var pph = parseFloat($("#pph_item_inp option:selected").val().replace(/,/, '.')).toFixed(2);
      }else{
        var pph = parseFloat(0);
      }
      //end
      // var pph = $("#pph_item_inp").autoNumeric('get');
      var label_ppn = (ppn == 0) ? "" : " PPN ("+ppn+"%) ";
      var label_pph = (pph == 0) ? "" : " PPH ("+pph+"%) ";

      // if(kode == ""){

      //   alert("Pilih item");
      // //haqim
      // } else  if (satuan=='') {

      //   alert("Satuan harus diisi");

      // } else
      // end

      var ada = $("#item_table tr input[value='"+kode+"']").length;

	//ditutup dulu nanti kalo butuh dibuka lagi
      // if(ada > 0){

        // alert("Kode barang tidak boleh sama");

      // } else
	  if(harga_satuan_int < 1){

        alert("Harga tidak boleh kurang dari 1");

      } else if(jumlah_int < 1){

        alert("Jumlah tidak boleh kurang dari 1");

      }else {


        var x = parseFloat(jumlah_int)*parseFloat(harga_satuan_int);
        var subtotal_int = x+(x*parseFloat(ppn)/100)+(x*(pph)/100);
        // var subtotal = inttomoney(subtotal_int);
        var subtotal = inttomoney(x);
        harga_satuan = inttomoney(harga_satuan_int);

        var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
        html += "<td><input type='hidden' class='kode_item' data-no='"+no+"' name='item_kode["+no+"]' value='"+kode+"'/>"+kode+"</td>";
        html += "<td><input type='hidden' class='tipe_item' data-no='"+no+"' name='item_tipe["+no+"]' value='"+tipe+"'/>"+tipe+"</td>";
        html += "<td><input type='hidden' class='deskripsi_item' data-no='"+no+"' name='item_deskripsi["+no+"]' value='"+deskripsi+"'/>"+deskripsi+"</td>";
        if (tipe == 'MULTIPLE') {
        }
        html += "<td class='text-right'><input type='hidden' class='max_item' data-no='"+no+"' name='max_item["+no+"]' value='"+max_notif+"'/> <input type='hidden' class='jumlah_item' data-no='"+no+"' name='item_jumlah["+no+"]' value='"+jumlah_int+"'/>"+jumlah+"</td>";
        html += "<td><input type='hidden' class='satuan_item' data-no='"+no+"' name='item_satuan["+no+"]' value='"+satuan+"'/>"+satuan+"</td>";
        html += "<td class='text-right'><input type='hidden' class='harga_satuan_item' data-no='"+no+"' name='item_harga_satuan["+no+"]' value='"+harga_satuan_int+"'/>"+harga_satuan+"</td>";
        html += "<td class='text-right' style='display: none'><input type='hidden' class='ppn_satuan_item' data-no='"+no+"' name='item_ppn_satuan["+no+"]' value='"+ppn+"'/> "+label_ppn;
        html += " <input type='hidden' class='pph_satuan_item' data-no='"+no+"' name='item_pph_satuan["+no+"]' value='"+pph+"'/> "+label_pph;
        html += "</td>";
        html += "<td class='text-right'><input type='hidden' class='subtotal_item' data-no='"+no+"' name='item_subtotal["+no+"]' value='"+subtotal_int+"'/>"+subtotal+"</td>"
        if (tipe == 'MULTIPLE') {
        };
        html += "</tr>";
        $("#item_table").append(html);
        $("#kode_item").val("");
        $("#tipe_item").text("");
        $("#deskripsi_item").text("");
        if (tipe == 'MULTIPLE') {
        }
        $("#max_volume").html("");
        $("#jumlah_item_inp").val("");
        $("#satuan_item_inp").val("");
        $("#jumlah_item_lbl").text("");
        $("#harga_satuan_item_inp").val("");
        // current pph field
        $("#pph_item_inp").val("");
        //end
        $("#ppn_item_inp").prop("checked",false);
        $("#current_item").val("");

      }

      set_total();

      if ($('#sisa_pagu_inp').val() < 0) {
        $('#sisa_pagu').css({
          "font-weight": 'bold',
          "color": 'red'
        });
      }else {
          // $('#sisa_pagu_inp_div').removeAttr('style')
          $('#sisa_pagu').removeAttr('style')
        }

        $('.edit_item').click(function(){
          // $('#sisa_pagu_inp_div').removeAttr('style')
          $('#sisa_pagu').removeAttr('style')

        })
        $('[data-toggle="popover"]').popover();

      });



$(document.body).on("click",".empty_item",function(){
  $('#max_volume').html('');
  var tipe = $("#tipe_item").text();
  $("#current_item").val("");
  $("#kode_item").val("");
  $("#tipe_item").text("");
  $("#deskripsi_item").text("");
  if (tipe == 'MULTIPLE') {
  }
  $("#jumlah_item_inp").val("");
  $("#satuan_item_inp").val("");
  $("#jumlah_item_lbl").text("");
  $("#harga_satuan_item_inp").val("");

  cek_group();

});

function cek_group(){

  var no = parseInt($("#item_table tr").length);

  if(no == 1){
    $.ajax({
      url:"<?php echo site_url('procurement/set_session/code_group/') ?>",
      success:function(){

      }
    })
  }

}

$(document.body).on("click",".edit_item",function(){
  var no = $(this).attr('data-no');
  max_notif_item = $(".max_item[data-no='"+no+"']").val();
  $('#max_volume').html(max_notif_item);
  var kode = $(".kode_item[data-no='"+no+"']").val();
  var tipe = $(".tipe_item[data-no='"+no+"']").val();
  var deskripsi = $(".deskripsi_item[data-no='"+no+"']").val();
  if (tipe == 'MULTIPLE') {



  }
  var jumlah = $(".jumlah_item[data-no='"+no+"']").val();
  var satuan = $(".satuan_item[data-no='"+no+"']").val();
  var harga_satuan = $(".harga_satuan_item[data-no='"+no+"']").val();
      // current pph field
      var ppn = $(".ppn_satuan_item[data-no='"+no+"']").val();
      var pph = $(".pph_satuan_item[data-no='"+no+"']").val();
      //end

      $("#current_item").val(no);
      $("#kode_item").val(kode);
      $("#tipe_item").text(tipe);
      $("#deskripsi_item").text(deskripsi);
      if (tipe == 'MULTIPLE') {
      }
      var jml = inttomoney(jumlah);
      $("#jumlah_item_inp").val(jml);
      $("#satuan_item_inp").val(satuan);
      $("#jumlah_item_lbl").text(jml.toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 8}));
      // $("#pph_item_inp").val(pph);
      // $("#pph_item_inp option:selected").val(pph.replace('.', ','));
      // current pph field
      var is_ppn = (parseFloat(ppn) != 0);
      $("#ppn_item_inp").prop('checked',is_ppn);
      $("#pph_item_inp option[value='"+pph.replace('.', ',')+"']").prop('selected',true);
      //end
      $("#harga_satuan_item_inp").val(inttomoney(harga_satuan));

      cek_group();

      $(this).parent().parent().remove();

      set_total();

      return false;

    });

})

function getMaxDataNo(selector) {
  var min=null, max=null;
  $(selector).each(function() {
    var no_pp = parseInt($(this).attr('data-no'), 10);
        // if ((min===null) || (no_pp < min)) { min = no_pp; }
        if ((max===null) || (no_pp > max)) { max = no_pp; }
      });
      // return {min:min, max:max};
      return max;
    }

  </script>
