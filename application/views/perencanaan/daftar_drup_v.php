<!--
<div class="row">
<div class="col-12">
<div class="card" style="border-radius: 20px;">
<div class="card-header border-bottom pb-2">
<div class="btn-group-sm float-left">
<span class="card-title text-bold-600 mr-2">Daftar Rencana Umum Pengadaan</span>
<span><a href="<?php echo site_url('perencanaan_pengadaan/pr_non_proyek_drup/pembuatan_drup'); ?>" class="btn btn-info btn-sm rounded"><i class="ft-plus"></i> Tambah</a></span>
</div>
</div>
<div class="card-content">
<div class="card-body">
<div class="table-responsive">
<table class="table table-sm">
<thead>
<tr>
<th rowspan="2" style="vertical-align: middle;">No</th>
<th rowspan="2" style="vertical-align: middle;">Kode COA</th>
<th rowspan="2" style="vertical-align: middle;">Kode SDA</th>
<th rowspan="2" style="vertical-align: middle;">Paket Pengadaan dan Program</th>
<th colspan="2" class="text-center">Unit Kerja</th>
<th colspan="2" class="text-center">Jenis Pengadaan</th>
<th colspan="2" class="text-center">Pelaksanaan Pengadaan</th>
<th colspan="2" class="text-center">Pelaksanaan Pekerjaan</th>
<th colspan="2" class="text-center">Volume</th>
<th colspan="2" class="text-center">Anggaran</th>
<th rowspan="2" style="vertical-align: middle;">Catatan</th>
</tr>
<tr>
<th>Pemilik Program</th>
<th>Pengelola Anggaran</th>
<th>Penyedia</th>
<th>swakelola</th>
<th>Tgl Mulai</th>
<th>Tgl Akhir</th>
<th>Tgl Mulai</th>
<th>Tgl Akhir</th>
<th>Jumlah</th>
<th>Satuan</th>
<th>Harga Satuan</th>
<th>Total</th>
</tr>
</thead>

<tbody>
<?php $noabjd = 'A'; foreach ($drup_data as $value) { ?>
<tr style="background-color: #f7f7f7">
<td class="text-center text-bold-700 font-small-2"><?php echo $noabjd++; ?></td>
<td class="text-center text-bold-700 font-small-2"><?php echo $value['kode_perkiraan'];?></td>
<td colspan="16" class="text-left text-bold-700 font-small-2"><?php echo $value['nama_perkiraan'];?></td>
</tr>
<?php
$no = 1;
$sql = "
SELECT * FROM prc_proses_drup ppd
WHERE coa_id ='".$value["coa_id"]."'
";
$detail = $this->db->query($sql)->result_array();
foreach ($detail as $value_in) {
?>
<tr>
<td class="text-center"><?php echo $no++;?></td>
<td class="text-center">&nbsp;</td>
<td class="text-center"><?php echo $value_in['kode_sumber_daya'];?></td>
<td><?php echo $value_in['nama_program'];?></td>
<td><?php echo $value_in['pemilik_program'];?></td>
<td><?php echo $value_in['pengelola_anggaran'];?></td>
<td class="text-center"><?php echo $value_in['penyedia'];?></td>
<td class="text-center"><?php echo $value_in['swakelola'];?></td>
<td class="text-center"><?php echo $value_in['tgl_mulai_pengadaan'];?></td>
<td class="text-center"><?php echo $value_in['tgl_akhir_pengadaan'];?></td>
<td class="text-center"><?php echo $value_in['tgl_mulai_pekerjaan'];?></td>
<td class="text-center"><?php echo $value_in['tgl_akhir_pekerjaan'];?></td>
<td class="text-center"><?php echo $value_in['volume'];?></td>
<td class="text-center"><?php echo $value_in['satuan'];?></td>
<td class="text-center"><?php echo number_format($value_in['harga_satuan']);?></td>
<td class="text-center"><?php echo number_format($value_in['volume'] * $value_in['harga_satuan']);?></td>
<td><?php echo $value_in['catatan'];?></td>
</tr>
<?php } ?>
<?php } ?>
</tbody>

<tfoot>
    <tr style="background-color: #f7f7f7">
        <td colspan="14">&nbsp;</td>
        <td class="text-center text-bold-700">TOTAL</td>
        <td class="text-right text-bold-700"><?php echo number_format($total_data['total']);?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>
