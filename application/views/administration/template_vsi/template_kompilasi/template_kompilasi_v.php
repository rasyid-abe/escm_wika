<style>
  .bootstrap-table {
    margin-top: 0px;
  }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <!-- <h5>Template Kuesioner Kepuasan Vendor</h5> -->
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>

        <div class="card-content">

          <div class="table-responsive">
            <table id="template_kompilasi" class="table table-bordered table-striped"></table>
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
    var link = "<?php echo site_url('administration/template_vsi') ?>";
    return [
    '<a class="btn btn-info btn-xs action" href="'+link+'/template_kompilasi/lihat/'+value+'">',
    '<i class="ft-eye mr-1"></i>Lihat Hasil',
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

  var $table = $('#template_kompilasi'),
  $remove = $('#remove'),
  selections = [];


</script>

<script type="text/javascript">

  $(function () {

    $table.bootstrapTable({

      url: "<?php echo site_url('administration/template_vsi/template_kompilasi/data/aktif') ?>",
      cookieIdTable:"adm_vsi_template_kompilasi",
      idField:"template_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'template_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'15%',
        formatter: operateFormatter,
      },
      {
        field: 'atk_name',
        title: 'Nama Template',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '55%',
        // editable: {
        //   placement: 'right',
        //   type:  'text',
        //   // name:  'urutan_inp',
        //   validate: function(v) {
        //       if(!v){ return 'Required field!'}
        //         else{
        //           $.ajax({
        //           url: "<?php echo site_url('administration/template_vsi/template_kompilasi/update?key=atk_name&data=') ?>"+v,
        //           type:"get"
        //         });

        //       };
        //   },

        // },
      },
       {
        field: 'periode',
        title: 'Periode',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '30%',
      },
 /*     {
        field: 'atk_status',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '5%',
        // editable: {
        //   placement: 'right',
        //   type:  'text',
        //   // name:  'urutan_inp',
        //   validate: function(v) {
        //       if(!v){ return 'Required field!'}
        //         else{
        //           $.ajax({
        //           url: "<?php echo site_url('administration/template_vsi/template_kompilasi/update?key=category&data=') ?>"+v,
        //           type:"get"
        //         });

        //       };
        //   },

        // },
      },
      {
        field: 'created_datetime',
        title: 'Created date',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '13%',
      },
      {
        field: 'updated_datetime',
        title: 'Update date',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width: '13%',
      },
      {
        field: 'checkbox',
        checkbox:true,
        align: 'center',
        valign: 'middle',
      },
      */
      ]

    });
setTimeout(function () {
  $table.bootstrapTable('resetView');
}, 200);

$table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_position"));
});

  $table.on('check.bs.table  check-all.bs.table', function () {
  // $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  // selections = getIdSelections();
  // var param = "";
  // $.each(selections,function(i,val){
  //   param += val+"=1&";
  // });
  // $.ajax({
  //   url:"<?php echo site_url('Administration/selection/selection_template_kompilasi') ?>",
  //   data:param,
  //   type:"get"
  // });

  //set session template_id
  $.ajax({
    url:"<?php echo site_url('administration/set_session/template_id') ?>"+'/'+getIdSelections(),
    type:"get"
  });

});
$table.on('uncheck.bs.table uncheck-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();

  var param = "";
  $.each(selections,function(i,val){
    param += val+"=0&";
  });
  $.ajax({
    url:"<?php echo site_url('Administration/selection/selection_template_kompilasi') ?>",
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

function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
    return row.template_id
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.template_id, selections) !== -1;
  });
  return res;
}


});



</script>

