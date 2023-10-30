<style scoped>
    .perencanaan-pengadaan-inp-c {
        position: absolute;
        top: 6%;
        right: 4%;
        background-color: #f7f7f8;
        color: #000;
        border: #e0e0e0;
        padding: 2px 17px;
    }

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

    .bg-select {
        background-color: #2aace3;
        color: white;
    }
    .border-remove {
        border-left: none;
        border-top: none;
        border-right: none;
    }

    .jenis-kontrak {
        position: absolute;
        top: 0%;
        right: 4%;
        background-color: #f7f7f8;
        color: #000;
        border: #e0e0e0;
    }

    .jenis-kontrak:hover {
        background-color: #f7f7f8;
        color: #000;
    }

    .jenis-kontrak:active {
        background-color: #f7f7f8;
        color: #000;
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
</style>
<script src="https://cdn.tiny.cloud/1/fomjvw28r2o4v9niehzlxvd035csn6z2f91rtszw92yr5ppm/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<div class="row">
    <div class="col-12">
        <div class="card card-top">

            <div class="card-header border-bottom pb-2">
                <span class="card-title text-bold-600 mr-2">Header</span>
                <span class="text-info text-bold-700"><i class="ft-cpu"></i> Kontrak Manual</span>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-md control-label text-bold-700">Nilai Kontrak <span class="text-danger text-bold-700">*</span></label>
                        <div class="col-md mb-2">
                            <?php
                            $valnil = "";

                            if ($bakp != '') {
                                $valnil = $bakp != '' ? $ahead['nilai_kontrak'] : '';
                            }
                            ?>
                            <input type="text" value="<?php echo $valnil ?>" class="form-control money border-remove" required maxlength="30" name="nilai_kontrak_inp" id="nilai_kontrak_inp">
                            <!-- <input type="hidden" value="<?php echo $valnil ?>" name="nilai_kontrak_inp" id="nilai_kontrak_inp" placeholder="Masukkan angka nilai kontrak"> -->
                            <input type="hidden" name="spkcodeinp" value="<?php echo $bakp != '' ? $ahead['spk_code'] : '' ?>">
                            <input type="hidden" name="ppmid" value="<?php echo $bakp != '' ? $ahead['ppm_id'] : '' ?>">
                            <?php if ($pl != ''): ?>
                                <input type="hidden" name="mth_pengadaan" value="Pembelian_Langsung">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">

                        <!-- left-side -->
                        <div class="col-md-6 row">

                            <?php $curval = "AUTO"; ?>
                            <div class="col-md-12 form-group">
                                <label class="col-md-4 control-label text-bold-700">Nomor Tender</label>
                                <div class="col-md-8">
                                    <?php if ($bakp != ''): ?>
                                        <input type="hidden" class="form-control" name="nomor_tender" value="<?php echo $bakp != '' ? $ahead['rfq_number'] : '' ?>" readonly>
                                        : <?php echo $bakp != '' ? $ahead['rfq_number'] : '' ?>
                                    <?php else: ?>
                                        : <?php echo $curval ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php $curval = "AUTO"; ?>
                            <div class="col-md-12 form-group">
                                <label class="col-sm-4 control-label text-bold-700">Nomor Kontrak</label>
                                <div class="col-sm-8"> :
                                    <?php echo $curval ?>
                                </div>
                            </div>

                            <?php $curval = $userdata['complete_name']; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Buyer <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8"> :
                                    <?php echo $curval ?>
                                    <!-- hidden value -->
                                    <input type="hidden" class="form-control" name="request_name_inp" id="request_name_inp" value="<?php echo $curval ?>" readonly>
                                    <input type="hidden" name="user_id_inp" id="user_id_inp" value="<?php echo $userdata['id'] ?>">
                                    <input type="hidden" name="pos_id_inp" id="pos_id_inp" value="<?php echo $userdata['pos_id'] ?>">
                                    <input type="hidden" name="pos_name_inp" id="pos_name_inp" value="<?php echo $userdata['pos_name'] ?>">
                                    <input type="hidden" name="district_id_inp" id="district_id_inp" value="<?php echo $userdata['district_id'] ?>">
                                    <input type="hidden" name="district_name_inp" id="district_name_inp" value="<?php echo $userdata['district_name'] ?>">
                                </div>
                            </div>

                            <?php $curval = $userdata['dept_name']; ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Divisi <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8"> :
                                    <?php echo $curval ?>
                                    <!-- hidden value -->
                                    <input type="hidden" class="form-control" value="<?php echo $curval ?>" readonly>
                                    <input type="hidden" name="dept_id_inp" id="dept_id_inp" value="<?php echo $userdata['dept_id'] ?>">
                                    <input type="hidden" name="dept_name_inp" id="dept_name_inp" value="<?php echo $userdata['dept_name'] ?>">
                                </div>
                            </div>

                            <?php if ($bakp != ''): ?>
                                <div class="col-md-12 form-group proyek">
                                    <?php $curval = $bakp != '' ? $ahead['project'] : ''; ?>
                                    <label class="col-sm-4 control-label text-bold-700">Proyek <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8"> :
                                        <?php echo $curval ?>
                                        <input type="hidden" class="form-control" name="nama_pekerjaan_inp" id="nama_pekerjaan_inp" value="<?php echo $curval ?>" readonly>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-md-12 form-group proyek">
                                    <?php $curval = set_value("nama_pekerjaan_inp"); ?>
                                    <label class="col-sm-4 control-label">Proyek <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 position-relative">
                                        <div class="is_sap">
                                            <input type="text" class="form-control" name="nama_pekerjaan_inp" id="nama_pekerjaan_inp" value="<?php echo $curval ?>" readonly>
                                            <input type="hidden" name="kode_spk" id="kode_spk" value="">

                                            <?php $curval = (isset($permintaan['ppm_id'])) ?  $permintaan["ppm_id"] : set_value("perencanaan_pengadaan_inp"); ?>
                                            <button type="button" data-id="perencanaan_pengadaan_inp" data-url="<?php echo site_url(PROCUREMENT_PERENCANAAN_PENGADAAN_PATH . '/sap_picker') ?>" class="btn btn-info picker perencanaan-pengadaan-inp-c rounded">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="perencanaan_pengadaan_inp" required="true" value="<?php echo $curval ?>" id="perencanaan_pengadaan_inp" />
                                        <input type="hidden" name="spk_code_inp" id="spk_code_inp" value="<?php echo $bakp != '' ? $ahead['spk_code'] : ''?>">
                                        <input type="hidden" name="ppm_id" id="ppm_id" value="<?php echo $bakp != '' ? $ahead['ppm_id'] : ''?>">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Jenis Kontrak <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 styleSelect">
                                    <select class="form-control bg-select" required name="item_kontrak_inp" id="tppo">
                                        <option value="">Pilih Jenis Kontrak</option>
                                        <?php foreach ($contract_item as $key => $val) { ?>
                                            <option value="<?php echo $val ?>"><?php echo $val ?></option>
                                        <?php } ?>
                                    </select>
                                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label text-bold-700">Tipe PO <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 styleSelect">
                                    <select class="form-control bg-select" required name="ctr_doc_type" value="<?php echo $curval ?>">
                                        <option value="" selected disabled>Pilih Tipe PO</option>
                                        <?php foreach ($doc_type as $k => $v): ?>
                                            <option value="<?php echo $v['code'] ?>"><?php echo $v['code'].' - '.$v['description'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                </div>
                            </div>

                            <?php if ($bakp != ''): ?>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Pemenang <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 styleSelect">
                                        <select class="form-control bg-select" required name="type_winner_inp">
                                            <option value="Single Winner" <?= $win_type != '2' ? 'selected' : '' ?>>Single Winner</option>
                                            <option value="Multiple Winner" <?= $win_type == '2' ? 'selected' : ''?>>Multiple Winner</option>
                                        </select>
                                        <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">Pemenang <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 styleSelect">
                                        <select class="form-control bg-select" required name="type_winner_inp">
                                            <option value="Single Winner" <?= $win_type != '2' ? 'selected' : '' ?>>Single Winner</option>
                                            <option value="Multiple Winner" <?= $win_type == '2' ? 'selected' : ''?>>Multiple Winner</option>
                                        </select>
                                        <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 control-label mt-2 text-bold-700">Download Template</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static mt-2">
                                        <a href="#" class="btn btn-info btn-sm">Kontrak Barang</a>
                                        <a href="#" class="btn btn-info btn-sm">Kontrak Jasa</a>
                                        <!-- <a href="<?php echo base_url('user_guide/PPJ [Perjanjian Pengadaan Jasa] .zip'); ?>" class="btn btn-info btn-sm">PPJ</a>
                                        <a href="<?php echo base_url('user_guide/PPB [Perjanjian Pengadaan Barang].zip'); ?>" class="btn btn-info btn-sm">PPB</a> -->
                                    </p>
                                </div>
                            </div>


                        </div>

                        <!-- right-side -->
                        <div class="col-md-6 row">

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 mb-2 control-label text-bold-700">Vendor/Penyedia <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 mb-2">
                                    <select class="form-control select2 bg-select" name="vendor_inp" id="selectVendor" onchange="typeVendor()">
                                        <option value="">Pilih Vendor</option>
                                        <?php foreach ($bidderList as $key => $val): ?>
                                            <?php if ($bakp != ''): ?>
                                                <option value='<?php echo $val['vendor_id']; ?>,<?php echo $val['fin_class']; ?>' <?php echo $val['vendor_id'] == $ahead['vendor'] ? 'selected' : '' ?>><?php echo $val['vendor_name']; ?></option>
                                            <?php else: ?>
                                                <option value='<?php echo $val['vendor_id']; ?>,<?php echo $val['fin_class']; ?>'><?php echo $val['vendor_name']?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 mb-2 control-label text-bold-700">Klasifikasi &nbsp;</label>
                                <div class="col-sm-8 mb-2">
                                    <?php if ($bakp != ''): ?>
                                        <span> : <?php echo $bakp != '' ? $ahead['klasifikasi'] : '' ?></span>
                                    <?php else: ?>
                                        <span id="type_vendor"> : -</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group col-md-12" style="display: none;">
                                <label class="col-sm-4 mb-2"></label>
                                <div class="col-sm-8 my-2">
                                    <a onclick="isShowAddVendor()" class="btn btn-info btn-sm"><i class="ft-plus"></i> Tambah Vendor</a>
                                </div>
                            </div>

                            <div id="showAddVendor" class="col mb-3" style="display: none;">
                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 control-label text-bold-700">- Nama Vendor <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" maxlength="100" name="vendor_name_inp" id="vendor_name_inp" placeholder="Nama vendor">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- NPWP <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <input type="text" class="form-control" name="npwp_inp" id="npwp_inp" pattern=".{20,}" title="Masukan NPWP dengan benar" placeholder="Masukkan nomor NPWP perusahaan">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Email <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <input type="email" class="form-control" maxlength="80" name="email_vendor_inp" id="email_vendor_inp" placeholder="Alamat email vendor">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Klasifikasi <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2 styleSelect">
                                        <select class="form-control bg-select" name="tipe_perusahaan_inp">
                                            <option value="">Pilih Tipe Perusahaan</option>
                                            <option value="B">Besar</option>
                                            <option value="M">Menengah</option>
                                            <option value="K">Kecil</option>
                                            <option value="I">Mikro</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Tipe Penyedia <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2 styleSelect">
                                        <select class="form-control bg-select" name="kategori_proyek_inp">
                                            <option value="">Pilih Tipe Penyedia</option>
                                            <option value="Material Konstruksi">Material Konstruksi</option>
                                            <option value="Pengadaan & Sewa Perlengkapan Furniture">Pengadaan & Sewa Perlengkapan Furniture</option>
                                            <option value="Jasa Konstruksi & Renovasi">Jasa Konstruksi & Renovasi</option>
                                            <option value="Jasa Ekspedisi & Pengepakan">Jasa Ekspedisi & Pengepakan</option>
                                            <option value="Jasa Advertising">Jasa Advertising</option>
                                            <option value="Jasa Perawatan Peralatan & Mesin">Jasa Perawatan Peralatan & Mesin</option>
                                            <option value="Catering & Snack">Catering & Snack</option>
                                            <option value="Pengadaan & Sewa Peralatan Mesin">Pengadaan & Sewa Peralatan Mesin</option>
                                            <option value="Jasa Mandor">Jasa Mandor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Provinsi <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <select class="select2 form-control" id="prop" name="prop" required style="width: 100%">
                                            <option value="" selected disabled>Pilih Provinsi</option>
                                            <?php foreach ($locations as $value) { ?>
                                                <option value="<?php echo $value['province_name']; ?>" ><?php echo $value['province_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Kota / Kabupaten <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <select class="select2 form-control" id="city" name="city" required disabled style="width: 100%">
                                            <option value="">Pilih Kabupaten</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Kecamatan <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <select class="select2 form-control" id="district" name="district" required disabled style="width: 100%">
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Kelurahan <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <select class="select2 form-control" id="village" name="village" required disabled style="width: 100%">
                                            <option value="">Pilih Kelurahan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-4 mb-2 control-label text-bold-700">- Alamat <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8 mb-2">
                                        <textarea class="form-control" id="alamat_vendor_inp" name="alamat_vendor_inp" placeholder="Alamat detail" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 mb-2 control-label text-bold-700">Tipe Kontrak <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 mb-2 styleSelect">
                                    <select class="form-control bg-select" required name="tipe_kontrak_inp">
                                        <option value="">Pilih Tipe Kontrak</option>
                                        <option value="HARGA SATUAN">HARGA SATUAN</option>
                                        <option value="LUMPSUM">LUMPSUM</option>
                                    </select>
                                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-sm-4 mb-2 control-label text-bold-700">Mata Uang <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8 mb-2 styleSelect">
                                    <select class="form-control bg-select" required name="mata_uang_inp">
                                        <option value="">Pilih Mata Uang</option>
                                        <option value="IDR" selected>IDR</option>
                                    </select>
                                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                </div>
                            </div>

                            <?php if ($bakp != ''): ?>
                                <?php if ($dpkn != '0'): ?>
                                    <div class="form-group col-md-12 mb-1">
                                        <label class="col-sm-4 control-label text-bold-700">Nilai RAB/Cost Plan <span class="text-danger text-bold-700">*</span></label>
                                        <div class="col-sm-8"> : Rp. <?php echo $bakp != '' ? inttomoney($ahead['nilai_rab']) : ''?></div>
                                        <input type="hidden" name="rabval" value="<?php echo $bakp != '' ? $ahead['nilai_rab'] : ''?>">
                                    </div>
                                <?php else: ?>
                                    <div class="form-group col-md-12 mb-1">
                                        <label class="col-sm-4 control-label text-bold-700">Nilai RAB/Cost Plan <span class="text-danger text-bold-700">*</span></label>
                                        <div class="col-sm-8"> : 0</div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="form-group col-md-12 mb-1">
                                    <label class="col-sm-4 control-label text-bold-700">Nilai RAB/Cost Plan <span class="text-danger text-bold-700">*</span></label>
                                    <div class="col-sm-8"> : 0</div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label text-bold-700 mt-2">Persen DP</label>
                                <div class="col-sm-8">
                                    <input type="number" max="100" name="ctr_down_payment" class="form-control" value="">
                                </div>
                            </div>

                            <div class="form-group col-md-12 mb-1">
                                <label class="col-sm-4 control-label text-bold-700 mt-2">Tanggal Akhir DP</label>
                                <div class="col-sm-8">
                                    <div class="input-group date align-items-center">
                                        <input type="date" name="ctr_down_payment_date" onchange="valid_date_dp()" class="form-control" value="">
                                        <div class="btn btn-sm btn-warning ml-2" onclick="clear_date('ctr_down_payment_date')"> <i class="fa fa-trash"></i> </div>
                                    </div>
                                </div>
                            </div>

                            <?php $curvalAwal = set_value("tgl_mulai_inp"); ?>
                            <?php $curvalAkhir = set_value("tgl_akhir_inp"); ?>
                            <div class="form-group col-md-12 mb-2">
                                <label class="col-sm-4 control-label text-bold-700">Tanggal Kontrak (Jangka waktu pelaksana)<span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-8">
                                    <div class="input-group date align-items-center">
                                        Tgl Mulai :
                                        <input type="date" name="tgl_mulai_inp" required onchange="valid_date_aw()" class="form-control" value="<?php echo $curvalAwal ?>">
                                        <div class="btn btn-sm btn-warning" onclick="clear_date('tgl_mulai_inp')"> <i class="fa fa-trash"></i> </div>
                                    </div>
                                    <div class="input-group date align-items-center">
                                        Tgl Akhir :
                                        <input type="date" name="tgl_akhir_inp" required onchange="valid_date_ak()" class="form-control" value="<?php echo $curvalAkhir ?>">
                                        <div class="btn btn-sm btn-warning" onclick="clear_date('tgl_akhir_inp')"> <i class="fa fa-trash"></i> </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12 mb-2">
                                <label class="col-sm-4 control-label">Bidang Pekerjaan</label>
                                <div class="col-sm-8 styleSelect">
                                    <select class="form-control bg-select" name="kategori_pekerjaan_inp">
                                        <option value="" selected disabled>Pilih Bidang Pekerjaan</option>
                                        <option value="Sipil">Sipil</option>
                                        <option value="Mekanikal">Mekanikal</option>
                                        <option value="Elektrikal">Elektrikal</option>
                                        <option value="Gedung">Gedung</option>
                                        <option value="ATK">ATK</option>
                                        <option value="TI">TI</option>
                                        <option value="HSE">CQSMS</option>
                                        <option value="Furnitur">Furnitur</option>
                                        <option value="Makanan dan Minuman">Makanan dan Minuman</option>
                                        <option value="Logistik">Logistik</option>
                                        <option value="Jasa Kesehatan">Jasa Kesehatan</option>
                                        <option value="Jasa Keuangan">Jasa Keuangan</option>
                                        <option value="Konsultan Lainnya">Konsultan Lainnya</option>
                                        <option value="Jasa Lainnya">Jasa Lainnya</option>
                                    </select>
                                    <i class="ft-chevron-down fa-2x" style="font-size: 18spx;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <?php if ($bakp != ''): ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-2 control-label text-bold-700">Paket Pengadaan <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-10">
                                    <div class="col-sm-8"> : <?php echo $bakp != '' ? $ahead['paket_pengadaan'] : '' ?></div>
                                    <input type="hidden" name="subject_work_inp" value="<?php echo $bakp != '' ? $ahead['paket_pengadaan'] : '' ?>">
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="form-group col-md-12">
                                <label class="col-sm-2 control-label text-bold-700">Paket Pengadaan <span class="text-danger text-bold-700">*</span></label>
                                <div class="col-sm-10">
                                    <input class="form-control" required name="subject_work_inp" placeholder="Nama pengadaan">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group col-md-12">
                            <label class="col-sm-2 control-label mt-2 text-bold-700">Deskripsi <span class="text-danger text-bold-700">*</span></label>
                            <div class="col-sm-10 mt-2">
                                <textarea class="form-control richtext" required name="scope_work_inp" placeholder="Deskripsi pengadaan"></textarea>
                            </div>
                        </div>

                        <!-- <div class="form-group col-md-12">
                            <label class="col-sm-2 control-label mt-2 text-bold-700">Term and Condition <span class="text-danger text-bold-700">*</span></label>
                            <div class="col-sm-10 mt-2">
                                <textarea class="form-control" required name="ctr_term_condition"></textarea>
                            </div>
                        </div> -->

                        <div class="form-group col-md-12">
                            <label class="col-sm-2 control-label mt-2 text-bold-700">Ruang Lingkup <span class="text-danger text-bold-700">*</span></label>
                            <div class="col-sm-10 mt-2">
                                <textarea class="form-control richtext" required name="ctr_scope"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<input type="hidden" name="prop_inp" id="prop_inp">
<input type="hidden" name="city_inp" id="city_inp">
<input type="hidden" name="district_inp" id="district_inp">
<input type="hidden" name="village_inp" id="village_inp">

<script>
tinymce.init({
    selector: '.richtext',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
});
</script>

<script type="text/javascript">

    function valid_date_dp() {
        let dp = $('[name="ctr_down_payment_date"]').val()
        let aw = $('[name="tgl_mulai_inp"]').val()
        let ak = $('[name="tgl_akhir_inp"]').val()

        if (dp != '') {
            if ((aw != '') && (dp < aw)) {
                toastr.error('Tanggal DP tidak boleh lebih besar dari tanggal awal kontrak!', '<i class="ft ft-alert-triangle"></i> Error!');
                $('[name="ctr_down_payment_date"]').val('')
            } else if ((ak != '') && (dp > ak)) {
                toastr.error('Tanggal DP tidak boleh lebih besar dari tanggal akhir kontrak!', '<i class="ft ft-alert-triangle"></i> Error!');
                $('[name="ctr_down_payment_date"]').val('')
            }
        }
    }

    function valid_date_aw() {
        let dp = $('[name="ctr_down_payment_date"]').val()
        let aw = $('[name="tgl_mulai_inp"]').val()
        let ak = $('[name="tgl_akhir_inp"]').val()

        if (aw != '') {
            if ((dp != '') && (aw < dp)) {
                toastr.error('Tanggal awal kontrak tidak boleh lebih kecil dari tanggal DP!', '<i class="ft ft-alert-triangle"></i> Error!');
                $('[name="tgl_mulai_inp"]').val('')
            } else if((ak != '') && (aw > ak)) {
                toastr.error('Tanggal awal kontrak tidak boleh lebih besar dari tanggal akhir kontrak!', '<i class="ft ft-alert-triangle"></i> Error!');
                $('[name="tgl_mulai_inp"]').val('')
            }
        }
    }

    function valid_date_ak() {
        let dp = $('[name="ctr_down_payment_date"]').val()
        let aw = $('[name="tgl_mulai_inp"]').val()
        let ak = $('[name="tgl_akhir_inp"]').val()

        if (ak != '') {
            if ((dp != '') && (ak < dp)) {
                toastr.error('Tanggal akhir kontrak tidak boleh lebih kecil dari tanggal DP!', '<i class="ft ft-alert-triangle"></i> Error!');
                $('[name="tgl_akhir_inp"]').val('')
            } else if ((aw != '') && (ak < aw)){
                toastr.error('Tanggal akhir kontrak tidak boleh lebih kecil dari tanggal awal kontrak!', '<i class="ft ft-alert-triangle"></i> Error!');
                $('[name="tgl_akhir_inp"]').val('')
            }
        }
    }
//
//
// $(document).ready(function() {
//     if ($('[name="ctr_down_payment_date"]').val() != '') {
//         $('[name="tgl_mulai_inp"]').attr('min', $(this).val());
//     }
//
//     $('[name="ctr_down_payment_date"]').change(function(event) {
//         if ($(this).val() != '') {
//             $('[name="tgl_mulai_inp"]').attr('min', $(this).val());
//         }
//     });
//
//     $('[name="tgl_mulai_inp"]').rules('add', {
//         messages: {
//             min: "Tidak boleh kurang dari Tanggal Pembayaran DP"
//         }
//     });
//
//     // ==================
//
//     if ($('[name="tgl_mulai_inp"]').val() != '') {
//         $('[name="tgl_akhir_inp"]').attr('min', $(this).val());
//     }
//
//     $('[name="tgl_mulai_inp"]').change(function(event) {
//         if ($(this).val() != '') {
//             $('[name="tgl_akhir_inp"]').attr('min', $(this).val());
//         }
//     });
//
//     $('[name="tgl_akhir_inp"]').rules('add', {
//         messages: {
//             min: "Tidak boleh kurang dari Tanggal Mulai Kontrak"
//         }
//     });
//
//     // ==================
//
//     if ($('[name="tgl_akhir_inp"]').val() != '') {
//         $('[name="tgl_mulai_inp"]').attr('max', $(this).val());
//     }
//
//     $('[name="tgl_akhir_inp"]').change(function(event) {
//         if ($(this).val() != '') {
//             $('[name="tgl_mulai_inp"]').attr('max', $(this).val());
//         }
//     });
//
//     $('[name="tgl_mulai_inp"]').rules('add', {
//         messages: {
//             max: "Tidak boleh lebih dari Tanggal Akhir Kontrak"
//         }
//     });
//
// });

function clear_date(name) {
    $('[name="'+name+'"]').val('')
}

function isShowAddVendor() {
    var div_add = document.getElementById("showAddVendor");
    if (div_add.style.display !== "none") {
        div_add.style.display = "none";
    } else {
        div_add.style.display = "block";
    }
}

function typeVendor() {
    var x = document.getElementById("selectVendor").value;
    console.log(x);
    var lastChar = x.substr(x.length - 1);

    if (lastChar == 'B') {
        lastChar = 'Besar';
    } else if (lastChar == 'M') {
        lastChar = 'Menengah';
    } else if (lastChar == 'K') {
        lastChar = 'Kecil';
    } else if (lastChar == 'I') {
        lastChar = 'Mikro';
    }

    document.getElementById("type_vendor").innerHTML = ': ' + lastChar;
}
</script>

<script>
$(document).ready( function(){

    $("#prop").on("change", function () {
        let prop = $("#prop").val();
        $.ajax({
            url: "<?php echo site_url('locations/get_regency');?>",
            data: { prop: prop },
            method: "post",
            dataType: "json",
            success: function (data) {
                city = '<option value="">Pilih</option>';
                $.each(data, function (i, item) {
                    city += '<option value="' + item.regency_name +'">' + item.regency_name + "</option>";
                });
                $("#city").html(city).removeAttr("disabled");
            },
        });
        document.getElementById("prop_inp").value = prop;
    });

    $("#city").on("change", function () {
        let city = $("#city").val();
        $.ajax({
            url: "<?php echo site_url('locations/get_district');?>",
            data: { city: city },
            method: "post",
            dataType: "json",
            success: function (data) {
                district = '<option value="">Pilih</option>';
                $.each(data, function (i, item) {
                    district += '<option value="' + item.district_name +'">' + item.district_name + "</option>";
                });
                $("#district").html(district).removeAttr("disabled");
            },
        });
        document.getElementById("city_inp").value = city;
    });

    $("#district").on("change", function () {
        let district = $("#district").val();
        $.ajax({
            url: "<?php echo site_url('locations/get_village');?>",
            data: { district: district },
            method: "post",
            dataType: "json",
            success: function (data) {
                village = '<option value="">Pilih</option>';
                $.each(data, function (i, item) {
                    village += '<option value="' + item.village_name +'">' + item.village_name + "</option>";
                });
                $("#village").html(village).removeAttr("disabled");
            },
        });
        document.getElementById("district_inp").value = district;
    });

    $("#village").on("change", function () {
        let village = $("#village").val();
        document.getElementById("village_inp").value = village;
    });

});
</script>
