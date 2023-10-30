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

          <?php $curval = $perencanaan['phc_id']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">No CAR </label>
              <div class="col-sm-10">
               <input type="text" disabled class="form-control" name="id_inp" value="<?php echo $curval ?>">
             </div>
           </div>

            <?php $curval = $perencanaan['phc_name']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama Pengadaan </label>
              <div class="col-sm-10">
               <input type="text" disabled class="form-control" name="name_inp" value="<?php echo $curval ?>">
             </div>
           </div>
          
           <?php $curval = $perencanaan["phc_type"]; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Tipe Pengadaan </label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" name="type_inp" value="<?php echo $curval ?>" maxlength="10">
            </div>
          </div>

           <?php $curval = $perencanaan["dept_name"]; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Divisi/Departemen </label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" name="departemen_inp" value="<?php echo $curval ?>" maxlength="10">
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
        <h5>LAMPIRAN</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

       <table class="table table-bordered default">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama File</th>
            <th>File</th>
          </tr>
        </thead>

        <tbody>
         <?php 
         $sisa = 5;
         if(isset($document) && !empty($document)){
          foreach ($document as $k => $v) {
            if(!empty($v['phd_file_name'])){
              ?>
              <tr>
                <td><?php echo $k+1 ?></td>
                <td><?php echo $v['phd_desc'] ?></td>
                <td><a href="<?php echo site_url('log/download_attachment/procurement/perencanaan/'.$v['phd_file_name']) ?>" target="_blank">
                <?php echo $v['phd_file_name'] ?>
                </a></td>
              </tr>

              <?php } } } ?>
            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>

     <?php $i = 0; ?>
     <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>History Progress</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">

            <table class="table comment">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Aktifitas</th>
                  <th>User Update</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($progress as $kc => $vc) { ?>
                <tr>
                  <td><?php echo $vc['hcp_start_date'] ?></td>
                  <td><?php echo $vc['hcp_activity']  ?></td>
                  <td><?php echo $vc['hcp_user_update'] ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
     <?php echo buttonback('procurement/perencanaan_pengadaan/daftar_history_car',lang('back')) ?>


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
    var total = 0;
    $.each(data, function (i, row) {
      total += +(row.price.substring(1));
    });
    return '$' + total;
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

