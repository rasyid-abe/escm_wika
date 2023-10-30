

<form class="form-horizontal">
  <div class="row">
      <div class="col-12">
          <div class="card">
            
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Header</h4>
            </div>

            <div class="card-content">
              <div class="card-body">
                  <?php $curval = $data['evt_name']; ?>
                  <div class="row form-group">
                      <label class="col-sm-2 control-label text-right">Nama *</label>
                      <div class="col-sm-10">
                      <input disabled type="text" class="form-control" required id="nama_inp" name="nama_inp" value="<?php echo $curval ?>">
                    </div>
                  </div>

                  <?php $curval = $data['evt_type']; ?>
                  <div class="row form-group">
                    <label class="col-sm-2 control-label text-right">Jenis *</label>
                    <div class="col-sm-4">
                      <select disabled class="form-control" required id="jenis_inp" name="jenis_inp">
                        <?php $selected = ($curval == 0) ? "selected" : "" ?>
                          <option <?php echo $selected ?> value="0">Evaluasi Kualitas Terbaik</option>
                        <?php $selected = ($curval == 1) ? "selected" : "" ?>
                        <option <?php echo $selected ?> value="1">Evaluasi Kualitas Teknik Dan Harga</option>
                        <?php $selected = ($curval == 2) ? "selected" : "" ?>
                        <option <?php echo $selected ?> value="2">Evaluasi Harga Rendah</option>
                      </select>
                    </div>
                  </div>

                  <?php $curval = $data['evt_passing_grade']; ?>
                  <div class="row form-group">
                    <label class="col-sm-2 control-label text-right">Passing Grade *</label>
                      <div class="col-sm-5">
                      <input disabled type="text" class="form-control money" maxlength="3" required id="passing_grade_inp" name="passing_grade_inp" value="<?php echo $curval ?>">
                    </div>
                  </div>

                  <?php $curval = $data['evt_tech_weight']; ?>
                  <div class="row form-group">
                    <label class="col-sm-2 control-label text-right">Bobot Teknis *</label>
                    <div class="col-sm-2">
                      <input disabled type="text" class="form-control" required id="bobot_teknis_inp" name="bobot_teknis_inp" value="<?php echo $curval ?>">
                    </div>
                  </div>

                  <?php $curval = $data['evt_price_weight']; ?>
                  <div class="row form-group">
                    <label class="col-sm-2 control-label text-right">Bobot Harga *</label>
                    <div class="col-sm-2">
                      <input disabled type="text" class="form-control" required id="bobot_harga_inp" name="bobot_harga_inp" value="<?php echo $curval ?>">
                    </div>
                  </div>
              </div>


            </div>

          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-12">
          <div class="card">
            
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Item Administrasi/Teknis</h4>
            </div>

            <div class="card-content">
              <div class="card-body">
                <table class="table table-bordered" id="item_table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Item</th>
                      <th>Jenis</th>
                      <th>Bobot</th>
                      <th></th>

                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($detail as $key => $value) { ?>
                  <tr>
                  <td><?php echo $key+1 ?></td>
                      <td><input disabled type='hidden' class='item_name' data-no='<?php echo $value['etd_id'] ?>' name='item_name[<?php echo $value['etd_id'] ?>]' value='<?php echo $value['etd_item'] ?>'/><?php echo $value['etd_item'] ?></td>
                      <td><input disabled type='hidden' class='item_jenis' data-no='<?php echo $value['etd_id'] ?>' name='item_jenis[<?php echo $value['etd_id'] ?>]' value='<?php echo $value['etd_mode'] ?>'/><?php echo ($value['etd_mode'] == 1) ? "Teknis" : "Administrasi" ?></td>
                      <td class="text-right"><input disabled type='hidden' class='item_bobot' data-no='<?php echo $value['etd_id'] ?>' name='item_bobot[<?php echo $value['etd_id'] ?>]' value='<?php echo $value['etd_weight'] ?>'/><?php echo $value['etd_weight'] ?></td>
                      <td><?php if($value['etd_weight'] > 0) : ?><a id="btnModalScore" onclick="fModalScore(<?php echo $value['etd_id'] ?>)" class="btn btn-info">Petunjuk Score</a><?php endif; ?></td>
                      
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-content">
          <div class="card-body">
            <?php echo buttonback('procurement/procurement_tools/daftar_template_evaluasi_pengadaan',lang('back'),lang('save')) ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</form>


<div id="score-modal" class="modal fade" tabindex="-1" role="dialog"  >
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">Title</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Content</p>
      </div>
      <div class="modal-footer">
        Footer
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
    
  });

  function fModalScore(id)
  {
    window.open('<?= base_url() ?>'+"/"+"procurement/procurement_tools/lihat_template_evaluasi_score/"+id);
    //$("#score-modal").modal("show");
  }

</script>
<?php include("form_template_evaluasi_js.php") ?>