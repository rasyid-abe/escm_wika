<div class="form-horizontal">
  <div class="row">
      <div class="col-12">
          <div class="card">
            
            <div class="card-header border-bottom pb-2">
               
            </div>

            <div class="card-content">
              <div class="card-body">
                  
                  <div class="row form-group">
                      <label class="col-sm-2 control-label text-right">KODE OTP *</label>
                      <div class="col-sm-10">
                      <input disabled type="text" class="form-control" required id="otp" name="otp" >
                      <br>
                      <a class="btn btn-info" id="btnOtp" onclick="fSendRequest()">Request OTP</a>
                      <a class="btn btn-info" id="btnSign" style="display: none;" onclick="fSendProcess()">Sign Document</a>
                      <a href="<?php echo base_url()."index.php/PrivyPenilaianUskep/save_doc/".$id; ?>" class="btn btn-info btn-sm" style="margin: 5px;font-size:11px;"><i class="ft ft-upload"></i> Get PDF E-sign</a>
                    </div>
                  </div>

                  
              </div>


            </div>

          </div>
      </div>
  </div>
</div>

<?php $this->load->view('devextreme'); ?>

<script>

    function fSendRequest () 
    {
        var id = '<?= $id ?>';
        var url = '<?= base_url() ?>' + 'index.php/PrivyPenilaianUskep/sign_in_doc_request/'+id;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function (response) {
                var message = response.message;

                if(response.status == "SUCCESS"){
                    DevExpress.ui.notify({
                        message,
                        position: {
                        my: 'center top',
                        at: 'center top',
                        },
                    }, 'success', 3000);

                    
                    $("#otp").removeAttr("disabled");
                    $("#btnOtp").hide();
                    $("#btnSign").show();
                } else {
                    
                    DevExpress.ui.notify({
                        message,
                        position: {
                        my: 'center top',
                        at: 'center top',
                        },
                    }, 'error', 3000);


                }
            }
        });
    }


    function fSendProcess() 
    {
        var id = '<?= $id ?>';
        var url = '<?= base_url() ?>' + 'index.php/PrivyPenilaianUskep/sign_in_doc_process/'+id;
        var otp = $("#otp").val();
        $.ajax({
            type: "GET",
            url: url + '/' +otp,
            dataType: "JSON",
            success: function (response) {
                if(response.status == "SUCCESS"){
                    var message = response.message;
                    DevExpress.ui.notify({
                        message,
                        position: {
                        my: 'center top',
                        at: 'center top',
                        },
                    }, 'success', 3000);

                    window.open("<?= base_url() ?>"+"index.php/procurement/pdf_penilaian/"+id);

                    window.location();

                } else {
                    DevExpress.ui.notify(response.message, "error", 1600);
                }
            }
        });
    }

</script>