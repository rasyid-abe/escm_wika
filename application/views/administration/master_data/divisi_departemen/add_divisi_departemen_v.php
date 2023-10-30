<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_divisi_departemen");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-title">            
            <div class="card-header border-bottom pb-2">
              
            </div>
          </div> 

          <div class="card-body">
            <div class="card-content">
              <?php $curval = set_value("dep_code_divbirnit_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Kode</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="dep_code_divbirnit_inp" maxlength="50" name="dep_code_divbirnit_inp" value="<?php echo $curval ?>">
                  </div>
                </div>

                <?php $curval = set_value("dept_name_divbirnit_inp"); ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label">Nama</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="dept_name_divbirnit_inp" maxlength="255" name="dept_name_divbirnit_inp" value="<?php echo $curval ?>">
                  </div>
                </div>

                <?php $curval = set_value("dist_id_divbirnit_inp"); ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label">Kantor</label>
                  <div class="col-sm-4">
                  <select required class="form-control" name="dist_id_divbirnit_inp">
                    <option value="">Pilih</option>
                    <?php 
                    foreach($dist_name as $key => $val){
                      $selected = ($val['district_id'] == $curval) ? "selected" : ""; 
                      ?>
                      <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

            <?php $curval = set_value("tipe_inp"); ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label">Tipe</label>
              <div class="col-sm-3">
              <select required class="form-control" name="tipe_inp" id="tipe_inp">
                <option value="">Pilih</option>
                <?php 
                foreach($tipe_list as $key => $val){
                  $selected = ($key == $curval) ? "selected" : ""; ?> 
                  <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <!-- ==================================Tambah===================================================== -->
          <?php $curval = set_value("gambar_attachment"); ?>
          <div class="form-group" id="tempat_gambar">
            <label class="col-md-2 control-label">Gambar Maps</label>
            <div class="col-md-6"> 
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" data-id="gambar_attachment" data-folder="<?php echo $dir ?>" data-preview="gambar_file" class="btn btn-primary upload">
                    <i class="fa fa-cloud-upload"></i>
                  </button> 
                  <button type="button" data-id="gambar_attachment" data-folder="<?php echo $dir ?>" data-preview="gambar_file" class="btn btn-danger removefile">
                    <i class="fa fa-remove"></i>
                  </button> 
                </span> 
                <input readonly type="text" class="form-control" id="gambar_attachment" ng-model="data.gambar_item" name="gambar_attachment">
                <span class="input-group-btn">

                  <button type="button" data-url="#" class="btn btn-primary preview_upload" id="gambar_file">
                    <i class="fa fa-share"></i>
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

  <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('administration/master_data/divisi_departemen',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>

<script type="text/javascript">
$( document ).ready(function(){
  //$("#tempat_gambar").hide();

  check_metode();

    $("#tipe_inp").change(function(){
      check_metode();
    });

    function check_metode(){

    var tipe = parseInt($("#tipe_inp").val());
    var tempat_gambar = $("#tempat_gambar");
    var form_pelabuhan = $("#form_pelabuhan");
      //var panitia_pelelangan = $("#panitia_pelelangan_cont");
      if(tipe == 1){
        tempat_gambar.show();
        form_pelabuhan.show();
        //panitia_pelelangan.hide();
      } else {
        tempat_gambar.hide();
        form_pelabuhan.hide();
        //panitia_pelelangan.hide();
      }

    }

})


    


</script>