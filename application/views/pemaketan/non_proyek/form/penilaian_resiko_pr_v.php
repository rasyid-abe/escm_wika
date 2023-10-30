<style scoped>
  .btn-action-edit {
    border-radius: 8px 0 0 8px;
    width: 100px;
  }

  .bt-action-delete {
    border-radius: 0 8px 8px 0;
    background-color: rgb(36 36 36 / 22%);
    position: relative;
    left: 0;
  }

  .popover {
    min-width: 450px;
  }

  .popover-header {
    color: #ffffff;
    background-color: #2AACE3;
  }

  input[type="file"] {
    display: block;
  }

  .custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    cursor: pointer;
    margin-bottom: 0;
  }

  .childed:last-child {
    border-bottom: none !important;
  }

  .childed:nth-last-child(2) {
    border-bottom: none !important;
  }

  .bg-risiko {
    background-color: #ff5566;
    color: white;
    padding: 7px;
    border-radius: 8px;
  }
</style>

<div class="card" id="jenis_nilai_resiko_jasa" style="display: none;">
  <div class="card-header">
    <span class="card-title">
      Penilaian Risiko Jasa
      <img src="<?php echo base_url(); ?>/assets/icons/danger.png" alt="Danger Icon" class="image-fluid ml-1 mr-1" width="">
      <span class="bg-risiko">
        <span>
          Risiko
        </span>
        <span id="resiko_barang"></span>
        <input type="hidden" name="resiko_barang_inp" id="resiko_barang_inp">
      </span>
    </span>
  </div>
  <div class="card-body">
    <table class="table table-striped" id="category">
      <tr>
        <th>No</th>
        <th>Kategori</th>
        <th style="min-width: 300px;">Upload Lampiran</th>
        <!-- <th>Lampiran</th> -->
        <th>Petunjuk Penilaian</th>
        <th>Nilai</th>
        <th>Bobot</th>
        <th>Nilai x Bobot</th>
      </tr>
      <?php
      foreach ($skala_nilai_jasa as $key => $value) {
        $myId = $key + 1; ?>
        <tr id="value">
          <td>
            <?= $key + 1 ?>
            <input type="hidden" name="id_risiko[<?= $key ?>]" value="<?= $value['id'] ?>">
          </td>
          <td>
            <?= $value['kategori'] ?>
            <input type="hidden" name="kategori_resiko_jasa[<?= $key ?>]" value="<?= $value['kategori'] ?>">
          </td>
          <td>
            <span style="display: flex;">
              <?php $curval = set_value("doc_attachment_inp_drup_jasa_$key"); ?>
              <button type="button" style="max-width: 60px" data-id="doc_attachment_inp_drup_jasa_<?= $key ?>" data-folder="pemaketan" data-preview="preview_file_drup_<?= $key ?>" class="btn btn-info upload btn-sm btn-action-edit">
                <i class="fa fa-cloud-upload"></i> Up
              </button>
              <button type="button" style="border-radius: 0;" data-url="<?php echo site_url('log/download_attachment/pemaketan/' . $curval) ?>" class="btn btn-info btn-sm preview_upload" id="preview_file_drup_<?= $key ?>">
                <i class="fa fa-share"></i>
              </button>
              <input readonly type="text" style="max-width: 150px; border-radius: 0;" class="form-control" id="doc_attachment_inp_drup_jasa_<?= $key ?>" name="doc_attachment_inp_drup_jasa_<?= $key ?>" value="<?php echo $curval ?>">
              <button type="button" data-id="doc_attachment_inp_drup_jasa_<?= $key ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_drup_<?= $key ?>" class="btn btn-sm bt-action-delete removefile">
                <i class="fa fa-trash"></i>
              </button>
            </span>
          </td>
          <td>
            <button type="button" id="skalaResikoId" class="btn btn-info btn-sm rounded" data-toggle="popover" data-html=true data-placement="left" data-title="
            <div class='row' style='background-color: #2AACE3;'>
              <div class='col-sm-2'>Nilai</div>
              <div class='col-sm-10'>Skala Resiko</div>
            </div>" data-content="
            <div class='row'>
              <?php foreach ($skala_resiko_nilai as $k => $val) {
                if ($val['id_nilai_resiko'] === $value['id']) {
              ?>
                <div class='col-sm-2 border-bottom py-1 childed'><?= $val['nilai'] ?></div>
                  <div class='col-sm-10 border-bottom py-1 childed'>
                  <?php
                  $skalaResiko = explode("- ", $val['skala_resiko']);
                  foreach ($skalaResiko as $nilai) {
                    if ($nilai != '') { ?>
                      - <?= $nilai ?> <br>
                    <?php } else {
                      echo $nilai;
                    }
                    ?>
                    <?php
                  }
                    ?>
                  </div>
              <?php }
              } ?>
              </>">
              Skala Risiko
            </button>
          </td>
          <td id="nilai_skala">
            <select name="nilai_skala_resiko[<?= $key ?>]" id="nilai_skala_resiko" class="form-control form-control-sm" data-id="<?= $myId ?>">
              <option selected value="0">Pilih nilai</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </td>
          <td id="skala_bobot" class="bobot-<?= $myId ?>">
            <?= $value['bobot'] ?>
            <input type="hidden" name="bobot_jasa[<?= $key ?>]" value="<?= $value['bobot'] ?>">
          </td>
          <td id="nilaixbobot">
            <div class="sum-<?= $myId ?>">0</div>
            <input class="nilaixbobotto<?= $myId ?>" type="hidden" name="nilai_x_bobot[<?= $key ?>]" value="">
          </td>
        </tr>
      <?php } ?>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Total</td>
        <td id="sumNilai">0</td>
        <td id="sumBobot">0</td>
        <td id="sumTotal">0</td>
      </tr>
    </table>
  </div>
