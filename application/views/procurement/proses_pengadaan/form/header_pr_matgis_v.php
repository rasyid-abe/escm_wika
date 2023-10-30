
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

          <?php $curval = (isset($permintaan['pr_number'])) ? $permintaan['pr_number'] : "AUTO"; ?>

          <div class="form-group">
            <label class="col-sm-2 control-label">No. Permintaan</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

         <?php $curval = (isset($permintaan['pr_requester_name'])) ? $permintaan['pr_requester_name'] : $userdata['complete_name']; ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">User</label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?></p>
         </div>
       </div>

       <?php $curval = (isset($permintaan['pr_requester_pos_name'])) ? $permintaan['pr_requester_pos_name'] : $pos['dept_name']; ?>

       <div class="form-group">
        <label class="col-sm-2 control-label">Divisi/Departemen</label>
        <div class="col-sm-10">
          <p class="form-control-static"><?php echo $curval ?></p>
        </div>
      </div>

      <?php $curval = (isset($permintaan['pr_subject_of_work'])) ?  $permintaan["pr_subject_of_work"] : set_value("nama_pekerjaan"); ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Nama Rencana Pengadaan Matgis</label>
        <div class="col-sm-10">
          <p class="form-control-static"><?php echo $curval ?></p>
          <input type="hidden" class="form-control" name="nama_pekerjaan" id="nama_pekerjaan" value="<?php echo $curval ?>">
        </div>
        <div class="col-sm-2">
          <?php $curval = (isset($permintaan['ppm_id'])) ?  $permintaan["ppm_id"] : set_value("perencanaan_pengadaan_inp"); ?>

          <input type="hidden" name="perencanaan_pengadaan_inp" required="true" value="<?php echo $curval ?>" id="perencanaan_pengadaan_inp"/>
        </div>
      </div>

      <?php $curval = (isset($permintaan['pr_scope_of_work'])) ? $permintaan["pr_scope_of_work"] : set_value("deskripsi_pekerjaan"); ?>
      <div class="form-group" hidden="hidden">
        <label class="col-sm-2 control-label">Deskripsi Rencana Pengadaan Matgis</label>
        <div class="col-sm-10">

          <textarea type="text" class="form-control" id="deskripsi_pekerjaan" required="true" name="deskripsi_pekerjaan" readonly><?php echo $curval ?></textarea>
        </div>
      </div>

      <!-- haqim -->
      <?php $curval = (isset($permintaan['pr_spk_code'])) ? $permintaan["pr_spk_code"] : set_value("nama_proyek"); ?>

  <?php if(!empty($curval)){ ?>
      <div class="form-group" id="kode_spk_div">
        <label class="col-sm-2 control-label">Kode SPK</label>
        <div class="col-sm-10">
          <p class="form-control-static"><?php echo $curval ?></p>
          <input type="hidden" class="form-control" name="spk_code" id="kode_spk" value="<?php echo $curval ?>">
        </div>
      </div>
    <?php } ?>

      <?php $curval = (isset($permintaan['pr_project_name'])) ? $permintaan["pr_scope_of_work"] : set_value("nama_proyek"); ?>
      <div class="form-group" id="nama_proyek_div">
        <label class="col-sm-2 control-label">Nama Proyek</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p>
         <input type="hidden" class="form-control" name="nama_pekerjaan" id="nama_proyek" value="<?php echo $curval ?>">
       </div>
     </div>
     <!-- end -->

     <?php 
     $code = (isset($permintaan['pr_mata_anggaran']) && !empty($permintaan['pr_mata_anggaran'])) ? $permintaan['pr_mata_anggaran'] : null;
     $label = (isset($permintaan['pr_nama_mata_anggaran']) && !empty($permintaan['pr_nama_mata_anggaran'])) ? $permintaan['pr_nama_mata_anggaran'] : null;
     $curval = (!empty($code) && !empty($label)) ? $code." ".$label : null; 
     ?>

     <?php if(!empty($curval)){ ?>

     <div class="form-group">
      <label class="col-sm-2 control-label">Mata Anggaran</label>
      <div class="col-sm-10">
        <p class="form-control-static" id="mata_anggaran"><?php echo $curval ?></p>
      </div>
    </div>

  <?php } ?>

    <?php

    $curval = null;
    if (isset($permintaan["pr_sub_mata_anggaran"]) and substr_count($permintaan["pr_sub_mata_anggaran"], " , ") >= 1 ) {
     $code = explode(" , ", $permintaan["pr_sub_mata_anggaran"]);
     $name = explode(" , ", $permintaan["pr_nama_sub_mata_anggaran"]);
     $curval = $permintaan["pr_sub_mata_anggaran"]." - ".$permintaan["pr_nama_sub_mata_anggaran"];
   }
   ?>

<?php if(!empty($curval)){ ?>

   <div class="form-group">
    <label class="col-sm-2 control-label">Sub Mata Anggaran *</label>
    <div class="col-sm-10">
      <p class="form-control-static" id="sub_mata_anggaran">
        <?php
        if (isset($code)) {
          foreach (array_combine($code, $name) as $code => $name ) {
            echo $code.' - '.$name."<br/>";
          }
        }else{
                   // else if ($permintaan["pr_sub_mata_anggaran"] == 0) {
                   //   foreach ($project_cost as $keypc => $valuepc) {
                   //    echo $valuepc['coa_code'].' - '.$valuepc['coa_name']."<br/>";
                   //   }
                   // }
                   // else{
          echo $curval;
        } 

        ?>
      </p>
    </div>
  </div>

<?php } ?>

  <?php //$curval = (isset($permintaan['pr_sub_mata_anggaran']) && isset($permintaan['pr_nama_sub_mata_anggaran'])) ? $permintaan["pr_sub_mata_anggaran"]." - ".$permintaan["pr_nama_sub_mata_anggaran"] : ""; ?>
        <!-- <div class="form-group">
          <label class="col-sm-2 control-label">Sub Mata Anggaran</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="sub_mata_anggaran"><?php //echo $curval ?></p>
          </div>
        </div> -->

        <?php $curval = (isset($permintaan['pr_pagu_anggaran'])) ? $permintaan["pr_pagu_anggaran"] : 0; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nilai Anggaran</label>
          <div class="col-sm-4">
            <p class="form-control-static" id="pagu_anggaran" maxlength="22"><?php echo inttomoney($curval) ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_sisa_anggaran'])) ? $permintaan["pr_sisa_anggaran"] : 0 ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Sisa Anggaran</label>
          <div class="col-sm-4">
            <p class="form-control-static" id="sisa_anggaran"><?php echo inttomoney($curval) ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_packet'])) ?  $permintaan["pr_packet"] : set_value("nama_paket"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Paket Pengadaan*</label>
          <div class="col-sm-10" id="nama_paket_div">
           <input type="text" class="form-control" name="nama_paket" id="nama_paket" required="true" value="<?php echo $curval ?>">
         </div>
       </div>

       <div class="form-group">
        <label class="col-sm-2 control-label">Pembelian Langsung/Swakelola
        </label>
        <div class="col-sm-4">
          <div class="checkbox">
            <?php $curval = set_value("swakelola_inp"); ?>
            <input type="checkbox" onclick="swakelola_confirm()" class="" name="swakelola_inp" id="swakelola_inp" value="1">
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
</div>
