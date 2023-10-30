<!-- Modal -->
<div class="modal" id="upload" tabindex="-3" role="dialog" aria-labelledby="uploadLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="uploadLabel">File Uploader</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="uploadForm" enctype="multipart/form-data" action="<?php echo site_url('log/doupload_contract') ?>">
          <input type="file" name="file" id="file-uploader" accept=".pdf" >
          <small id="error"></small>
          <input type="hidden" name="upload_id" id="upload_id">
          <input type="hidden" name="upload_preview" id="upload_preview">
          <input type="hidden" name="uploader" id="uploader">
          <input type="hidden" name="upload_activity" id="" value="doc_contract">
          <br>
          <center>
            <input type="submit" name="submit" value="Kirim" class="btn btn-info" id="submit_file">
          </center>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- loading  -->
<!-- <div class="modal" id="loading_upload" data-keyboard="false" role="dialog" style="padding-top:3%; overflow-y:visible;">
    <div class="modal-dialog modal-m" style="width: 40%;" role="document">
    <div class="modal-content">
      <div class="modal-header"><h3 style="margin:0;">Loading</h3></div>
      <div class="modal-body">
        <div class="progress">
            <div class="bar progress-bar progress-bar-success" role="progressbar"> <div class="percent">0%</div> </div >
        </div>
        <center><button id="stop_upload" class="btn btn-danger">Cancel</button></center>

      </div>
      </div>
    </div>
  </div>
</div> -->

<script type="text/javascript" src="assets/js/jquery.ajaxfileupload.js"></script>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>

<script type="text/javascript">
/*   $(document).ready(function(){

    $('#upload').on('hidden.bs.modal', function () {
      $('#file-uploader').val('');
      $('#error_msg').remove();
    })

    $('#file-uploader').bind('change', function(e) {
        $('#submit_file').attr('disabled',true);
        $('#error_msg').remove();
        var ext = $(this).val().split('.').pop().toLowerCase();
        var files = e.target.files;
         console.log(files)
        // alert(files[0].size)
        if (files[0].size > 5242880) {
          $(this).val('');
          $('#error').append("<span style='color:red' id='error_msg'>file tidak boleh lebih dari 5MB</span>");
        }else if($.inArray(ext, ['pdf']) == -1) {
            $(this).val('');
            $('#error').append("<span style='color:red' id='error_msg'>format file tidak sesuai</span>");
        } else {
            $('#submit_file').attr('disabled',false);
        }

        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        var form = $('#uploadForm').ajaxForm({
          dataType:  'json',
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function(xhr) {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                $('#stop_upload').click(function(){
                  xhr.abort();
                  $('#file-uploader').val("");
                  setTimeout(function () {
                    $('#loading_upload').modal('hide');
                  }, 1000);
                  $('#submit_file').attr('disabled',true);
                })
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#loading_upload').modal("show");
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                if (percentComplete == 100) {
                  setTimeout(function () {
                    $('#loading_upload').modal('hide');
                  }, 1000);
                }
            },
            success: function(responseJSON, statusText, xhr) {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);

                if (responseJSON.status == "error") {

                    setTimeout(function() {
                      toastr.options = {
                        closeButton: true,
                        progressBar: false,
                        showEasing: 'swing',
                        hideEasing: 'linear',
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut',
                        newestOnTop: false,
                        timeOut: 20000,
                        preventDuplicates: true,
                      };

                      toastr.error(responseJSON.message, "Error");

                    }, 1300);

                    var $fileInput = $("<input />")
                    .attr({
                      type: "file",
                      name: $('#file-uploader').attr("name"),
                      id: $('#file-uploader').attr("id"),
                      accept: $('#file-uploader').attr("accept"),
                    });

                  $("span." + $('#file-uploader').attr("id")).replaceWith($fileInput);
                  $('#file-uploader').val('');

                    return;

                  } else {

                    console.log(responseJSON)
                    var $span = $("span." + $('#file-uploader').attr("id")).text(responseJSON.filename + " ");
                    var url = responseJSON.url;
                    var id = $("#upload_id").val();
                    var preview = $("#upload_preview").val();
                    var filename = responseJSON.message;
                    $("#filename").val(filename);
                    $("#matgis_file").attr("src", "<?php echo base_url()?>uploads/contract/"+filename);
                    $("#"+id).val(filename).trigger('input').trigger('change');
                    $("#"+preview).attr("data-url",url);
                    var dialogshow = localStorage.getItem('dialogshow');

                    if(dialogshow == true || dialogshow != ""){
                      setTimeout(function(){
                        localStorage.setItem('dialogshow', "");
                      },1000);
                    }

                  var $fileInput = $("<input />")
                  .attr({
                    type: "file",
                    name: $('#file-uploader').attr("name"),
                    id: $('#file-uploader').attr("id"),
                    accept: $('#file-uploader').attr("accept"),
                  });

                  $span.replaceWith($fileInput);
                 setTimeout(function () {
                  $("#upload").modal("hide");
                  }, 1000);
                  $('#submit_file').attr('disabled',true);

                  }

            }
            ,
            complete: function(xhr) {
              $(document.body).removeClass("modal-open");
              $('.pace-done').css("padding-right: 0px !important");
              $(".modal-backdrop").remove();
            }
        });
    });
}); */

</script>
