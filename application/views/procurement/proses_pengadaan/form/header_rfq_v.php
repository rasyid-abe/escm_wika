<style>
  form label, .form-group label {
    font-size: 10px;
  }
  .card {
    border-radius: 0.75rem;
  }
  select.form-control {
    background-color: #2aace3;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    border-radius: 10px;
  }
  .text-black {
    color: black !important;
  }
</style>
<section>
  <div class="row">
    <div class="col-12">
      <div class="pt-2">

        <div class="">
            <h5 class="card-title mb-1"><b>Paket Pengadaan Proyek</b></h5>
        </div>

        <div class="card-content">
          <div class="card-body" style="line-height:0 !important;margin-bottom: -30px;">
            <div class="row">
                <div class="col-md-7">
                    <div class="card-content">
                      <div class="row form-group mb-3">
                        <label class="col-sm-4 control-label text-left"><b>Nomor Tender</b></label>
                        <div class="col-sm-8">
                          <a class="form-control-static no_tender" style="color: #2aace3;">: <?php echo $permintaan['ptm_number'] ?></a>
                        </div>
                      </div>

                      <div class="row form-group">
                        <label class="col-sm-4 control-label text-left"><b>Divisi</b></label>
                        <div class="col-sm-8">
                          <p class="form-control-static">: <?php echo $permintaan['ptm_requester_pos_name']; ?></p>
                        </div>
                      </div>
                      <div class="row form-group">
                        <label class="col-sm-4 control-label text-left"><b>Kode SPK</b></label>
                        <div class="col-sm-8">
                          <p class="form-control-static">: <?php echo $permintaan['spk_code']; ?></p>
                        </div>
                      </div>

                      <?php if ($permintaan['isjoin'] != 1) { ?>
                          <div class="row form-group mb-0">
                            <label class="col-sm-4 control-label text-left"><b>Nama Paket Pengadaan</b></label>
                            <div class="col-sm-8">
                              <p class="form-control-static" id="nama_paket" style="line-height:20px;margin-top:-10px;">: <?php echo$permintaan['ptm_packet'] ?></p>
                            </div>
                          </div>
                      <?php } ?>

                      <div class="row form-group mb-0">
                        <label class="col-sm-4 control-label text-left"><b>Nama Proyek</b></label>
                        <div class="col-sm-8">
                          <p class="form-control-static" style="line-height:20px;margin-top:-10px;">: <?php echo $permintaan['ptm_subject_of_work']; ?></p>
                        </div>
                      </div>

                      <div class="row form-group">
                        <label class="col-sm-4 control-label text-left"><b>Tipe Pengadaan</b></label>
                        <div class="col-sm-8">
                          <p class="form-control-static">: <?php echo $permintaan['ptm_tender_project_type']; ?></p>
                        </div>
                      </div>

                      <div class="row form-group">
                        <label class="col-sm-4 control-label text-left"><b>Metode Pengadaan</b></label>
                        <div class="col-sm-8">
                          <p class="form-control-static">: <?php echo $permintaans['pr_metode_pengadaan']; ?></p>
                          <input type="hidden" name="metode_pengadaan" value="<?php echo $permintaans['pr_metode_pengadaan']; ?>">
                        </div>
                      </div>

                      <?php if($activity_id > 1030){ ?>
                        <div class="row form-group">
                          <label class="col-sm-4 control-label text-left"><b>Jenis Kontrak</b></label>
                          <div class="col-sm-3" style="margin-top: -15px;">
                            <select class="form-control text-black" id="ptm_contract_type_inp" <?php  if($activity_id > 1030) echo "readonly"?> name="ptm_contract_type_inp" required>
                              <option value="">== Pilih ==</option>                              
                              <option value="LUMPSUM" <?php if($permintaan["ptm_contract_type"] == "LUMPSUM"){echo"selected";}?>>LUMPSUM</option>                              
                              <option value="HARGA SATUAN" <?php if($permintaan["ptm_contract_type"] == "HARGA SATUAN"){echo"selected";}?>>HARGA SATUAN</option>
                            </select>
                          </div>
                        </div>
                        <?php if($tender['is_sap'] == '1') : ?>

                          <?php $curval = (isset($permintaan['ptm_doc_type_sap'])) ? $permintaan["ptm_doc_type_sap"] : set_value("ptm_doc_type_sap"); ?>

                            <div class="row form-group">
                              <label class="col-sm-4 control-label text-bold-700">Tipe PO</label>
                              <div class="col-sm-8">                        
                                  <p class="form-control-static" >: <?php echo $doc_type_select['code'].' - '.$doc_type_select['description'] ?></p>        
                                  <input type="hidden" name="ptm_doc_type_sap" value="<?php echo $doc_type_select['code'] ?>" />                
                              </div>
                            </div>
                        
                            <?php $curval = (isset($tender['ctr_down_payment']) && !empty($kontrak['ctr_down_payment'])) ? $tender['ctr_down_payment'] : ""; ?>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label text-bold-700">Persen DP</label>
                                <div class="col-sm-8">
                                    <input type="number" max="100" name="ctr_down_payment" class="form-control" value="<?php echo $curval ?>">
                                </div>
                            </div>

                            <?php $curval = (isset($tender['ctr_down_payment_date']) && !empty($tender['ctr_down_payment_date'])) ? $tender['ctr_down_payment_date'] : ''; ?>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label text-bold-700">Tanggal Akhir DP</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <input type="date" disabled name="ctr_down_payment_date" onchange="valid_date_dp()" class="form-control" value="<?php echo $curval ?>">
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>
                            
                      <?php } ?>

                      <div class="row form-group">
                        <label class="col-sm-4 control-label text-left"><b>Share Pengumuman Tender</b></label>
                        <div class="col-sm-8">
                          <div class="form-control-static">
                            <div class="row" style="margin-top: -15px;">
                              <div class="col-sm-4">
                                <div class="card" style="margin: 5px 0;">
                                  <div class="card-body" style="padding: 0.5rem;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="padi_umkm_inp" id="customSwitch1">
                                      <label class="custom-control-label pt-2" for="customSwitch1">Padi UMKM</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-4" style="width: 35%;padding-left:0px;padding-right:0px;">
                                <div class="card" style="margin: 5px 0;">
                                  <div class="card-body" style="padding: 0.5rem;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="pengadaan_com_inp" id="customSwitch2">
                                      <label class="custom-control-label pt-2" for="customSwitch2">Pengadaan.com</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="card" style="margin: 5px 0;">
                                  <div class="card-body" style="padding: 0.5rem;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="portal_wika_inp" id="customSwitch3">
                                      <label class="custom-control-label pt-2" for="customSwitch3">Portal Wika</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-5">
                    <div class="card-content">
                    <div class="row form-group">
                      <label class="col-sm-4 control-label text-left"><b>Buyer</b></label>
                      <div class="col-sm-8">
                        <p class="form-control-static" id="deskripsi_pekerjaan">: <?php echo$permintaan['ptm_buyer'] ?></p>
                      </div>
                    </div>
                    <div class="row form-group">
                      <label class="col-sm-4 control-label text-left"><b>Tanggal Pembuatan</b></label>
                      <div class="col-sm-8">
                        <p class="form-control-static" id="ptm_created_date" >: <?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($permintaan['ptm_created_date'])); ?></p>
                      </div>
                    </div>

                    <?php if ($permintaan['isjoin'] != 1) { ?>

                      <?php
                      $code = (isset($permintaan['ptm_mata_anggaran']) && !empty($permintaan['ptm_mata_anggaran'])) ? $permintaan['ptm_mata_anggaran'] : null;
                      $label = (isset($permintaan['ptm_nama_mata_anggaran']) && !empty($permintaan['ptm_nama_mata_anggaran'])) ? $permintaan['ptm_nama_mata_anggaran'] : null;
                      $curval = (!empty($code) && !empty($label)) ? $code." ".$label : null;
                      ?>

                      <?php if(!empty($curval)){ ?>

                    <?php } ?>

                    <?php

                    $curval = null;
                    if (isset($permintaan["ptm_sub_mata_anggaran"]) and substr_count($permintaan["ptm_sub_mata_anggaran"], " , ") >= 1 ) {
                    $code = explode(" , ", $permintaan["ptm_sub_mata_anggaran"]);
                    $name = explode(" , ", $permintaan["ptm_nama_sub_mata_anggaran"]);
                    $curval = $permintaan["ptm_sub_mata_anggaran"]." - ".$permintaan["ptm_nama_sub_mata_anggaran"];
                  }

                  if(!empty($curval)){ ?>

                    <div class="row form-group">
                      <label class="col-sm-4 control-label text-right"><b>Sub Mata Anggaran</b></label>
                      <div class="col-sm-8">
                        <p class="form-control-static" id="sub_mata_anggaran">: <?php
                        if (isset($code)) {
                          foreach (array_combine($code, $name) as $code => $name ) {
                            echo $code.' - '.$name."<br/>";
                          }
                        }else if ($permintaan["ptm_sub_mata_anggaran"] == 0) {
                        foreach ($project_cost as $keypc => $valuepc) {
                          echo $valuepc['coa_code'].' - '.$valuepc['coa_name']."<br/>";
                        }
                      }
                      else{
                        echo $curval;
                      }

                      ?></p>
                    </div>
                  </div>

                  <?php } ?>

                  <?php $curval = $permintaan['ptm_currency']; ?>
                  <div class="row form-group">
                    <label class="col-sm-4 control-label text-left"><b>Mata Uang</b></label>
                    <div class="col-sm-8">
                    <p class="form-control-static">: <?php echo $curval ?></p>
                  </div>
                  </div>

                  <?php $curval = $prep["ptp_eauction"]; ?>
                  <div class="row form-group">
                    <label class="col-sm-4 control-label text-left" style="line-height: 12px;"><b>E - Auction</b></label>
                    <div class="col-sm-5" style="margin-top: -30px;">
                      <p class="form-control-static" id="">
                        <div class="card" style="margin: 5px 0;">
                          <div class="card-body" style="padding: 0.5rem;">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="eauction_inp" name="eauction_inp" value="1" <?php echo $curval > 0 ? 'checked' : ''?> >
                              <label class="custom-control-label pt-2" for="eauction_inp">E - Auction</label>
                            </div>
                          </div>
                        </div>
                      </p>
                    </div>
                  </div>

                  <div class="row form-group">
                    <label class="col-sm-4 control-label text-left" style="line-height: 12px;"><b>Preferensi Penilaian UMKM</b></label>
                    <div class="col-sm-5" style="margin-top: -30px;">
                      <p class="form-control-static" id="">
                        <div class="card" style="margin: 5px 0;">
                          <div class="card-body" style="padding: 0.5rem;">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="penilaian" name="penilaian_umkm_inp" value="Penilaian UMKM">
                              <label class="custom-control-label pt-2" for="penilaian">Preferensi UMKM</label>
                            </div>
                          </div>
                        </div>
                      </p>
                    </div>
                  </div>                      
                  
                  <div class="row form-group">
                    <label class="col-sm-4 control-label text-left" style="line-height: 12px;"><b>USKEP Online</b></label>
                    <div class="col-sm-5" style="margin-top: -30px;">
                      <p class="form-control-static" id="">
                        <div class="card" style="margin: 5px 0;">
                          <div class="card-body" style="padding: 0.5rem;">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="ptm_is_uskep_online" name="ptm_is_uskep_online" value="1">
                              <label class="custom-control-label pt-2" for="ptm_is_uskep_online"></label>
                            </div>
                          </div>
                        </div>
                      </p>
                    </div>
                  </div>                      

                  <?php } ?>

                  <?php 
                  if ($permintaan['ptm_type_of_plan'] == 'rkp_matgis') {
                    ?>
                    <div class="row form-group">
                    <label class="col-sm-4 control-label text-left" style="line-height: 12px;"><b>Jenis Matgis</b></label>
                    <div class="col-sm-5">
                      <p class="form-control-static" id="deskripsi_pekerjaan">: <?= $is_matgis['pr_jenis_kontrak'] ?></p>
                    </div>
                  </div>
                  <?php
                  }
                  ?>

                  <?php if ($activity_id >= 1141) { ?>
                    <div class="row form-group">
                      
                      <label class="col-sm-4 control-label">Tipe Pemenang</label>
                      <div class="col-sm-8">
                        <div class="">
                          <?php
                          $curval = $permintaan["ptm_winner"];
                          ?>
                          <?php if($curval == "1"){
                            $mustCheckWinner = "checked";
                            $mustCheckWinner2 = "";
                          } else if ($curval == "2") {
                            $mustCheckWinner = "";
                            $mustCheckWinner2 = "checked";
                          } else {
                            $mustCheckWinner = "checked";
                            $mustCheckWinner2 = "";
                          }?>
                          <div class="i-checks col-md-4">
                            <label class="">
                              <div class="iradio_square-green mustCheckWinner <?php echo $mustCheckWinner?>" style="position: relative;">
                                <input type="radio" value="1" name="winner_type_inp" id="tipe" style="position: absolute; opacity: 0;" checked="">
                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                              </div> <i style="line-height: 20px;"> Single Winner</i>
                            </label>
                          </div>

                          <div class="i-checks col-md-5">
                            <label class="">
                              <div class="iradio_square-green mustCheckWinner2 <?php echo $mustCheckWinner2 ?> " style="position: relative;">
                                <input type="radio" value="2" name="winner_type_inp" id="tipe" style="position: absolute; opacity: 0;">
                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                              </div> <i style="line-height: 20px;"> Multiple Winner</i>
                            </label>
                          </div>

                        </div>
                      </div>

                    </div>
                  <?php } ?>

                </div> <!-- end-col-5 -->
            </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script type="text/javascript">

  $('[name="ctr_down_payment"]').change(function (e) { 
    e.preventDefault();
    if($(this).val() != "")
    {
      $('[name="ctr_down_payment_date"]').removeAttr("disabled");
    } else {
      $('[name="ctr_down_payment_date"]').attr("disabled",true);
    }
    
  });
