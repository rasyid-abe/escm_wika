<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" id="form_aspek_penilaian_mutu" action="<?php echo site_url($controller_name."/vpi/monitor_pekerjaan/submit_penilaian_header");?>"  class="form-horizontal">

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
                        foreach ($date_range['text'] as $key => $value) { 
                          if (isset($current_data['vvh_date']) AND $current_data['vvh_date'] == $key) {
                            $selected = "selected";
                          }else{
                            $selected = "";
                          }
                          ?>

                        <option value="<?php echo $date_range['val'][$key] ?>" <?php echo $selected ?> >
                          <?php echo $value ?>    
                        </option>
                          
                      <?php }
                        
                       } ?>
                    </select>
                 </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 control-label">Tipe</label>
                  <div class="col-sm-3">
                    <p class="form-control-static">
                      <?php echo ucfirst($current_data['vvh_tipe']) ?>
                    </p>
                    <input type="hidden" name="tipe_inp" value="<?php echo $current_data['vvh_tipe'] ?>">
                 </div>
              </div>

       </div>
     </div>
    </div>
    </div>
<?php echo buttonsubmit('vendor/vpi/monitor_pekerjaan',lang('back'),lang('save')) ?>
  </form>