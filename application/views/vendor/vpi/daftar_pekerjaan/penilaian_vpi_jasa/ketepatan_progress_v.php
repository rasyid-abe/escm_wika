<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" id="form_aspek_penilaian_ketepatan_progress" action="<?php echo site_url($controller_name."/vpi/daftar_pekerjaan/penilaian_vpi/".$vvh_id."/jasa/submit_ketepatan_progress");?>"  class="form-horizontal">
    <?php 
    // echo "<pre>";var_dump($prev_data);
    ?>
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
                  <?php echo $vvh_data['subject_work'] ?>
                 </p>
               </div>
             </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-3">
                  <input type="hidden" name="date_inp" value="<?php echo $vvh_data['vvh_date']; ?>">
                  <p class="form-control-static">
                    <?php echo $vvh_data['vvh_date_text']; ?>
                  </p>
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
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Nilai Akhir *</label>
              <div class="col-sm-2">
              <?php $curval = isset($prev_data['vpkp_value']) ?  $prev_data['vpkp_value'] : set_value('nilai_akhir_inp') ?>
                <?php
                  $this->db->where('type', 0);
                  $listNilai = $this->db->get('adm_nilai_vpi')->result_array();
                  
                ?>
                <select name="nilai_akhir_inp" id="nilai_akhir_inp" class="form-control" required>
                  <option value=""></option>
                  <?php foreach ($listNilai as $key => $value) :?>
                    <?php $selected =  $curval == $value['value'] ?  "selected" : ""; ?>
                    <option <?= $selected; ?> value="<?= $value['value'] ?>"> Nilai <?= $value['value'] ?></option>
                  
                  <?php endforeach; ?>>
                </select>
               </div>
             </div>

             <div class="form-group">
                <!-- <label class="col-sm-2 control-label">Lampiran Time Schedule & Curve-S Pelaksanaan Pekerjaan *</label> -->
                <label class="col-sm-2 control-label">Lampiran</label>
                <?php $curval = isset($prev_data['vpkp_value_attach']) ? $prev_data['vpkp_value_attach'] : set_value('nilai_attachment_inp');
                      $data_url = isset($prev_data['vpkp_value_attach']) ? site_url('log/download_attachment/vendor/').'/'.$prev_data['vpkp_value_attach'] : '#';
                   ?>
               <div class="col-sm-5">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" data-id="nilai_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="nilai_attachment_file" class="btn btn-primary upload">
                      <i class="fa fa-cloud-upload"></i> Upload
                    </button> 
                    <button type="button" data-url="<?php echo $data_url ?>" class="btn btn-primary preview_upload" id="nilai_attachment_file">
                      <i class="fa fa-share"></i> Preview
                    </button> 
                  </span> 
                  <input readonly type="text" class="form-control" id="nilai_attachment_inp" name="nilai_attachment_inp" value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-id="nilai_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="nilai_attachment_file" class="btn btn-danger removefile">
                      <i class="fa fa-trash"></i> Delete
                    </button> 
                  </span> 
                </div>
                <label for="nilai_attachment_inp" generated="true" class="error"></label>
                 <div class="col-sm-0" style="font-size: 11px">
                <i>Max file 5 MB 
                <br>
                  Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                </i>
              </div>
          </div>
             </div>
             <div class="form-group">
             <div class="col-sm-5">
             <?php foreach ($listNilai as $key => $value) :?>
                     <p><?= $value['value'] ?> - <?= $value['desc'] ?></p> 
                  <?php endforeach; ?>
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
        <h5 class="card-title">Catatan</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
      <div class="form-group" style="display: none;">
        <?php $curval = isset($prev_data['vpkp_attach']) ? $prev_data['vpkp_attach'] : set_value('note_attachment_inp');
      $data_url = isset($prev_data['vpkp_attach']) ? site_url('log/download_attachment/vendor/').'/'.$prev_data['vpkp_attach'] : '#';
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
        <?php $curval = isset($prev_data['vpkp_note']) ? $prev_data['vpkp_note'] : set_value('note_inp');?>
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
  $(document).ready(function() {
    numeric_format();

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