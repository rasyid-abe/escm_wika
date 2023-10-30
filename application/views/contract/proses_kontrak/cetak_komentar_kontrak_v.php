<style type="text/css">
    .btn-action-edit {
        border-radius: 8px 0 0 8px;
        width: 100px;
    }

    .btn-action-delete {
        border-radius: 0 8px 8px 0;
        background-color: rgb(36 36 36 / 22%);
        position: relative;
        left: -4px;
    }

    .btn-tambah {
        border-radius: 8px;
    }

    .btn-export {
        background-color: transparent;
        border: none;
    }

    .save-comment {
        position: absolute;
        right: 20px;
    }

    .table-catatan td {
        padding: 10px !important;
    }

    .table-catatan th {
        padding: 10px !important;
    }

    html {
        font-family: sans-serif;
    }

    table {
        font-size: 10px;
    }

    td {
        padding: 5px;
    }

    th {
        padding: 5px;
        font-weight: bold;
        /*background-color: #b0ffc2;*/
    }

    p {
        font-size: 10px;
    }

    #table-content {
        font-size: 40%;
    }

    .is-content {
        border-collapse: collapse;
    }

    .is-content td {
        border: 1px solid black;
    }

    .is-content th {
        border: 1px solid black;
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="form-horizontal">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div class="row" id="form-comment">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom pb-2">
                        <h4 class="card-title float-left">Catatan</h4>
                        <div class="float-right">
                            suka : <b><?= $thumbs_up ?></b>
                            tidak suka : <b><?= $thumbs_down ?></b>
                            total catatan : <b><?= $comment ?></b>
                        </div>
                    </div>

                    <div class="card-body">
                        <br>
                        <div class="overflow-auto px-2">
                            <table class="table is-content table-catatan text-center">
                                <thead>
                                    <?php if ($com_num > 0) { ?>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Respon</th>
                                            <th scope="col">Objek Penilaian</th>
                                            <th scope="col">Lampiran</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Devisi</th>
                                            <th scope="col">No.Telp</th>
                                            <th scope="col">Tanggal & Waktu</th>
                                            <th scope="col">Komentar</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($komentar as $key => $val) {
                                    ?>
                                        <tr>
                                            <td><?php echo $key + 1 ?></td>
                                            <td>

                                                <?php
                                                $thumbs_up = '<i class="fa fa-thumbs-up fa-2x mr-1" style="color: #2aace3"></i>';
                                                $thumbs_down = '<i class="fa fa-thumbs-down fa-2x ml-1 mr-1" style="color: #ff7376"></i>';
                                                $comment = '<i class="fa fa-comment fa-2x ml-1 mr-1" style="color: #000"></i>';
                                                if ($val['cad_respon'] == 0) {
                                                    echo "Suka";
                                                } else if ($val['cad_respon'] == 1) {
                                                    echo "Tidak suka";
                                                } else {
                                                    echo "Komentar";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $val['cad_obj_nilai'] ?></td>
                                            <td>
                                                <a href="<?php echo site_url('log/download_attachment/contract/comment/' . $val['cad_lampiran']) ?>"><?= $val['cad_lampiran'] ?></a>
                                            </td>
                                            <td><?php echo $val['cad_user_name'] ?></td>
                                            <td><?php echo $val['cad_position'] ?></td>
                                            <td><?php echo $val['cad_divisi'] ?></td>
                                            <td><?php echo $val['cad_no_telp'] ?></td>
                                            <td><?php echo $val['cad_created_date'] ?></td>
                                            <td>
                                                <?php echo $val['cad_comment'] ?>
                                            </td>
                                        </tr>

                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="alert bg-light-secondary text-center text-bold-700" role="alert">Belum ada komentar.</div>
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