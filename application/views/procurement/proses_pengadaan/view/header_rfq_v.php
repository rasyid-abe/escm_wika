<style>
select.form-control {
  background-color: #2aace3;
  color: #fff;
  font-family: 'Poppins', sans-serif;
  border-radius: 10px;
}
form label, .form-group label {
  font-size: 10px;
}
.card {
  border-radius: 0.75rem;
}
</style>
<div class="row">
  <div class="col-12">
    <div class="pt-2">

      <div class="">
          <h4 class="card-title mb-1"><b>Paket Pengadaan Proyek</b></h4>
      </div>

      <div class="card-content">
        <div class="card-body" style="line-height:0 !important;margin-bottom: -30px;">
          <div class="row">
              <div class="col-md-7">
                  <div class="card-content">
                    <div class="row form-group">
                      <label class="col-sm-4 control-label text-left"><b>Nomor Tender</b></label>
                      <div class="col-sm-8">
                        <a class="form-control-static no_tender" style="color: #2aace3;">: <?php echo $permintaan['ptm_number'] ?></a>
                      </div>
                    </div>

                    <div class="row form-group mt-3">
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
                        <div class="row form-group mb-2">
                          <label class="col-sm-4 control-label text-left"><b>Nama Paket Pengadaan</b></label>
                          <div class="col-sm-8">
                            <p class="form-control-static" id="nama_paket" style="line-height:20px;margin-top:-10px;">: <?php echo$permintaan['ptm_packet'] ?></p>
                          </div>
                        </div>
                    <?php } ?>

                    <div class="row form-group mb-2">
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
                      </div>
                    </div>

                    <?php if($activity_id > 1030){ ?>
                      <div class="row form-group">
                        <label class="col-sm-4 control-label text-left"><b>Jenis Kontrak</b></label>
                        <div class="col-sm-3" style="margin-top: -15px;">
                          <select class="form-control" id="ptm_contract_type_inp" name="ptm_contract_type_inp" disabled style="background-color: #60d0ff;">
                            <option value="">== Pilih ==</option>                            
                            <option value="LUMPSUM" <?php if($permintaan["ptm_contract_type"] == "LUMPSUM"){echo"selected";}?>>LUMPSUM</option>
                            <option value="HARGA SATUAN" <?php if($permintaan["ptm_contract_type"] == "HARGA SATUAN"){echo"selected";}?>>HARGA SATUAN</option>
                          </select>
                        </div>
                      </div>
                    <?php } ?>
                    <?php $curval = $prep["ptp_padi_umkm"]; ?>
                    <div class="row form-group">
                      <label class="col-sm-4 control-label text-left"><b>Share Pengumuman Tender</b></label>
                      <div class="col-sm-8">
                        <div class="form-control-static">
                          <div class="row" style="margin-top: -15px;">
                            <div class="col-sm-4">
                              <div class="card" style="margin: 5px 0;">
                                <div class="card-body" style="padding: 0.5rem;">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" <?php ($curval > 0) ? print('checked disabled') : print('disabled') ?>>
                                    <label class="custom-control-label pt-2" for="customSwitch1">Padi UMKM</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php $curval = $prep["ptp_pengadaan_com"]; ?>
                            <div class="col-sm-4" style="width: 35%;padding-left:0px;padding-right:0px;">
                              <div class="card" style="margin: 5px 0;">
                                <div class="card-body" style="padding: 0.5rem;">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch2" <?php ($curval > 0) ? print('checked disabled') : print('disabled') ?>>
                                    <label class="custom-control-label pt-2" for="customSwitch2">Pengadaan.com</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php $curval = $prep["ptp_partai_wika"]; ?>
                            <div class="col-sm-4">
                              <div class="card" style="margin: 5px 0;">
                                <div class="card-body" style="padding: 0.5rem;">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch3" <?php ($curval > 0) ? print('checked disabled') : print('disabled') ?>>
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

                <?php if($permintaan['is_sap'] == '1') { ?>
                    <?php $curval = (isset($permintaan['ptm_doc_type_sap'])) ? $permintaan["ptm_doc_type_sap"] : set_value("ptm_doc_type_sap"); ?>

                    <div class="row form-group">
                      <label class="col-sm-4 control-label text-bold-700">Tipe PO</label>
                      <div class="col-sm-8">                        
                          <p class="form-control-static" >: <?php echo $doc_type_select['code'].' - '.$doc_type_select['description'] ?></p>        
                          <input type="hidden" name="ptm_doc_type_sap" value="<?php echo $doc_type_select['code'] ?>" />                
                      </div>
                    </div>

                    <?php $curval = (isset($tender['ctr_down_payment']) && !empty($tender['ctr_down_payment'])) ? $tender['ctr_down_payment'] : ""; ?>
                    <div class="row form-group">
                      <label class="col-sm-4 control-label text-bold-700">Persen DP</label>
                      <div class="col-sm-8">
                          <input type="number" max="100" name="ctr_down_payment" class="form-control" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($tender['ctr_down_payment_date']) && !empty($tender['ctr_down_payment_date'])) ?  date("Y-m-d", strtotime($tender["ctr_down_payment_date"])) : set_value("ctr_down_payment_date"); ?>
                    <div class="row form-group">
                        <label class="col-sm-4 control-label text-bold-700">Tanggal Akhir DP</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <input type="date" name="ctr_down_payment_date" class="form-control" value="<?php echo $curval ?>">
                            </div>
                        </div>
                    </div>

                <?php } ?>

                <?php if($tender['is_sap'] != '1') { ?>
                  <?php $curval = $permintaan['ptm_currency']; ?>
                  <div class="row form-group">
                    <label class="col-sm-4 control-label text-left"><b>Mata Uang</b></label>
                    <div class="col-sm-8">
                    <p class="form-control-static">: <?php echo $curval ?></p>
                  </div>
                  </div>

                  <?php $curval = inttomoney($permintaan["ptm_pagu_anggaran"]); ?>
                  <div class="row form-group">
                    <label class="col-sm-4 control-label text-left"><b>Nilai Anggaran</b></label>
                    <div class="col-sm-8">
                      <p class="form-control-static" id="nama_paket" style="line-height:20px;margin-top:-10px;">: <?php echo $curval ?></p>
                    </div>
                  </div>

                  <?php $curval = inttomoney($permintaan["ptm_sisa_anggaran"]); ?>
                  <div class="row form-group">
                    <label class="col-sm-4 control-label text-left"><b>Nilai HPS</b></label>
                    <div class="col-sm-8">
                      <p class="form-control-static" id="sisa_anggaran">: <?php echo $curval ?></p>
                    </div>
                  </div>
                <?php } ?>

                <?php $curval = $prep["ptp_eauction"]; ?>
                  <div class="row form-group">
                  <label class="col-sm-4 control-label text-left" style="line-height: 12px;"><b>E - Auction</b></label>
                  <div class="col-sm-5" style="margin-top: -25px;">
                    <p class="form-control-static" id="">
                      <div class="card" style="margin: 5px 0;">
                        <div class="card-body" style="padding: 0.5rem;">
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="penilaian" <?php ($curval > 0) ? print('checked disabled') : print('disabled') ?>>
                            <label class="custom-control-label pt-2" for="penilaian">E - Auction</label>
                          </div>
                        </div>
                      </div>
                    </p>
                  </div>
                </div>

                <?php $curval = $prep["ptp_preferensi_umkm"]; ?>
                <div class="row form-group">
                  <label class="col-sm-4 control-label text-left" style="line-height: 12px;"><b>Preferensi Penilaian UMKM</b></label>
                  <div class="col-sm-5" style="margin-top: -25px;">
                    <p class="form-control-static" id="">
                      <div class="card" style="margin: 5px 0;">
                        <div class="card-body" style="padding: 0.5rem;">
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="penilaian" value="Penilaian UMKM" <?php ($curval > 0) ? print('checked disabled') : print('disabled') ?>>
                            <label class="custom-control-label pt-2" for="penilaian">Preferensi UMKM</label>
                          </div>
                        </div>
                      </div>
                    </p>
                  </div>
                </div>

                <?php $curval = $prep["ptm_is_uskep_online"]; ?>
                <div class="row form-group">
                    <label class="col-sm-4 control-label text-left" style="line-height: 12px;"><b>USKEP Online</b></label>
                    <div class="col-sm-5" style="margin-top: -30px;">
                      <p class="form-control-static" id="">
                        <div class="card" style="margin: 5px 0;">
                          <div class="card-body" style="padding: 0.5rem;">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="ptm_is_uskep_online" name="ptm_is_uskep_online" value="1" <?php ($curval > 0 && $activity_id >= 1132) ? print('checked disabled') : ($curval > 0 && $activity_id < 1132) ? print("checked") : "" ?>>
                              <label class="custom-control-label pt-2" for="ptm_is_uskep_online"></label>
                            </div>
                          </div>
                        </div>
                      </p>
                    </div>
                  </div>


                <?php } ?>

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
                        <div class="i-checks col-lg-3">
                          <label class="">
                            <div class="iradio_square-green mustCheckWinner <?php echo $mustCheckWinner?>" style="position: relative;">
                              <input type="radio" value="1" name="tipe_inp" id="tipe" style="position: absolute; opacity: 0;" checked="">
                              <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                            </div> <i style="line-height: 20px;"> Single Winner</i>
                          </label>
                        </div>

                        <div class="i-checks col-lg-3">
                          <label class="">
                            <div class="iradio_square-green mustCheckWinner2 <?php echo $mustCheckWinner2 ?> " style="position: relative;">
                              <input type="radio" value="2" name="tipe_inp" id="tipe" style="position: absolute; opacity: 0;">
                              <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                            </div> <i style="line-height: 20px;"> Multiple Winner</i>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
          </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
function printToPdf(){
    var css = '@page {size: auto; margin: 2 auto;}',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);

    window.print();
  }
</script>
