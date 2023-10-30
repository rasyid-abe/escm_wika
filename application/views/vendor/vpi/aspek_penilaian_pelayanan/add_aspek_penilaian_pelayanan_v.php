<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" id="form_aspek_penilaian_pelayanan" action="<?php echo site_url($controller_name."/vpi/aspek_penilaian_pelayanan/submit_add");?>"  class="form-horizontal">


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
               <!-- </div>
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
              <th width="10px">No</th>
              <th>Pertanyaan</th>
              <th width="100px">Nilai A (%)</th>
            </tr>
          </thead>

          <tbody id="pertanyaan_table">
          <?php 
          if (isset($pertanyaan)) {
          $no = 1;
          foreach ($pertanyaan as $key => $value){ ?> 
            <tr>
              <td><?php echo $no ?></td>
              <td>
                <?php echo $value['app_value'] ?> 
                <input type="hidden" name="app_id_inp[<?php echo $no-1 ?>]" value="<?php echo $value['app_id'] ?>">
              </td>
              <td><input type="text" required class="form-control money answer_inp" name="answer_inp[<?php echo $no-1 ?>]"></td>
            </tr>

           <?php $no++; } } ?>
          </tbody>
        </table>
        <div style="text-align: center"><a class="btn btn-primary" id="hitung_nilai" style="align-self: center">Hitung</a></div>
        
      </div>
    </div>
  </div>
</div>

<div class="row">
<div class="col-lg-12">
  <div class="card float-e-margins">
    <div class="card-header border-bottom pb-2">
      <h5 class="card-title">Nilai Akhir</h5>
      <div class="card-tools">
        <a class="collapse-link">
          <i class="fa fa-chevron-up"></i>
        </a>
      </div>
    </div>
    <div class="card-body">

    <div class="form-group" style="text-align: center;">
        <label><h3>Skor Penyedia Barang/jasa </h3></label><br>
        <h1><span id="hasil"></span></h1><br>
        <input type="hidden" name="nilai_akhir_inp" id="nilai_akhir_inp">
<!--     </div>
  
    <div class="form-group"> -->
      <label><h4>Nilai Maksimal (A) =  100 %</h4></label>
    </div>

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

<?php echo buttonsubmit('vendor/vpi/aspek_penilaian_pelayanan',lang('back'),lang('save')) ?>
  </form>

</div>

