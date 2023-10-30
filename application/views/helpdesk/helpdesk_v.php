<!DOCTYPE html>
<html class="loading" lang="en">
<!-- BEGIN : Head-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="author" content="PIXINVENT">
	<title>PT WIJAYA KARYA (Persero) Tbk</title>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets') ?>/img/favicon.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
	<!-- BEGIN VENDOR CSS-->
	<!-- font icons-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/fonts/feather/style.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/fonts/simple-line-icons/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/fonts/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/vendors/css/perfect-scrollbar.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/vendors/css/prism.min.css">
	<!-- END VENDOR CSS-->
	<!-- BEGIN APEX CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/bootstrap-extended.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/colors.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/css/components.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets')?>/app-assets/css/toastr/toastr.min.css">
	<style>
		html,
		body {
			font-family: "Avenir";
			background: url("<?php echo base_url('assets/img/bg-blue.jpg') ?>") no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}

		li {
			font-size: 16px;
			text-align: justify;
		}

		.colh {
			-ms-flex-preferred-size: 0;
			flex-basis: 0;
			-ms-flex-positive: 1;
			flex-grow: 1;
			max-width: 100%;
			position: relative;
			width: 100%;
			padding-right: 15px;
			padding-left: 15px;
		}

		.title-main {
			font-size: 28px;
			color: #565655;
			padding: 15px 15px 5px 15px;
			font-weight: 700;
		}

		.title-sub {
			font-size: 18px;
			color: #565655;
			margin-bottom: 0;
			margin-top: 0;
			padding: 10px 10px 0 10px;
			font-weight: 700;
		}

		.text-confirm {
			font-size: 20px;
			padding: 0;
			margin-bottom: 0;
			font-weight: 700;
			color: #565656;
		}
	</style>
	<!-- END: Custom CSS-->
</head>
<!-- END : Head-->
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/plugins/switchery.css">
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/vendors/css/swiper.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/pages/page-faq.css">
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/pages/ex-component-swiper.css">

