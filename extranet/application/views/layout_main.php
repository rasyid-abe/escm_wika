<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">

	<link rel="manifest" href="<?php echo base_url('manifest.json') ?>">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png') ?>">

	<title>eSCM <?php echo COMPANY_NAME ?></title>

	<!-- App asset -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/fonts/feather/style.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/fonts/simple-line-icons/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/fonts/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/vendors/css/perfect-scrollbar.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/vendors/css/prism.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/vendors/css/switchery.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/custom.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/bootstrap-extended.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/colors.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/components.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/app-assets/css/plugins/switchery.css">

	<!-- Bootstrap-table -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugin/bootstrap-table/dist/bootstrap-table.min.css') ?>" />

	<!-- Data Tables -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/vendors/css/datatables/dataTables.bootstrap4.min.css">
	<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.responsive.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.tableTools.min.css') ?>" rel="stylesheet">

	<!-- Date Picker -->
	<link href="<?php echo base_url('assets/css/plugins/datapicker/datepicker3.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/animate.css') ?>" rel="stylesheet">

	<!-- Check Box -->
	<link href="<?php echo base_url('assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') ?>" rel="stylesheet">

	<!-- iCheck -->
	<link href="<?php echo base_url('assets/css/plugins/iCheck/custom.css') ?>" rel="stylesheet">

	<!-- Sweet Alert -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/sweetalert/sweetalert.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/plugins/toastr/toastr.min.css') ?>">

	<!-- App asset -->
	<script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/vendors.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/switchery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/app-assets/js/core/app-menu.js"></script>
	<script src="<?php echo base_url(); ?>assets/app-assets/js/core/app.js"></script>
	<script src="<?php echo base_url(); ?>assets/app-assets/js/customizer.js"></script>
	<script src="<?php echo base_url(); ?>assets/app-assets/js/scroll-top.js"></script>

	<!-- Mainly scripts -->
	<script src="<?php echo base_url('assets/js/jquery-2.1.1.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.form.min.js') ?>"></script>

	<!-- Data Tables -->
	<script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/datatable/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.responsive.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.tableTools.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ajaxfileupload.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.form.js') ?>"></script>

	<!-- Custom and plugin javascript -->
	<script src="<?php echo base_url('assets/js/plugins/pace/pace.min.js') ?>"></script>

	<!-- AutoNumeric -->
	<script src="<?php echo base_url('assets/plugin/autoNumeric/autoNumeric.js') ?>"></script>

	<!-- jQuery UI -->
	<script src="<?php echo base_url('assets/js/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>

	<!-- Date Picker -->
	<script src="<?php echo base_url('assets/js/plugins/datapicker/bootstrap-datepicker.js') ?>"></script>

	<!-- Accounting.js -->
	<script src="<?php echo base_url('assets/js/accounting.min.js') ?>"></script>

	<!-- iCheck -->
	<script src="<?php echo base_url('assets/js/plugins/iCheck/icheck.min.js') ?>"></script>

	<!-- Sweet Alert -->
	<script src="<?php echo base_url('assets/js/plugins/sweetalert/sweetalert.min.js') ?>"></script>

	<!-- Jquery Validate -->
	<script src="<?php echo base_url('assets/js/plugins/validate/jquery.validate.min.js') ?>"></script>

	<script type="text/javascript" src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.12.0.min.js"></script>
	<script src="<?php echo base_url('assets/js/custom-messaging.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/numeral.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/toastr/toastr.min.js') ?>"></script>
	<script src="<?php echo base_url('assets') ?>/app-assets/js/toastr/abe-toast.js"></script>

	<!-- Bootstrap-table -->
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/bootstrap-table.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table-filter/src/bootstrap-table-filter.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/filter/bootstrap-table-filter.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/flat-json/bootstrap-table-flat-json.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/key-events/bootstrap-table-key-events.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/reorder-columns/bootstrap-table-reorder-columns.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/natural-sorting/bootstrap-table-natural-sorting.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/reorder-columns/bootstrap-table-reorder-columns.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/resizable/bootstrap-table-resizable.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/toolbar/bootstrap-table-toolbar.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugin/bootstrap-table/dist/extensions/editable/x-editable.js') ?>"></script>

	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			//y validasi input type number minimal 0
			$('input[type="number"]').attr({
				min: "0",
				oninput: "this.value = Math.abs(this.value)"
			});

			var is_link = false
			$(document).click(function(e) {
				var target = $(e.target);
				if (target.is("a") || (target.is("button") && target.has("a"))) {
					//Do what you want to do
					is_link = true
				}
			})
			window.onbeforeunload = function() {
				if (!is_link) {
					return "Apakah Anda yakin ingin meninggalkan laman ini?";
				}
			}

		})
	</script>

	<script type="text/javascript">
		var currenttime = '<?php echo date("F d, Y H:i:s") ?>' //PHP method of getting server date

		var montharray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
		var serverdate = new Date(currenttime)

		function padlength(what) {
			var output = (what.toString().length == 1) ? "0" + what : what
			return output
		}

		function displaytime() {
			serverdate.setSeconds(serverdate.getSeconds() + 1)
			var datestring = padlength(serverdate.getDate()) + " " + montharray[serverdate.getMonth()] + " " + serverdate.getFullYear() + " - "
			var timestring = padlength(serverdate.getHours()) + ":" + padlength(serverdate.getMinutes()) + ":" + padlength(serverdate.getSeconds())
			//document.getElementById("servertime").innerHTML=datestring+" "+timestring+" WIB";
		}

		window.onload = function() {
			setInterval("displaytime()", 1000)
		}
	</script>

	<style>
		.goog-te-combo {
			padding: 10px !important;
			border: 1px solid white;
			border-radius: 5px;
		}

		.title-header {
			color: #2b71c6;
			font-weight: 500;
			font-size: 1.6rem;
		}

		th {
			white-space: nowrap;
		}

		.goog-te-banner-frame.skiptranslate {
			display: none !important;
		}

		body {
			top: 0px !important;
		}

		.goog-te-gadget span {
			display: none !important;
		}

		.app-sidebar .sidebar-content {
			background-image: linear-gradient(to bottom, rgb(41 167 222), rgb(0 67 121 / 74%)), url('<?php echo base_url(); ?>/assets/app-assets/img/sidebar-bg/01.jpg');
		}

		.app-sidebar .logo {
			background-color: #29a7de;
		}

		.bg-breadcrumb {
			background-image: linear-gradient(to right, #00306a, #2AACE3);
			color: #fff;
			margin-bottom: 20px;
			margin-top: 70px;
			border-radius: 10px;
			height: 99px;
		}

		b,
		strong {
			color: #ffffff;
		}

		@media screen and (min-width: 0px) and (max-width: 100px) {
			#logo_white {
				display: none;
			}

			/* show it on small screens */
		}
	</style>

