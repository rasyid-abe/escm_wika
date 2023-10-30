<style media="screen">
    .styled-table {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        width: 100%;
    }

    .styled-table td {
        padding: 4px;
        text-align: left;
        vertical-align:middle;
        font-weight: 300;
        font-size: 12px;
        color: black;
        border-bottom: solid 1px gray;
    }
    .styled-table th {
        padding: 10px 7px;
        text-align: left;
        font-weight: bold;
        font-size: 12px;
    }

    .bgblue {
        background-color: #2aace3;
    }

    .bggreen {
        background-color: lightgreen;
    }

    .header {
        background-color: lightgray;
        color: #fff;
    }

    .lds-hourglass {
        display: inline-block;
        position: relative;
        width: 10px;
        height: 10px;
    }
    .lds-hourglass:after {
        content: " ";
        display: block;
        border-radius: 50%;
        width: 0;
        height: 0;
        margin: 2px;
        box-sizing: border-box;
        border: 10px solid #2F8BE6;
        border-color: #2F8BE6 transparent #2F8BE6 transparent;
        animation: lds-hourglass 1.2s infinite;
    }
    @keyframes lds-hourglass {
        0% {
            transform: rotate(0);
            animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
        }
        50% {
            transform: rotate(900deg);
            animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        }
        100% {
            transform: rotate(1800deg);
        }
    }
</style>
<style scoped>
    .styleSelect select {
        border: 0;
        border-radius: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 8px;
        position: relative;
    }

    .styleSelect i {
        position: absolute;
        right: 5%;
        top: 20%;
        color: white;
    }

    .select2-container--classic .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #ffffff;
        background-color: #2aace3;
        border-radius: 4px;
    }

    .btn-info {
        border-radius: 8px;
    }


    .form-group {
        margin-bottom: 0;
    }

    .wrapper-switch {
        background-color: #fff;
        padding: 1rem;
        display: flex;
        border-radius: 10px;
        justify-content: space-between;
        align-items: center;
        max-width: 285px;
        box-shadow: -8px 8px 14px 0 rgb(25 42 70 / 11%);
    }

    .card-top {
        background-color: #f7f7f8;
        box-shadow: none;
    }

    .select2-container--classic .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:focus {
        outline: 0;
        border-color: #2aace3 !important;
        box-shadow: none !important;
    }

    .hide {
        display: none;
    }

</style>
<!-- CSS only -->
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

<div id="inp_tanggal" class="modal fade bd-example-modal-md" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Input Tanggal</h4>
			</div>
			<div class="modal-body">
                <input type="hidden" id="tgl_ppm_id_m" name="tgl_ppm_id" value="">
                <div class="form-group row">
                    <label for="tgl_tender" class="col-sm-4 col-form-label">Tanggal Tender</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="tgl_tender_m">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_po" class="col-sm-4 col-form-label">Tanggal PO</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="tgl_po_m">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_target" class="col-sm-4 col-form-label">Target Kedatangan</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="tgl_target_m">
                    </div>
                </div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_tgl" class="btn btn-sm btn-primary">Simpan</button>
            </div>
		</div>

	</div>
</div>

<div id="uploadfiles" class="modal fade bd-example-modal-lg" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">File Uploader</h4>
			</div>
			<div class="modal-body">
                <input type="file" name="uploadFile" id="uploadFile" value="" /><br><br>
                <div class="text-center">
                    <button class="btn btn-info btn-sm" id="uploadexcel">Upload</button>
                </div>
			</div>
		</div>

	</div>
</div>

