<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_edit_kat_jasa_smbd");?>"  class="form-horizontal">

    <?php //echo buttonsubmit('commodity/katalog/katalog_jasa') ?>
    
    <?php foreach ($srv_catalog as $k => $v) {
      $i = $v['srv_catalog_code'];
      ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="card float-e-margins">
            <div class="card-title">
              <h5>Form #<?php echo $i ?></h5>
              <div class="card-tools">
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </div>
            </div>
            <div class="card-content">
      <div class="form-group">
        <label class="col-sm-2 control-label">Grup Level 1 *</label>
        <div class="col-sm-10">
          <select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level1_inp[<?php echo $i ?>]">
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label">Grup Level 2 *</label>
        <div class="col-sm-10">
          <select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level2_inp[<?php echo $i ?>]">
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label">Grup Level 3 *</label>
        <div class="col-sm-10">
          <select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level3_inp[<?php echo $i ?>]">
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-2 control-label">Grup Barang UNSPSC</label>
        <div class="col-sm-10" id="unspsc_div_<?php echo $i ?>">
        </div>
      </div>

         <?php $curval = (isset($v['srv_catalog_code'])) ? $v['srv_catalog_code'] : set_value("code_inp[$i]") ?>
         <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('code') ?></label>
          <div class="col-sm-10">
            <input type="text" disabled class="form-control" name="code_inp[<?php echo $i ?>]" maxlength="10" value="<?php echo $curval ?>">
          </div>
        </div>


        <?php 
          $curval = set_value("is_matgis_inp[$i]");
        ?>   
<!--         <div class="form-group">
          <label class="col-sm-2 control-label">Tipe Sumberdaya</label>
          <div class="col-sm-10" id="tipe_smbd_div_<?php echo $i ?>">
          </div>
        
            <input type="hidden" name="is_matgis_inp[<?php echo $i ?>]" 
            value=""  >

        </div> -->

        <div class="form-group">
            <label class="col-sm-2 control-label">Tipe Matgis</label>
            <div class="col-sm-10">
              <p class="form-control-static">
                <input type="checkbox" name="is_matgis_inp[<?php echo $i ?>]" 
                value="t" <?php  echo $curval == 't' ? "checked" : ''; ?> >
              </p>
            </div>
        </div>

        <?php $curval = (isset($v['short_description'])) ? $v['short_description'] : set_value("deskripsi_inp[$i]") ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi Jasa</label>
          <div class="col-sm-10">
            <textarea readonly name="deskripsi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
          </div>
        </div>
        
        <?php $curval = (isset($v['long_description'])) ? $v['long_description'] : set_value("info_inp[$i]") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Jasa *</label>
                <div class="col-sm-10">
                  <textarea required name="info_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
                </div>
              </div>
        
        <?php $curval = (isset($v['tipe'])) ? $v['tipe'] : set_value("tipe_inp[$i]") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Tipe</label>
                <div class="col-sm-10">
                  <textarea name="tipe_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
                </div>
              </div>
        
        <?php $curval = (isset($v['lokasi'])) ? $v['lokasi'] : set_value("lokasi_inp[$i]") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Lokasi</label>
                <div class="col-sm-10">
                  <textarea name="lokasi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
                </div>
              </div>
        
        <?php $curval = (isset($v['others'])) ? $v['others'] : set_value("others_inp[$i]") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Atribut Lainnya</label>
                <div class="col-sm-10">
                  <textarea name="uraian_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


    <?php include(VIEWPATH."/comment_v.php") ?>

    <?php } ?>

    <?php echo buttonsubmit('commodity/katalog/katalog_jasa_sumberdaya',lang('back'),lang('save')) ?>

  </form>

</div>

