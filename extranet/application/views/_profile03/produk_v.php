<?php $this->load->view("_profile03/_tab.php") ?>

<section class="bordered-striped-form-layout">
    <!-- row starts -->
    <div class="match-height">
        <form class="form-bordered">
            <!-- peralatan -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title-w float-left">Produk (pengadaan.com) <span class="text-danger">(*)</span></h5>
                            <?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
                                <a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#produkForm"><i class="fa fa-plus"></i> Tambah</a>
                            <?php } ?>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- content -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-bordered long-field" style="width: 150%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Code</th>
                                                <th>Nama Group</th>
                                                <th>Nama Produk</th>
                                                <th>Brand</th>
                                                <th>Source</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($produk as $value) { ?>
                                                <tr>                                                    
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td><?php echo $value['product_id']; ?></td>
                                                    <td><?php echo $value['product_code']; ?></td>
                                                    <td><?php echo $value['name_group']; ?></td>
                                                    <td><?php echo $value['product_name']; ?></td>
                                                    <td><?php echo $value['brand']; ?></td>
                                                    <td><?php echo $value['source']; ?></td>
                                                    <td><?php echo $value['type']; ?></td>                                                    
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
                <a href="<?php echo site_url('registrasi_vendor/pengalaman');?>" class="btn btn-secondary btn-md" >Kembali</a>
                <a href="<?php echo site_url('registrasi_vendor/klasifikasi');?>" class="btn btn-info btn-md" >Selanjutnya</a>
            </div>
        </form>
    </div>
    <!-- Table ends -->
</section>

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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'fasilitas') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

	})
</script>
