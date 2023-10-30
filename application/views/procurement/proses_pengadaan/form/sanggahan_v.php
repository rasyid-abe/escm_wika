<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Sanggahan</h4>
      </div>

      <div class="card-content">
        <div class="card-body" id="sanggahan_form">          
          
          <div class="row form-group">
            <label class="col-sm-2 control-label">Judul Sanggahan</label>
            <div class="col-sm-6">
              <div class="input-group"> 
                <span class="input-group-btn">
                  <button type="button" data-id="sanggahan_inp" data-url="<?php echo site_url(PROCUREMENT_SANGGAHAN_PICKER_PATH) ?>" class="btn btn-info picker">...</button> 
                </span>
                <input type="hidden" class="form-control" id="sanggahan_inp" name="sanggahan_inp" value="">

                <input readonly type="text" class="form-control" id="sanggahan_label" value="">
              </div>
            </div>
          </div>

          <div class="row form-group">
            <label class="col-sm-2 control-label">Subtansi Sanggahan</label>
            <div class="col-sm-6">
              <p class="form-control-static" id="subtansi_sanggahan"></p>
            </div>
          </div>

          <div class="row form-group" >
            <label class="col-sm-2 control-label">Vendor</label>
            <div class="col-sm-6">
              <p class="form-control-static" id="vendor_sanggahan"></p>
            </div>
          </div>

          <div class="row form-group">
            <label class="col-sm-2 control-label">No Jawaban Sanggahan</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="no_jawaban" name="no_jawaban_sanggahan_inp" value="">
            </div>
          </div>

          <div class="row form-group">
            <label class="col-sm-2 control-label">Judul Jawaban Sanggahan</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="sanggahan_label" name="judul_jawaban_sanggahan_inp" value="">
            </div>
          </div>

          <div class="row form-group">
            <label class="col-sm-2 control-label">Jawaban Sanggahan</label>
            <div class="col-sm-8">
              <textarea name="jawaban_sanggahan_inp" maxlength="1000" class="form-control"></textarea>
            </div>
          </div>

          <div class="row form-group">
            <label class="col-sm-2 control-label">Lampiran Sanggahan</label>
            <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" data-id="attachment_inp_sanggahan" data-folder="procurement/sanggahan" data-preview="preview_file_sanggahan" class="btn btn-info upload">
                      <i class="fa fa-cloud-upload"></i> Upload
                    </button> 
                    <button type="button" data-url="" class="btn btn-info preview_upload" id="preview_file_sanggahan">
                      <i class="fa fa-share"></i> Preview
                    </button> 
                  </span> 
                  <input readonly type="text" class="form-control" id="attachment_inp_sanggahan" name="attachment_sanggahan_inp" value="">
                  <span class="input-group-btn">
                    <button type="button" data-id="attachment_inp_sanggahan" data-folder="procurement/sanggahan" data-preview="preview_file_sanggahan" class="btn btn-danger removefile">
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

          <div class="row form-group">
          <label class="col-sm-2 control-label">Respon</label>
            <div class="col-sm-3">
              <select name="status_sanggahan_inp" id="status_sanggahan_inp" class="form-control">
                <option value="Tidak Terbukti">Tidak Terbukti</option>
                <option value="Terbukti">Terbukti</option>
              </select>
            </div>
          </div>

          <div class="row form-group border-top pt-3">
            <label class="col-sm-2 control-label"> </label>
            <div class="col-sm-10">
              <a href="#" class="btn btn-info" id="sanggahan_btn">Simpan</a>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  $(function () {

    $("#sanggahan_btn").on("click",function(){

      var data = "";

      var sanggahan_inp = $("#sanggahan_inp").val();
      var jawaban_inp = $("#sanggahan_label").val();

      if(sanggahan_inp == ""){
        alert("Sanggahan harus diisi");
      } else if(jawaban_inp == ""){
        alert("Judul jawaban harus diisi");
      } else {

      $("#sanggahan_form input,#sanggahan_form textarea").each(function(){
        data += $(this).attr('name')+"="+$(this).val()+"&";
      });

      data += "status_sanggahan_inp="+$("#status_sanggahan_inp option:selected").val();

      $.ajax({
        url:"index.php/procurement/save_sanggahan",
        data:data,
        type:"post",
        success:function(x){
          alert("Jawaban sanggahan berhasil dikirim");
          $("#sanggahan_table").bootstrapTable('refresh');
          $("#sanggahan_form input,#sanggahan_form textarea").each(function(){
        $(this).val("");
      });
          $("#sanggahan_form .form-control-static").text("");
        }
      });

    }

      return false;
    }); 

    function check_sanggahan(){
      var id = $("#sanggahan_inp").val();
      var url = "<?php echo site_url('Procurement/data_sanggahan') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#sanggahan_label").val(mydata.pcl_title);
          $("#vendor_sanggahan").text(mydata.vendor_name);
          $("#subtansi_sanggahan").text(mydata.pcl_reason);
        }
      });
    }

    $(document.body).on("change","#sanggahan_inp",function(){

      check_sanggahan();

    });

  }); 

</script>