<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>KEPUTUSAN</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="card-content">

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