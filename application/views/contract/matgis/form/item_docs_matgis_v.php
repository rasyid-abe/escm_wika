<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>LAMPIRAN DOKUMEN</h5>
        <div class="card-tools">

          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

        <div class="row">
          <div class="col-lg-12">
            <center>
              <a class="btn btn-primary tambah_dok">Tambah Lampiran</a>
              <br/>
              <br/>
            </center>
          </div>
        </div>

        <div id="lampiran_container">

          <?php
          //var_dump($documents);
          $sisa = 5;
          if(isset($documents) && !empty($documents)){
            foreach ($documents as $k => $v) {
              $show = ($k == 0 || !empty($v['filename'])) ? "" : "display:none;";
              ?>

              <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
                <div class="col-lg-12">
                  <div class="card float-e-margins">
                    <div class="card-title">
                      <h5>DOKUMEN #<?php echo $k ?></h5>
                      <div class="card-tools">

                        <a class="tutup" data-no="<?php echo $k ?>">
                          <i class="fa fa-times"></i>
                        </a>

                        <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                        </a>
                      </div>
                    </div>
                    <div class="card-content">

                      <?php $curval = (isset($v['category'])) ? $v['category'] :  set_value("doc_category_inp[$k]"); ?>

                      <div class="form-group">
                        <label class="col-sm-1 control-label"><?php echo lang('category') ?></label>
                        <div class="col-sm-4">
                         <select class="form-control" name="doc_category_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                           <option value=""><?php echo lang('choose') ?></option>
                           <?php foreach($doc_category as $key => $val){
                            $selected = ($val['name'] == $curval) ? "selected" : "";
                            ?>
                            <option <?php echo $selected ?> value="<?php echo $val['name'] ?>"><?php echo $val['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <?php $curval = (isset($v['filename'])) ? $v['filename'] :  set_value("doc_attachment_inp[$k]"); ?>
                        <label class="col-sm-1 control-label"><?php echo lang('attachment') ?></label>
                        <div class="col-sm-6">
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                                <i class="fa fa-cloud-upload"></i> Upload
                              </button>
                               <button type="button" data-url="<?php echo site_url('log/download_attachment/'.$mod.'/'.$curval) ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                                <i class="fa fa-share"></i> Preview
                              </button>
                            </span>
                            <input readonly type="text" class="form-control" id="doc_attachment_inp_<?php echo $k ?>" name="doc_attachment_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                            <span class="input-group-btn">
                              <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-danger removefile">
                              <i class="fa fa-trash"></i> Delete
                              </button>
                            </span>
                          </div><div class="col-sm-0" style="font-size: 11px">
                          <i>Max file 5 MB
                          <br>
                            Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                          </i>
                        </div>
                        </div>
                      </div>

                      <?php $curval = (isset($v['description'])) ? $v['description'] :  set_value("doc_desc_inp[$k]"); ?>

                      <div class="form-group">
                        <label class="col-sm-1 control-label"><?php echo lang('description') ?></label>
                        <div class="col-sm-11">
                         <textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
                       </div>
                     </div>

                     <?php $curval = (isset($v['doc_id'])) ? $v['doc_id'] :  ""; ?>
                     <input type="hidden" name="doc_id_inp[<?php echo $k ?>]" value="<?php echo $curval ?>"/>
                   </div>
                 </div>
               </div>
             </div>

             <?php $sisa--;} } ?>

             <?php for ($k = 5-$sisa; $k <= 5; $k++) {
              $show = ($k == 0) ? "" : "display:none;";
              ?>

              <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
                <div class="col-lg-12">
                  <div class="card float-e-margins">
                    <div class="card-title">
                      <h5>DOKUMEN #<?php echo $k ?></h5>
                      <div class="card-tools">

                       <?php if($k > 0){ ?>
                       <a class="tutup" data-no="<?php echo $k ?>">
                        <!-- style="color:red; font-size: 30px;" -->
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
                          $selected = ($val['name'] == $curval) ? "selected" : "";
                          ?>
                          <option <?php echo $selected ?> value="<?php echo $val['name'] ?>"><?php echo $val['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <?php $curval = set_value("doc_attachment_inp[$k]"); ?>
                      <label class="col-sm-1 control-label"><?php echo lang('attachment') ?></label>
                      <div class="col-sm-6">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                              <i class="fa fa-cloud-upload"></i>  Upload
                            </button>
                            <button type="button" data-url="<?php echo site_url('log/download_attachment/'.$mod.'/'.$curval) ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
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

       </div>
     </div>
   </div>
 </div>



 <script type="text/javascript">


  $(document).ready(function(){

    $(".tambah_dok").click(function(){

      var total = parseInt($("div.lampiran:visible").length);
      var find = parseInt($("div.lampiran:hidden").attr("data-no"));

      if(total == 4){
        $(".tambah_dok").hide();
      }
      $("div.lampiran[data-no='"+find+"']").show();
      return false;

    });

    $(".tutup").click(function(){

      $(".tambah_dok").show();
      var no = parseInt($(this).attr("data-no"));
      $("div.lampiran[data-no='"+no+"']").hide();

      return false;

    });

  });
</script>
