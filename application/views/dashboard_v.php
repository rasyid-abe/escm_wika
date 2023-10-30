<link rel="stylesheet" href="<?php echo base_url('assets'); ?>/app-assets/css/pages/charts-apex.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/app-assets/vendors/css/apexcharts.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
	.form-select-sm {
		padding-top: 0.25rem;
		padding-bottom: 0.25rem;
		padding-left: 0.5rem;
		font-size: .875rem;
	}

	.form-select {
		display: block;
		width: 100%;
		padding: 0.375rem 2.25rem 0.375rem 0.75rem;
		-moz-padding-start: calc(0.75rem - 3px);
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #212529;
		background-color: #fff;
		background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
		background-repeat: no-repeat;
		background-position: right 0.75rem center;
		background-size: 16px 12px;
		border: 1px solid #ced4da;
		border-radius: 0.25rem;
		transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
	}

	.wrapper-search {
		position: absolute;
		top: 15px;
		right: 15px;
		max-width: 100px;
	}
</style>

<div id="detail_efisiensi_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail Efisiensi</h4>
			</div>
			<div class="modal-body">
				<table>
					<tr>
						<td>
							<h4>Total hps</h4>
						</td>
						<td>
							<h4 id="m_hps">load ...</h4>
						</td>
					</tr>
					<tr>
						<td>
							<h4>Total kontrak</h4>
						</td>
						<td>
							<h4 id="m_tot_kontrak">load ...</h4>
						</td>
					</tr>
					<tr>
						<td>
							<h4>Total Efisiensi</h4>
						</td>
						<td>
							<h4 id="m_tot_efi">load ...</h4>
						</td>
					</tr>
					<tr>
						<td>
							<h4>Efisiensi</h4>
						</td>
						<td>
							<h4 id="m_efi">load ...</h4>
						</td>
					</tr>
					<tr>
						<td>
							<h4>Target efisiensi</h4>
						</td>
						<td>
							<h4>&nbsp;: 2%</h4>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="vendor_status_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Status Vendor</h4>
			</div>
			<div class="modal-body">
				<div id="status_vendor_container"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="detail_kontrak_nilai" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Nilai Kontrak <span id="date_kontrak"></span> </h4>
			</div>
			<div class="modal-body">
				<table id="table_kontrak_detail" data-toggle="table" data-height="460" class="table table-bordered table-striped"></table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="detail_umkm" class="modal fade " tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail UMKM</h4>
			</div>
			<div class="modal-body">
				<table id="table_umkm_detail" class="table table-striped"></table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<section class="users-list-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body py-0">
						<div class="row pt-2">
							<div class="col-sm-5">
								<div class="media-body text-left">
									<h4 class="text-info">Summary</h4>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<input type="date" class="form-control" name="sdate" id="sdate" value="">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<input type="date" class="form-control" name="edate" id="edate" value="">
								</div>
							</div>

							<div class="col-sm-2">
								<div class="form-group">
									<select class="form-control select2" name="dept_list" id="dept_list" style="background-color: white; color: black;">
										<option value="">-Divisi-</option>
										<?php foreach ($dept as $k => $v) : ?>
											<option value="<?php echo $v['dept_id'] ?>"><?php echo $v['dept_name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-sm-1">
								<div class="media-right text-info text-right">
									<i class="ft-search float-right btn btn-block btn-sm btn-info" style="margin-top: 2px" id="sch_d"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">

		<!--Statistics cards Starts-->
		<div class="col-xl-3 col-lg-6 col-md-6 col-12" id="efisiensi_div">
			<div class="card gradient-purple-love" style="background-image: linear-gradient(45deg, #29a7de, #094a83);">
				<div class="card-content" style="min-height: 160px">
					<div class="card-body py-0">
						<div class="media pb-1">
							<div class="media-body white text-left">
								<h3 class="font-large-1 white mb-0" id="lb_efisien">memuat ...</h3>
								<span><?php echo $this->lang->line('persentase_efisiensi'); ?></span>
							</div>
							<div class="media-right white text-right">
								<i class="ft-briefcase font-large-2 float-right"></i>
							</div>
						</div>
						<div class="mt-3 mb-3">
							<button type="button" style="display: none" id="efisiensi_div_btn" class="btn btn-primary btn-rounded btn-block">Detail</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-12" id="rfq_ongoing">
			<div class="card gradient-ibiza-sunset">
				<div class="card-content" style="min-height: 160px">
					<div class="card-body py-0">
						<div class="media pb-1">
							<div class="media-body white text-left">
								<h3 class="font-large-1 white mb-0" id="lb_ongoing">memuat ...</h3>
								<span><?php echo $this->lang->line('jumlah_rfq_aktif'); ?></span>
							</div>
							<div class="media-right white text-right">
								<i class="ft-user font-large-2 float-right"></i>
							</div>
						</div>
						<div class="mt-3 mb-3">
							<button type="button" style="display: none" id="rfq_ongoing_btn" class="btn btn-primary btn-rounded btn-block">Detail</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-6 col-md-6 col-12" id="jml_pengadaan">
			<div class="card gradient-mint">
				<div class="card-content" style="min-height: 160px">
					<div class="card-body py-0">
						<div class="media pb-1">
							<div class="media-body white text-left">
								<h3 class="font-large-1 white mb-0" id="lb_pengadaan">memuat ...</h3>
								<span><?php echo $this->lang->line('jumlah_pengadaan'); ?></span>
							</div>
							<div class="media-right white text-right">
								<i class="ft-pie-chart font-large-2 float-right"></i>
							</div>
						</div>
						<div class="mt-3 mb-3">
							<button type="button" style="display: none" id="jml_pengadaan_btn" class="btn btn-primary btn-rounded btn-block">Detail</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-12" id="vend">
			<div class="card gradient-king-yna">
				<div class="card-content" style="min-height: 160px">
					<div class="card-body py-0">
						<div class="media pb-1">
							<div class="media-body white text-left">
								<h3 class="font-large-1 white mb-0" id="lb_vend_act">memuat ...</h3>
								<span><?php echo $this->lang->line('jumlah_vendor_aktif'); ?></span>
							</div>
							<div class="media-right white text-right">
								<i class="ft-life-buoy font-large-2 float-right"></i>
							</div>
						</div>
						<div class="mt-3 mb-3">
							<button type="button" style="display: none" id="vend_btn" class="btn btn-primary btn-rounded btn-block">Detail</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-4 col-12">
			<div class="card" style="min-height: 450px;">
				<div class="card-header">
					<h4 class="card-title">EFISIENSI</h4>
				</div>
				<!-- chart efisiensi -->
				<div class="wrapper-search">
					<select name="efisiensi_filter" class="form-select form-select-sm" id="efisiensi_filter">
						<option value="">All year</option>
						<?php foreach ($year_cont as $k => $v) : ?>
							<option value="<?php echo $v['year'] ?>" <?= isset($_GET['sdate']) == $v['year'] ? 'selected' : '' ?>><?php echo $v['year'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="chart_eff" class="mr-2"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="col-xl-6 col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="card-header">
							<h4 class="card-title"><?php echo $this->lang->line('jumlah_vendor_terverifikasi'); ?></h4>
						</div>
						<div class="card-content">
							<div class="card-body">
								<ul class="list-group mb-3">
									<li class="list-group-item">
										<span><?php echo $this->lang->line('jasa_sewa'); ?></span>
										<span class="badge bg-light-gray float-right"><span style="color: #004899;" >85 </span> / <span style="color: #FF4800;" >  87</span></span>
									</li>
									<li class="list-group-item">
										<span><?php echo $this->lang->line('jasa_lainnya'); ?></span>
										<span class="badge bg-light-gray float-right"><span style="color: #004899;">133</span> / <span style="color: #FF4800;" > 143</span></span>
									</li>
									<li class="list-group-item">
										<span><?php echo $this->lang->line('jasa_mandor'); ?></span>
										<span class="badge bg-light-gray float-right"><span style="color: #004899;">50 </span>/ <span style="color: #FF4800;" > 68</span></span>
									</li>
									<li class="list-group-item">
										<span><?php echo $this->lang->line('jasa_konsultan'); ?></span>
										<span class="badge bg-light-gray float-right"><span style="color: #004899;">50</span> / <span style="color: #FF4800;" > 52</span></span>
									</li>
									<li class="list-group-item">
										<span><?php echo $this->lang->line('jasa_konstruksi'); ?></span>
										<span class="badge bg-light-gray float-right"><span style="color: #004899;">130</span> / <span style="color: #FF4800;" > 146</span></span>
									</li>
									<li class="list-group-item">
										<span><?php echo $this->lang->line('barang'); ?></span>
										<span class="badge bg-light-gray float-right"><span style="color: #004899;">200 </span>/ <span style="color: #FF4800;" > 234</span></span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<div class="col-xl-8 col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Efisiensi Tahun <?php echo date('Y') ?></h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="chart_efi_tahun"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="col-xl-6 col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title"><?php echo $this->lang->line('diagram_verifikasi'); ?></h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="column-chart-hse"></div>
					</div>
				</div>
			</div>
		</div> -->
	</div>
	<div class="row">
		<div class="col-lg-6 col-12" id="rata">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="media">
							<div class="media-body">
								<h3 class="mb-1 danger" id="lb_hari_pengadaan">memuat ...</h3>
								<h5><?php echo $this->lang->line('rerata_waktu_pengadaan'); ?></h5>
							</div>
							<div class="media-right align-self-center">
								<i class="ft-calendar danger font-large-2 float-right"></i>
								<button style="display: none" type="button" id="rata-btn" class="mt-1 btn btn-primary btn-rounded pull-right">Detail</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="media">
							<div class="media-body text-left">
								<!-- <h3 class="mb-1 info"><?php echo $nilai_kontrak != 0 ? $nilai_kontrak : 'Rp. 0' ?></h3> -->
								<h3 class="mb-1 info" id="lb_nilai_kontrak">memuat ...</h3>
								<h5><?php echo $this->lang->line('nilai_kontrak'); ?></h5>
							</div>
							<div class="media-right align-self-center">
								<i class="ft-book-open info font-large-2 float-right"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Column Chart starts -->
		<div class="col-xl-6 col-12">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-between">
						<div class="col-sm-8">
							<h4 class="card-title">Efisiensi per Departemen</h4>
						</div>
						<div class="col-sm-2">
							<button type="button" class="btn btn-sm btn-block btn-info" name="button" style="display: none; margin-top: -10px" id="back_dept" onclick="back_dept();">Back</button>
						</div>
					</div>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="column-chart"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- Column Chart ends -->

		<!-- Bar Chart starts -->
		<div class="col-xl-6 col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Nilai Kontrak Tahun
						<select name="year_cont" id="year_cont">
							<?php foreach ($year_cont as $k => $v) : ?>
								<option value="<?php echo $v['year'] ?>" <?= $v['year'] == date("Y") ? 'selected' : '' ?>><?php echo $v['year'] ?></option>
							<?php endforeach; ?>
						</select>
					</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="chart_top10kontrak"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- Bar Chart ends -->
	</div>
	<div class="row">

		<!-- Bar Chart starts -->
		<div class="col-xl-12 col-12">
			<div class="card cart-info">
				<div class="card-header">
					<h4 class="card-title">TOP 10 UMKM</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="chart_umkm"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- Bar Chart ends -->
	</div>
	<div class="row">
		<div class="col-xl-12 col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">TOP 5 EFISIENSI</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div class="table-responsive">
							<table id="table_efisiensi" class="table table-bordered table-striped"></table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Column Chart ends -->

	</div>
</section>
<script src="<?php echo base_url('assets'); ?>/app-assets/vendors/js/apexcharts.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
	$(function() {
		$('input[name="datetimes"]').daterangepicker({
			timePicker: true,
			startDate: moment().startOf('hour'),
			endDate: moment().startOf('hour').add(24, 'hour'),
			locale: {
				format: 'YYYY/MM/DD HH:mm:ss'
			}
		});
	});

	$('#efisiensi_div_btn').click(function() {
		$('#detail_efisiensi_modal').modal('show')
	})
	$('#efisiensi_div').hover(function() {
		$('#efisiensi_div_btn').css('display', 'block');
	}, function() {
		$('#efisiensi_div_btn').css('display', 'none');
	})

	$('#rfq_ongoing').hover(function() {
		$('#rfq_ongoing_btn').css('display', 'block');
	}, function() {
		$('#rfq_ongoing_btn').css('display', 'none');
	})
	$('#rfq_ongoing_btn').click(function() {
		window.open('<?php echo site_url('laporan/report_progres/lap_daftar_rfq?type=rfq_ongoing') ?>', '_blank')
	})

	$('#jml_pengadaan').hover(function() {
		$('#jml_pengadaan_btn').css('display', 'block');
	}, function() {
		$('#jml_pengadaan_btn').css('display', 'none');
	})
	$('#jml_pengadaan_btn').click(function() {
		window.open('<?php echo site_url('laporan/report_progres/lap_daftar_rfq') ?>', '_blank')
	})

	$('#vend').hover(function() {
		$('#vend_btn').css('display', 'block');
	}, function() {
		$('#vend_btn').css('display', 'none');
	})
	$('#vend_btn').click(function() {
		$('#vendor_status_modal').modal('show')
	})

	$('#rata').hover(function() {
		$('#rata-btn').css('display', 'block');
	}, function() {
		$('#rata-btn').css('display', 'none');
	})
	$('#rata-btn').click(function(event) {
		window.open('<?php echo site_url('laporan/rekap_analisa/report_durasi_proses') ?>', '_blank');
	});

	$(`#sch_d`).on('click', function() {
		let dept = $(`#dept_list`).val()
		let sdate = $(`#sdate`).val()
		let edate = $(`#edate`).val()

		let bool = true
		if (sdate != '') {
			if (edate != '') {
				bool = true
			} else {
				bool = false
			}
		}

		if (edate != '') {
			if (sdate != '') {
				bool = true
			} else {
				bool = false
			}
		}

		if (bool) {
			get_data_dashboard(dept, sdate, edate)
		} else {
			alert('Filter tanggal harus terisi semua!')
		}
	})
</script>

<!-- ALL CHART -->
<script type="text/javascript">
	let curr = Intl.NumberFormat('id-ID')
	// var themeColors = [$primary, $info, $warning, $success, $label_color_light,$label_color_last];

	function generate_lable(data) {
		console.log(data);
		$(`#lb_efisien`).html(parseFloat(data['effisien']).toFixed(2) + ' %')
		$(`#lb_ongoing`).html(curr.format(parseInt(data['total_rfq_aktif']['count'])))
		$(`#lb_pengadaan`).html(curr.format(parseInt(data['total_pengadaan'])))
		$(`#lb_vend_act`).html(curr.format(parseInt(data['total_vendor_aktif']['count'])))

		$('#m_hps').html('&nbsp;: Rp. ' + curr.format(parseInt(data['eff_modal']['hps'])))
		$('#m_tot_kontrak').html('&nbsp;: Rp. ' + curr.format(parseInt(data['eff_modal']['total_contract'])))

		let m_ef = parseInt(data['eff_modal']['efisiensi']) != 0 ? parseInt(data['eff_modal']['efisiensi']) : parseInt(data['eff_modal']['inefisiensi'])
		$('#m_tot_efi').html('&nbsp;: Rp. ' + curr.format(m_ef))

		let m_eff = `&nbsp;: <span style="${parseFloat(data['eff_modal']['efisiensi_percent']) < 2 ? 'color: #d9534f' : 'color: #5cb85c'}">
		${parseFloat(data['eff_modal']['efisiensi_percent']) != 0 ? parseFloat(data['eff_modal']['efisiensi_percent']).toFixed(2) : '- ' + parseFloat(data['eff_modal']['inefisiensi_percent']).toFixed(2)} % </span>`
		$('#m_efi').html(m_eff)

		let lbhari = data['method_pemilihan_langsung'] != '' ? data['method_pemilihan_langsung'] : '0 Hari'
		$(`#lb_hari_pengadaan`).html(lbhari)
		let lbkon = data['total_kontrak'] != null ? data['total_kontrak'] : 0
		$(`#lb_nilai_kontrak`).html('Rp. ' + curr.format(parseInt(lbkon)))
	}

	$(`#year_cont`).on('change', function() {
		let y = $(`#year_cont`).val()
		$.ajax({
			url: "<?php echo site_url('log/nilai_kontrak_by_year') ?>",
			method: 'post',
			data: {
				'year': y
			},
			dataType: 'json',
			success: function(data) {
				nilai_kontrak_tahun(data)
			}
		})
	})

	function nilai_kontrak_tahun(data) {
		$(`#chart_top10kontrak`).html('')

		let val = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		$.each(data, function(i, v) {
			val[v.month - 1] = parseInt(data[i].amount)
		})
		var barChartOptions = {
			chart: {
				height: 350,
				type: 'bar',
				events: {
					dataPointSelection: (event, chartContext, config) => {
						key = data[config.seriesIndex].month
						nilai_kontrak_tahun_detail(key)
					}
				},
			},
			plotOptions: {
				bar: {
					horizontal: false,
					endingShape: 'rounded',
				}
			},
			dataLabels: {
				enabled: false
			},
			series: [{
				data: val,
			}],
			yaxis: {
				labels: {
					formatter: function(value) {
						return curr.format(value);
					}
				},
				title: {
					text: 'IDR'
				},
			},
			xaxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
				tickPlacement: 'on'
			},
			tooltip: {
				y: {
					formatter: function(value) {
						return curr.format(value);
					},
					title: {
						formatter: function() {
							return ''
						}
					},
				},
			},
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'light',
					type: "horizontal",
					shadeIntensity: 0.25,
					gradientToColors: undefined,
					inverseColors: true,
					opacityFrom: 0.85,
					opacityTo: 0.85,
					stops: [50, 0, 100]
				},
			}
		}
		var barChart = new ApexCharts(
			document.querySelector("#chart_top10kontrak"),
			barChartOptions
		);
		barChart.render();
	}

	function nilai_kontrak_tahun_detail(key) {
		let year = $(`#year_cont`).val()
		let month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
		$.ajax({
			url: "<?php echo site_url('log/nilai_kontrak_detail') ?>",
			method: 'post',
			data: {
				'month': key,
				'year': year
			},
			dataType: 'json',
			success: function(data) {
				let body = `<tr>
					<th class="text-center">No</th>
					<th class="text-center">PTM Number</th>
					<th class="text-right">Nilai</th>
					<th class="text-center">Tanggal TTD</th>
				</tr>`
				$.each(data, function(i, v) {
					body += `
						<tr>
						<td class="text-center">${i+1}</td>
						<td class="text-center">${v.ptm_number}</td>
						<td class="text-right">${curr.format(v.nilai)}</td>
						<td class="text-center">${v.sign_date}</td>
						</tr>
					`
				})

				$(`#date_kontrak`).html(`${month[key-1]} ${year}`)
				$(`#table_kontrak_detail`).html(body)
				$(`#table_kontrak_detail`).bootstrapTable()
				$('#detail_kontrak_nilai').modal('show')
			}
		})
	}

	function chart_vend_active(data) {
		let se = []
		let la = []
		$.each(data, function(i, v) {
			se.push(parseInt(v.jml))
			la.push(v.vendor_status)
		})

		var options = {
			series: se,
			chart: {
				events: {
					dataPointSelection: (event, chartContext, config) => {
						key = data[config.dataPointIndex]['vendor_status']
						window.open('<?php echo site_url('laporan/rekap_analisa/monitor_vendor?status=') ?>' + key, '_blank');
					}
				},
				width: 380,
				type: 'pie',
			},
			labels: la,
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}]
		};

		var chart = new ApexCharts(document.querySelector("#status_vendor_container"), options);
		chart.render();
	}

	function chart_efisiensi(data) {
		// let kontrak = parseInt(data[0].total_contract)
		let efisiensi = parseInt(data[0].efisiensi)
		let inefisiensi = parseInt(data[0].inefisiensi)

		var options = {
			title: {
				text: `Nilai Kontrak : ${curr.format(parseInt(data[0].total_contract))}`,
				align: 'bottom'
			},
			series: [efisiensi, inefisiensi],
			chart: {
				width: 380,
				type: 'pie',
				events: {
					dataPointSelection: (event, chartContext, config) => {
						if (config.dataPointIndex === 0) {
							window.location.replace("/laporan/rekap_analisa/lap_proc_value")
						}
					}
				}
			},
			labels: ['Efisiensi', 'Inefisiensi'],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 250
					},
				}
			}],
			yaxis: {
				labels: {
					formatter: function(value) {
						return curr.format(value);
					}
				},
			},
			legend: {
				position: 'bottom',
				horizontalAlign: 'center',
			},
		};

		var chart = new ApexCharts(document.querySelector("#chart_eff"), options);
		chart.render();
	}

	function chart_efisien_tahun(data) {
		let obj = [];
		$.each(data.data, function(i, v) {
			let val = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
			ob = {};
			for (var id = 1; id <= 12; id++) {
				if (v.data[id - 1]) {
					val[v.data[id - 1].month - 1] = parseInt(v.data[id - 1].y)
				}
			}
			ob['name'] = v.name;
			ob['data'] = val;

			obj.push(ob);
		})

		var options = {
			series: obj,
			chart: {
				events: {
					click: function() {
						window.open('<?php echo site_url('laporan/rekap_analisa/lap_proc_value') ?>', '_blank');
					}
				},
				height: 350,
				type: 'line',
				dropShadow: {
					enabled: true,
					color: '#000',
					top: 18,
					left: 7,
					blur: 10,
					opacity: 0.2
				},
				toolbar: {
					show: false
				}
			},
			colors: ['#77B6EA', '#545454'],
			// dataLabels: {
			// 	enabled: true,
			// },
			stroke: {
				curve: 'smooth'
			},
			grid: {
				borderColor: '#e7e7e7',
				row: {
					colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
					opacity: 0.5
				},
			},
			markers: {
				size: 1
			},
			xaxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
				title: {
					text: 'Month'
				}
			},
			yaxis: {
				labels: {
					formatter: function(value) {
						return curr.format(value);
					}
				},
				title: {
					text: 'IDR'
				},
			},
			legend: {
				position: 'bottom',
				horizontalAlign: 'right',
			}
		};

		var chart = new ApexCharts(document.querySelector("#chart_efi_tahun"), options);
		chart.render();
	}

	function chart_dept(data, type, title) {
		$('#column-chart').html('')

		if (type != 0) {
			$('#back_dept').css('display', 'block');
		}

		let cate = []
		$.each(data.data[0].data, function(i, v) {
			cate.push(v.name)
		})

		let ser = []
		$.each(data.data, function(i, v) {
			c_ser = {}
			c_ser['name'] = v.name

			c_dat = []
			$.each(v.data, function(id, va) {
				c_dat.push(va.y)
			})

			c_ser['data'] = c_dat
			ser.push(c_ser)
		})

		var columnChartOptions = {
			chart: {
				height: 350,
				type: 'bar',
				events: {
					dataPointSelection: (event, chartContext, config) => {
						if (type == 0) {
							key = data.data[config.seriesIndex].data[config.dataPointIndex].drilldown
							nam = data.data[config.seriesIndex].name
							div = data.data[config.seriesIndex].data[config.dataPointIndex].name
							tit = nam.concat(' > ', div)
							detail_dept(key, tit)
						} else {
							key = data.data[config.seriesIndex].data[config.dataPointIndex].name
							window.open('<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/') ?>' + '/' + key, '_blank');
						}
					}
				},
			},
			colors: ['#F55252', '#2F8BE6', '#975AFF'],
			plotOptions: {
				bar: {
					horizontal: false,
					endingShape: 'rounded',
					columnWidth: '55%',
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			series: ser,
			legend: {
				offsetY: -10
			},
			xaxis: {
				categories: cate,
			},
			yaxis: {
				labels: {
					formatter: function(value) {
						return curr.format(value);
					}
				},
				title: {
					text: 'IDR'
				},
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function(value) {
						return curr.format(value);
					}
				}
			}
		}

		columnChartOptions['title'] = {
			text: title
		}

		var columnChart = new ApexCharts(
			document.querySelector("#column-chart"),
			columnChartOptions
		);
		columnChart.render();
	}

	function detail_dept(e, title) {
		var offset = 0;
		var limit = 5;
		$.ajax({
			url: "<?php echo site_url('log/dept_detail') ?>",
			method: 'post',
			data: {
				offset: offset,
				limit: limit,
				param: e
			},
			dataType: 'json',
			success: function(data) {
				chart_dept(data, 1, title)
			}
		})
	}

	function back_dept() {
		$.ajax({
			url: "<?php echo site_url('log/dept_back') ?>",
			dataType: 'json',
			success: function(data) {
				chart_dept(data, 0, '')
				$('#back_dept').css('display', 'none');
			}
		})
	}

	function chart_umkm(data) {
		let ls = []
		let ct = []
		for (var i = 9; i >= 0; i--) {
			ls.push(parseInt(data[i].nilai))
			ct.push(data[i].vendor_name)
		}
		var options = {
			series: [{
				name: 'Rp ',
				data: ls
			}],
			chart: {
				type: 'bar',
				height: 380,
				events: {
					dataPointSelection: (event, chartContext, config) => {
						key = data[config.seriesIndex].vendor_id
						get_umkm_detail(key)
					}
				},
			},
			plotOptions: {
				bar: {
					barHeight: '100%',
					distributed: true,
					horizontal: true,
					dataLabels: {
						position: 'bottom'
					},
				}
			},
			colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
				'#f48024', '#69d2e7'
			],
			dataLabels: {
				enabled: true,
				textAnchor: 'start',
				style: {
					colors: ['#eee']
				},
				formatter: function(val, opt) {
					return opt.w.globals.labels[opt.dataPointIndex]
				},
				offsetX: 0,
				dropShadow: {
					enabled: true
				}
			},
			stroke: {
				width: 1,
				colors: ['#fff']
			},
			xaxis: {
				categories: ct,
				labels: {
					formatter: function(value) {
						return curr.format(value);
					}
				},
				title: {
					text: 'IDR'
				},
			},
			yaxis: {
				labels: {
					show: false
				}
			},
			legend: {
				show: false
			},
			tooltip: {
				y: {
					formatter: function(value) {
						return curr.format(value);
					},
					title: {
						formatter: function() {
							return ''
						}
					},
				},
				x: {
					show: false
				},
			},
		};

		var chart = new ApexCharts(document.querySelector("#chart_umkm"), options);
		chart.render();
	}

	function get_umkm_detail(data) {
		$.ajax({
			url: "<?php echo site_url('log/umkm_detail') ?>",
			method: 'post',
			data: {
				'vend_id': data
			},
			dataType: 'json',
			success: function(data) {
				let body = `
					<tr>
						<td>Nama Vendor</td>
						<td>:</td>
						<th>${data.vendor_name}</th>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<th>${data.address_street}</th>
					</tr>
					<tr>
						<td>Wilayah</td>
						<td>:</td>
						<th>${data.addres_prop}</th>
					</tr>
					<tr>
						<td>Kontak</td>
						<td>:</td>
						<th>${data.contact_name}</th>
					</tr>
					<tr>
						<td>No Handphone</td>
						<td>:</td>
						<th>${data.contact_phone_no}</th>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<th>${data.contact_email}</th>
					</tr>
				`

				$(`#table_umkm_detail`).html(body)
				$('#detail_umkm').modal('show')
			}
		})
	}
