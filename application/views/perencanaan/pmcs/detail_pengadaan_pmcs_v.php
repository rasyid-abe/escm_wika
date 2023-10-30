<style>

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
    <div class="col-sm-12">
        <table class="mt-3" width=100%>
            <tr>
                <th colspan="7"> <h5><b>Headline</b></h5> </th>
            </tr>
            <tr>
                <td width=18%><b>Kode Sumberdaya</b></td>
                <td>:</td>
                <td><?php echo $kode_smbd ?></td>
                <td>&nbsp;</td>
                <td width=18%><b>Harga Satuan</b></td>
                <td>:</td>
                <td><?php echo $head['price'] ?></td>
            </tr>
            <tr>
                <td width=18%><b>Nama Sumberdaya</b></td>
                <td>:</td>
                <td><?php echo $head['smbd_name'] ?></td>
                <td>&nbsp;</td>
                <td width=18%><b>Total Anggaran</b></td>
                <td>:</td>
                <td><?php echo $head['total'] ?></td>
            </tr>
            <tr>
                <td width=18%><b>Volume</b></td>
                <td>:</td>
                <td><?php echo $head['smbd_quantity'] ?></td>
                <td>&nbsp;</td>
                <td width=18%><b>Tanggal Update</b></td>
                <td>:</td>
                <td><?php echo $head['updated_date'] ?></td>
            </tr>
            <tr>
                <td width=18%><b>Satuan</b></td>
                <td>:</td>
                <td><?php echo $head['unit'] ?></td>
                <td>&nbsp;</td>
                <td width=18%></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-header border-bottom pb-2">
                    <div class="d-flex justify-content-between">
                        <span class="card-title text-bold-600 mr-2">History Volume Pengadaan</span>
                        <span class="mr-2"> <div class="lds-hourglass hide" id="load_volume"></div> </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="overflow-x:auto;">
                        <table width=100% class="radio-toolbar mb-2" id="tblvol">
                            <tr><th class="text-center">Loading data...</th></tr>
                        </table>
                    </div>
                    <table width="100%" id="vol_pagination" class="table"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-header border-bottom pb-2">
                    <div class="d-flex justify-content-between">
                        <span class="card-title text-bold-600 mr-3">History Pengadaan</span>
                        <span class="mr-2"> <div class="lds-hourglass hide" id="load_hist"></div> </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-end mb-2">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" name="datetimes" value="" id="dts" class="form-control myform" autocomplete="off" placeholder="Date Filter">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" id="search_history" class="form-control myform" placeholder=" Search" class="search"/>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <button type="button" class="form-control btn btn-info btn-block btn-sm" onclick="search();"><i class=" fa fa-search">Cari</i></button>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <button type="button" class="form-control btn btn-info btn-block btn-sm" onclick="fnExcelReport('tbl_history');"><i class=" fa fa-print">Export</i></button>
                            </div>
                        </div>
                    </div>
                    <table width=100% id="tbl_history" class="table table-sm">
                        <tr><th class="text-center">Memuat data ...</th></tr>
                    </table>
                    <table width="100%" id="his_pagination" class="table"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<iframe id="txtArea1" style="display:none"></iframe>
<!-- Modal -->
<div class="modal fade" id="modal_val" tabindex="-1" role="dialog" aria-labelledby="modal_valTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <select name="month" class="form-control" id="period_month"></select>
                <select name="year" class="form-control" id="period_year"></select>
                <input type="hidden" name="ids_ppi" id="ids_ppi" value="">
                <input type="hidden" name="vol_ppi" id="vol_ppi" value="">
                <input type="hidden" name="smbd_code" id="smbd_code" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_period()">Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $("#datepicker").datepicker( {
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months"
    });

    $(function() {
        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('day').subtract(6, 'day'),
            endDate: moment().startOf('day').add(1, 'day'),
            locale: {
                format: 'YYYY/MM/DD HH:mm'
            }
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function () {
    $('#dts').val('')
    get_list_volume()
    get_list_history('')
})

function fnExcelReport(tbl)
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById(tbl); // id of table

    for(j = 0 ; j < tab.rows.length ; j++)
    {
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }
    else                 //other browser not tested on IE 11
    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

    return (sa);
}

// ##================== START VOLUME ==================## //

let pa = [];
function get_pagination_a(e) {
    if (e >= 0) {
        if (e == 0) {
            pa.shift()
        } else {
            pa.push(1)
        }
        get_list_volume()
    }
}

