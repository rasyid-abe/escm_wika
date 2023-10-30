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
              foreach ($opportunity as $k => $val) {
                $numb = ($k + 1);
              ?>
                <tr>
                  <td>
                    <?= $val['pengusul'] ?>
                    <input type='hidden' class='id_opportunity' data-no="<?= $numb ?>" name="id_opportunity[<?= $numb ?>]" value="<?= $val['id'] ?>" />
                    <input type='hidden' class='pengusul' data-no="<?= $numb ?>" name="pengusul[<?= $numb ?>]" value="<?= $val['pengusul'] ?>" />
                  </td>
                  <td>
                    <?= $val['area'] ?>
                    <input type='hidden' class='area' data-no="<?= $numb ?>" name="area[<?= $numb ?>]" value="<?= $val['area'] ?>" />
                  </td>
                  <td>
                    <?= $val['opportunity'] ?>
                    <input type='hidden' class='opportunity' data-no="<?= $numb ?>" name='opportunity[<?= $numb ?>]' value="<?= $val['opportunity'] ?>" />
                  </td>
                  <td>
                    <?= $val['benefit'] ?>
                    <input type='hidden' class='benefit' data-no="<?= $numb ?>" name='benefit[<?= $numb ?>]' value="<?= $val['benefit'] ?>" />
                  </td>
                  <td>
                    <?= $val['nilai_benefit'] ?>
                    <input type='hidden' class='nilai_benefit' data-no="<?= $numb ?>" name='nilai_benefit[<?= $numb ?>]' value="<?= $val['nilai_benefit'] ?>" />
                  </td>
                  <td>
                    <?= $val['probabilitas'] ?>
                    <input type='hidden' class='probabilitas' data-no="<?= $numb ?>" name='probabilitas[<?= $numb ?>]' value="<?= $val['probabilitas'] ?>" />
                  </td>
                  <td>
                    <?= $val['rtl'] ?>
                    <input type='hidden' class='rtl' data-no="<?= $numb ?>" name='rtl[<?= $numb ?>]' value="<?= $val['rtl'] ?>" />
                  </td>
                  <td>
                    <?= $val['biaya'] ?>
                    <input type='hidden' class='biaya' data-no="<?= $numb ?>" name='biaya[<?= $numb ?>]' value="<?= $val['biaya'] ?>" />
                  </td>
                  <td>
                    <?= $val['hambatan'] ?>
                    <input type='hidden' class='hambatan' data-no="<?= $numb ?>" name='hambatan[<?= $numb ?>]' value="<?= $val['hambatan'] ?>" />
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