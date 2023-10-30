<form class="form-horizontal">
  <div class="row">
      <div class="col-12">
          <div class="card">
            
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Item Administrasi/Teknis</h4>
            </div>

            <div class="card-content">
              <div class="card-body">
                <div id="gridTemplateScore"></div>
              </div>
            </div>

          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <?php echo buttonback('procurement/procurement_tools/daftar_template_evaluasi_pengadaan',lang('back'),lang('save')) ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</form>


<?php $this->load->view('devextreme'); ?>

<script>
  $(document).ready(function () {

    const URL = '<?= base_url() ?>Template_petunjuk_score';
    const d = $.Deferred();
    const ordersStore = new DevExpress.data.CustomStore({
    key: 'id',
    load() {
      var data = [];
				
				$.ajax({
					type: "GET",
					url: URL + '/get_score/<?= $id ?>',
					//data: "data",
					dataType: "json",
					success: function(response) {
						d.resolve(response.data);
					}
				});
				return d.promise();
    },
    insert(values) {

      $.ajax({
					type: "POST",
					url: URL + '/insert_score/<?= $id ?>',
					data: {values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridTemplateScore').dxDataGrid("instance").refresh();
            }

            location.reload();
					}
				});
      // return sendRequest(`${URL}/insert_score/<?= $id ?>`, 'POST', {
      //   values: JSON.stringify(values),
      // });
    },
    update(key, values) {

      $.ajax({
					type: "POST",
					url: URL + '/update_score/<?= $id ?>',
					data: {key: key, values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridTemplateScore').dxDataGrid("instance").refresh();
            }

            location.reload();
					}
				});

      // return sendRequest(`${URL}/update_score`, 'POST', {
      //   key,
      //   values: JSON.stringify(values),
      // });
    },
    remove(key) {
      $.ajax({
					type: "POST",
					url: URL + '/delete_score/<?= $id ?>',
					data: {key: key},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridTemplateScore').dxDataGrid("instance").refresh();
            }

            location.reload();
					}
				});
      // return sendRequest(`${URL}/delete_score`, 'POST', {
      //   key,
      // });
    },
  });

  const dataGrid = $('#gridTemplateScore').dxDataGrid({
    dataSource: ordersStore,
    showBorders: true,
    editing: {
      mode: 'row',
      allowAdding: true,
      allowUpdating: true,
      allowDeleting: true,
    },
    scrolling: {
      mode: 'virtual',
    },
    columns: [
    {
      dataField: 'bobot',
      caption: 'BOBOT',
      dataType : 'number'
    },
    {
      dataField: 'deskripsi',
      caption: 'DESKRIPSI',
    }
    ],
    summary: {
      totalItems: [{
        column: 'bobot',
        valueFormat: '#0.00',
        summaryType: 'sum',
      }],
    },
  }).dxDataGrid('instance');


  });

  function fModalScore()
  {
    //$("#score-modal").modal("show");
  }

  function sendRequest(url, method = 'GET', data) {
    const d = $.Deferred();

    $.ajax(url, {
      method,
      data,
      cache: false,
    }).done((result) => {
      d.resolve(method === 'GET' ? result.data : result);
    }).fail((xhr) => {
      d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
    });

    return d.promise();
  }

</script>
<?php include("form_template_evaluasi_js.php") ?>