<div class="row">
	<div class="col-7">
		<div class="content-header"><strong><?php echo ($viewer) ? "Lihat" : "Form"; ?> Progress Milestone</strong></div>
	</div>
	<div class="col-5">
		<div class="content-header float-right">
			<a class="text-muted text-xs block h5" id="servertime"></a>
		</div>
	</div>
</div>

<form class="form-horizontal" method="post" action="<?php echo site_url('kontrak/submit_progress_milestone') ?>">
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?php echo $this->lang->line('Header'); ?></h5>
					</div>
					<div class="ibox-content">

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Nomor Kontrak
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["contract_number"]; ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Judul Kontrak
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["subject_work"] ?>

								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Deskripsi Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["description"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Target Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo date("d/m/Y",strtotime($header["target_date"])) ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Presentase Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["percentage"] ?> %

								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Tanggal Progress *
							</label>
							<div class="col-lg-3 m-l-n">
								<?php if(!$viewer){ ?>
								<input type="date" required name="tanggal_inp" class="form-control" value="">
								<?php } else { ?>
								<p class="form-control-static">
									<?php echo date("d/m/Y",strtotime($current["progress_date"])) ?>
								</p>
								<?php } ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Presentase Progress *
							</label>
							<div class="col-lg-2 m-l-n">

								<?php if(!$viewer){ ?>
								<div class="input-group">
									<input type="text" required class="form-control money" name="presentase_inp" value="">
									<span class="input-group-addon">%</span>
								</div>
								<?php } else { ?>
								<p class="form-control-static">
									<?php echo $current["percentage"] ?> %
								</p>
								<?php } ?>

							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Deskripsi Progress *
							</label>
							<div class="col-lg-6 m-l-n">

								<?php if(!$viewer){ ?>
								<textarea name="progress_inp" required class="form-control"></textarea>
								<?php } else { ?>
								<p class="form-control-static">
									<?php echo $current["description"] ?>
								</p>
								<?php } ?>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<!-- item list -->

		  <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Item List &nbsp; <button type="button" class="btn btn-xs btn-default" data-toggle="popover" title="Pilih Item" data-content="Tentukan item dan volume/jumlahnya pada termin ini"><span class="glyphicon glyphicon-question-sign"></span></button></h5>
                    </div>
                    <div class="ibox-content">

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Item</label>
                      <div class="col-sm-6">
                        <div class="input-group">
                          <span class="input-group-btn">
                               <button type="button" data-id="kode_item" data-url="<?php echo site_url('kontrak/picker_contract_item/'.$header["contract_id"]) ?>" class="btn btn-primary picker barang_btn not_integrated">Pilih Item</button>
                         </span>
                         <?php $curval = set_value("kode_item"); ?>
                         <input readonly type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">
                         <?php $curval = set_value("item_id"); ?>
                         <input type="hidden" class="form-control" id="item_id" name="item_id" value="<?php echo $curval ?>">
                       </div>
                     </div>
                   </div>

                 <?php $curval = set_value("deskripsi_item"); ?>
			     <div class="form-group">
			      <label class="col-sm-2 control-label">Deskripsi</label>
			      <div class="col-sm-10">
			        <p class="form-control-static" maxlength="1000" id="deskripsi_item"><?php echo $curval ?></p>
			      </div>
			    </div>

                <?php $curval = set_value("jumlah_item_inp"); ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Volume</label>
                  <div class="col-sm-2">
                   <input type="text" class="form-control jml_item" maxlength="40" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
                   <input type="hidden" class="form-control" maxlength="40" name="max_val" id="max_val" value="">
                   <small id="max_volume"></small>
                 </div>
                 <small id="error_jml"></small>
               </div>

               <?php $curval = set_value("satuan_item_inp"); ?>
               <div class="form-group">
                <label class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-2">
                 <input type="text" readonly="true" class="form-control" maxlength="12" name="satuan_item_inp" id="satuan_item_inp" value="<?php echo $curval ?>">
               </div>
             </div>

             <center>
              <a class="btn btn-primary action_item">Simpan</a>
              <a class="btn btn-light empty_item">Hapus</a>
              <input type="hidden" id="current_item" name="current_item" value=""/>
              <br>
             </center>

            <hr>

            <table class="table table-bordered" id="item_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kode</th>
                  <th>Item</th>
                  <th>Volume</th>
                  <th>Satuan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($item_progress) && !empty($item_progress)){
                  foreach ($item_progress as $key => $value) {
                    $idnya = $key+1;
                   ?>

                  <tr>
                    <td>
                      <button data-no="<?php echo $idnya ?>" class="btn btn-primary btn-xs edit_item" type="button">
                        <i class="fa fa-edit"></i>
                        <?php $curval = (isset($value['milestone_item_id'])) ? $value['milestone_item_id'] :  ""; ?>
                        <input type="hidden" name="item_id[<?php echo $idnya ?>]" value="<?php echo $curval ?>"/>
                      </button>
                    </td>
                    <td>
                    	<input type='hidden' class='max_item' max-val='<?php echo $value['qty'] ?>' data-no='<?php echo $idnya ?>' name='max_item["<?php echo $idnya ?>"]' value="<span id='max'><i>batas max <?php echo $value['qty'].' '.$value['uom'] ?></i></span>"/>
                      <input type="hidden" value="<?php echo $value['item_code'] ?>" name="item_kode[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="kode_item">
                      <?php echo $value['item_code'] ?>
                    </td>
                    <td>
                      <input type="hidden" value="<?php echo $value['short_description'] ?>" name="item_deskripsi[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="deskripsi_item">
                      <?php echo $value['short_description'] ?>
                    </td>
                    <td class="text-right">
                      <input type="hidden" value="<?php echo $value['qty_progress'] ?>" name="item_jumlah[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_item">
                      <?php echo inttomoney($value['qty_progress']) ?>
                    </td>
                    <td>
                      <input type="hidden" value="<?php echo $value['uom'] ?>" name="item_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="satuan_item">
                      <?php echo $value['uom'] ?>
                    </td>
                  </tr>

                  <?php
               } } ?>

             </tbody>
            </table>


                    </div>
                </div>
            </div>
        </div>


		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Riwayat Progress</h5>
					</div>
					<div class="ibox-content">


						<table class="table table-striped table-bordered table-hover milestone_table">

							<thead>

								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Deskripsi Progress</th>
									<th>Persentase</th>
								</tr>

							</thead>

							<tbody>

								<?php
								foreach ($item as $key => $value) { ?>

								<tr>
									<td><?php echo $key+1 ?></td>
									<td><?php echo date('d/m/Y',strtotime($value['progress_date'])) ?></td>
									<td><?php echo $value['description'] ?></td>
									<td><?php echo $value['percentage'] ?> %</td>
								</tr>

								<?php } ?>

							</tbody>

						</table>


					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>List Komentar</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">

						<table class="table comment milestone_table">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Nama</th>
									<th>Tipe</th>
									<th>Aktifitas</th>
									<th>Komentar</th>
								</tr>
							</thead>
							<tbody>

								<?php if(isset($comment_list) && !empty($comment_list)){

									foreach ($comment_list as $kc => $vc) {
										$start_date = date("d/m/Y H:i:s",strtotime($vc['comment_date']));
										?>
										<tr>
											<td><?php echo $start_date ?></td>
											<td><?php echo $vc['comment_name'] ?></td>
											<td><?php echo $vc['comment_type'] ? "Vendor" : "Internal" ?></td>
											<td><?php echo $vc['comment_activity'] ?></td>
											<td><?php echo $vc['comments'] ?></td>
										</tr>
										<?php } } ?>

									</tbody>

								</table>

							</div>
						</div>
					</div>
				</div>

				<?php if(!$viewer){ ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Form Komentar</h5>
							</div>
							<div class="ibox-content">

								<div class="form-group">
									<label class="col-sm-2 control-label">Komentar</label>
									<div class="col-lg-10 m-l-n">
										<textarea name="komentar_inp" class="form-control"></textarea>
									</div>
								</div>

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

				<?php } else { ?>
				<a href="javascript:window.history.go(-1);" class="btn btn-light">Kembali</a>
				<?php } ?>

			</form>

		</div>

