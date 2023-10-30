<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_pph");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>Form</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="card-content">

            <?php $curval = set_value("project_name_inp"); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Nama *</label>
            <div class="col-sm-8">
              <input type="text" class="form-control pph_name" name="pph_name_inp" value="<?php echo $curval ?>" required>
              <small id="pph_name_error"></small>
            </div>
          </div>

          <?php $curval = set_value("description_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nilai PPh *</label>
            <div class="col-sm-8">
              <input type="text" class="form-control pph_value" name="pph_value_inp" value="<?php echo $curval ?>" required>
              <small id="pph_value_error"></small>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('administration/master_data/pph',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('.pph_name').blur(function(){
      var pph_name = $('.pph_name').val()
      var url = "<?php echo site_url('administration/master_data/pph/check/')?>/"+pph_name;

      if (pph_name != '') {

        $.ajax({ 
           url : url,
           dataType:"json",
           success:function(result){
              if (result >= 1) {
                 $('#error_msg_name').remove();
                 $('.pph_name').val('');
                 $('#pph_name_error').append("<span style='color:red' id='error_msg_name'>Nama pph sudah ada</span>");
                  $('#error_msg_name').fadeOut(5000,function(){
                    this.remove();
                  })
                 
              }
           }
           
         });

         // $('.pph_name').bind('change',function(){
         //    $('#error_msg_name').remove();
         //  })

      }
           
    })

    $('.pph_value').blur(function(){
      var pph_value = $('.pph_value').val()
      if (pph_value != '') {
         var pph_val = parseFloat($(".pph_value").val().replace(/,/, '.')).toFixed(2)
         $('.pph_value').val(pph_val);

        var url = "<?php echo site_url('administration/master_data/pph/check/')?>/"+pph_val;

         $.ajax({ 
             url : url,
             dataType:"json",
             success:function(result){
                if (result >= 1) {
                   $('#error_msg_val').remove()
                   $('.pph_value').val('');
                   $('#pph_value_error').append("<span style='color:red' id='error_msg_val'>Nilai pph sudah ada</span>");
                   $('#error_msg_val').fadeOut(5000,function(){
                      this.remove();
                    })
                }
             }
             
           });

            // $('.pph_value').bind('change',function(){
            //   var pph_val = parseFloat($(".pph_value").val().replace(/,/, '.')).toFixed(2)
            //   $('.pph_value').val().replaceWith(pph_val);
            //   $('#error_msg_val').remove();
            // })  

      }
      
    })


  })
</script>
