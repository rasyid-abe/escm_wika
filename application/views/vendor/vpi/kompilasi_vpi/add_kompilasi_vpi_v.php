<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/vpi/kompilasi_vpi/submit_add");?>"  class="form-horizontal">


    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-header border-bottom pb-2">
            <h5 class="card-title">Header</h5>
            
          </div>
          <div class="card-body">
            <input type="hidden" name="contract_id_inp" value="<?php echo isset($contract_data['contract_id']) ? $contract_data['contract_id'] : "" ?>">

            <?php $dept_id = isset($contract_data['ptm_dept_id']) ? $contract_data['ptm_dept_id'] : "" ?>
            <?php $dept_name = isset($contract_data['ptm_dept_name']) ? $contract_data['ptm_dept_name'] : "" ?>

            <div class="form-group">
              <label class="col-sm-2 control-label">Departemen</label>
              <div class="col-sm-10">
                <input type="hidden" name="dept_id_inp" class="form-control" value="<?php echo $dept_id ?>">
               <p class="form-control-static">
                <?php echo $dept_name ?>
               </p>
               </div>
            </div>

            <?php $vendor_id = isset($contract_data['vendor_id']) ? $contract_data['vendor_id'] : "" ?>
            <?php $vendor_name = isset($contract_data['vendor_name']) ? $contract_data['vendor_name'] : "" ?>

            <div class="form-group">
              <label class="col-sm-2 control-label">Penyedia Barang/Jasa</label>
              <div class="col-sm-10">
                <input type="hidden" name="vendor_id_inp" class="form-control" value="<?php echo $vendor_id ?>">
               <p class="form-control-static">
                 <?php echo $vendor_name ?>
               </p>
               </div>
             </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Deskripsi Pengadaan</label>
                <div class="col-sm-10">
                 <p class="form-control-static">
                  <?php echo $contract_data['subject_work'] ?>
                 </p>
               </div>
             </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Bulan *</label>
                <div class="col-sm-3">
                  <select name='date_inp' class="form-control date_inp" required> 
                    <option value="">Pilih</option>
                    <?php if (isset($date_range)) { 
                      foreach ($date_range['text'] as $key => $value) { ?>

                      <option value="<?php echo $date_range['val'][$key] ?>"><?php echo $value ?></option>
                        
                    <?php }
                      
                     } ?>
                  </select>
               </div>
            </div>

       </div>
     </div>
    </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-header border-bottom pb-2">
            <h5 class="card-title">Kompilasi</h5>
            
          </div>
          <div class="card-body">
           <table class="table table-bordered table-responsive"  style="text-align: center;">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Parameter</th>
              <th style="text-align: center;">Key Performance Indicator</th>
              <th style="text-align: center;">Target</th>
              <th style="text-align: center;">Weight (%) <br> A</th>
              <th style="text-align: center;">Nilai <br> B</th>
              <th style="text-align: center;">Score <br> (AxB)</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <?php $target_ketepatan_progress = isset($target_dan_bobot['target_ketepatan_progress']['abt_value']) ? $target_dan_bobot['target_ketepatan_progress']['abt_value'] : 0; ?>
              <?php $bobot_ketepatan_progress = isset($target_dan_bobot['bobot_ketepatan_progress']['abt_value']) ? $target_dan_bobot['bobot_ketepatan_progress']['abt_value'] : 0; ?>
              <td>1</td>
              <td rowspan ="3" style="vertical-align: middle;">Performance</td>
              <td>Ketepatan Progress (Waktu)</td>
              <td>
                <span id="target_ketepatan_progress"><?php echo $target_ketepatan_progress ?></span>
                <input type="text" name="target_ketepatan_progress" class="form-control money" value="<?php echo $target_ketepatan_progress ?>" style="display: none;">  
              </td>
              <td>
                <span id="bobot_ketepatan_progress"><?php echo $bobot_ketepatan_progress ?></span>
                <input type="text" name="bobot_ketepatan_progress" class="form-control money" value="<?php echo $bobot_ketepatan_progress ?>" style="display: none;">  
              </td>
              <td id="ketepatan_progress"></td>
              <td id="score_ketepatan_progress"></td>
            </tr>
            <tr>
              <?php $target_mutu_pekerjaan = isset($target_dan_bobot['target_mutu_pekerjaan']['abt_value']) ? $target_dan_bobot['target_mutu_pekerjaan']['abt_value'] : 0; ?>
              <?php $bobot_mutu_pekerjaan = isset($target_dan_bobot['bobot_mutu_pekerjaan']['abt_value']) ? $target_dan_bobot['bobot_mutu_pekerjaan']['abt_value'] : 0; ?>
              <td>2</td>
              <td>Mutu Pekerjaan (Sesuai KAK)</td>
              <td>
                <span id="target_mutu_pekerjaan"><?php echo $target_mutu_pekerjaan ?></span>
                <input type="text" name="target_mutu_pekerjaan" class="form-control money" value="<?php echo $target_mutu_pekerjaan ?>" style="display: none;">    
              </td>
              <td>
                <span id="bobot_mutu_pekerjaan"><?php echo $bobot_mutu_pekerjaan ?></span>
                 <input type="text" name="bobot_mutu_pekerjaan" class="form-control money" value="<?php echo $bobot_mutu_pekerjaan ?>" style="display: none;">      
              </td>
              <td class="mutu"></td>
              <td id="score_mutu_pekerjaan"></td>
            </tr>
            <tr>
              <?php $target_mutu_personal = isset($target_dan_bobot['target_mutu_personal']['abt_value']) ? $target_dan_bobot['target_mutu_personal']['abt_value'] : 0; ?>
              <?php $bobot_mutu_personal = isset($target_dan_bobot['bobot_mutu_personal']['abt_value']) ? $target_dan_bobot['bobot_mutu_personal']['abt_value'] : 0; ?>
              <td>3</td>
              <td>Mutu Personal (Sesuai KAK)</td>
              <td>
                <span id="target_mutu_personal"><?php echo $target_mutu_personal ?></span>
                <input type="text" name="target_mutu_personal" class="form-control money" value="<?php echo $target_mutu_personal ?>" style="display: none;"> 
              </td>
              <td>
                <span id="bobot_mutu_personal"><?php echo $bobot_mutu_personal ?></span>
                <input type="text" name="bobot_mutu_personal" class="form-control money" value="<?php echo $bobot_mutu_personal ?>" style="display: none;"> 
              </td>
              <td class="mutu"></td>
              <td id="score_mutu_personal"></td>
            </tr>
            <tr>
              <?php $target_pelayanan = isset($target_dan_bobot['target_pelayanan']['abt_value']) ? $target_dan_bobot['target_pelayanan']['abt_value'] : 0; ?>
              <?php $bobot_pelayanan = isset($target_dan_bobot['bobot_pelayanan']['abt_value']) ? $target_dan_bobot['bobot_pelayanan']['abt_value'] : 0; ?>
              <td>4</td>
              <td>Service</td>
              <td>Pelayanan</td>
              <td>
                <span id="target_pelayanan"><?php echo $target_pelayanan ?></span>
                <input type="text" name="target_pelayanan" class="form-control money" value="<?php echo $target_pelayanan ?>" style="display: none;"> 
              </td>
              <td>
                <span id="bobot_pelayanan"><?php echo $bobot_pelayanan ?></span>
                <input type="text" name="bobot_pelayanan" class="form-control money" value="<?php echo $bobot_pelayanan ?>" style="display: none;"> 
              </td>
              <td id="pelayanan"></td>
              <td id="score_pelayanan"></td>
            </tr>
            <tr>
              <td colspan="3">Total</td>
              <td>
                <?php $total_target = $target_ketepatan_progress + $target_mutu_pekerjaan + $target_mutu_personal + $target_pelayanan; ?>
                <span id="total_target"><?php echo $total_target ?></span>
                <input type="text" name="total_target" class="form-control money" style="display: none;" value="<?php echo $total_target ?>">
              </td>
              <td>
                <?php $total_bobot = $bobot_ketepatan_progress + $bobot_mutu_pekerjaan + $bobot_mutu_personal + $bobot_pelayanan; ?>
                <span id="total_target"><?php echo $total_bobot ?></span>
                <input type="text" name="total_bobot" class="form-control money" style="display: none;" value="<?php echo $total_bobot ?>">
              </td>
              <td id="total_nilal"></td>
              <td id="total_score"></td>
            </tr>
          </tbody>
        </table>
        <div style="text-align: center;"> 
          <span class="btn btn-danger" id="edit_btn">Edit Target dan Bobot</span>
          <span class="btn btn-primary" id="simpan_btn" style="display: none;">Simpan</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
