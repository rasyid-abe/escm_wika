  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Headline</h4>
        </div>

        <div class="card-content">
          <div class="card-body">

              <?php $curval = $perencanaan['ppm_planner']; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">User </label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <?php $curval = $perencanaan["ppm_dept_name"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Divisi/Departemen </label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <!-- haqim -->
              <?php $curval = $perencanaan["ppm_type_of_plan"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Jenis Rencana*</label>
                <div class="col-sm-9">
                  <p class="form-control-static" id="kode_proyek">RKP Material Strategis</p>
                </div>
              </div>

              <?php $curval = $perencanaan["ppm_subject_of_work"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Rencana Matgis</label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <?php $curval = $perencanaan["ppm_scope_of_work"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Deskripsi Rencana Matgis</label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <?php $curval = $perencanaan["ppm_pagu_anggaran"] ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nilai Anggaran </label>
                <div class="col-sm-4">

                  <p class="form-control-static"><?php echo inttomoney($curval) ?></p>
                </div>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
