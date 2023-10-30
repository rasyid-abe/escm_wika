<section>
  <div class="row">
    <div class="col-12">
      <?php echo $this->session->flashdata('notif') ?>
      <div class="card">
        <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Daftar Transaksi</h4>
        </div>
        
        <div class="card-content">
          <div class="card-body">
            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('padi/upload_transaksi');?>">
            <div class="form-row">
                  <div class="col-2">
                      <div class="form-group">
                          <input class="form-control" name="file_transaksi" type="file" required="required"> 
                      </div>
                  </div>
                  <div class="col-3">
                      <div class="btn-group btn-group-sm">
                        <input class="btn btn-info" name="upload" type="submit" value="Import Transaksi">
                        <a class="btn btn-warning" href="<?php echo base_url('attachment/WIKA_Template_Transaksi_PaDi.xlsx'); ?>" target="_blank">Download Template</a>
                        <input class="btn btn-danger" onclick="pushPadi()" id="btnPushPadi" type="button" value="Push PaDi">
                      </div>
                  </div>
              </div>
            </form>
            <div class="table-responsive">
              <table id="daftar_transaksi" class="table table-bordered table-striped"></table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  var $daftar_transaksi = $('#daftar_transaksi'),
    selections = [];
</script>

<script type="text/javascript">

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('padi/transaksi/detail') ?>";
    return [
    '<a target="_blank" class="btn btn-info btn-sm action" href="'+link+'/'+value+'">',
    '<i class="ft-eye mr-1"></i>Lihat',
    '</a>  '
    ].join('');
  }

  function pushPadi() {
    var data = $('#daftar_transaksi').bootstrapTable("getSelections");

    if(data.length === 0)
    {
      Swal.fire({
        title: 'WARNING',
        text: "Tidak Ada data di select !",
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        backdrop: true,
        allowOutsideClick: false
      }).then((result) => {
       
      })
    } else {
        Swal.fire({
        title: 'WARNING',
        text: "Yakin Simpan  ?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        backdrop: true,
        allowOutsideClick: false
      }).then((result) => {
        if (result.value) {
          var link = "<?php echo site_url('padi/push_transaksi_all') ?>";
          var data  = $('#daftar_transaksi').bootstrapTable("getSelections");
          $('#loading_general').modal("show");
          $.ajax({
            type: "POST",
            url: link,
            data: {data : data },
            dataType: "json",
            success: function (response) {
          $('#loading_general').modal("hide");
                if(response.code == 500)
                {
                  alert(response.messages);
                } else {
                  alert(response.messages);
                  location.reload();
                }
            }
          });

        } else {

        }
      })
    }
  }

  function stateFormatter(value, row, index) {
    if (row.status_padi === "Sudah Diunggah") {
      return {
        disabled: true
      }
    }
    return value;
  }

  $(function() {

    $daftar_transaksi.bootstrapTable({

      url: "<?php echo site_url('padi/data_transaksi') ?>",
      cookieIdTable: "vw_padi_transaksi",
      idField: "id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
        {checkbox: true,formatter: stateFormatter},
        {
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          valign: 'middle',
          width: '10%',
          formatter: operateFormatter,
        },
        {
          field: 'transaksi_id',
          title: 'Id Transaksi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'bumn_id',
          title: 'Id BUMN',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'category_name',
          title: 'Kategori',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'tanggal_transaksi',
          title: 'Tanggal',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'nama_project',
          title: 'Nama Project',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'total_nilai_project',
          title: 'Total Nilai',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'status_padi',
          title: 'Status',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        }
      ]

    });
    setTimeout(function() {
      $daftar_kantor.bootstrapTable('resetView');
    }, 200);

  });
  
</script>