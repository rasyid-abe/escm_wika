<form method="post" action="<?php echo site_url($controller_name . "/submit_proses_drup"); ?>" class="form-horizontal ajaxform">

    <div class="row">
        <div class="col-12">
            <div class="card" style="border-radius: 20px;">
                <div class="card-header border-bottom pb-2">
                    <div class="btn-group-sm">
                        <span class="card-title text-bold-600">Headline</span>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row mx-2 mb-2">
                            <!-- left-side -->
                            <div class="col-sm-6">
                                <div class="row form-group mb-1">
                                    <label class="col-sm-4 control-label">Pemilik Program <span class="text-danger text-bold-700">*</span> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="pemilik_program_inp" id="pemilik_program_inp" required style="width: 100%">
                                            <option value="">Pilih Pemilik Program</option>
                                            <?php foreach ($dept_name as $v) { ?>
                                                <option value="<?php echo $v['dept_name']; ?>" <?php echo $userdata['dept_name'] == $v['dept_name'] ? 'selected' : ''; ?>><?php echo $v['dept_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label class="col-sm-4 control-label">Jenis Penyedia <span class="text-danger text-bold-700">*</span> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="jenis_penyedia_inp" id="jenis_penyedia_inp" required style="width: 100%">
                                            <option value="">Pilih Jenis Penyedia</option>
                                            <option value="Barang">Barang</option>
                                            <option value="Jasa">Jasa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label class="col-sm-4 control-label">P I C <span class="text-danger text-bold-700">*</span> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="pic_inp" id="pic_inp" required style="width: 100%">
                                            <option value="">Pilih PIC</option>
                                            <?php foreach ($adm_user as $v) { ?>
                                                <option value="<?php echo $v['complete_name']; ?>" <?php echo $userdata['complete_name'] == $v['complete_name'] ? 'selected' : ''; ?>><?php echo $v['complete_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- right-side -->
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <label class="col-sm-4 control-label">Pengelola Anggaran <span class="text-danger text-bold-700">*</span> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="pengelola_anggaran_inp" id="pengelola_anggaran_inp" required style="width: 100%">
                                            <option value="">Pilih Pengelola Anggaran</option>
                                            <?php foreach ($dept_name as $v) { ?>
                                                <option value="<?php echo $v['dept_name']; ?>" <?php echo $userdata['dept_name'] == $v['dept_name'] ? 'selected' : ''; ?>><?php echo $v['dept_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group mt-2">
                                    <label class="col-sm-4 control-label">Swakelola <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="checkbox checkbox-info">
                                            <input type="checkbox" name="swakelola_inp" id="color-checkbox-1" value="Ya">
                                            <label for="color-checkbox-1"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card" style="border-radius: 20px;">
                <div class="card-header border-bottom pb-2">
                    <div class="btn-group-sm float-left">
                        <span class="card-title text-bold-600 mr-2">Detail Produk</span> <span><a onclick="isShowAddDrup()" class="btn btn-info btn-sm rounded"><i class="ft-plus"></i> Tambah</a></span>
                    </div>
                    <div class="btn-group-sm float-right position-relative" id="showButtonDrup">
                        <input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info btn-sm action_drup btn-plus" value="Simpan">
                        <a class="btn btn-sm btn-sm empty_drup btn-trash" title="Hapus"><i class="ft-trash"></i></a>
                        <input type="hidden" id="current_drup" name="current_drup" value="" />
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="showAddDrup">
                            <div class="row mx-2 mb-2">
                                <!-- left-side -->
                                <div class="col-sm-6">

                                    <?php $curval = set_value("kode_item"); ?>
                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Sumberdaya <span class="text-danger text-bold-700">*</span> </label>
                                        <div class="col-sm-8">
                                            <input readonly type="text" class="form-control col-sm-6 mr-2" name="kode_item" id="kode_item" placeholder="Kode Sumberdaya" required value="<?php echo $curval ?>">
                                            <div class="btn-group-sm">
                                                <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_ALL_PATH . '/picker') ?>" class="btn btn-info btn-sm picker">Pilih Sumberdaya</button>
                                            </div>
                                        </div>
                                    </div>

                                    <?php $curval = set_value("id"); ?>
                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Nama Sumberdaya </label>
                                        <div class="col-sm-8">
                                            <input readonly type="hidden" name="id_inp" id="id_inp" value="<?php echo $curval ?>">
                                            <input readonly type="hidden" name="deskripsi_item_inp" id="deskripsi_item_inp" value="<?php echo $curval ?>">
                                            <span class="form-control-static" id="deskripsi_item"><?php echo $curval ?>-</span>
                                        </div>
                                    </div>

                                    <?php $curval = set_value("satuan_item_inp"); ?>
                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Satuan </label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control" name="satuan_item_inp" id="satuan_item_inp" placeholder="Satuan item" value="<?php echo $curval ?>">
                                        </div>
                                    </div>

                                    <?php $curval = set_value("jumlah_item_inp"); ?>
                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Volume <span class="text-danger text-bold-700">*</span> </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control money" maxlength="6" name="jumlah_item_inp" id="jumlah_item_inp" required placeholder="0" value="<?php echo $curval ?>">
                                            <small id="max_volume"></small>
                                        </div>
                                    </div>

                                    <?php $curval = set_value("harga_satuan_item_inp"); ?>
                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Harga Satuan RAB <span class="text-danger text-bold-700">*</span> </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control money" name="harga_satuan_item_inp" id="harga_satuan_item_inp" placeholder="Harga satuan RAB" readonly value="<?php echo $curval ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- right-side -->
                                <div class="col-sm-6">
                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Chart of Account (COA) <span class="text-danger text-bold-700">*</span> </label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="coa_id_inp" id="coa_id_inp" required style="width:100%;">
                                                <option value="">Pilih COA</option>
                                                <?php foreach ($coa_data as $value) { ?>
                                                    <option class="form-control" value="<?php echo $value['id']; ?>"><?php echo $value['kode_perkiraan'] . ' - ' . $value['nama_perkiraan']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Mata Uang <span class="text-danger text-bold-700">*</span> </label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="drup_currency" id="drup_currency" required style="width:100%;">
                                                <option value="">Pilih Mata Uang</option>
                                                <?php foreach ($currency as $row) { ?>
                                                    <option value="<?php echo $row["curr_code"] ?>" data-rates='<?php echo $row["sell"] ?>' <?php if (isset($header)) {
                                                                                                                                                if (($header["pqm_currency"] == $row["curr_code"])) {
                                                                                                                                                    echo "selected";
                                                                                                                                                }
                                                                                                                                            } ?>><?php echo $row["curr_code"] . " - " . $row["curr_name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php $curvalAwal = set_value("tgl_mulai_pengadaan_inp"); ?>
                                    <?php $curvalAkhir = set_value("tgl_akhir_pengadaan_inp"); ?>
                                    <div class="row form-group" style="margin-bottom: 0">
                                        <label class="col-sm-4 control-label">Pelaksanaan Pengadaan <span class="text-danger text-bold-700">*</span> </label>
                                        <div class="row col-sm-8">
                                            <div class="input-group input-group-sm col-sm-6">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Mulai</span>
                                                </div>
                                                <input type="date" name="tgl_mulai_pengadaan_inp" id="tgl_mulai_pengadaan_inp" required class="form-control" value="<?php echo $curvalAwal ?>">
                                            </div>
                                            <div class="input-group input-group-sm col-sm-6">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Akhir</span>
                                                </div>
                                                <input type="date" name="tgl_akhir_pengadaan_inp" id="tgl_akhir_pengadaan_inp" required class="form-control" value="<?php echo $curvalAkhir ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <?php $curvalAwal = set_value("tgl_mulai_pekerjaan_inp"); ?>
                                    <?php $curvalAkhir = set_value("tgl_akhir_pekerjaan_inp"); ?>
                                    <div class="row form-group" style="margin-bottom: 0">
                                        <label class="col-sm-4 control-label">Pelaksanaan Pekerjaan <span class="text-danger text-bold-700">*</span> </label>
                                        <div class="row col-sm-8">
                                            <div class="input-group input-group-sm col-sm-6">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Mulai</span>
                                                </div>
                                                <input type="date" name="tgl_mulai_pekerjaan_inp" id="tgl_mulai_pekerjaan_inp" required class="form-control" value="<?php echo $curvalAwal ?>">
                                            </div>
                                            <div class="input-group input-group-sm col-sm-6">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Akhir</span>
                                                </div>
                                                <input type="date" name="tgl_akhir_pekerjaan_inp" id="tgl_akhir_pekerjaan_inp" required class="form-control" value="<?php echo $curvalAkhir ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-4 control-label">Catatan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" maxlength="50" name="catatan_inp" id="catatan_inp" placeholder="Catatan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                        <th rowspan="2" style="vertical-align: middle;">Action</th>
                                    </tr>
                                    <tr>
                                        <th>Pemilik Program</th>
                                        <th>Pengelola Anggaran</th>
                                        <th>Penyedia</th>
                                        <th>Swasekola</th>
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
                                    <?php $noabjd = 'A';
                                    foreach ($drup_data as $value) { ?>
                                        <tr style="background-color: #f7f7f7">
                                            <td class="text-center text-bold-700 font-small-2"><?php echo $noabjd++; ?></td>
                                            <td class="text-center text-bold-700 font-small-2"><?php echo $value['kode_perkiraan']; ?></td>
                                            <td colspan="16" class="text-left text-bold-700 font-small-2"><?php echo $value['nama_perkiraan']; ?></td>
                                        </tr>
                                        <?php
                                        $no = 1;
                                        $sql = "
                                                    SELECT * FROM prc_proses_drup ppd
                                                    WHERE coa_id ='" . $value["coa_id"] . "'
                                                ";
                                        $detail = $this->db->query($sql)->result_array();
                                        foreach ($detail as $key => $value_in) {
                                            $myid = $value_in['id'];
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">
                                                    <input type="hidden" name="id_v" id="id_v" value="<?php echo $value_in['id'] ?>" data-no="<?php echo $myid ?>" />
                                                    <input type="hidden" name="coa_id_v" id="coa_id_v" value="<?php echo $value_in['coa_id'] ?>" data-no="<?php echo $myid ?>" />
                                                    <input type="hidden" name="currency_v" id="currency_v" value="<?php echo $value_in['currency'] ?>" data-no="<?php echo $myid ?>" />
                                                    <input type="hidden" name="kode_item_v" id="kode_item_v" value="<?php echo $value_in['kode_sumber_daya'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['kode_sumber_daya']; ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="deskripsi_item_v" id="deskripsi_item_v" value="<?php echo $value_in['nama_program'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['nama_program']; ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="pemilik_program_v" id="pemilik_program_v" value="<?php echo $value_in['pemilik_program'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['pemilik_program']; ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="pengelola_anggaran_v" id="pengelola_anggaran_v" value="<?php echo $value_in['pengelola_anggaran'] ?>" data-no="<?php echo $myid ?>" />
                                                    <input type="hidden" name="pic_v" id="pic_v" value="<?php echo $value_in['pic_user'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['pengelola_anggaran']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="tipe_v" id="tipe_v" value="<?php echo $value_in['penyedia'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['penyedia']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $value_in['swakelola']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="tgl_mulai_pengadaan_v" id="tgl_mulai_pengadaan_v" value="<?php echo $value_in['tgl_mulai_pengadaan'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['tgl_mulai_pengadaan']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="tgl_akhir_pengadaan_v" id="tgl_akhir_pengadaan_v" value="<?php echo $value_in['tgl_akhir_pengadaan'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['tgl_akhir_pengadaan']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="tgl_mulai_pekerjaan_v" id="tgl_mulai_pekerjaan_v" value="<?php echo $value_in['tgl_mulai_pekerjaan'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['tgl_mulai_pekerjaan']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="tgl_akhir_pekerjaan_v" id="tgl_akhir_pekerjaan_v" value="<?php echo $value_in['tgl_akhir_pekerjaan'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['tgl_akhir_pekerjaan']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="jumlah_item_v" id="jumlah_item_v" value="<?php echo $value_in['volume'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['volume']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="satuan_v" id="satuan_v" value="<?php echo $value_in['satuan'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['satuan']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" name="harga_satuan_v" id="harga_satuan_v" value="<?php echo $value_in['harga_satuan'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo number_format($value_in['harga_satuan']); ?>
                                                </td>
                                                <td class="text-center"><?php echo number_format($value_in['volume'] * $value_in['harga_satuan']); ?></td>
                                                <td>
                                                    <input type="hidden" name="catatan_v" id="catatan_v" value="<?php echo $value_in['catatan'] ?>" data-no="<?php echo $myid ?>" />
                                                    <?php echo $value_in['catatan']; ?>
                                                </td>
                                                <td class="text-center btn-group">
                                                    <button data-no="<?php echo $myid ?>" class="btn btn-sm btn-info edit_drup" title="Edit" type="button">
                                                        <i class="ft-edit"></i>
                                                        <input type="hidden" name="drup_id[<?php echo $myid ?>]" value="<?php echo $myid ?>" />
                                                    </button>
                                                    <a href="<?php echo site_url('perencanaan_pengadaan/hapus/' . $value_in['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin hapus data ini?')" title="Hapus">
                                                        <i class="ft-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr style="background-color: #f7f7f7">
                                        <td colspan="14">&nbsp;</td>
                                        <td class="text-center text-bold-700">TOTAL</td>
                                        <td class="text-right text-bold-700"><?php echo number_format($total_data['total']); ?></td>
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
    </div>

</form>

<script type="text/javascript">
    $(document).ready(function() {

        var item_int_btn_url = "<?php echo site_url('procurement/get_picker_sumberdaya') ?>";

        $(document.body).on("click", ".empty_drup", function() {
            $('#max_volume').html('');
            $("#kode_item").val("");
            $("#deskripsi_item").val("");
            $("#deskripsi_item_inp").val("");
            $("#satuan_item_inp").val("");
            $("#jumlah_item_inp").val("");
            $("#harga_satuan_item_inp").val("");
            $("#coa_id_inp").val("");
            $("#drup_currency").val("");
            $("#drup_currency").val("");
            $("#tgl_mulai_pengadaan_inp").val("");
            $("#tgl_akhir_pengadaan_inp").val("");
            $("#tgl_mulai_pekerjaan_inp").val("");
            $("#tgl_akhir_pekerjaan_inp").val("");
            $("#catatan_inp").val("");
        });

        $(document.body).on("click", ".edit_drup", function() {
            var no = $(this).attr('data-no');
            var id_inp = $("#id_v[data-no='" + no + "']").val();
            var pemilik_program_inp = $("#pemilik_program_v[data-no='" + no + "']").val();
            var pic_inp = $("#pic_v[data-no='" + no + "']").val();
            var pengelola_anggaran_inp = $("#pengelola_anggaran_v[data-no='" + no + "']").val();
            var coa_id_inp = $("#coa_id_v[data-no='" + no + "']").val();
            var drup_currency = $("#currency_v[data-no='" + no + "']").val();
            var kode_item = $("#kode_item_v[data-no='" + no + "']").val();
            var deskripsi_item = $("#deskripsi_item_v[data-no='" + no + "']").val();
            var tipe_inp = $("#tipe_v[data-no='" + no + "']").val();
            var jumlah_item_inp = $("#jumlah_item_v[data-no='" + no + "']").val();
            var satuan_inp = $("#satuan_v[data-no='" + no + "']").val();
            var harga_inp = $("#harga_satuan_v[data-no='" + no + "']").val();
            var tgl_mulai_pengadaan = $("#tgl_mulai_pengadaan_v[data-no='" + no + "']").val();
            var tgl_akhir_pengadaan = $("#tgl_akhir_pengadaan_v[data-no='" + no + "']").val();
            var tgl_mulai_pekerjaan = $("#tgl_mulai_pekerjaan_v[data-no='" + no + "']").val();
            var tgl_akhir_pekerjaan = $("#tgl_akhir_pekerjaan_v[data-no='" + no + "']").val();
            var catatan_inp = $("#catatan_v[data-no='" + no + "']").val();

            $("#id_inp").val(id_inp);
            $("#pemilik_program_inp").val(pemilik_program_inp);
            $("#pic_inp").val(pic_inp);
            $("#pengelola_anggaran_inp").val(pengelola_anggaran_inp);
            $("#coa_id_inp").val(coa_id_inp);
            $("#drup_currency").val(drup_currency);
            $("#kode_item").val(kode_item);
            $("#deskripsi_item").html(deskripsi_item);
            $("#tipe_item").html(tipe_inp);
            $("#jenis_penyedia_inp").val(tipe_inp);
            $("#jumlah_item_inp").val(jumlah_item_inp);
            $("#deskripsi_item_inp").val(deskripsi_item);
            $("#satuan_item_inp").val(satuan_inp);
            $("#harga_satuan_item_inp").val(harga_inp);
            $("#tgl_mulai_pengadaan_inp").val(tgl_mulai_pengadaan);
            $("#tgl_akhir_pengadaan_inp").val(tgl_akhir_pengadaan);
            $("#tgl_mulai_pekerjaan_inp").val(tgl_mulai_pekerjaan);
            $("#tgl_akhir_pekerjaan_inp").val(tgl_akhir_pekerjaan);
            $("#catatan_inp").val(catatan_inp);

            $(this).parent().parent().remove();

            return false;

        });

    })

    $(document.body).on("change", "#kode_item", function() {

        var id = $(this).val();
        var url = "<?php echo site_url('Commodity/data_kat_smbd') ?>";

        $('.int_item').css('display', 'none');
        $.ajax({
            url: url + "?id=" + id,
            dataType: "json",
            success: function(data) {
                var mydata = data.rows[0];
                $('#harga_satuan_item_inp').attr('disabled', false);
                $("#deskripsi_item").html(mydata.long_description);
                $("#deskripsi_item_inp").val(mydata.description);
                $("#deskripsi_pekerjaan").html(mydata.ppm_scope_of_work);
                $("#satuan_item_inp").val(mydata.uom);
                $("#harga_satuan_item_inp").val(mydata.total_price);
                $("#jumlah_item_inp").on('keyup', function(e) {
                    delay(function() {
                        $.ajax({
                                url: "<?php echo site_url('Procurement/get_volume') ?>" + "?smbd_code=" + $('#kode_item').val() + "&spk_code=" + $('#kode_spk').val(),
                                dataType: 'json',
                            })

                            .done(function(data_vol) {
                                var data_vol = data_vol.rows[0];
                                var vol_remain = data_vol.ppv_remain;
                                if (parseFloat(($("#jumlah_item_inp").val()).replace(/\./g, '')) > parseFloat(vol_remain)) {
                                    alert("Jumlah tidak boleh lebih dari " + vol_remain + ' ' + $("#satuan_item_inp").val());
                                    $("#jumlah_item_inp").val(1);
                                    $("#jumlah_item_inp").focus();
                                }

                            })

                            .fail(function() {
                                console.log("error");
                            })
                    }, 500);
                });
            }
        });

    });

    $(document).ready(function() {
        if ($('[name="tgl_mulai_pengadaan_inp"]').val() != '') {
            $('[name="tgl_akhir_pengadaan_inp"]').attr('min', $(this).val());
        }

        $('[name="tgl_mulai_pengadaan_inp"]').change(function(event) {
            if ($(this).val() != '') {
                $('[name="tgl_akhir_pengadaan_inp"]').attr('min', $(this).val());
            }
        });

        $('[name="tgl_akhir_pengadaan_inp"]').rules('add', {
            messages: {
                min: "Tidak boleh kurang dari Tanggal Mulai Pengadaan"
            }
        });

        if ($('[name="tgl_akhir_pengadaan_inp"]').val() != '') {
            $('[name="tgl_mulai_pengadaan_inp"]').attr('max', $(this).val());
        }

        $('[name="tgl_akhir_pengadaan_inp"]').change(function(event) {
            if ($(this).val() != '') {
                $('[name="tgl_mulai_pengadaan_inp"]').attr('max', $(this).val());
            }
        });

        $('[name="tgl_mulai_pengadaan_inp"]').rules('add', {
            messages: {
                max: "Tidak boleh lebih dari Tanggal Akhir Pengadaan"
            }
        });

    });

    $(document).ready(function() {
        if ($('[name="tgl_mulai_pekerjaan_inp"]').val() != '') {
            $('[name="tgl_akhir_pekerjaan_inp"]').attr('min', $(this).val());
        }

        $('[name="tgl_mulai_pekerjaan_inp"]').change(function(event) {
            if ($(this).val() != '') {
                $('[name="tgl_akhir_pekerjaan_inp"]').attr('min', $(this).val());
            }
        });

        $('[name="tgl_akhir_pekerjaan_inp"]').rules('add', {
            messages: {
                min: "Tidak boleh kurang dari Tanggal Mulai Pekerjaan"
            }
        });

        if ($('[name="tgl_akhir_pekerjaan_inp"]').val() != '') {
            $('[name="tgl_mulai_pekerjaan_inp"]').attr('max', $(this).val());
        }

        $('[name="tgl_akhir_pekerjaan_inp"]').change(function(event) {
            if ($(this).val() != '') {
                $('[name="tgl_mulai_pekerjaan_inp"]').attr('max', $(this).val());
            }
        });

        $('[name="tgl_mulai_pekerjaan_inp"]').rules('add', {
            messages: {
                max: "Tidak boleh lebih dari Tanggal Akhir Pekerjaan"
            }
        });

    });

    $(".action_drup").click(function() {

        var tipe = $("#tipe_item").text();
        var kode = $("#kode_item").val();
        var max_notif = $('#max_volume').html();
        var deskripsi = $("#deskripsi_item").text();
        var jumlah = $("#jumlah_item_inp").val();
        var satuan = $("#satuan_item_inp").val();
        var harga_satuan = $("#harga_satuan_item_inp").val();
        var jumlah_int = $("#jumlah_item_inp").autoNumeric('get');
        var harga_satuan_int = $("#harga_satuan_item_inp").autoNumeric('get');

        if (harga_satuan_int < 1) {

            alert("Harga tidak boleh kurang dari 1");

        } else if (jumlah_int < 1) {

            alert("Jumlah tidak boleh kurang dari 1");

        }
    });

    function isShowAddDrup() {
        var div_add = document.getElementById("showAddDrup");
        var div_btn = document.getElementById("showButtonDrup");

        if (div_add.style.display !== "none") {
            div_add.style.display = "none";
        } else {
            div_add.style.display = "block";
        }

        if (div_btn.style.display !== "none") {
            div_btn.style.display = "none";
        } else {
            div_btn.style.display = "block";
        }
    }
</script>