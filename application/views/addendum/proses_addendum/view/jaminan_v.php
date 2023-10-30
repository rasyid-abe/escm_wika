<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>JAMINAN PELAKSANAAN</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

        <?php $curval = (isset($kontrak['pf_bank'])) ? $kontrak['pf_bank'] : ""; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Bank</label>
          <div class="col-sm-8">
            <p class="form-control-static">
              <?php echo $curval ?>
            </p>
          </div>
        </div>

        <?php $curval = (isset($kontrak['pf_number'])) ? $kontrak['pf_number'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor Jaminan</label>
          <div class="col-sm-4">
            <p class="form-control-static">
              <?php echo $curval ?>
            </p>
          </div>
        </div>

        <?php $curval = date("d M Y - H:i:s",strtotime($kontrak['pf_start_date'])); ?>
        
        <div class="form-group">
          <label class="col-sm-2 control-label">Mulai Berlaku</label>
          <div class="col-sm-4">
            
            <p class="form-control-static">
              <?php echo $curval ?>
            </p>

          </div>
        </div>

        <?php $curval = date("d M Y - H:i:s",strtotime($kontrak['pf_end_date'])); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Berlaku Hingga</label>
          <div class="col-sm-4">
            
            <p class="form-control-static">
              <?php echo $curval ?>
            </p>

          </div>
        </div>

        
        <?php $curval = (isset($kontrak['ctr_currency'])) ? $kontrak["ctr_currency"] : set_value("ctr_currency_inp");?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Mata Uang Jaminan</label>
          <div class="col-sm-3">
           <select class="form-control" disabled name="currency_inp" value="<?php echo $curval ?>">
             <option value="">--Pilih--</option>
             <?php foreach($currency as $key => $val){
              $selected = ($val['curr_code'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['curr_code'] ?>"><?php echo $val['curr_code']." - ".$val['curr_name']?></option>
              <?php } ?>
            </select>
          </div>
        </div>


        <?php $curval = (isset($kontrak['pf_amount'])) ? inttomoney($kontrak['pf_amount']) : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nilai Jaminan</label>
          <div class="col-sm-5">
            <p class="form-control-static">
              <?php echo $curval ?>
            </p>
          </div>
        </div>

        <?php $curval = (isset($kontrak['pf_attachment'])) ? $kontrak['pf_attachment'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lampiran Jaminan</label>
          <div class="col-sm-5">
            <p class="form-control-static">
              <a href="<?php echo site_url("log/download_attachment/contract/".$curval) ?>" target="_blank">
                <?php echo $curval ?>
              </a>
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>