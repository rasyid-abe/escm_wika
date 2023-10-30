<?php $this->load->view("_profile01/_tab.php") ?>

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
                            <a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#katalogForm"><i class="fa fa-plus"></i> Tambah</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- content -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-bordered long-field" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Product Code</th>
                                                <th>Product Name</th>
                                                <th>Level</th>
                                                <th>UOM</th>
                                                <th>Term Of Delivery</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($katalog as $value) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>                                                                                                 
                                                    <td><?php echo $value['product_code']; ?></td>
                                                    <td><?php echo $value['product_name']; ?></td>
                                                    <td><?php echo $value['level']; ?></td>
                                                    <td><?php echo $value['uom']; ?></td>
                                                    <td><?php echo $value['tod']; ?></td>
                                                    <td><?php echo $value['created_at']; ?></td>
                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('registrasi_vendor/delete_katalog/'. $value['product_id'] ); ?>" onclick="return confirm('Apakah Anda yakin akan hapus data ini?')" class="btn btn-sm btn-danger"><i class="ft-trash"></i></a>
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
                        <div class="col-md-4">
                            <label class="text-bold-700">Level 1 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="form-control" name="level1" id="level1">  
                                <option value="" disabled selected>Pilih</option>        
                                <?php foreach($level1 as $v1) { ?>
                                    <option value="<?php echo $v1['resources_code_id'];?>"><?php echo $v1['name'];?></option>                                   
                                <?php } ?>
                            </select>

                            <label class="text-bold-700 mt-3">Level 2 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="form-control" name="level2" id="level2" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 3 <span class="text-danger text-bold-700">(*)</span></label>
                            <select class="form-control" name="level3" id="level3" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-4">                            
                            <label class="text-bold-700">Level 4</label>
                            <select class="form-control" name="level4" id="level4" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 5</label>
                            <select class="form-control" name="level5" id="level5" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 6</label>
                            <select class="form-control" name="level6" id="level6" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-md-4">                            
                            <label class="text-bold-700">Level 7</label>
                            <select class="form-control" name="level7" id="level7" disabled>
                                <option value="">Pilih</option>
                            </select>

                            <label class="text-bold-700 mt-3">Level 8</label>
                            <select class="form-control" name="level8" id="level8" disabled>
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Satuan Dasar</label>
                            <select class="form-control" name="uom_id" id="uom_id">   
                                <option value="">Pilih Satuan Dasar</option>                                                      
                                <?php foreach ($get_uoms as $value) { ?>
                                    <option value="<?php echo $value['name'];?>"><?php echo $value['name'];?></option>   
                                <?php } ?>  
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Term Of Delivery</label>                            
                            <select class="form-control" name="tod_id" id="tod_id">  
                                <option value="">Pilih Term Of Delivery</option>   
                                <?php foreach ($get_tod as $value) { ?>
                                    <option value="<?php echo $value['name'];?>"><?php echo $value['name'];?></option>   
                                <?php } ?>  
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="text-bold-700">Catatan</label>                            
                            <fieldset class="form-group position-relative has-icon-left">
                                <textarea rows="6" class="form-control" name="note" id="note" placeholder="Product note"></textarea>
                                <div class="form-control-position">
                                    <i class="ft-file-text"></i>
                                </div>
                            </fieldset>
                        </div>
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
				}
			}
		}
	})
</script>

<script type="text/javascript">   
    $(document).ready(function(){ 
        $('#add_katalog').click(function () { 
            var level1 = $('#level1').val();   
            var level2 = $('#level2').val();   
            var level3 = $('#level3').val();   
            var level4 = $('#level4').val();   
            var level5 = $('#level5').val();   
            var level6 = $('#level6').val();   
            var level7 = $('#level7').val();   
            var level8 = $('#level8').val();    
            var uom_id = $('#uom_id').val();   
            var tod_id = $('#tod_id').val();   
            var note = $('#note').val();   

            $.ajax({
                type : 'POST',
                url	: "<?php echo site_url('registrasi_vendor/submit_katalog'); ?>",
                data : {
                    level1:level1,
                    level2:level2,
                    level3:level3,
                    level4:level4,
                    level5:level5,
                    level6:level6,
                    level7:level7,
                    level8:level8,
                    uom_id:uom_id,
                    tod_id:tod_id,
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
                url: "<?php echo base_url('registrasi_vendor/get_level2');?>",
                data: { kategori: level1 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level2 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level2 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level2").html(level2).removeAttr("disabled");
                },
            });
        });

        $("#level2").on("change", function () {
            let level2 = $("#level2").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_level3');?>",
                data: { level2: level2 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level3 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level3 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
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
                    $.each(data, function (i, item) {   
                        level4 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
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
                    $.each(data, function (i, item) {   
                        level5 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
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
                    $.each(data, function (i, item) {   
                        level6 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level6").html(level6).removeAttr("disabled");
                },
            });
        });

        $("#level6").on("change", function () {
            let level6 = $("#level6").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_level7');?>",
                data: { level6: level6 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level7 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level7 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level7").html(level7).removeAttr("disabled");
                },
            });
        });

        $("#level7").on("change", function () {
            let level7 = $("#level7").val();
            $.ajax({
                url: "<?php echo site_url('registrasi_vendor/get_level8');?>",
                data: { level7: level7 },
                method: "post",
                dataType: "json",
                success: function (data) {
                    level7 = '<option value="">Pilih</option>';
                    $.each(data, function (i, item) {   
                        level8 += '<option value="' + item.resources_code_id +'">' + item.code + " - " + item.name + "</option>";                        
                    });
                    $("#level8").html(level8).removeAttr("disabled");
                },
            });
        });
    });
</script>