<form method="post" id="form_aspek_penilaian_mutu" action="<?php echo site_url($controller_name."/vpi/daftar_pekerjaan/submit_penilaian_header");?>"  class="form-horizontal">
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <span class="card-header border-bottom pb-2 text-bold-600">Header</span> 
        </div>

        <div class="card-body">
            <div class="card-body">
              <input type="hidden" name="contract_id_inp" value="<?php echo isset($contract_data['contract_id']) ? $contract_data['contract_id'] : "" ?>">

              <?php $dept_id = isset($contract_data['ptm_dept_id']) ? $contract_data['ptm_dept_id'] : "" ?>
              <?php $dept_name = isset($contract_data['ptm_dept_name']) ? $contract_data['ptm_dept_name'] : "" ?>

              <div class="row form-group">
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

              <div class="row form-group">
                <label class="col-sm-2 control-label">Penyedia Barang/Jasa</label>
                <div class="col-sm-10">
                  <input type="hidden" name="vendor_id_inp" class="form-control" value="<?php echo $vendor_id ?>">
                <p class="form-control-static">
                  <?php echo $vendor_name ?>
                </p>
                </div>
              </div>

              <div class="row form-group">
                  <label class="col-sm-2 control-label">Deskripsi Pengadaan</label>
                  <div class="col-sm-10">
                  <p class="form-control-static">
                    <?php echo $contract_data['subject_work'] ?>
                  </p>
                </div>
              </div>

              <div class="row form-group">
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

              <div class="row form-group">
                  <label class="col-sm-2 control-label">Tipe *</label>
                  <div class="col-sm-3">
                    <select name='tipe_inp' class="form-control" id="tipe_inp" required> 
                      <option value="">Pilih</option>
                      <?php if (isset($pilihan_tipe)) { 
                        foreach ($pilihan_tipe as $key => $value) { 

                          if (isset($current_data['vvh_tipe']) AND $current_data['vvh_tipe'] == $key) {
                            $selected = "selected";
                          }else{
                            $selected = "";
                          }
                          ?>

                        <option value="<?php echo $key ?>" <?php echo $selected; ?>>
                          <?php echo $value ?>
                        </option>
                          
                        <?php }
                        
                      } ?>
                    </select>
                    <div id="tipe_inp2"></div>
                </div>
              </div>

            </div>
        </div>

      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="card-body">
        <?php echo buttonsubmit('vendor/vpi/daftar_pekerjaan',lang('back'),lang('save')) ?>        
      </div>
    </div>
  </div>

</form>

<script type="text/javascript">
  $(document).ready(function() {
      var contract_id = "<?php echo $contract_data['contract_id']  ?>";
      $('#date_inp').change(function(event) {
        
        if ($(this).val() != "") {
          var vvh_date = $(this).val();

          $.ajax({
            url: '<?php echo site_url("vendor/vpi/daftar_pekerjaan/check_penilaian_header")?>'+'?vvh_date='+vvh_date+'&contract_id='+contract_id,
            type: 'get',
            dataType: 'json'
            })
            .done(function(data) {

              console.log("success");
              if (data != null) {
                $('#tipe_inp').val(data.vvh_tipe);
                $('#tipe_inp').attr('disabled', true);
                $('#tipe_inp2').html("<input type='hidden' name='tipe_inp' value='"+data.vvh_tipe+"'/>")
              }else{
                $('#tipe_inp').val("");
                $('#tipe_inp').attr('disabled', false);
                $('#tipe_inp2').html("")

              }
              
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });

        }

      });
      
  });
    
</script>