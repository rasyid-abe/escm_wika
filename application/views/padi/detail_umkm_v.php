<div class="row match-height">
    <!-- Bordered Form Layout starts -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title float-left">Data UMKM</h4>                
                <?php if ($umkm['status_padi'] == 'Belum Diunggah') { ?>
                    <span class="badge badge-danger float-right">Belum Diunggah</span>
                <?php } else { ?>
                    <span class="badge badge-success float-right">Sudah Diunggah</span>
                <?php } ?>
            </div>
            <div class="card-content">
                <div class="card-body">
                <form class="form-bordered">
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Vendor ID</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['vendor_id'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-cpu"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Nama UMKM</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['nama_umkm'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">NIB</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['nib'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-minus-square"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Alamat</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['alamat'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-map"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Blok NO Kav</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['blok_no_kav'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-octagon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Kode Pos</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['kode_pos'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-minus-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Provinsi</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['provinsi'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-navigation-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Kota</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['kota'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-navigation-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">No Telp</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['no_telp'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-phone"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">No HP</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['hp'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-phone-call"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Email</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['email'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-send"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Kategori Usaha</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['kategori_usaha'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-hard-drive"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Jenis Kegiatan Usaha</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['jenis_kegiatan_usaha'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-archive"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">NPWP</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['npwp'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-tv"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Nama Bank</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['nama_bank'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-cloud"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Country Bank</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['country_bank'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-server"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">No Rekening</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['no_rekening'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-pocket"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Nama Pemilik Rekening</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['nama_pemilik_rekening'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-monitor"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Longitute</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['longitute'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-navigation"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Latitute</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['latitute'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-navigation"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Total Project</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['total_project'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-feather"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Total Revenue</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['total_revenue'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-crosshair"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Ontime Rate</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['ontime_rate'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-codepen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Badan Usaha</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['badan_usaha'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-battery"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row last mb-3">
                            <label class="col-md-3 label-control text-right">Average Rating</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $umkm['average_rating'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-box"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo site_url('padi/umkm')?>" class="btn btn-secondary"><i class="ft-arrow-left mr-1"></i>Kembali</a>
                            <?php if($umkm['status_padi'] == 'Belum Diunggah') { ?>
                                <a href="<?php echo site_url('padi/push_umkm/' . $umkm['id'])?>" class="btn btn-info" onclick="return confirm('Apakah Anda yakin upload umkm ini?');"><i class="ft-upload mr-1"></i>Push ke PaDi</a>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bordered Form Layout ends -->
</div>