<style>
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
        background-color: #2aace3;
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

    .hide {
        display: none;
    }

    .myform {
        border: 2px solid #2F8BE6;
    }

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div id="inp_tanggal" class="modal fade bd-example-modal-md" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Input Tanggal</h4>
			</div>
			<div class="modal-body">
                <input type="hidden" id="tgl_ppm_id" name="tgl_ppm_id" value="">
                <div class="form-group row">
                    <label for="tgl_tender" class="col-sm-4 col-form-label">Tanggal Tender</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="tgl_tender">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_po" class="col-sm-4 col-form-label">Tanggal PO</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="tgl_po">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_target" class="col-sm-4 col-form-label">Target Kedatangan</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="tgl_target">
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

<div id="validasi_view" class="modal fade bd-example-modal-xl" role="dialog">
	<div class="modal-dialog modal-xl">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Validasi Data</h4>
			</div>
			<div class="modal-body">
                <table class="styled-table">
                    <tr>
                        <th class="text-center" rowspan="2">No</th>
                        <th class="text-center" rowspan="2">Profit Center</th>
                        <th class="text-center">Project Definisi</th>
                        <th class="text-center">Divisi</th>
                        <th class="text-center">Storage Loc</th>
                        <th class="text-center">Purch. Group</th>
                        <th class="text-center">Start-Finish Project</th>
                        <th class="text-center" rowspan="2">No PR</th>
                        <th class="text-center" rowspan="2">W8S Element</th>
                        <th class="text-center" rowspan="2">Network</th>
                        <th class="text-center" rowspan="2">Remark</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="2">Material Desc</th>
                        <th class="text-center">Volume</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Tgl. Pemakaian</th>
                    </tr>
                    <tbody id="body_valid"></tbody>
                </table>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_sap" class="btn btn-primary">Validasi</button>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form id="myFormId" action="<?php echo base_url('perencanaan_pengadaan/import_json') ?>" method="post">
                        <div class="row justify-content-end mb-2">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" id="tipe" name="tipe">
                                        <option value="">- Tipe Perencanaan -</option>
                                        <option value="0">PMCS</option>
                                        <option value="1">SAP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <span class="mr-3"> <div class="lds-hourglass hide" id="load_smbd"></div> </span>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="cari_text" id="cari_text" placeholder="Cari ..."  autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="tgl_pemakaian" id="tgl_pemakaian" placeholder="Cari ..."  autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-control btn btn-info btn-sm" onclick="search();"><i class="fa fa-search mt-1"></i>&nbsp; Cari</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <button type="button" class="form-control btn btn-info btn-sm" data-toggle="modal" data-target="#uploadfiles"><i class=" fa fa-upload"></i>&nbsp; Import</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <button type="submit" class="form-control btn btn-info btn-sm"><i class=" fa fa-print"></i>&nbsp; Export</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    <!-- </form> -->
                    <div class="" style="overflow-x:auto;">
                        <table id="tbl_view_sap" class="styled-table" cellpadding="0" cellspacing="0" border="0">
                            <tr><th class="text-center">Memuat data ...</th></tr>
                        </table>
                    </div>
                    <table width="100%" id="pg_sap" class="table"></table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>

    $("#datepicker").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months"
    });

    $(function() {
        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'YYYY/MM/DD HH:mm'
            }
        });
    });

    function load_modal_tgl(ppm_id) {
        $(`#tgl_ppm_id`).val(ppm_id)

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/get_tgl_sap') ?>',
            dataType: 'json',
            data: {'ppm_id': ppm_id},
            method: 'post',
            success: function(r){
                console.log(r);
                if (r.ppms_tgl_tender != '') {
                    $(`#tgl_tender`).val(r.ppms_tgl_tender)
                }
                if (r.ppms_tgl_po != '') {
                    $(`#tgl_po`).val(r.ppms_tgl_po)
                }
                if (r.ppms_target_kedatangan != '') {
                    $(`#tgl_target`).val(r.ppms_target_kedatangan)
                }
                $(`#inp_tanggal`).modal('toggle');
            }
        });

    }

    $(`#submit_tgl`).on('click', function() {
        $(`#inp_tanggal`).modal('toggle');
        $('#myLoader').modal('toggle');

        let tgl_tender = $(`#tgl_tender`).val()
        let tgl_po = $(`#tgl_po`).val()
        let tgl_target = $(`#tgl_target`).val()
        let ppm_id = $(`#tgl_ppm_id`).val()

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
    });

    function view_validate(ppm, ppi) {
        let items = ''
        for (var i = 0; i < ppm.length; i++) {
            items += `
                <tr class="header">
                    <td class="text-center">${i+1}</td>
                    <td class="text-center">${ppm[i]['ppm_project_id']}</td>
                    <td>${ppm[i]['ppm_subject_of_work']}</td>
                    <td class="text-center">${ppm[i]['ppm_project_name']}</td>
                    <td class="text-center">${ppm[i]['ppms_storage_loc']}</td>
                    <td class="text-center">${ppm[i]['ppms_dept_id']}</td>
                    <td colspan="5">${ppm[i]['ppms_start_date']} - ${ppm[i]['ppms_finish_date']}</td>
                </tr>
                <tr>
                    <td class="text-center">-</td>
                    <td class="text-center">${ppi[i]['ppi_code']}</td>
                    <td colspan="2">${ppi[i]['ppi_item_desc']}</td>
                    <td class="text-center">${ppi[i]['ppi_jumlah']} ${ppi[i]['ppi_satuan']}</td>
                    <td class="text-right">${ppi[i]['ppi_harga']}</td>
                    <td class="text-center">${ppi[i]['ppis_used_date']}</td>
                    <td>${ppi[i]['ppis_pr_number']}</td>
                    <td>${ppi[i]['ppis_wbs_element_desc']}</td>
                    <td>${ppi[i]['ppis_network_desc']}</td>
                    <td class="text-center">${ppi[i]['ppis_remark']}</td>
                </tr>
            `
        }

        $(`#body_valid`).html(items)
    }
