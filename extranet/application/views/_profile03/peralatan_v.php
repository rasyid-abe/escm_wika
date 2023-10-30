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
                            <h5 class="card-title-w float-left">Fasilitas/Peralatan <span class="text-danger">(*)</span></h5>
                            <?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
                                <a href="javascript:void(0)" class="btn btn-info modified btn-sm float-right" data-toggle="modal" data-target="#fasilitasForm"><i class="fa fa-plus"></i> Tambah</a>
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
                                                <th>Tipe</th>
                                                <th>Nama</th>
                                                <th>Jumlah</th>
                                                <th>Spesifikasi</th>
                                                <th>Merek</th>
                                                <th>Tahun Beli/Pembuatan</th>
                                                <th>Kondisi (%)</th>
                                                <th>Lokasi</th>
                                                <th>Kepemilikan</th>
                                                <th>Waktu Pembelian</th>
                                                <th>Lampiran Izin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($fasilitas as $value) { ?>
                                                <tr>                                                    
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td><?php echo $value['tipe_fasilitas']; ?></td>
                                                    <td><?php echo $value['nama_fasilitas']; ?></td>
                                                    <td><?php echo $value['jumlah']; ?></td>
                                                    <td><?php echo $value['specification']; ?></td>
                                                    <td><?php echo $value['merek']; ?></td>
                                                    <td><?php echo $value['tahun']; ?></td>
                                                    <td><?php echo $value['kondisi']; ?></td>
                                                    <td><?php echo $value['lokasi']; ?></td>
                                                    <td><?php echo $value['kepemilikan']; ?></td>
                                                    <td><?php echo $value['purchase_date']; ?></td>
													<td>
														<?php if ($value['lampiran'] != NULL) { ?>
															<a href="<?php echo $value['lampiran']; ?>" target="_blank">Download</a>
														<?php } else echo '-'; ?>
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
