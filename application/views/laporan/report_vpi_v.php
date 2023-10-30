<div class="card">
    <div class="card-body">
        <div class="form_dt_search mb-2" id="form_dt_search">
      		<label>Filter Laporan</label>
      		<form method="GET" action="<?= base_url() ?>laporan/report_vpi">
      		    <div class="row">
                  <div class="form-group col-md-3">
                      <select class="select2 form-control" id="s_year" name="year">
	                      <?php foreach($year as $v) : ?>
                        <option value="<?= $v['year'] ?>"><?= $v['year'] ?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="col-md-2">
                      <button type="submit" class="btn bg-light-warning" id="dt_cari_act"><i class="ft-search"></i> Submit</button>
                  </div>
              </div>
      		</form>
          <button class="btn btn-primary btn-sm float-right mb-2" onclick="downloadPDF()">Download PDF</button>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                       <h4>Tabel VPI Vendor </h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered selection-multiple-rows">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Vendor</th>
                                  <th>Januari</th>
                                  <th>Februari</th>
                                  <th>Maret</th>
                                  <th>April</th>
                                  <th>Mei</th>
                                  <th>Juni</th>
                                  <th>Juli</th>
                                  <th>Agustus</th>
                                  <th>September</th>
                                  <th>Oktober</th>
                                  <th>November</th>
                                  <th>Desember</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($data_vendor as $key => $value) :?>
                                  <tr>
                                  <td><?= $key +1 ?></td>
                                  <td><?= $value['vendor_name'] ?></td>
                                  <td><?= $value['januari'] ?></td>
                                  <td><?= $value['februari'] ?></td>
                                  <td><?= $value['maret'] ?></td>
                                  <td><?= $value['april'] ?></td>
                                  <td><?= $value['mei'] ?></td>
                                  <td><?= $value['juni'] ?></td>
                                  <td><?= $value['juli'] ?></td>
                                  <td><?= $value['agustus'] ?></td>
                                  <td><?= $value['september'] ?></td>
                                  <td><?= $value['oktober'] ?></td>
                                  <td><?= $value['november'] ?></td>
                                  <td><?= $value['desember'] ?></td>
                                  </tr>
                                <?php endforeach; ?>

                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4>Tabel VPI PROYEK </h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered selection-multiple-rows">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Proyek</th>
                                  <th>Tahun</th>
                                  <th>Januari</th>
                                  <th>Februari</th>
                                  <th>Maret</th>
                                  <th>April</th>
                                  <th>Mei</th>
                                  <th>Juni</th>
                                  <th>Juli</th>
                                  <th>Agustus</th>
                                  <th>September</th>
                                  <th>Oktober</th>
                                  <th>November</th>
                                  <th>Desember</th>
                                </tr>
                              </thead>
                              <tbody>
                  						<?php foreach ($data_proyek as $key => $value) :?>
                                  <tr>
                                  <td><?= $key +1 ?></td> 
                                  <td><?= $value['subject_work'] ?></td>
                                  <td><?= $value['vpi_year'] ?></td>
                                  <td><?= $value['januari'] ?></td>
                                  <td><?= $value['februari'] ?></td>
                                  <td><?= $value['maret'] ?></td>
                                  <td><?= $value['april'] ?></td>
                                  <td><?= $value['mei'] ?></td>
                                  <td><?= $value['juni'] ?></td>
                                  <td><?= $value['juli'] ?></td>
                                  <td><?= $value['agustus'] ?></td>
                                  <td><?= $value['september'] ?></td>
                                  <td><?= $value['oktober'] ?></td>
                                  <td><?= $value['november'] ?></td>
                                  <td><?= $value['desember'] ?></td>
                                  </tr>
                                <?php endforeach; ?>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                       <h4>Tabel VPI Divisi </h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered selection-multiple-rows">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Divisi</th>
                                  <th>Januari</th>
                                  <th>Februari</th>
                                  <th>Maret</th>
                                  <th>April</th>
                                  <th>Mei</th>
                                  <th>Juni</th>
                                  <th>Juli</th>
                                  <th>Agustus</th>
                                  <th>September</th>
                                  <th>Oktober</th>
                                  <th>November</th>
                                  <th>Desember</th>
                                </tr>
                              </thead>
                              <tbody>
                  						<?php foreach ($data_divisi as $key => $value) :?>
                                  <tr>
                                  <td><?= $key +1 ?></td>
                                  <td><?= $value['dept_name'] ?></td>
                                  <td><?= $value['januari'] ?></td>
                                  <td><?= $value['februari'] ?></td>
                                  <td><?= $value['maret'] ?></td>
                                  <td><?= $value['april'] ?></td>
                                  <td><?= $value['mei'] ?></td>
                                  <td><?= $value['juni'] ?></td>
                                  <td><?= $value['juli'] ?></td>
                                  <td><?= $value['agustus'] ?></td>
                                  <td><?= $value['september'] ?></td>
                                  <td><?= $value['oktober'] ?></td>
                                  <td><?= $value['november'] ?></td>
                                  <td><?= $value['desember'] ?></td>
                                  </tr>
                                <?php endforeach; ?>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


		

</div>

<script src="<?php echo base_url('assets'); ?>/app-assets/vendors/js/apexcharts.min.js"></script>

<script>
	var base_url = "<?= base_url() ?>";

  function downloadPDF() {
    const queryString = window.location.search;
    window.open(`/laporan/report_vpi_print${queryString}`, "_blank")
  }

</script>
