<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <!-- <h4 class="card-title float-left">Master Lokasi Proyek</h4> -->
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <a class="btn btn-info mb-3" href="<?php echo site_url('administration/master_data/penilaian_resiko_paket/add') ?>" role="button"><i class="ft-plus mr-1"></i>Tambah</a>
              <table class="table table-striped">
                <?php foreach ($rows as $key => $value) { ?>
                  <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Skala Resiko</th>
                    <th>Bobot</th>
                    <th style="text-align: center;">Aksi</th>
                  </tr>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $value['kategori'] ?></td>
                    <td><?= $value['kategori'] ?></td>
                    <td><?= $value['kategori'] ?></td>
                    <td style="text-align: center;">
                      <div class="btn-group"><a class="btn btn-sm btn-info btn-xs action" href="<?php site_url('administration/master_data/penilaian_resiko_paket') . '/edit/' . $value['id'] ?>">
                          <i class="ft-edit mr-1"></i>Edit</a>
                        <a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm('Anda yakin ingin menonaktifkan data?')" href="<?php site_url('administration/master_data/penilaian_resiko_paket') . '/delete/' . $value['id'] ?>">
                          <i class="ft-trash mr-1"></i>Hapus</a>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>