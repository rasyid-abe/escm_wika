<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url("/vendor/vendor_tools/doc_vendor/submit_edit"); ?>" class="form-horizontal ajaxform">

    <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>HEADER</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">

            <?php $curval = !empty(set_value("nama_inp")) ? set_value("nama_inp") : $data['avd_name']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Judul Template *</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" required id="nama_inp" name="nama_inp" value="<?php echo $curval ?>">
              </div>
            </div>

            <?php $curval = !empty(set_value("vnd_type_inp")) ? set_value("vnd_type_inp") : $data['vtm_id']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tipe Vendor *</label>
              <div class="col-sm-4">
                <select name="vnd_type_inp" class="form-control" id="vnd_type_inp" required>
                  <option>Pilih</option>
                  <?php foreach ($vnd_type as $key => $value) { ?>
                    <option value="<?php echo $value['vtm_id'] ?>" <?= $value['vtm_id'] == $curval ? "selected" : "" ?> >
                        <?php echo $value['vtm_name'].' - '.$value['vtm_description'] ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <?php $curval = !empty(set_value("status_inp")) ? set_value("status_inp") : $data['status']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Status</label>
              <div class="col-sm-4">
                <input id="status_inp" name="status_inp" <?= ($curval == 'on' OR $curval == 'Aktif') ? "checked" : "" ?> type="checkbox" data-toggle="toggle" data-on="Aktif" data-off="Non Aktif">
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>Dokumen</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">
            <div id="doc_item_form">
            <?php $curval = set_value("item"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama Dokumen</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="item" name="item" value="<?php echo $curval ?>">
                <input type="hidden" name="item_id" id="item_id" value="">
              </div>
            </div>

            <?php $curval = set_value("status_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Referensi Dokumen</label>
              <div class="col-sm-4">
                <input id="is_document" class="is_document" type="checkbox" data-toggle="toggle" data-on="Ada" data-off="Tidak Ada">
              </div>
            </div>

        <?php $curval = "" ?>
				<div class="form-group" id="doc_attachment">
					<label class="col-sm-2 control-label">Lampiran Referensi</label>
					<div class="col-sm-7">
				    	<div class="input-group">
				      		<span class="input-group-btn">
				        		<button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "vendor/documentpq" ?>" data-preview="preview_file" class="btn btn-primary upload">
				          			<i class="fa fa-cloud-upload"></i>
				        		</button> 
				        		<button type="button" data-id="doc_attachment_inp" data-folder="<?php echo "vendor/documentpq" ?>" data-preview="preview_file" class="btn btn-danger removefile">
				          			<i class="fa fa-remove"></i>
				        		</button> 
				      		</span> 
				      		<input readonly type="text" class="form-control" id="doc_attachment_inp" name="doc_attachment_inp" value="<?php echo $curval ?>">
				      		<span class="input-group-btn">
				        		<button type="button" data-url="<?php echo site_url("log/download_attachment/vendor/documentpq/".$curval) ?>" class="btn btn-primary preview_upload" id="preview_file">
				          			<i class="fa fa-share"></i>
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



            <?php $curval = set_value("jenis_doc"); ?>
            <div class="form-group" style="display: none;">
              <label class="col-sm-2 control-label">Jenis Dokumen</label>
              <div class="col-sm-8">
                <div class="radio">
                  <label>
                    <?php $selected = (0 == $curval) ? "checked" : "";  ?>
                    <input type="radio" <?php echo $selected ?> class="jenis_doc" name="jenis_doc" value="EXP"> Dengan masa berlaku
                  </label>
                  <br>
                  <p>
                    <p>
                      <label>
                        <?php $selected = (1 == $curval) ? "checked" : "";  ?>
                        <input type="radio" <?php echo $selected ?> class="jenis_doc" name="jenis_doc" value="IMO"> Tanpa masa berlaku
                      </label>
                </div>
              </div>
            </div>

            <center>
              <a class="btn btn-primary action_item">Tambah</a>
              <input type="hidden" id="current_item" value="" />
              <br>
            </center>
            </div>

            <hr>

            <table align="center" class="table table-bordered" id="item_table" style="max-width: 90%">
              <thead>
                <tr>
                  <th style="width:15%">
                    <center>#</center>
                  </th>
                  <th style="width:55%">
                    <center>Nama Dokumen</center>
                  </th>
                  <th style="width:30%;display:none;">
                    <center>Jenis Dokumen</center>
                  </th>
                  <th style="width:30%">
                    <center>Referensi Dokumen</center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($detail as $key => $value) { ?>
                  <tr>
                    <td>
                      <center>
                        <button type='button' class='btn btn-primary btn-xs edit_item' data-no='<?php echo $key ?>'><i class='fa fa-edit'></i>
                        </button>
                        <button type='button' class='btn btn-danger btn-xs delete_item' data-no='<?php echo $key ?>'><i class='fa fa-remove'></i>
                        </button>
                      </center>
                    </td>
                    <td>
                      <input type="hidden" class="item_id" name="item_id[<?= $key?>]" data-no="<?= $key ?>" value="<?= $value['vdd_id'] ?>">
                      <input type='hidden' class='item_name' data-no='<?php echo $key ?>' name='item_name[<?php echo $key ?>]' value='<?php echo $value['vdd_name'] ?>' /><?php echo $value['vdd_name'] ?>
                    </td>
                    <td style="display: none;">
                      <input type='hidden' class='item_jenis' data-no='<?php echo $key ?>' name='item_jenis[<?php echo $key ?>]' value='<?php echo $value['vdd_type'] ?>' /><?php echo ($value['vdd_type'] == "EXP") ? "Dengan masa berlaku" : "Tanpa masa berlaku" ?>
                    </td>
                    <td>
                    <input type='hidden' class='ref_document_inp' data-no='<?php echo $key ?>' name='ref_document_inp[<?php echo $key ?>]' value='<?php echo $value['vdd_ref_document_pq'] ?>''/>

                      <a href="<?php echo site_url('log/download_attachment/vendor/documentpq/' . $value['vdd_ref_document_pq']) ?>" target="_blank">
                        <?php echo $value['vdd_ref_document_pq'] ?>
                      </a>                   
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>

    <?php echo buttonsubmit('vendor/vendor_tools/doc_vendor', lang('back'), lang('save')) ?>

  </form>

</div>


<script type="text/javascript">
  $(document).ready(function() {

    if(parseInt($("#item_table tr").length)-1 >= 10){
        $('#doc_item_form').hide()
    }

    if ($("#is_document").prop('checked')==false) {
      $('#doc_attachment').hide()
    }

    $('.is_document').change(function() {
        if(this.checked) {
            $('#doc_attachment').show()
          } else {
            $('#doc_attachment').hide()
        }       
    });

    var no;

    $(".action_item").click(function() {

      var current_item = $("#current_item").val();
      no = current_item;

      if (current_item == "") {
        no = ($("#item_table tr").length) ? parseInt($("#item_table tr").length) : 1;
      }

      var item = $("#item").val();
      var item_id = $("#item_id").val();
      var jenis = $(".jenis_doc:checked").val();
      var jenis_name = (jenis == "EXP") ? "Dengan masa berlaku" : "Tanpa masa berlaku";
      let refDocumentPQ = $("#doc_attachment_inp").val();



      if (item == "") {
        $("#item").prop('required', true);
        $('#item')[0].reportValidity();
        // alert("Isi item");
        // setTimeout(function(){$("#item").prop('required', false)},2000)

      } else {

        var html = `<tr>
          <td>
            <center>
              <button type='button' class='btn btn-primary btn-xs edit_item' data-no='${no}'>
                <i class='fa fa-edit'></i>
              </button> 
              <button type='button' class='btn btn-danger btn-xs delete_item' data-no='${no}'>
                <i class='fa fa-remove'></i>
              </button>
            </center>
          </td>
          <td>
          <input type='hidden' class='item_id' data-no='${no}' name='item_id[${no}]' value='${item_id}'/>${item}</td>
            <input type='hidden' class='item_name' data-no='${no}' name='item_name[${no}]' value='${item}'/>${item}</td>
          <td style="display:none">
            <input type='hidden' class='item_jenis' data-no='${no}' name='item_jenis[${no}]' value='${jenis}'/>${jenis_name}
          </td>
          <td>
            <input type='hidden' class='ref_document_inp' data-no='${no}' name='ref_document_inp[${no}]' value='${refDocumentPQ}'/>

              <a href="<?php echo site_url("log/download_attachment/vendor/documentpq") ?>/${refDocumentPQ}" target="_blank">
                ${refDocumentPQ || "Tidak Ada Referensi"}
              </a>                   
            </td>
        </tr>`;

        if (no <= 10 ) {

          $("#item_table").append(html);

          $("#current_item").val("");
          $("#item").val("");
          $("#item_id").val("");

          $(".edit_item,.delete_item").show();
          
        }
        if(no >= 10){

          $('#doc_item_form').hide()
        }

      }

    });

    $(document.body).on("click", ".edit_item", function(e) {
      e.preventDefault();

      $(".edit_item,.delete_item").hide();
      $('#doc_item_form').show()

      var dataNo = $(this).attr('data-no');
      var item = $(".item_name[data-no='" + dataNo + "']").val();
      var item_id = $(".item_id[data-no='" + dataNo + "']").val();
      var jenis = $(".item_jenis[data-no='" + dataNo + "']").val();
      let ref_document_inp = $(".ref_document_inp[data-no='" + dataNo + "']").val();


      $("#current_item").val(dataNo);
      $("#item").val(item);
      $("#item_id").val(item_id);
      $(".jenis_doc[value='" + jenis + "']").prop("checked", true);
      $("#doc_attachment_inp").val(ref_document_inp);

      if (ref_document_inp) {
            $('#doc_attachment').show()
            $('.is_document').parent().removeClass('btn-default off')
            $('.is_document').parent().addClass('btn-primary')
      } else {
        $('#doc_attachment').hide()
            $('.is_document').parent().addClass('btn-default off')
            $('.is_document').parent().removeClass('btn-primary')
      }
      $(this).closest('tr').remove();
      // $(this).parent().parent().parent().remove();

      return false;

    });

    $(document.body).on("click", ".delete_item", function(e) {

      if (confirm("Are you sure want to delete this item?")) {
        e.preventDefault();
        $(this).closest('tr').remove();
        // $(this).parent().parent().parent().remove();
        if (no <= 10) {
          $('#doc_item_form').show()
        }

      }

      return false;

    });

    $("button[type='submit']").click(function(e) {

      var current_item = $("#current_item").val();
      $("#item").prop('required', false)
      if (current_item != "") {
        alert("Data item harus di simpan.");
        return false;
      }

    })

  })
</script>