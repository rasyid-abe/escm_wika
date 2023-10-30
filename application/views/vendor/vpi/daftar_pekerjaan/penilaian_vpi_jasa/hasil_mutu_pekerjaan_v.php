<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" id="form_aspek_penilaian_mutu" action="<?php echo site_url($controller_name."/vpi/daftar_pekerjaan/penilaian_vpi/".$vvh_id."/jasa/submit_mutu_pekerjaan");?>" class="form-horizontal">


    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-header border-bottom pb-2">
            <h5 class="card-title">Header</h5>
            
          </div>
          <div class="card-body">

            <input type="hidden" name="contract_id_inp" value="<?php echo isset($vvh_data['contract_id']) ? $vvh_data['contract_id'] : "" ?>">
            <input type="hidden" name="vvh_id_inp" value="<?php echo $vvh_id ?>">
            <input type="hidden" name="tipe_inp" value="jasa>">

            <?php $dept_id = isset($vvh_data['ptm_dept_id']) ? $vvh_data['ptm_dept_id'] : "" ?>
            <?php $dept_name = isset($vvh_data['ptm_dept_name']) ? $vvh_data['ptm_dept_name'] : "" ?>

            <div class="form-group">
              <label class="col-sm-2 control-label">Departemen</label>
              <div class="col-sm-10">
                <input type="hidden" name="dept_id_inp" class="form-control" value="<?php echo $dept_id ?>">
               <p class="form-control-static">
                <?php echo $dept_name ?>
               </p>
               </div>
            </div>

            <?php $vendor_id = isset($vvh_data['vendor_id']) ? $vvh_data['vendor_id'] : "" ?>
            <?php $vendor_name = isset($vvh_data['vendor_name']) ? $vvh_data['vendor_name'] : "" ?>

            <div class="form-group">
              <label class="col-sm-2 control-label">Penyedia Jasa</label>
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
                  <?php echo $vvh_data['subject_work'] ?>
                 </p>
               </div>
             </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-3">
                  <input type="hidden" name="date_inp" value="<?php echo $vvh_data['vvh_date'] ?>">
                  <p class="form-control-static">
                    <?php echo $vvh_data['vvh_date_text'] ?>
                  </p>
               </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Tipe</label>
                <div class="col-sm-3">
                  <input type="hidden" name="date_inp" value="<?php echo $vvh_data['vvh_date']; ?>">
                  <p class="form-control-static">
                    <?php echo ucfirst($vvh_data['vvh_tipe']); ?>
                  </p>
                  </p>
               </div>
            </div>

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
              <!-- <th width="10px">Nilai</th> -->
            </tr>
          </thead>
          
          <tbody id="pertanyaan_table">
          <?php 
          if (isset($pertanyaan)) {
          $no = 1;

          foreach ($pertanyaan as $key => $value){ 
            $disabled = $prev_data['vpm_ahm_id'] != $value['ahm_id'] ? "readonly" : "";
            $selected = $prev_data['vpm_ahm_id'] == $value['ahm_id'] ? "checked" : "";
            $curval = $prev_data['vpm_ahm_id'] == $value['ahm_id'] ? $prev_data['vpm_value'] : "";
            $nilai = substr($value['ahm_category'],6);
            ?> 
            <tr>
              <td><input type="radio" name="select_category" value="<?=$nilai ?>" onclick="clickRadio(<?php echo ($no-1) ?>,<?= $nilai ?>)" required class="radio_btn_mutu form-check-input select_category_<?php echo $no-1 ?>" data-no="<?php echo $no-1 ?>" <?php echo $selected ?>></td>
              <td><?php echo $no ?></td>
              <td>
                <?php echo $value['ahm_category'] ?> 
                <input type="hidden" name="ahm_id_inp" <?php echo $disabled ?> class="ahm_id_inp ahm_id_inp_<?php echo $no-1 ?>" value="<?php echo $value['ahm_id'] ?>">
              </td>
              <td>
                <?php echo $value['ahm_note'] ?> 
                <input type="hidden" id="answer_inp_<?php echo $no-1 ?>" class="form-control money answer_inp answer_inp_<?php echo $no-1 ?>" name="answer_inp" value="<?php echo $curval ?>">
              </td>
              <!-- <td></td> -->
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

      <?php $curval = isset($prev_data['vpm_attach']) ? $prev_data['vpm_attach'] : set_value('note_attachment_inp');
      $data_url = isset($prev_data['vpm_attach']) ? site_url('log/download_attachment/vendor/').'/'.$curval : '#';
       ?>
      <label class="col-sm-1 control-label">Lampiran</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" data-id="comment_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="comment_file" class="btn btn-primary upload">
                  <i class="fa fa-cloud-upload"></i> Upload
                </button> 
                <button type="button" data-url="<?php echo $data_url ?>" class="btn btn-primary preview_upload" id="comment_file">
                  <i class="fa fa-share"></i> Preview
                </button> 
              </span> 
              <input readonly type="text" class="form-control" id="comment_attachment_inp" name="note_attachment_inp" value="<?php echo $curval ?>">
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
        <?php $curval = isset($prev_data['vpm_note']) ? $prev_data['vpm_note'] : set_value('note_inp');?>
      <div class="form-group">
        <label class="col-sm-1 control-label">Catatan *</label>
        <div class="col-sm-11">
          <textarea name="note_inp" id="note_inp" required class="form-control" maxlength="1000" style="height: 80px"><?php echo $curval ?></textarea>
        </div>
      </div>

      </div>
      </div>
    </div>
</div>

<?php echo buttonsubmit('vendor/vpi/daftar_pekerjaan/penilaian_vpi/'.$vvh_id,lang('back'),lang('save')) ?>
  </form>

</div>

<script type="text/javascript"> 
function clickRadio(no,nilai) {
  $('.answer_inp').prop('disabled', true);
       $('.answer_inp').val("");
       
       $('#answer_inp_'+(no)).val(nilai);

}

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
      alert('Pertanyaan Hasil Mutu Pekerjaan Untuk Penyedia Jasa Belum dibuat');
    <?php } ?>

    $('.answer_inp').keypress(function(e){
      if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
      {
          e.preventDefault();
      }
    });

    

    numeric_format();
    $('.radio_btn').click(function(event) {
      var no = $(this).attr('data-no');
       $('.answer_inp').prop('disabled', true);
       $('.answer_inp').val("");
       $('.ahm_id_inp').prop('disabled', true);
       $('.answer_inp_'+no).prop('disabled', false);
       $('.ahm_id_inp_'+no).prop('disabled', false);
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
             $('.ahm_id_inp').prop('disabled', true);
             $('.answer_inp_'+no).prop('disabled', false);
             $('.ahm_id_inp_'+no).prop('disabled', false);
          });
    }


      function numeric_format(){
          $("input.money").autoNumeric({
              aSep: '.',
              aDec: ',', 
              aSign: '',
              vMax:'10',
              vMin:'0'
            });
      }

  });
</script>