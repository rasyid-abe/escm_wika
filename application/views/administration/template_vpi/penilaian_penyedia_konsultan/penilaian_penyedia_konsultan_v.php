<div class="wrapper wrapper-content animated fadeInRight">
  <?php $msg_status = $this->session->flashdata('status_submit_vpi');
        $msg_status = (empty($msg_status)) ? "" : $msg_status;
        if(!empty($msg_status)){ ?>
        <div class="alert <?php echo $msg_status == 'success' ? 'alert-info' : 'alert-danger' ?>" role="alert">
          <?php echo $this->session->flashdata('msg_submit_vpi');  ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
     <?php } ?>
 <form  method="post" id="template_form"  action="<?php echo site_url($controller_name."/template_vpi/penilaian_penyedia_konsultan");?>">
   <div class="card">
     <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
              <div class="table-responsive">
                <a class="pull-left btn btn-info edit-btn" style="margin-bottom: 10px"><i class="ft-edit mr-1"></i>Edit</a>

                <input type="hidden" name="mode" value="">

                <table class="table m-0"  style="text-align: center;">
                  <thead>
                    <tr>
                      <th style="text-align: center;">No</th>
                      <th style="text-align: center;">Parameter</th>
                      <th style="text-align: center;width: 20em">Key Performance Indicator</th>
                      <th style="text-align: center;width: 20em">Target</th>
                      <th style="text-align: center;width: 20em">Weight (%)</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td>1</td>
                      <td rowspan ="3" style="vertical-align: middle;">Performance</td>
                      <td>
                          Ketepatan Progress (Waktu)
                      </td>
                      <td>
                        <!-- <a class="input_required target target_ketepatan_progress"> -->
                          <span class="edit-hide">
                            <?php echo $data_bobot['target_ketepatan_progress'] ?>
                          </span>
                        <!-- </a> -->
                          <input type="text" class="form-control edit-show" name="target_ketepatan_progress" value="<?php echo $data_bobot['target_ketepatan_progress'] ?>" required>
                      </td>
                      <td>
                       <!-- <a class="input_required bobot bobot_ketepatan_progress"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['bobot_ketepatan_progress'] ?>
                            </span>
                          <!-- </a> -->
                          <input type="text" class="form-control bobot edit-show" name="bobot_ketepatan_progress" value="<?php echo $data_bobot['bobot_ketepatan_progress'] ?>" required>
                     </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>
                        <a href="<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/mutu') ?>">
                         Mutu Pekerjaan (Sesuai KAK)
                        </a>
                      </td>
                      <td>
                        <!-- <a class="input_required target_mutu_pekerjaan target"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['target_mutu_pekerjaan'] ?>
                            </span>
                          <!-- </a> -->
                          <input type="text" class="form-control edit-show" name="target_mutu_pekerjaan" value="<?php echo $data_bobot['target_mutu_pekerjaan'] ?>" required>
                      </td>
                      <td>
                        <!-- <a class="input_required bobot_mutu_pekerjaan bobot"> -->
                        <span class="edit-hide">
                        <?php echo $data_bobot['bobot_mutu_pekerjaan']?>
                        </span>
                        <input type="text" class="form-control bobot edit-show" name="bobot_mutu_pekerjaan" value="<?php echo $data_bobot['bobot_mutu_pekerjaan'] ?>" required>
                        <!-- </a> -->

                      </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>
                        <a href="<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/mutu') ?>">
                          Mutu Personal (Sesuai KAK)
                        </a>
                      </td>
                      <td>
                        <!-- <a class="input_required target_mutu_personal target"> -->
                        <span class="edit-hide">
                        <?php echo $data_bobot['target_mutu_personal']?>
                        </span>
                        <input type="text" class="form-control edit-show" name="target_mutu_personal" value="<?php echo $data_bobot['target_mutu_personal'] ?>" required>
                        <!-- </a> -->
                      </td>
                      <td>
                        <!-- <a class="input_required bobot_mutu_personal bobot"> -->
                        <span class="edit-hide">
                        <?php echo $data_bobot['bobot_mutu_personal'] ?>
                        </span>
                        <input type="text" class="form-control bobot edit-show" name="bobot_mutu_personal" value="<?php echo $data_bobot['bobot_mutu_personal'] ?>" required>
                        <!-- </a> -->
                      </td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Service</td>
                      <td>
                        <a href="<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/pelayanan') ?>">
                          Pelayanan
                        </a>
                      </td>
                      <td>
                        <!-- <a class="input_required target_pelayanan target"> -->
                          <span class="edit-hide">
                          <?php echo $data_bobot['target_pelayanan']; ?>
                          </span>
                          <input type="text" class="form-control edit-show" name="target_pelayanan" value="<?php echo $data_bobot['target_pelayanan'] ?>" required>
                        <!-- </a> -->
                      </td>
                      <td>
                        <!-- <a class="input_required bobot_pelayanan bobot"> -->
                          <span class="edit-hide">
                          <?php echo $data_bobot['bobot_pelayanan'] ?>
                          </span>
                          <input type="text" class="form-control bobot edit-show" name="bobot_pelayanan" value="<?php echo $data_bobot['bobot_pelayanan'] ?>" required>
                        <!-- </a> -->
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3">Total</td>
                      <td class="target_total">
                        <?php echo $total_target ?>
                      </td>
                      <td class="bobot_total" style="<?php echo $total_bobot < 100 ? "background-color:#d9534f;color:white" : ""; ?>">
                        <?php echo $total_bobot ?>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>
          </div>
        </div>

        <div class="row edit-show pt-10">
          <div class="col-md-12">
            <div style="margin-top: 20px;">
              <div class="row">
                <div class="col-md-12">
                  <div>
                    <button class="btn btn-danger btn-lg cancel-btn">Batal</button>
                    <button type="submit" class="btn btn-primary btn-lg pull-right"><?php echo lang('save') ?></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    // if (parseFloat($('.bobot_total').text()) <= 0) {
    //   setTimeout(function(){ $('.edit-btn').trigger('click') }, 300);
    // }else{

      $('.edit-show').css('display', 'none');

    // }

    $('input').css('text-align', 'center');


     var prev_total_bobot;
     var prev_total_target;
     var prev_target_ketepatan_progress;
     var prev_bobot_ketepatan_progress;
     var prev_target_mutu_pekerjaan;
     var prev_bobot_mutu_pekerjaan;
     var prev_target_mutu_personal;
     var prev_bobot_mutu_personal;
     var prev_target_pelayanan;
     var prev_bobot_pelayanan;


    $('.edit-btn').click(function(event) {
      $('.edit-show').css('display', 'block');
      $('.edit-btn').css('display', 'none');
      $('.edit-hide').css('display', 'none');
      $('[name=mode]').val('insert');

      prev_total_bobot = parseFloat($('.bobot_total').text());
      prev_total_target = parseFloat($('.target_total').text());
      prev_target_ketepatan_progress = parseFloat($('[name=target_ketepatan_progress]').val());
      prev_bobot_ketepatan_progress = parseFloat($('[name=bobot_ketepatan_progress]').val());
      prev_target_mutu_pekerjaan = parseFloat($('[name=target_mutu_pekerjaan]').val());
      prev_bobot_mutu_pekerjaan = parseFloat($('[name=bobot_mutu_pekerjaan]').val());
      prev_target_mutu_personal = parseFloat($('[name=target_mutu_personal]').val());
      prev_bobot_mutu_personal = parseFloat($('[name=bobot_mutu_personal]').val());
      prev_target_pelayanan = parseFloat($('[name=target_pelayanan]').val());
      prev_bobot_pelayanan = parseFloat($('[name=bobot_pelayanan]').val());

      // alert($('[name=mode]').val())
    });

    $('.cancel-btn').click(function(event) {
      event.preventDefault()
     $('[name=mode]').val('');
      if (prev_total_bobot != 100) {
          alert("Total bobot harus 100%")
          $(".bobot_total").css({
            'background-color': '#d9534f',
            'color': 'white'
          });
        }else{

          $('.bobot_total').css({
            'background-color': '',
            'color': 'black'
          });

          $('.edit-show').css('display', 'none');
          $('.edit-btn').css('display', 'block');
          $('.edit-hide').css('display', 'block');

          $('.bobot_total').text(prev_total_bobot)
          $('.target_total').text(prev_total_target)
          $('[name=target_ketepatan_progress]').val(prev_target_ketepatan_progress);
          $('[name=bobot_ketepatan_progress]').val(prev_bobot_ketepatan_progress);
          $('[name=target_mutu_pekerjaan]').val(prev_target_mutu_pekerjaan);
          $('[name=bobot_mutu_pekerjaan]').val(prev_bobot_mutu_pekerjaan);
          $('[name=target_mutu_personal]').val(prev_target_mutu_personal);
          $('[name=bobot_mutu_personal]').val(prev_bobot_mutu_personal);
          $('[name=target_pelayanan]').val(prev_target_pelayanan);
          $('[name=bobot_pelayanan]').val(prev_bobot_pelayanan);


        }
        // alert($('[name=mode]').val())
    });

    function cari_total_bobot(){
        var total_bobot = 0;

        $('.bobot').each(function(index, el) {
          if ($(this).val() == "") {
            $(this).val(0)
          }
          total_bobot += parseFloat($(this).val().replace(',','.').replace(' ',''))
        });

        return total_bobot;
    }

    $('#template_form').submit(function(e) {

      var total_bobot = cari_total_bobot();

        if (total_bobot != 100) {
          e.preventDefault()
          alert("Total bobot harus 100%")
          $(".bobot_total").css({
            'background-color': '#d9534f',
            'color': 'white'
          });
        }else{
          $('.bobot_total').css({
            'background-color': '',
            'color': 'black'
          });
        }

        $('.bobot_total').text(total_bobot)

    });

    $('.form-control').autoNumeric({
      vMin : 0,
      aSep: '.',
      aDec: ',',
      aSign: '',
      mDec: '2'
    });

  });
