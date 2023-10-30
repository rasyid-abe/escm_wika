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

            <?php $curval = (isset($perencanaan['ppm_planner'])) ? $perencanaan['ppm_planner'] : $userdata['complete_name']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">User *</label>
              <div class="col-sm-10">
               <input type="text" disabled class="form-control" required name="user_inp" value="<?php echo $curval ?>">
             </div>
           </div>

           <?php $curval = (isset($perencanaan['ppm_dept_name'])) ? $perencanaan['ppm_dept_name'] : $pos['dept_name']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Divisi/Departemen *</label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" required name="birounit_inp" value="<?php echo $curval ?>" maxlength="10">
            </div>
          </div>

          <!-- haqim -->
          <div class="form-group">
            <label class="col-sm-2 control-label">Jenis Rencana*</label>
            <div class="col-sm-10">
             <input type="hidden" name="jenis_rencana" value="rkp_matgis" class="jenis_rencana"> 
             <p class="form-control-static">RKP Material Strategis</p>
           </div>
         </div>

         <?php $curval = (isset($perencanaan['ppm_subject_of_work'])) ? $perencanaan['ppm_subject_of_work'] : set_value("nama_rencana_pekerjaan_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Nama Rencana Matgis *</label>
          <div class="col-sm-10">
           <select required class="form-control select2" id="nama_rencana_pekerjaan_inp" name="nama_rencana_pekerjaan_inp">
            <option value=""><?php echo lang('choose') ?></option>
            <?php foreach($desc_matgis as $key => $val){
              $selected = ($val['label'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> data-desc="<?php echo $val['desc'] ?>" value="<?php echo $val['label'] ?>"><?php echo $val['label'] ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <?php $curval = (isset($perencanaan['ppm_scope_of_work'])) ? $perencanaan['ppm_scope_of_work'] : set_value("deskripsi_rencana_pekerjaan_inp"); ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Deskripsi Rencana Matgis *</label>
        <div class="col-sm-10">
          <p id="deskripsi_rencana_pekerjaan_inp" class="form-control-static"><?php echo $curval ?></p>
          <input type="hidden" name="deskripsi_rencana_pekerjaan_inp" value="<?php echo $curval ?>">
        </div>
      </div>

      <?php $curval = (isset($perencanaan['ppm_currency'])) ? $perencanaan['ppm_currency'] : set_value("mata_uang_inp");
      $curval = (empty($curval)) ? "IDR" : $curval; ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Mata Uang *</label>
        <div class="col-sm-4">
         <select required class="form-control select2" name="mata_uang_inp">
          <option value=""><?php echo lang('choose') ?></option>
          <?php foreach($default_currency as $key => $val){
            $selected = ($key == $curval) ? "selected" : ""; 
            ?>
            <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
          <?php } ?>
        </select>
      </div>
    </div>


  <?php /*
  <?php $curval = (set_value("rencana_pelaksanaan_kebutuhan_month_inp")) ? set_value("rencana_pelaksanaan_kebutuhan_month_inp") : date("m"); ?>
  <?php $curval = (isset($perencanaan['ppm_renc_pelaksanaan'])) ? substr($perencanaan['ppm_renc_pelaksanaan'], 4,2) : $curval; ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Rencana Pelaksanaan Pengadaan *</label>
    <div class="col-sm-4">

     <?php echo month_select_box('rencana_pelaksanaan_kebutuhan_month_inp',$curval) ?>

   </div>
   <div class="col-sm-2">
     <?php $curval = (set_value("rencana_pelaksanaan_kebutuhan_year_inp")) ? set_value("rencana_pelaksanaan_kebutuhan_year_inp") : date("Y"); ?>
     <?php $curval = (isset($perencanaan['ppm_renc_pelaksanaan'])) ? substr($perencanaan['ppm_renc_pelaksanaan'], 0,4) : $curval; ?>
     <select class="form-control" name="rencana_pelaksanaan_kebutuhan_year_inp" value="<?php echo $curval ?>">
       <?php for ($i=date("Y"); $i <= date("Y")+5; $i++) { 
        $selected = ($val == $curval) ? "selected" : ""; 
        ?>
        <option <?php echo $selected ?>><?php echo $i ?></option>
      <?php } ?>
    </select>
  </div>

</div>
*/ ?>

<input type="hidden" name="rencana_pelaksanaan_kebutuhan_year_inp" value="">

<?php /*

<?php $curval = (set_value("rencana_kebutuhan_month_inp")) ? set_value("rencana_kebutuhan_month_inp") : date("m"); ?>
<?php $curval = (isset($perencanaan['ppm_renc_kebutuhan'])) ? substr($perencanaan['ppm_renc_kebutuhan'], 4,2) : $curval; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Rencana Kebutuhan *</label>
  <div class="col-sm-4">

    <?php echo month_select_box('rencana_kebutuhan_month_inp',$curval) ?>

  </div>
  <div class="col-sm-2">
    <?php $curval = (set_value("rencana_kebutuhan_year_inp")) ? set_value("rencana_kebutuhan_year_inp") : date("Y"); ?>
    <?php $curval = (isset($perencanaan['ppm_renc_kebutuhan'])) ? substr($perencanaan['ppm_renc_kebutuhan'], 0,4) : $curval; ?>
    <select class="form-control" name="rencana_kebutuhan_year_inp">
     <?php for ($i=date("Y"); $i <= date("Y")+5; $i++) { 
      $selected = ($i == $curval) ? "selected" : ""; 
      ?>
      <option <?php echo $selected ?>><?php echo $i ?></option>
    <?php } ?>
  </select>
</div>
</div>

*/ ?>

<input type="hidden" name="rencana_kebutuhan_month_inp" value="">

  <?php /*$curval = set_value("swakelola_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Swakelola *</label>
    <div class="col-sm-10">
      <div class="radio">
       <label>
         <?php $selected = (1 == $curval) ? "checked" : "";  ?>
         <input type="radio" <?php echo $selected ?> required name="swakelola_inp" value="1"> Ya
       </label>
       <label>
         <?php $selected = (0 == $curval) ? "checked" : "";  ?>
         <input type="radio" <?php echo $selected ?> required name="swakelola_inp" value="0"> Tidak
       </label>
     </div>
   </div>
   </div> */?>

 </div>
</div>
</div>
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
  });

    var deskripsi = [];
    <?php foreach($desc_matgis as $key => $val){ ?>
      deskripsi.push({lbl:"<?php echo $val['label'] ?>",desc:"<?php echo $val['desc'] ?>"});
    <?php } ?>

    console.log(deskripsi);

    $("#nama_rencana_pekerjaan_inp").change(function(){

      var val = $(this).val();

      for (var i = 0; i < deskripsi.length; i++) {
        if(val == deskripsi[i].lbl){
          $("#deskripsi_rencana_pekerjaan_inp").text(deskripsi[i].desc);
          $("input[name='deskripsi_rencana_pekerjaan_inp']").val(deskripsi[i].desc);
        }

      }

    });

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