<style>
  .card .card-title {
    color: #2aace3;
  }
</style>
<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header mb-3">
          <h4 class="card-title">
            <div class="btn-group-sm float-left">
              <span class="card-title text-bold-600 mr-2">Lampiran Dokumen</span>
              <span>
                <a onclick="isShowAddDoc()" class="btn btn-info btn-sm rounded">
                  <i class="ft-plus"></i> Tambah Lampiran
                </a>
              </span>
            </div>
            <div class="btn-group-sm float-right position-relative" id="showButtonDok" style="display: none">
              <a class="btn btn-info action_dok btn-plus text-capitalize">Simpan</a>
              <a class="btn btn-sm empty_documents btn-trash" style="color: #000" title="Hapus"><i class="ft-trash"></i></a>
              <br>
              <input type="hidden" id="current_dok" value="" />
            </div>
          </h4>
          <br>
        </div>

        <div class="card-content">
          <div class="card-body pt-0">
            <div class="row mb-2" id="showAddDok" style="display: none">
              <div class="col-md row">
                <div class="col-md-12 form-group mb-1">
                  <label class="col-sm-4 control-label"><?php echo lang('category') ?></label>
                  <div class="col-sm-8">
                    <select class="form-control" id="doc_category_inp" name="doc_category_inp" value="">
                      <option value=""><?php echo lang('choose') ?></option>
                      <?php foreach ($doc_category as $key => $val) {
                        $selected = ($val['ldc_name'] == $curval) ? "selected" : "";
                      ?>
                        <option <?php echo $selected ?> value="<?php echo $val['ldc_name'] ?>"><?php echo $val['ldc_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12 form-group mb-1">
                  <?php $curval = set_value("doc_attachment_inp"); ?>
                  <label class="col-sm-4 control-label"><?php echo lang('attachment') ?></label>
                  <div class="col-sm-8">
                    <div class="input-group">
                      <!-- <span class="input-group-btn">
                        <button type="button" data-id="doc_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="preview_file" class="btn btn-info upload rounded">
                          <i class="fa fa-cloud-upload"></i>
                        </button>
                        <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/' . $curval) ?>" class="btn btn-info preview_upload rounded mr-1" id="preview_file_lmprn">
                          <i class="fa fa-share"></i>
                        </button>
                      </span>
                      <input readonly type="text" class="form-control doc_attachment_inp" id="doc_attachment_inp" name="doc_attachment_inp" value="<?php echo $curval ?>">
                      <span class="input-group-btn">
                        <button type="button" data-id="doc_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="preview_file" class="btn btn-danger removefile rounded ml-1">
                          <i class="fa fa-trash"></i>
                        </button>
                      </span> -->
                      <span class="input-group-btn">
                    <button type="button" data-id="doc_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="preview_file_lmprn" class="btn btn-info upload rounded" title="Upload">
                      <i class="fa fa-cloud-upload"></i> Up
                    </button>
                    <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/' . $curval) ?>" class="btn btn-info preview_upload rounded mr-1" id="preview_file_lmprn">
                      <i class="fa fa-share"></i> View
                    </button>
                  </span>
                  <input readonly type="text" class="form-control" id="doc_attachment_inp" name="doc_attachment_inp" value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-id="doc_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="preview_file_lmprn" class="btn btn-danger removefile rounded ml-1">
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

              <div class="col-md row">
                <div class="col-md-12 form-group mb-1">
                  <label class="col-sm-4 control-label">Dokumen</label>
                  <div class="col-sm-8">
                    <?php $curval = set_value("doc_type_inp"); ?>
                    <select class="form-control" style=" border-color: grey" name="doc_type_inp" id="doc_type_inp">
                      <option selected value="">Pilih dokumen</option>
                      <option value="Dokumen Internal">Dokumen Internal</option>
                      <option value="Dokumen Vendor">Dokumen Vendor</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 form-group mb-1">
                  <?php $curval = set_value("doc_desc_inp"); ?>
                  <label class="col-sm-4 control-label"><?php echo lang('description') ?></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" maxlength="1000" id="doc_desc_inp" name="doc_desc_inp"><?php echo $curval ?></textarea>
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <label class="col-sm-4 control-label mt-2 text-bold-700">Download Template</label>
                  <div class="col-sm-8">
                    <p class="form-control-static mt-2">
                      <a href="<?php echo base_url('user_guide/SPK [surat perintah kerja].zip'); ?>" class="btn btn-info btn-sm rounded">SPK</a>
                      <a href="<?php echo base_url('user_guide/SPB[surat pemesanan barang] .zip'); ?>" class="btn btn-info btn-sm rounded">SPB</a>
                      <a href="<?php echo base_url('user_guide/PPJ [Perjanjian Pengadaan Jasa] .zip'); ?>" class="btn btn-info btn-sm rounded">PPJ</a>
                      <a href="<?php echo base_url('user_guide/PPB [Perjanjian Pengadaan Barang].zip'); ?>" class="btn btn-info btn-sm rounded">PPB</a>
                      <a href="#" class="btn btn-info btn-sm rounded">KAK</a>
                      <a href="#" class="btn btn-info btn-sm rounded">DP3</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div id="lampiran_container">
              <div class="table-responsive table-striped">
                <table class="table" id="dok_table" style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kategori</th>
                      <th>Lampiran</th>
                      <th>Type</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($document as $k => $v) {
                      $myid = $k + 1;
                    ?>

                      <tr>
                        <td><?= $no++; ?></td>
                        <td>
                          <input type="hidden" value="<?= $v['ptd_category'] ?>" class='doc_category_inp' name="doc_category_inp[<?php $k ?>]" data-no="<?= $myid ?>">
                          <?= $v['ptd_category'] ?>
                        </td>
                        <td>
                          <input readonly type="hidden" class="form-control doc_attachment_inp" id="doc_attachment_inp_<?= $k ?>" name="doc_attachment_inp[<?php $k ?>]" value="<?= $v['ptd_file_name'] ?>" data-no="<?= $myid ?>">
                          <a href="<?= site_url() ?>/log/download_attachment/procurement/tender/<?= $v['ptd_file_name'] ?>"><?= $v['ptd_file_name'] ?></a>
                        </td>
                        <td>
                          <input type="hidden" value="<?= $v['ptd_type'] ?>" class='doc_type_inp' name="ptd_type[<?php $k ?>]" data-no="<?= $myid ?>">
                          <?= $v['ptd_type'] ? "Dokumen Vendor" : "Dokumen Internal" ?>
                        </td>
                        <td>
                          <input type="hidden" value="<?= $v['ptd_description'] ?>" class='doc_desc_inp' name="doc_desc_inp[<?php $k ?>]" data-no="<?= $myid ?>">
                          <?= $v['ptd_description'] ?>
                        </td>
                        <td>
                          <button data-no="<?= $myid ?>" class="btn btn-info btn-sm edit_dok" type="button">
                            <i class="fa fa-edit"></i>
                            <?php  ?>
                            <input type="hidden" name="doc_id[<?= $k ?>]" value="<?= $k ?>" data-no="<?= $myid ?>" />
                          </button>
                        </td>
                      </tr>

                    <?php }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {

    $(".action_dok").click(function() {

      var current_dok = $("#current_dok").val();
      var no = current_dok;
      var doc_category_inp = $('#doc_category_inp').val();
      var doc_attachment_inp = $('#doc_attachment_inp').val();
      var doc_type_inp = $('#doc_type_inp').val();
      var doc_desc_inp = $('#doc_desc_inp').val();
      var host = "<?php echo site_url('log/download_attachment/procurement/') ?>";
      if (current_dok == "") {
        if (getMaxDataNo(".edit_dok") == null) {
          no = 1;
        } else {
          no = getMaxDataNo(".edit_dok") + 1;
        }
      }

      if (doc_category_inp == "" || doc_type_inp == "" || doc_desc_inp == "") {
        alert("Data tidak boleh kosong.");
      } else {
        dock_type_inp = doc_type_inp == 0 ? "Dokumen Internal" : "Dokumen Vendor";

        var html = "<tr>";
        html += "<td>" + no + "</td>";
        html += "<td class='text-left'><input type='hidden' class='doc_category_inp' value='" + doc_category_inp + "' name='doc_category_inp[" + no + "]' data-no='" + no + "'>" + doc_category_inp + "</td>";
        html += "<td class='text-left'><input type='hidden' class='doc_attachment_inp' value=" + doc_attachment_inp + " name='doc_attachment_inp[" + no + "]' data-no='" + no + "'>" +  "<a target='_blank' href='" + host + 'tender/' + doc_attachment_inp + "'>" + doc_attachment_inp + "</a></td>";
        html += "<td class='text-left'><input type='hidden' class='doc_type_inp' value=" + doc_type_inp + " name='doc_type_inp[" + no + "]' data-no='" + no + "'>" + doc_type_inp + "</td>";
        html += "<td class='text-left'><input type='hidden' class='doc_desc_inp' value=" + doc_desc_inp + " name='doc_desc_inp[" + no + "]' data-no='" + no + "'>" + doc_desc_inp + "</td>";
        html += "<td><button type='button' class='btn btn-info btn-sm edit_dok' data-no='" + no + "'><i class='fa fa-edit'></i></button></td>";
        html += "</tr>";

        $("#dok_table").append(html);
        $('#doc_category_inp').val("");
        $('#doc_attachment_inp').val("");
        $('#doc_type_inp').val("");
        $('#doc_desc_inp').val("");
      }
    });

    $(document.body).on("click", ".edit_dok", function() {

      var div_add = document.getElementById("showAddDok");
      var div_btn = document.getElementById("showButtonDok");
      div_btn.style.display = "flex";
      div_add.style.display = "flex";

      var no = $(this).attr('data-no');
      var doc_category_inp = $(".doc_category_inp[data-no='" + no + "']").val();
      var doc_attachment_inp = $(".doc_attachment_inp[data-no='" + no + "']").val();
      var doc_type_inp = $(".doc_type_inp[data-no='" + no + "']").val();
      var doc_desc_inp = $(".doc_desc_inp[data-no='" + no + "']").val();

      let inc = doc_attachment_inp.includes("name='doc_attachment_inp");
      doc_attachment_inp = inc ? '' : doc_attachment_inp
      console.log(inc);
      console.log(doc_attachment_inp);
      doc_type_inp = doc_type_inp ? "Dokumen Vendor" : "Dokumen Internal"

      $('#doc_category_inp').val(doc_category_inp);
      $('#doc_attachment_inp').val(doc_attachment_inp);
      $('#doc_type_inp').val(doc_type_inp);
      $('#doc_desc_inp').val(doc_desc_inp);
      $("#current_dok").val(no);

      $(this).parent().parent().remove();

      return false;

    });
    $(".empty_documents").click(function() {
      $('#doc_category_inp').val("");
      $('#doc_attachment_inp').val("");
      $('#doc_type_inp').val("");
      $('#doc_desc_inp').val("");
      var div_add = document.getElementById("showAddDok");
      var div_btn = document.getElementById("showButtonDok");
      div_btn.style.display = "none";
      div_add.style.display = "none";
    })
  });

  function isShowAddDoc() {
    var div_add = document.getElementById("showAddDok");
    var div_btn = document.getElementById("showButtonDok");
    if (div_add.style.display == "none") {
      div_add.style.display = "flex";
    } else {
      div_add.style.display = "none";
    }

    if (div_btn.style.display == "none") {
      div_btn.style.display = "flex";
    } else {
      div_btn.style.display = "none";
    }
  }

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