</script>

<!-- Tidak digunakan -->
<script type="text/javascript">
$(document).ready(function() {

  var $table = $('#aspek_penilaian_pelayanan'),
  $remove = $('#remove'),
  $activate = $('#activate'),
  selections = [];
  var newVal = "";
  var current_val;
  var total;

  var url= "<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/bobot_dan_target/submit?') ?>";
  var current_target_ketepatan_waktu = $('.target_ketepatan_waktu').text()
  $('.target_ketepatan_waktu').editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}

          },
          success: function(response, newValue) {

                total = total_target(current_target_ketepatan_waktu,newValue)
                $.ajax({
                  url: url+"key=target_ketepatan_waktu&data="+newValue+"&total="+total+"&type=konsultan",
                  type:"get"
                });
                current_target_ketepatan_waktu = parseFloat(newValue)
            }
        }
  );

  var current_val_bobot_ketepatan_waktu = $('.bobot_ketepatan_waktu').text()
  $('.bobot_ketepatan_waktu').editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_val_bobot_ketepatan_waktu,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }

          },
          success: function(response, newValue) {
             if (check_total_bobot(current_val_bobot_ketepatan_waktu,newValue) == "less than"){
                alert('Total Bobot masih kurang dari 100');
              }
              total = total_bobot(current_val_bobot_ketepatan_waktu,newValue)
              $.ajax({
                  url: url+"key=bobot_ketepatan_waktu&data="+newValue+"&total="+total+"&type=konsultan",
                  type:"get"
                });
              current_val_bobot_ketepatan_waktu = newValue

          }
        }
  );

  var current_val_target_mutu_pekerjaan = $('.target_mutu_pekerjaan').text()
  $('.target_mutu_pekerjaan').editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {
                    // return {newValue: response.newValue};
              total = total_target(current_val_target_mutu_pekerjaan,newValue)
              $.ajax({
                  url: url+"key=target_mutu_pekerjaan&data="+newValue+"&total="+total+"&type=konsultan",
                  type:"get"
                });
                    current_val_target_mutu_pekerjaan = newValue
                }
        }
  );

  var current_val_bobot_mutu_pekerjaan = $('.bobot_mutu_pekerjaan').text()
  $('.bobot_mutu_pekerjaan').editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_val_bobot_mutu_pekerjaan,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
                    // return {newValue: response.newValue};
                    if (check_total_bobot(current_val_bobot_mutu_pekerjaan,newValue) == "less than"){
                      alert('Total Bobot masih kurang dari 100');
                    }
                total = total_bobot(current_val_bobot_mutu_pekerjaan,newValue)
                $.ajax({
                    url: url+"key=bobot_mutu_pekerjaan&data="+newValue+"&total="+total+"&type=konsultan",
                    type:"get"
                  });
                      current_val_bobot_mutu_pekerjaan = newValue
                }
        }
  );

  var current_val_target_mutu_personal = $('.target_mutu_personal').text()
  $('.target_mutu_personal').editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {

              total = total_target(current_val_target_mutu_personal,newValue)
              $.ajax({
                  url: url+"key=target_mutu_personal&data="+newValue+"&total="+total+"&type=konsultan",
                  type:"get"
                });
                    current_val_target_mutu_personal = newValue
                }
        }
  );

  var current_val_bobot_mutu_personal = $('.bobot_mutu_personal').text()
  $('.bobot_mutu_personal').editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_val_bobot_mutu_personal,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
                    // return {newValue: response.newValue};
              if (check_total_bobot(current_val_bobot_mutu_personal,newValue) == "less than"){
                alert('Total Bobot masih kurang dari 100');
              }
              total = total_bobot(current_val_bobot_mutu_personal,newValue)
                $.ajax({
                    url: url+"key=bobot_mutu_personal&data="+newValue+"&total="+total+"&type=konsultan",
                    type:"get"
                  });
                    current_val_bobot_mutu_personal = newValue
                }
        }
  );

  var current_val_target_pelayanan = $('.target_pelayanan').text()
  $('.target_pelayanan').editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {
                    // return {newValue: response.newValue};
             total = total_target(current_val_target_pelayanan,newValue)
              $.ajax({
                  url: url+"key=target_pelayanan&data="+newValue+"&total="+total+"&type=konsultan",
                  type:"get"
                });
                    current_val_target_pelayanan = newValue
                }
        }
  );

  var current_val_bobot_pelayanan = $('.bobot_pelayanan').text()
  $('.bobot_pelayanan').editable({
          title: 'Masukkan Bobot',
          placement: 'number',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_val_bobot_pelayanan,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
                    // return {newValue: response.newValue};
                    if (check_total_bobot(current_val_bobot_pelayanan,newValue) == "less than"){
                      alert('Total Bobot masih kurang dari 100');
                    }
                  total = total_bobot(current_val_bobot_pelayanan,newValue)
                  $.ajax({
                    url: url+"key=bobot_pelayanan&data="+newValue+"&total="+total+"&type=konsultan",
                    type:"get"
                    });
                    current_val_bobot_pelayanan = newValue
                }
        }
  );