<body class="vertical-layout">
	<div class="container">
		<div class="wrapper">
			<div class="main-panel">
				<!-- BEGIN : Main Content-->
				<div class="main-content">
					<div class="content-overlay"></div>
					<div class="content-wrapper">
						<section class="faq-wrapper">
							<div class="faq-search">
								<div class="row">
									<div class="col-12">
										<div class="card faq-bg bg-transparent box-shadow-0">
											<div class="card-content">
												<div class="card-body">
													<h1 class="faq-title text-center">Selamat Datang di Helpdesk</h1>
													<h1 class="faq-title text-center mb-3">ESCM WIKA</h1>
													<p class="card-text text-center font-medium-1 mt-3">Pilih Kategori Kendala Anda</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- faq starts -->
							<div class="faq">
								<div class="row">
									<div class="col-12">
										<div class="card bg-transparent shadow-none">
											<div class="card-content">
												<div class="card-body py-2">
													<div class="swiper-centered-slides swiper-container p-3">
														<div class="swiper-wrapper">
															<div class="swiper-slide rounded swiper-shadow" id="pricing-plans-text">
																<i class="ft-dollar-sign font-large-1"></i>
																<div class="swiper-text pt-md-2 pt-sm-1">Info Lelang</div>
															</div>
															<div class="swiper-slide rounded swiper-shadow" id="sales-question-text">
																<i class="ft-users font-large-1"></i>
																<div class="swiper-text pt-md-2 pt-sm-1">Pendaftaran</div>
															</div>
															<div class="swiper-slide rounded swiper-shadow" id="usage-guide-text">
																<i class="ft-mail font-large-1"></i>
																<div class="swiper-text pt-md-2 pt-sm-1">Aktifasi Email</div>
															</div>
															<div class="swiper-slide rounded swiper-shadow" id="general-guide-text">
																<i class="ft-info font-large-1"></i>
																<div class="swiper-text pt-md-2 pt-sm-1">Lainnya</div>
															</div>
														</div>
														<!-- Add Arrows -->
														<div class="swiper-button-next"></div>
														<div class="swiper-button-prev"></div>
													</div>

													<div class="main-wrapper-content">
														<!-- Info Lelang  -->
														<div class="wrapper-content" data-faq="pricing-plans-text">
															<div class="text-center p-md-4 p-sm-1 py-1 p-0">
																<h1 class="faq-title">Info Lelang</h1>
																<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
															</div>
															<div class="card collapse-icon accordion-icon-rotate">
																<div class="accordion" id="Accordion2">
																	<div class="card-content">
																		<div class="card-body">
																			<?php foreach ($get_list1 as $value) { ?>
																				<div class="card-header border-bottom p-2">
																					<a data-toggle="collapse" href="#accordion<?php echo $value['faq_id']; ?>" aria-expanded="false" aria-controls="accordion29" class="card-title text-info"><?php echo $value['question']; ?></a>
																				</div>
																				<div id="accordion<?php echo $value['faq_id']; ?>" class="collapse" data-parent="#Accordion2">
																					<div class="card-body">
																						<textarea rows="6" class="form-control round" readonly><?php echo $value['answer']; ?></textarea>
																					</div>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<!-- Pendaftaran Accordion -->
														<div class="wrapper-content active" data-faq="sales-question-text">
															<div class="text-center p-md-4 p-sm-1 py-1 p-0">
																<h1 class="faq-title">Pendaftaran</h1>
																<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
															</div>
															<div class="card collapse-icon accordion-icon-rotate">
																<div class="accordion" id="Accordion5">
																	<div class="card-content">
																		<div class="card-body">
																			<?php foreach ($get_list2 as $value) { ?>
																				<div class="card-header border-bottom p-2">
																					<a data-toggle="collapse" href="#accordionpendaftaran<?php echo $value['faq_id']; ?>" aria-expanded="false" aria-controls="accordion" class="card-title text-info"><?php echo $value['question']; ?></a>
																				</div>
																				<div id="accordionpendaftaran<?php echo $value['faq_id']; ?>" class="collapse" data-parent="#Accordion5">
																					<div class="card-body">
																						<textarea rows="6" class="form-control round" readonly><?php echo $value['answer']; ?></textarea>																						
																					</div>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<!-- Aktifitas Email Accordion -->
														<div class="wrapper-content" data-faq="usage-guide-text">
															<div class="text-center p-md-4 p-sm-1 py-1 p-0">
																<h1 class="faq-title">Aktifasi Email</h1>
																<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
															</div>
															<div class="card collapse-icon accordion-icon-rotate">
																<div class="accordion" id="faqAccordion4">
																	<div class="card-content">
																		<div class="card-body">
																			<?php foreach ($get_list3 as $value) {; ?>
																				<div class="card-header border-bottom p-2">
																					<a data-toggle="collapse" href="#accordion<?php echo $value['faq_id']; ?>" aria-expanded="false" aria-controls="accordion29" class="card-title text-info"><?php echo $value['question']; ?></a>
																				</div>
																				<div id="accordion<?php echo $value['faq_id']; ?>" class="collapse" data-parent="#faqAccordion5">
																					<div class="card-body">
																						<textarea rows="6" class="form-control round" readonly><?php echo $value['answer']; ?></textarea>
																					</div>
																				</div>
																			<?php } ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<!-- Lainnya Accordion -->
														<div class="wrapper-content" data-faq="general-guide-text">
															<div class="text-center p-md-4 p-sm-1 py-1 p-0">
																<h1 class="faq-title">Lainnya</h1>
																<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
															</div>
															<div class="card collapse-icon accordion-icon-rotate">
																<div class="accordion" id="faqAccordion5">
																	<div class="card-content">
																		<div class="card-body">
																			<?php foreach ($get_list4 as $value) { ?>
																				<div class="card-header border-bottom p-2">
																					<a data-toggle="collapse" href="#accordion<?php echo $value['faq_id']; ?>" aria-expanded="false" aria-controls="accordion29" class="card-title text-info"><?php echo $value['question']; ?></a>
																				</div>
																				<div id="accordion<?php echo $value['faq_id']; ?>" class="collapse" data-parent="#faqAccordion5">
																					<div class="card-body">
																						<textarea rows="6" class="form-control round" readonly><?php echo $value['answer']; ?></textarea>
																					</div>
																				</div>
																			<?php } ?>
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
							</div>
							<!-- faq ends -->
							<!-- faq contact starts -->
							<div class="faq-contact">
								<div class="row mb-2">
									<div class="col-12 text-center">
										<h3 class="faq-subtitle my-3">Tidak menemukan solusi kendala yang Anda hadapi?</h3>
										<p class="text-muted font-medium-1 m-0">Jika Anda tidak dapat menemukan pertanyaan di FAQ kami,</p>
										<p class="text-muted font-medium-1 mb-3">Anda selalu dapat menghubungi kami. Kami akan segera menjawab Anda!</p>
									</div>
								</div>
								<div class="row d-flex justify-content-center mb-3">
									<div class="col-md-4 col-sm-6 kb-content-card">
										<div class="card">
											<div class="card-content">
												<div class="card-body text-center p-4">
													<a href="page-knowledge-categories.html">
														<i class="ft-link font-medium-5"></i>
														<h5 class="mt-2">New Ticket</h5>
														<p class="m-0 text-muted">Lapor disini, kami siap membantu Anda</p>
														<a href="#" class="btn btn-sm btn-info mt-3" data-toggle="modal" data-target="#ticketForm">New Ticket</a>
													</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-6 kb-content-card">
										<div class="card">
											<div class="card-content">
												<div class="card-body text-center p-4">
													<a href="page-knowledge-categories.html">
														<i class="ft-smartphone font-medium-5"></i>
														<h5 class="mt-2">Check Ticket</h5>
														<p class="m-0 text-muted">Sudah punya Ticket? Cek disini</p>
														<a href="<?php echo base_url('helpdesk/check_ticket') ?>" class="btn btn-sm btn-info mt-3">Check Ticket</a>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- faq contact ends -->
						</section>

						<!-- Modal -->
						<div class="modal fade text-left" id="ticketForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title modal-judul" id="myModalLabel">Tambah Ticket Baru</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
										</button>
									</div>
									<form name="formticket" action="<?php echo base_url('helpdesk/addTicket'); ?>" method="POST" onsubmit="return validateForm()">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6 col-12">
													<div class="form-group mb-2">
														<label class="col-form-label">Nama Perusahaan</label>
														<input type="text" class="form-control round" name="nama_perusahaan" placeholder="nama perusahaan">
													</div>
												</div>
												<div class="col-md-6 col-12">
													<div class="form-group mb-2">
														<label class="col-form-label">NPWP</label>
														<input type="text" class="form-control round" name="npwp_no" placeholder="nomor npwp">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 col-12">
													<div class="form-group mb-2">
														<label class="col-form-label">Email</label>
														<input type="email" class="form-control round" name="email_perusahaan" placeholder="email perusahaan">
													</div>
												</div>
												<div class="col-md-6 col-12">
													<div class="form-group mb-2">
														<label class="col-form-label">Telepon</label>
														<input type="text" class="form-control round" name="no_telp" placeholder="nomor telepon">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 col-12">
													<div class="form-group mb-2">
														<label class="col-form-label">Alamat</label>
														<textarea rows="6" class="form-control round" name="alamat" placeholder="alamat perusahaan"></textarea>
													</div>
												</div>
												<div class="col-md-6 col-12">
													<div class="form-group mb-2">
														<label class="col-form-label">Pertanyaan</label>
														<textarea rows="6" class="form-control round" name="deskripsi_pertanyaan" placeholder="deskripsi pertanyaan"></textarea>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 col-12">
													<div class="form-group mb-2">
														<label class="col-form-label">Kategori</label>
														<select class="form-control round" name="kategori" required>
															<option value="" selected disabled>Pilih</option>
															<option value="Lelang Info">Lelang Info</option>
															<option value="Pendaftaran">Pendaftaran</option>
															<option value="Aktifasi Email">Aktifasi Email</option>
															<option value="Lainnya">Lainnya</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Tutup">
											<input type="submit" onclick="return confirm('Apakah Anda yakin akan Simpan?')" class="btn btn-info mr-2" value="Simpan">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<footer class="footer undefined undefined mt-5">
					<p class="clearfix m-0"><span><strong>Copyright</strong> &copy; PT WIJAYA KARYA TBK &copy; 2018 - <?php echo date('Y'); ?> &nbsp;</span><span class="d-none d-sm-inline-block"></span></p>
				</footer>
				<!-- Scroll to top button -->
				<button class="btn btn-info scroll-top" type="button"><i class="ft-arrow-up"></i></button>

			</div>
		</div>
	</div>

	<div class="sidenav-overlay"></div>
	<div class="drag-target"></div>
	<!-- BEGIN VENDOR JS-->
	<script src="<?php echo base_url('assets'); ?>/app-assets/vendors/js/vendors.min.js"></script>
	<script src="<?php echo base_url('assets'); ?>/app-assets/vendors/js/switchery.min.js"></script>
	<script src="<?php echo base_url('assets'); ?>/app-assets/js/core/app-menu.js"></script>
	<script src="<?php echo base_url('assets'); ?>/app-assets/js/core/app.js"></script>
	<script src="<?php echo base_url('assets'); ?>/app-assets/js/notification-sidebar.js"></script>
	<script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/toastr.min.js"></script>
	<script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/abe-toast.js"></script>
	<script src="<?php echo base_url('assets'); ?>/app-assets/js/customizer.js"></script>
	<script src="<?php echo base_url('assets'); ?>/app-assets/js/scroll-top.js"></script>
	<script src="<?php echo base_url('assets'); ?>/app-assets/js/components-modal.min.js"></script>
	<script src="<?php echo base_url('assets'); ?>/assets/js/scripts.js"></script>
	<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/swiper.min.js"></script>
	<script src="<?php echo base_url('assets') ?>/app-assets/js/page-faq.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			toasterOptions();
			response_data();

			function response_data() {
				if ('<?= $this->session->flashdata('tab') ?>' == 'ticket') {
					if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
						toastr.info('Ticket berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
					} else {
						toastr.error('Ticket gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
					}
				}
			}

		})

		function validateFormEmail() {
			if (document.forms["formfaqemail"]["question"].value == "") {
				alert("isi Pertanyaan");
				document.forms["formfaqemail"]["question"].focus();
				return false;
			}
			if (document.forms["formfaqemail"]["answer"].value == "") {
				alert("Isi Jawaban Tidak Boleh Kosong");
				document.forms["formfaqemail"]["answer"].focus();
				return false;
			}
		}

		function validateFormLelang() {
			if (document.forms["formlelang"]["question"].value == "") {
				alert("isi Pertanyaan");
				document.forms["formlelang"]["question"].focus();
				return false;
			}
			if (document.forms["formlelang"]["answer"].value == "") {
				alert("Isi Jawaban Tidak Boleh Kosong");
				document.forms["formlelang"]["answer"].focus();
				return false;
			}
		}

		function validateFormFaqPendaftaran() {
			if (document.forms["formfaqpendaftaran"]["question"].value == "") {
				alert("isi Pertanyaan");
				document.forms["formfaqpendaftaran"]["question"].focus();
				return false;
			}
			if (document.forms["formfaqpendaftaran"]["answer"].value == "") {
				alert("Isi Jawaban Tidak Boleh Kosong");
				document.forms["formfaqpendaftaran"]["answer"].focus();
				return false;
			}
		}

		function validateformlain() {
			if (document.forms["formfaqlainnya"]["question"].value == "") {
				alert("isi Pertanyaan");
				document.forms["formfaqlainnya"]["question"].focus();
				return false;
			}
			if (document.forms["formfaqlainnya"]["answer"].value == "") {
				alert("Isi Jawaban Tidak Boleh Kosong");
				document.forms["formfaqlainnya"]["answer"].focus();
				return false;
			}
		}
	</script>
</body>

</html>
