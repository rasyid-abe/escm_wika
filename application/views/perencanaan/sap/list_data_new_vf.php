<style media="screen">
    .styled-table {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        width: 100%;
    }

    .styled-table td {
        padding: 4px;
        vertical-align:middle;
        font-weight: 300;
        font-size: 12px;
        color: black;
        border-bottom: solid 1px gray;
    }
    .styled-table th {
        padding: 10px 7px;
        /* font-weight: bold; */
        text-align: center;
        font-size: 12px;
        color: white;
        border: 2px solid white;
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
        font-weight: bold;
        font-size: 14;
        padding-left: 2px;
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

    .hide {
        display: none;
    }

</style>

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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header border-bottom">
                <div class="row justify-content-end mb-2">
                    <div class="col-sm-1 pt-1">
                        <span class="card-title text-bold-600 mr-2">Filter Data <i class="ft-document"></i></span>
                    </div>
                    <div class="col-sm-8 mb-2">
                        <div class="row">
                            <div class="col-sm-3 styleSelect">
                                <select class="form-control bg-select pgs" id="pg" name="pg">
                                    <option value="">Purchasing Group</option>
                                    <?php foreach ($pg as $k => $v): ?>
                                        <option value="<?php echo $v['ppm_dept_id'] ?>"><?php echo $v['dep_code']."-".$v['ppm_dept_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-3 styleSelect">
                                <select class="form-control bg-select proj" id="project" name="project">
                                    <option value="">Project</option>
                                    <?php foreach ($proj as $k => $v): ?>
                                        <option value="<?php echo $v['ppm_project_id'] ?>"><?php echo $v['ppm_subject_of_work'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-3 styleSelect">
                                <select class="form-control bg-select" id="prtype" name="prtype">
                                    <option value="">PR Type</option>
                                    <?php foreach ($type as $k => $v): ?>
                                        <option value="<?php echo $v['ppis_pr_type'] ?>"><?php echo $v['ppis_pr_type'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-3 styleSelect">
                                <select class="form-control bg-select prs" id="pr" name="pr">
                                    <option value="">No. PR</option>
                                    <?php foreach ($pr as $k => $v): ?>
                                        <option value="<?php echo $v['ppis_pr_number'] ?>"><?php echo $v['ppis_pr_number'] ?></option>
                                    <?php endforeach; ?>
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
                    <div class="col-sm-1">
                        <div class="form-group">
                            <form class="" action="<?php echo base_url('dir') ?>" method="post">
                                <button type="submit" class="form-control btn btn-secondary btn-sm" id="upload_ftp"><i class=" fa fa-upload"></i>&nbsp; FTP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="by_table">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="col-sm-4">
                        <select class="form-control bg-select" id="orby" name="orby">
                            <option value="">- Order By -</option>
                            <option value="ppms_start_date">Req Date</option>
                            <option value="ppms_finish_date">Dev Date</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control bg-select" id="orty" name="orty">
                            <option value="">- Order Type -</option>
                            <option value="asc">A - Z</option>
                            <option value="desc">Z - A</option>
                        </select>
                    </div>
                </div>
                <div class="col-3 col-md-1">
                    <span class="mr-3"> <div class="lds-hourglass hide" id="load_smbd"></div> </span>
                </div>
                <div class="col-6 col-md-4">
                    <label class="col-sm-4 text-right control-label text-bold-700 mt-2"></label>
                    <div class="col-sm-8">
                        <input type="text" style="border: 1px solid gray;" class="form-control" id="altex" onchange="show_table()" name="altex" value="" placeholder="Search All">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="" style="overflow-x:auto;">
                <table id="tbl_view_sap" class="styled-table">
                    <tr><th class="text-center bgblue">Memuat data ...</th></tr>
                </table>
            </div>
            <table width="100%" id="pg_sap" class="table"></table>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('#pr').addClass('hide')
        $('#pg').addClass('hide')
        $('#project').addClass('hide')
        $('.prs').select2({width: '100%'})
        $('.pgs').select2({width: '100%'})
        $('.proj').select2({width: '100%'})
        show_table()
    });

    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });

    $(`#sbmt`).on('click', function() {
        let orby = $('#orby').val()
        let orty = $('#orty').val()
        if ((orby != '') && (orty == '')) {
            alert('Order By dan Order Type harus diisi!')
        } else if ((orby == '') && (orty != '')) {
            alert('Order By dan Order Type harus diisi!')
        } else {
            view_data(1)
        }
    })

