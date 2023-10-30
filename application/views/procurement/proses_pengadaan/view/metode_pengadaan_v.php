
<style>
.select2-selection--single {
  height: 100% !important;
}
.select2-selection__rendered{
  word-wrap: break-word !important;
  text-overflow: inherit !important;
  white-space: normal !important;
}
select {
  font-family: 'Poppins', 'sans-serif';
}
.select2-container {
  width: 100% !important;
}
.card-header-primary{
  background-color: #2aace3 !important;
  padding-top: 10px;
  padding-bottom: 10px;
  color: #fff;
}
.card-content-item{
  background-color: #e0e0e0 !important;
  padding-top: 10px;
  padding-bottom: 10px;
}
.card-content-kriteria{
  background-color: #f4f3f3 !important;
  padding-top: 10px;
  padding-bottom: 10px;
}
.jenis_item{
  margin-top:30px;
}
.btn_delete_kriteria{
  margin-top:20px;
}
</style>

<div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
            <h4 class="card-title">Metode Pengadaan</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-4">
                <?php $curval = $prep['ptp_tender_method']; ?>
                <div class="row form-group" id="metode_pengadaan_cont">
                  <label class="col-sm-6 control-label">Metode Pengadaan</label>
                  <div class="col-sm-6">
                    <select class="form-control" disabled style="color: black; id="metode_pengadaan_inp" name="metode_pengadaan_inp">
                      <option value=""><?php echo lang('choose') ?></option>
                        <?php foreach ($metode as $key => $value) {
                          $selected = ($curval == $key) ? "selected" : "";
                        ?>
                          <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-5 d-none" id="syarat_penunjuk_langsung">
                <?php $curval = (!empty($prep['ptp_syarat_penunjuk']) ? json_decode($prep['ptp_syarat_penunjuk']) : [] );?>
                <div class="row form-group " >
                  <label class="col-sm-12 control-label text-bold-700">Penunjuk langsung dapat dilakukan apabila memenuhi minimal salah satu dari persyaratan sebagai berikut</label>
                  <div class="col-sm-12">
                  <select class="form-control multiselect" id="ptp_syarat_penunjuk" name="ptp_syarat_penunjuk[]" id="ptp_syarat_penunjuk" multiple="multiple" disabled>
                    <?php
                    foreach ($pilihan_syarat as $key => $value) {
                      $selected = ( in_array($key,$curval)  ? "selected" : "");
                      ?>
                      <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-sm-3 d-none" id="dokumen_penunjuk_langsung">
              <?php $curval = $tender["doc_attachment_inp_mtd_pengadaan"]; ?>
                <label class="col-sm-10 control-label"><a target="_blank" href="<?php echo site_url('log/download_attachment/procurement/tender/' . $curval) ?>">Dokumen</a></label>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4" style="padding-top:17px;">
                <div class="row form-group" id="evaluasi">
                  <label class="col-sm-6 control-label">Evaluasi</label>
                  <div class="col-sm-6">
                    <select class="form-control" id="penilaian" disabled name="evaluasi" style="color: black;">
                      <option value="">Pilih</option>
                      <option value="0" <?php if($data['evt_type']==0){echo "selected";} ?> >Sistem Nilai</option>
                      <option value="1" <?php if($data['evt_type']==1){echo "selected";} ?> >Penilaian Biaya Selama Umur Ekonomis</option>
                      <option value="2" <?php if($data['evt_type']==2){echo "selected";} ?> >Harga Terendah</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-2" id="">
                <div class="row form-group">
                  <label class="col-sm-12 control-label">Evaluasi Administrasi*</label>
                  <div class="col-sm-12">
                    <input class="form-control txt_evaluasi_admin" value="Sistem gugur" disabled>
                  </div>
                </div>
              </div>
              
              <input type="hidden" class="form-control" required  id="template_evaluasi_inp" name="template_evaluasi_inp" value="32">

              <div class="col-sm-2" id="">
                <div class="row form-group">                  
                  <div class="col-md-6">
                    <label>Evaluasi Teknis*</label>
                    <input class="form-control evt_tech_weight" value="<?php echo $data['evt_tech_weight']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label>Passing Grade*</label>
                    <input class="form-control evt_passing_grade" value="<?php echo $data['evt_passing_grade']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="col-sm-2" id="">
                <div class="row form-group">
                  <label class="col-md-12 control-label">Evaluasi Harga*</label>
                  <div class="col-md-12">
                    <input class="form-control evt_price_weight" value="<?php echo $data['evt_price_weight']?>" disabled>
                  </div>
                </div>
              </div>   
              <div class="col-sm-2" style="padding-top: 17px;">
                <a class="btn btn-info btn-sm" id="btn_detail_evaluasi" data-toggle="modal" data-target="#exampleModal_Template_view"><i class="ft-file-text"></i> Detail Evaluasi</a>
              </div>           
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript">

      $(document).ready(function(){
          $('.multiselect').select2();
      });

  $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });

  var evt_type, max_admin , max_teknis = 0;

  $("select[name='etd_mode']").change(function(event){
    var etd_mode = $(this).val();
    if(etd_mode==1){ //mode teknis
      $("input[name='evt_value']").val("31");
      $("input[name='evt_passing_grade']").val("15");
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
  
  function validasiBobot(){
    var max_admin = "24";
    var max_teknis = "100";
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
        vendor.hide();
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

    //var url =  "http://localhost/new_escm/index.php/Procurement/set_session/klasifikasi";
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
      var url = "http://localhost/new_escm/index.php/Procurement/data_template_evaluasi";
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