function next_pagination_a(e, all) {
    let rows = $('#show_rows').val();

    if (e >= 0) {
        if (e == 0) {
            pa = []
        } else {
            pa = []
            a = all % rows
            b = 0;
            if (a == 0) {
                b = (all / rows) - 1
            } else {
                b = (all - a) / rows
            }
            for (var i = 0; i < b; i++) {
                pa.push(1)
            }
        }

        get_list_volume()
    }
}

function create_pagination_a(data, table, co) {
    let disp = pa.length < 1 ? -1 : 0;
    let dispp = pa.length < 1 ? -1 : 0;

    let disnn = ''
    if (pa.lenght < 1) {
        disn = 2 * 10 > data.num_rows ? -1 : 1;
        disnn = 2 * 10 > data.num_rows ? -1 : 1;
    } else {
        disn = (pa.length+1) * 10 > data.num_rows ? -1 : 1;
        disnn = (pa.length+1) * 10 > data.num_rows ? -1 : 1;
    }

    body = `<tr>
    <td colspan=2 class="text-left">
    Tampilkan
    <select name="show_rows" id="show_val" onchange="change_rows_a()">
    <option value=10 ${data.shows == 10 ? 'selected' : ''}>10</option>
    <option value=25 ${data.shows == 25 ? 'selected' : ''}>25</option>
    <option value=50 ${data.shows == 50 ? 'selected' : ''}>50</option>
    <option value=100 ${data.shows == 100 ? 'selected' : ''}>100</option>
    </select>
    baris
    </td>
    <td colspan=3 class="text-center">Menampilkan ${data.num_rows == 0 ? 0 : data.offset + 1} sampai ${co} dari ${data.num_rows} data</td>
    <td colspan=2 class="text-right">
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="next_pagination_a(${dispp}, '')"><<</button>
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="get_pagination_a(${disp})"><</button>
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="get_pagination_a(${disn})">></button>
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="next_pagination_a(${disnn}, ${data.num_rows})">>></button>
    </td></tr>`

    $(`#vol_pagination`).html(body)
    $(`#tblvol`).html(table)
}

function change_rows_a() {
    pa = [];
    get_list_volume()
}

function search_a(ele) {
    if(event.key === 'Enter') {
        get_list_volume()
    }
}

function get_list_volume() {
    $(`#load_volume`).toggleClass('hide');
    let se = $('input[name=search_vol]').val();
    let rows = $('#show_val').val();
    let page = pa.length

    $.ajax({
        url: '<?php echo base_url('perencanaan_pengadaan/get_list_volume') ?>',
        method: 'post',
        data: {
            'smbd_code':'<?php echo $kode_smbd ?>',
            'rows': rows != undefined ? rows : 10,
            'page': page,
            'search': se != undefined ? se : '',
        },
        dataType: 'json',
        success: function(res) {
            extract_table_volume(res);
            $(`#load_volume`).toggleClass('hide');
        }
    })
}

function extract_table_volume(val) {
    let head = `
    <tr>
    <th>Tahun</th>
    <th>Satuan</th>
    <th width=7%>Januari</th>
    <th width=7%>Februari</th>
    <th width=7%>Maret</th>
    <th width=7%>April</th>
    <th width=7%>Mei</th>
    <th width=7%>Juni</th>
    <th width=7%>Juli</th>
    <th width=7%>Agustus</th>
    <th width=7%>September</th>
    <th width=7%>Oktober</th>
    <th width=7%>November</th>
    <th width=7%>Desember</th>
    </tr>
    `;

    let co = 0;
    $.each(val.volume, function(i, v) {
        co = i + 1 + val.offset
        tds = ``
        for (var j = 0; j < v.vol.length; j++) {
            tds += `
            <td>
            <input type="button"
            name="btn_val"
            value="${v.vol[j]}"
            class="btn btn-sm btn-light text-left"
            onclick="show_modal_change('btn_${v.year}_${j}')"
            style="width: 100%; font-size: 9pt"
            id="btn_${v.year}_${j}"
            data-year="${v.year}"
            data-month="${j}"
            data-ids="${v.ids[j]}"
            data-smbd="<?php echo $kode_smbd ?>"></input>
            </td>
            `;
        }
        head += `
        <tr>
        <td>${v.year}</td>
        <td>${v.unit}</td>
        ${tds}
        </tr>
        `;
    })

    // $(`#tblvol`).html(head)
    create_pagination_a(val, head, co)
}

