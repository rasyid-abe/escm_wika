<?php
$this->db->where('vpi_score <', 800);
$score = $this->db->get('vw_vpi_score_per_bulan')->num_rows();

$this->db->where('vvh_contract_id !=', null);
$asserted = $this->db->get('vw_vpi_asserted')->num_rows();

$this->db->where('vvh_contract_id ', null);
$nonasserted = $this->db->get('vw_vpi_asserted')->num_rows();


?>
<style>
  .kontrak-dinilai {
    text-decoration: none;
    font-size: 1rem;
    color: #2F8BE6 !important;
    position: absolute;
    top: 13px;
    right: 15px;
    display: none;
  }
  .kontrak-tidak-dinilai {
    text-decoration: none;
    font-size: 1rem;
    color: #2F8BE6 !important;
    position: absolute;
    top: 13px;
    right: 15px;
    display: none;
  }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
  <!-- Extra large modal -->
  <div class="modal fade kontrak_dinilai" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Kontrak Dinilai</h3>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="kontrak_dinilai" class="table table-bordered table-striped"></table>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm rounded btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade kontrak_tidak_dinilai" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Kontrak Dinilai</h3>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="kontrak_tidak_dinilai" class="table table-bordered table-striped"></table>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm rounded btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-body">
            <div class="media">
              <div class="media-body text-left">
                <h3 class="mb-1 danger font-medium-3"><?= $asserted + $nonasserted ?></h3>
                <span>Total Kontrak</span>
              </div>
              <div class="media-right align-self-center">
                <i class="ft-archive danger font-large-2 float-right"></i>
              </div>
            </div>
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="40" aria-valuemin="40" aria-valuemax="100" style="width:40%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12" onmouseover="showDetail()" onmouseout="unShowDetail()">
      <div class="card">
        <div class="card-body">
          <div class="card-body">
            <div class="media">
              <div class="media-body text-left">
                <a class="kontrak-dinilai" data-toggle="modal" data-target=".kontrak_dinilai">Lihat detail ></a>
                <h3 class="mb-1 info font-medium-3"><?= $asserted ?></h3>
                <span>Kontrak Dinilai</span>
              </div>
              <div class="media-right align-self-center">
                <i class="ft-file-text info font-large-2 float-right"></i>
              </div>
            </div>
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-info" role="progressbar" aria-valuenow="80" aria-valuemin="80" aria-valuemax="100" style="width:80%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12" onmouseover="showKotrakTidakNlai()" onmouseout="unShowKotrakTidakNlai()">
      <div class="card">
        <div class="card-body">
          <div class="card-body">
            <div class="media">
              <div class="media-body text-left">
                <a class="kontrak-tidak-dinilai" data-toggle="modal" data-target=".kontrak_tidak_dinilai">Lihat detail ></a>
                <h3 class="mb-1 warning font-medium-3"><?= $nonasserted ?></h3>
                <span>Kontrak Tidak Dinilai</span>
              </div>
              <div class="media-right align-self-center">
                <i class="ft-file-minus warning font-large-2 float-right"></i>
              </div>
            </div>
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="35" aria-valuemin="35" aria-valuemax="100" style="width:35%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-body">
            <div class="media">
              <div class="media-body text-left">
                <h3 class="mb-1 success font-medium-3"><?= $score ?></h3>
                <span>VPI Score < 800</span>
              </div>
              <div class="media-right align-self-center">
                <i class="ft-check-circle success font-large-2 float-right"></i>
              </div>
            </div>
            <div class="progress" style="height: 4px;">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="60" aria-valuemax="100" style="width:60%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">

        <div class="card-body">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive pt-4">
                <form method="get" class="form-horizontal">
                  <div class="row" style="display:none;">
                    <div class="form-group col-md-3">
                      <label>Nama Vendor</label>
                      <input type="text" id="s_vnd_name" class="form-control" placeholder="Nama Vendor">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Tanggal Mulai</label>
                      <input type="date" id="s_start_date" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Tanggal Selesai</label>
                      <input type="date" id="s_end_date" class="form-control">
                    </div>
                    <div class="col-md-2 mt-3">
                      <div class='btn-group' role='group'>
                        <button type="button" class="btn bg-light-warning" id="dt_cari_act" title="Search" name="button"><i class="ft-search"></i></button>
                        <button type="button" class="btn bg-light-info" id="db_reset_act" title="Reset" name="button"><i class="ft-refresh-ccw"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" style="display:none;">
                    <label class="col-sm-1 control-label">Vendor</label>
                    <div class="col-sm-4">
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button type="button" id="klir" name="klir" class="btn btn-danger">Semua</button>
                          <button type="button" id="btn_vnd" data-id="kode_vnd" data-url="<?= site_url('vendor/picker_seluruh_vendor') ?>" class="btn btn-primary picker">Pilih Vendor</button>
                        </span>
                        <input type="text" class="form-control" id="kode_vnd" name="kode_vnd" value="">
                      </div>
                    </div>
                  </div>
                </form>
                <table id="table_pekerjaan" class="table table-bordered table-striped"></table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal text-left" id="modal_note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1">Pemberian Catatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
        </button>
      </div>
      <form method="POST" action="<?php echo base_url('vendor/vpi/daftar_pekerjaan/submit_catatan_vpi_vendor'); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <p class="text-muted text-center"><?php echo date('D, d/M/Y'); ?></p>
          <input type="hidden" name="contract_id_note" id="contract_id_note">
          <div class="input-group d-flex justify-content-center">
            <div class="radio d-inline-block mr-3">
              <input type="radio" id="striped-form-1" checked name="status" value="1">
              <label for="striped-form-1"><i class="ft-thumbs-up text-info font-medium-3 mr-1"></i></label>
            </div>
            <div class="radio d-inline-block">
              <input type="radio" id="striped-form-2" name="status" value="2">
              <label for="striped-form-2"><i class="ft-thumbs-down font-medium-3 text-danger mr-1"></i></label>
            </div>
          </div>
          <div class="form-group">
            <label>Penjelasan</label>
            <textarea rows="4" class="form-control" name="note" required></textarea>
          </div>
          <div class="form-group">
            <label class="mr-3">Lampiran</label>
            <input type="file" id="upload" name="lampiran" style="display:none;" required>
            <label class="btn btn-warning btn-sm px-2 mr-3" for="upload"><i class="ft-upload-cloud"></i> Upload file</label>
            <label class="custom-file-upload"></label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-light-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-info" onclick="return confirm('Apakah Anda yakin simpan data ini?')">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  var kontrak_tidak_dinilai = $('#kontrak_tidak_dinilai');
