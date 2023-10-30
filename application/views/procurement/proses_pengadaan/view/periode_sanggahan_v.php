<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Periode Sanggahan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <?php $curval = $prep['ptp_denial_period']; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Lama Sanggahan</label>
              <div class="col-sm-4">
              <p class="form-control-static"><?php echo (!empty($curval)) ? $curval." Hari" : "Tidak Ada" ?></p>
              </div>
            </div>

            <?php $curval = $prep['ptp_denial_period_start']; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Mulai Sanggahan</label>
              <div class="col-sm-4">
              <p class="form-control-static"><?php echo (!empty($curval)) ? date(DEFAULT_FORMAT_DATETIME,strtotime($curval)) : "" ?></p>
              </div>
            </div>

            <?php $curval = $prep['ptp_denial_period_end']; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Selesai Sanggahan</label>
              <div class="col-sm-4">
              <p class="form-control-static"><?php echo (!empty($curval)) ? date(DEFAULT_FORMAT_DATETIME,strtotime($curval)) : "" ?></p>
              </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
