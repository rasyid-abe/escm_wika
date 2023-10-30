<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" id="form_aspek_penilaian_pelayanan" action="<?php echo site_url($controller_name."/vpi/daftar_pekerjaan/penilaian_vpi/".$vvh_id."/jasa/submit_pengamanan");?>"  class="form-horizontal">


    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-header border-bottom pb-2">
            <h5 class="card-title">Header</h5>
            
          </div>
          <div class="card-body">

            <input type="hidden" name="contract_id_inp" value="<?php echo isset($vvh_data['contract_id']) ? $vvh_data['contract_id'] : "" ?>">
            <input type="hidden" name="vvh_id_inp" value="<?php echo $vvh_id ?>">
            <input type="hidden" name="tipe_inp" value="jasa>">

            <?php $dept_id = isset($vvh_data['ptm_dept_id']) ? $vvh_data['ptm_dept_id'] : "" ?>
            <?php $dept_name = isset($vvh_data['ptm_dept_name']) ? $vvh_data['ptm_dept_name'] : "" ?>

            <div class="form-group">
              <label class="col-sm-2 control-label">Departemen</label>
              <div class="col-sm-10">
                <input type="hidden" name="dept_id_inp" class="form-control" value="<?php echo $dept_id ?>">
               <p class="form-control-static">
                <?php echo $dept_name ?>
               </p>
               </div>
            </div>

            <?php $vendor_id = isset($vvh_data['vendor_id']) ? $vvh_data['vendor_id'] : "" ?>
            <?php $vendor_name = isset($vvh_data['vendor_name']) ? $vvh_data['vendor_name'] : "" ?>

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
                  <?php echo $vvh_data['subject_work'] ?>
                 </p>
               </div>
             </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Bulan</label>
              <div class="col-sm-3">
                <input type="hidden" name="date_inp" value="<?php echo $vvh_data['vvh_date'] ?>">
                  <p class="form-control-static">
                    <?php echo $vvh_data['vvh_date_text'] ?>
                  </p>
             </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Tipe</label>
                <div class="col-sm-3">
                  <input type="hidden" name="date_inp" value="<?php echo $vvh_data['vvh_date']; ?>">
                  <p class="form-control-static">
                    <?php echo ucfirst($vvh_data['vvh_tipe']); ?>
                  </p>
                  </p>
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
            <h5 class="card-title">Penilaian Pengamanan</h5>
            
          </div>
          <div class="card-body">
           <table class="table table-bordered tbl-pertanyaan">
          <thead>
            <tr>
              <th width="10px">No</th>
              <th>Pertanyaan</th>
              <th width="100px">Nilai A (%)</th>
            </tr>
          </thead>

          <tbody id="pertanyaan_table">
          <?php 
          if (isset($pertanyaan)) {
          $no = 1;
          foreach ($pertanyaan as $key => $value){ 
            $curval = isset($value['vvps_value']) ? $value['vvps_value'] : "";
            $id = isset($value['vvps_id']) ? $value['vvps_id'] : ""; 
            ?> 
            <tr>
              <td><?php echo $no ?></td>
              <td>
                <?php echo $value['ap_value'] ?> 
                <input type="hidden" name="ap_id_inp[<?php echo $no-1 ?>]" value="<?php echo $value['ap_id'] ?>">
              </td>
              <td>
                 <input type="hidden" name="id_inp[<?php echo $no-1 ?>]"  value="<?php echo $id ?>">
                <input type="hidden" required class="form-control money answer_inp" 
                name="answer_inp[<?php echo $no-1 ?>]" value="<?php echo $curval ?>">
                <?php echo $curval ?>
              </td>
            </tr>

           <?php $no++; } } ?>
          </tbody>
        </table>
        <div style="text-align: center; display: none;">
          <a class="btn btn-primary" id="hitung_nilai" style="align-self: center">Hitung Nilai</a>
        </div>
        
      </div>
    </div>
  </div>
</div>

