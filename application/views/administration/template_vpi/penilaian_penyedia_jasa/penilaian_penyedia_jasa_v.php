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
  <form  method="post" id="template_form"  action="<?php echo site_url($controller_name."/template_vpi/penilaian_penyedia_jasa");?>">
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
                        <th style="text-align: center;width: 25em">Parameter</th>
                        <th style="text-align: center;width: 20em">Key Performance Indicator</th>
                        <th style="text-align: center;width: 20em">Target</th>
                        <th style="text-align: center;width: 20em">Weight (%)</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <td>1</td>
                        <td rowspan ="2" style="vertical-align: middle;">Performance</td>
                        <td>
                          Ketepatan Progress
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
                          <a href="<?php echo site_url('administration/template_vpi/penilaian_penyedia_jasa/hasil_mutu_pekerjaan') ?>">Hasil Mutu Pekerjaan</a>
                        </td>
                        <td>
                           <!-- <a class="input_required target target_hasil_mutu_pekerjaan"> -->
                            <span class="edit-hide">
                            <?php echo $data_bobot['target_hasil_mutu_pekerjaan'] ?>
                            </span>
                          <!-- </a> -->
                          <input type="text" name="target_hasil_mutu_pekerjaan" value="<?php echo $data_bobot['target_hasil_mutu_pekerjaan'] ?>" class="form-control edit-show" required>
                        </td>
                        <td>
                             <!-- <a class="input_required bobot bobot_hasil_mutu_pekerjaan"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['bobot_hasil_mutu_pekerjaan'] ?>
                            </span>
                            <input type="text" name="bobot_hasil_mutu_pekerjaan" value="<?php echo $data_bobot['bobot_hasil_mutu_pekerjaan'] ?>" class="form-control bobot edit-show" required>
                          <!-- </a> -->
                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td rowspan ="2" style="vertical-align: middle;">K3L / 5R</td>
                        <td>
                          <a href="<?php echo site_url('administration/template_vpi/penilaian_penyedia_jasa/k3l') ?>">
                            K3L
                          </a>
                        </td>
                        <td>
                          <!-- <a class="input_required target target_k3l"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['target_k3l'] ?>
                            </span>
                            <input type="text" name="target_k3l" value="<?php echo $data_bobot['target_k3l'] ?>" class="form-control edit-show" required>
                          <!-- </a> -->
                        </td>
                        <td>
                          <!-- <a class="input_required bobot bobot_k3l"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['bobot_k3l'] ?>
                            </span>
                            <input type="text" name="bobot_k3l" value="<?php echo $data_bobot['bobot_k3l'] ?>" class="bobot form-control edit-show" required>
                          <!-- </a> -->
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>
                          <a href="<?php echo site_url('administration/template_vpi/penilaian_penyedia_jasa/5r') ?>">
                            5R
                          </a>
                        </td>
                        <td>
                          <!-- <a class="input_required target target_5r"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['target_5r'] ?>
                            </span>
                            <input type="text" name="target_5r" value="<?php echo $data_bobot['target_5r'] ?>" class="form-control edit-show" required>
                          <!-- </a> -->
                        </td>
                        <td>
                          <!-- <a class="input_required bobot bobot_5r"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['bobot_5r'] ?>
                            </span>
                            <input type="text" name="bobot_5r" value="<?php echo $data_bobot['bobot_5r'] ?>" class="bobot form-control edit-show" required>
                          <!-- </a> -->
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Pengamanan</td>
                        <td>
                          <a href="<?php echo site_url('administration/template_vpi/penilaian_penyedia_jasa/pengamanan') ?>">
                            Pengamanan
                          </a>
                        </td>
                        <td>
                          <!-- <a class="input_required target target_pengamanan"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['target_pengamanan'] ?>
                            </span>
                            <input type="text" name="target_pengamanan" value="<?php echo $data_bobot['target_pengamanan'] ?>" class="form-control edit-show" required>
                          <!-- </a> -->
                        </td>
                        <td>
                          <!-- <a class="input_required bobot bobot_pengamanan"> -->
                            <span class="edit-hide">
                              <?php echo $data_bobot['bobot_pengamanan'] ?>
                            </span>
                            <input type="text" name="bobot_pengamanan" value="<?php echo $data_bobot['bobot_pengamanan'] ?>" class="form-control edit-show bobot" required>
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

        <div class="row edit-show">
          <div class="col-md-12">
            <div style="margin-bottom: 60px;">
              <div class="row">
                <div class="col-md-12">
                  <div style="padding-bottom:50px;">
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
     var prev_target_hasil_mutu_pekerjaan;
     var prev_bobot_hasil_mutu_pekerjaan;
     var prev_target_k3l;
     var prev_bobot_k3l;
     var prev_target_5r;
     var prev_bobot_5r;
     var prev_target_pengamanan;
     var prev_bobot_pengamanan;


    $('.edit-btn').click(function(event) {
      $('.edit-show').css('display', 'block');
      $('.edit-btn').css('display', 'none');
      $('.edit-hide').css('display', 'none');
      $('[name=mode]').val('insert');

      prev_total_bobot = parseFloat($('.bobot_total').text());
      prev_total_target = parseFloat($('.target_total').text());
      prev_target_ketepatan_progress = parseFloat($('[name=target_ketepatan_progress]').val());
      prev_bobot_ketepatan_progress = parseFloat($('[name=bobot_ketepatan_progress]').val());
      prev_target_hasil_mutu_pekerjaan = parseFloat($('[name=target_hasil_mutu_pekerjaan]').val());
      prev_bobot_hasil_mutu_pekerjaan = parseFloat($('[name=bobot_hasil_mutu_pekerjaan]').val());
      prev_target_k3l = parseFloat($('[name=target_k3l]').val());
      prev_bobot_k3l = parseFloat($('[name=bobot_k3l]').val());
      prev_target_5r = parseFloat($('[name=target_5r]').val());
      prev_bobot_5r = parseFloat($('[name=bobot_5r]').val());
      prev_target_pengamanan = parseFloat($('[name=target_pengamanan]').val());
      prev_bobot_pengamanan = parseFloat($('[name=bobot_pengamanan]').val());

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
          $('[name=target_hasil_mutu_pekerjaan]').val(prev_target_hasil_mutu_pekerjaan);
          $('[name=bobot_hasil_mutu_pekerjaan]').val(prev_bobot_hasil_mutu_pekerjaan);
          $('[name=target_k3l]').val(prev_target_k3l);
          $('[name=bobot_k3l]').val(prev_bobot_k3l);
          $('[name=target_5r]').val(prev_target_5r);
          $('[name=bobot_5r]').val(prev_bobot_5r);
          $('[name=target_pengamanan]').val(prev_target_pengamanan);
          $('[name=bobot_pengamanan]').val(prev_bobot_pengamanan);


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

<!-- tidak digunakan -->
<script type="text/javascript">
$(document).ready(function() {

  var $target_ketepatan_progress = $('.target_ketepatan_progress'),
  $target_hasil_mutu_pekerjaan = $('.target_hasil_mutu_pekerjaan'),
  $target_k3l = $('.target_k3l'),
  $target_5r = $('.target_5r'),
  $target_pengamanan = $('.target_pengamanan');
  var $bobot_ketepatan_progress = $('.bobot_ketepatan_progress'),
  $bobot_hasil_mutu_pekerjaan = $('.bobot_hasil_mutu_pekerjaan'),
  $bobot_k3l = $('.bobot_k3l'),
  $bobot_5r = $('.bobot_5r'),
  $bobot_pengamanan = $('.bobot_pengamanan');

  var url= "<?php echo site_url('administration/template_vpi/penilaian_penyedia_jasa/bobot_dan_target/submit?') ?>";
  var current_target_ketepatan_progress = $target_ketepatan_progress.text()
  $target_ketepatan_progress.editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {
                var total = total_target(current_target_ketepatan_progress,newValue)
                $.ajax({
                  url: url+"key=target_ketepatan_progress&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_target_ketepatan_progress = parseFloat(newValue)
            }
        }
  );

  var current_bobot_ketepatan_progress = $bobot_ketepatan_progress.text()
  $bobot_ketepatan_progress.editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_bobot_ketepatan_progress,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
            if (check_total_bobot(current_bobot_ketepatan_progress,newValue) == "less than"){
                alert('Total Bobot masih kurang dari 100');
              }
                var total = total_bobot(current_bobot_ketepatan_progress,newValue)
                $.ajax({
                  url: url+"key=bobot_ketepatan_progress&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_bobot_ketepatan_progress = parseFloat(newValue)
            }
        }
  );

  var current_target_hasil_mutu_pekerjaan = $target_hasil_mutu_pekerjaan.text()
  $target_hasil_mutu_pekerjaan.editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {
                var total = total_target(current_target_hasil_mutu_pekerjaan,newValue)
                $.ajax({
                  url: url+"key=target_hasil_mutu_pekerjaan&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_target_hasil_mutu_pekerjaan = parseFloat(newValue)
            }
        }
  );

  var current_bobot_hasil_mutu_pekerjaan = $bobot_hasil_mutu_pekerjaan.text()
  $bobot_hasil_mutu_pekerjaan.editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_bobot_hasil_mutu_pekerjaan,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
                if (check_total_bobot(current_bobot_hasil_mutu_pekerjaan,newValue) == "less than"){
                  alert('Total Bobot masih kurang dari 100');
                }
                var total = total_bobot(current_bobot_hasil_mutu_pekerjaan,newValue)
                $.ajax({
                  url: url+"key=bobot_hasil_mutu_pekerjaan&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_bobot_hasil_mutu_pekerjaan = parseFloat(newValue)
            }
        }
  );

  var current_target_k3l = $target_k3l.text()
  $target_k3l.editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {
                var total = total_target(current_target_k3l,newValue)
                $.ajax({
                  url: url+"key=target_k3l&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_target_k3l = parseFloat(newValue)
            }
        }
  );

  var current_bobot_k3l = $bobot_k3l.text()
  $bobot_k3l.editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_bobot_k3l,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
            if (check_total_bobot(current_bobot_k3l,newValue) == "less than"){
                  alert('Total Bobot masih kurang dari 100');
                }
                var total = total_bobot(current_bobot_k3l,newValue)
                $.ajax({
                  url: url+"key=bobot_k3l&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_bobot_k3l = parseFloat(newValue)
            }
        }
  );

  var current_target_5r = $target_5r.text()
  $target_5r.editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {
                var total = total_target(current_target_5r,newValue)
                $.ajax({
                  url: url+"key=target_5r&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_target_5r = parseFloat(newValue)
            }
        }
  );

  var current_bobot_5r = $bobot_5r.text()
  $bobot_5r.editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_bobot_5r,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
                if (check_total_bobot(current_bobot_5r,newValue) == "less than"){
                  alert('Total Bobot masih kurang dari 100');
                }
                var total = total_bobot(current_bobot_5r,newValue)
                $.ajax({
                  url: url+"key=bobot_5r&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_bobot_5r = parseFloat(newValue)
            }
        }
  );

  var current_target_pengamanan = $target_pengamanan.text()
  $target_pengamanan.editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
          },
          success: function(response, newValue) {
                var total = total_target(current_target_pengamanan,newValue)
                $.ajax({
                  url: url+"key=target_pengamanan&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_target_pengamanan = parseFloat(newValue)
            }
        }
  );

  var current_bobot_pengamanan = $bobot_pengamanan.text()
  $bobot_pengamanan.editable({
          title: 'Masukkan Bobot',
          placement: 'left',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}
              if (check_total_bobot(current_bobot_pengamanan,v) == "false"){
                return 'Total Bobot tidak boleh melebihi 100';
              }
          },
          success: function(response, newValue) {
              if (check_total_bobot(current_bobot_pengamanan,newValue) == "less than"){
                    alert('Total Bobot masih kurang dari 100');
                }
                var total = total_bobot(current_bobot_pengamanan,newValue)
                $.ajax({
                  url: url+"key=bobot_pengamanan&data="+newValue+"&total="+total+"&type=jasa",
                  type:"get"
                });
                current_bobot_pengamanan = parseFloat(newValue)
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
       total = current_total
       total -= parseFloat(current_val.toString().replace(',','.'))
       total += parseFloat(newValue.replace(',','.'))

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
