<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/plugins/switchery.css">
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/vendors/css/swiper.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/pages/page-faq.css">
<link rel="stylesheet" href="<?php echo base_url('assets') ?>/app-assets/css/pages/ex-component-swiper.css">
<style>
	body {
		font-family: "Avenir";
		background: url("<?php echo base_url('assets/img/bg-blue.jpg') ?>") no-repeat center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
</style>

<body class="vertical-layout">
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
											<button type="button" class="btn bg-light-info btn-sm" data-toggle="modal" data-target="#faqForm1">
												<i class="ft-plus"></i> Tambah FAQ Lelang Info
											</button>

											<!-- Modal-faq-lelang-info -->
											<div class="modal fade text-left" id="faqForm1" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h3 class="modal-title modal-judul">Form Tambah FAQ Lelang Info</h3>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
															</button>
														</div>
														<form name="formlelang" action="<?php echo base_url('administration/helpdesk/faq/add_faq'); ?>" method="POST" onsubmit="return validateFormLelang()">
															<div class="modal-body">
																<input type="hidden" name="category" value="1" />
																<label>Deskripsi Pertanyaan : </label>
																<div class="form-group position-relative has-icon-left">																	
																	<textarea rows="6" class="form-control round" name="question" placeholder="Isi pertanyaan" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-mail font-medium-2 text-muted"></i>
																	</div>
																</div>

																<label>Deskripsi Jawaban : </label>
																<div class="form-group position-relative has-icon-left">
																	<textarea rows="6" class="form-control round" name="answer" placeholder="Isi jawaban" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-lock font-medium-2 text-muted"></i>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
																<input type="submit" class="btn btn-info" value="Simpan">
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="card collapse-icon accordion-icon-rotate">
											<div class="accordion" id="faqAccordion2">
												<div class="card-content">
													<div class="card-body">
														<?php foreach ($get_list1 as $value) { ?>
															<div class="card-header border-bottom p-2">
																<a href="<?php echo base_url('administration/helpdesk/faq/delete_faq/' . $value['faq_id']);?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')"><i class="ft-trash text-danger mr-2"></i></a>
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

									<!-- Pendaftaran Accordion -->
									<div class="wrapper-content active" data-faq="sales-question-text">
										<div class="text-center p-md-4 p-sm-1 py-1 p-0">
											<h1 class="faq-title">Pendaftaran</h1>
											<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
											<button type="button" class="btn bg-light-info btn-sm" data-toggle="modal" data-target="#faqForm2">
												<i class="ft-plus"></i> Tambah FAQ Pendaftaran
											</button>

											<!-- Modal-faq-pendaftaran -->
											<div class="modal fade text-left" id="faqForm2" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h3 class="modal-title modal-judul">Form Tambah FAQ Pendaftaran</h3>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
															</button>
														</div>
														<form name="formfaqpendaftaran" action="<?php echo base_url('administration/helpdesk/faq/add_faq'); ?>" method="POST" onsubmit="return validateFormFaqPendaftaran()">
															<div class="modal-body">
																<input type="hidden" name="category" value="2" />
																<label>Deskripsi Pertanyaan : </label>
																<div class="form-group position-relative has-icon-left">
																	<textarea rows="6" class="form-control round" name="question" placeholder="Isi pertanyaan" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-mail font-medium-2 text-muted"></i>
																	</div>
																</div>

																<label>Deskripsi Jawaban : </label>
																<div class="form-group position-relative has-icon-left">
																	<textarea rows="6" class="form-control round" name="answer" placeholder="Isi jawaban" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-lock font-medium-2 text-muted"></i>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
																<input type="submit" class="btn btn-info" value="Simpan">
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="card collapse-icon accordion-icon-rotate">
											<div class="accordion" id="faqAccordion3">
												<div class="card-content">
													<div class="card-body">
														<?php foreach ($get_list2 as $value) { ?>
															<div class="card-header border-bottom p-2">
																<a href="<?php echo base_url('administration/helpdesk/faq/delete_faq/' . $value['faq_id']);?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')"><i class="ft-trash text-danger mr-2"></i></a>
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

									<!-- Aktifitas Email Accordion -->
									<div class="wrapper-content" data-faq="usage-guide-text">
										<div class="text-center p-md-4 p-sm-1 py-1 p-0">
											<h1 class="faq-title">Aktifasi Email</h1>
											<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam reprehenderit alias voluptas aspernatur maiores quis molestiae totam deserunt exercitationem ipsam officiis nisi, labore magni, commodi quaerat quia earum quas illo ea amet minus ad dolor?</p>
											<button type="button" class="btn bg-light-info btn-sm" data-toggle="modal" data-target="#faqForm3">
												<i class="ft-plus"></i> Tambah FAQ Aktifasi Email
											</button>

											<!-- Modal-faq-aktifasi-email -->
											<div class="modal fade text-left" id="faqForm3" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h3 class="modal-title modal-judul">Form Tambah FAQ Aktifasi Email</h3>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
															</button>
														</div>
														<form name="formfaqemail" action="<?php echo base_url('administration/helpdesk/faq/add_faq'); ?>" method="POST" onsubmit="return validateFormEmail()">
															<div class="modal-body">
																<input type="hidden" name="category" value="3" />
																<label>Deskripsi Pertanyaan : </label>
																<div class="form-group position-relative has-icon-left">
																	<textarea rows="6" class="form-control round" name="question" placeholder="Isi pertanyaan" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-mail font-medium-2 text-muted"></i>
																	</div>
																</div>

																<label>Deskripsi Jawaban : </label>
																<div class="form-group position-relative has-icon-left">
																	<textarea rows="6" class="form-control round" name="answer" placeholder="Isi jawaban" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-lock font-medium-2 text-muted"></i>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
																<input type="submit" class="btn btn-info" value="Simpan">
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="card collapse-icon accordion-icon-rotate">
											<div class="accordion" id="faqAccordion4">
												<div class="card-content">
													<div class="card-body">
														<?php foreach ($get_list3 as $value) {; ?>
															<div class="card-header border-bottom p-2">
																<a href="<?php echo base_url('administration/helpdesk/faq/delete_faq/' . $value['faq_id']);?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')"><i class="ft-trash text-danger mr-2"></i></a>
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
											<button type="button" class="btn bg-light-info btn-sm" data-toggle="modal" data-target="#faqForm4">
												<i class="ft-plus"></i> Tambah FAQ Lainnya
											</button>

											<!-- Modal-faq-lainnya -->
											<div class="modal fade text-left" id="faqForm4" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h3 class="modal-title modal-judul">Form Tambah FAQ Lainnya</h3>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
															</button>
														</div>
														<form name="formfaqlainnya" action="<?php echo base_url('administration/helpdesk/faq/add_faq'); ?>" method="POST" onsubmit="return validateformlain()">
															<div class="modal-body">
																<input type="hidden" name="category" value="4" />
																<label>Deskripsi Pertanyaan : </label>
																<div class="form-group position-relative has-icon-left">
																	<textarea rows="6" class="form-control round" name="question" placeholder="Isi pertanyaan" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-mail font-medium-2 text-muted"></i>
																	</div>
																</div>

																<label>Deskripsi Jawaban : </label>
																<div class="form-group position-relative has-icon-left">
																	<textarea rows="6" class="form-control round" name="answer" placeholder="Isi jawaban" required></textarea>
																	<div class="form-control-position">
																		<i class="ft-lock font-medium-2 text-muted"></i>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
																<input type="submit" class="btn btn-info" value="Simpan">
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="card collapse-icon accordion-icon-rotate">
											<div class="accordion" id="faqAccordion5">
												<div class="card-content">
													<div class="card-body">
														<?php foreach ($get_list4 as $value) { ?>
															<div class="card-header border-bottom p-2">
																<a href="<?php echo base_url('administration/helpdesk/faq/delete_faq/' . $value['faq_id']);?>" onclick="return confirm('Apakah Anda yakin hapus data ini?')"><i class="ft-trash text-danger mr-2"></i></a>
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
									<a href="<?php echo base_url('administration/helpdesk/ticket'); ?>" class="btn btn-sm btn-info mt-3">New Ticket</a>
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
									<p class="m-0 text-muted">Sudah punya Ticket? Anda bisa cek disini</p>
									<a href="<?php echo base_url('administration/helpdesk/ticket'); ?>" class="btn btn-sm btn-info mt-3">Check Ticket</a>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- faq contact ends -->
	</section>
</body>

<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/switchery.min.js"></script>
<script src="<?php echo base_url('assets') ?>/app-assets/vendors/js/swiper.min.js"></script>
<script src="<?php echo base_url('assets') ?>/app-assets/js/page-faq.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		toasterOptions();
		response_data();
		response_del();

		function response_data() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'faq') {
				if ('<?php echo $this->session->flashdata('status') ?>' == '1') {
					toastr.info('FAQ berhasil ditambah.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('FAQ gagal ditambah.', '<i class="ft ft-alert-triangle"></i> Error!');
				}
			}
		}

		function response_del() {
			if ('<?php echo $this->session->flashdata('tab') ?>' == 'del') {
				if ('<?php echo $this->session->flashdata('res') ?>' == '1') {
					toastr.info('FAQ berhasil dihapus.', '<i class="ft ft-check-square"></i> Success!');
				} else {
					toastr.error('FAQ gagal dihapus.', '<i class="ft ft-alert-triangle"></i> Error!');
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
