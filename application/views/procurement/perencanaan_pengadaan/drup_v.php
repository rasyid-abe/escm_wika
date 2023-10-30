<!-- <div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">
            <div class="card" style="border-radius: 30px;">
              <div class="card-body">
                <table id="table_perencanaan_non_pmcs" class="table table-bordered table-striped"></table>
              </div>
            </div>
          </div>


        </div>
      </div>


    </div>
  </div>
</div> -->

<section class="users-list-wrapper">
    <!-- starts -->
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 20px;">
                    <div class="card-content">
                        <div class="card-body">
                            <a href="#" class="btn btn-info mb-3 btn-lg" data-toggle="modal" data-target="#drupForm">
                              <i class="ft-file-plus"></i>Tambah
                            </a>
                            <a href="<?= base_url('procurement/doc_cetak/pdf_drup');?>" target="_blank" onclick="return confirm('Apakah Anda yakin cetak data ini?')" class="btn btn-info mb-3 btn-lg">
                              <i class="ft-printer"></i> Print
                            </a>
                  							<div class="table-responsive">
                  								<table class="table m-0">
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
                  											<th rowspan="2" style="vertical-align: middle;">Detail</th>
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
                                            <tr style="background-color: #4460691a">
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
                                                    <td class="text-right"><?php echo number_format($value_in['harga_satuan']);?></td>
                                                    <td class="text-right"><?php echo number_format($value_in['volume'] * $value_in['harga_satuan']);?></td>
                                                    <td><?php echo $value_in['catatan'];?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('procurement/proses_pengadaan/delete_drup/' . $value_in['id']);?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')" class="btn btn-sm btn-danger" title="Delete">
                                                          <i class="ft-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
									                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #4460691a">
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
    </div>
    <!-- ends -->
</section>

<div class="modal fade text-left" id="drupForm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title modal-judul">Tambah DRUP</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form action="<?= base_url('procurement/proses_pengadaan/submit_drup');?>" method="POST">
				<div class="modal-body">

					<label>Kode COA</label>
					<div class="form-group position-relative has-icon-left">
            <select class="form-control select2" name="coa_id" required style="width:100%;">
							<option value="" class="form-control">Pilih</option>
                <?php foreach ($coa_data as $value) { ?>
							    <option class="form-control" value="<?= $value['id'];?>"><?php echo $value['kode_perkiraan'] . ' __ ' . $value['nama_perkiraan'];?></option>
                <?php } ?>
						</select>
					</div>

					<label>Kode Sumber Daya</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" name="kode_sumber_daya" maxlength="10" placeholder="Kode Sumber Daya" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Nama Program</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" name="nama_program" maxlength="100" placeholder="Nama Program" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Pemilik Program</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" name="pemilik_program" maxlength="10p" placeholder="Pemilik Program" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

					<label>Pengelola Anggaran</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" name="pengelola_anggaran" maxlength="100" placeholder="Pengelola Anggaran" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

          <label>Penyedia</label>
					<div class="form-group position-relative has-icon-left">
            <select class="form-control select2" name="penyedia" required style="width:100%;">
							<option value="">Pilih</option>
							<option value="Jasa">Jasa</option>
							<option value="Barang">Barang</option>
						</select>
					</div>

                    <label>Swakelola</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" name="swakelola" maxlength="50" placeholder="Swakelola" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Tgl Mulai Pengadaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="date" name="tgl_mulai_pengadaan" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-calendar font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Tgl Akhir Pengadaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="date" name="tgl_akhir_pengadaan" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-calendar font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Tgl Mulai Pekerjaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="date" name="tgl_mulai_pekerjaan" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-calendar font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Tgl Akhir Pekerjaan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="date" name="tgl_akhir_pekerjaan" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-calendar font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Volume</label>
					<div class="form-group position-relative has-icon-left">
						<input type="int" name="volume" min="0" placeholder="Volume" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Satuan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" name="satuan" maxlength="10" placeholder="Satuan" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Harga Satuan</label>
					<div class="form-group position-relative has-icon-left">
						<input type="int" name="harga_satuan" min="0" placeholder="Harga Satuan" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

                    <label>Catatan</label>
					<div class="form-group position-relative has-icon-left">
            <textarea name="catatan" maxlength="100" placeholder="Catatan" class="form-control"></textarea>
						<div class="form-control-position">
							<i class="ft-file-text font-medium-2 text-muted"></i>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-danger" data-dismiss="modal" value="Tutup">
					<input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info" value="Simpan" >
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">

  jQuery.extend({
    getCustomJSON: function(url) {
      var result = null;
      $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(data) {
          result = data;
        }
      });
      return result;
    }
  });

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('procurement') ?>/"+url);

    var html = [];
    $.each(row, function (key, value) {
     var data = $.grep(mydata, function(e){
       return e.field == key;
     });

     if(typeof data[0] !== 'undefined'){

       html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
     }
   });

    return html.join('');

  }

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/perencanaan_pengadaan') ?>";
    var view = "";
    var edit = "";
    <?php if($view){ ?>
      var view ='<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_perencanaan_pengadaan/lihat/'+value+'">Lihat</a>';
    <?php } ?>
    <?php if($edit){ ?>
      var edit ='<a class="btn btn-primary btn-xs action" href="'+link+'/update_daftar_perencanaan/ubah/'+value+'">Ubah</a>';
    <?php } ?>
    return [view,edit].join('');
}
window.operateEvents = {
  'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  }
};
function totalTextFormatter(data) {
  return 'Total';
}
function totalNameFormatter(data) {
  return data.length;
}
function totalPriceFormatter(data) {
  var total = 0;
  $.each(data, function (i, row) {
    total += +(row.price.substring(1));
  });
  return '$' + total;
}

</script>

<script type="text/javascript">

  var $table_perencanaan_non_pmcs = $('#table_perencanaan_non_pmcs'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {



        var bar = $('.bar-csv');
        var percent = $('.percent-csv');

        $('#uploadFormCsv').ajaxForm({
          dataType:  'json',
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function(xhr) {
                // status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                $('#stop_upload_csv').click(function(){
                // return false;
                xhr.abort();
                $('#file-uploader-csv').val("");
                setTimeout(function () {
                $('#loading_upload_csv').modal('hide');
                }, 100);
                // $('#submit_file_csv').attr('disabled',true);

              })
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#loading_upload_csv').modal("show");
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                if (percentComplete == 100) {
                setTimeout(function () {
                $('#loading_upload_csv').modal('hide');
                }, 500);
              }
            },
            success: function(responseJSON, statusText, xhr) {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);

                console.log(responseJSON)
                if (responseJSON == "fail") {

                    alert('Gagal menambah perencanaan');

                  }
                  else{
                    alert('Sukses menambah perencanaan');
                  }


            },
            error: function (xhr, status, error) {
           console.log(error)
          },

    });


    $table_perencanaan_non_pmcs.bootstrapTable({

      url: "<?php echo site_url('procurement/data_perencanaan_non_pmcs') ?>/<?php echo ($edit) ? 'update' : '' ?>",
      cookieIdTable:"perencanaan_non_pmcs",
      idField:"ppm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'ppi_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      }, {
        field: 'ppi_item_type',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'ppm_dept_name',
        title: 'Divisi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'ppm_subject_of_work',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      },
      {
        field: 'ppi_satuan',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'ppi_harga',
        title: 'Harga',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'5%',
      },
      {
        field: 'ppi_jumlah',
        title: 'Volume',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'ppi_total',
        title: 'Total',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      }
      ]

    });
setTimeout(function () {
  $table_perencanaan_non_pmcs.bootstrapTable('resetView');
}, 200);

});

</script>
