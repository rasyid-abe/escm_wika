<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_ubah_history_car");?>"  class="form-horizontal ajaxform">
  <input type="hidden" name="id" value="<?php echo $id ?>">
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

            <?php $curval = $perencanaan['phc_id']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">No CAR</label>
              <div class="col-sm-10">
               <input type="text" disabled class="form-control" required name="id_inp" value="<?php echo $curval ?>">
             </div>
           </div>

           <?php $curval = $perencanaan['phc_name']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Nama Pengadaan *</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required name="name_inp" value="<?php echo $curval ?>" maxlength="255">
            </div>
          </div>

          <?php $curval = $perencanaan['phc_type']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Tipe Pengadaan</label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" required name="type_inp" value="<?php echo $curval ?>" maxlength="50">
            </div>
          </div>

          <?php $curval = $perencanaan['dept_name']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Divisi/Departemen </label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" required name="dept_inp" value="<?php echo $curval ?>" maxlength="10">
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

  <?php 
  $sisa = 5;
  if(!empty($document)){
    foreach ($document as $k => $v) {
      if($k == 0 || !empty($v['phd_file_name'])){
      $show = "";
      $sisa--;
    } else {
      $show = "display:none;";
    }
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
              <div class="form-group">
                <?php $curval = (isset($v['phd_file_name'])) ? $v['phd_file_name'] :  set_value("doc_attachment_inp[$k]"); ?>
                <label class="col-sm-1 control-label"><?php echo lang('attachment') ?></label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                        <i class="fa fa-cloud-upload"></i> Upload
                      </button> 
                      <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/'.$curval) ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
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
              <?php $curval = (isset($v['phd_desc'])) ? $v['phd_desc'] :  set_value("doc_desc_inp[$k]"); ?>
              <div class="form-group">
                <label class="col-sm-1 control-label"><?php echo lang('description') ?></label>
                  <div class="col-sm-11">
                    <textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
                  </div>
              </div>

            <?php $curval = (isset($v['phd_id'])) ? $v['phd_id'] :  ""; ?>
            <input type="hidden" name="doc_id_inp[<?php echo $k ?>]" value="<?php echo $curval ?>"/>

          </div>
        </div>
      </div>
    </div>

    <?php 
    } } ?>

    <?php for ($k = 5-$sisa; $k <= 100; $k++) { 
    $show = ($k == 0) ? "" : "display:none;";
    ?>

    <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>LAMPIRAN DOKUMEN #<?php echo $k ?></h5>
              <div class="card-tools">
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
                <?php if($k > 0){ ?>
                <a class="tutup" data-no="<?php echo $k ?>">
                  <i class="fa fa-times"></i>
                </a>
                <?php } ?>
              </div>
          </div>
            <div class="card-content">

              <?php $curval = set_value("doc_desc_inp[$k]"); ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('description') ?></label>
                <div class="col-sm-10">
                <textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
              </div>
            </div>


            <?php $curval = set_value("doc_attachment_inp[$k]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                        <i class="fa fa-cloud-upload"></i> Upload
                      </button> 
                      <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/'.$curval) ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                        <i class="fa fa-share"></i> Preview
                      </button> 
                    </span> 
                    <input readonly type="text" class="form-control" id="doc_attachment_inp_<?php echo $k ?>" name="doc_attachment_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                    <span class="input-group-btn">
                      <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-remove removefile">
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

        </div>
      </div>
    </div>
  </div>

  <?php } $i = 0;?>

</div>
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5>History Progress</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="card-content">

          <table class="table comment">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Aktifitas</th>
                <th>User Update</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($progress as $kc => $vc) { ?>
                <tr>
                  <td><?php echo $vc['hcp_start_date'] ?></td>
                  <td><?php echo $vc['hcp_activity']  ?></td>
                  <td><?php echo $vc['hcp_user_update'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
            
          </table>
            
        </div>
      </div>

    </div>
  </div>

  <?php echo buttonsubmit('procurement/perencanaan_pengadaan/daftar_history_car',lang('back'),lang('save')) ?>

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

    $(document.body).on("change","#mata_anggaran_inp",function(){

      var id = $(this).val();
      var url = "<?php echo site_url('Procurement/data_mata_anggaran') ?>";
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
      $(".lampiran[data-no='"+find+"']").show();
      return false;

    });

    $(".tutup").click(function(){

      $(".tambah_dok").show();
       var no = parseInt($(this).attr("data-no"));
      $(".lampiran[data-no='"+no+"']").hide();

      return false;

    });

  });
</script>
