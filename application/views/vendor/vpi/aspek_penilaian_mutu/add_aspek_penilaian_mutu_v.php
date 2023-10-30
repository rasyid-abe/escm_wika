<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" id="form_aspek_penilaian_mutu" action="<?php echo site_url($controller_name."/vpi/aspek_penilaian_mutu/submit_add");?>"  class="form-horizontal">


    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-header border-bottom pb-2">
            <h5 class="card-title">Header</h5>
            
          </div>
          <div class="card-body">

            <input type="hidden" name="contract_id_inp" value="<?php echo isset($contract_data['contract_id']) ? $contract_data['contract_id'] : "" ?>">

            <?php $dept_id = isset($contract_data['ptm_dept_id']) ? $contract_data['ptm_dept_id'] : "" ?>
            <?php $dept_name = isset($contract_data['ptm_dept_name']) ? $contract_data['ptm_dept_name'] : "" ?>

            <div class="form-group">
              <label class="col-sm-2 control-label">Departemen</label>
              <div class="col-sm-10">
                <input type="hidden" name="dept_id_inp" class="form-control" value="<?php echo $dept_id ?>">
               <p class="form-control-static">
                <?php echo $dept_name ?>
               </p>
               </div>
            </div>

            <?php $vendor_id = isset($contract_data['vendor_id']) ? $contract_data['vendor_id'] : "" ?>
            <?php $vendor_name = isset($contract_data['vendor_name']) ? $contract_data['vendor_name'] : "" ?>

            <div class="form-group">
              <label class="col-sm-2 control-label">Penyedia Barang/Jasa</label>
              <div class="col-sm-10">
                <input type="hidden" name="vendor_id_inp" class="form-control" value="<?php echo $vendor_id ?>">
               <p class="form-control-static">
                 <?php echo $vendor_name ?>
               </p>
               </div>
             </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Deskripsi Pengadaan</label>
                <div class="col-sm-10">
                 <p class="form-control-static">
                  <?php echo $contract_data['subject_work'] ?>
                 </p>
               </div>
             </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Bulan *</label>
                <div class="col-sm-3">
                  <select name='date_inp' class="form-control select2" id="date_inp" required> 
                    <option value="">Pilih</option>
                    <?php if (isset($date_range)) { 
                      foreach ($date_range['text'] as $key => $value) { ?>

                      <option value="<?php echo $date_range['val'][$key] ?>"><?php echo $value ?></option>
                        
                    <?php }
                      
                     } ?>
                  </select>
               </div>
            </div>

            <!-- <div class="form-group">
                <label class="col-sm-2 control-label">No Dokumen</label>
                <div class="col-sm-10">
                  <input type="text" name="no_doc_inp" id="no_doc_inp" class="form-control"> -->
                 <!-- <p class="form-control-static">

                 </p> -->
              <!--  </div>
             </div> -->

            <!-- <div class="form-group">
                <label class="col-sm-2 control-label">Judul *</label>
                <div class="col-sm-10">
                <input type="text" name="title_inp" id="title_inp" required class="form-control" value=""> -->
                 <!-- <p class="form-control-static">
                 </p> -->
               <!-- </div>
            </div> -->

       </div>
     </div>
    </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-header border-bottom pb-2">
            <h5 class="card-title">Penilaian *</h5>
            
          </div>
          <div class="card-body">
           <table class="table table-bordered tbl-pertanyaan">
          <thead>
            <tr>
              <th width="10px">#</th>
              <th width="10px">No</th>
              <th>Kategori Nilai</th>
              <th>Penjelasan</th>
              <th width="10px">Nilai</th>
            </tr>
          </thead>

          <tbody id="pertanyaan_table">
          <?php 
          if (isset($pertanyaan)) {
          $no = 1;
          foreach ($pertanyaan as $key => $value){ ?> 
            <tr>
              <td><input type="radio" name="select_category" required class="radio_btn form-check-input select_category_<?php echo $no-1 ?>" data-no="<?php echo $no-1 ?>"></td>
              <td><?php echo $no ?></td>
              <td>
                <?php echo $value['apm_category'] ?> 
                <input type="hidden" name="apm_id_inp" disabled class="apm_id_inp apm_id_inp_<?php echo $no-1 ?>" value="<?php echo $value['apm_id'] ?>">
              </td>
              <td>
                <?php echo $value['apm_note'] ?> 
              </td>
              <td><input type="text" disabled required class="form-control money answer_inp answer_inp_<?php echo $no-1 ?>" name="answer_inp"></td>
            </tr>

           <?php $no++; } } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-header border-bottom pb-2">
        <h5 class="card-title">Catatan</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
      <div class="form-group">
          <label class="col-sm-1 control-label">Aksi *</label>
          <div class="col-sm-5">
            <select required name="response_inp" id="response_inp" class="form-control" style="width:100%;">
              <option value="">Pilih</option>
              <option value="0">Simpan Sementara</option>
              <option value="1">Simpan</option>
            </select>
         </div>


      <label class="col-sm-1 control-label">Lampiran</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" data-id="comment_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="comment_file" class="btn btn-primary upload">
                  <i class="fa fa-cloud-upload"></i> Upload
                </button> 
                <button type="button" data-url="#" class="btn btn-primary preview_upload" id="comment_file">
                  <i class="fa fa-share"></i> Preview
                </button> 
              </span> 
              <input readonly type="text" class="form-control" id="comment_attachment_inp" name="note_attachment_inp" value="">
              <span class="input-group-btn">
                <button type="button" data-id="comment_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="comment_file" class="btn btn-danger removefile">
                  <i class="fa fa-trash"></i> Delete
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

      <div class="form-group">
        <label class="col-sm-1 control-label">Catatan *</label>
        <div class="col-sm-11">
          <textarea name="note_inp" id="note_inp" required class="form-control" maxlength="1000" style="height: 80px"></textarea>
        </div>
      </div>

      </div>
      </div>
    </div>
