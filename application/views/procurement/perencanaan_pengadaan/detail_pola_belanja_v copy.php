<div class="wrapper wrapper-content animated fadeInRight">
  <form class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>HEADLINE</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">

            <?php $curval = $pola_belanja[0]['ppm_planner']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">User </label>
              <div class="col-sm-10">
               <input type="text" disabled class="form-control" name="user_inp" value="<?php echo $curval ?>">
             </div>
           </div>

           <?php $curval = $pola_belanja[0]["ppm_dept_name"]; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Divisi/Departemen </label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" name="birounit_inp" value="<?php echo $curval ?>" maxlength="10">
            </div>
          </div>

          <!-- haqim -->
           <?php $curval = $pola_belanja[0]["ppm_type_of_plan"]; ?>
            <div class="form-group" style="display: none">
              <label class="col-sm-2 control-label">Jenis Rencana*</label>
              <div>
              <input type="hidden" name="jenis_rencana" value="<?=$pola_belanja[0]["ppm_type_of_plan"]?>">
             </div>
             <div class="col-sm-9">
               <p class="form-control-static" id="kode_proyek"><?php echo strtoupper($pola_belanja[0]["ppm_type_of_plan"])?></p>
             </div>
           </div>

           <?php if ($pola_belanja[0]["ppm_type_of_plan"] == 'rkp'): ?>
              <div class="form-group" id="kode_proyek_form">
                <?php $curval = set_value("kode_proyek"); ?>
                  <label class="col-sm-2 control-label">Kode SPK*</label>
                  <div class="col-sm-10">
                   <!-- <p class="form-control-static" id="kode_proyek"><php// echo $pola_belanja[0]['ppm_project_id']?></p> -->
                   <input type="text" class="form-control" name="kode_proyek" id="kode_proyek" value="<?=$pola_belanja[0]['ppm_project_id']?>" disabled>
                 </div>
               </div> 

              <div class="form-group" id="nama_proyek_form">
                <?php $curval = set_value("nama_proyek"); ?>
                  <label class="col-sm-2 control-label">Nama Proyek*</label>
                  <div class="col-sm-10">
                   <input type="text" class="form-control" name="nama_proyek" id="nama_proyek" value="<?=$pola_belanja[0]['ppm_project_name']?>" disabled>
                 </div>
               </div>           
           <?php endif ?>
           
           <!-- end -->

          <?php $curval = $pola_belanja[0]["ppm_subject_of_work"]; ?>
          <div class="form-group" style="display: none">
            <label class="col-sm-2 control-label">Nama Program </label>
            <div class="col-sm-10">
             <input type="text" disabled class="form-control" name="nama_rencana_pekerjaan_inp" value="<?php echo $curval ?>">
           </div>
         </div>

         <?php $curval = $pola_belanja[0]["ppm_scope_of_work"]; ?>
         <div class="form-group" style="display: none">
          <label class="col-sm-2 control-label">Deskripsi Rencana Pekerjaan </label>
          <div class="col-sm-10">
           <textarea class="form-control" disabled name="deskripsi_rencana_pekerjaan_inp"><?php echo $curval ?></textarea>
         </div>
       </div>

       <?php $curval = (isset($pola_belanja[0]['ppm_mata_anggaran']) && isset($pola_belanja[0]['ppm_nama_mata_anggaran'])) ? $pola_belanja[0]["ppm_mata_anggaran"]." - ".$pola_belanja[0]["ppm_nama_mata_anggaran"] : ""; ?>
       <div class="form-group" style="display: none">
        <label class="col-sm-2 control-label">Mata Anggaran</label>
        <div class="col-sm-10">
          <p class="form-control-static" id="mata_anggaran"><?php echo $curval ?></p>
        </div>
      </div>

      <?php $curval = (isset($pola_belanja[0]['ppm_sub_mata_anggaran']) && isset($pola_belanja[0]['ppm_nama_sub_mata_anggaran'])) ? $pola_belanja[0]["ppm_sub_mata_anggaran"]." - ".$pola_belanja[0]["ppm_nama_sub_mata_anggaran"] : ""; ?>
      <?php 
       if (isset($pola_belanja[0]['ppm_sub_mata_anggaran']) and substr_count($pola_belanja[0]['ppm_sub_mata_anggaran'], " , ") >= 1 ) {
           $code = explode(" , ", $pola_belanja[0]['ppm_sub_mata_anggaran']);
           $name = explode(" , ", $pola_belanja[0]['ppm_nama_sub_mata_anggaran']);
       }
      ?>
      <div class="form-group" style="display: none">
        <label class="col-sm-2 control-label">Sub Mata Anggaran</label>
        <div class="col-sm-10">
          <p class="form-control-static" id="sub_mata_anggaran"><?php
          if (isset($code)) {
            foreach (array_combine($code, $name) as $code => $name ) {
              echo $code.' - '.$name."<br/>";
            }
           }else if ($pola_belanja[0]["ppm_sub_mata_anggaran"] == 0) {
               foreach ($project_cost as $keypc => $valuepc) {
                 echo $valuepc['coa_code'].' - '.$valuepc['coa_name']."<br/>";
               }
             }else{
            echo $curval;
           } 

          ?></p>
        </div>
      </div>

      <?php $curval = $pola_belanja[0]["ppm_currency"]; ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Mata Uang </label>
        <div class="col-sm-2">
         <select disabled class="form-control" name="mata_uang_inp">
          <option value=""><?php echo lang('choose') ?></option>
          <?php foreach($default_currency as $key => $val){
            $selected = ($key == $curval) ? "selected" : ""; 
            ?>
            <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <?php $curval = $pola_belanja[0]["ppm_pagu_anggaran"] ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Nilai Anggaran </label>
        <div class="col-sm-4">
         <input disabled type="text" class="form-control" name="pagu_anggaran_inp" value="<?php echo inttomoney($curval) ?>">
       </div>
     </div>

     <?php $date = strlen($pola_belanja[0]["ppm_renc_pelaksanaan"])== 8 ? substr($pola_belanja[0]["ppm_renc_pelaksanaan"], 6, 2) : ""  ?>
    <?php $month = getmonthname(substr($pola_belanja[0]["ppm_renc_pelaksanaan"], 4, 2)); ?>
    <?php $year = substr($pola_belanja[0]["ppm_renc_pelaksanaan"], 0, 4); ?>
    <div class="form-group" style="display: none">
      <label class="col-sm-2 control-label">Rencana Pelaksanaan Pengadaan </label>
      <div class="col-sm-6">

        <p class="form-control-static"><?php echo $date ?> <?php echo $month ?> <?php echo $year ?></p>

      </div>
    </div>

     <?php $date = strlen($pola_belanja[0]["ppm_renc_kebutuhan"])== 8 ? substr($pola_belanja[0]["ppm_renc_kebutuhan"], 6, 2) : ""  ?>
    <?php $month = getmonthname(substr($pola_belanja[0]["ppm_renc_kebutuhan"], 4, 2)); ?>
     <?php $year = substr($pola_belanja[0]["ppm_renc_kebutuhan"], 0, 4); ?>
     <div class="form-group" style="display: none">
      <label class="col-sm-2 control-label">Rencana Kebutuhan </label>
      <div class="col-sm-6">

        <p class="form-control-static"><?php echo $date ?> <?php echo $month ?> <?php echo $year ?></p>

      </div>
    </div>

  </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>ITEM PERENCANAAN</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

       <table class="table table-bordered" id="item_table">
        <thead>
            <tr>		
              <th rowspan="2"><center>KODE</center></br><center>SUMBERDAYA</center></th>
              <th rowspan="2"><center>NAMA</center></br><center>SUMBERDAYA</center></th>
              <th rowspan="2"><center>SATUAN</center></br><center>{UOM}</center></th>
              <th colspan="3"><center>RAB</center></th>
              <?php 
				        foreach ($item_periode_pmcs as $k => $prd) { ?>
					        <th><center><?php echo $prd['periode_pengadaan']."" ?></center></th>
				      <?php }	?>
            </tr>
            <tr>
              <th><center>VOLUME</center></th>
              <th><center>HARSAT</center></th>
              <th><center>JUMLAH</center></th>
              <?php 
              $isi = 1;
              foreach ($item_periode_pmcs as $ky => $val) {?>
                
                  <th><center><?php echo $isi; ?></center></th>

                <?php 
                $isi++;
              } ?>
            </tr>
        </thead>
      
        <tbody>
         <?php
         if(isset($item_perencanaan_pmcs) && !empty($item_perencanaan_pmcs)){
          foreach ($item_perencanaan_pmcs as $k => $v) {
            if(!empty($v['group_smbd_name'])){
              ?>
              <tr>
                <td><?php echo $v["smbd_code"] ?></td>
                <td><?php echo $v['smbd_name'] ?></td>
                <td><?php echo $v['unit'] ?></td>
                <td><?php echo inttomoney($v['ppv_remain']) ?></td>
                <td><?php echo $v["currency"]." ";
                          echo inttomoney($v['price']) ?></td>
                <td><?php echo $v["currency"]." ";
                          echo inttomoney($v['jumlah']) ?></td>
                </a></td>
				<?php
					foreach ($item_periode_pmcs as $p => $prd) {?>
					<td><center><?php echo inttomoney($prd['smbd_quantity']) ?></center></td>
					<?php }?>
              </tr>

              <?php } } } ?>
            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>
</div>


     <?php 
     $i = 0;
     include(VIEWPATH."/comment_view_v.php") ?>

     <?php echo buttonback('procurement/perencanaan_pengadaan/daftar_pola_belanja',lang('back')) ?>


   </form>
 </div>


<script type="text/javascript">


  jQuery.extend({
    getCustomJSON: function(url) {
      var result = null;
      $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(data) {
          result = data;
        }
      });
      return result;
    }
  });

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('Procurement') ?>/"+url);

    var html = [];
    $.each(row, function (key, value) {
     var data = $.grep(mydata, function(e){ 
       return e.field == key; 
     });

     if(typeof data[0] !== 'undefined'){

       html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
     }
   });

    return html.join('');

  }

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/perencanaan_pengadaan/daftar_pola_belanja') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/lihat/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

  function totalTextFormatter(data) {
    return 'Total';
  }
  function totalNameFormatter(data) {
    return data.length;
  }
  function totalPriceFormatter(data) {
    var total = 0;
    $.each(data, function (i, row) {
      total += +(row.price.substring(1));
    });
    return '$' + total;
  }

</script>


