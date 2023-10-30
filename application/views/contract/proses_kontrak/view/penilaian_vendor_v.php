<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Review Vendor</h4>
      </div>

      <div class="card-content">
        <div class="card-body" style="overflow-x: auto">
            <table class="table table-bordered table-responsive">
              <thead>
                <tr class="text-center">
                  <th width="10%">Kode</th>
                  <th>Kriteria</th>
                  <th colspan="2" width="20%">Review</th>
                </tr>
              </thead>              

              <tbody>
                <?php 
                $i = 0;
                foreach ($penilaian as $key => $value) {?>
                <tr <?php if(strlen($value['kode']) <= 3){?> class="text-bold-700 font-medium-3"<?php }?>>
                <td><?php echo $value['kode']?></td>
                <td><?php echo $value['pertanyaan'] ?></td>    

                <input type="hidden" value="<?php echo $value['id']?>" name="id_question[]">

                <?php if(strlen($value['kode']) > 3){?>
                <td><input type="radio" name="jawaban[<?php print $i; ?>]" value="1" id="ya" disabled> IYA</td>
                <td><input type="radio" name="jawaban[<?php print $i; ?>]" value="0"  id="tidak" disabled> TIDAK</td>
                <?php } else {?>
                <td>
                  <td><input type="hidden" name="jawaban[<?php print $i; ?>]" value="0"  id="tidak"> </td>
                  <?php }?>

                </tr>

                <?php $i++;
              }?>
              

            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