</script>

<script type="text/javascript">
    function show_table() {
        view_data(1)
    }

    function view_data(fil) {
        $(`#load_smbd`).toggleClass('hide');

        let rows = $('#show_rows').val();
        let page = p.length

        let cari_text = ''
        let tgl_pemakaian = ''

        let send = {
            'drup': 0,
            'proyek': 'proyek',
            'rows': rows != undefined ? rows : 10,
            'page': page,
            'fil' : fil,
            'pg': $('#pg').val(),
            'project': $('#project').val(),
            'prtype': $('#prtype').val(),
            'pr': $('#pr').val(),
            'orby': $('#orby').val(),
            'orty': $('#orty').val(),
            'altex': $('#altex').val()
        }

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/view_data_sap_new') ?>',
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
            stt = 0
            items = v.item
            itr = ''
            $.each(items, function(id, va) {
                ppicode = va.ppi_code
                if (!isNaN(parseInt(va.ppi_code))) {
                    ppicode = parseInt(va.ppi_code)
                }

                stst = 'T'
                if (va.ptm_status == null) {
                    stst = "N"
                } else if (va.ptm_status >= 2903) {
                    stst = "D"
                }
                itr += `
                <tr>
                    <td class="text-center">${id+1}</td>
                    <td class="text-center">${va.ppis_pr_number}</td>
                    <td class="text-center">${va.ppis_acc_assig}</td>
                    <td class="text-center">${parseInt(va.ppis_pr_item)}</td>
                    <td class="text-center">${ppicode}</td>
                    <td class="text-left">&nbsp;${va.ppi_item_desc}</td>
                    <td class="text-center">${v.ppm_dept_name}</td>
                    <td class="text-center">${va.ppi_satuan}</td>
                    <td class="text-right">${va.ppi_jumlah}</td>
                    <td class="text-right">${formatter.format(va.ppi_harga)}</td>
                    <td class="text-right">${formatter.format(va.ppi_harga * va.ppi_jumlah)}</td>
                    <td class="text-center">${v.ppms_start_date}</td>
                    <td class="text-center">${va.ppis_delivery_date}</td>
                    <td class="text-center">${va.ppi_update_at != null ? va.ppi_update_at : '-'}</td>
                    <td class="text-center">${va.status_rkp}</td>
                </tr>
                `

                stt += (va.ppi_harga * va.ppi_jumlah)
            })

            let dp = ''
            if (v.ppms_start_date != null && v.ppms_finish_date != null) {
                dp = v.ppms_start_date +' - '+ v.ppms_finish_date
            }
            row += `
            <tr class="header">
                <td class="text-left" colspan="15" style="font-weight:bold;">
                &nbsp;&nbsp;${v.ppis_pr_type}, ${v.ppm_project_id}, Project Def : ${v.ppm_project_name}, TCM : ${formatter.format(stt)} , Total Cost Plan BL : Rp. 0
                </td>
            </tr>
            ${itr}
            `

            co = i + 1 + data.offset
        })

        let table = `
            <thead class="bgblue">
                <tr>
                    <th>No</th>
                    <th>PR</th>
                    <th>A</th>
                    <th>Line</th>
                    <th>Kode SDA</th>
                    <th>Deskripsi</th>
                    <th>PG</th>
                    <th>UOM</th>
                    <th>Qty</th>
                    <th>Harsat</th>
                    <th>Subtotal</th>
                    <th>Req Date</th>
                    <th>Dev Date</th>
                    <th>Update Date</th>
                    <th>Status</th>
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
