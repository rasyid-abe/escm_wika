<form role="form" id="komersial" method="POST" action="<?php echo site_url('/Vsi/submit_kuesioner') ?>" class="form-horizontal">
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Kuesioner Kepuasan Vendor</h5>
					</div>
					<div class="ibox-content">
						<form role="form" id="komersial" method="POST" action="<?php echo site_url('/Vsi/submit_kuesioner') ?>" class="form-horizontal">
							<input type="text" style="display: none" name="quest_id" value="<?php echo $quest_id ?>">
							<div class="form-group">
								<label class="col-sm-3 control-label">
									Faktor - Faktor yang Dinilai
								</label>
								<label class="col-sm-5 control-label">
									Tingkat Kepuasan
								</label>
								<label class="col-sm-3 control-label">
									Tingkat Kepentingan
								</label>
							</div>

							<?php
							$p = "";
							$h = 1;
							$tab = "&nbsp;&nbsp;&nbsp;";
							foreach ($quest as $key => $val) {
								$p .= "I";
								$q = 1;
								?>

								<div class="form-group">
									<div class="col-sm-6 col-form-label">
										<?php echo "<b>".$p.". ".$val[0]['vvk_quest_header']."</b>"; ?>
									</div>
								</div>

								<?php foreach ($val as $k => $v) { ?>
									<div class="form-group">
										<div class="col-sm-6 col-form-label">
											<?php echo $tab.$h.".".$q.$tab.$v['vvk_quest_name']; ?>
										</div>
										<div class="radio radio-info col-sm-3">
										<?php echo $tab.$tab;
										for ($i=1; $i <= 4 ; $i++) {
			                                echo $tab ;
			                                $check = ($i == $v['vvk_satis_score']) ? "checked" : null; ?>
			                                <input type="radio" id="satis_<?php echo $v['vvk_id'] ?>" name="satis_<?php echo $v['vvk_id']?>" <?php echo $check; ?> disabled>
			                                <label for="satis<?php echo $v['vvk_id'] ?>"> <?php echo $i.$tab ?> </label>
										<?php } ?>
			                            </div>

										<div class="radio radio-info col-sm-3">
										<?php echo $tab;
										for ($i=1; $i <= 4 ; $i++) {
			                                echo $tab ;
			                                $check = ($i == $v['vvk_imp_score']) ? "checked" : null; ?>
			                                <input type="radio" id="imp_<?php echo $v['vvk_id'] ?>" name="imp_<?php echo $v['vvk_id']?>" <?php echo $check ?> disabled >
			                                <label for="imp<?php echo $v['vvk_id'] ?>"> <?php echo $i.$tab ?> </label>
										<?php } ?>
			                            </div>
									</div>

								<?php $q++;
								}
								$h++;
							} ?>
							<br>
							<hr>
							<br>
							<div class="form-group">
								<div class="col-sm-12 col-form-label">
								<?php echo "<b>".$p."I".". Komentar/pendapat anda tentang WIKA selaku pengguna jasa jika dibandingkan dengan Kontraktor Lain ? </b>" ?>
								</div>
							</div>

							<table class="table table-bordered" id="quest_table">
							 	<thead>
								    <tr>
								      <th style="width: 8%"><center>No</center></th>
								      <th style="width: 52%"><center>Kontraktor</center></th>
								      <th style="width: 20%"><center>Jenis</center></th>
								      <th style="width: 5%"><center><</center></th>
								      <th style="width: 5%"><center>></center></th>
								      <th style="width: 5%"><center>=</center></th>
								      <th style="width: 5%"><center>0</center></th>
								    </tr>
							  	</thead>
							  	<tbody>
							    <?php
							    $urut = 1;
							    foreach ($contractor as $key => $value) { ?>
							    	<tr>
							    		<td>
							    			<center><?php echo $urut; ?></center>
							    		</td>
							    		<td>
							    			<?php echo $value['vvc_name']; ?>
							    		</td>
							    		<td>
							    			<?php echo $value['vvc_type']; ?>
							    		</td>
										<?php for ($i=1; $i <= 4 ; $i++) {
			                                $check = ($i == $value['vct_score']) ? "checked" : null; ?>
						    				<td>
						    					<div class="radio radio-info">
													<input type="radio" id="con<?php echo $key ?>" name="con<?php echo $key ?>" <?php echo $check ?> disabled >
					                                <label for="con<?php echo $key ?>"></label>
					                            </div>
						    				</td>
										<?php } ?>
						    		</tr>
							    <?php $urut++; }?>
							 	</tbody>
							</table>
							<br>
							<hr>
							<br>
							<div class="form-group">
								<div class="col-sm-12 col-form-label">
									<b> Bersedia menempatkan WIKA sebagai pelanggan potensial utama (memberikan harga paling kompetitif) </b>
								</div>
								<br><br>
								<div class="form-group">
								  	<div class="col-sm-12">
						 				<div class="radio radio-info col-sm-12">
							 				<?php echo $tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab.$tab;?>
							 				<input type="radio" id="already" name="already" value="1" <?php if($master['vvq_already'] == 1){echo "checked";} ?> disabled>
							 				<label for="already">Ya</label>
							 				<?php echo $tab.$tab.$tab.$tab ?>
							 				<input type="radio" id="already" name="already" value="0" <?php if($master['vvq_already'] == 0){echo "checked"; } ?> disabled>
							 				<label for="already">Tidak</label>
							 			</div>
						 			</div>

								</div>
							</div>
							<div class="form-group">
							    	 <label class="col-sm-2 control-label">Alasanya *</label>
							  	<div class="col-sm-6">
					 				<input type="text" class="form-control" name="reason" id="reason" disabled value="<?php echo $master['vvq_reason'] ?>">
					 			</div>
					 		</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Penilai *</label>
							    <div class="col-sm-6">
							   		<select name="evaluator" id="evaluator" class="form-control" disabled>
										<option checked><?php echo $master['vvq_evaluator'] ?></option>
									</select>
							   	</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Tingkat Jabatan *</label>
							    <div class="col-sm-6">
							   		<select name="job_rank" id="job_rank" class="form-control" disabled>
										<option checked><?php echo $master['vvq_job'] ?></option>
									</select>
							   	</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5><?php echo $this->lang->line('Komentar'); ?></h5>
						</div>

						<div class="ibox-content">

							<div class="form-group">
								<label class="col-sm-2 control-label">Komentar *</label>
								<div class="col-lg-10 m-1-n">
									<textarea name="komentar_inp" required class="form-control" disabled><?php echo $master['vvq_comment'] ?></textarea>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12 m-l-n text-center">
									<input type="hidden" name="contract_id" value="">
									<a href="javascript:window.history.go(-1);" class="btn btn-light">Kembali</a>
									<!-- <button class="btn btn-primary" type="submit">Simpan</button> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script >
