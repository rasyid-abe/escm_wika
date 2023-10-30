<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Periode Sanggahan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <?php $curval = $prep['ptp_denial_period']; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Lama Sanggahan *</label>
            <div class="col-sm-3">              
              <div class="input-group input-group-sm">
                  <input type="number" class="form-control" min="0" maxlength="2" name="periode_sanggahan_inp" id="periode_sanggahan_inp" aria-describedby="sizing-addon1" required>
                  <div class="input-group-append">
                      <span class="input-group-text" id="sizing-addon1">Hari Kerja</span>
                  </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>