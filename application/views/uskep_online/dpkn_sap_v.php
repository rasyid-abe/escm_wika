<style type="text/css">
    html{
        font-family:sans-serif;
    }
    table {
        font-size: 12px;
        border: 1px solid #fff
    }

    td {
        padding: 3px;
    }

    th {
        padding: 3px;
        font-weight: bold;
        /*background-color: #b0ffc2;*/
        background-color: #e6e7e8;
    }

    p{
        font-size:10px;
    }

    #table-content {
        font-size: 40%;
    }
    .ff:focus {
        background-color: #fff;
    }

    .ff {
        border: 1px solid black;
        color: black;
        background-color: #fff;
    }

    .is-content {
        border-collapse: collapse;
    }

    .is-content td {
        border: 1px solid black;
    }

    .is-content th {
        border: 1px solid black;
    }
    .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 10px;
    }
    .table td {
        line-height: 15px;
    }
    .table th, .table td {
        vertical-align: middle;
        word-break: break-all;
    }
    .bt-custom {
        border-top: 1px solid #a7a7a7 !important;
    }
    .form_header {
        border-radius: 5px;
        width: 90%;
        height: 35px;
        border: 1px solid gray;
        background-color: #fff;
    }

    .hidden{
        display: none;
    }

    .wrapper-progressBar {
        width: 100%
    }

    .progressBar {
    }

    .progressBar li {
        list-style-type: none;
        float: left;
        width: 33%;
        position: relative;
        text-align: center;
    }

    .progressBar li:before {
        content: " ";
        line-height: 30px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        border: 1px solid darkgray;
        display: block;
        text-align: center;
        margin: 0 auto 10px;
        background-color: white
    }

    .progressBar li:after {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: #ddd;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressBar li:first-child:after {
        content: none;
    }

    .progressBar li.active {
        color: dodgerblue;
    }

    .progressBar li.active:before {
        border-color: dodgerblue;
        background-color: dodgerblue
    }

    .progressBar li.active + li:after {
        background-color: dodgerblue;
    }

    .bold {
        font-weight: bold;
    }

    .sat_form {
        width: 60px;
    }

    .vol_form {
        width: 120px;
    }
    .long_form {
        width: 200px;
    }

</style>