function show_modal_change(uniq) {
    let month = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    let vss = $(`#${uniq}`)

    if (vss.val() > 0) {
        var opt_month = '<option value="">Pilih Bulan</option>';
        for (var i = 0; i < month.length; i++) {
            selm = ""
            if (i == vss.data('month')) { selm = "selected" }
            opt_month += '<option value="'+i+'" '+selm+'>'+month[i]+'</option>'
        }
        $(`#period_month`).html(opt_month)

        var year = <?php echo $year['min'] ?>;
        var till = <?php echo $year['max'] ?>;

        opt_year = '<option value="">Pilih Tahun</option>';
        for(var y=year; y<=till; y++){
            sely = ""
            if (y == vss.data('year')) { sely = "selected" }
            opt_year += "<option value='"+y+"' "+sely+">"+ y +"</option>";
        }
        $(`#period_year`).html(opt_year)

        $(`#ids_ppi`).val(vss.data('ids'))
        $(`#vol_ppi`).val(vss.val());
        $(`#smbd_code`).val(vss.data('smbd'));


        $(`#modal_val`).modal('toggle');
    }

}

function save_period() {
    $(`#modal_val`).modal('toggle');
    $('#myLoader').modal('toggle');

    let m = $(`#period_month`).val()
    let y = $(`#period_year`).val()
    let i = $(`#ids_ppi`).val()
    let v = $(`#vol_ppi`).val()
    let s = $(`#smbd_code`).val()

    $.ajax({
        url: '<?php echo base_url('perencanaan_pengadaan/change_period') ?>',
        method: 'post',
        data: {'i':i, 'm':m, 'y':y, 'v':v, 's':s},
        dataType: 'json',
        success: function(res) {
            get_list_history('')
            get_list_volume()
            setTimeout(function() {
                $('#myLoader').modal('toggle');
            }, 1000);
        }
    })
}

// ##================== END VOLUME ==================## //


// ##================== START HISTORY ==================## //

let p = [];
function get_pagination(e) {
    if (e >= 0) {
        if (e == 0) {
            p.shift()
        } else {
            p.push(1)
        }
        get_list_history('')
    }
}

function next_pagination(e, all) {
    let rows = $('#show_history').val();

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

        get_list_history('')
    }
}

function search() {
    get_list_history(1)
}

function get_list_history(fil) {
    $(`#load_hist`).toggleClass('hide');
    let rows = $('#show_history').val();
    let page = p.length

    let send = {
        'smbd_code':'<?php echo $kode_smbd ?>',
        'page' : page,
        'rows' : rows != undefined ? rows : 10,
    }

    if (fil != '') {
        send.fil = 1
        send.search = $(`#search_history`).val()
        send.date = $(`#dts`).val()
    }

    $.ajax({
        url: '<?php echo base_url('perencanaan_pengadaan/detail_rencana_pengadaan_history') ?>',
        method: 'post',
        data: send,
        dataType: 'json',
        success: function(res) {
            extract_table_history(res);
            $(`#load_hist`).toggleClass('hide');
        }
    })
}

function extract_table_history(data) {
    let table = `
    <tr>
    <th class="text-center">No</th>
    <th>Proyek</th>
    <th>Deskripsi</th>
    <th>Kasie Pengadaan</th>
    <th>Tanggal Update</th>
    <th>Lokasi</th>
    <th class="text-right">Sisa Volume</th>
    </tr>
    `;

    let co = 0;
    $.each(data.result, function(i,v) {
        co = i + 1 + data.offset
        table += `
        <tr>
        <td class="text-center">${co}</td>
        <td>${v.project_name}</td>
        <td>${v.ppv_no}</td>
        <td>${v.user_name}</td>
        <td>${v.created_datetime}</td>
        <td>${v.lokasi}</td>
        <td class="text-right">${v.ppv_remain}</td>
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
    <select name="show_rows" id="show_history" onchange="change_rows()">
    <option value=10 ${data.shows == 10 ? 'selected' : ''}>10</option>
    <option value=25 ${data.shows == 25 ? 'selected' : ''}>25</option>
    <option value=50 ${data.shows == 50 ? 'selected' : ''}>50</option>
    <option value=100 ${data.shows == 100 ? 'selected' : ''}>100</option>
    </select>
    baris
    </td>
    <td colspan=3 class="text-center">Menampilkan ${data.num_rows == 0 ? 0 : data.offset + 1} sampai ${co} dari ${data.num_rows} data</td>
    <td colspan=2 class="text-right">
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="next_pagination(${dispp}, '')"><<</button>
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="get_pagination(${disp})"><</button>
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="get_pagination(${disn})">></button>
    <button type="button" class="btn btn-sm btn-light" name="button" onclick="next_pagination(${disnn}, ${data.num_rows})">>></button>
    </td></tr>`

    $(`#his_pagination`).html(body)
    $(`#tbl_history`).html(table)
}

function change_rows() {
    p = [];
    get_list_history('')
}

// ##================== END HISTORY ==================## //

</script>
