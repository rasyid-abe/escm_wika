<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/vpi/aspek_penilaian_pelayanan/submit_add");?>"  class="form-horizontal">


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
              <td>1</td>
              <td rowspan ="3" style="vertical-align: middle;">Performance</td>
              <td>Ketepatan Progress (Waktu)</td>
              <td id="target_ketepatan_progress"></td>
              <td id="bobot_ketepatan_progress"></td>
              <td id="ketepatan_progress"></td>
              <td id="score_ketepatan_progress"></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Mutu Pekerjaan (Sesuai KAK)</td>
              <td id="target_mutu_pekerjaan"></td>
              <td id="bobot_mutu_pekerjaan"></td>
              <td id="mutu_pekerjaan"></td>
              <td id="score_mutu_pekerjaan"></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Mutu Personal (Sesuai KAK)</td>
              <td id="target_mutu_personal"></td>
              <td id="bobot_mutu_personal"></td>
              <td id="mutu_personal"></td>
              <td id="score_mutu_personal"></td>
            </tr>
            <tr>
              <td>4</td>
              <td>Service</td>
              <td>Pelayanan</td>
              <td id="target_pelayanan"></td>
              <td id="bobot_pelayanan"></td>
              <td id="pelayanan"></td>
              <td id="score_pelayanan"></td>
            </tr>
            <tr>
              <td colspan="3">Total</td>
              <td id="total_target"></td>
              <td id="total_bobot"></td>
              <td id="total_nilal"></td>
              <td id="total_score"></td>
            </tr>
          </tbody>
        </table>

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


<?php echo buttonback('vendor/vpi/aspek_penilaian_pelayanan',lang('back')) ?>
  </form>

</div>

<script type="text/javascript"> 
  $(document).ready(function() {

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
          url: "<?php echo site_url('vendor/vpi/kompilasi_vpi/data_detail') ?>"+'?contract_id='+<?php echo $contract_data['contract_id'] ?>+'&date='+$(this).val(),
          dataType: 'json',
        })
        .done(function(data) {

          var html = ""
          var data = data.rows[0];
          var nilai_mutu = 0
          var nilai_ketepatan_progress = 0
          var nilai_pelayanan = 0
          var target_ketepatan_progress = 0

          if (data.vkvs_target_ketepatan_progress != null) {
            target_ketepatan_progress = data.vkvs_target_ketepatan_progress
            $('#target_ketepatan_progress').html(target_ketepatan_progress)
          }
          
          if (data.vkvs_bobot_ketepatan_progress != null) {
            var bobot_ketepatan_progress = data.vkvs_bobot_ketepatan_progress
            $('#bobot_ketepatan_progress').html(bobot_ketepatan_progress)
          }

          if (data.vkvs_ketepatan_progress_value != null) {
            var ketepatan_progress_val = data.vkvs_ketepatan_progress_value
            $('#ketepatan_progress').html(ketepatan_progress_val)
          }

          if (data.vkvs_score_ketepatan_progress != null) {
            var score_ketepatan_progress = data.vkvs_score_ketepatan_progress
            $('#score_ketepatan_progress').html(score_ketepatan_progress)
          }
          
          if (data.vkvs_target_mutu_personal != null) {
            target_mutu_personal = data.vkvs_target_mutu_personal
            $('#target_mutu_personal').html(target_mutu_personal)
          }
          
          if (data.vkvs_bobot_mutu_personal != null) {
            var bobot_mutu_personal = data.vkvs_bobot_mutu_personal
            $('#bobot_mutu_personal').html(bobot_mutu_personal)
          }

          if (data.vkvs_mutu_personal_value != null) {
            var mutu_personal_val = data.vkvs_mutu_personal_value
            $('#mutu_personal').html(mutu_personal_val)
          }

          if (data.vkvs_score_mutu_personal != null) {
            var score_mutu_personal = data.vkvs_score_mutu_personal
            $('#score_mutu_personal').html(score_mutu_personal)
          }

          if (data.vkvs_target_mutu_pekerjaan != null) {
            target_mutu_pekerjaan = data.vkvs_target_mutu_pekerjaan
            $('#target_mutu_pekerjaan').html(target_mutu_pekerjaan)
          }
          
          if (data.vkvs_bobot_mutu_pekerjaan != null) {
            var bobot_mutu_pekerjaan = data.vkvs_bobot_mutu_pekerjaan
            $('#bobot_mutu_pekerjaan').html(bobot_mutu_pekerjaan)
          }

          if (data.vkvs_mutu_pekerjaan_value != null) {
            var mutu_pekerjaan_val = data.vkvs_mutu_pekerjaan_value
            $('#mutu_pekerjaan').html(mutu_pekerjaan_val)
          }

          if (data.vkvs_score_mutu_pekerjaan != null) {
            var score_mutu_pekerjaan = data.vkvs_score_mutu_pekerjaan
            $('#score_mutu_pekerjaan').html(score_mutu_pekerjaan)
          }

          if (data.vkvs_target_pelayanan != null) {
            target_pelayanan = data.vkvs_target_pelayanan
            $('#target_pelayanan').html(target_pelayanan)
          }
          
          if (data.vkvs_bobot_pelayanan != null) {
            var bobot_pelayanan = data.vkvs_bobot_pelayanan
            $('#bobot_pelayanan').html(bobot_pelayanan)
          }

          if (data.vkvs_pelayanan_value != null) {
            var pelayanan_val = data.vkvs_pelayanan_value
            $('#pelayanan').html(pelayanan_val)
          }

          if (data.vkvs_score_pelayanan != null) {
            var score_pelayanan = data.vkvs_score_pelayanan
            $('#score_pelayanan').html(score_pelayanan)
          }

          $("#total_target").html(parseFloat(target_ketepatan_progress)+parseFloat(target_mutu_personal)+parseFloat(target_mutu_pekerjaan)+parseFloat(target_pelayanan));
          $("#total_bobot").html(parseFloat(bobot_ketepatan_progress)+parseFloat(bobot_mutu_personal)+parseFloat(bobot_mutu_pekerjaan)+parseFloat(bobot_pelayanan));
          $('#total_nilal').html(parseFloat(ketepatan_progress_val)+parseFloat(mutu_personal_val)+parseFloat(mutu_pekerjaan_val)+parseFloat(pelayanan_val));
          $('#total_score').html(parseFloat(score_ketepatan_progress)+parseFloat(score_mutu_personal)+parseFloat(score_mutu_pekerjaan)+parseFloat(score_pelayanan));


          



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
  });
</script>