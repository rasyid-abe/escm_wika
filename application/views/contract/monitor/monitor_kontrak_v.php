<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
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

<section class="users-list-wrapper">
    <!-- starts -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-12">
                            <div class="card border-bottom border-top border-right border-left" style="margin: 0px;">

                                <div class="card-header" style="padding-top: 10px;">
                                    <span style="color:#2aace3;"><b>Multiple Filtering</b></span>
                                </div>

                                <div class="card-content">
                                    <div class="card-body" style="padding-top:5px;">
                                        <form action="<?php echo site_url('contract/monitor/monitor_kontrak') ?>" method="post" style="margin-left: -15px;margin-right: -15px;">
                                            <div class="col-md-4 col-12 form-filter">
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <select class="form-control" name="siup_type_keyword" id="siup_type">
                                                            <option value="#">Type</option>
                                                            <?php foreach ($siup_type as $v) { ?>
                                                                <option value="<?php echo $v['siup_type'];?>"><?php echo $v['siup_type'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-4 col-12 form-filter">
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <input type="date" name="date_start" id="date_start" class="form-control" placeholder="start">
                                                        <input type="date" name="date_end" id="date_end" class="form-control">
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-4 col-12 form-filter">
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <select class="form-control" name="divisi_keyword" id="divisi">
                                                            <option selected value="">Divisi</option>
                                                            <?php foreach ($ptm_dept_name as $v) { ?>
                                                                <option value="<?php echo $v['ptm_dept_name'];?>"><?php echo $v['ptm_dept_name'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-4 col-12 form-filter">
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <select class="form-control" name="divisi_keyword" id="divisi">
                                                            <option selected value="">Wilayah</option>
                                                            <option value="Jakarta">DKI Jakarta</option>
                                                            <option value="Tangerang">Tangerang</option>
                                                            <option value="Bekasi">Bekasi</option>
                                                            <option value="Depok">Depok</option>
                                                            <option value="Bogor">Bogor</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-4 col-12 form-filter">
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <select class="form-control" name="divisi_keyword" id="divisi">
                                                            <option selected value="">Impor</option>
                                                            <option value="Ekspor">Ekspor</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-2 col-12 form-filter">
                                                <fieldset class="form-group">
                                                    <button type="submit" class="btn btn-info btn-block">
                                                        <i class="ft-filter"></i> Filter
                                                    </button>
                                                </fieldset>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>                                  
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <!-- table -->
                        <div class="table-responsive">
                                <table id="dt-table-sap" class="table table-hover">
                                    <thead class="thead-light" style="display:none;">
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $link = site_url('contract/monitor/monitor_kontrak/lihat') ?>
                                        <?php foreach ($monitor_kontrak_data_sap as $value) { ?>
                                            <tr>
                                                <td>
                                                    <div class="card border-bottom border-top border-right border-left" style="box-shadow: 0px 2px 5px 0px rgb(25 42 70 / 22%);margin: 5px 0;">
                                                        <div class="card-body" style="padding:5px;">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-sm" style="line-height: 25px;">
                                                                        <?php if($value->status_name === 'Kontrak Aktif') { ?>
                                                                            <img src="<?php echo base_url('assets/img/icons/aktif_ic.png') ?>" /> <span style="color:#29a7de;font-size:10px;"><?php echo $value->status_name ?></span>
                                                                        <?php } elseif ($value->status_name === 'Approval') { ?>
                                                                            <img src="<?php echo base_url('assets/img/icons/aktif_ic.png') ?>" /> <span style="color:#29a7de;font-size:10px;"><?php echo $value->status_name ?></span>
                                                                        <?php } elseif ($value->status_name === 'Finalisasi Kontrak') { ?>
                                                                            <img src="<?php echo base_url('assets/img/icons/aktif_ic.png') ?>" /> <span style="color:#29a7de;font-size:10px;"><?php echo $value->status_name ?></span>
                                                                        <?php } elseif ($value->status_name === 'Kontrak Selesai') { ?>
                                                                            <img src="<?php echo base_url('assets/img/icons/aktif_ic.png') ?>" /> <span style="color:#29a7de;font-size:10px;"><?php echo $value->status_name ?></span>
                                                                        <?php } elseif ($value->status_name === 'Terminasi') { ?>
                                                                            <img src="<?php echo base_url('assets/img/icons/termin_ic.png') ?>" /> <span style="color:red;font-size:10px;"><?php echo $value->status_name ?></span>
                                                                        <?php } else { ?>
                                                                            <img src="<?php echo base_url('assets/img/icons/termin_ic.png') ?>" /> <span style="color:red;font-size:10px;"><?php echo $value->status_name ?></span>
                                                                        <?php } ?><br>

                                                                        <b style="text-transform: uppercase;"><?php echo $value->subject_work ?></b> <br>

                                                                        Pengadaan : <span style="color:#29a7de;"><?php echo $value->ptm_number ?></span>&nbsp; &nbsp; &nbsp; Kontrak : <span style="color:#29a7de;"><?php echo $value->contract_number ?></span><br>
                                                                        <?php echo $value->vendor_name ?>
                                                                    </div>
                                                                    <div class="col-sm" style="text-align: right;">
                                                                        <?php if($value->fin_class == 'B') { ?> <?php } else { ?>
                                                                            <img src="<?php echo base_url('assets/img/padi-umkm-logo.png') ?>" style="width: 7%;" />&nbsp; &nbsp; &nbsp; &nbsp;
                                                                        <?php } ?>
                                                                        <img src="<?php echo base_url('assets/img/buyer.png') ?>" /> <?php echo $value->ptm_requester_pos_name; ?> &nbsp; &nbsp; &nbsp; &nbsp;
                                                                        <i class="ft-calendar" style="color: #29a7de;font-size: large;"></i> <?php echo $value->start_date ?> <br><br>
                                                                        <span class="badge badge-light draggable mb-1 mr-1" style="padding:10px;"><?php echo $value->contract_type ?></span>
                                                                        <span class="badge badge-light draggable mb-1 mr-1" style="padding:10px;"><?php echo $value->status_name ?></span>
                                                                        <span class="badge badge-light draggable mb-1 mr-1" style="padding:10px;">Matgis</span>
                                                                        <span class="badge badge-light draggable mb-1 mr-1" style="padding:10px;"><?php echo $value->status_po ?></span>
                                                                        <a class="btn btn-info btn-sm action" href="<?php echo $link ?>/<?php echo $value->contract_id ?>"><i class="ft-file-text mr-1"></i>Lihat </a>
                                                                        <?php if($value->ctr_generate_text_number != "" && ($value->ctr_po_number == "" || $value->ctr_po_number == null) ) : ?>
                                                                        <a class="btn btn-info btn-sm action" onclick="fGeneratePoNumber('<?= $value->ctr_generate_text_number; ?>')"><i class="ft-cloud mr-1"></i>syn po number </a>
                                                                        <?php endif; ?>
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
</section>

<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
 function fGeneratePoNumber(filename) {
        var url = '<?php echo site_url()."/Sap/update_po_number/"; ?>';
			$.ajax({
	            type: "GET",
	            url: url+filename,
	            dataType: "JSON",
	            success: function (response) {
					// $(`#myLoader`).modal('hide');
	                if(response.status == "SUCCESS"){
	                    alert("update po number berhasil !");
	                } else {
	                    alert("update po number gagal !");
	                }
	            }
	        });
}
$(document).ready(function () {
    $('#dt-table').DataTable({
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, 'All'],
        ],
    });
    $('#dt-table-sap').DataTable({
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, 'All'],
        ],
    });
    $('.dataTables_length').addClass('bs-select');


});

</script>