<script type="text/javascript"> 
  $(document).ready(function() {
    numeric_format();
    var default_pertanyaan = ""
    $('.tbl-pertanyaan').DataTable({
      searching: false,
      paging: false,
      autoWidth: false,
      columnDefs: [
        { "width": "10%", "targets": 2}
      ]
    });

    $('.answer_inp').keypress(function(e){
      if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
      {
          e.preventDefault();
      }
    });

     <?php if(!isset($pertanyaan)){ ?>
      alert('Pertanyaan Aspek Penilaian Pelayanan Belum dibuat');
    <?php } ?>

    var total_pertanyaan = <?php echo count($pertanyaan);?>;
      <?php if (isset($pertanyaan)) {
          $no = 1;
          foreach ($pertanyaan as $key => $value){ ?> 
           default_pertanyaan += '<tr>'+
              '<td><?php echo $no ?></td>'+
              '<td>'+
                '<?php echo $value['app_value'] ?> '+
                '<input type="hidden" name="app_id_inp[<?php echo $no-1 ?>]" value="<?php echo $value['app_id'] ?>">'+
              '</td>'+
              '<td><input type="text" required class="form-control money answer_inp" name="answer_inp[<?php echo $no-1 ?>]"></td>'+
            '</tr>';

           <?php $no++; } } ?>

           $('.answer_inp').keypress(function(e){
              if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
              {
                  e.preventDefault();
              }
            });

      $("#date_inp").change(function(event) {
        if ($(this).val() == "") {

          reset_form();

        }else{
        $('#pertanyaan_table').html("")
        $.ajax({
          url: "<?php echo site_url('vendor/vpi/aspek_penilaian_pelayanan/data_detail') ?>"+'/'+<?php echo $contract_data['contract_id'] ?>+'?date='+$(this).val(),
          dataType: 'json',
        })
        .done(function(data) {

          if (data != 'empty') {
          $('#form_aspek_penilaian_pelayanan').attr('action', "<?php echo site_url($controller_name."/vpi/aspek_penilaian_pelayanan/submit_edit");?>");//here
          var no = 1;
          var html = ""
          $.each(data.data_pertanyaan, function(index, val) {
             html += "<tr>"
             html += "<td>"+no+"</td>"+
              "<td>"+
                val.app_value+
                '<input type="hidden" name="app_id_inp['+(no-1)+']" value="'+val.vppa_pertanyaan_id+'">'+
                '<input type="hidden" name="vppa_id_inp['+(no-1)+']" value="'+val.vppa_id+'">'+
              "</td>"+
              "<td><input type='text' required class='form-control money answer_inp' name='answer_inp["+(no-1)+"]' value='"+val.vppa_value.replace(/\,/g, '').replace(".", ",")+"'></td>"+
            "</tr>";
            no = no+1;
          });
          $('#pertanyaan_table').html(html)

          $('.answer_inp').keypress(function(e){
            if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
            {
                e.preventDefault();
            }
          });

          if (data.data_note[0].vpp_response != '') {

            $('#response_inp').val(data.data_note[0].vpp_response);
            $('#response_inp option[value="'+data.data_note[0].vpp_response+'"]').attr("selected","selected");

          }

          if (data.data_note[0].vpp_title != ''){
            $("#title_inp").val(data.data_note[0].vpp_title); 
          }

          if (data.data_note[0].vpp_no_doc != ''){
            $("#no_doc_inp").val(data.data_note[0].vpp_no_doc); 
          }

          if (data.data_note[0].vpp_attach != ''){
            var file_attachment = data.data_note[0].vpp_attach;
            var url_file_attach = "<?php echo site_url('log/download_attachment/vendor/') ?>"+"/"+file_attachment
            $("#comment_file").attr('data-url', url_file_attach);
            $("#comment_attachment_inp").val(file_attachment);
          }

          if (data.data_note[0].vpp_note != ''){
            $('#note_inp').text(data.data_note[0].vpp_note);
          }

          if (data.data_note[0].vpp_final_score != ''){
             $('#hasil').html(data.data_note[0].vpp_final_score.replace(/\,/g, '').replace(".", ","))
            $('#nilai_akhir_inp').val(data.data_note[0].vpp_final_score.replace(/\,/g, '').replace(".", ","));
          }

          }else{

            reset_form();

          }
          console.log("success");
          numeric_format();
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

        $('#hitung_nilai').click(function() {
        var total_nilai = 0;
        for (var i = 0; i < total_pertanyaan; i++) {
          total_nilai += parseInt($('input[name="answer_inp['+i+']"]').val())
        }
        total_nilai = Math.round(total_nilai/total_pertanyaan/10)
        $('#hasil').html(total_nilai)
        $('#nilai_akhir_inp').val(total_nilai);
        $('#hitung_nilai').prop('disabled', true);
        });

       $('.answer_inp').on('change',function(event) {
        $('#hitung_nilai').prop('disabled', false);
        $('#hasil').html("0")
        $('#nilai_akhir_inp').val("");
      });
      }
        
      });

      function reset_form(){
            $('#form_aspek_penilaian_pelayanan').attr('action', "<?php echo site_url($controller_name."/vpi/aspek_penilaian_pelayanan/submit_add");?>");
            $('#title_inp').val("");
            $('#no_doc_inp').val("");
            $('#pertanyaan_table').html(default_pertanyaan);
            $("#comment_file").attr('data-url', "");
            $('#note_inp').text("");
            $("#comment_attachment_inp").val("")
            $('#hasil').html("")
            $('#nilai_akhir_inp').val("")
      }
      
      function numeric_format(){
          $("input.money").autoNumeric({
              aSep: '.',
              aDec: ',', 
              aSign: '',
              vMax:'100'
            });
      }

  });
</script>