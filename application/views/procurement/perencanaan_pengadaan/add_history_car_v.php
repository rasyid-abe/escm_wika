<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_pembuatan_history_car");?>"  class="form-horizontal ajaxform">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>HEADLINE</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">

             <?php $curval = set_value("name_inp")?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Nama Pengadaan *</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required name="name_inp" value="<?php echo $curval ?>" maxlength="255">
            </div>
          </div>

          <?php $curval = set_value("type_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tipe Penggadaan *</label>
              <div class="col-sm-3">
              <select required class="form-control select2" name="type_inp">
                <option value=""><?php echo lang('choose') ?></option>
                <option value="Baru"><?php echo ('Baru') ?></option>
                <option value="Perpanjangan"><?php echo ('Perpanjangan') ?></option>
                </select>
              </div>
            </div>

          <?php $curval = set_value("dept_inp") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Divisi/Departemen *</label>
            <div class="col-sm-3">
            <select required class="form-control select2" name="dept_inp">
              <option value=""><?php echo lang('pilih') ?></option>
              <?php foreach($division as $key => $val){
                $selected = ($key == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <?php $curval = $userdata['complete_name']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">User *</label>
              <div class="col-sm-10">
               <input type="text" disabled class="form-control" required name="user_inp" value="<?php echo $curval ?>">
             </div>
           </div>

           <?php $curval = set_value("progress_inp") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Progress *</label>
              <div class="col-sm-3">
              <select required class="form-control select2" name="progress_inp">
                <option value=""><?php echo lang('choose') ?></option>
                <option value="Permintaan Pengadaan CAR dari Proyek"><?php echo ('Permintaan Pengadaan CAR dari Proyek') ?></option>
                <option value="Permintaan Penawaran dari Penyedia"><?php echo ('Permintaan Penawaran dari Penyedia') ?></option>
                <option value="Pemasukan Penawaran"><?php echo ('Pemasukan Penawaran') ?></option>
                <option value="Pembukaan Penawaran"><?php echo ('Pembukaan Penawaran') ?></option>
                <option value="Evaluasi Administrasi, Teknis, dan Harga"><?php echo ('Evaluasi Administrasi, Teknis, dan Harga') ?></option>
                <option value="Klarifikasi dan Negosiasi"><?php echo ('Klarifikasi dan Negosiasi') ?></option>
                <option value="Evaluasi Hasil Negosiasi"><?php echo ('Evaluasi Hasil Negosiasi') ?></option>
                <option value="Pengumuman Pemenang"><?php echo ('Pengumuman Pemenang') ?></option>
                <option value="Masa Sanggah"><?php echo ('Masa Sanggah') ?></option>
                <option value="Penunjukan Pemenang"><?php echo ('Penunjukan Pemenang') ?></option>
                </select>
              </div>
            </div>

</div>
</div>
</div>
</div>

<div class="row">
  <div class="col-lg-12">
    <center>
      <a class="btn btn-primary tambah_dok">Tambah Lampiran</a>
      <br/>
      <br/>
    </center>
  </div>

</div>

<div id="lampiran_container">

  <?php for ($k = 0; $k <= 100; $k++) { 
    $show = ($k == 0) ? "" : "display:none;";
    ?>

    <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>LAMPIRAN DOKUMEN #<?php echo $k ?></h5>
            <div class="card-tools">

             <?php if($k > 0){ ?>
             <a class="tutup" data-no="<?php echo $k ?>">
              <i class="fa fa-times"></i>
            </a>
            <?php } ?>

            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

            <?php $curval = set_value("doc_attachment_inp[$k]"); ?>
            <div class="form-group">
            <label class="col-sm-1 control-label"><?php echo lang('attachment') ?></label>
            <div class="col-sm-6">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                    <i class="fa fa-cloud-upload"></i> Upload
                  </button> 
                  <button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/$dir/$curval" ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                    <i class="fa fa-share"></i> Preview
                  </button> 
                </span> 
                <input readonly type="text" class="form-control" id="doc_attachment_inp_<?php echo $k ?>" name="doc_attachment_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                <span class="input-group-btn">
                  <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-danger removefile">
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

          <?php $curval = set_value("doc_desc_inp[$k]"); ?>
          <div class="form-group">
            <label class="col-sm-1 control-label"><?php echo lang('description') ?></label>
            <div class="col-sm-11">
             <textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
           </div>
         </div>

       </div>
     </div>
   </div>
 </div>

 <?php } $i = 0;?>


</div>



<?php echo buttonsubmit('procurement/perencanaan_pengadaan/daftar_history_pengadaan_car',lang('back'),lang('save')) ?>

</form>

</div>


<script type="text/javascript">
  $(document).ready(function(){

    $('#nama_proyek_form').hide();
    $('.jenis_rencana').click(function(){
      if ($(this).val() == 'rkp') {
           $('#nama_proyek_form').show();
           $('[name=nama_proyek]').attr('required','required');
      }else{
        $('#nama_proyek_form').hide();
        $('[name=nama_proyek]').removeAttr('required');

      }
    })

    $(document.body).on("change","#proyek_id",function(){

      var id = $(this).val();
      var url = "<?php echo site_url('administration/data_proyek/picker') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("[name=nama_proyek]").val(mydata.project_name);
          // $("#mata_anggaran_label_inp").val(mydata.name_cc);
          // $("#sub_mata_anggaran_code_inp").val(mydata.subcode_cc);
          // $("#sub_mata_anggaran_label_inp").val(mydata.subname_cc);
        }
      });

    });

    $(document.body).on("change","#mata_anggaran_inp",function(){

      var id = $(this).val();
      var url = "<?php echo site_url('administration/data_anggaran') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#mata_anggaran_code_inp").val(mydata.code_cc);
          $("#mata_anggaran_label_inp").val(mydata.name_cc);
          $("#sub_mata_anggaran_code_inp").val(mydata.subcode_cc);
          $("#sub_mata_anggaran_label_inp").val(mydata.subname_cc);
        }
      });

    });

    $(".tambah_dok").click(function(){

      var total = parseInt($("div.lampiran:visible").length);
      var find = parseInt($("div.lampiran:hidden").attr("data-no"));

      if(total == 4){
        $(".tambah_dok").hide();
      }
      $("div.lampiran[data-no='"+find+"']").show();
      return false;

    });

    $(".tutup").click(function(){

      $(".tambah_dok").show();
      var no = parseInt($(this).attr("data-no"));
      $("div.lampiran[data-no='"+no+"']").hide();

      return false;

    });

  });
</script>