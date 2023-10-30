<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" id="form_aspek_penilaian_ketepatan_progress" action="<?php echo site_url($controller_name."/vpi/daftar_pekerjaan/penilaian_vpi/".$vvh_id."/konsultan/submit_ketepatan_progress");?>"  class="form-horizontal">
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
            <input type="hidden" name="tipe_inp" value="konsultan>">


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
              <label class="col-sm-2 control-label">Penyedia Konsultan</label>
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
                <input type="hidden" name="nilai_akhir_inp" id="nilai_akhir_inp" value="<?php echo $curval ?>" class="form-control money" required>
                <?php echo $curval ?>
               </div>
             </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Lampiran</label>
                <?php $curval = isset($prev_data['vpkp_value_attach']) ? $prev_data['vpkp_value_attach'] : set_value('nilai_attachment_inp');
                      $data_url = isset($prev_data['vpkp_value_attach']) ? site_url('log/download_attachment/vendor/').'/'.$prev_data['vpkp_value_attach'] : '#';
                   ?>
               <div class="col-sm-5">
                <div class="input-group">
                  <p class="form-control-static">
                    <a href="<?php echo $data_url ?>"><?php echo $curval ?></a>
                  </p>
                </div>
                <label for="nilai_attachment_inp" generated="true" class="error"></label>
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
        <?php $curval = !empty($prev_data['vpkp_attach']) ? $prev_data['vpkp_attach'] : 'no file';
      $data_url = !empty($prev_data['vpkp_attach']) ? site_url('log/download_attachment/vendor/').'/'.$prev_data['vpkp_attach'] : '#';
       ?>
      <label class="col-sm-1 control-label">Lampiran</label>
          <div class="col-sm-5">
            <div class="input-group">
             <p class="form-control-static">
               <a href="<?php echo $data_url ?>"> <?php echo $curval ?></a>
             </p>
            </div>
             
          </div>
        </div>
        <?php $curval = isset($prev_data['vpkp_note']) ? $prev_data['vpkp_note'] : set_value('note_inp');?>
      <div class="form-group">
        <label class="col-sm-1 control-label">Catatan *</label>
        <div class="col-sm-11">
          <textarea readonly name="note_inp" id="note_inp" required class="form-control" maxlength="1000" style="height: 80px"><?php echo $curval ?></textarea>
        </div>
      </div>

      </div>
      </div>
    </div>
</div>

<?php echo buttonback('vendor/vpi/monitor_pekerjaan/penilaian_vpi/'.$vvh_id,lang('back'),lang('save')) ?>
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
              vMax:'10'
            });
      }
  });
</script>