<script type="text/javascript">
var doneLoad = false;
  $(function () {
    
    $.ajax({
          url:"<?php echo site_url('Commodity/dropdown_grup_jasa_smbd?type=smbd&level=1') ?>",
          type:"get",
      dataType:"json",
      success: function(data) {
      $("select[name*='group_level1_inp']").append("<option value=''><?php echo lang('choose') ?></option>");
            $.each(data, function(index, row) {
        $("select[name*='group_level1_inp']").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
      });
      $("select[name*='group_level1_inp']").each(function(index) {
        $(this).val($(this).data("no").toString().substring(0,1)).trigger("change");
        if($(this).val() != ""){
          loadLevel2AndBelow($(this).data("no"));
        }
      });
          }
        });

  $("select[name*='group_level1_inp']").change(function(){
    if(doneLoad){
    $("select[name='group_level2_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='group_level3_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='group_level2_inp["+$(this).data("no")+"]']").html("");
    $("select[name='group_level3_inp["+$(this).data("no")+"]']").html("");
    if($(this).val() != ""){
      loadLevel2AndBelow($(this).data("no"));
    }
    }
  });
    
  $("select[name*='group_level2_inp']").change(function(){
    if(doneLoad){
    $("select[name='group_level3_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='group_level3_inp["+$(this).data("no")+"]']").html("");
    if($(this).val() != ""){
      loadLevel3AndBelow($(this).data("no"));
    }
    }
  });
    

  $("select[name*='group_level3_inp']").change(function(){
    var no = $(this).data("no");
    var unspsc_div = $('#unspsc_div_'+no)
    $.ajax({
        url:"<?php echo site_url('Commodity/get_unspsc_code?type=smbd&group_code='); ?>"+$("select[name='group_level3_inp["+$(this).data("no")+"]']").val(),
        type:"get",
        dataType:"json",
        success: function(data) {
          if (data !== null) {
          unspsc_div.html("<p class='form-control-static'>"+data.unspsc_code+" - "+data.group_name+"</p>");
          if (data.is_matgis == 't') {
            // is_matgis = 'Matgis'
            $('[name="is_matgis_inp['+no+']"]').prop('checked',true)
          }else{
            // is_matgis = 'Non-Matgis'
            $('[name="is_matgis_inp['+no+']"]').prop('checked',false)
          }
          // tipe_smbd_div.html("<p class='form-control-static'>"+is_matgis+"</p>");
        }
      }  
  })
});

});

function loadLevel2AndBelow(no){
    $.ajax({
        url:"<?php echo site_url('Commodity/dropdown_grup_jasa_smbd?level=2&type=smbd&parent='); ?>"+$("select[name='group_level1_inp["+no+"]']").val(),
        type:"get",
        dataType:"json",
        success: function(data) {
          $("select[name='group_level2_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
        $.each(data, function(index, row) {
          $("select[name='group_level2_inp["+no+"]']").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
        });
        
        $("select[name='group_level2_inp["+no+"]']").select2().select2('val',no.toString().substring(0,2));
        
        loadLevel3AndBelow(no);
        }
      });   
  }
function loadLevel3AndBelow(no){
  $.ajax({
        url:"<?php echo site_url('Commodity/dropdown_grup_jasa_smbd?level=3&type=smbd&parent=') ?>"+$("select[name='group_level2_inp["+no+"]']").val(),
        type:"get",
        dataType:"json",
        success: function(data) {
          $("select[name='group_level3_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
        $.each(data, function(index, row) {
          $("select[name='group_level3_inp["+no+"]']").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
        });
        
        $("select[name='group_level3_inp["+no+"]']").select2().select2('val',no.toString().substring(0,3));
        
        loadLevel4(no);
        }
      });
}
function loadLevel4(no){
  $.ajax({
        url:"<?php echo site_url('Commodity/dropdown_grup_brg?parent=') ?>"+$("select[name='group_level3_inp["+no+"]']").val(),
        type:"get",
        dataType:"json",
        success: function(data) {
          $("select[name='group_level4_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
        $.each(data, function(index, row) {
          $("select[name='group_level4_inp["+no+"]']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
        });
        
        $("select[name='group_level4_inp["+no+"]']").select2().select2('val',no.toString().substring(0,8));
        
        doneLoad = true;        
        }
      });
}

</script>