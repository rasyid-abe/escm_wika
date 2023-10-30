<style>
  .disabled-button-wrapper {
  display: inline-block; /* display: block works as well */
  }

  .disabled-button-wrapper  .btn[disabled] {
  /* don't let button block mouse events from reaching wrapper */
  pointer-events: none;
  }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Template Aspek Penilaian Pelayanan</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>

        <div class="card-content">

          <div class="table-responsive">

          <!-- Button trigger modal -->
          <div class="input-group-btn" style="margin-bottom: -45px;">

            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_add_pertanyaan">
              <i class="ft-file-text"></i> Tambah
            </button>

            <div class="disabled-button-wrapper" data-title="Pilih Data Dulu">
              <button id="activate" disabled type="button" class="btn btn-success">
                <i class="ft-power"></i> Aktifkan
              </button>
            </div>
            <div class="disabled-button-wrapper" data-title="Pilih Data Dulu">
              <button id="remove" disabled type="button" class="btn btn-danger">
                <i class="ft-power"></i> Nonaktifkan
              </button>
            </div>
            <a href="<?= site_url('administration/template_vpi/penilaian_penyedia_barang/hasil_mutu_pekerjaan/5r') ?>" disabled type="button" class="btn btn-info">
              <i class="ft-refresh-cw"></i> Reset
            </a>

          </div>

            <table id="aspek_penilaian_pelayanan" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>


    </div>
  </div>
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

    var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/"+url);

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
    var link = "<?php echo site_url('administration/admin_tools/position') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/nonaktif/'+value+'">',
    'Nonaktifkan',
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

  var $table = $('#aspek_penilaian_pelayanan'),
  $remove = $('#remove'),
  $activate = $('#activate'),
  selections = [];


</script>

<script type="text/javascript">

  $(function () {

    $table.bootstrapTable({

      url: "<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/data_pelayanan') ?>",
      cookieIdTable:"adm_aspek_penilaian_pelayanan",
      idField:"app_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
        {
        field: 'checkbox',
        checkbox:true,
        align: 'center',
        valign: 'middle'
      },{
        field: 'app_seq',
        title: 'Urutan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '5%',
        editable: {
          placement: 'right',
          type:  'text',
          // name:  'urutan_inp',
          validate: function(v) {
              if(!v){ return 'Required field!'}
                else{
                  $.ajax({
                  url: "<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/update?key=urutan&data=') ?>"+v,
                  type:"get"
                });

              };
          },

        },
      },
      {
        field: 'app_value',
        title: 'Pertanyaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
      },
      {
        field: 'app_status_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '5px',
      },
      {
        field: 'created_datetime',
        title: 'Created date',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '20%',
      },
      {
        field: 'updated_datetime',
        title: 'Updated date',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '20%',
      },
      ]

    });
setTimeout(function () {
  $table.bootstrapTable('resetView');
}, 200);

$table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_position"));
});

$('.disabled-button-wrapper').tooltip();

$table.on('check.bs.table  check-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
  $activate.prop('disabled', !$table.bootstrapTable('getSelections').length);
  $('.disabled-button-wrapper').tooltip('disable');

  selections = getIdSelections();
  var param = "";
  var selected = "";
  $.each(selections,function(i,val){
    param += val+"=1&";
    selected = val;
  });
  $.ajax({
    url:"<?php echo site_url('Administration/selection/selection_aspek_penilaian_pelayanan') ?>",
    data:param,
    type:"get"
  });

  //set session app_id
  $.ajax({
    url:"<?php echo site_url('administration/set_session/app_id') ?>"+'/'+selected,
    type:"get"
  });

});
$table.on('uncheck.bs.table uncheck-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
  $activate.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();

  var param = "";
  $.each(selections,function(i,val){
    param += val+"=0&";
  });
  $.ajax({
    url:"<?php echo site_url('Administration/selection/selection_aspek_penilaian_pelayanan') ?>",
    data:param,
    type:"get"
  });
});
$table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row));

});
$table.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});
$remove.click(function () {
  var ids = getIdSelections();
  $table.bootstrapTable('remove', {
    field: 'id',
    values: ids
  });
  $remove.prop('disabled', true);
});

