<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Penetapan Pelaksana Pekerjaan</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
            <h2 align="center"><strong>Pilih Pelaksana Pekerjaan</strong></h2>

            <select class="form-control mb-3" name="winner_inp[]" required>
              <option value="">--Pilih--</option>
              <?php foreach ($evaluation as $key => $value) {
                //print_r($value);
                if($value['adm'] == "Lulus" && $value['pass'] == "Lulus"){
              ?>
                <option style="font-size:12pt;font-weight:bold;" value="<?php echo $value['ptv_vendor_code'] ?>"><?php echo $value['vendor_name'] ?> (<?php echo inttomoney($value['total']) ?>)</option>
              <?php } } ?>
            </select>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
      </div>

    </div>
  </div>
</div>
