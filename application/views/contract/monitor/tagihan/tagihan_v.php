<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Membuat Tagihan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <?php $curval = ""; ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label text-right">Vendor</label>
              <div class="col-sm-10">
                <P class="form-control"><?php echo $curval ?></P>
              </div>
            </div>

            <?php $curval = ""; ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label text-right">Tanggal Penagihan</label>
              <div class="col-sm-10">
                <P class="form-control"><?php echo $curval ?></P>
              </div>
            </div>

            <?php $curval = ""; ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label text-right">Target Tanggal</label>
              <div class="col-sm-4">
                <div class="input-group"> 
                  <input readonly type="text" class="form-control" id="target_tanggal" name="target_tanggal" value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-id="" data-folder="<?php echo $dir ?>" data-preview="" class="btn btn-primary upload">...</button> 
                  </span>
                </div>
              </div>
            </div>

            <?php $curval = ""; ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label text-right">Bobot (%)</label>
              <div class="col-sm-4">
                <input class="form-control"><?php echo $curval ?>
              </div>
            </div>

            </div>

            <div class="card-content">

            <div class="row">

              <div class="col-xs-5">
              </div>

              <div class="col-xs-2">
                <button class="btn btn-primary" type="submit">Tambah Data</button> <span><button class="btn btn-success" type="submit">Reset</button></span>
              </div>

              <div class="col-xs-5">
              </div>

            </div>
            <br>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Deskripsi</th>
                <th>Target Tanggal</th>
                <th>Bobot (%)</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>1</td>
                <td>Termin 1</td>
                <td>08.10.2015</td>
                <td>60%</td>
                <td align="center"><button class="btn btn-light" type="submit">Ubah</button> <span><button class="btn btn-danger" type="submit">Hapus</button></span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
