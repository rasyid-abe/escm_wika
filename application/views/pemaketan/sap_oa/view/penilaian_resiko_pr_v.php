<style scoped>
  .btn-action-edit {
    border-radius: 8px 0 0 8px;
    width: 100px;
  }

  .btn-action-delete {
    border-radius: 0 8px 8px 0;
    background-color: rgb(36 36 36 / 22%);
    position: relative;
    left: -4px;
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

<div class="card">
  <div class="card-header">
    <span class="card-title">
      Penilaian Risiko Pekerjaan
      <img src="<?php echo base_url(); ?>/assets/icons/danger.png" alt="Danger Icon" class="image-fluid ml-1 mr-1" width="">
      <span class="bg-risiko">
        <span>
          Risiko
        </span>
        <span id="resiko_barang"></span>
      </span>
    </span>
  </div>
  <div class="card-body">
    <table class="table table-striped" id="category">
      <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Petunjuk Penilaian</th>
        <th>Nilai</th>
        <th>Bobot</th>
        <th>Nilai x Bobot</th>
      </tr>
      <?php foreach ($risiko as $key => $value) {
        $myId = $key + 1;
        if ($value['nilai_risiko'] != 0) {
      ?>
          <tr id="value">
            <td><?= $key + 1 ?></td>
            <td>
              <?= $value['category_risiko'] ?>
            </td>            
            <td>
              <button type="button" id="skalaResikoId" class="btn btn-info btn-sm rounded" data-toggle="popover" data-html=true data-placement="left" data-title="
                <div class='row' style='background-color: #2AACE3;'>
                  <div class='col-sm-2'>Nilai</div>
                  <div class='col-sm-10'>Skala Resiko</div>
                </div>" data-content="
                <div class='row'>
              <?php foreach ($skala_resiko_nilai as $k => $val) {
                if ($val['id_nilai_resiko'] === $value['id_risiko']) { ?>
                <div class='col-sm-2 border-bottom py-1 childed'><?= $val['nilai'] ?></div>
                <div class='col-sm-10 border-bottom py-1 childed'><?= $val['skala_resiko'] ?></div>
              <?php }
              } ?>
              </>">
                Skala Risiko
            </td>
            <td id="nilai_skala">
              <?= $value['nilai_risiko'] ?>
            </td>
            <td id="skala_bobot" class="bobot-<?= $myId ?>">
              <?= $value['bobot_risiko'] ?>
            </td>
            <td id="nilaixbobot" class="sum-<?= $myId ?>">
              <?= $value['total_nilai_bobot'] ?>
            </td>
          </tr>
      <?php
        }
      }  ?>
      <tr>
        <td colspan="2"></td>
        <td>Total</td>
        <td id="sumNilai">0</td>
        <td id="sumBobot">0</td>
        <td id="sumTotal">0</td>
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

  // sum bobot 
  var varSumBobot = 0;
  var tempSumBobot = [];
  var tempSumNilai = 0;
  var multipleNilai = 0;
  var totalValuesSum = 0;
  var sumNilai = 0;

  dataSumTable.each(function() {
    sumNilai += getnum($(this).find("td:eq(4)").text());
  });
  $('#sumNilai').text(sumNilai);

  dataSumTable.each(function() {
    varSumBobot += getnum($(this).find("td:eq(5)").text());
  });
  $('#sumBobot').text(varSumBobot);


  dataSumTable.each(function() {
    totalValuesSum += getnum($(this).find("td:eq(6)").text());
  });
  $('#sumTotal').text(totalValuesSum);

  if (totalValuesSum > 76) {
    $('#resiko_barang').html("Tinggi");
  } else if (totalValuesSum > 50 && totalValuesSum < 75) {
    $('#resiko_barang').html("Menengah");
  } else {
    $('#resiko_barang').html("Rendah");
  }

  $(document).ready(function() {
    $('[data-toggle="popover"]').popover();
  });
</script>