<div class="col-lg-12">
  <div class="card float-e-margins">
    <div class="card-header border-bottom pb-2">
      <h5 class="card-title">Parameter Penilaian</h5>
      <div class="card-tools">
        <a class="collapse-link">
          <i class="fa fa-chevron-up"></i>
        </a>
      </div>
    </div>
    <div class="card-body">


       <table class="table table-bordered" style="text-align: center;">
          <thead>
            <tr >
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Parameter</th>
              <th style="text-align: center;">Lebih Cepat <br> >10% </th>
              <th style="text-align: center;">Lebih Cepat <br> >0% - &#8804;10%</th>
              <th style="text-align: center;">Tepat Schedule <br> Ra = Ri</th>
              <th style="text-align: center;">Terlambat <br> &#8804;5% </th>
              <th style="text-align: center;">Terlambat <br> >5% - &#8804;10% </th>
              <th style="text-align: center;">Terlambat <br> >10% - &#8804;20% </th>
              <th style="text-align: center;">Terlambat <br> >20% </th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>1</td>
              <td>Kecepatan Progress</td>
              <td>10</td>
              <td>9</td>
              <td>8</td>
              <td>7</td>
              <td>6</td>
              <td>5</td>
              <td>4</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Excellent</td>
              <td>Lebih Baik</td>
              <td>Baik</td>
              <td>Cukup</td>
              <td>Sedang</td>
              <td>Kurang</td>
              <td>Buruk</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Mutu Pekerjaan</td>
              <td>10</td>
              <td>9</td>
              <td>8</td>
              <td>7</td>
              <td>6</td>
              <td>5</td>
              <td>4</td>
            </tr>
            <tr>
              <td>3</td>
              <td rowspan="2">Mutu Personal</td>
              <td>10</td>
              <td>9</td>
              <td>8</td>
              <td>7</td>
              <td>6</td>
              <td>5</td>
              <td>4</td>
            </tr>
            <tr>
              <td></td>
              <td>100</td>
              <td>90 &#8804; N < 100</td>
              <td>80 &#8804; N < 90</td>
              <td>70 &#8804; N < 80</td>
              <td>60 &#8804; N < 70</td>
              <td>50 &#8804; N < 60</td>
              <td>N < 50</td>
            </tr>
            <tr>
              <td>4</td>
              <td rowspan="2">Pelayanan</td>
              <td>10</td>
              <td>9</td>
              <td>8</td>
              <td>7</td>
              <td>6</td>
              <td>5</td>
              <td>4</td>
            </tr>
          </tbody>
        </table>

    </div>
    </div>
  </div>
