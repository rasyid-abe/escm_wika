<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_edit_grup_brg_smbd");?>"  class="form-horizontal">
  
  <?php //echo buttonsubmit('commodity/katalog/grup_barang') ?>
  
  <?php foreach ($mat_group as $k => $v) {
    $i = $v['mat_group_code'];
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

            <?php $curval = (isset($v['mat_group_code'])) ? $v['mat_group_code'] : set_value("code_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('code') ?> *</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" required maxlength="4" name="code_inp[<?php echo $i ?>]" maxlength="10" value="<?php echo $curval ?>" readonly>
              </div>
            </div>

            <?php $curval = (isset($v['mat_group_name'])) ? $v['mat_group_name'] : set_value("name_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('name') ?> *</label>
              <div class="col-sm-10">
               <textarea class="form-control" required name="name_inp[<?php echo $i ?>]" ><?php echo $curval ?></textarea>
              </div>
            </div>

            <?php $curval = (isset($v['is_matgis'])) ? $v['is_matgis'] : set_value("is_matgis_inp[$i]");
                ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tipe Matgis</label>
              <div class="col-sm-10">
                <p class="form-control-static">
                  <input type="checkbox" name="is_matgis_inp[<?php echo $i ?>]" 
                  value="" <?php echo $curval == "t" ? "checked" : ""?> >
                </p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Level 1 UNSPSC *</label>
              <div class="col-sm-10">
                <select class="form-control select2" id="level_1" data-unspsc = "<?php echo $v['unspsc_code'] ?>" name="level1_inp[<?php echo $i ?>]" data-no = "<?php echo $i ?>">
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Level 2 UNSPSC *</label>
              <div class="col-sm-10">
                <select class="form-control select2" name="level2_inp[<?php echo $i ?>]" id="level_2" data-unspsc = "<?php echo $v['unspsc_code'] ?>" data-no = "<?php echo $i ?>">
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Level 3 UNSPSC</label>
              <div class="col-sm-10">
                <select class="form-control select2" name="level3_inp[<?php echo $i ?>]" id="level_3" data-unspsc = "<?php echo $v['unspsc_code'] ?>" data-no = "<?php echo $i ?>">
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Level 4 UNSPSC</label>
              <div class="col-sm-10">
                <select class="form-control select2" name="level4_inp[<?php echo $i ?>]" id="level_4" data-unspsc = "<?php echo $v['unspsc_code'] ?>" data-no = "<?php echo $i ?>">
                </select>
              </div>
            </div>

            <?php $curval = (isset($v['mat_group_parent'])) ? $v['mat_group_parent'] : set_value("parent_inp[$i]") ?>
            <input type="hidden" class="form-control level" data-group="grup_brg_<?php echo $i ?>" name="parent_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">

          </div>
        </div>
      </div>
    </div>

    <?php //include(VIEWPATH."/comment_v.php") ?>

    <?php } ?>

<?php echo buttonsubmit('commodity/katalog/grup_barang_sumberdaya',lang('back'),lang('save')) ?>

  </form>

  </div>

<script type="text/javascript">
  $(function () {
    
    $.ajax({
          url:"<?php echo site_url('Commodity/dropdown_grup_brg_smbd?level=1') ?>",
          type:"get",
          dataType:"json",
          success: function(data) { 
             $("select[name*='level1_inp']").append("<option value=''><?php echo lang('choose') ?></option>");
            $.each(data, function(index, row) {
            $("select[name*='level1_inp']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
          });
          $("select[name*='level1_inp']").each(function(index) {
            $(this).val($(this).data("unspsc").toString().substring(0,2)).trigger("change");
            if($(this).val() != ""){
              loadLevel2AndBelow($(this).data("no"));
            }
          });
          // loadLevel2AndBelow();
          }
        });
  })

  $("select[name*='level1_inp']").change(function(){
    $("select[name='level2_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='level3_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='level4_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='level2_inp["+$(this).data("no")+"]']").html("");
    $("select[name='level3_inp["+$(this).data("no")+"]']").html("");
    $("select[name='level4_inp["+$(this).data("no")+"]']").html("");
    loadLevel2AndBelow($(this).data("no"));  
    });
    
    
  $("select[name*='level2_inp']").change(function(){
    $("select[name='level3_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='level4_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='level3_inp["+$(this).data("no")+"]']").html("");
    $("select[name='level4_inp["+$(this).data("no")+"]']").html("");
    if($(this).val() != ""){
      loadLevel3AndBelow($(this).data("no"));
    }
  });

  $("select[name*='level3_inp']").change(function(){
    $("select[name='level4_inp["+$(this).data("no")+"]']").select2("val","");
    $("select[name='level4_inp["+$(this).data("no")+"]']").html("");
    if($(this).val() != ""){
      loadLevel4AndBelow($(this).data("no"));
    }
  });

  function loadLevel2AndBelow(no){
    $.ajax({
        url:"<?php echo site_url('Commodity/dropdown_grup_brg_smbd?parent='); ?>"+$("select[name='level1_inp["+no+"]']").val(),
        type:"get",
        dataType:"json",
        success: function(data) {
          $("select[name='level2_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
        $.each(data, function(index, row) {
          $("select[name='level2_inp["+no+"]']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
        });
        $("select[name*='level2_inp["+no+"]']").val($("select[name*='level2_inp["+no+"]']").data("unspsc").toString().substring(0,4)).change();
        
        loadLevel3AndBelow(no);
        }
      });   
  }

  function loadLevel3AndBelow(no){
    $.ajax({
        url:"<?php echo site_url('Commodity/dropdown_grup_brg_smbd?parent='); ?>"+$("select[name='level2_inp["+no+"]']").val(),
        type:"get",
        dataType:"json",
        success: function(data) {
          $("select[name='level3_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
        $.each(data, function(index, row) {
          $("select[name='level3_inp["+no+"]']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
        });
        $("select[name*='level3_inp["+no+"]']").val($("select[name*='level3_inp["+no+"]']").data("unspsc").toString().substring(0,6)).change();
        
        loadLevel4AndBelow(no);
        }
      });   
  }

  function loadLevel4AndBelow(no){
    $.ajax({
        url:"<?php echo site_url('Commodity/dropdown_grup_brg_smbd?parent='); ?>"+$("select[name='level3_inp["+no+"]']").val(),
        type:"get",
        dataType:"json",
        success: function(data) {
          $("select[name='level4_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
        $.each(data, function(index, row) {
          $("select[name='level4_inp["+no+"]']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
        });
        $("select[name*='level4_inp["+no+"]']").val($("select[name*='level4_inp["+no+"]']").data("unspsc").toString().substring(0,8)).change();
        
        }
      });   
  }


</script>