<script>
	$(document).ready(function() {
		$('.milestone_table').DataTable({
			"order": [[ 0, "desc" ]],
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});

	var contract_id = "<?php echo $header['contract_id'] ?>";

    $(document.body).on("change","#kode_item",function(){
       var item_code = $(this).val();
       var url = "<?php echo site_url('kontrak/get_contract_item') ?>";

        $.ajax({
          url : url+"?item_code="+item_code+'&contract_id='+contract_id,
          dataType:"json",
          success:function(data){
            var mydata = data.rows[0];
            if (check_exist_item(item_code) == 'false') {
            $("#deskripsi_item").html(mydata.short_description);
            $("#jumlah_item_inp").val(1);
            $("#satuan_item_inp").val(mydata.uom);
            $('#max_volume').html("<span id='max'><i>batas max "+parseFloat(mydata.volume_remain).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 8})+" "+mydata.uom+"</i></span>");
            $('#max_val').val(mydata.qty)

            $(".jml_item").autoNumeric('update',{
            	aSep: '.',
			    aDec: ',',
			    aSign: '',
			    vMin: '0',
			    vMax: mydata.volume_remain
			  });
        	}else{

        		alert('Item Sudah Dipilih!');
        		$("#kode_item").val("");

        	}
          }
        });

    });

    function check_exist_item(id){
    	var is_exists = 'false';
    	if ($("#current_item").length > 0) {

    		if ( getMaxDataNo(".edit_item") != "" && getMaxDataNo(".edit_item") != 0 ) {
	    		for (var i = 1; i < getMaxDataNo(".edit_item")+1 ; i++) {


	    			if (id == $("[name='item_kode["+i+"]']").val()) {
	    				 is_exists = 'true';
	    			}

	    		}
	    	}

    	}

    	return is_exists;

    }

    $(document.body).on("click",".empty_item",function(){
      $("#current_item").val("");
      $("#kode_item").val("");
      $("#deskripsi_item").text("");
      $("#jumlah_item_inp").val("");
      $("#satuan_item_inp").val("");
      $("#max_volume").html("")
      $("#max_val").val("")
      $("#harga_satuan_item_inp").val("");
      $('#item_id').val("")

    });

     function getMaxDataNo(selector) {
      var min=null, max=null;
      $(selector).each(function() {
        var no_pp = parseInt($(this).attr('data-no'), 10);
        if ((max===null) || (no_pp > max)) { max = no_pp; }
      });
      return max;
    }

     $(".action_item").click(function(){

      var current_item = $("#current_item").val();
      var no = current_item;

      if(current_item == ""){

        if (getMaxDataNo(".edit_item") == null) {
          no = 1;
        }else{
          no = getMaxDataNo(".edit_item")+1;
        }

      }

      var kode = $("#kode_item").val();
      var item_id = $('#item_id').val();
      var max_notif = $('#max_volume').html();
      var max_val = $("#max_val").val()
      var deskripsi = $("#deskripsi_item").text();
      var jumlah = $("#jumlah_item_inp").val();
      var satuan = $("#satuan_item_inp").val();
      var harga_satuan = $("#harga_satuan_item_inp").val();
      var jumlah_int = $("#jumlah_item_inp").autoNumeric('get');


	if(jumlah_int < 1){

        alert("Jumlah tidak boleh kurang dari 1");

      }else {

        var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button><input type='hidden' name='item_id["+no+"]' value='"+item_id+"' /></button></td>";
        html += "<td><input type='hidden' class='kode_item' data-no='"+no+"' name='item_kode["+no+"]' value='"+kode+"'/>"+kode+"</td>";
        html += "<td><input type='hidden' class='deskripsi_item' data-no='"+no+"' name='item_deskripsi["+no+"]' value='"+deskripsi+"'/>"+deskripsi+"</td>";
        html += "<td class='text-right'><input type='hidden' class='max_item' max-val='"+max_val+"' data-no='"+no+"' name='max_item["+no+"]' value='"+max_notif+"'/> <input type='hidden' class='jumlah_item' data-no='"+no+"' name='item_jumlah["+no+"]' value='"+jumlah_int+"'/>"+jumlah+"</td>";
        html += "<td><input type='hidden' class='satuan_item' data-no='"+no+"' name='item_satuan["+no+"]' value='"+satuan+"'/>"+satuan+"</td>";
        html += "</tr>";
        $("#item_table").append(html);
        $("#kode_item").val("");
        $('#item_id').val("");
        $("#deskripsi_item").text("");
        $("#max_volume").html("");
        $("#max_val").val("");
        $("#jumlah_item_inp").val("");
        $("#satuan_item_inp").val("");
        $("#current_item").val("");

      }

    });

      $(document.body).on("click",".edit_item",function(){

      var no = $(this).attr('data-no');
      max_notif_item = $(".max_item[data-no='"+no+"']").val();
      $('#max_volume').html(max_notif_item);
      var max_val = $(".max_item[data-no='"+no+"']").attr('max-val')
      var kode = $(".kode_item[data-no='"+no+"']").val();
      var deskripsi = $(".deskripsi_item[data-no='"+no+"']").val();
      var jumlah = $(".jumlah_item[data-no='"+no+"']").val();
      var satuan = $(".satuan_item[data-no='"+no+"']").val();
      var item_id = $('[name="item_id['+no+']"]').val();

      if ($('[name="item_id['+no+']"]').val() != "") {
      	alert($('[name="item_id['+no+']"]').val());
      }

      $(".jml_item").autoNumeric('update',{
            	aSep: '.',
			    aDec: ',',
			    aSign: '',
			    vMin: '0',
			    vMax: max_val
			  });

      $("#current_item").val(no);
      $("#kode_item").val(kode);
      $("#deskripsi_item").text(deskripsi);
      $("#jumlah_item_inp").val(inttomoney(jumlah));
      $("#satuan_item_inp").val(satuan);
      $("#item_id").val(item_id);


      $(this).parent().parent().remove();

      return false;

    });


	$("input.money").autoNumeric('init',{
	    aSep: '.',
	    aDec: ',',
	    aSign: '',
	    vMin: '0'
	  });

	$("input.jml_item").autoNumeric('init',{
	    aSep: '.',
	    aDec: ',',
	    aSign: '',
	    vMin: '0'
	  });

	});

		</script>
