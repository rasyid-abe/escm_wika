<?php $this->load->view("_profile02/_tab.php") ?>

<section class="bordered-striped-form-layout">
    <!-- row starts -->
    <div class="match-height">
        <form class="form-bordered" method="POST" action="<?php echo site_url('registrasi_vendor/submit_lampiran');?>" enctype="multipart/form-data">
            <!-- lampiran -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-bold-600 mr-2">Lampiran Vendor <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- content -->
                                <a href="<?php echo base_url('attachment/dok_surat_pernyataan.pdf');?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i> Download Surat Pernyataan Vendor</a>
                                <div class="form-group row mt-3">
                                    <label class="col-md-4 label-control">Surat Pernyataan Vendor</label>
                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <input type="file" name="vendor_lampiran" required>                                                                                            
                                            <?php if ($detail_vendor['vendor_lampiran'] != NULL) { ?>
                                                <span><a href="<?php echo site_url('attachment/vendor/'.$this->session->userdata('npwp_no_s').'/') . $detail_vendor['vendor_lampiran']?>" target="_blank">Download</a></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" onclick="return confirm('Apakah Anda yakin dengan data ini?')" class="btn btn-info btn-sm" value="Simpan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </form>

        <!-- catatan -->
        <div class="row">   
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-bold-600 mr-2">Daftar Aktivity</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- content -->
                            <div class="table-responsive">
                                <table class="table comment table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>User</th>
                                            <th>Posisi</th>
                                            <th>Activity</th>
                                            <th>Response</th>
                                            <th>Komentar</th>
                                            <th>File</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if(isset($comment_list) && !empty($comment_list)){

                                        foreach ($comment_list as $kc => $vc) {

                                        $start_date = date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_date']));
                                        $end_date = (isset($vc['comment_end_date']) && !empty(strtotime($vc['comment_end_date']))) ? date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_end_date'])) : "";
                                        ?>
                                        <tr>
                                        <td><?php echo $start_date ?></td>
                                        <td><?php echo $end_date  ?></td>
                                        <td><?php echo $vc['comment_name'] ?></td>
                                        <td><?php echo $vc['position'] ?></td>
                                        <td><?php echo $vc['activity_name'] ?></td>
                                        <td><?php echo $vc['response'] ?></td>
                                        <td><?php echo $vc['comments'] ?></td>
                                        <td><a href="<?php echo site_url("log/download_attachment/".$dir."/".$vc['attachment']) ?>" target="_blank"><?php echo $vc['attachment'] ?></a></td>
                                        </tr>
                                        <?php } } ?>

                                    </tbody>
                                </table>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="<?php echo site_url('registrasi_perorangan/submit_comment');?>" enctype="multipart/form-data">                                    
            <!-- form komentar -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-bold-600 mr-2">Form Aktivitas <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- content -->                                    
                                <input type="hidden" name="vendor_name" value="<?php echo $detail_vendor['vendor_name']?>">
                                <input type="hidden" name="syncron_date" value="<?php echo $detail_vendor['syncron_date']?>">
                                <div class="modal-body">  
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Komentar</label>
                                        <div class="col-md-9">
                                            <div class="position-relative has-icon-left">
                                                <textarea rows="4" class="form-control" name="vc_comment" required></textarea>
                                                <div class="form-control-position">
                                                    <i class="ft-file"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Lampiran</label>
                                        <div class="col-md-9">
                                            <div class="position-relative has-icon-left">
                                                <input type="file" class="form-control" name="vrc_attachment">
                                                <div class="form-control-position">
                                                    <i class="ft-file"></i>
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

            <div class="col-lg-12 text-center my-3">
                <a href="<?php echo site_url('registrasi_perorangan/pelatihan');?>" class="btn btn-secondary btn-md" >Kembali</a>
                <?php if ($detail_vendor['reg_status_id'] != 8 && $detail_vendor['reg_status_id'] != 14 && $detail_vendor['vnd_jenis'] != 'Pengadaan.com') { ?>
                    <input type="submit" onclick="return confirm('Apakah Anda yakin dengan data ini?')" class="btn btn-info" value="Simpan dan Selesai">
                <?php } ?>
            </div>
        </form>
    </div>
    <!-- Table ends -->
</section>

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
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'catatan') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('Data berhasil diperbarui.', '<i class="ft ft-check-square"></i> Success!');
				} else if ('<?php echo $this->session->flashdata('res') ?>' == '3') {
					toastr.error('Nama vendor belum diisi.', '<i class="ft ft-alert-triangle"></i> Error!');
				} else {
					toastr.error('Data gagal diperbarui.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}
	})
</script>
