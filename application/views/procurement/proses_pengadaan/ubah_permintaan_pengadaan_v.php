<?php $urlaction = ($last_comment['activity'] == 1012 ? '/submit_join_pengadaan' : '/submit_ubah_permintaan_pengadaan'); ?>

<div class="wrapper wrapper-content animated fadeInRight">

	<form method="post" action="<?php echo site_url($controller_name . $urlaction); ?>" class="form-horizontal ajaxform">
		
		<input type="hidden" name="id" value="<?php echo $id ?>">

		<?php

		foreach ($content as $key => $value) {
			include($value['awc_type'] . "/" . $value['awc_file'] . ".php");
		}

		?>

		<?php
		$i = 0;
		include(VIEWPATH . "/comment_workflow_attachment_v.php") ?>

		<div class="card">
			<div class="card-content">
				<div class="card-body">
					<?php echo buttonsubmit('procurement/daftar_pekerjaan', lang('back'), lang('save')) ?>
				</div>
			</div>
		</div>

	</form>

</div>

<?php
//haqim
include VIEWPATH . 'procurement/proses_pengadaan/chat_pr_v.php';
//end
?>

<script>
	$(document).ready(function() {
		var tipe_pengadaans = $('#tipe_pengadaan').find(":selected").text();
		if (tipe_pengadaans == 'Barang') {
			$('#jenis_nilai_resiko_barang').css('display', 'block')
			$('#jenis_nilai_resiko_jasa').css('display', 'none')
			$('#get_tipe_header').text("Barang")
		} else {
			$('#get_tipe_header').text("Jasa")
			$('#jenis_nilai_resiko_barang').css('display', 'none')
			$('#jenis_nilai_resiko_jasa').css('display', 'block')
		}
		tipePengadaan()
	});

	function tipePengadaan() {
		let jasa = document.getElementById('jenis_nilai_resiko_jasa')
		jasa.style = "display: flex";
		var params_type = $("#tipe_pengadaan").val()

		$("#onSkalaResiko").val(params_type);
		$('#onSkalaResiko').attr('value', params_type);

		if (params_type == 'barang') {
			$('#jenis_nilai_resiko_barang').css('display', 'block')
			$('#jenis_nilai_resiko_jasa').css('display', 'none')
			$('#get_tipe_header').text("Barang")
		} else {
			$('#get_tipe_header').text("Jasa")
			$('#jenis_nilai_resiko_barang').css('display', 'none')
			$('#jenis_nilai_resiko_jasa').css('display', 'block')
		}
	}
</script>