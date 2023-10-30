<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <div class="btn-group-sm">
          <span class="card-title text-bold-600 mr-2">Person In Charge</span>
        </div>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="table-responsive table-striped">
            <table class="table" style="margin-bottom: 0;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Divisi</th>
                  <th>Perusahaan</th>
                  <th>No. Telpon</th>
                  <th>Email</th>
                  <th>Keterangan</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                if (isset($person) && !empty($person)) {
                  foreach ($person as $key => $value) {
                    $myid = $key + 1;
                ?>

                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td>
                        <?php echo $value['pp_nama_lengkap'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_jabatan'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_divisi'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_nama_perusahaan'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_no_telp'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_email'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_note'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_created_date'] ?>
                      </td>                      
                    </tr>

                <?php }
                } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
