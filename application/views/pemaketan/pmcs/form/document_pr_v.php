<style>
  .rounded {
    border-radius: 0.55rem !important;
  }

  .wrapper-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
  }
</style>
<div class="row">
  <div class="card col-12">
    <div class="card-content">
      <div class="card-body">
        <div class="wrapper-header">
          <div class="title-header d-flex align-items-center">
            <h4 class="card-title">Lampiran Dokumen</h4>
            <a onclick="isDocProcurement()" class="btn btn-sm btn-info btn-tambah ml-2 rounded">
              <i class="ft ft-plus"></i>Tambah
            </a>
          </div>
          <div class="wrapper-button" id="btnLampiranProcurement" style="display: none;">
            <span class="wrapper-action save-comment">
              <a class="btn btn-sm btn-info btn-action-edit action_save_document">Simpan</a>
              <a onclick="resetFormDoc()" class="btn btn-sm btn-action-delete empty_item">
                <i class="fa fa-trash fa-lg"></i>
              </a>
              <input type="hidden" id="current_dok_lampiran_cr" value="" />
            </span>
          </div>
        </div>
        <div class="row" id="addLampiranProcurement" style="display: none;">
          <div class="col-md">
            <div class="col-md-12 row form-group mb-1">
              <label class="col-sm-4 control-label"><?php echo lang('category') ?></label>
              <div class="col-sm-8">
                <?php $curval = set_value("doc_category_inp_pr_cr"); ?>
                <select id="doc_category_inp_pr_cr" class="form-control bg-select" name="doc_category_inp_pr_cr[<?php echo $k ?>]" value="<?php echo $curval ?>">
                  <option value=""><?= lang('choose') ?></option>
                  <?php foreach ($doc_category as $key => $val) {
                    $selected = ($val['ldc_name'] == $curval) ? "selected" : "";
                  ?>
                    <option <?= $selected ?> value="<?= $val['ldc_name'] ?>"><?= $val['ldc_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="col-md-12 row form-group mb-1">
              <label class="col-sm-4 control-label"><?php echo lang('attachment') ?></label>
              <?php $curval = set_value("doc_attachment_inp_pr_cr[$k]"); ?>
              <div class="col-sm-8">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" data-id="doc_attachment_inp_pr_cr" data-folder="procurement/tender" data-preview="preview_file_lmprn" class="btn btn-info upload rounded" title="Upload">
                      <i class="fa fa-cloud-upload"></i> Up
                    </button>
                    <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/tender/' . $curval) ?>" class="btn btn-info preview_upload rounded mr-1" id="preview_file_lmprn">
                      <i class="fa fa-share"></i> View
                    </button>
                  </span>
                  <input readonly type="text" class="form-control" id="doc_attachment_inp_pr_cr" name="doc_attachment_inp_pr_cr" value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-id="doc_attachment_inp_pr_cr" data-folder="procurement/tender" data-preview="preview_file_lmprn" class="btn btn-danger removefile rounded ml-1">
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
          <div class="col-md">
            <div class="row form-group col-md-12">
              <?php $curval = set_value("doc_desc_inp_pr_cr[$k]"); ?>
              <label class="col-sm-4 control-label"><?php echo lang('description') ?></label>
              <div class="col-sm-8">
                <textarea id="doc_desc_inp_pr_cr" class="form-control" maxlength="1000" name="doc_desc_inp_pr_cr[<?php echo $k ?>]"><?php echo $curval ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- table -->
        <div id="lampiran_container">
          <div class="table-responsive table-striped">
            <table class="table" id="dok_table" style="margin-bottom: 0;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kategori</th>
                  <th>Lampiran</th>
                  <th>Deskripsi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $(document.body).on("click", ".edit_dok_pr_cr", function() {
      var no = $(this).attr('data-no');

      let category = $(".doc_category_inp_tbl_cr[data-no='" + no + "']").val()
      let file = $(".doc_attachment_inp_tbl_cr[data-no='" + no + "']").val()
      let desc = $(".doc_desc_inp_tbl_cr[data-no='" + no + "']").val()

      $('#doc_category_inp_pr_cr').val(category);
      $('#doc_attachment_inp_pr_cr').val(file);
      $('#doc_desc_inp_pr_cr').val(desc);
      $(this).parent().parent().remove();

    })

    $(".action_save_document").click(function() {

      var current_dok = $("#current_dok_lampiran_cr").val();
      var no = current_dok;
      var doc_id_inp = current_dok;
      var doc_category_inp = $('#doc_category_inp_pr_cr').val();
      var doc_attachment_inp = $('#doc_attachment_inp_pr_cr').val();
      var doc_desc_inp = $('#doc_desc_inp_pr_cr').val();

      if (current_dok == "") {
        if (getMaxDataNo(".edit_dok_pr_cr") == null) {
          no = 1;
        } else {
          no = getMaxDataNo(".edit_dok_pr_cr") + 1;
        }
      }

      if (doc_category_inp == "" || doc_category_inp == null || doc_attachment_inp == "" || doc_desc_inp == "") {
        alert("Data tidak boleh kosong.");
      } else {
        var html = "<tr>";
        html += "<td>" + no + "<input type='hidden' class='doc_id_inp_tbl_cr' value=" + doc_id_inp + " name='doc_id_inp_tbl_cr[" + no + "]' data-no='" + no + "'></td>";
        html += "<td class='text-left'><input type='hidden' class='doc_category_inp_tbl_cr' value='" + doc_category_inp + "' name='doc_category_inp_tbl_cr[" + no + "]' data-no='" + no + "'>" + doc_category_inp + "</td>";
        html += "<td class='text-left'><input type='hidden' class='doc_attachment_inp_tbl_cr' value=" + doc_attachment_inp + " name='doc_attachment_inp_tbl_cr[" + no + "]' data-no='" + no + "'>" +
          "<a href='" + document.location.origin + '/log/download_attachment/procurement/tender/' + doc_attachment_inp + "'>" + doc_attachment_inp + "</a></td>";
        html += "<td class='text-left'><input type='hidden' class='doc_desc_inp_tbl_cr' value=" + JSON.stringify(doc_desc_inp) + " name='doc_desc_inp_tbl_cr[" + no + "]' data-no='" + no + "'>" + doc_desc_inp + "</td>";
        html += "<td><button type='button' class='btn btn-info btn-sm edit_dok_pr_cr' data-no='" + no + "'><i class='fa fa-edit'></i></button></td>";
        html += "</tr>";

        $("#dok_table").append(html);
        resetFormDoc();
      }

    });

    $(".tutup").click(function() {

      $(".tambah_dok").show();
      var no = parseInt($(this).attr("data-no"));
      $("div.lampiran[data-no='" + no + "']").hide();

      return false;

    });

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

  function resetFormDoc() {
    $('#doc_category_inp_pr_cr').val("");
    $('#doc_attachment_inp_pr_cr').val("");
    $('#doc_desc_inp_pr_cr').val("");
  }

  function isDocProcurement() {
    var div = document.getElementById("addLampiranProcurement");
    var btnLampiranProcurement = document.getElementById("btnLampiranProcurement");
    if (div.style.display !== "none") {
      div.style.display = "none";
    } else {
      div.style.display = "flex";
    }
    // button
    if (btnLampiranProcurement.style.display !== "none") {
      btnLampiranProcurement.style.display = "none";
    } else {
      btnLampiranProcurement.style.display = "flex";
    }
  }
</script>