<div class="wrapper wrapper-content animated fadeInRight">

    <form method="post" action="<?php echo site_url($controller_name."/submit_dpkn");?>"  class="form-horizontal ajaxform">

        <input type="hidden" name="metode_pengadaan" value="<?php echo $mtd ?>">
        <br><br>
        <div class="row" id="vend_section">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-10 control-label text-left text-bold-700"><strong style="font-size:16pt;">Penyedia Barang dan Jasa</strong>
                    <span class="ml-2 btn-sm btn btn-success mb-2 hidden" id="add_penyedia"><i class="ft ft-plus"></i></span></label>
                    <button type="button" class="btn btn-sm btn-info check-budget">Check Budget</button>
                </div>
                <table width="100%" id="add_penyedia_tbl">
                    <input type="hidden" name="twin" value="<?php echo $winner ?>">
                    <?php if ($winner < 3): ?>
                        <?php for ($i=0; $i < 2; $i++) {?>
                            <tr>
                                <td width="100%">
                                    <select class="form-control select2" name="vendor" class="vend_val">
                                        <option value="">Pilih Vendor</option>
                                        <?php foreach($bidderList as $key => $val){ ?>
                                            <option value='<?= $val['vendor_name'] .'>'. $val['vendor_id'] .'>'. $val['address_street'] .'>'. $val['contact_name'] .'>'. $val['contact_phone_no']; ?>'><?= $val['vendor_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="text-right"></td>
                            </tr>
                        <?php } ?>
                    <?php else: ?>
                        <?php for ($i=0; $i < $winner; $i++) {?>
                            <tr>
                                <td width="100%">
                                    <select class="form-control select2" name="vendor" class="vend_val">
                                        <option value="">Pilih Vendor</option>
                                        <?php foreach($bidderList as $key => $val){ ?>
                                            <option value='<?= $val['vendor_name'] .'>'. $val['vendor_id'] .'>'. $val['address_street'] .'>'. $val['contact_name'] .'>'. $val['contact_phone_no']; ?>'><?= $val['vendor_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="text-right"></td>
                            </tr>
                        <?php } ?>
                    <?php endif; ?>
                </table>
                <span class=" m-2 btn btn-primary hidden" id="proses_tabel">Proses</span>
                <span class="btn btn-danger" onclick="history.back()">Kembali</span>
            </div>
        </div>

        <div class="row mt-3 mb-3 headtop hidden">
            <div class="col-sm-12">
                <div class="wrapper-progressBar">
                    <ul class="progressBar">
                        <li class="active"><p style="margin:0px;font-size:14px;"><b>DOKUMEN EVALUASI PENAWARAN, KLARIFIKASI DAN NEGOSIASI</b></p></li>
                        <li class=""><p style="margin:0px;font-size:14px;"><b>DOKUMEN SISTEM PENILAIAN</b></p></li>
                        <?php if ($mtd == "Penunjukan_Langsung"): ?>
                            <li class=""><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PENUNJUKAN LANGSUNG</b></p></li>
                        <?php else: ?>
                            <li class=""><p style="margin:0px;font-size:14px;"><b>BERITA ACARA KEPUTUSAN PEMENANG</b></p></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div id="tbl_inp_dpkn" class="table-responsive"></div>
            </div>
        </div>

        <div id="required" class="card hidden">
            <div class="card-content">
                <div class="card-body">
                    <?php echo buttonsubmit('contract/manual_sap',lang('back'),lang('save')) ?>
                </div>
            </div>
        </div>

    </form>

</div>

<script type="text/javascript">

    let list_vend = '';
    let list_proj = '';
    let vend_totl = 0;
    let order_itm = {};
    let order_idx = 0;
    let list_hcis = '';
    let uniq_prnu = [];
    $(document).ready(function(){

        $( '.uang' ).mask('0.000.000.000', {reverse: true});
        $.ajax({
            url: '<?php echo site_url($controller_name."/get_list_vendor");?>',
            method: 'post',
            data: {},
            dataType: 'json',
            success: function(data) {
                setTimeout(function() {
                    res_vendor = '<option value="">Pilih Vendor</option>';
                    $.each(data[0], function(k, v){
                        res_vendor += `<option value="${v.vendor_name}>${v.vendor_id}>${v.address_street}>${v.contact_phone_no}>${v.address_phone_no}">${v.vendor_name}</option>`;
                    });
                    list_vend = res_vendor;

                    res_project = '<option value="">Pilih Project</option>'
                    $.each(data[2], function(k, v) {
                        if (v.ppm_subject_of_work != '') {
                            res_project += `<option ppmid="${v.ppm_id}" projname="${v.ppm_subject_of_work}" value="${v.ppm_project_id}">${v.ppm_subject_of_work}</option>`
                        }
                    })
                    list_proj = res_project


                    hcis_nm = `<option value="">Pilih Nama TTD</option>`
                    $.each(data[3], function(id, va) {
                        hcis_nm += `<option value="${va.nip}_${va.nm_peg}_${va.posisi}">${va.nm_peg} - ${va.posisi}</option>`
                    })
                    list_hcis = hcis_nm

                    $('#add_penyedia').removeClass('hidden')
                    $('#proses_tabel').removeClass('hidden')
                }, 1000)
            }
        })
    })

    function count_harga(id, uniq) {
        let v1 = $(`#ch_pen_vol_${uniq}`).val()
        let vol = parseFloat(v1.replace(/[^\d\,]/g,''))

        if (isNaN(vol)) {
            alert('Volume harus diisi!')
            $(`#${id}`).val('')
            return false;
        }

        // satuan
        let ini = $(`#${id}`).val()
        let ini2 = parseFloat(ini.replace(/[^\d\.]/g,''))
        let res = ini2 * vol
        $(`#penhrg${uniq}`).val(res)
        $('#lblhartot_'+uniq).html(formatter.format(res))

        var nn=[];
        $(`.totpen`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        $(`#totpen1`).html(formatter.format(sum))

        // app
        // let inni = parseFloat(ini.replace(/[^\d\,]/g,''))
        // $(`#negohrgsat${uniq}`).val(inni)
        // $('#lblnegoharsat_' + uniq).html(formatter.format(inni))

        // nego
        let inii = $(`#${id}`).val();
        let inii2 = parseFloat(inii.replace(/[^\d\.]/g,''))
        let ress = inii2 * vol;
        $(`#negohrg${uniq}`).val(ress)
        $('#lblnegohartot_' + uniq).html(formatter.format(ress))

        $(`#totnego1`).html(formatter.format(sum))
        $(`#total_rbap`).val(sum);
    }

    function count_harga_vend(id, uniq, vend) {
        let v1 = $(`#ch_pen_vol_${uniq}`).val()
        let vol = parseFloat(v1.replace(/[^\d\,]/g,''))

        if (isNaN(vol)) {
            alert('Volume harus diisi!')
            $(`#${id}`).val('')
            return false;
        }
        let ini = $(`#${id}`).val()
        let ini2 = parseFloat(ini.replace(/[^\d\,]/g,''))
        let res = ini2 * vol

        $(`#penhrg${vend}${uniq}`).val(res)
        $(`#lblpenhrg_${vend}${uniq}`).html(formatter.format(res))

        var nn=[];
        $(`.total${vend}`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        $(`#tot_pen_vend${vend}`).html(formatter.format(sum))
        $(`#total_ppen${vend}`).val(sum)
    }

    function count_harga_vend_nego(id, uniq, vend) {
        let v1 = $(`#${uniq}_nego_vol`).val()
        let vol = parseFloat(v1.replace(/[^\d\,]/g,''))
        if (isNaN(vol)) {
            alert('Volume harus diisi!')
            $(`#${id}`).val('')
            return false;
        }
        let ini = $(`#${id}`).val()
        let ini2 = parseFloat(ini.replace(/[^\d\,]/g,''))
        let res = ini2 * vol

        $(`#negohrg${vend}${uniq}`).val(res)
        $(`#lblnegohrg_${vend}${uniq}`).html(formatter.format(res))

        var nn=[];
        $(`.totalnego${vend}`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}

        $(`#tot_nego_vend${vend}`).html(formatter.format(sum))
        $(`#total_ppeneg${vend}`).val(sum)

        let ttdt = []
        let vtt = 0
        $('.ttdcek').each(function() {
            if ($(this).val() != '') {
                ttdt.push($(this).val())
            }
            vtt++
        })

        if (ttdt.length == vtt) {
            $(`#required`).removeClass('hidden')
            // show_list_ttd()
        }
    }

    function show_list_ttd() {
        let idprk = $('#idprk').val()
        var prnum = $("input[name='pr_pen[]']").map(function(){return $(this).val();}).get();
        var nn=[];

        $(`.tn_val`).each(function(){ nn.push($(this).val()) });
        let min = Math.min.apply(Math, nn)

        var kewenangan = `
        <tr>
        <td colspan="7" align="center"><b>TIM PEJABAT PELAKSANA (TPPL)</b></td>
        </tr>
        <tr>
        <th align="center">No</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Deskripsi</th>
        <th>Tanda Tangan</th>
        </tr>`;

        $.ajax({
            url: '<?php echo site_url($controller_name."/ttdlist");?>',
            method: 'post',
            data: {idprk, prnum, min},
            dataType: 'json',
            success: function(res) {
                data = res['ttd']
                $.each(data, function(i,v) {

                    opt_nm = `<option value="">Pilih Nama TTD</option>`
                    $.each(v, function(id, va) {
                        opt_nm += `<option value="${va.nip}_${va.nm_peg}_${va.posisi}">${va.nm_peg} - ${va.posisi}</option>`
                    })

                    kewenangan += `<tr>
                    <td align="center">${i+1}</td>
                    <td style="width: 500px; text: white;">
                    <select class="form-control ff form_header select2" id="nmKew" name="nm_kew[]">${opt_nm}</select>
                    </td>
                    <td>
                    <select class="form-control" name="kategori[]">
                    <option>Menyetujui</option>
                    <option>Mengusulkan</option>
                    </select>
                    </td>
                    <td>
                    <select class="form-control" name="posisi[]">
                    <option>Anggota</option>
                    <option>Ketua</option>
                    </select>
                    </td>
                    <td >......................</td>
                    </tr>
                    `
                })
                $(`#required`).removeClass('hidden')

                $(`#tr_esign`).html(kewenangan)
                selectRefresh()

                $('#tipePlan').val(res['tipePlan']);
                $('#tipeProyek').val(res['tipeProyek']);
                $('#catmanagement').val(res['catmanagement']);
                $('#jnspengadaan').val(res['jnspengadaan']);
                // setTimeout(function() {
                // }, 1000);
            }
        });
    }

    function change_nego_text(id, uniq) {
        let val = $(`#${id}`).val()
        let vls = val.split("~")

        $.ajax({
            url: '<?php echo site_url("uskep_online_sap/get_detail_item");?>',
            method: 'post',
            data: {'ppi_code': vls[1].trim(), 'ppm_id': vls[2]},
            dataType: 'json',
            success: function(data) {
                if (data == null) {
                    alert('Item tidak tersedia!')
                    return false;
                }

                $('#lblsda_'+uniq).html(data.ppi_item_desc)
                $('#lblsat_'+uniq).html(data.ppi_satuan)
                $('#lblharsat_'+uniq).html(formatter.format(parseInt(data.ppi_harga)))
                $('#ch_pen_pr_'+uniq).val(data.ppis_pr_number)
                $('#ch_pen_sat_'+uniq).val(data.ppi_satuan)
                $('#penhrgsat'+uniq).val(parseInt(data.ppi_harga))

                $('#max_volume' + uniq).html("<span class='text-danger text-bold-700'>*</span><span id='max"+uniq+"'><i>batas max " + parseFloat(data.ppv_remain).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 8
                }) + " " + data.ppi_satuan + "</i></span>");

                $('#hidemax' + uniq).val(parseFloat(data.ppv_remain))

                $('#ch_pen_vol_' + uniq).attr('maxlength',parseFloat(data.ppv_remain));

                $('#lblnego_' + uniq).html(data.ppi_item_desc)
                $('#lblnegopr_' + uniq).html(data.ppis_pr_number)
                $('#lblnegosat_' + uniq).html(data.ppi_satuan)


                $(`#${uniq}_nego_text`).val($(`#${id}`).val())
                $(`#${uniq}_nego_pr`).val(data.ppis_pr_number)
                $(`#${uniq}_nego_sat`).val(data.ppi_satuan)
                // $('#negohrgsat'+uniq).val(parseInt(data.ppi_harga))
                // $('#lblnegoharsat_' + uniq).html(formatter.format(parseInt(data.ppi_harga)))
            }
        })

        $(`#${id} .select2`).select2({
            tags: true,
            allowClear: true,
            width: '100%'
        });
    }

    function change_nego_sat(id, uniq) {
        $(`#${uniq}_nego_sat`).val($(`#${id}`).val())
    }

    function change_nego_vol(id, uniq, vendor) {
        let vval = $('#ch_pen_vol_' + uniq).val()
        let vmax = $('#hidemax' + uniq).val()

        if (parseFloat(vval) > parseFloat(vmax)) {
            alert('Volume tidak cukup!')
            $('#ch_pen_vol_' + uniq).val('')
            return false
        }

        $('#lblnegovol_' + uniq).html($(`#${id}`).val())
        $(`#${uniq}_nego_vol`).val($(`#${id}`).val())

        let rab = $(`#penhrgsat${uniq}`).val()
        let volval = $(`#${id}`).val()

        let rabtot = volval * rab
        $(`#penhrg${uniq}`).val(rabtot)
        $('#lblhartot_'+uniq).html(formatter.format(rabtot))
        $(`#negohrg${uniq}`).val(rabtot)
        $('#lblnegohartot_' + uniq).html(formatter.format(rabtot))

        var nn=[];
        $(`.totpen`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        $(`#totpen1`).html(formatter.format(sum))
        $(`#totnego1`).html(formatter.format(sum))

        for (var i = 0; i < parseInt(vendor); i++) {
            let hs_ven1 = $(`#penhrgsat${i}${uniq}`).val()
            let hs_ven = parseFloat(hs_ven1.replace(/[^\d\,]/g,''))
            let resss = 0
            if (!isNaN(volval * hs_ven)) {
                resss = volval * hs_ven
            }
            $(`#penhrg${i}${uniq}`).val(resss)
            $(`#lblpenhrg_${i}${uniq}`).html(formatter.format(resss))

            var nn1=[];
            $(`.total${i}`).each(function(){
                if($(this).val() != ''){
                    nn1.push($(this).val())
                }
            });

            let sum1 = 0;
            for (var j = 0; j < nn1.length; j++) {sum1 += parseInt(nn1[j])}
            $(`#tot_pen_vend${i}`).html(formatter.format(sum1))

            let hsn_ven = $(`#negohrgsat${i}${uniq}`).val()
            let hsn_ven2 = parseFloat(hsn_ven.replace(/[^\d\,]/g,''))
            let lsi = 0
            if (!isNaN(volval * hsn_ven2)) {
                lsi = volval * hsn_ven2
            }
            $(`#negohrg${i}${uniq}`).val(lsi)
            $(`#lblnegohrg_${i}${uniq}`).html(formatter.format(lsi))

            var nn2=[];
            $(`.totalnego${i}`).each(function(){
                if($(this).val() != ''){
                    nn2.push($(this).val())
                }
            });

            let sum2 = 0;
            for (var k = 0; k < nn2.length; k++) {sum2 += parseInt(nn2[k])}
            $(`#tot_nego_vend${i}`).html(formatter.format(sum2))
            $(`#total_ppeneg${i}`).val(sum2)

            let ttdt = []
            let vtt = 0
            $('.ttdcek').each(function() {
                if ($(this).val() != '') {
                    ttdt.push($(this).val())
                }
                vtt++
            })
            if (ttdt.length == vtt) {
                show_list_ttd()
            }

        }

        let ids = `penhrgsat${uniq}`
        count_harga(ids, uniq)
    }

    function remove_count(id, uniq, vend, idx) {
        delete order_itm[idx]
        set_ordernum()

        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
        $(id).remove();

        var nn=[];
        $(`.totpen`).each(function(){
            if($(this).val() != ''){
                nn.push($(this).val())
            }
        });

        let sum = 0;
        for (var i = 0; i < nn.length; i++) {sum += parseInt(nn[i])}
        if (nn.length > 0){
            $(`#totpen1`).html(formatter.format(sum))
            $(`#totnego1`).html(formatter.format(sum))
            $(`#total_rbap`).val(sum);
        } else {
            $(`#totpen1`).html('')
            $(`#totnego1`).html('')
            $(`#total_rbap`).val('');
        }

        for (var i = 0; i < vend; i++) {
            clvend = []
            $(`.total${i}`).each(function(){
                if($(this).val() != ''){
                    clvend.push($(this).val())
                }
            });
            if (clvend.length > 0) {
                let sumto = 0;
                for (var j = 0; j < clvend.length; j++) {sumto += parseInt(clvend[j])}
                $(`#tot_pen_vend${i}`).html(formatter.format(sumto))
                $(`#total_ppen${i}`).val(sumto)
            } else {
                $(`#tot_pen_vend${i}`).html('###')
                $(`#total_ppen${i}`).val('')
            }

            clvendn = []
            $(`.totalnego${i}`).each(function(){
                if($(this).val() != ''){
                    clvendn.push($(this).val())
                }
            });
            if (clvendn.length > 0) {
                let sumton = 0;
                for (var j = 0; j < clvendn.length; j++) {sumton += parseInt(clvendn[j])}
                $(`#tot_nego_vend${i}`).html(formatter.format(sumton))
                $(`#total_ppeneg${i}`).val(sumton)

                let ttdt = []
                let vtt = 0
                $('.ttdcek').each(function() {
                    if ($(this).val() != '') {
                        ttdt.push($(this).val())
                    }
                    vtt++
                })
                if (ttdt.length == vtt) {
                    show_list_ttd()
                }

            } else {
                $(`#tot_nego_vend${i}`).html('###')
                $(`#total_ppeneg${i}`).val('')

                $('#tr_esign').html('')
            }
        }

    }

    function remove_elem(id) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
        $(id).remove();
    }

    function changetipeplan() {
        var nn=[];
        $(`.tn_val`).each(function(){
            nn.push($(this).val())
        });

        if (nn.includes("")) {
            $('#tipePlan').val('');
            alert('Item SDA harus dipilih!')
            return false;
        }

        if (nn.includes("0")) {
           $('#tipePlan').val('');
           alert('Harga Negosiasi harus diisi semua!')
           return false;
        }

        tp = $('#tipePlan').val();
        if (tp == 'proyek') {
            $('#catmanagement').removeClass('hidden');
            if (!$(`#tipeProyek`).hasClass('hidden')) {
                $('#tipeProyek').addClass('hidden')
            }
            $(`#tr_esign`).html('')
        } else {
            let min = Math.min.apply(Math, nn)

            let kelas = 'medium'
            if (parseInt(min) < 500000000) {
                kelas = 'low'
            } else if (parseInt(min) > 2000000000) {
                kelas = 'high'
            }

            if (!$(`#tipeProyek`).hasClass('hidden')) {$('#tipeProyek').addClass('hidden')}
            $('#tipeProyek').val('');
            if (!$(`#catmanagement`).hasClass('hidden')) {$('#catmanagement').addClass('hidden')}
            $('#catmanagement').val('')
            if (!$(`#jnspengadaan`).hasClass('hidden')) {$('#jnspengadaan').addClass('hidden')}
            $('#jnspengadaan').val('')

            changetipeproyek(kelas);

        }
    }

    function changecatmanagement() {
        tp = $('#catmanagement').val()
        if (tp == '1') {
            $('#jnspengadaan').removeClass('hidden')
            if (!$(`#tipeProyek`).hasClass('hidden')) {$('#tipeProyek').addClass('hidden')}
        } else {
            $('#tipeProyek').removeClass('hidden');
            if (!$(`#jnspengadaan`).hasClass('hidden')) {$('#jnspengadaan').addClass('hidden')}
            $('#jnspengadaan').addClass('hidden')
            $('#jnspengadaan').val('')
        }
    }

    function changejnspengadaan() {
        tp = $('#jnspengadaan').val()
        if (tp == 'oa') {
            if (!$(`#tipeProyek`).hasClass('hidden')) {$('#tipeProyek').addClass('hidden')}
            changetipeproyek('');
        } else {
            var nn=[];
            $(`.tn_val`).each(function(){
                nn.push($(this).val())
            });

            let min = Math.min.apply(Math, nn)

            let kelas = 'medium'
            if (parseInt(min) < 5000000000) {
                kelas = 'low'
            } else if (parseInt(min) > 50000000000) {
                kelas = 'high'
            }

            changetipeproyek(kelas);
        }
    }
    //
    // function changetipeproyek(kelas) {
    //     $(`#myLoader`).modal('show');
    //
    //     let proyek = $(`#tipePlan`).val();
    //     let catmanagement = $(`#catmanagement`).val();
    //     let jnspengadaan = $('#jnspengadaan').val();
    //     var kewenangan = `
    //     <tr>
    //     <td colspan="7" align="center"><b>TIM PEJABAT PELAKSANA (TPPL)</b></td>
    //     </tr>
    //     <tr>
    //     <th align="center">No</th>
    //     <th>Nama</th>
    //     <th>Kategori</th>
    //     <th>Deskripsi</th>
    //     <th>Tanda Tangan</th>
    //     </tr>`;
    //
    //     var nn=[];
    //     $(`.tn_val`).each(function(){
    //         nn.push($(this).val())
    //     });
    //
    //     let min = Math.min.apply(Math, nn)
    //
    //     let proyek_big = min >= 100000000000 ? '1' : '0';
    //
    //     let nilai = $('#tipeProyek').val();
    //
    //     if (nilai != '') {
    //         if ((min <= 2000000000) && (nilai == 'kecil')) {
    //             kelas = 'low'
    //         } else if ((min <= 5000000000) && (nilai == 'menengah')) {
    //             kelas = 'low'
    //         } else if ((min <= 10000000000) && (nilai == 'besar')) {
    //             kelas = 'low'
    //         } else if (( (min > 2000000000) && (min <= 50000000000) ) && (nilai == 'kecil')) {
    //             kelas = 'medium'
    //         } else if (( (min > 5000000000) && (min <= 50000000000) ) && (nilai == 'menengah')) {
    //             kelas = 'medium'
    //         } else if (( (min > 10000000000) && (min <= 50000000000) ) && (nilai == 'besar')) {
    //             kelas = 'medium'
    //         } else {
    //             kelas = 'high'
    //         }
    //     }
    //
    //     $.ajax({
    //         url: '<?php echo site_url($controller_name."/check_kewenangan_dpkn");?>',
    //         method: 'post',
    //         data: {catmanagement, proyek, jnspengadaan, kelas, nilai, proyek_big},
    //         dataType: 'json',
    //         success: function(res) {
    //             setTimeout(function() {
    //                 data = res
    //                 $.each(data, function(i,v) {
    //
    //                     opt_nm = `<option value="">Pilih Nama TTD</option>`
    //                     $.each(v, function(id, va) {
    //                         opt_nm += `<option value="${va.nip}_${va.nm_peg}_${va.posisi}">${va.nm_peg} - ${va.posisi}</option>`
    //                     })
    //
    //                     kewenangan += `<tr>
    //                         <td align="center">${i+1}</td>
    //                         <td style="width: 500px; text: white;">
    //                             <select class="form-control ff form_header select2" id="nmKew" name="nm_kew[]">${opt_nm}</select>
    //                         </td>
    //                         <td>
    //                             <select class="form-control" name="kategori[]">
    //                                 <option>Menyetujui</option>
    //                                 <option>Mengusulkan</option>
    //                             </select>
    //                         </td>
    //                         <td>
    //                             <select class="form-control" name="posisi[]">
    //                                 <option>Anggota</option>
    //                                 <option>Ketua</option>
    //                             </select>
    //                         </td>
    //                         <td >......................</td>
    //                     </tr>
    //                     `
    //                 })
    //                 $(`#required`).removeClass('hidden')
    //
    //                 $(`#tr_esign`).html(kewenangan)
    //                 selectRefresh()
    //                 $(`#myLoader`).modal('hide');
    //             }, 1000);
    //         }
    //     })
    // }

    function set_ordernum() {
        let nn = 1
        $.each(order_itm,function(i,v) {
            $('#or'+i).html(nn)
            $('#on'+i).html(nn)
            nn++
        })
    }

    function set_penawaran(data, vendor) {
        for (var i = 0; i < uniq_prnu.length; i++) {
            if (uniq_prnu[i] == data.ppis_pr_number) {
                return false
            }
        }

        var uniq = rand(3);

        order_idx++
        order_itm[order_idx] = 1

        let pena = ''
        let nego = ''
        for (var i = 0; i < parseInt(vendor); i++) {
            pena += `
            <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="form-control ff vol_form uang" onchange="count_harga_vend('penhrgsat${i}${uniq}', '${uniq}', ${i})" id="penhrgsat${i}${uniq}" name="hrg_sat_pen_vend_${i}[]" value="" required></td>
            <td class="text-right">
                <span id="lblpenhrg_${i}${uniq}"></span>
                <input type="hidden" class="form-control ff vol_form total${i}" name="harga_pen_vend_${i}[]" value="" id="penhrg${i}${uniq}" readonly>
            </td>
            `
            nego += `
            <td><input type="text" onkeyup="return prevent_letter(event, 'uang')" class="form-control ff vol_form uang ttdcek" onchange="count_harga_vend_nego('negohrgsat${i}${uniq}', '${uniq}', ${i})" id="negohrgsat${i}${uniq}" name="hrg_sat_nego_vend_${i}[]" value="" required></td>
            <td class="text-right">
                <span id="lblnegohrg_${i}${uniq}"></span>
                <input type="hidden" class="form-control ff vol_form totalnego${i}" name="harga_nego_vend_${i}[]" value="" id="negohrg${i}${uniq}" readonly>
            </td>
            `
        }

        let cont_pena = `
            <tr id="pen_${uniq}" class="itemsa">
                <td><span class="btn-sm btn btn-danger" onclick="remove_count(pen_${uniq}, '${uniq}', ${parseInt(vendor)}, ${order_idx});"><i class="ft ft-trash"></i></span></td>
                <td id="or${order_idx}"></td>
                <td>
                    <span id="lblsda_${uniq}">${data.ppis_pr_number}</span>
                    <input type="hidden" class="form-control ff pr_form" name="pr_pen[]" id="ch_pen_pr_${uniq}" value="${data.ppis_pr_number}">
                </td>
                <td>
                    <span id="lblpen_${uniq}">${data.ppi_item_desc}</span>
                    <input type="hidden" class="form-control ff pr_form" name="text_pen[]" id="ch_pen_text_${uniq}" value="${data.ppi_item_desc}">
                </td>
                <td>
                    <span id="lblsat_${uniq}">${data.ppi_satuan}</span>
                    <input type="hidden" class="form-control ff sat_form" name="sat_pen[]" id="ch_pen_sat_${uniq}" value="${data.ppi_satuan}">
                </td>
                <td>
                    <input type="text" onkeyup="return prevent_letter(event, 'uang')" class="form-control ff vol_form uang" name="vol_pen[]" onchange="change_nego_vol('ch_pen_vol_${uniq}', '${uniq}',${vendor})" id="ch_pen_vol_${uniq}" value="" required >
                    <small id="max_volume${uniq}"></small>
                    <input type="hidden" id="hidemax${uniq}" value="">
                </td>
                <td>
                    <span id="lblharsat_${uniq}">${formatter.format(data.ppi_harga)}</span>
                    <input type="hidden" onkeyup="return prevent_letter(event, 'uang')" class="form-control ff vol_form uang" onchange="count_harga('penhrgsat${uniq}', '${uniq}')" id="penhrgsat${uniq}" name="hrg_sat_pen[]" value="${parseFloat(data.ppi_harga)}">
                </td>
                <td class="text-right">
                    <span id="lblhartot_${uniq}"></span>
                    <input type="hidden" class="form-control ff vol_form totpen" name="harga_pen[]" id="penhrg${uniq}" value="" readonly>
                </td>
                ${pena}
            </tr>
        `;

        let cont_nego = `
            <tr class="sub_pen_${uniq}">
                <td></td>
                <td id="on${order_idx}"></td>
                <td>
                    <span id="lblnego_${uniq}">${data.ppis_pr_number}</span>
                    <input type="hidden" name="pr_nego[]" value="${data.ppis_pr_number}" id="${uniq}_nego_pr">
                </td>
                <td>
                    <span id="lblnegopr_${uniq}">${data.ppi_item_desc}</span>
                    <input type="hidden" name="text_nego[]" value="${data.ppi_item_desc}" id="${uniq}_nego_text">
                </td>
                <td>
                    <span id="lblnegosat_${uniq}">${data.ppi_satuan}</span>
                    <input type="hidden" name="sat_nego[]" value="${data.ppi_satuan}" id="${uniq}_nego_sat">
                </td>
                <td>
                    <span id="lblnegovol_${uniq}"></span>
                    <input type="hidden" name="vol_nego[]" id="${uniq}_nego_vol" value="">
                </td>
                <td>
                    <span id="lblnegoharsat_${uniq}">${formatter.format(data.ppi_harga)}</span>
                    <input type="hidden" id="negohrgsat${uniq}" name="hrg_sat_nego[]" value="${parseFloat(data.ppi_harga)}">
                </td>
                <td class="text-right">
                    <span id="lblnegohartot_${uniq}"></span>
                    <input type="hidden" name="harga_nego[]" id="negohrg${uniq}" value="">
                </td>
                ${nego}
            </tr>
        `;

        $("#tr_penawaran").append(cont_pena);
        $("#tr_nego").append(cont_nego);

        $(`.itemsa .select2`).select2({
            tags: true,
            allowClear: true,
            width: '100%'
        });

        $('#max_volume' + uniq).html("<span class='text-danger text-bold-700'>*</span><span id='max"+uniq+"'><i>batas max " + parseFloat(data.ppv_remain).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 8
        }) + " " + data.ppi_satuan + "</i></span>");

        $('#hidemax' + uniq).val(parseFloat(data.ppv_remain))
        // $('#tr_esign').html('')

        set_ordernum()
        uniq_prnu.push(data.ppis_pr_number)
    }

    function add_penawaran(vendor, prnum) {
        ppm_id = ''
        $("#idprk").each(function(){
            ppm_id = $('option:selected', this).attr('ppmid')
        })

        if (ppm_id == undefined) {
            alert('Proyek harus dipilih!')
        } else {
            $(`#myLoader`).modal('show');
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_list_items");?>',
                method: 'post',
                data: {ppm_id, prnum},
                dataType: 'json',
                success: function(data) {
                    set_penawaran(data, vendor)
                    $(`#myLoader`).modal('hide');
                }
            })
        }
    }

    function rand(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
        }
        return result;
    }

    function selectRefresh_vend() {
        $('#add_penyedia_tbl .select2').select2({
            tags: true,
            allowClear: true,
            width: '100%'
        });
    }

    function remove_ttd(id) {
        var cn = $(id).attr('id');
        $('.sub_' + cn).remove();
		$(id).remove();
	}

    $('#add_penyedia').on('click', function() {
        var uniq = rand(3);
        var id_vend = 'vend_uniq_' + uniq;
        let html = '<tr id="'+id_vend+'"><td><select class="form-control select2" name="vendor" class="vend_val">'+list_vend+'</select></td><td><span class="btn-sm btn btn-danger" onclick="remove_ttd('+id_vend+')"><i class="ft ft-trash"></i></span></td></tr>';
        $("#add_penyedia_tbl").append(html);
        selectRefresh_vend()
    })

    function selectidprk() {
        $('#selectprkid .select2').select2({
            tags: true,
            allowClear: true,
            width: '100%'
        });
    }

    function form_reload() {
        if(confirm("Perhatian! Ubah vendor akan mereset seluruh form yang telah diisi.")){
            $('#vend_section').removeClass('hidden')
            $('#tbl_inp_dpkn').html('')
            $(`.headtop`).addClass('hidden')
            $(`#required`).addClass('hidden')
        }
    }

    $('#proses_tabel').on('click', function() {
        var vendor = [];
        let vname = '';
        let addven = '';
        let hpven = '';
        let telven = '';
        let penven = '';
        let klaven = '';
        let vpenaw = '';
        let vpento = '';
        let vnegot = '';
        let klartx = '';
        let pilihan = '';
        let ii = 0;

        $("select[name=vendor]").each(function(){
            if ($(this).val() != '') {
                vd = $(this).val().split(">");

                vendor.push(vd[0]+'-'+vd[1]);

                vname += `<th style="background-color: #29a7de; color:white; font-weight: bold;" rowspan="3" colspan="2">${vd[0]}</th>`
                addven += `
                <input type="hidden" name="vendor_list[]" value="${vd[1]}">
                <td colspan="2">${vd[2] != 'null' ? vd[2] : '-'}</td>
                `
                hpven += `<td colspan="2">${vd[3] != 'null' ? vd[3] : '-'}</td>`
                telven += `<td colspan="2">${vd[4] != 'null' ? vd[4] : '-'}</td>`
                penven += `<td colspan="2"><input type="text" class="form-control ff" name="penawaran_tgl[]" value=""></td>`
                klaven += `<td colspan="2"><input type="text" class="form-control ff" name="klarifikasi_nego[]" value=""></td>`
                vpenaw += `<td>H. Satuan</td><td class="text-right">Harga</td>`
                vpento += `<input type="hidden" class="chpr_inp" name="total_ppen[]" value="" id="total_ppen${ii}" />
                <th colspan="2" id="tot_pen_vend${ii}" class="text-right chpr_txt">###</th>`
                vnegot += `<input type="hidden" class="chpr_inp tn_val" name="total_ppeneg[]" value="" id="total_ppeneg${ii}" />
                <th colspan="2" id="tot_nego_vend${ii}" class="text-right chpr_txt">###</th>`
                klartx += `<td colspan="2"><input type="text" class="form-control ff" name="klar_per_vend${ii}[]" value=""></td>`
                ii++
            }
        });

        if(vendor.length < 1) {
            alert('Vendor harus dipilih!')
            return false;
        }

        vend_totl = vendor.length

        $('#vend_section').addClass('hidden')
        $('.headtop').removeClass('hidden')

        let span_c = vendor.length

        var depkn_tbl = `
            <table style="width: 100%" class="table-striped" id="tbl_dpkn">
                <tr>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" colspan="8" rowspan="2"></th>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" colspan="${2 * span_c}" class="text-center">PENYEDIA <span class=" m-2 btn-sm btn btn-warning" onclick="form_reload();"><i class="ft ft-edit"></i></span></th>
                </tr>
                <tr>
                    <input type="hidden" name="rfq_no" value="<?= $rfq ?>">
                    ${vname}
                </tr>
                <tr>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" colspan="3">Paket Pengadaan</th>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" colspan="4">
                        <input type="text" class="form-control ff" name="pengadaan" value="" required>
                    </th>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;"></th>
                </tr>
                <tr>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" colspan="3">Proyek</th>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" id="selectprkid" colspan="4"><select class="form-control select2" id="idprk" name="proyek" onchange="clear_items()">${list_proj}</select>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;"></th>
                    <input type="hidden" name="proj_name" value="" id="proj_name">
                </tr>
                <tr>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" colspan="8"></th>
                    <th style="background-color: #29a7de; color:white; font-weight: bold;" colspan="${2 * span_c}"></th>
                </tr>
                <tr class="bg-blue">
                    <th>1</th>
                    <th colspan="7">DATA PENYEDIA</th>
                    <th colspan="${2 * span_c}"></th>
                </tr>
                <tr>
                    <td>1.1</td>
                    <td colspan="7">Alamat</td>
                    ${addven}
                </tr>
                <tr>
                    <td>1.2</td>
                    <td colspan="7">Kontak Personal</td>
                    ${hpven}
                </tr>
                <tr>
                    <td>1.3</td>
                    <td colspan="7">No. Telpon / Fax</td>
                    ${telven}
                </tr>
                <tr>
                    <td>1.4</td>
                    <td colspan="7">Penawaran No. / Tanggal</td>
                    ${penven}
                </tr>
                <tr>
                    <td>1.5</td>
                    <td colspan="7">BA Klarifikasi dan Negosiasi Tgl</td>
                    ${klaven}
                </tr>
                <tr><th colspan="8"></th><th colspan="${2 * span_c}"></th></tr>
                <tr>
                    <th>2</th>
                    <th colspan="4">DATA PEKERJAAN / SPESIFIKASI <button data-id="kode_item" id="item_int_btn" class="ml-2 btn-sm btn btn-info picker sumberdaya_btn integrated hidden"><i class="ft ft-plus"></i></button></th>
                    <th colspan="3">RABP/COST PLAN (IDR)</th>
                    <th colspan="${2 * span_c}"></th>
                </tr>
                <tr>
                    <td>A).</td>
                    <td colspan="4">Penawaran</td>
                    <td></td>
                    <td></td>
                    <td colspan="${2 * span_c}"></td>
                </tr>
                <tr class="bold">
                    <td></td>
                    <td>No</td>
                    <td>PR</td>
                    <td>SDA</td>
                    <td>SAT</td>
                    <td>VOLUME</td>
                    <td>H. Satuan</td>
                    <td class="text-right">Harga</td>
                    ${vpenaw}
                </tr>
                <tbody id="tr_penawaran"></tbody>
                <tr>
                    <th></th>
                    <th>TOTAL</th>
                    <th colspan="3"></th>
                    <th colspan="3" id="totpen1" class="text-right chpr_txt">###</th>
                    <input type="hidden" name="total_rbap" class="chpr_inp" value="" id="total_rbap" />
                    ${vpento}
                </tr>
                <tr class="bold">
                    <td>B).</td>
                    <td colspan="4">Negosiasi</td>
                    <td></td>
                    <td></td>
                    <td colspan="${2 * span_c}"></td>
                </tr>
                <tbody id="tr_nego"></tbody>
                <tr>
                    <th></th>
                    <th>TOTAL</th>
                    <th colspan="3"></th>
                    <th colspan="3" id="totnego1" class="text-right chpr_txt">###</th>
                    ${vnegot}
                </tr>
                <tr><th colspan="8"></th><th colspan="${2 * span_c}"></th></tr>
                <tr>
                    <th>3</th>
                    <th colspan="4">KLARIFIKASI <span class="ml-2 btn-sm btn btn-info" onclick="add_klarifikasi(${span_c})"><i class="ft ft-plus"></i></span></th>
                    <th colspan="3"></th>
                    <th colspan="${2 * span_c}"></th>
                </tr>
                <tr>
                    <td>3.1</td>
                    <td colspan="7"><input type="text" class="form-control ff" name="poin_klarifikasi[]" value="Lingkup Pekerjaan" required></td>
                    ${klartx}
                </tr>
                <tr>
                    <td>3.2</td>
                    <td colspan="7"><input type="text" class="form-control ff" name="poin_klarifikasi[]" value="Jadwal Pelaksanaan" required></td>
                    ${klartx}
                </tr>
                <tr>
                    <td>3.3</td>
                    <td colspan="7"><input type="text" class="form-control ff" name="poin_klarifikasi[]" value="Cara Pembayaran" required></td>
                    ${klartx}
                </tr>
                <tr>
                    <td>3.4</td>
                    <td colspan="7"><input type="text" class="form-control ff" name="poin_klarifikasi[]" value="Jaminan-jaminan" required></td>
                    ${klartx}
                </tr>
                <tr>
                    <td>3.5</td>
                    <td colspan="7"><input type="text" class="form-control ff" name="poin_klarifikasi[]" value="Denda dan Sangsi" required></td>
                    ${klartx}
                </tr>
                <tr>
                    <td>3.6</td>
                    <td colspan="7"><input type="text" class="form-control ff" name="poin_klarifikasi[]" value="SMK3L" required></td>
                    ${klartx}
                </tr>
                <tbody id="tr_klatifikasi"></tbody>
                <tr><th colspan="8"></th><th colspan="${2 * span_c}"></th></tr>
                <tr>
                    <td colspan="13">Catatan Komisi Pengadaan <span class="ml-2 btn-sm btn btn-info" onclick="add_catatan()"><i class="ft ft-plus"></i></span></td>
                </tr>
                <tbody id="note_kom"></tbody>
            </table>
            <input type="hidden" name="is_sap" value=1>
            <hr>
            <table style="width: 100%" id="tbl_esign">
                <tr class="">
                    <th colspan="2">
                        <span class="ml-2 btn-sm btn btn-info" onclick="add_sign()"><i class="ft ft-plus"></i> Add Signatory</span>
                    </th>
                </tr>
                <tbody id="tr_esign"></tbody>
            </table>
        `;

        $('#tbl_inp_dpkn').html(depkn_tbl)
        selectidprk()
    })

    function clear_items() {
        order_itm = {}

        ppmn = ''
        $("#idprk").each(function(){
            ppmn = $('option:selected', this).attr('projname');
        })
        $('#proj_name').val(ppmn);
        $('#tr_penawaran').html('');
        $('#tr_nego').html('');
        $('.chpr_txt').html('');
        $('.chpr_inp').val(0);

        $('#item_int_btn').removeClass('hidden');
        set_picker();
    }

    function prevent_letter(e, le) {
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(`.uang`).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
        });
    }

    function selectRefresh() {
        $('#tbl_esign .select2').select2({
            tags: true,
            allowClear: true,
            width: '100%'
        });
    }

    var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });

    function add_catatan() {
        var uniq = rand(3);

        let elem = `
        <tr id="note_${uniq}">
        <td><span class="btn-sm btn btn-danger" onclick="remove_elem(note_${uniq});"><i class="ft ft-trash"></i></span></td>
        <td colspan="7"><input type="text" class="form-control ff" name="note[]" value=""></td>
        <td colspan="4"></td>
        </tr>
        `
        $("#note_kom").append(elem);
    }

    function add_klarifikasi(vendor) {
        var uniq = rand(3);

        elem = ``
        for (var i = 0; i < parseInt(vendor); i++) {
            elem += `<td colspan="2"><input type="text" class="form-control ff" name="klar_per_vend${i}[]" value="" required></td>`
        }

        let html = `
        <tr id="klar_${uniq}">
            <td><span class="btn-sm btn btn-danger"  onclick="remove_elem(klar_${uniq});"><i class="ft ft-trash"></i></span></td>
            <td colspan="7"><input type="text" class="form-control ff" name="poin_klarifikasi[]" value="" required></td>
            ${elem}
        </tr>
        `
        $("#tr_klatifikasi").append(html);
    }

    function add_sign() {
        var uniq = rand(3);

        let html = `
        <tr id="sign_${uniq}">
            <td width="5%" class="text-right"><span class="btn-sm btn btn-danger" onclick="remove_elem(sign_${uniq});"><i class="ft ft-trash"></i></span></td>
            <td>
                <select class="form-control ff form_header select2" id="nmKew" name="nm_kew[]">${list_hcis}</select>
                <input type="hidden" name="kategori[]" value="Mengusulkan">
                <input type="hidden" name="posisi[]" value="Anggota">
            </td>
        </tr>
        `
        $("#tr_esign").append(html);
        selectRefresh()
    }

    function set_picker() {
        let sspk = $('#idprk').val;
        if (sspk != '') {
            var item_int_btn_url = "<?php echo site_url('procurement/get_picker_sumberdaya_sap_new') ?>";
            if ($('#idprk').val() != '') {
                $('#item_int_btn').attr('data-url', item_int_btn_url + "?spk_code=" + $("#idprk").val())
            }
        }

        $('#picker_pick').on('click', function() {
            let prnum = $('input[name="btSelectItem"]:checked').val();
            add_penawaran(vend_totl, prnum)
        })
    }

    // check budget sap
    function get_status_budget() {
        var res_status_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_status_budget = data['E_STATUS'];
                    } else {
                        res_status_budget = data['E_PESAN'];
                    }
                }
            });
            return res_status_budget;
        }
    }

    function get_val_budget() {
        var res_val_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_val_budget = data['PRVAL'];
                    } else {
                        res_val_budget = data['E_PESAN'];
                    }
                }
            });
            return res_val_budget;
        }
    }

    function get_exc_budget() {
        var res_exc_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_exc_budget = data['E_EXCED'];
                    } else {
                        res_exc_budget = data['E_PESAN'];
                    }
                }
            });
            return res_exc_budget;
        }
    }

    function get_curr_budget() {
        var res_curr_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_curr_budget = data['PRCUR'];
                    } else {
                        res_curr_budget = data['E_PESAN'];
                    }
                }
            });
            return res_curr_budget;
        }
    }

    function get_itm_budget() {
        var res_itm_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_itm_budget = data['PRITM'];
                    } else {
                        res_itm_budget = data['E_PESAN'];
                    }
                }
            });
            return res_itm_budget;
        }
    }

    function get_num_budget() {
        var res_num_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_num_budget = data['PRNUM'];
                    } else {
                        res_num_budget = data['E_PESAN'];
                    }
                }
            });
            return res_num_budget;
        }
    }

    function get_wbs_budget() {
        var res_wbs_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_wbs_budget = data['E_WBS'];
                    } else {
                        res_wbs_budget = data['E_PESAN'];
                    }
                }
            });
            return res_wbs_budget;
        }
    }

    function get_avl_budget() {
        var res_avl_budget;
        if ($('#idprk').val() != '') {
            $.ajax({
                url: '<?php echo site_url("uskep_online_sap/get_budget/");?>' + $('#idprk').val(),
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if (data['E_STATUS'] == 'OK') {
                        res_avl_budget = data['E_AVAIL'];
                    } else {
                        res_avl_budget = data['E_PESAN'];
                    }
                }
            });
            return res_avl_budget;
        }
    }

    $(document).ready(function(){
        $('.check-budget').on('click', function () {
            if (get_status_budget() == 'OK') {
                Swal.fire({
                    title: 'STATUS ' + get_status_budget(),
                    text: 'PRVAL : ' + new Intl.NumberFormat().format(get_val_budget()) + ' CURR : ' + get_curr_budget() + ' PR NUMBER : ' + get_num_budget(),
                    type: "success",
                    confirmButtonClass: 'btn btn-info',
                    buttonsStyling: false,
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: " Data Budget Tidak Ditemukan",
                    type: "error",
                    confirmButtonClass: 'btn btn-info',
                    buttonsStyling: false,
                });
            }
        });
    });

</script>
