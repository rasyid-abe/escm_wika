<div class="wrapper wrapper-content animated fadeIn">
    <div class="row m-t-lg">
        <div class="col-lg-12">
            <div class="tabs-container">

                <div class="tabs-left">
                    <div class="section-tab">
                        <a class="badge badge-secondary mt-1 active" data-toggle="tab" href="#tab-1"><?php echo $this->lang->line('Data Utama'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-2"><?php echo $this->lang->line('Data Legal'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-3"><?php echo $this->lang->line('Pengurus Perusahaan'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-4"><?php echo $this->lang->line('Data Keuangan'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-5"><?php echo $this->lang->line('Barang/Jasa'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-6"><?php echo $this->lang->line('SDM'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-7"><?php echo $this->lang->line('Sertifikasi'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-8"><?php echo $this->lang->line('Fasilitas/Peralatan'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-9"><?php echo $this->lang->line('Pengalaman Proyek'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-10"><?php echo $this->lang->line('Data Tambahan'); ?></a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-11">Data Dokumen</a>
                        <a class="badge badge-secondary mt-1" data-toggle="tab" href="#tab-13">CQSMS</a>
                    </div>

                    <div class="tab-content ">		
                        <?php if($hasSubmitHse == false) : ?>
                            <div id="tab-13" class="tab-pane">
                                <div class="panel-body">
                                    <div class="panel panel-info">
                                        <div style="padding: 15px;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php if($hasHse) : ?>
                                                        <div class="error-template" style="padding: 40px 15px;text-align: center">
                                                            <img src="<?php echo base_url('assets'); ?>/app-assets/img/maintenance.png" alt="" class="img-fluid maintenance-img mt-2" height="300" width="300">
                                                            <h1 class="mt-4">CQSMS sudah terkirim !</h1>
                                                            <div class="maintenance-text w-75 mx-auto mt-4">														
                                                            </div>																				
                                                        </div>														
                                                    <?php else : ?>
                                                        <div class="error-template" style="padding: 40px 15px;text-align: center">
                                                            <h1>Oops!</h1>
                                                            <h2 id="ecat-error-title">Silahkan Isi Dokumen <a href="<?= site_url()."/hse" ?>">CQSMS</a></h2>				
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($hasSubmitHse) : ?>
                            <div id="tab-13" class="tab-pane">
                                <div class="panel-body">
                                    <div class="panel panel-info">										
                                        <div style="padding: 15px;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php if(count($hseData) > 0 ) : ?>
                                                        <div class="tab-pane" id="verifikasi_hse" role="tabpanel" aria-labelledby="verifikasi_hse-tab">
                                                            
                                                            <?php if($hseData['header']['cqsms_type'] == 1) : ?>
                                                                <form id="formHse" action="<?= base_url() ?>Hse/post_hse_certificate" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" id="hseType" name="hseType" value="0">
                                                                <input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">
                                                                <input type="hidden" id="trx_h_id" name="trx_h_id" value="<?= $hseData['header']['id'] ?>">
                                                                <input type="hidden" id="hseStatus" name="hseStatus" value="">
                                                                <input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">

                                                                <div class="form-group row">
                                                                    <div class="col-md-9">
                                                                        <div class="form-group mb-2">
                                                                            <label style="font-weight: bold;">SCORE</label>
                                                                            <input type="number" readonly id="cqsms_score" class="form-control" value="<?= $hseData['header']['cqsms_total_score'] ?>" name="cqsms_score" required placeholder="Score">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-2">
                                                                        <label style="font-weight: bold;">Lampiran</label>
                                                                        <a href="<?= base_url() ?>attachment/vendor/CQSMS_<?= $hseData['header']['vendor_id'] ?>/<?= $hseData['detail'][0]['sertifikat'] ?>" target="_blank" class="form-control" >Unduh Lampiran</a>
                                                                    </div>
                                                                </div>

                                                                <?php if($hseData['header']['cqsms_status'] == 1) : ?>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-2">
                                                                        <label style="font-weight: bold;">Status</label>
                                                                        <a target="_blank" class="form-control btn btn-info" >VERIFIED</a>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>

                                                                <?php if($hseData['header']['cqsms_status'] == 2) : ?>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-2">
                                                                        <label style="font-weight: bold;">Status</label>
                                                                        <a target="_blank" class="form-control btn btn-info" >REVISI</a>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>

                                                                <?php if($hseData['header']['cqsms_status'] == NULL) : ?>
                                                                    <button type="submit" class="btn btn-primary mr-2" onclick="return confirm('Apakah Anda yakin simpan data ini?')" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Verifikasi</button>
                                                                <?php endif; ?>	

                                                                <?php if($hseData['header']['cqsms_status'] == 2) : ?>
                                                                    <button type="button" class="btn btn-primary mr-2" onclick="submitHse(1)" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Verifikasi</button>
                                                                <?php endif; ?>
                                                                    
                                                            <?php endif; ?>
                                                            
                                                            <?php if($hseData['header']['cqsms_type'] == 0) : ?>
                                                                <form id="formHse" action="<?= base_url() ?>Hse/post_score" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" id="hseType" name="hseType" value="0">
                                                                <input type="hidden" id="vendor_id" name="vendor_id" value="<?= $vendor_id ?>">
                                                                <input type="hidden" id="trx_h_id" name="trx_h_id" value="<?= $hseData['header']['id'] ?>">
                                                                <div class="form-group row">
                                                                    <?php if($hseData['header']['cqsms_status'] == 1) : ?>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group mb-2">
                                                                            <label style="font-weight: bold;">Status</label>
                                                                            <a target="_blank" class="form-control btn btn-info" >VERIFIED (<?= $vendor_verifikasi[0]['status_hse'] ?>)</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group mb-2">
                                                                            <label style="font-weight: bold;">Nilai</label>
                                                                            <a target="_blank" class="form-control btn btn-warning" ><?= number_format($vendor_score['score']['score'],2)  ?></a>
                                                                        </div>
                                                                    </div>
                                                                    <?php endif; ?>

                                                                    <?php if($hseData['header']['cqsms_status'] == 2) : ?>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group mb-2">
                                                                            <label style="font-weight: bold;">Status</label>
                                                                            <a target="_blank" class="form-control btn btn-info" >REVISI</a>
                                                                        </div>
                                                                    </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <?php $i = 0; $katNo =1; ?>
                                                                <?php foreach ($hse_cat as $key => $v) : ?>
                                                                    <div class="panel-heading card-header p-2">
                                                                    <h5 align="center"><?= $katNo.'. ' ?><?= $v['kategori_name'].' '.$v['persentase']. '%' ?></h5>
                                                                    </div>
                                                                <hr>
                                                                <div class="form-group row">
                                                                    <?php $no = 1; foreach ($hseQuestionList as $question) :?>
                                                                    <?php if ($question['kategori_id'] == $v['id']) :?>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label style="font-weight: bold;"><?= $katNo.'.'.$no ?><?= $question['pertanyaan'] ?></label>
                                                                            <!-- jawaban -->
                                                                            <div class="col-md-9">
                                                                                <?php if((int)$question['is_template'] != 1) : ?>
                                                                                <?php foreach ($question['jawaban'] as $answer) :?>
                                                                                <div class="form-check form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input disabled <?php if(isset($hseData['detail'][$question['id']]['jawaban_id'])) { ?> <?php if($answer['id'] == $hseData['detail'][$question['id']]['jawaban_id'] ) echo "checked" ?>  <?php } ?>  class="form-check-input" type="radio" name="pertanyaan_[<?= $question['id']; ?>]" id="jawaban_<?= $answer['id'] ?>" value="<?= $question['id'] ?>_<?= $answer['id'] ?>_<?= $answer['score'] ?>"> <?= $answer['jawaban'] ?>
                                                                                    </label>
                                                                                </div>
                                                                                <?php endforeach; ?>
                                                                                <?php  else : ?>
                                                                                    <table class="table border">
                                                                                        <thead>
                                                                                        <th>Tahun</th>
                                                                                        <th>Klasifikasi</th>
                                                                                        <th>Jumlah</th>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            
                                                                                            <?php $rs = 1; foreach ($catatanKecelakaan as $key => $value) : ?>
                                                                                            <tr>
                                                                                                <td> <?php if($rs == 1 || $rs == 7 || $rs == 13) { ?>  <input type="text" readonly class="form-control" value="<?= $value['tahun'] ?>" name=""> <?php } ?></td>
                                                                                                <td> <?= $value['klasifikasi'] ?></td>
                                                                                                <td><input type="text" readonly class="form-control"value="<?= $value['jawaban'] ?>"></td>

                                                                                            </tr>
                                                                                            <?php $rs++; endforeach; ?>
                                                                                            
                                                                                        </tbody>
                                                                                    </table>
                                                                                <?php  endif; ?>
                                                                                <div class="form-check form-check-inline">
                                                                        
                                                                                    <label class="form-check-label">
                                                                                    <input type="text" readonly style="width: 300px;" value="<?=$hseData['detail'][$question['id']]['notes'] ?>" class="form-control" placeholder="Deskripsi"></input>
                                                                                    </label>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>											
                                                                    </div>	

                                                                    <div class="col-md-2">
                                                                        <label style="font-weight: bold;">Score</label>
                                                                        <select disabled name="score[<?= $hseData['detail'][$question['id']]['trx_h_detail_id'] ?>]"  required  class="form-control" >
                                                                            <option value=""></option>
                                                                            <?php foreach ($question['petunjuk_score'] as $key => $value) : ?>
                                                                                <option <?php if($hseData['detail'][$question['id']]['answer_score'] == $value['bobot_petunjuk'] ) echo "selected"; ?> value="<?= $value['bobot_petunjuk'] ?>"><?= $value['bobot_petunjuk'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label class="form-check-label" style="margin-top: 19px;">
                                                                            <button type="button" class="button" data-toggle="tooltip" data-placement="right" data-html="true"  title="<?php foreach ($question['petunjuk_score'] as $key => $value) {echo "<p>Nilai <b>".$value['bobot_petunjuk']."</b> = ".$value['deskripsi']."</p>"; } ?>">Petunjuk Score</button>
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="form-group mb-2">
                                                                            <label style="font-weight: bold;">Lampiran</label>
                                                                            <?php if($hseData['detail'][$question['id']]['sertifikat'] != "-") {?>
                                                                            <a href="<?php if(isset($hseData['detail'][$question['id']]['sertifikat'])){ ?><?php if($hseData['detail'][$question['id']]['sertifikat'] != "-") {?> <?= base_url() ?>attachment/vendor/CQSMS_<?= $hseData['header']['vendor_id'] ?>/<?= $hseData['detail'][$question['id']]['sertifikat'] ?> <?php }else {echo"#";}?> <?php } ?>" <?php if($hseData['detail'][$question['id']]['sertifikat'] != "-") {?> target="_blank" <?php } ?> class="form-control" >Unduh Lampiran</a>
                                                                            <?php } else {?>
                                                                                <a target="_blank" class="form-control" >Unduh Lampiran</a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php $i++; $no++;  ?>
                                                                    <?php endif; ?>
                                                                    <?php endforeach; ?>															
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-12">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <th>SubTotal <?= $v['kategori_name']; ?></th>
                                                                                <th>Persentase</th>
                                                                                <th>Nilai</th>

                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($vendor_score['sub_score_category'] as $key => $value) : ?>
                                                                                <?php if($value['kategori_id'] == $v['id']) : ?>
                                                                                <tr>
                                                                                    <td><?= number_format($value['sub_total'],2); ?></td>
                                                                                    <td><?= number_format($value['persentase']) ?>%</td>
                                                                                    <td><?= number_format($value['score'],2) ?></td>
                                                                                </tr>
                                                                                <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <?php $katNo++; ?>
                                                                <?php endforeach; ?>

                                                                    <?php if($hseData['header']['cqsms_status'] == 0 || $hseData['header']['cqsms_status'] == null) : ?>
                                                                        <button type="submit" class="btn btn-primary mr-2" onclick="return confirm('Apakah Anda yakin simpan data ini?')" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Submit</button>
                                                                    <?php endif; ?>	

                                                                    <?php if($hseData['header']['cqsms_status'] == 2) : ?>
                                                                        <button type="button" class="btn btn-primary mr-2" onclick="submitHse(1)" id="btnHseVerifikasi" name="btnHse" value="verifikasi"><i class="ft-check-square mr-1"></i>Verifikasi</button>
                                                                    <?php endif; ?>									
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>				
                        <div id="tab-1" class="tab-pane active">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1 font-medium-1"><?php echo $this->lang->line('Nama Perusahaan'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Prefiks'); ?></th>
                                                <td><?php echo $header[0]['prefix']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Prefiks Lainnya'); ?></th>
                                                <td><?php echo $header[0]['prefixOther']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Nama Perusahaan'); ?></th>
                                                <td><?php echo $header[0]['vendorName']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Sufiks'); ?></th>
                                                <td><?php echo $header[0]['suffix']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Sufiks Lainnya'); ?></th>
                                                <td><?php echo $header[0]['suffixOther']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Tipe Perusahaan'); ?></th>
                                                <td>
                                                    <ol>
                                                        <?php foreach ($tipe as $row) {
                                                            echo "<li>" . $row['id']['companyType'] . "</li>" ?>

                                                        <?php } ?>
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Email Registrasi'); ?></th>
                                                <td><?php echo $header[0]['emailAddress']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Kontak Perusahaan'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th><?php echo $this->lang->line('Jenis'); ?></th>
                                                        <th><?php echo $this->lang->line('Alamat'); ?></th>
                                                        <th><?php echo $this->lang->line('Kota'); ?></th>
                                                        <th><?php echo $this->lang->line('Negara'); ?></th>
                                                        <th><?php echo $this->lang->line('Telp Kantor-1'); ?></th>
                                                        <th><?php echo $this->lang->line('Telp Kantor-2'); ?></th>
                                                        <th><?php echo $this->lang->line('Fax'); ?></th>
                                                        <th><?php echo $this->lang->line('Website'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($alamat as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row["type"] ?></td>
                                                            <td><?php echo $row["address"] ?></td>
                                                            <td><?php echo $row["city"] ?></td>
                                                            <td><?php echo $row["country"] ?></td>
                                                            <td><?php echo $row["telephone1No"] ?></td>
                                                            <td><?php echo $row["telephone2No"] ?></td>
                                                            <td><?php echo $row["fax"] ?></td>
                                                            <td><?php echo $row["website"] ?></td>
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
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Kontak Person'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Nama'); ?></th>
                                                <td><?php echo $header[0]['contactName']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Jabatan'); ?></th>
                                                <td><?php echo $header[0]['contactPos']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Nomor Telepon'); ?></th>
                                                <td><?php echo $header[0]['contactPhoneNo']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Alamat Email'); ?></th>
                                                <td><?php echo $header[0]['contactEmail']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Akta Pendirian'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No Akta'); ?></th>
                                                        <th><?php echo $this->lang->line('Jenis Akta'); ?></th>
                                                        <th><?php echo $this->lang->line('Tanggal Pembuatan'); ?></th>
                                                        <th><?php echo $this->lang->line('Notaris'); ?></th>
                                                        <th><?php echo $this->lang->line('Alamat'); ?></th>
                                                        <th><?php echo $this->lang->line('Pengesahan Kehakiman'); ?></th>
                                                        <th><?php echo $this->lang->line('Berita Negara'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($akta as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $row["aktaNo"] ?></td>
                                                            <td><?php echo $row["aktaType"] ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["dateCreation"]['time'])); ?></td>
                                                            <td><?php echo $row["notarisName"] ?></td>
                                                            <td><?php echo $row["notarisAddress"] ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["pengesahanHakim"]['time'])); ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["beritaAcaraNgr"]['time'])); ?></td>
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
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Domisili Perusahaan'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Nomor Domisili'); ?></th>
                                                <td><?php echo $header[0]['addressDomisiliNo']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Tanggal Domisili'); ?></th>
                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['addressDomisiliDate']['time'])); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Kadaluarsa'); ?></th>
                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['addressDomisiliExpDate']['time'])) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Alamat Perusahaan'); ?></th>
                                                <td><?php echo $header[0]['addressStreet']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Kota'); ?></th>
                                                <td><?php echo $header[0]['addressCity']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Provinsi'); ?></th>
                                                <td><?php echo $header[0]['addresProp']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Kode Pos'); ?></th>
                                                <td><?php echo $header[0]['addressPostcode']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Negara'); ?></th>
                                                <td><?php echo $header[0]['addressCountry']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Nomor Telepon'); ?></th>
                                                <td><?php echo $header[0]['addressPhoneNo']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Nilai Pokok Wajib Pajak (NPWP)'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Nomor'); ?></th>
                                                <td><?php echo $header[0]['npwpNo']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Alamat (Sesuai NPWP)'); ?></th>
                                                <td><?php echo $header[0]['npwpAddress']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Kota'); ?></th>
                                                <td><?php echo $header[0]['npwpCity']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Provinsi'); ?></th>
                                                <td><?php echo $header[0]['npwpProp']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Kode Pos'); ?></th>
                                                <td><?php echo $header[0]['npwpPostcode']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('PKP'); ?></th>
                                                <td><?php echo $header[0]['npwpPkp']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Nomor PKP'); ?></th>
                                                <td><?php echo $header[0]['npwpPkpNo']; ?></td>
                                            </tr>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Jenis Mitra Kerja'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Mitra Kerja'); ?></th>
                                                <td><?php echo $header[0]['vendorType']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Surat Izin Usaha Perusahaan (SIUP)'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>			
                                                <th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
                                                <td><?php echo $header[0]['siupIssuedBy']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Nomor'); ?></th>
                                                <td><?php echo $header[0]['siupNo']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Jenis SIUP'); ?></th>
                                                <td><?php echo $header[0]['siupType']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['siupFrom']['time'])) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['siupTo']['time'])) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Izin Lain Lain'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Jenis Izin'); ?></th>
                                                        <th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
                                                        <th><?php echo $this->lang->line('Nomor'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($izin_lain as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $row["type"] ?></td>
                                                            <td><?php echo $row["issuedBy"] ?></td>
                                                            <td><?php echo $row["no"] ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["startDate"]["time"])) ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["endDate"]["time"])) ?></td>
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
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Tanda Daftar Perusahaan (TDP)'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
                                                <td><?php echo $header[0]['tdpIssuedBy']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Nomor'); ?></th>
                                                <td><?php echo $header[0]['tdpNo']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['tdpFrom']['time'])) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['tdpTo']['time'])) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Surat Keagenan/Distributorship'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
                                                        <th><?php echo $this->lang->line('Nomor'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($agent_importir as $row) {
                                                        if ($row["type"] == "AGENT") { ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $row["issuedBy"] ?></td>
                                                                <td><?php echo $row["no"] ?></td>
                                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["createdDate"])) ?></td>
                                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["expiredDate"])) ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Angka Pengenal Importir'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
                                                        <th><?php echo $this->lang->line('Nomor'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($agent_importir as $row) {
                                                        if ($row["type"] == "IMPORTIR") { ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $row["issuedBy"] ?></td>
                                                                <td><?php echo $row["no"] ?></td>
                                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["createdDate"])) ?></td>
                                                                <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["expiredDate"])) ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Dewan Komisaris'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama'); ?></th>
                                                        <th><?php echo $this->lang->line('Jabatan'); ?></th>
                                                        <th><?php echo $this->lang->line('Telepon'); ?></th>
                                                        <th><?php echo $this->lang->line('Email'); ?></th>
                                                        <th><?php echo $this->lang->line('KTP'); ?></th>
                                                        <th><?php echo $this->lang->line('NPWP'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($board as $row) {
                                                        if ($row["type"] == "BOC") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["name"] ?></td>
                                                                <td><?php echo $row["pos"]; ?></td>
                                                                <td><?php echo $row["telephoneNo"] ?></td>
                                                                <td><?php echo $row["emailAddress"] ?></td>
                                                                <td><?php echo $row["ktpNo"] ?></td>
                                                                <td><?php echo $row["npwpNo"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Dewan Direksi'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama'); ?></th>
                                                        <th><?php echo $this->lang->line('Jabatan'); ?></th>
                                                        <th><?php echo $this->lang->line('Telepon'); ?></th>
                                                        <th><?php echo $this->lang->line('Email'); ?></th>
                                                        <th><?php echo $this->lang->line('KTP'); ?></th>
                                                        <th><?php echo $this->lang->line('NPWP'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($board as $row) {
                                                        if ($row["type"] == "BOD") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["name"] ?></td>
                                                                <td><?php echo $row["pos"]; ?></td>
                                                                <td><?php echo $row["telephoneNo"] ?></td>
                                                                <td><?php echo $row["emailAddress"] ?></td>
                                                                <td><?php echo $row["ktpNo"] ?></td>
                                                                <td><?php echo $row["npwpNo"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
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
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Rekening Bank'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('No.Rekening'); ?></th>
                                                        <th><?php echo $this->lang->line('Pemegang Rekening'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama Bank'); ?></th>
                                                        <th><?php echo $this->lang->line('Cabang Bank'); ?></th>
                                                        <th><?php echo $this->lang->line('Alamat'); ?></th>
                                                        <th><?php echo $this->lang->line('Valuta'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($bank as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row["accountNo"] ?></td>
                                                            <td><?php echo $row["accountName"]; ?></td>
                                                            <td><?php echo $row["bankName"] ?></td>
                                                            <td><?php echo $row["bankBranch"] ?></td>
                                                            <td><?php echo $row["address"] ?></td>
                                                            <td><?php echo $row["currency"] ?></td>
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
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Modal Sesuai Data Terakhir'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Modal Dasar'); ?></th>
                                                <td><?php echo $this->umum->cetakuang($header[0]['finAktaMdlDsr'], $header[0]['finAktaMdlDsrCurr']); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('Modal Setor'); ?></th>
                                                <td><?php echo $this->umum->cetakuang($header[0]['finAktaMdlStr'], $header[0]['finAktaMdlStrCurr']); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Informasi Laporan Keuangan'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Tahun Laporan'); ?></th>
                                                        <th><?php echo $this->lang->line('Jenis Laporan'); ?></th>
                                                        <th><?php echo $this->lang->line('Total Nilai Aset'); ?></th>
                                                        <th><?php echo $this->lang->line('Hutang Perusahaan'); ?></th>
                                                        <th><?php echo $this->lang->line('Pendapatan Kotor'); ?></th>
                                                        <th><?php echo $this->lang->line('Laba Bersih'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($financial as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $row["finRptYear"]; ?></td>
                                                            <td><?php echo $row["finRptType"]; ?></td>
                                                            <td><?php echo $this->umum->cetakuang($row["finRptAssetValue"], $row["finRptCurrency"]) ?></td>
                                                            <td><?php echo $this->umum->cetakuang($row["finRptHutang"], $row["finRptCurrency"]) ?></td>
                                                            <td><?php echo $this->umum->cetakuang($row["finRptRevenue"], $row["finRptCurrency"]) ?></td>
                                                            <td><?php echo $this->umum->cetakuang($row["finRptNetincome"], $row["finRptCurrency"]) ?></td>
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
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Klasifikasi Perusahaan'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <th><?php echo $this->lang->line('Klasifikasi Perusahaan'); ?></th>
                                                <td><?php if ($header[0]['finClass'] == "3") {
                                                        echo "BESAR";
                                                    } else if ($header[0]['finClass'] == "2") {
                                                        echo "MENENGAH";
                                                    } else if ($header[0]['finClass'] == "1") {
                                                        echo "KECIL";
                                                    } ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-5" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Barang yang Bisa Dipasok'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Jenis Komoditas'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama Barang'); ?></th>
                                                        <th><?php echo $this->lang->line('Merk'); ?></th>
                                                        <th><?php echo $this->lang->line('Sumber'); ?></th>
                                                        <th><?php echo $this->lang->line('Tipe'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($barang as $row) {
                                                        if ($row["catalog_type"] == "M") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["product_description"]; ?></td>
                                                                <td><?php echo $row["product_name"] ?></td>
                                                                <td><?php echo $row["brand"] ?></td>
                                                                <td><?php echo $row["source"] ?></td>
                                                                <td><?php echo $row["type"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Jasa yang Bisa Dipasok'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Jenis Komoditas'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama Barang'); ?></th>
                                                        <th><?php echo $this->lang->line('Merk'); ?></th>
                                                        <th><?php echo $this->lang->line('Sumber'); ?></th>
                                                        <th><?php echo $this->lang->line('Tipe'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($barang as $row) {
                                                        if ($row["catalog_type"] == "S") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["product_description"]; ?></td>
                                                                <td><?php echo $row["product_name"] ?></td>
                                                                <td><?php echo $row["brand"] ?></td>
                                                                <td><?php echo $row["source"] ?></td>
                                                                <td><?php echo $row["type"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-6" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Tenaga Ahli Utama'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama'); ?></th>
                                                        <th><?php echo $this->lang->line('Pendidikan Terakhir'); ?></th>
                                                        <th><?php echo $this->lang->line('Pengalaman'); ?></th>
                                                        <th><?php echo $this->lang->line('Status'); ?></th>
                                                        <th><?php echo $this->lang->line('Kewarganegaraan'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($sdm as $row) {
                                                        if ($row["type"] == "PRIMER") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["name"]; ?></td>
                                                                <td><?php echo $row["lastEducation"] ?></td>
                                                                <td><?php echo $row["yearExp"] ?></td>
                                                                <td><?php echo $row["empStatus"] ?></td>
                                                                <td><?php echo $row["empType"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Tenaga Ahli Pendukung'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama'); ?></th>
                                                        <th><?php echo $this->lang->line('Pendidikan Terakhir'); ?></th>
                                                        <th><?php echo $this->lang->line('Pengalaman'); ?></th>
                                                        <th><?php echo $this->lang->line('Status'); ?></th>
                                                        <th><?php echo $this->lang->line('Kewarganegaraan'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($sdm as $row) {
                                                        if ($row["type"] == "SUPPORT") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["name"]; ?></td>
                                                                <td><?php echo $row["lastEducation"] ?></td>
                                                                <td><?php echo $row["yearExp"] ?></td>
                                                                <td><?php echo $row["empStatus"] ?></td>
                                                                <td><?php echo $row["empType"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-7" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Keterangan Sertifikasi'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Jenis'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama Sertifikat'); ?></th>
                                                        <th><?php echo $this->lang->line('Nomor Sertifikat'); ?></th>
                                                        <th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
                                                        <th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($sertifikasi as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row["type"]; ?></td>
                                                            <td><?php echo $row["certName"] ?></td>
                                                            <td><?php echo $row["certNo"] ?></td>
                                                            <td><?php echo $row["issuedBy"] ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["validFrom"]["time"])) ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["validTo"]["time"])) ?></td>
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
                        <div id="tab-8" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Keterangan Fasilitas/Peralatan'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Kategori'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama Peralatan'); ?></th>
                                                        <th><?php echo $this->lang->line('Spesifikasi'); ?></th>
                                                        <th><?php echo $this->lang->line('Kuantitas'); ?></th>
                                                        <th><?php echo $this->lang->line('Tahun Pembuatan'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($fasilitas as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row["category"]; ?></td>
                                                            <td><?php echo $row["equipName"] ?></td>
                                                            <td><?php echo $row["spec"] ?></td>
                                                            <td><?php echo $row["yearMade"] ?></td>
                                                            <td><?php echo $row["quantity"] ?></td>
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
                        <div id="tab-9" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Pengalaman Pekerjaan'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama Pelanggan'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama Proyek'); ?></th>
                                                        <th><?php echo $this->lang->line('Keterangan Proyek'); ?></th>
                                                        <th><?php echo $this->lang->line('Nilai'); ?></th>
                                                        <th><?php echo $this->lang->line('Nomor Kontrak'); ?></th>
                                                        <th><?php echo $this->lang->line('Tanggal Dimulai'); ?></th>
                                                        <th><?php echo $this->lang->line('Tanggal Selesai'); ?></th>
                                                        <th>Contact Person</th>
                                                        <th><?php echo $this->lang->line('No Kontak'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($pengalaman as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row["clientName"]; ?></td>
                                                            <td><?php echo $row["projectName"] ?></td>
                                                            <td><?php echo $row["description"] ?></td>
                                                            <td><?php echo $this->umum->cetakuang($row["amount"], $row["currency"]) ?></td>
                                                            <td><?php echo $row["contractNo"] ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["startDate"]["time"])) ?></td>
                                                            <td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["endDate"]["time"])) ?></td>
                                                            <td><?php echo $row["contactPerson"] ?></td>
                                                            <td><?php echo $row["contactNo"] ?></td>
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
                        <div id="tab-10" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Prinsipal'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama'); ?></th>
                                                        <th><?php echo $this->lang->line('Alamat'); ?></th>
                                                        <th><?php echo $this->lang->line('Kota'); ?></th>
                                                        <th><?php echo $this->lang->line('Negara'); ?></th>
                                                        <th><?php echo $this->lang->line('Kode Pos'); ?></th>
                                                        <th><?php echo $this->lang->line('Kualifikasi'); ?></th>
                                                        <th><?php echo $this->lang->line('Hubungan'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($tambahan as $row) {
                                                        if ($row["type"] == "PRINCIPAL") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["name"]; ?></td>
                                                                <td><?php echo $row["address"] ?></td>
                                                                <td><?php echo $row["city"] ?></td>
                                                                <td><?php echo $row["country"] ?></td>
                                                                <td><?php echo $row["postCode"] ?></td>
                                                                <td><?php echo $row["qualification"] ?></td>
                                                                <td><?php echo $row["relationship"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Afiliasi'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama'); ?></th>
                                                        <th><?php echo $this->lang->line('Alamat'); ?></th>
                                                        <th><?php echo $this->lang->line('Kota'); ?></th>
                                                        <th><?php echo $this->lang->line('Negara'); ?></th>
                                                        <th><?php echo $this->lang->line('Kode Pos'); ?></th>
                                                        <th><?php echo $this->lang->line('Kualifikasi'); ?></th>
                                                        <th><?php echo $this->lang->line('Hubungan'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($tambahan as $row) {
                                                        if ($row["type"] == "AFFILIATE") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["name"]; ?></td>
                                                                <td><?php echo $row["address"] ?></td>
                                                                <td><?php echo $row["city"] ?></td>
                                                                <td><?php echo $row["country"] ?></td>
                                                                <td><?php echo $row["postCode"] ?></td>
                                                                <td><?php echo $row["qualification"] ?></td>
                                                                <td><?php echo $row["relationship"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1"><?php echo $this->lang->line('Subkontraktor'); ?></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('No'); ?></th>
                                                        <th><?php echo $this->lang->line('Nama'); ?></th>
                                                        <th><?php echo $this->lang->line('Alamat'); ?></th>
                                                        <th><?php echo $this->lang->line('Kota'); ?></th>
                                                        <th><?php echo $this->lang->line('Negara'); ?></th>
                                                        <th><?php echo $this->lang->line('Kode Pos'); ?></th>
                                                        <th><?php echo $this->lang->line('Kualifikasi'); ?></th>
                                                        <th><?php echo $this->lang->line('Hubungan'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($tambahan as $row) {
                                                        if ($row["type"] == "SUBCONTRACTOR") { ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td><?php echo $row["name"]; ?></td>
                                                                <td><?php echo $row["address"] ?></td>
                                                                <td><?php echo $row["city"] ?></td>
                                                                <td><?php echo $row["country"] ?></td>
                                                                <td><?php echo $row["postCode"] ?></td>
                                                                <td><?php echo $row["qualification"] ?></td>
                                                                <td><?php echo $row["relationship"] ?></td>
                                                            </tr>
                                                    <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-11" class="tab-pane">
                            <div class="card">
                                <div class="card-header border-bottom pb-2">
                                    <h4 class="card-title text-uppercase text-bold-700 font-medium-1">Dokumen</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; foreach ($dokumen as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row["vndSuppdocDesc"]; ?></td>
                                                            <td><a href="<?php echo $url_doc . "/" . $row["vndSuppdocFilename"] ?>" target="_blank"><?php echo $row["vndSuppdocFilename"] ?></a></td>
                                                        </tr>
                                                    <?php $i++; } ?>
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
        </div>
    </div>
</div>