</head>

<body class="vertical-layout vertical-menu 2-columns navbar-sticky" data-menu="vertical-menu" data-col="2-columns">

	<nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed">
		<div class="container-fluid navbar-wrapper">
			<div class="navbar-header d-flex">
				<div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
				<ul class="navbar-nav">
					<li class="nav-item mr-2 d-none d-lg-block">
						<a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;">
							<i class="ft-maximize font-medium-3"></i>
						</a>
					</li>
					<li>
						<img src="<?= base_url('assets/img/Logo_BUMN_Untuk_Indonesia_2020.png') ?>" width="150" />
					</li>
				</ul>
			</div>
			<div class="navbar-container">
				<div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
					<ul class="navbar-nav">
						<li class="nav-item mr-1">
							<a class="nav-link d-flex align-items-end" href="javascript:;">
								<div class="d-md-flex d-none mr-1"><span class="text-right"></span>
									<div id="google_translate_element"></div>

								</div>
							</a>
						</li>
						<li class="nav-item mr-1">
							<a class="nav-link d-flex align-items-end" href="<?php echo site_url('welcome/out') ?>">
								<div class="d-md-flex d-none mr-2"><i class="ft-power mr-1" style="margin-top: 3px"></i><span class="text-right"><?php echo $this->lang->line('Keluar'); ?></span></div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>

	<div class="wrapper" id="wrapper">

		<div class="app-sidebar menu-fixed" data-background-color="purple-bliss" data-image="<?= base_url(); ?>assets/app-assets/sidebar/img/07.png" data-scroll-to-active="true">

			<div class="sidebar-header">
				<div class="logo clearfix"><a class="logo-text float-left" href="#">
						<div class="logo-img">
							<img src="<?php echo base_url('assets/img/escm_white.png'); ?>" class="menu-title" alt="e-SCM Logo" style="width: 6.5rem; margin-left: 170%;">
						</div>
					</a><a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="expanded"></i></a><a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a></div>
			</div>

			<?php
			$link = $_SERVER['PHP_SELF'];
			$link_array = explode('/', $link);
			$url = end($link_array);
			?>

			<div class="sidebar-content main-menu-content">
				<div class="nav-container">
					<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

						<?php if ($this->session->userdata('status_aktivasi') == 8) { ?>

							<li class="<?php echo $url == 'home' ? 'active' : ''; ?> nav-item"><a href="<?php echo site_url('home'); ?>"><i class="ft-home"></i><span class="menu-title">Beranda</span></a></li>

							<li class="has-sub nav-item"><a href="javascript:;"><i class="ft-edit"></i><span class="menu-title"><?php echo $this->lang->line('Pengadaan'); ?></span></a>
								<ul class="menu-content">
									<li class="<?php echo $url == 'pengadaan' ? 'active' : ''; ?>"><a href="<?php echo site_url("pengadaan"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item"><?php echo $this->lang->line('Daftar Pekerjaan'); ?></span></a></li>
									<li class="<?php echo $url == 'monitorpengadaan' ? 'active' : ''; ?>"><a href="<?php echo site_url("pengadaan/monitorpengadaan"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item"><?php echo $this->lang->line('Monitor Pengadaan'); ?></span></a></li>
									<li class="<?php echo $url == 'buatsanggah' ? 'active' : ''; ?>"><a href="<?php echo site_url("pengadaan/buatsanggah"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item"><?php echo $this->lang->line('Membuat Sanggahan'); ?></span></a></li>
									<li class="<?php echo $url == 'monitorsanggah' ? 'active' : ''; ?>"><a href="<?php echo site_url("pengadaan/monitorsanggah"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item"><?php echo $this->lang->line('Monitor Sanggahan'); ?></span></a></li>
									<li class="<?php echo $url == 'terminasi_lelang' ? 'active' : ''; ?>"><a href="<?php echo site_url("pengadaan/terminasi_lelang"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Terminasi Lelang</span></a></li>
								</ul>
							</li>

							<li class="has-sub nav-item"><a href="javascript:;"><i class="ft-box"></i><span class="menu-title"><?php echo $this->lang->line('Kontrak'); ?></span></a>
								<ul class="menu-content">
									<li class="<?php echo $url == 'kontrak' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item"><?php echo $this->lang->line('Daftar Pekerjaan'); ?></span></a></li>
									<li class="<?php echo $url == 'addendum' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/addendum"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Addendum</span></a></li>
									<li class="<?php echo $url == 'wo' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/wo"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Update Progress PO</span></a></li>
									<li class="<?php echo $url == 'milestone' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/milestone"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Update Progress Milestone</span></a></li>
									<li class="<?php echo $url == 'monitor' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/monitor"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item"><?php echo $this->lang->line('Monitor Kontrak'); ?></span></a></li>
									<li class="<?php echo $url == 'monitor_wo' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/monitor_wo"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Monitor PO</span></a></li>
									<li class="<?php echo $url == 'monitor_milestone' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/monitor_milestone"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Monitor Milestone / Termin</span></a></li>
									<li class="<?php echo $url == 'monitor_bast' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/monitor_bast"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Monitor BAST</span></a></li>
									<li class="<?php echo $url == 'tagihan' ? 'active' : ''; ?>"><a href="<?php echo site_url("kontrak/tagihan"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item"><?php echo $this->lang->line('Monitor Tagihan'); ?></span></a></li>
								</ul>
							</li>

							<li class="has-sub nav-item"><a href="javascript:;"><i class="ft-file-text"></i><span class="menu-title"><?php echo $this->lang->line('VSI'); ?></span></a>
								<ul class="menu-content">
									<li class="<?php echo $url == 'kuesioner' ? 'active' : ''; ?>"><a href="<?php echo site_url("vsi/kuesioner"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">Kuesioner</span></a></li>
									<li class="<?php echo $url == 'lihat_kuesioner' ? 'active' : ''; ?>"><a href="<?php echo site_url("vsi/lihat_kuesioner"); ?>"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item">History Kuesioner</span></a></li>
								</ul>
							</li>
							<li class="<?php echo $url == 'profile' ? 'active' : ''; ?> nav-item"><a href="<?php echo site_url('home/profile'); ?>"><i class="ft-user"></i><span class="menu-title"><?php echo $this->lang->line('Profil'); ?></span></a></li>
							<li class="<?php echo $url == 'hse' ? 'active' : ''; ?> nav-item"><a href="<?php echo site_url("hse"); ?>"><i class="ft-book-open"></i><span class="menu-title"><?php echo "CQSMS"; ?></span></a></li>

							<li class="nav-item"><a href="<?php echo base_url("assets/guide/Manual_Vendor_Site.pdf"); ?>" target="_blank"><i class="ft-book-open"></i><span class="menu-title"><?php echo $this->lang->line('Bantuan'); ?></span></a></li>

						<?php } ?>

						<?php if ($this->session->userdata('status_aktivasi') != 8) { ?>

							<?php
							$is_active = '';
							$proses = array("utama", "legal", "pajak", "keuangan", "saham", "pengurus", "personil", "pengalaman", "peralatan", "produk", "katalog", "catatan", "tambahan", "documents");
							if (in_array($url, $proses)) {
								$is_active = 'active';
							}
							?>
							<?php if($this->session->userdata('vendor_type') == 1){ ?>
								<li class="<?php echo $is_active; ?> nav-item"><a href="<?php echo site_url("registrasi_vendor/utama"); ?>" ><i class="ft-file"></i><span class="menu-title"><?php echo "Registrasi"; ?></span></a></li>
							<?php } elseif($this->session->userdata('vendor_type') == 2) { ?>
								<li class="<?php echo $is_active; ?> nav-item"><a href="<?php echo site_url("registrasi_perorangan/utama"); ?>" ><i class="ft-file"></i><span class="menu-title"><?php echo "Registrasi"; ?></span></a></li>
							<?php } elseif($this->session->userdata('vendor_type') == 3) { ?>
								<li class="<?php echo $is_active; ?> nav-item"><a href="<?php echo site_url("registrasi_luar_negeri/utama"); ?>" ><i class="ft-file"></i><span class="menu-title"><?php echo "Registrasi"; ?></span></a></li>
							<?php } ?>
							<li class="<?php echo $url == 'hse' ? 'active' : ''; ?> nav-item"><a href="<?php echo site_url("hse"); ?>"><i class="ft-book-open"></i><span class="menu-title"><?php echo "CQSMS"; ?></span></a></li>
							<li class="nav-item"><a href="<?php echo base_url("assets/guide/Manual_Vendor_Site.pdf"); ?>" target="_blank"><i class="ft-book-open"></i><span class="menu-title"><?php echo $this->lang->line('Bantuan'); ?></span></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>

			<!-- main menu content-->
			<div class="sidebar-background"></div>
		</div>

		<div class="main-panel">
			<!-- BEGIN : Main Content-->
			<div class="main-content">
				<div class="content-overlay"></div>
				<div class="content-wrapper">
					<div class="row bg-breadcrumb">
						<div class="col-7 d-flex align-items-center" style="height: 99px;">
							<div class="title-header">
								<strong><?php echo $title; ?></strong>
							</div>
						</div>
						<div class="col-5" style="height: 99px;">
							<div class="float-right">
								<img src="<?php echo base_url('assets') ?>/app-assets/img/wika_employee.png" alt="WIKA Logo" style="width:220px; margin-top: -50px">
							</div>
						</div>
					</div>
					<?php echo $content_for_layout; ?>
					<?php include("picker_v.php"); ?>
				</div>
			</div>
			<!-- END : End Main Content-->

			<!-- BEGIN : Footer-->
			<footer class="footer undefined undefined">
				<p class="clearfix text-muted m-0"><span><?php echo COMPANY_NAME ?> &copy; 2016 </span></p>
			</footer>

			<button class="btn btn-info scroll-top" type="button"><i class="ft-arrow-up"></i></button>

		</div>

	</div>

	<div class="modal fade" id="myLoader" tabindex="-1" role="dialog" aria-labelledby="myLoaderLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h3 class="modal-title text-center" id="myLoaderLabel">Loading...</h3>
					<br />
					<div class="progress">
						<div class="progress-bar bg-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							<span class="sr-only">100% Complete</span>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="sidenav-overlay"></div>
	<div class="drag-target"></div>

	<script src="<?php echo base_url(); ?>assets/app-assets/js/components-modal.min.js"></script>

	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement({
				pageLanguage: 'en'
			}, 'google_translate_element');
		}

		function onlyNumber(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
		}

		$('input.currency').on('keyup', function() {
			const value = this.value.toString().replace(/\./g, '');
			if (value.length) {
				this.value = parseFloat(value).toLocaleString('id');
			}
		});
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>

</html>