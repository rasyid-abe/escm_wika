<?php $this->load->view("_profile01/_tab.php") ?>

<section class="bordered-striped-form-layout">
    <!-- row starts -->
    <div class="match-height">
        <form class="form-bordered">
            <!-- peralatan -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title-w float-left">Dokumen <span class="text-danger">(*)</span></h5>
                            <?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
                                <a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#produkForm"><i class="fa fa-plus"></i> Tambah</a>
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
                                                <th>Attachment</th>
                                                <th>Nama Dokumen</th>
                                                <th>Type</th>
                                                <th>Notes</th>
                                                <th>Jenis</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($dnb as $value) { ?>
                                                <tr>                                                    
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td><?php echo $value['attachment']; ?></td>
                                                    <td><?php echo $value['docname']; ?></td>
                                                    <td><?php echo $value['doctype']; ?></td>      
                                                    <td><?php echo $value['notes']; ?></td>
                                                    <td><?php echo $value['jenis']; ?></td>
                                                    <td><?php echo $value['created_at']; ?></td>
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
                <a href="<?php echo site_url('registrasi_vendor/tambahan');?>" class="btn btn-secondary btn-md" >Kembali</a>
                <a href="<?php echo site_url('registrasi_vendor/cqsms');?>" class="btn btn-info btn-md" >Selanjutnya</a>
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
