<?php $this->load->view("_profile03/_tab.php") ?>

<section class="bordered-striped-form-layout">
    <!-- row starts -->
    <div class="match-height">
        <form class="form-bordered">
            <!-- katalog -->            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title-w float-left">Data Katalog <span class="text-danger">(*)</span></h5>
                            <?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
                                <a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#katalogForm"><i class="fa fa-plus"></i> Tambah</a>
                            <?php } ?>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- content -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <!-- <th>Picture</th> -->
                                                <th>Kode Sumber Daya</th>
                                                <th>Product Name</th>
                                                <th>Level 1</th>
                                                <th>Level 2</th>
                                                <th>Level 3</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($katalog as $value) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>                                              
                                                    <!-- <td>
                                                        <img class="rounded mr-3" src="<?php echo site_url('assets/img/') . $value['gallery_1']; ?>" width="70" height="70" alt="avatar">                                                        
                                                    </td> -->
                                                    <td><?php echo $value['code_sda']; ?></td>
                                                    <td><?php echo $value['product_name']; ?></td>
                                                    <td><?php echo $value['level1']; ?></td>
                                                    <td><?php echo $value['level2']; ?></td>
                                                    <td><?php echo $value['level3']; ?></td>
                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('_api/vendor/data/delete_katalog/'. $value['id'] ); ?>" onclick="return confirm('Apakah Anda yakin akan hapus data ini?')" class="btn btn-sm btn-danger"><i class="ft-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 text-center my-3">
                <a href="<?php echo site_url('registrasi_vendor/klasifikasi');?>" class="btn btn-secondary btn-md" >Kembali</a>
                <a href="<?php echo site_url('registrasi_vendor/tambahan');?>" onclick="return confirm('Apakah Anda yakin dengan data di atas?')" class="btn btn-info btn-md" >Selanjutnya</a>
            </div>
        </form>
    </div>
    <!-- Table ends -->
</section>

<!-- modal-katalog -->
<div class="modal fade text-left" id="katalogForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-bold-700">Data Katalog</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">                       
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-bold-700">Level 1 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="select2 form-control" name="level1" id="level1">  
                                <option value="" disabled selected>Pilih</option>                                                                                       
                                    <option value="<?php echo $level1m['data'][0]['code'];?>"><?php echo $level1m['data'][0]['name'];?></option>                                   
                                    <option value="<?php echo $level1a['data'][0]['code'];?>"><?php echo $level1a['data'][0]['name'];?></option>                                   
                                    <option value="<?php echo $level1u['data'][0]['code'];?>"><?php echo $level1u['data'][0]['name'];?></option>                                   
                                    <option value="<?php echo $level1s['data'][0]['code'];?>"><?php echo $level1s['data'][0]['name'];?></option>                                   
                            </select>

                            <label class="text-bold-700 mt-3">Level 2 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="select2 form-control" name="level2" id="level2" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 3 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="select2 form-control" name="level3" id="level3" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-6">                            
                            <label class="text-bold-700">Level 4</label>
                            <select class="select2 form-control" name="level4" id="level4" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 5</label>
                            <select class="select2 form-control" name="level5" id="level5" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 6</label>
                            <select class="select2 form-control" name="level6" id="level6" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Product Name <span class="text-danger text-bold-700">(*)</span></label>                            
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product name">
                                <div class="form-control-position">
                                    <i class="ft-box"></i>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label class="text-bold-700">Berat/Unit</label>
                            <select class="select2 form-control" name="berat_unit" id="berat_unit" disabled>       
                                <option value="">Pilih Berat/Unit</option>  
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="text-bold-700">Satuan Dasar</label>
                            <select class="select2 form-control" name="uom_id" id="uom_id">   
                                <option value="">Pilih Satuan Dasar</option>                                                      
                                <?php foreach ($get_uoms['data'] as $value) { ?>
                                    <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>   
                                <?php } ?>  
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Term Of Delivery <span class="text-danger text-bold-700">(*)</span></label>                            
                            <select class="select2 form-control" name="term_of_delivery_id" id="term_of_delivery_id">  
                                <option value="">Pilih</option>   
                                <?php foreach ($get_tod['data'] as $value) { ?>
                                    <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>   
                                <?php } ?>  
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Catatan <span class="text-danger text-bold-700">(*)</span></label>                            
                            <fieldset class="form-group position-relative has-icon-left">
                                <textarea rows="6" class="form-control" name="note" id="note" placeholder="Product note"></textarea>
                                <div class="form-control-position">
                                    <i class="ft-file-text"></i>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="form-group col-12 row">
                    <div class="col-sm-4 pt-3">
                        <label class="text-bold-700">Gambar Utama <span class="text-danger text-bold-700">(*)</span></label><label class="text-muted ml-1"> (Tipe Image, Maksimal 20MB)</label>
                        <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery0" name="product_gallery0" data-id="0">                                                
                    </div>
                    <div class="col-sm-2 product-images py-3">
                        <img src="<?php echo site_url() ?>assets/img/noimage.jpg" id="images0" style="width: 90px; height: 70px">
                    </div>
                    <div class="col-sm-4 pt-3">
                        <label class="text-bold-700">Gallery 1 </label><label class="text-muted ml-1"> (Tipe Image, Maksimal 20MB)</label>
                        <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery1" name="product_gallery1" data-id="1">
                    </div>
                    <div class="col-sm-2 product-images py-3">
                        <img src="<?php echo site_url() ?>assets/img/noimage.jpg" id="images1" style="width: 90px; height: 70px">
                    </div>
                </div>

                <div class="form-group col-12 row">
                    <div class="col-sm-4 pt-3">
                        <label class="text-bold-700">Gallery 2 </label><label class="text-muted ml-1"> (Tipe Image, Maksimal 20MB)</label>
                        <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery2" name="product_gallery2" data-id="2">
                    </div>
                    <div class="col-sm-2 product-images py-3">
                        <img src="<?php echo site_url() ?>assets/img/noimage.jpg" id="images2" style="width: 90px; height: 70px">
                    </div>
                    <div class="col-sm-4 pt-3">
                        <label class="text-bold-700">Gallery 3 </label><label class="text-muted ml-1"> (Tipe Image, Maksimal 20MB)</label>

                        <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery3" name="product_gallery3" data-id="3">
                    </div>
                    <div class="col-sm-2 product-images py-3">
                        <img src="<?php echo site_url() ?>assets/img/noimage.jpg" id="images3" style="width: 90px; height: 70px">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Batal">
                    <input type="button" id="add_katalog" class="btn btn-info" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function (window, document, $) {
        'use strict';
        // Basic Select2 select
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    })(window, document, jQuery);

    $(document).ready(function () {
        $('.long-field').DataTable({
            ordering:  false,
            scrollX: true
        });
    });