</script>

<script type="text/javascript">
	let $table_efisiensi = $('#table_efisiensi')
	let selections = [];

	function efisiensi_formatter(value, row, index) {
		var link = "<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/') ?>";
		return [
			'<a href="' + link + '/lihat/' + value + '" target="_blank">',
			value,
			'</a>  ',
		].join('');
	}

	$(function() {
		$table_efisiensi.bootstrapTable({
			url: "<?php echo site_url('Procurement/data_top_5_efisiensi/') ?>",
			striped: true,
			selectItemName: "list",
			sidePagination: "server",
			smartDisplay: true,
			cookie: true,
			cookieExpire: "1h",
			cookieIdTable: "data_efisiensi",
			showExport: false,
			exportTypes: ['json', 'xml', 'csv', 'txt', 'excel'],
			showFilter: false,
			flat: true,
			keyEvents: false,
			showMultiSort: false,

			reorderableColumns: false,
			resizable: false,
			pagination: false,
			cardView: false,
			detailView: false,
			search: false,
			showRefresh: true,
			showToggle: false,
			idField: "ptm_number",

			showColumns: false,
			columns: [{
					field: 'ptm_number',
					title: 'No. RFQ',
					sortable: true,
					order: true,
					searchable: true,
					align: 'center',
					valign: 'middle',
					width: '15%',
					formatter: efisiensi_formatter,
				},

				{
					field: 'ptm_subject_of_work',
					title: 'Nama Pekerjaan',
					sortable: true,
					order: true,
					searchable: true,
					align: 'center',
					valign: 'middle',
					width: '21%',
				},
				{
					field: 'ptm_dept_name',
					title: 'Dept',
					sortable: true,
					order: true,
					searchable: true,
					align: 'center',
					valign: 'middle',
					width: '21%',
				}, {
					field: 'hps',
					title: 'Nilai HPS',
					sortable: true,
					order: true,
					searchable: true,
					align: 'right',
					valign: 'middle',
					width: '15%',
				}, {
					field: 'contract_amount',
					title: 'Nilai Kontrak',
					sortable: true,
					order: true,
					searchable: true,
					align: 'right',
					valign: 'middle',
					width: '15%',
				}, {
					field: 'efisiensi',
					title: 'Efisiensi',
					sortable: true,
					order: true,
					searchable: true,
					align: 'right',
					valign: 'middle',
					width: '15%',
				}, {
					field: 'efisiensi_percent',
					title: '%',
					sortable: true,
					order: true,
					searchable: true,
					align: 'center',
					valign: 'middle',
					width: '10%',
				}
			]
		});

	});
