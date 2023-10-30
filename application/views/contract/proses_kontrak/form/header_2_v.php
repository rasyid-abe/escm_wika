<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Header</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : "AUTO NUMBER"; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Nomor Pengadaan</label>
            <div class="col-sm-10">
            <p class="form-control-static">
            <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$curval) ?>" target="_blank">
            <?php echo $curval ?>
            </a></p>
            </div>
            </div>

            <?php $curval = (isset($tender['ptm_requester_name'])) ? $tender['ptm_requester_name'] : ""; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Nama Pengguna Barang/Jasa</label>
            <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            </div>

            <?php $curval = (isset($kontrak['vendor_name'])) ? $kontrak['vendor_name'] : ""; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Vendor</label>
            <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            </div>

            <?php $curval = (isset($kontrak['contract_type'])) ? $kontrak['contract_type'] : set_value("lokasi_kebutuhan_inp"); ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Tipe Kontrak</label>
            <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            </div>

            <?php $curval = (isset($kontrak[''])) ? $kontrak[''] : set_value(""); ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Tanggal Penetapan Pelaksana Pekerjaan</label>
            <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            </div>

            <?php $curval = (isset($kontrak['contract_type_2'])) ? $kontrak["contract_type_2"] : set_value("jenis_kontrak_inp"); ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Jenis Kontrak *</label>
            <div class="col-sm-3">
            <select class="form-control" required name="jenis_kontrak_inp" value="<?php echo $curval ?>">
            <option value="">Pilih Jenis Kontrak</option>
            <?php foreach($contract_type as $key => $val){
            $selected = ($val == $curval) ? "selected" : ""; 
            ?>
            <option <?php echo $selected ?> value="<?php echo $val ?>"><?php echo $val ?></option>
            <?php } ?>
            </select>
            </div>
            </div>

            <?php $curval = (isset($kontrak['start_date'])) ?  date("Y-m-d",$kontrak["start_date"]) : set_value("tgl_mulai_inp"); ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Tanggal Mulai Kontrak *</label>
            <div class="col-sm-4">
            <div class="input-group date">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" required name="tgl_mulai_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
            </div>
            </div>

            <?php $curval = (isset($kontrak['end_date'])) ?  date("Y-m-d",$kontrak["end_date"]) : set_value("tgl_akhir_inp"); ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Tanggal Berakhir Kontrak *</label>
            <div class="col-sm-4">
            <div class="input-group date">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" required name="tgl_akhir_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
            </div>
            </div>

            <?php $curval = (isset($hps['hps_total'])) ? inttomoney($hps['hps_total']) : 0; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Nilai HPS</label>
            <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            </div>


            <?php $curval = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Nilai Kontrak</label>
            <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            </div>


            <?php $curval = (isset($kontrak['subject_work'])) ? $kontrak['subject_work'] : set_value("subject_work_inp"); ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Judul Pekerjaan *</label>
            <div class="col-sm-8">
            <input class="form-control" required name="subject_work_inp" value="<?php echo $curval ?>">
            </div>
            </div>

            <?php $curval = (isset($kontrak['scope_work'])) ? $kontrak['scope_work'] : set_value("scope_work_inp"); ?>
            <div class="row form-group">
            <label class="col-sm-2 control-label text-right">Deskripsi Pekerjaan *</label>
            <div class="col-sm-8">
            <textarea class="form-control" required name="scope_work_inp"><?php echo $curval ?></textarea>
            </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