</script>

<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'katalog') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>

<script type="text/javascript">   
    $(document).ready(function(){ 
        product_gallery0.onchange = evt => {
            const [file1] = product_gallery0.files
            if (file1) {
                images0.src = URL.createObjectURL(file1)
            }
        }

        product_gallery1.onchange = evt => {
            const [file] = product_gallery1.files
            if (file) {
                images1.src = URL.createObjectURL(file)
            }
        }

        product_gallery2.onchange = evt => {
            const [file] = product_gallery2.files
            if (file) {
                images2.src = URL.createObjectURL(file)
            }
        }

        product_gallery3.onchange = evt => {
            const [file] = product_gallery3.files
            if (file) {
                images3.src = URL.createObjectURL(file)
            }
        }

        $('#add_katalog').click(function () { 
            var level1 = $('#level1').val();   
            var level2 = $('#level2').val();   
            var level3 = $('#level3').val();   
            var level4 = $('#level4').val();   
            var level5 = $('#level5').val();   
            var level6 = $('#level6').val();   
            var product_name = $('#product_name').val();   
            var berat_unit = $('#berat_unit').val();   
            var uom_id = $('#uom_id').val();   
            var term_of_delivery_id = $('#term_of_delivery_id').val();   
            var note = $('#note').val();   

            $.ajax({
                type : 'POST',
                url	: "<?php echo site_url('_api/vendor/data/add_katalog'); ?>",
                data : {
                    level1:level1,
                    level2:level2,
                    level3:level3,
                    level4:level4,
                    level5:level5,
                    level6:level6,
                    product_name:product_name,
                    berat_unit:berat_unit,
                    uom_id:uom_id,
                    term_of_delivery_id:term_of_delivery_id,
                    note:note
                },
                cache : false,
                success	: function(status){ 
                    if (status == 1) {
                        toastr.info('Data Berhasil Disimpan.', '<i class="ft ft-check-square"></i> Success!');
                        setInterval('location.reload()', 2000);
                    } else if (status == 2) {
                        toastr.error('Data Belum Terisi Lengkap.', '<i class="ft ft-alert-triangle"></i> Error!');
                    } else if (status == 3) {
                        toastr.error('Data Gagal Disimpan.', '<i class="ft ft-alert-triangle"></i> Error!');
                    } 
                }
            });
        });
    });            
</script> 

<script>    
    $(document).ready( function(){
        $("#level1").on("change", function () {
            let level1 = $("#level1").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_jenis');?>",
                data: { kategori: level1 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level2 = '<option value="">Pilih</option>';
                    $.each(data, function () {   
                        $.each(this, function (i, item) {   
                            level2 += '<option value="' + item.code +'">' + item.code + " - " + item.name + "</option>";
                        });
                    });
                    $("#level2").html(level2).removeAttr("disabled");
                },
            });
        });

        $("#level2").on("change", function () {
            let level2 = $("#level2").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_level3');?>",
                data: { jenis: level2 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level3 = '<option value="">Pilih</option>';
                    $.each(data, function () {   
                        $.each(this, function (i, item) {   
                            level3 += '<option value="' + item.code +'">' + item.code + " - " + item.name + "</option>";
                        });
                    });
                    $("#level3").html(level3).removeAttr("disabled");
                },
            });
        });

        $("#level3").on("change", function () {
            let level3 = $("#level3").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_level4');?>",
                data: { level3: level3 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level4 = '<option value="">Pilih</option>';
                    $.each(data, function () {   
                        $.each(this, function (i, item) {   
                            level4 += '<option value="' + item.code +'">' + item.code + " - " + item.name + "</option>";
                        });
                    });
                    $("#level4").html(level4).removeAttr("disabled");
                },
            });
        });

        $("#level4").on("change", function () {
            let level4 = $("#level4").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_level5');?>",
                data: { level4: level4 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level5 = '<option value="">Pilih</option>';
                    $.each(data, function () {   
                        $.each(this, function (i, item) {   
                            level5 += '<option value="' + item.code +'">' + item.code + " - " + item.name + "</option>";
                        });
                    });
                    $("#level5").html(level5).removeAttr("disabled");
                },
            });
        });

        $("#level5").on("change", function () {
            let level5 = $("#level5").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_level6');?>",
                data: { level5: level5 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level6 = '<option value="">Pilih</option>';
                    $.each(data, function () {   
                        $.each(this, function (i, item) {   
                            level6 += '<option value="' + item.code +'">' + item.code + " - " + item.name + "</option>";
                        });
                    });
                    $("#level6").html(level6).removeAttr("disabled");
                },
            });
        });
    });
</script>