</script>

<script type="text/javascript">
  var detail_contract_url = "<?php echo site_url('/kontrak/kontrak_tidak_dinilai') ?>"
  console.log(detail_contract_url);
  $(function() {
    kontrak_tidak_dinilai.bootstrapTable({
      url: detail_contract_url,
      idField: "urlid",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: "contract_id",
          title: 'No Kontrak',
          align: 'center',
          width: '20%',
          valign: 'middle',
        },
        {
          field: 'ptm_number',
          title: 'Nomor Pengadaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '15%',
          formatter: lihatRFQ,
        },
        {
          field: 'ptm_buyer',
          title: 'Buyer',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '15%',
        },
        {
          field: 'ptm_dept_name',
          title: 'Divisi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'ptm_project_name',
          title: 'Proyek',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          formatter: lihatVendor
        },
        {
          field: 'subject_work',
          title: 'Paket Pengadaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'scope_work',
          title: 'Deskripsi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'vendor_name',
          title: 'Vendor/ Penyedia',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'contract_type',
          title: 'Tipe Kontrak',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'start_date',
          title: 'Mulai Pelaksanaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'end_date',
          title: 'Akhir Pelaksanaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'subtotal_rab',
          title: 'Nilai RAB',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'contract_amount',
          title: 'Nilai Kontrak',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        }
      ]
    });
  })
</script>
<script type="text/javascript">
  var kontrak_dinilai = $('#kontrak_dinilai');
</script>

<script type="text/javascript">
  var detail_contract_url = "<?php echo site_url('/kontrak/kontrak_dinilai') ?>"
  console.log(detail_contract_url);
  $(function() {
    kontrak_dinilai.bootstrapTable({
      url: detail_contract_url,
      idField: "urlid",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: "contract_id",
          title: 'No Kontrak',
          align: 'center',
          width: '20%',
          valign: 'middle',
        },
        {
          field: 'ptm_number',
          title: 'Nomor Pengadaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '15%',
          formatter: lihatRFQ,
        },
        {
          field: 'ptm_buyer',
          title: 'Buyer',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '15%',
        },
        {
          field: 'ptm_dept_name',
          title: 'Divisi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'ptm_project_name',
          title: 'Proyek',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          formatter: lihatVendor
        },
        {
          field: 'subject_work',
          title: 'Paket Pengadaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'scope_work',
          title: 'Deskripsi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'vendor_name',
          title: 'Vendor/ Penyedia',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'contract_type',
          title: 'Tipe Kontrak',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'start_date',
          title: 'Mulai Pelaksanaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'end_date',
          title: 'Akhir Pelaksanaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'subtotal_rab',
          title: 'Nilai RAB',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'contract_amount',
          title: 'Nilai Kontrak',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        }
      ]
    });
  })
