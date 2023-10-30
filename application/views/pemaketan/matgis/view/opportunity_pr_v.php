<style scoped>
  .btn-action-edit {
    border-radius: 8px 0 0 8px;
    width: 100px;
  }

  .btn-action-delete {
    border-radius: 0 8px 8px 0;
    background-color: rgb(36 36 36 / 22%);
    position: relative;
    left: -4px;
  }

  .wrapper-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
  }
</style>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <span class="wrapper-header">
            <div class="title-header d-flex align-items-center">
              <h4 class="card-title ">OPPORTUNITY</h4>
            </div>
          </span>

          <table class="table table-striped" id="table_opportunity">
            <thead>
              <tr>
                <th>Pengusul</th>
                <th>Area</th>
                <th>Opportunity</th>
                <th>Benefit</th>
                <th>Nilai Benefit</th>
                <th>Probabilitas</th>
                <th>RTL</th>
                <th>Biaya</th>
                <th>Hambatan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($opportunity as $k => $val) { ?>
                <td><?= $val['pengusul'] ?></td>
                <td><?= $val['area'] ?></td>
                <td><?= $val['opportunity'] ?></td>
                <td><?= $val['benefit'] ?></td>
                <td><?= $val['nilai_benefit'] ?></td>
                <td><?= $val['probabilitas'] ?></td>
                <td><?= $val['rtl'] ?></td>
                <td><?= $val['biaya'] ?></td>
                <td><?= $val['hambatan'] ?></td>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>