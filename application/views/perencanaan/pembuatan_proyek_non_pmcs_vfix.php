<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_pembuatan_proyek_non_pmcs");?>"  class="form-horizontal ajaxform">

    <div class="row">
      <div class="col-12">
        <div class="card">

          <div class="card-header border-bottom pb-2">
            <h4 class="card-title">HEADLINE</h4>
          </div>

          <div class="card-content">
            <div class="card-body">
              <?php $curval = $userdata['complete_name']; ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label">User *</label>
                  <div class="col-sm-10">
                  <input type="text" readonly class="form-control" required name="user_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <input type="hidden" name="pos_name" value="<?php echo $userdata['pos_name'] ?>">
              <input type="hidden" name="pos_id" value="<?php echo $userdata['pos_id'] ?>">
              <input type="hidden" name="district_id" value="<?php echo $userdata['district_id'] ?>">
              <input type="hidden" name="district_name" value="<?php echo $userdata['district_name'] ?>">
              <input type="hidden" name="dept_id" value="<?php echo $userdata['dept_id'] ?>">
              <?php $curval = $userdata['dept_name']; ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Divisi/Departemen *</label>
                <div class="col-sm-10">
                  <input type="text" readonly class="form-control" required name="birounit_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <!-- haqim -->
              <div class="row form-group">
                <label class="col-sm-2 control-label">Jenis Rencana*</label>
                <div class="col-sm-10">
                  <input type="radio" name="jenis_rencana" value="rkp" class="jenis_rencana"> RKP
                  <input type="radio" name="jenis_rencana" value="rkap" class="jenis_rencana"> RKAP
                </div>
              </div>

              <div class="row form-group" id="nama_proyek_form">
                <?php $curval = set_value("nama_proyek"); ?>
                  <label class="col-sm-2 control-label">Nama Proyek *</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="nama_proyek" id="nama_proyek" value="" readonly>
                </div>
                <div class="col-sm-1">
                  <?php $curval = set_value("proyek_id"); ?>
                  <input readonly required type="hidden" class="form-control"  id="proyek_id" name="proyek_id" value="<?php echo $curval ?>">
                  <button type="button" data-id="proyek_id" data-url="<?php echo site_url('administration/picker_nama_proyek') ?>" class="btn btn-info btn-sm picker">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <!-- end -->

              <?php $curval = set_value("nama_rencana_pekerjaan_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Nama Program *</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" required maxlength="120" name="nama_rencana_pekerjaan_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = set_value("deskripsi_rencana_pekerjaan_inp"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Deskripsi Rencana Pekerjaan *</label>
                <div class="col-sm-10">
                  <textarea class="form-control" required maxlength="1000" name="deskripsi_rencana_pekerjaan_inp"><?php echo $curval ?></textarea>
                </div>
              </div>

              <div class="row form-group">
                <label class="col-sm-2 control-label">Mata Anggaran *</label>
                <div class="col-sm-3">

                  <?php $curval = set_value("mata_anggaran_code_inp"); ?>
                  <input readonly type="text" required class="form-control" id="mata_anggaran_code_inp" name="mata_anggaran_code_inp" value="<?php echo $curval ?>">

                </div>
                <div class="col-sm-6">

                <?php $curval = set_value("mata_anggaran_label_inp"); ?>
                <input readonly type="text" required class="form-control" id="mata_anggaran_label_inp" name="mata_anggaran_label_inp" value="<?php echo $curval ?>">

              </div>
              <div class="col-sm-1">

                <?php $curval = set_value("mata_anggaran_inp"); ?>
                <input readonly required type="hidden" class="form-control"  id="mata_anggaran_inp" name="mata_anggaran_inp" value="<?php echo $curval ?>">
                <button type="button" data-id="mata_anggaran_inp" data-url="<?php echo site_url('administration/picker_anggaran') ?>" class="btn btn-info btn-sm picker">
                  <i class="fa fa-search"></i>
                </button>

              </div>
            </div>

            <?php //$curval = set_value("sub_mata_anggaran_code_inp"); ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label">Sub Mata Anggaran</label>
              <div class="col-sm-3">

                <input type="text" class="form-control" id="sub_mata_anggaran_code_inp" name="sub_mata_anggaran_code_inp" value="">

              </div>
              <div class="col-sm-6">
                <?php $curval = set_value("sub_mata_anggaran_label_inp"); ?>
                <input type="text" class="form-control" id="sub_mata_anggaran_label_inp" name="sub_mata_anggaran_label_inp" value="">

              </div>
            </div>

            <?php $curval = (!empty(set_value("mata_uang_inp"))) ? set_value("mata_uang_inp") : "IDR"; ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label">Mata Uang *</label>
              <div class="col-sm-3">
              <select required class="form-control select2" name="mata_uang_inp">
                <option value=""><?php echo lang('choose') ?></option>
                <?php foreach($default_currency as $key => $val){
                  $selected = ($key == $curval) ? "selected" : "";
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <?php $curval = moneytoint(set_value("pagu_anggaran_inp")); ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label">Nilai Anggaran *</label>
              <div class="col-sm-4">
                <input type="text" class="form-control money" maxlength="30" required name="pagu_anggaran_inp" value="<?php echo $curval ?>">
              </div>
            </div>


            <?php $curval = (set_value("rencana_pelaksanaan_kebutuhan_month_inp")) ? set_value("rencana_pelaksanaan_kebutuhan_month_inp") : date("m"); ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label">Rencana Pelaksanaan Pengadaan *</label>
              <div class="col-sm-3">

                <?php echo month_select_box('rencana_pelaksanaan_kebutuhan_month_inp',$curval) ?>

              </div>
              <div class="col-sm-2">
                <?php $curval = (set_value("rencana_pelaksanaan_kebutuhan_year_inp")) ? set_value("rencana_pelaksanaan_kebutuhan_year_inp") : date("Y"); ?>
                <select class="form-control" name="rencana_pelaksanaan_kebutuhan_year_inp" value="<?php echo $curval ?>">
                  <?php for ($i=date("Y"); $i <= date("Y")+5; $i++) {
                    $selected = ($val == $curval) ? "selected" : "";
                    ?>
                    <option <?php echo $selected ?>><?php echo $i ?></option>
                    <?php } ?>
                  </select>
                </div>

              </div>

              <?php $curval = (set_value("rencana_kebutuhan_month_inp")) ? set_value("rencana_kebutuhan_month_inp") : date("m"); ?>
              <div class="row form-group">
                <label class="col-sm-2 control-label">Rencana Kebutuhan *</label>
                <div class="col-sm-3">

                  <?php echo month_select_box('rencana_kebutuhan_month_inp',$curval) ?>

                </div>
                <div class="col-sm-2">
                  <?php $curval = (set_value("rencana_kebutuhan_year_inp")) ? set_value("rencana_kebutuhan_year_inp") : date("Y"); ?>
                  <select class="form-control" name="rencana_kebutuhan_year_inp">
                  <?php for ($i=date("Y"); $i <= date("Y")+5; $i++) {
                    $selected = ($i == $curval) ? "selected" : "";
                    ?>
                    <option <?php echo $selected ?>><?php echo $i ?></option>
                    <?php } ?>
                  </select>
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
          <div class="card-content">
            <div class="card-body text-center">
                <a class="btn btn-info btn-sm tambah_dok">Tambah Lampiran</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="lampiran_container">

      <?php for ($k = 0; $k <= 4; $k++) {
        $show = ($k == 0) ? "" : "display:none;";
      ?>

      <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
        <div class="col-12">
          <div class="card">

            <div class="card-header border-bottom pb-2">
                <h4 class="card-title float-left">LAMPIRAN DOKUMEN #<?php echo $k ?></h4>
                <?php if($k > 0){ ?>
                <a class="tutup float-right" data-no="<?php echo $k ?>">
                  <i class="fa fa-times"></i>
                </a>
                <?php } ?>
            </div>

            <div class="card-content">
              <div class="card-body">

                  <?php $curval = set_value("doc_category_inp[$k]"); ?>
                  <div class="row form-group">
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
                          <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-info btn-sm upload">
                            <i class="fa fa-cloud-upload"></i> Upload
                          </button>
                          <button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/$dir/$curval" ?>" class="btn btn-info btn-sm preview_upload" id="preview_file_<?php echo $k ?>">
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
                  <div class="row form-group">
                    <label class="col-sm-1 control-label"><?php echo lang('description') ?></label>
                    <div class="col-sm-11">
                      <textarea class="form-control" maxlength="1000" placeholder="<?php echo lang('description') ?>" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php } ?>

    <?php
    $i = 0;
    include(VIEWPATH."/comment_workflow_v.php") ?>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <?php echo buttonsubmit('perencanaan_pengadaan/pr_proyek_non_pmcs',lang('back'),lang('save')) ?>
            </div>
          </div>
        </div>
      </div>
    </div>

  </form>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    $('#nama_proyek_form').hide();
    $('.jenis_rencana').click(function(){
      if ($(this).val() == 'rkp') {
           $('#nama_proyek_form').show();
           $('[name=nama_proyek]').attr('required','required');
      }else{
        $('#nama_proyek_form').hide();
        $('[name=nama_proyek]').removeAttr('required');

      }
    })

    $(document.body).on("change","#proyek_id",function(){
        let kdpyk = $('input[name=kdpyk]:checked')
        $("[name=nama_proyek]").val(kdpyk.val());
        $("#proyek_id").val(kdpyk.data('kode'));

    });

    $(document.body).on("change","#mata_anggaran_inp",function(){

      var id = $(this).val();
      var url = "<?php echo site_url('administration/data_anggaran') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#mata_anggaran_code_inp").val(mydata.kode_perkiraan);
          $("#mata_anggaran_label_inp").val(mydata.nama_perkiraan);
          // $("#sub_mata_anggaran_code_inp").val(mydata.subcode_cc);
          // $("#sub_mata_anggaran_label_inp").val(mydata.subname_cc);
        }
      });

    });

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