$('.input_required').click(function(event) {
  $('.input-sm').autoNumeric({
      vMin : 0,
      aSep: '.',
      aDec: ',',
      aSign: '',
      mDec: '0'
    });

  $('.input-sm').keypress(function(e){
    if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
    {
        e.preventDefault();
    }
  });
});


  function check_total_bobot(current_val,newValue){
    var current_total = 0;
    $('.bobot').each(function(){
      current_total += parseFloat($(this).text().replace(',','.'))
  });
    console.log('current_total ', current_total);
    console.log('current_val ', current_val);
    console.log('newValue ', newValue);
    total = current_total
    total -= parseFloat(current_val.toString().replace(',','.'))
    total += parseFloat(newValue.replace(',','.'))
    console.log('total ', total);

    if (total > 100) {
      return "false";
    }else if(total < 100){
      $(".bobot_total").css({
        'background-color': '#d9534f',
        'color': 'white'
      });
      $('.bobot_total').text(total)
      return "less than";
    }else{
      $('.bobot_total').css({
        'background-color': '',
        'color': 'black'
      });
      $('.bobot_total').text(total)
    }
  }

  function total_bobot(current_val,newValue){
  var current_total = 0;
    $('.bobot').each(function(){
      current_total += parseFloat($(this).text().replace(',','.'))
  });
    total = current_total
    total -= parseFloat(current_val.toString().replace(',','.'))
    total += parseFloat(newValue.replace(',','.'))

      return total;

  }

  function total_target(current_val,newValue){
  var current_total = 0;
  $('.target').each(function(){
      current_total += parseFloat($(this).text().replace(',','.'))
  });
    total = current_total
    total -= parseFloat(current_val.toString().replace(',','.'))
    total += parseFloat(newValue.replace(',','.'))

      $('.target_total').text(total)
      return total;

  }

});

</script>
