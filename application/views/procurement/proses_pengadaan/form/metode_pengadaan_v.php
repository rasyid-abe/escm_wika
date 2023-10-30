<style>
.select2-selection--single {
    height: 100% !important;
}
.select2-selection__rendered{
    word-wrap: break-word !important;
    text-overflow: inherit !important;
    white-space: normal !important;
}
select {
    font-family: 'Poppins', 'sans-serif';
}
.select2-container {
    width: 100% !important;
}
.card-header-primary{
    background-color: #2aace3 !important;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #fff;
}
.card-content-item{
    background-color: #e0e0e0 !important;
    padding-top: 10px;
    padding-bottom: 10px;
}
.card-content-kriteria{
    background-color: #f4f3f3 !important;
    padding-top: 10px;
    padding-bottom: 10px;
}
.jenis_item{
    margin-top:30px;
}
.btn_delete_kriteria{
    margin-top:20px;
}

table tr {
    vertical-align: bottom;
}

table .tbhead{
    vertical-align: middle !important;
    background-color: #2aace3 !important;
    color: white;
    font-weight: bold;
    height: 40px;
}

table .trprimary{
    background-color: #e0e0e0 !important;
}

.hide {
    display: none;
}
</style>
<?php
if($prep['ptp_prequalify'] == 2){
    include(VIEWPATH."procurement/proses_pengadaan/view/metode_pengadaan_v.php");
} else { ?>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom pb-2">
                    <h4 class="card-title">Metode Pengadaan</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <?php $curval = $prep['ptp_tender_method']; ?>
                                <div class="row form-group" id="metode_pengadaan_cont">
                                    <label class="col-sm-6 control-label">Metode Pengadaan</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="metode_pengadaan_inp" name="metode_pengadaan_inp">
                                            <option value=""><?php echo lang('choose') ?></option>
                                            <?php foreach ($metode as $key => $value) {
                                                $selected = ($curval == $key) ? "selected" : "";
                                                ?>
                                                <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 d-none" id="syarat_penunjuk_langsung">
                                <?php $curval = (!empty($prep['ptp_syarat_penunjuk']) ? json_decode($prep['ptp_syarat_penunjuk']) : [] );?>
                                <div class="row form-group " >
                                    <label class="col-sm-12 control-label text-bold-700">Penunjuk langsung dapat dilakukan apabila memenuhi minimal salah satu dari persyaratan sebagai berikut</label>
                                    <div class="col-sm-12">
                                        <select class="form-control multiselect" id="ptp_syarat_penunjuk" name="ptp_syarat_penunjuk[]" id="ptp_syarat_penunjuk"  multiple="multiple">
                                            <?php
                                            foreach ($pilihan_syarat as $key => $value) {
                                                $selected = ( in_array($key,$curval)  ? "selected" : "");
                                                ?>
                                                <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 d-none" id="dokumen_penunjuk_langsung">
                                <label class="col-sm-10 control-label"><a href="">Dokumen.pdf</a></label>
                                <!-- <input type="file" id="imgupload" style="display:none"/>
                                <button id="OpenImgUpload" class="btn btn-info btn-sm"><i class="ft-arrow-up"></i> Upload Dokumen</button> -->
                                <?php $curval = set_value("doc_attachment_inp_mtd_pengadaan"); ?>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" data-id="doc_attachment_inp_mtd_pengadaan" data-folder="<?php echo $dir ?>" data-preview="preview_file_mtd_pengadaan" class="btn btn-info upload rounded" title="Upload">
                                            <i class="fa fa-cloud-upload"></i> Up
                                        </button>
                                        <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/' . $curval) ?>" class="btn btn-info preview_upload rounded mr-1" id="preview_file_mtd_pengadaan">
                                            <i class="fa fa-share"></i> View
                                        </button>
                                    </span>
                                    <input readonly type="text" class="form-control doc_attachment_inp_mtd_pengadaan" id="doc_attachment_inp_mtd_pengadaan" name="doc_attachment_inp_mtd_pengadaan" value="<?php echo $curval ?>">
                                    <span class="input-group-btn">
                                        <button type="button" data-id="doc_attachment_inp_mtd_pengadaan" data-folder="<?php echo $dir ?>" data-preview="preview_file_mtd_pengadaan" class="btn btn-danger removefile rounded ml-1">
                                            <i class="fa fa-trash"></i> Del
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4" style="padding-top: 17px;">
                                <div class="row form-group" id="evaluasi">
                                    <label class="col-sm-6 control-label">Evaluasi</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="penilaian_eval" name="evaluasi">
                                            <option value="">Pilih</option>
                                            <option value="0" <?php if($data['evt_type']==0){echo "selected";} ?> >Sistem Nilai</option>
                                            <option value="1" <?php if($data['evt_type']==1){echo "selected";} ?> >Penilaian Biaya Selama Umur Ekonomis</option>
                                            <option value="2" <?php if($data['evt_type']==2){echo "selected";} ?> >Harga Terendah</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2" id="">
                                <div class="row form-group">
                                    <label class="col-sm-12 control-label">Evaluasi Administrasi*</label>
                                    <div class="col-sm-12">
                                        <input class="form-control txt_evaluasi_admin" value="Sistem gugur" disabled>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" required  id="template_evaluasi_inp" name="template_evaluasi_inp" value="">

                            <div class="col-sm-2" id="">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label>Evaluasi Teknis*</label>
                                        <select class="form-control evt_tech_weight" id="evt_tech_weight_lbl" name="evt_tech_weight">
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40" selected>40</option>
                                            <option value="50">50</option>
                                        </select>
                                        <!-- <input class="form-control evt_tech_weight" id="evt_tech_weight_lbl" name="evt_tech_weight" value="40" readonly> -->
                                    </div>
                                    <div class="col-md-6">
                                        <label>Passing Grade*</label>
                                        <input class="form-control evt_passing_grade" id="evt_passing_grade_lbl" name="evt_passing_grade" value="70" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2" id="">
                                <div class="row form-group">
                                    <label class="col-md-12 control-label">Evaluasi Harga*</label>
                                    <div class="col-md-12">
                                        <input class="form-control evt_price_weight" id="bobot_price" name="evt_price_weight" value="60" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding-top: 17px;">
                                <?php if ((int)$awa_id > 1040) { ?>
                                    <a class="btn btn-info btn-sm" id="btn_detail_evaluasi" data-toggle="modal" data-target="#exampleModal_Template"><i class="ft-file-text"></i> Detail Evaluasi</a>
                                <?php } else { ?>
                                    <a class="btn btn-info btn-sm" id="show_detail_evaluasi" data-val=2><i class="ft-file-text"></i> Detail Evaluasi</a>
                                <?php } ?>
                            </div>
                        </div>

                        <hr>

                        <div id="form_detval" class="hide">
                            <input class="form-control hide" id="evt_id" name="evt_id" value="<?=$prep['evt_id'] > 0 ? $prep['evt_id'] : 0 ?>">
                            <input class="form-control hide" id="evt_rfq_no" name="evt_rfq_no" value="<?=$prep['ptm_number']?>">

                            <input class="form-control hide" id="evt_type" name="evt_type" value="">
                            <div class="row">
                                <div class="col-md-2 jenis_item">
                                    <b>Jenis item2</b>
                                </div>
                                <div class="col-md-4">
                                    <label>&nbsp;</label>
                                    <select name="etd_mode" id="modal_etd_mode" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="0">Administrasi</option>
                                        <option value="1">Teknis</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="txt_nilai">
                                    <label>Bobot</label>
                                    <input class="form-control" required name="evt_value" id="evt_value_inp" placeholder="0" min="0">
                                </div>
                                <div class="col-md-2 hide" id="evt_passing_grade">
                                    <label>Passing Grade</label>
                                    <input class="form-control" id="evt_passing_grade_inp" name="evt_passing_grade" placeholder="40" min="0">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    &nbsp;
                                </div>
                                <div class="col-md-6">
                                    <label>Item penilaian</label>
                                    <input class="form-control" required id="etd_item" name="etd_item" placeholder="">
                                </div>
                                <div class="col-md-2">
                                    <label>Bobot</label>
                                    <input class="form-control" required onkeyup="validasiBobot();" name="etd_weight" id="etd_weight" placeholder="20" min="0">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    &nbsp;
                                </div>
                                <div class="col-md-6">
                                    <label>Kriteria penilaian
                                        <div class="btn btn-info btn-sm add_kriteria"><i class="fa fa-plus"></i></div>
                                    </label>
                                    <input class="form-control descc" required name="deskripsi[]" value="">
                                </div>
                                <div class="col-md-2">
                                    <label style="margin-bottom:15px !important;">Nilai</label>
                                    <input class="form-control bbtt" required name="bobot[]" placeholder="81 - 100">
                                </div>
                            </div>
                            <div class="element_container"></div>
                            <br>
                            <div class="row">
                                <div class="col-md-9">&nbsp;</div>
                                <div class="col-md-3">
                                    <div onclick="submit_ajax()" class="btn btn-primary">Simpan</div>
                                </div>
                            </div>

                            <br><br>
                        </div>

                        <div id="evaluasi_tbl"></div>

                    </div>
                </div>

            </div>
        </div>
    </div>

<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#label_tech_weight").html($("#evt_tech_weight_lbl").val() + "%");
        show_evaluasi();
        $("#evt_tech_weight_lbl").change(function (e) { 
            e.preventDefault();
            var val = Number($(this).val());
            var eval_harga = Number($("#bobot_price").val());

            var total = 100 - val;
            $("#bobot_price").val(total);
            $("#label_tech_weight").html($(this).val() + "%");
        });
    })

    function show_evaluasi() {
        $.ajax({
            url: '<?php echo site_url($controller_name."/get_evaluasi_detail");?>',
            method: 'post',
            data: {'rfq':$('#evt_rfq_no').val(), 'evt_id': $('#evt_id').val()},
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#evt_id').val(data.evt_id);
                show_table_evaluasi(data.administrasi, data.teknis, data.data)
            }
        })
    }

    function show_table_evaluasi(adm, tek, dat) {
        let head_adm = ''
        $.each(adm, function(i, v) {
            let item_adm = ''
            $.each(v.kriteria, function(id, va) {
                item_adm += `
                <div class="row card-content-kriteria">
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-7">
                        <span id="deskripsi_text_${va.id}">${va.deskripsi}</span>
                        <span id="deskripsi_input_${va.id}" class="hide"><input class="form-control deskripsi_${va.id}" value="${va.deskripsi}" required placeholder="81 - 100"></span>
                    </div>
                    <div class="col-md-2">
                        <span id="bobot_text_${va.id}">${va.bobot}</span>
                        <span id="bobot_input_${va.id}" class="hide"><input class="form-control bobot_${va.id}" value="${va.bobot}" required placeholder="81 - 100"></span>
                    </div>
                    <div class="col-md-2">
                        <div data-id="${va.id}" onclick="save_item(${va.id})" class="btn btn-success btn-sm hide" id="save_kriteria_${va.id}"><i class="fa fa-save"></i></div>
                        <div data-id="${va.id}" onclick="edit_item(${va.id})" class="edit_item btn btn-info btn-sm" id="edit_kriteria_${va.id}"><i class="fa fa-edit"></i></div>
                        <div data-id="${va.id}" onclick="cancel_item(${va.id})" class="btn btn-info btn-sm hide" id="cancel_kriteria_${va.id}"><i class="fa fa-close"></i></div>
                        <div data-id="${va.id}" onclick="removed('${va.id}', '')" class="btn btn-danger btn-sm" id="delete_${va.id}"><i class="fa fa-trash-o"></i></div>
                    </div>
                </div>
                `
            })

            head_adm += `
            <div class="row card-content-item">
                <div class="col-md-1">${i+1}</div>
                <div class="col-md-7">
                    <span id="item_text_${v.etd_id}">${v.etd_item}</span>
                    <span id="item_input_${v.etd_id}" class="hide"><input class="form-control item_${v.etd_id}" value="${v.etd_item}" required placeholder="81 - 100"></span>
                </div>
                <div class="col-md-2">
                    <span id="weight_text_${v.etd_id}">${v.etd_weight}%</span>
                    <span id="weight_input_${v.etd_id}" class="hide"><input class="form-control weight_${v.etd_id}" value="${v.etd_weight}" required placeholder="81 - 100"></span>
                </div>
                <div class="col-md-2">
                    <div data-id="${v.etd_id}" onclick="save_nilai(${v.etd_id})" class="btn btn-success btn-sm hide" id="save_nilai_${v.etd_id}"><i class="fa fa-save"></i></div>
                    <div data-id="${v.etd_id}" onclick="edit_nilai(${v.etd_id})" class="btn btn-info btn-sm" id="edit_nilai_${v.etd_id}"><i class="fa fa-edit"></i></div>
                    <div data-id="${v.etd_id}" onclick="cancel_nilai(${v.etd_id})" class="btn btn-info btn-sm hide" id="cancel_nilai_${v.etd_id}"><i class="fa fa-close"></i></div>
                    <div data-id="${v.etd_id}" onclick="removed('${v.etd_id}', 'detail')" class="btn btn-danger btn-sm" id="delete_${v.etd_id}"><i class="fa fa-trash-o"></i></div>
                </div>
            </div>

            ${item_adm}
            `
        })

        let head_tek = ''
        $.each(tek, function(i, v) {
            let item_tek = ''
            $.each(v.kriteria, function(id, va) {
                item_tek += `
                <div class="row card-content-kriteria">
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-7">
                        <span id="deskripsi_text_${va.id}">${va.deskripsi}</span>
                        <span id="deskripsi_input_${va.id}" class="hide"><input class="form-control deskripsi_${va.id}" value="${va.deskripsi}" required placeholder="81 - 100"></span>
                    </div>
                    <div class="col-md-2">
                        <span id="bobot_text_${va.id}">${va.bobot}</span>
                        <span id="bobot_input_${va.id}" class="hide"><input class="form-control bobot_${va.id}" value="${va.bobot}" required placeholder="81 - 100"></span>
                    </div>
                    <div class="col-md-2">
                        <div data-id="${va.id}" onclick="save_item(${va.id})" class="btn btn-success btn-sm hide" id="save_kriteria_${va.id}"><i class="fa fa-save"></i></div>
                        <div data-id="${va.id}" onclick="edit_item(${va.id})" class="edit_item btn btn-info btn-sm" id="edit_kriteria_${va.id}"><i class="fa fa-edit"></i></div>
                        <div data-id="${va.id}" onclick="cancel_item(${va.id})" class="btn btn-info btn-sm hide" id="cancel_kriteria_${va.id}"><i class="fa fa-close"></i></div>
                        <div data-id="${va.id}" onclick="removed('${va.id}', '')" class="btn btn-danger btn-sm" id="delete_${va.id}"><i class="fa fa-trash-o"></i></div>
                    </div>
                </div>
                `
            })

            head_tek += `
            <div class="row card-content-item">
                <div class="col-md-1">${i+1}</div>

                <div class="col-md-7">
                    <span id="item_text_${v.etd_id}">${v.etd_item}</span>
                    <span id="item_input_${v.etd_id}" class="hide"><input class="form-control item_${v.etd_id}" value="${v.etd_item}" required placeholder="81 - 100"></span>
                </div>
                <div class="col-md-2">
                    <span id="weight_text_${v.etd_id}">${v.etd_weight}%</span>
                    <span id="weight_input_${v.etd_id}" class="hide"><input class="form-control weight_${v.etd_id}" value="${v.etd_weight}" required placeholder="81 - 100"></span>
                </div>
                <div class="col-md-2">
                    <div data-id="${v.etd_id}" onclick="save_nilai(${v.etd_id})" class="btn btn-success btn-sm hide" id="save_nilai_${v.etd_id}"><i class="fa fa-save"></i></div>
                    <div data-id="${v.etd_id}" onclick="edit_nilai(${v.etd_id})" class="btn btn-info btn-sm" id="edit_nilai_${v.etd_id}"><i class="fa fa-edit"></i></div>
                    <div data-id="${v.etd_id}" onclick="cancel_nilai(${v.etd_id})" class="btn btn-info btn-sm hide" id="cancel_nilai_${v.etd_id}"><i class="fa fa-close"></i></div>
                    <div data-id="${v.etd_id}" onclick="removed('${v.etd_id}', 'detail')" class="btn btn-danger btn-sm" id="delete_${v.etd_id}"><i class="fa fa-trash-o"></i></div>
                </div>
            </div>

            ${item_tek}
            `
        })

        let body = `
        <div style="margin: 10px">
            <div class="row">
                <div class="col-md-1">No</div>
                <div class="col-md-7">Uraian</div>
                <div class="col-md-2">Bobot</div>
            </div>

            <div class="row card-header-primary">
                <div class="col-md-1">A</div>
                <div class="col-md-7">Administrasi</div>
                <div class="col-md-2">0%</div>
            </div>

            ${head_adm}

            <div class="row card-header-primary">
                <div class="col-md-1">B</div>
                <div class="col-md-7">Teknis</div>
                <div class="col-md-2" id="label_tech_weight">${dat.evt_tech_weight}%</div>
            </div>

            ${head_tek}

        </div>
        `

        $('#evaluasi_tbl').html(body)
    }

    $('#show_detail_evaluasi').on('click', function() {
        let vv = $(this).data('val')

        if (vv > 0) {
            $('#form_detval').removeClass('hide')
            $('#show_detail_evaluasi').data('val',0);
        } else {
            $('#form_detval').addClass("hide")
            $('#show_detail_evaluasi').data('val',1);
        }

    })

    function clear_form() {
        $('#modal_etd_mode').val('')
        $('#evt_value_inp').val('')
        $('#evt_passing_grade_inp').val('')
        $('#etd_item').val('')
        $('#etd_weight').val('')
        $('.descc').val('')
        $('.bbtt').val('')
        $('.element_container').html('')
    }

    function submit_ajax() {
        let desk = []
        $('input[name="deskripsi[]"]').each(function() {
            if ($(this).val() != '') {
                desk.push($(this).val())
            }
        });
        let ww = []
        $('input[name="bobot[]"]').each(function() {
            if ($(this).val()) {
                ww.push($(this).val())
            }
        });

        if ($("select[name='evaluasi']").val() == "") {
            alert("Tipe evaluasi harus dipilih!")
            return false
        }

        if ($('#modal_etd_mode').val() == "") {
            alert("Jenis item harus dipilih!")
            return false
        }

        if ($('#etd_item').val() == "") {
            alert("Item penilaian harus dipilih!")
            return false
        }

        var descc = $(".descc");
        for(var i = 0; i < descc.length; i++){
            if ($(descc[i]).val() == "") {
                alert('Deskripsi harus terisi semua!')
                return false;
            }
        }

        var bbtt = $(".bbtt");
        for(var i = 0; i < bbtt.length; i++){
            if ($(descc[i]).val() == "") {
                alert('Bobot harus terisi semua!')
                return false;
            }
        }

        let send = {
            'evt_id': $('#evt_id').val(),
            'evt_rfq_no': $('#evt_rfq_no').val(),
            'evt_type': $('#penilaian_eval').val(),
            'etd_mode': $('#modal_etd_mode').val(),
            'evt_value': $('#modal_etd_mode').val() != "1" ? '' : $('#evt_value_inp').val(),
            'evt_passing_grade': $('#modal_etd_mode').val() != "1" ? '' : $('#evt_passing_grade_inp').val(),
            'etd_item': $('#etd_item').val(),
            'etd_weight': $('#etd_weight').val(),
            'deskripsi': desk,
            'bobot': ww,
        }

        $.ajax({
            url: '<?php echo site_url($controller_name."/submit_item_evaluasi_template");?>',
            method: 'post',
            data: send,
            dataType: 'json',
            success: function(data) {
                $('#evt_id').val(data.evt_id)
                if (data.sts) {
                    toastr.success(data.msg, "Success");
                } else {
                    toastr.error(data.msg, "Error");
                }
                $('#bobot_price').val(100 - parseInt($('#evt_value_inp').val()))
                if ($('#modal_etd_mode').val() == "1") {
                    $('#evt_tech_weight_lbl').val($('#evt_value_inp').val())
                    $('#evt_passing_grade_lbl').val($('#evt_passing_grade_inp').val())
                }
                clear_form()
                show_evaluasi()
            }
        })
    }
