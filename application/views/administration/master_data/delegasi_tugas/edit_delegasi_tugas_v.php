<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_delegasi_tugas");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="card float-e-margins">
					<div class="card-title">
						<h5>Ubah Delegasi Pekerjaan</h5>
						<div class="card-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="card-content">

						<?php $curval = $data["start_date"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal mulai</label>
							<div class="col-sm-3">
								<div class='input-group date' id='datetimepicker1'>
								   <input type="text" class="form-control tgl_mulai_inp" id="tgl_mulai_inp" maxlength="50" name="tgl_mulai_inp" value="<?php echo $curval ?>">
								    <span class="input-group-addon input-group-addon1">
								        <span class="glyphicon glyphicon-calendar glyphicon1"></span>
								    </span>
								</div>
							</div>
						</div>

						<?php $curval = $data["end_date"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Akhir</label>
							<div class="col-sm-3">
								<div class='input-group date' id='datetimepicker2'>
								    <input type="text" class="form-control tgl_berakhir_inp" id="tgl_berakhir_inp" maxlength="255" name="tgl_berakhir_inp" value="<?php echo $curval ?>">
								    <span class="input-group-addon input-group-addon2">
								        <span class="glyphicon glyphicon-calendar glyphicon2"></span>
								    </span>
								</div>
							</div>
						</div>

						<?php $curval = $data["from"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Dari</label>
							<div class="col-sm-4">
								<select required class="form-control select2" name="dari_inp" >
									<option value="">Pilih</option>
									<?php 
									foreach($employee as $key => $val){
										$selected = ($val['id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['id'] ?>"><?php echo $val['fullname']." - ".$val['dept_name']  ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

						<?php $curval = $data["to"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Kepada</label>
							<div class="col-sm-4">
								 <select required class="form-control select2" name="kepada_inp" >
									<option value="">Pilih</option>
									<?php 
									foreach($employee1 as $key => $val){
										$selected = ($val['id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['id'] ?>"><?php echo $val['fullname']." - ".$val['dept_name']  ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

						<?php $curval = $data["notes"]; ?>
						<div class="form-group">
						  <label class="col-sm-2 control-label">Alasan</label>
						  <div class="col-sm-6">
						        <textarea type="text" class="form-control" id="keterangan_inp" name="keterangan_inp" value="<?php echo $curval ?>" height="200px"><?php echo $curval ?> </textarea>
						  </div>
						</div>


							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div style="margin-bottom: 60px;">
							<?php echo buttonsubmit('administration/master_data/delegasi_tugas',lang('back'),lang('save')) ?>
						</div>
					</div>
				</div>

			</form>
		</div>


		<script type="text/javascript">
		$(document).ready(function() {



  $('#tgl_mulai_inp').datetimepicker({format:"YYYY-MM-DD HH:mm:ss"})
  $('#tgl_berakhir_inp').datetimepicker({format:"YYYY-MM-DD HH:mm:ss"})


  $('.glyphicon1').click(function () {
      $("#datetimepicker1").datetimepicker({format:"YYYY-MM-DD HH:mm:ss"});
  });

  $('.glyphicon2').click(function () {
      $("#datetimepicker2").datetimepicker({format:"YYYY-MM-DD HH:mm:ss"});
  });

		})

		</script>

