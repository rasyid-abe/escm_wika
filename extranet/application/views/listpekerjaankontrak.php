<div class="row">
  <div class="col-lg-12">
    <?php if(!empty($message)){ ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $message ?>
      </div>
      <?php $this->session->unset_userdata("message"); } ?>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Approval PO Matgis</h5>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>Keterangan</th>
                  <th>No. PO</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_po_approve as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["wo_notes"]; ?></td>
                    <td><?php echo $row["wo_number"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('contract_ext_matgis/process_matgis/po/'.$row["wo_id"].'/3') ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["wo_id"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Proses</button>
                      </form>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Pembuatan Delivery Order(DO)</h5>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>No. WO</th>
                  <th>No. SPPM</th>
                  <th>SPPM Title</th>
                  <th>Deskripsi SPPM</th>
                  <th>Tanggal SPPM</th>
                  <th>Target Pengiriman</th>
                  <th>Sisa SPPM</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_sppm as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["wo_number"]; ?></td>
                    <td><?php echo $row["sppm_number"]; ?></td>
                    <td><?php echo $row["sppm_title"]; ?></td>
                    <td><?php echo $row["sppm_notes"]; ?></td>
                    <td><?php echo date("d/m/Y",strtotime($row["sppm_date"])); ?></td>
                    <td><?php echo date("d/m/Y",strtotime($row["tgl_expected_delivery"])); ?></td>
                    <td><?php echo $row["do_remain"]?></td>
                    <td><?php echo $row["awa_name"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('contract_ext_matgis/process_matgis/do/'.$row["sppm_id"]) ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["sppm_id"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('proses_do'); ?></button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Pembuatan Surat Jalan(SJ)</h5>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>No. WO</th>
                  <th>No. SPPM</th>
                  <th>No. DO</th>
                  <th>Judul DO</th>
                  <th>Tanggal SJ</th>
                  <th>Target Pengiriman</th>
                  <th>Sisa SJ</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_do as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["wo_number"]; ?></td>
                    <td><?php echo $row["sppm_number"]; ?></td>
                    <td><?php echo $row["do_number"]; ?></td>
                    <td><?php echo $row["do_title"]; ?></td>
                    <td><?php echo date("d/m/Y",strtotime($row["created_date"])); ?></td>
                    <td><?php echo date("d/m/Y",strtotime($row["tgl_expected_delivery"])); ?></td>
                    <td><?php echo $row["remain"]?></td>
                    <td><?php echo $row["awa_name"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('contract_ext_matgis/process_matgis/sj/'.$row["do_id"]) ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["do_id"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('proses_sj'); ?></button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Pembuatan BAST</h5>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>No. WO</th>
                  <th>No. SPPM</th>
                  <th>No. DO</th>
                  <th>No. SJ</th>
                  <th>Judul DO</th>
                  <th>Tanggal SJ</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_sj as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["wo_number"]; ?></td>
                    <td><?php echo $row["sppm_number"]; ?></td>
                    <td><?php echo $row["do_number"]; ?></td>
                    <td><?php echo $row["sj_number"]; ?></td>
                    <td><?php echo $row["do_title"]; ?></td>
                    <td><?php echo date("d/m/Y",strtotime($row["created_date"])); ?></td>
                    <td><?php echo $row["awa_name"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('contract_ext_matgis/process_matgis/bapb/'.$row["sj_id"]) ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["do_id"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Proses BAST</button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Pembuatan Tagihan</h5>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>No. WO</th>
                  <th>No. SJ</th>
                  <th>Tanggal SJ</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_bapb_invoice as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["wo_number"]; ?></td>
                    <td><?php echo $row["sj_number"]; ?></td>
                    <td><?php echo date("d/m/Y",strtotime($row["created_date"])); ?></td>
                    <td><?php echo $row["awa_name"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('contract_ext_matgis/process_matgis/inv/'.$row["bapb_id"]) ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["bapb_id"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Proses Tagihan</button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Revisi Progress Milestone</h5>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>Deskripsi</th>
                  <th>Presentase (%)</th>
                  <th>Target Tanggal</th>
                  <th>Progress (%)</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_milestone as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["percentage"]; ?></td>
                    <td><?php echo date("d/m/Y",strtotime($row["target_date"])); ?></td>
                    <td><?php echo $row["progress_percentage"]; ?></td>
                    <td><?php echo $row["activity"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('kontrak/process_milestone') ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["milestone_id"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('Pilih'); ?></button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Revisi Progress PO</h5>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. PO</th>
                  <th>No. Kontrak</th>
                  <th>Deskripsi Pekerjaan</th>
                  <th>Tipe</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_wo as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["po_number"]; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["subject_work"]; ?></td>
                    <td><?php echo $row["contract_type"]; ?></td>
                    <td><?php echo $row["activity"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('kontrak/process_wo') ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["po_id"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('Pilih'); ?></button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Pembuatan BAST</h5>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>Deskripsi</th>
                  <th>Presentase Progress</th>
                  <th>Activity</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_bast as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["progress_percentage"]; ?></td>
                    <td><?php echo $row["activity"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('kontrak/process_bast') ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["id"]; ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $row["type"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('Pilih'); ?></button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Pembuatan Tagihan</h5>
        </div>
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>Deskripsi</th>
                  <th>Activity</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list_invoice as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td><?php echo $row["contract_number"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["activity"]; ?></td>
                    <td style="text-align: center;">
                      <form action="<?php echo site_url('kontrak/process_tagihan') ?>" method="POST">
                        <input type="hidden" id="ids" name="ids" value="<?php echo $row["id"]; ?>">
                        <input type="hidden" id="ids_2" name="ids_2" value="<?php echo $row["id_2"]; ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $row["type"]; ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('Pilih'); ?></button>
                      </form>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>

  <script>
  $(document).ready(function() {
    $('.datatabless').DataTable({
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
      "search": {
        "smart": false
      }
    });
  });
  </script>
