<style></style>
<form role="form" id="komersial" method="POST" action="<?php echo site_url('/Vsi/submit_kuesioner') ?>" class="form-horizontal">			
		
                         <h3 class="card-title-w">TINGKAT KEPUASAN</h3>

						<input type="text" style="display: none" name="quest_id" value="<?php echo $quest_id ?>">

						<?php
						$p = "";
						$h = 1;
						$tab = "&nbsp;&nbsp;&nbsp;";
						foreach ($header as $key => $val) {
							$p .= "I";
							$q = 1;
							?>

							 <div class="form-group">
								<div class="col-sm-6 col-form-label">
								<label style="font-weight: bold;"><?php echo $p . ". " . $val[0]['avk_header']; ?></label>
								</div>
							</div> 
							
							<?php foreach ($val as $k => $v) { ?>
								<div class="row">
								<div class="col-lg-12">
									<div class="card">
										<div class="card-header">
											<h4 class="card-title-w"><?php echo $tab . $h . "." . $q . $tab . $v['avk_quest']; ?></h4>
										</div>
										<div class="card-content">
											<div class="col-lg-12">
											<div class="form-check form-check-inline" style="width:-webkit-fill-available;padding-bottom:2pc;">
												
												<?php echo $tab . $tab;
													for ($i = 1; $i <= 4; $i++) { ?>
												<?php echo $tab ?>
												<div class="col-lg-3">
												<input type="radio" style="height: 20px;width: 20px;" id="satis<?php echo $v['avk_id'] ?>" name="satis_<?php echo $v['avk_id'] ?>" value="<?php echo $i ?>" class="form-check-input" required>
												<label class="form-check-label" style="font-size: large;" for="satis<?php echo $v['avk_id'] ?>"> <?php echo $keterangan[$i] . $tab ?> </label>
												</div>
												<?php } ?>
												
											
										</div>
											</div>
										
										</div>
									</div>
								</div>
								</div>

								<div class="form-group">
									<div class="col-md-12">
									<div class="form-group mb-2">
									<label style="font-weight: bold;"></label>
									</div>
								</div>
		
								</div>

						<?php $q++;
							}
							$h++;
						} ?>


<h3 class="card-title-w">TINGKAT Kepentingan</h3>


<?php
$p = "";
$h = 1;
$tab = "&nbsp;&nbsp;&nbsp;";
foreach ($header as $key => $val) {
	$p .= "I";
	$q = 1;
	?>

	 <div class="form-group">
		<div class="col-sm-6 col-form-label">
		<label style="font-weight: bold;"><?php echo $p . ". " . $val[0]['avk_header']; ?></label>
		</div>
	</div> 
	
	<?php foreach ($val as $k => $v) { ?>
		<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title-w"><?php echo $tab . $h . "." . $q . $tab . $v['avk_quest']; ?></h4>
				</div>
				<div class="card-content">
					<div class="col-lg-12">
					<div class="form-check form-check-inline" style="width:-webkit-fill-available;padding-bottom:2pc;">
						
						<?php echo $tab . $tab;
							for ($i = 1; $i <= 4; $i++) { ?>
						<?php echo $tab ?>
						<div class="col-lg-3">
						<input type="radio" style="height: 20px;width: 20px;" id="imp<?php echo $v['avk_id'] ?>" name="imp_<?php echo $v['avk_id'] ?>" value="<?php echo $i ?>" class="form-check-input" required>
						<label class="form-check-label" style="font-size: large;" for="imp<?php echo $v['avk_id'] ?>"> <?php echo $keterangan[$i] . $tab ?> </label>
						</div>
						<?php } ?>
						
				</div>
					</div>
				
				</div>
			</div>
		</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
			<div class="form-group mb-2">
			<label style="font-weight: bold;"></label>
			</div>
		</div>

		</div>

<?php $q++;
	}
	$h++;
} ?>
					
						
						<hr>
						
				
				<div class="row">
					<div class="col-lg-12">

						<div class="row">
							<div class="col-lg-12">
							
								<div class="form-group">
											<div class="col-lg-12 m-l-n text-center">

												<a href="javascript:window.history.go(-1);" class="btn btn-light">Kembali</a>
												<button class="btn btn-primary" type="submit">Simpan</button>
											</div>
										</div>
							</div>
						</div>
					</div>
				</div>

					</div>
	
</form>


<script>
	$(document).ready(function() {
		$('.milestone_table').DataTable({
			"order": [
				[0, "desc"]
			],
			"lengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "All"]
			]
		});
	});
</script>


<script>
	$(document).ready(function() {

		var sel = ""

		$("#type_contr").change(function() {
			sel = $(this).children("option:selected").text();
		});

		$(".action_add").click(function() {

			var n = $('table tr').length;
			var i = n - 1
			var contr = $("#name_contr").val()
			var type = sel

			if (contr == "" || type == "") {
				alert('Tidak ada data yang ditambahkan')
			} else {
				var data = "<tr><td><center>" + n + "<input style='display: none' type='text' name='id_inp[]' value='" + i + "'></center></td>";
				data += "<td>" + contr + "<input style='display: none' type='text' name='name_inp[]' value='" + contr + "'></td>";
				data += "<td>" + type + "<input style='display: none' type='text' name='type_inp[]' value='" + type + "'></td>";
				data += "<td><div class='radio radio-info'><input type='radio' id='con" + i + "' name='con" + i + "' value='1'><label for='con" + i + "' ></label></div></td>";
				data += "<td><div class='radio radio-info'><input type='radio' id='con" + i + "' name='con" + i + "' value='2'><label for='con" + i + "' ></label></div></td>";
				data += "<td><div class='radio radio-info'><input type='radio' id='con" + i + "' name='con" + i + "' value='3'><label for='con" + i + "' ></label></div></td>";
				data += "<td><div class='radio radio-info'><input type='radio' id='con" + i + "' name='con" + i + "' value='4'><label for='con" + i + "' ></label></div></td>";
				$('#quest_table').append(data);
				i++;

				$('#type_contr option').prop('selected', function() {
					return this.defaultSelected;
				});
				$("#name_contr").val("");
			}
		});
	});
</script>