<div id="validasi_view" class="modal fade bd-example-modal-xl" role="dialog">
	<div class="modal-dialog modal-xl">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Validasi Data</h4>
			</div>
			<div class="modal-body">
                <div class="" style="overflow-x:auto;">
                    <table class="styled-table">
                        <tr>
                            <th class="text-center bgblue">No</th>
                            <th class="text-center bgblue">Profit Center</th>
                            <th class="text-center bgblue">Project Definisi</th>
                            <th class="text-center bgblue">Divisi</th>
                            <th class="text-center bgblue">Storage Loc</th>
                            <th class="text-center bgblue">Purch. Group</th>
                            <th class="text-center bgblue">Start-Finish Project</th>
                            <th class="text-center bggreen">No PR</th>
                            <th class="text-center bggreen">W8S Element</th>
                            <th class="text-center bggreen">Network</th>
                            <th class="text-center bggreen">Kode Sumberdaya</th>
                            <th class="text-center bggreen">Material Desc</th>
                            <th class="text-center bggreen">Volume</th>
                            <th class="text-center bggreen">Harga Satuan</th>
                            <th class="text-center bggreen">Tgl. Pemakaian</th>
                            <th class="text-center bggreen">Remark</th>
                        </tr>
                        <tbody id="body_valid"></tbody>
                    </table>
    			</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_sap" class="btn btn-primary">Validasi</button>
            </div>
		</div>

	</div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header border-bottom">
                <div class="row justify-content-end mb-2">
                    <div class="col-sm-1 pt-1">
                        <span class="card-title text-bold-600 mr-2">Filter Data <i class="ft-document"></i></span>
                    </div>
                    <div class="col-sm-9 mb-2">
                        <div class="row">
                            <!-- <div class="col-sm-3 styleSelect">
                                <select class="form-control bg-select" id="tipe" name="tipe">
                                    <option value="">- Tipe Perencanaan -</option>
                                    <option value="0">PMCS</option>
                                    <option value="1">SAP</option>
                                </select>
                            </div> -->
                            <div class="col-sm-4 styleSelect">
                                <select class="form-control bg-select" id="divisi" name="divisi">
                                    <option value="">- Divisi -</option>
                                    <?php foreach ($div as $k => $v): ?>
                                        <option value="<?php echo $v['ppm_planner_pos_code'] ?>"><?php echo $v['ppm_planner_pos_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-4 styleSelect">
                                <select class="form-control bg-select" id="project" name="project" disabled>
                                    <option value="">- Project -</option>
                                </select>
                            </div>
                            <div class="col-sm-4 styleSelect" id="selPR">
                                <select class="form-control bg-select" id="pr" name="pr" disabled>
                                    <option value="">- All PR Number -</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <button type="button" class="form-control btn btn-primary btn-sm" id="sbmt"><i class=" fa fa-search"></i>&nbsp; Proses</button>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <button type="button" class="form-control btn btn-secondary btn-sm" data-toggle="modal" data-target="#uploadfiles"><i class=" fa fa-upload"></i>&nbsp; Import</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="by_section" class="hide">
    <div class="row hide" id="head">
        <div class="col-12">
            <div class="card ">

                <div class="card-header border-bottom pb-2">
                    <span class="card-title text-bold-600 mr-2">Header <i class="ft-cpu"></i></span>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 row">

                                <div class="col-md-12 form-group">
                                    <label class="col-md-4 control-label text-bold-700">Profit Center</label>
                                    <div class="col-md-8"> :
                                        <span id="ppm_project_id"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label class="col-sm-4 control-label text-bold-700">Project Definisi</label>
                                    <div class="col-sm-8"> :
                                        <span id="ppm_subject_of_work"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label class="col-sm-4 control-label text-bold-700">Division</label>
                                    <div class="col-sm-8"> :
                                        <span id="ppm_project_name"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label class="col-sm-4 control-label text-bold-700">Storage Location</label>
                                    <div class="col-sm-8"> :
                                        <span id="ppms_storage_loc"></span>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Purchasing Group</label>
                                    <div class="col-sm-8"> :
                                        <span id="ppm_dept_name"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6 row">
                                <input type="hidden" id="tgl_ppm_id" name="tgl_ppm_id" value="">
                                <div class="form-group mb-1 col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Start Project</label>
                                    <div class="col-sm-8"> :
                                        <span id="ppms_start_date"></span>
                                    </div>
                                </div>

                                <div class="form-group mb-1 col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Finish Project</label>
                                    <div class="col-sm-8"> :
                                        <span id="ppms_finish_date"></span>
                                    </div>
                                </div>

                                <div class="form-group mb-1 col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Tender Date</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" onchange="ch_dates();" id="tgl_tender">
                                    </div>
                                </div>

                                <div class="form-group mb-1 col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">PO Date</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" onchange="ch_dates();" id="tgl_po">
                                    </div>
                                </div>

                                <div class="form-group mb-1 col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Arrival Date</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" onchange="ch_dates();" id="tgl_target">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row hide" id="itm">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom pb-2">
                    <h5 class="card-title">Item</h5>
                </div>
                <div id="content_item"></div>
            </div>
        </div>
    </div>

    <div class="row hide" id="hist">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom pb-2">
                    <h5 class="card-title">History Anggaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tbl_hist_anggaran" class="table">
                                <tr><th class="text-center bgblue">Memuat data ...</th></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom pb-2">
                    <h5 class="card-title">History Volume</h5>
                </div>
                <div class="card-content">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="table_history_volume" class="table table-bordered table-striped"></table>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="by_table" class="hide">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-3 col-md-1">
                    <span class="mr-3"> <div class="lds-hourglass hide" id="load_smbd"></div> </span>
                </div>
                <div class="col-12 col-md-7"></div>
                <div class="col-6 col-md-4">
                    <label class="col-sm-4 text-right control-label text-bold-700 mt-2">Cari No. PR</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="cpr" onchange="show_table()" name="cpr" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="" style="overflow-x:auto;">
                <table id="tbl_view_sap" class="styled-table" cellpadding="0" cellspacing="0" border="0">
                    <tr><th class="text-center bgblue">Memuat data ...</th></tr>
                </table>
            </div>
            <table width="100%" id="pg_sap" class="table"></table>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" charset="utf-8"></script>

<script type="text/javascript">

    $(document).ready(function () {
        let dd = $('#by_section').hasClass('hide')
        if (dd) {
        } else {
            $('#by_section').addClass('hide')
        }
        $('#by_table').removeClass('hide')
        show_table()

        $('#tgl_tender').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $('#tgl_po').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $('#tgl_target').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

    });

    function ch_dates() {

        let tgl_tender = $(`#tgl_tender`).val()
        let tgl_po = $(`#tgl_po`).val()
        let tgl_target = $(`#tgl_target`).val()
        let ppm_id = $(`#tgl_ppm_id`).val()

        console.log(ppm_id);

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/submit_tgl_sap') ?>',
            dataType: 'json',
            data: {'tgl_po': tgl_po, 'tgl_tender': tgl_tender, 'tgl_target': tgl_target, 'ppm_id': ppm_id},
            method: 'post',
            success: function(response){
                console.log(response);
                // setTimeout(function() {
                //     $('#myLoader').modal('toggle');
                //     alert('Insert Tanggal Success!')
                // }, 1000);
            }
        });
    }

    $('#uploadexcel').on('click', function() {
        $('#uploadfiles').modal('toggle');
        $('#myLoader').modal('toggle');

        var file_data = $('#uploadFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/pr_sap_import') ?>',
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response){
                res = JSON.parse(response)
                ppm = res['ppm']
                ppi = res['ppi']

                view_validate(ppm, ppi)

                setTimeout(function() {
                    $('#myLoader').modal('toggle');
                    $('#validasi_view').modal('toggle');
                }, 1000);
            }
        });
    })

    $('#upload_ftp').on('click', function() {
        $('#myLoader').modal('toggle');

        $.ajax({
            // url: '<?php // echo base_url('perencanaan_pengadaan/pr_sap_import_ftp') ?>',
            url: '<?php echo base_url('dir') ?>',
            dataType: 'json',
            method: 'post',
            success: function(response){
                console.log(response);
                res = response
                ppm = res['ppm']
                ppi = res['ppi']

                view_validate(ppm, ppi)

                setTimeout(function() {
                    $('#myLoader').modal('toggle');
                    $('#validasi_view').modal('toggle');
                }, 1000);
            }
        });
    })

    function view_validate(ppm, ppi) {
        let items = ''
        for (var i = 0; i < ppm.length; i++) {
            items += `
                <tr>
                    <td class="text-center">${i+1}</td>
                    <td class="text-center">${ppm[i]['ppm_project_id']}</td>
                    <td>${ppm[i]['ppm_subject_of_work']}</td>
                    <td class="text-center">${ppm[i]['ppm_planner_pos_name']}</td>
                    <td class="text-center">${ppm[i]['ppms_storage_loc']}</td>
                    <td class="text-center">${ppm[i]['ppms_dept_id']}</td>
                    <td >${ppm[i]['ppms_start_date']} - ${ppm[i]['ppms_finish_date']}</td>
                    <td>${ppi[i]['ppis_pr_number']}</td>
                    <td>${ppi[i]['ppis_wbs_element']}</td>
                    <td>${ppi[i]['ppis_network']}</td>
                    <td >${ppi[i]['ppi_code']}</td>
                    <td >${ppi[i]['ppi_item_desc']}</td>
                    <td class="text-center">${ppi[i]['ppi_jumlah']} ${ppi[i]['ppi_satuan']}</td>
                    <td class="text-right">${ppi[i]['ppi_harga']}</td>
                    <td class="text-center">${ppi[i]['ppis_used_date']}</td>
                    <td class="text-center">${ppi[i]['ppis_remark']}</td>
                </tr>
            `
        }

        $(`#body_valid`).html(items)
    }

    $(`#submit_sap`).on('click', function() {
        $('#validasi_view').modal('toggle');
        $('#myLoader').modal('toggle');

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/submit_sap') ?>',
            dataType: 'json',
            method: 'post',
            success: function(response){
                console.log(response);
                setTimeout(function() {
                    $('#myLoader').modal('toggle');
                    alert('Insert Success!')
                }, 1000);
            }
        });
    })

    // $(`#tipe`).on('change', function() {
    //     $('#myLoader').modal('toggle');
    //     let ppr = $('#selPR').hasClass('hide')
    //     if ($('#tipe').val() < 1) {
    //         if (ppr) {
    //         } else {
    //             $('#selPR').addClass('hide')
    //         }
    //     } else {
    //         $('#selPR').removeClass('hide')
    //     }
    //     $.ajax({
    //         url: "<?php echo site_url('perencanaan_pengadaan/get_divisi');?>",
    //         data: { 'tipe': 1 },
    //         method: "post",
    //         dataType: "json",
    //         success: function (data) {
    //             setTimeout(function() {
    //                 divisi = '<option value="">- Divisi -</option>';
    //                 $.each(data, function (i, item) {
    //                     divisi += '<option value="' + item.ppm_planner_pos_code +'">' + item.ppm_planner_pos_name + "</option>";
    //                 });
    //                 $("#divisi").html(divisi).removeAttr("disabled");
    //                 $("#project").html('<option value="">- Project -</option>').attr("disabled");
    //                 $("#pr").html('<option value="">- PR Number -</option>').attr("disabled");
    //                 $('#myLoader').modal('toggle');
    //             }, 1000);
    //         },
    //     });
    // })

    $(`#divisi`).on('change', function() {
        $('#myLoader').modal('toggle');
        $.ajax({
            url: "<?php echo site_url('perencanaan_pengadaan/get_project');?>",
            data: { 'divisi': $(`#divisi`).val() , 'tipe': 1 },
            method: "post",
            dataType: "json",
            success: function (data) {
                setTimeout(function() {
                    project = '<option value="">- Project -</option>';
                    $.each(data, function (i, item) {
                        project += '<option value="' + item.ppm_id +'">' + item.project + "</option>";
                    });
                    $("#project").html(project).removeAttr("disabled");
                    $("#pr").html('<option value="">- All PR Number -</option>').attr("disabled");
                    $('#myLoader').modal('toggle');
                }, 1000);
            },
        });
    })

    $(`#project`).on('change', function() {
        $('#myLoader').modal('toggle');

        let tipe = 1
        if (tipe == 0) {
            $("#pr").html('<option value="">- PR Number -</option>').attr("disabled");
            $('#myLoader').modal('toggle');
        } else {
            $.ajax({
                url: "<?php echo site_url('perencanaan_pengadaan/get_pr');?>",
                data: { 'ppm_id': $(`#project`).val() },
                method: "post",
                dataType: "json",
                success: function (data) {
                    setTimeout(function() {
                        pr = '<option value="">- PR Number -</option>';
                        $.each(data, function (i, item) {
                            pr += '<option value="' + item.ppm_id +'">' + item.ppis_pr_number + "</option>";
                        });
                        $("#pr").html(pr).removeAttr("disabled");
                        $('#myLoader').modal('toggle');
                    }, 1000);
                },
            });
        }

    })

    function show_detail() {
        let tipe = 1;
        let ppm_id = tipe < 1 ? $(`#project`).val() : $(`#pr`).val()
        $('#myLoader').modal('toggle');
        $.ajax({
            url: "<?php echo site_url('perencanaan_pengadaan/return_sap');?>",
            data: { 'ppm_id': ppm_id },
            method: "post",
            dataType: "json",
            success: function (data) {
                m = data.ppm
                i = data.ppi
                h = data.pph
                setTimeout(function() {
                    view_item(i)
                    view_hist_anggaran(h, i)
                    view_hist_volume(ppm_id)
                    $('#ppm_project_id').html(m.ppm_project_id)
                    $('#ppm_subject_of_work').html(m.ppm_subject_of_work)
                    $('#ppm_project_name').html(m.ppm_planner_pos_name)
                    $('#ppms_storage_loc').html(m.ppms_storage_loc != null ? m.ppms_storage_loc : '-')
                    $('#ppm_dept_name').html(m.ppm_dept_name)
                    $('#ppms_start_date').html(m.ppms_start_date)
                    $('#ppms_finish_date').html(m.ppms_finish_date)
                    $('#tgl_ppm_id').val(m.ppm_id)
                    if (m.ppms_tgl_tender != '') {
                        $(`#tgl_tender`).val(m.ppms_tgl_tender)
                    }
                    if (m.ppms_tgl_po != '') {
                        $(`#tgl_po`).val(m.ppms_tgl_po)
                    }
                    if (m.ppms_target_kedatangan != '') {
                        $(`#tgl_target`).val(m.ppms_target_kedatangan)
                    }
                    $('#head').removeClass('hide');
                    $('#myLoader').modal('toggle');
                }, 1000);
            },
        });
    }

    $(`#sbmt`).on('click', function() {
        let tipe = 1;
        //  let tipe = $(`#tipe`).val();
        if (tipe != '') {
            let pr = $(`#pr`).val()
            if (pr != '') {
                let tt = $('#by_table').hasClass('hide')
                if (tt) {
                } else {
                    $('#by_table').addClass('hide')
                }
                $('#by_section').removeClass('hide')
                show_detail()
            } else {
                let dd = $('#by_section').hasClass('hide')
                if (dd) {
                } else {
                    $('#by_section').addClass('hide')
                }
                $('#by_table').removeClass('hide')
                show_table()
            }
        } else {
            alert('Tipe Perencanaan harus dipilih!')
            return false
        }





        // if (tipe < 1) {
        //     let proj = $(`#project`).val();
        //     if (proj == '') {
        //         alert('Harus dipilih sampai project!')
        //         return false
        //     }
        // } else {
        //     let prr = $(`#pr`).val()
        //     if (prr == '') {
        //         alert('Harus dipilih sampai pr number!')
        //         return false
        //     }
        // }

        // let ppm_id = tipe < 1 ? $(`#project`).val() : $(`#pr`).val()
        // $('#myLoader').modal('toggle');
        // $.ajax({
        //     url: "<?php echo site_url('perencanaan_pengadaan/return_sap');?>",
        //     data: { 'ppm_id': ppm_id },
        //     method: "post",
        //     dataType: "json",
        //     success: function (data) {
        //         m = data.ppm
        //         i = data.ppi
        //         setTimeout(function() {
        //             view_item(i)
        //             $('#ppm_project_id').html(m.ppm_project_id)
        //             $('#ppm_subject_of_work').html(m.ppm_project_name)
        //             $('#ppm_project_name').html(m.ppm_project_name)
        //             $('#ppms_storage_loc').html(m.ppms_storage_loc != null ? m.ppms_storage_loc : '-')
        //             $('#ppm_dept_name').html(m.ppm_dept_name)
        //             $('#ppms_start_date').html(m.ppms_start_date)
        //             $('#ppms_finish_date').html(m.ppms_finish_date)
        //             $('#tgl_ppm_id').val(m.ppm_id)
        //             if (m.ppms_tgl_tender != '') {
        //                 $(`#tgl_tender`).val(m.ppms_tgl_tender)
        //             }
        //             if (m.ppms_tgl_po != '') {
        //                 $(`#tgl_po`).val(m.ppms_tgl_po)
        //             }
        //             if (m.ppms_target_kedatangan != '') {
        //                 $(`#tgl_target`).val(m.ppms_target_kedatangan)
        //             }
        //             $('#head').removeClass('hide');
        //             $('#myLoader').modal('toggle');
        //         }, 1000);
        //     },
        // });
    })

    function view_item(data) {
        let html = '';
        $.each(data, function(i,va) {
            ppicode = va.ppi_code
            if (!isNaN(parseInt(va.ppi_code))) {
                ppicode = parseInt(va.ppi_code)
            }
            html += `
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 row">
                            <div class="col-md-12 form-group">
                                <label class="col-sm-4 control-label text-bold-700">Nomor PR</label>
                                <div class="col-sm-8"> :
                                    <span id="ppis_pr_number${i}">${va.ppis_pr_number != null ? va.ppis_pr_number : '-'}</span>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="col-sm-4 control-label text-bold-700">Material Description</label>
                                <div class="col-sm-8"> :
                                    <span id="ppm_project_name${i}">${va.ppi_item_desc}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Kode Sumber Daya</label>
                                <div class="col-sm-8"> :
                                    <span id="ppi_code${i}">${ppicode}</span>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="col-sm-4 control-label text-bold-700">Volume</label>
                                <div class="col-sm-8"> :
                                    <span id="ppi_jumlah${i}">${va.ppi_jumlah} ${va.ppi_satuan}</span>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="col-sm-4 control-label text-bold-700">Harga Satuan</label>
                                <div class="col-sm-8"> :
                                    <span id="ppi_harga${i}">${va.ppi_harga}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-12 form-group">
                                <label class="col-md-4 control-label text-bold-700">Tanggal Pemakaian</label>
                                <div class="col-md-8"> :
                                    <span id="ppis_used_date${i}">${va.ppis_used_date != null ? va.ppis_used_date : '-'}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">WBS Element</label>
                                <div class="col-sm-8"> :
                                    <span id="ppis_wbs_element_desc${i}">${va.ppis_wbs_element != null ? va.ppis_wbs_element : '-'}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Network</label>
                                <div class="col-sm-8"> :
                                    <span id="ppis_network_desc${i}">${va.ppis_network_desc != null ? va.ppis_network_desc : '-'}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Remark</label>
                                <div class="col-sm-8"> :
                                    <span id="ppis_remark${i}">${va.ppis_remark != null ? va.ppis_remark : '-'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            `

            $('#itm').removeClass('hide');
            $('#content_item').html(html)
        })
    }

    function view_hist_anggaran(data, itm) {
        let urlpr = '<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat_permintaan')."/"; ?>'
        let urlrfq = '<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat')."/"; ?>'
        let urlctr = '<?php echo site_url('contract/monitor/monitor_kontrak/lihat')."/"; ?>'

        var descc = {
            0: 'Pembuatan Anggaran Awal',
            1010: 'Pembuatan Paket Pengadaan No. ',
            1000: 'Revisi Paket Pengadaan No. ',
            1904: 'Pembatalan Paket Pengadaan No. ',
            1040: 'dilanjutkan RFQ No. ',
            1902: 'Pembatalan RFQ No. ',
            2010: 'Selisih nilai hps dan nilai kontrak dengan No. '
        };

        // console.log(descc[0]);
        let body = '';
        $.each(data, function(i, v) {
            let act = ''
            let url = ''

            if (v.pph_desc == 0) {
                act = descc[0]
                url = ""
            } else if (v.pph_desc == 1010) {
                act = descc[1010]
                url = urlpr
            } else if (v.pph_desc == 1011) {
                act = descc[1010]
                url = urlpr
            } else if (v.pph_desc == 1012) {
                act = descc[1010]
                url = urlpr
            } else if (v.pph_desc == 1000) {
                act = descc[1000]
                url = urlpr
            } else if (v.pph_desc == 1904) {
                act = descc[1904]
                url = urlpr
            } else if (v.pph_desc == 1906) {
                act = descc[1904]
                url = urlpr
            } else if (v.pph_desc == 1040) {
                act = descc[1010] + "<a href = '"+urlpr+v.pph_first+"' target='_blank'>"+v.pph_first+"</a> dilanjutkan RFQ No. "
                url = urlrfq
            } else if (v.pph_desc == 1902) {
                act = descc[1040]
                url = urlrfq
            } else if (v.pph_desc == 2010) {
                act = descc[2010]
                url = urlrfq
            } else {
                act = ''
                url = ''
            }

            let urul = v.pph_mod != null ? `<a href="${url+v.pph_mod}" target="_blank">${v.pph_mod}</a>` : ''

            body += `
                <tr>
                    <td class="text-center">${i+1}</td>
                    <td class="text-center">${v.pph_date}</td>
                    <td class="text-right">${itm[0].ppi_mata_uang} ${v.pph_main != null ? v.pph_main : 0}</td>
                    <td class="text-right">${itm[0].ppi_mata_uang} ${v.pph_plus != null ? v.pph_plus : 0}</td>
                    <td class="text-right">${itm[0].ppi_mata_uang} ${v.pph_min != null ? v.pph_min : 0}</td>
                    <td class="text-right">${itm[0].ppi_mata_uang} ${v.pph_remain != null ? v.pph_remain : 0}</td>
                    <td class="text-left">${act} ${urul}</td>
                </tr>`
        })

        let table = `
            <table>
                <thead>
                <tr class="bgblue">
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-right">Angaran Sebelumnya</th>
                    <th class="text-right">Penambahan</th>
                    <th class="text-right">Pengurangan</th>
                    <th class="text-right">Anggaran Saat Ini</th>
                    <th class="text-left">Keterangan</th>
                </tr>
                </thead>
                <tbody>
                ${body}
                </tbody>
            </table>
        `

        $('#hist').removeClass('hide');
        $('#tbl_hist_anggaran').html(table)
        $('#tbl_hist_anggaran').DataTable();
    }

    function view_hist_volume(id) {
        var $table_history_volume = $('#table_history_volume'),
        selections = [];

        $table_history_volume.bootstrapTable({

          url: "<?php echo site_url('Procurement/perencanaan_pengadaan/history_volume').'?id=' ?>" + id,
          cookieIdTable:"monitor_pengadaan",
          idField:"ptm_number",
          <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
          columns: [
          {
            field: 'no',
            title: 'No',
            align: 'center',
            width:'10%',
            valign: 'middle'
          },
         {
            field: 'ppv_main',
            title: 'Volume Awal',
            sortable:true,
            order:true,
            searchable:true,
            align: 'center',
            valign: 'middle',
            width:'10%',
          }, {
            field: 'ppv_plus',
            title: 'Penambahan',
            sortable:true,
            order:true,
            searchable:true,
            align: 'left',
            valign: 'middle',
            width:'10%',
          },
          {
            field: 'ppv_minus',
            title: 'Pengurangan',
            sortable:true,
            order:true,
            searchable:true,
            align: 'left',
            valign: 'middle',
            width:'10%',
          },
          {
            field: 'ppv_remain',
            title: 'Volume Saat Ini',
            sortable:true,
            order:true,
            searchable:true,
            align: 'left',
            valign: 'middle',
            width:'10%',
          },
          {
            field: 'ppv_smbd_code',
            title: 'Kode Sumberdaya',
            sortable:true,
            order:true,
            searchable:true,
            align: 'left',
            valign: 'middle'
          },
          {
            field: 'smbd_name',
            title: 'Nama Sumberdaya',
            sortable:true,
            order:true,
            searchable:true,
            align: 'center',
            valign: 'middle',
            width:'25%',
          },
          {
            field: 'ppv_unit',
            title: 'Unit',
            sortable:true,
            order:true,
            searchable:true,
            align: 'center',
            valign: 'middle',
            width:'10%',
          },
          {
            field: 'status',
            title: 'Status',
            sortable:true,
            order:true,
            searchable:true,
            align: 'center',
            valign: 'middle',
            width:'25%',
          },
          ]

        });
        setTimeout(function () {
          $table_history_volume.bootstrapTable('resetView');
        }, 200);

        $table_history_volume.on('expand-row.bs.table', function (e, index, row, $detail) {
          $detail.html(detailFormatter(index,row,"alias"));
        });
    }
