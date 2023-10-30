<div class="wrapper wrapper-body animated fadeInRight">

<form method="post" action="<?php echo site_url($controller_name."/vpi/daftar_pekerjaan/penilaian_vpi/".$vvh_id."/barang/submit_kompilasi");?>"  class="form-horizontal">

<div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
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
                <div class="col-sm-10">
                 <p class="form-control-static">
                <input type="hidden" name="date_inp" class="form-control" value="<?php echo $vvh_data['vvh_date'] ?>">
                  <?php echo $vvh_data['vvh_date_text'] ?>
                 </p>
               </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Tipe</label>
                <div class="col-sm-10">
                 <p class="form-control-static">
                <input type="hidden" name="date_inp" class="form-control" value="<?php echo $vvh_data['vvh_date'] ?>">
                  <?php echo ucfirst($vvh_data['vvh_tipe']) ?>
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
          <h5 class="card-title">Penilaian Penyedia Barang</h5>
          
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
                <a class="btn btn-xs btn-primary" href="<?php echo current_url().'/'.'barang/ketepatan_progress' ?>">
                Nilai
              </a></td>
              <td rowspan ="2" style="vertical-align: middle;">Performance</td>
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
                    <?php $score_ketepatan_progress =  isset($nilai_ketepatan_progress) ? replace_comma((int)$nilai_ketepatan_progress) * replace_comma((int)$data_bobot['bobot_ketepatan_progress']) : 0;
                          echo inttomoney($score_ketepatan_progress);
                          $curval = isset($kompilasi_score['ketepatan_progress']) ? $kompilasi_score['ketepatan_progress'] : "0"; 
                           ?>
                    <input type="hidden" name="score_ketepatan_progress" class="score" value="<?php echo $score_ketepatan_progress ?>" title="Score Ketepatan Progress">
                    <input type="hidden" name="ketepatan_progress_id"  value="<?php echo $curval ?>" >
              </td>
            </tr>
            <tr>
              <td>
                <a class="btn btn-xs btn-primary" href="<?php echo current_url().'/'.'barang/mutu_pekerjaan' ?>">
                  Nilai
                </a>
              </td>
              <td>
                Hasil Mutu Pekerjaan
              </td>
              <td>
                  <?php echo $data_bobot['target_hasil_mutu_pekerjaan'] ?>
              </td>
              <td>
                  <?php echo $data_bobot['bobot_hasil_mutu_pekerjaan'] ?>
                </td>
              <td id="nilai_hasil_mutu_pekerjaan">
                <?php echo isset($nilai_mutu_pekerjaan) ? $nilai_mutu_pekerjaan : ""; ?>
              </td>
              <td id="score_hasil_mutu_pekerjaan">

                <?php $score_hasil_mutu_pekerjaan =  isset($nilai_mutu_pekerjaan) ? replace_comma((int)$nilai_mutu_pekerjaan) * replace_comma((int)$data_bobot['bobot_hasil_mutu_pekerjaan']) : "";
                echo inttomoney($score_hasil_mutu_pekerjaan); 
                $curval = isset($kompilasi_score['hasil_mutu_pekerjaan']) ? $kompilasi_score['hasil_mutu_pekerjaan'] : ""; ?>

                    <input type="hidden" class="score" name="score_hasil_mutu_pekerjaan" value="<?php echo $score_hasil_mutu_pekerjaan ?>" title="Score Hasil Mutu Pekerjaan">

                    <input type="hidden" name="mutu_pekerjaan_id"  value="<?php echo $curval ?>" >

              </td>
            </tr>
            <tr>
              <td rowspan="2" style="vertical-align: middle;">
                <a class="btn btn-xs btn-primary" href="<?php echo current_url().'/'.'barang/k3ldan5r' ?>">
                  Nilai
                </a>
              </td>
              <td rowspan ="2" style="vertical-align: middle;">K3L / 5R</td>
              <td>
                  K3L
              </td>
              <td>
                  <?php echo $data_bobot['target_k3l'] ?>
              </td>
              <td>
                  <?php echo $data_bobot['bobot_k3l'] ?>
              </td>
              <td id="nilai_k3l">
                <?php echo isset($nilai_k3l) ? floor($nilai_k3l) : ""; ?>
              </td>
              <td id="score_k3l">
                <?php $score_k3l = isset($nilai_k3l) ? replace_comma((int)$nilai_k3l) * replace_comma((int)$data_bobot['bobot_k3l']) : ""; 
                echo inttomoney($score_k3l);
                $curval = isset($kompilasi_score['k3l']) ? $kompilasi_score['k3l'] : ""; ?>
                <input type="hidden" class="score" name="score_k3l" title="Score K3L" value="<?php echo $score_k3l  ?>">
                <input type="hidden" name="k3l_id"  value="<?php echo $curval ?>" >
              </td>
            </tr>
            <tr>
              <td>
                  5R
              </td>
              <td>
                  <?php echo $data_bobot['target_5r'] ?>    
              </td>
              <td>
                  <?php echo $data_bobot['bobot_5r'] ?>
              </td>
              <td id="nilai_5r">
                <?php echo isset($nilai_5r) ? floor($nilai_5r) : ""; ?>
              </td>
              <td id="score_5r">
                <?php $score_5r = isset($nilai_5r) ? replace_comma((int)$nilai_5r) * replace_comma((int)$data_bobot['bobot_5r']) : "";
                 echo inttomoney($score_5r);
                $curval = isset($kompilasi_score['5r']) ? $kompilasi_score['5r'] : "";  ?>
                <input type="hidden" class="score" name="score_5r"  title="Score 5R" value="<?php echo $score_5r  ?>">
                <input type="hidden" name="id_5r"  value="<?php echo $curval ?>" >
              </td>
            </tr>
            <tr>
              <td>
                <a class="btn btn-xs btn-primary" href="<?php echo current_url().'/'.'barang/pengamanan' ?>">
                  Nilai
                </a>
              </td>
              <td>Pengamanan</td>
              <td>
                  Pengamanan
              </td>
              <td>
                  <?php echo $data_bobot['target_pengamanan'] ?>
              </td>
              <td>
                  <?php echo $data_bobot['bobot_pengamanan'] ?>
              </td>
              <td id="nilai_pengamanan">
                <?php echo isset($nilai_pengamanan) ? $nilai_pengamanan : ""; ?>
              </td>
              <td id="score_pengamanan">
                <?php $score_pengamanan =  isset($nilai_pengamanan) ? replace_comma((int)$nilai_pengamanan) * replace_comma((int)$data_bobot['bobot_pengamanan']) : "";
                  echo inttomoney($score_pengamanan);
                  $curval = isset($kompilasi_score['pengamanan']) ? $kompilasi_score['pengamanan'] : "";  ?>  
                <input type="hidden" class="score" title="Score Pengamanan" name="score_pengamanan" value="<?php echo $score_pengamanan ?>">
                <input type="hidden" name="pengamanan_id"  value="<?php echo $curval ?>" >
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

<?php //include('parameter_penilaian_barang_dan_jasa_v.php') ?>

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

<?php echo buttonsubmit('vendor/vpi/aspek_penilaian_pelayanan',lang('back'),lang('save')) ?>

</form>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var score_total = parseFloat($('input[name="score_ketepatan_progress"]').val()) + parseFloat($('input[name="score_hasil_mutu_pekerjaan"]').val()) + parseFloat($('input[name="score_k3l"]').val()) + parseFloat($('input[name="score_5r"]').val())+ parseFloat($('input[name="score_pengamanan"]').val())
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