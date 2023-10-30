<div class="modal" id="exampleModal_Template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Evaluasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" action="<?php echo site_url($controller_name."/submit_item_evaluasi_template");?>">
      <div class="modal-body">
          <input class="form-control hide" id="evt_id" name="evt_id" value="<?=$prep['evt_id']?>">
          <input class="form-control hide" id="evt_rfq_no" name="evt_rfq_no" value="<?=$prep['ptm_number']?>">

          <input class="form-control hide" id="evt_type" name="evt_type" value="">
          <div class="row">
              <div class="col-md-2 jenis_item">
                  <b>Jenis item</b>
              </div>
              <div class="col-md-4">
                  <label>&nbsp;</label>
                  <select name="etd_mode" id="modal_etd_mode" class="form-control">
                      <option value="">Pilih</option>
                      <option value="0">Administrasi</option>
                      <option value="1">Teknis</option>
                  </select>
              </div>
              <div class="col-md-2" id="txt_nilai">
                  <label>Bobot</label>
                  <input class="form-control" required name="evt_value" placeholder="0" min="0">
              </div>
              <div class="col-md-2 hide" id="evt_passing_grade">
                  <label>Passing Grade</label>
                  <input class="form-control" name="evt_passing_grade" placeholder="40" min="0">
              </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class="col-md-6">
                <label>Item penilaian</label>
                <input class="form-control" required name="etd_item" placeholder="">
            </div>
            <div class="col-md-2">
                <label>Bobot</label>
                <input class="form-control" required onkeyup="validasiBobot();" name="etd_weight" placeholder="20" min="0">
            </div>
        </div>
        <br>
          <br>
          <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class="col-md-6">
                <label>Kriteria penilaian
                    <div class="btn btn-info btn-sm add_kriteria"><i class="fa fa-plus"></i></div>
                </label>
                <input class="form-control" required name="deskripsi[]" value="">
            </div>
            <div class="col-md-2">
                <label style="margin-bottom:15px !important;">Nilai</label>
                <input class="form-control" required name="bobot[]" placeholder="81 - 100">
            </div>
        </div>
        <div class="element_container"></div>
        <br>
        <div class="row">
          <div class="col-md-9">&nbsp;</div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>

        </form>
        <br><br>

        <div class="row">
          <div class="col-md-1">No</div>
          <div class="col-md-7">Uraian</div>
          <div class="col-md-2">Bobot</div>
        </div>

        <div class="row card-header-primary">
          <div class="col-md-1">A</div>
          <div class="col-md-7">Administrasi</div>
          <div class="col-md-2">0%</div>
        </div>
        <?php foreach ($detail as $key => $detail) { ?>
          <?php if($detail['etd_mode'] == 0){?>
            <div class="row card-content-item">
              <div class="col-md-1"><?=$key?></div>
              <div class="col-md-7">
                <span class="item_text_<?=$detail['etd_id']?>"><?=$detail['etd_item']?></span>
                <span class="item_input_<?=$detail['etd_id']?> hide"><input class="form-control item_<?=$detail['etd_id']?>" value="<?=$detail['etd_item']?>" required placeholder="81 - 100"></span>
              </div>
              <div class="col-md-2">
                <span class="weight_text_<?=$detail['etd_id']?>"><?=$detail['etd_weight']?>%</span>
                <span class="weight_input_<?=$detail['etd_id']?> hide"><input class="form-control weight_<?=$detail['etd_id']?>" value="<?=$detail['etd_weight']?>" required placeholder="81 - 100"></span>
              </div>
              <div class="col-md-2">
                <div data-id="<?=$detail['etd_id']?>" class="save_nilai btn btn-success btn-sm hide save_nilai_<?=$detail['etd_id']?>"><i class="fa fa-save"></i></div>
                <div data-id="<?=$detail['etd_id']?>" class="edit_nilai btn btn-info btn-sm edit_nilai_<?=$detail['etd_id']?>"><i class="fa fa-edit"></i></div>
                <div data-id="<?=$detail['etd_id']?>" class="cancel_nilai btn btn-info btn-sm hide cancel_nilai_<?=$detail['etd_id']?>"><i class="fa fa-close"></i></div>
                <a href="<?php echo site_url($controller_name."/delete_item_evaluasi_template/".$detail['etd_id']."/detail");?>" class="btn btn-danger btn-sm delete_kriteria"><i class="fa fa-trash-o"></i></a>
              </div>
            </div>
            <?php 
              $kriteria_admnin =  $this->Procevaltemp_m->getTemplateEvaluasiItem($detail['etd_id'])->result_array();
              foreach ($kriteria_admnin as $key3 => $kriteria) {
                ?>
                <div class="row card-content-kriteria">
                  <div class="col-md-1">&nbsp;</div>
                  <div class="col-md-7">
                    <span class="deskripsi_text_<?=$kriteria['id']?>"><?=$kriteria['deskripsi']?></span>
                    <span class="deskripsi_input_<?=$kriteria['id']?> hide"><input class="form-control deskripsi_<?=$kriteria['id']?>" value="<?=$kriteria['deskripsi']?>" required placeholder="81 - 100"></span>
                  </div>
                  <div class="col-md-2">
                    <span class="bobot_text_<?=$kriteria['id']?>"><?=$kriteria['bobot']?></span>
                    <span class="bobot_input_<?=$kriteria['id']?> hide"><input class="form-control bobot_<?=$kriteria['id']?>" value="<?=$kriteria['bobot']?>" required placeholder="81 - 100"></span>
                  </div>
                  <div class="col-md-2">
                    <div data-id="<?=$kriteria['id']?>" class="save_item btn btn-success btn-sm hide save_kriteria_<?=$kriteria['id']?>"><i class="fa fa-save"></i></div>
                    <div data-id="<?=$kriteria['id']?>" class="edit_item btn btn-info btn-sm edit_kriteria_<?=$kriteria['id']?>"><i class="fa fa-edit"></i></div>
                    <div data-id="<?=$kriteria['id']?>" class="cancel_item btn btn-info btn-sm hide cancel_kriteria_<?=$kriteria['id']?>"><i class="fa fa-close"></i></div>
                    <a href="<?php echo site_url($controller_name."/delete_item_evaluasi_template/".$kriteria['id']);?>" class="btn btn-danger btn-sm delete_kriteria"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div>
              <?php } ?>
          <?php } ?>
        <?php }?>

        <!-- TEKNIS -->
        <div class="row card-header-primary">
          <div class="col-md-1">B</div>
          <div class="col-md-7">Teknis</div>
          <div class="col-md-2"><?=$data['evt_tech_weight']?>%</div>
        </div>
        <?php foreach ($detail_teknis as $keys => $teknis) { ?>
          <?php if($teknis['etd_mode'] == 1){?>
            <div class="row card-content-item">
              <div class="col-md-1"><?=$keys+1?></div>

              <div class="col-md-7">
                <span class="item_text_<?=$teknis['etd_id']?>"><?=$teknis['etd_item']?></span>
                <span class="item_input_<?=$teknis['etd_id']?> hide"><input class="form-control item_<?=$teknis['etd_id']?>" value="<?=$teknis['etd_item']?>" required placeholder="81 - 100"></span>
              </div>
              <div class="col-md-2">
                <span class="weight_text_<?=$teknis['etd_id']?>"><?=$teknis['etd_weight']?>%</span>
                <span class="weight_input_<?=$teknis['etd_id']?> hide"><input class="form-control weight_<?=$teknis['etd_id']?>" value="<?=$teknis['etd_weight']?>" required placeholder="81 - 100"></span>
              </div>
              <div class="col-md-2">
                <div data-id="<?=$teknis['etd_id']?>" class="save_nilai btn btn-success btn-sm hide save_nilai_<?=$teknis['etd_id']?>"><i class="fa fa-save"></i></div>
                <div data-id="<?=$teknis['etd_id']?>" class="edit_nilai btn btn-info btn-sm edit_nilai_<?=$teknis['etd_id']?>"><i class="fa fa-edit"></i></div>
                <div data-id="<?=$teknis['etd_id']?>" class="cancel_nilai btn btn-info btn-sm hide cancel_nilai_<?=$teknis['etd_id']?>"><i class="fa fa-close"></i></div>
                <a href="<?php echo site_url($controller_name."/delete_item_evaluasi_template/".$teknis['etd_id']."/detail");?>" class="btn btn-danger btn-sm delete_kriteria"><i class="fa fa-trash-o"></i></a>
              </div>

            </div>
              <?php 
              $kriteria_teknis =  $this->Procevaltemp_m->getTemplateEvaluasiItem($teknis['etd_id'])->result_array();
              foreach ($kriteria_teknis as $key2 => $kriteria2) {
                ?>
                <div class="row card-content-kriteria">
                  <div class="col-md-1">&nbsp;</div>
                  <div class="col-md-7">
                    <span class="deskripsi_text_<?=$kriteria2['id']?>"><?=$kriteria2['deskripsi']?></span>
                    <span class="deskripsi_input_<?=$kriteria2['id']?> hide"><input class="form-control deskripsi_<?=$kriteria2['id']?>" value="<?=$kriteria2['deskripsi']?>" required placeholder="81 - 100"></span>
                  </div>
                  <div class="col-md-2">
                    <span class="bobot_text_<?=$kriteria2['id']?>"><?=$kriteria2['bobot']?></span>
                    <span class="bobot_input_<?=$kriteria2['id']?> hide"><input class="form-control bobot_<?=$kriteria2['id']?>" value="<?=$kriteria2['bobot']?>" required placeholder="81 - 100"></span>
                  </div>
                  <div class="col-md-2">
                    <div data-id="<?=$kriteria2['id']?>" class="save_item btn btn-success btn-sm hide save_kriteria_<?=$kriteria2['id']?>"><i class="fa fa-save"></i></div>
                    <div data-id="<?=$kriteria2['id']?>" class="edit_item btn btn-info btn-sm edit_kriteria_<?=$kriteria2['id']?>"><i class="fa fa-edit"></i></div>
                    <div data-id="<?=$kriteria2['id']?>" class="cancel_item btn btn-info btn-sm hide cancel_kriteria_<?=$kriteria2['id']?>"><i class="fa fa-close"></i></div>
                    <a href="<?php echo site_url($controller_name."/delete_item_evaluasi_template/".$kriteria2['id']);?>" class="btn btn-danger btn-sm delete_kriteria"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div>
              <?php } ?>
          <?php } ?>
        <?php }?>
      
      <!-- teknis -->
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>