function valid_date_dp() {
    let dp = $('[name="ctr_down_payment_date"]').val()
    let aw = $('[name="start_date"]').val()
    let ak = $('[name="end_date"]').val()

    if (dp != '') {
        if ((aw != '') || (ak != '')) {
            if ((dp > aw) || (dp > ak)) {
                alert('Tanggal DP tidak boleh lebih besar dari tanggal awal dan akhir kontrak!')
                $('[name="ctr_down_payment_date"]').val('')
            }
        }
    }
}


function valid_date_aw() {
    let dp = $('[name="ctr_down_payment_date"]').val()
    let aw = $('[name="start_date"]').val()
    let ak = $('[name="end_date"]').val()

    if (aw != '') {
        if ((dp != '') || (ak != '')) {
            if ((dp > aw) || (aw > ak)) {
                alert('Tanggal awal kontrak tidak boleh lebih kecil dari tanggal dp dan tidak boleh lebih besar dari tanggal akhir kontrak!')
                $('[name="start_date"]').val('')
            }
        }
    }
}

function valid_date_ak() {
    let dp = $('[name="ctr_down_payment_date"]').val()
    let aw = $('[name="start_date"]').val()
    let ak = $('[name="end_date"]').val()

    if (ak != '') {
        if ((aw != '') || (dp != '')) {
            if ((ak < aw) || (dp > ak)) {
                alert('Tanggal akhir kontrak tidak boleh lebih kecil dari tanggal awal kontrak dan tanggal dp!')
                $('[name="end_date"]').val('')
            }
        }
    }
}


  $(document).ready(function(){

    function check_plan_tender(){
      var id = $("#perencanaan_pengadaan_inp").val();
      var url = "<?php echo site_url('Procurement/data_perencanaan_pengadaan') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#nama_pekerjaan").text(mydata.ppm_subject_of_work);
          $("#deskripsi_pekerjaan").text(mydata.ppm_scope_of_work);
          $("#mata_anggaran").text(mydata.ppm_mata_anggaran+" - "+mydata.ppm_nama_mata_anggaran);
          $("#sub_mata_anggaran").text(mydata.ppm_sub_mata_anggaran+" - "+mydata.ppm_nama_sub_mata_anggaran);
          $("#pagu_anggaran").text(mydata.ppm_pagu_anggaran);
          $("#sisa_anggaran").text(mydata.ppm_sisa_anggaran);
        }
      });
    }

    $(document.body).on("change","#perencanaan_pengadaan_inp",function(){

      check_plan_tender();

    });

  });
///////////////////////////////////////////////////////
$('input[type=checkbox][data-tipe=sw]').change(function() {
  if ($(this).is(':checked')) {
    $('.mustCheckWinner').addClass('checked');
    $('.mustCheckWinner2').removeClass('checked');
    $('input[type=checkbox][data-tipe=mw]').attr("checked",false);
  } else {
   $('.mustCheckWinner').removeClass('checked');
 }
});

$('input[type=checkbox][data-tipe=mw]').change(function() {
  if ($(this).is(':checked')) {
    $('.mustCheckWinner2').addClass('checked');
    $('.mustCheckWinner').removeClass('checked');
    $('input[type=checkbox][data-tipe=sw]').attr("checked",false);
  } else {
   $('.mustCheckWinner2').removeClass('checked');
 }
});

<?php if($permintaan["ptm_status"] == 1141){ ?>
  $("#formtender").submit(function(e){
    var win;
    win = $("input[name='winner_type_inp']:checked").val();
    console.log(win);
    if(win == null ){
      alert("Tipe pemenang harus dipilih")
      e.preventDefault()
      $('html, body').animate({
        scrollTop: $("#chatBtn").offset().top
      }, 1000)
    }
  });
<?php } ?>

</script>
