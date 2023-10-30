
<div class="row">
  <div class="col-lg-12">
    <center>
      <a class="btn btn-primary tambah_dok">Tambah Dokumen</a>
      <br/>
      <br/>
    </center>
  </div>

</div>

<div id="lampiran_container">

  <?php for ($k = 0; $k <= 4; $k++) { 
    $show = ($k == 0) ? "" : "display:none;";
    ?>

    <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>LAMPIRAN DOKUMEN #<?php echo $k ?></h5>
            <div class="card-tools">

             <?php if($k > 0){ ?>
             <a class="tutup" data-no="<?php echo $k ?>">
              <i class="fa fa-times"></i>
            </a>
            <?php } ?>

            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <?php $curval = set_value("doc_category_inp[$k]"); ?>
          <div class="form-group">
            <label class="col-sm-1 control-label"><?php echo lang('category') ?></label>
            <div class="col-sm-4">
             <select class="form-control" name="doc_category_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
               <option value=""><?php echo lang('choose') ?></option>
               <?php foreach($doc_category as $key => $val){
                $selected = ($val['ldc_name'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['ldc_name'] ?>"><?php echo $val['ldc_name'] ?></option>
                <?php } ?>
              </select>
            </div>
            <?php $curval = set_value("doc_attachment_inp[$k]"); ?>
            <label class="col-sm-1 control-label"><?php echo lang('attachment') ?></label>
            <div class="col-sm-6">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                    <i class="fa fa-cloud-upload"></i> Upload
                  </button> 
                  <button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/$dir/$curval" ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                    <i class="fa fa-share"></i> Preview
                  </button> 
                </span> 
                <input readonly type="text" class="form-control" id="doc_attachment_inp_<?php echo $k ?>" name="doc_attachment_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                <span class="input-group-btn">
                  <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-danger removefile">
                    <i class="fa fa-trash"></i> Delete
                  </button> 
                </span> 
              </div>
               <div class="col-sm-0" style="font-size: 11px">
                <i>Max file 5 MB 
                <br>
                  Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                </i>
              </div>
            </div>
          </div>

          <?php $curval = set_value("doc_desc_inp[$k]"); ?>
          <div class="form-group">
            <label class="col-sm-1 control-label"><?php echo lang('description') ?></label>
            <div class="col-sm-11">
             <textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
           </div>
         </div>

       </div>
     </div>
   </div>
 </div>

 <?php } ?>

</div>