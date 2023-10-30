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

  .wrapper-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
  }
</style>
<div class="row" id="sec-opp" style="display: none">
  <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <span class="wrapper-header">
            <div class="title-header d-flex align-items-center">
              <h4 class="card-title ">OPPORTUNITY</h4>
              <a onclick="isOpportunity()" class="btn btn-sm btn-info btn-tambah ml-2 rounded">
                <i class="ft ft-plus"></i>Tambah
              </a>
            </div>
            <div class="wrapper-button" id="btnOpportunity" style="display: none;">
              <span class="wrapper-action save-comment">
                <a class="btn btn-sm btn-info btn-action-edit" id="action_opportunity">Simpan</a>
                <a class="btn btn-sm btn-action-delete delete_item_opportunity">
                  <i class="fa fa-trash fa-lg"></i>
                </a>
                <input type="hidden" id="current_item_opportunity">
              </span>
            </div>
          </span>
          <div id="saveOpportunity" style="display: none;">
            <div class="row mb-2">
              <div class="col-md">
                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Pengusul</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="opp_pengusul" id="opp_pengusul" placeholder="Pengusul">
                  </div>
                </div>

                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Probabilitas</label>
                  <div class="col-md-8">
                    <select name="opp_propabilitas" id="opp_probabilitas" class="form-control bg-select">
                      <option value="">Pilih</option>
                      <option value="rendah">Rendah</option>
                      <option value="menengah">Menengah</option>
                      <option value="tinggi">Tinggi</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Area</label>
                  <div class="col-md-8">
                    <select name="opp_area" id="opp_area" class="form-control bg-select">
                      <option value="">Pilih</option>
                      <option value="biaya">Biaya</option>
                      <option value="mutu">Mutu</option>
                      <option value="waktu">Waktu</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Hambatan</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="opp_hambatan" id="opp_hambatan" placeholder="Hambatan">
                  </div>
                </div>
              </div>

              <div class="col-md row">
                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Opportunity</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="opp_opportunity" id="opp_opportunity" placeholder="Opportunity">
                  </div>
                </div>

                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Biaya</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control money" name="opp_biaya" id="opp_biaya" placeholder="Biaya">
                  </div>
                </div>

                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Benefit</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="opp_benefit" id="opp_benefit" placeholder="Benefit">
                  </div>
                </div>

                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-4 control-label">Nilai Benefit</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control money" name="opp_nilai_benefit" id="opp_nilai_benefit" placeholder="Nilai Benefit">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="row form-group col-md-12 mb-1">
                  <label class="col-md-2 control-label">Rencana Tindak Lanjut</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="opp_rtl" id="opp_rtl" placeholder="Rencana Tindak Lanjut">
                  </div>
                </div>
              </div>
            </div>
          </div>


          <table class="table table-striped" id="table_opportunity">
            <thead>
              <tr>
                <th>Pengusul</th>
                <th>Area</th>
                <th>Opportunity</th>
                <th>Benefit</th>
                <th>Nilai Benefit</th>
                <th>Probabilitas</th>
                <th>RTL</th>
                <th>Biaya</th>
                <th>Hambatan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (isset($opportunity)) {
                foreach ($opportunity as $k => $val) { ?>
                  <td><?= $val['pengusul'] ?></td>
                  <td><?= $val['area'] ?></td>
                  <td><?= $val['opportunity'] ?></td>
                  <td><?= $val['benefit'] ?></td>
                  <td><?= $val['nilai_benefit'] ?></td>
                  <td><?= $val['probabilitas'] ?></td>
                  <td><?= $val['rtl'] ?></td>
                  <td><?= $val['biaya'] ?></td>
                  <td><?= $val['hambatan'] ?></td>
                  <td><button type='button' class='btn btn-info btn-xs edit_item_opportunity' data-no='<?= ($k + 1) ?>'><i class='fa fa-edit'></i></button></td>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  function isOpportunity() {
    var div = document.getElementById("btnOpportunity");
    var smbd_save = document.getElementById("saveOpportunity");
    if (div.style.display !== "none") {
      div.style.display = "none";
      smbd_save.style.display = "none";
    } else {
      div.style.display = "flex";
      smbd_save.style.display = "block";
    }
  }

  $(document).ready(function() {
    $('#action_opportunity').click(function() {

      var current_item_opportunity = $('#current_item_opportunity').val();
      var no = current_item_opportunity;
      if (getMaxDataNo(".edit_item_opportunity") == null) {
        no = 0;
      } else {
        no = getMaxDataNo(".edit_item") + 1;
      }

      var opp_pengusul = $('#opp_pengusul').val();
      var opp_probabilitas = $('#opp_probabilitas').val();
      var opp_area = $('#opp_area').val();
      var opp_hambatan = $('#opp_hambatan').val();
      var opp_opportunity = $('#opp_opportunity').val();
      var opp_biaya = $('#opp_biaya').val();
      var opp_benefit = $('#opp_benefit').val();
      var opp_nilai_benefit = $('#opp_nilai_benefit').val();
      var opp_rtl = $('#opp_rtl').val();

      if (opp_pengusul == '' ||
        opp_probabilitas == '' ||
        opp_area == '' ||
        opp_hambatan == '' ||
        opp_opportunity == '' ||
        opp_biaya == '' ||
        opp_benefit == '' ||
        opp_nilai_benefit == '' ||
        opp_rtl == '') {
        alert("Semua inputan harus diisi!");
      } else {
        var html = "<tr><td><input type='hidden' class='pengusul' data-no='" + no + "' name='pengusul[" + no + "]' value='" + opp_pengusul + "'/>" + opp_pengusul + "</td>";
        html += "<td><input type='hidden' class='area' data-no='" + no + "' name='area[" + no + "]' value='" + opp_area + "'/>" + opp_area + "</td>";
        html += "<td><input type='hidden' class='opportunity' data-no='" + no + "' name='opportunity[" + no + "]' value='" + opp_opportunity + "'/>" + opp_opportunity + "</td>";
        html += "<td><input type='hidden' class='benefit' data-no='" + no + "' name='benefit[" + no + "]' value='" + opp_benefit + "'/>" + opp_benefit + "</td>";
        html += "<td><input type='hidden' class='nilai_benefit' data-no='" + no + "' name='nilai_benefit[" + no + "]' value='" + opp_nilai_benefit + "'/>" + opp_nilai_benefit + "</td>";
        html += "<td><input type='hidden' class='probabilitas' data-no='" + no + "' name='probabilitas[" + no + "]' value='" + opp_probabilitas + "'/>" + opp_probabilitas + "</td>";
        html += "<td><input type='hidden' class='rtl' data-no='" + no + "' name='rtl[" + no + "]' value='" + opp_rtl + "'/>" + opp_rtl + "</td>";
        html += "<td><input type='hidden' class='biaya' data-no='" + no + "' name='biaya[" + no + "]' value='" + opp_biaya + "'/>" + opp_biaya + "</td>";
        html += "<td><input type='hidden' class='hambatan' data-no='" + no + "' name='hambatan[" + no + "]' value='" + opp_hambatan + "'/>" + opp_hambatan + "</td>";
        html += "<td><button type='button' class='btn btn-info btn-xs edit_item_opportunity' data-no='" + no + "'><i class='fa fa-edit'></i></button></td>";
        html += "</tr>";

        $("#table_opportunity").append(html);

        $('#opp_pengusul').val("");
        $('#opp_probabilitas').val("");
        $('#opp_area').val("");
        $('#opp_hambatan').val("");
        $('#opp_opportunity').val("");
        $('#opp_biaya').val("");
        $('#opp_benefit').val("");
        $('#opp_nilai_benefit').val("");
        $('#opp_rtl').val("");
      }
    })
    $(document.body).on("click", ".edit_item_opportunity", function() {
      var no = $(this).attr('data-no');
      var pengusul = $(".pengusul[data-no='" + no + "']").val();
      var probabilitas = $(".probabilitas[data-no='" + no + "']").val();
      var area = $(".area[data-no='" + no + "']").val();
      var hambatan = $(".hambatan[data-no='" + no + "']").val();
      var opportunity = $(".opportunity[data-no='" + no + "']").val();
      var biaya = $(".biaya[data-no='" + no + "']").val();
      var benefit = $(".benefit[data-no='" + no + "']").val();
      var nilai_benefit = $(".nilai_benefit[data-no='" + no + "']").val();
      var rtl = $(".rtl[data-no='" + no + "']").val();

      $('#opp_pengusul').val(pengusul);
      $('#opp_probabilitas').val(probabilitas);
      $('#opp_area').val(area);
      $('#opp_hambatan').val(hambatan);
      $('#opp_opportunity').val(opportunity);
      $('#opp_biaya').val(biaya);
      $('#opp_benefit').val(benefit);
      $('#opp_nilai_benefit').val(nilai_benefit);
      $('#opp_rtl').val(rtl);

      $(this).parent().parent().remove();
    })

    $(document.body).on("click", ".delete_item_opportunity", function() {
      let text = "Hapus data input ini?";
      if (confirm(text) == true) {
        $('#opp_pengusul').val("");
        $('#opp_probabilitas').val("");
        $('#opp_area').val("");
        $('#opp_hambatan').val("");
        $('#opp_opportunity').val("");
        $('#opp_biaya').val("");
        $('#opp_benefit').val("");
        $('#opp_nilai_benefit').val("");
        $('#opp_rtl').val("");
      } else {}

    })
  });

  function getMaxDataNo(selector) {
    var min = null,
      max = null;
    $(selector).each(function() {
      var no_pp = parseInt($(this).attr('data-no'), 10);
      if ((max === null) || (no_pp > max)) {
        max = no_pp;
      }
    });
    return max;
  }
</script>