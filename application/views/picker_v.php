
<!-- Modal -->
<div class="modal" id="picker" tabindex="-2" role="dialog" aria-labelledby="pickerLabel">
  <div class="modal-dialog modal-xl" style="width:90%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="pickerLabel">Data Picker</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="picker_content"></div>
        <input type="hidden" name="picker_id" id="picker_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" id="picker_pick">Select</button>
      </div>
    </div>
  </div>
</div>