<!-- Modal -->
<div class="modal fade" id="modal_add_tempalte" tabindex="-1" role="dialog" aria-labelledby="modal_add_tempalteLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered modal-lg" class="overflow-y: initial !important" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_add_tempalteLabel">Tambah Template</h4>
        </button>
      </div>
      <form method="post" action="<?php
      echo site_url('administration/template_vsi/template_kompilasi/submit_add') ?>"
      id="app_form" >
      <div class="modal-body" style="height: 300px;overflow-y: auto;">

        <div id="form_template">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Template Ke-1" name="name_inp[0]" data-no="0" required="required"/>
        </div>

        <div style="text-align: center;">
          <button style="align-content: center;" disabled type="button" class="btn btn-primary">
            <!-- <span class="glyphicon glyphicon-trash"></span> -->
            Hapus
          </button>
        </div>
        <hr>
        </div>
        <div class="col-md-11">
          <button type="button" class="btn btn-primary" id="tambah-btn">Tambah</button>
          <button type="button" class="btn btn-primary" id="reset-btn">Reset</button>
        </div>
        <!-- <br><br> -->


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
    var scroll = 200;
    $('#tambah-btn').click(function() {
      var html = ''
      html += '<span id="span_'+no+'">'
      html += '<div class="form-group">'
      html += '<input type="text" class="form-control" placeholder="Template Ke-'+(no+1)+'" name="name_inp['+no+']" data-no="'+no+'" required="required"/>'
      html += '</div>'
      html += '<div class="form-group">'
      // html += '<input type="text" class="form-control" placeholder="Penjelasan" name="note_inp[0]" data-no="0" required="required"/>'
      // html += '<textarea class="form-control" rows="3" placeholder="Pertanyaan Ke-'+(no+1)+'" name="quest_inp['+no+']" data-no="'+no+'" required="required"></textarea>'
      html += '</div>'
      html += '<div style="text-align: center;">'
      html += '<button style="align-content: center;" type="button" class="btn btn-primary hapus-btn" data-no="'+no+'">'
      html += 'Hapus'
      html += '</button>'
      html += '</div>'
      // html += '<br><br>'
      html += '</span>'
      $('#form_template').append(html)

      $('input[name="category_inp['+no+']"]').focus();
      $('.modal-body').scrollTop(scroll);

      scroll = scroll+200
      no = no+1;

          $('button.hapus-btn').click(function() {
            var this_no = $(this).data('no')
            $('#span_'+this_no).remove()
          });

      // $('input[name="category_inp['+no+']"]').scrollTop($('.modal-body').height())

    });

    $('#reset-btn').click(function() {
      reset()
    });

     $('#tutup-btn').click(function() {
      reset()
    });

     $('#modal_add_tempalte').on('hidden.bs.modal', function () {
      reset()
    })

    function reset(){
      no = 1;
      var html = ''
      html += '<span id="span_0">'
      html += '<div class="form-group">'
      html += '<input type="text" class="form-control" placeholder="Template Ke-1" name="name_inp[0]" data-no="0" required="required"/>'
      html += '</div>'
      html += '<div class="form-group">'
      // html += '<input type="text" class="form-control" placeholder="Penjelasan" name="note_inp[0]" data-no="0" required="required"/>'
      // html += '<textarea class="form-control" rows="3" placeholder="Pertanyaan Ke-1" name="quest_inp[0]" data-no="0" required="required"></textarea>'
      html += '</div>'
      html += '<div style="text-align: center;">'
      html += '<button disabled style="align-content: center;" disabled type="button" class="btn btn-primary">'
      html += 'Hapus'
      html += '</button>'
      html += '</div>'
      // html += '<br><br>'
      html += '</span>'
      $('#form_template').html(html)
      scroll=200;
    }

    $('#app_form').submit(function(e) {
       e.preventDefault(); // avoid to execute the actual submit of the form.
      $('#app_form').ajaxSubmit({
        url: '<?php echo site_url('administration/template_vsi/template_kompilasi/submit_add') ?>',
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
                 url: "<?php echo site_url('administration/template_vsi/template_kompilasi/nonaktif');?>",
                 success: function(data)
                 {
                     alert(data); // show response from the php script.
                     $table.bootstrapTable('refresh');
                 }
               });

   });
    // this is the id of the form
    // $("#app_form").submit(function(e) {
    //      e.preventDefault(); // avoid to execute the actual submit of the form.

    //     var form = $(this);
    //     var url = form.attr('action');

    //     $.ajax({
    //            type: "POST",
    //            url: url,
    //            data: form.serialize(), // serializes the form's elements.
    //            success: function(data)
    //            {
    //                alert(data); // show response from the php script.
    //            }
    //          });
    // });

  });
</script>