<script type="text/javascript">
  
  $(".edit_nilai").click(function(e){
      var id_nilai = $(this).data('id');

      $('.item_text_'+id_nilai).addClass('hide');
      $('.weight_text_'+id_nilai).addClass('hide');
      $('.edit_nilai_'+id_nilai).addClass('hide');

      $('.item_input_'+id_nilai).removeClass('hide');
      $('.weight_input_'+id_nilai).removeClass('hide');
      $('.save_nilai_'+id_nilai).removeClass('hide');
      $('.cancel_nilai_'+id_nilai).removeClass('hide');
  });


  $(".cancel_nilai").click(function(e){
    var id_nilai = $(this).data('id');

    $('.item_text_'+id_nilai).removeClass('hide');
    $('.weight_text_'+id_nilai).removeClass('hide');

    $('.item_input_'+id_nilai).addClass('hide');
    $('.weight_input_'+id_nilai).addClass('hide');

    $('.save_nilai_'+id_nilai).addClass('hide');
    $('.cancel_nilai_'+id_nilai).addClass('hide');
    $('.edit_nilai_'+id_nilai).removeClass('hide');
  });

  
  $(".save_nilai").click(function(e){
    var id_nilai = $(this).data('id');
    $('.item_text_'+id_nilai).removeClass('hide');
    $('.weight_text_'+id_nilai).removeClass('hide');

    $('.item_input_'+id_nilai).addClass('hide');
    $('.weight_input_'+id_nilai).addClass('hide');

    $('.save_nilai_'+id_nilai).addClass('hide');
    $('.cancel_nilai_'+id_nilai).addClass('hide');
    $('.edit_nilai_'+id_nilai).removeClass('hide');
    var weight_val = $('.weight_'+id_nilai).val();
    var item_val = $('.item_'+id_nilai).val();

    $.ajax({
      url:"<?php echo site_url('procurement/update_detail_valuasi_template') ?>",
      data:"id="+id_nilai+"&etd_weight="+weight_val+"&etd_item="+item_val,
      type:"post",
      success:function(results){
        if(results.results==1){
          $('.weight_'+id_nilai).val(weight_val);
          $('.item_'+id_nilai).val(item_val);
          $('.weight_text_'+id_nilai).text(weight_val+'%');
          $('.item_text_'+id_nilai).text(item_val);
        }
      }
    });
  });
