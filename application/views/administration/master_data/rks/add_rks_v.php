<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_rks");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">

            <div class="form-group">
              <label for="exampleInputEmail1">RKS Header</label>
              <input type="text" class="form-control" id="header_main" name="header_main" placeholder="Enter Header Main">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">RKS Header Sub</label>
              <input type="text" class="form-control" id="header_sub" placeholder="Enter Header Sub" name="header_sub">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">RKS Description</label>
              <textarea class="form-control" name="description"></textarea>
            </div>

          </div>
        </div>
      </div>
    </div>

    <?php echo buttonsubmit('administration/master_data/rks',lang('back'),lang('save')) ?>

  </form>
</div>

<div class="accordion" id="accordionExample" style="display:none;">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2>
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Tambah Header
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <form action="<?php echo base_url('administration/master_data/rks/submit_add_rks_header'); ?>" method="POST">
  				<div class="modal-body">

  					<label class="text-bold-700">Header Main <span class="text-danger text-bold-700">(*)</span></label>
  					<div class="form-group position-relative has-icon-left">
  						<input type="text" maxlength="100" name="header_main" placeholder="Masukan Header" class="form-control" required>
  						<div class="form-control-position">
  							<i class="ft-airplay font-medium-2 text-muted"></i>
  						</div>
  					</div>

  				</div>
  				<div class="modal-footer">
  					<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
  					<input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info" value="Simpan">
  				</div>
  			</form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2>
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Tambah Sub Header
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <form action="<?php echo base_url('administration/master_data/rks/submit_add_rks_header_sub'); ?>" method="POST">
  				<div class="modal-body">

  					<label class="text-bold-700">Header Main <span class="text-danger text-bold-700">(*)</span></label>
  					<div class="form-group">
                <select class="form-control" name="header_main" required>
                    <option value="">Pilih</option>
                    <?php foreach ($rks_header as $v) { ?>
                        <option value="<?php echo $v['header_main']?>"><?php echo $v['header_main']?></option>
                    <?php } ?>
                </select>
  					</div>

  					<label class="text-bold-700">Header Sub <span class="text-danger text-bold-700">(*)</span></label>
  					<div class="form-group position-relative has-icon-left">
  						<input type="text" maxlength="200" name="header_sub" placeholder="Masukan Header Sub" class="form-control" required>
  						<div class="form-control-position">
  							<i class="ft-airplay font-medium-2 text-muted"></i>
  						</div>
  					</div>

  				</div>
  				<div class="modal-footer">
  					<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
  					<input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info" value="Simpan">
  				</div>
  			</form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2>
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Tambah Description
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        <form action="<?php echo base_url('administration/master_data/rks/add_rks_description'); ?>" method="POST">
  				<div class="modal-body">

            <label class="text-bold-700">Header Main <span class="text-danger text-bold-700">(*)</span></label>
  					<div class="form-group">
              <select class="form-control" name="header_main" required>
                  <option value="">Pilih</option>
                  <?php foreach ($rks_header as $v) { ?>
                      <option value="<?php echo $v['header_main']?>"><?php echo $v['header_main']?></option>
                  <?php } ?>
              </select>
  					</div>

            <label class="text-bold-700">Header Sub <span class="text-danger text-bold-700">(*)</span></label>
  					<div class="form-group">
              <select class="form-control" name="header_sub" required>
                  <option value="">Pilih</option>
                  <?php foreach ($rks_header_sub as $v) { ?>
                      <option value="<?php echo $v['header_sub']?>"><?php echo $v['header_sub']?></option>
                  <?php } ?>
              </select>
  					</div>

  					<label class="text-bold-700">Description <span class="text-danger text-bold-700">(*)</span></label>
  					<div class="form-group position-relative has-icon-left">
  						<textarea rows="6" class="form-control round" name="description" placeholder="Masukan Description" required></textarea>
  						<div class="form-control-position">
  							<i class="ft-airplay font-medium-2 text-muted"></i>
  						</div>
  					</div>

  				</div>
  				<div class="modal-footer">
  					<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
  					<input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info" value="Simpan">
  				</div>
  			</form>
      </div>
    </div>
  </div>
</div>