</script>


<script type="text/javascript">

    $(document).ready(function() {
        $(`#datetimes`).val('')
        view_data('');
    })

    $(`#tipe`).on('change', function() {
        search()
    })

    function search() {
        view_data(1)
    }

    function view_data(fil) {
        $(`#load_smbd`).toggleClass('hide');

        let rows = $('#show_rows').val();
        let page = p.length

        let cari_text = $(`#cari_text`).val()
        let tgl_pemakaian = $(`#tgl_pemakaian`).val()
        let tipe = $(`#tipe`).val()

        let send = {
            'rows': rows != undefined ? rows : 10,
            'page': page,
        }

        if (fil != '') {
            send.fil = 1
            send.free_text = cari_text
            send.tgl_pemakaian = tgl_pemakaian
            send.tipe = tipe
        }

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/view_data_sap') ?>',
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
                itr += `
                <tr>
                    <td class="text-center">-</td>
                    <td class="text-center">${va.ppi_code}</td>
                    <td colspan="2">${va.ppi_item_desc}</td>
                    <td class="text-center">${va.ppi_jumlah} ${va.ppi_satuan}</td>
                    <td class="text-right">${va.ppi_harga}</td>
                    <td class="text-center">${va.ppis_used_date != null ? va.ppis_used_date : ''}</td>
                    <td>${va.ppis_pr_number != null ? va.ppis_pr_number : ''}</td>
                    <td>${va.ppis_wbs_element_desc != null ? va.ppis_wbs_element_desc : ''}</td>
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
                <td>${v.ppm_project_name}</td>
                <td class="text-center">${v.ppm_project_name}</td>
                <td class="text-center">${v.ppms_storage_loc != null ? v.ppms_storage_loc : '' }</td>
                <td class="text-center">${v.ppm_dept_name}</td>
                <td>${dp}</td>
                <td class="text-center" colspan="3">${v.ppm_is_sap != 0 ? 'SAP' : 'PMCS'}</td>
                <td class="text-center" onclick="load_modal_tgl('${v.ppm_id}')">
                    <a class="text-info"><i class=" fa fa-list"></i></a>
                </td>
            </tr>
            ${itr}
            `

            co = i + 1 + data.offset
        })

        let table = `
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Profit Center</th>
                    <th class="text-center">Project Definisi</th>
                    <th class="text-center">Divisi</th>
                    <th class="text-center">Storage Loc</th>
                    <th class="text-center">Purch. Group</th>
                    <th>Start-Finish Project</th>
                    <th class="text-center" rowspan="2">No PR</th>
                    <th class="text-center" rowspan="2">W8S Element</th>
                    <th class="text-center" rowspan="2">Network</th>
                    <th class="text-center" rowspan="2">Remark</th>
                </tr>
                <tr>
                    <th class="text-center" colspan="2">Material Desc</th>
                    <th class="text-center">Volume</th>
                    <th class="text-center">Harga Satuan</th>
                    <th>Tgl. Pemakaian</th>
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
