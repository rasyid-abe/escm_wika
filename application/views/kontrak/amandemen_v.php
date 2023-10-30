<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.semanticui.min.css" rel="stylesheet">
<style>
table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
bottom: .5em;
}

.table-bordered, .table-bordered td, .table-bordered th {
  border: 1px solid #e0e0e000;
}

table.dataTable thead th[class*="sorting"]:not(.sorting_disabled):before {
  display: none;
}

table.dataTable.table thead th.sorting:after, table.dataTable.table thead td.sorting:after {
  display: none;
}

.table .thead-light th {
  background-color: transparent;
  border-left: transparent;
  border-right: transparent;
  font-size: medium;
}

table.dataTable.table {
  padding-top: 10px;
}

.card {
  border-radius: 15px;
}

.card .card-title {
  color: #29a7de;
}

.input-group > .form-control:not(:first-child), .input-group > .custom-select:not(:first-child) {
  border-top-right-radius: 15px;
  border-bottom-right-radius: 15px;
  background-color: #e9ecef;
}

.form-control {
  font-size: 12px;
  background-color: #f7f7f8;
  outline: none;
}
td:hover {
  border-radius: 15px;
  background-color: #dbdee566;
}
.form-control:hover {
  border-color: #29a7de;
}
.input-group > .input-group-prepend > .input-group-text {
  border-top-left-radius: 15px;
  border-bottom-left-radius: 15px;
}

table.dataTable.no-footer {
  border-bottom: 1px solid #d8d8d8;
}

.dataTables_wrapper .dataTables_filter input {
  border: 2px solid #29a7de;
  border-top: 0;
  border-left: 0;
  border-right: 0;
  border-radius: 15px;
  padding: 6px;
  background-color: transparent;
  margin-left: 11px;
}
table.dataTable tbody th, table.dataTable tbody td {
  padding: 0px 2px;
}
.form-group {
  margin-bottom: 0;
}
.form-filter {
  padding-left: 10px;
  padding-right: 10px;
}
.btn {
  font-size: 13px;
}
.table th, .table td {
  border-top: 0px solid #E0E0E0;
}
</style>

<!-- starts -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Daftar Kontrak Amandemen</h4>
            </div>  
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="dt-table" class="table table-hover">
                        <thead class="thead-light" style="display:none;">
                        <tr>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $link = site_url('contract/monitor/monitor_kontrak/lihat') ?>
                        <?php foreach ($monitor_kontrak_data as $value) { ?>
                            <tr>
                                <td>
                                <div class="card border-bottom border-top border-right border-left" style="box-shadow: 0px 2px 5px 0px rgb(25 42 70 / 22%);margin: 5px 0;">
                                    <div class="card-body" style="padding:5px;">
                                    <div class="container">
                                        <div class="row">
                                          <div class="col-sm" style="line-height: 25px;">
                                              <b style="text-transform: uppercase;"><?= $value->subject_work ?>&nbsp; &nbsp; </b>
                                              <?php if($value->status_name === 'Kontrak Aktif') { ?>
                                                  <img src="<?= base_url('assets/img/icons/aktif_ic.png') ?>" /> <span style="color:#29a7de;font-size:10px;"><?= $value->status_name ?></span>
                                              <?php } elseif ($value->status_name === 'Approval') { ?>
                                                  <img src="<?= base_url('assets/img/icons/aktif_ic.png') ?>" /> <span style="color:#29a7de;font-size:10px;"><?= $value->status_name ?></span>
                                              <?php } elseif ($value->status_name === 'Terminasi') { ?>
                                                  <img src="<?= base_url('assets/img/icons/termin_ic.png') ?>" /> <span style="color:red;font-size:10px;"><?= $value->status_name ?></span>
                                              <?php } else { ?>
                                                  <img src="<?= base_url('assets/img/icons/termin_ic.png') ?>" /> <span style="color:red;font-size:10px;"><?= $value->status_name ?></span>
                                              <?php } ?><br>

                                              Pengadaan : <span style="color:#29a7de;"><?= $value->ptm_number ?></span>&nbsp; &nbsp; &nbsp; Kontrak : <span style="color:#29a7de;"><?= $value->contract_number ?></span><br> Kontrak Sebelumnya : <span style="color:#29a7de;"><?= $value->amandemen_number ?></span> <br>
                                              <?= $value->vendor_name ?>
                                          </div>
                                          <div class="col-sm" style="text-align: right;">
                                              <?php if($value->fin_class == 'B') { ?> <?php } else { ?>
                                                <img src="<?php echo base_url('assets/img/padi-umkm-logo.png') ?>" style="width: 7%;" />&nbsp; &nbsp; &nbsp; &nbsp;
                                              <?php } ?>
                                              <img src="<?php echo base_url('assets/img/buyer.png') ?>" /> <?php echo $value->ptm_requester_pos_name; ?> &nbsp; &nbsp; &nbsp; &nbsp;                                              
                                              <i class="ft-calendar" style="color: #29a7de;font-size: large;"></i> <?php echo $value->created_date ?> <br><br>
                                              <span class="badge badge-light draggable mb-1 mr-1" style="padding:10px;"><?php echo $value->contract_type ?></span>
                                              <span class="badge badge-light draggable mb-1 mr-1" style="padding:10px;"><?php echo $value->status_name ?></span>
                                              <span class="badge badge-light draggable mb-1 mr-1" style="padding:10px;">Matgis</span>
                                              <a class="btn btn-info btn-sm action" href="<?php echo $link ?>/<?php echo $value->contract_id ?>"><i class="ft-file-text mr-1"></i>Lihat </a>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ends -->

<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

  $(document).ready(function () {
    $('#dt-table').DataTable();
    $('.dataTables_length').addClass('bs-select');
  });

</script>
