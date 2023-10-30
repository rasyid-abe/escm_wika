<form class="form-horizontal">
  <div class="row">
      <div class="col-12">
          <div class="card">
            
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Detail</h4>
            </div>

            <div class="card-content">
              <div class="card-body">
                <div id="gridDetailKewenangan"></div>
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
            <?php echo buttonback('procurement/procurement_tools/daftar_template_kewenangan',lang('back'),lang('save')) ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</form>


<?php $this->load->view('devextreme'); ?>

<script>
  $(document).ready(function () {

    const URL = '<?= base_url() ?>Master_kewenangan';
    const d = $.Deferred();
    const ordersStore = new DevExpress.data.CustomStore({
    key: 'id',
    load() {
      var data = [];
				
				$.ajax({
					type: "GET",
					url: URL + '/get_detail/<?= $id ?>',
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
					url: URL + '/insert_detail/<?= $id ?>',
					data: {values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridDetailKewenangan').dxDataGrid("instance").refresh();
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
					url: URL + '/update_detail/<?= $id ?>',
					data: {key: key, values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridDetailKewenangan').dxDataGrid("instance").refresh();
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
					url: URL + '/delete_detail/<?= $id ?>',
					data: {key: key},
					dataType: "json",
					success: function(response) {
						d.resolve();
            if(response.code == 200)
            {
              $('#gridDetailKewenangan').dxDataGrid("instance").refresh();
            }

            location.reload();
					}
				});
      // return sendRequest(`${URL}/delete_score`, 'POST', {
      //   key,
      // });
    },
  });

  var lookup = <?= $adm_pos ?>;
  var lookup_fungsi_bidang = <?= $fungsi_bidang ?>;
  var lookup_posisi = <?= $posisi ?>;



  const dataGrid = $('#gridDetailKewenangan').dxDataGrid({
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
      dataField: 'order_no',
      caption: 'Nomor Urut',
      dataType : 'number'
    },
    {
      dataField: 'job_title',
      caption: 'Posisi',
      lookup: {
                                dataSource: lookup,
                                valueExpr: "job_title",
                                displayExpr: "job_title",
                                //searchExpr: ['pos_id', 'job_title']
                            },
    },
    {
      dataField: 'posisi',
      caption: 'Deskripsi',
    },
    {
      dataField: 'kategori',
      caption: 'Kategori',
    },
    {
      dataField: 'nm_fungsi_bidang',
      caption: 'Nama Fungsi Bidang',
      lookup: {
                                dataSource: lookup_fungsi_bidang,
                                valueExpr: "nm_fungsi_bidang",
                                displayExpr: "nm_fungsi_bidang",
                                //searchExpr: ['pos_id', 'job_title']
                            },
    },
    {
      dataField: 'posisi_user',
      caption: 'Posisi Pegawai',
      lookup: {
                                dataSource: lookup_posisi,
                                valueExpr: "posisi",
                                displayExpr: "posisi",
                                //searchExpr: ['pos_id', 'job_title']
                },
    },
    {
      dataField: 'is_search_divisi',
      caption: 'Search By Divisi ?',
      dataType : 'boolean'
    },
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