$activate.click(function () {
  var ids = getIdSelections();
  $table.bootstrapTable('remove', {
    field: 'id',
    values: ids
  });
  $activate.prop('disabled', true);
});
function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
    return row.app_id
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.app_id, selections) !== -1;
  });
  return res;
}


});



</script>

<!-- Modal -->
<div class="modal fade" id="modal_add_pertanyaan" tabindex="-1" role="dialog" aria-labelledby="modal_add_pertanyaanLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_add_pertanyaanLabel">Tambah Pertanyaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </button>
      </div>
      <form method="post" action="<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/submit_add') ?>" id="app_form" >
      <div class="modal-body">

        <div id="pertanyaan_inp">
        <div class="col-md-11">
          <input type="text" class="form-control" placeholder="Pertanyaan" name="pertanyaan_inp[0]" data-no="0" required="required"/>
        </div>
        <button disabled type="button" class="btn btn-primary">
        <span class="glyphicon glyphicon-trash"></span></button>
        <br><br>
        </div>
        <div class="col-md-11">
          <button type="button" class="btn btn-primary" id="tambah-btn">Tambah</button>
          <button type="button" class="btn btn-primary" id="reset-btn">Reset</button>
        </div>
        <br><br>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="tutup-btn" data-dismiss="modal">Tutup</button>
        <input type="submit" value="Simpan" class="btn btn-primary" id="simpan-btn">
        <!-- <button type="button" class="btn btn-primary" id="simpan-btn">Simpan</button> -->
      </div>
       </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var no = 1;
    $('#tambah-btn').click(function() {
      var html = ''
      html += '<span id="span_'+no+'">'
      html += '<div class="col-md-11">'
      html += ' <input type="text" class="form-control" placeholder="Pertanyaan" name="pertanyaan_inp['+ no +']" data-no="'+no+'" required>'
      html += ' </div>'
      html += '<button type="button" class="btn btn-primary hapus-btn" data-no="'+no+'">'
      html += '<span class="glyphicon glyphicon-trash"></span></button>'
      html += '<br><br>'
      html += '</span>'
      $('#pertanyaan_inp').append(html)
      no = no+1;

          $('button.hapus-btn').click(function() {
            var this_no = $(this).data('no')
            $('#span_'+this_no).remove()
          });

    });

    $('#reset-btn').click(function() {
      reset()
    });

     $('#tutup-btn').click(function() {
      reset()
    });

     $('#modal_add_pertanyaan').on('hidden.bs.modal', function () {
      reset()
    })

    function reset(){
      no = 1;
      var html = ''
      html += '<div class="col-md-11">'
      html += ' <input type="text" class="form-control" placeholder="Pertanyaan" name="pertanyaan_inp[0]" data-no="0" required>'
      html += ' </div>'
      html += '<button disabled type="button" class="btn btn-primary">'
      html += '<span class="glyphicon glyphicon-trash"></span></button>'
      html += '<br><br>'
      $('#pertanyaan_inp').html(html)
    }

    $('#app_form').submit(function(e) {
       e.preventDefault(); // avoid to execute the actual submit of the form.
      $('#app_form').ajaxSubmit({
        url: '<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/submit_add') ?>',
        type: 'post',
        success: function(msg){
          alert(msg)
          reset();
          $table.bootstrapTable('refresh');
        }
      })
    });

   $remove.click(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
           $.ajax({
                 type: "POST",
                 url: "<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/nonaktif');?>",
                 success: function(data)
                 {
                     alert(data); // show response from the php script.
                     $table.bootstrapTable('refresh');
                     $activate.prop('disabled', true);
                 }
               });

   });

      $activate.click(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
           $.ajax({
                 type: "POST",
                 url: "<?php echo site_url('administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/aktifkan');?>",
                 success: function(data)
                 {
                     alert(data); // show response from the php script.
                     $table.bootstrapTable('refresh');
                     $remove.prop('disabled', true);
                 }
               });

   });

  });
</script>
