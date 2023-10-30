<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Daftar Vendor Usulan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <tr>
                    <th>No</th>
                    <th>Nama Vendor</th>
                    <th>Lokasi</th>
                    <th>Klasifikasi</th>
                  </tr>
                  <?php $no=1; foreach($vendor_usulan as $v) { ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $v['vendor_name']; ?></td>
                      <td><?php echo $v['address_street']; ?></td>
                      <td><?php echo $v['siup_type']; ?></td>
                    </tr>
                  <?php } ?>
                </table>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>