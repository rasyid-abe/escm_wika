<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Bobot dan Target Kompilasi</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="card-content">

          <div class="table-responsive">           
<table class="table table-bordered table-responsive"  style="text-align: center;">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Parameter</th>
              <th style="text-align: center;">Key Performance Indicator</th>
              <th style="text-align: center;">Target</th>
              <th style="text-align: center;">Weight (%) <br> A</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>1</td>
              <td rowspan ="3" style="vertical-align: middle;">Performance</td>
              <td>Ketepatan Progress (Waktu)</td>
              <td><a class="input_required target_ketepatan_waktu target"><?php echo isset($current_data[0]['target_ketepatan_progress']["abt_value"]) ? $current_data[0]['target_ketepatan_progress']["abt_value"] : 0; ?></a></td>
              <td><a class="input_required bobot_ketepatan_waktu bobot"> <?php echo isset($current_data[0]['bobot_ketepatan_progress']['abt_value']) ? $current_data[0]['bobot_ketepatan_progress']['abt_value'] : 0; ?> </a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Mutu Pekerjaan (Sesuai KAK)</td>
              <td><a class="input_required target_mutu_pekerjaan target">
                <?php echo isset($current_data[0]['target_mutu_pekerjaan']['abt_value']) ? $current_data[0]['target_mutu_pekerjaan']['abt_value'] : 0; ?></a>
              </td>
              <td><a class="input_required bobot_mutu_pekerjaan bobot">
                <?php echo isset($current_data[0]['bobot_mutu_pekerjaan']['abt_value']) ? $current_data[0]['bobot_mutu_pekerjaan']['abt_value'] : 0; ?></a>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Mutu Personal (Sesuai KAK)</td>
              <td><a class="input_required target_mutu_personal target">
                <?php echo isset($current_data[0]['target_mutu_personal']['abt_value']) ? $current_data[0]['target_mutu_personal']['abt_value'] : 0; ?></a></td>
              <td><a class="input_required bobot_mutu_personal bobot">
                <?php echo isset($current_data[0]['bobot_mutu_personal']['abt_value']) ? $current_data[0]['bobot_mutu_personal']['abt_value'] : 0; ?></a></td>
            </tr>
            <tr>
              <td>4</td>
              <td>Service</td>
              <td>Pelayanan</td>
              <td><a class="input_required target_pelayanan target"><?php echo isset($current_data[0]['target_pelayanan']['abt_value']) ? $current_data[0]['target_pelayanan']['abt_value'] : 0; ?></a></td>
              <td><a class="input_required bobot_pelayanan bobot"><?php echo isset($current_data[0]['bobot_pelayanan']['abt_value']) ? $current_data[0]['bobot_pelayanan']['abt_value'] : 0; ?></a></td>
            </tr>
            <tr>
              <td colspan="3">Total</td>
              <td class="target_total">
                <?php echo (isset($current_data[0]['target_ketepatan_progress']["abt_value"]) ? $current_data[0]['target_ketepatan_progress']["abt_value"] : 0) + (isset($current_data[0]['target_mutu_pekerjaan']["abt_value"]) ? $current_data[0]['target_mutu_pekerjaan']["abt_value"] : 0) + (isset($current_data[0]['target_mutu_personal']["abt_value"]) ? $current_data[0]['target_mutu_personal']["abt_value"] : 0) + (isset($current_data[0]['target_pelayanan']["abt_value"]) ? $current_data[0]['target_pelayanan']["abt_value"] : 0) ?>
              </td>
              <td class="bobot_total">
                <?php echo (isset($current_data[0]['bobot_ketepatan_progress']["abt_value"]) ? $current_data[0]['bobot_ketepatan_progress']["abt_value"] : 0) + (isset($current_data[0]['bobot_mutu_pekerjaan']["abt_value"]) ? $current_data[0]['bobot_mutu_pekerjaan']["abt_value"] : 0) + (isset($current_data[0]['bobot_mutu_personal']["abt_value"]) ? $current_data[0]['bobot_mutu_personal']["abt_value"] : 0) + (isset($current_data[0]['bobot_pelayanan']["abt_value"]) ? $current_data[0]['bobot_pelayanan']["abt_value"] : 0) ?>
              </td>
            </tr>
          </tbody>
        </table>

          </div>

        </div>
      </div>


    </div>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
  
  var $table = $('#aspek_penilaian_pelayanan'),
  $remove = $('#remove'),
  $activate = $('#activate'),
  selections = [];
  var newVal = "";
  var current_val;
  var total1;
  var total2;
  var total3;
  var total4;
  var total5;
  var total6;
  var total7;
  var total8;

  var url= "<?php echo site_url('administration/template_vpi/bobot_dan_target_kompilasi/submit?') ?>";
  var current_target_ketepatan_waktu = $('.target_ketepatan_waktu').text()
  $('.target_ketepatan_waktu').editable({
          title: 'Masukkan Target',
          placement: 'right',
          type: 'text',
          validate: function(v) {
              if(!v){ return 'Required field!'}

          },
          success: function(response, newValue) {

                total1 = total_target(current_target_ketepatan_waktu,newValue)
                $.ajax({
                  url: url+"key=target_ketepatan_waktu&data="+newValue+"&total="+total1,
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
              total2 = total_bobot(current_val_bobot_ketepatan_waktu,newValue)
              $.ajax({
                  url: url+"key=bobot_ketepatan_waktu&data="+newValue+"&total="+total2,
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
              total3 = total_target(current_val_target_mutu_pekerjaan,newValue)
              $.ajax({
                  url: url+"key=target_mutu_pekerjaan&data="+newValue+"&total="+total3,
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
                total4 = total_bobot(current_val_bobot_mutu_pekerjaan,newValue)
                $.ajax({
                    url: url+"key=bobot_mutu_pekerjaan&data="+newValue+"&total="+total4,
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
            
              total5 = total_target(current_val_target_mutu_personal,newValue)
              $.ajax({
                  url: url+"key=target_mutu_personal&data="+newValue+"&total="+total5,
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
              total6 = total_bobot(current_val_bobot_mutu_personal,newValue)
                $.ajax({
                    url: url+"key=bobot_mutu_personal&data="+newValue+"&total="+total6,
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
             total7 = total_target(current_val_target_pelayanan,newValue)
              $.ajax({
                  url: url+"key=target_pelayanan&data="+newValue+"&total="+total7,
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
                      return 'Total Bobot masih kurang dari 100';
                    }
                  total8 = total_bobot(current_val_bobot_pelayanan,newValue)
                  $.ajax({
                    url: url+"key=bobot_pelayanan&data="+newValue+"&total="+total8,
                    type:"get"
                    });
                    current_val_bobot_pelayanan = newValue
                }
        }
  );

$('.input_required').click(function(event) {
  $('.input-sm').autoNumeric({
      aSep: '.',
      aDec: ',', 
      aSign: ''
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
      current_total += parseFloat($(this).text())
  });
    total = current_total - parseFloat(current_val) + parseFloat(newValue)

    if (total > 100) {
      return "false";
    }else if(total < 100){
      $('.bobot_total').text(total)
      return "less than";
    }else{
      $('.bobot_total').text(total)
    }
  }

  function total_bobot(current_val,newValue){
  var current_total = 0;
    $('.bobot').each(function(){
      current_total += parseFloat($(this).text())
  });
    total = current_total - parseFloat(current_val) + parseFloat(newValue)

      return total;
    
  }

  function total_target(current_val,newValue){
  var current_total = 0;
  $('.target').each(function(){
      current_total += parseFloat($(this).text())
  });
    total = current_total - parseFloat(current_val) + parseFloat(newValue)

      $('.target_total').text(total)
      return total;
    
  }

});

</script>
