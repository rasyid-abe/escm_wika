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
                <table>
                    <tr>
                        <td rowspan="2" width=10%%><span class="card-title text-bold-600 mr-2">Uskep Online </span></td>
                        <td widht=10%><small><span style="width:200px" class="ml-1">Metode Pengadaan :</span></small></td>
                        <?php if ($dpkn == ''): ?>
                            <td><small><span class="ml-1">Pemenang :</span></small></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td width=10%>
                            <?php if ($dpkn == ''): ?>
                                <select style="width:200px" class="form_header" name="mth_pengadaan" id="mth_" onchange="is_pl();">
                                    <option value="Tender_Terbatas" <?= $mtode == "Tender_Terbatas" ? "selected" : "" ?>>Tender Terbatas</option>
                                    <option value="Tender_Umum" <?= $mtode == "Tender_Umum" ? "selected" : "" ?>>Tender Umum</option>
                                    <option value="Penunjukan_Langsung" <?= $mtode == "Penunjukan_Langsung" ? "selected" : "" ?>>Penunjukan Langsung</option>
                                </select>
                            <?php else: ?>
                                <select style="width:200px" class="form_header" name="mth_pengadaan" id="mth_" onchange="is_pl();">
                                    <?php if ($mtode == 'Tender_Terbatas'): ?>
                                        <option value="Tender_Terbatas" <?= $mtode == "Tender_Terbatas" ? "selected" : "" ?>>Tender Terbatas</option>
                                    <?php elseif ($mtode == 'Tender_Umum'): ?>
                                        <option value="Tender_Umum" <?= $mtode == "Tender_Umum" ? "selected" : "" ?>>Tender Umum</option>
                                    <?php else: ?>
                                        <option value="Penunjukan_Langsung" <?= $mtode == "Penunjukan_Langsung" ? "selected" : "" ?>>Penunjukan Langsung</option>
                                    <?php endif; ?>
                                </select>
                            <?php endif; ?>
                        </td>
                        <?php if ($dpkn == ''): ?>
                            <td>
                                <span id="add_usk" class="<?php echo $dpkn == '' ? '' : 'hidden' ?>">
                                    <select style="width:200px" class="form_header" name="typewin" onchange="showbtn()">
                                        <option value="1">Single Winner</option>
                                        <option value="2">Multiple winner</option>
                                    </select>
                                    <input id="twin" type="number" class="form_header hidden" name="twin" onchange="setval()" value="" placeholder="Total Pemenang">
                                    <a href="#" id="tamb" class="btn btn-info btn-sm ml-2"><i class="ft-plus"></i> Create Uskep Online</a>
                                    <div type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#upld_UskepOnline"><i class="fa fa-upload"></i> Upload Uskep Manual</div>
                                </span>
                            </td>
                        <?php endif; ?>
                        <td>
                            <!-- <a onclick="remove_data()" class="ml-2 btn btn-danger btn-sm <?php echo $dpkn == '' ? 'hidden' : '' ?>" id="btnremove"><i class="ft ft-trash"></i> Hapus</a> -->
                            <div class="float-right position-relative">
                                <!-- <input type="hidden" id="is_upload" value="<?php echo $is_upload ?>"> -->
                                <!-- <a onclick="fUploadDoc_bakp()" class="btn btn-danger btn-sm hidden" id="btnshare"><i class="ft ft-upload"></i> Upload & Share E-Sign</a> -->
                                <?php if ($bakp_filename != ''): ?>
                                    <a target="_blank" href="<?php echo base_url('uploads/' . $bakp_filename) ?>" class="btn btn-sm btn-info"><i class="ft ft-pdf"></i> Lihat Dokumen PDF</a>
                                <?php else: ?>
                                    <a class="btn btn-sm btn-info <?php echo $bakp != '' ? '' : 'hidden' ?>" href="<?php echo site_url('uskep_online_sap/uskep_pdf/') . $rfq ?>" onclick="show_share()" target="_blank">Export PDF</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table_uskeponline">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th class="text-left">Nama Dokumen</th>
                                    <!-- <th class="text-center">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody id="data_usk">
                                <?php if ($dpkn != ''): ?>
                                    <tr>
                                        <td>1</td>
                                        <?php if ($dpkn != '0'): ?>
                                            <td class="text-left">Dokumen Evaluasi Penawaran, Klarifikasi dan Negosiasi</td>
                                        <?php else: ?>
                                            <td><?php echo str_replace(".pdf", " ", str_replace("_"," ",$bakp_filename)) ?></td>
                                        <?php endif; ?>
                                        <!-- <td class="text-center">
                                            <?php if ($dpkn != '0'): ?>
                                                <a href="<?php echo site_url('uskep_online_sap/edit_dpkn/') . '-' . '/' . $rfq ?>" class="btn btn-sm btn-warning"><i class="ft ft-edit"></i> Edit</a>
                                            <?php else: ?>
                                                <a target="_blank" href="<?php echo base_url('uploads/' . $bakp_filename) ?>" class="btn btn-sm btn-warning"><i class="ft ft-edit"></i> Lihat</a>
                                            <?php endif; ?> -->
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($dsp != ''): ?>
                                    <tr>
                                        <td>2</td>
                                        <td class="text-left">Dokumen Sistem Penilaian</td>
                                        <!-- <td class="text-center">
                                            <a href="<?php echo site_url('uskep_online_sap/edit_dsp/') . '-' . '/' . $rfq ?>" class="btn btn-sm btn-warning"><i class="ft ft-edit"></i> Edit</a>
                                        </td> -->
                                    </tr>
                                <?php endif; ?>
                                <?php if ($bakp != ''): ?>
                                    <tr>
                                        <td>3</td>
                                        <?php if ($mtode == "Penunjukan_Langsung"): ?>
                                            <td class="text-left">Berita Acara Keputusan Penunjukan Langsung</td>
                                        <?php else: ?>
                                            <td class="text-left">Berita Acara Keputusan Pemenang</td>
                                        <?php endif; ?>
                                        <!-- <td class="text-center">
                                            <a class="btn btn-sm btn-warning" href="<?php echo site_url('uskep_online_sap/edit_bakp/') . '-' . '/' . $rfq ?>" ><i class="ft ft-edit"></i> Edit</a>
                                        </td> -->
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

    $(document).ready(function() {
        set_attr()
    })

    function set_attr() {
        let sel = $(`select[name=typewin]`).val()
        let mtd = $(`select[name=mth_pengadaan]`).val()

        if (sel == 1) {
            $(`#tamb`).attr('href', '<?php echo site_url('uskep_online_sap/dpkn/') ?>' + sel + '/' + mtd)
        } else {
            $(`#twin`).removeClass('hidden')
            $(`#twin`).val('')
        }
    }

    function is_pl() {
        set_attr()
    }

    function remove_data() {
        if (confirm('Anda yakin menghapus data USKEP?')) {
            $(`#myLoader`).modal('show');
            $.ajax({
                url: '<?php echo site_url()."/uskep_online_sap/remove_data/" . $rfq;?>',
                method: 'POST',
                dataType: 'json',
                success: function(res) {
                    window.location = window.location
                }
            })
        }
    }

    function show_share() {
        let dpkn = $('#is_upload').val()
        if (dpkn == 1) {
            $(`#btnshare`).removeClass('hidden')
        }
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
            $(`#tamb`).attr('href', '<?php echo site_url('uskep_online_sap/dpkn/') ?>' + sel + '/' + mtd)
        } else {
            if (!$(`#tamb`).hasClass('hidden')) {
                $(`#tamb`).addClass('hidden')
            }
            $(`#twin`).removeClass('hidden')
            $(`#twin`).val('')
        }
    }

    function setval() {
        let mtd = $(`select[name=mth_pengadaan]`).val()
        let twin = $(`#twin`).val()
        // if (!$(`#tamb`).hasClass('hidden')) {
        // }
        $(`#tamb`).removeClass('hidden')
        $(`#tamb`).attr('href', '<?php echo site_url('uskep_online_sap/dpkn/') ?>' + twin + '/' + mtd)
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