</div>


<?php echo buttonsubmit('vendor/vpi/aspek_penilaian_pelayanan',lang('back'),lang('save')) ?>
  </form>

</div>

<script type="text/javascript"> 
  $(document).ready(function() {
    <?php if (!isset($target_dan_bobot)) { ?>
     alert('Target dan Bobot belum di set')
    <?php } ?>

      $(".date_inp").change(function(event) {
        if ($(this).val() == "") {

          $('.mutu').html("")
          $('#ketepatan_progress').html("")
          $('#score_ketepatan_progress').html("")
          $('#pelayanan').html("")
          $('#score_mutu_pekerjaan').html("")
          $('#score_ketepatan_progress').html("");
          $('#score_mutu_personal').html("")
          $('#score_pelayanan').html("")
          $('#total_score').html("")

        }else{

        $.ajax({
          url: "<?php echo site_url('vendor/vpi/kompilasi_vpi/data') ?>"+'?contract_id='+<?php echo $contract_data['contract_id'] ?>+'&date='+$(this).val(),
          dataType: 'json',
        })
        .done(function(data) {

          var html = ""
          var data = data.rows;
          var nilai_mutu = 0
          var nilai_ketepatan_progress = 0
          var nilai_pelayanan = 0

          if (data[0].nilai_mutu != null) {
            nilai_mutu = data[0].nilai_mutu
          }

          if (nilai_mutu == 0) {
            $('.mutu').html("Belum ada nilai")
          }else{
            $('.mutu').html("<input type='hidden' name='mutu_personal_inp' value='"+nilai_mutu+"'><input type='hidden' name='mutu_pekerjaan_inp' value='"+nilai_mutu+"'>"+ nilai_mutu)
          }
          

          if (data[0].nilai_ketepatan_progress != null) {
            nilai_ketepatan_progress = data[0].nilai_ketepatan_progress
          }

          if (nilai_ketepatan_progress == 0) {
            $('#ketepatan_progress').html("Belum ada nilai")
          }else{
            $('#ketepatan_progress').html("<input type='hidden' name='ketepatan_progress_inp' value='"+nilai_ketepatan_progress+"'>"+ nilai_ketepatan_progress)
          }
          

          if (data[0].nilai_pelayanan != null) {
            nilai_pelayanan = data[0].nilai_pelayanan
          }

          if (nilai_pelayanan == 0) {
            $('#pelayanan').html("Belum ada nilai")
          }else{
            $('#pelayanan').html("<input type='hidden' name='pelayanan_inp' value='"+nilai_pelayanan+"'>"+ nilai_pelayanan)
          }
          
          var nilai_bobot_ketepatan_progress = parseFloat($('input[name="bobot_ketepatan_progress"]').val());
          if ($('input[name="bobot_ketepatan_progress"]').val() == "") {
             nilai_bobot_ketepatan_progress = 0
          }

          $("#score_ketepatan_progress").html("<input type='hidden' name='score_ketepatan_progress' value='"+(nilai_bobot_ketepatan_progress*nilai_ketepatan_progress)+"'/>"+(nilai_bobot_ketepatan_progress*nilai_ketepatan_progress))

          var nilai_bobot_mutu_personal = parseFloat($('input[name="bobot_mutu_personal"]').val());
          if ($('input[name="bobot_mutu_personal"]').val() == "") {
             nilai_bobot_mutu_personal = 0
          }

          $("#score_mutu_personal").html("<input type='hidden' name='score_mutu_personal' value='"+(nilai_bobot_mutu_personal*nilai_mutu)+"'/>"+(nilai_bobot_mutu_personal*nilai_mutu))

          var nilai_bobot_mutu_pekerjaan = parseFloat($('input[name="bobot_mutu_pekerjaan"]').val());
          if ($('input[name="bobot_mutu_pekerjaan"]').val() == "") {
             nilai_bobot_mutu_pekerjaan = 0
          }

          $("#score_mutu_pekerjaan").html("<input type='hidden' name='score_mutu_pekerjaan' value='"+(nilai_bobot_mutu_pekerjaan*nilai_mutu)+"'/>"+(nilai_bobot_mutu_pekerjaan*nilai_mutu))

          var nilai_bobot_pelayanan = parseFloat($('input[name="bobot_pelayanan"]').val());
          if ($('input[name="bobot_pelayanan"]').val() == "") {
             nilai_bobot_pelayanan = 0
          }

          $("#score_pelayanan").html("<input type='hidden' name='score_pelayanan' value='"+(nilai_bobot_pelayanan*nilai_pelayanan)+"'/>"+(nilai_bobot_pelayanan*nilai_pelayanan))

          var total_score = (nilai_bobot_ketepatan_progress*nilai_ketepatan_progress)+(nilai_bobot_mutu_personal*nilai_mutu)+(nilai_bobot_mutu_pekerjaan*nilai_mutu)+(nilai_bobot_pelayanan*nilai_pelayanan)
          $('#total_score').html("<input type='hidden' name='total_score' value='"+total_score+"' />"+total_score)



          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        }
      });

      var total_target = 0;
      var total_bobot = 0;
      var check = 0;

      $('#edit_btn').click(function(event) {
       $('input[name="target_ketepatan_progress"]').css('display', '');
       $('#target_ketepatan_progress').css('display', 'none');
       $('input[name="target_mutu_personal"]').css('display', '');
       $('#target_mutu_personal').css('display', 'none');
       $('input[name="target_mutu_pekerjaan"]').css('display', '');
       $('#target_mutu_pekerjaan').css('display', 'none');
       $('input[name="target_pelayanan"]').css('display', '');
       $('#target_pelayanan').css('display', 'none');


       $('input[name="bobot_ketepatan_progress"]').css('display', '');
       $('#bobot_ketepatan_progress').css('display', 'none');
       $('input[name="bobot_mutu_personal"]').css('display', '');
       $('#bobot_mutu_personal').css('display', 'none');
       $('input[name="bobot_mutu_pekerjaan"]').css('display', '');
       $('#bobot_mutu_pekerjaan').css('display', 'none');
       $('input[name="bobot_pelayanan"]').css('display', '');
       $('#bobot_pelayanan').css('display', 'none');

       $('#simpan_btn').css('display', '');
       $('#edit_btn').css('display', 'none');
      });

      $('#simpan_btn').click(function(event) {

       
       
       $('.money').each(function(index, el) {
          if ($(this).val() == "") {
            check = 1;
            
          }
        });

      if (check == 1) {
        alert("Target Dan Bobot tidak boleh kosong");
        check = 0
      }else{

       $('input[name="target_ketepatan_progress"]').css('display', 'none');
       $('#target_ketepatan_progress').css('display', '');
       $('#target_ketepatan_progress').text($('input[name="target_ketepatan_progress"]').val())
       $('input[name="target_mutu_personal"]').css('display', 'none');
       $('#target_mutu_personal').css('display', '');
       $('#target_mutu_personal').text($('input[name="target_mutu_personal"]').val())
       $('input[name="target_mutu_pekerjaan"]').css('display', 'none');
       $('#target_mutu_pekerjaan').css('display', '');
       $('#target_mutu_pekerjaan').text($('input[name="target_mutu_pekerjaan"]').val())
       $('input[name="target_pelayanan"]').css('display', 'none');
       $('#target_pelayanan').css('display', '');
       $('#target_pelayanan').text($('input[name="target_pelayanan"]').val())

       total_target = parseFloat($('input[name="target_ketepatan_progress"]').val()) + parseFloat($('input[name="target_mutu_personal"]').val())+parseFloat($('input[name="target_mutu_pekerjaan"]').val())+parseFloat($('input[name="target_pelayanan"]').val());

       $('#total_target').text(total_target);
       $('input[name="total_target"]').val(total_target)

       $('input[name="bobot_ketepatan_progress"]').css('display', 'none');
       $('#bobot_ketepatan_progress').css('display', '');
       $('#bobot_ketepatan_progress').text($('input[name="bobot_ketepatan_progress"]').val())
       $('input[name="bobot_mutu_personal"]').css('display', 'none');
       $('#bobot_mutu_personal').css('display', '');
       $('#bobot_mutu_personal').text($('input[name="bobot_mutu_personal"]').val())
       $('input[name="bobot_mutu_pekerjaan"]').css('display', 'none');
       $('#bobot_mutu_pekerjaan').css('display', '');
       $('#bobot_mutu_pekerjaan').text($('input[name="bobot_mutu_pekerjaan"]').val())
       $('input[name="bobot_pelayanan"]').css('display', 'none');
       $('#bobot_pelayanan').css('display', '');
       $('#bobot_pelayanan').text($('input[name="bobot_pelayanan"]').val())
        total_bobot = parseFloat($('input[name="bobot_ketepatan_progress"]').val()) + parseFloat($('input[name="bobot_mutu_personal"]').val())+parseFloat($('input[name="bobot_mutu_pekerjaan"]').val())+parseFloat($('input[name="bobot_pelayanan"]').val());
       $('#total_bobot').text(total_bobot);
       $('input[name="total_bobot"]').val(total_bobot)

        $('#simpan_btn').css('display', 'none');
        $('#edit_btn').css('display', '');
      }
       
      });

      $('.money').keypress(function(e){
              if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
              {
                  e.preventDefault();
              }
            });


  });
</script>