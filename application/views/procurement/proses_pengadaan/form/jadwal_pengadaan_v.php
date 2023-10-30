<?php $jadwal_tahap_2 = ($prep['ptp_submission_method'] == 2 && $activity_id >= 1112); ?>
<?php echo $jadwal_tahap_2 ?>
<style>
  .input-group > .form-control {
    font-size: 10px;
  }
</style>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header border-bottom pb-2">
				<h4 class="card-title">Jadwal Pengadaan</h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<?php $is_tgl_pembukaan = (strtotime($prep['ptp_reg_opening_date']) > 0) ? date("Y-m-d H:i", strtotime($prep['ptp_reg_opening_date'])) : ""; ?>

					<div class="row col">
						<div class="col-md-3">
							<label class="tgl_pembukaan">Periode Tender *</label>
							<div class="input-group date">								
								<select class="form-control periode_tender" name="tender_priod_inp" id="tender_priod_inp">
									<option value="0">Pilih</option>
									<?php foreach ($periodes as $key => $value) { ?>
										<option value="<?php echo $key ?>" <?php echo $key == $prep['ptp_tender_priod'] ? 'selected' : ''; ?> ><?php echo $value ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="color: red; display: none;" id="alert_buka">Periode Tender harus diisi</div>
						</div>
						<div class="col-md-3">
							<label>Pembukaan pendaftaran *</label>
							<div class="input-group date">
								<?php if (!$jadwal_tahap_2) { ?>
								<?php } ?>
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="tgl_pembukaan_pendaftaran_inp" class="form-control tgl_pembukaan_pendaftaran_inp" required id="tgl_pembukaan_pendaftaran_inp" value="">
							</div>
							<div style="color: red; display: none;" id="alert_buka">Tanggal pembukaan pendaftaran harus diisi</div>
						</div>
						<div class="col-md-3">
							<label>Penutupan Pendaftaran *</label>
							<div class="input-group date">
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="tgl_penutupan_pendaftaran_inp" id="tgl_penutupan_pendaftaran_inp" required class="form-control  tgl_penutupan_pendaftaran_inp" value="<?php echo $prep['ptp_reg_closing_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_tutup">Tanggal penuntupan pendaftaran harus diisi</div>
						</div>
						<div class="col-md-3">
							<label>Aanwijzing *</label>
							<div class="input-group date">
								<?php if (!$jadwal_tahap_2) { ?>
								<?php } ?>
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="tgl_aanwijzing_inp" id="tgl_aanwijzing_inp" class="form-control tgl_aanwijzing_inp" required value="<?php echo $prep['ptp_prebid_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_anwz">Tanggal aanwijzing harus diisi</div>
						</div>
					</div>

					<div class="row col">
						<div class="col-md-3">
							<label>Mulai kirim Penawaran *</label>
							<div class="input-group date">
								<?php if (!$jadwal_tahap_2) { ?>
								<?php } ?>
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="tgl_mulai_penawaran_inp" id="tgl_mulai_penawaran_inp" class="form-control  tgl_mulai_penawaran_inp" required value="">
							</div>
							<div style="color: red; display: none;" id="alert_mulai">Tanggal mulai kirim Penawaran harus diisi</div>
						</div>
						<div class="col-md-3">
							<label>Akhir Kirim Penawaran *</label>
							<div class="input-group date">
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="tgl_akhir_penawaran_inp" id="tgl_akhir_penawaran_inp" required class="form-control tgl_akhir_penawaran_inp" value="<?php echo $prep['ptp_quot_closing_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_akhir">Tanggal Akhir Kirim Penawaran</div>
						</div>
						<div class="col-md-3">
							<label class="tgl_pembukaan" style="font-size: 11px;">Pembukaan dok. penawaran *</label>
							<div class="input-group date">
								<?php if (!$jadwal_tahap_2) { ?>
								<?php } ?>
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="tgl_pembukaan_dok_penawaran_inp" required class="form-control tgl_pembukaan_dok_penawaran_inp" id="tgl_pembukaan_dok_penawaran_inp" value="<?php echo $prep['ptp_doc_open_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_doc">Tanggal pembukaan dokumen penawaran harus diisi</div>
						</div>
						<div class="col-md-3">
							<label>Negosiasi *</label>
							<div class="input-group date">
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="negosiasi" id="negosiasi" required class="form-control negosiasi" value="<?php echo $prep['ptp_quot_closing_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_akhir">Tanggal Negosiasi harus diisi</div>
						</div>
					</div>

					<div class="row col">
						<div class="col-md-3">
							<label>USKEP *</label>
							<div class="input-group date">
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="uskep" id="uskep" required class="form-control uskep" value="<?php echo $prep['ptp_quot_closing_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_akhir">Tanggal uskep diisi</div>
						</div>
						<div class="col-md-3">
							<label>Pengumuman *</label>
							<div class="input-group date">
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="pengumuman" id="pengumuman" required class="form-control pengumuman" value="<?php echo $prep['ptp_quot_closing_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_akhir">Tanggal Pengumuman harus diisi</div>
						</div>
						<div class="col-md-3">
							<label>Sanggahan *</label>
							<div class="input-group date">
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="sanggahan" id="sanggahan" required class="form-control sanggahan" value="<?php echo $prep['ptp_quot_closing_date']; ?>">
							</div>
							<div style="color: red; display: none;" id="alert_akhir">Tanggal sanggahan harus diisi</div>
						</div>
						<div class="col-md-3">
							<label>Penunjukan *</label>
							<div class="input-group date">
								<input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="datetime-local" name="penunjukan" id="penunjukan" required class="form-control penunjukan" value="<?php echo $prep['ptp_quot_closing_date']; ?>">

							</div>
							<div style="color: red; display: none;" id="alert_akhir">Tanggal Penunjukan harus diisi</div>
						</div>
					</div>

					<div class="row form-group hide">
						<label class="col-sm-2 text-right">Lokasi Aanwijzing</label>
						<div class="col-sm-4">
							<textarea <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> class="form-control" id="lokasi_aanwijzing_inp" name="lokasi_aanwijzing_inp"><?php echo $prep['ptp_prebid_location']; ?></textarea>
						</div>
						<?php $curval = (!empty($prep['ptp_aanwijzing_online'])) ? "checked" : ""; ?>
						<label class="col-sm-2 text-right">Aanwijzing Online</label>
						<div class="col-sm-4">
							<input type="checkbox" name="aanwijzing_online_inp" <?php echo $curval ?> value="1">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ($jadwal_tahap_2) { ?>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header border-bottom pb-2">
					<h4 class="card-title">Jadwal Pengadaan Tahap 2</h4>
				</div>
				<div class="card-content">
					<div class="card-body col-md-12">
						<div class="row form-group">
							<?php $curval = $prep['ptp_tgl_aanwijzing2']; ?>
							<label class="col-sm-2 text-right">Tanggal Aanwijzing Tahap 2 *</label>
							<div class="col-sm-4">
								<div class="input-group date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" name="tgl_aanwijzing_2_inp" required class="form-control datetimepicker" value="<?php echo $curval ?>">
								</div>
							</div>
							<?php $curval = $prep['ptp_bid_opening2']; ?>
							<label class="col-sm-2 text-right">Tanggal Mulai Kirim Penawaran Tahap 2 *</label>
							<div class="col-sm-4">
								<div class="input-group date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" name="tgl_mulai_penawaran_2_inp" required class="form-control datetimepicker" value="<?php echo $curval ?>">
								</div>
							</div>
						</div>
						<div class="row form-group">
							<?php $curval = $prep['ptp_lokasi_aanwijzing2']; ?>
							<label class="col-sm-2 text-right">Lokasi Aanwijzing Tahap 2</label>
							<div class="col-sm-4">
								<textarea required class="form-control" id="lokasi_aanwijzing_2_inp" name="lokasi_aanwijzing_2_inp"><?php echo $curval ?></textarea>
							</div>
							<?php $curval = $prep['ptp_bid_closing2']; ?>
							<label class="col-sm-2 text-right">Tanggal Akhir Kirim Penawaran Tahap 2 *</label>
							<div class="col-sm-4">
								<div class="input-group date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" name="tgl_akhir_penawaran_2_inp" required class="form-control datetimepicker" value="<?php echo $curval ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
<?php } ?>

<script type="text/javascript">
	<?php
	$data_js = json_encode($prep);
	echo "let data = " . $data_js . ";\n";
	?>

	function dateFromDb(date) {
		return moment(new Date(date)).format('YYYY-MM-DDThh:mm')
	}

	// init value before
	const tglOpenReg = dateFromDb(data["ptp_reg_opening_date"] ? data["ptp_reg_opening_date"] : new Date())
		$("#tgl_pembukaan_pendaftaran_inp").val(tglOpenReg);
		$("#tender_priod_inp").val(data["ptp_tender_priod"] ? data["ptp_tender_priod"] : 0)
		$("#tgl_penutupan_pendaftaran_inp").val(dateFromDb(data["ptp_reg_closing_date"]));
		$("#tgl_mulai_penawaran_inp").val(dateFromDb(data["ptp_quot_opening_date"]));
		$("#tgl_akhir_penawaran_inp").val(dateFromDb(data["ptp_quot_closing_date"]));
		$("#tgl_aanwijzing_inp").val(dateFromDb(data["ptp_prebid_date"]));
		$("#tgl_pembukaan_dok_penawaran_inp").val(dateFromDb(data["ptp_doc_open_date"]));
		$("#negosiasi").val(dateFromDb(data["ptp_negosiation_date"]));
		$("#uskep").val(dateFromDb(data["ptp_uskep_date"]));
		$("#pengumuman").val(dateFromDb(data["ptp_announcement_date"]));
		$("#sanggahan").val(dateFromDb(data["ptp_disclaimer_date"]));
		$("#penunjukan").val(dateFromDb(data["ptp_appointment_date"]));


	$(document).ready(function() {
		function prevDate($name) {
			return $("[name=" + $name + "]").val()
		}
	});

	var is_tgl_pembukaan = "<?php echo $is_tgl_pembukaan; ?>";
	if (is_tgl_pembukaan !== undefined || is_tgl_pembukaan != "") {
		$(".toogle_hide").removeClass("d-none");
	}


	$("#tgl_pembukaan_pendaftaran_inp").change(function() {
		changeJadwal($('.periode_tender').val(), $('#tgl_pembukaan_pendaftaran_inp').val())
	});

	$('.periode_tender').change(function() {
		changeJadwal($(this).val(), $('#tgl_pembukaan_pendaftaran_inp').val(), $(this).attr('id'))
	});

	const rumusFormTglPembukaan = {
		7: {
			tgl_penutupan_pendaftaran_inp: 0,
			tgl_aanwijzing_inp: 1,
			tgl_mulai_penawaran_inp: 2,
			tgl_akhir_penawaran_inp: 2,
			tgl_pembukaan_dok_penawaran_inp: 2,
			negosiasi: 3,
			uskep: 4,
			pengumuman: 4,
			sanggahan: 6,
			penunjukan: 7,
		},
		14: {
			tgl_penutupan_pendaftaran_inp: 1,
			tgl_aanwijzing_inp: 2,
			tgl_mulai_penawaran_inp: 3,
			tgl_akhir_penawaran_inp: 5,
			tgl_pembukaan_dok_penawaran_inp: 6,
			negosiasi: 7,
			uskep: 9,
			pengumuman: 10,
			sanggahan: 12,
			penunjukan: 13,
		},
		30: {
			tgl_penutupan_pendaftaran_inp: 5,
			tgl_aanwijzing_inp: 6,
			tgl_mulai_penawaran_inp: 7,
			tgl_akhir_penawaran_inp: 14,
			tgl_pembukaan_dok_penawaran_inp: 16,
			negosiasi: 18,
			uskep: 23,
			pengumuman: 24,
			sanggahan: 26,
			penunjukan: 27,
		}
	}

	function changeJadwal(period_tender, tanggal_pembukaan, div_input) {
		var today = new Date(tanggal_pembukaan);
		var penutup = 0;
		var mulai = 0;
		var akhir = 0;
		var aanwijzing = 0;
		var dok = 0;
		var negosiasi = 0;
		var uskep = 0;
		var pengumuman = 0;
		var sanggahan = 0;
		var penunjukan = 0;
		var div_input = div_input;

		if (period_tender == 0) {
			$("#tgl_penutupan_pendaftaran_inp").val("");
			$("#tgl_mulai_penawaran_inp").val("");
			$("#tgl_akhir_penawaran_inp").val("");
			$("#tgl_aanwijzing_inp").val("");
			$("#tgl_pembukaan_dok_penawaran_inp").val("");
			$("#negosiasi").val("");
			$("#uskep").val("");
			$("#pengumuman").val("");
			$("#sanggahan").val("");
			$("#penunjukan").val("");
		} else if (period_tender == 7) {
			penutup = 1
			aanwijzing = 1 + penutup;
			mulai = 1 + aanwijzing;
			akhir = 1 + mulai;
			dok = 0 + akhir;
			negosiasi = 1 + dok;
			uskep = 1 + negosiasi;
			pengumuman = 0 + uskep;
			sanggahan = 2 + pengumuman;
			penunjukan = 1 + sanggahan;
		} else if (period_tender == 14) {
			penutup = 1
			aanwijzing = 1 + penutup;
			mulai = 1 + aanwijzing;
			akhir = 2 + mulai;
			dok = 1 + akhir;
			negosiasi = 1 + dok;
			uskep = 2 + negosiasi;
			pengumuman = 1 + uskep;
			sanggahan = 2 + pengumuman;
			penunjukan = 1 + sanggahan;
		} else if (period_tender == 30) {
			penutup = 5
			aanwijzing = 1 + penutup;
			mulai = 1 + aanwijzing;
			akhir = 7 + mulai;
			dok = 2 + akhir;
			negosiasi = 2 + dok;
			uskep = 5 + negosiasi;
			pengumuman = 1 + uskep;
			sanggahan = 2 + pengumuman;
			penunjukan = 1 + sanggahan;
		}

		date_penutup = moment(today.addDays(penutup)).format('YYYY-MM-DDThh:mm');
		date_mulai = moment(today.addDays(mulai)).format('YYYY-MM-DDThh:mm');
		date_akhir = moment(today.addDays(akhir)).format('YYYY-MM-DDThh:mm');
		date_aanwijzing = moment(today.addDays(aanwijzing)).format('YYYY-MM-DDThh:mm');
		date_dok = moment(today.addDays(dok)).format('YYYY-MM-DDThh:mm');
		date_negosiasi = moment(today.addDays(negosiasi)).format('YYYY-MM-DDThh:mm');
		date_uskep = moment(today.addDays(uskep)).format('YYYY-MM-DDThh:mm');
		date_pegumuman = moment(today.addDays(pengumuman)).format('YYYY-MM-DDThh:mm');
		date_sanggahan = moment(today.addDays(sanggahan)).format('YYYY-MM-DDThh:mm');
		date_penunjukan = moment(today.addDays(penunjukan)).format('YYYY-MM-DDThh:mm');

		$(".toogle_hide").removeClass("d-none");

		$("#tgl_penutupan_pendaftaran_inp").val(date_penutup);
		$("#tgl_aanwijzing_inp").val(date_aanwijzing);
		$("#tgl_mulai_penawaran_inp").val(date_mulai);
		$("#tgl_akhir_penawaran_inp").val(date_akhir);
		$("#tgl_pembukaan_dok_penawaran_inp").val(date_dok);
		$("#negosiasi").val(date_negosiasi);
		$("#uskep").val(date_uskep);
		$("#pengumuman").val(date_pegumuman);
		$("#sanggahan").val(date_sanggahan);
		$("#penunjukan").val(date_penunjukan);
	}

	Date.prototype.addDays = function(days) {
		var date = new Date(this.valueOf());
		date.setDate(date.getDate() + days);
		return date;
	}
</script>
<script>
	$("#tgl_penutupan_pendaftaran_inp").change(handleUbahJadwal)
	$('#tgl_aanwijzing_inp').change(handleUbahJadwal)
	$('#tgl_mulai_penawaran_inp').change(handleUbahJadwal)
	$('#tgl_akhir_penawaran_inp').change(handleUbahJadwal)
	$('#tgl_pembukaan_dok_penawaran_inp').change(handleUbahJadwal)
	$('#negosiasi').change(handleUbahJadwal)
	$('#uskep').change(handleUbahJadwal)
	$('#pengumuman').change(handleUbahJadwal)
	$('#sanggahan').change(handleUbahJadwal)
	$('#penunjukan').change(handleUbahJadwal)

	function handleUbahJadwal() {
		const currentValue = new Date($(this).val())
		const name = $(this).attr('id')
		const periode = $('.periode_tender').val()
		ubahJadwal(periode, currentValue, name)
	}

	function ubahJadwal(period_tender, tanggal_ubah, div_input) {
		var today = new Date(tanggal_ubah);
		var penutup = 0;
		var mulai = 0;
		var akhir = 0;
		var aanwijzing = 0;
		var dok = 0;
		var negosiasi = 0;
		var uskep = 0;
		var pengumuman = 0;
		var sanggahan = 0;
		var penunjukan = 0;

		if (period_tender == 0) {
			$("#tgl_penutupan_pendaftaran_inp").val("");
			$("#tgl_mulai_penawaran_inp").val("");
			$("#tgl_akhir_penawaran_inp").val("");
			$("#tgl_aanwijzing_inp").val("");
			$("#tgl_pembukaan_dok_penawaran_inp").val("");
			$("#negosiasi").val("");
			$("#uskep").val("");
			$("#pengumuman").val("");
			$("#sanggahan").val("");
			$("#penunjukan").val("");
		} else if (period_tender == 7) {
			if ( div_input == 'tgl_penutupan_pendaftaran_inp' ) {
				penutup = 0
				aanwijzing = 1 + penutup;
				mulai = 1 + aanwijzing;
				akhir = 0 + mulai;
				dok = 0 + akhir;
				negosiasi = 1 + dok;
				uskep = 1 + negosiasi;
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_aanwijzing_inp' ) {
				aanwijzing = 1 + penutup;
				mulai = 1 + aanwijzing;
				akhir = 0 + mulai;
				dok = 0 + akhir;
				negosiasi = 1 + dok;
				uskep = 1 + negosiasi;
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_mulai_penawaran_inp' ) {
				mulai = 1 + aanwijzing;
				akhir = 0 + mulai;
				dok = 0 + akhir;
				negosiasi = 1 + dok;
				uskep = 1 + negosiasi;
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_akhir_penawaran_inp' ) {
				akhir = 0 + mulai;
				dok = 0 + akhir;
				negosiasi = 1 + dok;
				uskep = 1 + negosiasi;
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_pembukaan_dok_penawaran_inp' ) {
				dok = 0 + akhir;
				negosiasi = 1 + dok;
				uskep = 1 + negosiasi;
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'negosiasi' ) {
				negosiasi = 1 + dok;
				uskep = 1 + negosiasi;
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'uskep' ) {
				uskep = 1 + negosiasi;
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'pengumuman' ) {
				pengumuman = 0 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'sanggahan' ) {
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}

		} else if (period_tender == 14) {
			if ( div_input == 'tgl_penutupan_pendaftaran_inp' ) {
				penutup = 1
				aanwijzing = 1 + penutup;
				mulai = 1 + aanwijzing;
				akhir = 2 + mulai;
				dok = 1 + akhir;
				negosiasi = 1 + dok;
				uskep = 2 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_aanwijzing_inp' ) {
				aanwijzing = 1 + penutup;
				mulai = 1 + aanwijzing;
				akhir = 2 + mulai;
				dok = 1 + akhir;
				negosiasi = 1 + dok;
				uskep = 2 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_mulai_penawaran_inp' ) {
				mulai = 1 + aanwijzing;
				akhir = 2 + mulai;
				dok = 1 + akhir;
				negosiasi = 1 + dok;
				uskep = 2 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_akhir_penawaran_inp' ) {
				akhir = 2 + mulai;
				dok = 1 + akhir;
				negosiasi = 1 + dok;
				uskep = 2 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_pembukaan_dok_penawaran_inp' ) {
				dok = 1 + akhir;
				negosiasi = 1 + dok;
				uskep = 2 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'negosiasi' ) {
				negosiasi = 1 + dok;
				uskep = 2 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'uskep' ) {
				uskep = 2 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'pengumuman' ) {
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'sanggahan' ) {
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}

		} else {
			if ( div_input == 'tgl_penutupan_pendaftaran_inp' ) {
				penutup = 5;
				mulai = 1 + aanwijzing;
				akhir = 7 + mulai;
				dok = 2 + akhir;
				negosiasi = 2 + dok;
				uskep = 5 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_aanwijzing_inp' ) {
				mulai = 1 + aanwijzing;
				akhir = 7 + mulai;
				dok = 2 + akhir;
				negosiasi = 2 + dok;
				uskep = 5 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_mulai_penawaran_inp' ) {
				akhir = 7 + mulai;
				dok = 2 + akhir;
				negosiasi = 2 + dok;
				uskep = 5 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_akhir_penawaran_inp' ) {
				dok = 2 + akhir;
				negosiasi = 2 + dok;
				uskep = 5 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'tgl_pembukaan_dok_penawaran_inp' ) {
				negosiasi = 2 + dok;
				uskep = 5 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'negosiasi' ) {
				uskep = 5 + negosiasi;
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'uskep' ) {
				pengumuman = 1 + uskep;
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'pengumuman' ) {
				sanggahan = 2 + pengumuman;
				penunjukan = 1 + sanggahan;
			}
			if ( div_input == 'sanggahan' ) {
				penunjukan = 1 + sanggahan;
			}
		}


		date_penutup = moment(today.addDays(penutup)).format('YYYY-MM-DDThh:mm');
		date_mulai = moment(today.addDays(mulai)).format('YYYY-MM-DDThh:mm');
		date_akhir = moment(today.addDays(akhir)).format('YYYY-MM-DDThh:mm');
		date_aanwijzing = moment(today.addDays(aanwijzing)).format('YYYY-MM-DDThh:mm');
		date_dok = moment(today.addDays(dok)).format('YYYY-MM-DDThh:mm');
		date_negosiasi = moment(today.addDays(negosiasi)).format('YYYY-MM-DDThh:mm');
		date_uskep = moment(today.addDays(uskep)).format('YYYY-MM-DDThh:mm');
		date_pegumuman = moment(today.addDays(pengumuman)).format('YYYY-MM-DDThh:mm');
		date_sanggahan = moment(today.addDays(sanggahan)).format('YYYY-MM-DDThh:mm');
		date_penunjukan = moment(today.addDays(penunjukan)).format('YYYY-MM-DDThh:mm');

		$(".toogle_hide").removeClass("d-none");

		if ( div_input == 'tgl_pembukaan_pendaftaran_inp' || div_input == 'tender_priod_inp' ) {
			$("#tgl_penutupan_pendaftaran_inp").val(date_penutup);
			$("#tgl_aanwijzing_inp").val(date_aanwijzing);
			$("#tgl_mulai_penawaran_inp").val(date_mulai);
			$("#tgl_akhir_penawaran_inp").val(date_akhir);
			$("#tgl_pembukaan_dok_penawaran_inp").val(date_dok);
			$("#negosiasi").val(date_negosiasi);
			$("#uskep").val(date_uskep);
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'tgl_penutupan_pendaftaran_inp' ) {
			$("#tgl_aanwijzing_inp").val(date_aanwijzing);
			$("#tgl_mulai_penawaran_inp").val(date_mulai);
			$("#tgl_akhir_penawaran_inp").val(date_akhir);
			$("#tgl_pembukaan_dok_penawaran_inp").val(date_dok);
			$("#negosiasi").val(date_negosiasi);
			$("#uskep").val(date_uskep);
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'tgl_penutupan_pendaftaran_inp' ) {
			$("#tgl_mulai_penawaran_inp").val(date_mulai);
			$("#tgl_akhir_penawaran_inp").val(date_akhir);
			$("#tgl_pembukaan_dok_penawaran_inp").val(date_dok);
			$("#negosiasi").val(date_negosiasi);
			$("#uskep").val(date_uskep);
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'tgl_penutupan_pendaftaran_inp' ) {
			$("#tgl_akhir_penawaran_inp").val(date_akhir);
			$("#tgl_pembukaan_dok_penawaran_inp").val(date_dok);
			$("#negosiasi").val(date_negosiasi);
			$("#uskep").val(date_uskep);
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'tgl_akhir_penawaran_inp' ) {
			$("#tgl_pembukaan_dok_penawaran_inp").val(date_dok);
			$("#negosiasi").val(date_negosiasi);
			$("#uskep").val(date_uskep);
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'tgl_pembukaan_dok_penawaran_inp' ) {
			$("#negosiasi").val(date_negosiasi);
			$("#uskep").val(date_uskep);
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'negosiasi' ) {
			$("#uskep").val(date_uskep);
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'uskep' ) {
			$("#pengumuman").val(date_pegumuman);
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'pengumuman' ) {
			$("#sanggahan").val(date_sanggahan);
			$("#penunjukan").val(date_penunjukan);
		}
		if ( div_input == 'sanggahan' ) {
			$("#penunjukan").val(date_penunjukan);
		}
	}

</script>