<div class="row">
<div class="col-lg-12">
  <div class="card float-e-margins">
    <div class="card-header border-bottom pb-2">
      <h5 class="card-title">Nilai Akhir</h5>
      <div class="card-tools">
        <a class="collapse-link">
          <i class="fa fa-chevron-up"></i>
        </a>
      </div>
    </div>
    <div class="card-body">
    <?php $curval = isset($prev_data['vvp_value']) ? $prev_data['vvp_value']  : ""?>
    <div class="form-group" style="text-align: center;">
        <label><h3>Skor Penyedia Jasa </h3></label><br>
        <h1><span id="hasil"><?php echo $curval ?></span></h1><br>
        <input type="hidden" name="nilai_akhir_inp" id="nilai_akhir_inp" value="<?php echo $curval ?>">
      <label><h4>Nilai Maksimal (A) =  100 %</h4></label>
    </div>

    </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-header border-bottom pb-2">
        <h5 class="card-title">Catatan</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
      <div class="form-group">
        <?php $curval = !empty($prev_data['vvp_note_attach']) ? $prev_data['vvp_note_attach'] : "no file";
              $data_url = !empty($prev_data['vvp_note_attach']) ? site_url('log/download_attachment/vendor/').'/'.$prev_data['vvp_note_attach'] : "#"; 
         ?>
      <label class="col-sm-1 control-label">Lampiran</label>
          <div class="col-sm-5">
            <div class="input-group">
              <p class="form-control-static">
                <a href="<?php echo $data_url ?>"><?php echo $curval ?></a>
              </p>
            </div>
             
          </div>
        </div>
      <?php $curval = isset($prev_data['vvp_note']) ? $prev_data['vvp_note'] : ""  ?>
      <div class="form-group">
        <label class="col-sm-1 control-label">Catatan *</label>
        <div class="col-sm-11">
          <textarea readonly name="note_inp" id="note_inp" required class="form-control" maxlength="1000" style="height: 80px"><?php echo $curval ?></textarea>
        </div>
      </div>

      </div>
      </div>
    </div>
</div>

<?php echo buttonback('vendor/vpi/monitor_pekerjaan/penilaian_vpi/'.$vvh_id,lang('back'),lang('save')) ?>
  </form>

</div>

<script type="text/javascript"> 
  $(document).ready(function() {
    numeric_format();

    $('.answer_inp').keypress(function(e){
      if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
      {
          e.preventDefault();
      }
    });

     <?php if(!isset($pertanyaan)){ ?>
      alert('Pertanyaan Belum dibuat');
    <?php }?>

    var total_pertanyaan = <?php echo count($pertanyaan);?>;

           $('.answer_inp').keypress(function(e){
              if (e.which != 8 && e.which != 0 && e.which < 48 || e.which > 57)
              {
                  e.preventDefault();
              }
            });

        $('#hitung_nilai').click(function() {
          hitung();
        });       

        function hitung(){
          var total_nilai = 0;
          for (var i = 0; i < total_pertanyaan; i++) {
            if ($('input[name="answer_inp['+i+']"]').val() == "") {
              var current_val = 0;
            }else{
              var current_val = $('input[name="answer_inp['+i+']"]').val()
            }
            
            total_nilai += parseFloat(current_val)
          }
          total_nilai = total_nilai/total_pertanyaan/10
          total_nilai = total_nilai.toFixed(2)
          
            $('#hasil').html(total_nilai)
            $('#nilai_akhir_inp').val(total_nilai);
            $('#hitung_nilai').prop('disabled', true);

        }

       $('.answer_inp').on('change',function(event) {

        $('#hitung_nilai').prop('disabled', false);
        hitung()
        // $('#hasil').html("0")
        // $('#nilai_akhir_inp').val("");
      });

        function check_total(tipe){
        var current_total = 0;
        $('.answer_'+tipe+'_inp').each(function(){
            current_total += parseFloat($(this).val().replace(',','.'))
        });
        total = current_total 
        // - parseFloat(current_val.toString().replace(',','.')) + parseFloat(newValue.replace(',','.'))

        if (total > 100) {
          alert('Maksimum Total Nilai 100%')
          $('.answer_'+tipe+'_inp').val('')
          return 'false';
        }else{
          return 'true';
        }
      }

      function numeric_format(){
          $("input.money").autoNumeric({
              aSep: '.',
              aDec: ',', 
              aSign: '',
              vMax:'100'
            });
      }

  });
</script>