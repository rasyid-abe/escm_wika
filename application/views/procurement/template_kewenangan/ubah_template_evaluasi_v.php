<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_ubah_template_evaluasi");?>"  class="form-horizontal ajaxform">

  <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>HEADER</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">

            <?php $curval = $data['evt_name']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama *</label>
              <div class="col-sm-10">
               <input type="text" class="form-control" required id="nama_inp" name="nama_inp" value="<?php echo $curval ?>">
             </div>
           </div>

           <?php $curval = $data['evt_type']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Jenis *</label>
            <div class="col-sm-4">
             <select class="form-control" required id="jenis_inp" name="jenis_inp">
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
         <div class="form-group">
          <label class="col-sm-2 control-label">Passing Grade *</label>
          <div class="col-sm-5">
           <input type="text" class="form-control money" required id="passing_grade_inp" name="passing_grade_inp" value="<?php echo $curval ?>">
         </div>
       </div>

       <?php $curval = $data['evt_tech_weight']; ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Bobot Teknis *</label>
        <div class="col-sm-2">
         <input type="text" class="form-control money" required id="bobot_teknis_inp" name="bobot_teknis_inp" value="<?php echo $curval ?>">
       </div>
     </div>

     <?php $curval = $data['evt_price_weight']; ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Bobot Harga *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control money" required id="bobot_harga_inp" name="bobot_harga_inp" value="<?php echo $curval ?>">
     </div>
   </div>

 </div>
</div>
</div>
</div>

<br>

<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>ITEM ADMINISTRASI/TEKNIS</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

        <?php $curval = set_value("item"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Item</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" id="item" name="item" value="<?php echo $curval ?>">
         </div>
       </div>

       <?php $curval = set_value("jenis_item"); ?>
       <div class="form-group">
         <label class="col-sm-2 control-label">Jenis Item</label>
         <div class="col-sm-10">
          <div class="radio">
           <label>
             <?php $selected = (0 == $curval) ? "checked" : "";  ?>
             <input type="radio" <?php echo $selected ?> class="jenis_item" name="jenis_item" value="0"> Administrasi
           </label>
           <label>
             <?php $selected = (1 == $curval) ? "checked" : "";  ?>
             <input type="radio" <?php echo $selected ?> class="jenis_item" name="jenis_item" value="1"> Teknis
           </label>
         </div>
       </div>
     </div>

     <?php $curval = set_value("bobot"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Bobot</label>
      <div class="col-sm-3">
       <input type="text" class="form-control money" id="bobot" name="bobot" value="<?php echo $curval ?>">
     </div>
   </div>

   <center>
    <a class="btn btn-primary action_item">Tambah</a>
    <input type="hidden" id="current_item" value=""/>
    <br>
  </center>

  <hr>

  <table class="table table-bordered" id="item_table">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Jenis</th>
        <th>Bobot</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($detail as $key => $value) { ?>
    <tr>
    <td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='<?php echo $value['etd_id'] ?>'><i class='fa fa-edit'></i></button> 
        <button type='button' class='btn btn-primary btn-xs delete_item' data-no='<?php echo $value['etd_id'] ?>'><i class='fa fa-remove'></i></button></td>
        <td><input type='hidden' class='item_name' data-no='<?php echo $value['etd_id'] ?>' name='item_name[<?php echo $value['etd_id'] ?>]' value='<?php echo $value['etd_item'] ?>'/><?php echo $value['etd_item'] ?></td>
        <td><input type='hidden' class='item_jenis' data-no='<?php echo $value['etd_id'] ?>' name='item_jenis[<?php echo $value['etd_id'] ?>]' value='<?php echo $value['etd_mode'] ?>'/><?php echo ($value['etd_mode'] == 1) ? "Teknis" : "Administrasi" ?></td>
        <td class="text-left"><input type='hidden' class='item_bobot' data-no='<?php echo $value['etd_id'] ?>' name='item_bobot[<?php echo $value['etd_id'] ?>]' value='<?php echo $value['etd_weight'] ?>'/><?php echo $value['etd_weight'] ?></td>
        </tr>
    <?php } ?>
    </tbody>
  </table>

</div>

</div>
</div>
</div>

<?php echo buttonsubmit('procurement/procurement_tools/daftar_template_evaluasi_pengadaan',lang('back'),lang('save')) ?>

</form>

</div>

<?php include("form_template_evaluasi_js.php") ?>