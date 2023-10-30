<?php
$sumber_hps = [
  [
    'value' => '',
    'option' => 'Pilih sumber HPS',
  ],
  [
    'value' => 'a. RAB proyek yang telah disahkan didalam RKP',
    'option' => 'a. RAB proyek yang telah disahkan didalam RKP',
  ],
  [
    'value' => 'b. Informasi biaya satuan yang dipublikasikan secara resmi oleh Badan Pusat Statistik (BPS)',
    'option' => 'b. Informasi biaya satuan yang dipublikasikan secara resmi oleh Badan Pusat Statistik (BPS)',
  ],
  [
    'value' => 'c. Informasi biaya satuan yang dipublikasikan secara resmi oleh asosiasi terkait dan sumber
    data lain yang dapat dipertanggungjawabkan',
    'option' => 'c. Informasi biaya satuan yang dipublikasikan secara resmi oleh asosiasi terkait dan sumber
    data lain yang dapat dipertanggungjawabkan',
  ],
  [
    'value' => 'd. Daftar biaya/tarif barang/jasa yang dikeluarkan oleh pabrikan / distributor tunggal',
    'option' => 'd. Daftar biaya/tarif barang/jasa yang dikeluarkan oleh pabrikan / distributor tunggal',
  ],
  [
    'value' => 'e. Biaya kontrak sebelumnya atau yang sedang berjalan dengan mempertimbangkan faktor perubahan biaya',
    'option' => 'e. Biaya kontrak sebelumnya atau yang sedang berjalan dengan mempertimbangkan faktor perubahan biaya',
  ],
  [
    'value' => 'f. Inflasi tahun sebelumnya, suku bunga berjalan dan/atau kurs tengah Bank Indonesia',
    'option' => 'f. Inflasi tahun sebelumnya, suku bunga berjalan dan/atau kurs tengah Bank Indonesia',
  ],
  [
    'value' => 'g. Hasil perbandingan dengan kontrak sejenis, baik yang dilakukan dengan instansi lain maupun pihak lain',
    'option' => 'g. Hasil perbandingan dengan kontrak sejenis, baik yang dilakukan dengan instansi lain maupun pihak lain',
  ],
  [
    'value' => 'h. Perkiraan perhitungan biaya yang dilakukan oleh konsultan perencanaan',
    'option' => 'h. Perkiraan perhitungan biaya yang dilakukan oleh konsultan perencanaan',
  ],
  [
    'value' => 'i. Norma indeks; dan/atau',
    'option' => 'i. Norma indeks; dan/atau',
  ],
  [
    'value' => 'j. Informasi lain yang dapat dipertanggungjawabkan',
    'option' => 'j. Informasi lain yang dapat dipertanggungjawabkan',
  ]
];
?>
<style>
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
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <span class="wrapper-header">
            <div class="title-header d-flex align-items-center">
              <h4 class="card-title ">ITEM SUMBER DAYA</h4>
              <a onclick="isSumberDaya()" class="btn btn-sm btn-info btn-tambah ml-2 rounded" id="ifcheckedspk" style="display: none;">
                <i class="ft ft-plus"></i>Tambah
              </a>
            </div>
            <div class="wrapper-button" id="btnSaveSmbdDaya" style="display: none;">
              <span class="wrapper-action save-comment">
                <a class="btn btn-sm btn-info btn-action-edit action_item_sumberdaya">Simpan</a>
                <a onclick=" return resetFormEdit('comment')" class="btn btn-sm btn-action-delete empty_item">
                  <i class="fa fa-trash fa-lg"></i>
                </a>
                <input type="hidden" id="current_item">
              </span>
            </div>

          </span>
          <div class="row mb-2" id="addSumberDaya" style="display: none;">
            <div class="col-md">

              <?php $curval = set_value("kode_item"); ?>
              <div class="row form-group col-md-12 mb-1">
                <label class="col-sm-4 control-label">Sumberdaya <span class="text-danger text-bold-700">*</span> </label>
                <div class="col-sm-8">
                  <input readonly type="text" class="form-control col-sm-6 mr-2" name="kode_item" id="kode_item" placeholder="Kode Sumberdaya" value="<?php echo $curval ?>">
                  <div class="btn-group-sm">
                    <button type="button" data-id="kode_item" id="item_int_btn" data-url="<?php echo site_url('procurement/get_picker_sumberdaya') ?>" class="btn btn-info picker sumberdaya_btn">Pilih sumberdaya</button>
                  </div>
                </div>
              </div>

              <div class="row form-group col-md-12 mb-1">
                <?php $curval = set_value("group_name"); ?>
                <label class="col-sm-4 control-label">Nama Sumberdaya <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <p class="form-control-static" id="item_deskripsi"><?php echo $curval ?></p>
                </div>
              </div>

              <div class="row form-group col-md-12">
                <?php $curval = set_value("tipe_item"); ?>
                <label class="col-sm-4 control-label">Tipe</label>
                <div class="col-sm-8">
                  <p class="form-control-static" id="tipe_item"><?php echo $curval ?></p>
                </div>
              </div>

              <div class="row form-group col-md-12 mb-1">
                <?php $curval = set_value("jumlah_item_inp"); ?>
                <label class="col-sm-4 control-label">Volume <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control money" maxlength="40" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
                  <small id="max_volume"></small>
                </div>
                <small id="error_jml"></small>
              </div>

              <div class="row form-group col-md-12 mb-1">
                <?php $curval = set_value("harga_satuan_item_inp"); ?>
                <label class="col-sm-4 control-label">Harga Satuan RAB <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control money" maxlength="40" name="harga_satuan_item_inp" id="harga_satuan_item_inp" value="<?php echo $curval ?>">
                  <small>
                    <i>Harga Satuan sudah termasuk PPH, Bunga Disconto, dan Biaya Lainnya
                    </i>
                  </small>
                </div>

                <div class="col-sm-1">
                  <div class="checkbox">
                    <?php $curval = set_value("ppn_item_inp"); ?>
                    <input type="checkbox" class="" name="ppn_item_inp" id="ppn_item_inp" value="0" style="visibility: hidden"> <!-- val = 10 -->
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

              <div class="row form-group col-md-12" hidden>
                <?php $curval = set_value("item_deskripsi"); ?>
                <label class="col-sm-4 control-label">Deskripsi</label>
                <div class="col-sm-8">
                  <p class="form-control-static" maxlength="1000" id="deskripsi_item"><?php echo $curval ?></p>
                </div>
              </div>
            </div>
            <div class="col-md">
              <?php $curval = set_value("satuan_item_inp"); ?>
              <div class="row form-group col-md-12 mb-1">
                <label class="col-sm-4 control-label">Satuan</label>
                <div class="col-sm-8">
                  <input type="text" readonly="true" class="form-control" maxlength="12" name="satuan_item_inp" id="satuan_item_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <div class="row form-group col-md-12 mb-1">
                <label class="col-sm-4 control-label">Incoterm <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <select class="form-control bg-select" name="incoterm" id="incoterm">
                    <option value="">Pilih</option>
                    <option value="Ex work">Ex work (EXW-nama tempat penyerahan)</option>
                    <option value="Free Carrier">Free Carrier (FCA)</option>
                    <option value="Free on Board">Free on Board (FOB)</option>
                    <option value="Free Alongside Ship">Free Alongside Ship (FAS)</option>
                    <option value="Carrier Insurance Freight">Carrier Insurance Freight (CIF)</option>
                    <option value="Carrier insurance paid to">Carrier insurance paid to (CIP)</option>
                    <option value="Cost Freight">Cost Freight (CFR)</option>
                    <option value="Carriage paid to">Carriage paid to (CPT)</option>
                    <option value="Delivery Duty Paid">Delivery Duty Paid (DDP)</option>
                    <option value="Delivered at place">Delivered at place (DAP)</option>
                    <option value="Delivered at Terminal">Delivered at Terminal (DAT)</option>
                  </select>
                </div>
              </div>

              <div class="row form-group col-md-12 mb-1">
                <label class="col-sm-4 control-label">Lokasi Incoterm <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="lokasi_incoterm" id="lokasi_incoterm" value="">
                </div>
              </div>

              <div class="row form-group col-md-12 mb-1">
                <?php $curval = set_value("tipe_item"); ?>
                <label class="col-sm-4 control-label">Sumber HPS <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <select class="form-control bg-select" name="sumber_hps" id="sumber_hps">
                    <?php foreach ($sumber_hps as $k => $v) { ?>
                      <option value="<?= $v['value'] ?>"><?= $v['option'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="row form-group col-md-12 mb-1">
                <?php $curval = set_value("hps"); ?>
                <label class="col-sm-4 control-label">HPS <span class="text-danger text-bold-700">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control money" maxlength="40" name="hps" id="hps" value="<?php echo $curval ?>">
                  <small id="max_volume"></small>
                </div>
                <small id="error_jml"></small>
              </div>

              <div class="row form-group col-md-12">
                <label class="col-sm-4 control-label"><?php echo lang('attachment') ?></label>
                <?php $curval = set_value("doc_attachment_inp_smbd_matgis[$k]"); ?>
                <div class="col-sm-8">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" data-id="doc_attachment_inp_smbd_matgis" data-folder="procurement/tender" data-preview="preview_file" class="btn btn-info upload rounded">
                        <i class="fa fa-cloud-upload"></i> Up
                      </button>
                      <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/tender/' . $curval) ?>" class="btn btn-info preview_upload rounded mr-1" id="preview_file">
                        <i class="fa fa-share"></i> View
                      </button>
                    </span>
                    <input readonly type="text" class="form-control" id="doc_attachment_inp_smbd_matgis" name="doc_attachment_inp_smbd_matgis" value="<?php echo $curval ?>">
                    <span class="input-group-btn">
                      <button type="button" data-id="doc_attachment_inp_smbd_matgis" data-folder="procurement/tender" data-preview="preview_file" class="btn btn-danger removefile rounded ml-1">
                        <i class="fa fa-trash"></i> Del
                      </button>
                    </span>
                  </div>
                  <div class="col-sm-0" style="font-size: 11px">
                    <i>Max file 5 MB
                      <br>
                      Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                    </i>
                  </div>
                </div>
              </div>


            </div>
          </div>

          <table class="table table-striped table-responsive" id="item_table">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode SDA</th>
                <th>Nama Sumber Daya</th>
                <th>Tipe</th>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Harga Satuan RAB</th>
                <th>Subtotal</th>
                <th>Incoterm</th>
                <th>Lokasi Incoterm</th>
                <th>Sumber HPS</th>
                <th>HPS</th>
                <th>Subtotal HPS</th>
                <th>Lampiran</th>
                <th style="display: none">Pajak</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $subtotal = 0;
              $subtotalhps = 0;
              if (isset($item) && !empty($item)) {
                foreach ($item as $key => $value) {
                  $idnya = $key + 1;

              ?>

                  <tr>
                    <td><?= $idnya ?></td>
                    <td>
                      <?php echo $value['ppi_code'] ?>
                    </td>
                    <td>
                      <?php echo $value['ppi_description'] ?>
                    </td>
                    <td>
                      <?php echo $value['ppi_type'] ?>
                    </td>
                    <td class="text-right">
                      <?php echo inttomoney($value['ppi_quantity']) ?>
                    </td>
                    <td>
                      <?php echo $value['ppi_unit'] ?>
                    </td>
                    <td class="text-right">
                      <?php echo inttomoney($value['ppi_price']) ?>
                    </td>
                    <td class="text-right" id="subtotal_rab">
                      <?php echo inttomoney($value['ppi_price'] * $value['ppi_quantity']) ?>
                    </td>
                    <td class="text-right" style="display: none">
                      <input type="hidden" value="<?php echo $value['ppi_ppn'] ?>" name="item_ppn_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppn_satuan_item">
                      <?php echo (!empty($value['ppi_ppn'])) ? " PPN (" . $value['ppi_ppn'] . "%) " : "" ?>
                      <input type="hidden" value="<?php echo $value['ppi_pph'] ?>" name="item_pph_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pph_satuan_item">
                      <?php echo (!empty($value['ppi_pph'])) ? " PPH (" . $value['ppi_pph'] . "%)" : "" ?>
                    </td>
                    <td>
                      <?= $value['ppi_incoterm'] ?>
                    </td>
                    <td>
                      <?= $value['ppi_lokasi_incoterm'] ?>
                    </td>
                    <td>
                      <?= $value['ppi_sumber_hps'] ?>
                    </td>
                    <td>
                      <?= inttomoney($value['ppi_hps']) ?>
                    </td>
                    <td id="subtotal_hps">
                      <?= inttomoney($value['ppi_hps'] * $value['ppi_quantity']) ?>
                    </td>
                    <td>
                      <?= $value['ppi_lampiran'] ?>
                    </td>
                    <td>
                      <button type='button' class='btn btn-info btn-xs edit_item' data-no='<?= ($k + 1) ?>'><i class='fa fa-edit'></i></button>
                    </td>
                  </tr>

              <?php
                  $subtotal += $value['ppi_price'] * $value['ppi_quantity'];
                  $subtotalhps += $value['ppi_hps'] * $value['ppi_quantity'];
                }
              } ?>
            </tbody>
          </table>

          <hr>
          <div class="row form-group">
            <div class="col-sm-5">
            </div>
            <label class="col-sm-4 control-label text-right">Total RAB</label>
            <div class="col-sm-3">
              <p class="form-control-static text-right" id="total_rab"><?= inttomoney($subtotal) ?></p>
              <input type="hidden" name="total_rab_inp" id="total_rab_inp">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-5">
            </div>
            <label class="col-sm-4 control-label text-right">Total HPS</label>
            <div class="col-sm-3">
              <p class="form-control-static text-right" id="total_hps"><?= inttomoney($subtotalhps) ?></p>
              <input type="hidden" name="total_hps_inp" id="total_hps_inp">
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  $(document.body).on("change", "#kode_item", function() {

    var id = $(this).val();
    var url = "<?php echo site_url('Procurement/get_item_perencanaan') ?>";

    if ($('#kode_spk').val() == '') {
      $('.int_item').css('display', 'none');
      $.ajax({
        url: url + "?id=" + id,
        dataType: "json",
        success: function(data) {
          var mydata = data.rows[0];
          $('#harga_satuan_item_inp').attr('disabled', false);
          $("#deskripsi_pekerjaan").html(mydata.ppm_scope_of_work);
          $("#jumlah_item_inp").val(1);
          $("#satuan_item_inp").val(mydata.unit);
          $("#harga_satuan_item_inp").val(mydata.price);
          $("#item_deskripsi").html(mydata.smbd_name);
          $("#kode_item").val(mydata.smbd_code);
        }
      });
    } else {

      //function delay        
      var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
          clearTimeout(timer);
          timer = setTimeout(callback, ms);
        };
      })();

      $.ajax({
        url: url + "?id=" + id + "&spk_code=" + $('#kode_spk').val() + "&",
        dataType: "json",
        cache: false,
        success: function(data) {
          $('.int_item').css('display', '');
          var mydata = data.rows[0];
          $("#harga_satuan_item_inp").val(mydata.price);
          $("#item_deskripsi").html(mydata.smbd_name);
          $("#deskripsi_item").html(mydata.smbd_name);
          $("#deskripsi_item_inp").val(mydata.smbd_name);
          $('#max_volume').html("<span id='max'><i>batas max " + parseFloat(mydata.ppv_remain).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 8
          }) + " " + mydata.unit + "</i></span>");
          $("#jumlah_item_inp").val(1);
          $("#satuan_item_inp").val(mydata.unit);
          $("#jumlah_item_inp").on('keyup', function(e) {
            delay(function() {
              $.ajax({
                  url: "<?php echo site_url('Procurement/get_volume') ?>" + "?smbd_code=" + $('#kode_item').val() + "&spk_code=" + $('#kode_spk').val(),
                  dataType: 'json',
                })

                .done(function(data_vol) {
                  var data_vol = data_vol.rows[0];
                  var vol_remain = data_vol.ppv_remain;
                  if (parseFloat(($("#jumlah_item_inp").val()).replace(/\./g, '')) > parseFloat(vol_remain)) {
                    alert("Jumlah tidak boleh lebih dari " + vol_remain + ' ' + $("#satuan_item_inp").val());
                    $("#jumlah_item_inp").val(1);
                    $("#jumlah_item_inp").focus();
                  }

                })

                .fail(function() {
                  console.log("error");
                })
            }, 500);
          });
          return false;
        }
      });

    }

  });

  $(function() {
    $.ajax({
      url: "<?php echo site_url('administration/dropdown_pph') ?>",
      type: "get",
      dataType: "json",
      success: function(data) {
        $.each(data, function(index, row) {

          $("#pph_item_inp").append("<option value='" + row.pph_value + "'>" + row.pph_name + " - " + row.pph_value + "</option>");

        });
      }
    });

  });

  function isSumberDaya() {
    var div = document.getElementById("addSumberDaya");
    var smbd_save = document.getElementById("btnSaveSmbdDaya");
    if (div.style.display !== "none") {
      div.style.display = "none";
      smbd_save.style.display = "none";
    } else {
      div.style.display = "flex";
      smbd_save.style.display = "flex";
    }
  }

  function set_total() {

    var total_alokasi = 0;
    var ppn = 0;
    var pph = 0;
    var total_alokasi_ppn = 0;

    var total_rab = 0;
    var sub_hps = 0;

    $("#item_table tr").each(function() {

      var item = (!isNaN($(this).find(".harga_satuan_item").val())) ? parseFloat($(this).find(".harga_satuan_item").val()) : 0;
      var qty = (!isNaN($(this).find(".jumlah_item").val())) ? parseFloat($(this).find(".jumlah_item").val()) : 0;
      var total_hps = ($(this).find(".subtotal_hps").val()) ? $(this).find(".subtotal_hps").val() : 0;
      var subtotal = (!isNaN($(this).find(".subtotal_item").val())) ? parseFloat($(this).find(".subtotal_item").val()) : 0;
      var ppn_persen = ($(this).find(".ppn_satuan_item").val()) ? $(this).find(".ppn_satuan_item").val() / 100 : 0;
      var pph_persen = ($(this).find(".pph_satuan_item").val()) ? $(this).find(".pph_satuan_item").val() / 100 : 0;

      var ppn_nominal = (item * qty) * ppn_persen;

      ppn += ppn_nominal;
      var pph_nominal = (item * qty) * pph_persen;
      pph += pph_nominal;
      total_alokasi_ppn += (item * qty) + ppn_nominal + pph_nominal;
      total_rab += subtotal;
      sub_hps += parseFloat(total_hps);
    });

    $("#ppn").text(inttomoney(ppn));
    $("#ppn_inp").val(ppn);
    $("#pph").text(inttomoney(pph));
    $("#pph_inp").val(pph);
    $("#total_rab").text(inttomoney(total_rab));
    $("#total_rab_inp").val(total_rab);

    $("#total_rab").text(inttomoney(total_rab));
    $("#total_rab_inp").val(total_rab);

    $("#total_hps").text(inttomoney(sub_hps));
    $("#total_hps_inp").val(inttomoney(sub_hps));

  }

  $(document).ready(function() {

    $('.int_item').css('display', 'none');
    $(".barang_btn").click(function() {
      $("#tipe_item").text("BARANG");
    });
    $(".jasa_btn").click(function() {
      $("#tipe_item").text("JASA");
    });
    $(".sumberdaya_btn").click(function() {
      $("#tipe_item").text("MULTIPLE");
    });
    var uri_pp = '<?php echo site_url('Procurement/periode_pengadaan_picker') ?>';

    if ($('#kode_spk').val() == '') {
      $('.int_item').css('display', 'none');
      $('.not_integrated').show();
      $('.integrated').hide();
    } else {
      $('.integrated').show();
      $('.not_integrated').hide();
      $('.int_item').css('display', '');
    }


    $(".action_item_sumberdaya").click(function() {

      var tipe = $("#tipe_item").text();
      var current_item = $("#current_item").val();
      var no = current_item;

      if (current_item == "") {
        if (getMaxDataNo(".edit_item") == null) {
          no = 1;
        } else {
          no = getMaxDataNo(".edit_item") + 1;
        }
      }

      var kode = $("#kode_item").val();
      var max_notif = $('#max_volume').html();
      var item_deskripsi = $('#item_deskripsi').text();

      var incoterm = $('#incoterm').val();
      var lokasi_incoterm = $('#lokasi_incoterm').val();
      var sumber_hps = $('#sumber_hps').val();
      var hps = $('#hps').val();
      var hps_int = $('#hps').autoNumeric('get');
      var doc_attachment_inp_smbd_matgis = $('#doc_attachment_inp_smbd_matgis').val();

      var deskripsi = $("#deskripsi_item").text();
      var jumlah = $("#jumlah_item_inp").val();
      var satuan = $("#satuan_item_inp").val();
      var harga_satuan = $("#harga_satuan_item_inp").val();
      var jumlah_int = $("#jumlah_item_inp").autoNumeric('get');
      var harga_satuan_int = $("#harga_satuan_item_inp").autoNumeric('get');
      var ppn = ($("#ppn_item_inp").prop('checked')) ? 10 : 0;

      if (kode === '' || jumlah === '' || harga_satuan === '' || incoterm === '' || lokasi_incoterm === '' || sumber_hps === '' ||
        hps === '') {
        alert("Semua input mandarory (*) harus diisi!");
        return false;
      }
      // current pph field
      if ($("#pph_item_inp option:selected").val() != "") {
        var pph = parseFloat($("#pph_item_inp option:selected").val().replace(/,/, '.')).toFixed(2);
      } else {
        var pph = parseFloat(0);
      }
      //end
      var label_ppn = (ppn == 0) ? "" : " PPN (" + ppn + "%) ";
      var label_pph = (pph == 0) ? "" : " PPH (" + pph + "%) ";


      if (harga_satuan_int < 1) {
        alert("Harga tidak boleh kurang dari 1");
      } else if (jumlah_int < 1) {
        alert("Jumlah tidak boleh kurang dari 1");
      } else {
        var subtotal_hps = parseFloat(hps_int) * parseFloat(jumlah_int);
        var subtotal_hps_int = subtotal_hps;
        subtotal_hps = inttomoney(subtotal_hps);
        var x = parseFloat(jumlah_int) * parseFloat(harga_satuan_int);
        var subtotal_int = x + (x * parseFloat(ppn) / 100) + (x * (pph) / 100);
        var subtotal = inttomoney(x);

        harga_satuan = inttomoney(harga_satuan_int);

        var html = "<tr><td>" + no + "</td>";
        html += "<td><input type='hidden' class='kode_item' data-no='" + no + "' name='item_kode[" + no + "]' value='" + kode + "'/>";
        html += "<td><input type='hidden' class='item_deskripsi' data-no='" + no + "' name='item_deskripsi[" + no + "]' value='" + item_deskripsi + "'/>" + item_deskripsi + "</td>";
        html += "<td><input type='hidden' class='tipe_item' data-no='" + no + "' name='item_tipe[" + no + "]' value='" + tipe + "'/>" + tipe + "</td>";
        html += "<td class='text-right'><input type='hidden' class='max_item' data-no='" + no + "' name='max_item[" + no + "]' value='" + max_notif + "'/> <input type='hidden' class='jumlah_item' data-no='" + no + "' name='item_jumlah[" + no + "]' value='" + jumlah_int + "'/>" + jumlah + "</td>";
        html += "<td><input type='hidden' class='satuan_item' data-no='" + no + "' name='item_satuan[" + no + "]' value='" + satuan + "'/>" + satuan + "</td>";
        html += "<td class='text-right'><input type='hidden' class='harga_satuan_item' data-no='" + no + "' name='item_harga_satuan[" + no + "]' value='" + harga_satuan_int + "'/>" + harga_satuan + "</td>";
        html += "<td class='text-right'><input type='hidden' class='subtotal_item' data-no='" + no + "' name='item_subtotal[" + no + "]' value='" + subtotal_int + "'/>" + subtotal + "</td>";

        html += "<td><input type='hidden' class='incoterm' data-no='" + no + "' name='incoterm[" + no + "]' value='" + incoterm + "'/>" + incoterm + "</td>";
        html += "<td><input type='hidden' class='lokasi_incoterm' data-no='" + no + "' name='lokasi_incoterm[" + no + "]' value='" + lokasi_incoterm + "'/>" + lokasi_incoterm + "</td>";
        html += "<td><input type='hidden' class='sumber_hps' data-no='" + no + "' name='sumber_hps[" + no + "]' value='" + sumber_hps + "'/>" + sumber_hps + "</td>";
        html += "<td><input type='hidden' class='hps' data-no='" + no + "' name='hps[" + no + "]' value='" + hps_int + "'/>" + inttomoney(hps_int) + "</td>";
        html += "<td><input type='hidden' class='subtotal_hps' data-no='" + no + "' name='subtotal_hps[" + no + "]' value='" + subtotal_hps_int + "'/>" + subtotal_hps + "</td>";
        html += "<td><input type='hidden' class='doc_attachment_inp_smbd_matgis' data-no='" + no + "' name='doc_attachment_inp_smbd_matgis[" + no + "]' value='" + doc_attachment_inp_smbd_matgis + "'/>"
                + "<a href='"+ document.location.origin + '/log/download_attachment/pemaketan/' + doc_attachment_inp_smbd_matgis +"'>"+ doc_attachment_inp_smbd_matgis + "</a></td>";

        html += "<td class='text-right' style='display: none'><input type='hidden' class='ppn_satuan_item' data-no='" + no + "' name='item_ppn_satuan[" + no + "]' value='" + ppn + "'/> " + label_ppn;
        html += " <input type='hidden' class='pph_satuan_item' data-no='" + no + "' name='item_pph_satuan[" + no + "]' value='" + pph + "'/> " + label_pph;
        html += "</td>";
        html += "<td><button type='button' class='btn btn-info btn-xs edit_item' data-no='" + no + "'><i class='fa fa-edit'></i></button></td>";
        html += "</tr>";

        $("#item_table").append(html);

        $("#kode_item").val("");
        $('#item_deskripsi').text("");
        $('#incoterm').val("");
        $('#lokasi_incoterm').val("");
        $('#sumber_hps').val("");
        $('#hps').val("");
        $('#doc_attachment_inp_smbd_matgis').val("");
        $("#tipe_item").text("");
        $("#deskripsi_item").text("");
        $("#max_volume").html("");
        $("#jumlah_item_inp").val("");
        $("#satuan_item_inp").val("");
        $("#harga_satuan_item_inp").val("");
        // current pph field
        $("#pph_item_inp").val("");
        //end
        $("#ppn_item_inp").prop("checked", false);
        $("#current_item").val("");
        arraySmbd();
      }

      set_total();

      if ($('#sisa_pagu_inp').val() < 0) {
        $('#sisa_pagu').css({
          "font-weight": 'bold',
          "color": 'red'
        });
      } else {
        $('#sisa_pagu').removeAttr('style')
      }

      $('.edit_item').click(function() {
        $('#sisa_pagu').removeAttr('style')
      })

      $('[data-toggle="popover"]').popover();
    });

    $(document.body).on("click", ".empty_item", function() {
      $('#max_volume').html('');
      var tipe = $("#tipe_item").text();
      $("#current_item").val("");
      $("#kode_item").val("");
      $("#tipe_item").text("");
      $("#deskripsi_item").text("");
      if (tipe == 'MULTIPLE') {}
      $("#jumlah_item_inp").val("");
      $("#satuan_item_inp").val("");
      $("#harga_satuan_item_inp").val("");

      $("#item_deskripsi").text("");
      $('#incoterm').val("");
      $('#lokasi_incoterm').val("");
      $('#sumber_hps').val("");
      $('#hps').val("");
      $('#doc_attachment_inp_smbd_matgis').val("");

      cek_group();

    });

    function cek_group() {

      var no = parseInt($("#item_table tr").length);

      if (no == 1) {
        $.ajax({
          url: "<?php echo site_url('procurement/set_session/code_group/') ?>",
          success: function() {

          }
        })
      }

    }

    $(document.body).on("click", ".edit_item", function() {
      var no = $(this).attr('data-no');
      max_notif_item = $(".max_item[data-no='" + no + "']").val();
      $('#max_volume').html(max_notif_item);
      var kode = $(".kode_item[data-no='" + no + "']").val();
      var tipe = $(".tipe_item[data-no='" + no + "']").val();
      var item_deskripsi = $(".item_deskripsi[data-no='" + no + "']").val();
      var jumlah = $(".jumlah_item[data-no='" + no + "']").val();
      var satuan = $(".satuan_item[data-no='" + no + "']").val();
      var harga_satuan = $(".harga_satuan_item[data-no='" + no + "']").val();
      // current pph field
      var ppn = $(".ppn_satuan_item[data-no='" + no + "']").val();
      var pph = $(".pph_satuan_item[data-no='" + no + "']").val();
      //end

      var incoterm = $(".incoterm[data-no='" + no + "']").val();
      var lokasi_incoterm = $(".lokasi_incoterm[data-no='" + no + "']").val();
      var sumber_hps = $(".sumber_hps[data-no='" + no + "']").val();
      var hps = $(".hps[data-no='" + no + "']").val();
      var hps_int = $(".hps[data-no='" + no + "']").val();
      var doc_attachment_inp_smbd_matgis = $(".doc_attachment_inp_smbd_matgis[data-no='" + no + "']").val();

      $("#current_item").val(no);
      $("#kode_item").val(kode);
      $("#tipe_item").text(tipe);
      $("#item_deskripsi").text(item_deskripsi);
      if (tipe == 'MULTIPLE') {}
      $("#jumlah_item_inp").val(inttomoney(jumlah));
      $("#satuan_item_inp").val(satuan);

      $('#incoterm').val(incoterm);
      $('#lokasi_incoterm').val(lokasi_incoterm);
      $('#sumber_hps').val(sumber_hps);
      $('#hps').val(hps);
      $('#doc_attachment_inp_smbd_matgis').val(doc_attachment_inp_smbd_matgis);

      // current pph field
      var is_ppn = (parseFloat(ppn) != 0);
      $("#ppn_item_inp").prop('checked', is_ppn);
      $("#pph_item_inp option[value='" + pph.replace('.', ',') + "']").prop('selected', true);
      //end
      $("#harga_satuan_item_inp").val(inttomoney(harga_satuan));

      cek_group();

      $(this).parent().parent().remove();

      set_total();

      return false;

    });

  })

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