</script>

<script type="text/javascript">
  
  $(".edit_item").click(function(e){
      var id_kriteria = $(this).data('id');

      $('.deskripsi_text_'+id_kriteria).addClass('hide');
      $('.bobot_text_'+id_kriteria).addClass('hide');
      $('.edit_kriteria_'+id_kriteria).addClass('hide');

      $('.deskripsi_input_'+id_kriteria).removeClass('hide');
      $('.bobot_input_'+id_kriteria).removeClass('hide');
      $('.save_kriteria_'+id_kriteria).removeClass('hide');
      $('.cancel_kriteria_'+id_kriteria).removeClass('hide');
  });


  $(".cancel_item").click(function(e){
    var id_kriteria = $(this).data('id');

    $('.deskripsi_text_'+id_kriteria).removeClass('hide');
    $('.bobot_text_'+id_kriteria).removeClass('hide');

    $('.deskripsi_input_'+id_kriteria).addClass('hide');
    $('.bobot_input_'+id_kriteria).addClass('hide');

    $('.save_kriteria_'+id_kriteria).addClass('hide');
    $('.cancel_kriteria_'+id_kriteria).addClass('hide');
    $('.edit_kriteria_'+id_kriteria).removeClass('hide');
  });

  
  $(".save_item").click(function(e){
    var id_kriteria = $(this).data('id');
    $('.deskripsi_text_'+id_kriteria).removeClass('hide');
    $('.bobot_text_'+id_kriteria).removeClass('hide');

    $('.deskripsi_input_'+id_kriteria).addClass('hide');
    $('.bobot_input_'+id_kriteria).addClass('hide');

    $('.save_kriteria_'+id_kriteria).addClass('hide');
    $('.cancel_kriteria_'+id_kriteria).addClass('hide');
    $('.edit_kriteria_'+id_kriteria).removeClass('hide');
    var bobot_val = $('.bobot_'+id_kriteria).val();
    var deskripsi_val = $('.deskripsi_'+id_kriteria).val();

    $.ajax({
      url:"<?php echo site_url('procurement/update_item_valuasi_template') ?>",
      data:"id="+id_kriteria+"&bobot="+bobot_val+"&deskripsi="+deskripsi_val,
      type:"post",
      success:function(results){
        if(results.results==1){
          $('.bobot_'+id_kriteria).val(bobot_val);
          $('.deskripsi_'+id_kriteria).val(deskripsi_val);
          $('.bobot_text_'+id_kriteria).text(bobot_val);
          $('.deskripsi_text_'+id_kriteria).text(deskripsi_val);
        }
      }
    });
  });


  $(".delete_item").click(function(e){
    var id_kriteria = $(this).data('id');
    $.ajax({
      url:"<?php echo site_url('procurement/delete_item_evaluasi_template') ?>",
      data:"id="+id_kriteria,
      type:"post",
      success:function(results){
        console.log(results);
        //if(results.results==1){
        //$(this).parent().parent().remove();
        //}
      }
    });
  });