</div>

<div class="card" id="jenis_nilai_resiko_barang" style="display: none;">
  <div class="card-header">
    <span class="card-title">
      Penilaian Risiko Barang
      <img src="<?php echo base_url(); ?>/assets/icons/danger.png" alt="Danger Icon" class="image-fluid ml-1 mr-1" width="">
      <span class="bg-risiko">
        <span>
          Risiko
        </span>
        <span id="resiko_barang_barang"></span>
        <input type="hidden" name="resiko_barang_barang_inp" id="resiko_barang_barang_inp">
      </span>
    </span>
  </div>
  <div class="card-body">
    <table class="table table-striped" id="category_barang">
      <tr>
        <th>No</th>
        <th>Kategori</th>
        <th style="min-width: 260px;">Upload Lampiran</th>
        <th>Petunjuk Penilaian</th>
        <th>Nilai</th>
        <th>Bobot</th>
        <th>Nilai x Bobot</th>
      </tr>
      <?php
      foreach ($skala_nilai as $key => $value) {
        $myId = $key + 1; ?>
        <tr id="value">
          <td>
            <?= $key + 1 ?>
            <input type="hidden" name="id_risiko_barang[<?= $key ?>]" value="<?= $value['id'] ?>">
          </td>
          <td>
            <?= $value['kategori'] ?>
            <input type="hidden" name="kategori_resiko_jasa_barang[<?= $key ?>]" value="<?= $value['kategori'] ?>">
          </td>
          <td>
            <span style="display: flex;">
              <?php $curval = set_value("doc_attachment_inp_drup_barang_$key"); ?>
              <button type="button" style="max-width: 60px" data-id="doc_attachment_inp_drup_barang_<?= $key ?>" data-folder="pemaketan" data-preview="preview_file_barang_<?= $key ?>" class="btn btn-info upload btn-sm btn-action-edit">
                <i class="fa fa-cloud-upload"></i> Up
              </button>
              <button type="button" style="border-radius: 0;" data-url="<?php echo site_url('log/download_attachment/pemaketan/' . $curval) ?>" class="btn btn-info btn-sm preview_upload" id="preview_file_barang_<?= $key ?>">
                <i class="fa fa-share"></i>
              </button>
              <input readonly type="text" style="max-width: 150px; border-radius: 0;" class="form-control" id="doc_attachment_inp_drup_barang_<?= $key ?>" name="doc_attachment_inp_drup_barang_<?= $key ?>" value="<?php echo $curval ?>">
              <button type="button" data-id="doc_attachment_inp_drup_barang_<?= $key ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_barang_<?= $key ?>" class="btn btn-sm bt-action-delete removefile">
                <i class="fa fa-trash"></i>
              </button>
            </span>
          </td>
          <td>
            <button type="button" id="skalaResikoId" class="btn btn-info btn-sm rounded" data-toggle="popover" data-html=true data-placement="left" data-title="
            <div class='row' style='background-color: #2AACE3;'>
              <div class='col-sm-2'>Nilai</div>
              <div class='col-sm-10'>Skala Resiko</div>
            </div>" data-content="
            <div class='row'>
              <?php foreach ($skala_resiko_nilai as $k => $val) {
                if ($val['id_nilai_resiko'] === $value['id']) {
              ?>
                <div class='col-sm-2 border-bottom py-1 childed d-flex align-items-center justify-content-center'><?= $val['nilai'] ?></div>
                  <div class='col-sm-10 border-bottom py-1 childed'>
                  <?php
                  $skalaResiko = explode("- ", $val['skala_resiko']);
                  foreach ($skalaResiko as $nilai) {
                    if ($nilai != '') { ?>
                      - <?= $nilai ?> <br>
                    <?php } else {
                      echo $nilai;
                    }
                    ?>
                    <?php
                  }
                    ?>
                  </div>
              <?php }
              } ?>
              </>">
              Skala Risiko
            </button>
          </td>
          <td id="nilai_skala_barang">
            <select name="nilai_skala_resiko_barang[<?= $key ?>]" id="nilai_skala_resiko_barang" class="form-control form-control-sm" data-id="<?= $myId ?>">
              <option selected value="0">Pilih nilai</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </td>
          <td id="skala_bobot_barang" class="bobot_barang-<?= $myId ?>">
            <?= $value['bobot'] ?>
            <input type="hidden" name="bobot_jasa_barang[<?= $key ?>]" value="<?= $value['bobot'] ?>">
          </td>
          <td id="nilaixbobot_barang">
            <div class="sum_barang-<?= $myId ?>">0</div>
            <input class="nilaixbobotto_barang<?= $myId ?>" type="hidden" name="nilai_x_bobot_barang[<?= $key ?>]" value="">
          </td>
        </tr>
      <?php } ?>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Total</td>
        <td id="sumNilaiBarang">0</td>
        <td id="sumBobotBarang">0</td>
        <td id="sumTotalBarang">0</td>
      </tr>
    </table>
  </div>
