<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 20px;">
            <div class="card-header border-bottom pb-2">
                <div class="btn-group-sm float-left">
                    <span class="card-title text-bold-600 mr-2">Daftar Rencana Umum Pengadaan</span>
                    <span><a href="<?php echo site_url('perencanaan_pengadaan/pr_non_proyek_drup/pembuatan_drup'); ?>" class="btn btn-info btn-sm rounded"><i class="ft-plus"></i> Tambah</a></span>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                    <th rowspan="2" style="vertical-align: middle;">Kode COA</th>
                                    <th rowspan="2" style="vertical-align: middle;">Kode SDA</th>
                                    <th rowspan="2" style="vertical-align: middle;">Paket Pengadaan dan Program</th>
                                    <th colspan="2" class="text-center">Unit Kerja</th>
                                    <th colspan="2" class="text-center">Jenis Pengadaan</th>
                                    <th colspan="2" class="text-center">Pelaksanaan Pengadaan</th>
                                    <th colspan="2" class="text-center">Pelaksanaan Pekerjaan</th>
                                    <th colspan="2" class="text-center">Volume</th>
                                    <th colspan="2" class="text-center">Anggaran</th>
                                    <th rowspan="2" style="vertical-align: middle;">Catatan</th>
                                </tr>
                                <tr>
                                    <th>Pemilik Program</th>
                                    <th>Pengelola Anggaran</th>
                                    <th>Penyedia</th>
                                    <th>Swasekola</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Akhir</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Akhir</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $noabjd = 'A'; foreach ($drup_data as $value) { ?>
                                    <tr style="background-color: #f7f7f7">
                                        <td class="text-center text-bold-700 font-small-2"><?php echo $noabjd++; ?></td>
                                        <td class="text-center text-bold-700 font-small-2"><?php echo $value['kode_perkiraan'];?></td>
                                        <td colspan="16" class="text-left text-bold-700 font-small-2"><?php echo $value['nama_perkiraan'];?></td>
                                    </tr>
                                    <?php
                                        $no = 1;
                                        $sql = "
                                                SELECT * FROM prc_proses_drup ppd
                                                WHERE coa_id ='".$value["coa_id"]."'
                                            ";
                                        $detail = $this->db->query($sql)->result_array();
                                        foreach ($detail as $value_in) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++;?></td>
                                        <td class="text-center">&nbsp;</td>
                                        <td class="text-center"><?php echo $value_in['kode_sumber_daya'];?></td>
                                        <td><?php echo $value_in['nama_program'];?></td>
                                        <td><?php echo $value_in['pemilik_program'];?></td>
                                        <td><?php echo $value_in['pengelola_anggaran'];?></td>
                                        <td class="text-center"><?php echo $value_in['penyedia'];?></td>
                                        <td class="text-center"><?php echo $value_in['swakelola'];?></td>
                                        <td class="text-center"><?php echo $value_in['tgl_mulai_pengadaan'];?></td>
                                        <td class="text-center"><?php echo $value_in['tgl_akhir_pengadaan'];?></td>
                                        <td class="text-center"><?php echo $value_in['tgl_mulai_pekerjaan'];?></td>
                                        <td class="text-center"><?php echo $value_in['tgl_akhir_pekerjaan'];?></td>
                                        <td class="text-center"><?php echo $value_in['volume'];?></td>
                                        <td class="text-center"><?php echo $value_in['satuan'];?></td>
                                        <td class="text-center"><?php echo number_format($value_in['harga_satuan']);?></td>
                                        <td class="text-center"><?php echo number_format($value_in['volume'] * $value_in['harga_satuan']);?></td>
                                        <td><?php echo $value_in['catatan'];?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>

                            <tfoot>
                                <tr style="background-color: #f7f7f7">
                                    <td colspan="14">&nbsp;</td>
                                    <td class="text-center text-bold-700">TOTAL</td>
                                    <td class="text-right text-bold-700"><?php echo number_format($total_data['total']);?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
