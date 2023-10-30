<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Keputusan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <?php $curval = ""; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Keputusan</label>
            <div class="col-sm-10">
                <input type="radio" name="keputusan" value="Selesai"> Selesai <span><input type="radio" name="keputusan" value="Terminasi"> Terminasi</span>
            </div>
          </div>

          <?php $curval = ""; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Catatan Singkat</label>
            <div class="col-sm-10">
              <textarea class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>