</div>
</div> -->
<style media="screen">
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
                    <div class="row mb-2">
                        <div class="col-sm-2">
                            <span class="mr-3"> <div class="lds-hourglass hide" id="load_drup"></div> </span>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select class="form-control myform" id="se_penyedia">
                                    <option value="">- Penyedia -</option>
                                    <option value="Barang">Barang</option>
                                    <option value="Jasa">Jasa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control myform" id="se_tgl">
                                <option value="">- Jenis Tanggal -</option>
                                <option value="Pengadaan">Pengadaan</option>
                                <option value="Pengerjaan">Pengerjaan</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select class="form-control myform" id="se_order">
                                    <option value="">- Order By -</option>
                                    <option value="kode_sumber_daya">Kode SDA</option>
                                    <option value="nama_program">Paket Pengadaan</option>
                                    <option value="pemilik_program">Pemilik Program</option>
                                    <option value="pengelola_anggaran">Pengelola Anggaran</option>
                                    <option value="penyedia">Swakelola</option>
                                    <option value="tgl_mulai_pengadaan">Tgl Mulai Pengadaan</option>
                                    <option value="tgl_akhir_pengadaan">Tgl Akhir Pengadaan</option>
                                    <option value="tgl_mulai_pekerjaan">Tgl Mulai Pekerjaan</option>
                                    <option value="tgl_akhir_pekerjaan">Tgl Akhir Pekerjaan</option>
                                    <option value="volume">Volume</option>
                                    <option value="satuan">Satuan</option>
                                    <option value="harga_satuan">Harga Satuan</option>
                                    <option value="catatan">Catatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select class="form-control myform" id="se_sort">
                                    <option value="">- Sort -</option>
                                    <option value="asc">ASC</option>
                                    <option value="desc">DESC</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end mb-2">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control myform" id="cari_text" placeholder="Cari ..."  autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" class="form-control myform" id="sdate" placeholder="Cari ..."  autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" class="form-control myform" id="edate" placeholder="Cari ..."  autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select class="form-control myform" id="se_swakelola">
                                    <option value="">- Swakelola -</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <button type="button" class="form-control btn btn-info btn-block btn-sm" onclick="search();"><i class=" fa fa-search">Cari</i></button>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <button type="button" class="form-control btn btn-info btn-block btn-sm" onclick="fnExcelReport('tbl_drup');"><i class=" fa fa-print">Export</i></button>
                            </div>
                        </div>
                    </div>
                    <div class="" style="overflow-x:auto;">
                    <table id="tbl_drup" class="table table-sm">
                        <tr><th class="text-center">Memuat data ...</th></tr>
                    </table>
                    </div>
                    <table width="100%" id="drup_pagination" class="table"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>

    function cu(e) {
        let format = e.toString().split('').reverse().join('');
        let convert = format.match(/\d{1,3}/g);

        return convert.join('.').split('').reverse().join('')
    }

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
</script>

