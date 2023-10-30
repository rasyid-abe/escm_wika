<section>
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
          <h4 class="card-title float-left">Data Sumberdaya Data e-Catalogue</h4>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="catalog" class="table table-bordered table-striped">
                <a class="btn btn-info" href="<?php echo site_url('administration/sync_catalog') ?>" role="button"><i class="fa fa-retweet mr-1"></i> Sync</a>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

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

  </script>

  <script type="text/javascript">
    var $catalog = $('#catalog'),
      selections = [];
  </script>

  <script type="text/javascript">
    $(function() {

      $catalog.bootstrapTable({

        url: "<?php echo site_url('administration/data_catalog') ?>",
        cookieIdTable: "catalog_tbl",
        idField: "id",
        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
        columns: [          
          {
            field: 'resources_code_id',
            title: 'Resources Code',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'code',
            title: 'Code',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'parent_code',
            title: 'Parent Code',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'level',
            title: 'Level',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'name',
            title: 'Name',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'description',
            title: 'Description',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'uoms_name',
            title: 'Uoms Name',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'jenis_material',
            title: 'Jenis Material',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'material_code',
            title: 'Material Code',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'material_name',
            title: 'Material Name',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'valuation_class_code',
            title: 'Valuation Class Code',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'valuation_class_name',
            title: 'Valuation Class Name',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
          {
            field: 'flag',
            title: 'Category',
            sortable: true,
            order: true,
            searchable: true,
            align: 'center',
            valign: 'middle'
          },
        ]

      });
      setTimeout(function() {
        $catalog.bootstrapTable('resetView');
      }, 200);

      $catalog.on('expand-row.bs.table', function(e, index, row, $detail) {
        $detail.html(detailFormatter(index, row, "alias_catalog"));
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
