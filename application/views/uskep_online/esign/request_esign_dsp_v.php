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
                      <input type="text" class="form-control" required id="otp" name="otp" disabled>
                      <br>
                      <a class="btn btn-danger" target="_blank" href="<?php echo base_url($dokumen) ?>">Lihat Dokumen</a>
                      <a class="btn btn-info" id="btnOtp" onclick="fSendRequest()">Request OTP</a>
                      <a class="btn btn-info" id="btnSign" style="display: none;" onclick="fSendProcess()">Sign Document</a>

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
        $(`#myLoader`).modal('show');
        var id = '<?= $id ?>';
        var privy = '<?= $privy ?>';
        var url = '<?= base_url() ?>' + 'index.php/privyDSP/sign_in_doc_request/'+id+'/'+privy;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                var message = response.message;

                if (response.status == "SUCCESS") {
                    toastr.success(message, '<i class="ft ft-check-square"></i> Success!');
                    $("#otp").removeAttr("disabled");
                    $("#btnOtp").hide();
                    $("#btnSign").show();
                } else {
                    toastr.error(message, '<i class="ft ft-alert-triangle"></i> Error!');
                }
                $(`#myLoader`).modal('hide');
            }
        });
    }


    function fSendProcess()
    {
        $(`#myLoader`).modal('toggle');

        var id = '<?= $id ?>';
        var otp = $(`#otp`).val();
        var privy = '<?= $privy ?>';

        var url = '<?= base_url() ?>' + 'index.php/PrivyDSP/sign_in_doc_process/'+id+'/'+otp+'/'+privy;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function (response) {
                $(`#myLoader`).modal('toggle');
                if(response.status == "SUCCESS"){
                    var message = response.message;
                    DevExpress.ui.notify({
                        message,
                        position: {
                        my: 'center top',
                        at: 'center top',
                        },
                    }, 'success', 3000);

                    window.open("<?= base_url() ?>"+"index.php/contract/manual");

                    window.location();

                } else {
                    DevExpress.ui.notify(response.message, "error", 1600);
                }
            }
        });
    }

</script>
