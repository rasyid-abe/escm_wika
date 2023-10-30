<section class="users-list-wrapper">
    <!-- Table starts -->
    <div class="users-list-table">
	<form id="form_matgis" action="<?= $actionPostMatgis; ?>" method="post" enctype="multipart/form-data">
		<!-- header -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
					<div class="card-header text-muted">
							<h5><b> Detail Proyek</b></h5>
							<span class="tags float-right">
								<!-- <a onclick="fshowSettings()" class="btn btn-sm btn-warning"><i class="ft ft-settings"></i> Pengaturan Pertanyaan</a> -->
							</span>
						</div>
                        <div class="card-body">
						<div class="form-group row">
							<label class="col-md-3 label-control" for="striped-form-1">User</label>
							<div class="col-md-9">
							<input type="text" id="striped-form-1" class="form-control" readonly name="fullname" value="<?= $emp['fullname'] ?>">
							</div>
                        </div>

						<div class="form-group row">
							<label class="col-md-3 label-control" for="striped-form-1">Divisi/Departemen</label>
							<div class="col-md-9">
							<input type="text" id="striped-form-1" class="form-control" readonly name="departemen" value="<?= $emp['dept_name'] ?>">
							</div>
                        </div>

						<div class="form-group row">
							<label class="col-md-3 label-control" for="striped-form-1">Jenis Rencana</label>
							<div class="col-md-9">
							<input type="text" id="striped-form-1" class="form-control" name="h_matgis_rencana" value="RKP NON PMCS" readonly>
							</div>
                        </div>

						<div class="form-group row">
							<label class="col-md-3 label-control" for="striped-form-1">Nama Rencana</label>
							<div class="col-md-9">
							<select name="h_matgis" class="form-control select2" id="h_matgis">
								<option value="">--- PILIH RENCANA ---</option>
								<?php foreach ($master_matgis as $key => $value) : ?>
								<option value="<?=$value['id'] ?>"><?=$value['label'] ?></option>
								<?php endforeach; ?>
							</select>
							</div>
                        </div>

						<div class="form-group row">
							<label class="col-md-3 label-control" for="striped-form-1">Mata Uang</label>
							<div class="col-md-9">
							<select name="h_curr_code" class="form-control select2" id="h_curr_code">
								<?php foreach ($curr as $key => $value) : ?>
								<option value="<?=$value['curr_code'] ?>"><?=$value['curr_name'] ?></option>
								<?php endforeach; ?>
							</select>
							</div>
                        </div>

                           <!-- content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<!-- Matgis -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
			                 <div class="card-header text-muted">
            							<h5><b>Detail Produk</b></h5>
            							<span class="tags float-right">
            								<!-- <a onclick="fshowSettings()" class="btn btn-sm btn-warning"><i class="ft ft-settings"></i> Pengaturan Pertanyaan</a> -->
            							</span>
            						</div>
                        <div class="card-body">
              						<div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1">Kode</label>
              							<div class="col-md-9">
              								<input type="hidden" id="i_kode">
              							<!-- <button type="button" id="btnItemMatgis" data-bs-toggle="modal" data-bs-target="#modalItemMatgis" class="btn btn-info">Pilih Matgis</button> -->
              							<select name="i_matgis" class="form-control select2" id="i_matgis">
              								<option value="">--- PILIH ---</option>
              								<?php foreach ($item_matgis as $key => $value) : ?>
              								<option value="<?=$value['smbd_code'] ?>_<?=$value['group_smbd_code'] ?>"><?=$value['smbd_code'] ?> - <?=$value['smbd_name'] ?></option>
              								<?php endforeach; ?>
              							</select>
              							</div>
                          </div>

              						<div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1">Tipe</label>
              							<div class="col-md-9">
              							<input type="text"  class="form-control" name="i_tipe" readonly id="i_tipe">
              							</div>
                          </div>

              						<div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1">Deskripsi</label>
              							<div class="col-md-9">
              							<input type="text"  class="form-control" name="i_deskripsi" readonly id="i_deskripsi">
              							</div>
                          </div>

              						<div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1">Volume</label>
              							<div class="col-md-9">
              							<input type="text"  class="form-control input-number" name="i_volume" id="i_volume" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true,  'radixPoint':','" >
              							</div>
                          </div>

              						<div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1">Satuan</label>
              							<div class="col-md-9">
              							<input type="text"  class="form-control" name="i_satuan" readonly id="i_satuan">
              							</div>
                          </div>

              						<div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1">Harga Satuan</label>
              							<div class="col-md-9">
              							<input type="text"  class="form-control input-number" name="i_harga_satuan" id="i_harga_satuan_view" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true,  'radixPoint':','" >
              							<input type="hidden"  class="form-control" name="i_harga_satuan" id="i_harga_satuan">

              							</div>
                          </div>

              						<div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1"> </label>
              							<div class="col-md-9">
                                <span class="float-right">
                                  <button class="btn btn-danger"><i class="ft ft-trash-2"></i> Hapus</button>
  			                          <button class="btn btn-info" id="btnTambahMatgis"><i class="ft ft-file-text"></i> Simpan</button>
                               </span>
              							</div>
                          </div>

              						<div class="form-group row">
              							<div class="col-md-12">
                							<table class="table table-bordered" id="item_table">
                  							<thead>
                  								<tr>
                    								<th>#</th>
                    								<th>Kode</th>
                    								<th>Item</th>
                    								<th>Volume</th>
                    								<th>Satuan</th>
                    								<th>Harga Satuan<br/><!-- (Sebelum Pajak) --></th>
                    								<th style="display: none">Pajak</th>
                    								<th>Subtotal<br/><!-- (Sebelum Pajak) --></th>
                  								</tr>
                  							</thead>
                  							<tbody id="i_body_item">

                  							</tbody>
                							</table>
              							</div>
              						</div>
                           <!-- content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

		     <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h5><b>Lampiran Dokumen</b> <button type="button" class="btn bg-light-info" data-toggle="modal" data-target="#info">Tambah</button></h5>
                  </div>
                  <div class="card-body" style="padding-top: 0px;padding-bottom: 0px;">
                    <div class="card" style="width: 18rem;">
                      <div class="card-body" style="background-color: #ececec;border-radius: 10px;width: 430%;">
                        <div class="row">
                           <div class="col-2">
                             <div class="card" style="margin: 0px 0;">
                              <div class="card-header" style="background-color: #2aace3;text-align: center;padding-bottom: 10px;color:#fff;">
                                <b>Upload</b>
                              </div>
                              <div class="card-body">
                                <blockquote class="blockquote mb-0" style="text-align: center;">
                                  <img src="<?= base_url('assets/img/file.png') ?>" style="width:50px;" />
                                </blockquote>
                              </div>
                            </div>
                           </div>
                           <div class="col-10">
                             <fieldset class="form-group" style="background-color: #fff;">
                                  <select class="form-control" id="basicSelect">
                                      <option>General Term and Condition</option>
                                      <option>General Term and Condition</option>
                                      <option>General Term and Condition</option>
                                  </select>
                              </fieldset>
                              <textarea class="form-control" style="background-color: #fff;height: 110px;">Some quick example text to build on the card title and make up the bulk of the card's content</textarea>
                           </div>
                         </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body" style="padding-top: 0px;padding-bottom: 0px;">
                    <div class="card" style="width: 18rem;">
                      <div class="card-body" style="background-color: #ececec;border-radius: 10px;width: 430%;">
                        <div class="row">
                           <div class="col-2">
                             <div class="card" style="margin: 0px 0;">
                              <div class="card-header" style="background-color: #2aace3;text-align: center;padding-bottom: 10px;color:#fff;">
                                <b>Upload</b>
                              </div>
                              <div class="card-body">
                                <blockquote class="blockquote mb-0" style="text-align: center;">
                                  <img src="<?= base_url('assets/img/file.png') ?>" style="width:50px;" />
                                </blockquote>
                              </div>
                            </div>
                           </div>
                           <div class="col-10">
                             <fieldset class="form-group" style="background-color: #fff;">
                                  <select class="form-control" id="basicSelect">
                                      <option>General Term and Condition</option>
                                      <option>General Term and Condition</option>
                                      <option>General Term and Condition</option>
                                  </select>
                              </fieldset>
                              <textarea class="form-control" style="background-color: #fff;height: 110px;">Some quick example text to build on the card title and make up the bulk of the card's content</textarea>
                           </div>
                         </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div style="display:none;" class="card">
                    <div class="card-content">
					             <div class="card-header text-muted">
            							<h3>Lampiran</h3>
            							<hr>
            							<span class="tags float-right">
            								<!-- <a onclick="fshowSettings()" class="btn btn-sm btn-warning"><i class="ft ft-settings"></i> Pengaturan Pertanyaan</a> -->
            							</span>
            						</div>

        						<!-- <div class="form-group row">
              							<label class="col-md-3 label-control" for="striped-form-1"> </label>
              							<div class="col-md-9">
              							<button class="btn btn-info" id="btnTambahLampiran">Tambah lampiran</button>
              							</div>
                          </div> -->


                           <!-- content -->
                      </div>
                  </div>
              </div>
          </div>

          <section id="configuration">
              <div class="row">
                  <div class="col-12">
                      <div class="card">
                          <div class="card-header">
                              <h4 class="card-title">Daftar Komentar</h4>
                          </div>
                          <div class="card-content">
                              <div class="card-body">
                                  <div class="table-responsive">
                                      <table class="table table-striped table-bordered zero-configuration">
                                          <thead>
                                              <tr>
                                                <th>Mulai</th>
                                                <th>Selesai</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Aktifitas</th>
                                                <th>Tanggapan</th>
                                                <th>Komentar</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td>12/11/20 - 15:05:14</td>
                                                  <td>12/11/20 - 15:05:14</td>
                                                  <td>Wirasto Mukti</td>
                                                  <td>GM Departemen Luar Negeri</td>
                                                  <td>Permintaan Persetujuan GM Departemen Luar Negeri</td>
                                                  <td>Setuju</td>
                                                  <td>Approved</td>
                                              </tr>
                                              <tr>
                                                  <td>12/11/20 - 15:05:14</td>
                                                  <td>12/11/20 - 15:05:14</td>
                                                  <td>Wirasto Mukti</td>
                                                  <td>GM Departemen Luar Negeri</td>
                                                  <td>Permintaan Persetujuan GM Departemen Luar Negeri</td>
                                                  <td>Siap dan Kirim</td>
                                                  <td>Mohon Approvalnya</td>
                                              </tr>
                                              <tr>
                                                  <td>12/11/20 - 15:05:14</td>
                                                  <td>12/11/20 - 15:05:14</td>
                                                  <td>Francisco</td>
                                                  <td>GM Departemen Luar Negeri</td>
                                                  <td>Permintaan Persetujuan GM Departemen Luar Negeri</td>
                                                  <td>Setuju</td>
                                                  <td>Approved</td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>

      		<div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-content">
      					          <div class="card-header">
              							<h5><b>Komentar</b></h5>
              							<span class="tags float-right">
              								<!-- <a onclick="fshowSettings()" class="btn btn-sm btn-warning"><i class="ft ft-settings"></i> Pengaturan Pertanyaan</a> -->
              							</span>
              						</div>
                          <div class="card-body" style="padding:35px;">
                						<div class="form-group row lampiran_matgis">
                							<label class="col-md-2 label-control" for="striped-form-1"><b>Aksi*</b></label>
                							<div class="col-md-10">
                							<!-- <input type="text" class="form-control" name="aksi" required> -->
                                <fieldset class="form-group" style="background-color: #fff;">
                                     <select class="form-control" id="basicSelect">
                                         <option>General Term and Condition</option>
                                         <option>General Term and Condition</option>
                                         <option>General Term and Condition</option>
                                     </select>
                                 </fieldset>
                							</div>
                            </div>
                            <div class="form-group row lampiran_matgis">
                							<label class="col-md-2 label-control" for="striped-form-1"><b>Komentar*</b></label>
                							<div class="col-md-10">
                							<textarea class="form-control" name="komentar" required>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when anunknown printer took a galley of type and scrambled it to make a type specimen book</textarea>
                							</div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

						<span class="tags float-left">
              <span class="float-left">
                <a href="<?= site_url('procurement/perencanaan_pengadaan/perencanaan_non_pmcs') ?>" class="btn btn-danger"><i class="ft ft-corner-up-left"></i> Kembali</a>
              </span>
						</span>
            <span class="tags float-right">
              <span class="float-right"><a href="#" id="btnSimpanMatgis" class="btn btn-success"><i class="ft ft-upload"></i> Ajukan</a></span>
              <span class="float-right" style="padding-right:10px;"><a href="#" id="btnSimpanMatgis" class="btn btn-info"><i class="ft ft-file-text"></i> Simpan</a></span>
            </span>

    </div>
    <!-- Table ends -->
    <div class="modal fade text-left" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="myModalLabel11">Lampiran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="body_lampiran">
                  <div class="form-group row lampiran_matgis">
                    <label class="col-md-3 label-control" for="striped-form-1">Sisipkan Lampiran</label>
                    <div class="col-md-9">
                       <input type="file" class="form-control" multiple id="file_" name="files[]">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-info">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8-beta.15/jquery.inputmask.min.js" integrity="sha512-eum9D1RPicKrvZhf7ou17bWG/No1K7hX/kayp4EjFfuRx5E6jTtHkqUs4HN3whiaNqWx4g3UThNWcFjJqCAsXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
	$(document.body).on("click",".edit_item",function(){

      //cek_group();

      $(this).parent().parent().remove();

      //set_total();

      return false;

    });

	$(document).ready(function () {

		<?php if($this->session->flashdata("success") == true){ ?>
			toastr.success('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		<?php if($this->session->flashdata("error") == true){ ?>
			toastr.error('Notification !', '<?php echo  $this->session->flashdata("message") ?>');
		<?php } ?>

		$("#btnItemMatgis").click(function (e) {
			e.preventDefault();
			$("#modalItemMatgis").modal('show');

		});
		$('#h_curr_code').select2();
		$('#h_matgis').select2();
		$('#i_matgis').select2();

		$('#h_curr_code').val('IDR');
		$('#h_curr_code').trigger('change'); // Notify any JS components that the value changed
		$('.input-number').inputmask();

		$('#i_matgis').on('select2:select', function (e) {
		// Do something
		var data = e.params.data;
			$.ajax({
				type: "GET",
				url: "<?= base_url() ?>procurement/perencanaan_pengadaan/pembuatan_perencanaan_matgis/get_item_matgis_detail/"+data.id,
				data: {id : data.id},
				dataType: "json",
				success: function (response) {

					if(response != null) {

						$('#i_kode').val(response.smbd_code);

						$('#i_tipe').val(response.tipe);
						$('#i_deskripsi').val(response.long_description);
						$('#i_volume').val();
						$('#i_satuan').val(response.unit);
						$('#i_harga_satuan').val(response.price);
						$('#i_harga_satuan_view').val(parseFloat(response.price.replace('.',',')));

					}
				}
			});
		});

		$("#btnTambahMatgis").click(function (e) {
			e.preventDefault();
			var no =1;
			var kode = $("#i_kode").val();
			var tipe = $("#i_tipe").val();


			var deskripsi = $("#i_deskripsi").val();
			var jumlah = $("#i_volume").val();
			var satuan = $("#i_satuan").val();
			var harga_satuan = $("#i_harga_satuan").val();
			var harga_satuan_view = $("#i_harga_satuan_view").val();

			var total = (parseFloat(jumlah.replace('.','')) * parseFloat(harga_satuan.replace('.',',')));

			if(jumlah < 1 || jumlah == '') {
				alert("volume tidak boleh 0");
				return false;
			}

			if(harga_satuan < 1 || harga_satuan == '') {
				alert("harga tidak boleh 0");
				return false;
			}

			var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
			html += "<td><input type='hidden' class='kode_item' data-no='"+no+"' name='item_kode[]' value='"+kode+"'/>"+kode+"</td>";
			html += "<td><input type='hidden' class='tipe_item' data-no='"+no+"' name='item_tipe[]' value='"+tipe+"'/>"+tipe+"</td>";
			html += "<td class='text-right'><input type='hidden' name='item_jumlah[]' value='"+jumlah+"'/>"+jumlah+"</td>";
			html += "<td><input type='hidden' class='satuan_item' data-no='"+no+"' name='item_satuan[]' value='"+satuan+"'/>"+satuan+"</td>";
			html += "<td class='text-right'><input type='hidden' class='harga_satuan_item' data-no='' name='item_harga_satuan[]' value='"+harga_satuan+"'/>"+harga_satuan_view+"</td>";
			//html += "<td class='text-right' style='display: none'><input type='hidden' class='ppn_satuan_item' data-no='' name='item_ppn_satuan[]' value='"+ppn+"'/> "+label_ppn;
			//html += " <input type='hidden' class='pph_satuan_item' data-no='' name='item_pph_satuan[]' value='"+pph+"'/> "+label_pph;
			// html += "</td>";
			html += "<td class='text-right'><input type='hidden' class='subtotal_item' data-no='' name='item_desc[]' value='"+deskripsi+"'/><input type='hidden' class='subtotal_item' data-no='' name='item_subtotal[]' value='"+total+"'/>"+total+"</td>"
			html += "</tr>";
			$("#item_table").append(html);
			clearItem();
		});

		$("#btnSimpanMatgis").click(function (e) {
			e.preventDefault();
			e.preventDefault();
			Swal.fire({
			title: 'WARNING',
			text: "Yakin Simpan  ?",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
			backdrop: true,
			allowOutsideClick : false
			}).then((result) => {
				if (result.value) {
					$("#form_matgis").submit();

				} else {

				}
			})
		});

	});

	function fAddItem()
	{

	}

	function clearItem()
	{
		$('#i_kode').val("");
		$('#i_tipe').val("");
		$('#i_deskripsi').val("");
		$('#i_volume').val(0);
		$('#i_satuan').val("");
		$('#i_harga_satuan').val("");
		$('#i_harga_satuan_view').val("");
	}
</script>
