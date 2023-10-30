<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <h4 class="card-title float-left">User Hcis</h4>
          <a class="btn btn-info float-right" onclick="syncAll()" role="button">SYCN ALL</a>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="employee" class="table table-bordered table-striped"></table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<?php $this->load->view('devextreme'); ?>

<script>
  $(document).ready(function () {

    const URL = '<?= base_url() ?>administration/user_management';
    const d = $.Deferred();

  var data = <?= $data_hcis ?>;


  const dataGrid = $('#employee').dxDataGrid({
    dataSource: data,
    showBorders: true,
    filterRow: {
                        visible: true,
                        applyFilter: "auto"
                    },
                    headerFilter: {
                        visible: true
                    },
    paging: {
      pageSize: 50,
    },
    pager: {
      visible: true,
      allowedPageSizes: [5, 10, 50,100],
      showPageSizeSelector: true,
      showInfo: true,
      showNavigationButtons: true,
    },
    columns: [
      {     
				  caption : "Action",
					allowEditing: false,   
					width: '130',          
				    cellTemplate: function (container, options) {
				        var id = options.data.nip;
					
							$("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?= base_url() ?>administration/user_management/hcis/detail/"+id+"') class='btn bg-light-info btn-sm' target='_self'>Detail</a>"))
                    .appendTo(container);

                    $("<div class='btn-group'>")
				            .append($("<a onclick=window.open('<?= base_url() ?>hcis/get_data/"+id+"') class='btn bg-light-warning btn-sm' target='_self'>Sync</a>"))

				        .appendTo(container);
						
				            
				    }
				},
      {
      dataField: 'nip',
      caption: 'NIP Pegawai',
    },
      {
      dataField: 'nm_peg',
      caption: 'Nama Pegawai',
    },
    {
      dataField: 'nm_jabatan',
      caption: 'Job Title',
     
    },
    {
      dataField: 'nm_departemen',
      caption: 'Divisi',
    },
    {
      dataField: 'no_spk',
      caption: 'NO SPK',
    },
    {
      dataField: 'nama_proyek',
      caption: 'Nama Proyek',
    },
    {
      dataField: 'Posisi',
      caption: 'posisi',
    },
    {
      dataField: 'user_name',
      caption: 'User name',
     
    },
   
    ],
   
  }).dxDataGrid('instance');


  });

  function fModalScore()
  {
    //$("#score-modal").modal("show");
  }


  function syncAll()
  {
    var grid = $("#employee").dxDataGrid("instance");
    $.ajax({
            type: "GET",
            url: '<?= base_url() ?>Hcis/syncAll',
            dataType: "json",
            success: function (response) {
              
                if(response.code == 200)
                {
                  alert("sync berhasil !");
                } else {
                  alert("sync gagal")
                }

                //var gridHutang = $("#GridUtangNeraca").dxDataGrid("instance");
                var grid = $("#employee").dxDataGrid("instance");

                grid.endCustomLoading();

            }
        });
    grid.beginCustomLoading("Loading...");
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