
  <form class="col-md-12" method="post" action="<?php echo site_url($controller_name."/submit_edit_anggaran");?>">
    <div class="card">
      <div class="card-body">
				<input type="hidden" name="id" value="<?= $id ?>">
				<?php
					$kode_perkiraan = $data["kode_perkiraan"];
					$nama_perkiraan = $data["nama_perkiraan"];
					$pusat = $data["pusat"];
					$devisi = $data["devisi"];
					$proyek = $data["proyek"];
				?>
         <div class="form-group">
            <label class="control-label">Kode Anggaran</label>
            <input type="text" class="form-control" maxlength="12" name="kode_perkiraan" value="<?= $kode_perkiraan ?>">
          </div>

          <div class="form-group">
            <label class="control-label">Nama Anggaran</label>
            <input type="text" class="form-control" maxlength="255" name="nama_perkiraan" value="<?= $nama_perkiraan ?>">
          </div>

          <div class="form-group">
            <label class="checkbox-inline col-sm-3">
							<?php if($pusat === 't') { ?>
	              <input type="checkbox" class="form-check-input" name="pusat" value="<?= $pusat ?>" checked> Pusat
							<?php } else { ?>
								<input type="checkbox" class="form-check-input" name="pusat" value="<?= $pusat ?>"> Pusat
							<?php } ?>
            </label>
            <label class="checkbox-inline col-sm-3">
							<?php if($devisi === 't') { ?>
	              <input type="checkbox" class="form-check-input" name="divisi" value="<?= $devisi ?>" checked> Divisi
							<?php } else { ?>
								<input type="checkbox" class="form-check-input" name="divisi" value="<?= $devisi ?>"> Divisi
							<?php } ?>
            </label>
            <label class="checkbox-inline col-sm-3">
							<?php if($proyek === 't') { ?>
	              <input type="checkbox" class="form-check-input" name="proyek" value="<?= $proyek ?>" checked> Proyek
							<?php } else { ?>
								<input type="checkbox" class="form-check-input" name="proyek" value="<?= $proyek ?>"> Proyek
							<?php } ?>
            </label>
          </div>

        </div>
      </div>
      <?= buttonsubmit('administration/master_data/anggaran',lang('back'),lang('save')) ?>

    </form>
