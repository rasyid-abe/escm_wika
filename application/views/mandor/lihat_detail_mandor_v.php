<div class="wrapper wrapper-content animated fadeIn">
  <div class="row m-t-lg">
    <div class="col-lg-12">
      <!-- perubahan d m Y H:i:s dari hlmifzi -->

      <?php if (empty($header)) { ?>

        <center>
          <h1>Data Vendor tidak Valid</h1>
        </center>

      <?php } else { ?>

        <div class="tabs-container">

          <div class="tabs-left">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab-1">Data Administrasi</a></li>
              <li class=""><a data-toggle="tab" href="#tab-4">Data Keuangan</a></li>
              <li class=""><a data-toggle="tab" href="#tab-3">Pengalaman Proyek</a></li>
              <li class=""><a data-toggle="tab" href="#tab-5">Teknis (Ahli Bidang / Tools)</a></li>
              <li class="active" style="padding:20px">
              <?php if($header['status'] == 'N'){?>
               <div style="text-align:center" class="col-md-12 col-sm-12 alert alert-dismissible alert-danger">Non Active</div>
               <form action="<?php echo site_url('vendor/update_status_mandor/A/'.$vmh_id) ?>" method="get">
                 <button class="btn btn-success col-md-12"> Aktifkan</button>
               </form>
              <?php } elseif($header['status'] == 'WA') { ?>

               <div style="text-align:center" class="col-md-12 col-sm-12 alert alert-dismissible alert-warning">Waiting Approval</div>
               <form action="<?php echo site_url('vendor/update_status_mandor/N/'.$vmh_id)?>" method="get">
                  <button class="btn btn-danger col-md-12"> Non Aktifkan</button>
               </form>
              <form action="<?php echo site_url('vendor/update_status_mandor/A/'.$vmh_id) ?>" method="get">
                <button class="btn btn-success col-md-12" style="margin-top:10px"> Aktifkan</button>
              </form>
              <?php } elseif($header['status'] == 'A') { ?>
               <div style="text-align:center" class="col-md-12 col-sm-12 alert alert-dismissible alert-success">Active</div>
                <form action="<?php echo site_url('vendor/update_status_mandor/N/'.$vmh_id) ?>" method="get">
                  <button class="btn btn-danger col-md-12"> Non Aktifkan</button>
                </form>
              <?php } ?>
              </li>
            </ul>
            <div class="tab-content ">
              <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                        Profil Mandor
                        <button class="btn btn-success btn-action" data-id="<?php echo $header['vmh_id']; ?>"  data-category="profil" data-action="edit" data-detail='<?= json_encode($header) ?>' >Edit</button>
                    </div>
                    <div style="padding: 15px;">
                      <table class="table">
                        <tr>
                          <th>Nama</th>
                          <td><?php echo $header['vmh_name']; ?></td>
                        </tr>
                        <tr>
                          <th>No NPWP</th>
                          <td><?php echo $header['vmh_npwp']; ?></td>
                        </tr>
                        <tr>
                          <th>Alamat</th>
                          <td><?php echo $header['vmh_address']; ?></td>
                        </tr>
                        <tr>
                          <th>Email Registrasi</th>
                          <td><?php echo $header['vmh_email']; ?></td>
                        </tr>
                        <tr>
                          <th>No Hnadphone Perusahaan</th>
                          <td><?php echo $header['vmh_hp']; ?></td>
                        </tr>
                        <tr>
                          <th>Jumlah Tenaga Kerja</th>
                          <td><?php echo $header['vmh_qty_employee']; ?></td>
                        </tr>
                        <tr>
                          <th>Surat Pernyataan</th>
                          <td>
                            <a href="<?php echo site_url('log/download_attachment_extranet/administrasi/statement/'.$header['vmh_statement_letter'])?>" target="_blank">
                             <?php echo $header['vmh_statement_letter']; ?>
                            </a>
                          </td>
                        </tr>
                       
                      </table>
                    </div>
                  </div>
      
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      PIC Mandor
                    </div>
                    <div style="padding: 15px;">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama PIC</th>
                              <th>Jabatan</th>
                              <th>Telp Kantor</th>
                              <th>Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $i = 1;
                              foreach ($pic_mandor as $row) { ?>
                              <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $row["vmp_pic_name"] ?></td>
                                <td><?php echo $row["vmp_pic_position"] ?></td>
                                <td><?php echo $row["vmp_pic_contact"] ?></td>
                                <td>
                                  <button class="btn btn-sm btn-success btn-action" data-id="<?= $row['vmp_id'] ?>" data-action="edit" data-category="pic_mandor" data-detail='<?= json_encode($row) ?>'>Edit</button>
                                </td>
                              </tr>
                            <?php
                                $i++;
                              }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Bidang Mandor
                    </div>
                    <div style="padding: 15px;">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Bidang</th>
                              <th>Nama Sub Bidang</th>
                              <th>Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $i = 1;
                              foreach ($bidang_mandor as $row) { ?>
                              <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $row["vmb_bidang_name"] ?></td>
                                <td><?php echo $row["vmb_sub_bidang_name"] ?></td>
                                <td>
                                  <button class="btn btn-sm btn-success btn-action" data-id="<?= $row['vmb_id'] ?>" data-action="edit" data-category="bidang_mandor" data-detail='<?= json_encode($row) ?>'>Edit</button>
                                </td>
                              </tr>
                            <?php
                                $i++;
                              }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div id="tab-4" class="tab-pane">
                <div class="panel-body">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Modal Sesuai Data Terakhir
                      <button class="btn btn-success btn-action" data-id="<?php echo $header['vmh_id']; ?>"  data-category="modal_mandor" data-action="edit" data-detail='<?= json_encode($header) ?>' >Edit</button>
                    </div>
                    <div style="padding: 15px;">
                      <table class="table">
                        <tr>
                          <th>Nama Bank</th>
                          <td><?php echo $header['vmh_bank_account']; ?></td>
                        </tr>
                        <tr>
                          <th>Nomor Rekening</th>
                          <td><?php echo $header['vmh_bank_no_account']; ?></td>
                        </tr>
                        <tr>
                          <th>Atas Nama Rekening</th>
                          <td><?php echo $header['vmh_bank_name']; ?></td>
                        </tr>
                        <tr>
                          <th>Rekening koran</th>
                          <td>
                            <a href="<?php echo site_url()?>" target="_blank">
                              <?php echo $header['vmh_rekening_koran']; ?>
                            </a>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="tab-3" class="tab-pane">
                <div class="panel-body">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Pengalaman Proyek
                    </div>
                    <div style="padding: 15px;">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Tahun Proyek</th>
                              <th>Nama Proyek</th>
                              <th>Nilai Pekerjaan</th>
                              <th>Nama Kontraktor</th>
                              <th>Bidang </th>
                              <th>Sub Bidang</th>
                              <th>Tanda Bukti Proyek</th>
                              <th>Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $i = 1;
                              foreach ($experience_mandor as $row) {?>
                                <tr>
                                  <td><?php echo $i ?></td>
                                  <td><?php echo $row["vmpe_year"] ?></td>
                                  <td><?php echo $row["vmpe_project_name"]; ?></td>
                                  <td><?php echo inttomoney($row["vmpe_project_value"]) ?></td>
                                  <td><?php echo $row["vmpe_contractor_name"]; ?></td>
                                  <td><?php echo $row["vmb_bidang_name"] ?></td>
                                  <td><?php echo $row["vmb_sub_bidang_name"] ?></td>
                                  <td>
                                    <a href="<?php echo site_url()?>" target="_blank">
                                      <?php echo $row["vmpe_evidence_project"] ?>
                                   </a>
                                  </td>
                                  <td>
                                    <button class="btn btn-sm btn-success btn-action" data-id="<?= $row['vmpe_id'] ?>" data-action="edit" data-category="pengalaman_mandor" data-detail='<?= json_encode($row) ?>'>Edit</button>
                                  </td>
                                </tr>
                            <?php
                                  $i++;
                              }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div id="tab-5" class="tab-pane">
                <div class="panel-body">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Ahli Bidang Mandor
                    </div>
                    <div style="padding: 15px;">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Bidang</th>
                              <th>Jumlah Ahli Bidang</th>
                              <th>Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $i = 1;
                              foreach ($jml_ahli_bidang_mandor as $row) {?>
                                <tr>
                                  <td><?php echo $i ?></td>
                                  <td><?php echo $row["vmtq_ahli_bidang"] ?></td>
                                  <td><?php echo $row["vmtq_qty_ahli_bidang"]; ?></td>
                                  <td>
                                    <button class="btn btn-sm btn-success btn-action" data-id="<?= $row['vmtq_id'] ?>" data-action="edit" data-category="ahli_bidang_mandor" data-detail='<?= json_encode($row) ?>'>Edit</button>
                                  </td>
                                </tr>
                            <?php
                                  $i++;
                              }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Daftar Peralatan (Tools)
                    </div>
                    <div style="padding: 15px;">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Peralatan</th>
                              <th>Merk</th>
                              <th>Jumlah Peralatan</th>
                              <th>Kondisi </th>
                              <th>Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $i = 1;
                              foreach ($tools_bidang as $row) {?>
                                <tr>
                                  <td><?php echo $i ?></td>
                                  <td><?php echo $row["vmt_tools_name"] ?></td>
                                  <td><?php echo $row["vmt_tool_brand"]; ?></td>
                                  <td><?php echo $row["vmt_qty_tools"] ?></td>
                                  <td><?php echo $row["vmt_condition"] ?></td>
                                  <td>
                                    <button class="btn btn-sm btn-success btn-action" data-id="<?= $row['vmt_id'] ?>" data-action="edit" data-category="peralatan" data-detail='<?= json_encode($row) ?>'>Edit</button>
                                  </td>
                                </tr>
                            <?php
                                  $i++;
                              }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
             


             

            </div>

          </div>

        </div>

      <?php } ?>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="profil" tabindex="-4" role="dialog" aria-labelledby="dialogLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('/vendor/update_profil_mandor') ?>" id="form-profil" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="dialogLabel">Edit Profile</h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="vmh_id">
            <div class="form-group row">
              <div class="col-md-5">
                <label class="control-label">Nama *</label>
                <input name="vmh_name" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama" />
              </div>
              <div class="col-md-7">
                <label class="control-label">Alamat *</label>
                <input name="vmh_address" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Alamat" />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label class="control-label">No NPWP *</label>
                <input name="vmh_npwp" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan No NPWP" />
              </div>
              <div class="col-md-4">
                <label class="control-label">Email *</label>
                <input name="vmh_email" maxlength="100" type="email" required="required" class="form-control" placeholder="Masukkan Email" />
              </div>
              <div class="col-md-4">
                <label class="control-label">No Telepon/HP *</label>
                <input name="vmh_hp" maxlength="100" type="number" required="required" class="form-control" placeholder="Masukkan No Telephone" />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label class="control-label">Jumlah Tenaga Kerja *</label>
                <input name="vmh_qty_employee" maxlength="100" type="number" required="required" class="form-control" placeholder="Masukkan Jumlah Tenaga Kerja" />
              </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-sm btn-success mr-1 btn-submit"><i class="icon-paperplane mr-1"></i>Submit</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="pic_mandor" tabindex="-4" role="dialog" aria-labelledby="dialogLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('/vendor/update_pic_mandor') ?>" id="form-pic_mandor" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="dialogLabel">Edit PIC Mandor</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="vmp_id"> 
          <input type="hidden" name="h_id1"> 

          <div class="row">
            <div class="col-md-6">
              <label class="control-label t">Nama PIC *</label>
              <input maxlength="100" type="text" name="vmp_pic_name" required="required" class="form-control" placeholder="Masukkan Nama PIC" />
            </div>
            <div class="col-md-6">
              <label class="control-label">Keterangan Jabatan *</label>
              <input maxlength="100" type="text" name="vmp_pic_position" required="required" class="form-control" placeholder="Masukkan Jabatan PIC" />
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">No Handphone *</label>
              <input maxlength="100" type="number" name="vmp_pic_contact" required="required" class="form-control" placeholder="ex: 08120120129" />
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-sm btn-success mr-1 btn-submit"><i class="icon-paperplane mr-1"></i>Submit</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="bidang_mandor" tabindex="-4" role="dialog" aria-labelledby="dialogLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('/vendor/update_bidang_mandor') ?>" id="form-bidang_mandor" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="dialogLabel">Edit Bidang Mandor</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="vmb_id"> 
          <input type="hidden" name="h_id2"> 
          <div class="row">
            <div class="col-md-5">
              <label class="control-label">Bidang *</label>
              <select class="form-control m-b bidang" data-no="1" name="vmb_bidang_code">
                <option>Pilih Bidang</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="control-label">Sub Bidang *</label>		
              <select class="form-control m-b sub_bidang"  data-no="1" name="vmb_sub_bidang_code">
                <option>Pilih Sub Bidang</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-sm btn-success mr-1 btn-submit"><i class="icon-paperplane mr-1"></i>Submit</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_mandor" tabindex="-4" role="dialog" aria-labelledby="dialogLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('/vendor/update_modal_mandor') ?>" id="form-modal_mandor" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="dialogLabel">Edit Modal</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name='h_id3'>
          <div class="form-group row">
            <div class="col-md-3">
              <label class="control-label">Nama Bank *</label>
              <input name="vmh_bank_account" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama" />
            </div>
            <div class="col-md-5">
              <label class="control-label">Nomor Rekening *</label>
              <input name="vmh_bank_no_account" maxlength="100" type="number" required="required" class="form-control" placeholder="Masukkan No Rekening" />
            </div>
            <div class="col-md-4">
              <label class="control-label">Atas Nama Rekening *</label>
              <input name="vmh_bank_name" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Rekening" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <label class="control-label">Upload Rekening koran tahun <?php 
              $time = strtotime("-1 year", time());
              $dateMinusOneYear = date("Y", $time);
              echo $dateMinusOneYear.' dan tahun '.date('Y'); ?>*</label>
              <input name="vmh_rekening_koran" type="file" class="form-control" placeholder="Upload Rekening Koran" />
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-sm btn-success mr-1 btn-submit"><i class="icon-paperplane mr-1"></i>Submit</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="pengalaman_mandor" tabindex="-4" role="dialog" aria-labelledby="dialogLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('/vendor/update_pengalaman_mandor') ?>" id="form-pengalaman_mandor" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="dialogLabel">Edit Pengalaman Proyek</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name='vmpe_id'>
          <input type="hidden" name='h_id4'>
          <div class="form-group row">
            <div class="col-md-4">
              <label class="control-label">Tahun Proyek *</label>
              <select class="form-control m-b" name="vmpe_year">
                <option>Pilih Tahun</option>
                <?php for($i=2000;$i<=2050;$i++){?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php }?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="control-label">Nama Proyek *</label>
              <input name="vmpe_project_name" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Proyek" />
            </div>
            <div class="col-md-4">
              <label class="control-label">Nilai Pekerjaan *</label>
              <input name="vmpe_project_value" maxlength="100" type="number" required="required" class="form-control rupiah" placeholder="Masukkan Nilai pekerjaan" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-6">
              <label class="control-label">Nama Kontraktor *</label>
              <input name="vmpe_contractor_name" maxlength="100" type="text" required="required" class="form-control rupiah" placeholder="Masukkan Nama Kontraktor" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <label class="control-label">Upload Bukti Proyek, Ditandatangani Manager Proyek</label>
              <input name="vmpe_evidence_project" type="file" class="form-control" placeholder="Upload Rekening Koran" />
            </div>
          </div>
          <div class="form-group row" >
            <div class="col-md-12" style="color:#0288D1">
              <h3>Bidang</h3>
            </div>
            <div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
              <div class="bidang_pengalaman">
                <div class="row">
                  <div class="col-md-4">
                    <label class="control-label">Bidang *</label>
                    <select class="form-control m-b bidang_proyek" data-no="1" name="vmb_bidang_code_proyek[]" >
                    <?php foreach ($bidang as $k => $v) { ?>
                      <option value="<?php echo $v['am_kode'] ?>"><?php echo $v['am_name'] ?></option>
                    <?php } ?>
                  </select>
                  </div>
                  <div class="col-md-7">
                    <label class="control-label">Sub Bidang *</label>
                    <select class="form-control m-b sub_bidang_proyek" data-no="1" name="vmb_sub_bidang_code_proyek[]" >
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <button class="btn btn-primary col-md-12 btn-action" style="margin-top:20px" type="button" data-category="bidang_pengalaman" data-action="add"><i class="fa fa-plus"></i> Tambah Bidang</button>
              </div>
            </div>
          </div>
        <div class="modal-footer d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-sm btn-success mr-1 btn-submit"><i class="icon-paperplane mr-1"></i>Submit</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ahli_bidang_mandor" tabindex="-4" role="dialog" aria-labelledby="dialogLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('/vendor/update_ahli_bidang_mandor') ?>" id="form-ahli_bidang_mandor" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="dialogLabel">Edit Ahli Bidang Mandor</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name='vmtq_id'>
          <input type="hidden" name='h_id5'>
          <div class="form-group row">
            <div class="col-md-8">
              <label class="control-label">Ahli Bidang *</label>
              <input name="vmtq_ahli_bidang" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Ahli Bidang" />
            </div>
            <div class="col-md-3">
              <label class="control-label">Jumlah *</label>
              <input name="vmtq_qty_ahli_bidang" maxlength="100" type="number" required="required" class="form-control" placeholder="Masukkan Jumlah Ahli Bidang" />
            </div>
          </div>
        <div class="modal-footer d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-sm btn-success mr-1 btn-submit"><i class="icon-paperplane mr-1"></i>Submit</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="peralatan" tabindex="-4" role="dialog" aria-labelledby="dialogLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('/vendor/update_peralatan') ?>" id="form-peralatan" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="dialogLabel">Edit Peralatan Mandor</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name='vmt_id'>
          <input type="hidden" name='h_id6'>
          <div class="form-group row">
            <div class="col-md-5">
              <label class="control-label">Nama Peralatan *</label>
              <input name="vmt_tools_name" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Peralatan" />
            </div>
            <div class="col-md-6">
              <label class="control-label">Merek *</label>
              <input name="vmt_tool_brand" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Merek Peralatan" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-5">
              <label class="control-label">Jumlah Peralatan *</label>
              <input name="vmt_qty_tools" maxlength="100" type="number" required="required" class="form-control" placeholder="Masukkan Jumlah Peralatan" />
            </div>
            <div class="col-md-6">
              <label class="control-label">Kondisi *</label>
              <input name="vmt_condition" maxlength="100" type="text" required="required" class="form-control" placeholder="Jelaskan Kodisi peralatan" />
            </div>
          </div>
        <div class="modal-footer d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-sm btn-success mr-1 btn-submit"><i class="icon-paperplane mr-1"></i>Submit</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="icon-cross2 mr-1"></i>Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  
  $(document).ready(function() {
    $('.dataTables-example').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ]
    });

    $('#form-profil').validate({
      ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
      errorClass: 'validation-invalid-label',
      successClass: 'validation-valid-label',
      validClass: 'validation-valid-label',
      highlight: function (element, errorClass) {
          $(element).removeClass(errorClass);
      },
      unhighlight: function (element, errorClass) {
          $(element).removeClass(errorClass);
      },
      // success: function(label) {
      //     label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
      // },
      // Different components require proper error label placement
      errorPlacement: function (error, element) {

          // Unstyled checkboxes, radios
          if (element.parents().hasClass('form-check')) {
              error.appendTo(element.parents('.form-check').parent());
          }

          else if (element.parents().hasClass('custom-control')) {
              error.appendTo(element.parents('.custom-control').parent().parent().parent());
          }

          // Input with icons and Select2
          else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
              error.appendTo(element.parent());
          }

          // Input group, styled file input
          else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
              error.appendTo(element.parent().parent());
          }

          // Other elements
          else {
              error.insertAfter(element);
          }
        },
    })
    
   
  });
  const general = {
    header: JSON.parse(`<?= json_encode($header) ?>`),
    bidang_pengalaman: {
      no: 1,
      selected_sub_bidang_proyek: []
    }
  }
  $(document).on('click', '.btn-action', function(){
    _logic.app(this)
  });

  $(document.body).on("change",'select[name=vmb_bidang_code]', function(e) {
    let bidang_code = $(this).val()
    let dataNo = $(this).attr('data-no')

    $.ajax({
      url: "<?php echo site_url('vendor/get_sub_bidang') ?>",
      datatype: "json",
      type: "POST",
      data: {bidang_code: bidang_code},
      success: function(data) {
        var d = JSON.parse(data)
        $('select[name=vmb_sub_bidang_code] option').remove();
        let content = '';
        $.each(d.data, function (key, result) {
          if(data.vmb_sub_bidang_code == result.am_kode){
            content += "<option selected value='" + result.am_kode + "'>" + result.am_name +
            "</option>";
          }else{
            content += "<option value='" + result.am_kode + "'>" + result.am_name +
            "</option>";
          }
        });
        $('select[name=vmb_sub_bidang_code]').append(content);
      }
    });
  });

  $(document.body).on("change",'.bidang_proyek', function(e) {
    let bidang_code = $(this).val()
    let dataNo = $(this).attr('data-no')
    $.ajax({
      url: "<?php echo site_url('vendor/get_sub_bidang') ?>",
      datatype: "json",
      type: "POST",
      data: {
        bidang_code: bidang_code,
        selected_sub_bidang: general.bidang_pengalaman.selected_sub_bidang_proyek
      },
      success: function(data) {
        d = JSON.parse(data)
        let subBidang = d.data.map((v)=>{
          return(`
            <option value="${v.am_kode}">${v.am_name}</option>
          `)
        })
        $(`.sub_bidang_proyek[data-no=${dataNo}]`).html("")
        $(`.sub_bidang_proyek[data-no=${dataNo}]`).append(subBidang)
        $(`.sub_bidang_proyek[data-no=${dataNo}]`).trigger('change')
      }
    });
  });

  $(document).on('change', '.sub_bidang_proyek',function(){
    //listing selected sub bidang
    if(!general.bidang_pengalaman.selected_sub_bidang_proyek.includes($(this).val())){
      general.bidang_pengalaman.selected_sub_bidang_proyek.push($(this).val())
    }
  })
  
  const _logic = {
    app: (elem) => {
      try {
        _logic.modules[$(elem).attr('data-category')][$(elem).attr('data-action')](elem);
      } catch (error) {
        alert('Oops something went wrong');
        console.log(error)
      }
    },
    modules: {
      profil: {
        edit: (elem) => {
          $(`#form-${$(elem).attr('data-category')}`)[0].reset();
          $(`#${$(elem).attr('data-category')}`).modal('show');
          const data =  JSON.parse($(elem).attr('data-detail'));
          _logic.modules[$(elem).attr('data-category')].fill_form(data);
        },
        fill_form: (data) => {
          $('input[name=vmh_id]').val(data.vmh_id)
          $('input[name=vmh_name]').val(data.vmh_name)
          $('input[name=vmh_address]').val(data.vmh_address)
          $('input[name=vmh_npwp]').val(data.vmh_npwp)
          $('input[name=vmh_email]').val(data.vmh_email)
          $('input[name=vmh_qty_employee]').val(data.vmh_qty_employee)
        }
      },
      pic_mandor: {
        edit: (elem) => {
          $(`#form-${$(elem).attr('data-category')}`)[0].reset();
          $(`#${$(elem).attr('data-category')}`).modal('show');
          const data =  JSON.parse($(elem).attr('data-detail'));
          _logic.modules[$(elem).attr('data-category')].fill_form(data);
        },
        fill_form: (data) => {
          $('input[name=vmp_id]').val(data.vmp_id)
          $('input[name=h_id1]').val(general.header.vmh_id)
          $('input[name=vmp_pic_name]').val(data.vmp_pic_name)
          $('input[name=vmp_pic_position]').val(data.vmp_pic_position)
          $('input[name=vmp_pic_contact]').val(data.vmp_pic_contact)
        }
      },
      bidang_mandor: {
        edit: (elem) => {
          $(`#form-${$(elem).attr('data-category')}`)[0].reset();
          $(`#${$(elem).attr('data-category')}`).modal('show');
          const data =  JSON.parse($(elem).attr('data-detail'));
          _logic.modules[$(elem).attr('data-category')].fill_form(data);
        },
        fill_form: (data) => {
          var bidangs = JSON.parse('<?= json_encode($bidang) ?>')
          $('select[name=vmb_bidang_code] option').remove();
          let content = '';
          $.each(bidangs, function (key, result) {
            if(data.vmb_bidang_code == result.am_kode){
              content += "<option selected value='" + result.am_kode + "'>" + result.am_name +
              "</option>";
            }else{
              content += "<option value='" + result.am_kode + "'>" + result.am_name +
              "</option>";
            }
          });
          $('select[name=vmb_bidang_code]').append(content); 
          $('select[name=vmb_bidang_code]').trigger('change');
          $('input[name=vmb_id]').val(data.vmb_id)
          $('input[name=h_id2]').val(general.header.vmh_id)

        }
      },
      modal_mandor: {
        edit: (elem) => {
          $(`#form-${$(elem).attr('data-category')}`)[0].reset();
          $(`#${$(elem).attr('data-category')}`).modal('show');
          const data =  JSON.parse($(elem).attr('data-detail'));
          _logic.modules[$(elem).attr('data-category')].fill_form(data);
        },
        fill_form: (data) => {
          $('input[name=vmh_bank_account]').val(data.vmh_bank_account); 
          $('input[name=vmh_bank_no_account]').val(data.vmh_bank_no_account);
          $('input[name=vmh_bank_name]').val(data.vmh_bank_name)
          $('input[name=vmh_id]').val(data.vmh_id)
          $('input[name=h_id3]').val(general.header.vmh_id)

        }
      },
      pengalaman_mandor: {
        edit: (elem) => {
          $(`#form-${$(elem).attr('data-category')}`)[0].reset();
          $(`#${$(elem).attr('data-category')}`).modal('show');
          const data =  JSON.parse($(elem).attr('data-detail'));
          _logic.modules[$(elem).attr('data-category')].fill_form(data, elem);
        },
        fill_form: (data, elem) => {
          $('select[name=vmpe_year]').val(data.vmpe_year); 
          $('input[name=vmpe_project_name]').val(data.vmpe_project_name); 
          $('input[name=vmpe_project_value]').val(data.vmpe_project_value);
          $('input[name=vmpe_contractor_name]').val(data.vmpe_contractor_name)
          $('input[name=vmpe_id]').val(data.vmpe_id);
          $('input[name=h_id4]').val(general.header.vmh_id);

          const bidang_pengalaman = JSON.parse(data.vmb_bidang_code);
          const sub_bidang_pengalaman = JSON.parse(data.vmb_sub_bidang_code);

          for (let index = 0; index < bidang_pengalaman.length; index++) {
            const bidang_code = bidang_pengalaman[index];
            const sub_bidang_code = sub_bidang_pengalaman[index];

            $(`.bidang_proyek[data-no=${index+1}]`).val(bidang_code)
            _ddl.sub_bidang(bidang_code, index+1, sub_bidang_code).then((result) => {
              if(index < bidang_pengalaman.length-1){
                const content = _template['bidang_pengalaman']
                $(`.bidang_pengalaman`).append(content)
              }
            }).catch((err) => {
              alert('Oops something went wrong')
            });
          }
        }
      },
      ahli_bidang_mandor: {
        edit: (elem) => {
          $(`#form-${$(elem).attr('data-category')}`)[0].reset();
          $(`#${$(elem).attr('data-category')}`).modal('show');
          const data =  JSON.parse($(elem).attr('data-detail'));
          _logic.modules[$(elem).attr('data-category')].fill_form(data);
        },
        fill_form: (data) => {
          $('input[name=vmtq_ahli_bidang]').val(data.vmtq_ahli_bidang); 
          $('input[name=vmtq_qty_ahli_bidang]').val(data.vmtq_qty_ahli_bidang);
          $('input[name=vmtq_id]').val(data.vmtq_id);
          $('input[name=h_id5]').val(general.header.vmh_id)
        }
      },
      peralatan: {
        edit: (elem) => {
          $(`#form-${$(elem).attr('data-category')}`)[0].reset();
          $(`#${$(elem).attr('data-category')}`).modal('show');
          const data =  JSON.parse($(elem).attr('data-detail'));
          _logic.modules[$(elem).attr('data-category')].fill_form(data);
        },
        fill_form: (data) => {
          $('input[name=vmt_tools_name]').val(data.vmt_tools_name); 
          $('input[name=vmt_tool_brand]').val(data.vmt_tool_brand);
          $('input[name=vmt_qty_tools]').val(data.vmt_qty_tools);
          $('input[name=vmt_condition]').val(data.vmt_condition);
          $('input[name=vmt_id]').val(data.vmt_id);
          $('input[name=h_id6]').val(general.header.vmh_id)
        }
      },
      bidang_pengalaman: {
        add: (elem) => {
          const content = _template[$(elem).attr('data-category')]
          $(`.bidang_pengalaman`).append(content)
        }
      }
    }
  }

  const _ddl = {
    sub_bidang: (bidang, data_no = null, value = null) => new Promise(async (resolve, reject) => {
      try {
        let dataNo = data_no
        const result = await $.ajax({
          url: "<?php echo site_url('vendor/get_sub_bidang') ?>",
          datatype: "json",
          type: "POST",
          data: {
            bidang_code: bidang,
            selected_sub_bidang: general.bidang_pengalaman.selected_sub_bidang_proyek
          }
        })
        const d = JSON.parse(result);
        let subBidang = d.data.map((v)=>{
          if(v.am_kode == value){
            return `<option selected value="${v.am_kode}">${v.am_name}</option>`;
          }else{
            return `<option value="${v.am_kode}">${v.am_name}</option>`;
          }
        })
        $(`.sub_bidang_proyek[data-no=${dataNo}]`).html("")
        $(`.sub_bidang_proyek[data-no=${dataNo}]`).append(subBidang)
        $(`.sub_bidang_proyek[data-no=${dataNo}]`).trigger('change')
        resolve(true)
      } catch (error) {
        console.error(error)
        reject(error)
      }
    })
  }
  const _template = {
    bidang_pengalaman: () => {
      general.bidang_pengalaman.no++;
      return `<div class="row">
            <div class="col-md-4">
              <label class="control-label">Bidang *</label>
              <select class="form-control m-b bidang_proyek" data-no="${general.bidang_pengalaman.no}" name="vmb_bidang_code_proyek[]" >
              <?php foreach ($bidang as $k => $v) { ?>
                <option value="<?php echo $v['am_kode'] ?>"><?php echo $v['am_name'] ?></option>
              <?php } ?>
            </select>
            </div>
            <div class="col-md-7">
              <label class="control-label">Sub Bidang *</label>
              <select class="form-control m-b sub_bidang_proyek" data-no="${general.bidang_pengalaman.no}" name="vmb_sub_bidang_code_proyek[]" >
              </select>
            </div>
          </div>`

    }
  }
</script>