</script>

<script type="text/javascript">

    function edit_nilai(e) {
        var id_nilai = $('#edit_nilai_'+e).data('id');

        $('#item_text_'+id_nilai).addClass('hide');
        $('#weight_text_'+id_nilai).addClass('hide');
        $('#edit_nilai_'+id_nilai).addClass('hide');

        $('#item_input_'+id_nilai).removeClass('hide');
        $('#weight_input_'+id_nilai).removeClass('hide');
        $('#save_nilai_'+id_nilai).removeClass('hide');
        $('#cancel_nilai_'+id_nilai).removeClass('hide');
    }

    function cancel_nilai(e) {
        var id_nilai = $('#cancel_nilai_'+e).data('id');

        $('#item_text_'+id_nilai).removeClass('hide');
        $('#weight_text_'+id_nilai).removeClass('hide');

        $('#item_input_'+id_nilai).addClass('hide');
        $('#weight_input_'+id_nilai).addClass('hide');

        $('#save_nilai_'+id_nilai).addClass('hide');
        $('#cancel_nilai_'+id_nilai).addClass('hide');
        $('#edit_nilai_'+id_nilai).removeClass('hide');
    }

    function save_nilai(e) {
        var id_nilai = $('#save_nilai_'+e).data('id');
        $('#item_text_'+id_nilai).removeClass('hide');
        $('#weight_text_'+id_nilai).removeClass('hide');

        $('#item_input_'+id_nilai).addClass('hide');
        $('#weight_input_'+id_nilai).addClass('hide');

        $('#save_nilai_'+id_nilai).addClass('hide');
        $('#cancel_nilai_'+id_nilai).addClass('hide');
        $('#edit_nilai_'+id_nilai).removeClass('hide');
        var weight_val = $('.weight_'+id_nilai).val();
        var item_val = $('.item_'+id_nilai).val();

        $.ajax({
            url:"<?php echo site_url('procurement/update_detail_valuasi_template') ?>",
            data:"id="+id_nilai+"&etd_weight="+weight_val+"&etd_item="+item_val,
            type:"post",
            success:function(results){
                if(results.results==1){
                    toastr.success("Berhasil mengubah data", "Success");
                    $('.weight_'+id_nilai).val(weight_val);
                    $('.item_'+id_nilai).val(item_val);
                    $('#weight_text_'+id_nilai).html(weight_val+'%');
                    $('#item_text_'+id_nilai).html(item_val);
                } else {
                    toastr.error("Berhasil mengubah data", "Error");
                }
            }
        });
    }