$(document).ready(function(){

	var sel = ""

	$("#type_contr").change(function(){
        sel = $(this).children("option:selected").text();
    });

    $(".action_add").click(function(){

		var n = $('table tr').length;
		var i = n-1
		var contr = $("#name_contr").val()
		var type = sel

    	if (contr == "" || type == "") {
    		alert('Tidak ada data yang ditambahkan')
    	}else{
    		var data="<tr><td><center>"+n+"<input style='display: none' type='text' name='id_inp[]' value='"+i+"'></center></td>";
				data +="<td>"+contr+"<input style='display: none' type='text' name='name_inp[]' value='"+contr+"'></td>";
				data +="<td>"+type+"<input style='display: none' type='text' name='type_inp[]' value='"+type+"'></td>";
				data +="<td><div class='radio radio-info'><input type='radio' id='con"+i+"' name='con"+i+"' value='1'><label for='con"+i+"' ></label></div></td>";
				data +="<td><div class='radio radio-info'><input type='radio' id='con"+i+"' name='con"+i+"' value='2'><label for='con"+i+"' ></label></div></td>";
				data +="<td><div class='radio radio-info'><input type='radio' id='con"+i+"' name='con"+i+"' value='3'><label for='con"+i+"' ></label></div></td>";
				data +="<td><div class='radio radio-info'><input type='radio' id='con"+i+"' name='con"+i+"' value='4'><label for='con"+i+"' ></label></div></td>";
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
