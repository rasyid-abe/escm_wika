<div class="row">
  <div class="col-lg-12">


      <?php if(!empty($message)){ ?>

      <div class="alert alert-success" role="alert"><?php echo $message ?></div>

      <?php $this->session->unset_userdata("message"); } ?>

      <div class="ibox float-e-margins">
        <div class="ibox-content">
          <div class="table-responsive">
            <table class="table table-striped table-bordered datatabless">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Kontrak</th>
                  <th>Deskripsi</th>
                  <th>Periode</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($list as $key => $row) { ?>
                  <tr>
                    <td><?php echo ++$key; ?></td>
                    <td>
                      <?php $curval = isset($row["contract_number"]) ? $row["contract_number"] : NULL;
                      echo $curval; ?>
                    </td>
                    <td>
                      <?php $curval = isset($row["subject_work"]) ? $row["subject_work"] : NULL;
                      echo $curval;?>
                    </td>
                    <td>
                      <?php $curval = isset($periode['periode']) ? $periode['periode'] : NULL;
                      $is = isset($month) ? $month : NULL;
                      echo "Periode ".$curval." - ".$is; ?>
                    </td>
                    <td style="text-align: center;">
                      <?php $curval = isset($template['atk_id']) ? $template['atk_id'] : NULL ?>
                      <form action="<?php echo site_url('vsi/insert_kuesioner') ?>" method="POST">
                        <input type="hidden" id="template_id" name="template_id" value="<?php echo $curval; ?>">
                       <!--  <input type="hidden" id="ids_2" name="ids_2" value="<?php echo $row["id_2"]; ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $row["type"]; ?>"> -->
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
