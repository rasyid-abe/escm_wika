<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets')?>/app-assets/vendors/css/datatables/dataTables.bootstrap4.min.css"/>

<section class="users-list-wrapper">    
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered selection-multiple-rows">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No</th>
                                            <th>Pelaporan</th>
                                            <th>Lampiran</th>
                                            <th>Date Created</th>
                                            <th>User By</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $no=1; foreach ($get_data as $value) { ?>   
                                            <tr>
                                                <td>
                                                    <a href="<?php echo base_url('administration/helpdesk/pelaporan/delete_pelaporan/' . $value['id']);?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')" class="btn btn-sm btn-danger"><i class="ft-trash"></i></a>
                                                </td>
                                                <td><?php echo $no++;?></td>
                                                <td><?php echo $value['isi_laporan'];?></td>
                                                <td><a href="<?php echo $this->config->item('ekstranet_url') . 'attachment/pelaporan/' . date("Y-m-d", strtotime($value['date_created'])) . '/' . $value['lampiran']?>" target="_blank">Download</a></td>
                                                <td><?php echo date("d-m-Y h:i:s", strtotime($value['date_created'])); ?></td>                                                
                                                <td><?php echo $value['created_by'];?></td>
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
    </div>
    <!-- Table ends -->
</section>

<script src="<?php echo base_url('assets')?>/app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets')?>/app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        $(".selection-multiple-rows").DataTable({ordering:false});

        toasterOptions();
        response_data();

        function response_data() {            
            if ('<?php echo $this->session->flashdata('tab') ?>' == 'pelaporan_del') {
                if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
                    toastr.info('Pelaporan berhasil dihapus.', '<i class="ft ft-check-square"></i> Success!');
                } else {
                    toastr.error('Pelaporan gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
                }
            }
        }
    });
</script>