</script>

<script type="text/javascript">

    function edit_item(e) {
        var id_kriteria = $('#edit_kriteria_'+e).data('id');

        $('#deskripsi_text_'+id_kriteria).addClass('hide');
        $('#bobot_text_'+id_kriteria).addClass('hide');
        $('#edit_kriteria_'+id_kriteria).addClass('hide');

        $('#deskripsi_input_'+id_kriteria).removeClass('hide');
        $('#bobot_input_'+id_kriteria).removeClass('hide');
        $('#save_kriteria_'+id_kriteria).removeClass('hide');
        $('#cancel_kriteria_'+id_kriteria).removeClass('hide');
    }

    function cancel_item(e) {
        var id_kriteria = $('#cancel_kriteria_'+e).data('id');

        $('#deskripsi_text_'+id_kriteria).removeClass('hide');
        $('#bobot_text_'+id_kriteria).removeClass('hide');

        $('#deskripsi_input_'+id_kriteria).addClass('hide');
        $('#bobot_input_'+id_kriteria).addClass('hide');

        $('#save_kriteria_'+id_kriteria).addClass('hide');
        $('#cancel_kriteria_'+id_kriteria).addClass('hide');
        $('#edit_kriteria_'+id_kriteria).removeClass('hide');
    }

    function save_item(e) {
        var id_kriteria = $('#save_kriteria_'+e).data('id');
        $('#deskripsi_text_'+id_kriteria).removeClass('hide');
        $('#bobot_text_'+id_kriteria).removeClass('hide');

        $('#deskripsi_input_'+id_kriteria).addClass('hide');
        $('#bobot_input_'+id_kriteria).addClass('hide');

        $('#save_kriteria_'+id_kriteria).addClass('hide');
        $('#cancel_kriteria_'+id_kriteria).addClass('hide');
        $('#edit_kriteria_'+id_kriteria).removeClass('hide');
        var bobot_val = $('.bobot_'+id_kriteria).val();
        var deskripsi_val = $('.deskripsi_'+id_kriteria).val();

        $.ajax({
            url:"<?php echo site_url('procurement/update_item_valuasi_template') ?>",
            data:"id="+id_kriteria+"&bobot="+bobot_val+"&deskripsi="+deskripsi_val,
            type:"post",
            success:function(results){
                if(results.results==1){
                    toastr.success("Berhasil mengubah data", "Success");
                    $('.bobot_'+id_kriteria).val(bobot_val);
                    $('.deskripsi_'+id_kriteria).val(deskripsi_val);
                    $('#bobot_text_'+id_kriteria).html(bobot_val);
                    $('#deskripsi_text_'+id_kriteria).html(deskripsi_val);
                } else {
                    toastr.error("Berhasil mengubah data", "Error");
                }
            }
        });
    }

    function removed(id, lvl) {
        var idn = $('#delete_'+id).data('id');
        $.ajax({
            url:"<?php echo site_url('procurement/delete_item_evaluasi_template') ?>",
            method: 'post',
            data: {'id': id, 'type':lvl},
            dataType: 'json',
            success:function(data){
                if (data.sts) {
                    toastr.success(data.msg, "Success");
                } else {
                    toastr.error(data.msg, "Error");
                }
                show_evaluasi()
            }
        });
    }
