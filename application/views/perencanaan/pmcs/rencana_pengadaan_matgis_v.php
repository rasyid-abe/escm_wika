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
        color: #fff;
        /* text-transform: uppercase; */
        background-color: #2aace3
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form id="myFormId" action="<?php echo base_url('perencanaan_pengadaan/export_matgis') ?>" method="post">
                        <div class="row justify-content-end mb-2">
                            <div class="col-sm-1">
                                <span class="mr-3"> <div class="lds-hourglass hide" id="load_smbd"></div> </span>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control myform" name="cari_text" id="cari_text" placeholder="Cari ..."  autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control myform" name="datetimes" id="datetimes" placeholder="Date Filter">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <select class="form-control myform" id="se_divisi" name="se_divisi">
                                        <option value="">- Divisi -</option>
                                        <?php foreach ($divisi as $k => $v): ?>
                                            <option value="<?php echo $v['kddivisi'] ?>"><?php echo $v['divisiname'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control myform" name="datepicker" id="datepicker" placeholder="Periode">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control btn btn-info btn-sm" onclick="search();"><i class="fa fa-search mt-1"></i>&nbsp; Cari</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <button type="submit" class="form-control btn btn-info btn-sm"><i class=" fa fa-print"></i>&nbsp; Export</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="" style="overflow-x:auto;">
                        <table id="tbl_smbd" class="styled-table" cellpadding="0" cellspacing="0" border="0">
                            <tr><th class="text-center">Memuat data ...</th></tr>
                        </table>
                    </div>
                    <table width="100%" id="smbd_pagination" class="table"></table>
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
</script>

<script type="text/javascript">

    $(document).ready(function() {
        $(`#datetimes`).val('')
        data_rencana_pengadaan('');
    })

    function search() {
        data_rencana_pengadaan(1)
    }

    function data_rencana_pengadaan(fil) {
        $(`#load_smbd`).toggleClass('hide');

        let rows = $('#show_rows').val();
        let page = p.length

        let send = {
            'rows': rows != undefined ? rows : 10,
            'page': page,
        }

        if (fil != '') {
            send.fil = 1
            send.free_text = $(`#cari_text`).val()
            send.b_date = $(`#datetimes`).val()
            send.period = $(`#datepicker`).val()
            send.divisi = $(`#se_divisi`).val()
        }

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/data_rencana_pengadaan_matgis') ?>',
            method: 'post',
            data: send,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                extract_table(data);
                $(`#load_smbd`).toggleClass('hide');
            }
        })
    }

    function extract_table(data) {
        let table = `
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Kode Sumber Daya</th>
                <th class="text-center">Nama Sumber Daya</th>
                <th class="text-center">Nama Proyek</th>
                <th class="text-center">Divisi</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">volume</th>
                <th class="text-center">Harga Satuan</th>
                <th class="text-center">Total Harga</th>
                <th class="text-center">Sisa Volume</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Kasie Pengadaan</th>
                <th class="text-center">Tanggal Singkron</th>
                <th class="text-center">Periode</th>
                <th class="text-center">Aksi</th>
            </tr>
        `;
        let l = '<?php echo site_url('procurement/detail_rencana_pengadaan') ?>'
        let co = 0;

        $.each(data.result, function(i,v) {
            co = i + 1 + data.offset
            table += `
                <tr>
                    <td class="text-center">${co}</td>
                    <td class="text-center">${v.smbd_code}</td>
                    <td>${v.smbd_name}</td>
                    <td>${v.project_name}</td>
                    <td>${v.divisiname}</td>
                    <td class="text-center">${v.unit}</td>
                    <td class="text-right">${v.smbd_quantity}</td>
                    <td class="text-right">${v.price}</td>
                    <td class="text-right">${v.total}</td>
                    <td class="text-right">${v.ppv_remain}</td>
                    <td>${v.lokasi}</td>
                    <td>${v.user_name}</td>
                    <td>${v.updated_date}</td>
                    <td>${v.periode_pengadaan}</td>
                    <td class="text-center" style="margin-top: -20px;">
                        <a href="${l}/${v.smbd_code}" target="_blank"><i class=" fa fa-list"></i></a>
                    </td>
                </tr>
            `;

        })
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

        $(`#smbd_pagination`).html(body)
        $(`#tbl_smbd`).html(table)
    }

    function change_rows() {
        p = [];
        data_rencana_pengadaan('')
    }

    let p = [];
    function get_pagination(e) {
        if (e >= 0) {
            if (e == 0) {
                p.shift()
            } else {
                p.push(1)
            }
            data_rencana_pengadaan('')
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

            data_rencana_pengadaan('')
        }
    }
</script>