</div>


<script>
  function getnum(t) {
    if (isNumeric(t)) {
      return parseInt(t, 10);
    }
    return 0;

    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
  }

  var dataSumTable = $("#category tr").not(':first').not(':last');
  var dataSumTableBarang = $("#category_barang tr").not(':first').not(':last');

  // sum bobot jasa
  var varSumBobot = 0;
  var tempSumBobot = [];
  var tempSumNilai = 0;
  var multipleNilai = 0;
  var totalValuesSum = 0;

  //sum for resiko barang
  var varSumBobotBarang = 0;
  var tempSumBobotBarang = [];
  var tempSumNilaiBarang = 0;
  var multipleNilaiBarang = 0;
  var totalValuesSumBarang = 0;

  dataSumTable.each(function() {
    varSumBobot += getnum($(this).find("td:eq(5)").text());
    tempSumBobot.push(getnum($(this).find("td:eq(5)").text()));
  });

  $("#sumBobot").text(varSumBobot);

  dataSumTableBarang.each(function() {
    varSumBobotBarang += getnum($(this).find("td:eq(5)").text());
    tempSumBobotBarang.push(getnum($(this).find("td:eq(5)").text()));
  });
  $("#sumBobotBarang").text(varSumBobotBarang);

  //sum nilai jasa
  $('table#category select[id=nilai_skala_resiko]').change(function(el) {
    var varSumNilai = 0;
    var varBobotNilai = 0;
    var indexEl;

    $('table#category select[id=nilai_skala_resiko]').each(function(index1, el1) {
      varSumNilai += parseInt($(el1).val());
      tempSumNilai = parseInt($(el1).val());

      multipleNilai = tempSumBobot[index1] * tempSumNilai
      $(".sum-" + (index1 + 1)).text(multipleNilai);
      $(".nilaixbobotto" + (index1 + 1)).val(multipleNilai);
    });

    $("#sumNilai").text(varSumNilai);

    // last total
    totalValuesSum = 0;
    dataSumTable.each(function() {
      totalValuesSum += getnum($(this).find("td:eq(6)").text());
    });
    $("#sumTotal").text(totalValuesSum);

    if (totalValuesSum > 76) {
      $('#resiko_barang_inp').val("Risiko Tinggi");
      $('#resiko_barang').html("Tinggi");
    } else if (totalValuesSum > 50 && totalValuesSum < 75) {
      $('#resiko_barang_inp').val("Risiko Menengah");
      $('#resiko_barang').html("Menengah");
    } else {
      $('#resiko_barang_inp').val("Risiko Rendah");
      $('#resiko_barang').html("Rendah");
    }
  });

  // sum nilai barang
  $('table#category_barang select[id=nilai_skala_resiko_barang]').change(function(el) {
    var varSumNilaiBarang = 0;

    $('table#category_barang select[id=nilai_skala_resiko_barang]').each(function(index1, el1) {
      varSumNilaiBarang += parseInt($(el1).val());
      tempSumNilaiBarang = parseInt($(el1).val());

      multipleNilaiBarang = tempSumBobotBarang[index1] * tempSumNilaiBarang
      $(".sum_barang-" + (index1 + 1)).text(multipleNilaiBarang);
      $(".nilaixbobotto_barang" + (index1 + 1)).val(multipleNilaiBarang);
    });

    $("#sumNilaiBarang").text(varSumNilaiBarang);

    // last total
    totalValuesSumBarang = 0;
    dataSumTableBarang.each(function() {
      totalValuesSumBarang += getnum($(this).find("td:eq(6)").text());
    });
    $("#sumTotalBarang").text(totalValuesSumBarang);

    if (totalValuesSumBarang > 76) {
      $('#resiko_barang_barang_inp').val("Risiko Tinggi");
      $('#resiko_barang_barang').html("Tinggi");
    } else if (totalValuesSumBarang > 50 && totalValuesSumBarang < 75) {
      $('#resiko_barang_barang_inp').val("Risiko Menengah");
      $('#resiko_barang_barang').html("Menengah");
    } else {
      $('#resiko_barang_barang_inp').val("Risiko Rendah");
      $('#resiko_barang_barang').html("Rendah");
    }
  });

  $(document).ready(function() {
    $('[data-toggle="popover"]').popover();
  });
</script>