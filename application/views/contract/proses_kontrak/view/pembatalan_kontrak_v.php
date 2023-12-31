
<div class="wrapper wrapper-content animated fadeInRight">

	<form class="form-horizontal">

		<?php 

		$loaded = array();
		foreach ($content as $key => $value) {
			$str = $value['awc_file'].".php";
			if(!in_array($str, $loaded)){
				include($str);
				$loaded[] = $str;
			}
		}

		?>


	</form>

	<form class="form-horizontal ajaxform" id="form_pengadaan">

		<input type="hidden" name="id" value="<?php echo $id ?>">
		<input type="hidden" name="ptm_number" value="<?php echo $ptm_number ?>">

		<?php 
		$i = 0;
		include(VIEWPATH."/comment_v.php") ?>

	</form>

	<center>
		<button type="button" class="btn btn-light" data-dismiss="modal">Kembali</button>
		<button type="button" id="batalkan_kontrak_btn" class="btn btn-info">Simpan</button>
	</center>

</div>

<script src="<?php echo base_url() ?>/assets/js/custom.js"></script>

<script type="text/javascript">

	$("#batalkan_kontrak_btn").on("click",function(){

		if(confirm("Apakah anda yakin batal kontrak?")){

			var data = $("form.ajaxform").serialize();

			$.ajax({
				url:"<?php echo site_url($controller_name.'/submit_pembatalan_kontrak');?>",
				data:data,
				type:"post",
				dataType:"json",
				success:function(x){

					if(x.message === ""){

						toastr.success("Berhasil membatalkan pengadaan", "Success");

						$("#dialog").modal("hide");
						$("#table_pembatalan_kontrak").bootstrapTable("refresh");

					} else {
						toastr.error(x.message, "Error");
					}

				}
			});

		}

		return false;

	}); 

</script>