</script>

<script type="text/javascript">
    $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });

    var evt_type, max_admin , max_teknis = 0;

    $("#modal_etd_mode").on('change', function(){
        console.log('blablabla');
        var etd_mode = $("#modal_etd_mode").val();
        if(etd_mode==1){ //mode teknis
            $('#evt_passing_grade').removeClass('hide');
            $("input[name='evt_value']").removeAttr("disabled");
            $("input[name='etd_weight']").removeAttr('readonly');
            $("input[name='etd_weight']").val('');
        } else {
            $("input[name='evt_value']").attr("disabled", true);
            $("input[name='evt_value']").val('0');
            $('#evt_passing_grade').addClass('hide');
            $("input[name='etd_weight']").val('0');
            $("input[name='etd_weight']").attr('readonly', true);
        }
    });

    function validasiBobot(){
        var max_admin = "<?=$max_admin?>";
        var max_teknis = "<?=$max_teknis?>";
        var etd_mode = parseInt($("#modal_etd_mode :selected").val());
        var etd_weight = $("input[name='etd_weight']").val();

        if(etd_mode==1 && !isNaN(etd_mode)){
            if(parseInt(max_teknis) + parseInt(etd_weight) > 100){
                //console.log(parseInt(max_teknis) + parseInt(etd_weight));
                $("input[name='etd_weight']").val('');
                alert('Maaf jumlah melebihi batas maksimal 100%');
                return false;
            }
        } else if(etd_mode==0 && !isNaN(etd_mode)){
            if(parseInt(max_admin) + parseInt(etd_weight) > 100){
                //console.log(parseInt(max_admin) + parseInt(etd_weight));
                $("input[name='etd_weight']").val('');
                alert('Maaf jumlah melebihi batas maksimal 100%');
                return false;

            }
        } else {
            alert('Maaf Silahkan pilih Jenis item dahulu.!');
        }

    }


    $('#btn_detail_evaluasi').click(function(event){
        var button = $(event.relatedTarget);
        $('#evt_type').val($("select[name='evaluasi']").val());
    });


    function check_metode(){

        var metode = parseInt($("#metode_pengadaan_cont select option:selected").val());
        var template_evaluasi = $("#template_evaluasi_cont");
        var klasifikasi_peserta = $("#klasifikasi_peserta_cont");
        var keterangan = $("#keterangan_metode_cont");
        var sampul = $("#sistem_sampul_cont");
        var vendor = $("#vendor_container");
        var eauction = $("#eauction_cont");
        //var panitia_pelelangan = $("#panitia_pelelangan_cont");
        if(metode == 0){
            template_evaluasi.show();
            klasifikasi_peserta.show();
            keterangan.show();
            sampul.hide();
            vendor.show();
            $("input[name='eauction_inp']").prop('checked',false);
            $("input[name='eauction_inp']").prop('required',false);
            //panitia_pelelangan.hide();
            $("#penunjuk_langsung").removeClass("d-none");
            $("#syarat_penunjuk_langsung").removeClass("d-none");
            $("#dokumen_penunjuk_langsung").removeClass("d-none");
        } else if(metode == 1){
            template_evaluasi.show();
            klasifikasi_peserta.show();
            keterangan.show();
            sampul.show();
            vendor.show();
            eauction.show();
            $("input[name='eauction_inp']").prop('checked',false);
            $("input[name='eauction_inp']").prop('required',false);
            //panitia_pelelangan.hide();
            $("#penunjuk_langsung").addClass("d-none");
            $("#syarat_penunjuk_langsung").addClass("d-none");
            $("#dokumen_penunjuk_langsung").addClass("d-none");
        } else if(metode == 2){
            template_evaluasi.show();
            klasifikasi_peserta.show();
            keterangan.show();
            sampul.show();
            vendor.show();
            eauction.show();
            $("input[name='eauction_inp']").prop('required',false);
            //panitia_pelelangan.show();
            $("#penunjuk_langsung").addClass("d-none");
            $("#syarat_penunjuk_langsung").addClass("d-none");
            $("#dokumen_penunjuk_langsung").addClass("d-none");
        } else {
            template_evaluasi.hide();
            klasifikasi_peserta.hide();
            keterangan.hide();
            sampul.hide();
            vendor.show();
            //panitia_pelelangan.hide();
            $("#penunjuk_langsung").addClass("d-none");
            $("#syarat_penunjuk_langsung").addClass("d-none");
            $("#dokumen_penunjuk_langsung").addClass("d-none");
        }

        var ss = $("#sistem_sampul_inp option:selected").val();
        var mp = $("#metode_pengadaan_inp option:selected").val();
        if(mp == 2){
            $(".pq_cont").show();
        } else {
            $(".pq_cont").hide();
            $("input[name='pq_inp']").prop('checked',false);
        }

        if(mp == 1){
            $("#sistem_sampul_inp option[value='2']").hide();
        } else {
            $("#sistem_sampul_inp option[value='2']").show();
        }

    }

    check_metode();

    $("#metode_pengadaan_inp").change(function(){
        check_metode();
    });

    $("#sistem_sampul_inp").change(function(){
        check_metode();
    });


    function filtervendor(){
        var kecil = $("#klasifikasi_kecil_inp").prop("checked");
        var menengah = $("#klasifikasi_menengah_inp").prop("checked");
        var besar = $("#klasifikasi_besar_inp").prop("checked");
        var filtering = ["K","M","B"];
        var myfilter = "";
        var index = 0;
        if(!kecil){
            index = filtering.indexOf("K");
            if (index > -1) {
                myfilter += "";
                filtering.splice(index, 1);
            }
            $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Kecil"]})
        } else {
            myfilter += "K_";
        }
        if(!menengah){
            index = filtering.indexOf("M");
            if (index > -1) {
                myfilter += "";
                filtering.splice(index, 1);
            }
            $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Menengah"]})
        } else {
            myfilter += "M_";
        }
        if(!besar){
            index = filtering.indexOf("B");
            if (index > -1) {
                myfilter += "";
                filtering.splice(index, 1);
            }
            $("#daftar_vendor").bootstrapTable("uncheckBy", {field:"fin_class", values:["Besar"]})
        } else {
            myfilter += "B_";
        }

        var url = "<?php echo site_url('Procurement/set_session/klasifikasi') ?>";

        $.ajax({
            url : url+"/"+myfilter,
            success:function(data){
                // $("#daftar_vendor").bootstrapTable('destroy');
                $("#daftar_vendor").bootstrapTable('refresh');

                setTimeout(function () {
                    $("#daftar_vendor").bootstrapTable('resetView');
                }, 200);
            }
        });

    }

    $(document).ready(function(){
        window.setTimeout(function(){
            filtervendor();
            check_metode();
        },3000);


        $("#klasifikasi_kecil_inp,#klasifikasi_menengah_inp,#klasifikasi_besar_inp").click(function(e){
            filtervendor();
        });

        if ($('#template_evaluasi_inp').val() == '') {
            $('#klasifikasi_kecil_inp').prop( "checked", true );
            filtervendor();
        }
    });


    $(document).ready(function(){

        function check_template_evaluasi(){
            var id = $("#template_evaluasi_inp").val();
            var url = "<?php echo site_url('Procurement/data_template_evaluasi') ?>";
            $.ajax({
                url : url+"?id="+id,
                dataType:"json",
                success:function(data){
                    var mydata = data.rows[0];
                    $("#template_evaluasi_label").html(mydata.evt_name);
                }
            });
        }

        $(document.body).on("change","#template_evaluasi_inp",function(){

            check_template_evaluasi();

        });

    });

</script>

<script type="text/javascript">
    $(".add_kriteria").click(function(){
        $(".element_container").append(`
            <div class="row">
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-6">
            <label>&nbsp; </label>
            <input class="form-control" required name="deskripsi[]" value="">
            </div>
            <div class="col-md-2">
            <label>&nbsp;</label>
            <input class="form-control" required name="bobot[]" placeholder="">
            </div>
            <div class="col-md-2">
            <label>&nbsp;</label>
            <div class="btn btn-warning btn-sm btn_delete_kriteria"><i class="fa fa-minus"></i>
            </div>
            </div>
            </div>
        `);
    });

    $('.element_container').on('click', '.btn_delete_kriteria', function() {
        $(this).parent().parent().remove();
    });
</script>
