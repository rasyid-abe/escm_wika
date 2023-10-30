<div style="display: none;" class="alert alert-notif mt-2" role="alert">
  <span id="alert-text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <h4 class="card-title">Daftar Data GR/SES</h4>        
      </div>

      <div class="card-content">
        <div class="card-body">
          <div class="btn-group">
            <a href="<?php echo site_url('contract/sync_grses');?>" class="btn btn-danger btn-sm"><i class="fa fa-retweet"></i> Syncron Data</a>
            <a href="javascript:void(0)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#grsesForm"><i class="fa fa-plus"></i> Tambah</a>
          </div>
          <div class="table-responsive">

            <table id="table_gr_ses" class="table table-bordered table-striped"></table>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- modal-grses -->
<div class="modal fade text-left" id="grsesForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-bold-700">Tambah Data GR/SES</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form action="<?php echo site_url('contract/submit_gr_ses'); ?>" method="POST">
                <div class="modal-body">  
                  <div class="row">
                    <div class="col">
                      <div class="row">
                        <div class="col-md-12 mb-2">
                          <label class="text-bold-700">PO Number</label>
                          <select class="form-control" name="po_number" required>
                            <option value="">Pilih</option>
                            <?php foreach($po_number as $v) { ?>
                              <option value="<?php echo $v['ctr_po_number'];?>"><?php echo $v['ctr_po_number'];?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Dev ID</label>
                              <input type="text" class="form-control" name="devid" placeholder="YMMI009" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Package ID</label>
                              <input type="text" class="form-control" name="packageid" placeholder="Package ID" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Quantity</label>
                              <input type="number" class="form-control" name="quantity" required />
                          </div>
                      </div>                      
                      <div class="row">
                        <div class="col-md-12 mb-2">
                          <label class="text-bold-700">PO Item</label>
                          <input type="number" class="form-control" name="po_item" required />
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">UOM</label>
                              <input type="text" class="form-control" name="entry_uom" placeholder="UOM" required />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Code</label>
                              <input type="text" class="form-control" name="cocode" placeholder="Co Code" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Mat Doc</label>
                              <input type="text" class="form-control" name="mat_doc" placeholder="Mat Doc" />
                          </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Doc Year</label>
                              <input type="text" class="form-control" name="doc_year" placeholder="2023" required />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Doc Date</label>
                              <input type="date" class="form-control" name="doc_date" required />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Psting Date</label>
                              <input type="date" class="form-control" name="psting_date" required />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Matdoc Item</label>
                              <input type="number" class="form-control" name="matdoc_itm" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Ref Doc</label>
                              <input type="text" class="form-control" name="ref_doc" placeholder="Ref Doc" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Material</label>
                              <input type="text" class="form-control" name="material" placeholder="Material" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Plant</label>
                              <input type="text" class="form-control" name="plant" placeholder="Plant" />
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 mb-2">
                              <label class="text-bold-700">Move Type</label>
                              <input type="text" class="form-control" name="move_type" placeholder="Move Type" />
                          </div>
                      </div>
                    </div>
                  </div>                                                                                              
                </div>

                <div class="modal-footer btn-group">
                    <input type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal" value="Batal">
                    <input type="submit" onclick="return confirm('Anda yakin ingin menghapus data?')" class="btn btn-sm btn-info" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

  function gr_ses_act(value, row, index) {
    var link = "<?php echo site_url('contract/gr_ses/') ?>";
    var link_delete = "<?php echo site_url('contract/delete_gr_ses/') ?>";
    return [
    '<div class="btn-group"><a class="btn btn-primary btn-sm action" href="'+link+'/lihat/'+value+'">',
        'Detail',
    '</a>',
    '<a class="btn btn-danger btn-sm" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="'+link_delete+'/'+value+'">',
    'Hapus</a></div>',
    ].join('');
  }

  var $table_gr_ses = $('#table_gr_ses');
  var selections = [];

  $(function () {

    $table_gr_ses.bootstrapTable({

      url: "<?php echo site_url('contract/gr_ses/data_gr_ses') ?>",
      cookieIdTable:"daftar_gr_ses",
      idField:"id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: gr_ses_act,
      },
      {
        field: 'mat_doc',
        title: 'Mat Doc',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'po_number',
        title: 'PO Number',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'po_item',
        title: 'PO Item',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'material',
        title: 'Material',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'entry_uom',
        title: 'Entry UOM',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'move_type',
        title: 'Move Type',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      ]

    });
    setTimeout(function () {
      $table_gr_ses.bootstrapTable('resetView');
    }, 200);

    $table_gr_ses.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_kontrak"));
    });

  });

  var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }
      }
  };

  if(getUrlParameter('status') != typeof undefined){

    if (getUrlParameter('status') == 'success') {

      $('.alert-notif').addClass('bg-light-info').css('display','block')
      $('#alert-text').html(getUrlParameter('msg'))

    } else if (getUrlParameter('status') == 'fail'){

        $('.alert-notif').addClass('bg-light-warning').css('display','block')
        $('#alert-text').html(getUrlParameter('msg'))

    } else if (getUrlParameter('status') == 'not_found'){

        $('.alert-notif').addClass('bg-light-danger').css('display','block')
        $('#alert-text').html(getUrlParameter('msg'))

    } else if (getUrlParameter('status') == 'error_ws'){

        $('.alert-notif').addClass('bg-light-danger').css('display','block')
        $('#alert-text').html(getUrlParameter('msg'))
    }
    
  }

</script>