</script>

<script type="text/javascript">
    function load_modal_tgl(ppm_id) {
        $(`#tgl_ppm_id_m`).val(ppm_id)

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/get_tgl_sap') ?>',
            dataType: 'json',
            data: {'ppm_id': ppm_id},
            method: 'post',
            success: function(r){
                console.log(r);
                if (r.ppms_tgl_tender != '') {
                    $(`#tgl_tender_m`).val(r.ppms_tgl_tender)
                }
                if (r.ppms_tgl_po != '') {
                    $(`#tgl_po_m`).val(r.ppms_tgl_po)
                }
                if (r.ppms_target_kedatangan != '') {
                    $(`#tgl_target_m`).val(r.ppms_target_kedatangan)
                }
                $(`#inp_tanggal`).modal('toggle');
            }
        });

    }

    $(`#submit_tgl`).on('click', function() {
        $(`#inp_tanggal`).modal('toggle');
        $('#myLoader').modal('toggle');

        let tgl_tender = $(`#tgl_tender_m`).val()
        let tgl_po = $(`#tgl_po_m`).val()
        let tgl_target = $(`#tgl_target_m`).val()
        let ppm_id = $(`#tgl_ppm_id_m`).val()

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/submit_tgl_sap') ?>',
            dataType: 'json',
            data: {'tgl_po': tgl_po, 'tgl_tender': tgl_tender, 'tgl_target': tgl_target, 'ppm_id': ppm_id},
            method: 'post',
            success: function(response){
                console.log(response);
                setTimeout(function() {
                    $('#myLoader').modal('toggle');
                    alert('Insert Tanggal Success!')
                }, 1000);
            }
        });
    })

    // $(document).ready(function() {
    //     view_data('');
    // })
    //
    // $(`#tipe`).on('change', function() {
    //     search()
    // })

    function show_table() {
        view_data(1)
    }

    $("#cpr").keyup(function() {
        $("#cpr").val(this.value.match(/[0-9]*/));
    });

    function view_data(fil) {
        $(`#load_smbd`).toggleClass('hide');

        let rows = $('#show_rows').val();
        let page = p.length

        let cari_text = ''
        let tgl_pemakaian = ''
        let tipe = 1

        let send = {
            'rows': rows != undefined ? rows : 10,
            'page': page,
            'fil' : fil,
            'divisi': $(`#divisi`).val(),
            'project': $(`#project`).val(),
            'tipe': tipe,
            'nopr': $('#cpr').val()
        }

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/view_data_sap/matgis') ?>',
            method: 'post',
            data: send,
            dataType: 'json',
            success: function(data) {
                extract_table(data);
                $(`#load_smbd`).toggleClass('hide');
            }
        })
    }

    function extract_table(data) {
        let co = 0;
        const alphabet = "abcdefghijklmnopqrstuvwxyz".split("");

        let row = ''
        $.each(data.result, function(i,v) {
            items = v.item
            itr = ''
            $.each(items, function(id, va) {
                ppicode = va.ppi_code
                if (!isNaN(parseInt(va.ppi_code))) {
                    ppicode = parseInt(va.ppi_code)
                }
                console.log(ppicode);
                itr += `
                <tr>
                    <td class="text-center">-</td>
                    <td class="text-center">${ppicode}</td>
                    <td colspan="2">${va.ppi_item_desc}</td>
                    <td class="text-center">${va.ppi_jumlah} ${va.ppi_satuan}</td>
                    <td class="text-right">${va.ppi_harga}</td>
                    <td class="text-left">${va.ppis_used_date != null ? va.ppis_used_date : ''}</td>
                    <td class="text-center">${va.ppis_pr_number != null ? va.ppis_pr_number : ''}</td>
                    <td class="text-center">${va.ppis_pr_type != null ? va.ppis_pr_type : ''}</td>
                    <td class="text-center">${va.ppis_acc_assig != null ? va.ppis_acc_assig : ''}</td>
                    <td>${va.ppis_wbs_element != null ? va.ppis_wbs_element : ''}</td>
                    <td>${va.ppis_network_desc != null ? va.ppis_network_desc : ''}</td>
                    <td class="text-center">${va.ppis_remark != null ? va.ppis_remark : ''}</td>
                </tr>
                `
            })

            let dp = ''
            if (v.ppms_start_date != null && v.ppms_finish_date != null) {
                dp = v.ppms_start_date +' - '+ v.ppms_finish_date
            }
            row += `
            <tr class="header">
                <td class="text-center">${i+1}</td>
                <td class="text-center">${v.ppm_project_id}</td>
                <td class="text-center">${v.ppm_subject_of_work}</td>
                <td class="text-center">${v.ppm_planner_pos_name}</td>
                <td class="text-center">${v.ppms_storage_loc != null ? v.ppms_storage_loc : '' }</td>
                <td class="text-center">${v.ppm_dept_name}</td>
                <td>${dp}</td>
                <td class="text-center" colspan="5">${v.ppm_is_sap != 0 ? '' : ''}</td>
                <td class="text-center" onclick="load_modal_tgl('${v.ppm_id}')">
                    <a class="text-info"><i class=" fa fa-list"></i></a>
                </td>
            </tr>
            ${itr}
            `

            co = i + 1 + data.offset
        })

        let table = `
            <thead class="bgblue">
                <tr>
                    <th class="text-center" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Profit Center</th>
                    <th class="text-center">Project Definisi</th>
                    <th class="text-center">Divisi</th>
                    <th class="text-center">Storage Loc</th>
                    <th class="text-center">Purch. Group</th>
                    <th>Start-Finish Project</th>
                    <th class="text-center" rowspan="2">No PR</th>
                    <th class="text-center" rowspan="2">Tipe PR</th>
                    <th class="text-center" rowspan="2">Assignment</th>
                    <th class="text-left" rowspan="2">W8S Element</th>
                    <th class="text-center" rowspan="2">Network</th>
                    <th class="text-center" rowspan="2">Remark</th>
                </tr>
                <tr>
                    <th class="text-left " colspan="2">Material Desc</th>
                    <th class="text-center">Volume</th>
                    <th class="text-right">Harga Satuan</th>
                    <th clsss="text-right">Tgl. Pemakaian</th>
                </tr>
            </thead>
            ${row}
        `;

        create_pagination(data, table, co)
    }

    function create_pagination(data, table, co) {
        let disp = p.length < 1 ? -1 : 0;
        let dispp = p.length < 1 ? -1 : 0;

        let disnn = ''
        if (p.lenght < 1) {
            disn = 2 * 10 > data.num_rows ? -1 : 1;
            disnn = 2 * 10 > data.num_rows ? -1 : 1;
        } else {
            disn = (p.length+1) * 10 > data.num_rows ? -1 : 1;
            disnn = (p.length+1) * 10 > data.num_rows ? -1 : 1;
        }

        body = `<tr>
        <td colspan=2 class="text-left">
            Tampilkan
            <select name="show_rows" id="show_rows" onchange="change_rows()">
            <option value=10 ${data.shows == 10 ? 'selected' : ''}>10</option>
            <option value=25 ${data.shows == 25 ? 'selected' : ''}>25</option>
            <option value=50 ${data.shows == 50 ? 'selected' : ''}>50</option>
            <option value=100 ${data.shows == 100 ? 'selected' : ''}>100</option>
            </select>
            baris
        </td>
        <td colspan=3 class="text-center">
            Menampilkan ${data.num_rows == 0 ? 0 : data.offset + 1} sampai ${co} dari ${data.num_rows} data
        </td>
        <td colspan=2 class="text-right">
        <button type="button" class="btn btn-sm btn-light" name="button" onclick="next_pagination(${dispp}, '')"><<</button>
        <button type="button" class="btn btn-sm btn-light" name="button" onclick="get_pagination(${disp})"><</button>
        <button type="button" class="btn btn-sm btn-light" name="button" onclick="get_pagination(${disn})">></button>
        <button type="button" class="btn btn-sm btn-light" name="button" onclick="next_pagination(${disnn}, ${data.num_rows})">>></button>
        </td></tr>`

        $(`#pg_sap`).html(body)
        $(`#tbl_view_sap`).html(table)

    }

    function change_rows() {
        p = [];
        view_data('')
    }

    let p = [];
    function get_pagination(e) {
        if (e >= 0) {
            if (e == 0) {
                p.shift()
            } else {
                p.push(1)
            }
            view_data('')
        }
    }

    function next_pagination(e, all) {
        let rows = $('#show_rows').val();

        if (e >= 0) {
            if (e == 0) {
                p = []
            } else {
                p = []
                a = all % rows

                b = 0;
                if (a == 0) {
                    b = (all / rows) - 1
                } else {
                    b = (all - a) / rows
                }

                for (var i = 0; i < b; i++) {
                    p.push(1)
                }
            }

            view_data('')
        }
    }

</script>
