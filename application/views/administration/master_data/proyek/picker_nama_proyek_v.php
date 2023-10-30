<style>

  .input-group > .form-control:not(:first-child), .input-group > .custom-select:not(:first-child) {
    background-color: #e9ecef;
  }

  .form-control {
    font-size: 12px;
    background-color: #f7f7f8;
    outline: none;
  }

  .form-control:hover {
    border-color: #29a7de;
  }

  .dataTables_wrapper .dataTables_filter input {
    border: 2px solid #29a7de;
    border-top: 0;
    border-left: 0;
    border-right: 0;
    border-radius: 15px;
    padding: 6px;
    background-color: transparent;
    margin-left: 11px;
  }

</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title text-bold-600 mr-2">Daftar Pembuatan Proyek <?php echo $year; ?> (Non PMCS)</h4>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table comment table-striped">
                        <thead>
                          <tr>
                              <th>Pilih</th>
                              <th>Kode Proyek</th>
                              <th>Customer</th>
                              <th>Nama Proyek</th>
                              <th>HPS</th>
                              <th>Jadwal Tender</th>
                              <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($getCrm)) { ?>
                            <?php foreach ($getCrm as $v) { ?>
                              <tr>
                                <td><input type="radio" name="kdpyk" data-kode="<?php echo $v['KodeProyek'];?>" value="<?php echo $v['NamaProyek'];?>"></td>
                                <td class="text-center"><?php echo $v['KodeProyek'];?></td>
                                <td><?php echo $v['Customer'];?></td>
                                <td><?php echo $v['NamaProyek'];?></td>
                                <td class="text-right"><?php echo inttomoney($v['HPS']);?></td>
                                <td><?php echo $v['JadwalTender'];?></td>
                                <td><?php echo $v['Status'];?></td>
                              </tr>
                            <?php } ?>
                          <?php } ?>

                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

  $(document).ready(function () {
    $("table.comment").bootstrapTable({
      pagination:true,
      search:true,
      sortable:true
    });
  });

</script>