</script>

<script type="text/javascript">
  function showDetail() {
    let show = document.getElementsByClassName('kontrak-dinilai')
    show[0].style.display = "block"
  }

  function unShowDetail() {
    let show = document.getElementsByClassName('kontrak-dinilai')
    show[0].style.display = "none"
  }

  function showKotrakTidakNlai() {
    let show = document.getElementsByClassName('kontrak-tidak-dinilai')
    show[0].style.display = "block"
  }

  function unShowKotrakTidakNlai() {
    let show = document.getElementsByClassName('kontrak-tidak-dinilai')
    show[0].style.display = "none"
  }


  $(document).ready(function() {});

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

    var mydata = $.getCustomJSON("<?php echo site_url() ?>/" + url);

    var html = [];
    $.each(row, function(key, value) {
      var data = $.grep(mydata, function(e) {
        return e.field == key;
      });

      if (typeof data[0] !== 'undefined') {

        html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
      }
    });

    return html.join('');

  }

  function show_modal_catatan(ContractId) {
    $("#contract_id_note").val(ContractId);
    $("#modal_note").modal("show");
  }

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('vendor/vpi/daftar_pekerjaan/penilaian_header') ?>";
    return [
      // '<a class="btn btn-secondary" id="btn_note" ondblclick="show_modal_catatan('+value+')">',
      // '<i class="ft-file-text info"></i>',
      // '</a>  ',
      '<a class="btn btn-primary action" href="' + link + '/' + value + '">',
      '<i class="ft-settings mr-1"></i>',
      '</a>  ',
    ].join('');
  }

  function lihatRFQ(value, row, index) {
    var link = "<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat') ?>";
    return [
      '<a href="' + link + '/' + value + '" target="_blank">',
      value,
      '</a>  ',
    ].join('');
  }

  function lihatVendor(value, row, index) {
    var link = "<?php echo site_url('vendor/daftar_vendor/lihat_detail_vendor') ?>";
    return [
      '<a href="' + link + '/' + value + '" target="_blank">',
      value,
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
    $.each(data, function(i, row) {
      total += +(row.price.substring(1));
    });
    return '$' + total;
  }
</script>

<script type="text/javascript">
  var $table_pekerjaan = $('#table_pekerjaan'),
    selections = [];
</script>


<script type="text/javascript">
  var url = "<?php echo site_url('contract/data_monitor_kontrak/activeandfinish?') ?>"

  $(function() {

    $table_pekerjaan.bootstrapTable({

      url: url,
      cookieIdTable: "daftar_pekerjaan",
      idField: "urlid",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: "contract_id",
          title: '#',
          align: 'center',
          width: '20%',
          valign: 'middle',
          formatter: operateFormatter,
        },
        {
          field: 'ptm_number',
          title: 'Nomor Pengadaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '15%',
          formatter: lihatRFQ,
        },
        {
          field: 'contract_number',
          title: 'Nomor Kontrak',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '15%',
        },
        {
          field: 'subject_work',
          title: 'Deskripsi Pekerjaan',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle',
          width: '30%',
        },
        {
          field: 'vendor_id',
          title: 'Vendor ID',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          formatter: lihatVendor
        },
        {
          field: 'vendor_name',
          title: 'Vendor',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'contract_type',
          title: 'Tipe',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',

        },
        {
          field: 'status_name',
          title: 'Status',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle',
          width: '20%',
        },

      ]

    });
    setTimeout(function() {
      $table_pekerjaan.bootstrapTable('resetView');
    }, 200);

    $table_pekerjaan.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias"));
    });

    $('#kode_vnd').change(function(event) {
      $table_pekerjaan.bootstrapTable('refresh', {
        url: url + '&vnd_id=' + $(this).val()
      })
    });

    $('#klir').click(function(event) {
      $('#kode_vnd').val("")
      $table_pekerjaan.bootstrapTable('refresh', {
        url: url
      })
    });

  });
</script>