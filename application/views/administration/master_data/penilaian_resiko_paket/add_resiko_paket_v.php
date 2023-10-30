<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name . "/submit_add"); ?>" class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <h5>Tambah Penilaian Resiko</h5>
              </div>
              <div class="card-content">
                <div class="row">
                  <div class="col-md">
                    <div class="form-group">
                      <label for="">Jenis Penilaian</label>
                      <select class="form-control" name="jenis_penilaian" id="jenis_penilaian">
                        <option value="">Pilih jenis penilaian</option>
                        <option value="Barang">Barang</option>
                        <option value="Basa">Jasa</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="">Kategori</label>
                      <input type="text" name="kategori" id="kategori" class="form-control">
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="form-group">
                      <label for="">Skala Resiko</label>
                      <?php $currentSkala = 0; ?>
                      <a class="btn btn-info btn-sm" onclick="addSkala()">
                        <i class="ft-plus"></i>
                      </a>
                      <a class="btn btn-warning btn-sm" onclick="delSkala()">
                        <i class="ft-trash"></i>
                      </a>
                      <div class="wrapper-skala" id="skalaResiko">
                        <input type="text" name="jenis_penilaian" id="jenis_penilaian" data-id="<?= $currentSkala ?>" class="form-control">
                        <?= $currentSkala ?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="">Bobot</label>
                      <select class="form-control" name="jenis_penilaian" id="jenis_penilaian">
                        <option value="">Pilih jenis penilaian</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div style="margin-bottom: 60px;">
          <?php echo buttonsubmit('administration/master_data/penilaian_resiko_paket', lang('back'), lang('save')) ?>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  function addSkala() {
    <?php $currentSkala = $currentSkala + 1 ?>
    <?php echo $currentSkala ?>
    document.getElementById('skalaResiko').innerHTML += '<input type="text" name="jenis_penilaian" id="jenis_penilaian" data-id="<?= $currentSkala + 1 ?>" class="form-control">'
  }

  function delSkala() {
    document.getElementById('skalaResiko').innerHTML -= '<input type="text" name="jenis_penilaian" id="jenis_penilaian" data-id="<?= $currentSkala + 1 ?>" class="form-control">'
  }
</script>