<script type="text/javascript">

    $(document).ready(function() {
        $(`#datetimes`).val('')
        data_drup('');
    })

    function search() {
        data_drup(1)
    }

    function data_drup(fil) {
        $(`#load_drup`).toggleClass('hide');

        let rows = $('#show_rows').val();
        let page = p.length

        let sdate = $(`#sdate`).val()
        let edate = $(`#edate`).val()
        let se_tgl = $(`#se_tgl`).val()
        let order = $(`#se_order`).val()
        let sort = $(`#se_sort`).val()

        let send = {
            'rows': rows != undefined ? rows : 10,
            'page': page,
        }

        if (fil != '') {
            if ((sdate != '') || (edate !='')) {
                if (se_tgl == '') {
                    $(`#sdate`).val('')
                    $(`#edate`).val('')
                    alert('Jenis Tanggal harus dipilih')
                    $(`#load_drup`).toggleClass('hide');
                    return false
                }
            }

            if (order != '') {
                if (sort =='') {
                    $(`#se_order`).val('')
                    alert('Sort harus dipilih')
                    $(`#load_drup`).toggleClass('hide');
                    return false
                }
            }
            if (sort != '') {
                if (order =='') {
                    $(`#se_sort`).val('')
                    alert('Order by harus dipilih')
                    $(`#load_drup`).toggleClass('hide');
                    return false
                }
            }
            send.fil = 1
            send.free_text = $(`#cari_text`).val()
            send.swakelola = $(`#se_swakelola`).val()
            send.penyedia = $(`#se_penyedia`).val()
            send.se_tgl = se_tgl
            send.sdate = sdate
            send.edate = edate
            send.order = order
            send.sort = sort
        }

        $.ajax({
            url: '<?php echo base_url('perencanaan_pengadaan/data_drup') ?>',
            method: 'post',
            data: send,
            dataType: 'json',
            success: function(data) {
                extract_table(data);
                $(`#load_drup`).toggleClass('hide');
            }
        })
    }

    function extract_table(data) {
        let table = `
        <thead>
        <tr>
        <th rowspan="2" style="vertical-align: middle;">No</th>
        <th rowspan="2" style="vertical-align: middle;">Kode COA</th>
        <th rowspan="2" style="vertical-align: middle;">Kode SDA</th>
        <th rowspan="2" style="vertical-align: middle;">Paket Pengadaan dan Program</th>
        <th colspan="2" class="text-center">Unit Kerja</th>
        <th colspan="2" class="text-center">Jenis Pengadaan</th>
        <th colspan="2" class="text-center">Pelaksanaan Pengadaan</th>
        <th colspan="2" class="text-center">Pelaksanaan Pekerjaan</th>
        <th colspan="2" class="text-center">Volume</th>
        <th colspan="2" class="text-center">Anggaran</th>
        <th rowspan="2" style="vertical-align: middle;">Catatan</th>
        </tr>
        <tr>
        <th>Pemilik Program</th>
        <th>Pengelola Anggaran</th>
        <th>Penyedia</th>
        <th>Swakelola</th>
        <th>Tgl Mulai</th>
        <th>Tgl Akhir</th>
        <th>Tgl Mulai</th>
        <th>Tgl Akhir</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Harga Satuan</th>
        <th>Total</th>
        </tr>
        </thead>
        `;

        let co = 0;
        const alphabet = "abcdefghijklmnopqrstuvwxyz".split("");

        $.each(data.result, function(i,v) {
            row = ``;
            nn = 1
            $.each(v.detail, function(a,b) {
                row += `
                <tr>
                    <td>${nn}</td>
                    <td></td>
                    <td>${b.kode_sumber_daya}</td>
                    <td>a${b.nama_program}</td>
                    <td>${b.pemilik_program}</td>
                    <td>${b.pengelola_anggaran}</td>
                    <td>${b.penyedia}</td>
                    <td>${b.swakelola}</td>
                    <td>${b.tgl_mulai_pengadaan}</td>
                    <td>${b.tgl_akhir_pengadaan}</td>
                    <td>${b.tgl_mulai_pekerjaan}</td>
                    <td>${b.tgl_akhir_pekerjaan}</td>
                    <td class="text-right">${b.volume}</td>
                    <td>${b.satuan}</td>
                    <td class="text-right">${b.harga_satuan}</td>
                    <td class="text-right">${b.volume * b.harga_satuan}</td>
                    <td>${b.catatan}</td>
                </tr>
                `
            })
            co = i + 1 + data.offset
            table += `
                <tr style="background-color: lightgray; font-weight: bold">
                    <td>${alphabet[i].toUpperCase()}</td>
                    <td>${v.kode_perkiraan}</td>
                    <td colspan="15" class="text-left">${v.nama_perkiraan}</td>
                </tr>
                ${row}
            `;

        })

        table += `
        <tfoot>
            <tr style="background-color: #f7f7f7">
                <td colspan="14">&nbsp;</td>
                <td class="text-center text-bold-700">TOTAL</td>
                <td class="text-right text-bold-700"><?php echo $total_data['total'];?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
        `
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

        $(`#drup_pagination`).html(body)
        $(`#tbl_drup`).html(table)
    }

    function change_rows() {
        p = [];
        data_drup('')
    }

    let p = [];
    function get_pagination(e) {
        if (e >= 0) {
            if (e == 0) {
                p.shift()
            } else {
                p.push(1)
            }
            data_drup('')
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

            data_drup('')
        }
    }
</script>
