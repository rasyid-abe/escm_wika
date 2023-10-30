<style>
  .perencanaan-pengadaan-inp-c {
    position: absolute;
    top: 6%;
    right: 4%;
    background-color: #f7f7f8;
    color: #000;
    border: #e0e0e0;
    padding: 2px 17px;
  }

  .perencanaan-pengadaan-inp-c:hover {
    background-color: #f7f7f8;
    color: #000;
  }

  .perencanaan-pengadaan-inp-c:active {
    background-color: #f7f7f8;
    color: #000;
  }

  .form-group {
    margin-bottom: 0;
  }

  .bg-transparent {
    background-color: transparent;
    box-shadow: none;
  }
</style>
<div class="row">
  <div class="col-12">
    <div class="card bg-transparent">
      <div class="card-content">
        <div class="card-body">
          <h4 class="card-title mb-3">Detail Paket</h4>

          <div class="row">
            <!-- left side -->
            <div class="col-md">
              <div class="col-md-12 form-group row"> <?php $curval = (isset($pr_main['pr_number'])) ? $pr_main['pr_number'] : "AUTO"; ?>
                <label class="col-sm-4 control-label">Nomor Paket</label>
                <div class="col-sm-8">
                  <p class="form-control-static"> : <?php echo $curval ?> </p>
                  <input type="hidden" name="pr_number" id="pr_number" value="<?php echo $curval ?>" readonly>
                  <input type="hidden" name="ppm_id" value="<?php echo $pr_main["ppm_id"] ?>" readonly>
                </div>
              </div>
              <div class="col-md-12 form-group row"> <?php $curval = (isset($pr_main['pr_requester_name'])) ? $pr_main['pr_requester_name'] : $userdata['complete_name']; ?>
                <label class="col-sm-4 control-label">Buyer</label>
                <div class="col-sm-8">
                  <p class="form-control-static"> : <?php echo $curval ?> </p>
                </div>
              </div>
              <div class="col-md-12 form-group row"> <?php $curval = (isset($pr_main['pr_dept_name'])) ? $pr_main['pr_dept_name'] : $pos['dept_name']; ?>
                <label class="col-sm-4 control-label">Divisi/Departemen</label>
                <div class="col-sm-8">
                  <p class="form-control-static"> : <?php echo $curval ?> </p>
                </div>
              </div>
              <div class="col-md-12 form-group row mb-1"> <?php $curval = (isset($pr_main['pr_requester_name'])) ? $pr_main['pr_requester_name'] : $userdata['complete_name']; ?>
                <label class="col-sm-4 control-label">Tipe Pengadaan <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8"> <?php
                  $curval = '';
                  if(substr($pr_item_row['ppi_code'],0,1) == 'A') {
                    $curval = 'barang';
                  }

                  if(substr($pr_item_row['ppi_code'],0,1) == 'C' || substr($pr_item_row['ppi_code'],0,1) == 'D' || substr($pr_item_row['ppi_code'],0,1) == 'E') {
                    $curval = 'jasa';
                  }

                  if(substr($pr_item_row['ppi_code'],0,1) == 'F' || substr($pr_item_row['ppi_code'],0,1) == 'S') {
                    $curval = 'asset';
                  } ?>
                  <input type="hidden" name="tipe_pengadaan" id="tipe_pengadaan" value="<?php echo strtoupper($curval); ?>" readonly>
                  <p class="form-control-static"> : <?php echo strtoupper($curval); ?> </p>
                </div>
              </div>
              <div class="col-md-12 form-group row mb-1 proyek">
                <?php $curval = (isset($pr_main['pr_subject_of_work'])) ? $pr_main["pr_subject_of_work"] : set_value("nama_pekerjaan"); ?>
                <label class="col-sm-4 control-label">Proyek <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8 position-relative">
                  <div class="is_sap">
                    <input type="hidden" name="nama_pekerjaan" id="nama_pekerjaan" value="<?php echo $curval ?>" readonly>
                    <p class="form-control-static"> : <?php echo $curval; ?> </p>
                  </div>
                  <?php $curval = (isset($pr_main['ppm_id'])) ?  $pr_main["ppm_id"] : set_value("perencanaan_pengadaan_inp"); ?>
                  <input type="hidden" name="perencanaan_pengadaan_inp" required="true" value="<?php echo $curval ?>" id="perencanaan_pengadaan_inp" />
                </div>
              </div>
              <!-- end -->
              <div class="form-group row col-md-12">
                <label class="col-sm-4 control-label text-bold-700">Tipe PO <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8 styleSelect">
                    <select class="form-control bg-select" required name="pr_doc_type" value="<?php echo $curval ?>">
                        <option value="" selected disabled>Pilih Tipe PO</option>
                        <?php
                          $type_po = 'ZW01';
                          if ($pr_main['pr_dept_id'] == 48) {
                            $type_po = 'ZW03';
                          }
                          foreach ($doc_type as $k => $v): ?>
                            <option value="<?php echo $v['code']; ?>" <?php echo $type_po == $v['code'] ? 'selected' : ''; ?> ><?php echo $v['code'].' - '.$v['description'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                </div>
              </div>
            </div>
            <!-- end left side -->

            <!-- right side -->
            <div class="col-md"> <?php
              $code = (isset($pr_main['pr_mata_anggaran']) && !empty($pr_main['pr_mata_anggaran'])) ? $pr_main['pr_mata_anggaran'] : null;
              $label = (isset($pr_main['pr_nama_mata_anggaran']) && !empty($pr_main['pr_nama_mata_anggaran'])) ? $pr_main['pr_nama_mata_anggaran'] : null;
              $curval = (!empty($code) && !empty($label)) ? $code . " " . $label : null;
              ?> <?php if (!empty($curval)) { ?> <div class="col-md-12 form-group">
                <label class="col-sm-4 control-label">Mata Anggaran</label>
                <div class="col-sm-8">
                  <p class="form-control-static" id="mata_anggaran"> <?php echo $curval ?> </p>
                </div>
              </div> <?php } ?> <?php

              $curval = null;
              if (isset($pr_main["pr_sub_mata_anggaran"]) and substr_count($pr_main["pr_sub_mata_anggaran"], " , ") >= 1) {
                $code = explode(" , ", $pr_main["pr_sub_mata_anggaran"]);
                $name = explode(" , ", $pr_main["pr_nama_sub_mata_anggaran"]);
                $curval = $pr_main["pr_sub_mata_anggaran"] . " - " . $pr_main["pr_nama_sub_mata_anggaran"];
              }
              ?> <?php if (!empty($curval)) { ?> <div class="col-md-12 form-group">
                <label class="col-sm-4 control-label">Sub Mata Anggaran *</label>
                <div class="col-sm-8">
                  <p class="form-control-static" id="sub_mata_anggaran"> <?php
                      if (isset($code)) {
                        foreach (array_combine($code, $name) as $code => $name) {
                          echo $code . ' - ' . $name . "
														<br/>";
                        }
                      } else {
                        echo $curval;
                      }
                      ?> </p>
                </div>
              </div> <?php } ?> <div class="col-md-12 form-group row" hidden> <?php $curval = (isset($pr_main['pr_pagu_anggaran'])) ? $pr_main["pr_pagu_anggaran"] : 0; ?> <label class="col-sm-4 control-label">Total Anggaran</label>
                <div class="col-sm-8">
                  <p class="form-control-static" id="pagu_anggaran"> : <?php echo inttomoney($curval) ?> </p>
                </div>
              </div> <?php $curval = (isset($pr_main['pr_sisa_anggaran'])) ? $pr_main['pr_sisa_anggaran'] : 0 ?>
              <div class="col-md-12 form-group row" hidden>
                <label class="col-sm-4 control-label">Sisa Anggaran</label>
                <div class="col-sm-8">
                  <p class="form-control-static" id="sisa_anggaran"> : <?php echo inttomoney($curval) ?> </p>
                </div>
              </div> <?php $curvalAwal = (isset($pr_main["pr_jadwal_pengadaan_awal"])) ? date("Y-m-d", strtotime($pr_main["pr_jadwal_pengadaan_awal"])) : '' ?> <?php $curvalAkhir = (isset($pr_main["pr_jadwal_pengadaan_akhir"])) ? date("Y-m-d", strtotime($pr_main["pr_jadwal_pengadaan_akhir"])) : '' ?> <div class="form-group col-md-12 mb-1 row">
                <label class="col-sm-4 control-label text-bold-700">Jadwal Rencana Pengadaan <span class="text-danger text-bold-700">*</span>
                </label>
                <div class="col-sm-8">
                  <div class="input-group date align-items-center">
                    <input type="date" name="tgl_mulai_inp" required class="form-control mr-1" value="<?php echo $curvalAwal ?>"> s/d <input type="date" name="tgl_akhir_inp" required class="form-control ml-1" onchange="validateJadwal()" value="<?php echo $curvalAkhir ?>">
                  </div>
                </div>
              </div>
              <div class="form-group col-md-12 mb-1 row">
                <label class="col-sm-4 control-label text-bold-700">Metode Pengadaan <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group date align-items-center"> <?php
                    $metode_pengadaan = [
                      ['val' => 'Tender Umum', 'text' => 'Tender Umum'],
                      ['val' => 'Tender Terbatas', 'text' => 'Tender Terbatas'],
                      ['val' => 'Penunjukan Langsung', 'text' => 'Penunjukan Langsung']
                    ];
                    $curval = (isset($pr_main['pr_metode_pengadaan'])) ? $pr_main['pr_metode_pengadaan'] : '';
                    ?> <select class="form-control bg-select" name="metode_pengadaan" id="metode_pengadaan" required>
                      <option value="">Pilih metode pengadaan</option> <?php foreach ($metode_pengadaan as $key => $value) {
                        $selected = ($curval == $value['val']) ? "selected" : "";
                      ?> <option <?php echo $selected ?> value="<?php echo $value['val'] ?>"> <?php echo $value['text'] ?> </option> <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-12 mb-1 row">

              </div>
              <div class="form-group col-md-12 mb-1 row">
                  <label class="col-sm-4 control-label">Tipe Pengadaan <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                      <?php $curval = (isset($pr_main['pr_tipe_pengadaan'])) ? $pr_main['pr_tipe_pengadaan'] : ''; ?>
                    <select class="form-control bg-select" name="tipe_pengadaan_kew" id="tipe_pengadaan_kew" required>
                        <option value="">Pilih</option>
                        <option value="proyek" <?= $curval == 'proyek' ? 'selected' : '' ?>>Proyek</option>
                        <option value="non-proyek" <?= $curval == 'non-proyek' ? 'selected' : '' ?>>Non Proyek</option>
                    </select>
                  </div>
              </div>
              <div class="form-group col-md-12 mb-1 row">
                  <label class="col-sm-4 control-label">Category Management <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                      <?php $curval = (isset($pr_main['pr_cat_management'])) ? $pr_main['pr_cat_management'] : ''; ?>
                    <select class="form-control bg-select" name="cat_management_kew" id="cat_management_kew" required>
                        <option value="">Pilih</option>
                        <option value=1 <?= $curval == 1 ? 'selected' : '' ?>>Ya</option>
                        <option value=0 <?= $curval == 0 ? 'selected' : '' ?>>Tidak</option>
                    </select>
                  </div>
              </div>
              <div class="form-group col-md-12 mb-1 row">
                  <label class="col-sm-4 control-label">Jenis Pengadaan <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                      <?php $curval = (isset($pr_main['pr_jns_pengadaan'])) ? $pr_main['pr_jns_pengadaan'] : ''; ?>
                    <select class="form-control bg-select" name="jns_pengadaan_kew" id="jns_pengadaan_kew" required>
                        <option value="">Pilih</option>
                        <option value="oa" <?= $curval == 'oa' ? 'selected' : '' ?>>Matgis Kontrak Payung (OA)</option>
                        <option value="non-oa" <?= $curval == 'non-oa' ? 'selected' : '' ?>>Matgis Kontrak Spot (Non-OA)</option>
                    </select>
                  </div>
              </div>
              <div class="form-group col-md-12 mb-1 row">
                  <label class="col-sm-4 control-label">Nilai Pengadaan <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                      <?php $curval = (isset($pr_main['pr_nilai_pengadaan'])) ? $pr_main['pr_nilai_pengadaan'] : ''; ?>
                    <select class="form-control bg-select" name="nilai_pengadaan_kew" id="nilai_pengadaan_kew" required>
                        <option value="">Pilih</option>
                        <option value="kecil" <?= $curval == 'kecil' ? 'selected' : '' ?>>Kecil</option>
                        <option value="menengah" <?= $curval == 'menengah' ? 'selected' : '' ?>>Menengah</option>
                        <option value="besar" <?= $curval == 'besar' ? 'selected' : '' ?>>Besar</option>
                    </select>
                  </div>
              </div>
            </div>
            <!-- end right side -->

            <div class="col-md-12 form-group mb-1 mt-2"> <?php $curval = (isset($pr_main['pr_packet'])) ?  $pr_main["pr_packet"] : set_value("nama_paket"); ?>
              <label class="col-sm-2 control-label">Nama Paket Pengadaan <span class="text-danger text-bold-700">*</span></label>
              <div class="col-sm-10  pr-4" id="nama_paket_div" style="padding-left: 0;">
                <input type="text" class="form-control" name="nama_paket" id="nama_paket" required="true" value="<?php echo $curval ?>">
              </div>
            </div>
          </div>

          <!-- HLMIFZI -->
          <div class="row form-group" hidden>
            <label class="col-sm-2 control-label">Pembelian Langsung/Swakelola </label>
            <div class="col-sm-10">
              <div class=""> <?php $curval = set_value("swakelola_inp"); ?> <input type="checkbox" onclick="swakelola_confirm()" class="" name="swakelola_inp" id="swakelola_inp" value="1">
              </div>
            </div>
          </div>
          <div class="row form-group" hidden="hidden"> <?php $curval = (isset($pr_main['pr_scope_of_work'])) ? $pr_main["pr_scope_of_work"] : set_value("deskripsi_pekerjaan"); ?> <label class="col-sm-2 control-label">Deskripsi Pekerjaan</label>
            <div class="col-sm-10">
              <textarea type="text" class="form-control" id="deskripsi_pekerjaan" required="true" name="deskripsi_pekerjaan" readonly>
                <?php echo $curval ?>
              </textarea>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    <?php if (isset($pr_main['pr_project_name'])) { ?>
    <?php  } else { ?>
      $("#nama_proyek_div").hide();
      $("#kode_spk_div").hide();
    <?php } ?>
    var item_int_btn_url = "<?php echo site_url('procurement/get_picker_sumberdaya_sap') ?>";
    if ($('#kode_spk').val() != '') {
      $('#item_int_btn').attr('data-url', item_int_btn_url + "?spk_code=" + $("#kode_spk").val())
    }

    function check_plan_tender() {
      var id = $("#perencanaan_pengadaan_inp").val();
      var url = "<?php echo site_url('Procurement/data_perencanaan_pengadaan') ?>";
      var spk_code = "";
      $.ajax({
        url: url + "?id=" + id,
        dataType: "json",
        success: function(data) {
          var mydata = data.rows[0];
          $('#item_int_btn').attr('data-url', item_int_btn_url)
          $("#nama_pekerjaan").val(mydata.ppm_project_id + ' - ' + mydata.ppm_subject_of_work);
          $("#deskripsi_pekerjaan").val(mydata.ppm_scope_of_work);
          $("#mata_anggaran").text(mydata.ppm_mata_anggaran + " - " + mydata.ppm_nama_mata_anggaran);

          if (mydata.ppm_sub_mata_anggaran == 0) {
            getProjectCost(id);
          } else {
            var sub_mata_anggaran = mydata.ppm_sub_mata_anggaran + " - " + mydata.ppm_nama_sub_mata_anggaran;
            $("#sub_mata_anggaran").html(sub_mata_anggaran);
          }

          $("#pagu_anggaran,#total_pagu").text(mydata.ppm_pagu_anggaran);
          $("#sisa_anggaran,#sisa_pagu").text(mydata.ppm_sisa_anggaran);
          $("#total_pagu_inp").val(moneytoint(mydata.ppm_pagu_anggaran));
          $("#total_sisa_inp").val(moneytoint(mydata.ppm_sisa_anggaran));
          $("#sisa_pagu_awal_inp").val(moneytoint(mydata.ppm_pagu_anggaran));

          if (mydata.ppm_project_id != null) {
            $("#nama_proyek").val(mydata.ppm_subject_of_work);
            $("#nama_pekerjaan").val(mydata.ppm_project_id + ' - ' + mydata.ppm_subject_of_work);
            $("#kode_spk").val(mydata.ppm_project_id);
            $('#item_int_btn').attr('data-url', item_int_btn_url + "?spk_code=" + $("#kode_spk").val())
          } else {
            $("#nama_proyek_div").hide();
            $("#kode_spk_div").hide();
          }

          if (mydata.ppm_is_integrated == 1) {
            $('.not_integrated').hide();
            $('.integrated').show();
          } else {
            $('.integrated').hide();
            $('.not_integrated').show();
          }

          if (mydata.ppm_kode_rencana != null) {
            $.ajax({
              url: "<?php echo site_url('Procurement/daftar_paket_pengadaan') ?>" + "?program_code=" + mydata.ppm_kode_rencana,
              dataType: "json",
              success: function(data) {
                var drpdownhtml = "";
                $.each(data.rows, function(i, val) {

                  drpdownhtml += "<option value='" + val.pps_paket_pengadaan_name + "'>" + val.pps_paket_pengadaan_name + "</option>";

                });
                var selecthtml = "<select class='form-control' name='nama_paket' id='nama_paket' required='true'>" + drpdownhtml + "</select>";
                $('#nama_paket_div').html(selecthtml);
                $('#nama_paket_div').removeClass("col-sm-8");
                $('#nama_paket_div').addClass("col-sm-5");
              }
            })
          } else {
            var htmlnamapr = "<input type='text' class='form-control' name='nama_paket' id='nama_paket' required='true' value='<?php echo $curval ?>'>";
            $('#nama_paket_div').html(htmlnamapr);
            $('#nama_paket_div').removeClass("col-sm-5");
            $('#nama_paket_div').addClass("col-sm-8");

          }
        }
      });
    }

    function getProjectCost(id) {
      $.ajax({
        url: "<?php echo site_url('Procurement/perencanaan_pengadaan/get_project_cost') ?>" + "?ppm_id=" + id,
        dataType: "json",
        success: function(data) {
          var mata_anggaran = "";
          $.each(data.rows, function(i, val) {

            mata_anggaran += val.coa_code + " " + val.coa_name + "<br/>";

          });

          $("#sub_mata_anggaran").html(mata_anggaran);
        }
      })
    }

    $('.integrated').hide();

    $(document.body).on("change", "#perencanaan_pengadaan_inp", function() {

      check_plan_tender();

    });

  });

  function validateJadwal() {
    let awal = $("input[name='tgl_mulai_inp']").val();
    let akhir = $("input[name='tgl_akhir_inp']").val();

    if (akhir == awal || awal < akhir) {
      return true;
    } else {
      alert("Jadwal Rencana Pengadaan akhir tidak boleh kurang dari rencana awal!")
      $("input[name='tgl_akhir_inp']").val("");
    }
  }

  function swakelola_confirm() {

    if ($('[name=swakelola_inp]')[0].checked == true) {

      if (confirm('Anda yakin untuk melakukan pembelian langsung bukan melalui pelelangan/RFQ?')) {
        $('[name=swakelola_inp]').prop('checked', true);
      } else {
        $('[name=swakelola_inp]').prop('checked', false);

      }

    }

  }

  function joinpr_confirm() {

    if ($('[name=joinpr]')[0].checked == true) {

      if (confirm('Anda yakin akan join paket pengadaan?')) {
        $('[name=joinpr]').prop('checked', true);
      } else {
        $('[name=joinpr]').prop('checked', false);

      }

    }

  }

</script>