</div>

<?php echo buttonsubmit('vendor/vpi/aspek_penilaian_mutu',lang('back'),lang('save')) ?>
  </form>

</div>

<script type="text/javascript"> 
  $(document).ready(function() {
    $('.tbl-pertanyaan').DataTable({
      searching: false,
      paging: false,
      autoWidth: false,
      columnDefs: [
        { "width": "10%", "targets": 4 }
      ]
    });

    <?php if(!isset($pertanyaan)){ ?>
      alert('Pertanyaan Aspek Penilaian Mutu Belum dibuat');
    <?php } ?>

    $('.answer_inp').keypress(function(e){
      if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
      {
          e.preventDefault();
      }
    });

    var pertanyaan_default = ""
    var jml_pertanyaan = <?php echo count($pertanyaan); ?>;
    <?php 
          if (isset($pertanyaan)) {

          $no = 1;
      foreach ($pertanyaan as $key => $value){ ?> 

        pertanyaan_default += "<tr>"+
              '<td><input type="radio" name="select_category" required class="radio_btn form-check-input select_category_<?php echo $no-1 ?>" data-no="<?php echo $no-1 ?>"></td>'+
              '<td><?php echo $no ?></td>'+
              '<td>'+
                '<?php echo $value['apm_category'] ?> '+
                '<input type="hidden" name="apm_id_inp" disabled class="apm_id_inp apm_id_inp_<?php echo $no-1 ?>" value="<?php echo $value['apm_id'] ?>">'+
              '</td>'+
              '<td>'+
                '<?php echo $value['apm_note'] ?> '+
              '</td>'+
              '<td><input type="text" disabled required class="form-control money answer_inp answer_inp_<?php echo $no-1 ?>" name="answer_inp"></td>'+
            '</tr>';

    <?php $no++; }} ?>

    numeric_format();
    $('.radio_btn').click(function(event) {
      var no = $(this).attr('data-no');
       $('.answer_inp').prop('disabled', true);
       $('.answer_inp').val("");
       $('.apm_id_inp').prop('disabled', true);
       $('.answer_inp_'+no).prop('disabled', false);
       $('.apm_id_inp_'+no).prop('disabled', false);
    });

    function reset_form(){

      $('#form_aspek_penilaian_mutu').attr('action', "<?php echo site_url($controller_name."/vpi/aspek_penilaian_mutu/submit_add");?>");
      $('#title_inp').val("");
      $('#no_doc_inp').val("");
      $('#response_inp').prop('disabled', false);
      $('#response_inp').val("");
      $('#pertanyaan_table').html(pertanyaan_default)
      $('#response_inp option[value=""]').attr("selected","selected");
      $('#note_attach').html("")
      $("#comment_file").attr('data-url', "");
      $("#comment_attachment_inp").val("");
      $('#note_inp').text("");

          $('.radio_btn').click(function(event) {
            var no = $(this).attr('data-no');
             $('.answer_inp').prop('disabled', true);
             $('.answer_inp').val("");
             $('.apm_id_inp').prop('disabled', true);
             $('.answer_inp_'+no).prop('disabled', false);
             $('.apm_id_inp_'+no).prop('disabled', false);
          });
    }

    $("#date_inp").change(function(event) {
    if ($(this).val() == "") {

      reset_form();

    }else{

        $.ajax({
          url: "<?php echo site_url('vendor/vpi/aspek_penilaian_mutu/data_detail') ?>"+'/'+<?php echo $contract_data['contract_id'] ?>+'?date='+$(this).val(),
          dataType: 'json',
        }).done(function(data) {
          if (data != 'empty') {
            $('#form_aspek_penilaian_mutu').attr('action', "<?php echo site_url($controller_name."/vpi/aspek_penilaian_mutu/submit_edit");?>");
          var no = 1;
          var html = ""
          var exist = ""
          

          if (data.data_note[0].vpm_response != '') {

            $('#response_inp').val(data.data_note[0].vpm_response);
            $('#response_inp option[value="'+data.data_note[0].vpm_response+'"]').attr("selected","selected");

          }

          if (data.data_note[0].vpm_title != ''){
            $("#title_inp").val(data.data_note[0].vpm_title); 
          }

          if (data.data_note[0].vpp_no_doc != ''){
            $("#no_doc_inp").val(data.data_note[0].vpm_no_doc); 
          }

          if (data.data_note[0].vpm_attach != ''){
            var file_attachment = data.data_note[0].vpm_attach;
            var url_file_attach = "<?php echo site_url('log/download_attachment/vendor/') ?>"+"/"+file_attachment
            $("#comment_file").attr('data-url', url_file_attach);
            $("#comment_attachment_inp").val(file_attachment);
          }

          if (data.data_note[0].vpm_note != ''){
            $('#note_inp').text(data.data_note[0].vpm_note);
          }


           html += "<tr>"
           html += "<td><input type='radio' name='select_category' required class='radio_btn form-check-input' data-no='<?php echo $no-1 ?>' checked></td>"+
           "<td>"+no+"</td>"+
              "<td>"+data.data_pertanyaan[0].apm_category+
              "<input type='hidden' name='apm_id_inp' class='apm_id_inp apm_id_inp_<?php echo $no-1 ?>' value='"+data.data_pertanyaan[0].vpm_apm_id+"'></td>"+
              "<td>"+data.data_pertanyaan[0].apm_note+"</td>"+
              "<td> <input type='text' required class='form-control money answer_inp answer_inp_<?php echo $no-1 ?>' name='answer_inp' value='"+data.data_note[0].vpm_answer+"'></td>"+
            "</tr>";

          for (var i = 0; i < jml_pertanyaan; i++) {
            if ($('.apm_id_inp_'+i).val() == data.data_pertanyaan[0].apm_id) {
              if (exist == "") {
                exist = "true"
                $('.answer_inp').val("")
                $('.answer_inp').prop('disabled', true);
                $('.apm_id_inp').prop('disabled', true);
                $('.select_category_'+i).prop('checked', true);
                $('.apm_id_inp_'+i).prop('disabled', false);
                $('.answer_inp_'+i).prop("disabled", false);
                $('.answer_inp_'+i).val(data.data_note[0].vpm_answer.replace(/\,/g, '').replace(".", ","))
                
                return false;
              }
            }
            exist = exist
          }
          $('#pertanyaan_table').append(html)
          $('.answer_inp').keypress(function(e){
            if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
            {
                e.preventDefault();
            }
          });
            
            $('.radio_btn').click(function(event) {
            var no = $(this).attr('data-no');
             $('.answer_inp').prop('disabled', true);
             $('.answer_inp').val("");
             $('.apm_id_inp').prop('disabled', true);
             $('.answer_inp_'+no).prop('disabled', false);
             $('.apm_id_inp_'+no).prop('disabled', false);
          });

        }else{

          reset_form();

        }
          console.log("success");
        

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });;
    }

  });


      function numeric_format(){
          $("input.money").autoNumeric({
              aSep: '.',
              aDec: ',', 
              aSign: '',
              vMax:'10'
            });
      }

  });
</script>