</script>

<script type="text/javascript">
  $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });

  var evt_type, max_admin , max_teknis = 0;

  $("select[name='etd_mode']").change(function(event){
    var etd_mode = $(this).val();
    if(etd_mode==1){ //mode teknis
      $("input[name='evt_value']").val("<?=$data['evt_tech_weight']?>");
      $("input[name='evt_passing_grade']").val("<?=$data['evt_passing_grade']?>");
      $('#evt_passing_grade').removeClass('hide');
      $("input[name='evt_value']").removeAttr("disabled");
      $("input[name='etd_weight']").removeAttr('readonly');
      $("input[name='etd_weight']").val('');
    } else {
      $("input[name='evt_value']").attr("disabled", true);
      $("input[name='evt_value']").val('0');
      $('#evt_passing_grade').addClass('hide');
      $("input[name='etd_weight']").val('0');
      $("input[name='etd_weight']").attr('readonly', true);
    }
  });

  /* $("select[name='evaluasi']").change(function(){
    var id = $("#template_evaluasi_inp").val();
    var url = "<?php echo site_url('Procurement/data_template_evaluasi') ?>";
    $.ajax({
      url : url+"?id="+$(this).val(),
      dataType:"json",
      success:function(data){
        var mydata = data.rows[0];
        $(".evt_tech_weight").val(mydata.evt_tech_weight);
        $(".evt_price_weight").val(mydata.evt_price_weight);
        $(".evt_passing_grade").val(mydata.evt_passing_grade);
        $('#btn_detail_evaluasi').attr('data-evt_id', mydata.evt_id);
        evt_id = mydata.evt_id;
      }
    });
  }); */

  function validasiBobot(){
    var max_admin = "<?=$max_admin?>";
    var max_teknis = "<?=$max_teknis?>";
    var etd_mode = parseInt($("#modal_etd_mode :selected").val());
    var etd_weight = $("input[name='etd_weight']").val();

    if(etd_mode==1 && !isNaN(etd_mode)){
      if(parseInt(max_teknis) + parseInt(etd_weight) > 100){
        //console.log(parseInt(max_teknis) + parseInt(etd_weight));
        $("input[name='etd_weight']").val('');
        alert('Maaf jumlah melebihi batas maksimal 100%');
        return false;
      }
    } else if(etd_mode==0 && !isNaN(etd_mode)){
      if(parseInt(max_admin) + parseInt(etd_weight) > 100){
        //console.log(parseInt(max_admin) + parseInt(etd_weight));
        $("input[name='etd_weight']").val('');
        alert('Maaf jumlah melebihi batas maksimal 100%');
        return false;

      }
    } else {
      alert('Maaf Silahkan pilih Jenis item dahulu.!');
    }

  }


  $('#btn_detail_evaluasi').click(function(event){
    var button = $(event.relatedTarget);
    $('#evt_type').val($("select[name='evaluasi']").val());
  });


  function check_metode(){

    var metode = parseInt($("#metode_pengadaan_cont select option:selected").val());
    var template_evaluasi = $("#template_evaluasi_cont");
    var klasifikasi_peserta = $("#klasifikasi_peserta_cont");
    var keterangan = $("#keterangan_metode_cont");
    var sampul = $("#sistem_sampul_cont");
    var vendor = $("#vendor_container");
    var eauction = $("#eauction_cont");
      //var panitia_pelelangan = $("#panitia_pelelangan_cont");
      if(metode == 0){
        template_evaluasi.show();
        klasifikasi_peserta.show();
        keterangan.show();
        sampul.hide();
        vendor.show();
        $("input[name='eauction_inp']").prop('checked',false);
        $("input[name='eauction_inp']").prop('required',false);
        //panitia_pelelangan.hide();
        $("#penunjuk_langsung").removeClass("d-none");
        $("#syarat_penunjuk_langsung").removeClass("d-none");
        $("#dokumen_penunjuk_langsung").removeClass("d-none");
      } else if(metode == 1){
        template_evaluasi.show();
        klasifikasi_peserta.show();
        keterangan.show();
        sampul.show();
        vendor.show();
        eauction.show();
        $("input[name='eauction_inp']").prop('checked',false);
        $("input[name='eauction_inp']").prop('required',false);
        //panitia_pelelangan.hide();
        $("#penunjuk_langsung").addClass("d-none");
        $("#syarat_penunjuk_langsung").addClass("d-none");
        $("#dokumen_penunjuk_langsung").addClass("d-none");
      } else if(metode == 2){
        template_evaluasi.show();
        klasifikasi_peserta.show();
        keterangan.show();
        sampul.show();
        vendor.show();
        eauction.show();
        $("input[name='eauction_inp']").prop('required',false);
        //panitia_pelelangan.show();
        $("#penunjuk_langsung").addClass("d-none");
        $("#syarat_penunjuk_langsung").addClass("d-none");
        $("#dokumen_penunjuk_langsung").addClass("d-none");
      } else {
        template_evaluasi.hide();
        klasifikasi_peserta.hide();
        keterangan.hide();
        sampul.hide();
        vendor.show();
        //panitia_pelelangan.hide();
        $("#penunjuk_langsung").addClass("d-none");
        $("#syarat_penunjuk_langsung").addClass("d-none");
        $("#dokumen_penunjuk_langsung").addClass("d-none");
      }

      var ss = $("#sistem_sampul_inp option:selected").val();
      var mp = $("#metode_pengadaan_inp option:selected").val();
      if(mp == 2){
        $(".pq_cont").show();
      } else {
        $(".pq_cont").hide();
        $("input[name='pq_inp']").prop('checked',false);
      }

      if(mp == 1){
        $("#sistem_sampul_inp option[value='2']").hide();
      } else {
        $("#sistem_sampul_inp option[value='2']").show();
      }

    }

    check_metode();

    $("#metode_pengadaan_inp").change(function(){
      check_metode();
    });

    $("#sistem_sampul_inp").change(function(){
      check_metode();
    });


    function filtervendor(){
     var kecil = $("#klasifikasi_kecil_inp").prop("checked");
     var menengah = $("#klasifikasi_menengah_inp").prop("checked");
     var besar = $("#klasifikasi_besar_inp").prop("checked");
     var filtering = ["K","M","B"];
     var myfilter = "";
     var index = 0;
     if(!kecil){
      index = filtering.indexOf("K");
      if (index > -1) {
        myfilter += "";
        filtering.splice(index, 1);
      }
      $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Kecil"]})
    } else {
      myfilter += "K_";
    }
    if(!menengah){
      index = filtering.indexOf("M");
      if (index > -1) {
        myfilter += "";
        filtering.splice(index, 1);
      }
      $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Menengah"]})
    } else {
      myfilter += "M_";
    }
    if(!besar){
      index = filtering.indexOf("B");
      if (index > -1) {
        myfilter += "";
        filtering.splice(index, 1);
      }
      $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Besar"]})
    } else {
      myfilter += "B_";
    }

    var url = "<?php echo site_url('Procurement/set_session/klasifikasi') ?>";

    $.ajax({
      url : url+"/"+myfilter,
      success:function(data){
        // $("#daftar_vendor").bootstrapTable('destroy');
        $("#daftar_vendor").bootstrapTable('refresh');

        setTimeout(function () {
          $("#daftar_vendor").bootstrapTable('resetView');
        }, 200);
      }
    });

  }

  $(document).ready(function(){
    window.setTimeout(function(){
      filtervendor();
      check_metode();
    },3000);


    $("#klasifikasi_kecil_inp,#klasifikasi_menengah_inp,#klasifikasi_besar_inp").click(function(e){
      filtervendor();
    });

    if ($('#template_evaluasi_inp').val() == '') {
      $('#klasifikasi_kecil_inp').prop( "checked", true );
      filtervendor();
    }
  });


  $(document).ready(function(){

    function check_template_evaluasi(){
      var id = $("#template_evaluasi_inp").val();
      var url = "<?php echo site_url('Procurement/data_template_evaluasi') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#template_evaluasi_label").html(mydata.evt_name);
        }
      });
    }

    $(document.body).on("change","#template_evaluasi_inp",function(){

      check_template_evaluasi();

    });

  });

</script>

<script type="text/javascript">
  $(".add_kriteria").click(function(){
      $(".element_container").append(`
      <div class="row">
        <div class="col-md-2">&nbsp;</div>
        <div class="col-md-6">
            <label>&nbsp; </label>
            <input class="form-control" required name="deskripsi[]" value="">
        </div>
        <div class="col-md-2">
            <label>&nbsp;</label>
            <input class="form-control" required name="bobot[]" placeholder="">
        </div>
        <div class="col-md-2">
          <label>&nbsp;</label>
          <div class="btn btn-warning btn-sm btn_delete_kriteria"><i class="fa fa-minus"></i>
        </div>
      </div>
    </div>
    `);
});

$('.element_container').on('click', '.btn_delete_kriteria', function() {
    $(this).parent().parent().remove();
});  
</script>