<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <div class="btn-group-sm float-left">
          <span class="card-title text-bold-600 mr-2">Dokumen</span> <span><a onclick="isShowAddDok()" class="btn btn-info btn-sm"><i class="ft-plus"></i> Tambah</a></span>
        </div>
        <div class="btn-group-sm float-right position-relative">
          <a class="btn btn-info action_dok btn-plus">Simpan</a>
          <a class="btn btn-sm empty_dok btn-trash" title="Hapus"><i class="ft-trash"></i></a>
          <input type="hidden" id="current_dok" value="" />
        </div>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="showAddDok" style="display: none;">
            <div class="row mb-2">
              <!-- left-side -->
              <div class="col-md-6 row">
                <div class="form-group col-md-12 mb-1">
                  <label class="col-sm-4 control-label">Nama Dokumen <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="doc_name_inp" id="doc_name_inp" placeholder="Nama dokumen" />
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label class="col-sm-4 control-label">Keterangan <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="doc_desc_inp" id="doc_desc_inp" placeholder="Keterangan"></textarea>
                  </div>
                </div>
              </div>

              <!-- right-side -->
              <div class="col-md-6 row">
                <?php $curval = set_value("doc_attachment_inp"); ?>
                <div class="form-group col-md-12">
                  <label class="col-sm-4 control-label">Upload Dokumen <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "contract/document" ?>" data-preview="preview_file" class="btn btn-info upload mr-1" title="Upload"><i class="ft-upload"></i></button>
                      </span>
                      <input readonly type="text" class="form-control" id="doc_attachment_inp" name="doc_attachment_inp" value="<?php echo $curval ?>">
                      <span class="btn-group-">
                        <button type="button" data-url="<?php echo site_url("log/download_attachment/contract/document/" . $curval) ?>" class="btn btn-info preview_upload ml-1" id="preview_file" title="Preview"><i class="fa fa-share"></i></button>
                        <button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "contract/document" ?>" data-preview="preview_file" class="btn btn-danger removefile rounded">
                          <i class="fa fa-trash"></i>
                        </button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label class="col-sm-4 control-label">Kirim ke Vendor </label>
                  <div class="col-sm-8">
                    <div class='custom-switch custom-switch-info'>
                      <input type='checkbox' name='doc_vendor_inp' id='doc_vendor_inp' class='custom-control-input'>
                      <label class='custom-control-label' for='doc_vendor_inp'></label>
                    </div>                    
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="table-responsive">
            <table class="table" id="dok_table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Dokumen</th>
                  <th>Lampiran</th>
                  <th>Signor</th>
                  <th>Tanggal Upload</th>
                  <th>Keterangan</th>
                  <th>Kirim Vendor</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                <?php
                $no = 1;
                if (isset($document) && !empty($document)) {
                  foreach ($document as $key => $value) {
                    $myid = $key + 1;
                ?>

                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td>
                        <input type="hidden" value="<?php echo $value['name_input'] ?>" name="doc_name[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="doc_name">
                        <?php echo $value['name_input'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['filename'] ?>" name="doc_attachment[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="doc_attachment">
                        <a href='<?php echo site_url("log/download_attachment/contract/document/" . $value['filename']) ?>' target="_blank"><?php echo $value['filename'] ?></a>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['signor'] ?>" name="doc_name_signor[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="doc_name_signor">
                        <?php echo $value['signor'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['upload_date'] ?>" name="upload_date_inp[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="upload_date_inp">
                        <?php echo $value['upload_date'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['description'] ?>" name="doc_desc[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="doc_desc">
                        <?php echo $value['description'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['publish'] ?>" name="doc_vendor[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="doc_vendor">
                        <?php echo $value['publish'] == '1' ? 'Ya' : 'Tidak'; ?>
                      </td>
                      <td>
                        <button data-no="<?php echo $myid ?>" class="btn btn-info btn-sm edit_dok" type="button">
                          <i class="fa fa-edit"></i>
                          <?php  ?>
                          <input type="hidden" name="doc_id_inp[<?php echo $myid ?>]" value="<?php echo $myid ?>" />
                        </button>
                      </td>
                    </tr>

                <?php }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $(".action_dok").click(function() {

      var url_file = '<?php echo site_url("log/download_attachment/contract/document/") ?>';
      var current_dok = $("#current_dok").val();
      var no = current_dok;
      var doc_vendor = $("#doc_vendor_inp").val();
      var doc_name = $("#doc_name_inp").val();
      var doc_desc = $("#doc_desc_inp").val();
      var doc_attachment = $("#doc_attachment_inp").val();      
      var isCheckedVendor = "";

      var today = new Date();
      var upload_date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();  

      if (doc_vendor == "on") {
        isCheckedVendor = "Ya";
      } else {
        isCheckedVendor = "Tidak";
      }

      if (current_dok == "") {
        if (getMaxDataNo(".edit_dok") == null) {
          no = 1;
        } else {
          no = getMaxDataNo(".edit_dok") + 1;
        }

      } else {}

      if (doc_name == "" || doc_desc == "") {

        alert("Data tidak boleh kosong.");

      } else {

        var html = "<tr>";
        html += "<td>" + no + "</td>";
        html += "<td class='text-left'><input type='hidden' class='doc_name' data-no='" + no + "' name='doc_name[" + no + "]' value='" + doc_name + "'/>" + doc_name + "</td>";
        html += "<td class='text-right'><input type='hidden' class='doc_attachment' data-no='" + no + "' name='doc_attachment[" + no + "]' value='" + doc_attachment + "'/><a href='" + url_file + doc_attachment + "' target='_blank'>" + doc_attachment + "</a></td>";
        html += "<td class='text-left'><input type='hidden' class='signor' data-no='" + no + "' name='signor[" + no + "]' value=''/></td>";
        html += "<td class='text-left'><input type='hidden' class='upload_date' data-no='" + no + "' name='upload_date[" + no + "]' value=''/>" + upload_date + "</td>";
        html += "<td class='text-left'><input type='hidden' class='doc_desc' data-no='" + no + "' name='doc_desc[" + no + "]' value='" + doc_desc + "'/>" + doc_desc + "</td>";
        html += "<td class='text-left'><input type='hidden' name='doc_vendor[" + no + "]' class='doc_vendor[" + no + "]' value='" + isCheckedVendor + "'>" + isCheckedVendor + "</td>";
        html += "<td><button type='button' class='btn btn-info btn-sm edit_dok' data-no='" + no + "'><i class='fa fa-edit'></i></button></td>";
        html += "</tr>";

        $("#dok_table").append(html);
        $("#current_dok").val("");
        $("#doc_name_inp").val("");
        $("#doc_desc_inp").val("");
        $("#doc_attachment_inp").val("");
      }

    });

    $(document.body).on("click", ".empty_dok", function() {
      $("#current_dok").val("");
      $("#doc_name_inp").val("");
      $("#doc_desc_inp").val("");
      $("#doc_attachment_inp").val("");
    });

    $(document.body).on("click", ".edit_dok", function() {
      var no = $(this).attr('data-no');
      var doc_vendor = $(".doc_vendor[data-no='" + no + "']").val();
      var doc_name = $(".doc_name[data-no='" + no + "']").val();
      var doc_desc = $(".doc_desc[data-no='" + no + "']").val();
      var signor = $(".signor[data-no='" + no + "']").val();
      var upload_date = $(".upload_date[data-no='" + no + "']").val();
      var doc_attachment = $(".doc_attachment[data-no='" + no + "']").val();

      $("#current_dok").val(no);
      $("#doc_vendor_inp").val(doc_vendor);
      $("#doc_name_inp").val(doc_name);
      $("#doc_desc_inp").val(doc_desc);
      $("#doc_attachment_inp").val(doc_attachment);


      $(this).parent().parent().remove();

      return false;

    });

  })  
  
  function isShowAddDok() {
		var div_add = document.getElementById("showAddDok");
		var div_btn = document.getElementById("showButtonDok");
		if (div_add.style.display !== "none") {
			div_add.style.display = "none";
		} else {
			div_add.style.display = "block";
		}

    if (div_btn.style.display !== "none") {
			div_btn.style.display = "none";
		} else {
			div_btn.style.display = "block";
		}
	}  

</script>
