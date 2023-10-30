<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo COMPANY_NAME ?></title>

	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png') ?>">

	<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/animate.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">

	<!-- Data Tables -->
	<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.bootstrap.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.responsive.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.tableTools.min.css') ?>" rel="stylesheet">

	<!-- Sweet Alert -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/sweetalert/sweetalert.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/iproc_scm.css') ?>">

	<style>
	/* Latest compiled and minified CSS included as External Resource*/
/* Optional theme */
/*@import url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css');*/
.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
	</style>

</head>

<body class="top-navigation">

	<!-- Mainly scripts -->
	<script src="<?php echo base_url('assets/js/jquery-2.1.1.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.form.min.js') ?>"></script>

	<!-- Custom and plugin javascript -->
	<script src="<?php echo base_url('assets/js/inspinia.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/pace/pace.min.js') ?>"></script>

	<!-- Data Tables -->
	<script src="<?php echo base_url('assets/js/plugins/dataTables/jquery.dataTables.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.bootstrap.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.responsive.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.tableTools.min.js') ?>"></script>

	<!-- Jquery Validate -->
	<script src="<?php echo base_url('assets/js/plugins/validate/jquery.validate.min.js') ?>"></script>

	<!-- Sweet Alert -->
	<script src="<?php echo base_url('assets/js/plugins/sweetalert/sweetalert.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/xss.min.js') ?>"></script>

	<div id="wrapper">
		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom white-bg">
				<nav class="navbar navbar-static-top" role="navigation">
					<div class="navbar-collapse collapse" id="navbar">
						<ul class="nav navbar-nav">
							<li class="active">
								<a aria-expanded="false" role="button"><img src="<?php echo base_url('assets/img/logo.png') ?>" style="width: 100px; height: 40px"></a>
							</li>
							<li class="active">
								<div class="col-md-12" style="color:#0288D1">
									<h1>
										Pendaftaran Mandor PT Wijaya Karya
									</h1>
								</div>
							</li>
						</ul>
					</div>
				</nav>
			</div>

			<div class="container">
				<div style="margin-top:20px">
					<?=$this->session->flashdata('pesan')?>
				</div>
				<div class="stepwizard" style="margin-top:50px">
					<div class="stepwizard-row setup-panel">
						<div class="stepwizard-step col-xs-3"> 
							<button href="#step-1" type="button" class="btn btn-primary btn-circle">1</button>
							<p><small>Administration</small></p>
						</div>
						<div class="stepwizard-step col-xs-3"> 
							<button href="#step-2" type="button" class="btn btn-light btn-circle" disabled>2</button>
							<p><small>Keuangan</small></p>
						</div>
						<div class="stepwizard-step col-xs-3"> 
							<button href="#step-3" type="button" class="btn btn-light btn-circle" disabled>3</button>
							<p><small>Pengalaman</small></p>
						</div>
						<div class="stepwizard-step col-xs-3"> 
							<button href="#step-4" type="button" class="btn btn-light btn-circle" disabled >4</button>
							<p><small>Teknis</small></p>
						</div>
					</div>
				</div>
				
				<!-- <form role="form" action="<?php echo site_url('welcome/submit_mandor') ?>" method="post" style="margin-top:50px;margin-bottom:100px" enctype="multipart/form-data"> -->
				<?php echo form_open_multipart('welcome/submit_mandor');?>

					<div class="panel panel-default setup-content "  id="step-1">
						<div class="ibox-title">
							<h5>Administration</h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="form-group col-md-5">
									<label class="control-label">Nama *</label>
									<input name="vmh_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama" />
								</div>
								<div class="form-group col-md-7">
									<label class="control-label">Alamat KTP *</label>
									<input name="vmh_address_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Alamat" />
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label class="control-label">No NPWP *</label>
									<input name="vmh_npwp_inp[]" maxlength="15" type="text" required="required" class="form-control number" placeholder="Masukkan No NPWP" />
								</div>
								<div class="form-group col-md-4">
									<label class="control-label">Email *</label>
									<input name="vmh_email_inp[]" maxlength="100" type="email" required="required" class="form-control" placeholder="Masukkan Email" />
								</div>
								<div class="form-group col-md-4">
									<label class="control-label">No Telepon/HP *</label>
									<input name="vmh_hp_inp[]" max="99999999999999999999" type="text" required="required" class="form-control number" placeholder="Masukkan No Telephone" />
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label class="control-label">Jumlah Tenaga Kerja *</label>
									<input name="vmh_qty_employee_inp[]" max="99999999999999999999" type="text" required="required" class="form-control number" placeholder="Masukkan Jumlah Tenaga Kerja" />
								</div>
							</div>
							<div class="row" style="padding:20px;border-radius:6px">
								<div class="col-md-12" style="color:#0288D1">
									<h3>PIC Mandor</h3>
								</div>
								<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
									<div class="pic_mandor">
										<div class="form-group col-md-4">
											<label class="control-label t">Nama PIC *</label>
											<input maxlength="100" type="text" name="vmp_pic_name_inp[]" required="required" class="form-control" placeholder="Masukkan Nama PIC" />
										</div>
										<div class="form-group col-md-3">
											<label class="control-label">Keterangan Jabatan *</label>
											<input maxlength="100" type="text" name="vmp_pic_position_inp[]" required="required" class="form-control" placeholder="Masukkan Jabatan PIC" />
										</div>
										<div class="form-group col-md-4">
											<label class="control-label">No Handphone *</label>
											<input max="99999999999999999999" type="text"  name="vmp_pic_contact_inp[]" required="required" class="form-control number" placeholder="ex: 08120120129" />
										</div>
									</div>
									<div class="form-group col-md-12">
										<button class="btn btn-primary col-md-12 add_pic" style="margin-top:20px" type="button"><i class="fa fa-plus"></i> Tambah PIC</button>
									</div>
								</div>
							</div>
							<div class="row" style="padding:20px;border-radius:6px">
								<div class="col-md-12" style="color:#0288D1">
									<h3>Bidang Mandor</h3>
								</div>
								<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
									<div class="bidang_mandor">
										<div class="form-group col-md-5">
											<label class="control-label">Bidang *</label>
											<select class="form-control m-b bidang" data-no="1" name="vmb_bidang_code_inp[]">
												<option>Pilih Bidang</option>
												<?php foreach ($bidang as $k => $v) { ?>
													<option value="<?php echo $v['am_kode'] ?>"><?php echo $v['am_name'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group col-md-6">
											<label class="control-label">Sub Bidang *</label>		
											<select class="form-control m-b sub_bidang"  data-no="1" name="vmb_sub_bidang_code_inp[]">
												<option>Pilih Sub Bidang</option>
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<button class="btn btn-primary col-md-12 add_bidang_mandor" style="margin-top:20px" type="button"><i class="fa fa-plus"></i> Tambah Bidang</button>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<a href="https://drive.google.com/file/d/1A9rWADUej1azpTnhkN1UaNaSFg5lpw-B/view?usp=sharing" target="_blank"><button class="btn btn-primary" style="margin-top:20px" type="button"><i class="fa fa-file"></i> Download Surat Pernyataan</button></a>
								</div>
								<div class="form-group col-md-4">
									<label class="control-label">Upload Surat Pernyataan</label>
									<input name="vmh_statement_letter_inp" type="file" required="required" class="form-control" placeholder="Enter Last Name" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									<div style="font-size: 11px">
				                        <i>Max file 5 MB 
				                        <br>
				                          File Type : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
				                        </i>
			                     	</div>
								</div>
							</div>
							<hr/>
							<div class="text-right">
								<button class="btn btn-primary nextBtn" type="button">Next</button>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default setup-content" id="step-2">
						<div class="ibox-title">
							<h5>Keuangan</h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="form-group col-md-3">
									<label class="control-label">Nama Bank *</label>
									<input name="vmh_bank_account_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama" />
								</div>
								<div class="form-group col-md-5">
									<label class="control-label">Nomor Rekening *</label>
									<input name="vmh_bank_no_account_inp[]" max="99999999999999999999" type="text"  required="required" class="form-control number" placeholder="Masukkan No Rekening" />
								</div>
								<div class="form-group col-md-4">
									<label class="control-label">Atas Nama Rekening *</label>
									<input name="vmh_bank_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Rekening" />
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label class="control-label">Upload Rekening koran 1 tahun terakhir dan tahun berjalan *</label>
									<input name="vmh_rekening_koran_inp" type="file" required="required" class="form-control" placeholder="Upload Rekening Koran" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div style="font-size: 11px">
				                        <i>Max file 5 MB 
				                        <br>
				                          File Type : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
				                        </i>
			                     	</div>
								</div>
							</div>
							<hr/>
							<div class="text-right">
								<button class="btn btn-primary nextBtn" type="button">Next</button>
							</div>	
						</div>
					</div>
					
					<div class="panel panel-default setup-content" id="step-3">
						<div class="ibox-title">
							<h5>Pengalaman</h5>
						</div>
						<div class="ibox-content">	
							<div class="row" style="padding:20px;border-radius:6px">
								<div class="col-md-12" style="color:#0288D1">
									<h3>Proyek</h3>
								</div>
								<div class="proyek">
								<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
										<div class="row">
											<div class="form-group col-md-4">
												<label class="control-label">Tahun Proyek *</label>
												<select class="form-control m-b" name="vmpe_year_inp[]">
													<option>Pilih Tahun</option>
													<?php for($i=2000;$i<=2050;$i++){?>
														<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php }?>
												</select>
											</div>
											<div class="form-group col-md-4">
												<label class="control-label">Nama Proyek *</label>
												<input name="vmpe_project_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Proyek" />
											</div>
											<div class="form-group col-md-4">
												<label class="control-label">Nilai Pekerjaan *</label>
												<input name="vmpe_project_value_inp[]" max="99999999999999999999" type="text"  required="required" class="form-control rupiah" placeholder="Masukkan Nilai pekerjaan" />
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6">
												<label class="control-label">Nama Kontraktor *</label>
												<input name="vmpe_contractor_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Kontraktor" />
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-4">
												<label class="control-label">Upload Bukti Proyek, Ditandatangani Manager Proyek *</label>
												<input name="vmpe_evidence_project_inp[]" type="file" required="required" class="form-control" placeholder="Upload Rekening Koran" />
											</div>
										</div>
										<div class="row" >
											<div class="col-md-12" style="color:#0288D1">
												<h3>Bidang</h3>
											</div>
											<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
												<div class="bidang_pengalaman_0">
													<div class="row">
														<div class="form-group col-md-4">
															<label class="control-label">Bidang *</label>
															<select class="form-control m-b bidang_proyek" data-no="0" data-sub-no="0" name="vmb_bidang_code_proyek_inp[0][]" >
															<option value="">Pilih Bidang</option>
															<?php foreach ($bidang as $k => $v) { ?>
																<option value="<?php echo $v['am_kode'] ?>"><?php echo $v['am_name'] ?></option>
															<?php } ?>
														</select>
														</div>
														<div class="form-group col-md-7">
															<label class="control-label">Sub Bidang *</label>
															<select class="form-control m-b sub_bidang_proyek" data-no="0" data-sub-no="0" name="vmb_sub_bidang_code_proyek_inp[0][]" >
															<option value="">Pilih Sub Bidang</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<button class="btn btn-primary col-md-12 btn-action" style="margin-top:20px" type="button" data-category="bidang-pengalaman" data-no="0" data-action="add"><i class="fa fa-plus"></i> Tambah Bidang</button>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-4">
												<div style="font-size: 11px">
													<i>Max file 5 MB 
													<br>
													File Type : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
													</i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<button class="btn btn-primary col-md-12 add_proyek" type="button"><i class="fa fa-plus"></i> Tambah Pengalaman Proyek</button>
								</div>
							</div>

							<hr/>
							<div class="text-right">
								<button class="btn btn-primary nextBtn " type="button">Next</button>
							</div>						
						</div>
					</div>
					
					<div class="panel panel-default setup-content" id="step-4">
						<div class="ibox-title">
							<h3 class="panel-title">Teknis</h3>
						</div>
						<div class="ibox-content">
							<div class="form-group row" style="padding:17px;border-radius:6px">
								<div class="col-md-12" style="color:#0288D1">
									<h3>Ahli Bidang Mandor</h3>
								</div>
								<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
									<div class="ahliBidangMandor">
										<div class="form-group col-md-8">
											<label class="control-label">Ahli Bidang *</label>
											<input name="vmtq_ahli_bidang_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Ahli Bidang" />
										</div>
										<div class="form-group col-md-3">
											<label class="control-label">Jumlah *</label>
											<input name="vmtq_qty_ahli_bidang_inp[]" max="99999999999999999999" type="text"  required="required" class="form-control number" placeholder="Masukkan Jumlah Ahli Bidang" />
										</div>
									</div>
									<div class="col-md-12">
										<button class="btn btn-primary col-md-12 addahliBidangMandor" style="margin-top:20px" type="button"><i class="fa fa-plus"></i> Tambah Ahli Bidang</button>
									</div>
								</div>
							</div>
							<div >
								<div class="col-md-12" style="color:#0288D1">
									<h3>Daftar Peralatan</h3>
								</div>
								<div class="DaftarPeralatan">
									<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
										<div class="row">
											<div class="form-group col-md-5">
												<label class="control-label">Nama Peralatan *</label>
												<input name="vmt_tools_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Peralatan" />
											</div>
											<div class="form-group col-md-6">
												<label class="control-label">Merek *</label>
												<input name="vmt_tool_brand_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Merek Peralatan" />
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-5">
												<label class="control-label">Jumlah Peralatan *</label>
												<input name="vmt_qty_tools_inp[]" max="99999999999999999999" type="text"  required="required" class="form-control number" placeholder="Masukkan Jumlah Peralatan" />
											</div>
											<div class="form-group col-md-6">
												<label class="control-label">Kondisi *</label>
												<input name="vmt_condition_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Jelaskan Kodisi peralatan" />
											</div>
										</div>
									</div>
								</div>
							<div class="form-group row">
								<div class="col-md-12">
									<button class="btn btn-primary col-md-12 addDaftarPeralatan" style="margin-top:20px" type="button"><i class="fa fa-plus"></i>Tambah Peralatan</button>
								</div>
							</div>
							</div>
							<hr/>
							<div class="text-right">
								<button class="btn btn-primary " type="submit">Finish!</button>
							</div>	
						</div>
					</div>
				</form>
			</div>
				<div class="footer" style="margin-top:5000px">
					<div class="pull-right">
						<?php echo COMPANY_NAME . " &copy; " . date('Y') ?>
					</div>
				</div>
			</div>
		</div>
		<script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
		<link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">

		<script type="text/javascript">
			const data = {
				index_bidang_pengalaman: 1,
				selected_sub_bidang_proyek: [],
				selected_sub_bidang: [],
			}
			let noBidangProyek = 0;
			$(document).ready(function() {
				_event()
				$(".add_pic").on("click", function(e) {
					let appendData = `
					<div class="key">
						<div class="col-md-4" style="margin-top:20px">
							<label class="control-label t">Nama PIC *</label>
							<input maxlength="100" type="text" name="vmp_pic_name_inp[]" required="required" class="form-control" placeholder="Masukkan Nama PIC" />
						</div>
						<div class="col-md-3" style="margin-top:20px">
							<label class="control-label">Keterangan Jabatan *</label>
							<input maxlength="100" type="text" name="vmp_pic_position_inp[]" required="required" class="form-control" placeholder="Masukkan Jabatan PIC" />
						</div>
						<div class="col-md-4" style="margin-top:20px">
							<label class="control-label">No Handphone *</label>
							<input maxlength="100" type="text" name="vmp_pic_contact_inp[]" required="required" class="form-control" placeholder="Masukkan Nomor Handphone" />
						</div>
						<div class="col-md-1" style="margin-top:45px">
							<button type='button' class='btn btn-danger btn-xs delete_pic'>
							<i class='fa fa-remove'></i>
							</button>
						</div>
					</div>`
					
					$('.pic_mandor').append(appendData)
				});
				let noBidang = 2;
				$(".add_bidang_mandor").on("click", function(e) {
					let appendData = `
					<div class="key">
						<div class="col-md-5">
							<label class="control-label">Bidang *</label>
							<select class="form-control m-b bidang" data-no="${noBidang}" name="vmb_bidang_code_inp[]">
								<option>Pilih Bidang</option>
								<?php foreach ($bidang as $k => $v) { ?>
									<option value="<?php echo $v['am_kode'] ?>"><?php echo $v['am_name'] ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6">
							<label class="control-label">Sub Bidang *</label>		
							<select class="form-control m-b sub_bidang" data-no="${noBidang}" name="vmb_sub_bidang_code_inp[]">
								<option>Pilih Sub Bidang</option>
							</select>
						</div>
						<div class="col-md-1" style="margin-top:20px">
							<button type='button' class='btn btn-danger btn-xs delete_bidang_mandor'>
							<i class='fa fa-remove'></i>
							</button>
						</div>
					</div>`
					
					$('.bidang_mandor').append(appendData)
					noBidang++
				});
				$(".add_proyek").on("click", function(e) {
					if(data.index_bidang_pengalaman > 0){
						data.index_bidang_pengalaman = 0
					}
					data.index_bidang_pengalaman++;
					noBidangProyek++
					let appendData = `
					<div class="key">
						<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px; margin-top:60px">
							<div class="form-group row">
								<div class="col-md-4">
									<label class="control-label">Tahun Proyek *</label>
									<select class="form-control m-b" name="vmpe_year_inp[]">
										<option>Pilih Tahun</option>
										<?php for($i=2000;$i<=2050;$i++){?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php }?>
										<option>2018</option>
										<option>2019</option>
										<option>2020</option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="control-label">Nama Proyek *</label>
									<input name="vmpe_project_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Proyek" />
								</div>
								<div class="col-md-3">
									<label class="control-label">Nilai Pekerjaan *</label>
									<input name="vmpe_project_value_inp[]" max="99999999999999999999" type="text"  required="required" class="form-control rupiah" placeholder="Masukkan Nilai pekerjaan" />
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button type='button' class='btn btn-danger btn-xs delete_bidang_mandor'>
									<i class='fa fa-remove'></i>
									</button>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<label class="control-label">Nama Kontraktor *</label>
									<input name="vmpe_contractor_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Proyek" />
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<label class="control-label">Upload Bukti Proyek, Ditandatangani Manager Proyek *</label>
									<input name="vmpe_evidence_project_inp[]" type="file" required="required" class="form-control" placeholder="Upload Bukti Proyek" />
								</div>
							</div>
							<div class="form-group row" >
								<div class="col-md-12" style="color:#0288D1">
									<h3>Bidang</h3>
									<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px">
										<div class="bidang_pengalaman_${noBidangProyek}">
											<div class="row">
												<div class="col-md-4">
													<label class="control-label">Bidang *</label>
													<select class="form-control m-b bidang_proyek" data-no="${noBidangProyek}"  data-sub-no="${data.index_bidang_pengalaman}" name="vmb_bidang_code_proyek_inp[${noBidangProyek}][]" >
													<option value="">Pilih Bidang</option>
													<?php foreach ($bidang as $k => $v) { ?>
														<option value="<?php echo $v['am_kode'] ?>"><?php echo $v['am_name'] ?></option>
													<?php } ?>
												</select>
												</div>
												<div class="col-md-7">
													<label class="control-label">Sub Bidang *</label>
													<select class="form-control m-b sub_bidang_proyek" data-no="${noBidangProyek}"data-sub-no="${data.index_bidang_pengalaman}" name="vmb_sub_bidang_code_proyek_inp[${noBidangProyek}][]" >
														<option value="">Pilih Sub Bidang</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button class="btn btn-primary col-md-12 btn-action" style="margin-top:20px" type="button" data-category="bidang-pengalaman" data-no="${noBidangProyek}" data-action="add"><i class="fa fa-plus"></i> Tambah Bidang</button>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<div style="font-size: 11px">
				                        <i>Max file 5 MB 
				                        <br>
				                          File Type : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
				                        </i>
			                     	</div>
								</div>
							</div>
						</div>
					</div>`
					
					$('.proyek').append(appendData)
				});
			});
			$(".addahliBidangMandor").on("click", function(e) {
				let appendData = `
				<div class="key">
					<div class="col-md-8" style="margin-top:20px">
						<label class="control-label">Ahli Bidang *</label>
						<input name="vmtq_ahli_bidang_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Ahli Bidang" />
					</div>
					<div class="col-md-3" style="margin-top:20px">
						<label class="control-label">Jumlah *</label>
						<input name="vmtq_qty_ahli_bidang_inp[]" max="99999999999999999999" type="text"  required="required" class="form-control number" placeholder="Masukkan Jumlah Ahli Bidang" />
					</div>
					<div class="col-md-1" style="margin-top:45px">
						<button type='button' class='btn btn-danger btn-xs delete_ahliBidangMandor'>
						<i class='fa fa-remove'></i>
						</button>
					</div>
				</div>`
				
				$('.ahliBidangMandor').append(appendData)
			});
			
			$(".addDaftarPeralatan").on("click", function(e) {
				let appendData = `
				<div class="key">
					<div class="col-md-12" style="background-color:rgba(206, 214, 220, 0.16); padding:20px; margin-top:20px">
						<div class="form-group row">
							<div class="col-md-5">
								<label class="control-label">Nama Peralatan *</label>
								<input name="vmt_tools_name_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Nama Peralatan" />
							</div>
							<div class="col-md-6">
								<label class="control-label">Merek *</label>
								<input name="vmt_tool_brand_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Masukkan Merek Peralatan" />
							</div>
							<div class="col-md-1" style="margin-top:20px">
								<button type='button' class='btn btn-danger btn-xs delete_daftarPeralatan'>
								<i class='fa fa-remove'></i>
								</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-5">
								<label class="control-label">Jumlah Peralatan *</label>
								<input name="vmt_qty_tools_inp[]" max="99999999999999999999" type="text"  required="required" class="form-control number" placeholder="Masukkan Jumlah Peralatan" />
							</div>
							<div class="col-md-6">
								<label class="control-label">Kondisi *</label>
								<input name="vmt_condition_inp[]" maxlength="100" type="text" required="required" class="form-control" placeholder="Jelaskan Kodisi peralatan" />
							</div>
						</div>
					</div>
				</div>`
				
				$('.DaftarPeralatan').append(appendData)
			});
			const _logic = {
				app: (elem) => {
					debugger
					switch ($(elem).attr('data-category')) {
						case 'bidang-pengalaman':
							switch ($(elem).attr('data-action')) {
								case 'add':
									const content = _template[$(elem).attr('data-category')]()
									$(`.bidang_pengalaman_${$(elem).attr('data-no')}`).append(content)
									break;
								case 'delete':
									$(elem).closest('div.row').remove();
									break;									
								default:
									alert('Oops Something Went wrong')
									break;
							}
							break;
					
						default:
							alert('Oops Something Went wrong')
							break;
					}
				},
				action: (elem) => {
				}
			}
			const _event = () => {
				$(document).on('keyup', '.number',function(){
					this.value = this.value.match(/[0-9]+/g)
				})
				$(document).on('keyup', '.rupiah',function(){
					this.value = formatRupiah(this.value, 'Rp. ');
				})
				$(document).on('click', '.btn-action',function(){
					_logic.app(this)
				})
				$(document).on('change', '.sub_bidang_proyek',function(){
					//listing selected sub bidang
					console.log(data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`] || 'kosong')
					if(data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`]){
						if(!data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`].includes($(this).val())){
							data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`].push($(this).val())
						}
					}else{
						data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`] = []
						data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`].push($(this).val())
					}
					console.log(data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`] || 'kosong lagi')
				})
			}
			const _template = {
				"bidang-pengalaman": () => {
					debugger
					data.index_bidang_pengalaman++;
					return `<div class="row">
								<div class="col-md-4">
									<label class="control-label">Bidang *</label>
									<select class="form-control m-b bidang_proyek" data-no="${noBidangProyek}" data-sub-no="${data.index_bidang_pengalaman}" name="vmb_bidang_code_proyek_inp[${noBidangProyek}][]" >
									<option value="">Pilih Bidang</option>
										<?php foreach ($bidang as $k => $v) { ?>
											<option value="<?php echo $v['am_kode'] ?>"><?php echo $v['am_name'] ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-7">
									<label class="control-label">Sub Bidang *</label>
									<select class="form-control m-b sub_bidang_proyek" data-no="${noBidangProyek}" data-sub-no="${data.index_bidang_pengalaman}" name="vmb_sub_bidang_code_proyek_inp[${noBidangProyek}][]" >
									<option value="">Pilih Sub Bidang</option>
									
									</select>
								</div>
								<div class="col-md-1" style="margin-top:45px">
									<button type='button' class='btn btn-danger btn-xs btn-action' data-action='delete' data-category='bidang-pengalaman'>
									<i class='fa fa-remove'></i>
									</button>
								</div>
							</div>`
				}
			}
		</script>

		<script>
		    $(document.body).on("click", ".delete_pic", function(e) {
				e.preventDefault();
				$(this).closest('div.key').remove();
			});
			$(document.body).on("click", ".delete_bidang_mandor", function(e) {
				e.preventDefault();
				$(this).closest('div.key').remove();
				noBidang--
			});
			
			$(document.body).on("click", ".delete_ahliBidangMandor", function(e) {
				e.preventDefault();
				$(this).closest('div.key').remove();
			});
			$(document.body).on("click", ".delete_daftarPeralatan", function(e) {
				e.preventDefault();
				$(this).closest('div.key').remove();
			});
			$(document.body).on("change",'.bidang', function(e) {
				let bidang_code = $(this).val()
				let dataNo = $(this).attr('data-no')
				
				$.ajax({
					url: "<?php echo site_url('welcome/get_sub_bidang') ?>",
					datatype: "json",
					type: "POST",
					data: {
						bidang_code: bidang_code,
						selected_sub_bidang: data.selected_sub_bidang
					},
					success: function(data) {
						d = JSON.parse(data)
						let subBidang = d.data.map((v)=>{
							return(`
								<option value="${v.am_kode}">${v.am_name}</option>
							`)
						})
						$(`.sub_bidang[data-no=${dataNo}]`).html("")
						$(`.sub_bidang[data-no=${dataNo}]`).append(`<option>Pilih Sub Bidang</option>${subBidang}`)
						$(`.sub_bidang[data-no=${dataNo}]`).trigger('change')
					}
				});
			});
			$(document.body).on("input",'input[type=number]', function(e) {
				if (this.value.length > 20) {
					this.value = this.value.slice(0,20); 
				}
			});
			$(document).on('change', '.sub_bidang',function(){
				//listing selected sub bidang
				if(!data.selected_sub_bidang.includes($(this).val())){
					data.selected_sub_bidang.push($(this).val())
				}
			})
			$(document.body).on("change",'.bidang_proyek', function(e) {
					console.log( data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`] || 'kosong')
					let bidang_code = $(this).val()
					let dataNo = $(this).attr('data-no')
					let dataSubNo = $(this).attr('data-sub-no')
					$.ajax({
						url: "<?php echo site_url('welcome/get_sub_bidang') ?>",
						datatype: "json",
						type: "POST",
						data: {
							bidang_code: bidang_code,
							selected_sub_bidang: data.selected_sub_bidang_proyek[`${$(this).attr('data-no')}`] || []
						},
						success: function(data) {
							d = JSON.parse(data)
							let subBidang = d.data.map((v)=>{
								return(`
									<option value="${v.am_kode}">${v.am_name}</option>
								`)
							})
							$(`.sub_bidang_proyek[data-no=${dataNo}][data-sub-no=${dataSubNo}]`).html("")
							$(`.sub_bidang_proyek[data-no=${dataNo}][data-sub-no=${dataSubNo}]`).append(`<option>Pilih Sub Bidang</option>${subBidang}`)
						}
					});
				});
		</script>

	<script type="text/javascript">
	
			/* Fungsi formatRupiah */
			function formatRupiah(angka, prefix){
				var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split   		= number_string.split(','),
				sisa     		= split[0].length % 3,
				rupiah     		= split[0].substr(0, sisa),
				ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
	
				// tambahkan titik jika yang di input sudah menjadi angka ribuan
				if(ribuan){
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
	
				rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
				return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
			}
	</script>



		<script>
			$(document).ready(function () {
			var navListItems = $('div.setup-panel div button'),
				allWells = $('.setup-content'),
				allNextBtn = $('.nextBtn');
			allWells.hide();
			navListItems.click(function (e) {
				e.preventDefault();
				var $target = $($(this).attr('href')),
					$item = $(this);
				if (!$item.hasClass('disabled')) {
					navListItems.removeClass('btn-success').addClass('btn-primary');
					$item.addClass('btn-primary');
					$item.removeClass('btn-default');
					allWells.hide();
					$target.show();
					$target.find('input:eq(0)').focus();
				}
			});
			allNextBtn.click(function () {
				var curStep = $(this).closest(".setup-content"),
					curStepBtn = curStep.attr("id"),
					nextStepWizard = $('div.setup-panel div button[href="#' + curStepBtn + '"]').parent().next().children("button"),
					curInputs = curStep.find("input[type='text'],input[type='url'], input[type='number'], input[type='file']"),
					isValid = true;
				$(".form-group").removeClass("has-error");
				for (var i = 0; i < curInputs.length; i++) {
					if (!curInputs[i].validity.valid) {
						isValid = false;
						$(curInputs[i]).closest(".form-group").addClass("has-error");
					}
				}
				if(document.getElementsByClassName('has-error').length > 0) document.getElementsByClassName('has-error')[0].childNodes[document.getElementsByClassName('has-error')[0].childNodes.length - 2].focus()
				
				if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
				
			});
			$('div.setup-panel div button.btn-primary').trigger('click');
			});
		</script>


</body>

</html>