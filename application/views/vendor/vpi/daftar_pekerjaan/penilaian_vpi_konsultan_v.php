<div class="wrapper wrapper-content animated fadeInRight">

<form method="post" action="<?php echo site_url($controller_name."/vpi/daftar_pekerjaan/penilaian_vpi/".$vvh_id."/konsultan/submit_kompilasi");?>"  class="form-horizontal">

<div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header border-bottom pb-2">
            <h5 class="card-title">Header</h5>
            
          </div>
          <div class="card-body">
            <input type="hidden" name="contract_id_inp" value="<?php echo isset($vvh_data['contract_id']) ? $vvh_data['contract_id'] : "" ?>">
            <input type="hidden" name="vvh_id_inp" value="<?php echo isset($vvh_id) ? $vvh_id : "" ?>">

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
              <label class="col-sm-2 control-label">Penyedia Konsultan</label>
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
                <div class="col-sm-10">
                 <p class="form-control-static">
                <input type="hidden" name="date_inp" class="form-control" value="<?php echo $vvh_data['vvh_date'] ?>">
                  <?php echo $vvh_data['vvh_date_text'] ?>
                 </p>
               </div>
            </div>

       </div>
     </div>
    </div>
    </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-bottom pb-2">
          <h5 class="card-title">Penilaian Penyedia Konsultan</h5>
          
        </div>        

        <div class="card-body">

          <div class="table-responsive">           
          <table class="table table-bordered table-responsive"  style="text-align: center;">
          <thead>
            <tr>
              <th style="text-align: center;">Aksi</th>
              <th style="text-align: center;width: 25em">Parameter</th>
              <th style="text-align: center;">Key Performance Indicator</th>
              <th style="text-align: center;">Target</th>
              <th style="text-align: center;">Weight (%)<br/> A</th>
              <th style="text-align: center;">Nilai <br> B</th>
              <th style="text-align: center;">Score <br> A x B </th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>
                <a class="btn btn-xs btn-primary" href="<?php echo current_url().'/'.'konsultan/ketepatan_progress' ?>">
                Nilai
              </a></td>
              <td rowspan ="3" style="vertical-align: middle;">Performance</td>
              <td>           
                Ketepatan Progress
              </td>
              <td>
                  <?php echo $data_bobot['target_ketepatan_progress'] ?>
              </td>
              <td>
                    <?php echo $data_bobot['bobot_ketepatan_progress'] ?>
              </td>
              <td id="nilai_ketepatan_progress">
                    <?php echo isset($nilai_ketepatan_progress) ? $nilai_ketepatan_progress : ""; ?>
              </td>
              <td id="score_ketepatan_progress">
                    <?php $score_ketepatan_progress =  isset($nilai_ketepatan_progress) ? replace_comma((int)$nilai_ketepatan_progress) * replace_comma((int)$data_bobot['bobot_ketepatan_progress']) : "";
                          echo inttomoney($score_ketepatan_progress);
                          $curval = isset($kompilasi_score['ketepatan_progress']) ? $kompilasi_score['ketepatan_progress'] : "";
                           ?>
                    <input type="hidden" name="score_ketepatan_progress" class="score" value="<?php echo $score_ketepatan_progress ?>" title="Score Ketepatan Progress">
                    <input type="hidden" name="ketepatan_progress_id"  value="<?php echo $curval ?>" >
              </td>
            </tr>
            <tr>
              <td rowspan="2" style="vertical-align: middle;">
                <a class="btn btn-xs btn-primary" href="<?php echo current_url().'/'.'konsultan/mutu_pekerjaan' ?>">
                  Nilai
                </a>
              </td>
              <td>
                Mutu Pekerjaan (Sesuai KAK)
              </td>
              <td>
                  <?php echo $data_bobot['target_mutu_pekerjaan'] ?>
              </td>
              <td>
                  <?php echo $data_bobot['bobot_mutu_pekerjaan'] ?>
                </td>
              <td id="nilai_mutu_pekerjaan">
                <?php echo isset($nilai_mutu) ? $nilai_mutu : ""; ?>
              </td>
              <td id="score_mutu_pekerjaan">

                <?php $score_mutu_pekerjaan =  isset($nilai_mutu) ? replace_comma((int)$nilai_mutu) * replace_comma((int)$data_bobot['bobot_mutu_pekerjaan']) : "";
                echo inttomoney($score_mutu_pekerjaan); 
                $curval = isset($kompilasi_score['mutu_pekerjaan']) ? $kompilasi_score['mutu_pekerjaan'] : ""; ?>

                    <input type="hidden" class="score" name="score_mutu_pekerjaan" value="<?php echo $score_mutu_pekerjaan ?>" title="Score Hasil Mutu Pekerjaan">

                    <input type="hidden" name="mutu_pekerjaan_id"  value="<?php echo $curval ?>" >

              </td>
            </tr>
            <tr>
              <td>
                 Mutu Personal (Sesuai KAK)
              </td>
              <td>
                  <?php echo $data_bobot['target_mutu_personal'] ?>
              </td>
              <td>
                  <?php echo $data_bobot['bobot_mutu_personal'] ?>
              </td>
              <td id="nilai_hasil_mutu_personal">
                <?php echo isset($nilai_mutu) ? $nilai_mutu : ""; ?>
              </td>
              <td id="nilai_hasil_mutu_personal">
                <?php $score_mutu_personal = isset($nilai_mutu) ? replace_comma((int)$nilai_mutu) * replace_comma((int)$data_bobot['bobot_mutu_personal']) : ""; 
                echo inttomoney($score_mutu_personal);
                $curval = isset($kompilasi_score['mutu_personal']) ? $kompilasi_score['mutu_personal'] : ""; ?>
                <input type="hidden" class="score" name="score_mutu_personal" title="Score mutu_personal" value="<?php echo $score_mutu_personal  ?>">
                <input type="hidden" name="mutu_personal_id"  value="<?php echo $curval ?>" >
              </td>
            </tr>
            <tr>
              <td>
                <a class="btn btn-xs btn-primary" href="<?php echo current_url().'/'.'konsultan/pelayanan' ?>">
                  Nilai
                </a>
              </td>
              <td style="vertical-align: middle;">Service</td>

              <td>
                  Pelayanan
              </td>
              <td>
                  <?php echo $data_bobot['target_pelayanan'] ?>    
              </td>
              <td>
                  <?php echo $data_bobot['bobot_pelayanan'] ?>
              </td>
              <td id="nilai_pelayanan">
                <?php echo isset($nilai_pelayanan) ? $nilai_pelayanan : ""; ?>
              </td>
              <td id="score_pelayanan">
                <?php $score_pelayanan = isset($nilai_pelayanan) ? replace_comma((int)$nilai_pelayanan) * replace_comma((int)$data_bobot['bobot_pelayanan']) : "";
                 echo inttomoney($score_pelayanan);
                $curval = isset($kompilasi_score['pelayanan']) ? $kompilasi_score['pelayanan'] : "";  ?>
                <input type="hidden" class="score" name="score_pelayanan"  title="Score pelayanan" value="<?php echo $score_pelayanan  ?>">
                <input type="hidden" name="pelayanan_id"  value="<?php echo $curval ?>" >
              </td>
            </tr>
            
             <tr>
              <td colspan="3">Total</td>
              <td class="target_total">
                <?php echo $total_target ?>
                <input type="hidden" name="target_total" value="<?php echo $total_target ?>">
              </td>
              <td class="bobot_total">
                <?php echo $total_bobot ?>
                <input type="hidden" name="bobot_total" value="<?php echo $total_bobot ?>">
              </td>
              <td id="nilai_total">
              <?= (int)$nilai_ketepatan_progress + (int)$nilai_mutu_pekerjaan + floor($nilai_5r) + floor($nilai_k3l) + (int)$nilai_pengamanan  ?>

              </td>
              <td>
                <?php $curval = isset($kompilasi['score_total']) ? $kompilasi['score_total'] : ""; ?>
                <span id="score_total"></span>
                <input type="hidden" name="score_total" value="<?php echo $curval ?>">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<?php //include('parameter_penilaian_konsultan_v.php') ?>

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
          <label class="col-sm-1 control-label">Aksi *</label>
          <div class="col-sm-5">
            <select required name="response_inp" id="response_inp" class="form-control" style="width:100%;">
              <option value="">Pilih</option>
              <option value="0" <?php echo $prev_data['vk_response'] == '0' ? 'selected' : '' ?> >
              Simpan Sebagai Draft</option>
              <option value="1" <?php echo $prev_data['vk_response'] == '1' ? 'selected' : '' ?> >
               Simpan dan Lanjut</option>
            </select>
         </div>

          <?php $curval = isset($prev_data['vk_note_attach']) ? $prev_data['vk_note_attach'] : "";
            $data_url = isset($prev_data['vk_note_attach']) ? site_url('log/download_attachment/vendor/').'/'.$prev_data['vk_note_attach'] : '#'; ?>
      <label class="col-sm-1 control-label">Lampiran</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" data-id="comment_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="comment_file" class="btn btn-primary upload">
                  <i class="fa fa-cloud-upload"></i> Upload
                </button> 
                <button type="button" data-url="<?php echo $data_url ?>" class="btn btn-primary preview_upload" id="comment_file">
                  <i class="fa fa-share"></i> Preview
                </button> 
              </span> 
              <input readonly type="text" class="form-control" id="comment_attachment_inp" name="note_attachment_inp" value="<?php echo $curval ?>">
              <span class="input-group-btn">
                <button type="button" data-id="comment_attachment_inp" data-folder="<?php echo $dir ?>" data-preview="comment_file" class="btn btn-danger removefile">
                  <i class="fa fa-trash"></i> Delete
                </button> 
              </span> 
            </div>
             <div class="col-sm-0" style="font-size: 11px">
            <i>Max file 5 MB 
            <br>
              Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
            </i>
          </div>
          </div>
        </div>

        <?php $curval = isset($prev_data['vk_note']) ? $prev_data['vk_note'] : "" ?>
      <div class="form-group">
        <label class="col-sm-1 control-label">Catatan *</label>
        <div class="col-sm-11">
          <textarea name="note_inp" id="note_inp" required class="form-control" maxlength="1000" style="height: 80px"><?php echo $curval ?>
          </textarea>
        </div>
      </div>

      </div>
      </div>
    </div>
</div>

<?php echo buttonsubmit('vendor/vpi/daftar_pekerjaan',lang('back'),lang('save')) ?>

</form>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var score_total = parseFloat($('input[name="score_ketepatan_progress"]').val()) + parseFloat($('input[name="score_mutu_pekerjaan"]').val()) + parseFloat($('input[name="score_mutu_personal"]').val()) + parseFloat($('input[name="score_pelayanan"]').val())
  $('#score_total').text(score_total);
  $('input[name="score_total"]').val(score_total)

  $('#response_inp').change(function(event) {
    if($('#response_inp option:selected').val() == 1) {

      $('.score').each(function(index, el) {
         if($(this).val() == "" || $(this).val() == 0) {
          alert($(this).attr('title')+' belum dinilai!');
          $('#response_inp').val("")
          return false;
         }
      });
    }

  });
});
</script>