</script>

<script>
	// lanjut
	function get_efisiensi_year() {
		let year = document.getElementById("year_eff")
		$.ajax({
			url: '<?php echo site_url("log/get_data_dashboard"); ?>',
			method: 'post',
			data: {
				'dept': dept,
				'sdate': sdate,
				'edate': edate
			},
			dataType: 'json',
			success: function(data) {
				generate_lable(data['lables'])
				chart_efisiensi(data['chart_pie_efisiensi'])
				chart_efisien_tahun(data['chart_efi_tahun'])
			}
		})
	}

	$(`#efisiensi_filter`).on('change', function() {
		let y = $(`#efisiensi_filter`).val()
		$.ajax({
			url: "http://localhost/new_escm2/log/get_efisiensi_year?sdate=" + y + "&edate=" + y,
			method: 'post',
			data: {
				'year': y
			},
			dataType: 'json',
			success: function(data) {
				chart_efisiensi(data['chart_pie_efisiensi'])
			}
		})
	})

	function get_data_dashboard(dept = '', sdate = '', edate = '') {
		$.ajax({
			url: '<?php echo site_url("log/get_data_dashboard"); ?>',
			method: 'post',
			data: {
				'dept': dept,
				'sdate': sdate,
				'edate': edate
			},
			dataType: 'json',
			success: function(data) {
				generate_lable(data['lables'])
				chart_vend_active(data['chart_vend_active'])
				chart_efisiensi(data['chart_pie_efisiensi'])
				chart_efisien_tahun(data['chart_efi_tahun'])
				chart_dept(data['chart_dept'], 0, '')
				nilai_kontrak_tahun(data['chart_nilai_kontrak'])
				chart_umkm(data['chart_umkm'])
			}
		})
	}
	$(document).ready(function() {
		get_data_dashboard()

		var $primary = "#975AFF",
			$success = "#40C057",
			$info = "#2F8BE6",
			$warning = "#F77E17",
			$danger = "#F55252",
			$label_color_light = "#EAF0F9";
		$label_color_last = "#F55252";

		var themeColors = [$primary, $info, $warning, $success, $label_color_light, $label_color_last];

		//-------------- Column Chart starts --------------


		var columnChartOptionsHse = {
			chart: {
				height: 350,
				type: 'bar',
				stacked: false,

			},
			colors: ['#004899', '#FF4800'],
			plotOptions: {
				bar: {
					horizontal: false,
					endingShape: 'rounded',
					columnWidth: '55%',
					distributed: false,
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			series: [{
					name: 'Jumlah Terverifikasi',
					data: [85, 133, 50, 50, 130, 234],
					//colors : ['bl']
				},
				{
					name: 'Jumlah Terdaftar',
					data: [87, 143, 68, 52, 146, 234]
				}
			],
			legend: {
				offsetY: -10,
				//show : false
			},
			xaxis: {
				title: {
					text: 'Kategori Vendor'
				},
				categories: ['Jasa Sewa', 'Jasa Lainnya (transporter, dll di luar jasa konstruksi dan konsultan)', 'Jasa Mandor', 'Jasa Konsultan', 'Jasa Konstruksi (Subkon)', 'Barang (Vendor, Supplier)'],
				labels: {
					style: {
						//colors: themeColors,
						fontSize: '12px'
					}


				}
			},
			yaxis: {
				title: {
					text: 'Jumlah Vendor'
				}
			},
			fill: {
				opacity: 1,
				//colors: themeColors
			},
			tooltip: {
				y: {
					formatter: function(val) {
						return val
					}
				}
			}
		}
		var columnChartHse = new ApexCharts(
			document.querySelector("#column-chart-hse"),
			columnChartOptionsHse
		);
		columnChartHse.render();


		//-------------- Bar Chart starts --------------


	});
</script>