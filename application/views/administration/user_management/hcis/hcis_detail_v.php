<style>
  .bold-td 
  {
    font-weight: bold;
  }
</style>
<div class="wrapper wrapper-content">
<section class="users-view">
                        <!-- Media object starts -->
                        <div class="row">
                            <div class="col-12 col-sm-7">
                                <div class="media d-flex align-items-center">
                                    <a href="javascript:;">
                                        <img src="<?= $data['foto_url'] ?>" alt="user view avatar" class="users-avatar-shadow rounded" height="164" width="164">
                                    </a>
                                    <div class="media-body ml-3">
                                        <h4>
                                            <span class="users-view-name" style="color: #29a7de;"><?= $data['nm_peg'] ?></span>
                                           
                                        </h4>
                                        <span></span>
                                        <span class="users-view-id"><?= $data['nip'] ?></span>
                                        <br>
                                        <span></span>
                                        <span class="users-view-id"><?= $data['posisi'] ?></span>
                                        <br>
                                        <span class="badge bg-light-success users-view-status">Active</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                <!-- <a href="javaScript:void(0);" class="btn btn-sm bg-light-secondary mr-2 px-3 py-1"><i class="ft-mail"></i></a>
                                <a href="javaScript:void(0);" class="btn btn-sm bg-light-secondary mr-2 px-3 py-1">Profile</a>
                                <a href="page-users-edit.html" class="btn btn-sm btn-primary px-3 py-1">Edit</a> -->
                            </div>
                        </div>
                        <!-- Media object ends -->

                        <div class="row">
                            <div class="col-6">
                                <!-- Card data starts -->
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                        <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Personal Info</h5>
                                            <div class="row">
                                                <div class="col-12 col-xl-12">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="bold-td">Agama:</td>
                                                                <td><?= $data['nm_agama'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Jenis Kelamin:</td>
                                                                <td><?= $data['jns_kelamin_peg'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Alamat:</td>
                                                                <td><?= $data['alamat'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Kode Pos:</td>
                                                                <td><?= $data['kodepos'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Handphone:</td>
                                                                <td><?= $data['handphone_1'] ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="bold-td">Tempat Lahir:</td>
                                                                <td><?= $data['tempat_lahir_peg'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Tanggal Lahir:</td>
                                                                <td><?= $data['tgl_lahir'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">User SCM:</td>
                                                                <td><?= $data['user_name'] ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card data ends -->
                            </div>
                            <div class="col-6">
                                <!-- Card data starts -->
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                        <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Organisasi Info</h5>
                                            <div class="row">
                                                <div class="col-12 col-xl-12">
                                                    <table class="table table-borderless bold-table">
                                                        <tbody>
                                                        <tr>
                                                                <td class="bold-td">Nama Divisi :</td>
                                                                <td><?= $data['nm_departemen'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Kode Fungsi Bidang :</td>
                                                                <td><?= $data['kd_fungsi_bidang'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Nama Fungsi Bidang</td>
                                                                <td><?= $data['nm_fungsi_bidang'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Kode Kantor :</td>
                                                                <td><?= $data['kd_kantor'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Nama Kantor :</td>
                                                                <td><?= $data['nm_kantor'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Kode Unit Organisasi :</td>
                                                                <td><?= $data['kd_unit_org'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Nama Unit Organisasi :</td>
                                                                <td><?= $data['nm_unit_org'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Direksi :</td>
                                                                <td><?= $data['direksi'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Nama Direktorat :</td>
                                                                <td><?= $data['nm_direktorat'] ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card data ends -->
                            </div>
                                                      
                        </div>
                    </section>
</div>
