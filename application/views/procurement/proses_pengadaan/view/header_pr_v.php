<style>
  .form-group {
    margin-bottom: 0;
  }
  
  .bg-transparent {
    background-color: transparent;
    box-shadow: none;
  }
</style>

<?php if ($pr_main['pr_type'] == "MATERIAL STRATEGIS") {
  include(VIEWPATH . "procurement/proses_pengadaan/view/header_pr_matgis_v.php");
} else { ?>

  <div class="row">
    <div class="col-12">
      <div class="card bg-transparent">
        <div class="card-content">
          <div class="card-body">
              <h4 class="card-title mb-3">Detail Perencanaan</h4>

              <div class="row">
                <!-- left side -->
                <div class="col-md">
                  <div class="col-md-12 form-group row"> <?php $curval = (isset($pr_main['pr_number'])) ? $pr_main['pr_number'] : "AUTO"; ?>
                    <label class="col-sm-4 control-label">Nomor Perencanaan</label>
                    <div class="col-sm-8">
                      <p class="form-control-static"> : <?php echo $curval ?> </p>
                      <input type="hidden" name="pr_number" id="pr_number" value="<?php echo $curval ?>" readonly>
                      <input type="hidden" name="ppm_id" value="<?php echo $pr_main["ppm_id"] ?>" readonly>
                      <input type="hidden" name="pr_type_of_plan" value="<?php echo $pr_main["pr_type_of_plan"] ?>" readonly>
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
                    <label class="col-sm-4 control-label">Tipe Pengadaan </label>
                    <div class="col-sm-8"> <?php
                      $curval = '';
                      if(substr($pr_item_row['ppi_code'],0,1) == 'A') {
                        $curval = 'barang';
                      }

                      elseif(substr($pr_item_row['ppi_code'],0,1) == 'C' || substr($pr_item_row['ppi_code'],0,1) == 'D' || substr($pr_item_row['ppi_code'],0,1) == 'E') {
                        $curval = 'jasa';
                      }

                      elseif(substr($pr_item_row['ppi_code'],0,1) == 'F' || substr($pr_item_row['ppi_code'],0,1) == 'S') {
                        $curval = 'asset';
                      }
                      
                      else {
                        $curval = 'lainnya';
                      }
                      
                      ?>
                      <input type="hidden" name="tipe_pengadaan" id="tipe_pengadaan" value="<?php echo strtoupper($curval); ?>" readonly>
                      <p class="form-control-static"> : <?php echo strtoupper($curval); ?> </p>
                    </div>
                  </div>
                  <div class="col-md-12 form-group row mb-1 proyek">
                    <?php $curval = (isset($pr_main['pr_subject_of_work'])) ? $pr_main["pr_subject_of_work"] : set_value("nama_pekerjaan"); ?>
                    <label class="col-sm-4 control-label">Proyek </label>
                    <div class="col-sm-8 position-relative">
                      <div class="is_sap">
                        <input type="hidden" name="nama_pekerjaan" id="nama_pekerjaan" value="<?php echo $curval ?>" readonly>
                        <p class="form-control-static"> : <?php echo $curval; ?> </p>
                      </div>
                      <?php $curval = (isset($pr_main['ppm_id'])) ?  $pr_main["ppm_id"] : set_value("perencanaan_pengadaan_inp"); ?>
                      <input type="hidden" name="perencanaan_pengadaan_inp" value="<?php echo $curval ?>" id="perencanaan_pengadaan_inp" />
                    </div>
                  </div>
                  <!-- end -->
                  <div class="form-group row col-md-12">
                    <label class="col-sm-4 control-label text-bold-700">Tipe PO </label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-sm" name="pr_doc_type" value="<?php echo $curval ?>" disabled>
                            <option value="">Pilih Tipe PO</option>
                            <?php
                              $type_po = 'ZW01';
                              if ($pr_main['pr_dept_id'] == 48) {
                                $type_po = 'ZW03';
                              }
                              foreach ($doc_type as $k => $v): ?>
                                <option value="<?php echo $v['code']; ?>" <?php echo $type_po == $v['code'] ? 'selected' : ''; ?> ><?php echo $v['code'].' - '.$v['description'] ?></option>
                            <?php endforeach; ?>
                        </select>
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
                  </div>
                  <div class="form-group col-md-12 mb-1 row">

                  </div>
                  <div class="form-group col-md-12 mb-1 row">
                      <label class="col-sm-4 control-label">Tipe Proyek </label>
                      <div class="col-sm-8">
                        <?php $curval = (isset($pr_main['pr_tipe_pengadaan'])) ? $pr_main['pr_tipe_pengadaan'] : ''; ?>
                        <select class="form-control form-control-sm" name="tipe_pengadaan_kew" id="tipe_pengadaan_kew" disabled>
                            <option value="">Pilih</option>
                            <option value="proyek" <?php echo $curval == 'proyek' ? 'selected' : '' ?>>Proyek</option>
                            <option value="non-proyek" <?php echo $curval == 'non-proyek' ? 'selected' : '' ?>>Non Proyek</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group col-md-12 mb-1 row">
                      <label class="col-sm-4 control-label">Category Management </label>
                      <div class="col-sm-8">
                        <?php $curval = (isset($pr_main['pr_cat_management'])) ? $pr_main['pr_cat_management'] : ''; ?>
                        <select class="form-control form-control-sm" name="cat_management_kew" id="cat_management_kew" disabled>
                            <option value="">Pilih</option>
                            <option value=1 <?php echo $curval == 1 ? 'selected' : '' ?>>Ya</option>
                            <option value=0 <?php echo $curval == 0 ? 'selected' : '' ?>>Tidak</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group col-md-12 mb-1 row">
                      <label class="col-sm-4 control-label">Jenis Pengadaan </label>
                      <div class="col-sm-8">
                        <?php $curval = (isset($pr_main['pr_jns_pengadaan'])) ? $pr_main['pr_jns_pengadaan'] : ''; ?>
                        <select class="form-control form-control-sm" name="jns_pengadaan_kew" id="jns_pengadaan_kew" disabled>
                            <option value="">Pilih</option>
                            <option value="oa" <?php echo $curval == 'oa' ? 'selected' : '' ?>>Matgis Kontrak Payung (OA)</option>
                            <option value="non-oa" <?php echo $curval == 'non-oa' ? 'selected' : '' ?>>Matgis Kontrak Spot (Non-OA)</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group col-md-12 mb-1 row">
                      <label class="col-sm-4 control-label">Nilai Pengadaan </label>
                      <div class="col-sm-8">
                        <?php $curval = (isset($pr_main['pr_nilai_pengadaan'])) ? $pr_main['pr_nilai_pengadaan'] : ''; ?>
                        <select class="form-control form-control-sm" name="nilai_pengadaan_kew" id="nilai_pengadaan_kew" disabled>
                            <option value="">Pilih</option>
                            <option value="kecil" <?php echo $curval == 'kecil' ? 'selected' : '' ?>>Kecil</option>
                            <option value="menengah" <?php echo $curval == 'menengah' ? 'selected' : '' ?>>Menengah</option>
                            <option value="besar" <?php echo $curval == 'besar' ? 'selected' : '' ?>>Besar</option>
                        </select>
                      </div>
                  </div>
                </div>
                <!-- end right side -->
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
                <textarea type="text" class="form-control" id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" readonly>
                  <?php echo $curval ?>
                </textarea>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

<?php } ?>