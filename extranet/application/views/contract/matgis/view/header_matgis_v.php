<style media="screen">
.label-success, .badge-success {
  background-color: #5b9c1f;
  color: #FFFFFF;
}
</style>
<!-- Initiate State from caller -->
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
        <?php
        switch ($mod) {
          case 'po':
          include(VIEWPATH."/contract/matgis/view/po_header.php");
          break;
          case 'do':
          include(VIEWPATH."/contract/matgis/view/do_header.php");
          break;
          case 'sj':
          include(VIEWPATH."/contract/matgis/view/sj_header.php");
          break;
          case 'inv':
          include(VIEWPATH."/contract/matgis/view/inv_header.php");
          break;
          default:
          break;
        }
        ?>
      </div>
    </div>
  </div>
</div>
