<div class="row match-height">
    <!-- Bordered Form Layout starts -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title float-left">Data Transaksi</h4>                
                <?php if ($transaksi['status_padi'] == 'Belum Diunggah') { ?>
                    <span class="badge badge-danger float-right">Belum Diunggah</span>
                <?php } else { ?>
                    <span class="badge badge-success float-right">Sudah Diunggah</span>
                <?php } ?>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form-bordered">
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Transaksi ID</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['transaksi_id'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-cpu"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">BUMN ID</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['bumn_id'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-briefcase"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Tanggal Transaksi</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['tanggal_transaksi'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Nama Project</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['nama_project'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Nama Kategori</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['category_name'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Total Nilai Project</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo number_format($transaksi['total_nilai_project']);?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Tipe Nilai Project</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['tipe_nilai_project'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Kategori UMKM</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['kategori_umkm'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">ID / Nama UMKM</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['uid_umkm'] . ' / ' . $transaksi['nama_umkm'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Target Penyelesaian</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['target_penyelesaian'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Tanggal Order Placement</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['tanggal_order_placement'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Tanggal Confirmation</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['tanggal_confirmation'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Tanggal Delivery</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['tanggal_delivery'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Tanggal Invoice</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['tannggal_invoice'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Total Cycle Time</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['total_cycle_time'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Kategori Delivery Time</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['kategori_delivery_time'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Rating</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['rating'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Feedback</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <textarea rows="4" class="form-control"><?php echo $transaksi['feedback'];?></textarea>
                                    <div class="form-control-position">
                                        <i class="ft-file"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Satker ID</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['id_satker'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Is_PDN</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['is_pdn'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">TKDN</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['tkdn'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Is_Certificate</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['is_certificate'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">Certificate Tkdn</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" value="<?php echo $transaksi['certificate_tkdn'];?>">
                                    <div class="form-control-position">
                                        <i class="ft-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row last mb-3">
                            <label class="col-md-3 label-control text-right">Deskripsi Project</label>
                            <div class="col-md-9">
                                <div class="position-relative has-icon-left">
                                    <textarea rows="4" class="form-control"><?php echo $transaksi['deskripsi_project'];?></textarea>
                                    <div class="form-control-position">
                                        <i class="ft-file"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo site_url('padi/transaksi')?>" class="btn btn-secondary"><i class="ft-arrow-left mr-1"></i>Kembali</a>
                            <?php if($transaksi['status_padi'] == 'Belum Diunggah') { ?>
                                <a href="<?php echo site_url('padi/push_transaksi/' . $transaksi['id'])?>" class="btn btn-info" onclick="return confirm('Apakah Anda yakin upload transaksi ini?');"><i class="ft-upload mr-1"></i>Push ke PaDi</a>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bordered Form Layout ends -->
</div>