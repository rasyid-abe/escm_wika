<!-- Modal -->
<?php $idpick = (isset($isnego) == TRUE) ? "picker_pick_nego" : "picker_pick" ?>
<div class="modal fade" id="picker" tabindex="-1" role="dialog" aria-labelledby="pickerLabel">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="pickerLabel"><?php echo $this->lang->line('Pilih Data'); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="picker_content" width="100%" height="480px;"></div>
        <input type="hidden" name="picker_id" id="picker_id">
      </div>
      <div class="modal-footer">
	      <button type="button" class="btn btn-info" id=<?php echo $idpick ?>><?php echo $this->lang->line('Simpan'); ?></button>
        <button type="button" class="btn btn-secondary" id="dismiss" data-dismiss="modal"><?php echo $this->lang->line('Keluar'); ?></button>
      </div>
    </div>
  </div>
</div>
