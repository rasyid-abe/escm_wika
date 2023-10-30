<form class="form-horizontal">
  
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Headline</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
                <?php $curval = $perencanaan['ppm_planner']; ?>
                  <div class="row form-group">
                    <label class="col-sm-2 control-label text-right">User </label>
                    <div class="col-sm-10">
                    <input type="text" disabled class="form-control" name="user_inp" value="<?php echo $curval ?>">
                  </div>
                </div>

                <?php $curval = $perencanaan["ppm_dept_name"]; ?>
                <div class="row form-group">
                  <label class="col-sm-2 control-label text-right">Divisi/Departemen </label>
                  <div class="col-sm-10">
                    <input type="text" disabled class="form-control" name="birounit_inp" value="<?php echo $curval ?>" maxlength="10">
                  </div>
                </div>

                <!-- haqim -->
                <?php $curval = $perencanaan["ppm_type_of_plan"]; ?>
                  <div class="row form-group" style="display: none">
                    <label class="col-sm-2 control-label text-right">Jenis Rencana*</label>
                    <div>
                    <input type="hidden" name="jenis_rencana" value="<?=$perencanaan["ppm_type_of_plan"]?>">
                  </div>
                  <div class="col-sm-9">
                    <p class="form-control-static" id="kode_proyek"><?php echo strtoupper($perencanaan["ppm_type_of_plan"])?></p>
                  </div>
                </div>

                <?php if ($perencanaan["ppm_type_of_plan"] == 'rkp'): ?>
                    <div class="row form-group" id="kode_proyek_form">
                      <?php $curval = set_value("kode_proyek"); ?>
                        <label class="col-sm-2 control-label text-right">Kode SPK*</label>
                        <div class="col-sm-10">
                        <!-- <p class="form-control-static" id="kode_proyek"><php// echo $perencanaan['ppm_project_id']?></p> -->
                        <input type="text" class="form-control" name="kode_proyek" id="kode_proyek" value="<?=$perencanaan['ppm_project_id']?>" disabled>
                      </div>
                    </div> 

                    <div class="row form-group" id="nama_proyek_form">
                      <?php $curval = set_value("nama_proyek"); ?>
                        <label class="col-sm-2 control-label text-right">Nama Proyek*</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama_proyek" id="nama_proyek" value="<?=$perencanaan['ppm_project_name']?>" disabled>
                      </div>
                    </div>           
                <?php endif ?>
                
                <!-- end -->

                <?php $curval = $perencanaan["ppm_subject_of_work"]; ?>
                <div class="row form-group" style="display: none">
                  <label class="col-sm-2 control-label text-right">Nama Program </label>
                  <div class="col-sm-10">
                  <input type="text" disabled class="form-control" name="nama_rencana_pekerjaan_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = $perencanaan["ppm_scope_of_work"]; ?>
              <div class="row form-group" style="display: none">
                <label class="col-sm-2 control-label text-right">Deskripsi Rencana Pekerjaan </label>
                <div class="col-sm-10">
                <textarea class="form-control" disabled name="deskripsi_rencana_pekerjaan_inp"><?php echo $curval ?></textarea>
              </div>
            </div>

            <?php $curval = (isset($perencanaan['ppm_mata_anggaran']) && isset($perencanaan['ppm_nama_mata_anggaran'])) ? $perencanaan["ppm_mata_anggaran"]." - ".$perencanaan["ppm_nama_mata_anggaran"] : ""; ?>
            <div class="row form-group" style="display: none">
              <label class="col-sm-2 control-label text-right">Mata Anggaran</label>
              <div class="col-sm-10">
                <p class="form-control-static" id="mata_anggaran"><?php echo $curval ?></p>
              </div>
            </div>

            <?php $curval = (isset($perencanaan['ppm_sub_mata_anggaran']) && isset($perencanaan['ppm_nama_sub_mata_anggaran'])) ? $perencanaan["ppm_sub_mata_anggaran"]." - ".$perencanaan["ppm_nama_sub_mata_anggaran"] : ""; ?>
            <?php 
            if (isset($perencanaan['ppm_sub_mata_anggaran']) and substr_count($perencanaan['ppm_sub_mata_anggaran'], " , ") >= 1 ) {
                $code = explode(" , ", $perencanaan['ppm_sub_mata_anggaran']);
                $name = explode(" , ", $perencanaan['ppm_nama_sub_mata_anggaran']);
            }
            ?>
            <div class="row form-group" style="display: none">
              <label class="col-sm-2 control-label text-right">Sub Mata Anggaran</label>
              <div class="col-sm-10">
                <p class="form-control-static" id="sub_mata_anggaran"><?php
                if (isset($code)) {
                  foreach (array_combine($code, $name) as $code => $name ) {
                    echo $code.' - '.$name."<br/>";
                  }
                }else if ($perencanaan["ppm_sub_mata_anggaran"] == 0) {
                    foreach ($project_cost as $keypc => $valuepc) {
                      echo $valuepc['coa_code'].' - '.$valuepc['coa_name']."<br/>";
                    }
                  }else{
                  echo $curval;
                } 

                ?></p>
              </div>
            </div>

            <?php $curval = $perencanaan["ppm_currency"]; ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label text-right">Mata Uang </label>
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

            <?php $curval = $perencanaan["ppm_pagu_anggaran"] ?>
            <div class="row form-group">
              <label class="col-sm-2 control-label text-right">Nilai Anggaran </label>
              <div class="col-sm-4">
              <input disabled type="text" class="form-control" name="pagu_anggaran_inp" value="<?php echo inttomoney($curval) ?>">
            </div>
          </div>

          <?php $date = strlen($perencanaan["ppm_renc_pelaksanaan"])== 8 ? substr($perencanaan["ppm_renc_pelaksanaan"], 6, 2) : ""  ?>
          <?php $month = getmonthname(substr($perencanaan["ppm_renc_pelaksanaan"], 4, 2)); ?>
          <?php $year = substr($perencanaan["ppm_renc_pelaksanaan"], 0, 4); ?>
          <div class="row form-group" style="display: none">
            <label class="col-sm-2 control-label text-right">Rencana Pelaksanaan Pengadaan </label>
            <div class="col-sm-6">

              <p class="form-control-static"><?php echo $date ?> <?php echo $month ?> <?php echo $year ?></p>

            </div>
          </div>

          <?php $date = strlen($perencanaan["ppm_renc_kebutuhan"])== 8 ? substr($perencanaan["ppm_renc_kebutuhan"], 6, 2) : ""  ?>
          <?php $month = getmonthname(substr($perencanaan["ppm_renc_kebutuhan"], 4, 2)); ?>
          <?php $year = substr($perencanaan["ppm_renc_kebutuhan"], 0, 4); ?>
          <div class="row form-group" style="display: none">
            <label class="col-sm-2 control-label text-right">Rencana Kebutuhan </label>
            <div class="col-sm-6">

              <p class="form-control-static"><?php echo $date ?> <?php echo $month ?> <?php echo $year ?></p>

            </div>
          </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Item Perencanaan</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
              <table class="table table-bordered default">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Sumberdaya</th>
                    <th>Nama Sumberdaya</th>
                    <th>Satuan</th>
                    <th>Volume</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Periode Pengadaan</th>
                  </tr>
                </thead>

                <tbody>
                <?php 
                $sisa = 5;
                if(isset($item_perencanaan_pmcs) && !empty($item_perencanaan_pmcs)){
                  foreach ($item_perencanaan_pmcs as $k => $v) {
                    if(!empty($v['group_smbd_name'])){
                      ?>
                      <tr>
                        <td><?php echo $k+1 ?></td>
                        <td><?php echo $v["smbd_code"] ?></td>
                        <td><?php echo $v['smbd_name'] ?></td>
                        <td><?php echo $v['unit'] ?></td>
                        <td><?php echo inttomoney($v['smbd_quantity']) ?></td>
                        <td><?php echo $v["currency"]." ";
                                  echo inttomoney($v['price']) ?></td>
                        <td><?php echo $v["currency"]." ";
                                  echo $v['jumlah'] ?></td>
                        </a></td>
                        <td><?php echo $v['periode_pengadaan'] ?></td>
                      </tr>

                      <?php } } } ?>
                  </tbody>
                </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">History Anggaran</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
              <table class="table comment">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Anggaran Sebelumnya</th>
                    <th>Penambahan</th>
                    <th>Pengurangan</th>
                    <th>Anggaran Saat Ini</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>

                <?php
                $i = 0;
                $num = 1;
                if(isset($anggaran_list[$i]) && !empty($anggaran_list[$i])){ 
                  $last = count($anggaran_list[$i]);
                  foreach ($anggaran_list[$i] as $kc => $vc) {
                
                    $modified = ($vc['pph_date'] != null ? date(DEFAULT_FORMAT_DATETIME,strtotime($vc['pph_date'])) : null);

                    switch ($vc['pph_desc']) {
                      case 0 :
                        $act = $desc[0];
                        $url = "";
                        break;
                      case 1010 :
                        $act = $desc[1010];
                        $url = $urlpr;
                        break;
                      case 1011 :
                        $act = $desc[1010];
                        $url = $urlpr;
                        break;
                      case 1012 :
                        $act = $desc[1010];
                        $url = $urlpr;
                        break;
                      case 1000 :
                        $act = $desc[1000];
                        $url = $urlpr;
                        break;
                      case 1904 :
                        $act = $desc[1904];
                        $url = $urlpr;
                        break;
                      case 1906 :
                        $act = $desc[1904];
                        $url = $urlpr;
                        break;
                      case 1040 :
                        $act = $desc[1010]."<a href = '".$urlpr.$vc['pph_first']."' target='_blank'>".$vc['pph_first']."</a> dilanjutkan RFQ No. ";
                        $url = $urlrfq;
                        break;
                      case 1902 :
                        $act = $desc[1040];
                        $url = $urlrfq;
                        break;
                      case 2010 :
                        $act = $desc[2010];
                        $url = $urlrfq;
                        break;
                      default:
                        $act = "";
                        $url = "";
                        break;
                    }


                  ?>
                    <tr>
                      <td><center><?php echo $num++ ?></center></td>
                      
                      <td><?php echo $modified?></td>
                      
                      <td> 
                        <?php 
                        echo $perencanaan["ppm_currency"]." ";
                        echo inttomoney($vc['pph_main']) ?>
                      </td>
                      
                      <td> 
                        <?php
                        echo $perencanaan["ppm_currency"]." ";
                        echo inttomoney($vc['pph_plus']) ?>
                      </td>
                      
                      <td> 
                        <?php 
                        echo $perencanaan["ppm_currency"]." ";
                        echo inttomoney($vc['pph_min']) ?>
                      </td>

                      <td> 
                        <?php 
                        echo $perencanaan["ppm_currency"]." ";
                        echo inttomoney($vc['pph_remain']) ?>
                      </td>
                      
                      <td><?php 

                      echo $act;
                      echo " <a href= ".$url.$vc['pph_mod']." target='_blank' >".$vc['pph_mod']."</a>" ;

                      ?></td>
                    </tr>
                <?php } } ?>
                </tbody>
              </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Histori Volume</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
              <div class="table-responsive">
                  <table id="table_history_volume" class="table table-bordered table-striped"></table>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Lampiran</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
              <table class="table table-bordered default">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kategori</th>
                  <th>Deskripsi</th>
                  <th>File</th>
                </tr>
              </thead>

              <tbody>
              <?php 
              $sisa = 5;
              if(isset($document) && !empty($document)){
                foreach ($document as $k => $v) {
                  if(!empty($v['ppd_file_name'])){
                    ?>
                    <tr>
                      <td><?php echo $k+1 ?></td>
                      <td><?php echo $v["ppd_category"] ?></td>
                      <td><?php echo $v['ppd_description'] ?></td>
                      <td><a href="<?php echo site_url('log/download_attachment/procurement/perencanaan/'.$v['ppd_file_name']) ?>" target="_blank">
                      <?php echo $v['ppd_file_name'] ?>
                      </a></td>
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

  <div class="card">				
    <div class="card-content">
      <div class="card-body">			        
        <?php echo buttonback('procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan',lang('back')) ?>
      </div>
    </div>
  </div>

</form>


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
    var link = "<?php echo site_url('procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan') ?>";
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
    var total_price = 0;
    $.each(data, function (i, row) {
      total_price += +(row.price.substring(1));
    });
    return '$' + total_price;
  }

</script>

<script type="text/javascript">

  var $table_history_volume = $('#table_history_volume'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_history_volume.bootstrapTable({

      url: "<?php echo site_url('Procurement/perencanaan_pengadaan/history_volume').'?id='.$this->uri->segment(5) ?>",
      cookieIdTable:"monitor_pengadaan",
      idField:"ptm_number",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'no',
        title: 'No',
        align: 'center',
        width:'10%',
        valign: 'middle'
      },
     {
        field: 'ppv_main',
        title: 'Volume Awal',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      }, {
        field: 'ppv_plus',
        title: 'Penambahan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'ppv_minus',
        title: 'Pengurangan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'ppv_remain',
        title: 'Volume Saat Ini',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'ppv_smbd_code',
        title: 'Kode Sumberdaya',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'smbd_name',
        title: 'Nama Sumberdaya',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      },
      {
        field: 'ppv_unit',
        title: 'Unit',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'status',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      },
      ]

    });
    setTimeout(function () {
      $table_history_volume.bootstrapTable('resetView');
    }, 200);

    $table_history_volume.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias"));
    });

  });

</script>

