<style media="screen">
.form_header {
    border-radius: 5px;
    width: 10%;
    height: 30px;
    border: 1px solid gray;
    background-color: #fff;
}
.hidden{
    display: none;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header border-bottom pb-2">
                <div class="btn-group-sm">
                    <span class="card-title text-bold-600 mr-2">Uskep Online </span>
                    <?php if ($mtode != ''): ?>
                        <input type="text" class="form_header" value="<?php echo str_replace("_", " ", $mtode); ?>" readonly>
                        <input type="hidden" name="mth_pengadaan" value="<?php echo $mtode ?>">
                    <?php else: ?>
                        <select class="form_header" name="mth_pengadaan" id="mth_" onchange="is_pl();">
                            <option value="">Metode Pengadaan</option>
                            <option value="Tender_Umum" >Tender Umum</option>
                            <option value="Tender_Terbatas" >Tender Terbatas</option>
                            <option value="Penunjukan_Langsung" >Penunjukan Langsung</option>
                            <option value="Pembelian_Langsung" >Pembelian Langsung</option>
                        </select>
                    <?php endif; ?>
                    <span id="add_usk" class="<?php echo $dsp == '' ? '' : 'hidden' ?>">
                        <select class="form_header" name="typewin" onchange="showbtn()">
                            <option value="">Pilih Pemenang</option>
                            <option value="1">Single Winner</option>
                            <option value="2">Multiple winner</option>
                        </select>
                        <input id="twin" type="number" class="form_header hidden" name="twin" onchange="setval()" value="" placeholder="Total Pemenang">
                        <span id="tamb" class="hidden"><a id="addval" href="<?php echo site_url('uskep_online_sap/dsp') ?>" class="btn btn-info btn-sm ml-2"><i class="ft-plus"></i> Tambah</a></span>
                    </span>
                    <span></span>

                    <span id="tamb" class="hidden"><a id="addval" href="<?php echo site_url('uskep_online_sap/dsp') ?>" class="btn btn-info btn-sm ml-2"><i class="ft-plus"></i> Tambah</a></span>

                    <a onclick="remove_data()" class="ml-2 btn btn-danger btn-sm <?php echo $dsp == '' ? 'hidden' : '' ?>" id="btnremove"><i class="ft ft-trash"></i> Hapus</a>
                    <div class="float-right position-relative">
                        <a onclick="fUploadDoc_bakp()" class="btn btn-danger btn-sm <?php echo $bakp_filename != '' ? '' : 'hidden' ?>" id="btnshare"><i class="ft ft-upload"></i> Upload & Share E-Sign</a>
                        <a class="btn btn-sm btn-info <?php echo $bakp != '' ? '' : 'hidden' ?>" href="<?php echo site_url('uskep_online_sap/uskep_pdf/') . $rfq ?>" onclick="show_share()" target="_blank">Export PDF</a>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table_uskeponline">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dokumen</th>
                                    <!-- <th class="text-center">Status E-Sign</th>
                                    <th class="text-center">Lampiran</th> -->
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_usk">
                                <?php if ($dsp != ''): ?>
                                    <tr>
                                        <td>1</td>
                                        <td>Dokumen Sistem Penilaian</td>
                                        <!-- <td class="text-center">
                                            <?php if ($dsp_status_esign != ''): ?>
                                                <a class="btn btn-sm btn-success" href="<?php echo site_url('privyDSP/save_doc/') . $rfq ?>" target="_blank">Save Document Privy</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info" href="<?php echo site_url('uskep_online_sap/dsp_pdf/') . $rfq ?>" onclick="show_share()" target="_blank">Export PDF</a>
                                            <a onclick="fUploadDoc_dsp()" class="btn btn-danger btn-sm <?php echo $dsp_filename != '' ? '' : 'hidden' ?>" id="btnshare"><i class="ft ft-upload"></i> Upload & Share E-Sign</a>
                                        </td> -->
                                        <td class="text-center">
                                            <a href="<?php echo site_url('uskep_online_sap/edit_dsp/') . '-' . '/' . $rfq ?>" class="btn btn-sm btn-warning"><i class="ft ft-edit"></i> Edit</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($dpkn != ''): ?>
                                    <tr>
                                        <td>2</td>
                                        <td>Dokumen Evaluasi Penawaran, Klarifikasi dan Negosiasi</td>
                                        <!-- <td class="text-center">
                                            <?php if ($dpkn_status_esign != ''): ?>
                                                <a class="btn btn-sm btn-<?= $dpkn_status_esign[1] == 'done' ? 'success' : 'warning' ?>" href="<?php echo site_url('privyDPKN/save_doc/') . $rfq ?>" target="_blank">Save Document Privy</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info" href="<?php echo site_url('uskep_online_sap/dpkn_pdf/') . $rfq ?>" onclick="show_share_dpkn()" target="_blank">Export PDF</a>
                                            <a onclick="fUploadDoc_dpkn()" class="btn btn-danger btn-sm <?php echo $dpkn_filename != '' ? '' : 'hidden' ?>" id="btnshare_dpkn"><i class="ft ft-upload"></i> Upload & Share E-Sign</a>
                                        </td> -->
                                        <td class="text-center">
                                            <a href="<?php echo site_url('uskep_online_sap/edit_dpkn/') . '-' . '/' . $rfq ?>" class="btn btn-sm btn-warning"><i class="ft ft-edit"></i> Edit</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($bakp != ''): ?>
                                    <tr>
                                        <td>3</td>
                                        <?php if ($mtode == "Penunjukan_Langsung"): ?>
                                            <td>Berita Acara Keputusan Penunjukan Langsung</td>
                                        <?php else: ?>
                                            <td>Berita Acara Keputusan Pemenang</td>
                                        <?php endif; ?>
                                        <!-- <td class="text-center">
                                            <?php if ($bakp_status_esign != ''): ?>
                                                <a class="btn btn-sm btn-<?= $bakp_status_esign[1] == 'done' ? 'success' : 'warning' ?>" href="<?php echo site_url('privyBAKP/save_doc/') . $rfq ?>" target="_blank">Save Document Privy</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info" href="<?php echo site_url('uskep_online_sap/bakp_pdf/') . $rfq ?>"  onclick="show_share_bakp()" target="_blank">Export PDF</a>
                                            <a onclick="fUploadDoc_bakp()" class="btn btn-danger btn-sm <?php echo $bakp_filename != '' ? '' : 'hidden' ?>" id="btnshare_bakp"><i class="ft ft-upload"></i> Upload & Share E-Sign</a>
                                        </td> -->
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-warning" href="<?php echo site_url('uskep_online_sap/edit_bakp/') . '-' . '/' . $rfq ?>" ><i class="ft ft-edit"></i> Edit</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">

    function is_pl() {
        let nn = $('#mth_').val()
        if (nn == 'Pembelian_Langsung') {
            $('#sbmbtn').removeClass('hide')
        } else {
            $('#sbmbtn').addClass('hide')
        }
    }

    function remove_data() {
        if (confirm('Anda yakin menghapus data USKEP?')) {
            $(`#myLoader`).modal('show');
            $.ajax({
                url: '<?php echo site_url()."/uskep_online_sap/remove_data/" . $rfq;?>',
                method: 'POST',
                dataType: 'json',
                success: function(res) {
                    setTimeout(function() {
                        if (res == 1) {
                            if (!$(`#btnremove`).hasClass('hidden')) {
                                $(`#btnremove`).addClass('hidden')
                            }
                            $(`#add_usk`).removeClass('hidden')
                            $(`#data_usk`).html('');
                            $(`#myLoader`).modal('hide');
                            toastr.success('Data USKEP berhasil dihapus!', '<i class="ft ft-check-square"></i> Success!');
                        } else {
                            $(`#myLoader`).modal('hide');
                            toastr.error('Data USKEP gagal dihapus!', '<i class="ft ft-alert-triangle"></i> Error!');
                        }
                    }, 1000);
                }
            })
            window.location = window.location
        }
    }

    function show_share() {
        $(`#btnshare`).removeClass('hidden')
    }

    function show_share_dpkn() {
        $(`#btnshare_dpkn`).removeClass('hidden')
    }

    function show_share_bakp() {
        $(`#btnshare_bakp`).removeClass('hidden')
    }

    function showbtn() {
        let sel = $(`select[name=typewin]`).val()
        let mtd = $(`select[name=mth_pengadaan]`).val()
        if (mtd == '') {
            $(`select[name=typewin]`).val('')
            alert('Metode Pengadaan harus dipilih!')
            return false
        }
        if (sel == 1) {
            $(`#tamb`).removeClass('hidden')
            if (!$(`#twin`).hasClass('hidden')) {
                $(`#twin`).addClass('hidden')
            }
            $(`#addval`).attr('href', '<?php echo site_url('uskep_online_sap/dsp/') ?>' + sel + '/' + mtd)
        } else {
            if (!$(`#tamb`).hasClass('hidden')) {
                $(`#tamb`).addClass('hidden')
            }
            $(`#twin`).removeClass('hidden')
            $(`#twin`).val('')
        }
    }

    function setval() {
        $(`#tamb`).removeClass('hidden')
        let mtd = $(`select[name=mth_pengadaan]`).val()
        if (mtd == '') {
            $(`select[name=typewin]`).val('')
            alert('Metode Pengadaan harus dipilih!')
            return false
        }
        let twin = $(`#twin`).val()
        $(`#addval`).attr('href', '<?php echo site_url('uskep_online_sap/dsp/') ?>' + twin + '/' + mtd)
    }

    function fUploadDoc_dsp() {
		$(`#myLoader`).modal('show');
        var url = '<?php echo site_url()."/PrivyDSP/upload_doc/".$rfq; ?>';
        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function (response) {
                if (response) {
                    toastr.success('Dokumen DSP Berhasil di Upload!', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Dokumen DSP Gagal di Upload!', '<i class="ft ft-alert-triangle"></i> Error!');
                }
                $(`#myLoader`).modal('hide');
            },
			error: function(xhr, status, error) {
				toastr.success('Dokumen DSP Berhasil di Upload!', '<i class="ft ft-check-square"></i> Success!');
				$(`#myLoader`).modal('hide');
			}
        });
    }

    function fUploadDoc_dpkn() {
        $(`#myLoader`).modal('show');
        var url = '<?php echo site_url()."/PrivyDPKN/upload_doc/".$rfq; ?>';
        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function (response) {
                if (response) {
                    toastr.success('Dokumen DEPKN Berhasil di Upload!', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Dokumen DEPKN Gagal di Upload!', '<i class="ft ft-alert-triangle"></i> Error!');
                }
                $(`#myLoader`).modal('hide');
            },
			error: function(xhr, status, error) {
				toastr.success('Dokumen DEPKN Berhasil di Upload!', '<i class="ft ft-check-square"></i> Success!');
				$(`#myLoader`).modal('hide');
			}
        });
    }

    function fUploadDoc_bakp() {
        $(`#myLoader`).modal('show');
        var url = '<?php echo site_url()."/PrivySAP/upload_doc/".$rfq; ?>';
        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function (response) {
                if (response) {
                    toastr.success('Dokumen BAKP Berhasil di Upload!', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Dokumen BAKP Gagal di Upload!', '<i class="ft ft-alert-triangle"></i> Error!');
                }
                $(`#myLoader`).modal('hide');
            },
			error: function(xhr, status, error) {
				toastr.success('Dokumen BAKP Berhasil di Upload!', '<i class="ft ft-check-square"></i> Success!');
				$(`#myLoader`).modal('hide');
			}
        });
    }
</script>
