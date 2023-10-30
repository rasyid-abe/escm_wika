<style media="screen">
.label-success, .badge-success {
  background-color: #5b9c1f;
  color: #FFFFFF;
}
</style>
<!-- Initiate State from caller -->
<input type="hidden" name="type_form" value="<?php echo $type_form?>">
<input type="hidden" name="state" value="<?php echo $state?>">
<input type="hidden" name="reff" value="<?php echo $reff?>">
<input type="hidden" name="mod" value="<?php echo $mod?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<?php $curval = (isset($header[$mod.'_total'])) ? $header[$mod.'_total'] : 0; ?>
<input type="hidden" name="<?php echo $mod?>_total" value="<?php echo $curval ?>">
<?php $curval = (isset($header['activity_id'])) ? $header['activity_id'] : 0; ?>
<input type="hidden" name="activity_id" value="<?php echo $curval ?>">

<?php
// $data=array();
$ext=null;
$filename=isset($doc['filename'])?$doc['filename']:"";
if($filename){
$ext = pathinfo($filename, PATHINFO_EXTENSION);
}
?>
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Header <?php echo $title?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">
        <div class="form-group">
          <?php

          if($mod=='wo'){
            $mod_label='po';
          }else{
            $mod_label=$mod;
          }?>
          <label class="col-sm-2 control-label">Nomor <?php echo strtoupper($mod_label)?>*</label>
          <div class="col-sm-10">
            <p class="form-control-static">
              <?php $curval = (isset($header[$mod.'_number'])) ? $header[$mod.'_number'] : ""; ?>
              <?php if(!empty($curval)){ ?>
                <?php echo $curval ?>
                <input type="hidden"  name="<?php echo $mod?>_number" id="<?php echo $mod?>_number" value="<?php echo $curval ?>">
              <?php } else { ?>
                <input type="text" name="<?php echo $mod?>_number" id="<?php echo $mod?>_number" value="<?php echo $curval ?>" required>
              <?php } ?>
            </p>
          </div>
        </div>
        <?php
        switch ($mod) {
          case 'wo':
          include(VIEWPATH."/matgis/screens/po.php");
          break;
          case 'skbdn':
          include(VIEWPATH."/matgis/screens/skbdn.php");
          break;
          case 'si':
          include(VIEWPATH."/matgis/screens/si.php");
          break;
          case 'sppm':
          include(VIEWPATH."/matgis/screens/sppm.php");
          break;
          case 'do':
          include(VIEWPATH."/matgis/screens/header_do.php");
          break;
          case 'sj':
          include(VIEWPATH."/matgis/screens/header_sj.php");
          break;
          case 'bapb':
          include(VIEWPATH."/matgis/screens/header_bapb.php");
          break;
          case 'inv':
          include(VIEWPATH."/matgis/screens/header_inv.php");
          break;
          default:
          // code...
          break;
        }
        ?>
      </div>
    </div>
  </div>
</div>
<script>
$(function () {
  $("#hapus_file").click(function(){
    $("#matgis_file").attr("src", "");
    $.ajax({
      url: "contract/DeleteFile/"+$("#filename").val(),
      type: "post",
      data: {filename:$("#filename").val()} ,
      success: function (response) {
        alert("file dihapus");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });

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


</script>
